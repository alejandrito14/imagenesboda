<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}


require_once("../../clases/conexcion.php");
require_once("../../clases/class.PagConfig.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Funciones.php");


try
{
	$db= new MySQL();
	$conf= new Configuracion();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	
	//Como no sabemos cuantos archivos van a llegar, iteramos la variable $_FILES
	$ruta="imagenes/";
	
	
	$conf->db=$db;	
	$md->db = $db;
	$db->begin();
		
		
	//recibiendo datos
	$conf->telefono1 = $f->guardar_cadena_utf8($_POST['telefono1']);
	$conf->telefono2 = $f->guardar_cadena_utf8($_POST['telefono2']);
	$conf->celular = $f->guardar_cadena_utf8($_POST['celular']);
	$conf->celular2 = $f->guardar_cadena_utf8($_POST['celular2']);
	$conf->whatsapp = $f->guardar_cadena_utf8($_POST['whatsapp']);
	$conf->whatsapp2 = $f->guardar_cadena_utf8($_POST['whatsapp2']);
	
	$conf->costoenvio = $f->guardar_cadena_utf8($_POST['costoenvio']);
	$conf->cantidadminimo = $f->guardar_cadena_utf8($_POST['cantidadminimo']);
	
	
	$conf->telefono01800 = $f->guardar_cadena_utf8($_POST['telefono01800']);
	$conf->emailsoporte = $f->guardar_cadena_utf8($_POST['emailsoporte']);
	$conf->emailpedido = $f->guardar_cadena_utf8($_POST['emailpedido']);
	$conf->emailsoporte = $f->guardar_cadena_utf8($_POST['emailsoporte']);
	$conf->emailpedido = $f->guardar_cadena_utf8($_POST['emailpedido']);
	
	$conf->facebook = $f->guardar_cadena_utf8($_POST['facebook']);
	$conf->twitter = $f->guardar_cadena_utf8($_POST['twitter']);
	$conf->rss = $f->guardar_cadena_utf8($_POST['rss']);
	$conf->delicious = $f->guardar_cadena_utf8($_POST['delicious']);
	$conf->linkedin = $f->guardar_cadena_utf8($_POST['linkedin']);
	$conf->flickr = $f->guardar_cadena_utf8($_POST['flickr']);
	$conf->skype = $f->guardar_cadena_utf8($_POST['skype']);
	$conf->instagram = $f->guardar_cadena_utf8($_POST['instagram']);
	$conf->googlemap = $f->guardar_cadena_utf8($_POST['googlemap']);
  
	$conf->otrometodo= $f->guardar_cadena_utf8($_POST['otrometodo']);
	$conf->tarjeta= $f->guardar_cadena_utf8($_POST['tarjeta']);
	$conf->oxxo= $f->guardar_cadena_utf8($_POST['oxxo']);
	$conf->spei=$f->guardar_cadena_utf8($_POST['spei']);
	$conf->llavepublica= $f->guardar_cadena_utf8($_POST['llavepublica']);
	$conf->llaveprivada= $f->guardar_cadena_utf8($_POST['llaveprivada']);
	$conf->host= $f->guardar_cadena_utf8($_POST['host']);
	$conf->puerto= $f->guardar_cadena_utf8($_POST['puerto']);
	$conf->usuario= $f->guardar_cadena_utf8($_POST['usuario']);
	$conf->contrasena= $f->guardar_cadena_utf8($_POST['contrasena']);
	$conf->remitente= $f->guardar_cadena_utf8($_POST['remitente']);
	$conf->nombreremitente= $f->guardar_cadena_utf8($_POST['nombreremitente']);
	$conf->smtauth= $f->guardar_cadena_utf8($_POST['smtauth']);
	$conf->seguridad= $f->guardar_cadena_utf8($_POST['seguridad']);
	$conf->negocio= $f->guardar_cadena_utf8($_POST['negocio']);
	$conf->bienvenida=addslashes(trim($_POST['bienvenida']));
	$conf->diasvencimiento=$_POST['diasvencimiento'];
	$conf->nombrenegocio1=$_POST['nombrenegocio1'];
	
	
	//guardando
	
	//evaluamos si ya existia la configuracion de la empresa. con la variable
	
	$conf->idpagconfig =  $f->guardar_cadena_utf8($_POST['v_id']);
	

	
	if($conf->idpagconfig == 0)
	{
	
	$conf->GuardarNewConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Guardando Configuracion de la empresa-'.$conf->idpagconfig));
	}else
	{
		
	$conf->idConfiguracion = $id;
	$conf->ModificarConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Modificamos la Configuracion de la empresa-'.$conf->idpagconfig));
	}
	
	
	foreach ($_FILES as $key) 
	  {
		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
		  $extension = end(explode(".", $_FILES['file']['name']));
            $nombre = str_replace(' ','_',date('Y-m-d H:i:s').'.jpg');//Obtenemos el nombre del archivo

		  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
		  $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
		  
		   //obtenemos el nombre del archivo anterior para ser eliminado si existe
		  
		  $sql = "SELECT logo FROM pagina_configuracion";
		  $result_borrar = $db->consulta($sql);
		  $result_borrar_row = $db->fetch_assoc($result_borrar);
		  $nombreborrar = $result_borrar_row['logo'];		  
		  
		  if($nombreborrar != "")
		  {
			  unlink($ruta.$nombreborrar); 
		  }
		  
		  
		  move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
		  //El echo es para que lo reciba jquery y lo ponga en el div "cargados"
		  
		 
		  $sql = "UPDATE pagina_configuracion SET logo = '$nombre'";
		   
		  $result = $db->consulta($sql);	 
		}
	  }
	
	
	
	
	$db->commit();
	echo 1;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
}
?>