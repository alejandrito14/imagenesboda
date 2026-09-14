<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
		/* header("Location: ../login.php"); */ echo "login";
	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Sucursalesfolios.php");
try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$su = new Sucursal();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$folio=new Sucursalesfolios();
	
	//enviamos la conexión a las clases que lo requieren
	$su->db = $db;
	$md->db = $db;	
	$folio->db=$db;
	
	$db->begin();
		
	//Recbimos parametros  
	$su->idsucursales = trim($_POST['idsucursales']);

	$obtener=$su->buscar_sucursalpaquete();
	$sucursal=$db->fetch_array($obtener);
	$sucursal_num=$db->num_rows($obtener);


	if ($sucursal_num>0) {

		echo 2;

	}else{

		$su->EliminarDeFolio();
		$su->EliminarSucursales();
		echo 1;
	}

	/*$sucursalid=$sucursal['idsucursales'];
	$empresasid=$sucursal['idempresas'];*/
	
				
	$db->commit();
	
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>