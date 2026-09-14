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
require_once("../../clases/class.Tipopartidos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$tipopartidos = new Tipopartidos();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$tipopartidos->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$tipopartidos->idtipopartido = trim($_POST['id']);
	$tipopartidos->nombre= trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$tipopartidos->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$tipopartidos->numeroset=$_POST['v_numero'];
	
	
	//Validamos si hacermos un insert o un update
	if($tipopartidos->idtipopartido == 0)
	{
		//guardando
		$tipopartidos->GuardarTipopartido();
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipopartidos'),'tipopartidos',$f->guardar_cadena_utf8('Nuevo tipopartidos creado con el ID-'.$tipopartidos->idtipopartido));
	}else{
		$tipopartidos->ModificarTipopartido();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipopartidos'),'tipopartidos',$f->guardar_cadena_utf8('Modificación de tipopartidos -'.$tipopartidos->idtipopartido));
	}
				
	$db->commit();
	echo "1|".$tipopartidos->idtipopartido;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>