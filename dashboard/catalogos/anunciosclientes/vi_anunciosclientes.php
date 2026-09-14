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
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Clientes.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Sucursal();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$cli = new Clientes();
$cli->db = $db;
$sql_cliente = $cli->lista_clientes();
$result_row = $db->fetch_assoc($sql_cliente);
$result_row_num = $db->num_rows($sql_cliente);



//Validamos si cargar el formulario para nuevo registro o para modificacion

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

<form id="f_paquetespro" name="f_paquetespro" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;">VISUALIZACIÓN DE ANUNCIOS POR CLIENTE</h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = " ActualizarAnunciovisto('f_paquetespro','catalogos/anunciosclientes/vi_anunciosclientes.php','main','$idmenumodulo');";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				
						$bt->tipo = 1;
						$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idgrupo; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
				
				</div>
				<div class="col-md-12">
				<div class="card-body" >

					<div style="">
						 <div class="">

			<table id="zero_config1" class="table dataTable table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead>
					
 						<th style="text-align: center;">ID</th>
 	
						<th  style="text-align: center;">NOMBRE</th>
						
						<th  style="text-align: center;">USUARIO</th>

						<th  style="text-align: center;">ESTATUS</th>

						<th width="200"  style="text-align: right;">
							<span style="float: left;">ACTIVAR TODOS</span><input type="checkbox" name="v_seleccionartodos" class="form-check-input " id="v_seleccionartodos" onchange="SeleccionarTodos()" ></th>
				
				</thead>
				<tbody>
					<?php 

						if( $result_row_num  != 0)
					{

						?>
						


				<?php		do
						{
		
					 ?>

					 
					 	<tr> 
						  
							<td><?php echo utf8_encode($result_row['idcliente']); ?></td>
						
						  	<td><?php

						  	$nombre=mb_strtoupper($f->imprimir_cadena_utf8($result_row['nombre']." ".$result_row['paterno']." ".$result_row['materno']));

						  	 echo mb_strtoupper($f->imprimir_cadena_utf8($result_row['nombre']." ".$result_row['paterno']." ".$result_row['materno'])); ?></td>
						  	<td><?php echo $result_row['usuario']; ?></td>

						  	<?php $estatus="No visto";

						  		if($result_row['anunciovisto']==1) {

						  			$estatus="Visto";
						  		}
						  		


						  	 ?>
						  	<td style="text-align: center;"><?php echo $estatus; ?></td>

						  	<?php 
						  		$checked="checked";
						  		if ($result_row['anunciovisto']==1) {
						  		$checked="";

						  		}

						  	 ?>
						  	<td style="text-align: right;">
						  		

					                  <input type="checkbox" name="v_clienteanuncio" class="form-check-input v_clienteanunciook "   value="<?php echo $result_row['anunciovisto']; ?>" id="v_clienteanuncio_<?php echo $result_row['idcliente'];?>"  <?php echo $checked; ?>>
						  	</td>
						  </tr>
					  

					 <?php 
						}while( $result_row = $db->fetch_assoc($sql_cliente));

					}else{?>
					
					<tr> 
				<td colspan="6" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN CLIENTES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
					<?php }
					?>

						</tbody>
					</table>
							 </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>


	</div>
</form>

<script type="text/javascript" charset="utf-8">
var oTable="";
$(document).ready(function() {

 oTable = $('#zero_config1').DataTable( {		
	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
					"sZeroRecords": "Nada Encontrado - Disculpa",
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
       		 "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0],
            }],
       
	   "sPaginationType": "full_numbers",
	   		 	"ordering": true,

		});
});
function SeleccionarTodos() {
	var seleccionar=0;
	if ($("#v_seleccionartodos").is(':checked')) {

		seleccionar=1;

			$("#v_seleccionartodos").attr('checked',true);
	}else{

			$("#v_seleccionartodos").attr('checked',false);
	}

	 state = $("#v_seleccionartodos").attr('checked');
	
 	var cols = oTable.column(4).nodes();
        	
        for (var i = 0; i < cols.length; i += 1) {
        	
        		cols[i].querySelector("input[type='checkbox']").checked = state;
        }
}



function ActualizarAnunciovisto(form,regresar,donde,idmenumodulo) {
	var vistos=[];
	var novistos=[];
	
 	var cols = oTable.column(4).nodes();
        	
        for (var i = 0; i < cols.length; i += 1) {
        		var elemento=cols[i].querySelector("input[type='checkbox']");

        		validar=elemento.checked;
        		var id=elemento.id;
  
        		var dividir=id.split('_')[2];
        		if(validar==true){

        			novistos.push(dividir)

        		}else{
        			vistos.push(dividir)
        		}
        }

       $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>');

        var datos="vistos="+vistos+"&novistos="+novistos;
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/anunciosclientes/ga_anunciosclientes.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, 
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						 
					  },
					success:function(msj){

						var resp=msj.respuesta;

						if (resp==1) {

				aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito&idempresas="+resp[1],donde);


						}
								
					  	}
				  });				  					  
		},1000);
}
//

</script>
  
<style type="text/css">



</style>


<?php

?>