<?php 
require_once '../../../clases/functions/excel.php';
require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Sesion.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Usuarios.php");
require_once("../../../clases/class.AccesoEmpresa.php");
require_once("../../../clases/class.NotaRemision.php");
require_once("../../../clases/class.Reportes.php");

require_once('../../../clases/PHPExcel-1.8/Classes/PHPExcel.php');

//creamos nuestra sesion.
$se = new Sesion();

$servidor='https://'.$_SERVER['HTTP_HOST'].'/IS-U-ORDER/';
$carpeta=$_SESSION['carpetaapp'];
if(!isset($_SESSION['se_SAS']))
{
   /*header("Location: ../../login.php"); */ echo "login";
   exit;
}
$db = new MySQL();

$f = new Funciones();
$usuario = new Usuarios();
$usuario->db=$db;
$acceso=new AccesoEmpresa();
$acceso->db=$db;
$rpt->db = $db;
$notaremision=new NotaRemision();
$notaremision->db=$db;
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion

$lista_empresas = $_SESSION['se_liempresas']; //variables de session
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');



$horainicio="";
if(empty($_GET['horainicio'])) {
   
   $horainicio='00:00:00';
}else{

   $horainicio=$_GET['horainicio'].':00';
}
$horafin="";

if(empty($_GET['horafin'])) {
   
   $horafin='23:59:59';
}else{

   $horafin=$_GET['horafin'].':59';
}

   $idsucursal=0;
   $fecha_inicial1=date('Y-m-d');
   $fecha_final1=date('Y-m-d');
if (isset($_GET['idsucursal'])) {
  $idsucursal=$_GET['idsucursal'];
}
if (isset($_GET['fechainicio'])) {
   $fecha_inicial1 = date('Y-m-d',strtotime($_GET['fechainicio'])).' '.$horainicio;
}
if (isset($_GET['fechafin'])) {
   $fecha_final1 = date('Y-m-d',strtotime($_GET['fechafin'])).' '.$horafin;

}


   $fecha_hoy = new DateTime();
   $fecha_hoy = date_format($fecha_hoy, 'd-m-Y H:i:s');
   //echo "<br>Fecha hoy.- ".$fecha_hoy;
   $usuario->id_usuario=$_SESSION['se_sas_Usuario'];
   $datos=$usuario->ObtenerDatosUsuario();
   //$tipousaurio=$datos['tipo'];

   $acceso->idusuarios=$usuario->id_usuario;


   if ($tipousaurio==0) {

      if ($idsucursal==0) {
      $obtener=$usuario->ObtenerTodasSucursales();
      $lista_empresas=$obtener['idsucursales'];

      }else{

         $lista_empresas=$idsucursal;
   
      }

   }else{

      if ($idsucursal==0) {
         $listado=$acceso->obtenerSucursalAsignadasAgrupada();
         $obtener=$db->fetch_assoc($listado);
         $lista_empresas=$obtener['idsucursales'];
      }else{


         $lista_empresas=$idsucursal;
      }
      

   }

   $sql="nr.idsucursales IN(".$lista_empresas.")";

//http://localhost:8888/is-market/www/modelosreportes/ventas/excel/rpt_TotalpedidosporCliente.php?idsucursal=0&fechainicio=2022-03-01&fechafin=2022-03-31&horainicio=&horafin=

   
   $sql_sucursales = "SELECT
   nr.idsucursales,
   e.sucursal,
   CONCAT(c.nombre,' ',c.paterno,' ',c.materno) AS nombre_cliente,
   nr.total,
   nr.sumatotalapagar,
   nr.nuevototal,
   nr.datoscosto,
   nr.habilitarsumaenvio,
   nr.datoscosto,
   nr.ivacompra,
   nr.comisiontotal,
   nr.idcliente,
   nr.folio,
   nr.fechapedido,
   nr.requierefactura,
   nr.montonuevoafacturar,
   nr.codigocupon,
   nr.montodescontado,
   nr.idnota_remision,
   nr.opcionelegida,
   nr.opcionelegidapago,
   es.idestatus as estatusid,
   es.estatus as estatusnota,
   nr.estatus ,
   nr.idtransaccionstripe
   FROM
   nota_remision AS nr
   INNER JOIN sucursales e ON e.idsucursales = nr.idsucursales
   INNER JOIN clientes c ON c.idcliente=nr.idcliente
   INNER join estatus es ON es.codigoestatus=nr.estatus
   
   WHERE ".$sql."
    AND nr.fechapedido >= '".$fecha_inicial1."' AND  nr.fechapedido<='".$fecha_final1."'
   ORDER BY
   e.sucursal,nr.idnota_remision ASC  ";



        $result_clientes = $db->consulta($sql_sucursales);
        $result_clientes_row = $db->fetch_assoc($result_clientes);
       $result_clientes_num = $db->num_rows($result_clientes); 
       $total_gral=0;

       $arrayresultado=array();



