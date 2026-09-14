<?php
header('Content-Type: application/json');

require_once __DIR__ . '/includes/database.php';
$conn = boda_db();

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión.']);
    exit();
}

$id_foto = $_GET['id_foto'] ?? 0;

if ($id_foto == 0) {
    echo json_encode(['error' => 'ID de foto no especificado.']);
    exit();
}

$sql = "SELECT nombre_comentador, comentario, fecha_comentario FROM comentarios WHERE id_foto = ? ORDER BY fecha_comentario ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_foto);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(['comments' => $comments]);
?>
