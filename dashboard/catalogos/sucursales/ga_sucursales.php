<?php


/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
		/* header("Location: ../login.php"); */ echo "login";
	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Sucursalesfolios.php");
try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$su = new Sucursal();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$folio=new Sucursalesfolios();
	
	//enviamos la conexión a las clases que lo requieren
	$su->db = $db;
	$md->db = $db;	
	$folio->db=$db;
	$ruta="imagenes/".$_SESSION['codservicio'].'/';
	$rutati="imagenesticket/".$_SESSION['codservicio'].'/';

	$db->begin();
		
	//Recbimos parametros
	$su->idsucursales = trim($_POST['idsucursales']);
	$su->idempresas = trim($_POST['idempresas']);
	$su->sucursal = trim($f->guardar_cadena_utf8($_POST['v_sucursal']));
	$su->direccion = trim($f->guardar_cadena_utf8($_POST['v_direccion_sucursal']));
	$su->telefono = trim($f->guardar_cadena_utf8($_POST['v_telefono']));
	$su->email = trim($f->guardar_cadena_utf8($_POST['v_email']));
	$su->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$su->iva=trim($_POST['v_iva']);
	$su->solicitarfactura=$_POST['solicitarfactura'];

	$su->v_pais=$_POST['v_pais'];
	$su->v_estado=$_POST['v_estado'];
	$su->v_municipio=$_POST['v_municipio'];
	$su->horainicio=$_POST['horainicio'];
	$su->horafin=$_POST['horafin'];
	$su->minutosconsiderados=$_POST['minutosconsiderados'];
	$su->orden=$_POST['orden'];
	$su->colonia = trim($f->guardar_cadena_utf8($_POST['v_colonia']));
	$su->iddatofiscal=$_POST['datofiscal'];
	$su->encabezado=$_POST['encabezado'];
	$su->leyendafinal=$_POST['leyendaticket'];
	$su->telefono2=$_POST['v_telefono2'];
	$su->telefono3=$_POST['v_telefono3'];
	$su->telefono4=$_POST['v_telefono4'];
	$su->ticketventa=$_POST['tventa'];
	$su->ticketproduccion=$_POST['tproduccion'];
	$su->codigopostal=$_POST['codigopostal'];

	$su->trecordatorio=$_POST['trecordatorio'];
	$su->minutosrecordatorio=$_POST['minutosrecordatorio'];
	$su->mensajesucursal=$_POST['mensajeempresa'];
	$su->mensajecliente=$_POST['mensajecliente'];
	$su->habilitarcampomontofactura=$_POST['habilitarcampomontofactura'];
	$su->habilitarnotaventa=$_POST['notaventa'];
	$su->mensajesecciontipopago=$_POST['mensajesecciontipopago'];

	if ($su->orden=='') {
		$su->orden=0;
	}

	$diasemanas=explode(',', $_POST['diasemana']);
	$horainiciosemana=explode(',', $_POST['horainiciodia']);
	$horafinsemana=explode(',', $_POST['horafindia']);
	$opcionespedido=explode(',', $_POST['opcionepedido']);
	$tipodepagos=explode(',', $_POST['tipodepagos']);

	if ($su->minutosconsiderados=='') {
		$su->minutosconsiderados=0;
	}

	if ($su->iva=='') {
		$su->iva=0;
	}
	
	//Validamos si hacermos un insert o un update
	if($su->idsucursales == 0)
	{
		//guardando 
		
		$su->guardar_sucursal();
		$md->guardarMovimiento($f->guardar_cadena_utf8('sucursales'),'sucursales',$f->guardar_cadena_utf8('Nueva sucursal creado con el ID-'.$su->idsucursales));
		$folio->idsucursal=$su->idsucursales;
		$folio->GuardarFolio();


		if (count($diasemanas)>0 && $diasemanas[0]!='') {
			# code...
		
		for ($i=0; $i < count($diasemanas); $i++) { 
				$su->dia=$diasemanas[$i];
				$su->horainiciosemana=$horainiciosemana[$i];
				$su->horafinsemana=$horafinsemana[$i];
				$su->GuardarHorarioSemana();
			}

		}

		if (count($opcionespedido) && $opcionespedido[0]!='') {

			for ($i=0; $i <count($opcionespedido); $i++) { 
				$su->opcionepedido=$opcionespedido[$i];
				$su->GuardarOpcionpedido();

			}
		}


		if (count($tipodepagos) && $tipodepagos[0]!='') {

			for ($i=0; $i <count($tipodepagos); $i++) { 
				$su->tipodepago=$tipodepagos[$i];
				$su->GuardarTipodepago();

			}
		}

			
	}else{
		$su->modificar_sucursal();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('sucursales'),'sucursales',$f->guardar_cadena_utf8('Modificación de sucursal -'.$su->idsucursales));

		$su->EliminarHorarioSemana();
	
		if (count($diasemanas)>0 && $diasemanas[0]!='') {

		for ($i=0; $i < count($diasemanas); $i++) { 
				$su->dia=$diasemanas[$i];
				$su->horainiciosemana=$horainiciosemana[$i];
				$su->horafinsemana=$horafinsemana[$i];
				$su->GuardarHorarioSemana();
			}
		}

	$su->EliminarOpcionespedido();


	if (count($opcionespedido) && $opcionespedido[0]!='') {

			for ($i=0; $i <count($opcionespedido); $i++) { 
				$su->opcionepedido=$opcionespedido[$i];
				$su->GuardarOpcionpedido();

				

			}
		}



		$su->EliminarTiposdepago();

		if (count($tipodepagos) && $tipodepagos[0]!='') {

			for ($i=0; $i <count($tipodepagos); $i++) { 
				$su->tipodepago=$tipodepagos[$i];
				$su->GuardarTipodepago();

			}
		}

	}

