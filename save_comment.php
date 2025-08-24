<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto
$password = "root"; // Cambia esto
$dbname = "baseboda"; // Cambia esto

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión.']);
    exit();
}

$id_foto = $_POST['photoId'] ?? 0;
$nombre_comentador = $_POST['commenterName'] ?? '';
$comentario = $_POST['commentText'] ?? '';
$fecha_comentario = date("Y-m-d H:i:s");

if ($id_foto == 0 || empty($nombre_comentador) || empty($comentario)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit();
}

$sql = "INSERT INTO comentarios (id_foto, nombre_comentador, comentario, fecha_comentario) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $id_foto, $nombre_comentador, $comentario, $fecha_comentario);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el comentario.']);
}

$stmt->close();
$conn->close();
?>