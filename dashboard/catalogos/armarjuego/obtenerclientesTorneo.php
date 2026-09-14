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
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Torneos.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$clientes = new Clientes();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$torneo = new Torneos();
	$torneo->db=$db;
	
	//enviamos la conexión a las clases que lo requieren
	$clientes->db=$db;
	$md->db = $db;	
	
	$db->begin();

	$idtorneo=$_POST['idtorneo'];
	$torneo->idtorneo=$idtorneo;
	$consultatorneo=$torneo->buscarTorneo();
	$consulta_row=$db->fetch_assoc($consultatorneo);


	if ($consulta_row['costo']>0) {

			$consulta=$clientes->ObtenerClientesTorneos($idtorneo);

	}else{


			$consulta=$clientes->ObtenerClientesTorneos2($idtorneo);

	}


	$respuesta['respuesta']=$consulta;

	echo json_encode($respuesta);


	//Validamos si hacermos un insert o un update
	
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>