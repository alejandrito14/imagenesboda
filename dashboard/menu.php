<?php


if (!isset($_SESSION)) 
{
  session_start();
}

require_once("clases/conexcion.php");
require_once("clases/class.Menu.php");

require_once("clases/class.Funciones.php");

try

{

	$db= new MySQL();
	
	$me= new Menu();
    $fu = new Funciones();
	
	$me->db=$db;
	$me->idperfil=$_SESSION['se_sas_Perfil'];
	
	echo $fu->imprimir_cadena_utf8($me->ArmarMenu());
}
catch(Exception $e)
{
	echo "Error 404: ".$e;
}
?>




