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
require_once("../../clases/class.Opcionespedido.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$opcionespedido = new Opcionespedido();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$opcionespedido->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		
		
		

	//Recbimos parametros
	$opcionespedido->idopcionespedido = trim($_POST['id']);
	$opcionespedido->nombre= trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$opcionespedido->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$opcionespedido->confecha=$_POST['confecha'];	
	$opcionespedido->condireccionentrega=$_POST['condireccionentrega'];
	$opcionespedido->habilitaretiqueta=$_POST['habilitaretiqueta'];
	$opcionespedido->nombreetiqueta=$_POST['nombreetiqueta'];

	$opcionespedido->habilitarmensaje=$_POST['habilitarmensaje'];
	$opcionespedido->mensaje=$_POST['mensaje'];
	$opcionespedido->habilitarsumaenvio=$_POST['habilitarsumamonto'];

	
	//Validamos si hacermos un insert o un update
	if($opcionespedido->idopcionespedido == 0)
	{
		//guardando
		$opcionespedido->Guardaropcionespedido();
		$md->guardarMovimiento($f->guardar_cadena_utf8('opcionespedido'),'opcionespedido',$f->guardar_cadena_utf8('Nuevo opcionespedido creado con el ID-'.$opcionespedido->idtipopartido));
	}else{
		$opcionespedido->ModificarOpcionespedido();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('opcionespedido'),'opcionespedido',$f->guardar_cadena_utf8('Modificación de opcionespedido -'.$opcionespedido->idtipopartido));
	}
				
	$db->commit();
	echo "1|".$opcionespedido->idopcionespedido;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>