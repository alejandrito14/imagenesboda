<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
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
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Reportes.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$rpt = new Reportes();
$f = new Funciones();
$bt = new Botones_permisos();

$rpt->db = $db;
	
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
$idsucursal = $_GET['v_idsucursales'] ;
										
?>

<div class="row">

<div class="col-md-12">  
	
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
							ORDER BY empresas";
	
	$sql_empresas_result = $db->consulta($sql_empresas);
	$sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
	$sql_empresas_num = $db->num_rows($sql_empresas_result);
	
do{
	
?>	
	
  <h3><?php echo $sql_empresas_row['empresas'];?></h3>
	
	<?php
	
	   //obtenemos la sucursales a buscar
	
	
       //VAMOS A OBTENER EL VALOR DE LA SUCURSAL O DE TODAS LAS SUCURSALES DE ESA EMRPESA
	
	if($idsucursal != 0)
	{
		$id_sucursal = " AND idsucursales = $idsucursal";
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
	
		<table class="table" id="tbl_inventario">
		  <thead class="thead-dark">
			<tr>
			  <th align="center" scope="col" style="text-align: center">COD INSUMO.</th>
			  <th align="center" scope="col">NOMBRE DEL INSUMO</th>
			  <th align="center" valign="middle" scope="col" style="text-align: center">EXISTENCIAS PARA VENTA</th>
			  <th align="center" valign="middle" scope="col" style="text-align: center">EXISTENCIA EN BODEGA</th>
			</tr>
		  </thead>
		  <tbody>	
		       <?PHP
		           $idsucursal_ciclo = $result_sucursales_row ['idsucursales'];
								
									    
										 $sql_inventario = "SELECT
													inv.*,
													i.nombre,
													tm.nombre as medida											

												FROM
													inventario inv
													INNER JOIN insumos i ON i.idinsumos = inv.idinsumos 
													INNER JOIN tipo_medida tm ON tm.idtipo_medida = i.idtipo_medida
												WHERE inv.idsucursales = '$idsucursal_ciclo' AND inv.idempresas = '$idempresas_ciclo'												
												ORDER BY																					
													inv.idinsumos
													";

								$result_inventario = $db->consulta($sql_inventario);
								$result_inventario_row = $db->fetch_assoc($result_inventario);
								$result_inventario_num = $db->num_rows($result_inventario);
		
										if($result_inventario_num != 0)
										{

											do
												 {

													  $existencia_venta = $result_inventario_row['entradas']-$result_inventario_row['salidas'];
													  $existencia_bodega = $result_inventario_row['entradafisica']-$result_inventario_row['entradasalida'];
													  $medida = $f->imprimir_cadena_utf8($result_inventario_row['medida']);

													  ?>
												 <tr>
												  <th align="center" scope="row" style="text-align: center"><?php echo $result_inventario_row['idinsumos']; ?></th>
												  <td><?php echo $f->imprimir_cadena_utf8($result_inventario_row['nombre']); ?></td>
												  <td align="center"><?php echo $existencia_venta.' '. $medida; ?></td>
												  <td align="center"><?php echo $existencia_bodega.' '. $medida; ?></td>
												</tr>
												  <?php

												}while($result_inventario_row = $db->fetch_assoc($result_inventario));
										}else
										{
										?>
			  									<tr>
												  <th colspan="4" scope="row">NO EXISTEN INSUMOS EN INVENTARIO</th>
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
	

	
</divZ>
	
	
	
</div>




<script type="text/javascript">
	 $('#tbl_inventarios').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN EMPRESAS EN LA BASE DE DATOS.",
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