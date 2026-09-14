<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../login.php");
	echo "login";
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Pais.php");



$db = new MySQL();
$bt = new Botones_permisos(); 
$fu = new Funciones();
$cli = new Clientes();
$pais = new Paises();



$su->db = $db;
$cli->db = $db;
$pais->db=$db;

$idmenumodulo = $_GET['idmenumodulo'];



$resul_paises=$pais->ObtenerPaices();
$result_paises_row=$db->fetch_assoc($resul_paises);
$result_paises_num=$db->num_rows($resul_paises);

$resul_paises1=$pais->ObtenerPaices();
$result_paises_row1=$db->fetch_assoc($resul_paises1);




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
//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



if(!isset($_GET['idcliente']))
{
	$idcliente = 0;
	$$v_idempresa = "";
	
	$v_sexo = "H" ;
	$v_no_cliente = "";
	$v_f_nacimiento = "";
	$v_no_tarjeta ="" ;
	$v_nombre = "";
	$v_paterno = "";
	$v_materno = "";
	$v_direccion = "";
	$v_telefono ="" ;
	$v_fax = "" ;
	$v_fis_razonsocial ="" ;
	$v_fis_rfc = "";
	$v_fis_direccion = "";
	$v_fis_no_int = "";
	$v_fis_no_ext = "";
	$v_fis_col = "";
	$v_fis_ciudad = "";
	$v_fis_estado = "";
	$v_fis_cp = "";
	$v_usuario = "";
	$v_email = "";
	$v_clave = "";
	$v_estatus = "1";
	$v_direccion_envio = "";
	$v_cp = "" ;
	$disabled="disabled";
	$idpais=0;
	$idmunicipio=0;
	$v_referencia='';
	$v_fis_correo="";
	$v_celular="";
	$titulo='NUEVO CLIENTE';
	$bloquearediciondedatos=0;
}else
{
	
	$idcliente = $_GET['idcliente'];
	
	//buscamos la información del cliente..
	
	$cli->idCliente = $idcliente;
	$cliente = $cli->ObtenerInformacionCliente();

	$cliente_row = $db->fetch_assoc($cliente);
	$cliente_num = $db->num_rows($cliente);
	
	//echo "Entro por que tiene un id de lciente.";
	
	$v_idempresa = $fu->imprimir_cadena_utf8($cliente_row['idempresas']);
	$v_no_cliente = $fu->imprimir_cadena_utf8($cliente_row['no_cliente']);
	$v_sexo = $fu->imprimir_cadena_utf8($cliente_row['sexo']);
	$v_f_nacimiento = $fu->imprimir_cadena_utf8($cliente_row['f_nacimiento']);
	$v_no_tarjeta =$fu->imprimir_cadena_utf8($cliente_row['no_tarjeta']);
	$v_nombre = $fu->imprimir_cadena_utf8($cliente_row['nombre']);
	$v_paterno =$fu->imprimir_cadena_utf8($cliente_row['paterno']);
	$v_materno = $fu->imprimir_cadena_utf8($cliente_row['materno']);
	$v_direccion = $fu->imprimir_cadena_utf8($cliente_row['direccion']);
	$v_telefono =$fu->imprimir_cadena_utf8($cliente_row['telefono']);

	$v_celular=$fu->imprimir_cadena_utf8($cliente_row['celular']);
	$v_edad=$fu->imprimir_cadena_utf8($cliente_row['edad']);
	$opcionespago='';
	if ($cliente_row['opcionespagobloqueadas']!='') {
		$opcionespago=$cliente_row['opcionespagobloqueadas'];

	}

	$validartelefono=$fu->imprimir_cadena_utf8($cliente_row['validartelefono']);
	$bloquearediciondedatos=$cliente_row['bloquearediciondatos'];

	$fotoine=$fu->imprimir_cadena_utf8($cliente_row['ine']);
	$fotoperfil=$fu->imprimir_cadena_utf8($cliente_row['foto']);
	$v_fax =$fu->imprimir_cadena_utf8($cliente_row['fax']);
	$v_fis_razonsocial =$fu->imprimir_cadena_utf8($cliente_row['fis_razonsocial']);
	$v_fis_rfc = $fu->imprimir_cadena_utf8($cliente_row['fis_rfc']);
	$v_fis_direccion = $fu->imprimir_cadena_utf8($cliente_row['fis_direccion']);
	$v_fis_no_int = $fu->imprimir_cadena_utf8($cliente_row['fis_no_int']);
	$v_fis_no_ext = $fu->imprimir_cadena_utf8($cliente_row['fis_no_ext']);
	$v_fis_col =$fu->imprimir_cadena_utf8($cliente_row['fis_col']);
	$v_fis_estado = $fu->imprimir_cadena_utf8($cliente_row['fis_estado']);
	$v_fis_cp = $fu->imprimir_cadena_utf8($cliente_row['fis_cp']);
	$v_usuario = $fu->imprimir_cadena_utf8($cliente_row['usuario']);
	$v_email = $fu->imprimir_cadena_utf8($cliente_row['email']);
	$v_clave = $fu->imprimir_cadena_utf8($cliente_row['clave']);
	$v_estatus = $fu->imprimir_cadena_utf8($cliente_row['estatus']);
	$v_direccion_envio = $fu->imprimir_cadena_utf8($cliente_row['direccion_envio']);
	$v_cp = $fu->imprimir_cadena_utf8($cliente_row['cp']);

	$colonia = $fu->imprimir_cadena_utf8($cliente_row['colonia']);
	$no_ext = $fu->imprimir_cadena_utf8($cliente_row['no_ext']);
	$no_int = $fu->imprimir_cadena_utf8($cliente_row['no_int']);
	$folioadmin = $fu->imprimir_cadena_utf8($cliente_row['folio_adminpack']);
	$v_referencia=$fu->imprimir_cadena_utf8($cliente_row['referencia']);
	$v_fis_correo=$fu->imprimir_cadena_utf8($cliente_row['correofiscal']);


	$v_fis_ciudad = $fu->imprimir_cadena_utf8($cliente_row['fis_ciudad']);
	$v_ciudad= $fu->imprimir_cadena_utf8($cliente_row['idlocalidad']);
	$v_municipio= $fu->imprimir_cadena_utf8($cliente_row['municipios']);
	$v_estado= $fu->imprimir_cadena_utf8($cliente_row['estados']);
	$idpais=$fu->imprimir_cadena_utf8($cliente_row['pais']);

	$habilitarobservacion=$fu->imprimir_cadena_utf8($cliente_row['activarobservacion']);


	$v_fis_municipio=$fu->imprimir_cadena_utf8($cliente_row['fis_municipio']);

	if ($v_fis_estado=="" || $v_fis_estado=='t' ) {
		$v_fis_estado=0;
	}
	if ($v_fis_ciudad=="" || $v_fis_estado=='t') {
		$v_fis_ciudad=0;
	}
	if ($v_fis_municipio=="" || $v_fis_estado=='t') {
		$v_fis_municipio=0;
	}

	if ($idpais=="" || $idpais=='t' ) {
		$idpais=1;
	}


	if ($v_estado=="" || $v_estado=='t' ) {
		$v_estado=0;
	}
	if ($v_ciudad=="" || $v_ciudad=='t') {
		$v_ciudad=0;
	}
	if ($v_municipio=="" || $v_municipio=='t') {
		$v_municipio=0;
	}

	if ($v_telefono=='0') {
		$v_telefono='';
	}
	$habilitar='';
	if ($v_no_cliente>0) {
		$habilitar='disabled';
	}

	$checkedhabilitar="";
	if ($habilitarobservacion==1) {
		$checkedhabilitar="checked";

	}
	$titulo='EDITAR CLIENTE';


	

	if($fotoine==""){
		$rutaine="images/sinfoto.png";
	}
	else{
		//$rutaine="catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio']."/$foto";

		$rutaine="app/".$_SESSION['carpetaapp']."/php/upload/ine/$fotoine";
	}


	if($fotoperfil==""){
		$rutaperfil="images/sinfoto.png";
	}
	else{
		//$rutaine="catalogos/paquetes/imagenespaquete/".$_SESSION['codservicio']."/$foto";

		$rutaperfil="app/".$_SESSION['carpetaapp']."/php/upload/perfil/$fotoperfil";
	}

}



