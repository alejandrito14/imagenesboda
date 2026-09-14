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

	$habilitarcampo=$f->imprimir_cadena_utf8($result_tipodepagos_row['habilitarcampomonto']);

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
								<label>HABILITAR CUENTA:</label>
								<input type="checkbox" class="" id="confoto" name="confoto" onchange="Habilitarfoto()" value="<?php echo $confoto; ?>" title="CON FOTO" placeholder='CON FOTO' <?php echo $che ?>>
							</div>


							<div class="form-group cuenta" style="display: <?php echo $visualizarcuenta;?>;">
								<label>CUENTA:</label>
								<textarea type="text" class="form-control" id="cuenta" name="cuenta"  title="CUENTA" placeholder='CUENTA'><?php echo $cuenta; ?></textarea>
							</div>


							<div class="form-group">
								<label>HABILITAR STRIPE:</label>
								<input type="checkbox" class="" id="constripe" name="constripe" onchange="habilitarstripe()" value="<?php echo $constripe; ?>" title="HABILITAR STRIPE" placeholder='HABILITAR STRIPE' <?php echo $che2?>>
							</div>


							<div class="form-group">
								<label>HABILITAR CAMPO ¿Con cuanto pagas? :</label>
								<input type="checkbox" class="" id="habilitarcampomonto" name="habilitarcampomonto" onchange="habilitarmonto()" value="<?php echo $habilitarcampo; ?>" title="HABILITAR CAMPO" placeholder='HABILITAR CAMPO' <?php echo $che3?>>
							</div>

							<div class="form-group privada" style="display: <?php echo $visualizar;?>;">
								<label>CLAVE PRIVADA:</label>
								<input type="text" class="form-control" id="claveprivada" name="claveprivada" value="<?php echo $claveprivada; ?>" title="CLAVE PRIVADA" placeholder='CLAVE PRIVADA'>
							</div>


							<div class="form-group publica" style="display: <?php echo $visualizar;?>;">
								<label>CLAVE PUBLICA:</label>
								<input type="text" class="form-control" id="clavepublica" name="clavepublica" value="<?php echo $claveprivada; ?>" title="CLAVE PUBLICA" placeholder='CLAVE PUBLICA'>
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
<script  type="text/javascript" src="./js/mayusculas.js"></script>

<style type="text/css">
	input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

input[type=number] { -moz-appearance:textfield; }
</style>

<?php

?>