<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once('../clases/class.Funciones.php');

$fu = new Funciones();

?>


<form id="alta_modulos" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title m-b-0" style="float: left;">NUEVO MÓDULO</h5>
			

			<button type="button" onClick="var resp=MM_validateForm('nombre','','R'); if(resp==1){ GuardarEspecial('alta_modulos','administrador/ga_md_modulosMenu.php','administrador/vi_modulos.php','main');}" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>Guardar</button>

			<button type="button" onClick="aparecermodulos('administrador/vi_modulos.php','main');" class="btn btn-primary" style="float: right;margin-right: 5px;">LISTADO DE MÓDULOS</button>
			<div style="clear: both;"></div>
		</div>
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>*NOMBRE DEL M&Oacute;DULO:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" placeholder="NOMBRE DEL M&Oacute;DULO " />
			</div>
			
			<div class="form-group m-t-20">
				<label>NIVEL DE ORDEN:</label>
				<input type="number" name="nivel" id="nivel" class="form-control" title="NIVEL DE ORDEN" placeholder="0" />
			</div>
			
			<div class="form-group m-t-20">
				<label>ESTATUS:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1">ACTIVADO</option>
					<option value="0">DESACTIVADO</option>
				</select>
			</div>
		</div>
		
		<div class="card-footer">
			<input type="hidden" name="tipo" id="tipo" value="1" />
			
		</div>
	</div>
</form>