<?php
require_once("../../clases/class.Sesion.php");

$se = new Sesion();
    $ruta='imagenespaquete/'.$_SESSION['codservicio'].'/';

if (($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $ruta.$_FILES['file']['name'])) {
        //more code here...
        echo "catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio'].'/'.$_FILES['file']['name'];
    } else {
        echo 0;
    }
} else {
    echo 0;
}

 ?>