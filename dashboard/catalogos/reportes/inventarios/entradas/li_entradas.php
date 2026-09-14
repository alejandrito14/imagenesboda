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

 //echo "<br>id empresa: ".$idempresa;
 //echo "<br>id sucursal: ".$idsucursal1;
$arraytipo=array('COMPRA','','','DEVOLUCION','OTRAS');										
?>

<div class="row">
	
<div class="col-md-12">  
	<div style="text-align: right">	
	<a class="btn btn-primary" title="Reporte" onClick="rpt_excel_entradas1();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
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
	
		<table class="table table-striped table-bordered" id="tbl_entradas" cellpadding="0" cellspacing="0" style="overflow: auto">
		  <thead class="thead-dark">
			<tr>
			  <th style="text-align: center;">ID</th> 
			   <th style="text-align: center;">FECHA</th>
			   <th style="text-align: center;">EMPRESA</th> 
			   <th style="text-align: center;">SUCURSAL</th>
			   <th style="text-align: center;">NO.DE REFERENCIA</th>
			   <th style="text-align: center;">TIPO</th>
			  
			</tr>
		  </thead>
		  <tbody>	
		       <?php
		           $idsucursal_ciclo = $result_sucursales_row ['idsucursales'];								
									    
										 $sql_entradas = "SELECT entradas.identradas,empresas.empresas,sucursales.sucursal,entradas.fecha,entradas.nodocto,entradas.tipo,entradas.estatus 
FROM entradas 
INNER JOIN empresas on entradas.idempresas=empresas.idempresas
INNER JOIN sucursales on sucursales.idsucursales=entradas.idsucursales
WHERE 1=1 AND entradas.idempresas= '".$sql_empresas_row['idempresas']."' AND entradas.idsucursales= '".$result_sucursales_row['idsucursales']."'
GROUP BY entradas.identradas ORDER BY entradas.identradas asc ";

								$result_entradas = $db->consulta($sql_entradas);
								$result_entradas_row = $db->fetch_assoc($result_entradas);
								$result_entradas_num = $db->num_rows($result_entradas);							

										if($result_entradas_num != 0)
										{

											do
												 {
												 	$fecha = date("d-m-Y H:i:s",strtotime($result_entradas_row['fecha']));
													  ?>
												 <tr>
												  <td style="text-align: center"><?php echo $result_entradas_row['identradas']; ?></td>
												  <td style="text-align: center" ><?php echo $fecha; ?></td>
												  <td style="text-align: center"><?php echo $f->imprimir_cadena_utf8($result_entradas_row['empresas']); ?></td>
												  <td style="text-align: center"><?php echo $f->imprimir_cadena_utf8($result_entradas_row['sucursal']); ?></td>
												  <td style="text-align: center"><?php echo $f->imprimir_cadena_utf8($result_entradas_row['nodocto']);  ?></td>
												  <td style="text-align: center"><?php echo $arraytipo[$result_entradas_row['tipo']]; ?></td>
												
												  <?php

												}while($result_entradas_row = $db->fetch_assoc($result_entradas));
										}else
										{
										?>
			  									<tr>
												  <th colspan="6" style="text-align: center; font-weight: bold;" scope="row">NO EXISTEN ENTRADAS EN INVENTARIO</th>
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
