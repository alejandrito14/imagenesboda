<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto
$password = "root"; // Cambia esto
$dbname = "baseboda"; // Cambia esto


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos.']);
    exit();
}

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 4; // Parámetro para limitar

$sql = "SELECT id, nombre_archivo, nombre_subida FROM fotos_boda ORDER BY fecha_subida DESC";
if ($limit > 0) {
    $sql .= " LIMIT " . $limit;
}

$result = $conn->query($sql);

$photos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $photos[] = $row;
    }
}

$conn->close();

echo json_encode(['photos' => $photos]);
?>