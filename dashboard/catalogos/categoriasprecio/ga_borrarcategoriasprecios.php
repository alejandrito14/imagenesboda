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
require_once("../../clases/class.Categoriasprecios.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Categoriasprecios();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	
	$db->begin();

	//Recbimos parametros
	$emp->idcategoriaprecios = trim($_POST['idcategorias_precios']);
	

	//Validamos si hacermos un insert o un update
	if($emp->idcategoriaprecios > 0)
	{
		//guardando
		//
		$emp->eliminarrangos();
		$emp->EliminarCategoriaPrecios();


		$md->guardarMovimiento($f->guardar_cadena_utf8('Categoria'),'categorias precio',$f->guardar_cadena_utf8('Elimino de la categoria precio -'.$emp->idcategoriaprecios));
	}

	$db->commit();
	echo "1";
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>