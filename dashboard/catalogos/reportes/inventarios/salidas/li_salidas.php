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
$t_entregado = array('0','ENTREGADO');

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

//echo "<br>Fecha inicial: ".$fechaInicial;
//echo "<br>Fecha final: ".$fechaFinal;
										
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
	
		<table class="table table-striped table-bordered" id="tbl_salidas">
		  <thead class="thead-dark">
			<tr>
			   <th align="center" scope="col" style="text-align: center">NUM</th>
			   <th align="center" scope="col" style="text-align: center">FECHA</th>
			   <th align="center" scope="col" style="text-align: center">ID EMPRESA</th>
			   <th align="center" scope="col" style="text-align: center">ID SUCURSAL</th>
			   <th align="center" valign="middle" scope="col" style="text-align: center">USUARIO</th>
			   <th align="center" valign="middle" scope="col" style="text-align: center">TIPO</th>
			   <th align="center" valign="middle" scope="col" style="text-align: center">NUM. REMISI&Oacute;N</th>
			   <th align="center" valign="middle" scope="col" style="text-align: center">COMENTARIO</th>
			   <th align="center" valign="middle" scope="col" style="text-align: center">REPORTE</th>
			</tr>
		  </thead>
		  <tbody>	
		       <?php
		           $idsucursal_ciclo = $result_sucursales_row ['idsucursales'];	

		           		/*
		           		if($idinsumo!=0)
						{
							$id_insumo = " AND inv.idinsumos= $idinsumo";
						}
						else
						{
							$id_insumo = " ";
						}
						*/							
							
							$sql_salida = "SELECT s.*,
											CONCAT(usr.nombre,' ',usr.paterno,' ',usr.materno) as nombre_usuario
											FROM salidas AS s 
											INNER JOIN usuarios usr ON s.idusuarios = usr.idusuarios
											WHERE s.idempresas = '".$sql_empresas_row['idempresas']."'
											AND s.idsucursales= '".$result_sucursales_row['idsucursales']."'
											ORDER BY
											s.fecha ASC ";
		
							echo "<br>".$sql_salida;

							$result_salida = $db->consulta($sql_salida);
							$result_salida_row = $db->fetch_assoc($result_salida);
							$result_salida_num = $db->num_rows($result_salida);							

										if($result_salida_num != 0)
										{
											$nums =0;
											do											
											{
											$nums++;

										?>
											<tr onClick="f_toogle(<?php echo $result_salida_row['idsalidas']; ?>);"  style="cursor: pointer;">
												  <td align="center" scope="row" style="text-align: center"><?php echo $nums; ?></td>
												  <td align="center" scope="row" style="text-align: center"><?php echo $result_salida_row['fecha']; ?></td>
												  <td align="center"><?php echo $result_salida_row['idempresas']; ?></td>
												  <td align="center"><?php echo $result_salida_row['idsucursales']; ?></td>
												  <td align="center"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_salida_row['nombre_usuario'])); ?></td>
												   <td align="center"><?php echo $result_salida_row['tipo']; ?></td>				 
												  <td style="text-align: center"><?php echo $result_salida_row['nodocto']; ?></td>
												  <td style="text-align: center"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_salida_row['comentario'])); ?></td>
												  <td style="text-align: center; font-size: 15px;" width="80">
													<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" title="REPORTE DE ENTRADAS" onclick="rpt_excel_entradas();" ></i>
												</td>
											</tr>

											<!-- se agrega la siguente tabla -->
                                            <tr id="<?php echo $result_salida_row['idsalidas']; ?>" style="background-color: #fff; display: none;">
                                                  <th colspan="9" align="center" style="text-align: center; color: #000;" >

                                                     <table width="100%" border="0" id="otra" class="table table-striped table-bordered">
                                                          <tbody>
                                                            <tr style="background-color: #b3afaf; font-weight: bold">
                                                                <td colspan="9">DETALLE DEL PRODUCTO</td>
                                                             </tr>   
                                                            <tr style="background-color: #DCDADA; font-weight: bold">
                                                              <td align="center" >TIPO MEDIDA</td>
                                                              <td align="center" >LOTE</td>
                                                              <td align="center" >ID INSUMO</td>
                                                              <td align="center" >NOMBRE DEL INSUMO</td> 
                                                              <td align="center" >MEDIA</td>
                                                              <td align="center" >CANTIDAD</td>                                
                                                              <td align="center" >TOTAL</td>                                
                                                              <td align="center" >OBSERVACIONES</td>                                
                                                            </tr>
                                                            <?php 
                                                        
                                                            $qry_rango=" SELECT sd.*
																		FROM salidas_detalles AS sd
																		WHERE sd.idsalidas =  '".$result_salida_row['idsalidas']."' ";

															echo "<br>".$qry_rango;

                                                            $result_rango  = $db->consulta($qry_rango);
                                                            $result_rango_row = $db->fetch_assoc($result_rango);
                                                            $result_rango_num = $db->num_rows($result_rango);		

															//echo $qry_rango;
                                                            //var_dump($result_rango_row);                                                                                                 
                                                            $numr=0;
                                                            $total=0;
                                                            do
                                                            {
                                                            $numr++; 

															if($result_rango_num == 0){
															?>

															<tr> 
																<td colspan="8" style="text-align: center">
																	<h5 class="alert_warning">NO EXISTEN DETALLES DE SALIDAS.</h5>
																</td>
															</tr>
															<?php
			  												}else
			  												{
                                                            ?>

                                                            <tr style="color: #000;">                                                              
                                                              <td><?php echo $result_rango_row['idtipo_medida']; ?></td>
                                                              <td><?php echo $result_rango_row['lote']; ?></td>
                                                              <td><?php echo $result_rango_row['idinsumos']; ?></td> 
                                                              <td><?php echo $result_rango_row['nombre']; ?></td>  
                                                              <td><?php echo $result_rango_row['medida']; ?></td>  
                                                              <td align="right"><?php echo $result_rango_row['cantidad'];  ?></td>
                                                              <td align="right"><?php echo number_format($result_rango_row['total'],2); ?></td>
                                                              <td><?php echo $f->imprimir_cadena_utf8($f->mayus($result_rango_row['observaciones'])); ?></td>                                                
                                                            </tr>                                                            

                                                            <?php
                                                        	}//else
                                                            }
                                                            while($result_rango_row = $db->fetch_assoc($result_rango));
                                                                
                                                            ?>                                                        
                                                          
                                                          </tbody>
                                                    </table>
                                                  </th>
                                            </tr>


										<?php

												}while($result_salida_row = $db->fetch_assoc($result_salida));
										}else
										{
										?>
			  									<tr>
												  <th style="text-align: center; font-weight: bold;" colspan="9" scope="row">NO EXISTEN SALIDAS</th>
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

</script>