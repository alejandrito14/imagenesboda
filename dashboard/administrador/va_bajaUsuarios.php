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

try
{
	$db= new MySQL();
	
	$usuario=$_POST['id'];
	
	//comparando si exiten registro en la bitacora de ese usuario
	$querybi="SELECT * FROM bitacora WHERE idusuarios=".$usuario;
	$resp=$db->consulta($querybi);
	$rows=$db->fetch_assoc($resp);
	$total=$db->num_rows($resp);
	
	if($total==0)
	{
		$queryDE="DELETE FROM usuarios WHERE idusuarios=$usuario ";
		
		if($db->consulta($queryDE))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		
	}
	else
	{
		echo 2;
	}
		
}
catch(Exception $e)
{
}
?>