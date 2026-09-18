<?php
require_once __DIR__ . '/includes/database.php';
header('Content-Type: application/json; charset=utf-8');

function upload_response(int $status, array $payload): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$conn = boda_db();

// Verificar conexión
if ($conn->connect_error) {
    upload_response(500, ['success' => false, 'message' => 'No se pudo conectar con la base de datos.']);
}

// Carpeta donde se guardarán las imágenes
$target_dir = __DIR__ . "/uploads/";

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Variables del formulario
$uploaderName = $_POST['uploaderName'] ?? '';
$uploadDate = date("Y-m-d H:i:s");

// Validar datos
if (empty($uploaderName)) {
    upload_response(422, ['success' => false, 'message' => 'El nombre de la persona que sube las fotos es obligatorio.']);
}

if (empty($_FILES['photos']['name'])) {
    upload_response(422, ['success' => false, 'message' => 'No se ha seleccionado ninguna imagen.']);
}

if (count($_FILES['photos']['name']) > 10) {
    upload_response(422, ['success' => false, 'message' => 'Solo se permite subir un máximo de 10 imágenes.']);
}

$uploaded_files = $_FILES['photos'];
$success_count = 0;

foreach ($uploaded_files['name'] as $key => $name) {
    $file_tmp = $uploaded_files['tmp_name'][$key];
    $file_error = $uploaded_files['error'][$key];

    if ($file_error !== UPLOAD_ERR_OK) {
        continue;
    }

    if (($uploaded_files['size'][$key] ?? 0) > 12 * 1024 * 1024) {
        continue;
    }
 $image_info = getimagesize($file_tmp);
$file_type = $image_info['mime'] ?? false;

if (
    !in_array($file_type, ['image/jpeg', 'image/png', 'image/webp'], true)
    || $image_info === false
) {
    continue;
}
 
    // Se fuerza una extensión segura y consistente con la compresión final.
    $new_file_name = bin2hex(random_bytes(12)) . '.jpg';
    $target_file = $target_dir . $new_file_name;

    $image = null;
    if ($file_type === 'image/jpeg') {
        $image = imagecreatefromjpeg($file_tmp);
    } elseif ($file_type === 'image/png') {
        $image = imagecreatefrompng($file_tmp);
    } elseif ($file_type === 'image/webp' && function_exists('imagecreatefromwebp')) {
        $image = imagecreatefromwebp($file_tmp);
    }

    if (!$image || !imagejpeg($image, $target_file, 82)) {
        if ($image) imagedestroy($image);
        continue;
    }
    imagedestroy($image);
  
    // Insertar datos en la base de datos
    $sql = "INSERT INTO fotos_boda (nombre_subida, nombre_archivo, fecha_subida) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $uploaderName, $new_file_name, $uploadDate);
    
    if ($stmt->execute()) {
        $success_count++;
    } else {
        unlink($target_file);
    }
    $stmt->close();
}

$conn->close();

if ($success_count > 0) {
    upload_response(200, ['success' => true, 'message' => 'Se han subido ' . $success_count . ' imágenes exitosamente.']);
} else {
    upload_response(422, ['success' => false, 'message' => 'No se pudo subir ninguna imagen.']);
}

?>
