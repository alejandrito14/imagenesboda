<?php
header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Sucursales.php");

try
{
	$db= new MySQL();
	$su = new Sucursales();
	
	$su->db = $db;
	
	if(!isset($_GET['id'])){
		$id = 0;
	}else{
		$id = $_GET['id'];
		
		$su->idsucursales = $id;
		
		//Buscamos sucursal
		$result_sucursal = $su->buscarSucursal();
		$result_sucursal_row = $db->fetch_assoc($result_sucursal);
		
		$nombre = $result_sucursal_row['sucursal'];
		$direccion = $result_sucursal_row['direccion'];
		$tel = $result_sucursal_row['tel'];
		$email = $result_sucursal_row['email'];
		$tipo = $result_sucursal_row['tipo'];
		$notas_print = $result_sucursal_row['notas_print'];
	}
	
	
?>
<form id="alta_sucursales" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title m-b-0">ALTA DE SUCURSALES</h5>

			<div style="padding: 20px;">
				<button type="button" onClick="aparecermodulos('administrador/vi_sucursales.php','main');" class="btn btn-primary" style="float: right;">Ver Sucursales</button>
				<div style="clear: both;"></div>
			</div>

			<div class="form-group m-t-20">
				<label>Nombre de la Sucursal:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Direcci&oacute;n:</label>
				<textarea type="text"  name="direccion" id="direccion" class="form-control" title="Direcci&oacute;n" placeholder="Direcci&oacute;n"><?php echo $direccion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Tel&eacute;fono:</label>
				<input type="text" name="tel" id="tel" class="form-control" title="Tel&eacute;fono" placeholder="Tel&eacute;fono" value="<?php echo $tel; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Email:</label>
				<input type="email" name="Email" id="email" class="form-control" title="Email" placeholder="Email" value="<?php echo $email; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Tipo de impresi&oacute;n:</label>
				<select id="notas_print" name="notas_print" class="form-control">
					<option value="0" <?php if($notas_print == 0){ echo "selected";} ?>>Carta</option>
					<option value="1" <?php if($notas_print == 1){ echo "selected";} ?>>T&eacute;rmica 80mm</option>
					<!--<option value="2" <?php if($notas_print == 2){ echo "selected";} ?>>T&eacute;rmica 57mm</option>-->
				</select>
			</div>            
            
		</div>
	</div>
	
	<div class="card">
		<div class="card-body">			
			<input type="hidden" name="tipo" id="tipo" value="1" />
			<input type="hidden" id="v_id" value="<?php echo $id; ?>" />
			<button type="button" onClick="var resp=MM_validateForm('nombre','','R','direccion','','R','tel','','R isNum','email','','R isEmail'); if(resp==1){ g_sucursal('administrador/vi_sucursales.php','main');}" class="btn btn-primary alt_btn" style="float: right;" <?php echo $disabled; ?>>Guardar</button>
		</div>
	</div>
</form>

<?php
}
catch(Exception $e)
{
	echo $e;
}
?>