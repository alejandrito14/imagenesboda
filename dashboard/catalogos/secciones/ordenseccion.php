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
require_once("../../clases/class.Seccion.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$seccion = new Seccion();
$f = new Funciones();
$bt = new Botones_permisos();


$seccion->db = $db;




//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
						

	$idseccion=$_POST['idseccion'];
	$seccion->idseccion=$idseccion;

	$seccion->orden=$_POST['orden'];

	$seccion->ActualizarOrdenSeccion();

	$respuesta=1;


	echo $respuesta;


?>