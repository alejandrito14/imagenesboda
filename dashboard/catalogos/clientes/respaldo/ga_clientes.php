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
		
	
	$idsucursales = $_POST['v_idsucursal'];

	
	$db->begin();
	
	//enviamos datos a las variables de la tablas	
	
	//die($_POST['v_descuento']."s");
	
	if($_POST['v_f_nacimiento'] == ""){
		$f_nacimiento = "1900-12-12";
	}else{
		$f_nacimiento = trim($_POST['v_f_nacimiento']);
	}
	$cli->no_cliente = trim($f->guardar_cadena_utf8($_POST['v_no_cliente']));
	$cli->idCliente = trim($f->guardar_cadena_utf8($_POST['v_idcliente']));
	$cli->no_tarjeta = trim($f->guardar_cadena_utf8($_POST['v_no_tarjeta']));
	$cli->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$cli->paterno = trim($f->guardar_cadena_utf8($_POST['v_paterno']));
	$cli->materno = trim($f->guardar_cadena_utf8($_POST['v_materno']));
	$cli->direccion = trim($f->guardar_cadena_utf8($_POST['v_direccion']));
	$cli->telefono = trim($f->guardar_cadena_utf8($_POST['v_telefono']));
	$cli->fax = trim(utf8_decode($_POST['v_telefono']));
	$cli->email = trim(utf8_decode($_POST['v_email']));
	$cli->sexo = trim(utf8_decode($_POST['v_sexo']));
	$cli->usuario = trim($f->guardar_cadena_utf8($_POST['v_usuario']));
	$cli->clave = trim($f->guardar_cadena_utf8($_POST['v_clave']));
	$cli->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$cli->direccion_envio = trim($f->guardar_cadena_utf8($_POST['v_direccion_envio']));
	$cli->cp = $_POST['v_cp'];
	$cli->habilitarobservacion=$_POST['habilitarobservaciones'];
	$cli->edad = trim($f->guardar_cadena_utf8($_POST['v_edad']));
	$cli->celular = $_POST['v_celular'];

	//$cli->f_nacimiento = trim(utf8_decode($_POST['v_f_nacimiento']));
	$cli->f_nacimiento = $f_nacimiento;
	$cli->descuento = trim(utf8_decode($_POST['v_descuento']));
	$cli->nivel = trim($_POST['v_nivel']);
	$cli->idsucursales = $idsucursales;
	
	
	//variables de lo fiscal
	
	$cli->fis_razonsocial = trim($f->guardar_cadena_utf8($_POST['v_fis_razonsocial']));
	$cli->fis_rfc = trim($f->guardar_cadena_utf8($_POST['v_fis_rfc']));
	$cli->fis_direccion = trim($f->guardar_cadena_utf8($_POST['v_fis_direccion']));
	$cli->fis_no_ext = trim(utf8_decode($_POST['v_fis_no_ext']));
	$cli->fis_no_int = trim(utf8_decode($_POST['v_fis_no_int']));
	$cli->fis_cp = trim(utf8_decode($_POST['v_fis_cp']));
	$cli->fis_estado = trim($f->guardar_cadena_utf8($_POST['v_fis_estado']));
	$cli->fis_ciudad = trim($f->guardar_cadena_utf8($_POST['v_fis_ciudad']));
	$cli->fis_col= trim($f->guardar_cadena_utf8($_POST['v_fis_col']));
	$cli->fis_municipio= trim($f->guardar_cadena_utf8($_POST['v_fis_municipio']));


	$cli->municipio=trim($f->guardar_cadena_utf8($_POST['v_municipio']));
	$cli->estado=trim($f->guardar_cadena_utf8($_POST['v_estado']));
	$cli->pais=trim($f->guardar_cadena_utf8($_POST['v_pais']));
	$cli->ciudad=trim($f->guardar_cadena_utf8($_POST['v_ciudad']));

	$cli->colonia=trim($f->guardar_cadena_utf8($_POST['v_colonia']));
	$cli->no_ext=trim($f->guardar_cadena_utf8($_POST['no_ext']));
	$cli->no_int=trim(utf8_decode($_POST['v_no_int']));
	$cli->folio_adminpack=trim(utf8_decode($_POST['foliopack']));
	$cli->referencia = trim($f->guardar_cadena_utf8($_POST['v_referencia']));
	$cli->fis_correo=trim($f->guardar_cadena_utf8($_POST['v_fis_correo']));
	$opcionestipopagobloqueada="";

	
	if($cli->idCliente == 0)
	{
		$cli->GuardarNewCliente();
	    $md->guardarMovimiento(utf8_decode('Clientes'),'cliente',utf8_decode('Nuevo Cliente creado con el ID :'.$cli->ultimoIDCliente));
	}else
	{

		if (isset($_POST['opcionestipopagobloqueada'])) {
			$opcionestipopagobloqueada=$_POST['opcionestipopagobloqueada'];
			$cli->opcionestipopagobloqueada=$opcionestipopagobloqueada;
		}
			$validacioncel=$_POST['validacioncel'];
			$cli->validacioncel=$validacioncel;


			$bloquearediciondatos=$_POST['bloquearediciondedatos'];
			$cli->bloquearediciondedatos=$bloquearediciondatos;
			$mostraranuncios=$_POST['mostraranuncios'];
			$cli->mostraranuncios=$mostraranuncios;
		$cli->ModificarCliente();


		$clienteinfo=$cli->ObtenerInformacionCliente();
		$cliente_row=$db->fetch_assoc($clienteinfo);
		$md->guardarMovimiento(utf8_decode('Clientes'),'cliente',utf8_decode('Modificar Cliente con el ID :'.$cli->idCliente));
		/*$cli->idprospecto=$cliente_row['idprospecto'];
		$cli->ModificarProspectoCliente();
		$md->guardarMovimiento(utf8_decode('Clientes'),'cliente',utf8_decode('Modificar Cliente con el ID :'.$cli->idCliente));*/
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