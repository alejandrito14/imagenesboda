<?php
require_once "../../clases/class.Cupones.php";
require_once "../../clases/conexcion.php";
    
    $fname = $_REQUEST['fname'];
    $db = new MySQL();
    $obj = new Cupones();
    $obj->db = $db;

    switch ($fname) {
        case 'getCode':       
          $isval = 0;
          $code = substr(str_shuffle('234579ABCDEFGHJKMNPQRTUVWXYZ'), 1, 5);
          $isval = $obj->validarCodigoCupon($code);
          if ($isval == 0){
            echo $code;
          }
          else{
            http_response_code(500);
          }
        break;
        case 'changeCouponState':
          $state = $_REQUEST['state'];
          $idcupon = $_REQUEST['id'];
          $obj->ActualizarEstado($idcupon,$state);
        break;

         case 'changeCouponState2':
          $state = $_REQUEST['state'];
          $idcupon = $_REQUEST['id'];
          $obj->ActualizarAutomaticoCupon($idcupon,$state);
        break;
        default:
           http_response_code(500);
      } 
?>