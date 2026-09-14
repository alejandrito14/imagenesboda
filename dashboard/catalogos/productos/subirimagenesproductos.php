<?php
/**
 * This is just an example of how a file could be processed from the
 * upload script. It should be tailored to your own requirements.
 */
require_once("../../clases/conexcion.php");

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain');
header('Content-Length: ');
header('Accept-Ranges: bytes');
// Only accept files with these extensions
$db = new MySQL();

$whitelist = array('jpg','JPG','JPEG','jpeg','png','PNG');

$name      = null;
$error     = 'No se pudo cargar el archivo.';
$uploads_dir = 'archivosproductos';
if (isset($_FILES)) {
	if (isset($_FILES['file'])) {
		try{
		$tmp_name = $_FILES['file']['tmp_name'];
		$name     = basename($_FILES['file']['name']);
		$error    = $_FILES['file']['error'];
		
		if ($error === UPLOAD_ERR_OK) {
			$extension = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($extension, $whitelist)) {
				$error = 'Tipo de archivo inválido.';
			} else {

				$puronombre =$name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME); //Obtenemos el nombre del archivo
				$fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.


				$nombre=$puronombre.date('Y-m-d H:i:s').'.'.$extension;
				move_uploaded_file($tmp_name,$uploads_dir.'/'.$nombre);

				$idproductos=$_POST['idproductos'];
				$idempresas=$_POST['idempresas'];



				$sql="INSERT INTO `productos_imagenes` (`idproducto`, `idempresas`,`imagen`) VALUES ('$idproductos', $idempresas, '$nombre')";

				
				$db->consulta($sql);


			}
		}
	}catch(Exception $e){

		$error=$e;
	}
	}
}

echo json_encode(array(
	'name'  => $name,
	'error' => $error,
));
die();