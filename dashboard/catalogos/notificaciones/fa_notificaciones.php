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
require_once("../../clases/class.Notificaciones.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Usuarios.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Notificaciones();
$f = new Funciones();
$bt = new Botones_permisos();

$cli = new Clientes();
$cli->db = $db;
$r_clientes = $cli->lista_clientes();
$a_cliente = $db->fetch_assoc($r_clientes);
$r_clientes_num = $db->num_rows($r_clientes);

$usu=new Usuarios();
$usu->db=$db;
$r_usuarios=$usu->ObtUsuariosActivos();
$a_usuarios=$db->fetch_assoc($r_usuarios);
$r_usuarios_num=$db->num_rows($r_usuarios);

$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idnotificacion'])){
	//El formulario es de nuevo registro
	$idnotificacion = 0;
	$emp->idnotificacion=0;
	//Se declaran todas las variables vacias
	 $dia='';
	 $mes='';
	 $anio='';
	 $hora='';
	 $estatus=1;
	
	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVA NOTIFICACION';
	$habilitadoclientes=2;
	$habilitadoadmin=2;
	$programado=0;
	$seleccionar=0;
	$copia=1;

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del pagos a modificar a nuestra clase Pagos
	$idnotificacion = $_GET['idnotificacion'];
	$emp->idnotificacion = $idnotificacion;

	

	//Realizamos la consulta en tabla Pagos
	$result_NOTIFICACION = $emp->buscarnotificacion();
	$result_NOTIFICACION_row = $db->fetch_assoc($result_NOTIFICACION);

	$titulonoti=$result_NOTIFICACION_row['titulo'];
    $mensaje=$result_NOTIFICACION_row['mensaje'];
    $programado=$result_NOTIFICACION_row['programado'];
    $seleccionar=$result_NOTIFICACION_row['seleccionar'];
    $todosclientes=$result_NOTIFICACION_row['todosclientes'];
    $todosadmin=$result_NOTIFICACION_row['todosadmin'];
    $estatus=$f->imprimir_cadena_utf8($result_NOTIFICACION_row['estatus']);
    $emp->fechacreacion=$result_NOTIFICACION_row['fechacreacion'];;

    $emp->fechahora=$f->imprimir_cadena_utf8($result_NOTIFICACION_row['fechahora']);
    $fechaprogramada="";
	$horaprogramada="";
    if ($emp->fechahora!='') {

	    $fecha=explode(' ', $emp->fechahora);
	    $fechaprogramada=$fecha[0];
	    $horaprogramada=$fecha[1];

	}

	$habilitadoclientes=$result_NOTIFICACION_row['todosclientes'];
	$habilitadoadmin=$result_NOTIFICACION_row['todosadmin'];


	//Cargamos en las variables los datos 


	$col = "col-md-12";
	$ver = "";

	$copia=0;


	if(isset($_GET['copia'])){

		$copia=$_GET['copia'];
	}

		if ($copia==1) {
			$titulo='NUEVA NOTIFICACION';
			$idnotificacion=0;
		}else{

			$titulo='EDITAR NOTIFICACION';

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

<form id="f_NOTIFICACION" name="f_NOTIFICACION" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "ENVIAR Y GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R'); if(resp==1){ Guardarnotificacion('f_NOTIFICACION','catalogos/notificaciones/vi_notificaciones.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idnotificacion == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/notificaciones/vi_notificaciones.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE NOTIFICACION</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idnotificacion; ?>" />

				<input type="hidden" id="copia" name="copia" value="<?php echo $copia; ?>" />

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

					
							<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>TITULO:</label>
								<input type="text" class="form-control" id="v_titulo" name="v_titulo" value="<?php echo $titulonoti; ?>"  placeholder='TITULO' maxlength="20">
							</div>


							<div class="form-group m-t-20">
								<label>*MENSAJE:</label>
								<textarea name="mensaje" class="form-control" placeholder="MENSAJE" id="mensaje" cols="30" rows="10" maxlength="100"><?php echo $mensaje; ?></textarea>
							</div>

							
							
							<div class="form-group m-t-20">
								<label>*PROGRAMACIÓN:</label>
								<select class="form-control" name="programado" id="programado" onchange="programar();">
									<option  value="0">SELECCIONAR OPCIÓN</option>
									<option value="1">AHORA</option>
									<option value="2">PROGRAMADO</option>
								</select>
							</div>

							<div id="mostrarfecha" style="display: none;">
								<div class="form-group m-t-20">
									<label for="">FECHA:</label>
									<input type="date" id="fechaprogramada" class="form-control" name="fechaprogramada" value="<?php echo $fechaprogramada ?>">

								</div>

								<label for="">HORA:</label>
								<input type="time" id="horaprogramada" class="form-control" value="<?php echo $horaprogramada ?>" name="horaprogramada">
							</div>

							<div class="form-group m-t-20">
								<label>*DIRIGIDO A:</label>
								<select class="form-control" name="dirigido" id="dirigido" onchange="dirigira()">
									<option value="0">SELECCIONAR OPCIÓN</option>
									<option value="1">CLIENTES</option>
									<option value="2">USUARIOS</option>
									<option value="3">CLIENTES Y USUARIOS</option>
									<option value="4">TELÉFONOS REGISTRADOS</option>
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

			 <div class="card clienteslistado" style="display: none;">
		<div class="card-header">
				<label style="font-size: 16px;">*CLIENTE(S):</label>
			</div>
		<div class="card-body col-md-12">
			<div class="col-md-6" style="float: left;">
				<div class="card-header" style="padding-left: 0.45rem;">  TODOS LOS CLIENTES
				 <input type="checkbox" id="v_tclientes"  name="v_tclientes" onchange="HabilitarDeshabilitarCheck2('#lclientesdiv')" value="<?php echo  $habilitadoclientes;?>" title="PROMOCIÓN" placeholder='PROMOCIÓN'  >
				</div>
                <div class="card-body" id="lclientesdiv" style="display: block; padding: 0;">
                
                    <div class="form-group m-t-20">	 
						<input type="text" class="form-control" name="buscadorcli_1" id="buscadorcli_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorcli_','.cli_')">
				    </div>
                    <div class="clientes"  style="overflow:scroll;height:100px;overflow-x: hidden" id="clientes_<?php echo $a_cliente['idcliente'];?>">
					    <?php     	
							if ($r_clientes_num>0) {	
						    	do {
						?>
						    	<div class="form-check cli_"  id="cli_<?php echo $a_cliente['idcliente'];?>_<?php echo $a_cliente['idcliente'];?>">
						    	    <?php 	
						    			$valor="";
                                        $nombre=mb_strtoupper($f->imprimir_cadena_utf8($a_cliente['nombre']." ".$a_cliente['paterno']." ".$a_cliente['materno']));
						    		?>
									  <input  type="checkbox" onchange="ClienteSeleccionado()"  value="<?php echo $a_cliente['idcliente']?>" class="form-check-input chkcliente" id="inputcli_<?php echo $a_cliente['idcliente']?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault"><?php echo $nombre; ?></label>
								</div>						    		
						    	<?php
						    		} while ($a_cliente = $db->fetch_assoc($r_clientes));
     					    	 ?>
						    	<?php } ?>    
				    </div>
                </div> <!-- lclientesdiv -->
			</div>
		</div>
    </div><!--card-CLI-->


     <div class="card usuarioslista" style="display: none;">
		<div class="card-header">
				<label style="font-size: 16px;">*USUARIO(S):</label>
			</div>
		<div class="card-body col-md-12">
			<div class="col-md-6" style="float: left;">
				<div class="card-header" style="padding-left: 0.45rem;"> TODOS LOS USUARIOS
				 <input type="checkbox" id="v_tusuarios"  name="v_tusuarios" onchange="HabilitarDeshabilitarCheck3('#lusuariosdiv')" value="<?php echo $habilitadoadmin;?>" title="PROMOCIÓN" placeholder='PROMOCIÓN' >
				</div>
                <div class="card-body" id="lusuariosdiv" style="display: block; padding: 0;">
                
                    <div class="form-group m-t-20">	 
						<input type="text" class="form-control" name="buscadorcli_2" id="buscadorusuario_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorusuario_','.usu_')">
				    </div>

			
                    <div class="usuarios"  style="overflow:scroll;height:100px;overflow-x: hidden" id="usuarios_<?php echo $a_cliente['idusuarios'];?>">
					    <?php     	
							if ($r_usuarios_num>0) {	
						    	do {
						?>
						    	<div class="form-check usu_"  id="usu_<?php echo $a_usuarios['idusuarios'];?>_<?php echo $a_usuarios['idusuarios'];?>">
						    	    <?php 	
						    			$valor="";
                                        $nombre=mb_strtoupper($f->imprimir_cadena_utf8($a_usuarios['nombre']." ".$a_usuarios['paterno']." ".$a_usuarios['materno']));
						    		?>
									  <input  type="checkbox"  onchange="UsuarioSeleccionado()" value="<?php echo $a_usuarios['idusuarios']?>" class="form-check-input chkusuario" id="inputcli_<?php echo $a_usuarios['idusuarios']?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault"><?php echo $nombre; ?></label>
								</div>						    		
						    	<?php
						    		} while ($a_usuarios = $db->fetch_assoc($r_usuarios));
     					    	 ?>
						    	<?php } ?>    
				    </div>
                </div> <!-- lclientesdiv -->
			</div>
		</div>
    </div><!--card-CLI-->


		</div>




	</div>
</form>

<script>

	var programado=<?php echo $programado;?>;
	$("#programado").val(programado);

	var dirigido=<?php echo $seleccionar; ?>;
	$("#dirigido").val(dirigido);
	programar();
	dirigira();

	var idnotificacion=<?php echo $emp->idnotificacion; ?>;
	var todosclientes=<?php echo $todosclientes;?>;
	var todosadmin=<?php echo $todosadmin;?>;

	if (idnotificacion>0) {

		

		if (todosclientes==1) {
			ObtenerClientesNotificacion(idnotificacion);

		}

		if (todosclientes==0) {
			$("#v_tclientes").prop('checked',true);
			$("#v_tclientes").val(0);
		}

		if (todosadmin==1) {

			ObtenerUsuariosNotificacion(idnotificacion);

		}

		if (todosadmin==0) {
			$("#v_tusuarios").prop('checked',true);
			$("#v_tusuarios").val(0);
		}


	}
	//programado(programado);


</script>
<!-- <script  type="text/javascript" src="./js/mayusculas.js"></script>
 -->


<?php

?>