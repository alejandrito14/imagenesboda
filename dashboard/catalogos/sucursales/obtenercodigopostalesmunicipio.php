<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/



require_once("../../clases/conexcion.php");
require_once("../../clases/class.CodigoPostal.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new CodigoPostal();
$f = new Funciones();


$emp->db = $db;


$idpais = $_POST['pais']; 
$estado = $_POST['estado']; 
$municipio = $_POST['municipio']; 

$emp->idestado=$estado;
$obtenerClaveestado=$emp->obtenerClaveestado();
$resultado=$db->fetch_assoc($obtenerClaveestado);

$emp->idmunicipio=$municipio;

$obtenerClavemunicipio=$emp->obtenerClavemunicipio();
$resultado2=$db->fetch_assoc($obtenerClavemunicipio);


$claveestado=$resultado['clave'];
$clavemunicipio=$resultado2['clave'];

$obtenercodigos=$emp->Obtenercodigospostalesclave($claveestado,$clavemunicipio);



$vrespuesta['respuesta']=$obtenercodigos;

echo json_encode($vrespuesta);

?>