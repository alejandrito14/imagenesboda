<?php
require_once __DIR__ . '/includes/invitation.php';

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => true,
    'photos' => invitation_gallery_load(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
