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
require_once("../../clases/class.Juego.php");
require_once("../../clases/class.Tipopartidos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$juego = new Juego();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	$tipo=new Tipopartidos();
	
	//enviamos la conexión a las clases que lo requieren
	$juego->db=$db;
	$md->db = $db;	
	$tipo->db=$db;
	
	$db->begin();
		
	//Recbimos parametros
	$juego->idjuego = trim($_POST['id']);
	$juego->nombre=trim($f->guardar_cadena_utf8($_POST['v_nombre']));;
	$juego->descripcion=trim($f->guardar_cadena_utf8($_POST['v_descripcion']));;
	$juego->idtorneo=trim($f->guardar_cadena_utf8($_POST['v_torneo']));;
	$juego->idtipojuego=trim($f->guardar_cadena_utf8($_POST['v_tipojuego']));;
	$juego->idtipopartido=trim($f->guardar_cadena_utf8($_POST['v_tipopartido']));;
	$juego->idespacio=trim($f->guardar_cadena_utf8($_POST['v_espacio']));;
	$juego->fechahora=trim($f->guardar_cadena_utf8($_POST['v_horario']));;
	$juego->estatus=trim($f->guardar_cadena_utf8($_POST['v_estatus']));

	$equipo1=explode(',',$_POST['equipo1']);
	$equipo2=explode(',',$_POST['equipo2']);


	$tipo->idtipopartido=$juego->idtipopartido;
	$obtenertipo=$tipo->buscarTipopartido();
	$rowtipopartido=$db->fetch_assoc($obtenertipo);
	
	//Validamos si hacermos un insert o un update
	if($juego->idjuego == 0)
	{
		//guardando
		$juego->Guardarjuego();


		for ($i=0; $i <count($equipo1) ; $i++) { 


			$juego->GuardarClienteJuego($equipo1[$i],'1');
			
		}

		for ($i=0; $i <count($equipo2) ; $i++) { 


			$juego->GuardarClienteJuego($equipo2[$i],'2');
			
		}


		for ($i=0; $i <$rowtipopartido['numerosets'] ; $i++) { 

			$juego->CrearSets($i);
		}




		$md->guardarMovimiento($f->guardar_cadena_utf8('juegos'),'juego',$f->guardar_cadena_utf8('Nuevo juego creado con el ID-'.$juego->idjuego));
	}else{
		$juego->Modificarjuego();	
		$md->guardarMovimiento($f->guardar_cadena_utf8('juegos'),'juego',$f->guardar_cadena_utf8('Modificación de juego -'.$juego->idjuego));
	}
				
	$db->commit();
	echo "1|".$juego->idjuego;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>