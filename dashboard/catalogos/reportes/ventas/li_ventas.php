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

$idmenumodulo = $_GET['idmenumodulo'];

//validaciones para todo el sistema
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

$idempresa = $_GET['v_idempresa'] ;
$fecha_inicial = $_GET['v_fecha_inicial'];
$fecha_final = $_GET['v_fecha_final'];
$nombre = $_GET['v_nombre'];

$db = new MySQL();
$rpt = new Reportes();
$bt = new Botones_permisos();
$f = new Funciones();

$rpt->db = $db;

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}

//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
date_default_timezone_set("America/Mexico_City");
$fecha_hoy = new DateTime();
$fecha_hoy = date_format($fecha_hoy, 'd-m-Y H:i:s');
//echo "<br>Fecha hoy.- ".$fecha_hoy;

if($tipousaurio != 0)
	{
		if($idempresa == 0)
		{
			$id_empresa ="AND nr.idempresas IN ($lista_empresas)" ;
		}else
		{
			$id_empresa = "AND nr.idempresas IN ($idempresa)";
		}
	}else
	{
		if($idempresa == 0)
		{
			$id_empresa =" " ;
		}else
		{
			$id_empresa = "AND nr.idempresas IN ($idempresa)";
		}
	}
	
	$sql_sucursales = "SELECT
nr.idempresas,
nr.no_cliente,
CONCAT(c.nombre,' ',c.paterno,' ',c.materno) AS nombre_cliente, e.empresas, c.folio_adminpack 
FROM
nota_remision AS nr
INNER JOIN clientes c ON c.no_cliente = nr.no_cliente AND c.idempresas = '".$idempresa."'
INNER JOIN empresas e ON e.idempresas = nr.idempresas
WHERE
nr.idempresas = '".$idempresa."'
AND CONCAT(c.nombre,' ',c.paterno,' ',c.materno) LIKE '%$nombre%'
GROUP BY
nr.no_cliente
ORDER BY
nr.no_cliente ASC  ";

//echo $sql_sucursales;
			
	     $result_clientes = $db->consulta($sql_sucursales);
	     $result_clientes_row = $db->fetch_assoc($result_clientes);
		 $result_clientes_num = $db->num_rows($result_clientes);	
		 $total_gral=0;

?>
  <h3>EMPRESA: <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['empresas']));?></h3>	
  <div class="form-group col-md-12" style="text-align: right">
	
	<a class="btn btn-primary" title="Reporte en Excel" onClick="rpt_excel_vtas_cliente();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>REPORTE EXCEL</a>		

	</div>				

