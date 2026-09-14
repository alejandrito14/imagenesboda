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
	$tipodepagos->idtipodepago = trim($_POST['id']);
	$tipodepagos->tipo= trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$tipodepagos->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$tipodepagos->habilitarfoto=$_POST['confoto'];	
	$tipodepagos->habilitarstripe=$_POST['constripe'];	
	$tipodepagos->claveprivada=$_POST['claveprivada'];
	$tipodepagos->clavepublica=$_POST['clavepublica'];
	$tipodepagos->cuenta=$_POST['cuenta'];
	$tipodepagos->habilitarcampomonto=$_POST['habilitarcampomonto'];

	
	//Validamos si hacermos un insert o un update
	if($tipodepagos->idtipodepago == 0)
	{
		//guardando
		$tipodepagos->Guardartipodepagos();
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipodepagos'),'tipodepagos',$f->guardar_cadena_utf8('Nuevo tipodepagos creado con el ID-'.$tipodepagos->idtipopartido));
	}else{
		$tipodepagos->Modificartipodepagos();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipodepagos'),'tipodepagos',$f->guardar_cadena_utf8('Modificación de tipodepagos -'.$tipodepagos->idtipopartido));
	}
				
	$db->commit();
	echo "1|".$tipodepagos->idtipodepagos;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>