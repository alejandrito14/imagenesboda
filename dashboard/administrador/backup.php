<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");

//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}


$db= new MySQL();
$db->backup_tables();	




?>