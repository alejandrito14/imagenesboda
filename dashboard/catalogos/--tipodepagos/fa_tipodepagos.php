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
$lista_tipodepagosresas = $_SESSION['se_litipodepagosresas']; //variables de sesion
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Tipodepagos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$tipodepagos = new Tipodepagos();
$f = new Funciones();
$bt = new Botones_permisos();

$tipodepagos->db = $db;

$tipodepagos->tipo_usuario = $tipousaurio;
$tipodepagos->lista_tipodepagosresas = $lista_tipodepagosresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idtipodepago'])){
	//El formulario es de nuevo registro
	$idtipodepago = 0;

	//Se declaran todas las variables vacias

	 $nombre='';
	 $estatus=1;
	 $confecha=0;
	 $condireccionentrega=0;
	 $visualizar='none';
	$visualizarcuenta='none';
	$cuenta='';
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO TIPO DE PAGO';
	$che3="";
	$habilitarcampo=0;
	$confoto=0;
	$constripe=0;
	$habilitarcampomontofactura=0;
	$chkparafactura=0;
	$chktpv=0;
	$chksinrevision=0;
	$chkcatalogobancos=0;
	$chkcampodigitos=0;
	$chkopciontarjeta=0;
	$chkbotonpagardirecto=0;
	$chkapp=0;
}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del tipodepagos a modificar a nuestra clase tipodepagoss
	$idtipodepago = $_GET['idtipodepago'];
	$tipodepagos->idtipodepago = $idtipodepago;

	//Realizamos la consulta en tabla tipodepagoss
	$result_tipodepagos = $tipodepagos->buscartipodepago();
	$result_tipodepagos_row = $db->fetch_assoc($result_tipodepagos);

	//Cargamos en las variables los datos 

	//DATOS GENERALES
	$nombre=$f->imprimir_cadena_utf8($result_tipodepagos_row['tipo']);
	$estatus = $f->imprimir_cadena_utf8($result_tipodepagos_row['estatus']);
	$confoto=$f->imprimir_cadena_utf8($result_tipodepagos_row['habilitarfoto']);
	$constripe=$f->imprimir_cadena_utf8($result_tipodepagos_row['constripe']);
	$cuenta=$f->imprimir_cadena_utf8($result_tipodepagos_row['cuenta']);
	$clavepublica = $f->imprimir_cadena_utf8($result_tipodepagos_row['clavepublica']);
	$claveprivada = $f->imprimir_cadena_utf8($result_tipodepagos_row['claveprivada']);
	$porcentajecomision = $f->imprimir_cadena_utf8($result_tipodepagos_row['comisionporcentaje']);
	$montotransaccion = $f->imprimir_cadena_utf8($result_tipodepagos_row['comisionmonto']);
	$porcentajeimpuesto = $f->imprimir_cadena_utf8($result_tipodepagos_row['impuesto']);
	$chkparafactura=$result_tipodepagos_row['factura'];

	$habilitarcampo=$f->imprimir_cadena_utf8($result_tipodepagos_row['habilitarcampomonto']);

	$habilitarcampomontofactura=$result_tipodepagos_row['habilitarcampomontofactura'];
	$habilitartiposervicio=$result_tipodepagos_row['habilitartiposervicio'];


$chktpv=$result_tipodepagos_row['habilitartpv'];
$habilitartpv=$result_tipodepagos_row['habilitartpv'];
$chksinrevision=$result_tipodepagos_row['habilitarsinrevision'];
$chkcatalogobancos=$result_tipodepagos_row['habilitarcatalogobanco'];
$chkcampodigitos=$result_tipodepagos_row['habilitarcampodigitos'];
$chkopciontarjeta=$result_tipodepagos_row['habilitaropciontarjeta'];
$chkbotonpagardirecto=$result_tipodepagos_row['habilitarpagar'];
	
$chkapp=$result_tipodepagos_row['habilitarapp'];
	$che="";
	$visualizarcuenta='none';
	if ($confoto==1) {
		$che="checked";
		$visualizarcuenta='block';
	}
	$visualizar='none';
	$che2="";

	if ($constripe==1) {
		$che2="checked";
		$visualizar='block';
	}

	$che3="";

	if ($habilitarcampo==1) {
		$che3="checked";
	}
	$che5="";
	if ($chkparafactura==1) {
		$che5="checked";
	}

	$che4="";

	if ($habilitarcampomontofactura==1) {
		$che4="checked";
	}

	$che7="";
	$che8="";
	$che9="";
	$che10="";
	$che11="";
	$che12="";
	$$che13="";

	if($chktpv==1){
		$che7="checked";

	}
