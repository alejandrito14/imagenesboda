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
	nr.fechapedido
	FROM
	nota_remision AS nr
	INNER JOIN sucursales e ON e.idsucursales = nr.idsucursales
	INNER JOIN clientes c ON c.idcliente=nr.idcliente
	
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
 
<table border="1" cellspacing="1" cellpadding="5" style="overflow: auto">
	<thead class="thead-dark">
		<tr bgcolor="#3B3B3B" style="color: #FFFFFF; text-align: center;">
			
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
			<tr onClick="f_toogle('<?php echo $idfila; ?>');" style="cursor: pointer;">
			    <td style="text-align: center; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['sucursal'])); ?></td>
			     <td style="text-align: center; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['folio'])); ?></td>
			      <td style="text-align: center; "><?php echo mb_strtoupper(date('d-m-Y H:i:s',strtotime($result_clientes_row['fechapedido']))); ?></td>
			    <td style="text-align: center;"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['nombre_cliente'])); ?></td>
			   <!--  <td style="text-align: center; mso-number-format:'@' "><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row['total'])); ?></td> -->
				<td style="text-align: right;">$ <?php echo number_format($result_clientes_row['total'],2); ?></td>
			</tr>
			<!-- EMPIEZA LA SEGUNDA TABLA-->
			<tr id="<?php echo $idfila; ?>" style="background-color: #fff; display: none;">
    						<th colspan="4" align="center" style="text-align: center; color: #000;" >

    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    								<tbody>
    									<tr style="background-color: #b3afaf; font-weight: bold">
    										<td colspan="4">DETALLE DE LAS VENTAS POR CLIENTES</td>
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
										nota_remision.fechapedido,
										nota_remision.idusuarios,
										nota_remision.total
										FROM
										nota_remision
										WHERE
										nota_remision.idsucursales = '".$result_clientes_row['idsucursales']."' AND
										nota_remision.idcliente = '".$result_clientes_row['idcliente']."'
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
	    									{ ?>

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


<?php 




 ?>

  