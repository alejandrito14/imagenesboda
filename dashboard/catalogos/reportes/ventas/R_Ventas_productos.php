<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";
	exit;
}

$idmenumodulo = $_GET['idmenumodulo'];

//validaciones para todo el sistema
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//Importamos nuestras clases
require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Reportes.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Botones.php");
require_once("../../../clases/class.Empresas.php");
require_once("../../../clases/class.Fechas.php");


//Se crean los objetos de clase
$db = new MySQL();
$rpt = new Reportes();
$fu = new Funciones();
$bt = new Botones_permisos();
$emp = new Empresas();
$fe = new Fechas();

$rpt->db = $db;
$emp->db = $db;
	
//Declaración de variables
$t_estatus = array('Desactivado','Activado');

$fechaactual = $fe->fechaaYYYY_mm_dd_guion();
$fechaInicio = date("Y-m-d",strtotime($fechaactual."- 1 week"));
$fechaFin = $fechaactual;

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

//Enviamos a la clase las variables de sesion
$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

// Consultas
$l_empresas = $emp->obtenerTodas();
$l_empresas_row = $db->fetch_assoc($l_empresas);
$l_empresas_num = $db->num_rows($l_empresas);
										
?>

<div class="card" style="background-color: #C9C9C9; border-radius: 4px;">
		<div class="card-body">
			<div class="col-md-12" style="background-color: #C9C9C9; border-radius: 4px; padding: 5px;">

				<form id="f_Reportes" name="f_Reportes" onsubmit="return valida_emp(this)">

							<div class="row">

								<div class="form-group col-md-4"style="display: block;" id="list_empresas">
									<label for="exampleInputEmail1">EMPRESA</label>
										<select name="v_idempresa" id="v_idempresa" class="form-control" onChange="CargarProductos()">
											<option value="0">TODAS LAS EMPRESAS</option>																    	
												<?php
													do
													  {
												?>
											      <option value="<?php echo $l_empresas_row['idempresas']; ?>"><?php echo $fu->imprimir_cadena_utf8($l_empresas_row['empresas']); ?></option>
												<?php
													  }while($l_empresas_row = $db->fetch_assoc($l_empresas));
												?>
										</select>
								</div>

								<div class="form-group col-md-4" >
									<label>PRODUCTOS</label>
									<select class="form-control" id="v_idproductos" name="v_idproductos">
										<option value="0">SELECCIONA UNA EMPRESA</option>
									</select>
								</div>	

								<div class="form-group col-md-2" id="fecha_inicial" >
									<label for="v_fecha_inicial">FECHA INICIAL </label>								  
									<input name="v_fecha_inicial" id="v_fecha_inicial" class="form-control" type="date" value="<?php echo $fechaInicio;  ?>">
								</div>
								
								<div class="form-group col-md-2" id="fecha_final" >
									<label for="v_fecha_final">FECHA FINAL</label>
									<input name="v_fecha_final" id="v_fecha_final" class="form-control" type="date" value="<?php echo $fechaFin ?>">
								</div>	

								<div class="form-group col-md-12" style="text-align: right">
									<a class="btn btn-primary" style="margin-top: 5px; color: #ffffff" id="validate2"><i class="mdi mdi-account-search"></i>  VER REPORTE</a>				
								</div>			

							</div>  <!-- row -->
						</form>

			</div>	

		</div>
</div>

	<div class="card" style="background-color: #C9C9C9; border-radius: 4px;">
		<div class="card-body">
			<div class="col-md-12" id="d_DetalleReporte" style="overflow: auto; height: 500px">  

			</div>
		</div>
    </div>	

	
<script type="text/javascript">
$(document).ready(function() {

	$('#validate2').click(function() {

		var emp_trans = $('#v_idempresa').val().trim();
		console.log('valor es: '+emp_trans);

		if(emp_trans!=='0')
		{
			VerReporte(<?php echo $idmenumodulo; ?>);	 
		}
		else{
			
			alert('Favor de seleccionar una empresa.');
			return false;
		}	
      
	});

});
</script>