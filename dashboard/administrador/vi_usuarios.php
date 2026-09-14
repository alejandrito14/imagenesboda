<?php
include("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");



require_once("../clases/class.Funciones.php");
require_once("../clases/class.Botones.php");
require_once("../clases/class.Empresas.php");


$db = new MySQL();

$fu = new Funciones();
$bt = new Botones_permisos();

$query="SELECT usuarios.idusuarios, 
	usuarios.idperfiles, 
	usuarios.nombre, 
	usuarios.paterno, 
	usuarios.materno, 
	usuarios.telefono, 
	usuarios.celular, 
	usuarios.email, 
	usuarios.usuario, 
	usuarios.clave, 
	usuarios.estatus,
	usuarios.tipo,
	IF(usuarios.estatus,'ACTIVADO','DESACTIVADO')AS est,
	perfiles.perfil
FROM perfiles INNER JOIN usuarios ON perfiles.idperfiles = usuarios.idperfiles";


$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

$tipo_usuario = array('ADMIN','EMPLEADO','CLIENTE');





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
	$permisos = $_SESSION['permisos_acciones_erp']['pag-2'];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>



<div class="card">
	<div class="card-header">
		<h5 class="card-title" style="float: left;">LISTADO DE USUARIOS</h5>
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Usuario";
			$bt->icon = "mdi-plus-circle";
			$bt->funcion = "aparecermodulos('administrador/fa_usuarios.php','main');";
			$bt->estilos = "float: right;";
			$bt->permiso = $permisos;
			$bt->tipo = 5;
		
			$bt->armar_boton();
		?>
		<div style="clear: both;"></div>
	</div>
	
	<div class="card-body">
		<div class="table-responsive">
			<table id="zero_config" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>TIPO</th>
						<th>PERFIL</th> 
						<th>USUARIO</th> 
						<th>NOMBRE</th> 
						<th>CELULAR</th>
						<th>TEL&Eacute;FONO</th> 
						<th>EMAIL</th>
						<th>SUCURSAL</th>
						<th style="width: 248px;">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($total==0)
					{
				 	?>
						<h4 class="alert_warning">No Existen Usuarios en la base de datos</h4>
				 	<?php
					}else{
				  		do
						{
				 	?>
				   			<tr> 
								<td><?php echo $fu->imprimir_cadena_utf8($tipo_usuario[$rows['tipo']]); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['perfil']); ?></td> 
								<td><?php echo $fu->imprimir_cadena_utf8($rows['usuario']); ?></td> 
								<td><?php echo mb_strtoupper($fu->imprimir_cadena_utf8($rows['nombre']." ".$rows['paterno']." ".$rows['materno'])); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['celular']); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['telefono']); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['email']); ?></td>
                    			<td><?php echo $fu->imprimir_cadena_utf8($rows['est']); ?></td> 
								<td style="text-align: center;">
									<!--<a href="#" onClick="aparecermodulos('administrador/fa_usuarios.php?id=<?php echo $rows['idusuarios'];?>','main')" title="EDITAR"><i class="mdi mdi-table-edit"></i></a>-->
									
									<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "mdi-table-edit";
										$bt->funcion = "aparecermodulos('administrador/fa_usuarios.php?id=".$rows['idusuarios']."','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;
										$bt->class='btn btn_colorgray';
										$bt->title="EDITAR";
										$bt->armar_boton();
									?>
									
									
									<?php
										$tipo = $rows['tipo'];		  
										if($tipo == 0){  
										}else{
									?>
											<!--<a href="#" onClick="BorrarDatos('<?php echo $rows['idusuarios'];?>','idusuarios','usuarios','n','administrador/vi_usuarios.php','main')" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>-->
									
											<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = "mdi-delete-empty";
												$bt->funcion = "BorrarDatos('".$rows['idusuarios']."','idusuarios','usuarios','n','administrador/vi_usuarios.php','main')";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;
												$bt->title="BORRAR";

												$bt->armar_boton();
											?>
												<button onclick="AsignarEmpresas(<?php echo $rows['idusuarios'] ?>);" class="btn btn-primary"><i class="mdi mdi-clipboard-check" title="ASIGNAR EMPRESAS"></i></button>

									<?php


									}
									?>


								</td> 
							</tr>
            		<?php 
						}while($rows=$db->fetch_assoc($resp));
				  	}
	              	?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript" charset="utf-8">	
	var oTable = $('#zero_config').dataTable( {		

	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
					"sZeroRecords": "No Existen Usuarios en la base de datos",
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
</script>
<div class="modal fade" id="modalempresas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ASIGNAR SUCURSALES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<input type="hidden" id="usuarioid">
      <div id="empresasasignadas"></div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-primary" onclick="GuardarEmpresasAcceso();">GUARDAR</button>
      </div>
    </div>
  </div>
</div>