//echo "ID CLIENTE ES: " . $idcliente;

$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion


$su->tipo_usuario= $tipousaurio;
$su->lista_empresas = $lista_empresas;

//obtenedremos todas las sucursales de las empresas a las que puedes visualizar.




?>

<script type="text/javascript">
	//$('#titulo-modal-forms').html("ALTA A CLIENTE");
</script>


<form name="form_cliente" id="form_cliente">
	<input id="v_idcliente" name="v_idcliente" type="hidden" value="<?php echo $idcliente; ?>">

	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>

			<div style="float: right;" >
					
			
					<div style="clear: both;"></div>

				


				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = "					
				var resp=MM_validateForm('v_nombre','','R','v_paterno','','R');
					 if(resp==1){ GuardarCliente('form_cliente','catalogos/clientes/vi_clientes.php','main',$idmenumodulo)}";

					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->tipo = 1;
					$bt->class='btn btn-success';
					//validamos que permiso aplicar si el de alta o el de modificacion
					/*if($idcliente == 0)
					{
						
					}else{
						$bt->tipo = 2;
					}*/
			
					$bt->armar_boton();
				?>
				<button type="button" onClick="aparecermodulos('catalogos/clientes/vi_clientes.php?idmenumodulo=<?php echo $idmenumodulo;?>','main');" class="btn btn-primary" title="LISTADO DE JUGADORES" style="margin-right: 10px;float: right;"><i class="mdi mdi-arrow-left-box"></i>LISTADO DE CLIENTES</button>
				
				<input type="hidden" id="v_idcliente" name="v_idcliente" value="<?php echo $idcliente; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>



	<div class="card">
		<div class="card-body" style="padding: 15px">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">DATOS GENERALES</span></a> </li>
				
				<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">DATOS DE ACCESO</span></a> </li>
				<li style="display: none;" class="nav-item"> <a class="nav-link" data-toggle="tab" href="#envio" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Direcci&oacute;n de env&iacute;o</span></a> </li>

				<li style="" class="nav-item" id="opcionesavanzadas"> <a class="nav-link" data-toggle="tab" href="#avanzado" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">OPCIONES AVANZADAS</span></a> </li>

			</ul>
			<!-- Tab panes -->

			<div class="tab-content tabcontent-border" style=" padding-top: 15px;">

				<div class="tab-pane active p-20" id="home" role="tabpanel">
					<div class="row">
				<!-- 	<div class="form-group col-md-4">
						<label>NO. DEL CLIENTE:</label>
							<input type="hidden" name="VALIDACION" id="VALIDACION" value="<?php echo ($validacion);?>"  ></input>
						<input type="text" onblur="validarCliente(this.value,'alt_btn')" onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); verificar(event);" name="v_no_cliente" id="v_no_cliente" class="form-control" title="No. del Cliente" value="<?php echo ($v_no_cliente); ?>" placeholder="CODIGO"  readonly></input><span style="margin-left:2%" id="error" ></span>
					</div> -->

					<!-- <div class="form-group col-md-4">
						<label for="">FOLIO INTERNO</label>
						<input class="form-control" type="text" id="foliopack" name="foliopack" value="<?php echo $folioadmin; ?>">
					</div> -->
					</div>
				
				<div class="row">

					<div class="form-group col-md-4">
						<label>NOMBRE:</label>
						<input name="v_nombre" id="v_nombre" title="NOMBRE" type="text" class="form-control" placeholder="NOMBRE"  required value="<?php echo $v_nombre; ?>">
					</div>
					
					<div class="form-group col-md-4">
						<label>PATERNO:</label>
						<input name="v_paterno" id="v_paterno" title="APELLIDO PATERNO" type="text" class="form-control" placeholder="APELLIDO PATERNO"  required value="<?php echo $v_paterno; ?>" >
					</div>
					
					<div class="form-group col-md-4">
						<label>MATERNO:</label>
						<input name="v_materno" id="v_materno" title="APELLIDO MATERNO" type="text" class="form-control" placeholder="APELLIDO MATERNO"  required value="<?php echo $v_materno; ?>" >
					</div>	

						<div class=" form-group  col-md-4">
							
								<label>GÉNERO:</label>
								<select name="v_sexo" id="v_sexo" title="sexo" class="form-control">
									<option value="H" <?php if("H" == $v_sexo ){ echo "selected"; } ?>>HOMBRE</option>
									<option value="M" <?php if("M" == $v_sexo ){ echo "selected"; } ?>>MUJER</option>
								</select>
							</div>	

					<div class="col-md-4">
						<label>EDAD:</label>
					  <input name="v_edad" id="v_edad" title="EDAD" type="text" class="form-control" placeholder="EDAD" required="" value="<?php echo $v_edad;?>">
					</div>

					
						
						<div class="col-md-4 form-group " style="display: none;">
							
								<label>FECHA DE NACIMIENTO:</label>
								<div class="input-group">
									<input type="text" class="form-control" name="v_f_nacimiento" id="v_f_nacimiento" placeholder="yyyy-mm-dd" value="<?PHP echo $v_f_nacimiento; ?>" >
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>


				</div>
					<div class="row">
				
					<!---AGREGUE PAIS,ESTADO,MUNICIPIO,LOCALIDAD--->
			
			   
					<!-- <div class="form-group col-md-4">
						<label>PAIS:</label>


						<select name="v_pais" id="v_pais" class="form-control" onchange="ObtenerEstadosCatalogo2(0,$(this).val(),'v_estado,v_fis_estado')">
							  <option value="0">SELECCIONAR PAIS</option>
							   <?php
							  do
							  {
							?>
								<option  value="<?php echo $result_paises_row['idpais'] ?>"  <?php if($result_paises_row['idpais'] == $idpais){ echo "selected"; }?>><?php echo strtoupper($fu->imprimir_cadena_utf8($result_paises_row['pais']));?></option>
							<?php
							   }while($result_paises_row = $db->fetch_assoc($resul_paises));
						   ?>
						</select>
						
					</div> -->

					<!-- <div class="form-group col-md-4">
						<label>ESTADO:</label>
						

						<select onchange="ObtenerMunicipios(0);" name="v_estado" id="v_estado" class="form-control" >
							<option value="0">SELECCIONAR ESTADO</option>
						</select>
					</div> -->
				   
				  <!--  <div class="form-group col-md-4">
						<label>MUNICIPIO:</label>
						

						<select  name="v_municipio" id="v_municipio" class="form-control" >
						<option value="0">SELECCIONAR MUNICIPIO</option>

						</select>
					</div> -->

					
				  
				   <!--  <div class="form-group col-md-4">
						<label>LOCALIDAD:</label>
					
						<input type='text' name="v_ciudad" id="v_ciudad" value="<?php echo $v_ciudad; ?>" class="form-control" placeholder='LOCALIDAD'>
						
					</div>  -->

					<!-- <div class="form-group col-md-4">
						<label>CP:</label>
						<input name="v_cp" id="v_cp" title="CP" type="text" value="<?php echo $v_cp; ?>" class="form-control" placeholder="CP"  required>
					</div> -->

					<!-- <div class="form-group col-md-4">
						<label>AVENIDA/BLVD/CALLE:</label>
						<textarea name="v_direccion" rows="2" required id="v_direccion" class="form-control" placeholder="AVENIDA/BLVD/CALLE" title="AVENIDA/BLVD/CALLE"><?php echo $v_direccion; ?></textarea>
					</div>
 -->
						
					
