<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once('../clases/class.Sucursales.php');
require_once('../clases/class.MovimientoBitacora.php');


try
{
	$db= new MySQL();
	$su= new Sucursales();
	$md = new MovimientoBitacora();
	
	$su->db = $db;
	$md->db = $db;	
	
	$db->begin();
		
	//recibiendo datos
	$su->nombre = trim(utf8_decode($_POST['nombre']));
	$su->direccion = trim(utf8_decode($_POST['direccion']));
	$su->tel = trim($_POST['tel']);
	$su->email = trim(utf8_decode($_POST['email']));
	$su->notas_print = $_POST['notas_print'];
	
	
	$id = $_POST['id'];
	
	
	if($id == 0){
		//Insert
		//guardando
		$su->tipo = 1;
		
		$su->guardarSucursal();
		$md->guardarMovimiento(utf8_decode('sucursales'),'sucursales',utf8_decode('Nueva Sucursal creada -'.$su->idultimo));
	}else{
		//Update
		$su->idsucursales = $id;
		$su->modificarSucursal();
		$md->guardarMovimiento(utf8_decode('sucursales'),'sucursales',utf8_decode('Modifico Sucursal con ID: -'.$id));
	}
	
	
	$db->commit();
	echo 1;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>