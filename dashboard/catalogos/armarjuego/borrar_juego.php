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
		
	//Recbimos parametros
	$juego->idjuego = trim($_POST['id']);

	$obtenerjuego=$juego->buscarjuego();
	$obtener_row=$juego->fetch_assoc($obtenerjuego);

	$jugado=$obtener_row['jugado'];

	$respuesta=0;
	if ($jugado==0) {	
			
		$juego->borrarJuego();
		$respuesta=1;
	}


	
				
	$db->commit();
	echo $respuesta;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>