<!-- 
					<div class="col-md-4">
						<label>NO. INT:</label>
					  <input name="v_no_int" id="v_no_int" title="NO.INT" type="text" class="form-control" placeholder="NO.INT" required="" value="<?php echo $no_int;?>">
					</div>
					<div class="col-md-4">
						<label>NO. EXT:</label>
					  <input name="no_ext" id="no_ext" title="NO.EXT" type="text" class="form-control" placeholder="NO.EXT" required="" value="<?php echo $no_ext;?>">
					</div> -->
<!-- 
					<div class="col-md-4">
						<label>COLONIA:</label>
						<input name="v_colonia" id="v_colonia" title="COLONIA" type="text" class="form-control" placeholder="COLONIA" required="" value="<?php echo $colonia; ?>">
					</div> -->

			<!-- 		</div>
				<div class="row" style="    margin-top: 1em;">
					<div class="form-group col-md-4">
						<label>REFERENCIA:</label>
						<textarea name="v_referencia" id="v_referencia" title="REFERENCIA" type="text" class="form-control" placeholder="REFERENCIA"><?php echo $v_referencia; ?></textarea>
					</div> -->
					<div class="form-group col-md-4">
						<label>CELULAR:</label>
						<input name="v_celular" id="v_celular" title="CELULAR" type="text" class="form-control" placeholder="CELULAR" value="<?php echo $v_celular; ?>" >
					</div>
					<div class="form-group col-md-4">
						<label>TEL&Eacute;FONO:</label>
						<input name="v_telefono" id="v_telefono" title="TELÉFONO" type="text" class="form-control" placeholder="TELÉFONO"  required value="<?php echo $v_telefono; ?>">
					</div>


					

				
							
					

				</div>

					<!---AGREGUE PAIS,ESTADO,MUNICIPIO,LOCALIDAD--->

					

				
						
					
					
					<div class="row">
					<div class="form-group col-md-4">
						<label>HABILITAR OBSERVACIONES:</label>
						<input type="checkbox" name="habilitarobservaciones" id="habilitarobservaciones" value="<?php echo $habilitarobservacion ?>" onchange="HabilitarObservaciones()" <?php echo $checkedhabilitar; ?>>
					</div>
				
					</div>

					<div class="row">
					
					<div class="col-md-4">
						<label>FOTO DE PERFIL:</label>
					 	<div>

					 		<form method="post" action="#" enctype="multipart/form-data">
								    <div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
								        <img class="card-img-top" src="">
								        <div id="d_foto" style="text-align:center; ">
											<img src="<?php echo $rutaperfil; ?>" class="card-img-top " alt="" style="border: 1px #777 solid;    border-radius: 20px; "> 
										</div>
								        <div class="card-body">
								            <h5 class="card-title"></h5>
								           
								            <div class="form-group">

								               <!--  <input type="file" class="form-control-file" name="image" id="image" onchange="SubirImagen()"> -->
								            </div>
								         
								        </div>
								    </div>
								</form>
					 		
					 	</div>
					</div>

					<div class="col-md-4">
						<label>INE:</label>
					 	<div>

					 		<form method="post" action="#" enctype="multipart/form-data">
								    <div class="card" style="width: 18rem;margin: auto;margin-top: 3em;">
								        <img class="card-img-top" src="">
								        <div id="d_foto" style="text-align:center; ">
											<img src="<?php echo $rutaine; ?>" class="card-img-top"  alt="" style="border: 1px #777 solid;    border-radius: 20px; "/> 
										</div>
								        <div class="card-body">
								            <h5 class="card-title"></h5>
								           
								            <div class="form-group">

								               <!--  <input type="file" class="form-control-file" name="image" id="image" onchange="SubirImagen()"> -->
								            </div>
								          <!--   <input type="button" class="btn btn-primary upload" value="Subir"> -->
								        </div>
								    </div>
								</form>
					 		
					 	</div>
					</div>

			

					
						
				
				</div>


					<div class="form-group m-t-20" style="display: none;">
						<label>NO. DE TARJETA:</label>
						<input name="v_no_tarjeta" id="v_no_tarjeta" title="Tu Nombre" type="text" class="form-control" placeholder="No. de tarjeta"  required value="<?php echo $v_no_tarjeta; ?>">
					</div>	
					
					
					</div>
				


				
					
					
			


				<div class="tab-pane  p-20" id="profile" role="tabpanel">
						<div class="row">
					<div class="form-group col-md-4">
						<label>RAZÓN SOCIAL:</label>
						<input name="v_fis_razonsocial" id="v_fis_razonsocial" title="RAZÓN SOCIAL" type="text" class="form-control" placeholder="RAZÓN SOCIAL"  required value="<?php echo $v_fis_razonsocial; ?>" >
					</div>

					<div class="form-group col-md-4">
						<label>RFC:</label>
						<input name="v_fis_rfc" id="v_fis_rfc" title="RFC" type="text" class="form-control" placeholder="RFC"  required value="<?php echo $v_fis_rfc; ?>" >
					</div>

					<div class="form-group col-md-4">
						<label>CORREO FISCAL:</label>
						<input name="v_fis_correo" id="v_fis_correo" title="CORREO FISCAL" type="text" class="form-control" placeholder="CORREO FISCAL"  required value="<?php echo $v_fis_correo; ?>" >
					</div>

				</div>

					<div class="row">
					<!-- 	
						<div class="form-group col-md-4">
						<label>PAIS:</label>


						<select name="v_pais1" id="v_pais1" class="form-control" onchange="ObtenerEstadosCatalogo2(0,$(this).val(),'v_estado,v_fis_estado')">
							  <option value="0">SELECCIONAR PAIS</option>
							   <?php
							  do
							  {
							?>
								<option  value="<?php echo $result_paises_row['idpais'] ?>"  <?php if($result_paises_row1['idpais'] == $idpais){ echo "selected"; }?>><?php echo strtoupper($fu->imprimir_cadena_utf8($result_paises_row1['pais']));?></option>
							<?php
							   }while($result_paises_row1 = $db->fetch_assoc($resul_paises1));
						   ?>
						</select>
						
					</div> -->

					
				


				<!-- 	<div class="form-group col-md-4">
						<label>ESTADO:</label>
						
						<select name="v_fis_estado" id="v_fis_estado" class="form-control" style="width: 100%;" onchange="ObtenerMunicipiosCatalogo(0,$(this).val(),'v_fis_municipio');"></select>
							

					</div>	 -->
					
					

					<!-- <div class="form-group col-md-4">
						<label>MUNICIPIO:</label>	
						<select name="v_fis_municipio" id="v_fis_municipio" class="form-control" ></select>
					</div>
					
					
					<div class="form-group col-md-4 ">
						<label>LOCALIDAD:</label>
					
						<input type="text" name="v_fis_ciudad" id="v_fis_ciudad" class="form-control" placeholder="LOCALIDAD" value="<?php echo $v_fis_ciudad;?>">
					</div>

					<div class="form-group col-md-4">
						<label>CP:</label>
						<input name="v_fis_cp" id="v_fis_cp" title="CP" type="text" class="form-control" placeholder="CP"  required value="<?php echo $v_fis_cp; ?>">
					</div>


					<div class="col-md-4">
						<div class="form-group ">
						<label>CALLE/AV/BLVD:</label>
						<textarea name="v_fis_direccion" required id="v_fis_direccion" class="form-control" placeholder="DIRECCION" title="DIRECCION"><?php echo $v_fis_direccion; ?></textarea>
					</div>
					</div>

						<div class="col-md-4">
							<div class="form-group ">
								<label>NO.INT:</label>
								<input name="v_fis_no_int" id="v_fis_no_int" title="NO.INT" type="text" class="form-control" placeholder="NO.INT"  required value="<?php echo $v_fis_no_int; ?>">
							</div>	
						</div>

						<div class="col-md-4">
							<div class="form-group ">
								<label>NO. EXT:</label>
								<input name="v_fis_no_ext" id="v_fis_no_ext" title="NO.EXT. Fiscal" type="text" class="form-control" placeholder="NO.EXT"  required value="<?php echo $v_fis_no_ext; ?>" >
							</div>
						</div> -->


