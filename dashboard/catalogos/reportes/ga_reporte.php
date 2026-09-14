<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Reportes.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Funciones.php");

try

{

	$db = new MySQL();
	//$pa = new Paqueterias();
	$pa = new Reportes();
	$md = new MovimientoBitacora();
	$fu = new Funciones();
	
	$pa->db = $db;
	$md->db = $db;
	
	$db->begin();
	
	//enviamos datos a las variables de la tablas	
	$pa->nombre = $fu->guardar_cadena_utf8($_POST['nombre']);
	$pa->direccion = $fu->guardar_cadena_utf8($_POST['direccion']);
	$pa->tel = $_POST['telefono'];
	$pa->email = $fu->guardar_cadena_utf8($_POST['email']);
	$pa->urlrastreo = $fu->guardar_cadena_utf8($_POST['urlrastreo']);
	$pa->estatus = $_POST['estatus'];
	$pa->idpaqueterias = $_POST['idpaqueterias'];	
	
	if($pa->idpaqueterias == 0){
		//guardando
		$pa->guardar_reporte();
		$md->guardarMovimiento($fu->guardar_cadena_utf8('reportes'),'reportes',$fu->guardar_cadena_utf8('Nuevo reporte creado con el ID :'.$pa->idpaqueterias));	
	}else{
		
		$pa->modificar_reporte();
		$md->guardarMovimiento($fu->guardar_cadena_utf8('reportes'),'reportes',$fu->guardar_cadena_utf8('Modificacion de reporte con el ID :'.$pa->idpaqueterias));			
	}

	$db->commit();
	echo 1;
	
	
}catch(Exception $e){
	$db->rollback();
	$v = explode ('|',$e);
	// echo $v[1];
	 $n = explode ("'",$v[1]);
	 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;

}

?>