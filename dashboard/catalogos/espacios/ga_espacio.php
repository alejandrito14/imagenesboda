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
require_once("../../clases/class.Espacios.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$espacio = new Espacios();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$espacio->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$espacio->idespacio = trim($_POST['id']);
	$espacio->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$espacio->lugar = trim($f->guardar_cadena_utf8($_POST['v_lugar']));
	$espacio->ubicacion = trim($f->guardar_cadena_utf8($_POST['v_ubicacion']));
	$espacio->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($espacio->idespacio == 0)
	{
		//guardando
		$espacio->GuardarEspacio();
		$md->guardarMovimiento($f->guardar_cadena_utf8('Espacios'),'espacio',$f->guardar_cadena_utf8('Nuevo espacio creado con el ID-'.$espacio->idespacio));
	}else{
		$espacio->ModificarEspacio();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Espacios'),'espacio',$f->guardar_cadena_utf8('Modificación de espacio -'.$espacio->idespacio));
	}
				
	$db->commit();
	echo "1|".$espacio->idespacio;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>