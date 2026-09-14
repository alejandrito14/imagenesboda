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
require_once("../clases/class.PerfilesPermisos.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once("../clases/class.Funciones.php");


try
{
	$db= new MySQL();
	$pp = new PerfilesPermisos();
	$md = new MovimientoBitacora();
	$fu = new Funciones();
	
	$pp->db = $db;	
	$md->db = $db;

	
	$db->begin();	

	$tipo = $_POST['tipo'];
	$cantidad = $_POST['cantidad_menu'];//cantidad de submenus seleccionados
	
	switch($tipo)
	{
		case 1:
				$pp->perfil = $fu->guardar_cadena_utf8($_POST['nombre']);
				$pp->estatus = $_POST['estatus'];				
				$pp->GuardarNewPerfil();
				
				for($i=1;$i<=$cantidad;$i++)
				{
					
					if(isset($_POST['menu'.$i]))
					{
						$pp->Perfiles_Permisos($_POST['menu'.$i],$_POST['insertar'.$i],$_POST['modificar'.$i],$_POST['borrar'].$i);
					}
				}
				
				$md->guardarMovimiento(('perfiles'),'perfiles',('Nuevo Perfil creado -'.$pp->ultimoperfil));				
			break;
		case 2:
				$pp->idperfiles = $_POST['idperfiles'];
				$pp->ultimoperfil = $_POST['idperfiles'];
				
				$pp->EliminarPermisos();
				
				$pp->perfil = $fu->guardar_cadena_utf8($_POST['nombre']);
				$pp->estatus = $_POST['estatus'];				
				$pp->ModificarPerfil();
				
				for($i=1;$i<=$cantidad;$i++)
				{
					if(isset($_POST['menu'.$i]))
					{						
						
						if($_POST['insertar'.$i] == 1){
							$insertar = $_POST['insertar'.$i];
						}else{
							$insertar = 0;
						}
						
						if($_POST['modificar'.$i] == 1){
							$modificar = $_POST['modificar'.$i];
						}else{
							$modificar = 0;
						}
						
						if($_POST['borrar'.$i] == 1){
							$borrar = $_POST['borrar'.$i];
						}else{
							$borrar = 0;
						}
						
						$pp->Perfiles_Permisos($_POST['menu'.$i],$insertar,$modificar,$borrar);
					}
				}
				
				$md->guardarMovimiento(('perfiles'),'perfiles',('Modificacion del perfil creado -'.$_POST['idperfiles']));
			break;
	}
	
	
	
	
	$db->commit();
	echo 1;
}
catch(Exception $e)
{
	//echo $e;
	echo 0;
	$db->rollback();
}

?>
