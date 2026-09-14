<?php
define("cfileUrl", "archivosproductos/");
require_once("../../clases/conexcion.php");

$vdataResponse=array();
    try{

        $db = new MySQL();

        $idproductosimagenes=$_POST['idproductos_imagenes'];
        $idproductos=$_POST['idproductos'];
        $idempresas=$_POST['idempresas'];

        $sql1="SELECT *FROM productos_imagenes where idproductos_imagenes=".$idproductosimagenes."";
        $productos=$db->consulta($sql1);
        $productos_row=$db->fetch_assoc($productos);

        $imagen=$productos_row['imagen'];



        if ( is_file(cfileUrl .trim($imagen)) ){
            if ( unlink(cfileUrl .trim($imagen))){

                 $sql="DELETE FROM productos_imagenes WHERE idproductos_imagenes=".$idproductosimagenes."";
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