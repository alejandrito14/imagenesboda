<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

$idmenumodulo = $_GET['idmenumodulo'];

if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../login.php");
    echo "login";
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Proveedores.php");
require_once('../../clases/class.MovimientoBitacora.php');

require_once('../../clases/class.Funciones.php');

require_once('../../clases/class.MovimientoBitacora.php');





try
{
	$db= new MySQL();
	$cli= new Proveedores();
	$md = new MovimientoBitacora();
	$f=new Funciones();
	
	$cli->db = $db;
	$md->db = $db;
		
	
	$idproveedor = $_POST['idproveedor'];

	
	$db->begin();

	$cli->idproveedor=$idproveedor;
	$obtenerrelacion=$cli->ObtenerTablarelacion();
	$numrow=$db->num_rows($obtenerrelacion);


/*	$noclient=$row_cliente['no_cliente'];
	$idempresa=$row_cliente['idempresas'];

	$obtenesnotas=$cli->obtenerTorneos($idcliente);
	$row_notas=$db->fetch_assoc($obtenesnotas);
	$num_notas=$db->num_rows($obtenesnotas);

*/

	if ($numrow>0) {
		echo 0;

	}else{



		$cli->Eliminarproveedor();
 		$md->guardarMovimiento(utf8_decode('Proveedores'),'proveedor',utf8_decode('Borrado proveedor con el ID :'.$cli->idproveedor));
		echo 1;

	}

	

	
	$db->commit();
	
	
	
}
catch(Exception $e)
{
	$db->rollback();
	     $v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

		 echo $db->m_error($n[0]);	
}
?>