if($chksinrevision==1){
			$che8="checked";

}
if($chkcatalogobancos==1){
			$che9="checked";

}
if($chkcampodigitos==1){
			$che10="checked";

}
if($chkopciontarjeta==1){
			$che11="checked";

}
if($chkbotonpagardirecto==1){
		$che12="checked";


}

if ($chkapp==1) {
		$che13="checked";
	# code...
}


	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR TIPO DE PAGO';

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

<form id="f_tipodepagos" name="f_tipodepagos" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R'); if(resp==1){ 
						Guardartipopago('f_tipodepagos','catalogos/tipodepagos/vi_tipodepagos.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idtipodepagos == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_tipodepagosresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ Guardartipodepagosresa('f_tipodepagosresa','catalogos/tipodepagosresas/fa_tipodepagosresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/tipodepagos/vi_tipodepagos.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE TIPOS DE PAGO</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idtipodepago; ?>" />
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
				<div class="col-md-6">
				<div class="card-body">
					
					
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">

							<div class="form-group m-t-20">
								<label>*NOMBRE:</label>
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombre; ?>" title="NOMBRE" placeholder='NOMBRE'>
							</div>

							<div class="form-group">
								<label>HABILITAR CUENTA PARA TRANSFERENCIA:</label>
								<input type="checkbox" class="" id="confoto" name="confoto" onchange="Habilitarfoto()" value="<?php echo $confoto; ?>" title="CON FOTO" placeholder='CON FOTO' <?php echo $che ?>>
							</div>


							<div class="form-group cuenta" style="display: <?php echo $visualizarcuenta;?>;">
								<label>CUENTA:</label>
								<textarea type="text" class="form-control" id="cuenta" name="cuenta"  title="CUENTA" placeholder='CUENTA'><?php echo $cuenta; ?></textarea>
							</div>

								<div class="form-group">
								<label>HABILITAR CAMPO ¿Con cuanto pagas? :</label>
								<input type="checkbox" class="" id="habilitarcampomonto" name="habilitarcampomonto" onchange="habilitarmonto()" value="<?php echo $habilitarcampo; ?>" title="HABILITAR CAMPO" placeholder='HABILITAR CAMPO' <?php echo $che3?>>
							</div>
							

							<div class="form-group">
								<label>HABILITAR STRIPE:</label>
								<input type="checkbox" class="" id="constripe" name="constripe" onchange="habilitarstripe()" value="<?php echo $constripe; ?>" title="HABILITAR STRIPE" placeholder='HABILITAR STRIPE' <?php echo $che2?>>
							</div>


						


							<div class="form-group" style="display: none;">
								<label>HABILITAR CAMPO DE MONTO FACTURACIÓN :</label>
								<input type="checkbox" class="" id="habilitarcampomontofactura" name="habilitarcampomontofactura" onchange="habilitarmontofactura()" value="<?php echo $habilitarcampomontofactura; ?>" title="HABILITAR CAMPO DE MONTO FACTURACIÓN" placeholder='HABILITAR DE MONTO FACTURACIÓN' <?php echo $che4?>>
							</div>

							<div class="form-group privada" style="display: <?php echo $visualizar;?>;">
								<label>CLAVE PRIVADA:</label>
								<input type="text" class="form-control" id="claveprivada" name="claveprivada" value="<?php echo $claveprivada; ?>" title="CLAVE PRIVADA" placeholder='CLAVE PRIVADA'>
							</div>

							<div class="form-group publica" style="display: <?php echo $visualizar;?>;">
								<label>CLAVE PUBLICA:</label>
								<input type="text" class="form-control" id="clavepublica" name="clavepublica" value="<?php echo $clavepublica; ?>" title="CLAVE PUBLICA" placeholder='CLAVE PUBLICA'>
							</div>

							<div class="form-group publica" style="display: <?php echo $visualizar;?>;">
								<label>PORCENTAJE DE COMISIÓN:</label>
								<input type="text" class="form-control" id="porcentajecomision" name="porcentajecomision" value="<?php echo $porcentajecomision; ?>" title="PORCENTAJE COMISION" placeholder='PORCENTAJE DE COMISIÓN'>
							</div>

							<div class="form-group publica" style="display: <?php echo $visualizar;?>;">
								<label>MONTO POR TRANSACCIÓN:</label>
								<input type="text" class="form-control" id="montotransaccion" name="montotransaccion" value="<?php echo $montotransaccion; ?>" title="MONTO TRANSACCION" placeholder='MONTO POR TRANSACCIÓN'>
							</div>

							<div class="form-group publica" style="display: <?php echo $visualizar;?>;">
								<label>PORCENTAJE DE IMPUESTO:</label>
								<input type="text" class="form-control" id="porcentajeimpuesto" name="porcentajeimpuesto" value="<?php echo $porcentajeimpuesto; ?>" title="PORCENTAJE IMPUESTO" placeholder='PORCENTAJE DE IMPUESTO'>
							</div>

								<div class="form-group" style="display: none;">
								<label>HABILITAR TIPO DE PAGO PARA FACTURA:</label>
								<input type="checkbox" class="" id="chkparafactura" name="chkparafactura"  title="" onchange="Habilitarparafactura()" value="<?php echo $chkparafactura; ?>"placeholder='' <?php echo $che5 ?>>
							</div>

							<!-- <div class="form-group">
								<label>HABILITAR EN VALIDACIÓN:</label>
								<input type="checkbox" class="" id="chkparaagendar" name="chkparaagendar"  title="" onchange="Habilitarparaagendar()" value="<?php echo $chkparaagendar; ?>"placeholder='' <?php echo $che5 ?>>
							</div> -->

							<div class="form-group">
								<label>HABILITAR PARA LA APP:</label>
								<input type="checkbox" class="" id="chkapp" name="chkapp"  title="" onchange="Habilitarparaapp()" value="<?php echo $chkapp; ?>"placeholder='' <?php echo $che13 ?>>
							</div>

							<!-- <div class="form-group">
								<label>HABILITAR TPV:</label>
								<input type="checkbox" class="" id="chktpv" name="chktpv"  title="" onchange="Habilitarparatv()" value="<?php echo $chktpv; ?>"placeholder='' <?php echo $che7 ?>>
							</div> -->

							<div class="form-group">
								<label>HABILITAR SIN REVISIÓN (El pago es aceptado directamente):</label>
								<input type="checkbox" class="" id="chksinrevision" name="chksinrevision"  title="" onchange="Habilitarsinrevision()" value="<?php echo $chksinrevision; ?>"placeholder='' <?php echo $che8 ?>>
							</div>


								<div class="form-group">
								<label>HABILITAR CATÁLOGO DE BANCOS:</label>
								<input type="checkbox" class="" id="chkcatalogobancos" name="chkcatalogobancos"  title="" onchange="Habilitarcatalogobancos()" value="<?php echo $chkcatalogobancos; ?>"placeholder='' <?php echo $che9 ?>>
							</div>

								<div class="form-group">
								<label>HABILITAR CAMPO DE INGRESO DE DÍGITOS PARA EL BANCO:</label>
								<input type="checkbox" class="" id="chkcampodigitos" name="chkcampodigitos"  title="" onchange="Habilitarcampodigitos()" value="<?php echo $chkcampodigitos; ?>"placeholder='' <?php echo $che10 ?>>
							</div>

								<div class="form-group">
								<label>HABILITAR LA OPCIÓN DE TIPO DE TARJETA(crédito/débito):</label>
								<input type="checkbox" class="" id="chkopciontarjeta" name="chkopciontarjeta"  title="" onchange="Habilitaropciontarjeta()" value="<?php echo $chkopciontarjeta; ?>"placeholder='' <?php echo $che11 ?>>
							</div>

									<div class="form-group">
								<label>HABILITAR BOTÓN PAGAR DIRECTO(
									Habilita el boton pagar desde que se escoge el tipo de pago):</label>
								<input type="checkbox" class="" id="chkbotonpagardirecto" name="chkbotonpagardirecto"  title="" onchange="Habilitarbotonpagardirecto()" value="<?php echo $chkbotonpagardirecto; ?>"placeholder='' <?php echo $che12 ?>>
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


				<div class="card" style="" id="divhorarios">
				<div class="card-header" style="">

				</div>
				<div class="card-body">
						<div style="margin-top: 3em;margin-left: 1em;">

							<div class="row">
								<div class="col-md-12">
									<div class="form-check" style="margin-bottom: 1em;">
                    
					<input type="checkbox" class="form-check-input " name="v_tiposervicio" id="v_tiposervicio" value="0" onchange="Desplegartiposerviciotipo()" style="top: -0.3em;">
					<label class="form-check-label">POR TIPO SERVICIO</label>
			</div>
								
									
								</div>
								<div class="col-md-3">
										
									</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="divtiposervicio" style="display: none;">
							<div class="row">
								<div class="col-md-12">
									<!-- <button class="btn btn-primary" type="button" style=" float: right;   margin-top: -1em;" onclick="AgregarTipopago()">NUEVO TIPO DE SERVICIO</button> -->
								</div>
								
							</div>
								
							<div id="tiposervicios">
								<div class="form-group m-t-20">  
		                        <input type="text" class="form-control" name="buscadortipo_" id="buscadortipo_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadortipo_','.pasucat_')" style="    margin-bottom: 1em;">
		                        <div id="todostiposervicios" style="    overflow: scroll;height: 200px;"></div>
		                    </div>





							</div>
						</div>

								</div>
							</div>
						


					</div>
				</div>
			</div>


				<div class="card" style="" id="divtpv">
				<div class="card-header" style="">

				</div>
				<div class="card-body">
						<div style="margin-top: 3em;margin-left: 1em;">

							<div class="row">
								<div class="col-md-12">
							

				<div class="form-check">
					<input type="checkbox"  style="    top: -0.3em;" class="form-check-input " id="chkparatpv" name="chkparatpv"  title="" onchange="Habilitarparatpv()" value="<?php echo $habilitartpv; ?>"placeholder='' <?php echo $che7 ?>>
								<label style="">HABILITAR PARA TPV:</label>
								
							</div>
								
									
								</div>
								<div class="col-md-3">
										
									</div>
							</div>
							<div class="row">
								<div class="col-md-6">
							<div class="divusuarios" style="display: none;    margin-left: 10px;">
							<div class="row">
								<div class="col-md-12">
									<!-- <button class="btn btn-primary" type="button" style=" float: right;   margin-top: -1em;" onclick="AgregarTipopago()">NUEVO TIPO DE SERVICIO</button> -->
								</div>
								
							</div>
								
							<div id="usuarios">
								<div class="form-group m-t-20">  
		          <input type="text" class="form-control" name="buscadorusu_" id="buscadorusu_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorusu_','.pasusuario_')" style="    margin-bottom: 1em;">
		           <div id="todosusuariossistema" style="    overflow: scroll;height: 200px;"></div>
		                    </div>





							</div>
						</div>

								</div>
							</div>
						


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
<style type="text/css">
	input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

input[type=number] { -moz-appearance:textfield; }
</style>

<script>
	var idtipodepago='<?php echo $idtipodepago ?>';
	var habilitartiposervicio='<?php echo $habilitartiposervicio ?>';

	var habilitartpv='<?php echo $habilitartpv ?>';
	CargarUsuariosSistema();


	if (idtipodepago>0) {

		if (habilitartiposervicio==1) {
			$(".divtiposervicio").css('display','block');
			$("#v_tiposervicio").val(habilitartiposervicio);
			$("#v_tiposervicio").attr('checked',true);
			CargarTipoServicios2();
		}

		if (habilitartpv==1) {

			$(".divtpv").css('display','block');
			 $("#chkparatpv").val(habilitartpv);
			 $("#chkparatpv").attr('checked',true);

			$(".divusuarios").css('display','block');
		}

		ObtenerCategoriasTipo(idtipodepago);


	ObtenerUsuariosRelacion(idtipodepago);

	}


</script>


<!-- <script>
	var idtipodepago='<?php echo $idtipodepago ?>';
	var habilitartiposervicio='<?php echo $habilitartiposervicio ?>';
var habilitartpv='<?php echo $habilitartpv ?>';
	CargarUsuariosSistema();


	if (idtipodepago>0) {

		if (habilitartiposervicio==1) {
			$(".divtiposervicio").css('display','block');
			$("#v_tiposervicio").val(habilitartiposervicio);
			$("#v_tiposervicio").attr('checked',true);
			CargarTipoServicios2();
		}
		if (habilitartpv==1) {

				$(".divtpv").css('display','block');
			 $("#chkparatpv").val(habilitartpv);
			 $("#chkparatpv").attr('checked',true);

					$(".divusuarios").css('display','block');
		}

		//ObtenerCategoriasTipo(idtipodepago);
		ObtenerUsuariosRelacion(idtipodepago);
	}

</script> -->

<?php

?>