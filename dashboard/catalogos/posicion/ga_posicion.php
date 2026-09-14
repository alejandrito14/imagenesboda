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
require_once("../../clases/class.Posiciones.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$posiciones = new Posiciones();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$posiciones->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$posiciones->idposicion = trim($_POST['id']);
	$posiciones->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$posiciones->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($posiciones->idposicion == 0)
	{
		//guardando
		$posiciones->Guardarposicion();
		$md->guardarMovimiento($f->guardar_cadena_utf8('posicioness'),'posiciones',$f->guardar_cadena_utf8('Nuevo posiciones creado con el ID-'.$posiciones->idposicion));
	}else{
		$posiciones->ModificarPosicion();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('posicioness'),'posiciones',$f->guardar_cadena_utf8('Modificación de posiciones -'.$posiciones->idposicion));
	}
				
	$db->commit();
	echo "1|".$posiciones->idposiciones;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>