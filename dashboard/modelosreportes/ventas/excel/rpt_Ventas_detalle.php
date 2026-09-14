<?PHP

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

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

//validaciones para todo el sistema
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

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
	nr.idcliente,
	nr.folio,
	nr.fechapedido,
	nr.idnota_remision
	FROM
	nota_remision AS nr
	INNER JOIN sucursales e ON e.idsucursales = nr.idsucursales
	INNER JOIN clientes c ON c.idcliente=nr.idcliente
	
	WHERE ".$sql."
	 AND nr.fechapedido BETWEEN '".$fecha_inicial."'  AND '".$fecha_final."'
	ORDER BY
	e.sucursal,nr.idnota_remision ASC  ";

	     $result_clientes = $db->consulta($sql_sucursales);
	     $result_clientes_row = $db->fetch_assoc($result_clientes);
		 $result_clientes_num = $db->num_rows($result_clientes);	
		 $total_gral=0;

$fecha_inicial = date('d-m-Y',strtotime($_GET['fechainicio']));
$fecha_final = date('d-m-Y',strtotime($_GET['fechafin']));

$filename = "rpt_Ventas_detalle-".$lista_empresas.'-'.$fecha_inicial.' '.$horainicio."-".$fecha_final.' '.$horafin.".xls";
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header('Content-Disposition: attachment; filename="'.$filename.'"');


?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- <h3>EMPRESA: <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['empresas']));?></h3>	 -->
 
