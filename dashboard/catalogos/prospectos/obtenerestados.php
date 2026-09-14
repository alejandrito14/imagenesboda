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
require_once("../../clases/class.Estado.php");
require_once("../../clases/class.Funciones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Estado();
$f = new Funciones();


$emp->db = $db;


$idpais = $_POST['idpais']; 



//Realizamos consulta


if($idpais != 't')

{			
	$resultado_estados = $emp->ObtenerEstados($idpais);

	$resultado_estados_num = $db->num_rows($resultado_estados);
	$lista_estados_row = $db->fetch_assoc($resultado_estados);
	



	$opciones = '<option value="0">SELECCIONAR ESTADO</option>'; 

	do{
		$opciones = $opciones . '<option value="'.$lista_estados_row['id'].'">'.mb_strtoupper($f->imprimir_cadena_utf8($lista_estados_row['nombre']))."</option>";

	}while($lista_estados_row = $db->fetch_assoc($resultado_estados));
	

	
	


}
else
{
	$opciones = '<option value="0">SELECCIONAR ESTADO</option>'; 
}

echo $opciones;

?>