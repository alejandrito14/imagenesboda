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
require_once("../../clases/class.Seccion.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Noticia.php");
require_once("../../clases/class.CalendarioSeccion.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$su = new Seccion();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$noticia = new Noticia();
	$calendarioseccion = new CalendarioSeccion();

	//enviamos la conexión a las clases que lo requieren
	$su->db = $db;
	$md->db = $db;	
	$noticia->db=$db;
	$calendarioseccion->db=$db;

	$db->begin();
		
	//Recbimos parametros
	$su->idseccion = trim($_POST['idsecciones']);
	$su->titulo = trim($f->guardar_cadena_utf8($_POST['titulo']));
	$su->descripcion = trim($f->guardar_cadena_utf8($_POST['descripcion']));
	
	$su->tipo=$_POST['tipo'];
	$su->foto=$_POST['imagenprincipal'];
	$su->estatus=$_POST['estatus'];
	$su->orden=$_POST['v_orden'];
	$imagenes=json_decode($_POST['imagenesderevista']);
	$sucursales=$_POST['sucursalvinculados'];
	$noticias=json_decode($_POST['imagenesdenoticia']);
	$imagenescalendario=json_decode($_POST['imagenescalendario']);

	if ($sucursales!='') {
		$sucursalvinculados=explode(',', $_POST['sucursalvinculados']);
	}
	
	$imagenespromo=json_decode($_POST['imagenespromo']);


	//Validamos si hacermos un insert o un update
	if($su->idseccion == 0)
	{
		//guardando 
		
		$su->guardar_seccion();
		$md->guardarMovimiento($f->guardar_cadena_utf8('secciones'),'secciones',$f->guardar_cadena_utf8('Nueva seccion creado con el ID-'.$su->idseccion));
	
		for ($i=0; $i < count($imagenes); $i++) { 


		 $su->rutaimagen=$imagenes[$i]->{'nombreimagen'};
		 $su->estatusimagen=$imagenes[$i]->{'v_estatusimagen'};
		 $su->ordenimagen=$imagenes[$i]->{'ordenimagen'};

			$su->GuardarImagenesRevista();
		}

		if ($sucursales!='') {
			for ($i=0; $i <count($sucursalvinculados) ; $i++) { 
				$su->idsucursal=$sucursalvinculados[$i];
				$su->VincularSeccion();

			}
		}
	
		if ($imagenespromo!='') {
			for ($i=0; $i <count($imagenespromo) ; $i++) { 
				
			 $su->rutaimagen=$imagenespromo[$i]->{'nombreimagen'};
			 $su->estatusimagen=$imagenespromo[$i]->{'v_estatusimagen'};
			 $su->ordenimagen=$imagenespromo[$i]->{'ordenimagen'};

			$su->GuardarImagenesPromo();
			}
		}



	

		if ($noticias!='') {

			for ($i=0; $i <count($noticias) ; $i++) { 
				
				$noticia->titulo=$noticias[$i]->titulonoticia;
				$noticia->descripcion=$noticias[$i]->descripcion;
				$noticia->imagennoticia=$noticias[$i]->nombreimagen;
				$noticia->enlace=$noticias[$i]->enlace;
				$noticia->orden=$noticias[$i]->ordennoticia;
				$noticia->estatus=$noticias[$i]->v_estatusnoticia;
				$noticia->fechapublicacion=$noticias[$i]->fechapublicacion;
				$noticia->idseccion=$su->idseccion;
				$noticia->GuardarNoticia();
			}
			
		}

		if ($imagenescalendario!='') {

			for ($i=0; $i <count($imagenescalendario) ; $i++) { 
				$calendarioseccion->imagen=$imagenescalendario[$i]->nombreimagen;
				$calendarioseccion->estatus=$imagenescalendario[$i]->v_estatusfecha;
				$calendarioseccion->descripcion=$imagenescalendario[$i]->descripcion;
				$calendarioseccion->fecha=$imagenescalendario[$i]->fecha;
				$calendarioseccion->idseccion=$su->idseccion;

				$calendarioseccion->GuardarCalendariofecha();

			}
		}

			
	}else{
		
		$su->Modificarseccion();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('secciones'),'secciones',$f->guardar_cadena_utf8('Modificación de seccion -'.$su->idseccion));

		$su->Eliminarimagenesrevista();

		for ($i=0; $i < count($imagenes); $i++) { 


		 $su->rutaimagen=$imagenes[$i]->{'nombreimagen'};
		 $su->estatusimagen=$imagenes[$i]->{'v_estatusimagen'};
		 $su->ordenimagen=$imagenes[$i]->{'ordenimagen'};

			$su->GuardarImagenesRevista();
		}

		$su->Eliminarvinculacion();

		if ($sucursales!='') {
			for ($i=0; $i <count($sucursalvinculados) ; $i++) { 
				$su->idsucursal=$sucursalvinculados[$i];
				$su->VincularSeccion();

			}
		}


		if ($imagenespromo!='') {

			$su->EliminarimagenPromocionales();
			for ($i=0; $i <count($imagenespromo) ; $i++) { 
				
			 $su->rutaimagen=$imagenespromo[$i]->{'nombreimagen'};
			 $su->estatusimagen=$imagenespromo[$i]->{'v_estatusimagen'};
			 $su->ordenimagen=$imagenespromo[$i]->{'ordenimagen'};

			$su->GuardarImagenesPromo();
			}
		}


			if ($noticias!='') {

				$noticia->idseccion=$su->idseccion;
				$noticia->EliminarNoticiasseccion();

			for ($i=0; $i <count($noticias) ; $i++) { 
				
				$noticia->titulo=$noticias[$i]->titulonoticia;
				$noticia->descripcion=$noticias[$i]->descripcion;
				$noticia->imagennoticia=$noticias[$i]->nombreimagen;
				$noticia->enlace=$noticias[$i]->enlace;
				$noticia->orden=$noticias[$i]->ordennoticia;
				$noticia->estatus=$noticias[$i]->v_estatusnoticia;
				$noticia->fechapublicacion=$noticias[$i]->fechapublicacion;
				$noticia->idseccion=$su->idseccion;
				$noticia->GuardarNoticia();
			}
			
		}


		if ($imagenescalendario!='') {
			$calendarioseccion->idseccion=$su->idseccion;
			$calendarioseccion->EliminarCalendariofecha();
			for ($i=0; $i <count($imagenescalendario) ; $i++) { 
				$calendarioseccion->imagen=$imagenescalendario[$i]->nombreimagen;
				$calendarioseccion->estatus=$imagenescalendario[$i]->v_estatusfecha;
				$calendarioseccion->descripcion=$imagenescalendario[$i]->descripcion;
				$calendarioseccion->fecha=$imagenescalendario[$i]->fecha;
				$calendarioseccion->idseccion=$su->idseccion;

				$calendarioseccion->GuardarCalendariofecha();

			}
		}
	

	}


	

				
	$db->commit();
	echo '1|'.$su->idseccion;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>
