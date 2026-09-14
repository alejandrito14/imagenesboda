<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../../clases/class.Sesion.php");
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

//validaciones para todo el sistema

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../../../clases/conexcion.php");
require_once("../../../../clases/class.Reportes.php");
require_once("../../../../clases/class.Funciones.php");
require_once("../../../../clases/class.Botones.php");
require_once("../../../../clases/class.Empresas.php");
require_once("../../../../clases/class.Fechas.php");


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

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

//OBTEN4MOS DOS VALORES IMPORATNTS PARA PODER REALIZAR LA CONSULTA ID EMPRESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

//Enviamos a la clase las variables de sesion
$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$fechaactual = $fe->fechaaYYYY_mm_dd_guion();
$fechaInicio = date("Y-m-d",strtotime($fechaactual."- 1 week"));
$fechaFin = $fechaactual;

/*
// Consulta de insumos por empresa  

 if($tipousaurio != 0)  // si no es administrador
    {
    		$id_empresa = "AND e.idempresas IN ($idempresa)";
    }else
    {
    		$id_empresa =" " ;
    }

// Consultas
  
$qry_insumos="SELECT i.*, e.empresas
FROM insumos i
				INNER JOIN empresas e ON e.idempresas = i.idempresas
				WHERE 1=1 $id_empresa				
				ORDER BY  i.idempresas, i.idinsumos ";

 $result_insumos = $db->consulta($qry_insumos);
 $result_insumos_row = $db->fetch_assoc($result_insumos);
 $result_insumos_num = $db->num_rows($result_insumos); 

*/

$l_empresas = $emp->obtenerTodas();
$l_empresas_row = $db->fetch_assoc($l_empresas);
$l_empresas_num = $db->num_rows($l_empresas);

//catalogo de tipo de presentación
/*
$qry_tipo_presentacion = "SELECT
tipo_presentacion.idtipo_presentacion,
tipo_presentacion.nombre,
tipo_presentacion.descripcion
FROM
tipo_presentacion
ORDER BY
tipo_presentacion.nombre ASC
";

$result_tipop = $db->consulta($qry_tipo_presentacion);
$l_tipop_row = $db->fetch_assoc($result_tipop);
$l_tipop_num = $db->num_rows($result_tipop);
*/
										
?>

<div class="card" style="background-color: #C9C9C9; border-radius: 4px;">
		<div class="card-body">
			<div class="col-md-12" style="background-color: #C9C9C9; border-radius: 4px; padding: 5px;">

				<form id="f_Reportes" name="f_Reportes" onsubmit="return valida_emp(this)">

							<div class="row">

								<div class="form-group col-md-5"style="display: block;" id="list_empresas">
									<label for="exampleInputEmail1">EMPRESA</label>
										<select name="v_idempresa" id="v_idempresa" class="form-control" onChange="CargarSucursales_e_Insumos()">
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

								<div class="form-group col-md-5" style="display: block;" id="list_sucursales">
									<label for="exampleInputEmail1">SUCURSALES </label>
									<select name="v_idsucursales" id="v_idsucursales" class="form-control" >
										  <option value="0">TODAS LAS SUCURSALES</option>								
									</select>
								</div>	

								<div class="form-group col-md-2" style="display: block;" >
									<label for="v_nombre">LOTE</label>
									<input name="v_lote" id="v_lote" class="form-control" type="text">
								</div>	

							</div>  <!-- row -->
						
							
						<!-- OTRA FILA  -->

						<div class="row">
	
							<div class="form-group col-md-4" >
								<label>INSUMOS:</label>
								<select class="form-control" id="v_idinsumos" name="v_idinsumos">
									<option value="0">SELECCIONA UN INSUMO</option>
								</select>
							</div>		
							<!--
							<div class="form-group col-md-4" >
								<label>PRESENTACI&Oacute;N:</label>
								<select class="form-control" id="v_idpresentacion" name="v_idpresentacion">
									<option value="0">SELECCIONA UNA PRESENTACI&Oacute;N</option>
								</select>
							</div>	
						    -->

							<div class="form-group col-md-4"style="display: block;" id="list_tipo">
									<label for="v_idpresentacion">TIPO DE SALIDA</label>
										<select name="v_idtipo" id="v_idtipo" class="form-control">
											<option value="X" selected>TODOS LOS TIPOS</option>	
											<option value="0">0.- VENTAS</option>	
											<option value="1">1.- PRODUCTO FALLA</option>	
											<option value="2">2.- CADUCADO</option>	
											<option value="3">3.- MUESTRAS</option>	
											<option value="4">4.- RETENCI&Oacute;N</option>	
											<option value="5">5.- DONACI&Oacute;N</option>											
											<option value="6">6.- REPOSICI&Oacute;N</option>
											<option value="7">7.- TRASPASO</option>		
											<option value="8">8.- CREACI&Oacute;N DE PRODUCTO</option>		
											<option value="9">9.- OTRAS</option>	
										</select>
							</div>					

								<div class="form-group col-md-2" style="display: block;" >
									<label for="v_fecha_inicial">FECHA PEDIDO INICIAL </label>								  
								  <input name="v_fecha_inicial" id="v_fecha_inicial" class="form-control" type="date" value="<?php echo $fechaInicio;  ?>">
								</div>
								
							    <div class="form-group col-md-2" style="display: block;" >
									<label for="v_fecha_final">FECHA PEDIDO FINAL</label>
								  <input name="v_fecha_final" id="v_fecha_final" class="form-control" type="date" value="<?php echo $fechaFin ?>">
								</div>

								<div class="form-group col-md-12" style="text-align: right">
									<a class="btn btn-primary" style="margin-top: 5px; color: #ffffff" id="validate"><i class="mdi mdi-account-search"></i>  VER REPORTE</a>				
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
$( document ).ready(function() {

	$('#validate').click(function() {

		var valid = $('#v_idempresa').val().trim();
		console.log('valor es: '+valid);

		if(valid!=='0')
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