if($_FILES['archivo']){//V
		if($_FILES['archivo']['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
			$nombre = str_replace(' ','_',date('Y-m-d H:i:s').'-'.$su->idsucursales.".jpg");//Obtenemos el nombre del archivo
			$temporal = $_FILES['archivo']['tmp_name']; //Obtenemos el nombre del archivo temporal
			$tamano= ($_FILES['archivo']['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB

			//obtenemos el nombre del archivo anterior para ser eliminado si existe

			$sql = "SELECT foto FROM sucursales WHERE idsucursales='".$su->idsucursales."'";
			$result_borrar = $db->consulta($sql);
			$result_borrar_row = $db->fetch_assoc($result_borrar);
			$nombreborrar = $result_borrar_row['foto'];		  

			if($nombreborrar != "")
			{
				unlink($ruta.$nombreborrar); 
			}

			move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada

			$sql = "UPDATE sucursales SET foto = '$nombre' WHERE idsucursales ='".$su->idsucursales."'";   
			$db->consulta($sql);	 
		}
	}
	


if($_FILES['ticket'])//V
		{
		if($_FILES['ticket']['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
			$nombre = str_replace(' ','_',date('Y-m-d H:i:s').'-'.$su->idsucursales.".jpg");//Obtenemos el nombre del archivo
			$temporal = $_FILES['ticket']['tmp_name']; //Obtenemos el nombre del archivo temporal
			$tamano= ($_FILES['ticket']['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB

			//obtenemos el nombre del archivo anterior para ser eliminado si existe

			$sql = "SELECT imagenticket FROM sucursales WHERE idsucursales='".$su->idsucursales."'";
			$result_borrar = $db->consulta($sql);
			$result_borrar_row = $db->fetch_assoc($result_borrar);
			$nombreborrar = $result_borrar_row['imagenticket'];		  

			if($nombreborrar != "")
			{
				unlink($rutati.$nombreborrar); 
			}


			move_uploaded_file($temporal, $rutati.$nombre); //Movemos el archivo temporal a la ruta especificada

			$sql = "UPDATE sucursales SET imagenticket = '$nombre' WHERE idsucursales ='".$su->idsucursales."'";   
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

