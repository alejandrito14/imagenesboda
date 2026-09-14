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


$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Reportes.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$reporte = new Reportes();
$f = new Funciones();
$bt = new Botones_permisos();

$reporte->db = $db;
	


//Recibo parametros del filtro


//Envio parametros a la clase empresas

$idreporte=$_POST['idreporte'];
$reporte->idreporte=$idreporte;
//Realizamos consulta
$resultado_reporte = $reporte->buscar_reportes();
$resultado_reporte_num = $db->num_rows($resultado_reporte);
$resultado_reporte_row = $db->fetch_assoc($resultado_reporte);



$respuesta['respuesta']=$resultado_reporte_row;

echo json_encode($respuesta);

?>
