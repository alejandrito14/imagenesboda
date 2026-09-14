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
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$productoimagen = new Productos();
$f = new Funciones();
$bt = new Botones_permisos();


$productoimagen->db = $db;

				

$idproductos=$_POST['idproductos'];
$idempresas=$_POST['idempresas'];
$array = array();

$productoimagenes=$productoimagen->ObtenerImagenes($idproductos,$idempresas);
$productoimagenes_row=$db->fetch_assoc($productoimagenes);

$productoimagenes_num=$db->num_rows($productoimagenes);


$resultado=0;
if ($productoimagenes_num>0) {
	$resultado=1;

	do {

		$variable=array('idproductos_imagenes'=>$productoimagenes_row['idproductos_imagenes'],'idproductos'=>$productoimagenes_row['idproducto'],'idempresas'=>$productoimagenes_row['idempresas'],'imagen'=>$productoimagenes_row['imagen']);
	/*	echo $productoimagenes_row['idproducto'].$productoimagenes_row['imagen'].$productoimagenes_row['idempresas'];
*/
		array_push($array,$variable);
	}while($productoimagenes_row=$db->fetch_assoc($productoimagenes));


}



$respuesta['respuesta']=$resultado;
$respuesta['productos']=$array;

echo json_encode($respuesta);




?>
	
		