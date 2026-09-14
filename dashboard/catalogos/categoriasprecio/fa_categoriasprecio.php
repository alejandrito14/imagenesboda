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
require_once("../../clases/class.Categoriasprecios.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Unidadmedida.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Categoriasprecios();
$f = new Funciones();
$bt = new Botones_permisos();
$un = new UnidadMedida();

$emp->db = $db;
$un->db=$db;
$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//obtenemos la lista de medidas..
$lista_medidas = $un->ListaMedidas();
$lista_medidas_row = $db->fetch_assoc($lista_medidas);
$lista_medidas_num = $db->num_rows($lista_medidas );

//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idcategoriaprecio'])){
	//El formulario es de nuevo registro
	$idcategoriaprecio = 0;

	//Se declaran todas las variables vacias
	$nombre = "";
	$descripcion = "";
	$empresa="";

	
	$col = "col-md-12";
	$ver = "display:none;";
	$resul_num_rangos=0;
    $resul_num_insumos=0;
	$disable="";
	$idtipomedida=0;
	$titulo='NUEVO PRECIO';


}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id de la empresa a modificar a nuestra clase empresas
	$idcategoriaprecio = $_GET['idcategoriaprecio'];
	$emp->idcategoriaprecios = $idcategoriaprecio;

	//Realizamos la consulta en tabla empresas
	$result_presentacion = $emp->buscarCategoria();
	$result_presentacion_row = $db->fetch_assoc($result_presentacion);


	//Cargamos en las variables los datos de las empresas

	//DATOS GENERALES
	$nombre = $f->imprimir_cadena_utf8($result_presentacion_row['categoria']);
	$descripcion = $f->imprimir_cadena_utf8($result_presentacion_row['descripcion']);
    $empresa = $f->imprimir_cadena_utf8($result_presentacion_row['idempresas']);
	$idtipomedida=$f->imprimir_cadena_utf8($result_presentacion_row['idtipo_medida']);

	$emp->empresa = $empresa;
	
	$result_rangos=$emp->ObtenerRangosPrecios();
	$result_rangos_row=$db->fetch_assoc($result_rangos);
	$resul_num_rangos=$db->num_rows($result_rangos);

	$result_insumos=$emp->ObtenerInsumosAcategoria();
	$result_insumos_row=$db->fetch_assoc($result_insumos);
	$resul_num_insumos=$db->num_rows($result_insumos);

	$disable="disabled";

	$col = "col-md-12";
	$ver = "";
	$titulo='EDITAR PRECIO';

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

