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
$lista_opcionespedidoresas = $_SESSION['se_liopcionespedidoresas']; //variables de sesion
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Opcionespedido.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$opcionespedido = new Opcionespedido();
$f = new Funciones();
$bt = new Botones_permisos();

$opcionespedido->db = $db;

$opcionespedido->tipo_usuario = $tipousaurio;
$opcionespedido->lista_opcionespedidoresas = $lista_opcionespedidoresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idopcionespedido'])){
	//El formulario es de nuevo registro
	$idopcionespedido = 0;

	//Se declaran todas las variables vacias

	 $nombre='';
	 $estatus=1;
	 $confecha=0;
	 $condireccionentrega=0;
	 $habilitaretiqueta=0;
	 $habilitarmensaje=0;
	 $habilitarsumamonto=0;
	 $che="";
	 $che2="";
	 $che4="";
	 $che5="";
	 $che6="";
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVA OPCIÓN DE PEDIDO';

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del opcionespedido a modificar a nuestra clase opcionespedidos
	$idopcionespedido = $_GET['idopcionespedido'];
	$opcionespedido->idopcionespedido = $idopcionespedido;

	//Realizamos la consulta en tabla opcionespedidos
	$result_opcionespedido = $opcionespedido->buscaropcionespedido();
	$result_opcionespedido_row = $db->fetch_assoc($result_opcionespedido);

	//Cargamos en las variables los datos 

	//DATOS GENERALES
	$nombre=$f->imprimir_cadena_utf8($result_opcionespedido_row['opcionpedido']);
	$estatus = $f->imprimir_cadena_utf8($result_opcionespedido_row['estatus']);
	$confecha=$result_opcionespedido_row['confecha'];
	$condireccionentrega=$result_opcionespedido_row['condireccionentrega'];
	//$habilitarcampomonto=$result_opcionespedido_row['campomonto'];
	$habilitaretiqueta=$result_opcionespedido_row['habilitaretiqueta'];
	$nombreetiqueta=$result_opcionespedido_row['nombreetiqueta'];

	$habilitarmensaje=$result_opcionespedido_row['habilitarmensaje'];
	$mensaje=$result_opcionespedido_row['mensaje'];

	$habilitarsumamonto=$result_opcionespedido_row['habilitarsumaenvio'];

	$che="";
	if ($confecha==1) {
		$che="checked";
	}

	$che2="";
	if ($condireccionentrega==1) {
		$che2="checked";
	}


	$che4="";



	if ($habilitaretiqueta==1) {
		$che4="checked";
	}

	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR OPCIÓN DE PEDIDO';
	$che5="";
	if ($habilitarmensaje==1) {
		$che5="checked";
	}

	$che6="";
	if ($habilitarsumamonto==1) {
		$che6="checked";
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

<form id="f_opcionespedido" name="f_opcionespedido" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R'); if(resp==1){ Guardaropcionpedido('f_opcionespedido','catalogos/opcionespedido/vi_opcionespedido.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idopcionespedidos == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_opcionespedidoresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ Guardaropcionespedidoresa('f_opcionespedidoresa','catalogos/opcionespedidoresas/fa_opcionespedidoresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/opcionespedido/vi_opcionespedido.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE OPCIONES DE PEDIDO</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idopcionespedido; ?>" />
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
								<label>HABILITAR APARTADO DE FECHA DE ENTREGA:</label>
								<input type="checkbox" class="" id="confecha" name="confecha" onchange="Cambiarfecha()" value="<?php echo $confecha; ?>" title="CON FECHA" placeholder='CON FECHA' <?php echo $che ?>>
							</div>


							<div class="form-group">
								<label>HABILITAR APARTADO DE DIRECCIÓN DE ENTREGA:</label>
								<input type="checkbox" class="" id="condireccionentrega" name="condireccionentrega" onchange="habilitardireccion()" value="<?php echo $condireccionentrega; ?>" title="CON DIRECCIÓN DE ENTREGA" placeholder='CON DIRECCIÓN DE ENTREGA' <?php echo $che2?>>
							</div>


						<!-- 	<div class="form-group">
								<label>HABILITAR CAMPO MONTO:</label>
								<input type="checkbox" class="" id="habilitarcampomonto" name="habilitarcampomonto" onchange="habilitarmonto()" value="<?php echo $habilitarcampomonto; ?>" title="HABILITAR CAMPO" placeholder='HABILITAR CAMPO' <?php echo $che3?>>
							</div> -->


							<div class="form-group">
								<label>HABILITAR ETIQUETA DE ENVIADO:</label>
								<input type="checkbox" id="habilitaretiqueta" name="habilitaretiqueta" onchange="habilitaretiqueta1()" value="<?php echo $habilitaretiqueta; ?>" title="HABILITAR ETIQUETA" placeholder='HABILITAR ETIQUETA' <?php echo $che4?>>
							</div>


							<div class="form-group" id="etiqueta" style="display: none;">
								<label>CONTENIDO DE LA ETIQUETA DE ENVIADO:</label>
								<input type="text" class="form-control" name="nombreetiqueta" id="nombreetiqueta" value="<?php echo $nombreetiqueta ?>" title="NOMBRE DE ETIQUETA" placeholder="NOMBRE DE ETIQUETA">

							</div>



							<div class="form-group">
								<label>HABILITAR MENSAJE DESCRIPTIVO:</label>
								<input type="checkbox" id="habilitarmensaje" name="habilitarmensaje" onchange="habilitarmensaje1()" value="<?php echo $habilitarmensaje; ?>" 
								title="HABILITAR MENSAJE" placeholder='HABILITAR MENSAJE' <?php echo $che5?>>
							</div>


							<div class="form-group" id="mensaje" style="display: none;">
								<label>CONTENIDO DEL MENSAJE DESCRIPTIVO:</label>
								<input type="text" class="form-control" name="mensaje" id="mensaje" value="<?php echo $mensaje ?>" title="MENSAJE" placeholder="MENSAJE">

							</div>

							<div class="form-group">
								<label>HABILITAR SUMA DEL ENVÍO AL MONTO TOTAL:</label>
								<input type="checkbox" id="habilitarsumamonto" name="habilitarsumamonto" onchange="habilitarsumamonto1()" value="<?php echo $habilitarsumamonto; ?>" 
								title="HABILITAR SUMA DE ENVÍO AL MONTO TOTAL" placeholder='HABILITAR SUMA DE ENVÍO AL MONTO TOTAL' <?php echo $che6?>>
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
<!-- <script  type="text/javascript" src="./js/mayusculas.js"></script>
 -->

 <script type="text/javascript">
 	var habilitaretiqueta='<?php echo $habilitaretiqueta; ?>';

 	if (habilitaretiqueta==1) {
 		habilitaretiqueta1();
 	}

 		var habilitarmensaje='<?php echo $habilitarmensaje; ?>';

 	if (habilitarmensaje==1) {
 		habilitarmensaje1();
 	}

 </script>
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