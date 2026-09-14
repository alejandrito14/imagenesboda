<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/



require_once("../../clases/conexcion.php");
require_once("../../clases/class.Estado.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Estado();
$f = new Funciones();


$emp->db = $db;


$idpais = $_POST['idpais']; 



//Realizamos consulta

$array=array();
	$i=0;
if($idpais != 't')

{			
	$resultado_estados = $emp->ObtenerEstados($idpais);

	$resultado_estados_num = $db->num_rows($resultado_estados);
	$lista_estados_row = $db->fetch_assoc($resultado_estados);
	



/*	$opciones = '<option value="0">SELECCIONAR ESTADO</option>'; 
*/
	do{
		$array[$i]=$lista_estados_row;
		$i++;
	}while($lista_estados_row = $db->fetch_assoc($resultado_estados));
	

	
	


}


$vrespuesta['respuesta']=$array;

echo json_encode($vrespuesta);

?>