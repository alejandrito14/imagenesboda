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
require_once("../../clases/class.Presentacion.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Presentacion();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$emp->idpresentacion = trim($_POST['id']);
	$emp->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$emp->descripcion = trim($f->guardar_cadena_utf8($_POST['v_descripcion']));
	
	
	
	//Validamos si hacermos un insert o un update
	if($emp->idpresentacion == 0)
	{
		//guardando
		$emp->guardarPresentacion();
		$md->guardarMovimiento($f->guardar_cadena_utf8('Presentación'),'tipo_presentacion',$f->guardar_cadena_utf8('Nueva presentacion creado con el ID-'.$emp->idpresentacion));
	}else{
		$emp->modificarPresentacion();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Presentación'),'tipo_presentacion',$f->guardar_cadena_utf8('Modificación de la presentacion -'.$emp->idpresentacion));
	}
				
	$db->commit();
	echo "1|".$emp->idpresentacion;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>