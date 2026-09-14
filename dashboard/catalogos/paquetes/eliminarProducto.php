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
$producto = new Productos();
$f = new Funciones();
$bt = new Botones_permisos();


$producto->db = $db;



$producto->tipo_usuario = $tipousaurio;
$producto->lista_empresas = $lista_empresas;

//Realizamos consulta






//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
						

$idproducto=$_POST['idproducto'];
$idempresa=$_POST['idempresa'];
$producto->idproducto=$idproducto;
$producto->empresa=$idempresa;

$productos=$producto->VerificarSiestaEnCompra($idproducto,$idempresa);
$productos_row=$db->fetch_assoc($productos);
$productos_num=$db->num_rows($productos);



	if ($productos_num==0) {
		$noencontrado=0;
	}else{
		$noencontrado=1;
	}

	if ($noencontrado==0) {
		

		$producto->EliminarProductosDescripcion();
		$producto->EliminarProducto();
	}


	$respuesta['respuesta']=$noencontrado;


	echo json_encode($respuesta);


?>
	