<?php
/*================================*
*  Proyecto: AUTOBUSES AEXA		  *
*  Compañia: CAPSE 				  *
*  Fecha: 22/08/2019     		  *
* MSD José Luis Gómez Aguilar     *
*=================================*/

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
		/* header("Location: ../login.php"); */ echo "login";
	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Empresas.php");
require_once("../../../clases/class.Sucursales.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Botones.php");


//Se crean los objetos de clase
$db = new MySQL();
$em = new Empresas();
$su = new Sucursales();
$f = new Funciones();
$bt = new Botones_permisos();

$em->db = $db;
$su->db = $db;
	
//Recibo parametros del filtro
$idempresas = $_GET['idempresas'];

$em->idempresas = $idempresas;
$resultado_empresa = $em->buscarEmpresa();
$resultado_empresa_row = $db->fetch_assoc($resultado_empresa);

$empresas = $resultado_empresa_row['empresas'];

//Envio parametros a la clase empresas
$su->idempresas = $idempresas;

//Realizamos consulta
$resultado_sucursales = $su->obtener_sucursales_empresa();
$resultado_sucursales_num = $db->num_rows($resultado_sucursales);
$resultado_sucursales_row = $db->fetch_assoc($resultado_sucursales);

//Declaración de variables
$t_estatus = array('DESACTIVADO','ACTIVADO');
		
//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-13'];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

?>

<table class="table table-striped table-bordered" id="tbl_sucursales" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead>
		<tr>
			<th>SUCURSAL</th> 
			<th>DIRECCI&Oacute;N</th> 
			<th>TEL&Eacute;FONO <br> EMAIL</th>
			<th>ESTATUS</th>
			<th>ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
			<?php
			if($resultado_sucursales_num == 0){
			?>
			<tr> 
				<td colspan="5" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN SUCURSALES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
					<tr>
						<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_sucursales_row['sucursal']); ?></td>
						<td style="text-align: center;"><?php echo nl2br($f->imprimir_cadena_utf8($resultado_sucursales_row['direccion']));?></td>
						<td style="text-align: center;"><?php echo $resultado_sucursales_row['telefono']."<br>".$resultado_sucursales_row['email']; ?></td>
						<td style="text-align: center;"><?php echo $t_estatus[$resultado_sucursales_row['estatus']]; ?></td>
						<td style="text-align: center; font-size: 15px;">
					   		<!--<i class="mdi mdi-table-edit" onclick="abrir_modal_formulario('catalogos/empresas/sucursales/fa_sucursales.php?idempresas=<?php echo $idempresas; ?>&idsucursales=<?php echo $resultado_sucursales_row['idsucursales']; ?>','AGREGAR SUCURSAL A <?php echo $empresas; ?>');" style="cursor: pointer" title="Modificar Sucursal"></i>-->
							
							<?php
								//SCRIPT PARA CONSTRUIR UN BOTON
								$bt->titulo = "";
								$bt->icon = "mdi-table-edit";
								$bt->funcion = "abrir_modal_formulario('catalogos/empresas/sucursales/fa_sucursales.php?idempresas=".$idempresas."&idsucursales=".$resultado_sucursales_row['idsucursales']."','AGREGAR SUCURSAL A ".$empresas."');";
								$bt->estilos = "";
								$bt->permiso = $permisos;
								$bt->tipo = 2;
								$bt->class='btn btn_colorgray';
								$bt->title="EDITAR";

								$bt->armar_boton();
							?>
							
							<?php
								//SCRIPT PARA CONSTRUIR UN BOTON
								$bt->titulo = "";
								$bt->icon = "mdi-delete-empty";
								$bt->funcion = "BorrarSucursal(".$resultado_sucursales_row['idsucursales'].",".$idempresas.")";
								$bt->estilos = "";
								$bt->permiso = $permisos;
								$bt->tipo = 3;
								$bt->title="BORRAR";

								$bt->armar_boton();
							?>
							

							<!--<i class="mdi mdi-delete-empty" style="cursor: pointer" onclick="BorrarDatosGet('<?php echo $resultado_sucursales_row['idsucursales'];?>','idsucursales','sucursales','n','catalogos/empresas/sucursales/li_sucursales.php?idempresas=<?php echo $idempresas; ?>','content_sucursales')" ></i>-->
						</td>
					</tr>
			<?php
				}while($resultado_sucursales_row = $db->fetch_assoc($resultado_sucursales));
			}
			?>
	</tbody>
</table>


<script type="text/javascript">
	 $('#tbl_sucursales').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN SUCURSALES EN LA BASE DE DATOS.",
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