<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";

	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Categoriasproductos();
	$ruta="./catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio'].'/';

//paquetes/imagenespaquete/60/2021-05-05_19-16-52-87.jpg

	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$emp->idcategoria = trim($_POST['id']);


	$paquetescategorias=$emp->ObtenerPaquetesCategorias();

	for ($i=0; $i <count($paquetescategorias) ; $i++) { 
		$imagen="../images/sinimagenlogo.png";

		if ($paquetescategorias[$i]->foto!='') {
		
			$imagen=$paquetescategorias[$i]->foto;

		}

		$paquetescategorias[$i]->ruta=$ruta.$imagen;
	}


	$respuesta['respuesta']=$paquetescategorias;

	echo json_encode($respuesta);

	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>