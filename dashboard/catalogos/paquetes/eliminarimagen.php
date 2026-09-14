<?php
require_once("../../clases/class.Sesion.php");
$se = new Sesion();

define("cfileUrl", "imagenespaquete/".$_SESSION['codservicio']."/");

require_once("../../clases/conexcion.php");

$vdataResponse=array();
    try{

        $db = new MySQL();

        $idpaquetesimagenes=$_POST['idpaquetesimagenes'];

        $sql1="SELECT *FROM paquetesimagenes where idpaquetesimagenes=".$idpaquetesimagenes."";
        $paquetes=$db->consulta($sql1);
        $paquetes_row=$db->fetch_assoc($paquetes);

        $imagen=$paquetes_row['imagen'];



        if ( is_file(cfileUrl .trim($imagen)) ){
            if ( unlink(cfileUrl .trim($imagen))){

                 $sql="DELETE FROM paquetesimagenes WHERE idpaquetesimagenes=".$idpaquetesimagenes."";
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