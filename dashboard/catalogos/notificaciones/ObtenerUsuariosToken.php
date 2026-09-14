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
require_once("../../clases/class.Usuarios.php");
require_once("../../clases/class.Funciones.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$usuarios = new Usuarios();
	$f = new Funciones();
	
	//enviamos la conexión a las clases que lo requieren
	$usuarios->db=$db;
	$md->db = $db;	
	
	$obtenerUsuarios=$usuarios->ObtenerUsuariosToken();
		

	$respuesta['usuarios']=$obtenerUsuarios;
	echo json_encode($respuesta);
		

	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>