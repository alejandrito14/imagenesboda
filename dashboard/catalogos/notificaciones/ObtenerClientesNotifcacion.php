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
require_once("../../clases/class.Notificaciones.php");
require_once("../../clases/class.Funciones.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$notificaciones = new Notificaciones();
	$f = new Funciones();
	
	//enviamos la conexión a las clases que lo requieren
	$md->db = $db;	
	$notificaciones->db=$db;
	
	$idnotificacion=$_POST['idnotificacion'];
	$notificaciones->idnotificacion=$idnotificacion;
	$obtenerclientes=$notificaciones->ObtenerClientesNotificacion2();
		

	$respuesta['clientes']=$obtenerclientes;
	echo json_encode($respuesta);
		

	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>