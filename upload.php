<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto
$password = "root"; // Cambia esto
$dbname = "baseboda"; // Cambia esto

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Carpeta donde se guardarán las imágenes
$target_dir = "uploads/";

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
    $file_type = $uploaded_files['type'][$key];
    $file_error = $uploaded_files['error'][$key];

    if ($file_error !== UPLOAD_ERR_OK) {
        continue; // O maneja el error específico
    }

    // Generar un nombre único para el archivo
    $file_extension = pathinfo($name, PATHINFO_EXTENSION);
    $new_file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_file_name;

    // Comprimir y guardar la imagen (usando la librería GD)
    $image = null;
    if ($file_type == 'image/jpeg' || $file_type == 'image/jpg') {
        $image = imagecreatefromjpeg($file_tmp);
    } elseif ($file_type == 'image/png') {
        $image = imagecreatefrompng($file_tmp);
    }

    if ($image) {
        // Redimensionar o comprimir (ejemplo simple de compresión)
        imagejpeg($image, $target_file, 75); // 75 es el nivel de calidad
        imagedestroy($image);
    } else {
        // Si no se puede comprimir, simplemente se mueve
        move_uploaded_file($file_tmp, $target_file);
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO fotos_boda (nombre_subida, nombre_archivo, fecha_subida) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $uploaderName, $new_file_name, $uploadDate);
    
    if ($stmt->execute()) {
        $success_count++;
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