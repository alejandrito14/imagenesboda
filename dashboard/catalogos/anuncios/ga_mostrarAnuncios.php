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
require_once("../../clases/class.Anuncios.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Anuncios();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	$valor=$_POST['valor'];
	$emp->valor=$valor;

	$emp->ActualizarMostrarAnuncios();

	$md->guardarMovimiento($f->guardar_cadena_utf8('Anuncios'),'mostrar anuncios',$f->guardar_cadena_utf8('Cambio al valor -'.$emp->valor));

	$respuesta['respuesta']=1;

	echo json_encode($respuesta);

		


}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>