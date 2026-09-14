<?php
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Funciones.php");

//creamos nuestra sesion.
$se = new Sesion();
$fu = new Funciones();


if(!isset($_SESSION['se_SAS']))
{
	///*header("Location: ../../login.php"); */ echo "login";

	echo "login";
	exit;
	//aparecermodulos('catalogos/clientes/vi_clientes.php?idmenumodulo=15','main'); return false;
}

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

require_once("../../clases/conexcion.php");
require_once("../../clases/class.PagConfig.php");

$db = new MySQL();
$conf = new Configuracion();

$conf->db = $db;


try{  

	$row_configuracion = $conf->ObtenerInformacionConfiguracion();


	if($row_configuracion['cuantos'] == 0)
	{
		$id = 0;
		$texto1="";
	}else
	{
		$id =  $row_configuracion['idpagina_configuracion'];
		$texto1=$row_configuracion['texto1'];
		$bloquearediciondatoscliente=$row_configuracion['ediciondedatoscliente'];

		
	}


	?>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

	<form name="f_configuracion" id="f_configuracion">
		<div class="card">

			<div class="card-body">

				<h5 class="card-title m-b-0">CONFIGURACI&Oacute;N DE TU EMPRESA</h5>

				<br>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">DATOS GENERALES</span></a> </li>

					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">REDES SOCIALES</span></a> </li>


					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#textos" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">CONFIGURACIÓN EN LA APP</span></a> </li>


					<li class="nav-item" style="display: none;"> <a class="nav-link" data-toggle="tab" href="#pasarelapago" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">PASARELA DE PAGO CONEKTA</span></a> </li>


					<li class="nav-item" style="display: none;"> <a class="nav-link" data-toggle="tab" href="#correoenvio" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">SALIDA DE CORREO</span></a> </li>
				</ul>
				<!-- Tab panes -->

				<div class="tab-content tabcontent-border">


					<div class="tab-pane active" id="home" role="tabpanel">

						<div class="form-group m-t-20" align="center">
							<label style="width:92%;">LOGO</label>
							
								<?php
								if($row_configuracion['logo'] != "")
								{
									$imagen = "catalogos/configuracion/imagenes/".$_SESSION['codservicio']."/".$row_configuracion['logo'];
								}else{
									$imagen = "images/configuracion/market.png";
								}
								?>


								<form method="post" action="#" enctype="multipart/form-data">
								    <div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
								        <img class="card-img-top" src="">
								        <div id="d_foto" style="text-align:center; ">
											<img src="<?php echo $imagen; ?>" class="card-img-top" alt="" style="border: 1px #777 solid"/> 
										</div>
								        <div class="card-body">
								            <h5 class="card-title"></h5>
								           
								            <div class="form-group">

								            	
								               
								                <input type="file" class="form-control-file"  id="v_logo" name="v_logo[]"  onchange="SubirImagenLogo()">
								            </div>
								          <!--   <input type="button" class="btn btn-primary upload" value="Subir"> -->
								        </div>
								    </div>
								</form>
								<p style="text-align: center;">Dimensiones de la imagen Ancho:320px Alto:340px</p>


							<!-- <div id="d_logo" style="text-align:center">
								<img src="<?php echo $imagen; ?>" alt="" style="border: 1px #707070 solid; width: 15em; height: 15em" /> 
							</div>

							<p style="text-align:center;">&nbsp;&nbsp;Dimensiones de la imagen Ancho:873px Alto:882px</p>   
							<div class="spacer"></div>
							<input type="file" id="v_logo" name="v_logo[]">
 -->

						</div>

						<div class="row" style="display: none;">
							<div class="col-md-12">
								<div class="form-group m-t-20">
							<label for="">TEXTO DE BIENVENIDA</label>
							<textarea style="height: 20px;" name="descripcion" id="descripcion" cols="1" rows="1" class="form-control"><?php echo $fu->imprimir_cadena_utf8($row_configuracion['bienvenida']); ?></textarea>
						</div>
					</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>NOMBRE DE LA EMPRESA</label>
									<input name="nombrenegocio1" type="text" id="nombrenegocio1" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['nombrenegocio1']) ?>">
								</div>	
							</div>
						</div>

						<div class="row">


							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>TEL&Eacute;FONO 1</label>
									<input name="telefono1" type="text" id="telefono1" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['telefono']) ?>">
								</div>	
							</div>
						</div>
							<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>TEL&Eacute;FONO 2</label>
									<input name="telefono2" type="text" id="telefono2" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['telefono1'])?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>TELEFONO 3</label>
									<input name="telefono01800" type="text" id="telefono01800" class="form-control" title="NO. 01800" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['telefono01800']); ?>">
								</div>	
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>CELULAR 1</label>
									<input name="celular" type="text" id="celular" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['cel'])?>">
								</div>	
							</div>
						</div>

							<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>CELULAR 2</label>
									<input name="celular2" type="text" id="celular2" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['cel1'])?>">
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>WHATSAPP 1</label>
									<input name="whatsapp" type="text" id="whatsapp" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['whatsapp'])?>">
								</div>	
							</div>
						</div>
							<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>WHATSAPP 2</label>
									<input name="whatsapp2" type="text" id="whatsapp2" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['whatsapp2'])?>">
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>EMAIL 1</label>
									<input name="emailsoporte" type="text" id="emailsoporte" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['emailsoporte']);?>">
								</div>	
							</div>

						</div>
							<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>EMAIL 2</label>
									<input name="emailpedido" type="text" id="emailpedido" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['emailpedidos'])?>">
								</div>
							</div>
						</div>
							<div class="row">
							
						   <div class="col-md-6" style="display: none;">
								<div class="form-group m-t-20">
									<label>COSTO DE ENV&Iacute;O POR PAQUETER&Iacute;A</label>
									<input name="costoenvio" type="text" id="costoenvio" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['costoenvio'])?>">
								</div>
							</div>
						</div>
							<div class="row">
							
						    <div class="col-md-6" style="display: none;">
								<div class="form-group m-t-20">
									<label>CANTIDAD M&Iacute;NIMA PARA NO PAGAR ENV&Iacute;O</label>
									<input name="cantidadminimo" type="text" id="cantidadminimo" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['montominimo'])?>">
								</div>
							</div>

						</div>

					</div>




					<div class="tab-pane m-t-20" id="messages" role="tabpanel">


						<br><br>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>FACEBOOK</label>
									<input name="facebook" type="text" id="facebook" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['facebook'])?>">
								</div>	
							</div>
						</div>
							<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>TWITTER</label>
									<input name="twitter" type="text" id="twitter" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['twitter'])?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>RSS</label>
									<input name="rss" type="text" id="rss" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['rss'])?>">
								</div>	
							</div>
						</div>

								<div class="row">
							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>DELICIOUS</label>
									<input name="delicious" type="text" id="delicious" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['delicious'])?>">
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>LINKEDIN</label>
									<input name="linkedin" type="text" id="linkedin" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['linkedin']);?>">
								</div>	
							</div>

						</div>
							<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>YOUTUBE</label>
									<input name="flickr" type="text" id="flickr" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['flickr'])?>">
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>SKYPE</label>
									<input name="skype" type="text" id="skype" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['skype']);?>">
								</div>	
							</div>

						</div>

							<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>INSTAGRAM</label>
									<input name="instagram" type="text" id="instagram" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['instagram'])?>">
								</div>
							</div>



						</div>






						<div class="row">

							<div class="col-md-6">
								<div class="form-group m-t-20">
									<label>GOOGLE MAPS</label>
									<textarea name="googlemap" rows="6" class="form-control" id="googlemap"><?php echo $fu->imprimir_cadena_utf8($row_configuracion['googlemap']);?></textarea>

								</div>	
							</div>




						</div>

					</div>

					<div class="tab-pane m-t-20" id="textos" role="tabpanel">
						<br><br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">TEXTO 1</label>
									<input type="text" id="texto1" class="form-control" value="<?php echo $texto1 ?>">
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									
								<div class="form-check " id="">
								   <input type="checkbox" class="form-check-input " id="bloquearediciondedatos" >
								 <label class="form-check-label" for="flexCheckDefault" id="">BLOQUEAR LA EDICIÓN DE DATOS DEL CLIENTE</label>
								</div>

								</div>
							</div>
						</div>

					</div>

					<div class="tab-pane m-t-20" id="pasarelapago" role="tabpanel">
						<br><br>
						<div class="row">

							<div class="col-md-2">
								<div class="form-group">

									<?php if ($row_configuracion['pagollamada']==1) {
										$checke1='checked';
									}else{
										$checke1='';
									} ?>
									<label for="" class="">OTRO M&Eacute;TODO DE PAGO</label>
									<input type="checkbox" id="otro" class="" <?php echo $checke1;?>>
								</div>
							</div>


							<div class="col-md-2">
								<div class="form-group">

									<?php if ($row_configuracion['pagotarjeta']==1) {
										$checke2='checked';
									}else{
										$checke2='';
									} ?>

									<label for="" class="">PAGO CON TARJETA</label>
									<input type="checkbox" id="tarjeta" class="" <?php echo $checke2;?>>
								</div>
							</div>


							<div class="col-md-2">
								<div class="form-group">
									<?php if ($row_configuracion['pagooxxopay']==1) {
										$checke3='checked';
									}else{
										$checke3='';
									} ?>

									<label for="" class="">PAGO OXXO PAY</label>
									<input type="checkbox" id="oxxo" class="" <?php echo $checke3;?>>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<?php if ($row_configuracion['pagospei']==1) {
										$checke4='checked';
									}else{
										$checke4='';
									} ?>

									<label for="" class="">PAGO SPEI</label>
									<input type="checkbox" id="spei" class="" <?php echo $checke4;?>>
								</div>
							</div>
							<div class="col-md-6">
								<label for="">NEGOCIO</label>
								<input type="text" id="negocio" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['nombrenegocio']); ?>">
								
							</div>
							<div class="col-md-6"></div>



							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">LLAVE P&Uacute;BLICA</label>
									<input type="text" id="llavepublica" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['setPublicKey']); ?>">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">LLAVE PRIVADA</label>
									<input type="text" id="llaveprivada" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['setApikey']); ?>">
								</div>
							</div>

								<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">DIAS DE VENCIMIENTO</label>
									<input type="number" id="diasvencimiento" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['dias_vencimiento']); ?>">
								</div>
							</div>


						</div>

					</div>

					<div class="tab-pane" id="correoenvio" role="tabpanel">

						<br>
						<br>
						<div class="row">


							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">HOST</label>
									<input type="text" id="host" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['host']); ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">PUERTO</label>
									<input type="text" id="puerto" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['puertoenvio']); ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">NOMBRE DE USUARIO</label>
									<input type="text" id="usuario" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['nombreusuario']); ?>">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">CONTRASE&Ntilde;A</label>
									<input type="text" id="contrasena" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['contrasena']); ?>">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">REMITENTE</label>
									<input type="text" id="remitente" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['remitente']); ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="">NOMBRE REMITENTE</label>
								<input type="text" id="nombreremitente" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['remitente_nombre']);?>">
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="" class="">SMTP AUTENTICACI&Oacute;N</label>
										<?php if ($row_configuracion['r_autenticacion']=='true') {
										$checke4='checked';
									}else{
										$checke4='';
									} ?>

									<input type="checkbox" id="smtauth" class="form-control"  <?php echo $checke4; ?>>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="" class="">SMTP SEGURIDAD</label>
									

									<input type="text" id="smtpseguridad" class="form-control" value="<?php echo $fu->imprimir_cadena_utf8($row_configuracion['r_ssl']); ?>" >
								</div>
							</div>
							
						</div>
					</div>




				</div>


				<div style="width: 100%;">
					<input name="v_id" type="hidden" value="<?php echo $id; ?>" id="v_id">

					<button type="button" title="GUARDAR" onClick="g_Configuracion();" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>Guardar</button>				
				</div>

			</div>
		</div>
	</form>

	<script>

		var bloquearediciondatoscliente='<?php echo $bloquearediciondatoscliente;?>';


		if (bloquearediciondatoscliente==1) {

			$("#bloquearediciondedatos").attr('checked',true);
		}


	function SubirImagenLogo() {
	 	// body...
	 
        var formData = new FormData();
        var files = $('#v_logo')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: 'catalogos/configuracion/upload.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
              beforeSend: function() {
	      $("#d_foto").css('display','block');
	      $("#d_foto").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	

		    },
        	success: function(response) {
               	var ruta='<?php echo $imagen; ?>';
	
                if (response != 0) {
                    $(".card-img-top").attr("src", response);
                    $("#d_foto").css('display','none');
                } else {

                	 $("#d_foto").html('<img src="'+ruta+'" class="card-img-top" alt="" style="border: 1px #777 solid"/> ');
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    }

		  CKEDITOR.addCss('.cke_editable { font-size: 15px; padding: 2em; }');

    CKEDITOR.replace('descripcion', {
      toolbar: [{
          name: 'document',
          items: ['Print']
        },
        {
          name: 'clipboard',
          items: ['Undo', 'Redo']
        },
        {
          name: 'styles',
          items: ['Format', 'Font', 'FontSize']
        },
        {
          name: 'colors',
          items: ['TextColor', 'BGColor']
        },
        {
          name: 'align',
          items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        },
        '/',
        {
          name: 'basicstyles',
          items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
        },
        {
          name: 'links',
          items: ['Link', 'Unlink']
        },
        {
          name: 'paragraph',
          items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
        },
        {
          name: 'insert',
          items: ['Image', 'Table']
        },
        {
          name: 'tools',
          items: ['Maximize']
        },
        {
          name: 'editing',
          items: ['Scayt']
        }
      ],

      extraAllowedContent: 'h3{clear};h2{line-height};h2 h3{margin-left,margin-top}',

      // Adding drag and drop image upload.
      extraPlugins: 'print,format,font,colorbutton,justify,uploadimage',
     // uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      //filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
      //filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
      filebrowserUploadUrl: 'paginaweb/pagconfig/upload.php',
      filebrowserImageUploadUrl: 'paginaweb/pagconfig/upload.php',

      height: 150,

      removeDialogTabs: 'image:advanced;link:advanced'
    });
	</script>

	<style>
/*QUITAR FLECHAS DE INPUT NUMBER
*/	input[type=number]::-webkit-outer-spin-button,

	input[type=number]::-webkit-inner-spin-button {

	    -webkit-appearance: none;

	    margin: 0;

	}

	 

	input[type=number] {

	    -moz-appearance:textfield;

	}

</style>

	<?php
 }//fin del try
 catch(Exception $e)
 {
 	$v = explode ('|',$e);
		// echo $v[1];
 	$n = explode ("'",$v[1]);
 	$n[0];
 	$result = $db->m_error($n[0]);
 	echo $result ;


 }

 ?>
