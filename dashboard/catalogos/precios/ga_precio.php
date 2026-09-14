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
require_once("../../clases/class.Precios.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$precio = new Precios();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$precio->db=$db;
	$md->db = $db;	
	
	$db->begin();
		
		




	//Recbimos parametros
	$precio->idprecio = trim($_POST['id']);
	$precio->nombre = trim($f->guardar_cadena_utf8($_POST['v_precio']));
	$precio->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$precio->principal=$_POST['v_principal'];
	
		$obtener=$precio->ObtprecioActivos();

		$contar=count($obtener);

		if ($contar==0) {
			
			$precio->principal=1;
		}

	//Validamos si hacermos un insert o un update
	if($precio->idprecio == 0)
	{
		//guardando
		$precio->Guardarprecio();


		if ($precio->principal==1) {
			$precio->Actualizarpincipal();
		}
		$md->guardarMovimiento($f->guardar_cadena_utf8('precio'),'precio',$f->guardar_cadena_utf8('Nuevo precio creado con el ID-'.$precio->idprecio));
	}else{
		$precio->Modificarprecio();	

		if ($precio->principal==1) {
			$precio->Actualizarpincipal();
		}
		
		$md->guardarMovimiento($f->guardar_cadena_utf8('precio'),'precio',$f->guardar_cadena_utf8('Modificación de precio -'.$precio->idprecio));
	}
				
	$db->commit();
	echo "1|".$precio->idprecio;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>