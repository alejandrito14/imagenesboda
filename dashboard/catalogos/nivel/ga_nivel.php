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
require_once("../../clases/class.Niveles.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$nivel = new Niveles();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$nivel->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		




	//Recbimos parametros
	$nivel->idnivel = trim($_POST['id']);
	$nivel->nombre = trim($f->guardar_cadena_utf8($_POST['v_nivel']));
	$nivel->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($nivel->idnivel == 0)
	{
		//guardando
		$nivel->Guardarnivel();
		$md->guardarMovimiento($f->guardar_cadena_utf8('nivel'),'nivel',$f->guardar_cadena_utf8('Nuevo nivel creado con el ID-'.$nivel->idnivel));
	}else{
		$nivel->Modificarnivel();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('nivel'),'nivel',$f->guardar_cadena_utf8('Modificación de nivel -'.$nivel->idnivel));
	}
				
	$db->commit();
	echo "1|".$nivel->idnivel;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>