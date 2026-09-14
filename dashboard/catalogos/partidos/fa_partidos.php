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
require_once("../../clases/class.Partidos.php");
require_once("../../clases/class.Espacios.php");
require_once("../../clases/class.Horarios.php");

require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Partidos();
$f = new Funciones();
$bt = new Botones_permisos();

$espacios = new Espacios();
$espacios->db = $db;

$horarios= new Horarios();
$horarios->db = $db;
$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idpartido'])){
	//El formulario es de nuevo registro
	$idpartido = 0;

	//Se declaran todas las variables vacias
	 $nombre='';
	 $idespacio='';
	 $idhorario='';
	 $estatus=1;
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO PARTIDO';

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del partido a modificar a nuestra clase partidos
	$idpartido = $_GET['idpartido'];
	$emp->idpartido = $idpartido;

	//Realizamos la consulta en tabla partidos
	$result_partido = $emp->buscarpartido();
	$result_partido_row = $db->fetch_assoc($result_partido);


	//Cargamos en las variables los datos 

	//DATOS GENERALES
	$idespacio=$f->imprimir_cadena_utf8($result_partido_row['idespacio']);
	$idhorario = $f->imprimir_cadena_utf8($result_partido_row['idhorario']);
	$estatus = $f->imprimir_cadena_utf8($result_partido_row['estatus']);
	

	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR PARTIDO';





}



$l_espacios = $espacios->ObtenerEspacios();
$result_espacios_row = $db->fetch_assoc($l_espacios);

$l_espacios_num = $db->num_rows($l_espacios);


$l_horarios = $horarios->ObtenerHorarios();
$result_horario_row = $db->fetch_assoc($l_horarios);
$l_horarios_num = $db->num_rows($l_horarios);



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

<form id="f_partido" name="f_partido" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R'); if(resp==1){ GuardarPartido('f_partido','catalogos/partidos/vi_partidos.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idpartidos == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/partidos/vi_partidos.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE partidoS</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idpartido; ?>" />
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
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombre; ?>" title="NOMBRE" placeholder='NOMBRE'>
							</div>

							<div class="form-group m-t-20">
								<label for="">ESPACIO</label>
								<select name="v_espacio" id="v_espacio" class="form-control">
									 <option value="0">SELECCIONAR ESPACIO</option>
							   <?php

							  do
							  {
							?>
								<option  value="<?php echo $result_espacios_row['idespacio'] ?>"  <?php if($result_espacios_row['idespacio'] == $idespacio){ echo "selected"; }?>><?php echo strtoupper($f->imprimir_cadena_utf8($result_espacios_row['nombre']));?></option>
							<?php
							   }while($result_espacios_row = $db->fetch_assoc($l_espacios));
						   ?>
								</select>
							</div>

							<div class="form-group m-t-20">
								<label for="">HORARIO</label>
								<select name="v_horario" id="v_horario" class="form-control">
								<option value="0">SELECCIONAR HORARIO</option>
							   <?php

							  do
							  {
							?>
								<option  value="<?php echo $result_horario_row['idhorario'] ?>"  <?php if($result_horario_row['idhorario'] == $idhorario){ echo "selected"; }?>><?php echo strtoupper($f->imprimir_cadena_utf8($result_horario_row['dia'].'/'.$result_horario_row['mes'].'/'.$result_horario_row['anio'].' '.$result_horario_row['hora']));?></option>
							<?php
							   }while($result_horario_row = $db->fetch_assoc($l_horarios));
						   ?>
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
</form>
<script  type="text/javascript" src="./js/mayusculas.js"></script>



<?php

?>