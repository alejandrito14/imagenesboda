<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

define("cfileUrl", "imagenes/".$_SESSION['codservicio']."/");
require_once("../../clases/conexcion.php");


$vdataResponse=array();
    try{

        $db = new MySQL();

        $idproductosimagenes=$_POST['idsucursalesimagenes'];

        $sql1="SELECT *FROM sucursalesimagenes where idsucursalesimagenes=".$idproductosimagenes."";
        $productos=$db->consulta($sql1);
        $productos_row=$db->fetch_assoc($productos);

        $imagen=$productos_row['imagen'];



        if ( is_file(cfileUrl .trim($imagen)) ){
            if ( unlink(cfileUrl .trim($imagen))){

                 $sql="DELETE FROM sucursalesimagenes WHERE idsucursalesimagenes=".$idproductosimagenes."";
                 $db->consulta($sql);
                $vdataResponse["messageNumber"]=1;
            }
            else{
                $vdataResponse["messageNumber"]=0;
            }
        }



        else{


          $vdataResponse["messageNumber"]=-1;
        }
        
        unset($vrequest);
    }
    catch (Exception $vexception){
        $vdataResponse["messageNumber"]=-100;
    }
    echo json_encode($vdataResponse);

?>