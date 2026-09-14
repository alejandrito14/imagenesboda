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
require_once("../../clases/class.Productos_descripcion.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Categoriasprecios.php");
require_once("../../clases/class.Unidadmedida.php");


$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Productos();
$cat=new Categoriasprecios();
$productos_descripcion=new Productos_descripcion();
$f = new Funciones();
$bt = new Botones_permisos();
$productos_descripcion->db=$db;

$un = new UnidadMedida();

$un->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$emp->db =$db;

$cat->db=$db;


//obtenemos la lista de medidas..
$lista_medidas = $un->ListaMedidas();
$lista_medidas_row = $db->fetch_assoc($lista_medidas);
$lista_medidas_num = $db->num_rows($lista_medidas );


//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idproducto'])){
	//El formulario es de nuevo registro
	$idproducto = 0;

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
	$idcategorias=0;
	$idtipopresentacion=0;
	$titulo='NUEVO PRODUCTO';
	$nuevo=0;
	$idtipomedida=0;
	$codigo="validarProducto(id,'alt_btn');


					 if(validado==0){


					 	bandera=0;
					 	html+='CÓDIGO DE PRODUCTO YA EXISTE'+'<br>';

					 }";


}else{
	//El formulario funcionara para modificacion de un registro
	$_SESSION['CarritoProducto']=null;

	//Enviamos el id de la empresa a modificar a nuestra clase empresas
	$idproducto = $_GET['idproducto'];
	$emp->idproducto = $idproducto;
	$emp->empresa=$_GET['idempresas'];


	
	//Realizamos la consulta en tabla empresas
	$result_presentacion = $emp->buscarProducto();
	$result_presentacion_row = $db->fetch_assoc($result_presentacion);


	
	//Cargamos en las variables los datos de las empresas

	//DATOS GENERALES
	$nombreproducto = $f->imprimir_cadena_utf8($result_presentacion_row['nombre']);
	$descripcion = $f->imprimir_cadena_utf8($result_presentacion_row['descripcion']);
	$descuento = "";
	$titulo='EDITAR PRODUCTO';


	$codigoproducto = $f->imprimir_cadena_utf8($result_presentacion_row['codigoproducto']);
	
	$foto = $f->imprimir_cadena_utf8($result_presentacion_row['foto']);
	$estatus = $f->imprimir_cadena_utf8($result_presentacion_row['estatus']);
	$categoria = $f->imprimir_cadena_utf8($result_presentacion_row['idcategorias']);
	
	$idtipopresentacion= $f->imprimir_cadena_utf8($result_presentacion_row['idtipo_presentacion']);
	$idtipomedida=$f->imprimir_cadena_utf8($result_presentacion_row['idtipomedida']);


	$preciouni=$result_presentacion_row['pu'];
	$precioventa=$result_presentacion_row['pv'];

	$productos_descripcion->idproducto=$idproducto;
	/*$resul=$productos_descripcion->ObtenerDescripcionProducto();
	$resul_row=$db->fetch_assoc($resul);
	$num=$db->num_rows($resul);*/

	unset($_SESSION['CarritoProducto']);
	
		

	/*do{
		$idinsumo=$resul_row['idinsumos'];
		$cantidad=$resul_row['cantidad'];
		$nombre=$resul_row['nombre'];
		$pm='';
		$subtotal='';
		$medida=$resul_row['medida'];
		$subtotalmedida=$resul_row['subtotalmedida'];
		$tipomedida=$resul_row['tipomedida'];

		 $_SESSION['CarritoProducto'][$idinsumo] = $cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida;

	}while($resul_row=$db->fetch_assoc($resul));
*/
		$validacion=2;
	
	if($foto==""){
		$ruta="images/sinfoto.png";
	}
	else{
		$ruta="catalogos/productos/imagenes/$foto";
	}

	$col = "col-md-12";
	$ver = "";
	$disabled ="disabled";

	$nuevo=1;

	$codigo="";
	
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

<form id="f_productos" name="f_productos" method="post" action="">
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
					var resp=MM_validateForm('codigoproducto','','R','v_nombre','','R');
					
					var id=$('#id').val();
					var v_categoria=$('#v_categoria').val();
					var v_idtipo_medida=$('#v_idtipo_medida').val();
					var v_categoriaprecios=$('#v_categoriaprecios').val();
					bandera=1;
					var html='';
					
				
					if(v_idtipo_medida==0){

						bandera=0;
					html+='TIPO DE MEDIDA Es requerido'+'<br>';

					}
					

					if(bandera==1){
					 if(resp==1){ 
					 	PreguntarSiesproducto('f_productos','catalogos/productos/vi_productos.php','main','$idmenumodulo');

					 	}

					}else{

						$('#modal-title').append(html);
						$('#modal-notificacion').modal();


					}

					";
					
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success habilitarboton';
				
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
				
				<button type="button" onClick="aparecermodulos('catalogos/productos/vi_productos.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE PRODUCTOS</button>
				<div style="clear: both;"></div>
				
				
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
		<div class="">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
					<!--<h5>DATOS</h5>-->

				</div>

				<div class="card-body col-md-6" >
					
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">
							<h5>DATOS GENERALES</h5>
									

						<div class="form-group m-t-20">
						<label>CÓDIGO PRODUCTO</label>
						<input type="hidden" id="id" name="id" value="<?php echo $idproducto;?>">
							<input type="hidden" name="VALIDACION" id="VALIDACION" value="<?php echo ($validacion);?>" ></input>
						    
						    <input type="text" onblur="validarProducto(this.value,'alt_btn')" name="codigoproducto" id="codigoproducto" class="form-control" title="CODIGO DE PRODUCTO" value="<?php echo ($codigoproducto); ?>" placeholder="CÓDIGO" >

						   

						    <span style="margin-left:2%" id="error" ></span>
					</div>
							
							<div class="form-group m-t-20">
								<label>NOMBRE:</label>
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombreproducto; ?>" title="NOMBRE"  placeholder="NOMBRE">
							</div>

							

							<div class="form-group m-t-20">
								<label>DESCRIPCION:</label>
								<textarea id="v_descripcion" name="v_descripcion" title="DESCRIPCION" class="form-control" style="height: 85px;"><?php echo $descripcion; ?></textarea>
							</div>
						
					
						
						<div class="form-group m-t-20" style="display: none;">
								<label>CATEGORÍA:</label>
								<?php 
								
									$categorias= $emp->obtenerCategorias();
									$categorias_num=$db->num_rows($categorias);
									$categorias_row=$db->fetch_assoc($categorias);
								?>
								<select  class="form-control" id="v_categoria" name="v_categoria" title="FAMILIA DE PRODUCTOS">
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

								<div class="form-group m-t-20">
						<label>UNIDAD DE MEDIDA</label>
						
						<select id="v_idtipo_medida" name="v_idtipo_medida" class="form-control">
							<option value="0">SELECCIONAR UNIDAD DE MEDIDA</option>
							<?php
							do
							{
								?>
							<option value="<?php echo $lista_medidas_row['idtipo_medida'] ;?>" <?php if($lista_medidas_row['idtipo_medida']==$idtipomedida){ echo ("selected");} ?>><?php echo $lista_medidas_row['nombre'] ;?></option>
							<?php
							}while($lista_medidas_row = $db->fetch_assoc($lista_medidas));
							?>
						  
						</select>

					</div>

					<div class="form-group m-t-20">
								<label>ESTATUS:</label>
							<select class="form-control" id="v_estatus" name="v_estatus">
							<option value="1" <?php if(1==$estatus){echo "selected";}?>>ACTIVADO</option>
							<option value="0" <?php if(0==$estatus){echo "selected";}?>>DESACTIVADO</option>
							</select>
								
							</div>

						<!-- <div class="form-group m-t-20">


								<label>PRESENTACION:</label>
								<?php 

								
									$presentacion= $emp->obtenerPresentacion();
									$presentacion_num=$db->num_rows($presentacion);
									$presentacion_row=$db->fetch_assoc($presentacion);
								
								?>
								<select  class="form-control" id="v_presentacion" name="v_presentacion" title="PRESENTACIÓN">
									<option value="0">SELECCIONAR PRESENTACIÓN</option>
									<?php
									do{
									?>
									<option value="<?php echo ($presentacion_row['idtipo_presentacion']);?>" <?php if($presentacion_row['idtipo_presentacion']==$idtipopresentacion){ echo "selected";}?>>
										<?php echo ($presentacion_row['nombre']);?></option>
									
									<?php 
										} while($presentacion_row=$db->fetch_assoc($presentacion));
									?>
								</select>
							</div> -->


							<!-- <div class="form-group m-t-20">
								<label>CATEGORIA DE PRECIOS:</label>
							
								<select  class="form-control" id="v_categoriaprecios" name="v_categoriaprecios" title="CATEGORIA DE PRECIOS" onchange="CargaInsumoEmpresa()">
									<option value="0">SELECCIONAR CATEGORIA DE PRECIOS</option>
								</select>
							</div> -->



						
						<div class="form-group m-t-20" style="display: none;" >
								<label>PRECIO NORMAL $:</label>
								<input type="text" id="preciounitario" name="preciounitario" class="form-control"value="<?php echo $preciouni; ?>" >
								
							</div>

							<div class="form-group m-t-20" style="display: none;">
								<label>PRECIO VENTA $:</label>
							<input type="number" id="precioventa" class="form-control" value="<?php echo $precioventa; ?>">
							
								
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
<script>

	
	//CargaInsumoEmpresa();
	ObtenerCategoriasPrecios(0,<?php echo $categoria;?>);
	CargaInsumoEmpresa2(<?php echo $idcategorias;?>);

</script>

<script>
		$("#v_empresa").chosen({width:"100%"});
		$("#v_categoria").chosen({width:"100%"});
	    $("#v_presentacion").chosen({width:"100%"});
	    $("#v_categoriaprecios").chosen({width:"100%"});
	    $("#v_estatus").chosen({width:"100%"});
   
	    $("#v_idtipo_medida").chosen({width:"100%"});




</script>
	
<?php

?>