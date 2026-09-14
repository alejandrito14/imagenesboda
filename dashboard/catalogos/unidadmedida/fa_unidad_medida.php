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

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Unidadmedida.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new UnidadMedida();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idmedida'])){
	//El formulario es de nuevo registro
	$idpresentacion = 0;

	//Se declaran todas las variables vacias
	$nombre = "";
	$medida = "";
	$estatus=1;

	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVA UNIDAD DE MEDIDA';


}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id de la empresa a modificar a nuestra clase empresas
	$idmedida = $_GET['idmedida'];
	$emp->idmedida = $idmedida;

	//Realizamos la consulta en tabla empresas
	$result_presentacion = $emp->buscarMedida();
	$result_presentacion_row = $db->fetch_assoc($result_presentacion);

	//Cargamos en las variables los datos de las empresas

	//DATOS GENERALES
	$nombre = $f->imprimir_cadena_utf8($result_presentacion_row['nombre']);
	$medida = $f->imprimir_cadena_utf8($result_presentacion_row['medidaminima']);
	$estatus=$f->imprimir_cadena_utf8($result_presentacion_row['estatus']);

	$col = "col-md-12";
	$ver = "";
	$titulo='EDITAR UNIDAD DE MEDIDA';

}

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

<form id="f_medida" name="f_medida" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R','v_medida','','R','v_medida','','isNum'); if(resp==1){ GuardarMedida('f_medida','catalogos/unidadmedida/vi_unidad_medida.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->class='btn btn-success';
					$bt->permiso = $permisos;
					
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idpresentacion == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/unidadmedida/vi_unidad_medida.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i>  LISTADO DE UNIDADES DE MEDIDA</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idmedida; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="<?php echo $col; ?>">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
					<!--<h5>DATOS</h5>-->

				</div>

				<div class="card-body">
					
					
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">
							<div class="form-group m-t-20">
								<label>*NOMBRE:</label>
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombre; ?>" placeholder='NOMBRE' title="NOMBRE">
							</div>

							

							<div class="form-group m-t-20">
								<label>*MEDIDAD MINIMA:</label>
								<!--<input class="form-control" id="v_medida" name="v_medida" min="0" step="0.01" type="number" value="<?php echo $medida; ?>" title="MEDIDA MINIMA" >-->
								<input type="text" class="form-control" id="v_medida" name="v_medida" value="<?php echo $medida; ?>" placeholder='0.0' title="MEDIDA MINIMA" >
								
							</div>
							
							<div class="form-group m-t-20">
							<label for="exampleInputEmail1">ESTATUS</label>
							<select name="v_estatus" id="v_estatus" class="form-control">
								<option value="1" <?php if($estatus==1){echo ("selected");}?>>ACTIVADO</option>
								<option value="0" <?php if($estatus==0){echo ("selected");}?>>DESACTIVADO</option>
							</select>
						 </div>

							
						</div>
						
						
					
					</div>
				</div>
			</div>
		</div>


	</div>
</form>
<!-- <script  type="text/javascript" src="./js/mayusculas.js"></script>
 -->
<?php

?>