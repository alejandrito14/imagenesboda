<?php

require_once __DIR__ . '/database.php';

function invitation_defaults(): array
{
    return [
        'id' => 1,
        'bride_name' => 'María',
        'groom_name' => 'Juan',
        'couple_name' => 'Juan & María',
        'event_type' => 'wedding',
        'event_label' => 'Nuestra boda',
        'story_label' => 'Nuestra historia',
        'story_title' => 'Todo comenzó con un encuentro',
        'public_url' => '',
        'preview_url' => '',
        'event_date' => '2026-11-15',
        'ceremony_time' => '18:00:00',
        'reception_time' => '20:00:00',
        'venue' => 'Hacienda Los Olivos',
        'address' => 'Camino de los Olivos 150, México',
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Hacienda+Los+Olivos',
        'hero_image' => 'imagenes/boda2.jpg',
        'venue_image' => 'imagenes/boda4.jpg',
        'romantic_phrase' => 'Hay momentos que son para siempre. Queremos compartir el nuestro contigo.',
        'story_intro' => 'Dos caminos, una historia y toda una vida por escribir.',
        'dress_code' => 'Formal · Evita vestir de blanco',
        'gift_intro' => 'El mejor regalo es compartir este día contigo.',
        'gift_enabled' => 1,
        'gallery_enabled' => 1,
        'upload_enabled' => 1,
    ];
}

function invitation_story_defaults(): array
{
    return [
        ['year' => '2019', 'title' => 'Nuestro primer encuentro', 'description' => 'Una coincidencia sencilla se convirtió en el inicio de nuestra historia.', 'image' => 'imagenes/boda1.jpg'],
        ['year' => '2022', 'title' => 'Nuestra primera aventura', 'description' => 'Descubrimos que cualquier lugar se siente como hogar si estamos juntos.', 'image' => 'imagenes/boda3.jpg'],
        ['year' => '2026', 'title' => 'Nuestro para siempre', 'description' => 'Elegimos celebrar el amor y comenzar esta nueva etapa rodeados de ustedes.', 'image' => 'imagenes/boda4.jpg'],
    ];
}

function invitation_load(): array
{
    $data = invitation_defaults();

    try {
        $result = boda_db()->query('SELECT * FROM invitation_settings WHERE id = 1 LIMIT 1');
        if ($row = $result->fetch_assoc()) {
            $data = array_replace($data, $row);
        }
    } catch (Throwable $exception) {
        // Los valores predeterminados permiten visualizar la plantilla antes de migrar la BD.
    }

    return $data;
}

function invitation_guest_by_code(string $code): ?array
{
    $code = mb_strtoupper(trim($code));
    if ($code === '') return null;

    try {
        $statement = boda_db()->prepare('SELECT * FROM invitation_guests WHERE UPPER(invitation_code) = ? LIMIT 1');
        $statement->bind_param('s', $code);
        $statement->execute();
        return $statement->get_result()->fetch_assoc() ?: null;
    } catch (Throwable $exception) {
        return null;
    }
}

function invitation_request_base_url(): string
{
    $forwardedProto = trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))[0]);
    $scheme = $forwardedProto ?: ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    if (($position = strpos($script, '/dashboard/')) !== false) {
        $basePath = substr($script, 0, $position);
    } elseif (($position = strpos($script, '/i/')) !== false) {
        $basePath = substr($script, 0, $position);
    } else {
        $basePath = rtrim(dirname($script), '/.');
    }

    return $scheme . '://' . $host . $basePath;
}

function invitation_public_base_url(?array $invitation = null): string
{
    $configured = trim((string) ($invitation['public_url'] ?? ''));
    if ($configured !== '') return rtrim($configured, '/');
    $preview = trim((string) ($invitation['preview_url'] ?? ''));
    return $preview !== '' ? rtrim($preview, '/') : invitation_request_base_url();
}

