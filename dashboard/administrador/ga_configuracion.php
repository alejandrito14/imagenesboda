<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.Configuracion.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once("../clases/class.Funciones.php");


try
{
	$db= new MySQL();
	$conf= new Configuracion();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	
	//Como no sabemos cuantos archivos van a llegar, iteramos la variable $_FILES
    $ruta="../images/configuracion/";
	
	
	$conf->db=$db;	
	$md->db = $db;
	$db->begin();
		
		
	//recibiendo datos
	$conf->nombre_empresa = utf8_decode( $_POST['v_nombre_empresa']);
	$conf->direccion = '';//utf8_decode( $_POST['v_direccion']);
	$conf->telefonos = '';//$_POST['v_telefonos'];
	$conf->url = $_POST['v_url'];
	$conf->email = $_POST['v_email'];
	$conf->email_pedido = $_POST['v_email_pedido'];
	$conf->clave_caja = $_POST['clave_caja'];
	$conf->notas_print = $_POST['formato_impresion'];
	$conf->porc_comision = $_POST['comision'];
	
	$conf->razon_social = utf8_decode($_POST['v_razonsocial']);
	$conf->rfc = utf8_decode($_POST['v_rfc']);
	$conf->direccion_fiscal = utf8_decode( $_POST['v_dfiscal']);
	$conf->no_int_fiscal = $_POST['v_nint'];
	$conf->no_ext_fiscal = $_POST['v_next'];
	$conf->ciudad_fiscal = utf8_decode($_POST['v_ciudad']);
	$conf->estado_fiscal = utf8_decode($_POST['v_estado']);
	$conf->cp_fiscal = $_POST['v_cp'];
	$conf->colonia_fiscal = utf8_decode($_POST['v_colonia']);
	
	
	$conf->iva = $_POST['v_iva'];
	$conf->t_descuento = $_POST['v_tipo_descuento'];
	$conf->cuentasbancarias = $_POST['v_cuentas'];
	$conf->moneda = $_POST['v_moneda'];
	
	
   $conf->v_e_cuenta = $_POST['v_e_cuenta'];
   $conf->v_e_clave = $_POST['v_e_clave'];
   $conf->v_e_pop = $_POST['v_e_pop'];
   $conf->v_e_pentrante = $_POST['v_e_pentrante'];
   $conf->v_e_smtp = $_POST['v_e_smtp'];
   $conf->v_e_psaliente = $_POST['v_e_psaliente'];
   $conf->v_e_autenticacion = $_POST['v_e_autenticacion'];
   $conf->v_e_ss = $_POST['v_e_ss'];
  
	
	
	//guardando
	
	//evaluamos si ya existia la configuracion de la empresa. con la variable
	
	$id =  $_POST['v_id'];
	
	
	if($id == 0)
	{
	
	$conf->GuardarNewConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Guardando Configuracion de la empresa-'.$conf->ultimoIDConfiguracion));
	}else
	{
		
	$conf->idConfiguracion = $id;
	$conf->ModificarConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Modificamos la Configuracion de la empresa-'.$conf->idConfiguracion));
	}
	
	
	foreach ($_FILES as $key) 
	  {
		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
		   
		  $nombre = $f->conver_especial($key['name']);//Obtenemos el nombre del archivo
		  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
		  $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
		  
		   //obtenemos el nombre del archivo anterior para ser eliminado si existe
		  
		  $sql = "SELECT logo FROM configuracion";
		  $result_borrar = $db->consulta($sql);
		  $result_borrar_row = $db->fetch_assoc($result_borrar);
		  $nombreborrar = $result_borrar_row['logo'];		  
		  
		  if($nombreborrar != "")
		  {
			  unlink($ruta.$nombreborrar); 
		  }
		  
		  
		  move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
		  //El echo es para que lo reciba jquery y lo ponga en el div "cargados"
		  
		 
		  $sql = "UPDATE configuracion SET logo = '$nombre'";
		   
		  $result = $db->consulta($sql);	 
		}
	  }
	
	
	
	
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
	$result = $db->m_error($n[0]);
	echo $result ;
}
?>