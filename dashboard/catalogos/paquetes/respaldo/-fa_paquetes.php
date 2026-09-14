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


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Productos.php");

require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

require_once("../../clases/class.Categoriasprecios.php");

require_once("../../clases/class.Grupos.php");
require_once("../../clases/class.Paquetes.php");
require_once('../../clases/class.Paquetesproductos.php');



$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Productos();
$cat=new Categoriasprecios();
$paquetes_productos=new Paquetesproductos();
$f = new Funciones();
$bt = new Botones_permisos();
$paquetes_productos->db=$db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$emp->db =$db;

$cat->db=$db;

$grupos = new Grupos();
$grupos->db=$db;



$paquetes = new Paquetes();
$paquetes->db=$db;
$busqueda='';
$obtenergrupos=$grupos->ObtGruposActivos($busqueda);
$num_rows=$db->num_rows($obtenergrupos);
$rowsgrupos=$db->fetch_assoc($obtenergrupos);
$arrayopcion=array('NO','SI');

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idpaquete'])){
	//El formulario es de nuevo registro
	$idpresentacion = 0;
	$idpaquete=0;
	//Se declaran todas las variables vacias
	$nombreproducto = "";
	$descripcion = "";
	$descuento = "";
	$ruta="images/sinfoto.png";
	
	$estatus=1;
	$categoria =0;
	$empresa= "";
	$presentacion= "";
	$pv="";
	$col = "col-md-12";
	$ver = "display:none;";
	$disabled="";
	$validacion=1;
	$num=0;
	$_SESSION['CarritoProducto']=null;
	$_SESSION['CarritoComplemento']=null;
	$idcategorias=0;
	$idtipopresentacion=0;
	$titulo='NUEVO PAQUETE';
	$nuevo=0;
	$numgrupopaquete=0;
	$promocion=0;

	$che2="checked";
	$che3="";
	$che5="";
	$cantidada="";
	$considerar="";
	$servicio=0;
	$che4="";
	$preciofijo="";
	$activarcomentario=0;
	$lunes=0;
	$martes=0;
	$miercoles=0;
	$jueves=0;
	$viernes=0;
	$sabado=0;
	$domingo=0;
	$ok=0;
	$horainicio="00:00";
	$horafin="00:00";
	$mensajev="";
	/*$obtenerorden=$paquetes->ObtenerUltimoOrdenpaquete();
	$roworden=$db->fetch_assoc($obtenerorden);
	$num=$db->num_rows($obtenerorden);
	if ($num>0) {
		$orden=$roworden['ordenar']+1;
	}else{
		$orden=0;
	}*/
}else{
	//El formulario funcionara para modificacion de un registro
	$_SESSION['CarritoProducto']=null;
	$_SESSION['CarritoComplemento']=null;

	//Enviamos el id de la empresa a modificar a nuestra clase empresas
	$idpaquete = $_GET['idpaquete'];
	$paquetes->idpaquete = $idpaquete;


	
	//Realizamos la consulta en tabla empresas
	$result_presentacion = $paquetes->ObtenerPaquete();
	$result_presentacion_row = $db->fetch_assoc($result_presentacion);
	//Cargamos en las variables los datos de las empresas

	//DATOS GENERALES
	$nombreproducto = $f->imprimir_cadena_utf8($result_presentacion_row['nombrepaquete']);
	$descripcion = $f->imprimir_cadena_utf8($result_presentacion_row['descripcion']);
	$descuento = "";
	$titulo='EDITAR PAQUETE';


	
	
	$foto = $f->imprimir_cadena_utf8($result_presentacion_row['foto']);
	$estatus = $f->imprimir_cadena_utf8($result_presentacion_row['estatus']);
	$categoria = $f->imprimir_cadena_utf8($result_presentacion_row['idcategorias']);

	$preciouni=$result_presentacion_row['precionormal'];
	$precioventa=$result_presentacion_row['precioventa'];

	$promocion=$result_presentacion_row['promocion'];
	$definirfecha=$result_presentacion_row['definirfecha'];

	$cantidada=$result_presentacion_row['cantidad'];
	$considerar=$result_presentacion_row['considerar'];

	$fechainicial=$result_presentacion_row['fechainicial'];
	$fechafinal=$result_presentacion_row['fechafinal'];

	$servicio=$result_presentacion_row['servicio'];
	$repetitivo=$result_presentacion_row['repetitivo'];

	$lunes=$result_presentacion_row['lunes'];
	$martes=$result_presentacion_row['martes'];
	$miercoles=$result_presentacion_row['miercoles'];
	$jueves=$result_presentacion_row['jueves'];
	$viernes=$result_presentacion_row['viernes'];
	$sabado=$result_presentacion_row['sabado'];
	$domingo=$result_presentacion_row['domingo'];

	$preciofijo=$result_presentacion_row['preciofijo'];

	$horainicio=$result_presentacion_row['horainicialpromo'];
	$horafin=$result_presentacion_row['horafinalpromo'];
	$mensajev=$result_presentacion_row['mensaje'];


	if ($horainicio=='') {
		$horainicio="00:00";
		$horafin="00:00";
	}

	$chelunes="";
	$chemartes="";
	$chemiercoles="";
	$chejueves="";
	$cheviernes="";
	$chesabado="";
	$chedomingo="";
	$ok=0;

	if ($lunes==1) {
		$chelunes="checked";
		$ok=$ok+1;
	}
	if ($martes==1) {
		$chemartes="checked";
		$ok=$ok+1;
	}
	if ($miercoles==1) {
		$chemiercoles="checked";
		$ok=$ok+1;
	}
	if ($jueves==1) {
		$chejueves="checked";
		$ok=$ok+1;
	}
	if ($viernes==1) {
		$cheviernes="checked";
		$ok=$ok+1;
	}
	if ($sabado==1) {
		$chesabado="checked";
		$ok=$ok+1;
	}

	if ($domingo==1) {
		$chedomingo="checked";
		$ok=$ok+1;
	}
	$chetodos="";
	if ($ok==7) {

		$chetodos="checked";
	}


	$che="";
	$che2="";
	$che3="";

	if ($promocion==1) {
		$che="checked";
	}

	$aplicardirecto=$result_presentacion_row['aplicardirecto'];


	if ($aplicardirecto==1) {
		
		$che3="checked";
	}

	if ($definirfecha==1) {
		$che2="checked";
	}

	$che4="";
	if ($servicio==1) {
		$che4="checked";
	}

	$che5="";
	if ($repetitivo==1) {
		$che5="checked";
	}

	unset($_SESSION['CarritoProducto']);

	$paquetes_productos->idpaquete=$idpaquete;
	$resultado=$paquetes_productos->ObtenerDescripcionPaquete();
	//$resul_row=$db->fetch_assoc($resultado);
	$numpaquete=$db->num_rows($resultado);

	$cont=0;
if ($numpaquete>0) {

	while($resul_row=$db->fetch_assoc($resultado)){


		$idinsumo=$resul_row['idproducto'];
		$cantidad=$resul_row['cantidad'];
		$nombre=$resul_row['nombre'];
		$pm='';
		$subtotal='';
		$medida=$resul_row['medida'];
		$subtotalmedida=$resul_row['subtotalmedida'];
		$tipomedida=$resul_row['tipomedida'];
		$codigoproducto=$resul_row['codigoproducto'];

		$_SESSION['CarritoProducto'][$cont] = $idinsumo."|".$cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida.'|'.$codigoproducto;

		$cont++;
	}
}

	

	$obtenergrupopaquete=$grupos->ObtenerGrupoPaquete($idpaquete);
//	$resulgrupopaquete_row=$db->fetch_assoc($obtenergrupopaquete);
	$numgrupopaquete=$db->num_rows($obtenergrupopaquete);


	$cont2=0;
	unset($_SESSION['CarritoComplemento']);

if ($numgrupopaquete>0) {
	# code...

	while($resulgrupopaquete_row=$db->fetch_assoc($obtenergrupopaquete)) {

		$sincoprecio=$resulgrupopaquete_row['sincoprecio'];
		$multiple=$resulgrupopaquete_row['multiple'];
		$cantidad=1;
		$idgrupo=$resulgrupopaquete_row['idgrupo'];
		$nombre=$resulgrupopaquete_row['nombregrupo'];
		$tope=$resulgrupopaquete_row['tope'];

		if ($resulgrupopaquete_row['topesecundario']!=0) {
			
			$tope=$resulgrupopaquete_row['topesecundario'];
		}


	$_SESSION['CarritoComplemento'][$cont2]=$idgrupo.'|'.$cantidad."|".$nombre."|".$sincoprecio."|".$multiple."|".$tope;

	$cont2++;
	}



}

	$validacion=2;
	
	if($foto==""){
		$ruta="images/sinfoto.png";
	}
	else{
		$ruta="catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio']."/$foto";
	}

	$col = "col-md-12";
	$ver = "";
	$disabled ="disabled";

	$nuevo=1;

	$codigo="";


	$orden=$result_presentacion_row['orden'];
	$activarcomentario=$result_presentacion_row['activarcomentario'];
	$che6;
	if ($activarcomentario==1) {
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

<form id="f_paquetes" name="f_paquetes" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php

					//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "GUARDAR";
				$bt->icon = "mdi mdi-content-save";
				$bt->funcion = "

				$('#modal-title').html('');

				var id=$('#id').val();
				var nombre=$('#v_nombre').val();
				var descripcion=$('#v_descripcion').val();
				var categoria=$('#v_categoria').val();
				var preciov=$('#precioventa').val();

				bandera=1;
				var html='';

				if(nombre==''){
					bandera=0;
					html+='<p>Nombre es requerido</p>';
				}
				if(descripcion==''){
					bandera=0;
					html+='<p>Descripcion es requerido</p>';
				}
				if(categoria==0){
					bandera=0;
					html+='<p>Categoria es requerido</p>';
				}
				if(preciov==''){
					bandera=0;
					html+='<p>Precio es requerido</p>';
				}

				if(bandera==0){

					html2='<p>Han ocurrido los siguientes errores.<p>';
				}


				if(bandera==1){
					
						Guardarpaquete('f_paquetes','catalogos/paquetes/vi_paquetes.php','main','$idmenumodulo');

						}else{

							$('#modal-title').append(html2+html);
							$('#modal-notificacion').modal();

						}

						";

						$bt->estilos = "float: right;";
						$bt->permiso = $permisos;
						$bt->class='btn btn-success';

					//validamos que permiso aplicar si el de alta o el de modificacion
						if($idproducto == 0)
						{
							$bt->tipo = 1;
						}else{
							$bt->tipo = 2;
						}

						$bt->armar_boton();
						?>

						<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->

						<button type="button" onClick="aparecermodulos('catalogos/paquetes/vi_paquetes.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE PAQUETES</button>
						<div style="clear: both;"></div>


					</div>
					<div style="clear: both;"></div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="">
						<div class="card">
							<div class="card-header" >
								<!--<h5>DATOS</h5>-->

							</div>
							<input type="hidden" id="validacion" value="<?php echo $validacion; ?>">
							<input type="hidden" id="id" name="id" value="<?php echo $idpaquete; ?>">


							<div class="row">
								<div class="col-md-6" >

									<form method="post" action="#" enctype="multipart/form-data">
								    <div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
								        <img class="card-img-top" src="">
								        <div id="d_foto" style="text-align:center; ">
											<img src="<?php echo $ruta; ?>" class="card-img-top" alt="" style="border: 1px #777 solid"/> 
										</div>
								        <div class="card-body">
								            <h5 class="card-title"></h5>
								           
								            <div class="form-group">

								            	
								               
								                <input type="file" class="form-control-file" name="image" id="image" onchange="SubirImagen()">
								            </div>
								          <!--   <input type="button" class="btn btn-primary upload" value="Subir"> -->
								        </div>
								    </div>
								</form>
								<p style="text-align: center;">Dimensiones de la imagen Ancho:640px Alto:426px</p>
									<!-- <div class="" style="text-align: center;">
										<div id="d_foto" style="text-align:center; margin-top: 10px; margin-bottom: 20px;">
											<img src="<?php echo $ruta; ?>" width="150" height="150" alt="" style="border: 1px #777 solid"/> 
										</div>
										<p style="text-align:center;">&nbsp;&nbsp;Dimensiones de la imagen Ancho: 200 px Alto: 200px</p>
										<div class="spacer"></div>
										<input type="file" id="v_imagen" name="v_imagen" accept="image/*">
									</div>	
 -->

								</div>
								<div class="col-md-5" style="float: left;">

									<div class="tab-content tabcontent-border">
										<div class="tab-pane active show" id="generales" role="tabpanel">
											<h5>DATOS GENERALES</h5>






											<div class="form-group m-t-20">
												<label>NOMBRE:</label>
												<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombreproducto; ?>" title="NOMBRE"  placeholder="NOMBRE">
											</div>



											<div class="form-group m-t-20">
												<label>DESCRIPCION:</label>
												<textarea id="v_descripcion" name="v_descripcion" title="DESCRIPCION" class="form-control" style="height: 85px;"><?php echo $descripcion; ?></textarea>
											</div>
					



							<div class="form-group" >
							 <div id="verprecio" style="display: none;"><label>PRECIO $:</label><span id="precioprincipal"></span> </div>

								
								<div data-toggle="modal" onclick="AbrirModalPrecios(<?php echo $idpaquete; ?>)"  class="btn btn-success" style="width: 100%">AGREGAR PRECIOS</div>

								
							</div>

								<div class="form-group m-t-20">
								<label>CATEGORÍA:</label>
								<?php 
								
								$categorias= $emp->obtenerCategorias();
								$categorias_num=$db->num_rows($categorias);
								$categorias_row=$db->fetch_assoc($categorias);
								?>
								<select onchange="ObtenerOrden()"  class="form-control" id="v_categoria" name="v_categoria" title="CATEGORIA">
									<option value="0">SELECCIONAR CATEGORÍA</option>
									<?php
									do{
										?>
										<option value="<?php echo ($categorias_row['idcategorias']);?>" <?php if($categorias_row['idcategorias']==$categoria){ echo ("selected");}?>><?php echo ($categorias_row['categoria']);?></option>

										<?php 
									} while($categorias_row=$db->fetch_assoc($categorias));
									?>
								</select>
							</div>

							<div class="form-group">
								<label>ORDEN:</label>
								<input type="number" id="v_orden" name="v_orden" title="ORDEN" class="form-control" value="<?php echo $orden; ?>"/>
							</div>

							<div class="form-group">
								<label>ACTIVAR INSTRUCCIONES ESPECIALES

									<input type="checkbox" name="v_activarcomentario" onchange="Habilitarcomentario()" value="<?php echo $activarcomentario;?>" id="v_activarcomentario" <?php echo $che6;?> >
								</label>
							</div>



							<!-- <div class="form-group m-t-20" >
								<label>PRECIO 1 $:</label>
								<input type="number" id="preciouno" name="preciouno" class="form-control" value="<?php echo $preciouni; ?>" >
								
							</div> -->

							<!-- <div class="form-group m-t-20" >
								<label>PRECIO $:</label>
								<input type="number" id="precioventa" class="form-control" value="<?php echo $precioventa; ?>">

								
							</div> -->


						

							<div class="form-group m-t-20" style="">
								SERVICIO:
							
								<input type="checkbox" name="servicio" id="servicio" onchange="Habilitarservicio()" value="<?php echo $servicio?>" <?php echo $che4;?>>
						
								
							</div>

							<br>
							<div class="form-group m-t-20">
								<label>ESTATUS:</label>
								<select class="form-control" id="v_estatus" name="v_estatus">
									<option value="1" <?php if(1==$estatus){echo "selected";}?>>ACTIVADO</option>
									<option value="0" <?php if(0==$estatus){echo "selected";}?>>DESACTIVADO</option>
								</select>
								
							</div>



							<div></div>





							



							
						</div>




						
						

					</div>


				</div>

			</div>

		</div>


	</div>






</div>


<div class="col-md-12">
	<div class="card">
		<div class="card-header">


				<label style="font-size: 16px;">PROMOCIÓN</label>

			</div>
		<div class="card-body col-md-12">

			<div class="col-md-6" style="float: left;">
				<div class="card-header">PROMOCIÓN
				 <input type="checkbox" id="conpromo" name="conpromo" onchange="Habilitarpromo()" value="<?php echo $promocion; ?>" title="PROMOCIÓN" placeholder='PROMOCIÓN' <?php echo $che ?>>
				</div>
				<div class="card-body" id="promociondiv" style="display: none;">
					


							<div class="form-group m-t-20">
<!-- 								<label >PROMOCIÓN:</label>
 -->								

							</div>

							<div >
							<div class="form-group">
								

								<input type="radio"  id="confecha" name="conopcion" onchange="Promo();"  value="<?php echo $definirfecha; ?>" title="POR FECHAS" placeholder='POR FECHAS' <?php echo $che2 ?>>
								<label>POR FECHAS</label>

								<div class="row">
									<div class="col-md-4" style="    margin-left: 1em;">
										<label>FECHA INICIAL:</label>
									</div>
									<div class="col-md-6">
										<input type="date" class="form-control" name="fechainicial" id="fechainicial" value="<?php echo $fechainicial; ?>">
									</div>
								</div>







								<div class="row">
									<div class="col-md-4" style="    margin-left: 1em;">
										<label>FECHA FINAL:</label>
									</div>
									<div class="col-md-6">
										<input type="date" class="form-control" name="fechafinal" id="fechafinal" value="<?php echo $fechafinal; ?>">
									</div>
								</div>
							
						</div>

						<input type="radio"  id="repetitivo" name="conopcion" onchange="Promo();"  value="<?php echo $repetitivo; ?>" title="REPETITIVO" placeholder='REPETITIVO' <?php echo $che5 ?>>
								<label>REPETITIVO</label>

								<br>

						<label style="    margin-left: 1em;">SELECCIONAR LOS DÍAS A PROMOCIONAR:</label>

						<div class="row">
						<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Todos</label>	
						  </div>
						  <div class="col-md-2">
						  	<input type="checkbox" name="" id="todosdias" onchange="SeleccionarTodos()" <?php echo $chetodos;?>></div>
						 
						</div>
						<div class="row">
						<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Lunes</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('lunes')" id="lunes" name="lunes" value="<?php echo $lunes; ?>" <?php echo $chelunes; ?>></div>
						 
						</div>


						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Martes</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('martes')" id="martes" name="martes" value="<?php echo $martes; ?>" <?php echo $chemartes; ?>></div>
						 
						</div>

						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Miércoles</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('miercoles')" id="miercoles" name="miercoles" value="<?php echo $miercoles; ?>" <?php echo $chemiercoles; ?>></div>
						 
						</div>

						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Jueves</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('jueves')" id="jueves" name="jueves" value="<?php echo  $jueves;?>" <?php echo $chejueves; ?>></div>
						 
						</div>

						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Viernes</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('viernes')" id="viernes" name="viernes" value="<?php echo  $viernes;?>" <?php echo $cheviernes; ?>></div>
						 
						</div>

						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Sábado</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('sabado')" id="sabado" name="sabado" value="<?php echo $sabado; ?>" <?php echo $chesabado; ?>></div>
						 
						</div>

						<div class="row">
							<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label >Domingo</label>	
						  </div>
						  <div class="col-md-2"><input type="checkbox" onchange="Seleccionchek('domingo')" id="domingo" name="domingo" value="<?php echo $domingo; ?>" <?php echo $chedomingo; ?>></div>
						 
						</div>





							<div class="form-group">
								<input type="radio"  id="directo" name="conopcion"  onchange="Promo();"  value="<?php echo $aplicardirecto; ?>" title="DIRECTO" placeholder='DIRECTO' <?php echo $che3 ?>>
								<label>DIRECTO</label>

							</div>

							<div class="form-group">
								
								
							</div>


						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


	<div class="col-md-12" id="opcionesdepromocion" style="display: none;">
	<div class="card">
		<div class="card-header">
			<label>OPCIONES DE PROMOCIÓN</label>
			</div>
		<div class="card-body col-md-12">

							<div style="margin-top: 3em">
								<label>HORARIO DE PROMOCIÓN</label>

									<form class="form-inline">
									<label>Hora de inicio:</label>
										<div class="form-group mb-2" style="margin-left: 1em;">
											<input type="time" name="" class="form-control" id="horainicio" value="<?php echo $horainicio; ?>">
										</div>

									</form>

									<form class="form-inline">
										<label>Hora de fin:</label>
										<div class="form-group mb-2" style="margin-left: 1em;">
											<input type="time" name="" class="form-control" style="margin-left: 1.2em;" id="horafin" value="<?php echo $horafin; ?>">
										</div>

									</form>

							</div>
							<div style="margin-top: 5em;">
							<label>FACTOR MULTIPLICADOR:</label>
							<form class="form-inline" style="">

							  <div class="form-group mb-2">
							   <input type="number" style="width:4em;float: left;" class="form-control" name="cantidadaconsiderar" id="cantidadaconsiderar" value="<?php echo $considerar; ?>">
							  </div>
							  	<label style="float: right;margin-left: 1em;">A CONSIDERAR X</label>

							  <div class="form-group mx-sm-3 mb-2">
							   <input type="number" style="width:4em;float: left;" class="form-control" name="cantidadcobrar" id="cantidadcobrar" value="<?php echo $cantidada; ?>">
							  </div>
							 
							</form>

							<label>PRECIO FIJO</label>

							<div class="" style="width: 18em;">
									<input type="number" name="preciofijo" class="form-control" id="preciofijo" value="<?php echo $preciofijo; ?>" placeholder="$">
							</div>

							  
							
						
						</div>
				</div>


			</div>
		</div>



	<div class="col-md-12" id="vincularpaquete" style="display: none;">
		<div class="card">
			<div class="card-header">
				<label>VINCULAR A LOS SIGUIENTES PAQUETES QUE NO TIENEN PROMOCIÓN</label>
				</div>
			<div class="card-body col-md-12">

								<div style="margin-top: 3em">
									<div id="paquetesnopromocion" class="col-md-6" style="height: 15em;overflow: scroll;"></div>

								</div>

								<div style="margin-top: 1em" class="col-md-6">
									<label for="">Mensaje promocional:</label>
									<input type="text" id="mensajev" class="form-control" value="<?php echo $mensajev; ?>" >
								</div>
								
					</div>


				</div>
			</div>
	</div>
</div>
</div>



<div class="col-md-12">
	<div class="card">
		<div class="card-header">


				<label style="font-size: 16px;">PRODUCTO</label>

			</div>
		<div class="card-body col-md-12">

			<div class="col-md-6" style="float: left;">
				<div class="card-header">PRODUCTOS</div>
				<div class="" style="margin-top: 1em;">
					<input placeholder="BUSCAR" type="text" id="FiltrarContenido" name="FiltrarContenido" onkeyup="BuscarProductosLista();" class="form-control">
				</div>
				<div class="aqui " style="overflow: scroll;height:400px; margin-top: 1em;">
					<div class="row " >
						<div class="col-md-12 col-sm-3 col-xs-2" id="contenedor_insumos">
							<div class="card">
								<div class="card-body">
									


								</div>
							</div>
						</div>



					</div>
				</div>

			</div>

			<div class="col-md-6 col-sm-3 col-xs-2" style="float: left;">
				<div class="card-header">PRODUCTOS QUE INCLUYE EL PAQUETE</div>

				<br>

				<div class="table-responsive" id="contenedor_agregados">
					<table id="zero_config" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
						<thead>
							<tr>

								<th  style="text-align: center;">CÓDIGO</th> 

								<th  style="text-align: center;">PRODUCTO</th> 
								<th style="text-align: center;">CANTIDAD</th> 
								


								<th style="text-align: center;">ACCI&Oacute;N</th>
							</tr>
						</thead>
						<tbody id="tabla_agregados">

							<?php 
							if($numpaquete == 0){
								?>
								<tr> 
									<td colspan="8" style="text-align: center">
										<h4 class="alert_warning">NO EXISTEN PRODUCTOS AGREGADOS.</h4>
									</td>
								</tr>

								<?php
							}else{
								$resultado1=$paquetes_productos->ObtenerDescripcionPaquete();

								$contador=0;
						while($resul_row=$db->fetch_assoc($resultado1)){


									?>


				<tr class="insumostabla" id="insumota_<?php echo $resul_row['idproducto'];?>"> 

	 			<td align="center" style="text-align: center;" class="idinsummook" id="insumo_<?php echo $resul_row['idproducto'];?>"><?php echo $resul_row['codigoproducto'];?></td>
	 			
	 			<td align="center" style="text-align: center;" class="insumonombre" id="insumonombre_<?php echo $resul_row['idproducto'];?>"><?php echo $resul_row['nombre'];?></td>
	 			<td align="center" id="cantidad_<?php echo $resul_row['idproducto'];?>" class="" style="text-align:center"> 

	 			<div class="btn-group" role="group" aria-label="Basic example">
	 			<button type="button" style="float: left;" class="btn " onclick="contadormenos2(<?php echo $resul_row['idproducto'];?>)">-</button>

	 			<div class="input-group-prepend">
	 			<input style="width: 50px;text-align: center;float: left;" class="form-control insumocantidad" min="1" type="number" value="<?php echo $resul_row['cantidad'];?>" id="cantidadpro_58" onblur="AgregarCantidad(<?php echo $resul_row['idproducto'];?>)">

	 			</div>
	 			<button type="button" style="float: left;" class="btn " onclick="contadormas2(<?php echo $resul_row['idproducto'];?>)">+</button>
	 			</div>


	 			</td><td  align='center'>
	 			<button type='button' onclick='BorrarInsumoProducto(<?php echo $contador;?>)' class='btn btn_rojo' style=' margin-right:10px;' title=''>
	 			<i class='mdi mdi-delete-empty'></i>
	 			</button>
	 			</td> 
	 			</tr>

	 			
									<!-- <tr class="insumostabla" id="insumota_<?php echo $resul_row['idproducto'];?>">

										<td class="idinsummook" id="insumo_<?php echo $resul_row['idproducto'];?>" style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resul_row['codigoproducto']); ?></td>

										<td class="insumonombre" id="insumonombre_<?php echo $resul_row['idproducto'];?>" style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resul_row['nombre']); ?></td>

										<td align="center" id="cantidad_<?php echo $resul_row['idproducto'];?>" class="insumocantidad" style="text-align:center"><?php echo $f->imprimir_cadena_utf8($resul_row['cantidad']); ?></td>


										<td style="text-align: center; font-size: 15px;">

											<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "mdi-delete-empty";
											$bt->funcion = "BorrarInsumoProducto('".$contador."')";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 3;

											$bt->armar_boton();
											?> 

										</td>
									</tr> -->
									<?php
									$contador++;
								}
							}
							?>




						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-3"></div>


			<div class="col-md-3"></div>


			


		</div>
	</div>