<table border="1" cellspacing="1" cellpadding="5" style="overflow: auto">
	<thead class="thead-dark">
		<tr bgcolor="#3B3B3B" style="color: #FFFFFF; text-align: left;">
			
			<th>SUCURSAL</th>
			<th>FOLIO</th>
			<th>FECHA DE PEDIDO</th>

			<th>CLIENTE</th>
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
					
					$total_gral=$total_gral+$result_clientes_row['total'];

			?>
			<tr onClick="f_toogle('<?php echo $idfila; ?>');" style="cursor: pointer;background-color: #b3afaf;">
			    <td style="text-align: left; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['sucursal'])); ?></td>
			     <td style="text-align: left; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['folio'])); ?></td>
			      <td style="text-align: left; "><?php echo mb_strtoupper(date('d-m-Y H:i:s',strtotime($result_clientes_row['fechapedido']))); ?></td>
			    <td style="text-align: left;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['nombre_cliente'])); ?></td>
			   <!--  <td style="text-align: left; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['total'])); ?></td> -->
				<td style="text-align: right;">$ <?php echo number_format($result_clientes_row['total'],2); ?></td>
			</tr>
			<!-- EMPIEZA LA SEGUNDA TABLA-->
			<tr id="<?php echo $idfila; ?>" style="background-color: #fff;">
    						<th colspan="4"  style="text-align: left; color: #000;" >

    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    								<tbody>
    									   
    									<tr style=" font-weight: bold">
    					    				<td colspan="2"  >NO.</td>

    										<td  colspan="2" >PAQUETE</td>
    										<td  colspan="2">CANTIDAD</td>
    										<!-- <td >PRODUCTOS</td>
    										<td >COMPLEMENTOS</td>
    										<td  >TOTAL</td> -->
    									</tr>

    									<?php

    									//CONSULTA DE LAS SALIDAS CON DETALLES SEGUN EMPRESA, SUCURSAL E ID INSUMO, FILTRO FECHA ETC.

    									$qry_salida_detalles = " SELECT
										nota_remision_descripcion.idnota_remision,
										nota_remision_descripcion.idnota_remision_descripcion,
										nota_remision_descripcion.idsucursal,
										nota_remision_descripcion.nombre,
										nota_remision_descripcion.presentacion,
										nota_remision_descripcion.descripcion,
										nota_remision_descripcion.cantidad,
										nota_remision_descripcion.precio,
										nota_remision_descripcion.complementos,
										nota_remision_descripcion.promocion,
										nota_remision_descripcion.cantidadpromo,
										nota_remision_descripcion.considerar,
										nota_remision_descripcion.porfechas,
										nota_remision_descripcion.directo,
										nota_remision_descripcion.repetitivo,
										nota_remision_descripcion.idpaquete,
										nota_remision_descripcion.preciooriginal,
										nota_remision_descripcion.productos,
										nota_remision_descripcion.comentario
										FROM
										nota_remision_descripcion WHERE nota_remision_descripcion.idnota_remision=".$result_clientes_row['idnota_remision']."";




    									$result_salida_detalles = $db->consulta($qry_salida_detalles);
	    								$result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles);
	    								$result_salida_detalles_num = $db->num_rows($result_salida_detalles);
	    								$total=0;
										$contador=1;
	    								do{

	    									if($result_salida_detalles_num==0)
	    									{ ?>

	    								<tr> 
	    											<td colspan="4" style="text-align: left; ">
	    												<h5 class="alert_warning">NO EXISTEN DATOS CON ESOS FILTROS.</h5>
	    											</td>
	    										</tr>
	    										<?php
	    									}
	    									else
	    									{/*
                                                $fecha= date("d-m-Y H:i:s",strtotime($result_salida_detalles_row['fechapedido']));*/
                                         
                                            $concatenar="";
                                            $imprimir=1;
                                         	 $descripcion=explode(',',$result_salida_detalles_row['productos']);

							         for ($i=0; $i <count($descripcion)-1; $i++) {   
							                        
							             $dividir=explode('|',$descripcion[$i]);
							             $nombreproducto=$dividir[1];
							             $concatenar=$concatenar.' '.$nombreproducto.'<br>';


							                    }

							         $concatenarcomple="";
							         $conprecio="";
							         $sinprecio="";
							         if ($result_salida_detalles_row['complementos']!=''){ ?>
                                
                          
                            

                                        <?php 

                                       $complementos=explode(',', $result_salida_detalles_row['complementos']);


                                       for ($i=0; $i <count($complementos)-1 ; $i++) { 

                                            $opcion=explode('|', $complementos[$i]);

                                            $dato=$opcion[1];

                                                $text = $dato;
                                                $encontrado=0;

                                           //  $concatenarcomple=$concatenarcomple.$text.'<br>';


                                         for($c = 0; $c < strlen($text); $c++){  
                                                $caracter = $text[$c];
                                              
                                              if ($caracter=='$') {
                                                  $encontrado=1;
                                              }
                                                
                                            }

                                            if ($encontrado==1) {
                                                
                                                $dato=explode('$',$opcion[1]);
                                                $conprecio=$conprecio.$text.'<br>';
                                            }else{

                                            	$sinprecio=$sinprecio.$text.'<br>';
                                            }

                                            $concatenarcomple=$conprecio.$sinprecio;

                                            $multiple=$opcion[2];
                                            $sincoprecio=$opcion[3];
                                            $llevacantidad="";

                                        /* if ($sincoprecio==1) {
                                             $llevacantidad=$producto->cantidad;
                                            }

                                         if ($sincoprecio==0) {
                                             $llevacantidad="";
                                            }


                                            if ($multiple==1 && $sincoprecio==0) {
                                               $llevacantidad=$producto->cantidad;
                                            }*/

                                         


                                            }
                                        }

	    									?>
	    									<tr style="color: #000;background-color: #DCDADA; ">
	    										<td style="text-align: left;" colspan="2"><?php echo $contador; ?></td> 
	    										<td colspan="2" style="text-align: left;" ><?php echo $result_salida_detalles_row['nombre']; ?></td> 
	    										<td colspan="2" style="text-align: left;" ><?php echo $result_salida_detalles_row['cantidad']; ?></td>
	    										

	    							

	    									</tr> 


	    									<tr id="<?php echo $idfila; ?>" style="background-color: #fff;">
				    						<th colspan="4"  style="text-align: left; color: #000;" >

				    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
				    								<tbody>
								    					<tr style=" font-weight: bold;">
								    						<td style="text-align: left;" rowspan="2"  colspan="2"></td>
				    										<td style="text-align: left;border: 1px solid ;" rowspan="2"  colspan="2">PRODUCTOS</td>
				    										<td rowspan="2" colspan="2" style="text-align: left;border: 1px solid;"><?php echo $concatenar;?></td>
				    									</tr>   
				    								</tbody>
				    							</table>
				    						</th>
				    					</tr>

				    					<tr id="<?php echo $idfila; ?>" style="background-color: #fff;">
				    						<th colspan="4"  style="text-align: left; color: #000;" >

				    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
				    								<tbody>
								    					<tr style=" font-weight: bold">
								    						<td style="text-align: left; rowspan="2"  colspan="2"></td>
				    										<td style="text-align: left;border: 1px solid;" rowspan="2"  colspan="2">COMPLEMENTOS</td>
				    										<td rowspan="2" colspan="2" style="text-align: left;border: 1px solid;"><?php echo $concatenarcomple;?></td>
				    									</tr>   
				    								</tbody>
				    							</table>
				    						</th>
				    					</tr>

	    									<!-- <tr>
												<td rowspan="3">celda 5</td>
												<td rowspan="3">celda 6</td>
												<td rowspan="3" colspan="2">celda 7</td>
											</tr> -->
	    									
	    									<?php
	    									} // else 

	    									$contador++
	    									?>

    									<?php
    									}while($result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles));

    									 //terminamos el while de las salidas con detalles por id insumos etc..
    									?>
<!-- 
    									<tr>
    										<td colspan="2" style="text-align: right; font-weight: bold">TOTAL</td>
    										<td style="text-align: right; font-weight: bold">$ 
    											<?php echo number_format($total,2); ?>
    										</ td>	-->
    									</tr>

    								</tbody>
    							</table>
    						</th>
    					</tr>
	
			<?php
				}while($result_clientes_row = $db->fetch_assoc($result_clientes));
			}
			?>

			<tr>
				<td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
				<td style="text-align: right; font-weight: bold">$ 
					<?php echo number_format($total_gral,2); ?>
				</td>
					
			</tr>
	</tbody>
</table>

