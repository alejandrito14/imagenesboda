<?PHP
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$idmenumodulo = $_GET['idmenumodulo'];

$db = new MySQL();
$cli = new Clientes();
$bt = new Botones_permisos();

$f = new Funciones();


$cli->db = $db;

$result_clientes = $cli->clientesTelefono();
$result_clientes_row = $db->fetch_assoc($result_clientes);
$result_clientes_num = $db->num_rows($result_clientes);




//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



 

?>
    
    
    <!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<!--<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>-->
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_clientes').dataTable( {		
					
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
					   "sScrollX": "100%",
		               "sScrollXInner": "100%",
		               "bScrollCollapse": true
					  
					  
						
				} );
				} );
				
				</script>
                
      <article class="module width_full" style="background-color:#CCC">
<div id="li_modulos" class="tab_container">
<table  border="0" cellspacing="2" cellpadding="2"  id="d_clientes" style="color:#999" >
<thead > 
  <tr >
    <th width="11%" align="center" style="border-top-left-radius: 5px">ID</th>
    <th width="81%" align="center">NOMBRE CLIENTE</th>
    <th align="center">TELEFONO</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">ACCION</th>
    </tr>
</thead>    

<tbody>
  <?php
  	do
	{
    	$id = $result_clientes_row['idcliente'];	
		$nombre = $f->imprimir_cadena_utf8($result_clientes_row['nombre']." ".$result_clientes_row['paterno']." ".$result_clientes_row['materno']);
		$numero = $result_clientes_row['telefono'];
	?>
	<tr>
            <td align="center" ><?php echo $id;?></td>
            
            
            <td><?php echo $nombre; ?></td>
 			<td><?php echo $numero; ?></td>           
            <td align="center" ><input type="button" name="button" id="button" value="Seleccionar" onClick="add_num('<?php echo $id;?>','<?php echo $numero;?>'); CerrarModalGeneral('ModalPrincipal');"></td>
      </tr>
		
		
		<?php
	}while($result_clientes_row = $db->fetch_assoc($result_clientes));
  
  ?>

    </tbody>
</table>
    </div>

</article>
    