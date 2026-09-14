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
	$emp->idcategoriaprecios = trim($_POST['id']);
	$emp->nombre = trim($f->guardar_cadena_utf8($_POST['nombre']));
	$emp->descripcion = trim($f->guardar_cadena_utf8($_POST['v_descripcion']));
	$emp->empresa= trim($f->guardar_cadena_utf8($_POST['empresa']));
	$emp->tipomedida=$f->guardar_cadena_utf8($_POST['idtipomedida']);


	if ($_POST['rango1']!='') {
		$rango1=explode(',',$_POST['rango1']);
		$rango2=explode(',',$_POST['rango2']);
		$precio=explode(',',$_POST['precio']);
	}else{


		$rango1=0;
		$rango2=0;
		$precio=0;
	}

	if ($_POST['codinsumo']!='') {
		$codinsumo=explode(',',$_POST['codinsumo']);
	
	}else{
		$codinsumo=0;
		
	}
	



	//Validamos si hacermos un insert o un update
	if($emp->idcategoriaprecios == 0)
	{
		//guardando
		$emp->guardarCategoriaPrecio();


		if ($rango1!=0) {

			for ($i=0; $i <count($rango1); $i++) { 

				$emp->rango1=$rango1[$i];
				$emp->rango2=$rango2[$i];
				$emp->precio=$precio[$i];

				$emp->GuardarRangoPrecios();

			}

		}

		if ($codinsumo!=0) {
			for ($i=0; $i <count($codinsumo) ; $i++) { 
				$emp->codinsumo=$codinsumo[$i];
				$emp->GuardarInsumoCategoria();
			}
		}

		$md->guardarMovimiento($f->guardar_cadena_utf8('Categoria'),'categorias precio',$f->guardar_cadena_utf8('Nueva categoria precio creado con el ID-'.$emp->idcategoriaprecios));
	}else{
		$emp->modificarCategoriaPrecio();	
		$emp->eliminarrangos();
		$emp->eliminarInsumoCategoria();

		if ($rango1!=0) {
			for ($i=0; $i <count($rango1); $i++) { 

				$emp->rango1=$rango1[$i];
				$emp->rango2=$rango2[$i];
				$emp->precio=$precio[$i];

				$emp->GuardarRangoPrecios();

			}
		}

		if ($codinsumo!=0) {
			
			for ($i=0; $i <count($codinsumo) ; $i++) { 
				$emp->codinsumo=$codinsumo[$i];
				$emp->GuardarInsumoCategoria();
			}
		}



		$md->guardarMovimiento($f->guardar_cadena_utf8('Categoria'),'categorias precio',$f->guardar_cadena_utf8('Modificación de la categoria precio -'.$emp->idcategoria));
	}

	$db->commit();
	echo "1|".$emp->idcategoria;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>