<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

try{

require_once("../../clases/conexcion.php");

require_once("../../clases/class.Clientes.php");

//creamos los objetos

$db = new MySQL (); 

$cliente = new Clientes();



//optenemos id del producto con la variable valor 

$cliente->db = $db ;
$nocliente = strtoupper($_POST['nocliente']);
$nocliente = trim($nocliente);
$cliente->no_cliente = $nocliente;



$msj = 0 ;





$result_cliente = $cliente->ValidarNoCliente();
$result_cliente_num =$db->num_rows($result_cliente);
//echo $producto->validarProducto();;





if ($result_cliente_num > 0)

{

	echo $msj =  1 ;

	}

else

 {

	 echo $msj =  0 ;

	}	

}catch(Exception $e)
{
	echo $msj = "noval" ;
}



?>