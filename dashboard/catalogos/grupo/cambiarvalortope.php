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
$idmenumodulo = $_GET['idmenumodulo'];

//validaciones para todo el sistema


$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Grupos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.AgregarComplemento.php");


//Se crean los objetos de clase
$db = new MySQL();
$grupo = new Grupos();
$f = new Funciones();
$bt = new Botones_permisos();
$agregar = new AgregarComplemento();
$agregar->db=$db;

$grupo->db = $db;


$grupo->tipo_usuario = $tipousaurio;
$grupo->lista_empresas = $lista_empresas;

//Realizamos consulta


try{
	
	
	$posicion=$_POST['posicion'];
	$valor=$_POST['valor'];


	$agregar->CambiarValortope($posicion,$valor);
	$agregar->VerCarrito();

}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>