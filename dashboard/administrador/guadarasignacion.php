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
require_once("../clases/class.Funciones.php");
require_once("../clases/class.AccesoEmpresa.php");



try
{
	$db= new MySQL();
	$us= new Usuarios();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	$acceso=new AccesoEmpresa();
	
	$us->db=$db;
	$md->db = $db;	
	$acceso->db=$db;
	
	$db->begin();
		
	$id = $_POST['idusuario'];
	$empresa=$_POST['sucursales'];
	$acceso->idusuarios=$id;

	$empresas=explode(',',$empresa);

	$acceso->EliminarAsignacion();



	for ($i=0; $i <count($empresas); $i++) { 
		
			$acceso->idsucursales=$empresas[$i];
			$acceso->AsignarUsuariosEmpresas();


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