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
require_once("../../clases/class.CostoEnvio.php");
require_once("../../clases/class.CodigoPostal.php");

require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new CostoEnvio();
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
	$idcodigopostalcosto = 0;

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
	$idcodigopostalcosto = $_GET['idcostoenvio'];
	$emp->idcodigopostalcosto = $idcodigopostalcosto;

	//Realizamos la consulta en tabla codigopostalcostos
	$result_codigopostalcosto = $emp->buscarcodigopostalcosto();
	$result_codigopostalcosto_row = $db->fetch_assoc($result_codigopostalcosto);



	$idsucursal=$result_codigopostalcosto_row['idsucursal'];
	$codigopostalfinal=$result_codigopostalcosto_row['codigofinal'];
	$costoinicial=$result_codigopostalcosto_row['costoinicial'];
	$costofinal=$result_codigopostalcosto_row['costofinal'];
	$idproveedor=$result_codigopostalcosto_row['idproveedor'];
	$tipoasentamiento=$result_codigopostalcosto_row['tipoasentamiento'];
	$asentamiento=$result_codigopostalcosto_row['asentamiento'];
	/*$idpais2=$result_codigopostalcosto_row['idpais2'];
	$idestado2=$result_codigopostalcosto_row['idestado2'];
	$idmunicipio2=$result_codigopostalcosto_row['idmunicipio2'];
*/
	$codigo->codigopostal=$codigopostalfinal;
	$estadomuniclave=$codigo->ObtenerClaveMunicipioEstado();

	$idpais2=$estadomuniclave['idpais'];
	$idestado2=$estadomuniclave['idestado'];
	$idmunicipio2=$estadomuniclave['idmunicipio'];



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
					$bt->funcion = "var resp=MM_validateForm('v_pais','','R'); if(resp==1){ Guardarcodigopostalcosto('f_codigopostalcosto','catalogos/costosenvio/vi_costoenvio.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idcodigopostalcosto == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/costosenvio/vi_costoenvio.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE COSTOS DE ENVÍO</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idcodigopostalcosto; ?>" />
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
								<label>*PROVEEDOR:</label>
								<select id="proveedor" name="proveedor" class="form-control">
									<option value="0">Seleccionar</option>
								</select>
							</div>
					
						<label>*PARA PODER SELECCIONAR EL CÓDIGO POSTAL FINAL SE DEBE FILTRAR POR PAIS,ESTADO,MUNICIPIO,TIPO DE ASENTAMIENTO,ASENTAMIENTO</label>



					<div class="form-group m-t-20">
						<label>PAIS:</label>
						<select style="text-transform: uppercase;" name="v_pais2"  id="v_pais2" class="form-control" onchange="ObtenerEstadoIdElemento(0,$(this).val(),'v_estado2')" tabindex="112"></select>
					</div>


					<div class="form-group m-t-20">
						<label>ESTADO:</label>
						<select  style="text-transform: uppercase;" name="v_estado2" id="v_estado2" class="form-control" onchange="ObtenerMunicipiosIdElemento(0,$(this).val(),'v_municipio2')" tabindex="113">
							<option value="0">Seleccionar estado</option>
						</select>
					</div>


					<div class="form-group m-t-20">
						<label>MUNICIPIO:</label>
						<select style="text-transform: uppercase;" name="v_municipio2" onchange="ObtenerCodigospostalesmunicipios('v_pais2','v_estado2','v_municipio2','codigopostalfinal','');" id="v_municipio2" class="form-control" tabindex="114">
							<option value="0">Seleccionar municipio</option>
						</select>
					</div>



							<div class="form-group m-t-20">
								<label>*CÓDIGO POSTAL FINAL:</label>

								<select id="codigopostalfinal" onchange="ObtenerTipoAsentamiento('v_pais2','v_estado2','v_municipio2','tipoasentamiento','codigopostalfinal','')" name="codigopostalfinal" class="form-control">
									<option value="0">SELECCIONAR CÓDIGO POSTAL</option>
								</select>
							</div>


							<div class="form-group m-t-20">
								<label>*TIPO ASENTAMIENTO:</label>
								<select id="tipoasentamiento" 
								onchange="ObtenerAsentamientos('v_pais2','v_estado2','v_municipio2','asentamiento','codigopostalfinal','tipoasentamiento','')" name="tipoasentamiento" class="form-control">
									<option value="0">SELECCIONAR TIPO DE ASENTAMIENTO</option>
								</select>
							</div>

							<div class="form-group m-t-20">
								<label>*ASENTAMIENTO:</label>
								<select id="asentamiento" name="asentamiento" class="form-control">
									<option value="0">SELECCIONAR ASENTAMIENTO</option>
								</select>
							</div>


						

							<div class="form-group m-t-20">
								<label>*COSTO INICIAL:</label>
								<input type="number" name="costoinicial" id="costoinicial" class="form-control" value="<?php echo $costoinicial;?>" placeholder="$0.00" />
								
							</div>

							<div class="form-group m-t-20">
								<label>*COSTO FINAL:</label>
								<input type="number" name="costofinal" id="costofinal" class="form-control" value="<?php echo $costofinal; ?>" placeholder="$0.00" />
									
								
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
	ObtenerPaisIdelemento(0,'v_pais2');


	var idcodigopostalcosto='<?php echo $idcodigopostalcosto?>';

	if (idcodigopostalcosto>0) {
		var idsucursal='<?php echo $idsucursal;?>';
		var idproveedor='<?php echo $idproveedor;?>';
		var idpais2='<?php echo $idpais2;?>';
		var idestado2='<?php echo $idestado2;?>';
		var idmunicipio2='<?php echo $idmunicipio2;?>';
		var codigopostalfinal='<?php echo $codigopostalfinal;?>';
		var tipoasentamiento='<?php echo $tipoasentamiento;?>';
		var asentamiento='<?php echo $asentamiento;?>';

		ObtenerSucursales(idsucursal,'sucursal');
		ObtenerProveedores(idproveedor,'proveedor');
		$("#v_pais2").val(idpais2);
		
		ObtenerEstadoIdElemento(idestado2,idpais2,'v_estado2');
		ObtenerMunicipiosIdElemento(idmunicipio2,idestado2,'v_municipio2');
		ObtenerCodigospostalesmunicipios('v_pais2','v_estado2','v_municipio2','codigopostalfinal',codigopostalfinal);
		ObtenerTipoAsentamiento('v_pais2','v_estado2','v_municipio2','tipoasentamiento','codigopostalfinal',tipoasentamiento);

		ObtenerAsentamientos('v_pais2','v_estado2','v_municipio2','asentamiento','codigopostalfinal','tipoasentamiento',asentamiento);





	}else{

			ObtenerSucursales(0,'sucursal');
		ObtenerProveedores(0,'proveedor');

	}

		/*$("#v_pais2").chosen();
		$("#v_estado2").chosen();
		$("#v_municipio2").chosen();
		$("#codigopostalfinal").chosen();
		$("#tipoasentamiento").chosen();
		$("#asentamiento").chosen();*/



</script>
