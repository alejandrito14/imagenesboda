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
require_once("../../clases/class.Clientes.php");
require_once('../../clases/class.MovimientoBitacora.php');

require_once('../../clases/class.Funciones.php');


try
{
	$db= new MySQL();
	$cli= new Clientes();
	$md = new MovimientoBitacora();
	$f=new Funciones();
	
	$cli->db = $db;
	$md->db = $db;
		
	
	$idcliente = $_POST['idcliente'];

	
	$db->begin();

	$cli->idCliente=$idcliente;
	$obtenercliente=$cli->ObtenerInformacionCliente();
	$row_cliente=$db->fetch_assoc($obtenercliente);


/*	$noclient=$row_cliente['no_cliente'];
	$idempresa=$row_cliente['idempresas'];

	$obtenesnotas=$cli->obtenerTorneos($idcliente);
	$row_notas=$db->fetch_assoc($obtenesnotas);
	$num_notas=$db->num_rows($obtenesnotas);

*/

	if ($num_notas>0) {
		echo 0;

	}else{


	

		$cli->EliminarCliente();

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