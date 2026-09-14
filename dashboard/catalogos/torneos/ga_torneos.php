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
require_once("../../clases/class.Torneos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$torneos = new Torneos();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$torneos->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$torneos->idtorneo = trim($_POST['id']);
	$torneos->nombre= trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$torneos->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$torneos->costo=trim($_POST['v_costo']);
	$torneos->fechainicial=$_POST['v_fechainicial'];
	$torneos->fechafinal=$_POST['v_fechafinal'];

	
	
	//Validamos si hacermos un insert o un update
	if($torneos->idtorneo == 0)
	{
		//guardando
		$torneos->GuardarTorneo();
		$md->guardarMovimiento($f->guardar_cadena_utf8('torneos'),'torneos',$f->guardar_cadena_utf8('Nuevo torneo creado con el ID-'.$torneos->idtorneo));
	}else{
		$torneos->ModificarTorneo();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('torneos'),'torneos',$f->guardar_cadena_utf8('Modificación de torneo -'.$torneos->idtorneo));
	}
				
	$db->commit();
	echo "1|".$torneos->idtorneo;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>