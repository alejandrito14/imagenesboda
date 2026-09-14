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
require_once("../clases/class.Botones.php");

$db = new MySQL();
$fu = new Funciones();
$bt = new Botones_permisos();

$query="SELECT *,IF(estatus,'ACTIVADO','DESACTIVADO')AS est FROM perfiles";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert alert-success" role="alert">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert alert-danger" role="alert">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';	
	echo $msj;
}


//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

$permisos = $_SESSION['permisos_acciones_erp']['pag-3'] ?? '';
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">LISTADO DE PERFILES</h5>	
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Perfil";
			$bt->icon = "mdi-plus-circle";
			$bt->funcion = "aparecermodulos('administrador/fa_perfiles.php','main');";
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
						<th>ID PERFIL</th> 
						<th>PERFIL</th> 
						<th>ESTATUS</th> 
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($total==0)
						{
						}else{
							do{
					?>
								<tr> 
									<td width="50"><?php echo $rows['idperfiles'];?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['perfil']); ?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['est']); ?></td> 
									<td>
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "mdi-table-edit";
											$bt->funcion = "aparecermodulos('administrador/fc_perfiles.php?id=".$rows['idperfiles']."','main');";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 2;
											$bt->class='btn btn_colorgray';
											$bt->title="EDITAR";
											$bt->armar_boton();
										?>
										
										<!--<a href="#" onClick="aparecermodulos('administrador/fc_perfiles.php?id=<?php echo $rows['idperfiles'];?>','main');" title="EDITAR"><i class="mdi mdi-table-edit"></i></a>-->
										
										<!--<a href="#" onClick="BorrarDatos('<?php echo $rows['idperfiles'];?>','idperfiles','perfiles','n','administrador/vi_perfiles.php','main')" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>-->
										
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "mdi-delete-empty";
											$bt->funcion = "BorrarDatos('".$rows['idperfiles']."','idperfiles','perfiles','n','administrador/vi_perfiles.php','main');";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 3;
										$bt->title="BORRAR";

											$bt->armar_boton();
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
						"sZeroRecords": "No Existen Perfiles en la base de datos",
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
</script>
