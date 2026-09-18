<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/invitation.php';

function rsvp_response(int $status, array $payload): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    rsvp_response(405, ['success' => false, 'message' => 'Método no permitido.']);
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$action = $input['action'] ?? '';
$code = mb_strtoupper(trim((string) ($input['invitation_code'] ?? '')));
$lastName = trim((string) ($input['last_name'] ?? ''));
if ($code === '' || $lastName === '') rsvp_response(422, ['success' => false, 'message' => 'Escribe tu código y apellidos.']);

try {
    $db = boda_db();
    $statement = $db->prepare('SELECT id, guest_name, last_name, guest_count, pass_information, attendance FROM invitation_guests WHERE UPPER(invitation_code) = ? AND LOWER(last_name) = LOWER(?) LIMIT 1');
    $statement->bind_param('ss', $code, $lastName);
    $statement->execute();
    $guest = $statement->get_result()->fetch_assoc();
    if (!$guest) rsvp_response(404, ['success' => false, 'message' => 'No encontramos una invitación con esos datos. Revisa que estén escritos como en tu pase.']);

    if ($action === 'lookup') {
        rsvp_response(200, ['success' => true, 'guest' => ['guest_name' => invitation_guest_display_name($guest), 'guest_count' => (int) $guest['guest_count'], 'pass_information' => $guest['pass_information'], 'attendance' => $guest['attendance']]]);
    }
    if ($action === 'respond') {
        $attendance = $input['attendance'] ?? '';
        if (!in_array($attendance, ['yes', 'no'], true)) rsvp_response(422, ['success' => false, 'message' => 'Selecciona una respuesta válida.']);
        $update = $db->prepare('UPDATE invitation_guests SET attendance = ?, responded_at = NOW() WHERE id = ?');
        $update->bind_param('si', $attendance, $guest['id']);
        $update->execute();
        $message = $attendance === 'yes' ? '¡Gracias por confirmar! Nos emociona mucho celebrar contigo.' : 'Gracias por avisarnos. Te tendremos presente en este día tan especial.';
        rsvp_response(200, ['success' => true, 'message' => $message]);
    }
    rsvp_response(400, ['success' => false, 'message' => 'Acción no válida.']);
} catch (Throwable $exception) {
    rsvp_response(500, ['success' => false, 'message' => 'El servicio de confirmación no está disponible por el momento.']);
}
