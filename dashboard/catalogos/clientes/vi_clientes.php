<?php
require_once("../../clases/class.Sesion.php");

//creamos nuestra sesion.
$se = new Sesion();


$idmenumodulo = $_GET['idmenumodulo'];

if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../login.php");
	echo "login";
	exit;
}
     require_once("../../clases/conexcion.php");
     require_once("../../clases/class.Clientes.php");
     require_once("../../clases/class.Botones.php");
     require_once("../../clases/class.Funciones.php");

	 
	 $db = new MySQL();
     $cli = new Clientes();
     $bt = new Botones_permisos(); 
     $f=new Funciones();
     $cli->db = $db;
    
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion


$cli->tipo_usuario= $tipousaurio;
$cli->lista_empresas = $lista_empresas;
	 

	 $sql_cliente = $cli->lista_clientes();


	 $result_row = $db->fetch_assoc($sql_cliente);
	 $result_row_num = $db->num_rows($sql_cliente);

//die("Entro ".$result_row_num);


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



 
 ?>
 
<script type="text/javascript" charset="utf-8">

//$(document).ready(function() {

var oTable = $('#zero_config').dataTable( {		

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
	   "sPaginationType": "full_numbers",
	   		 	"ordering": true,

});
//});

</script>
  

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">LISTADO DE CLIENTES</h5>
		<!--<button type="button" onClick="AbrirModalGeneral2('ModalPrincipal','900','560','catalogos/clientes/fa_cliente.php');" class="btn btn-info" style="float: right;">AGREGAR CLIENTE</button>-->
		<?php
		
				
		$bt->titulo = "NUEVO CLIENTE";
		$bt->icon = "mdi-plus-circle";
		$bt->funcion = "
	
			 aparecermodulos('catalogos/clientes/fa_cliente.php?idmenumodulo=$idmenumodulo','main');
			 ";
		$bt->estilos = "float: right; margin-right: 10px;";
		$bt->permiso = $permisos;
		$bt->tipo = 5;
		$bt->title="NUEVO CLIENTE";
		$bt->armar_boton();

			?>

		
		
		
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table id="zero_config" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
 						<th>ID</th>
 	
						<th width="72">NOMBRE</th>
					<!--	<th>NIVEL</th> -->
						<!--<th>NO TARJETA</th>-->
						<th width="88">CELULAR</th>
						<th>CORREO</th>
<!-- 						<th width="97">LOCALIDAD</th>
 --> 						<th width="72">TOKEN</th>


						<!--<th>SUCURSAL</th>-->
						<th width="64">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
				
					
					if( $result_row_num  != 0)
					{
						do
						{
						
			
					?>

						<tr> 
						  
							<td width="30"><?php echo utf8_encode($result_row['idcliente']); ?></td>
						
						  	<td><?php

						  	$nombre=mb_strtoupper($f->imprimir_cadena_utf8($result_row['nombre']." ".$result_row['paterno']." ".$result_row['materno']));

						  	 echo mb_strtoupper($f->imprimir_cadena_utf8($result_row['nombre']." ".$result_row['paterno']." ".$result_row['materno'])); ?></td>
						  	<!--<td><?php echo $nivel; ?></td>-->
						  	
						  	<td><a href="tel://<?php echo utf8_encode($result_row['celular']); ?>"><?php echo utf8_encode($result_row['celular']); ?></a></td>
						  	<td width="30"><?php echo utf8_encode($result_row['usuario']); ?></td>

						  	<td width="30"><?php echo utf8_encode($result_row['token']); ?></td>
						  	<!--<td style="text-align:center;"><?php echo utf8_encode($result_row['usuario']); ?></td>-->
							<!-- <td width="97"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_row['idlocalidad'])); ?></td> -->

						
						
					  	  <!--	<td style="text-align:center;"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>-->
						  	<td align="center">
								

										<?php
													//SCRIPT PARA CONSTRUIR UN BOTON
													$bt->titulo = "";
													$bt->icon = "mdi-table-edit";
													$bt->funcion = "aparecermodulos('catalogos/clientes/fa_cliente.php?idmenumodulo=$idmenumodulo&idcliente=".$result_row['idcliente']."','main')";
													$bt->estilos = "";
													$bt->permiso = $permisos;
													$bt->tipo = 2;
													$bt->title="EDITAR";
													$bt->class='btn btn_colorgray';
													$bt->armar_boton();
											


													$bt->titulo = "";
													$bt->icon = "mdi-delete-empty";
													$bt->funcion = "BorrarCliente('".$result_row['idcliente']."','".$nombre."',".$idmenumodulo.")";
													$bt->estilos = "";
													$bt->permiso = $permisos;
													$bt->tipo = 3;
													$bt->title="BORRAR";

													$bt->armar_boton();
												   					
												
								
													$bt->titulo = "";
													$bt->icon = "mdi-truck";
													$bt->funcion = "AbrirModalDireccionesEnvio('".$result_row['idcliente']."',".$idmenumodulo.")";
													$bt->estilos = "";
													$bt->permiso = $permisos;
													$bt->tipo = 4;
													$bt->title="DIRECCIONES DE ENVIO";

													$bt->armar_boton();
							
							
													$bt->titulo = "";
													$bt->icon = "mdi-receipt";
													$bt->funcion = "AbrirModalDatosFiscales('".$result_row['idcliente']."',".$idmenumodulo.")";
													$bt->estilos = "";
													$bt->permiso = $permisos;
													$bt->tipo = 4;
													$bt->title="DATOS FISCALES";

													$bt->armar_boton();
							     

													//SCRIPT PARA CONSTRUIR UN BOTON
												
												?>
								
									
								
<!--								<button type="button" onClick="AbrirModalGeneral2('ModalPrincipal','900','560','catalogos/fc_cliente.php?id=<?php echo $result_row['idcliente'];?>');" title="EDITAR" class="btn btn-outline-info"><i class="mdi mdi-table-edit"></i></button>
							
								<button type="button" onClick="BorrarDatos('<?php echo $result_row['idcliente'];?>','idcliente','clientes','n','catalogos/vi_clientes.php','main')" title="BORRAR" class="btn btn-outline-danger"><i class="mdi mdi-delete-empty"></i></button>-->
								
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

<script>
	//Buscar_empleado(<?php echo $idmenumodulo; ?>);
</script>

