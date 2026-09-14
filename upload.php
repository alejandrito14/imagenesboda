<?php
require_once __DIR__ . '/includes/database.php';
$conn = boda_db();

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
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
    echo "El nombre de la persona que sube las fotos es obligatorio.";
    exit;
}

if (empty($_FILES['photos']['name'])) {
    echo "No se ha seleccionado ninguna imagen.";
    exit;
}

if (count($_FILES['photos']['name']) > 10) {
    echo "Solo se permite subir un máximo de 10 imágenes.";
    exit;
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

    $file_type = (new finfo(FILEINFO_MIME_TYPE))->file($file_tmp);
    if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/webp'], true) || @getimagesize($file_tmp) === false) {
        continue;
    }

    // Se fuerza una extensión segura y consistente con la compresión final.
    $new_file_name = bin2hex(random_bytes(12)) . '.jpg';
    $target_file = $target_dir . $new_file_name;

    $image = null;
    if ($file_type === 'image/jpeg') {
        $image = @imagecreatefromjpeg($file_tmp);
    } elseif ($file_type === 'image/png') {
        $image = @imagecreatefrompng($file_tmp);
    } elseif ($file_type === 'image/webp' && function_exists('imagecreatefromwebp')) {
        $image = @imagecreatefromwebp($file_tmp);
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
        @unlink($target_file);
    }
    $stmt->close();
}

$conn->close();

if ($success_count > 0) {
    echo "Se han subido " . $success_count . " imágenes exitosamente.";
} else {
    echo "No se pudo subir ninguna imagen.";
}

?>
