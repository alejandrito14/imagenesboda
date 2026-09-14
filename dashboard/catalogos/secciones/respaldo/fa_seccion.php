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
require_once("../../clases/class.Seccion.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Sucursal.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Seccion();
$f = new Funciones();
$bt = new Botones_permisos();
$sucursal=new Sucursal();

$emp->db = $db;
$sucursal->db=$db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$listadosucursales=$sucursal->ObtenerSucursalesLista();
//Validamos si cargar el formulario para nuevo registro o para modificacion
if(!isset($_GET['idseccion'])){
	//El formulario es de nuevo registro
	$idseccion = 0;

	//Se declaran todas las variables vacias
	 $dia='';
	 $mes='';
	 $anio='';
	 $hora='';
	 $estatus=1;
	$disable="";

	$col = "col-md-12";
	$ver = "display:none;";
	$titulo='NUEVA SECCIÓN';
	$tituloseccion="";
	$principal=0;
	$tipo=0;

}else{
	//El formulario funcionara para modificacion de un registro

	//Enviamos el id del pagos a modificar a nuestra clase Pagos
	$idseccion = $_GET['idseccion'];
	$emp->idseccion = $idseccion;

	//Realizamos la consulta en tabla Pagos
	$result_seccion = $emp->Obtenerseccion();
	$result_seccion_row = $db->fetch_assoc($result_seccion);


	$tituloseccion=$f->imprimir_cadena_utf8($result_seccion_row['titulo']);
	$descripcion=$result_seccion_row['descripcion'];
	$tipo=$result_seccion_row['tipo'];
	$estatus = $f->imprimir_cadena_utf8($result_seccion_row['estatus']);
	$foto = $f->imprimir_cadena_utf8($result_seccion_row['foto']);
	$rutafoto='./catalogos/secciones/imagenes/'.$_SESSION['codservicio'].'/'.$foto;
	
	$arrayimagenes=array();
		$arrayimagenespromo=array();

	if ($tipo==1) {
		$imagenesseccion=$emp->Obtenerimagenesrevista();
	
		for ($i=0; $i < count($imagenesseccion); $i++) { 
			
			$ruta='./catalogos/secciones/imagenesrevista/'.$_SESSION['codservicio'].'/'.$imagenesseccion[$i]->ruta;
			$orden=$imagenesseccion[$i]->orden;
			$estatus1=$imagenesseccion[$i]->estatus;
			$imagen=$imagenesseccion[$i]->ruta;
			$info = array('ruta' => $ruta,'ordenimagen'=>$orden,'v_estatusimagen'=>$estatus1,'nombreimagen'=>$imagen);
			array_push($arrayimagenes,$info);

		}

		$imagenespromocionales=$emp->Obtenerimagenespromocion();

		for ($i=0; $i < count($imagenespromocionales); $i++) { 
			
			$ruta='./catalogos/secciones/imagenespromo/'.$_SESSION['codservicio'].'/'.$imagenespromocionales[$i]->ruta;
			$orden=$imagenespromocionales[$i]->orden;
			$estatus1=$imagenespromocionales[$i]->estatus;
			$imagen=$imagenespromocionales[$i]->ruta;
			$info = array('ruta' => $ruta,'ordenimagen'=>$orden,'v_estatusimagen'=>$estatus1,'nombreimagen'=>$imagen);
			array_push($arrayimagenespromo,$info);
		}

		
	}


	$col = "col-md-12";
	$ver = "";
		$titulo='EDITAR SECCIÓN';

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

<form id="f_seccion" name="f_seccion" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "var resp=MM_validateForm('v_seccion','','R'); if(resp==1){ Guardarseccion('f_seccion','catalogos/secciones/vi_secciones.php','main','$idmenumodulo');}";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				if($idseccion == 0)
					{
						$bt->tipo = 1;
					}else{
						$bt->tipo = 2;
					}
			
					$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				<button type="button" onClick="aparecermodulos('catalogos/secciones/vi_secciones.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" style="float: right; margin-right: 10px;"><i class="mdi mdi-arrow-left-box"></i> LISTADO DE SECCIONES</button>
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idseccion; ?>" />
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

									
								    <div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
								        <img class="card-img-top imagenfoto" src="">
								        <div id="d_fotoimagen" style="text-align:center; ">
											<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid"> 
										</div>
								        <div class="card-body">
								            <h5 class="card-title"></h5>
								           
								            <div class="form-group">

								            	
								               
								                <input type="file" class="form-control-file" name="image" id="image" onchange="SubirImagen()">
								            </div>
								          <!--   <input type="button" class="btn btn-primary upload" value="Subir"> -->
								        </div>
								    </div>
								
								<p style="text-align: center;">Dimensiones de la imagen Ancho:640px Alto:420px</p>


								</div>
		<div class="col-md-6">

				<div class="card-body">
					
					
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active show" id="generales" role="tabpanel">


							
							<div class="form-group m-t-20">
								<label>*TITULO:</label>
								<input type="text" class="form-control" title="TITULO" id="v_seccion" name="v_seccion" value="<?php echo $tituloseccion; ?>" >
							</div>

					

							<div class="form-group m-t-20">
								<label>*DESCRIPCIÓN:</label>
								<input type="text" class="form-control" id="v_descripcion" name="v_descripcion" value="<?php echo $descripcion; ?>" title="DESCRIPCIÓN">
							</div>

							
						<div class="form-group m-t-20">
							<label>ESTATUS:</label>
							<select name="v_estatus" id="v_estatus" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVADO</option>
							</select>
						</div>



						<div class="form-group m-t-20">
							<label>TIPO:</label>
							<select name="v_tipo" id="v_tipo" title="Tipo" class="form-control"  >
								<option value="0">SELECCIONAR TIPO</option>
								<option value="1"  <?php if($tipo == 1) { echo "selected"; } ?> >REVISTA</option>
								<option  value="2"  <?php if($tipo == 2) { echo "selected"; } ?> >NOTICIAS</option>
								<option value="3"  <?php if($tipo == 3) { echo "selected"; } ?> >CALENDARIO</option>
							</select>
						</div>

						<div class="form-group m-t-20">
							<label for="">SELECCIONAR SUCURSAL:</label>
						<div id="listadosucursales">
							
							<?php 
							for ($i=0; $i < count($listadosucursales); $i++) { 

								?>
									
								<div class="row">
								<div class="col-md-2"></div>
								  <div class="col-md-6">
								  		<label><?php echo $listadosucursales[$i]->sucursal ?></label>	
								  </div>
								  <div class="col-md-2">
								  	<input type="checkbox" class="sucursalvinculado" name="" id="sucursalvinculado_<?php echo $listadosucursales[$i]->idsucursales;?>" onchange="SeleccionarSucursalesvinculado(<?php echo $listadosucursales[$i]->idsucursales;?>)"></div>
								 
								</div>

							<?php	}

							 ?>
						</div>
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

					<div class="row">
					
				<div class="col-md-4"><label style="font-size: 16px;">IMÁGENES DE REVISTA</label></div>
						<div class="col-md-4">
								
						</div>
						<div class="col-md-4">
								<button type="button" onclick="AbrirModal()" class="btn btn-primary">AGREGAR</button>
						</div>
						</div>
			

			</div>
		<div class="card-body col-md-12">
	
					
					

					<div class="row">
						<table id="tbl_seccion" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						 
						<th style="text-align: center;">IMAGEN </th> 
					
						<th style="text-align: center;">ORDEN</th>
						<th style="text-align: center;">ESTATUS</th>

						<th style="text-align: center;">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody id="imagenesfilas">
					
					
							<tr>
							
						
							
							<td style="text-align: center;"></td>

						
							<td style="text-align: center;"></td>

							<td style="text-align: center; font-size: 15px;">

								

								</td>
							<td style="text-align: center; font-size: 15px;">

								

								</td>

							</tr>
						
				</tbody>
			</table>
					</div>


						
					</div>
				</div>
			</div>


			<div class="col-md-12">
	<div class="card">
		<div class="card-header">

					<div class="row">
					
				<div class="col-md-4"><label style="font-size: 16px;">IMÁGENES PROMOCIONALES</label></div>
						<div class="col-md-4">
								
						</div>
						<div class="col-md-4">
								<button type="button" onclick="AbrirModalPromocion()" class="btn btn-primary">AGREGAR</button>
						</div>
						</div>
			

			</div>
		<div class="card-body col-md-12">
	
					
					

					<div class="row">
						<table id="tbl_seccion" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						 
						<th style="text-align: center;">IMAGEN </th> 
					
						<th style="text-align: center;">ORDEN</th>
						<th style="text-align: center;">ESTATUS</th>

						<th style="text-align: center;">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody id="imagenespromocionales">
					
					
							<tr>
							
						
							
							<td style="text-align: center;"></td>

						
							<td style="text-align: center;"></td>

							<td style="text-align: center; font-size: 15px;">

								

								</td>
							<td style="text-align: center; font-size: 15px;">

								

								</td>

							</tr>
						
				</tbody>
			</table>
					</div>


						
					</div>
				</div>
			</div>

		</div>
	</div>


	</div>
</form>


<div class="modal" id="modalimagenes" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">IMÁGEN DE REVISTA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
       	<div class="" style="justify-content: center;text-align: center;margin: auto;">

									
			<div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
			 <img class="card-img-top imagenrevista" src="">
					<div id="d_fotorevista" style="text-align:center; ">
						<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid"> 
					</div>
					<div class="card-body">
						 <h5 class="card-title"></h5>
								           
						 <div class="form-group">

								            	
								               
						 <input type="file" class="form-control-file" name="imagerevista" id="imagerevista" onchange="SubirImagenderevista()">
		 				</div>
								         
					  </div>
	  				  </div>
								
					<p style="text-align: center;">Dimensiones de la imagen Ancho:640px Alto:750px</p>


					</div>
				</div>
							<div class="">
								<div class="form-group">
								<label for="">ORDEN:</label>
								<input type="number" id="ordenimagen" class="form-control">
							</div>
							</div>

							<div class="">
								<div class="form-group ">
							<label>ESTATUS:</label>
							<select name="v_estatusimagen" id="v_estatusimagen" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVADO</option>
							</select>
						</div>
							</div>




       </div>
       
   
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnguardardatos" onclick="GuardarDatos(-1)">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal" id="modalimagenespromocion" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">IMAGEN PROMOCIONAL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
       	<div class="" style="justify-content: center;text-align: center;margin: auto;">

									
			<div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
			 <img class="card-img-top imagenpromo" src="">
					<div id="d_fotopromo" style="text-align:center; ">
						<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid"> 
					</div>
					<div class="card-body">
						 <h5 class="card-title"></h5>
								           
						 <div class="form-group">

								            	
								               
						 <input type="file" class="form-control-file" name="imagepromo" id="imagepromo" onchange="SubirImagendepromo()">
		 				</div>
								         
					  </div>
	  				  </div>
								
					<p style="text-align: center;">Dimensiones de la imagen Ancho:290px Alto:100px</p>


					</div>
				</div>
							<div class="">
								<div class="form-group">
								<label for="">ORDEN:</label>
								<input type="number" id="ordenpromo" class="form-control">
							</div>
							</div>

							<div class="">
								<div class="form-group ">
							<label>ESTATUS:</label>
							<select name="v_estatusimagenpromo" id="v_estatusimagenpromo" title="Estatus" class="form-control"  >
								<option value="0" <?php if($estatus == 0) { echo "selected"; } ?> >DESACTIVO</option>
								<option value="1" <?php if($estatus == 1) { echo "selected"; } ?> >ACTIVADO</option>
							</select>
						</div>
							</div>




       </div>
       
   
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnpromoguardar" onclick="GuardarDatosPromo(-1)">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
	var idseccion='<?php echo $idseccion;?>';
	var imagenesderevista=[];
	var tipo='<?php echo $tipo;?>';
	var foto='<?php echo $foto;?>';
	var rutafoto='<?php echo $rutafoto;?>';
	var imagenprincipal="";
	var imagenespromo=[];

	if (idseccion>0) {

		if (tipo==1) {
			var imagenesderevista=<?php echo json_encode($arrayimagenes);?>;
			 if (imagenesderevista.length>0) {
			 			PintarImagenesSeccion();
	
			 }

			 var imagenespromo=<?php echo json_encode($arrayimagenespromo);?>;


			 if (imagenespromo.length>0) {
			 	
			 	PintarImagenesSeccionPromo();
	
			 }
		}

	
		if (foto!='') {
			imagenprincipal=foto;
			 $(".imagenfoto").attr("src", rutafoto);
             $("#d_fotoimagen").css('display','none');
		}

		ObtenerSucursalesVinculadas(idseccion);


	}

	
	 function SubirImagenderevista() {
	 	// body...
	 
        var formData = new FormData();
        var files = $('#imagerevista')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: 'catalogos/secciones/uploadimagenrevista.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
              beforeSend: function() {
	      $("#d_fotorevista").css('display','block');
	      $("#d_fotorevista").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	

		    },
        	success: function(response) {
               	var ruta2='<?php echo $ruta2; ?>';
	
                if (response != 0) {
                    $(".imagenrevista").attr("src", response);
                    $("#d_fotorevista").css('display','none');
                } else {

                	 $("#d_fotorevista").html('<img src="'+ruta2+'" class="card-img-top" alt="" style="border: 1px #777 solid"/> ');
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    }


     function SubirImagen() {
	 	// body...
	 
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: 'catalogos/secciones/uploadimagen.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
              beforeSend: function() {
	      $("#d_fotoimagen").css('display','block');
	      $("#d_fotoimagen").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	

		    },
        	success: function(response) {
               	var ruta1='<?php echo $rutafoto; ?>';
	
                if (response != 0) {

                	imagenprincipal=response.split('/')[4];

                    $(".imagenfoto").attr("src", response);
                    $("#d_fotoimagen").css('display','none');
                }else{

                	 $("#d_fotoimagen").html('<img src="'+ruta1+'" class="card-img-top" alt="" style="border: 1px #777 solid"/> ');
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    }

    function SubirImagendepromo() {
    	 var formData = new FormData();
        var files = $('#imagepromo')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: 'catalogos/secciones/uploadimagenpromo.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
              beforeSend: function() {
	      $("#d_fotopromo").css('display','block');
	      $("#d_fotopromo").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	

		    },
        	success: function(response) {
               	var ruta3='<?php echo $ruta3; ?>';
	
                if (response != 0) {
                    $(".imagenpromo").attr("src", response);
                    $("#d_fotopromo").css('display','none');
                } else {

                	 $("#d_fotopromo").html('<img src="'+ruta2+'" class="card-img-top" alt="" style="border: 1px #777 solid"/> ');
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    }
</script>

<?php

?>