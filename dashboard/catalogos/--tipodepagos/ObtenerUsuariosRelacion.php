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
require_once("../../clases/class.Tipodepagos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$tipodepagos = new Tipodepagos();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$tipodepagos->db=$db;
	$md->db = $db;	
	
	$db->begin();
		

	//Recbimos parametros
	$tipodepagos->idtipodepago = trim($_POST['idtipodepago']);


	$obtener=$tipodepagos->ObtenerRelacionUsuarios();
		

	$db->commit();
	$respuesta['respuesta']=$obtener;

	echo json_encode($respuesta);

	
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>