<form id="f_categoriapre" name="f_categoria" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_nombre','','R','v_depende','','isNum'); if(resp==1){ GuardarCategoriasRango('f_categoriapre','catalogos/categoriasprecio/vi_categoriaprecios.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idcategoriaprecio == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/categoriasprecio/vi_categoriaprecios.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE PRECIOS</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idcategoria; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
					<!--<h5>DATOS</h5>-->

				</div>

				<div class="card-body">
					
					
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">
							<input type="hidden" id="idcate" value="<?php echo $idcategoriaprecio; ?>">

							<div class="form-group ">
								<label>*NOMBRE:</label>
								<input type="text" class="form-control" id="v_nombre" name="v_nombre" value="<?php echo $nombre; ?>" title="NOMBRE" placeholder='NOMBRE'>
							</div>
	
						<div class="form-group ">
								<label>DESCRIPCION:</label>
								<input type="text" class="form-control" id="v_descripcion" name="v_descripcion" value="<?php echo $descripcion; ?>" title="DESCRIPCION" placeholder='DESCRIPCION'>
							</div>
							


							<div class="form-group ">
								<label>EMPRESA:</label>
								<?php 
									$empresas= $emp->obtenerEmpresas();
									$empresas_num=$db->num_rows($empresas);
									$empresas_row=$db->fetch_assoc($empresas);
								
								?>
								<select   class="form-control" onchange="ObtenerInsumoscategoria();" id="v_empresa" name="v_empresa" <?php echo $disable; ?> >
									<?php
									do{
									?>
									<option value="<?php echo ($empresas_row['idempresas']);?>" <?php if($empresas_row['idempresas']==$empresa){ echo "selected";}?>><?php echo ($empresas_row['empresas']);?></option>
									
									<?php 
										} while($empresas_row=$db->fetch_assoc($empresas));
									?>
								</select>
							</div>
							
					<div class="form-group ">
						<label>TIPO DE MEDIDA:</label>
						
						<select id="v_idtipo_medida" name="v_idtipo_medida" class="form-control" onchange="ObtenerInsumoscategoria();">
							<option value="0">SELECCIONAR TIPO MEDIDA</option>

							<?php

							do
							{


								?>
							<option value="<?php echo $lista_medidas_row['idtipo_medida'] ;?>" <?php if ($lista_medidas_row['idtipo_medida']==$idtipomedida) {
								echo "selected";} ?> ><?php echo $lista_medidas_row['nombre'] ; ?></option>
							<?php
							}while($lista_medidas_row = $db->fetch_assoc($lista_medidas));
							?>
						  
						</select>

					</div>

							

						

							
						</div>
						
						
					
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
		<div class="card">
						<div class="card-header">RANGOS</div>

			<div class="card-body">

			<div class="row">
				<input type="hidden" id="idrango" value="0">
					
							<div class="col-xs-6	col-sm-6	col-md-6 col-lg-6">

										<label>RANGO INICIAL:</label>
									    <input type="text"  id="v_ri" name="v_ri" value="<?php echo $v_ri; ?>" title="RANGO INICIAL"  class="form-control"   >


							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

								<label>RANGO FINAL:</label>
							    <input type="text"  id="v_rf" name="v_rf" value="<?php echo $v_rf; ?>" title="RANGO FINAL"  class="form-control"   >

							</div>

			
					
					</div>
					
					<div class="row">
					
							<div class="col-xs-6	col-sm-6	col-md-6 col-lg-6">

						     <label>PRECIO VENTA $:</label>
						     <input type="text" class="form-control" id="v_pv" name="v_pv" value="<?php echo $v_pv; ?>" title="PRECIO DE LA UNIDAD">


							</div>
						<input type="hidden" value="0" id="v_idprecios_rango" name="v_idprecios_rango">

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >

									<!-- <?php


										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "AGREGAR RANGO";
										$bt->icon = "mdi mdi-content-save";
										$bt->funcion = "var resp=MM_validateForm('v_ri','','RisNum','v_rf','','RisNum','v_pv','','RisNum'); if(resp==1){ GuardarR($idmenumodulo);}";
										$bt->estilos = "margin-top: 10px; width: 90%; height: 82%";
										$bt->permiso = $permisos;
										$bt->tipo = 1;
										$bt->armar_boton();
									?> -->
						<br>

					<button type="button" id="btn_agregar" onclick="var resp=MM_validateForm('v_ri','','RisNum','v_rf','','RisNum','v_pv','','RisNum'); if(resp==1){ GuardarR();}" class="btn btn-primary">AGREGAR RANGO</button>





				

							</div>
						
						

			
					
					</div>


					<br>
					
					<div class="row" id="d_lista_rangos" >
					
						<table class="table">
						  <thead>
							<tr>
							  <th scope="col">RI</th>
							  <th scope="col">RF</th>
							  <th scope="col">PV</th>
							   <th scope="col">ACCIÓN</th>

							</tr>
						  </thead>
						  <tbody id="rangosdeprecios">
							<?php if ($resul_num_rangos==0){ ?>

							<tr class="remove">
								 <td colspan="4" style="text-align: center">
		  						<h4 class="alert_warning">NO EXISTEN RANGOS EN LA BASE DE DATOS.</h4>
			  					</td>
							</tr>


								
							<?php }else{
									do {?>
								
			<tr class="rangostr" id="eliminar_<?php echo $result_rangos_row['idprecios_rango']?>">
			
			<td><input type="hidden" value="<?php echo $result_rangos_row['ri']?>" class="rango1"><?php echo $result_rangos_row['ri']?></td>


			<td><input type="hidden" value="<?php echo $result_rangos_row['rf']?>" class="rango2"><?php echo $result_rangos_row['rf']?></td>
			<td><input type="hidden" value="<?php echo $result_rangos_row['pv']?>" class="rangop">$<?php echo $result_rangos_row['pv']?></td>
			<td>

				<button type="button" id="editar_<?php echo $result_rangos_row['idprecios_rango']?>"
			 onclick="EditarRango('<?php echo $result_rangos_row['idprecios_rango']?>')" class="btn btn-primary"><i class="mdi mdi-table-edit"></i></button>




				<button type="button" id="eliminar_<?php echo $result_rangos_row['idprecios_rango']?>"
			 onclick="BorrarRang('<?php echo $result_rangos_row['idprecios_rango']?>')" class="btn btn-primary"><i class="mdi mdi-delete-empty"></i></button>


				

			</td>

			</tr>



							<?php } while ($result_rangos_row=$db->fetch_assoc($result_rangos));

							?>

								


						<?php	} ?>



						
							
						  </tbody>
						</table>
					
					</div>

				</div>

		</div>
	</div>



			<div class="col-md-6">
		<div class="card">
			<div class="card-header">INSUMOS</div>
			<div class="card-body">

			<div class="row">
				<label for="">INSUMOS</label>
				<select name="v_productos" id="v_productos" class="form-control">
					<option value="0">SELECCIONAR INSUMOS</option>
				</select>

			
					
					</div>
					<br>
					
					<div class="row">
					<div class=" col-md-12">

					<div style="float: right;">
					<button type="button" id="btn_agregar" onclick="var resp=MM_validateForm('v_productos','','R'); if(resp==1){ GuardarInsumo();}" class="btn btn-primary">AGREGAR INSUMO</button>
					</div>	

							</div>
						
						

			
					
					</div>


					<br>
					
					<div class="row" id="d_lista_rangos" >
					
						<table class="table">
						  <thead>
							<tr>
							  <th scope="col" style="text-align: center;">COD. INSUMO</th>
							  <th scope="col" style="text-align: center;">NOMBRE</th>
							
							   <th scope="col" style="text-align: center;">ACCIÓN</th>

							</tr>
						  </thead>
						  <tbody id="insumoslista">
							<?php if ($resul_num_insumos==0){ ?>

							<tr class="remove2">
								 <td colspan="4" style="text-align: center">
		  						<h4 class="alert_warning">NO EXISTEN INSUMOS EN LA BASE DE DATOS.</h4>
			  					</td>
							</tr>


								
							<?php }else{
									do {?>
								
			<tr class="insumostr" id="eliminarinsu_<?php echo $result_insumos_row['idinsumos']?>">
			
			


			<td style="text-align: center;"><input type="hidden" value="<?php echo $result_insumos_row['idinsumos']?>" class="codinsumo"><?php echo $result_insumos_row['idinsumos']?></td>
			<td style="text-align: center;"><input type="hidden" value="<?php echo $result_insumos_row['nombre']?>" class="nombreinsumo"><?php echo $result_insumos_row['nombre']?></td>
			<td style="text-align:center">

			

				<button type="button" id="eliminar_<?php echo $result_insumos_row['idinsumos']?>"
			 onclick="BorrarInsumo('<?php echo $result_insumos_row['idinsumos']?>')" class="btn btn-primary"><i class="mdi mdi-delete-empty"></i></button>


				

			</td>

			</tr>
			



							<?php } while ($result_insumos_row=$db->fetch_assoc($result_insumos));

							?>

								


						<?php	} ?>



						
							
						  </tbody>
						</table>
					
					</div>

				</div>

		</div>
		</div>
		</div>


	</div>
</form>
<script  type="text/javascript" src="./js/mayusculas.js"></script>

<?php
	echo '<script type="text/javascript">ObtenerInsumoscategoria();</script>'; 


?>

<script>
	$("#v_empresa").chosen({width:"100%"});
	$("#v_idtipo_medida").chosen({width:"100%"});

</script>