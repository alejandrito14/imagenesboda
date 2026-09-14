<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";
	exit;
}

$idmenumodulo = $_GET['idmenumodulo'];

//validaciones para todo el sistema

$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//validaciones para todo el sistema
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../../../clases/conexcion.php");
require_once("../../../../clases/class.Empresas.php");
require_once("../../../../clases/class.Funciones.php");
require_once("../../../../clases/class.Inventario.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Empresas();
$f = new Funciones();
$inven=new Inventario();

$emp->db = $db;
$inven->db=$db;

//Declaración de variables
$t_estatus = array('Desactivado','Activado');

$t_tipo = array('VENTAS','PRODUCTO FALLA','CADUCADO','MUESTRAS','RETENCI&Oacute;N','DONACI&Oacute;N','REPOSICI&Oacute;N','TRASPASO','CREACI&Oacute;N DE PRODUCTO','OTRAS');

//0 - ventas \n 1 - producto falla \n 2 - caducado\n. 3 - Muestras 4- Retención 5 - Donación 6 - Reposición 7 - Traspaso 8- Creación de Producto 9 - otras

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

//OBTENEMOS DOS VALORES IMPORATNTS PARA PODER REALIZAR LA CONSULTA ID MPERESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

$idempresa = $_GET['v_idempresa'] ;
$idsucursal1 = $_GET['v_idsucursales'] ;
$idinsumo = $_GET['v_idinsumos'] ;
$idtipo= $_GET['v_idtipo'] ;
$fechaInicial = $_GET['v_fecha_inicial'];
$fechaFinal = $_GET['v_fecha_final'];
$lote = $_GET['v_lote'];

// echo "<br>Fecha inicial: ".$fechaInicial;
// echo "<br>Fecha final: ".$fechaFinal;

?>

<div class="row">
	
	<div class="col-md-12"> 
        <br>
    
		<div style="text-align: right">	
			<a class="btn btn-primary" title="Reporte" onClick="rpt_excel_salidas_gral();" style="margin-top: 5px; color: #ffffff">
				<i class="mdi mdi-account-search"></i>  REPORTE EXCEL
			</a>	
		</div>	
	
		<?php
	$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
    $lista_empresas = $_SESSION['se_liempresas']; //variables de sesion	

    if($tipousaurio != 0)
    {
    	if($idempresa == 0)
    	{
    		$id_empresa ="AND idempresas IN ($lista_empresas)" ;
    	}else
    	{
    		$id_empresa = "AND idempresas IN ($idempresa)";
    	}
    }else
    {
    	if($idempresa == 0)
    	{
    		$id_empresa =" " ;
    	}else
    	{
    		$id_empresa = "AND idempresas IN ($idempresa)";
    	}
    }

    if(!empty($lote))
    {
        $qry_id_lote =" AND sd.lote='$lote' ";
    }
    else {  echo $qry_id_lote=""; } 

    $sql_empresas = " SELECT *  FROM empresas WHERE 1=1 $id_empresa ORDER BY idempresas";

    $sql_empresas_result = $db->consulta($sql_empresas);
    $sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
    $sql_empresas_num = $db->num_rows($sql_empresas_result);

    do{

    	?>	

    	<h3><?php echo $sql_empresas_row['empresas'];?></h3>

    	<?php

        //VAMOS A OBTENER EL VALOR DE LA SUCURSAL O DE TODAS LAS SUCURSALES DE ESA EMRPESA

    	if($idsucursal1!=0)
    	{
    		$id_sucursal = " AND idsucursales = $idsucursal1";
    	}
    	else
    	{
    		$id_sucursal = " ";
    	}

    	$idempresa_ciclo = $sql_empresas_row['idempresas'];
    	$sql_sucursales = "SELECT
    	s.idsucursales,
    	s.sucursal					
    	FROM
    	sucursales s
    	WHERE
    	s.idempresas = '$idempresa_ciclo' $id_sucursal";

    	$result_sucursales = $db->consulta($sql_sucursales);
    	$result_sucursales_row = $db->fetch_assoc($result_sucursales);

    	do
    	{		

    		?>
    		<h5>SUCURSAL: <?php echo $result_sucursales_row['sucursal'];?></h5>

    		<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="overflow: auto" id="tbl_inventario">
    			<thead class="thead-dark">
    				<tr>
    					<th align="center" scope="col" style="text-align: center">COD INSUMO.</th>
    					<th align="center" scope="col" style="text-align: center">NOMBRE DEL INSUMO</th>
    					<th align="center" valign="middle" scope="col" style="text-align: center">EXISTENCIA EN BODEGA</th>
    					<th align="center" valign="middle" scope="col" style="text-align: center">TOTAL SALIDAS</th>
    					<th align="center" valign="middle" scope="col" style="text-align: center">REPORTE</th>
    				</tr>
    			</thead>
    			<tbody>	
    				<?php

    				$idsucursal_ciclo = $result_sucursales_row ['idsucursales'];
    				//echo "id empresa ".$idempresa_ciclo. "<br>";	
    				//echo "id sucursal ".$idsucursal_ciclo. "<br>";

    				if(!empty($idinsumo))
    				{
    					$id_insumo = " AND inv.idinsumos= '$idinsumo' ";
    				}
    				else
    				{
    					$id_insumo = " ";
    				}		

    				// CONSULTA DE INVENTARIOS 
    				$qry_inventario="SELECT inv.*, i.nombre, tm.nombre as medida FROM inventario inv LEFT JOIN insumos i ON i.idinsumos = inv.idinsumos AND i.idempresas = '".$idempresa_ciclo."' LEFT JOIN tipo_medida tm ON tm.idtipo_medida = i.idtipo_medida 
						WHERE inv.idempresas = '".$idempresa_ciclo."' AND inv.idsucursales = '".$idsucursal_ciclo."' $id_insumo ";
    				
    				$result_inventario = $db->consulta($qry_inventario);
    				$result_inventario_row = $db->fetch_assoc($result_inventario);
    				$result_inventario_num = $db->num_rows($result_inventario);

    				//echo $qry_inventario;
    				$i=0;
    				do{
    					$i++;
    					if($result_inventario_num==0)
    					{
						?>
    						<tr>
    							<th colspan="5" style="text-align: center; font-weight: bold;" scope="row">NO EXISTEN INSUMOS EN INVENTARIO</th>
    						</tr>
						<?php
    					}
    					else
    					{
    						$existencia_bodega = $result_inventario_row['entradafisica']-$result_inventario_row['entradasalida'];
    						$medida = $f->imprimir_cadena_utf8($result_inventario_row['medida']);

    						//CONSULTA SOLO DE LA SUMA DE SALIDAS DE SALIDAS POR ID DE INSUMOS
	    						$qry_sum_salidas = "SELECT
	    						salidas.idsalidas,
	    						salidas.idempresas,
	    						salidas.idsucursales,
	    						salidas.idsalidas,
	    						salidas_detalles.idinsumos,
	    						SUM(salidas_detalles.total) as total
	    						FROM
	    						salidas
	    						INNER JOIN salidas_detalles ON salidas_detalles.idsalidas = salidas.idsalidas
	    						WHERE
	    						salidas.idempresas = '".$idempresa_ciclo."' AND
	    						salidas.idsucursales = '".$idsucursal_ciclo."' AND
	    						salidas_detalles.idinsumos = '".$result_inventario_row['idinsumos']."' ";

	    						$result_salidas = $db->consulta($qry_sum_salidas);
	    						$result_salidas_row = $db->fetch_assoc($result_salidas);

	    						$idfila =  $idsucursal_ciclo.$result_salidas_row['idinsumos'].$i;
	    						//echo "<br>id fila: ".$idfila;


                                // consulta de segundo nivel

                                // FILTRO TIPO
                                        if($idtipo!='X')
                                        {
                                            $id_tipo= " AND s.tipo = '$idtipo' ";
                                        }
                                        else
                                        {
                                            $id_tipo = " ";
                                        }   

                                        //CONSULTA DE LAS SALIDAS CON DETALLES SEGUN EMPRESA, SUCURSAL E ID INSUMO, FILTRO FECHA ETC.
                                        $qry_salida_detalles = " SELECT 
                                        sd.idsalidas_detalles,
                                        s.*,
                                        sd.idinsumos, sd.nombre, sd.lote, sd.cantidad, sd.total, sd.idtipo_medida,
                                        tm.nombre AS nombre_medida,
                                        CONCAT(usr.nombre,' ',usr.paterno,' ',usr.materno) AS nombre_usuario 
                                        FROM salidas AS s
                                        INNER JOIN salidas_detalles sd ON sd.idsalidas = s.idsalidas
                                        INNER JOIN usuarios usr ON usr.idusuarios = s.idusuarios
                                        INNER JOIN tipo_medida tm ON tm.idtipo_medida = sd.idtipo_medida
                                        WHERE sd.idinsumos = '".$result_inventario_row['idinsumos']."' AND s.idempresas = '".$idempresa_ciclo."' AND s.idsucursales = '".$idsucursal_ciclo."'
                                        AND DATE(s.fecha) >= DATE('$fechaInicial') AND DATE(s.fecha) <= DATE('$fechaFinal') $id_tipo $qry_id_lote ";

                                        //echo "<br><br>".$qry_salida_detalles;

                                        $result_salida_detalles = $db->consulta($qry_salida_detalles);
                                        $result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles);
                                        $result_salida_detalles_num = $db->num_rows($result_salida_detalles);
                                        $total=0;

                                        if($result_salida_detalles_num==0)
                                        {
                                            continue;
                                        }

                                        // termina consulta de segundo nivel

    					?>	
    					<tr onClick="f_toogle('<?php echo $idfila; ?>');"  style="cursor: pointer;">
    						<th align="center" scope="row" style="text-align: center"><?php echo $result_inventario_row['idinsumos']; ?></th>
    						<td align="center"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_inventario_row['nombre'])); ?></td>
    						<td align="right"><?php echo number_format($existencia_bodega,2).' '. $medida; ?></td>
    						<td align="right"><?php echo number_format($result_salidas_row['total'],2).' '. $medida; ?></td>
    						<td style="text-align: center; font-size: 15px;" width="80">
    							<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" title="REPORTE DE SALIDAS" onclick="rpt_excel_salidas('<?php echo $idempresa_ciclo; ?>','<?php echo $idsucursal_ciclo; ?>','<?php echo $result_salidas_row['idinsumos']; ?>')" ></i>
    						</td>
    					</tr>

    					<tr id="<?php echo $idfila; ?>" style="background-color: #fff; display: none;">
    						<th colspan="8" align="center" style="text-align: center; color: #000;" >

    							<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    								<tbody>
    									<tr style="background-color: #b3afaf; font-weight: bold">
    										<td colspan="8">DETALLE DE SALIDA</td>
    									</tr>   
    									<tr style="background-color: #DCDADA; font-weight: bold">
    										<td align="center" >ID SALIDA</td>
    										<td align="center" >FECHA DE SALIDA</td>
    										<td align="center" >USUARIO</td>
    										<td align="center" >TIPO</td> 
    										<td align="center" >NUM. DOCTO</td>
    										<td align="center" >LOTE</td>
    										<td align="center" >CANTIDAD</td>
    										<td align="center" >TOTAL</td>
    									</tr>

    									<?php
    									// aqui va consulta de segundo nivel

	    								do{

	    									if($result_salida_detalles_num==0)
	    									{
	    										?>
	    										<tr> 
	    											<td colspan="8" style="text-align: center; ">
	    												<h5 class="alert_warning">NO EXISTEN DETALLES DE SALIDAS.</h5>
	    											</td>
	    										</tr>
	    										<?php
	    									}
	    									else
	    									{
                                                $fecha= date("d-m-Y H:i:s",strtotime($result_salida_detalles_row['fecha']));
	    									?>
	    									<tr style="color: #000;">
	    										<td><?php echo $result_salida_detalles_row['idsalidas']; ?></td> 
	    										<td><?php echo $fecha; ?></td>
	    										<td><?php echo $f->imprimir_cadena_utf8($f->mayus($result_salida_detalles_row['nombre_usuario'])); ?></td>
	    										<td><?php echo $t_tipo[$result_salida_detalles_row['tipo']]; ?></td> 
	    										<td><?php echo $result_salida_detalles_row['nodocto']; ?></td>
	    										<td><?php echo $result_salida_detalles_row['lote']; ?></td>
	    										<td align="right"><?php echo number_format($result_salida_detalles_row['cantidad']); ?></td>
	    										<td align="right"><?php echo number_format($result_salida_detalles_row['total'],2)." ".$result_salida_detalles_row['nombre_medida']; 
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
    										<td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
    										<td style="text-align: right; font-weight: bold">
    											<?php echo number_format($total,2)." " .$result_inventario_row['medida']; ?>
    										</td>	
    									</tr>

    								</tbody>
    							</table>
    						</th>
    					</tr>
    					<?php
    					}
    					?>

    					<?php
    				}while($result_inventario_row = $db->fetch_assoc($result_inventario)); //terminamos el while del inventario por empresa y por sucursal
    				?>

    			</tbody>
    		</table>

    		<?php
	   }while($result_sucursales_row = $db->fetch_assoc($result_sucursales)); //terminamos el while de sucursales por empresa

	}while($sql_empresas_row = $db->fetch_assoc($sql_empresas_result));	 //terminamos el while de mpersas.
	?>	

</div>

</div>

