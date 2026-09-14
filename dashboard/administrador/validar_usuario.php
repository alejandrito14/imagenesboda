<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once ("../clases/conexcion.php");
require_once("../clases/class.Usuarios.php");

$db = new MySQL();
$us = new Usuarios();

$us->db = $db;
try{
$us->usuario = $_POST['usuario'];

$result = $us->ValidarUsuario($us->usuario);

echo $result ;
}//fin del try
catch(Exeption $e)
{
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
}


?>