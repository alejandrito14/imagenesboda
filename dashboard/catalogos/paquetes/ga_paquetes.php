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
require_once("../../clases/class.Paquetes.php");
require_once('../../clases/class.Paquetesproductos.php');
require_once('../../clases/class.Opcion.php');

require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$emp = new Paquetes();
	$f = new Funciones();
	$md = new MovimientoBitacora();

	$emp->db=$db;
	$md->db = $db;	
	$ruta="imagenespaquete/".$_SESSION['codservicio'].'/';
	$db->begin();

	//Recbimos parametros
	
	$VALIDACION = trim($_POST['VALIDACION']);
	$emp->idpaquete = trim($_POST['id']);
	$emp->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$emp->descripcion = trim($f->guardar_cadena_utf8($_POST['v_descripcion']));
	$emp->precionormal = trim($f->guardar_cadena_utf8($_POST['preciounitario']));

	$emp->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$emp->precioventa=trim($_POST['precioventa']);
	$emp->idcategoria=$_POST['idcategoria'];


	$emp->conpromo=$_POST['conpromo'];
	$emp->confecha=$_POST['confecha'];
	$emp->directo=$_POST['directo'];
	$emp->fechainicial=$_POST['fechainicial'];
	$emp->fechafinal=$_POST['fechafinal'];
	$emp->cantidadcobrar=$_POST['cantidadcobrar'];
	$emp->cantidadaconsiderar=$_POST['cantidadaconsiderar'];
	$emp->servicio=$_POST['servicio'];

	$emp->repetitivo=$_POST['repetitivo'];
	$emp->lunes=$_POST['lunes'];
	$emp->martes=$_POST['martes'];
	$emp->miercoles=$_POST['miercoles'];
	$emp->jueves=$_POST['jueves'];
	$emp->viernes=$_POST['viernes'];
	$emp->sabado=$_POST['sabado'];
	$emp->domingo=$_POST['domingo'];
	$emp->preciofijo=$_POST['preciofijo'];

	$emp->horainicio=$_POST['horainicio'];

	$emp->horafin=$_POST['horafin'];
	$emp->orden=$_POST['orden'];
	$emp->activarcomentario=$_POST['activarcomentario'];
	$emp->siniva=$_POST['siniva'];
	$emp->iva=$_POST['iva'];
	$emp->mensajev=$_POST['mensajev'];


	/*if ($emp->iva=='') {
		$emp->iva
	}*/

	if ($emp->preciofijo=='') {
		$emp->preciofijo=0;
	}

	if ($emp->cantidadcobrar=='') {
		$emp->cantidadcobrar=0;
	}

	if ($emp->cantidadaconsiderar=='') {
		$emp->cantidadaconsiderar=0;
	}
	if($emp->directo==''){
		$emp->directo=0;
	}
	if ($emp->conpromo=='') {
		$emp->conpromo=0;
	}
	if ($emp->repetitivo=='') {
		$emp->repetitivo=0;
	}

	if ($emp->servicio=='') {
		$emp->servicio=0;
	}
	if ($emp->confecha=='') {
		$emp->confecha=0;
	}
	$idinsumos=explode(',',$_POST['idproductos']);
	$cantidades=explode(',', $_POST['cantidades']);
	$insumomedidas=explode(',', $_POST['insumomedidas']);
	$insumototalmedidas=explode(',', $_POST['insumototalmedidas']);

	$preciospaquete=explode(',',$_POST['preciospaquete']);


	$complementos=explode(',', $_POST['complementos']);
	$paquetesvinculados=explode(',',$_POST['paquetesvinculados']);


	$suma=0;
	//Validamos si hacermos un insert o un update
	if($VALIDACION==1)
	{


		//guardando
		$emp->GuardarPaquete();
		




		foreach($_SESSION['CarritoProducto'] as $k => $v)
		{  
			$cantidaddeprodutos ++;
			$producto_array = $k;	
			$producto_valores = explode("|",$v);

			$idproducto = $producto_valores[0];
			$cantidad = $producto_valores[1];
			$nombre=$producto_valores[2];


			$productos_descripcion=new Paquetesproductos();
			$productos_descripcion->db=$db;

			$productos_descripcion->idproducto=$idproducto;
			$productos_descripcion->cantidad=$cantidad;
				
				$productos_descripcion->idpaquete=$emp->idpaquete;

				$productos_descripcion->guardarPaqueteDescripcion();


			}


			if ($complementos[0]!='') {
				# code...
			$topessecundarios=explode(',',$_POST['topessecundarios']);

			if (count($complementos)>0) {
				# code...

				for ($i=0; $i <count($complementos) ; $i++) { 

					$op = new Opcion();
					$op->db=$db;
					$op->idgrupo=$complementos[$i];
					$op->idpaquete=$emp->idpaquete;
					$op->topesecundario=$topessecundarios[$i];
					$op->GuardaGrupoPaquete();



				}
			}
		}


			for ($i=0; $i < count($preciospaquete); $i++) { 
					
				$dividircadena=explode('_',$preciospaquete[$i]);	
				$idprecio=$dividircadena[0];
				$precio=$dividircadena[1];

				$emp->GuardaPreciopaquete($idprecio,$precio);

			}


			if ($emp->conpromo==1) {
	

			if ($paquetesvinculados[0]!='') {


				for ($i=0; $i < count($paquetesvinculados); $i++) { 
						
					$idpaquetevinculado=$paquetesvinculados[$i];
						
					
					if ($idpaquetevinculado!=0) {
						$emp->GuardaPaquetevinculado($idpaquetevinculado);

					}

				}

			}

		}

			$md->guardarMovimiento($f->guardar_cadena_utf8('Paquetes'),'Paquetes',$f->guardar_cadena_utf8('Nuevo paquete creado con el ID-'.$emp->idpaquete));


			$se->crearSesion('CarritoComplemento',null);
		}else{

			

		$emp->modificarPaquete();	
	
		$emp->EliminarPaquetesProductos();
		$emp->EliminarComplementos();


		foreach($_SESSION['CarritoProducto'] as $k => $v)
		{  
			$cantidaddeprodutos ++;
			$producto_array = $k;	
			$producto_valores = explode("|",$v);

			$idproducto = $producto_valores[0];
			$cantidad = $producto_valores[1];
			$nombre=$producto_valores[2];


			$productos_descripcion=new Paquetesproductos();
			$productos_descripcion->db=$db;

			$productos_descripcion->idproducto=$idproducto;
			$productos_descripcion->cantidad=$cantidad;
				/*$productos_descripcion->medida=$insumomedidas[$i];
				$productos_descripcion->subtotalmedida=$insumototalmedidas[$i];*/
				$productos_descripcion->idpaquete=$emp->idpaquete;

				$productos_descripcion->guardarPaqueteDescripcion();

				//$suma=$suma+$subtotalinsumos[$i];

			}
if ($complementos[0]!='') {
			if (count($complementos)>0) {
				# code...
				$topessecundarios=explode(',',$_POST['topessecundarios']);

				for ($i=0; $i <count($complementos) ; $i++) { 

					$op = new Opcion();
					$op->db=$db;
					$op->idgrupo=$complementos[$i];
					$op->idpaquete=$emp->idpaquete;
					$op->topesecundario=$topessecundarios[$i];

					$op->GuardaGrupoPaquete();



				}
			}
		}


				$emp->eliminarpreciopaquete();

			for ($i=0; $i < count($preciospaquete); $i++) { 
					
				$dividircadena=explode('_',$preciospaquete[$i]);	
				$idprecio=$dividircadena[0];
				$precio=$dividircadena[1];

				$emp->GuardaPreciopaquete($idprecio,$precio);

			}
			
			$emp->Eliminarpaquetevinculado();

			if ($emp->conpromo==1) {
	

			if ($paquetesvinculados[0]!='') {

				for ($i=0; $i < count($paquetesvinculados); $i++) { 
						
					$idpaquetevinculado=$paquetesvinculados[$i];	
					
					if ($idpaquetevinculado!=0) {
						$emp->GuardaPaquetevinculado($idpaquetevinculado);

					}

				}

			}

		}

				$md->guardarMovimiento($f->guardar_cadena_utf8('Paquetes'),'Paquetes',$f->guardar_cadena_utf8('Modificacion de paquete con el ID-'.$emp->idpaquete));
		}

	//$emp->ActualizarPrecioProducto();

		foreach ($_FILES as $key) 
		{
		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente

			$nombre = str_replace(' ','_',date('Y-m-d H:i:s').'-'.$emp->idpaquete.".jpg");//Obtenemos el nombre del archivo
			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB

			//obtenemos el nombre del archivo anterior para ser eliminado si existe

			$sql = "SELECT foto FROM paquetes WHERE idpaquete='".$emp->idpaquete."'";
			$result_borrar = $db->consulta($sql);
			$result_borrar_row = $db->fetch_assoc($result_borrar);
			$nombreborrar = $result_borrar_row['foto'];		  

			if($nombreborrar != "")
			{
				unlink($ruta.$nombreborrar); 
			}


			move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada

			$sql = "UPDATE paquetes SET foto = '$nombre' WHERE idpaquete ='".$emp->idpaquete."'";   
			$db->consulta($sql);	 
		}
	}
	

	$db->commit();
	echo 1;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>


