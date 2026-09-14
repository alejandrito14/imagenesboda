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
require_once("../../clases/class.Unidadmedida.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new UnidadMedida();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$emp->idmedida = trim($_POST['id']);
	$emp->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$emp->medida = trim($f->guardar_cadena_utf8($_POST['v_medida']));
	$emp->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	
	//Validamos si hacermos un insert o un update
	if($emp->idmedida == 0)
	{
		//guardando
		$emp->guardarMedida();
		$md->guardarMovimiento($f->guardar_cadena_utf8('Medida'),'tipo_medida',$f->guardar_cadena_utf8('Nueva medida creado con el ID-'.$emp->idmedida));
	}else{
		$emp->modificarMedida();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Medida'),'tipo_medida',$f->guardar_cadena_utf8('Modificación de la medida -'.$emp->idmedida));
	}
				
	$db->commit();
	echo "1|".$emp->idmedida;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>