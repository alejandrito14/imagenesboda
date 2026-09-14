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
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$clientes = new Clientes();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$clientes->db = $db;	
	$md->db=$db;
	$db->begin();
		
	//Recbimos parametros
	$vistos =explode(',', $_POST['vistos']);
    $novistos = explode(',', $_POST['novistos']);

	if ($vistos[0]!='') {
		for ($i=0; $i <count($vistos) ; $i++) { 
			
			$clientes->idCliente=$vistos[$i];
			$clientes->mostraranuncios=1;
			$clientes->ActualizarAnunciovisto();

		}
	}
	if ($novistos[0]!='') {
		for ($i=0; $i <count($novistos) ; $i++) { 
			
			$clientes->idCliente=$novistos[$i];
			$clientes->mostraranuncios=0;
			$clientes->ActualizarAnunciovisto();

		}
	}
	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Anuncios Clientes'),'Anuncios clientes',$f->guardar_cadena_utf8('Modificación de anuncios clientes -'));
	
				
	$db->commit();
	$respuesta['respuesta']=1;
	echo json_encode($respuesta);
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>