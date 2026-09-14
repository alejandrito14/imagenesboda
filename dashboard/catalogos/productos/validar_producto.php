<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();



require_once("../../clases/conexcion.php");

require_once("../../clases/class.Productos.php");

//creamos los objetos

$db = new MySQL (); 

$producto = new Productos();



//optenemos id del producto con la variable valor 

$producto->db = $db ;
$idproducto = strtoupper($_POST['idproducto']);
$idproducto = trim($idproducto);

$producto->idproducto = $idproducto;



$msj = 0 ;





$result_producto = $producto->validarProducto();

//echo $producto->validarProducto();;





if ($result_producto > 0)

{

	echo $msj =  1 ;

	}

else

 {

	 echo $msj =  0 ;

	}	





?>