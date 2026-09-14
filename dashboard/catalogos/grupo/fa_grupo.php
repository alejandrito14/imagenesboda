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
require_once("../../clases/class.Grupos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Grupos();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idgrupo'])){
	//El formulario es de nuevo registro
	$idgrupo = 0;

	//Se declaran todas las variables vacias
	 $nombre='';
	 $lugar='';
	 $ubicacion='';
	 $estatus=1;
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVO COMPLEMENTO';
		$display = "display:none";
	$multiple=0;
	$valorsin=0;
	$valorcon=0;
	$obligatorio="";
	$copia='1';

}else{

	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del grupo a modificar a nuestra clase grupos
	$idgrupo = $_GET['idgrupo'];
	$emp->idgrupos = $idgrupo;

	//Realizamos la consulta en tabla grupos
	$result_grupo = $emp->ObtenerGrupo();
	$result_grupo_row = $db->fetch_assoc($result_grupo);



	//Cargamos en las variables los datos 

	//DATOS GENERALES
	$nombre=$f->imprimir_cadena_utf8($result_grupo_row['nombregrupo']);
	$sinprecio = $f->imprimir_cadena_utf8($result_grupo_row['sincoprecio']);
	$multiple = $f->imprimir_cadena_utf8($result_grupo_row['multiple']);
	$estatus = $f->imprimir_cadena_utf8($result_grupo_row['estatus']);
	$tope = $f->imprimir_cadena_utf8($result_grupo_row['tope']);

	$obli = $f->imprimir_cadena_utf8($result_grupo_row['obligatorio']);
	$obligatorio="";
	if ($obli==1) {
		$obligatorio="checked";
	}

		$display='display:none';

	if ($multiple==1) {
		$display='display:block';
	}


	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR COMPLEMENTO';

	if(isset($_GET['copia'])){

		$copia=$_GET['copia'];
	}
			
		
	$valorsin=0;
	$valorcon=0;
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

<form id="f_grupo" name="f_grupo" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = " GuardarGrupo('f_grupo','catalogos/grupo/vi_grupo.php','main','$idmenumodulo');";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idgrupos == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/grupo/vi_grupo.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE COMPLEMENTOS</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idgrupo; ?>" />
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
								<label>*TITULO:</label>
								<input type="text" class="form-control" id="nombregrupo" name="nombregrupo" value="<?php echo $nombre; ?>" title="NOMBRE" tabindex="1" placeholder='NOMBRE'>
							</div>



							
							
					


                        <label for="">*¿CUENTA CON COSTO ADICIONAL?</label>
                        <div class="form-check">

                        <?php 
                        	if ($sinprecio==0) {
                        		$checkedsin="checked";
                        	}else{

                        		$checkedcon="checked";
                        	}



                         ?>
                          <input type="radio" id="conprecio" tabindex="2" name="costoadicional" class="form-check-input" value="1" <?php echo $checkedcon; ?>>


                          <label class="form-check-label" for="exampleRadios1">
                             SI
                         </label>
                     </div>


                     <div class="form-check">


                    


                      <input type="radio" id="sinprecio" tabindex="3" name="costoadicional" class="form-check-input" value="0" <?php echo $checkedsin; ?>>
                      <label class="form-check-label" for="exampleRadios1">
                        NO
                     </label>
                 </div>

                 <br>

                        <label for="">*¿LA SELECCIÓN ES MÚLTIPLE?</label>

               


             <div class="form-check">
             	    <?php 
                        	if ($multiple==0) {
                        		$multiplesin="checked";
                        		$valorsin=0;

                        	}else{

                        		$multiplecon="checked";
                        		$valorcon=1;
                        	}



                         ?>

              <input type="radio" id="unica" name="seleccionmultiple" class="form-check-input " onchange="Checar()" tabindex="4" value="<?php echo  $valorcon;?>" <?php echo $multiplecon; ?>>
              <label class="form-check-label" for="exampleRadios1">
                 SI
              </label>
          </div>
            <div class="form-check">


                  <input type="radio" id="unica2" name="seleccionmultiple" class="form-check-input" value="<?php echo $valorsin;?>" onchange="Checar()" tabindex="5" <?php echo $multiplesin; ?>>
                  <label class="form-check-label" for="exampleRadios1">
                    NO
                 </label>
             </div>


             <div class="form-group m-t-20" id="colocartope" style="<?php echo $display; ?>">
             		
             		<label for="">¿CUANTAS OPCIONES SE PUEDEN ELEGIR?:</label>
             		<input class="form-control" type="number" id="tope" name="tope" value="<?php echo $tope; ?>">


             </div>


              <div class="form-group" id="" style="">
             		<div class="" style="margin-top: 1em;">
             		<label class="form-check-label" for="">¿ES OBLIGATORIO SELECCIONAR COMPLEMENTO?:</label><br>
             		<input type="checkbox" id="obligatorio" name="obligatorio1" value="0" style="margin-left: .2em;margin-top: .3em;" <?php echo $obligatorio ?> >

             		</div>
             </div>
             <br>

             	<div class="form-group m-t-20">
							<label>ESTATUS:</label>
							<select name="v_estatus" tabindex="6" id="v_estatus" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVADO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVADO</option>
							</select>
						</div>


          <br>




          <label for="">AGREGAR OPCIÓN<button type="button" onclick="AgregarOpciones()" class="btn btn-primary"><span class="mdi mdi-plus"></span></button>
          </label>

          <div id="opciones" class="col-md-12"></div>





						
							
						</div>
						
						
					
					</div>
				</div>
			</div>
			</div>
		</div>


	</div>
</form>
<!-- <script  type="text/javascript" src="./js/mayusculas.js"></script>
 --><script>
	var idgrupo=<?php echo $idgrupo;?>;
	var copia=<?php echo $copia;?>;

	if(idgrupo>0) {
		ObtenerOpcionesGrupos(idgrupo);
	}

	if (copia==1) {
		$("#id").val(0);
	}
</script>
<style type="text/css">



</style>


<?php

?>