if (isset($_GET['fechainicio'])) {
  $fecha_inicial = date('d-m-Y',strtotime($_GET['fechainicio']));
}
if (isset($_GET['fechafin'])) {
$fecha_final = date('d-m-Y',strtotime($_GET['fechafin']));

}


         if($result_clientes_num == 0){
        
         }else{
            
            $num=0;
            do
            {


            $idtransaccion=$result_clientes_row['idtransaccionstripe'];
            $rutacomprobante="app/".$_SESSION['carpetaapp']."/php/upload/comprobante/";
            $habilitarsumaenvio=$result_clientes_row['habilitarsumaenvio'];
            $estatusnota=$result_clientes_row['estatusnota'];
            $entrega=$result_clientes_row['opcionelegida'];
            $pago=$result_clientes_row['opcionelegidapago'];
            $notaremision->idnota_remision=$result_clientes_row['idnota_remision'];

            $detallenota=$notaremision->Obtenerdescripcion2();
            $suma=0;

      for ($j=0; $j <count($detallenota) ; $j++) { 

      if ($result_clientes_row['requierefactura']==1 && $result_clientes_row['montonuevoafacturar']!=0 && $result_clientes_row['montonuevoafacturar']!=null) {
            $suma=$suma+$detallenota[$j]->precio;  
      
      }
          else{
       if ($result_clientes_row['requierefactura']==1 && $result_clientes_row['montonuevoafacturar']==0) {
      
            if ($detallenota[$j]->totpaquedesc!=0) {
                     
               $suma=$suma+$detallenota[$j]->totpaquedesc;  

            }else{
                     
            $suma=$suma+$detallenota[$j]->totantespagar; 
         }
        
        
       }else{

         $suma=$suma+$detallenota[$j]->precio;  
       }

    }

       $subtotal=0;
       $descuento=0;
       $subtotal1=0;
       if ($detallenota[$j]->totantespagar!=null) {
             $subtotal=$subtotal+$detallenota[$j]->totantespagar;

       }

       if ($detallenota[$j]->totpaquedesc!=null) {
       $subtotal1=$subtotal1+$detallenota[$j]->totpaquedesc;

      }

    $descuento=$subtotal1-$subtotal;
 

               
   }
            $montodescontado=0;

            $codigocupon=$result_clientes_row['codigocupon'];
            if ($result_clientes_row['requierefactura']==1 && ($result_clientes_row['montonuevoafacturar']==0 || $result_clientes_row['montonuevoafacturar']==null)) {
                  if ($codigocupon!='' && $codigocupon!=null) {

                     if ($descuento!=0 && $descuento!=null) {

                        $montodescontado=$descuento;
   
                     }else{

                     $montodescontado=$result_clientes_row['montodescontado'];
   
                     }
                  //totalg=suma;
               }
                }

        else if($result_clientes_row['requierefactura']==1 && $result_clientes_row['montonuevoafacturar']!=0) {


            $montodescontado=$result_clientes_row['montodescontado'];

          }

          else{

            if ($codigocupon!='' && $codigocupon!=null) {

                  $montodescontado=$result_clientes_row['montodescontado'];
                  //totalg=suma;
               }

          }
      

              $costofinal=0;
              $total=$suma;
           if ($result_clientes_row['datoscosto']!='') {
               $costo=$result_clientes_row['datoscosto'];
               $dividircosto=explode('|',$costo);
               $costofinal=$dividircosto[3];
               if ($habilitarsumaenvio==1) {
               $total=$total+$costofinal;

               }

            }  

            if ($montodescontado!=0) {
               $total=$total-$montodescontado;
            }



            $montofacturado=0;
            $ivacompra=0;
             if ($result_clientes_row['ivacompra']!='' && $result_clientes_row['ivacompra']!=0 && $result_clientes_row['ivacompra']!=null) {
               $montofacturado=$result_clientes_row['montoafacturar'];
               $ivacompra=$result_clientes_row['ivacompra'];
            $total=$total+$ivacompra;
           }
         
         $comisiontotal=0;

              if ($result_clientes_row['comisiontotal']!=null && $result_clientes_row['comisiontotal']!=0 && $result_clientes_row['comisiontotal']!='') {
               $comisiontotal=$result_clientes_row['comisiontotal'];
               $total=$total+$comisiontotal;

              }

          
               
              $imagencomprobante=$notaremision->obtenerImagenesComprobantes();
               if($result_clientes_row['estatusid']==3){

                  $total_gral=$total_gral+$total;
               }
            
      
   $exitosos=0;
   $monto=0;
   $cancelados=0;
      if ($result_clientes_row['estatus']==2) {
                     
                     $exitosos=$exitosos+1;


                     $monto=$monto+$total;   

                     }

      if ($result_clientes_row['estatus']==3) {
                     
            $cancelados=$cancelados+1;

                  }
   
      $arreglo=array('idcliente'=>$result_clientes_row['idcliente'],'nombrecliente'=>$result_clientes_row['nombre_cliente'],'cancelados'=>$cancelados,'exitosos'=>$exitosos,'monto'=>$monto,'paquetefrecuente'=>'');

                  

            $posicion=BuscarEnArray($arrayresultado,$result_clientes_row['idcliente']);

            
            
               if ($posicion ==-1) {
                  
                  array_push($arrayresultado, $arreglo);


               }else{

                  

                  if ($result_clientes_row['estatus']==2) {
                     
                     $arrayresultado[$posicion]['exitosos']=$arrayresultado[$posicion]['exitosos']+1;


                     $arrayresultado[$posicion]['monto']=$arrayresultado[$posicion]['monto']+$total;  

                     }

                  if ($result_clientes_row['estatus']==3) {
                     
                     $arrayresultado[$posicion]['cancelados']=                   $arrayresultado[$posicion]['cancelados']+1;

                        }

               }


         
         
            }while($result_clientes_row = $db->fetch_assoc($result_clientes));


         }

         
         for ($i=0; $i <count($arrayresultado) ; $i++) { 
            
            $idcliente=$arrayresultado[$i]['idcliente'];

            //$obtener=PaqueteFrecuente($idcliente,$fecha_inicial,$fecha_final,$db);


            $sql="SELECT
         nombre,
         sum( cantidad ) AS totalvendidos 
      FROM
         (
         SELECT
            nota_remision.idnota_remision,
            nota_remision_descripcion.nombre,
            SUM( nota_remision_descripcion.cantidad ) AS cantidad 
         FROM
            nota_remision
            INNER JOIN nota_remision_descripcion ON nota_remision.idnota_remision = nota_remision_descripcion.idnota_remision 
         WHERE
            fechapedido >= '$fecha_inicial1' 
            AND fechapedido <= '$fecha_final1' And idcliente='$idcliente'
         GROUP BY
            idnota_remision,
            nombre 
         ) AS tbl 
      GROUP BY
         nombre 
      ORDER BY
         totalvendidos DESC LIMIT 1";
            
         $result= $db->consulta($sql);

         $dato=$db->fetch_assoc($result);

         $arrayresultado[$i]['paquetefrecuente']=$dato['nombre'];

         }


    function BuscarEnArray($array,$valor)
   {


      if (count($array)>0) {
         
         $encontrado=0;
         for ($i=0; $i <count($array) ; $i++) { 
            
            //print_r($array[$i]['idcliente'].'=='.$valor);
            if ($array[$i]['idcliente']==$valor) {
               $encontrado=1;
               //echo 'posicion'.$i;
               return $i;

            }
         }
         
         if ($encontrado==0) {
            return -1;
         }

      }else{

         return -1;
      }
   }

         



         


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
               ->setLastModifiedBy("Maarten Balliauw")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLSX Test Document")
               ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CLIENTE')
            ->setCellValue('B1', 'PEDIDOS EXITOSOS')
            ->setCellValue('C1', 'PEDIDOS CANCELADOS')
            ->setCellValue('D1', 'MONTO')
            ->setCellValue('E1', 'PAQUETE FRECUENTE');

