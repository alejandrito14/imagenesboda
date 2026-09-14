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
require_once("../../clases/class.Categoriasprecios.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$emp = new Categoriasprecios();
$bt = new Botones_permisos(); 
$fu = new Funciones();

$emp->db = $db;


//obtenemos todas las empreas que puede visualizar el usuario.

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$l_empresas = $emp->obtenerTodas();
$l_empresas_row = $db->fetch_assoc($l_empresas);
$l_empresas_num = $db->num_rows($l_empresas);


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





?>

<div class="card">
	<div class="card-body">
		<h5 class="card-title" style="float: left;">LISTADO DE PRECIOS</h5>
		
		<div style="float:right;">
			<button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn_accion" style="float: right;display: none;"><i class="mdi mdi-account-search"></i>FILTRAR</button>			
			
			<?php
			
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVO PRECIO";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('catalogos/categoriasprecio/fa_categoriasprecio.php?idmenumodulo=$idmenumodulo','main');";
				$bt->estilos = "float: right; margin-right:10px;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;
				$bt->title="NUEVA CATEGORIA DE PRECIOS";

				$bt->armar_boton();

			
			?>
			
			<div style="clear: both;"></div>
		</div>
		
		<div style="clear: both;"></div>
	</div>
</div>
	
<div class="card">
	<div class="card-body">
		<div class="table-responsive" id="contenedor_empresas">
			<table id="zero_config" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th> 
						<th>NOMBRE</th> 
						
						
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<tr> 
						<td colspan="7" style="text-align: center">
	  						<h4 class="alert_warning">NO EXISTEN CATEGORIAS DE PRECIOS EN LA BASE DE DATOS.</h4>
		  				</td>
	  				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>





<!-- MODAL FILTRO -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-filtros">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="height: 100%;">
			<div class="modal-header" id="modal-header-filtros">
				<span class="modal-title" id="modal-title" style="font-size: 14px; font-weight: bold;">FILTRO</span> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!--<input type="hidden" name="bandera_modal" id="bandera_modal" value="0">-->
			<div class="modal-body" id="modal-body-filtros">
				<div class="widget-box">
					<div class="widget-content">
						<div class="form-group">
							<label for="exampleInputEmail1">ID</label>
				
								<input type="text" class="form-control" id="b_id" name="b_id"  title="ID">
							
						 </div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">*NOMBRE</label>
							<input type="text" class="form-control" id="b_nombre" name="b_nombre"  title="NOMBRE">
						 </div>
						
						<div class="form-group m-t-20">
								<label>EMPRESA:</label>
								<?php 
									$empresas= $emp->obtenerEmpresas();
									$empresas_num=$db->num_rows($empresas);
									$empresas_row=$db->fetch_assoc($empresas);
								
								?>
								<select  class="form-control" id="b_empresa" name="b_empresa">
									<option value="" >TODOS</option>
									<?php
									do{
									?>
									<option value="<?php echo ($empresas_row['idempresas']);?>" ><?php echo ($empresas_row['empresas']);?></option>
									
									<?php 
										} while($empresas_row=$db->fetch_assoc($empresas));
									?>
								</select>
							</div>

						<div class="span3" style="margin: 0; float: right;">
							<br>
							<button class="btn btn-primary" onClick="Buscar_categoriasproducto(<?php echo $idmenumodulo; ?>);" style="margin-top: 5px;"><i class="mdi mdi-account-search"></i>  BUSCAR</button>
						</div>

						<div style="clear: both;"></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<script type="text/javascript">
	Buscar_categoriasprecios(<?php echo $idmenumodulo; ?>);
</script>