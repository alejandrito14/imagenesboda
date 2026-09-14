<?php


/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
		/* header("Location: ../login.php"); */ echo "login";
	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Seccion.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$su = new Seccion();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$su->db = $db;
	$md->db = $db;	

	$db->begin();
		
	//Recbimos parametros
	$su->idseccion = trim($_POST['idseccion']);

	$vinculadas=$su->ObtenerSucursalesVinculadas();

	$vrespuesta['respuesta']=$vinculadas;
	
	echo json_encode($vrespuesta);
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>