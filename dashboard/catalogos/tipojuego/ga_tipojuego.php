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
require_once("../../clases/class.Tipojuego.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$tipojuego = new Tipojuego();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$tipojuego->db=$db;
	$md->db = $db;	
	
	$db->begin();
		


		


	//Recbimos parametros
	$tipojuego->idtipojuego = trim($_POST['id']);
	$tipojuego->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$tipojuego->numerocontendiente = trim($f->guardar_cadena_utf8($_POST['v_contendiente']));
	$tipojuego->numeroadversario = trim($f->guardar_cadena_utf8($_POST['v_adversario']));

	$tipojuego->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($tipojuego->idtipojuego == 0)
	{
		//guardando
		$tipojuego->Guardartipojuego();
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipojuego'),'tipojuego',$f->guardar_cadena_utf8('Nuevo tipojuego creado con el ID-'.$tipojuego->idtipojuego));
	}else{
		$tipojuego->Modificartipojuego();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('tipojuego'),'tipojuego',$f->guardar_cadena_utf8('Modificación de tipojuego -'.$tipojuego->idtipojuego));
	}
				
	$db->commit();
	echo "1|".$tipojuego->idtipojuego;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>