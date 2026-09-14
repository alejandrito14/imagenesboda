<?php

require_once("class.ManipulacionDatos.php");

require_once("class.Funciones.php");









$md = new ManipulacionDatos();

$fn = new Funciones ();

$id = $_POST['id'];

$cadena = $fn->desconver_especial($id);// sustituimos el caracter "|gato" por el  "#" ya que unos productos traen ese caracter

//y no se puede enviar por post ni por get



$md->id= $cadena ;

$md->campoid=$_POST['campo'];

$md->tabla=$_POST['tabla'];

$md->tipo=$_POST['tipo'];



$md->borrarDatos();


?>