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
require_once("../../clases/class.Juego.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$juego = new Juego();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$juego->db=$db;
	$md->db = $db;	
	
	$db->begin();

	$idjuego=$_POST['idjuego'];
	$juego->idjuego=$idjuego;

	$consulta=$juego->buscarjuego();
	$row=$db->fetch_assoc($consulta);

	$obtenerjugadores=$juego->obtenerjugadores();


	$array = array('juego' =>$row,'jugadores'=>$obtenerjugadores);

	$respuesta['respuesta']=$array;

	echo json_encode($respuesta);


	//Validamos si hacermos un insert o un update
	
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>