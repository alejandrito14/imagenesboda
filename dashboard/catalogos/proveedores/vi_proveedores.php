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
require_once("../../clases/class.Proveedores.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$proveedores = new Proveedores();
$bt = new Botones_permisos(); 
$f = new Funciones();

$proveedores->db = $db;


//obtenemos todas las empreas que puede visualizar el usuario.

$proveedores->tipo_usuario = $tipousaurio;
$proveedores->lista_empresas = $lista_empresas;

$l_proveedores = $proveedores->ObtenerTodosProveedores();
$l_proveedores_row = $db->fetch_assoc($l_proveedores);
$l_proveedores_num = $db->num_rows($l_proveedores);

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
		<h5 class="card-title" style="float: left;">LISTADO DE PROVEEDORES</h5>
		
		<div style="float:right;">
			<button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn-primary" style="float: right;display: none;"><i class="mdi mdi-account-search"></i>  BUSCAR</button>			
			
			<?php
		
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVO PROVEEDOR";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('catalogos/proveedores/fa_proveedores.php?idmenumodulo=$idmenumodulo','main');";
				$bt->estilos = "float: right; margin-right:10px;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;
				$bt->title="NUEVO PROVEEDOR";
				

				$bt->armar_boton();
			
			?>
			
			<div style="clear: both;"></div>
		</div>
		
		<div style="clear: both;"></div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive" id="contenedor_proveedores">
			<table id="tbl_proveedores" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						 
						<th style="text-align: center;">EMPRESA </th> 
						<th style="text-align: center;">ENCARGADO</th>
						
						<th style="text-align: center;">CELULAR</th>
						<th style="text-align: center;">TELÉFONO</th>
						<th style="text-align: center;">ESTATUS</th>
						<th style="text-align: center;">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					
					<?php
					if($l_proveedores_num== 0){
						?>
						<tr> 
							<td colspan="6" style="text-align: center">
								<h5 class="alert_warning">NO EXISTEN REGISTROS EN LA BASE DE DATOS.</h5>
							</td>
						</tr>
						<?php
					}else{
						do
						{
							?>
							<tr>
							
						
							<td style="text-align: center;"><?php echo $l_proveedores_row['empresa'];?></td>
							<td style="text-align: center;"><?php echo $l_proveedores_row['nombre'];?></td>
							<td style="text-align: center;"><?php echo $l_proveedores_row['celular'];?></td>
						<td style="text-align: center;"><?php echo $l_proveedores_row['telefono'];?></td>
							<td style="text-align: center;"><?php echo $estatus[$l_proveedores_row['estatus']];?></td>

							<td style="text-align: center; font-size: 15px;">

									<?php
													//SCRIPT PARA CONSTRUIR UN BOTON
									$bt->titulo = "";
									$bt->icon = "mdi-table-edit";
									$bt->funcion = "aparecermodulos('catalogos/proveedores/fa_proveedores.php?idmenumodulo=$idmenumodulo&idproveedor=".$l_proveedores_row['idproveedor']."','main')";
									$bt->estilos = "";
									$bt->permiso = $permisos;
									$bt->tipo = 2;
									$bt->title="EDITAR";
									$bt->class='btn btn_colorgray';
									$bt->armar_boton();


									$bt->titulo = "";
									$bt->icon = "mdi-delete-empty";
									$bt->funcion = "Borrarproveedor('".$l_proveedores_row['idproveedor']."','".$idmenumodulo."')";
									$bt->estilos = "";
									$bt->permiso = $permisos;
									$bt->tipo = 3;
									$bt->title="BORRAR";

									$bt->armar_boton();
												   					
												
							


									?>

								</td>


							</tr>
							<?php
						}while($l_proveedores_row = $db->fetch_assoc($l_proveedores));
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">
	 $('#tbl_proveedores').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PROVEEDORES EN LA BASE DE DATOS.",
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
