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
require_once("../../clases/class.CostoEnviopordia.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$costoenvio = new CostoEnviopordia();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$costoenvio->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		


	$costoenvio->idfechaenvio=trim($_POST['id']);
	$costoenvio->idsucursal=trim($_POST['sucursal']);
	$costoenvio->costo=number_format(trim($_POST['costoinicial']), 2, '.', ',');
	$costoenvio->fecha=$_POST['fecha'];
	$costoenvio->estatus=$_POST['v_estatus'];
	$costoenvio->horainicial=$_POST['horainicial'];
	$costoenvio->horafinal=$_POST['horafinal'];



//	var_dump($costoenvio);
	//Validamos si hacermos un insert o un update
	if($costoenvio->idfechaenvio == 0)
	{
		//guardando
		$costoenvio->Guardarenviocosto();
		$md->guardarMovimiento($f->guardar_cadena_utf8('costoenviopordia'),'costoenviopordia',$f->guardar_cadena_utf8('Nuevo costoenviopordia creado con el ID-'.$costoenvio->idfechaenvio));
	}else{
		$costoenvio->Modificarenviocosto();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('costoenviopordia'),'costoenviopordia',$f->guardar_cadena_utf8('Modificación de costoenviopordia -'.$costoenvio->idfechaenvio));
	}
				
	$db->commit();
	echo "1|".$costoenvio->idfechaenvio;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>