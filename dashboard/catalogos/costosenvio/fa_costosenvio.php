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
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new CostoEnvio();
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



	$codigopostalinicial=$result_codigopostalcosto_row['codigopostalinicial'];
	$codigopostalfinal=$result_codigopostalcosto_row['codigopostalfinal'];
	$costoinicial=$result_codigopostalcosto_row['costoinicial'];
	$costofinal=$result_codigopostalcosto_row['costofinal'];
	$idproveedor=$result_codigopostalcosto_row['idproveedor'];
	//Cargamos en las variables los datos 

	$idpais1=$result_codigopostalcosto_row['idpais1'];
	$idpais2=$result_codigopostalcosto_row['idpais2'];
	$idestado1=$result_codigopostalcosto_row['idestado1'];
	$idestado2=$result_codigopostalcosto_row['idestado2'];
	$idmunicipio1=$result_codigopostalcosto_row['idmunicipio1'];
	$idmunicipio2=$result_codigopostalcosto_row['idmunicipio2'];

	

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
				if($idcodigopostalcostos == 0)
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
						<label>PAIS:</label>
						<select style="text-transform: uppercase;"  id="v_pais" class="form-control" name="v_pais" onchange="ObtenerEstadoIdElemento(0,$(this).val(),'v_estado')" tabindex="112"></select>
					</div>


					<div class="form-group m-t-20">
						<label>ESTADO:</label>
						<select  style="text-transform: uppercase;" id="v_estado" class="form-control" name="v_estado" onchange="ObtenerMunicipiosIdElemento(0,$(this).val(),'v_municipio');ObtenerCodigospostalesmunicipios('v_pais','v_estado','v_municipio','codigopostalinicial','');" tabindex="113">
							<option value="0">Seleccionar estado</option>
						</select>
					</div>


					<div class="form-group m-t-20">
						<label>MUNICIPIO:</label>
						<select style="text-transform: uppercase;" onchange="ObtenerCodigospostalesmunicipios('v_pais','v_estado','v_municipio','codigopostalinicial','');"  name="v_municipio" id="v_municipio" class="form-control" tabindex="114">
							<option value="0">Seleccionar municipio</option>
						</select>
					</div>

				
					<div class="form-group m-t-20">
								<label>*CÓDIGO POSTAL INICIAL:</label>
								<select id="codigopostalinicial" name="codigopostalinicial" class="form-control">
									<option value="0">SELECCIONAR CÓDIGO POSTAL</option>
								</select>
					</div>


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
								<select id="codigopostalfinal" name="codigopostalfinal" class="form-control">
									<option value="0">SELECCIONAR CÓDIGO POSTAL</option>
								</select>
							</div>


							<div class="form-group m-t-20">
								<label>*COSTO INICIAL:</label>
								<input type="number" name="costoinicial" id="costoinicial" class="form-control" placeholder="$0.00" />
								
							</div>

							<div class="form-group m-t-20">
								<label>*COSTO FINAL:</label>
								<input type="number" name="costofinal" id="costofinal" class="form-control"  placeholder="$0.00" />
									
								
							</div>

							<div class="form-group m-t-20">
								<label>*PROVEEDOR:</label>
								<select id="proveedor" name="proveedor" class="form-control">
									<option value="0">Seleccionar</option>
								</select>
							</div>
							
						<div class="form-group m-t-20">
							<label>ESTATUS:</label>
							<select name="v_estatus" id="v_estatus" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVO</option>
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
	ObtenerPaisIdelemento(0,'v_pais');
	ObtenerPaisIdelemento(0,'v_pais2');
	ObtenerProveedores(0,'proveedor');

	var idcodigopostalcosto='<?php echo $idcodigopostalcosto;?>';

	if (idcodigopostalcosto>0){




		var idpais1='<?php echo $idpais1; ?>';
		var idpais2='<?php echo $idpais2; ?>';

		var idestado1='<?php echo $idestado1;?>';
		var idestado2='<?php echo $idestado2;?>';


		var idmunicipio1='<?php echo $idmunicipio1;?>';
		var idmunicipio2='<?php echo $idmunicipio2;?>';

		var codigopostalinicial='<?php echo ?>';
		var codigopostalfinal='<?php echo ?>';
	
		ObtenerPaisIdelemento(idpais1,'v_pais');
		ObtenerPaisIdelemento(idpais2,'v_pais2');

		ObtenerEstadoIdElemento(idestado1,idpais1,'v_estado');

		ObtenerEstadoIdElemento(idestado2,idpais2,'v_estado2');


		ObtenerMunicipiosIdElemento(idmunicipio1,idestado1,'v_municipio');


		ObtenerMunicipiosIdElemento(idmunicipio2,idestado2,'v_municipio2');

		ObtenerCodigospostalesmunicipios('v_pais','v_estado','v_municipio','codigopostalinicial',codigopostalinicial);

		ObtenerCodigospostalesmunicipios('v_pais2','v_estado2','v_municipio2','codigopostalfinal',codigopostalfinal);

	}

</script>

<?php

?>