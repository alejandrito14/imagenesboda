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

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.PaquetesSucursales.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$paquetessucursales = new PaquetesSucursales();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$paquetessucursales->db=$db;
	$md->db = $db;	
	
	$db->begin();
		

	//Recbimos parametros
	$paquetessucursales->idsucursal = trim($_POST['idsucursal']);
	$paquetes=explode(',',$_POST['paquetes']);

	$seleccionar=$paquetessucursales->SeleccionarPaquetes();
	$contar=$db->num_rows($seleccionar);

	if ($contar>0) {

		$paquetessucursales->EliminarPaquetesSucursal();

	}


	if ($paquetes[0]!='') {
		

		for ($i=0; $i <count($paquetes) ; $i++) { 
			
			$paquetessucursales->idpaquete=$paquetes[$i];
			$paquetessucursales->guardar();
		}
	}




				
	$db->commit();
	$vrespuesta['respuesta']=1;

	echo json_encode($vrespuesta);
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>