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
require_once("../../clases/class.Tipojuego.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$tipojuego = new Tipojuego();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$tipojuego->db=$db;
	$md->db = $db;	
	
	$db->begin();
		

	//Recbimos parametros
	$tipojuego->idtipojuego = trim($_POST['idtipojuego']);
	$res=$tipojuego->buscartipojuego();
	$re_row=$db->fetch_assoc($res);


	$respuesta['respuesta']=$re_row;
				
	echo json_encode($respuesta);
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>
