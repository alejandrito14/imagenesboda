<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.ModulosMenu.php");
require_once("../clases/class.Funciones.php");



try
{
	$db= new MySQL();
	$mm= new ModulosMenu();
	$fu = new Funciones();
	$mm->db=$db;
	$db->begin();
	$tipo=$_POST['tipo'];//tipo de guardado que va a realizar  1.-alta demodulos 2.- modificacion de modulos  3.- alta de menu  4.- modificacion de menu
	
	
	
	
	switch($tipo)
	{
		case 1:
				$mm->modulo=$fu->guardar_cadena_utf8($_POST['nombre']);
				$mm->estatusmodulo=$_POST['estatus'];
				$mm->nivel = $_POST['nivel'];
				$mm->GuardarNewModulo();
			break;
		case 2:
				$mm->idmodulo=$_POST['idmodulo'];
				$mm->modulo=$fu->guardar_cadena_utf8($_POST['nombre']);
				$mm->estatusmodulo=$_POST['estatus'];
				$mm->nivel = $_POST['nivel'];
				
				$mm->ModificarModulos();				
			break;
		case 3:
				$mm->idmodulo=$_POST['idmodulos'];
				$mm->menu=$fu->guardar_cadena_utf8($_POST['nombre']);
				$mm->archvio=$_POST['archivo'];
				$mm->ubi_archivo=$_POST['ubi'];
				$mm->estatusMenu=$_POST['estatus'];
				$mm->nivel = $_POST['nivel'];
				
				$mm->GuardarNewMenu();			
			break;
		case 4:
				$mm->idmenu=$_POST['idmodulos_menu'];
				$mm->idmodulo=$_POST['idmodulos'];
				$mm->menu=$fu->guardar_cadena_utf8($_POST['nombre']);
				$mm->archvio=$_POST['archivo'];
				$mm->ubi_archivo=$_POST['ubi'];
				$mm->estatusMenu=$_POST['estatus'];
				$mm->nivel = $_POST['nivel'];
				
				$mm->ModificarMenu();	
			break;
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