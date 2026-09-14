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

//Importación de clase conexión
require_once("../../clases/conexcion.php");
require_once("../../clases/class.CostoEnvio.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$costos = new CostoEnvio();
$bt = new Botones_permisos(); 
$f = new Funciones();

$costos->db = $db;


//obtenemos todas las empreas que puede visualizar el usuario.

$costos->tipo_usuario = $tipousaurio;
$costos->lista_empresas = $lista_empresas;

$l_costos = $costos->ObtenerTodoscodigopostalcosto();
$l_costos_row = $db->fetch_assoc($l_costos);
$l_costos_num = $db->num_rows($l_costos);

/*======================= INICIA VALIDACIÓN DE RESPUESTA (alertas) =========================*/

if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		echo '<script type="text/javascript">AbrirNotificacion("'.$_GET['msj'].'","mdi-checkbox-marked-circle");</script>'; 
	}
	else
	{
		echo '<script type="text/javascript">AbrirNotificacion("'.$_GET['msj'].'","mdi-close-circle");</script>';
	}
	
	echo '<script type="text/javascript">OcultarNotificacion()</script>';
}

/*======================= TERMINA VALIDACIÓN DE RESPUESTA (alertas) =========================*/

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



$estatus=array('DESACTIVADO','ACTIVADO');

?>

<div class="card">
	<div class="card-body">
		<h5 class="card-title" style="float: left;">LISTADO DE COSTOS DE ENVÍO</h5>
		
		<div style="float:right;">
			<button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn-primary" style="float: right;display: none;"><i class="mdi mdi-account-search"></i>  BUSCAR</button>			
			
			<?php
		
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVO COSTO";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('catalogos/costosenvio/fa_costo.php?idmenumodulo=$idmenumodulo','main');";
				$bt->estilos = "float: right; margin-right:10px;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;
				$bt->title="NUEVO COSTO";
				

				$bt->armar_boton();
			
			?>
			
			<div style="clear: both;"></div>
		</div>
		
		<div style="clear: both;"></div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive" id="contenedor_costos">
			<table id="tbl_costos" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="text-align: center;">SUCURSAL</th>
						<th style="text-align: center;">PROVEEDOR</th>

						<th style="text-align: center;">CÓDIGO POSTAL INICIAL </th> 
						<th style="text-align: center;">CÓDIGO POSTAL FINAL</th>
						
						<th style="text-align: center;">TIPO ASENTAMIENTO</th>
						<th style="text-align: center;">ASENTAMIENTO</th>
						<th style="text-align: center;">COSTO INICIAL</th>
						<th style="text-align: center;">COSTO FINAL</th>
						<th style="text-align: center;">ESTATUS</th>

						<th style="text-align: center;">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					
					<?php
					if($l_costos_num== 0){
						?>
						<tr> 
							<td colspan="10" style="text-align: center">
								<h5 class="alert_warning">NO EXISTEN REGISTROS EN LA BASE DE DATOS.</h5>
							</td>
						</tr>
						<?php
					}else{
						do
						{
							?>
							<tr>
							
							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($l_costos_row['sucursal']);?></td>
							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($l_costos_row['empresa']);?></td>
							<td style="text-align: center;"><?php echo $l_costos_row['codigoinicial'];?></td>
							<td style="text-align: center;"><?php echo $l_costos_row['codigofinal'];?></td>
							
							<td style="text-align: center;"><?php echo $l_costos_row['tipoasentamiento'];?></td>
							<td style="text-align: center;"><?php echo $l_costos_row['asentamiento'];?></td>
							<td style="text-align: center;">$<?php echo $l_costos_row['costoinicial'];?></td>
							<td style="text-align: center;">$<?php echo $l_costos_row['costofinal'];?></td>
							<td style="text-align: center;"><?php echo $estatus[$l_costos_row['estatus']];?></td>

							<td style="text-align: center; font-size: 15px;">

									<?php
													//SCRIPT PARA CONSTRUIR UN BOTON
									$bt->titulo = "";
									$bt->icon = "mdi-table-edit";
									$bt->funcion = "aparecermodulos('catalogos/costosenvio/fa_costo.php?idmenumodulo=$idmenumodulo&idcostoenvio=".$l_costos_row['idsucursal_proveedor_codigo']."','main')";
									$bt->estilos = "";
									$bt->permiso = $permisos;
									$bt->tipo = 2;
									$bt->title="EDITAR";
									$bt->class='btn btn_colorgray';
									$bt->armar_boton();


									?>

								</td>


							</tr>
							<?php
						}while($l_costos_row = $db->fetch_assoc($l_costos));
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">
	 $('#tbl_costos').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN COSTOS DE ENVÍO EN LA BASE DE DATOS.",
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
		 	"ordering": true,
        	"info":     false


		} );
</script>


