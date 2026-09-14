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
require_once("../../clases/class.Proveedores.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$pro = new Proveedores();
	$f = new Funciones();
	$md = new MovimientoBitacora();



	
	
	//enviamos la conexión a las clases que lo requieren
	$pro->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	$pro->idproveedor = trim($_POST['id']);
	$pro->empresa = trim($f->guardar_cadena_utf8($_POST['v_empresa']));
	$pro->nombre=trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$pro->celular=trim($f->guardar_cadena_utf8($_POST['v_celular']));

	$caracteres = array("(", ")", "-"," ");

	$pro->celular="+52".str_replace($caracteres,"",$pro->celular);
	$pro->telefono=trim($f->guardar_cadena_utf8($_POST['v_telefono']));
	$pro->email=trim($f->guardar_cadena_utf8($_POST['v_email']));
	$pro->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$pro->idpais=$_POST['v_pais'];
	$pro->idestado=$_POST['v_estados'];
	$pro->idmunicipio=$_POST['v_municipio'];

	//Validamos si hacermos un insert o un update
	if($pro->idproveedor == 0)
	{
		//guardando
		$pro->guardarProveedor();
		$md->guardarMovimiento($f->guardar_cadena_utf8('Proveedores'),'Proveedores',$f->guardar_cadena_utf8('Nuevo proveedor creado con el ID-'.$pro->idproveedor));
	}else{
		$pro->modificarProveedor();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Proveedores'),'Proveedores',$f->guardar_cadena_utf8('Modificación de proveedor -'.$pro->idproveedor));
	}
				
	$db->commit();
	echo "1|".$pro->idproveedor;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>