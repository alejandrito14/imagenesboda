<?php


/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
        /* header("Location: ../login.php"); */ echo "login";
    exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Sucursalesfolios.php");
try
{
    //declaramos los objetos de clase
    $db = new MySQL();
    $su = new Categoriasproductos();
    $f = new Funciones();
    $md = new MovimientoBitacora();
    
    //enviamos la conexión a las clases que lo requieren
    $su->db = $db;
    $md->db = $db;  
    $ruta="imagenes/".$_SESSION['codservicio'].'/';

    $su->idcategoria=$_POST['idcategoriasproducto'];

if (($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")) {




  
            $temporal = $_FILES["file"]["tmp_name"]; //Obtenemos el nombre del archivo temporal
            $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
            $extension = end(explode(".", $_FILES['file']['name']));
            $nombre = str_replace(' ','_',date('Y-m-d H:i:s').'-'.$su->idcategoria.".".$extension);//Obtenemos el nombre del archivo


           if (move_uploaded_file($temporal, $ruta.$nombre)) {
                # code...
             //Movemos el archivo temporal a la ruta especificada

            $sql = "INSERT INTO categoriasimagenes(imagen,idcategorias) VALUES('$nombre','$su->idcategoria')";   

          
            $db->consulta($sql);   

             echo 1;

            }else{

             echo 0;
            }

           

} else {
    echo 0;
}


}catch(Exception $e)
{
    $db->rollback();
    echo "Error. ".$e;
}
?>
