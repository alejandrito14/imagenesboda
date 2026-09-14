<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../../login.php");
	echo "login";
	exit;
}

$idmenumodulo = $_GET['idmenumodulo'];

$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Reportes.php");
require_once("../../clases/class.Botones.php");

$db = new MySQL();
$fu = new Funciones();
$rpt = new Reportes();
$bt = new Botones_permisos(); 

$rpt->db = $db;


// Consultas
$l_reportes = $rpt->Lista_reportes();
$l_reportes_row = $db->fetch_assoc($l_reportes);
$l_reportes_num = $db->num_rows($l_reportes);

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
<script type="text/javascript" charset="utf-8">

	//$(document).ready(function() {

		var oTable = $('#zero_config').dataTable( {		

			"oLanguage": {
				"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
				"sZeroRecords": "Lo sentimos, no se han encontrado registros.",
				"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
				"sInfoEmpty": "desde 0 a 0 de 0 records",
				"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
				"sSearch": "Buscar",
				"oPaginate": {
					"sFirst":    "Inicio",
					"sPrevious": "Anterior",
					"sNext":     "Siguiente",
					"sLast":     "Ultimo"
				}
			},
			"sPaginationType": "full_numbers",
			"sScrollX": "100%",
			"sScrollXInner": "100%",
			"bScrollCollapse": true

		} );
		//} );
</script>

	<div class="card" style="background-color: #C9C9C9; border-radius: 4px;">
		<div class="card-body">
			<h5 class="card-title" style="float: left; margin-top: 5px;">REPORTES</h5>	
			<div style="clear: both;"></div>

				<div class="row">
					<div class="form-group col-md-6">
						<label for="exampleInputEmail1">LISTA DE REPORTES</label>
						<select name="v_id_reportes" id="v_id_reportes" class="form-control"  onchange="CargarFiltrosreportes($(this).val())">
							  <option value="0">ESCOGER REPORTE</option>

							<?php

								if ($l_reportes_num==0) { ?>

							  <option value="0">NO SE ENCONTRARON REPORTES EN LA BASE</option>

									
							<?php	}else{


								do
								{
							?>
									<option value="<?php echo $l_reportes_row['idreporte']; ?>"><?php echo $fu->imprimir_cadena_utf8($l_reportes_row['nombre']); ?></option>
									<?php
								}while($l_reportes_row = $db->fetch_assoc($l_reportes));

							}
									?>
										
							  
						</select>
					</div>

				</div>
				<div class="row" id="sucursales">
				  <div class="col-md-6">

				  	<div class="form-group m-t-20">
				  	<label>Sucursales</label>
				  	<select id="v_idsucursales" class="form-control">
				  		
				  	</select>
				   	</div>
				  </div>

<!-- 				   <div class="col">
 -->
				  <!-- 	<select id="v_categoria" class="form-control">
				  		
				  	</select>
				    -->
<!-- 				  </div>
 -->
				  <div class="col-md-6" id="fechainicio">
				  	<div class="form-group">
				  		<label>Fecha inicio</label>

			            <div class='input-group date' id='datetimepicker1'>
			               <input type='date' class="form-control" id="fechainicio1" />
			               <span class="input-group-addon">
			               <span class="glyphicon glyphicon-calendar"></span>
			               </span>
			            </div>
				  </div>
				</div>




				  <div class="col-md-6" id="horainicio">
				  	<div class="form-group">
				  		<label>Hora inicio</label>

			            <div class='input-group date' id='datetimepicker1'>
			               <input type='time' class="form-control" id="v_horainicio" />
			               <span class="input-group-addon">
			               <span class="glyphicon glyphicon-calendar"></span>
			               </span>
			            </div>
				  </div>
				</div>



				   <div class="col-md-6" id="fechafinal">
				   	<div class="form-group">
				  		 <label>Fecha fin</label>

			            <div class='input-group date' id='datetimepicker2'>
			               <input type='date' class="form-control" id="fechafin" />
			               <span class="input-group-addon">
			               <span class="glyphicon glyphicon-calendar"></span>
			               </span>
			           </div>
				  </div>

				</div>

				<div class="col-md-6" id="horafin">
				  	<div class="form-group">
				  		<label>Hora fin</label>

			            <div class='input-group date' id='datetimepicker1'>
			               <input type='time' class="form-control" id="v_horafin" />
			               <span class="input-group-addon">
			               <span class="glyphicon glyphicon-calendar"></span>
			               </span>
			            </div>
				  </div>
				</div>

				<div class="row">
					<div class="col-md-4" style="
					    float: left;
					"></div>
					<div class="col-md-2" style="
					    float: right;
					">
						
						<button style="display: none;margin-left:3em;" id="btngenerar" class="btn btn-primary" onclick="">Generar reporte</button>

					</div>

				</div>
		</div>
	</div>




		 <div class="col-md-12" id="contenedor_reportes">
			 
		 </div>


		 <style type="text/css">
		 	.datetimepicker th.switch{
					width: 105px!important;
				}
		 </style>



<!--  Funcion para llenar el list de sucursales dependiendo el id de empresa  -->
<script type="text/javascript">
	$("#sucursales").css('display','none');
	$("#fechainicio").css('display','none');
	$("#fechafinal").css('display','none');
	//CargarSucursales();
//	CargarCategorias();
	


/*	jQuery('#datetimepicker1').datetimepicker({
			format: 'dd-mm-yyyy HH:mm:ss',
            autoclose: true,
            todayHighlight: true,
			language: 'es'
        });

	jQuery('#datetimepicker2').datetimepicker({
			format: 'dd-mm-yyyy HH:mm:ss',
            autoclose: true,
            todayHighlight: true,
			language: 'es'
        });
*/


/*	function getFormattedDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear().toString().slice(2);

    return day + '-' + month + '-' + year;
}*/
</script>

