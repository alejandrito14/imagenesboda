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
require_once("../../clases/class.Productos.php");
require_once('../../clases/class.Productos_descripcion.php');
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Productos();
	$f = new Funciones();
	$md = new MovimientoBitacora();

	//$productos_descripcion = new Productos_descripcion();

	//enviamos la conexión a las clases que lo requieren
	$emp->db=$db;
	$md->db = $db;	
	$ruta="imagenes/";
	$db->begin();
		
	//Recbimos parametros
	
	$VALIDACION = trim($_POST['VALIDACION']);
	$emp->idproducto = trim($_POST['id']);
	$emp->codigoproducto = trim($_POST['codigoproducto']);
	$emp->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$emp->descripcion = trim($f->guardar_cadena_utf8($_POST['v_descripcion']));
	$emp->descuento = trim($f->guardar_cadena_utf8($_POST['v_descuento']));
	$emp->empresa = trim($f->guardar_cadena_utf8($_POST['v_empresa']));
	$emp->categoria = trim($f->guardar_cadena_utf8($_POST['v_categoria']));
	$emp->presentacion = trim($f->guardar_cadena_utf8($_POST['v_presentacion']));
	$emp->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));

	$emp->precionormal=trim($f->guardar_cadena_utf8($_POST['v_precio']));
	$emp->precioventa=trim($_POST['precioventa']);

	$emp->idcategoria_precios=$_POST['categoria_producto'];
	$emp->v_idtipo_medida=$_POST['v_idtipo_medida'];

	/*$idinsumos=explode(',',$_POST['idinsumos']);
	$cantidades=explode(',', $_POST['cantidades']);
	$insumomedidas=explode(',', $_POST['insumomedidas']);
	$insumototalmedidas=explode(',', $_POST['insumototalmedidas']);*/

	$suma=0;
	//Validamos si hacermos un insert o un update
	if($VALIDACION==1)
	{
			

		//guardando
		$emp->guardarProducto();
		


		/*for ($i=0; $i < count($idinsumos); $i++) { 
				$productos_descripcion=new Productos_descripcion();
				$productos_descripcion->db=$db;

				$productos_descripcion->idinsumos=$idinsumos[$i];
				$productos_descripcion->idempresas=$emp->empresa;
				$productos_descripcion->cantidad=$cantidades[$i];
				$productos_descripcion->medida=$insumomedidas[$i];
				$productos_descripcion->subtotalmedida=$insumototalmedidas[$i];
				$productos_descripcion->idproducto=$emp->idproducto;

				$productos_descripcion->guardarProductoDescripcion();

				//$suma=$suma+$subtotalinsumos[$i];


			}*/

			$md->guardarMovimiento($f->guardar_cadena_utf8('Producto'),'productos',$f->guardar_cadena_utf8('Nueva producto creado con el ID-'.$emp->idproducto));



	}else{

			

		$emp->modificarProducto();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('Producto'),'productos',$f->guardar_cadena_utf8('Modificación del producto -'.$emp->idproducto));


		/*$emp->EliminarProductosDescripcion();

			for ($i=0; $i < count($idinsumos); $i++) { 
				$productos_descripcion=new Productos_descripcion();

				$productos_descripcion->db=$db;

				$productos_descripcion->idinsumos=$idinsumos[$i];
				$productos_descripcion->idempresas=$emp->empresa;
				$productos_descripcion->cantidad=$cantidades[$i];
				$productos_descripcion->medida=$insumomedidas[$i];
				$productos_descripcion->subtotalmedida=$insumototalmedidas[$i];
				$productos_descripcion->idproducto=$emp->idproducto;

				


				

				$productos_descripcion->guardarProductoDescripcion();



			}*/
	}
	/*$emp->precio=$suma;

	$emp->ActualizarPrecioProducto();*/
				
		foreach ($_FILES as $key) 
  	{
		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
		   
			$nombre = $emp->idproducto.".jpg";//Obtenemos el nombre del archivo
			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB

			//obtenemos el nombre del archivo anterior para ser eliminado si existe

			$sql = "SELECT foto FROM productos WHERE idproducto='".$emp->idproducto."'";
			$result_borrar = $db->consulta($sql);
			$result_borrar_row = $db->fetch_assoc($result_borrar);
			$nombreborrar = $result_borrar_row['foto'];		  

			if($nombreborrar != "")
			{
				unlink($ruta.$nombreborrar); 
			}


			move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada

			$sql = "UPDATE productos SET foto = '$nombre' WHERE idproducto ='".$emp->idproducto."'";   
			$db->consulta($sql);	 
		}
  	}
	
		
	$db->commit();
	echo '1|'.$emp->idproducto;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>