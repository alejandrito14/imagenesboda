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
require_once("../../clases/class.AgregarAproducto.php");


//Se crean los objetos de clase
$db = new MySQL();
$insumos = new Productos();
$f = new Funciones();
$bt = new Botones_permisos();
$agregar = new AgregarAproducto();


$insumos->db = $db;



$insumos->tipo_usuario = $tipousaurio;
$insumos->lista_empresas = $lista_empresas;

//Realizamos consulta






//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
						

$idproducto=$_POST['insumo'];
$cantidad=$_POST['cantidad'];
$idempresa=$_POST['empresa'];

$insumo=$insumos->ObtenerProducto($idproducto);
$insumo_row=$db->fetch_assoc($insumo);


$nombre=$insumo_row['nombre'];
$codigoproducto=$insumo_row['codigoproducto'];
$pm="";


/*$medida=$insumo_row['cantidad'];
$subtotalmedida=$insumo_row['cantidad']*$cantidad;
$tipomedida=$insumo_row['medida'];*/
$subtotal="";

$agregar->AgregarAdescripcion($idproducto,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto);


$agregar->EliminarSillevaCero();
$agregar->VerCarrito();



?>
	
			


	