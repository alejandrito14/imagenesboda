<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	 echo "login";

	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Paquetes.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Paquetes();
	$ruta="/catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio'].'/';
	$emp->db=$db;
	$paquetes=$_POST['paquetes'];
	$idcategoria=$_POST['idcategoria'];

	$arraypaquetes=array();

	if ($paquetes!='') {
		$arraypaquetes=explode(',', $paquetes);
	}
	$emp->idcategoria=$idcategoria;
	$emp->ActualizarVisualizarCarrusel(0);
	if (count($arraypaquetes)>0) {
	
		for ($i=0; $i < count($arraypaquetes); $i++) { 
			
				$emp->idpaquete=$arraypaquetes[$i];
				$emp->VisualizarPaquetesCarrusel();
		}
	}
	
	$respuesta['respuesta']=1;

	echo json_encode($respuesta);

	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>