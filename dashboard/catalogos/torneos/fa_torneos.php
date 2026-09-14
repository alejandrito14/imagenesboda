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
$lista_torneosresas = $_SESSION['se_litorneosresas']; //variables de sesion
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Torneos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$torneos = new Torneos();
$f = new Funciones();
$bt = new Botones_permisos();

$torneos->db = $db;

$torneos->tipo_usuario = $tipousaurio;
$torneos->lista_torneosresas = $lista_torneosresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idtorneos'])){
	//El formulario es de nuevo registro
	$idtorneos = 0;

	//Se declaran todas las variables vacias

	 $nombre='';
	 $estatus=1;
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO TORNEO';

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del torneos a modificar a nuestra clase torneos
	$idtorneos = $_GET['idtorneos'];
	$torneos->idtorneo = $idtorneos;

	//Realizamos la consulta en tabla torneos
	$result_torneos = $torneos->buscarTorneo();
	$result_torneos_row = $db->fetch_assoc($result_torneos);


	//Cargamos en las variables los datos 

	//DATOS GENERALES
	$nombre=$f->imprimir_cadena_utf8($result_torneos_row['nombre']);
	$estatus = $f->imprimir_cadena_utf8($result_torneos_row['estatus']);
	$costo=$f->imprimir_cadena_utf8($result_torneos_row['costo']);
	$fechainicial=$f->imprimir_cadena_utf8($result_torneos_row['fechainicial']);
	$fechafinal=$f->imprimir_cadena_utf8($result_torneos_row['fechafinal']);


	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR TORNEO';

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

<form id="f_torneos" name="f_torneos" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R'); if(resp==1){ Guardartorneos('f_torneos','catalogos/torneos/vi_torneos.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idtorneos == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_torneosresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ Guardartorneosresa('f_torneosresa','catalogos/torneosresas/fa_torneosresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/torneos/vi_torneos.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO TORNEOS</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idtorneos; ?>" />
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
								<label>*COSTO:</label>
								<input type="text" class="form-control" id="v_costo" name="v_costo" value="<?php echo $costo; ?>" title="COSTO" placeholder='COSTO'>
							</div>

							<div class="form-group m-t-20">
								<label>*FECHA INICIAL:</label>
								<input type="date" class="form-control" id="v_fechainicial" name="v_fechainicial" value="<?php echo $fechainicial; ?>" title="FECHA INICIAL" placeholder='FECHA INICIAL '>
							</div>


							<div class="form-group m-t-20">
								<label>*FECHA FINAL:</label>
								<input type="date" class="form-control" id="v_fechafinal" name="v_fechafinal" value="<?php echo $fechafinal; ?>" title="FECHA FINAL" placeholder='FECHA FINAL '>
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