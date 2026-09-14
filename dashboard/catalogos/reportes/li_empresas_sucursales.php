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
	<div style="text-align: right">	
	<a class="btn btn-primary" title="Reporte" onClick="XXXgenerarpdf_rpt_lista_empresas();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
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
    ORDER BY empresas";

    $sql_empresas_result = $db->consulta($sql_empresas);
    $sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
    $sql_empresas_num = $db->num_rows($sql_empresas_result);

    do{

    	?>	
    	<br>
    	<h3>EMPRESA: <?php echo $sql_empresas_row['empresas'];?></h3>
		
		

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
    	$sql_sucursales = "SELECT *
    	FROM
    	sucursales s
    	WHERE
    	s.idempresas = '$idempresas_ciclo' $id_sucursal";

    	$result_sucursales = $db->consulta($sql_sucursales);
    	$result_sucursales_row = $db->fetch_assoc($result_sucursales);

    	do
    	{

    		?>
		
		
	

    		<table class="table table-striped table-bordered" id="tbl_empresas" cellpadding="0" cellspacing="0" style="overflow: auto">
    			<thead class="thead-dark">
    				<tr style="text-align: center">
    					<th>ID</th> 
    					<th>SUCURSAL</th> 
    					<th>DIRECCI&Oacute;N</th> 
    					<th>TEL&Eacute;FONO</th> 
    					<th>EMAIL</th>
    					<th>ESTATUS</th>
    					<th>ACCI&Oacute;N</th>
    				</tr>
    			</thead>

    			<tbody>
    				<?php
    				if($result_sucursales_row == 0){
    					?>
    					<tr> 
    						<td colspan="7" style="text-align: center">
    							<h5 class="alert_warning">NO EXISTEN SUCURSALES EN LA BASE DE DATOS.</h5>
    						</td>
    					</tr>
    					<?php
    				}else{
    					do
    					{
    						?>
    						<tr>
    							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_sucursales_row['idsucursales']); ?></td>
    							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_sucursales_row['sucursal']); ?></td>
    							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_sucursales_row['direccion']);?></td>
    							<td style="text-align: center;"><?php echo $result_sucursales_row['telefono'];?></td>
    							<td style="text-align: center;"><?php echo $result_sucursales_row['email'];?></td>
    							<td style="text-align: center;"><?php echo $t_estatus[$result_sucursales_row['estatus']];?></td>
    							<td style="text-align: center; font-size: 15px;">

    								<i class="btn btn-primary mdi mdi-file-pdf" style="cursor: pointer" onclick="generarpdf_rpt_sucursales('<?php echo $result_sucursales_row['idsucursales'];?>')" ></i>

    							</td>
    						</tr>
    						<?php
    					}while($result_sucursales_row = $db->fetch_assoc($result_sucursales));
    				}
    				?>
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