$j = 2;
/*$sql="SELECT *FROM nota_remision";
$informe=$db->consulta($sql);


while($row = $db->fetch_assoc($informe))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $row['idcliente'])
            ->setCellValue("B$i", $row['fechapedido'])
            ->setCellValue("C$i", $row['subtotal'])
            ->setCellValue("D$i", $row['total']);
$i++;
}*/

if(count($arrayresultado) == 0){

   $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$j","")
            ->setCellValue("B$j", "")
            ->setCellValue("C$j", "")
            ->setCellValue("D$j", "")
            ->setCellValue("E$j", "");

        
      }else{

         for ($i=0; $i <count($arrayresultado) ; $i++) { 
            
            $idcliente=$arrayresultado[$i]['idcliente'];
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit("A$j", $arrayresultado[$i]['nombrecliente'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("B$j", $arrayresultado[$i]['exitosos'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("C$j", $arrayresultado[$i]['cancelados'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("D$j",'$'.number_format($arrayresultado[$i]['monto']),PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit("E$j", $arrayresultado[$i]['paquetefrecuente'],PHPExcel_Cell_DataType::TYPE_STRING);
            $j++;

         }

      }
   

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Informe de ventas por cliente');

$objPHPExcel->setActiveSheetIndex(0);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename = "rpt_TotalpedidosporCliente".$lista_empresas.'-'.$fecha_inicial.' '.$horainicio."-".$fecha_final.' '.$horafin.".xls";

// Redirect output to a client’s web browser (Excel5)
header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );

header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


?>