<?php
// Incluye tu archivo de conexión a la base de datos
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();
require_once("../../clases/conexcion.php");
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_gruposresas = $_SESSION['se_ligruposresas'] ?? ''; // variable opcional de sesión

// Define la ruta donde se guardan las imágenes subidas
define('UPLOAD_DIR', '../../../uploads/');
$idmenumodulo=$_POST['idmenumodulo'];

$db = new MySQL();
// -----------------------------------------------------------
// Sección para la descarga de un grupo completo
// -----------------------------------------------------------
if (isset($_POST['descargar_grupo'])) {
    $nombre_subida = $_POST['descargar_grupo'];
       

    // Consulta la base de datos para obtener las imágenes de ese grupo
    $sql = "SELECT nombre_archivo FROM fotos_boda WHERE nombre_subida = '$nombre_subida'";
    $result = $db->consulta($sql);
  
    
    // Crea un archivo ZIP para comprimir las imágenes
    $zip = new ZipArchive();
    $zipFileName = $nombre_subida . '.zip';

    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        $filesToZip = [];
        while ($row = $result->fetch_assoc()) {
          
            $filePath = UPLOAD_DIR . $row['nombre_archivo'];
            // Verifica que el archivo exista antes de agregarlo al ZIP
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $row['nombre_archivo']);
                $filesToZip[] = $filePath;
            }
        }
        $zip->close();

        // Envía el archivo ZIP al navegador para su descarga
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);

        // Elimina el archivo ZIP temporalmente creado en el servidor
        if (file_exists($zipFileName)) {
            unlink($zipFileName);
        }
        exit;
    } else {
        echo "Error al crear el archivo ZIP.";
    }
}

// -----------------------------------------------------------
// Sección para la eliminación de imágenes seleccionadas
// -----------------------------------------------------------
if (isset($_POST['accion']) && $_POST['accion'] === 'borrar') {
    if (!empty($_POST['borrar'])) {
        $ids_a_borrar = $_POST['borrar'];

        // Crea una cadena de placeholders para la consulta IN
        // Ejemplo: (?, ?, ?)
        $placeholders = implode(',', $ids_a_borrar);
        
        // El tipo de dato para cada ID es 'i' (entero)
        $types = str_repeat('i', count($ids_a_borrar));

        // ------------------------------------------------------------------
        // Paso 1: Selecciona los nombres de archivo antes de borrarlos
        // ------------------------------------------------------------------
        $sql_select = "SELECT nombre_archivo FROM fotos_boda WHERE id IN ($placeholders)";
     
        $result = $db->consulta($sql_select);
        
      
        // Borra los archivos físicos del servidor
        while ($row = $result->fetch_assoc()) {
            $filePath = UPLOAD_DIR . $row['nombre_archivo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // ------------------------------------------------------------------
        // Paso 2: Elimina los registros de la base de datos
        // ------------------------------------------------------------------
        $sql_delete = "DELETE FROM fotos_boda WHERE id IN ($placeholders)";
        $stmt_delete = $db->consulta($sql_delete);


        // Redirige al usuario
            echo json_encode(['status' => 'success', 'message' => 'Imágenes eliminadas correctamente.']);
        exit;
    } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al procesar: ' . $e->getMessage()]);
        exit;
    }
}

// Si la petición no es válida, redirige con un mensaje de error
    echo json_encode(['status' => 'error', 'message' => 'Petición inválida.']);
exit;

?>
