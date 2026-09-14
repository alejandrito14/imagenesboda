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
require_once("../../../../clases/class.Botones.php");
require_once("../../../../clases/class.Inventario.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Empresas();
$f = new Funciones();
$bt = new Botones_permisos();
$inven=new Inventario();

$emp->db = $db;
$inven->db=$db;

//Declaración de variables
$t_estatus = array('Desactivado','Activado');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

//OBTENEMOS DOS VALORES PARA PODER REALIZAR LA CONSULTA ID EMPRESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

$idempresa = $_GET['v_idempresa'] ;
$idsucursal1 = $_GET['v_idsucursales'] ;
$idinsumo = $_GET['v_idinsumos'] ;
$fechaInicial = $_GET['v_fecha_inicial'];
$fechaFinal = $_GET['v_fecha_final'];
$lote = $_GET['v_lote'];
//$fecha_corte = $_GET['v_fecha_corte'];

date_default_timezone_set("America/Mexico_City");

// echo "<br>Fecha inicial: ".$fechaInicial;
// echo "<br>Fecha final: ".$fechaFinal;

?>

<div class="row">
	
	<div class="col-md-12">  
		<div style="text-align: right">	
			<a class="btn btn-primary" title="Reporte" onClick="rpt_excel_existencias_lotes();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
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
    	$qry_id_lote = "AND ed.lote = '$lote' ";
    	$qry_id_lote2 = "AND sd.lote = '$lote' ";
    }
    else { 
    	$qry_id_lote ="";
    	$qry_id_lote2 ="";
     }

