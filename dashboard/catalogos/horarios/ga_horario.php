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
require_once("../../clases/class.Horarios.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$horario = new Horarios();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$horario->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$horario->idhorario = trim($_POST['id']);
	$horario->dia = trim($f->guardar_cadena_utf8($_POST['v_dia']));
	$horario->mes = trim($f->guardar_cadena_utf8($_POST['v_mes']));
	$horario->anio = trim($f->guardar_cadena_utf8($_POST['v_anio']));
	$horario->hora= trim($f->guardar_cadena_utf8($_POST['v_hora']));

	$horario->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	
	
	//Validamos si hacermos un insert o un update
	if($horario->idhorario == 0)
	{
		//guardando
		$horario->Guardarhorario();
		$md->guardarMovimiento($f->guardar_cadena_utf8('horarios'),'horario',$f->guardar_cadena_utf8('Nuevo horario creado con el ID-'.$horario->idhorario));
	}else{
		$horario->Modificarhorario();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('horarios'),'horario',$f->guardar_cadena_utf8('Modificación de horario -'.$horario->idhorario));
	}
				
	$db->commit();
	echo "1|".$horario->idhorario;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>