</div>


<div class="col-md-12">
	<div class="card">
		<div class="card-body">

			<div class="card-header">


				<label style="font-size: 16px;">COMPLEMENTOS</label>


				<!-- <button type="button" onClick="AgregarNuevoGrupo()" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i>NUEVO GRUPO</button> -->

				<!-- <button type="button" onClick="" class="btn btn-primary" style="float: right; margin-right: 10px;margin-bottom: 1em;"><i class="mdi mdi-arrow-left-box"></i>AGREGAR GRUPO</button> -->

			</div>
			<div class="card-body">
				<div class="col-sm-12 col-md-12" style="">

					<div class="row">
						<div id="accordion" class="col-md-6">

							<div class="card-header">COMPLEMENTOS </div>
							<div class="" style="margin-top: 1em;margin-bottom:1em; ">
								<input placeholder="BUSCAR" type="text" id="FiltrarContenido2" name="FiltrarContenido2" onkeyup="BuscarComplemento();" class="form-control">
							</div>

							<div style="overflow: scroll;height:400px; margin-top: 1em;" id="cargarcomplementos">

								<?php 

								$contador=0;

								$contarcomple=$db->num_rows($obtenergrupos);

								if ($contarcomple>0) {
									# code...
								
								do { 

									?>

									<div class="card col-sm-12 col-md-12" style="float: left;" >
										<div class="card-header" style="background: #d7d7d7;" id="headingOne<?php echo $rowsgrupos['idgrupo'];?>">
											<div class="row">
												<div class="col-md-2"></div>
												<div class="col-md-8">
												<h5 class="mb-0" style="font-size: 2em!important;text-align: center;margin-bottom: 1em!important;" data-toggle="collapse" data-target="#collapseOne<?php echo $rowsgrupos['idgrupo'];?>" aria-expanded="true" aria-controls="collapseOne">
												
													<?php echo $rowsgrupos['nombregrupo']; ?>
												</h5>
												</div>
												<div class="col-md-2"></div>

												
											</div>

									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6">
										
										<h5 style="margin-left: 1em;" for="" class="mb-0">CON PRECIO: <?php echo $arrayopcion[$rowsgrupos['sincoprecio']]; ?> </h5>
										<h5 style="margin-left: 1em;" for="" class="mb-0">OPCIÓN MÚLTIPLE: <?php echo $arrayopcion[$rowsgrupos['multiple']]; ?> </h5>

										
										</div>


									</div>

									<div class="row">
									</div>

							<div class="row">
								<div class="col-md-12">

									<div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" style="float: left;" class="btn " onclick="contadormenoscomplemento(<?php echo $rowsgrupos['idgrupo'] ?>)">-</button>

										<div class="input-group-prepend">
											<input style="width: 50px;text-align: center;float: left;" class="form-control" min="1" type="number" value="1" name="numero" id="complemento_<?php echo $rowsgrupos['idgrupo'] ?>">

										</div>

										<button type="button" style="float: left;" class="btn " onclick="contadormascomplemento(<?php echo $rowsgrupos['idgrupo'] ?>)">+</button>
									</div>
									<br>
									<button type="button" style="width: 9.5em;margin-top: 1em;" onclick="AgregarComplemento(<?php echo $rowsgrupos['idgrupo'] ?>);" class="btn btn-primary">AGREGAR</button>

								</div>
								<div class="col-md-12" style="margin-top: 1em;
								">

<!-- 								<button type="button" style="width: 9em;" onclick="AgregarComplemento(<?php echo $rowsgrupos['idgrupo'] ?>);" class="btn btn-primary">AGREGAR</button>
 -->							</div>
						</div>

					</div>

					<div id="collapseOne<?php echo $rowsgrupos['idgrupo'] ?>" class="collapse " aria-labelledby="headingOne<?php echo $rowsgrupos['idgrupo'] ?>" data-parent="#accordion">
						<div class="card-body">


							<?php 

							$idgrupo=$rowsgrupos['idgrupo'];

							$obteneropciones=$grupos->ObtenerOpciones($idgrupo);

							if (count($obteneropciones)>0) {
								?>

								<div class="row">

									<div class="col-md-12">

										<div class="col-md-6" style="float: left;color: #4da84b;">OPCIÓN</div>

										<div class="col-md-6" style="float: left;color: #4da84b;">COSTO</div>

									</div>

								</div>

								<?php	for ($i=0; $i <count($obteneropciones) ; $i++) { ?> 

									<div class="row">

										<div class="col-md-12">

											<div class="col-md-6" style="float: left;"><?php echo $obteneropciones[$i]->opcion ?> </div>

											<div class="col-md-6" style="float: left;">$<?php echo $obteneropciones[$i]->costo ?></div>

										</div>

									</div>

									<?php

								}
							}

							?>



						</div>

					</div>


				</div>


				<?php 	
				$contador++;
			} while ($rowsgrupos=$db->fetch_assoc($obtenergrupos));

		}else{

								?>
								<tr> 
									<td colspan="8" style="text-align: center">
										<h4 class="alert_warning">NO EXISTEN COMPLEMENTOS EN LA BASE DE DATOS.</h4>
									</td>
								</tr>

			<?php 
		}?>

		</div>
	</div>

	<div class="col-md-6">

		<div class="col-md-12" style="float: left;">
			<div class="card-header">COMPLEMENTOS QUE INCLUYE EL PAQUETE</div>

				<div style="overflow: scroll;height:400px; margin-top: 1em;" id="complementosagregados">
					<?php 

							if($numgrupopaquete == 0){
								?>
								<tr> 
									<td colspan="8" style="text-align: center">
										<h4 class="alert_warning">NO EXISTEN COMPLEMENTOS AGREGADOS.</h4>
									</td>
								</tr>

						<?php
							}else{

				//	$resulgrupopaquete_row=$db->fetch_assoc($obtenergrupopaquete);

						$obtenergrupopaquete=$grupos->ObtenerGrupoPaquete($idpaquete);

					  $contador2=0;;
						
						 while($resulgrupopaquete_row=$db->fetch_assoc($obtenergrupopaquete)){

							
							$sincoprecio=$resulgrupopaquete_row['sincoprecio'];
							$multiple=$resulgrupopaquete_row['multiple'];
							$cantidad=1;
							$idgrupo=$resulgrupopaquete_row['idgrupo']; 
							$nombre=$resulgrupopaquete_row['nombregrupo'];

							$topesecundario=$resulgrupopaquete_row['topesecundario'];
							$tope=$resulgrupopaquete_row['tope'];

							$tope1=$resulgrupopaquete_row['tope'];

								if ($topesecundario>0) {
									
									$tope=$topesecundario;
								}

							 ?>

				<div class="card col-sm-12 col-md-12 complemento" style="float: left;" id="divcomplemento_<?php echo $idgrupo ?>" >
	 			<div class="card-header" style="background: #d7d7d7;" id="heading<?php echo $contador2;?>">
	 			<div class="row">


				 <div class="col-md-2"></div>
				 <div class="col-md-8">
	 				<h5 class="mb-0" style="font-size: 2em!important;
    text-align: center;
    margin-bottom: 1em!important;" data-toggle="collapse" data-target="#collapse<?php echo $contador2;?>" aria-expanded="true" aria-controls="collapseOne">
			 			<?php echo $nombre; ?>

			 		

	 			</h5>
	 			</div>

	 			<div class="col-md-2"></div>

	 		</div>


	 			<div class="row">
	 			<div class="col-md-6"></div>

	 			<div class="col-md-6">

	 			<h5 style="margin-left: 1em;" for="" class="mb-0">CON PRECIO: <?php echo $arrayopcion[$sincoprecio] ?> </h5>


	 			<h5 style="margin-left: 1em;" for="" class="mb-0">OPCIÓN MÚLTIPLE: <?php echo $arrayopcion[$multiple]; ?> </h5>

	 			<?php if ($multiple==1){ ?>
	 				
	 				 	<h5 style="margin-left: 1em;" for="" class="mb-0">¿CUANTAS OPCIONES SE PUEDEN ELEGIR?</h5>
	 				
	 			<?php } ?>

	 		<div style="margin-top:1em;" class="col-md-4">
	 		



	 				<?php if ($multiple==1) {


	 				 ?>

	 				
	 				
	 		<input type="number" min="0" class="form-control topes" id="comple_<?php echo $contador2;?>" value="<?php echo $tope;?>" onblur="CambiarTope(<?php echo $contador2; ?>,<?php echo $tope1 ?>)" placeholder="Colocar tope">

	 			<?php	}else{ ?>


	 			<input type="number" min="0" style="display:none;" class="form-control topes" id="comple_<?php echo $contador2;?>" value="<?php echo $tope; ?>" placeholder="Colocar tope">';

	 			<?php	} ?>

			

					</div>

	 			</div>

	 			<div class="row">
	 			<div class="col-md-12">


	 			<div class="col-md-12" style="margin-top: 1em;
	 			">

	 			<button type="button" onclick="EliminarComplemento(<?php echo $contador2;?>)" class="btn btn-danger">ELIMINAR</button>
	 			</div>
	 			</div>

	 			</div>
	 			</div>

	 			<div id="collapse<?php echo $contador2;?>" class="collapse " aria-labelledby="heading <?php echo $contador2;?>" data-parent="#accordion">
	 			<div class="card-body">



	 			<div class="row">

	 			<div class="col-md-12">

	 			<div class="col-md-6" style="float: left;color: #4da84b;">OPCIÓN</div>

	 			<div class="col-md-6" style="float: left;color: #4da84b;">COSTO</div>

	 			</div>

	 			</div>

	 			<?php 
	 			$sql="SELECT *FROM grupoopcion WHERE idgrupo=".$idgrupo."";
	 			$obtener=$db->consulta($sql);
				$row=$db->fetch_assoc($obtener);

				$contador=$db->num_rows($obtener);
	 			do {?>

	 				
	 			<div class="row">

		 			<div class="col-md-12">

		 			<div class="col-md-6" style="float: left;"><?php echo $row['opcion'];?></div>

		 			<div class="col-md-6" style="float: left;">$<?php echo $row['costo'];?></div>

		 			</div>

	 			</div>

	 		<?php 
	 			} while ($row=$db->fetch_assoc($obtener));

	 		?>

	 			</div>

	 			</div>
	 			

	 			</div>
	 		</div>
						<?php 
						$contador2++;

						}




					}
					 ?>
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

