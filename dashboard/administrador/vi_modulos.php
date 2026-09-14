<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/class.Funciones.php");
//creamos nuestra sesion.
$se = new Sesion();
$fu = new Funciones();

if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
//require_once("../clases/class.Paginas.php");
require_once("../clases/class.ModulosMenu.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.Botones.php");

$db = new MySQL();
$fu = new Funciones();
$bt = new Botones_permisos();

//$pag= new Paginas();

$mm= new ModulosMenu();
$mm->db=$db;


$query="SELECT *,IF(estatus,'ACTIVADO','DESACTIVADO')AS est FROM modulos ORDER BY nivel";
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

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-4'];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>

 

		<script type="text/javascript" charset="utf-8">
				
				var oTable = $('#zero_config').dataTable( {		
					
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
									"sZeroRecords": "NO EXISTEN MODULOS EN LA BASE DE DATOS",
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
				
				var oTable = $('#submenus').dataTable( {		
					
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
									"sZeroRecords": "NO EXISTEN MENUS EN LA BASE DE DATOS.",
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
				
				
				/*new FixedColumns( oTable, {
 		             
		              
					  "iLeftColumns": 0,
		              "iRightColumns": 1
					   });*/
		</script>


<div class="card">
	<div class="card-header">
		<h5 class="card-title" style="float: left;">LISTADO DE MÓDULOS</h5>
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "NUEVO MÓDULO";
			$bt->icon = "mdi-plus-circle";
			$bt->funcion = "aparecermodulos('administrador/fa_modulos.php','main');";
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
						<th>ID MODULO</th> 
						<th>MODULOS</th>
						<th>NIVEL</th> 
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
									<td><?php echo $rows['idmodulos'];?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['modulo']);?></td>
									<td align="center"><?php echo $fu->imprimir_cadena_utf8($rows['nivel']);?></td> 
									<td><?php echo $rows['est'];?></td> 
									<td>
										<!--<a href="#" onClick="aparecermodulos('administrador/fc_modulos.php?id=<?php echo $rows['idmodulos'];?>','main');" title="EDITAR"><i class="mdi mdi-table-edit"></i></a>-->
										
										
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "mdi-table-edit";
											$bt->funcion = "aparecermodulos('administrador/fc_modulos.php?id=".$rows['idmodulos']."','main');";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 2;
											$bt->class='btn btn_colorgray	';
											$bt->title="EDITAR";

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

<br>

<?php

	//sacando los menus del sistema
	$queryMenu="SELECT *,IF(estatus,'ACTIVADO','DESACTIVADO')AS est FROM  modulos_menu ORDER BY nivel";
	$respmenu=$db->consulta($queryMenu);
	$rowsmenu=$db->fetch_assoc($respmenu);
	$totalmenu=$db->num_rows($respmenu);
	
	
?>

<div class="card">
	<div class="card-body">
		<h5 class="card-title">LISTADO DE MENÚS</h5>
		
		<div style="padding: 20px;">			
			<?php
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVO MENÚ";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('administrador/fa_menu.php','main');";
				$bt->estilos = "float: right;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;


				$bt->armar_boton();
			?>
			
			<div style="clear: both;"></div>
		</div>
		
		
		<div class="table-responsive">
			<table id="submenus" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID MENU</th>
						<th>MODULO</th>
						<th>MENU</th>
						<th>ARCHIVO</th>
						<th>UBICACI&Oacute;N</th>
						<th>NIVEL</th>
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
						<td><?php echo $rowsmenu['idmodulos_menu'];?></td> 
						<td><?php $mm->idmodulo=$rowsmenu['idmodulos']; $datos=$mm->ObtenerInfoModulo(); echo $fu->imprimir_cadena_utf8($datos['modulo']);?></td>
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['menu']);?></td> 
						<td><?php echo $rowsmenu['archivo'];?></td> 
						<td><?php echo $rowsmenu['ubicacion_archivo'];?></td>
						<td><?php echo $rowsmenu['nivel'];?></td> 
						<td><?php echo $rowsmenu['est'];?></td> 
						<td>
							<!--<a href="#" onClick="aparecermodulos('administrador/fc_menu.php?id=<?php echo $rowsmenu['idmodulos_menu'];?>','main')" title="EDITAR"><i class="mdi mdi-table-edit"></i></a>-->
							
							<?php
								//SCRIPT PARA CONSTRUIR UN BOTON
								$bt->titulo = "";
								$bt->icon = "mdi-table-edit";
								$bt->funcion = "aparecermodulos('administrador/fc_menu.php?id=".$rowsmenu['idmodulos_menu']."','main');";
								$bt->estilos = "";
								$bt->permiso = $permisos;
								$bt->tipo = 2;
								$bt->title="EDITAR";
								$bt->class='btn btn_colorgray';
								$bt->armar_boton();
							?>
							
						</td> 
					</tr>
					<?php
							}while($rowsmenu=$db->fetch_assoc($respmenu));
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>