<?php
require_once("clases/class.Sesion.php");
$se= new Sesion();

$se->terminarSesion();
header("location: index.php");
?>