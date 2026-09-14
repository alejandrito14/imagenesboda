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
require_once("../../clases/class.CostoEnvio.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$costoenvio = new CostoEnvio();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$costoenvio->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		


	$costoenvio->idcodigopostalcosto=trim($_POST['id']);
	$costoenvio->idsucursal=trim($_POST['sucursal']);//

	$costoenvio->costoinicial=trim($_POST['costoinicial']);
	$costoenvio->costofinal=trim($_POST['costofinal']);
	$costoenvio->idproveedor=trim($_POST['proveedor']);
	$costoenvio->estatus=trim($_POST['v_estatus']);

	$costoenvio->idpais2=$_POST['v_pais2'];
	$costoenvio->idestado2=$_POST['v_estado2'];
	$costoenvio->idmunicipio2=$_POST['v_municipio2'];
	$costoenvio->codigopostalfinal=$_POST['codigopostalfinal'];
	$costoenvio->tipoasentamiento=$_POST['tipoasentamiento'];
	$costoenvio->asentamiento=$_POST['asentamiento'];

//	var_dump($costoenvio);
	//Validamos si hacermos un insert o un update
	if($costoenvio->idcodigopostalcosto == 0)
	{
		//guardando
		$costoenvio->Guardarcodigopostalcosto();
		$md->guardarMovimiento($f->guardar_cadena_utf8('costoenvio'),'costoenvio',$f->guardar_cadena_utf8('Nuevo costoenvio creado con el ID-'.$costoenvio->idcodigopostalcosto));
	}else{
		$costoenvio->Modificarcodigopostalcosto();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('costoenvio'),'costoenvio',$f->guardar_cadena_utf8('Modificación de costoenvio -'.$costoenvio->idcodigopostalcosto));
	}
				
	$db->commit();
	echo "1|".$costoenvio->idcodigopostalcosto;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>