<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Municipio.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Municipio();
$f = new Funciones();


$emp->db = $db;


$idestado = $_POST['idestado']; 



//Realizamos consulta
	$array=array();
	$i=0;

if($idestado != '0')

{			
	$resultado_municipios = $emp->ObtenerMunicipios($idestado);

	$resultado_municipios_num = $db->num_rows($resultado_municipios);
	$lista_municipios_row = $db->fetch_assoc($resultado_municipios);
	



/*	$opciones = '<option value="0">SELECCIONAR MUNICIPIO</option>'; 
*/

	do{
		/*$opciones = $opciones . '<option value="'.$lista_municipios_row['id'].'">'.mb_strtoupper($f->imprimir_cadena_utf8($lista_municipios_row['nombre']))."</option>";*/
			$array[$i]=$lista_municipios_row;
		$i++;
	}while($lista_municipios_row = $db->fetch_assoc($resultado_municipios));
	

	
	


}


	$vrespuesta['respuesta']=$array;

	echo json_encode($vrespuesta);


?>