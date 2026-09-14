<?PHP

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();
$servidor='https://'.$_SERVER['HTTP_HOST'].'/IS-U-ORDER/';
$carpeta=$_SESSION['carpetaapp'];
if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";
	exit;
}

//validaciones para todo el sistema
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Reportes.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Botones.php");
require_once("../../../clases/class.AccesoEmpresa.php");
require_once("../../../clases/class.Usuarios.php");
require_once("../../../clases/class.NotaRemision.php");

//validaciones para todo el sistema
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

/*$idempresa = $_GET['v_idempresa'] ;
*/

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






$idsucursal=$_GET['idsucursal'];
$fecha_inicial = date('Y-m-d',strtotime($_GET['fechainicio'])).' '.$horainicio;
$fecha_final = date('Y-m-d',strtotime($_GET['fechafin'])).' '.$horafin;

$db = new MySQL();
$rpt = new Reportes();
$bt = new Botones_permisos();
$f = new Funciones();
$usuario = new Usuarios();
$usuario->db=$db;
$acceso=new AccesoEmpresa();
$acceso->db=$db;
$rpt->db = $db;
$notaremision=new NotaRemision();
$notaremision->db=$db;


	date_default_timezone_set("America/Mexico_City");
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
	es.estatus as estatusnota,
	nr.idtransaccionstripe
	FROM
	nota_remision AS nr
	INNER JOIN sucursales e ON e.idsucursales = nr.idsucursales
	INNER JOIN clientes c ON c.idcliente=nr.idcliente
	INNER join estatus es ON es.codigoestatus=nr.estatus
	
	WHERE ".$sql."
	 AND nr.fechapedido BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
	ORDER BY
	e.sucursal,nr.idnota_remision ASC  ";

	     $result_clientes = $db->consulta($sql_sucursales);
	     $result_clientes_row = $db->fetch_assoc($result_clientes);
		 $result_clientes_num = $db->num_rows($result_clientes);	
		 $total_gral=0;

$fecha_inicial = date('d-m-Y',strtotime($_GET['fechainicio']));
$fecha_final = date('d-m-Y',strtotime($_GET['fechafin']));


$filename = "rpt_Ventas_general-".$lista_empresas.'-'.$fecha_inicial.' '.$horainicio."-".$fecha_final.' '.$horafin.".xls";
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename="'.$filename.'"');


?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- <h3>EMPRESA: <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['empresas']));?></h3>	 -->
 <style>
 	.wrap2 { 
 
  height:50px;
  overflow: auto;
  width:100px;
}
 </style>
<table border="1" cellspacing="1" cellpadding="5" style="overflow: auto">
	<thead class="thead-dark">
		<tr bgcolor="#3B3B3B" style="color: #FFFFFF; text-align: center;">
			
			<th>SUCURSAL</th>
			<th>FOLIO</th>
			<th>FECHA DE PEDIDO</th>
			<th>ESTATUS</th>
			<th>CLIENTE</th>

			<th>OPCION DE ENTREGA</th>
			<th>OPCION DE PAGO</th>
			<th>COMPROBANTE</th>
			<th>IDTRANSACCION</th>
			<th>SUBTOTAL</th>

			<th>DESCUENTO</th>

			<th>COSTO ENVÍO</th>
			<th>IVA</th>
			<th>COMISIÓN</th>
			<th>TOTAL</th> 
		</tr>
	</thead>

	<tbody>
			<?php
			if($result_clientes_num == 0){
			?>
			<tr> 
				<td colspan="4" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN DATOS EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
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

							$montodescontado=$result_clientes['montodescontado'];
	
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
			/*		
			if ($result_clientes_row['nuevototal']!=0 && $result_clientes_row['nuevototal']!=null ) {
              	$result_clientes_row['total']=$result_clientes_row['nuevototal'];

              }*/

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

            /*  if ($result_clientes_row['sumatotalapagar']!=null &&  $result_clientes_row['sumatotalapagar']!=0) {
              	  $result_clientes_row['total']=$result_clientes_row['sumatotalapagar'];

              }*/
					
              $imagencomprobante=$notaremision->obtenerImagenesComprobantes();
					
				$total_gral=$total_gral+$total;
			?>
			<tr onClick="f_toogle('<?php echo $idfila; ?>');" style="cursor: pointer;" colspan="4">
			    <td style="text-align: center; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['sucursal'])); ?></td>
			     <td style="text-align: center; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['folio'])); ?></td>
			      <td style="text-align: center; "><?php echo mb_strtoupper(date('d-m-Y H:i:s',strtotime($result_clientes_row['fechapedido']))); ?></td>
			      <td style="text-align: center;"><?php echo $estatusnota; ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['nombre_cliente'])); ?></td>
			    <td style="text-align: center;"> <?php echo $entrega; ?></td>
			    <td style="text-align: center;"> <?php echo $pago; ?></td>
<!-- 			    <td style="width:200px;height: 150px;" >
 -->		<td style="height: 50px;" >
    		 <div class="wrap2">
			    	<?php 
			    		
			    if (count($imagencomprobante)>0) {

			    	for ($k=0; $k <count($imagencomprobante) ; $k++) { 
			    			$rutaimg=$servidor.$rutacomprobante.$imagencomprobante[$k]->rutacomprobante;
			    			
			    			 ?>
			    		<!-- <a href="<?php echo $rutaimg; ?>"><img WIDTH=40 HEIGHT=100  src="<?echo $rutaimg;?>" alt=""></a> -->

			    		

			    		     <a href="<?php echo $rutaimg; ?>"><?echo $imagencomprobante[$k]->rutacomprobante;?></a>


			    		<?php	
				    	}
				    }


			    	 ?>
			    	 </div>
			    </td>
			    <td style="text-align: center;">
			    	<?php echo $idtransaccion; ?>
			    </td>
			     <td style="text-align: right;">$ <?php echo number_format($suma,2); ?></td>
			   <td style="text-align: right;">$ <?php echo number_format($montodescontado,2); ?></td>
			   <td style="text-align: right;">$ <?php echo number_format($costofinal,2); ?></td>

			    <td style="text-align: right;">$ <?php echo number_format($ivacompra,2); ?></td>

			     <td style="text-align: right;">$ <?php echo number_format($comisiontotal,2); ?></td>

				<td style="text-align: right;">$ <?php echo number_format($total,2); ?></td>
			</tr>
			
			<?php
				}while($result_clientes_row = $db->fetch_assoc($result_clientes));
			}
			?>

			<tr>
				<td colspan="14" style="text-align: right; font-weight: bold">TOTAL</td>
				<td style="text-align: right; font-weight: bold">$ 
					<?php echo number_format($total_gral,2); ?>
				</td>
					
			</tr>
	</tbody>
</table>


<?php 




 ?>

  