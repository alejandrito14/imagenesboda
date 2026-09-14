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
$idmenumodulo = $_GET['idmenumodulo'];

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Proveedores.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];
//Se crean los objetos de clase
$db = new MySQL();
$pro = new Proveedores();
$f = new Funciones();
$bt = new Botones_permisos();

$pro->db = $db;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idproveedor'])){
	//El formulario es de nuevo registro
	$idproveedor = 0;

	//Se declaran todas las variables vacias
	$empresa ="";
	$nombre="";
	$celular="";
	$telefono="";
	$email="";
	$idpais=0;
	$idestado=0;
	$idmunicipio=0;
	

	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO PROVEEDOR';
	$estatus=1;

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id de la empresa a modificar a nuestra clase empresas
	$idproveedor = $_GET['idproveedor'];
	$pro->idproveedor = $idproveedor;


	//Realizamos la consulta en tabla empresas
	$result_proveedores = $pro->buscarproveedor();

	$result_proveedores_row = $db->fetch_assoc($result_proveedores);
	//Cargamos en las variables los datos de las empresas

	//DATOS GENERALES
	$empresa = $f->imprimir_cadena_utf8($result_proveedores_row['empresa']);
	$nombre=$f->imprimir_cadena_utf8($result_proveedores_row['nombre']);
	$celular=str_replace("+52","",$f->imprimir_cadena_utf8($result_proveedores_row['celular']));
	$telefono=$f->imprimir_cadena_utf8($result_proveedores_row['telefono']);
	$email=$f->imprimir_cadena_utf8($result_proveedores_row['email']);

	$estatus=$f->imprimir_cadena_utf8($result_proveedores_row['estatus']);
	$idpais=$result_proveedores_row['idpais'];
	$idestado=$result_proveedores_row['idestado'];
	$idmunicipio=$result_proveedores_row['idmunicipio'];

	$col = "col-md-12";
	$ver = "";
	$titulo='EDITAR PROVEEDOR';

	if ($idpais=='') {
		$idpais=0;
	}
	if ($idestado=='') {
		$idestado=0;
	}
	if ($idmunicipio=='') {
		$idmunicipio=0;
	}
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

<form id="f_proveedor" name="f_proveedor" method="post" action="form-group">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo;?></h4>

			<div style="float: right;">
				
				<?php 
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_empresa','','R','v_nombre','','R','v_celular','','R'); if(resp==1){ GuardarProveedor('f_proveedor','catalogos/proveedores/vi_proveedores.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;

					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
					if($idproveedor == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/proveedores/vi_proveedores.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i>LISTA DE PROVEEDORES</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idproveedor; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>

	
	<div class="row">
		<div class="<?php echo $col; ?> ">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
					<!--<h5>DATOS</h5>-->

					
				</div>

				<div class="card-body">
					
						<div class="col-md-6">
					<div class="tab-content tabcontent-border">
						
							<div class="form-group m-t-20">
								<label>*NOMBRE DE LA EMPRESA:</label>
								<input type="text" class="form-control" id="v_empresa" name="v_empresa" value="<?php echo $empresa; ?>" title="EMPRESA">
							</div>
							<div class="form-group m-t-20">
								<label>*NOMBRE DEL ENCARGADO:</label>
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombre; ?>" title="NOMBRE DEL ENCARGADO">
							</div>

						<div class="form-group m-t-20">
							<label>PAIS:</label>
							<select style="text-transform: uppercase;"  id="v_pais" class="form-control" onchange="ObtenerEstado(0,$(this).val())" tabindex="113"></select>
						</div>


						<div class="form-group m-t-20">
							<label>ESTADO:</label>
							<select  style="text-transform: uppercase;" id="v_estado" class="form-control" onchange="ObtenerMunicipios(0,$(this).val())" tabindex="114">
								<option value="0">SELECCIONAR ESTADO</option>
							</select>
						</div>


						<div class="form-group m-t-20">
							<label>MUNICIPIO:</label>
							<select style="text-transform: uppercase;"  id="v_municipio" class="form-control" tabindex="115">
								<option value="0">SELECCIONAR MUNICIPIO</option>
							</select>
						</div>


							
							<div class="form-group m-t-20">
								<label>*CELULAR:</label>
								<input type="text" class="form-control" id="v_celular" name="v_celular" value="<?php echo $celular; ?>" title="CELULAR">
							</div>
						
							<div class="form-group m-t-20">
								<label>TEL&Eacute;FONO:</label>
								<input type="text" class="form-control" id="v_telefono" name="v_telefono" value="<?php echo $telefono; ?>" title="TELÉFONO">
							</div>


							<div class="form-group m-t-20">
								<label>EMAIL:</label>
								<input type="text" class="form-control" id="v_email" name="v_email" value="<?php echo $email; ?>" title="EMAIL">
							</div>

							<div class="form-group m-t-20">
								<label>ESTATUS:</label>
								<select class="form-control" id="v_estatus" name="v_estatus">
									<option value="1" <?php if(1==$estatus){echo "selected";}?>>ACTIVADO</option>
									<option value="0" <?php if(0==$estatus){echo "selected";}?>>DESACTIVADO</option>
								</select>
								
							</div>

						
					</div>
					</div>
				</div>
			</div>
		</div>

	
	</div>
</form>

<script type="text/javascript">
	
	


	ObtenerPais(0);
	var idproveedor='<?php echo $idproveedor;?>';
	var idpais='<?php echo $idpais;?>';
	var idestado='<?php echo $idestado;?>';
	var idmunicipio='<?php echo $idmunicipio;?>';


	if (idpais!=0) {
		$("#v_pais").val(idpais);

		if (idestado>0) {
			ObtenerEstado(<?php echo $idestado; ?>,<?php echo $idpais;?>);
		}
		if (idmunicipio>0) {
		ObtenerMunicipios(<?php echo $idmunicipio; ?>,<?php echo $idestado; ?>);	
		}
	
	}

	

	$('#v_pais').chosen();
	$('#v_estado').chosen();
	$('#v_municipio').chosen();
	phoneFormattercel('v_celular');
	phoneFormattercel('v_telefono');
	phoneFormatter2('v_celular');
	phoneFormatter2('v_telefono');
</script>
<script  type="text/javascript" src="./js/mayusculas.js"></script>

<?php

?>