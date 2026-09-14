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

$db = new MySQL();
$rpt = new Reportes();
$bt = new Botones_permisos();
$f = new Funciones();

$rpt->db = $db;

//$result_clientes = $rpt->lista_clientes();

if($tipousaurio != 0)
	{
		if($idempresa == 0)
		{
			$id_empresa ="AND e.idempresas IN ($lista_empresas)" ;
		}else
		{
			$id_empresa = "AND e.idempresas IN ($idempresa)";
		}
	}else
	{
		if($idempresa == 0)
		{
			$id_empresa =" " ;
		}else
		{
			$id_empresa = "AND e.idempresas IN ($idempresa)";
		}
	}
	
	$sql_sucursales = "SELECT 
c.no_cliente,
c.idempresas,
CONCAT(c.nombre, ' ',c.paterno, ' ',c.materno) as nombre_cliente, 
c.folio_adminpack,
e.empresas,
CONCAT(ce.direccion,' ',ce.no_ext,' ',ce.no_int,', ',ce.col,' ',ce.cp,' ',ce.ciudad) as direccion_cliente,
ce.* 
FROM clientes_envios AS ce
INNER JOIN clientes c ON c.idcliente =  ce.idcliente
INNER JOIN empresas e ON e.idempresas = c.idempresas
WHERE 1=1 $id_empresa
ORDER BY c.no_cliente ASC, c.idempresas ASC ";						

//echo $sql_sucursales;
			
	     $result_clientes = $db->consulta($sql_sucursales);
	     $result_clientes_row = $db->fetch_assoc($result_clientes);
		 $result_clientes_num = $db->num_rows($result_clientes);
	
//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

?>
 
<div class="form-group col-md-12" style="text-align: right">
	
	<a class="btn btn-primary" title="Reporte en Excel" onClick="rpt_excel_clientes_direcciones();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>REPORTE EXCEL</a>		
		
	</div>				

<table class="table table-striped table-bordered" id="tbl_clientes" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead class="thead-dark">
		<tr style="text-align: center">		
			<th>No. CLIENTE</th>
			<th>NOMBRE CLIENTE</th> 
			<th>EMPRESA</th> 
			<th>FOLIO ADMIN PACK</th> 
			<th>DIRECCI&Oacute;N</th> 
			<th>TEL&Eacute;FONO</th> 	
		</tr>
	</thead>

	<tbody>
			<?php
			if($result_clientes_num == 0){
			?>
			<tr> 
				<td colspan="7" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN CLIENTES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
			<tr>
			    <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_clientes_row['no_cliente']); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_clientes_row['nombre_cliente'])); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_clientes_row['empresas'])?></td>
				<td style="text-align: center;"><?php echo $f->mayus($result_clientes_row['folio_adminpack']);?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_clientes_row['direccion_cliente'])); ?></td>
				<td style="text-align: center;"><?php echo $result_clientes_row['telefono']; ?></td>	
			</tr>
			<?php
				}while($result_clientes_row = $db->fetch_assoc($result_clientes));
			}
			?>
	</tbody>
</table>

<script type="text/javascript">
	$('#tbl_clientes').DataTable( {		
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


