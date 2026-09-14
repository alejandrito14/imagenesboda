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
require_once("../../clases/class.Pagos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$pagos = new Pagos();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$pagos->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		




	//Recbimos parametros
	$pagos->idpagos = trim($_POST['id']);
	$pagos->etiqueta = trim($f->guardar_cadena_utf8($_POST['v_etiqueta']));
	$pagos->fechainicial = trim($f->guardar_cadena_utf8($_POST['v_fechainicial']));
	$pagos->fechafinal = trim($f->guardar_cadena_utf8($_POST['v_fechafinal']));

	$pagos->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($pagos->idpagos == 0)
	{
		//guardando
		$pagos->Guardarpagos();
		$md->guardarMovimiento($f->guardar_cadena_utf8('pagos'),'pagos',$f->guardar_cadena_utf8('Nuevo pagos creado con el ID-'.$pagos->idpagos));
	}else{
		$pagos->Modificarpagos();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('pagos'),'pagos',$f->guardar_cadena_utf8('Modificación de pagos -'.$pagos->idpagos));
	}
				
	$db->commit();
	echo "1|".$pagos->idpagos;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>