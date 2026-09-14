<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}
require_once("../clases/conexcion.php");
require_once("../clases/class.Funciones.php");

try
{
	$db = new MySQL();
	$fu = new Funciones();
	
	$query="SELECT * FROM modulos WHERE estatus=1";
	$resp=$db->consulta($query);
	$row=$db->fetch_assoc($resp);
	$total=$db->num_rows($resp);
	
	$disabled='';
?>


<form id="alta_modulos" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title m-b-0" style="float: left;">NUEVO MENÚ</h5>
			

			<button type="button" onClick="var resp=MM_validateForm('nombre','','R','archivo','','R','ubi','','R','nivel','','RisNum'); if(resp==1){ GuardarEspecial('alta_modulos','administrador/ga_md_modulosMenu.php','administrador/vi_modulos.php','main');}" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>Guardar</button>

			<button type="button" onClick="aparecermodulos('administrador/vi_modulos.php','main');" class="btn btn-primary" style="float: right;">LISTADO DE MÓDULOS</button>
			<div style="clear: both;"></div>
		</div>
		
		<div class="card-body">
			<div class="form-group m-t-20">
<?php
        	if($total==0)
			{
				$disabled='disabled="disabled"';
?>
        		<label>No existen modulos disponibles, por lo que no es posible crear menus</label>
<?php
			}else{
?>
        		<label>Modulo</label>
				<select name="idmodulos" id="idmodulos" class="form-control">
					<?php do{?>
					<option value="<?php echo $row['idmodulos'];?>"><?php echo $fu->imprimir_cadena_utf8($row['modulo']); ?></option>   
					<?php }while($row=$db->fetch_assoc($resp));?>         
				</select>
<?php
			}
?>
			</div>
			

			<div class="form-group m-t-20">
				<label>Nombre del Menu:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" placeholder="Nombre" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Nombre del Archivo:</label>
				<input type="text" name="archivo" id="archivo" class="form-control" title="Archivo" placeholder="Archivo" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Ubicacion del Archivo:</label>
				<input type="text" name="ubi" id="ubi" class="form-control" title="Ubicaci&oacute;n del Archivo" placeholder="Ubicaci&oacute;n de Archivo" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Nivel en el Orden:</label>
				<input type="text" name="nivel" id="nivel" class="form-control" title="Nivel de Orden" placeholder="0" value="0" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				</select>
			</div>
		</div>
		
		<div class="card-footer">
			<input type="hidden" name="tipo" id="tipo" value="3" />
			
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