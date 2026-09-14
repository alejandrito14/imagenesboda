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




$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.CostoEnviopordia.php");
require_once("../../clases/class.CodigoPostal.php");

require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new CostoEnviopordia();
$codigo = new CodigoPostal();
$codigo->db=$db;
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idcostoenvio'])){
	//El formulario es de nuevo registro
	$idfechaenvio = 0;

	//Se declaran todas las variables vacias
	 $nombre='';
	 $lugar='';
	 $ubicacion='';
	 $estatus=1;
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO COSTO ENVÍO';

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del codigopostalcosto a modificar a nuestra clase codigopostalcostos
	$idfechaenvio = $_GET['idcostoenvio'];
	$emp->idfechaenvio = $idfechaenvio;

	//Realizamos la consulta en tabla codigopostalcostos
	$result_codigopostalcosto = $emp->buscarcostoenvio();
	$result_codigopostalcosto_row = $db->fetch_assoc($result_codigopostalcosto);



	$idsucursal=$result_codigopostalcosto_row['idsucursal'];

	$costoinicial=$result_codigopostalcosto_row['costo'];
	$fecha=$result_codigopostalcosto_row['fecha'];

	$horainicial=$result_codigopostalcosto_row['horainicial'];
	$horafinal=$result_codigopostalcosto_row['horafinal'];

	

	$estatus = $f->imprimir_cadena_utf8($result_codigopostalcosto_row['estatus']);
	

	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR COSTO ENVÍO';

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

<form id="f_codigopostalcosto" name="f_codigopostalcosto" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_pais','','R'); if(resp==1){ Guardarcostodia('f_codigopostalcosto','catalogos/costospordia/vi_costodia.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idfechaenvio == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/costospordia/vi_costodia.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE COSTOS DE ENVÍO</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idfechaenvio; ?>" />
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
					
					<div class="col-md-6">
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">

							<div class="form-group m-t-20">
								<label>*SUCURSAL:</label>
								<select id="sucursal" name="sucursal" class="form-control">
									<option value="0">Seleccionar</option>
								</select>
							</div>

						
							<div class="form-group m-t-20">
								<label>*FECHA:</label>
								<input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha;?>"  />
								
							</div>


							<div class="form-group m-t-20">
								<label>*HORA INICIAL:</label>
								<input type="time" name="horainicial" id="horainicial" class="form-control" value="<?php echo $horainicial;?>"  />
								
							</div>

							<div class="form-group m-t-20">
								<label>*HORA FINAL:</label>
								<input type="time" name="horafinal" id="horafinal" class="form-control" value="<?php echo $horafinal;?>"  />
								
							</div>

						

							<div class="form-group m-t-20">
								<label>*COSTO:</label>
								<input type="number" name="costoinicial" id="costoinicial" class="form-control" value="<?php echo $costoinicial;?>" placeholder="$0.00" />
								
							</div>

							
							
						<div class="form-group m-t-20">
							<label>ESTATUS:</label>
							<select name="v_estatus" id="v_estatus" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVADO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVADO</option>
							</select>
						</div>

						
							
						</div>
						
						
					
					</div>



				</div>
				</div>
			</div>
		</div>


	</div>
</form>

<script type="text/javascript">
	//ObtenerPaisIdelemento(0,'v_pais2');


	var idfechaenvio='<?php echo $idfechaenvio?>';

	if (idfechaenvio>0) {
		var idsucursal='<?php echo $idsucursal;?>';
	

		ObtenerSucursales(idsucursal,'sucursal');
		




	}else{

			ObtenerSucursales(0,'sucursal');

	}

		/*$("#v_pais2").chosen();
		$("#v_estado2").chosen();
		$("#v_municipio2").chosen();
		$("#codigopostalfinal").chosen();
		$("#tipoasentamiento").chosen();
		$("#asentamiento").chosen();*/


</script>
