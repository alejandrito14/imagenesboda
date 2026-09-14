<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');



/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Pais.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Paises();
$f = new Funciones();


$emp->db = $db;





			
	$resultado_pais = $emp->ObtenerPaices();

	$resultado_pais_num = $db->num_rows($resultado_pais);
	$lista_pais_row = $db->fetch_assoc($resultado_pais);
	



	//$opciones = '<option value="0">SELECCIONAR PAIS</option>'; 
	$array=array();
	$i=0;
	if ($resultado_pais_num>0) {
		# code...
	

	do{
		/*$opciones = $opciones . '<option value="'.$lista_pais_row['idpais'].'">'.mb_strtoupper($f->imprimir_cadena_utf8($lista_pais_row['pais']))."</option>";*/

		$array[$i]=$lista_pais_row;
		$i++;

	}while($lista_pais_row = $db->fetch_assoc($resultado_pais));
	

	}
	

$vrespuesta['respuesta']=$array;

echo json_encode($vrespuesta);

?>