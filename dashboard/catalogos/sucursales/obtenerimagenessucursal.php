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
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$sucursal = new Sucursal();
$f = new Funciones();
$bt = new Botones_permisos();


$sucursal->db = $db;

				

$idsucursal=$_POST['idsucursal'];

$array = array();

$sucursal->idsucursales=$idsucursal;
$sucursales=$sucursal->ObtenerImagenesSucursal();


for ($i=0; $i <count($sucursales) ; $i++) { 
		$sucursales[$i]->imagen=$_SESSION['codservicio'].'/'.$sucursales[$i]->imagen;

}




$respuesta['imagenes']=$sucursales;

echo json_encode($respuesta);




?>
	