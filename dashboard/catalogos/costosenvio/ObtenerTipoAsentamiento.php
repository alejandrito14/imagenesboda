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


//Inlcuimos las clases a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.TipoAsentamiento.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.CodigoPostal.php");

try
{
	
	//Declaramos objetos de clases
	$db = new MySQL();
	$lo = new TipoAsentamiento();
	$f=new Funciones();
	$co = new CodigoPostal();
	$co->db=$db;

	//Enviamos la conexion a la clase
	$lo->db = $db;

	$idpais=$_POST['idpais'];
	$idestado=$_POST['idestado'];
	$idmunicipio=$_POST['idmunicipio'];
	$codigopostal=$_POST['codigopostal'];


	$co->idestado=$idestado;
	$co->idmunicipio=$idmunicipio;

	$resultado=$co->obtenerClaveestado();
	$rowresultado=$db->fetch_assoc($resultado);

	$resultado2=$co->obtenerClavemunicipio();
	$rowresultado2=$db->fetch_assoc($resultado2);


	$c_estado=$rowresultado['clave'];
	$c_municipio=$rowresultado2['clave'];


	$obtenertipoasentamiento=$lo->ObtenerTiposAsentamiento($c_estado,$c_municipio,$codigopostal);



	$respuesta['respuesta']=$obtenertipoasentamiento;
	
	//Retornamos en formato JSON 
	$myJSON = json_encode($respuesta);
	echo $myJSON;

}catch(Exception $e){
	//$db->rollback();
	//echo "Error. ".$e;
	
	$array->resultado = "Error: ".$e;
	$array->msg = "Error al ejecutar el php";
	$array->id = '0';
		//Retornamos en formato JSON 
	$myJSON = json_encode($array);
	echo $myJSON;
}
?>