<!-- 
						<div class=" col-md-4">
						<div class="form-group ">
						<label>COLONIA:</label>
						<input name="v_fis_col" id="v_fis_col" title="COLONIA" type="text" class="form-control" placeholder="COLONIA"  required value="<?php echo $v_fis_col; ?>" >
					</div>
					</div> -->

					
					</div>

					

				

					

						


					</div>
				
				

				

				

				<div class="tab-pane p-20" id="messages" role="tabpanel">

					<div class="col-md-6">
					<div class="form-group m-t-20" >
						<label>USUARIO:</label>
						<input name="v_usuario" onBlur="validarUsuarioCliente();" id="v_usuario" title="Usuario" type="text" class="form-control" placeholder="Chiapas"  required value="<?php echo $v_usuario; ?>" >
					</div>
					
					
					
					<div class="form-group m-t-20">
						<label>CONTRASE&Ntilde;A:</label>
						<input name="v_clave" type="password"  id="v_clave" placeholder="CONTRASEÑA" title="CONTRASEÑA" class="form-control" value="<?php echo $v_clave; ?>">
					</div>
					
					<div class="form-group m-t-20">
						<label>ESTATUS:</label>
						<select name="v_estatus" id="v_estatus" title="Estatus" class="form-control"  >
							<option value="0" <?php if($v_estatus == 0) { echo "selected"; } ?> >NO ACTIVO</option>
							<option value="1" <?php if($v_estatus == 1) { echo "selected"; } ?> >ACTIVO</option>
						</select>
					</div>
					</div>
				</div>
				
				
				<div class="tab-pane p-20" id="envio" role="tabpanel">
					
					
					
					
					
					<div class="form-group m-t-20">
						<label>DIRECCI&Oacute;N DE ENV&Iacute;O:</label>
						<textarea name="v_direccion_envio" rows="5" required id="v_direccion_envio" class="form-control" placeholder="Ingresa tu Direccion" title="Dirección"><?php echo $v_direccion_envio; ?></textarea>
					</div>
					
					
					
				</div>

				<div style="" class="tab-pane  p-20" id="avanzado" role="tabpanel">
						<div class="form-group m-t-20">
							<label>OCULTAR OPCIONES DE TIPO DE  PAGO</label>
							<div id="opcionestipopago" class="col-md-4"></div>
						</div>
			

			
						<div class="form-group m-t-20">
							<label>SOLICITAR VALIDACIÓN DE TELÉFONO</label>
							<div class="col-md-4">
								<div class="form-check " id="">
								   <input type="checkbox" class="form-check-input " id="validaciontelefono">
								 <label class="form-check-label" for="flexCheckDefault" id="">Validación de teléfono</label>
								</div>
							</div>
						</div>

						<div class="form-group m-t-20">
							<label>BLOQUEAR EDICIÓN DE DATOS EN LA APPLICACIÓN</label>
							<div class="col-md-4">
								<div class="form-check " id="">
								   <input type="checkbox" class="form-check-input " id="bloquearediciondedatos">
								 <label class="form-check-label" for="flexCheckDefault" id="">BLOQUEAR</label>
								</div>
							</div>
						</div>
			
				</div>



			</div>


			<div style="width: 100%;">
				
				
				
				
				
