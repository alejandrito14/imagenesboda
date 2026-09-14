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
require_once("../../clases/class.Paquetes.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$paquete = new Paquetes();
$f = new Funciones();
$bt = new Botones_permisos();


$paquete->db = $db;



$paquete->tipo_usuario = $tipousaurio;
$paquete->lista_empresas = $lista_empresas;

//Realizamos consulta






//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
						

$idpaquete=$_POST['idpaquete'];
$paquete->idpaquete=$idpaquete;

/*$idempresa=$_POST['idempresa'];
$paquete->idpaquete=$idpaquete;
$paquete->empresa=$idempresa;*/

/*$paquetes=$paquete->VerificarSiestaEnCompra($idpaquete,$idempresa);
$paquetes_row=$db->fetch_assoc($paquetes);
$paquetes_num=$db->num_rows($paquetes);
*/


	/*if ($paquetes_num==0) {
		$noencontrado=0;
	}else{
		$noencontrado=1;
	}

	if ($noencontrado==0) {
		*/
	$paquete->EliminarPaquetesProductos();
	$paquete->EliminarComplementos();
	$paquete->eliminarpreciopaquete();
	$paquete->EliminarPaquete();
		
	//}


	$respuesta=1;


	echo $respuesta;


?>