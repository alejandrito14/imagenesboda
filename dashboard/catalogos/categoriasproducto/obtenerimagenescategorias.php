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
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$categoria = new Categoriasproductos();
$f = new Funciones();
$bt = new Botones_permisos();


$categoria->db = $db;

				

$idcategoriasproducto=$_POST['idcategoriasproducto'];

$array = array();

$categoria->idcategoria=$idcategoriasproducto;
$categorias=$categoria->ObtenerImagenesCategorias();

for ($i=0; $i <count($categorias) ; $i++) { 
	$categorias[$i]->imagen=$_SESSION['codservicio'].'/'.$categorias[$i]->imagen;
}


$respuesta['imagenes']=$categorias;

echo json_encode($respuesta);




?>