<style type="text/css">
	.table-condensed th, .table-condensed td {
    padding: 4px 5px;
}
</style>
<!-- <script  type="text/javascript" src="./js/mayusculas.js"></script>
-->
<script>


	BuscarProductosLista();
	ObtenerTablaprecios();

	var idpaquete=<?php echo $idpaquete; ?>;
	if (idpaquete>0) {
		ObtenerOpcionesdelPaquete(idpaquete);

		ObtenerPreciosPaquete(idpaquete);
		Precioprincipal(idpaquete);
	}


	 function SubirImagen() {
	 	// body...
	 
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: 'catalogos/paquetes/upload.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
             beforeSend: function() {
      $("#d_foto").css('display','block');
      $("#d_foto").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	

		    },
            success: function(response) {
                if (response != 0) {
                    $(".card-img-top").attr("src", response);
                    $("#d_foto").css('display','none');
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    }
</script>

<script>

	$("#v_empresa").chosen({width:"100%"});
	$("#v_categoria").chosen({width:"100%"});
	$("#v_presentacion").chosen({width:"100%"});
	$("#v_categoriaprecios").chosen({width:"100%"});
	$("#v_estatus").chosen({width:"100%"});
	Promo();
	Habilitarpromo();
	ObtenerPaquetesSinpomocion();

	var idpaquete='<?php echo $idpaquete;?>';
	var idpromocion='<?php echo $idpromocion;?>';

	if (idpaquete>0) {

		ObtenerPaquetesVinculados(idpaquete);
	}



    var today = new Date();

    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes();
    var dateTime = date+' '+time;
    /*$("#fechainicial").datetimepicker({
    	 language: 'es',
        format: 'dd-mm-yyyy hh:ii',
        autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });


    $("#fechafinal").datetimepicker({
    	 language: 'es',
        format: 'dd-mm-yyyy hh:ii',
        autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });*/
    //$(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

</script>


</script>

<?php 


	if(isset($_GET['idproducto'])){
		$idproducto=$_GET['idproducto'];
	 ?>

		<script type="text/javascript">

			var idproducto='<?php echo $idproducto;?>'	
			ObtenerProductoPaquete(idproducto);
		</script>

<?php
	}

 ?>
