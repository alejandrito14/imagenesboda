<?php
require_once("../../clases/class.Sesion.php");

    $se = new Sesion();
    $ruta='imagenesnoticias/'.$_SESSION['codservicio'].'/';
    $fecha=date('Y-m-d H:i:s');
 $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION );
if (($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")) {


    if (move_uploaded_file($_FILES["file"]["tmp_name"],$ruta.$fecha.'.'.$ext)) {
       
        //more code here...
        echo "./catalogos/secciones/imagenesnoticias/".$_SESSION['codservicio'].'/'.$fecha.'.'.$ext;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

 ?>