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
require_once("../clases/class.Usuarios.php");
require_once('../clases/class.MovimientoBitacora.php');


try
{
	$db= new MySQL();
	$us= new Usuarios();
	$md = new MovimientoBitacora();
	
	$db->begin();
	
	$us->db=$db;
	$md->db = $db;
	//recibiendo datos
	$us->id_usuario=$_POST['id_usuario'];
	$us->idperfiles=$_POST['idperfiles'];
	$us->nombre=trim(utf8_decode($_POST['nombre']));
	$us->paterno=trim(utf8_decode($_POST['paterno']));
	$us->materno=trim(utf8_decode($_POST['materno']));
	$us->celular=trim($_POST['celular']);
	$us->telefono=trim($_POST['telefono']);
	$us->email=trim(utf8_decode($_POST['email']));
	$us->usuario=trim(utf8_decode($_POST['usuario']));
	$us->clave=trim(utf8_decode($_POST['clave']));
	$us->estatus=$_POST['estatus'];
	$us->sucursal = $_POST['sucursal'];
	
	$tipo = $_POST['tipo'];


	//Validamos que sea superUsuario
	if($tipo == 0){
		$us->tipo = 0;
	}else{
		$us->tipo = 1;
	}
	
	
		
	//guardando
	$us->ModificarUsuario();
	$db->commit();
	
	
	$md->guardarMovimiento(utf8_decode('usuarios'),'usuarios',utf8_decode('Modificación de Usuario -'.$_POST['usuario']));
	
	echo 1;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>