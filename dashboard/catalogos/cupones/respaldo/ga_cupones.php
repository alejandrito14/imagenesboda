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
require_once("../../clases/class.Cupones.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$cup = new Cupones();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$cup->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
	//Recbimos parametros
	
	$cup->idcupon = trim($_POST['id']);
	$cup->sucursal = trim($_POST['v_sucursal']);
	$cup->codigocupon = trim($f->guardar_cadena_utf8($_POST['v_codigo']));
	$cup->tipodescuento = trim($f->guardar_cadena_utf8($_POST['v_tipodescuento']));
	$cup->descuento = trim($f->guardar_cadena_utf8($_POST['v_descuento']));
	$cup->limiteusos = trim($f->guardar_cadena_utf8($_POST['v_limiteusos']));
	$cup->fechainicial = trim($f->guardar_cadena_utf8($_POST['v_fechainicial']));
	$cup->fechafinal = trim($f->guardar_cadena_utf8($_POST['v_fechafinal']));
	$cup->horainicial = trim($f->guardar_cadena_utf8($_POST['v_horainicial']));
	$cup->horafinal = trim($f->guardar_cadena_utf8($_POST['v_horafinal']));
	$cup->montocompra = trim($f->guardar_cadena_utf8($_POST['v_montocompra']));
	$cup->cantidadcompra = trim($f->guardar_cadena_utf8($_POST['v_cantidadcompra']));
	$cup->secuenciaventa = trim($f->guardar_cadena_utf8($_POST['v_secuenciaventa']));
	$cup->lusocliente = trim($f->guardar_cadena_utf8($_POST['v_lusocliente']));
	$cup->lusodia = trim($f->guardar_cadena_utf8($_POST['v_lusodia']));
	$cup->lusosucursal = trim($f->guardar_cadena_utf8($_POST['v_lusosucursal']));
	$cup->lusototal = trim($f->guardar_cadena_utf8($_POST['v_lusototal']));
	$cup->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$cup->tsucursales = trim($f->guardar_cadena_utf8($_POST['v_tsucursales']));
    $a_sucs = json_decode(trim($f->guardar_cadena_utf8($_POST['v_sucursales'])));
	$cup->tpaquetes = trim($f->guardar_cadena_utf8($_POST['v_tpaquetes']));
    $a_paqs = json_decode(trim($f->guardar_cadena_utf8($_POST['v_paquetes'])));
	$cup->tclientes = trim($f->guardar_cadena_utf8($_POST['v_tclientes']));
    $a_clis = json_decode(trim($f->guardar_cadena_utf8($_POST['v_clientes'])));
	$cup->aplicarsobrepromo = trim($f->guardar_cadena_utf8($_POST['v_aplicarsobrepromo']));

	
	//Validamos si hacermos un insert o un update
	if($cup->idcupon == 0)
	{
		$cup->guardarCupon();

		if($cup->tsucursales == 0 and sizeof($a_sucs) > 0){
			foreach ($a_sucs as $idsuc){
				$cup->guardarCuponSucursales($idsuc);
			}
		}
		
		if($cup->tpaquetes == 0 and sizeof($a_paqs) > 0){
			foreach ($a_paqs as $idpaq){
				$cup->guardarCuponPaquetes($idpaq);
			}
		}

		if($cup->tclientes == 0 and sizeof($a_clis) > 0){
			foreach ($a_clis as $idcli){
				$cup->guardarCuponClientes($idcli);
			}
		}	
		
		$md->guardarMovimiento($f->guardar_cadena_utf8('Cupones'),'cupones',$f->guardar_cadena_utf8('Nuevo cupón creado con el ID-'.$cup->idcupon));
	}else{ //FALTA PARA MODIFICAR
		//$cup->modificarCategoria();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Cupones'),'cupones',$f->guardar_cadena_utf8('Modificación de cupón -'.$cup->idcategoria));
	}
				
	$db->commit();
	echo "1|".$cup->idcupon;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>