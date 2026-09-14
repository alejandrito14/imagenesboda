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
$idproducto = $_GET['v_idproductos'];

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

if($idproducto!=0)
{
	$qry_id_producto ="AND nrd.idproducto='$idproducto' ";
}
else {  $qry_id_producto =""; } 

	$qry_ventas_productos = "SELECT
nrd.idnota_remision_descripcion,
nrd.idproducto,
nrd.idnota_remision,
nrd.idempresas,
nrd.presentacion,
nrd.nombre,
nrd.descripcion,
nrd.cantidad,
nrd.pv, e.empresas
FROM
nota_remision_descripcion AS nrd
INNER JOIN empresas e ON e.idempresas=nrd.idempresas
WHERE
nrd.idempresas = '".$idempresa."'
$qry_id_producto
GROUP BY
nrd.idproducto
ORDER BY
nrd.idproducto ASC ";

//echo $qry_ventas_productos;
			
	     $result_clientes = $db->consulta($qry_ventas_productos);
	     $result_clientes_row = $db->fetch_assoc($result_clientes);
		 $result_clientes_num = $db->num_rows($result_clientes);	

		 $total_gral=0;


?>
  <h3>EMPRESA: <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['empresas']));?></h3>	
  <div class="form-group col-md-12" style="text-align: right">
	
	<a class="btn btn-primary" title="Reporte en Excel" onClick="rpt_excel_vtas_productos();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>REPORTE EXCEL</a>		

	</div>				

<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead class="thead-dark">
		<tr style="text-align: center">
			<th>NUM</th> 
			<th>ID PRODUCTO</th>
			<th>PRESENTACIÓN</th>
			<th>NOMBRE</th>
			<th>TOTAL</th>
			<th>REPORTE</th> 			
		</tr>
	</thead>

	<tbody>
			<?php
			if($result_clientes_num == 0){
			?>
			<tr> 
				<td colspan="6" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN DATOS EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				
				$num=0;
				do
				{
					// ciclo de los clientes
					
					$sql_totcli="SELECT 
					nrd.idproducto,
					SUM(total) AS total
					FROM nota_remision AS nr
					INNER JOIN nota_remision_descripcion nrd ON nr.idnota_remision=nrd.idnota_remision AND nrd.idempresas='".$idempresa."'
					WHERE nr.idempresas='".$idempresa."'
					AND nrd.idproducto='".$result_clientes_row['idproducto']."'
					AND DATE(nr.fechapedido) >= DATE('$fecha_inicial') AND DATE(nr.fechapedido) <= DATE('$fecha_final') ";

					$result_totcli = $db->consulta($sql_totcli);					
					$result_totcli_row = $db->fetch_assoc($result_totcli);
		 			$result_totcli_num = $db->num_rows($result_totcli);	 	

		 			//echo "<br>".$sql_totcli;	

		 			$total = $result_totcli_row['total'];

		 			if($total==0)
		 			{
		 				continue;
		 			}
					$num++;

		 			$total_gral = $total_gral + $total;

		 			$idfila =  $idempresa.$result_clientes_row['idproducto'];

			?>
			<tr onClick="f_toogle('<?php echo $idfila; ?>');" style="cursor: pointer;">
			    <td style="text-align: center;"><?php echo $num; ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['idproducto'])); ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['presentacion'])); ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['nombre'])); ?></td>
				<td style="text-align: right;">$ <?php echo number_format($total,2); ?></td>
				
				<td style="text-align: center; font-size: 15px;">                               

					<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" onClick="rpt_excel_vtas_productos_id('<?php echo $result_clientes_row['idempresas']; ?>','<?php echo $result_clientes_row['idproducto']; ?>');" ></i>		

				</td>		
							
			</tr>
			<!-- EMPIEZA LA SEGUNDA TABLA-->

				<tr id="<?php echo $idfila; ?>" style="background-color: #fff; display: none;">
    						<th colspan="6" align="center" style="text-align: center; color: #000;" >

    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    								<tbody>
    									<tr style="background-color: #b3afaf; font-weight: bold">
    										<td colspan="6">DETALLE DE LAS VENTAS POR PRODUCTOS</td>
    									</tr>   
    									<tr style="background-color: #DCDADA; font-weight: bold">
    										<td align="center" >ID NOTA</td>
    										<td align="center" >FECHA</td>
    										<td align="center" >CANTIDAD</td>
    										<td align="center" >PV</td>
    										<td align="center" >TOTAL</td>
    									</tr>

    									<?php

    									//CONSULTA DE LAS SALIDAS CON DETALLES SEGUN EMPRESA, SUCURSAL E ID INSUMO, FILTRO FECHA ETC.

    									$qry_salida_detalles = " SELECT
											nr.fechapedido, nr.total,
											nrd.*											
											FROM
											nota_remision_descripcion AS nrd	
											INNER JOIN nota_remision nr ON nr.idnota_remision=nrd.idnota_remision
											WHERE nrd.idempresas = '".$idempresa."'
											AND nrd.idproducto = '".$result_clientes_row['idproducto']."'
											AND DATE(nr.fechapedido) >= DATE('$fecha_inicial') AND DATE(nr.fechapedido) <= DATE('$fecha_final') "; 

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
                                                //echo "<br>pv: ".$result_salida_detalles_row['pv'];
                                                //echo "<br>cantidad: ".$result_salida_detalles_row['cantidad'];
                                                $pv=($result_salida_detalles_row['pv']/$result_salida_detalles_row['cantidad']);
	    									?>
	    									<tr style="color: #000;">
	    										<td><?php echo $result_salida_detalles_row['idnota_remision']; ?></td> 
	    										<td><?php echo $fecha; ?></td> 
	    										<td align="right"><?php echo $result_salida_detalles_row['cantidad']; ?></td>   										
	    										<td align="right"><?php echo number_format($pv,2); ?></td>
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
    										<td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
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
				<td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
				<td style="text-align: right; font-weight: bold">$ 
					<?php echo number_format($total_gral,2); ?>
				</td>
				<td></td>	
			</tr>
	</tbody>
</table>