/*
     // EN CASO DE USAR SOLO FECHA DE CORTE
     if(!empty($fecha_corte))
     {
        $fecha_inicio = date('2000-01-01');
        $qry_fecha_corte1= " AND e.fecha BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_corte 23:59:59'";
        $qry_fecha_corte2= " AND s.fecha BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_corte 23:59:59'";       
     }
     else
     {
         $qry_fecha_corte1="";
         $qry_fecha_corte2="";
     }
*/

    $sql_empresas = " SELECT *  FROM empresas 
    WHERE 1=1
    $id_empresa
    ORDER BY idempresas";

    $sql_empresas_result = $db->consulta($sql_empresas);
    $sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
    $sql_empresas_num = $db->num_rows($sql_empresas_result);

    do{

    	?>	

    	<h3><?php echo $sql_empresas_row['empresas'];?></h3>

    	<?php

	   //obtenemos la sucursales a buscar	

       //VAMOS A OBTENER EL VALOR DE LA SUCURSAL O DE TODAS LAS SUCURSALES DE ESA EMRPESA

    	if($idsucursal1!=0)
    	{
    		$id_sucursal = " AND idsucursales = $idsucursal1";
    	}
    	else
    	{
    		$id_sucursal = " ";
    	}

    	$idempresas_ciclo = $sql_empresas_row['idempresas'];
    	$sql_sucursales = "SELECT
    	s.idsucursales,
    	s.sucursal					
    	FROM
    	sucursales s
    	WHERE
    	s.idempresas = '$idempresas_ciclo' $id_sucursal";

		//echo $sql_sucursales;

    	$result_sucursales = $db->consulta($sql_sucursales);
    	$result_sucursales_row = $db->fetch_assoc($result_sucursales);

    	do
    	{		

    		?>
    		<h5>SUCURSAL: <?php echo $result_sucursales_row['sucursal'];?></h5>

    		<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="overflow: auto" id="tbl_inventario">
    			<thead class="thead-dark">
    				<tr>
    					<th align="center" scope="col" style="text-align: center">ID INSUMO</th>			  
    					<th align="center" valign="middle" scope="col" style="text-align: center">NOMBRE DEL INSUMO</th>
    					<th align="center" valign="middle" scope="col" style="text-align: center">MEDIDA</th>			  
    				</tr>
    			</thead>
    			<tbody>	
    				<?php
    				$idsucursal_ciclo = $result_sucursales_row ['idsucursales'];	
		           //echo "id insumo: ".$idinsumo. "<br>";

    				if($idsucursal1!=0)
    				{
    					$id_sucursal1 = " AND idsucursales = $idsucursal1";
    				}
    				else
    				{
    					$id_sucursal1 = " ";
    				}

    				if(!empty($idinsumo))
    				{
    					$qry_id_insumo = " AND ed.idinsumos = '$idinsumo' ";
    				}
    				else
    				{
    					$qry_id_insumo = " ";
    				}							

    				$qry_existencias_lotes_idinsumo = " SELECT 
    				e.idempresas,
    				e.idsucursales,
    				ed.*, tm.nombre AS nombre_medida
    				FROM entradas_detalle AS ed
    				INNER JOIN entradas e ON e.identradas=ed.identradas
    				LEFT JOIN tipo_medida tm ON tm.idtipo_medida = ed.idtipo_medida
    				WHERE 1=1 
    				AND e.idempresas = '".$idempresas_ciclo."' 
    				AND e.idsucursales = '".$idsucursal_ciclo."'								
    				$qry_id_insumo	
    				$qry_id_lote                    
    				GROUP BY ed.idinsumos, e.idsucursales
    				ORDER BY ed.idinsumos ASC, e.idempresas ASC, e.idsucursales ASC ";

					//echo $qry_existencias_lotes_idinsumo;

    				$result_inventario = $db->consulta($qry_existencias_lotes_idinsumo);
    				$result_inventario_row = $db->fetch_assoc($result_inventario);
    				$result_inventario_num = $db->num_rows($result_inventario);	

    				if($result_inventario_num != 0)
    				{

    					do
    					{
    						$idfila = $idempresas_ciclo.$idsucursal_ciclo.$result_inventario_row['idinsumos'];
    						$nombre_medida = mb_strtoupper($result_inventario_row['nombre_medida']);

    						?>
    						<tr onClick="f_toogle('<?php echo $idfila; ?>');"  style="cursor: pointer;">
    							<th align="center" width="300" scope="row" style="text-align: center"><?php echo $result_inventario_row['idinsumos']; ?></th>
    							<td align="center"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_inventario_row['nombre']));  ?></td>
    							<td align="center" ><?php echo $nombre_medida; ?></td>

    						</tr>

    						<!-- se agrega la siguente tabla -->
    						<tr id="<?php echo $idfila; ?>" style="background-color: #fff; display: none;">
    							<th colspan="4" align="center" style="text-align: center; color: #000;" >

    								<table width="100%" border="0" id="otra" class="table table-striped table-bordered">
    									<tbody>
    										<tr align="center" style="background-color: #b3afaf; font-weight: bold">
    											<td colspan="4">DETALLE DE ENTRADAS Y SALIDAS</td>
    										</tr>   
    										<tr style="background-color: #DCDADA; font-weight: bold">   										
    											<td align="center" >LOTE</td> 
    											<td align="center" >TOTAL ENTRADA</td>
    											<td align="center" >TOTAL SALIDA</td>
    											<td align="center" >TOTAL </td>

    											<?php 

                                                # sumando por lote las entradas de cada insumo
    											$qry_entradas_agrupado_lote ="SELECT 
    											SUM(ed.total) AS total_cantidad,
    											e.idempresas, 
    											e.idsucursales, e.fecha,
    											ed.*
    											FROM entradas_detalle AS ed
    											INNER JOIN entradas e ON e.identradas=ed.identradas
    											WHERE e.idempresas = '".$idempresas_ciclo."'
    											AND e.idsucursales= '".$idsucursal_ciclo."'
    											AND ed.idinsumos = '".$result_inventario_row['idinsumos']."'
                                                AND DATE(e.fecha) >= DATE('$fechaInicial') AND DATE(e.fecha) <= DATE('$fechaFinal')
    											$qry_id_lote                                                
    											GROUP BY ed.lote
    											ORDER BY ed.idinsumos ASC, ed.lote ASC ";

    											$result_entrada_lote = $db->consulta($qry_entradas_agrupado_lote);
    											$result_entrada_lote_row = $db->fetch_assoc($result_entrada_lote);
    											$result_entrada_lote_num = $db->num_rows($result_entrada_lote);

    											//echo "entrada: ".$qry_entradas_agrupado_lote;

    											$numr=0;
    											$total=0;
    											$total_e=0;
    											$total_s=0;
    											do
    											{
    												
    												//echo "<br>1.-".$qry_salidas_agrupado_lote;
													//echo "<br>".$result_salida_lote_num;
													//echo "<br>";

    												if($result_entrada_lote_num == 0){
    													?>

    													<tr> 
    														<td colspan="4" style="text-align: center">
    															<h5 class="alert_warning">NO EXISTEN DETALLES DE ENTRADAS.</h5>
    														</td>
    													</tr>
    													<?php
    												}else
    												{

													$numr++; 
    												$lote_entrada=$result_entrada_lote_row['lote'];
    												//echo "<br>".$lote_entrada;

    												//aqui va qry_fecha_corte2
                                                    $qry_salidas_agrupado_lote="SELECT 
    												SUM(sd.total) AS total_cantidad,
    												s.idempresas,
    												s.idsucursales, s.fecha,
    												sd.*
    												FROM salidas_detalles AS sd
    												INNER JOIN salidas s ON s.idsalidas=sd.idsalidas
    												WHERE s.idempresas = '".$idempresas_ciclo."'
    												AND s.idsucursales= '".$idsucursal_ciclo."'
    												AND sd.idinsumos = '".$result_inventario_row['idinsumos']."'
    												AND sd.lote = '".$result_entrada_lote_row['lote']."'
                                                   AND DATE(s.fecha) >= DATE('$fechaInicial') AND DATE(s.fecha) <= DATE('$fechaFinal')
    												GROUP BY sd.lote
    												ORDER BY sd.lote ";

                                                    //echo "<br>salida<br>".$qry_salidas_agrupado_lote;

    												$result_salida_lote = $db->consulta($qry_salidas_agrupado_lote);
    												$result_salida_lote_row = $db->fetch_assoc($result_salida_lote);
    												$result_salida_lote_num = $db->num_rows($result_salida_lote);

    												$total_salida=0;

			  											//$fecha_entrada = date("d-m-Y H:i:s",strtotime($result_rango_row['fecha']));

			  										  // encontro el lote en salida
    													if($result_salida_lote_num!=0)
    													{

    														$total_salida=$result_salida_lote_row['total_cantidad'];

    													}

    													$total_g = $result_entrada_lote_row['total_cantidad']-$total_salida;
    													?>

    													<tr style="color: #000;">
    														                                                           
    														<td><?php echo $result_entrada_lote_row['lote']; ?></td>                                                              
    														<td align="right"><?php echo number_format($result_entrada_lote_row['total_cantidad'],2)." ".$nombre_medida; 
    															$total_e=$total_e +$result_entrada_lote_row['total_cantidad'];
    														?></td>
    														<td align="right"><?php 

    														if($total_salida!=0)
    														{
    															echo number_format($total_salida,2)." ".$nombre_medida; 
    														}
    														else { echo $total_salida; } 
															$total_s=$total_s+$total_salida;
    														?></td>                                                  
    														<td align="right"><?php echo number_format($total_g,2)." ".$nombre_medida; 
    														         $total=$total + $total_g;
    														?></td>                                                  
    													</tr>                                                            

    													<?php
                                                        	}//else
                                                        }
                                                        while($result_entrada_lote_row = $db->fetch_assoc($result_entrada_lote));

                                                        //mostramos los lotes que esten en salidas y no en entradas
                                                        $qry_lotes_salidas2 = "SELECT 
															SUM(sd.total) AS total_cantidad, 
															s.idempresas, 
															s.idsucursales, s.fecha, 
															sd.* 
															FROM salidas_detalles AS sd
															INNER JOIN salidas s ON s.idsalidas=sd.idsalidas 
															WHERE s.idempresas = '".$idempresas_ciclo."' 
															AND s.idsucursales= '".$idsucursal_ciclo."' 
															AND sd.idinsumos = '".$result_inventario_row['idinsumos']."'
															AND DATE(s.fecha) >= DATE('$fechaInicial') AND DATE(s.fecha) <= DATE('$fechaFinal')
                                                            $qry_id_lote2
															GROUP BY sd.lote 
															ORDER BY sd.lote ";

															//echo "<br>salida 2<br>".$qry_lotes_salidas2;

															$result_salida2 = $db->consulta($qry_lotes_salidas2);
    												$result_salidas2_row = $db->fetch_assoc($result_salida2);
    												$result_salidas2_num = $db->num_rows($result_salida2);

    												if($result_salidas2_num!=0)
    												{

    												$i=0;
    												//$total_s2=0
    												do
    												{

    													//echo "<br>".$i++;
    													// consultamos los lotes de salida en las entradas
    													$qry_check_lote_entradas ="SELECT 
															SUM(ed.total) AS total_cantidad,
															e.idempresas,
															e.idsucursales, e.fecha,
															ed.*
															FROM entradas_detalle AS ed
															INNER JOIN entradas e ON e.identradas=ed.identradas
															WHERE e.idempresas = '".$idempresas_ciclo."' 
															AND e.idsucursales= '".$idsucursal_ciclo."' 
															AND ed.idinsumos = '".$result_inventario_row['idinsumos']."'
															AND ed.lote= '".$result_salidas2_row['lote']."'
                                                            AND DATE(e.fecha) >= DATE('$fechaInicial') AND DATE(e.fecha) <= DATE('$fechaFinal')
															GROUP BY ed.lote
															ORDER BY ed.idinsumos ASC, ed.lote ASC
															";

															$result_entradas2 = $db->consulta($qry_check_lote_entradas);
    												$result_entradas2_row = $db->fetch_assoc($result_entradas2);
    												$result_entradas2_num = $db->num_rows($result_entradas2);

    												if($result_entradas2_num==0)
    												{
    													//se encontraron lotes de salida que no existen en los lotes de entrada 
    													//echo "<br> encontro este lote.- ".$result_salidas2_row['lote'];
    													$valor_cero=0;
    													$total_salida2=$valor_cero-$result_salidas2_row['total_cantidad'];
    													?>

    													<tr style="color: #000;">
    														                                                           
    														<td><?php echo $result_salidas2_row['lote']; ?></td>                                                              
    														<td align="right"><?php echo $valor_cero; ?></td>
    														<td align="right"><?php echo number_format($result_salidas2_row['total_cantidad'],2)." ".$nombre_medida; 
															$total_s=$total_s+$result_salidas2_row['total_cantidad'];	
    														?></td>                                                  
    														<td style="color: #FF0000;" align="right"><?php echo number_format($total_salida2,2)." ".$nombre_medida; 
    														$total=$total + $total_salida2; 
    														?></td>                                                  
    													</tr>                                                            

    													<?php

    												}

    												}while($result_salidas2_row = $db->fetch_assoc($result_salida2));

    											} // if si total de registros es diferente de cero
                                                       ?>

                                                        <tr>
                                                        	<td style="text-align: right; font-weight: bold">TOTAL</td>
                                                        	<td style="text-align: right; font-weight: bold">
                                                        		<?php echo number_format($total_e,2)." ".$nombre_medida; ?>
                                                        	</td>
                                                        	<td style="text-align: right; font-weight: bold">
                                                        		<?php echo number_format($total_s,2)." ".$nombre_medida; ?>
                                                        	</td>
                                                        	<td style="text-align: right; font-weight: bold">
                                                        		<?php echo number_format($total,2)." ".$nombre_medida; ?>
                                                        	</td>	
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>

                                        <?php

                                    }while($result_inventario_row = $db->fetch_assoc($result_inventario));
                                }else
                                {
                                	?>
                                	<tr>
                                		<th colspan="3" style="text-align: center; font-weight: bold;" scope="row">NO EXISTEN INSUMOS EN INVENTARIO</th>
                                	</tr>
                                	<?php

                                }
                                ?>    
                            </tr>
                        </tbody>
                    </table>

                    <?php
	   }while($result_sucursales_row = $db->fetch_assoc($result_sucursales)); //tyerminamos el while de sucursales por empresa

	}while($sql_empresas_row = $db->fetch_assoc($sql_empresas_result));	 //temrinamos el while de mpersas.
	?>	

</div>

</div>