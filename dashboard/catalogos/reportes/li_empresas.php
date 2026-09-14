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

//Recibo parametros del filtro
$idempresas = $_GET['v_idempresa'];
//$estatus = $_GET['estatus'];

/*
echo "<br>valor de id empresa trae: ".$idempresas;
echo "<br>valor de estatus empresa trae: ".$estatus;
echo "<br>valor de tipo de usuario: ".$tipousaurio;
echo "<br>valor de lista de empresa trae: ".$lista_empresas;
*/

//Envio parametros a la clase empresas

$rpt->idempresas = $idempresas;
/*
$emp->estatus = $estatus;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;
*/

//Realizamos consulta
$resultado_empresas = $rpt->lista_empresas();
$resultado_empresas_num = $db->num_rows($resultado_empresas);
$resultado_empresas_row = $db->fetch_assoc($resultado_empresas);

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

?>
<h5>LISTA DE EMPRESAS</h5>
<div class="form-group col-md-12" style="text-align: right">
	
	
	<a class="btn btn-primary" title="Reporte2" onClick="generarexcel_rpt_lista_empresas();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
	
	
	<a class="btn btn-primary" title="Reporte" onClick="generarpdf_rpt_lista_empresas();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE PDF</a>
	
</div>

<table class="table table-striped table-bordered" id="tbl_empresas" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead class="thead-dark">
		<tr style="text-align: center">
			<th>No. EMPRESA</th> 
			<th>EMPRESA</th> 
			<th>DIRECCI&Oacute;N</th> 
			<th>TEL&Eacute;FONO</th> 
			<th>EMAIL</th>
			<th>ESTATUS</th>
			<th>ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
		<?php
		if($resultado_empresas_num == 0){
			?>
			<tr> 
				<td colspan="7" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN EMPRESAS EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
		}else{
			$num=0;
			do
			{
				$num++
				?>
				<tr>
					<td style="text-align: center;"><?php echo $num; ?></td>
					<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['empresas']); ?></td>
					<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['direccion']);?></td>
					<td style="text-align: center;"><?php echo $resultado_empresas_row['telefono'];?></td>
					<td style="text-align: center;"><?php echo $resultado_empresas_row['email'];?></td>
					<td style="text-align: center;"><?php echo $t_estatus[$resultado_empresas_row['estatus']];?></td>
					<td style="text-align: center; font-size: 15px;">

						<i class="btn btn-primary mdi mdi-file-pdf" style="cursor: pointer" title="REPORTE DETALLE" onclick="generarpdf_rpt_empresas('<?php echo $resultado_empresas_row['idempresas'];?>')" ></i>

					</td>
				</tr>
				<?php
			}while($resultado_empresas_row = $db->fetch_assoc($resultado_empresas));
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
	$('#tbl_empresas').DataTable( {		
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