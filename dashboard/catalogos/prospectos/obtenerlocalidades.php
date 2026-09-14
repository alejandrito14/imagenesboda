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


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Localidad.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Localidad();
$f = new Funciones();


$emp->db = $db;


$idmunicipio = $_POST['idmunicipio']; 



//Realizamos consulta


if($idestado != '0')

{			
	$resultado_localidades = $emp->Obtenerlocalidades($idmunicipio);

	$resultado_localidades_num = $db->num_rows($resultado_localidades);
	$lista_localidades_row = $db->fetch_assoc($resultado_localidades);
	



	$opciones = '<option value="0">SELECCIONA UN LOCALIDAD</option>'; 

	do{
		$opciones = $opciones . '<option value="'.$lista_localidades_row['id'].'">'.mb_strtoupper($f->imprimir_cadena_utf8($lista_localidades_row['nombre']))."</option>";

	}while($lista_localidades_row = $db->fetch_assoc($resultado_localidades));
	

	
	


}
else
{
	$opciones = '<option value="0">SELECCIONA UN LOCALIDAD</option>'; 
}

echo $opciones;

?>