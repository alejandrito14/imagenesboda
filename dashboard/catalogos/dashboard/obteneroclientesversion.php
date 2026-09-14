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
require_once("../../clases/class.Dashboard.php");

require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.PagConfig.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$dashboard = new Dashboard();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$confi=new Configuracion();
	//enviamos la conexión a las clases que lo requieren
	$dashboard->db=$db;
	$md->db = $db;	
	$confi->db=$db;
	

	//Recbimos parametros

	$obtener=$confi->ObtenerInformacionConfiguracion();
	$version=$obtener['versionapp'];


	$obtenerversiones=$dashboard->ObtenerTodasversiones();
	$versionactual=explode('.',$version);
	$arrayversiones=array();
	for ($i=0; $i < count($obtenerversiones); $i++) { 
		$esmayor=0;
		if ($obtenerversiones[$i]->v1>=$versionactual[0]) {
			
			$esmayor=1;

		}

		if ($obtenerversiones[$i]->v2>=$versionactual[1]) {
			$esmayor=1;	
				
			}

		if ($obtenerversiones[$i]->v3>=$versionactual[2] ) {
					
					$variable=$obtenerversiones[$i]->v1.'.'.$obtenerversiones[$i]->v2.'.'.$obtenerversiones[$i]->v3;

					array_push($arrayversiones, $variable);
				}
		
	}
	$totales=0;$concatenar="";
	for ($i=0; $i < count($arrayversiones); $i++) { 
		
		$resultado=$dashboard->Obtenerporversion($arrayversiones[$i]);

		$totales=$totales+$resultado[0]->total;

		$concatenar.=$arrayversiones[$i].",";
	}

	
	$contarmenosactuales=$dashboard->ContarMenosActuales($concatenar);

	$respuesta['anterior']=$contarmenosactuales[0]->total;

	$respuesta['actual']=$totales;
	$respuesta['versionactual']=$version;

	echo json_encode($respuesta);


	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>