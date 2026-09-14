<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../clases/class.Sesion.php';
$session = new Sesion();
if (!isset($_SESSION['se_SAS'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'La sesión terminó. Inicia sesión nuevamente.']);
    exit;
}
require_once dirname(__DIR__, 3) . '/includes/database.php';

function admin_value(string $key): string { return trim((string)($_POST[$key] ?? '')); }
function invitation_admin_upload(string $field, ?int $index = null): ?string
{
    if (!isset($_FILES[$field])) return null;
    $file = $_FILES[$field];
    $error = $index === null ? ($file['error'] ?? UPLOAD_ERR_NO_FILE) : ($file['error'][$index] ?? UPLOAD_ERR_NO_FILE);
    if ($error === UPLOAD_ERR_NO_FILE) return null;
    if ($error !== UPLOAD_ERR_OK) throw new RuntimeException('Una imagen no pudo cargarse.');
    $size = $index === null ? $file['size'] : $file['size'][$index];
    $temporary = $index === null ? $file['tmp_name'] : $file['tmp_name'][$index];
    if ($size > 8 * 1024 * 1024) throw new RuntimeException('Cada imagen debe pesar menos de 8 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporary);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($extensions[$mime])) throw new RuntimeException('Sólo se permiten imágenes JPG, PNG o WebP.');
    $directory = dirname(__DIR__, 3) . '/uploads/invitation';
    if (!is_dir($directory) && !mkdir($directory, 0775, true)) throw new RuntimeException('No se pudo crear la carpeta de imágenes.');
    $filename = bin2hex(random_bytes(12)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($temporary, $directory . '/' . $filename)) throw new RuntimeException('No se pudo guardar una imagen.');
    return 'uploads/invitation/' . $filename;
}

try {
    $db = boda_db();
    $db->begin_transaction();
    $heroImage = invitation_admin_upload('hero_image_file') ?? admin_value('current_hero_image');
    $venueImage = invitation_admin_upload('venue_image_file') ?? admin_value('current_venue_image');
    $giftEnabled = isset($_POST['gift_enabled']) ? 1 : 0;
    $galleryEnabled = isset($_POST['gallery_enabled']) ? 1 : 0;
    $uploadEnabled = isset($_POST['upload_enabled']) ? 1 : 0;

    $sql = 'INSERT INTO invitation_settings (id, bride_name, groom_name, couple_name, event_type, event_label, story_label, story_title, public_url, preview_url, event_date, ceremony_time, reception_time, venue, address, maps_url, hero_image, venue_image, romantic_phrase, story_intro, dress_code, gift_intro, gift_enabled, gallery_enabled, upload_enabled) VALUES (1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE bride_name=VALUES(bride_name),groom_name=VALUES(groom_name),couple_name=VALUES(couple_name),event_type=VALUES(event_type),event_label=VALUES(event_label),story_label=VALUES(story_label),story_title=VALUES(story_title),public_url=VALUES(public_url),preview_url=VALUES(preview_url),event_date=VALUES(event_date),ceremony_time=VALUES(ceremony_time),reception_time=VALUES(reception_time),venue=VALUES(venue),address=VALUES(address),maps_url=VALUES(maps_url),hero_image=VALUES(hero_image),venue_image=VALUES(venue_image),romantic_phrase=VALUES(romantic_phrase),story_intro=VALUES(story_intro),dress_code=VALUES(dress_code),gift_intro=VALUES(gift_intro),gift_enabled=VALUES(gift_enabled),gallery_enabled=VALUES(gallery_enabled),upload_enabled=VALUES(upload_enabled)';
    $statement = $db->prepare($sql);
    $bride = admin_value('bride_name'); $groom = admin_value('groom_name'); $couple = admin_value('couple_name');
    $eventType = admin_value('event_type'); if (!in_array($eventType, ['wedding', 'quince', 'birthday'], true)) $eventType = 'wedding';
    $eventLabel = admin_value('event_label'); $storyLabel = admin_value('story_label'); $storyTitle = admin_value('story_section_title');
    $publicUrl = rtrim(admin_value('public_url'), '/'); $previewUrl = rtrim(admin_value('preview_url'), '/'); $date = admin_value('event_date');
    $ceremony = admin_value('ceremony_time'); $reception = admin_value('reception_time'); $venue = admin_value('venue'); $address = admin_value('address');
    $maps = admin_value('maps_url'); $phrase = admin_value('romantic_phrase'); $storyIntro = admin_value('story_intro'); $dress = admin_value('dress_code'); $giftIntro = admin_value('gift_intro');
    $statement->bind_param('sssssssssssssssssssssiii', $bride, $groom, $couple, $eventType, $eventLabel, $storyLabel, $storyTitle, $publicUrl, $previewUrl, $date, $ceremony, $reception, $venue, $address, $maps, $heroImage, $venueImage, $phrase, $storyIntro, $dress, $giftIntro, $giftEnabled, $galleryEnabled, $uploadEnabled);
    $statement->execute();

    $db->query('DELETE FROM invitation_story_items');
    $storyStatement = $db->prepare('INSERT INTO invitation_story_items (year,title,description,image,sort_order,active) VALUES (?,?,?,?,?,1)');
    foreach (($_POST['story_title'] ?? []) as $index => $titleValue) {
        $title = trim((string)$titleValue);
        if ($title === '') continue;
        $year = trim((string)($_POST['story_year'][$index] ?? ''));
        $description = trim((string)($_POST['story_description'][$index] ?? ''));
        $image = invitation_admin_upload('story_file', $index) ?? trim((string)($_POST['story_image'][$index] ?? 'imagenes/boda1.jpg'));
        $order = $index + 1;
        $storyStatement->bind_param('ssssi', $year, $title, $description, $image, $order);
        $storyStatement->execute();
    }

    $db->query('DELETE FROM invitation_gifts');
    $giftStatement = $db->prepare('INSERT INTO invitation_gifts (label,url,details,sort_order,active) VALUES (?,?,?,?,1)');
    foreach (($_POST['gift_label'] ?? []) as $index => $labelValue) {
        $label = trim((string)$labelValue);
        if ($label === '') continue;
        $url = trim((string)($_POST['gift_url'][$index] ?? '#')) ?: '#';
        $details = trim((string)($_POST['gift_details'][$index] ?? ''));
        $order = $index + 1;
        $giftStatement->bind_param('sssi', $label, $url, $details, $order);
        $giftStatement->execute();
    }

    $keptGuestIds = [];
    foreach (($_POST['guest_code'] ?? []) as $index => $codeValue) {
        $code = mb_strtoupper(trim((string)$codeValue));
        $lastName = trim((string)($_POST['guest_last_name'][$index] ?? ''));
        $guestName = trim((string)($_POST['guest_name'][$index] ?? ''));
        if ($code === '' || $lastName === '' || $guestName === '') continue;
        $count = max(1, (int)($_POST['guest_count'][$index] ?? 1));
        $pass = trim((string)($_POST['guest_pass'][$index] ?? ''));
        $phone = preg_replace('/\D+/', '', (string)($_POST['guest_phone'][$index] ?? ''));
        $phone = $phone !== '' ? $phone : null;
        $id = (int)($_POST['guest_id'][$index] ?? 0);
        if ($id > 0) {
            $guestUpdate = $db->prepare('UPDATE invitation_guests SET invitation_code=?,last_name=?,guest_name=?,phone=?,guest_count=?,pass_information=? WHERE id=?');
            $guestUpdate->bind_param('ssssisi', $code, $lastName, $guestName, $phone, $count, $pass, $id);
            $guestUpdate->execute();
            $keptGuestIds[] = $id;
        } else {
            $guestInsert = $db->prepare('INSERT INTO invitation_guests (invitation_id,invitation_code,last_name,guest_name,phone,guest_count,pass_information) VALUES (1,?,?,?,?,?,?)');
            $guestInsert->bind_param('ssssis', $code, $lastName, $guestName, $phone, $count, $pass);
            $guestInsert->execute();
            $keptGuestIds[] = $db->insert_id;
        }
    }
    if ($keptGuestIds) {
        $db->query('DELETE FROM invitation_guests WHERE id NOT IN (' . implode(',', array_map('intval', $keptGuestIds)) . ')');
    } else {
        $db->query('DELETE FROM invitation_guests');
    }
    $db->commit();
    require_once dirname(__DIR__, 3) . '/includes/invitation.php';
    echo json_encode([
        'success' => true,
        'message' => 'Invitación guardada y publicada.',
        'invitation' => [
            'couple_name' => $couple,
            'event_label' => $eventLabel,
            'event_date_label' => invitation_date_label($date),
            'hero_image' => $heroImage,
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    if (isset($db)) $db->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No se pudo guardar: ' . $exception->getMessage()], JSON_UNESCAPED_UNICODE);
}
