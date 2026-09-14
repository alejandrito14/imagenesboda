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
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.AccesoEmpresa.php");

//Se crean los objetos de clase
$db = new MySQL();
$su = new Sucursal();
$f = new Funciones();
$bt = new Botones_permisos();


$acceso=new AccesoEmpresa();

$acceso->db=$db;

			

$su->db = $db;
	
$tipousaurio=$_SESSION['se_sas_Tipo'];
$idusuario=$_SESSION['se_sas_Usuario'];

//Recibo parametros del filtro


//Envio parametros a la clase empresas


//Realizamos consulta
if ($tipousaurio==0) {
	

$resultado_sucursales = $su->ObtenerTodos();
$resultado_sucursales_num = $db->num_rows($resultado_sucursales);
$resultado_sucursales_row = $db->fetch_assoc($resultado_sucursales);

}else{
	
	$acceso->idusuarios=$idusuario;
	$resultado_sucursales=$acceso->obtenerSucursalAsignadas();
	$resultado_sucursales_row=$db->fetch_assoc($resultado_sucursales);
	$resultado_sucursales_num = $db->num_rows($resultado_sucursales);



}


?>

   <option value="0">TODAS LAS SUCURSALES</option>

<?PHP
	do
	{
?>
      <option value="<?php echo $resultado_sucursales_row['idsucursales']; ?>"><?php echo $resultado_sucursales_row['sucursal']; ?> </option>
<?php
	}while($resultado_sucursales_row = $db->fetch_assoc($resultado_sucursales));
?>
