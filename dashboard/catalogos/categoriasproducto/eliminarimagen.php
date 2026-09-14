<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

define("cfileUrl", "imagenes/".$_SESSION['codservicio']."/");
require_once("../../clases/conexcion.php");

$vdataResponse=array();
    try{

        $db = new MySQL();

        $idcategoriasimagenes=$_POST['idcategoriasimagenes'];

        $sql1="SELECT *FROM categoriasimagenes where idcategoriasimagenes=".$idcategoriasimagenes."";
        $productos=$db->consulta($sql1);
        $productos_row=$db->fetch_assoc($productos);

        $imagen=$productos_row['imagen'];



        if ( is_file(cfileUrl .trim($imagen)) ){
            if ( unlink(cfileUrl .trim($imagen))){

                 $sql="DELETE FROM categoriasimagenes WHERE idcategoriasimagenes=".$idcategoriasimagenes."";
                 $db->consulta($sql);
                $vdataResponse["messageNumber"]=1;
            }
            else{
                $vdataResponse["messageNumber"]=0;
            }
        }



        }else{


          $vdataResponse["messageNumber"]=-1;
        }
        
        unset($vrequest);
    }
    catch (Exception $vexception){
        $vdataResponse["messageNumber"]=-100;
    }
    echo json_encode($vdataResponse);

?>