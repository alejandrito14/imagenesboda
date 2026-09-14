<?php
header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Paginas.php");
require_once("../clases/class.Sucursales.php");

$db= new MySQL();
$pag= new Paginas();
$suc = new Sucursales();

$suc->db = $db;

$resp=$suc->todasSucursales();
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

?>

<script type="text/javascript" charset="utf-8">

	//$(document).ready(function() {
	
		var oTable = $('#zero_config').dataTable( {		
		
		  "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por pagina",
						"sZeroRecords": "No Existen Sucursales en la base de datos",
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
	//});
	
</script>


<div class="card">
	<div class="card-body">
		<h5 class="card-title">LISTA DE SUCURSALES</h5>
		
		<div style="padding: 20px;">
			<button type="button" onClick="aparecermodulos('administrador/fa_sucursales.php','main');" class="btn btn-primary" style="float: right;">Nueva Sucursal</button>
			<div style="clear: both;"></div>
		</div>
		
		
		<div class="table-responsive">
			<table id="zero_config" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th> 
						<th>SUCURSAL</th> 
						<th>DIRECCION</th>
						<th>TELEFONO</th>
						<th>EMAIL</th> 
						<th>IMPRESI&Oacute;N</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($total==0)
						{
						}else{
							do{
								$tipo = array('Carta','T&eacute;rmica 80mm','T&eacute;rmica 57mm');
					?>
					<tr> 
						<td width="50"><?php echo $rows['idsucursales'];?></td> 
						<td><?php echo $rows['sucursal'];?></td> 
						<td><?php echo $rows['direccion'];?></td> 
						<td><?php echo $rows['tel'];?></td> 
						<td><?php echo $rows['email'];?></td> 
						<td><?php echo $tipo[$rows['notas_print']]; ?></td>
						<td>
							<!-- Inicia Editar -->
							<a href="#" onClick="aparecermodulos('administrador/fa_sucursales.php?id=<?php echo $rows['idsucursales'];?>','main');" title="EDITAR"><i class="mdi mdi-table-edit"></i></a>
							<!-- Inicia Borrar -->
							<?php
							//Validamos que sea principal para bloquear la eliminacion
							if($rows['tipo'] == 0){

							?>
							<?php
							}else{
							?>
							<a href="#" onClick="BorrarDatos('<?php echo $rows['idsucursales'];?>','idsucursales','sucursales','n','administrador/vi_sucursales.php','main')" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>
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