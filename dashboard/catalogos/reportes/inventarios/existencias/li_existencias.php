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

//OBTEN4MOS DOS VALORES IMPORATNTS PARA PODER REALIZAR LA CONSULTA ID MPERESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

$idempresa = $_GET['v_idempresa'] ;
$idsucursal1 = $_GET['v_idsucursales'] ;
$idinsumo = $_GET['v_idinsumos'] ;
$fechaInicial = $_GET['v_fecha_inicial'];
$fechaFinal = $_GET['v_fecha_final'];
$lote = $_GET['v_lote'];

// echo "<br>Fecha inicial: ".$fechaInicial;
// echo "<br>Fecha final: ".$fechaFinal;
										
?>

<div class="row">
	
<div class="col-md-12">  
	<div style="text-align: right">	
		<a class="btn btn-primary" title="Reporte" onClick="rpt_excel_existencias();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
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
			$qry_id_lote = "AND entradas_detalle.lote = '$lote' ";
	}
	else { $qry_id_lote =""; } 
		
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
			  <th align="center" scope="col">NOMBRE DEL INSUMO</th>
			  <th align="center" valign="middle" scope="col" style="text-align: center">EXISTENCIAS PARA VENTA</th>
			  <th align="center" valign="middle" scope="col" style="text-align: center">EXISTENCIA EN BODEGA</th>
			  <th align="center" valign="middle" scope="col" style="text-align: center">REPORTE</th>
			</tr>
		  </thead>
		  <tbody>	
		       <?php
		           $idsucursal_ciclo = $result_sucursales_row ['idsucursales'];	
		           //echo "id insumo: ".$idinsumo. "<br>";

		           if(!empty($idinsumo))
						{
							$id_insumo = " AND inv.idinsumos= '$idinsumo' ";
						}
						else
						{
							$id_insumo = " ";
						}							
														    
										 $sql_inventario = "SELECT
													inv.*,
													i.nombre,
													tm.nombre as medida	
												FROM
													inventario inv
													LEFT JOIN insumos i ON i.idinsumos = inv.idinsumos AND i.idempresas = '$idempresas_ciclo'
													LEFT JOIN tipo_medida tm ON tm.idtipo_medida = i.idtipo_medida
												WHERE inv.idsucursales = '$idsucursal_ciclo' AND inv.idempresas = '$idempresas_ciclo' $id_insumo
											   ORDER BY inv.idinsumos ";
											   //echo $sql_inventario;

												$result_inventario = $db->consulta($sql_inventario);
												$result_inventario_row = $db->fetch_assoc($result_inventario);
												$result_inventario_num = $db->num_rows($result_inventario);	

										if($result_inventario_num != 0)
										{

											do
												 {

												 	      $qry_rango="SELECT
															entradas_detalle.*,
															entradas.idempresas,
															entradas.idsucursales,
															entradas.nodocto,
															tipo_medida.nombre AS nombre_medida,
															entradas.fecha
															FROM
															entradas_detalle
															INNER JOIN entradas ON entradas_detalle.identradas = entradas.identradas
															INNER JOIN tipo_medida ON entradas_detalle.idtipo_medida = tipo_medida.idtipo_medida
															WHERE
															entradas_detalle.idinsumos = '".$result_inventario_row['idinsumos']."' AND entradas.idempresas = '".$sql_empresas_row['idempresas']."' AND entradas.idsucursales = '".$result_inventario_row['idsucursales']."'  AND DATE(entradas.fecha) >= DATE('$fechaInicial') AND DATE(entradas.fecha) <= DATE('$fechaFinal')
																$qry_id_lote
															   ";

                                                            $result_rango  = $db->consulta($qry_rango);
                                                            $result_rango_row = $db->fetch_assoc($result_rango);
                                                            $result_rango_num = $db->num_rows($result_rango);	

                                                            if($result_rango_num==0)
                                                            {
                                                            	continue;
                                                            }	

															//echo $qry_rango;
                                                            //var_dump($result_rango_row);                                                                 

												 	$idinsumos=$result_inventario_row['idinsumos'];
													$idempresa=$result_inventario_row['idempresas'];
													$idsucursal=$idsucursal_ciclo;

													  $existencia_venta = $result_inventario_row['entradas']-$result_inventario_row['salidas'];
													  //echo "<br>Existencia venta: ".$existencia_venta;
													  $existencia_bodega = $result_inventario_row['entradafisica']-$result_inventario_row['entradasalida'];
													  //echo "<br>Existencia bodega: ".$existencia_bodega;
													  $medida = $f->imprimir_cadena_utf8($f->mayus($result_inventario_row['medida']));

													  $inven->idinsumos=$idinsumos;
													  $inven->idempresas=$idempresa;
													  $inven->idsucursales=$idsucursal;
													  //print_r($inven);

													 $total= $inven->TotalInsumoEnNotasRemision();
													
													  $resultado=$db->fetch_assoc($total);
													  $suma=$resultado['sumainsumo'];
													  $existencia_venta=$existencia_venta-$suma;

													  ?>
												 <tr onClick="f_toogle(<?php echo $result_inventario_row['idinventario']; ?>);"  style="cursor: pointer;">
												  <th align="center" scope="row" style="text-align: center"><?php echo $result_inventario_row['idinsumos']; ?></th>
												  <td><?php echo $f->imprimir_cadena_utf8($result_inventario_row['nombre']); ?></td>
												  <td align="right"><?php echo number_format($existencia_venta,2).' '. $medida; ?></td>
												  <td align="right"><?php echo number_format($existencia_bodega,2).' '. $medida; ?></td>
												  <td style="text-align: center; font-size: 15px;" width="80">
						
												<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" title="REPORTE DE ENTRADAS" onclick="rpt_excel_entradas('<?php echo $sql_empresas_row['idempresas']; ?>','<?php echo $result_inventario_row['idsucursales']; ?>','<?php echo $result_inventario_row['idinsumos']; ?>','<?php echo $result_rango_row['lote']; ?>')" ></i>

												</td>

												</tr>

												    <!-- se agrega la siguente tabla -->
                                            <tr id="<?php echo $result_inventario_row['idinventario']; ?>" style="background-color: #fff; display: none;">
                                                  <th colspan="8" align="center" style="text-align: center; color: #000;" >

                                                     <table width="100%" border="0" id="otra" class="table table-striped table-bordered">
                                                          <tbody>
                                                            <tr style="background-color: #b3afaf; font-weight: bold">
                                                                <td colspan="8">DETALLE DE ENTRADA</td>
                                                             </tr>   
                                                            <tr style="background-color: #DCDADA; font-weight: bold">
                                                              <td align="center" >NUM</td>
                                                              <td align="center" >ID ENTRADA</td>
                                                              <td align="center" >FECHA DE ENTRADA</td>
                                                              <td align="center" >LOTE</td> 
                                                              <td align="center" >OBSERVACIONES</td>
                                                              <td align="center" >NUM. DOCTO</td>
                                                              <td align="center" >CANTIDAD DE UNIDADES</td>
                                                              <td align="center" >TOTAL</td> 
                                                            </tr>
                                                            <?php 
                                                        
                                                                                      
                                                            $numr=0;
                                                            $total=0;
                                                            do
                                                            {
                                                            $numr++; 


														if($result_rango_num == 0){
															?>

															<tr> 
																<td colspan="8" style="text-align: center">
																	<h5 class="alert_warning">NO EXISTEN DETALLES DE ENTRADAS.</h5>
																</td>
															</tr>
															<?php
			  												}else
			  												{
			  													$fecha_entrada = date("d-m-Y H:i:s",strtotime($result_rango_row['fecha']));
                                                            ?>

                                                            <tr style="color: #000;">
                                                              <td><?php echo $numr; ?></td> 
                                                              <td><?php echo $result_rango_row['identradas']; ?></td>
                                                              <td><?php echo $fecha_entrada; ?></td>
                                                              <td><?php echo $result_rango_row['lote']; ?></td> 
                                                              <td><?php echo $result_rango_row['observaciones']; ?></td>
                                                              <td><?php echo $result_rango_row['nodocto']; ?></td>
                                                              <td align="right"><?php echo number_format($result_rango_row['cantidad'],2);  ?></td>
                                                              <td align="right"><?php echo number_format($result_rango_row['total'],2) ." " .$f->mayus($result_rango_row['nombre_medida']);
                                                              $total=$total + $result_rango_row['total']; 
                                                               ?></td>                                               
                                                            </tr>                                                            

                                                            <?php
                                                        	}//else
                                                            }
                                                            while($result_rango_row = $db->fetch_assoc($result_rango));
                                                                
                                                            ?>
                                                            <!-- TABLA DE TRASPASOS-->
                                                            
                                                            <tr style="background-color: #b3afaf; font-weight: bold">
                                                                <td colspan="8">DETALLE DE TRASPASOS</td>
                                                             </tr>

                                                              <tr style="background-color: #DCDADA; font-weight: bold">
                                                              <td align="center" >NUM</td>
                                                              <td align="center" >ID TRASPASO</td>
                                                              <td align="center" >FECHA DE TRASPASO</td>
                                                              <td align="center" >LOTE</td> 
                                                              <td align="center" >OBSERVACIONES</td>
                                                              <td align="center" >AUTORIZO</td>
                                                              <td align="center" >CANTIDAD DE UNIDADES</td>
                                                              <td align="center" >TOTAL</td> 
                                                            </tr> 

                                                            <?php

                                                            $sql_traspaso="SELECT
																traspaso_detalle.*,
																traspaso.idempresas,
																traspaso.para,
																traspaso.fecha,
																traspaso.autorizo,
																tipo_medida.nombre as nom_medida
																FROM
																traspaso_detalle
																INNER JOIN traspaso ON traspaso_detalle.idtraspaso = traspaso.idtraspaso LEFT JOIN tipo_medida ON traspaso_detalle.idtipo_medida = tipo_medida.idtipo_medida
																WHERE
																traspaso.idempresas = '".$sql_empresas_row['idempresas']."' AND
																traspaso.para = '".$result_inventario_row['idsucursales']."' AND
																traspaso_detalle.idinsumos = '".$result_inventario_row['idinsumos']."' AND DATE(traspaso.fecha) >= DATE('$fechaInicial') AND DATE(traspaso.fecha) <= DATE('$fechaFinal') ";

                                                            $result_trasp  = $db->consulta($sql_traspaso);
                                                            $result_trasp_row = $db->fetch_assoc($result_trasp);
                                                            $result_trasp_num = $db->num_rows($result_trasp);	

                                                            $numt=0;
                                                            do
                                                            {
                                                            	$numt++;

                                                            if($result_trasp_num == 0){
															?>

															<tr> 
																<td colspan="8" style="text-align: center; ">
																	<h5 class="alert_warning">NO EXISTEN DETALLES DE TRASPASOS.</h5>
																</td>
															</tr>
															<?php
			  												}else
			  												{
			  													$fecha_traspaso = date("d-m-Y H:i:s",strtotime($result_trasp_row['fecha']));
                                                            ?>		

                                                             <tr style="color: #000;">
                                                              <td><?php echo $numt; ?></td> 
                                                              <td><?php echo $result_trasp_row['idtraspaso']; ?></td>
                                                              <td><?php echo $fecha_traspaso; ?></td>
                                                              <td><?php echo $result_trasp_row['lote']; ?></td> 
                                                              <td><?php echo $result_trasp_row['observaciones']; ?></td>
                                                              <td><?php echo $f->imprimir_cadena_utf8($f->mayus($result_trasp_row['autorizo'])); ?></td>
                                                              <td align="right"><?php echo number_format($result_trasp_row['cantidad'],2);  ?></td>
                                                              <td align="right"><?php echo number_format($result_trasp_row['total'],2) ." " .$result_trasp_row['nom_medida'];
                                                              $total=$total + $result_trasp_row['total']; 
                                                               ?></td>                                               
                                                            </tr>                                                            

                                                            <?php
                                                        		}//ELSE
                                                            }
                                                            while($result_trasp_row = $db->fetch_assoc($result_trasp));
                                                                
                                                            ?>
                                                            <!-- FIN TABLA TRASPASOS-->


                                                            <tr>
                                                            	<td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
                                                            	<td style="text-align: right; font-weight: bold">
                                                            		<?php echo number_format($total,2)." " .$f->mayus($result_inventario_row['medida']); ?>
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
												  <th colspan="5" style="text-align: center; font-weight: bold;" scope="row">NO EXISTEN INSUMOS EN INVENTARIO</th>
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

<script type="text/javascript">
	 $('#tbl_inventarios').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "SELECCIONE UNA EMPRESA PARA INICIAR UNA BÚSQUEDA.",
						"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
						"sInfoEmpty": "desde 0 a 0 de 0 records",
						"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
						"sSearch": "Buscar",
						"oPaginate": {
									 "sFirst":    "Inicio",
									 "sPrevious": "Anterior",
									 "sNext":     "Siguiente",
									 "sLast":     "Ultimo"
									 }
						},
		   "sPaginationType": "full_numbers", 
		 	"paging":   true,
		 	"ordering": false,
        	"info":     false
		} );
</script>