function invitation_preview_base_url(?array $invitation = null): string
{
    $configured = trim((string) ($invitation['preview_url'] ?? ''));
    return $configured !== '' ? rtrim($configured, '/') : invitation_public_base_url($invitation);
}

function invitation_guest_url(string $code, ?array $invitation = null): string
{
    return invitation_public_base_url($invitation) . '/i/' . rawurlencode(mb_strtoupper(trim($code)));
}

function invitation_date_label(string $date): string
{
    $parts = invitation_date_parts($date);
    return (int) $parts['day'] . ' de ' . mb_strtolower($parts['month']) . ' de ' . $parts['year'];
}

function invitation_celebration_message(array $invitation): string
{
    $name = trim((string) ($invitation['couple_name'] ?? ''));
    return match ($invitation['event_type'] ?? 'wedding') {
        'quince' => $name . ' está por celebrar sus XV años y nos encantaría contar contigo.',
        'birthday' => $name . ' está por celebrar su cumpleaños y nos encantaría contar contigo.',
        default => $name . ' están por celebrar su boda y nos encantaría contar contigo.',
    };
}

function generateWhatsAppUrl(array $invitation, array $guest): string
{
    $name = trim((string) ($guest['guest_name'] ?? '')) ?: 'invitado';
    $code = mb_strtoupper(trim((string) ($guest['invitation_code'] ?? '')));
    $phone = preg_replace('/\D+/', '', (string) ($guest['phone'] ?? ''));
    $url = invitation_guest_url($code, $invitation);
    $message = "Hola {$name} 👋\n\n"
        . "Tenemos una invitación muy especial para ti. 💍\n\n"
        . invitation_celebration_message($invitation) . "\n\n"
        . '📅 ' . invitation_date_label($invitation['event_date']) . "\n"
        . '🕒 ' . invitation_time_label($invitation['ceremony_time']) . "\n"
        . '📍 ' . $invitation['venue'] . "\n\n"
        . "🎟️ Tu invitación personal:\n{$url}\n\n"
        . "Por favor confirma tu asistencia desde el enlace.\n\n"
        . '¡Esperamos verte! ❤️';

    return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
}

function invitation_story_load(): array
{
    try {
        $result = boda_db()->query('SELECT * FROM invitation_story_items WHERE active = 1 ORDER BY sort_order, id');
        $items = $result->fetch_all(MYSQLI_ASSOC);
        return $items ?: invitation_story_defaults();
    } catch (Throwable $exception) {
        return invitation_story_defaults();
    }
}

function invitation_gifts_load(): array
{
    try {
        $result = boda_db()->query('SELECT * FROM invitation_gifts WHERE active = 1 ORDER BY sort_order, id');
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Throwable $exception) {
        return [
            ['label' => 'Ver mesa de regalos', 'url' => '#', 'details' => 'Agrega aquí tu tienda o alternativa preferida.'],
        ];
    }
}

function invitation_gallery_load(): array
{
    try {
        $result = boda_db()->query('SELECT id, nombre_subida, nombre_archivo FROM fotos_boda ORDER BY fecha_subida DESC');
        $photos = [];
        while ($row = $result->fetch_assoc()) {
            $relativePath = 'uploads/' . basename($row['nombre_archivo']);
            if (is_file(dirname(__DIR__) . '/' . $relativePath)) {
                $row['src'] = $relativePath;
                $photos[] = $row;
            }
        }
        return $photos;
    } catch (Throwable $exception) {
        return [];
    }
}

function invitation_date_parts(string $date): array
{
    $months = [1 => 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
    $timestamp = strtotime($date) ?: strtotime('2026-11-15');

    return [
        'day' => date('d', $timestamp),
        'month' => $months[(int) date('n', $timestamp)],
        'year' => date('Y', $timestamp),
    ];
}

function invitation_time_label(string $time): string
{
    $timestamp = strtotime($time);
    return $timestamp ? date('g:i A', $timestamp) : $time;
}

function invitation_escape(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