<!--				<button type="button" onClick=""var resp=MM_validateForm('v_nombre','','R','v_paterno','','R','v_materno','','R','v_cp','','isNum','v_fis_cp','','isNum'); if(resp==1){ GuardarCliente('form_cliente','catalogos/clientes/vi_clientes.php','main',$idmenumodulo)}}" class="btn btn-success alt_btn3" style="float: right; margin-top: 10px;" <?php echo $disabled; ?> >GUARDAR</button>				
-->			</div>

		</div>
	</div>
</form>


<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script  type="text/javascript" src="./js/mayusculas.js"></script>

<script>
 phoneFormatter2('v_telefono');
 phoneFormatter2('v_celular');

 var bloquearediciondedatos='<?php echo $bloquearediciondedatos?>';

 validarbloquearediciondatos(bloquearediciondedatos);

</script>



<?php if($_GET['idcliente']>0){ ?>

	<script type="text/javascript">
		var opcionestipopago='<?php echo $opcionespago; ?>';
		var opcionespago="";
		if (opcionestipopago!='') {
		 opcionespago=JSON.stringify(<?php echo $opcionespago; ?>);

		}

		var validartelefono='<?php echo $validartelefono; ?>';

		ObtenerEstados(<?php echo $v_estado; ?>);
		ObtenerMunicipiosP(<?php echo $v_estado; ?>,<?php echo $v_municipio; ?>);
	//	ObtenerLocalidades2(<?php echo $v_municipio; ?>,<?php echo $v_ciudad; ?>);

	ObtenerEstadosCatalogo(<?php echo $v_fis_estado;?>,<?php echo $idpais;?>,'v_fis_estado');

 	ObtenerMunicipiosCatalogo(<?php echo $v_fis_municipio;?>,<?php echo $v_fis_estado;?>,'v_fis_municipio');
 //	ObtenerLocalidadesCatalogo(<?php echo $v_fis_ciudad;?>,<?php echo $v_fis_municipio;?>,'v_fis_ciudad');
 	
 	if (opcionespago=='') {
 		opcionespago=0;
 	}
 	OpcionesPago(opcionespago);

 	validartelefonocheck(validartelefono);

	</script>


<?php 	}else{ ?>
	<script type="text/javascript">

	 ObtenerEstados(0);
	 $("#avanzado").css('display','none');
	 $("#opcionesavanzadas").css('display','none');
</script>


<?php } ?>


<script>
$("#v_estatus").chosen({width:"100%"});

	$("#v_pais").chosen({width:"100%"});
	$("#v_pais1").chosen({width:"100%"});


	jQuery('#v_f_nacimiento').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });


</script>