<table class="table table-striped table-bordered" id="tbl_clientes" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead class="thead-dark">
		<tr style="text-align: center">
			<th>NUM CLIENTE</th>
			<th>NOMBRE</th>
			<th>FOLIO ADMIN PACK</th> 
			<th>TOTAL</th>
			<th>REPORTE</th> 			
		</tr>
	</thead>

	<tbody>
			<?php
			if($result_clientes_num == 0){
			?>
			<tr> 
				<td colspan="5" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN DATOS EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				
				$num=0;
				do
				{
					$num++;
					// ciclo de los clientes
					$sql_totcli="SELECT SUM(total) AS total
										FROM
										nota_remision
										WHERE
										nota_remision.no_cliente = '".$result_clientes_row['no_cliente']."'
										AND nota_remision.idempresas = '".$idempresa."' 
										AND DATE(nota_remision.fechapedido) >= DATE('$fecha_inicial') AND DATE(nota_remision.fechapedido) <= DATE('$fecha_final') ";
										//echo $sql_totcli;

					$result_totcli = $db->consulta($sql_totcli);					
					$result_totcli_row = $db->fetch_assoc($result_totcli);
		 			$result_totcli_num = $db->num_rows($result_totcli);	 

		 			if($result_totcli_row['total']==0)
		 			{
		 				continue;
		 			}	

		 			//echo "<br>".$sql_total_cliente;

		 			$total = $result_totcli_row['total'];

		 			$total_gral = $total_gral + $total;

		 			$idfila =  $idempresa.$result_clientes_row['no_cliente'];

			?>
			<tr onClick="f_toogle('<?php echo $idfila; ?>');" style="cursor: pointer;">
			   
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['no_cliente'])); ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['nombre_cliente'])); ?></td>
				<td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['folio_adminpack'])); ?></td>
				<td style="text-align: right;">$ <?php echo number_format($total,2); ?></td>
				<td style="text-align: center; font-size: 15px;">                               

					<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" onClick="rpt_excel_ventas_cliente_id('<?php echo $result_clientes_row['idempresas']; ?>','<?php echo $result_clientes_row['no_cliente']; ?>');" ></i>		

				</td>		
							
			</tr>
			<!-- EMPIEZA LA SEGUNDA TABLA-->

				<tr id="<?php echo $idfila; ?>" style="background-color: #fff; display: none;">
    						<th colspan="5" align="center" style="text-align: center; color: #000;" >

    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    								<tbody>
    									<tr style="background-color: #b3afaf; font-weight: bold">
    										<td colspan="5">DETALLE DE LAS VENTAS POR CLIENTES</td>
    									</tr>   
    									<tr style="background-color: #DCDADA; font-weight: bold">
    										<td align="center" >ID NOTA</td>
    										<td align="center" >FECHA</td>
    										<td align="center" >TOTAL</td>
    									</tr>

    									<?php

    									//CONSULTA DE LAS SALIDAS CON DETALLES SEGUN EMPRESA, SUCURSAL E ID INSUMO, FILTRO FECHA ETC.

    									$qry_salida_detalles = " SELECT
										nota_remision.idnota_remision,
										nota_remision.idempresas,
										nota_remision.fechapedido,
										nota_remision.no_cliente,
										nota_remision.idusuarios,
										nota_remision.total
										FROM
										nota_remision
										WHERE
										nota_remision.idempresas = '".$idempresa."' AND
										nota_remision.no_cliente = '".$result_clientes_row['no_cliente']."'
										AND DATE(nota_remision.fechapedido) >= DATE('$fecha_inicial') AND DATE(nota_remision.fechapedido) <= DATE('$fecha_final') 
										ORDER BY
										nota_remision.fechapedido ASC ";

    									//echo $qry_salida_detalles;

    									$result_salida_detalles = $db->consulta($qry_salida_detalles);
	    								$result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles);
	    								$result_salida_detalles_num = $db->num_rows($result_salida_detalles);
	    								$total=0;
										
	    								do{

	    									if($result_salida_detalles_num==0)
	    									{

	    								?>
	    										<tr> 
	    											<td colspan="4" style="text-align: center; ">
	    												<h5 class="alert_warning">NO EXISTEN DATOS CON ESOS FILTROS.</h5>
	    											</td>
	    										</tr>
	    										<?php
	    									}
	    									else
	    									{
                                                $fecha= date("d-m-Y H:i:s",strtotime($result_salida_detalles_row['fechapedido']));
	    									?>
	    									<tr style="color: #000;">
	    										<td><?php echo $result_salida_detalles_row['idnota_remision']; ?></td> 
	    										<td><?php echo $fecha; ?></td>
	    										<td align="right"><?php echo number_format($result_salida_detalles_row['total'],2); 
	    										$total=$total + $result_salida_detalles_row['total']; 
	    										?></td>
	    									</tr> 
	    									<?php
	    									} // else 

	    									?>

    									<?php
    									}while($result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles)); //terminamos el while de las salidas con detalles por id insumos etc..
    									?>

    									<tr>
    										<td colspan="2" style="text-align: right; font-weight: bold">TOTAL</td>
    										<td style="text-align: right; font-weight: bold">$ 
    											<?php echo number_format($total,2); ?>
    										</td>	
    									</tr>

    								</tbody>
    							</table>
    						</th>
    					</tr>

			<!-- TERMINA LA SEGUNDA TABLA-->

			<?php
				}while($result_clientes_row = $db->fetch_assoc($result_clientes));
			}
			?>

			<tr>
				<td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
				<td style="text-align: right; font-weight: bold">$ 
					<?php echo number_format($total_gral,2); ?>
				</td>
				<td></td>	
			</tr>
	</tbody>
</table>




