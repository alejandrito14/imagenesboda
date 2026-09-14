<?php
// header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Usuarios.php");
require_once("../clases/class.Sucursales.php");
require_once("../clases/class.Funciones.php");

	$db= new MySQL();
	$us= new Usuarios();
	$us->db=$db;
	$su = new Sucursales();
	$fu=new Funcion();

	$su->db = $db;	
	
	$queryPerfil="SELECT idperfiles, perfil FROM perfiles WHERE estatus=1";
	$resp= $db->consulta($queryPerfil);
	$rows= $db->fetch_assoc($resp);
	$total=$db->num_rows($resp);
	
	$us->id_usuario=$_GET['id'];	
	$datos = $us->ObtenerDatosUsuario();
	
	$result_sucursales = $su->todasSucursales();
	$result_sucursales_row = $db->fetch_assoc($result_sucursales);
	
?>

<form id="modi_usuario" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title m-b-0">MODIFICAR USUARIO</h5>

			<div style="padding: 20px;">
				<button type="button" onClick="aparecermodulos('administrador/vi_usuarios.php','main');" class="btn btn-primary" style="float: right;">Ver Usuario</button>
				<div style="clear: both;"></div>
			</div>

			<div class="form-group m-t-20">
				<label>Perfil:</label>
				<select id="idperfiles" name="idperfiles" class="form-control">
					<?php do{?>
					<option value="<?php echo $rows['idperfiles'];?>" <?php if($datos['idperfiles']==$rows['idperfiles']){echo 'selected="selected"';}?> ><?php echo htmlentities($rows['perfil'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></option>
					<?php }while($rows= $db->fetch_assoc($resp));?>
				</select>
			</div>

			<div class="form-group m-t-20">
				<label>Nombre :</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" placeholder="Nombre" value="<?php echo $datos['nombre'];?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Apellido Paterno:</label>
				<input type="text" name="paterno" id="paterno" class="form-control" title="Apellido Paterno" placeholder="Apellido Paterno" value="<?php echo $datos['paterno'];?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Apellido Materno:</label>
				<input type="text" name="materno" id="materno" class="form-control" title="Apellido Materno" placeholder="Apellido Materno" value="<?php echo $datos['materno'];?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Celular:</label>
				 <input type="text" name="celular" id="celular" class="form-control" title="Celular" placeholder="Celular" value="<?php echo $datos['celular'];?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Tel&eacute;fono:</label>
				<input type="text" name="telefono" id="telefono" class="form-control" title="Tel&eacute;fono" placeholder="Tel&eacute;fono" value="<?php echo $datos['telefono'];?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Email:</label>
				<input type="text" name="email" id="email" class="form-control" title="Email" placeholder="Email" value="<?php echo $datos['email'];?>" />
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Usuario:</label>
				<input type="text" name="usuario" id="usuario" class="form-control" title="Usuario" placeholder="Usuario" value="<?php echo $datos['email'];?>" readonly />
				<span style="float:left; font-size: 10px;" id="msj_error">&nbsp;</span>
				<div id="mensajes" class="width_3_quarter"></div>
            	<input type="hidden" name="user_valid" id="user_valid" value="no"  title="Usuario Válido"/>
				<input type="hidden" id="tipo" name="tipo" value="<?php echo $datos['tipo']; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Clave:</label>
				<input type="password" name="clave" id="clave" class="form-control" title="Clave" placeholder="Clave" value="<?php echo $datos['clave'];?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Sucursal:</label>
				<select id="sucursal" name="sucursal" class="form-control">
            	<?php
				do
				{ 
				?>
            		<option value="<?php echo $result_sucursales_row['idsucursales']; ?>" <?php if($result_sucursales_row['idsucursales'] == $datos['idsucursales']){ echo "selected"; } ?> ><?php echo $fu->imprimir_cadena_utf8($result_sucursales_row['sucursal']); ?></option>
                <?php
				}while($result_sucursales_row = $db->fetch_assoc($result_sucursales));
				?>
            	</select>
			</div>
			
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1" <?php if($datos['estatus']==1){echo 'selected="selected"';}?>>Activo</option>
					<option value="0" <?php if($datos['estatus']==0){echo 'selected="selected"';}?>>Cancelado</option>
				</select>
			</div>
			
			
			
			
		</div>
	</div>
	
	<div class="card">
		<div class="card-body">
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET['id'];?>" />
			<button type="button" onClick="var resp=MM_validateForm('nombre','','R','paterno','','R','materno','','R','email','','RisEmail','usuario','','R','clave','','R'); if(resp==1){GuardarEspecial('modi_usuario','administrador/md_usuarios.php','administrador/vi_usuarios.php','main')}" class="btn btn-primary" style="float: right;">Guardar</button>
		</div>
	</div>
</form>