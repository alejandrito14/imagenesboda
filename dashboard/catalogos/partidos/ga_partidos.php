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
require_once("../../clases/class.Partidos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$partido = new Partidos();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$partido->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$partido->idpartido = trim($_POST['id']);
	$partido->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$partido->idespacio = trim($f->guardar_cadena_utf8($_POST['v_espacio']));
	$partido->idhorario = trim($f->guardar_cadena_utf8($_POST['v_horario']));

	$partido->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($partido->idpartido == 0)
	{
		//guardando
		$partido->Guardarpartido();
		$md->guardarMovimiento($f->guardar_cadena_utf8('partidos'),'partido',$f->guardar_cadena_utf8('Nuevo partido creado con el ID-'.$partido->idpartido));
	}else{
		$partido->Modificarpartido();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('partidos'),'partido',$f->guardar_cadena_utf8('Modificación de partido -'.$partido->idpartido));
	}
				
	$db->commit();
	echo "1|".$partido->idpartido;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>