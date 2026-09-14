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
	$fu = new Funciones();
	
	$cli->db = $db;
	$md->db = $db;
	
		
	
	
	$idclientes_envio = $_POST['idclientes_envio'];


	
	$db->begin();
	
	$cli->idclientes_envios = trim($fu->guardar_cadena_utf8($_POST['idclientes_envio']));
	$cli->idCliente = trim($fu->guardar_cadena_utf8($_POST['idcliente']));
	$cli->envio_direccion = trim($fu->guardar_cadena_utf8($_POST['direccion']));
	$cli->envio_no_int = trim($fu->guardar_cadena_utf8($_POST['no_int']));
	$cli->envio_no_ext = trim($fu->guardar_cadena_utf8($_POST['no_ext']));
	$cli->envio_col = trim($fu->guardar_cadena_utf8($_POST['col']));
	$cli->envio_cp = trim($fu->guardar_cadena_utf8($_POST['cp']));
	$cli->envio_municipio = trim($fu->guardar_cadena_utf8($_POST['municipio']));
	$cli->envio_ciudad = trim($fu->guardar_cadena_utf8($_POST['ciudad']));
	$cli->envio_estado = trim($fu->guardar_cadena_utf8($_POST['estado']));
	$cli->envio_pais = trim($fu->guardar_cadena_utf8($_POST['pais']));
	$cli->envio_referencia = trim($fu->guardar_cadena_utf8($_POST['referencia']));
	$cli->envio_telefono=$fu->guardar_cadena_utf8($_POST['telefono']);
	
	
	if($cli->idclientes_envios == 0)
	{
		$cli->GuardarDireccionEnvio();
	    $md->guardarMovimiento($fu->guardar_cadena_utf8('Clientes_evios'),'Clientes_evios',$fu->guardar_cadena_utf8('Nueva direccion de envio del Cliente con ID'.$cli->idCliente.' el ID de la nueva direccion es ID :'.$cli->idclientes_envios));
		
	}else
	{
		$cli->ModificarDireccionEnvio();
		$md->guardarMovimiento($fu->guardar_cadena_utf8('clientes_envios'),'clientes_envios',$fu->guardar_cadena_utf8('Modificar la Direccion de envio con el ID :'.$cli->idclientes_envios));
	}
	//guardando
	
	
	$db->commit();
	echo 1;
	
	
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