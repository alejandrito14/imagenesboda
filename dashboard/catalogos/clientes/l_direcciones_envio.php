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

if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../login.php");
    echo "login";
	exit;
}

$cli->db = $db;

$cli->idCliente = $_GET['idcliente'];
$result_clientes_direccion = $cli->ListaDireccionesEnvios();
$result_clientes_row_direccion = $db->fetch_assoc($result_clientes_direccion);
$result_clientes_num_direccion = $db->num_rows($result_clientes_direccion);


$resultadocliente=$cli->ObtenerInformacionCliente();
$resultado_row=$db->fetch_assoc($resultadocliente);
$idempresa=$resultado_row['idempresas'];
$v_no_cliente=$resultado_row['no_cliente'];

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



   ?>

  

 <table class="table" id="tabladireccion" class="table-striped table-bordered table-responsive">
	  <thead class="thead-dark">
		<tr>
					  <th scope="col">TELÉFONO</th>

		  <th scope="col">DIRECCION</th>
		  <th scope="col">LOCALIDAD</th>

		  <th scope="col">MUNICIPIO</th>
		  <th scope="col">ESTADO</th>
		  <th scope="col">PAIS</th>
		  <th scope="col" style="width: 150px;">ACCIONES</th>
		</tr>
	  </thead>
	  <tbody>
		  
		   <?php

if($result_clientes_num_direccion  != 0)
{
	
		do
	{
			
			$direccion = $f->imprimir_cadena_utf8($result_clientes_row_direccion['direccion'].' No. Int. '.$result_clientes_row_direccion['no_int'].' No. Ext. '.$result_clientes_row_direccion['no_ext'].' Col. '.$result_clientes_row_direccion['col'].' CP. '.$result_clientes_row_direccion['cp'].' Referencia:  '.$result_clientes_row_direccion['referencia'] );
	$v_telefono=$result_clientes_row_direccion['telefono'];

?>
		  
		<tr>
		<th scope="row"><?php echo $v_telefono; ?></th>

		  <th scope="row"><?php echo $direccion; ?></th>
		 
		  <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['ciudad'])); ?></th>
		   <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombremunicipio'])); ?></th>
		  <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombreestado'])); ?></th>
		  <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombrepais'])); ?></th>
		  <th scope="row" style="text-align: center;">
			<?php
			
			    $datos = array('idmenumodulo'=>$idmenumodulo,'idempresa'=>$idempresa,'no_cliente'=>$v_no_cliente,'idclientes_envio'=>$result_clientes_row_direccion['idclientes_envios'],'direccion'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['direccion']),'no_int'=>$result_clientes_row_direccion['no_int'],'no_ext'=>$result_clientes_row_direccion['no_ext'],'referencia'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['referencia']),'col'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['col']),'cp'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['cp']),'estado'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['idestado']),'ciudad'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['ciudad']),'municipio'=>$result_clientes_row_direccion['idmunicipio'],'pais'=>$f->imprimir_cadena_utf8($result_clientes_row_direccion['idpais']),'telefono'=>$v_telefono);
			
			   $json = htmlspecialchars(json_encode($datos), ENT_QUOTES, 'UTF-8'); 
			    //$json =  json_encode ($datos, JSON_HEX_QUOT);
			
			
				//SCRIPT PARA CONSTRUIR UN BOTON
                $bt->titulo = "";
                $bt->icon = "mdi-table-edit";
                $bt->funcion = "ModificarDireccionEnvio($json)";
                $bt->estilos = "";
                $bt->permiso = $permisos;
                $bt->tipo = 2;
                $bt->class='btn btn_colorgray';

                $bt->armar_boton();
			
			
			
			
                //SCRIPT PARA CONSTRUIR UN BOTON
                $bt->titulo = "";
                $bt->icon = "mdi-delete-empty";
                $bt->funcion = "BorrarDatosGet('".$result_clientes_row_direccion['idclientes_envios']."','idclientes_envios','clientes_envios','n','catalogos/clientes/l_direcciones_envio.php?idmenumodulo=$idmenumodulo&idcliente=$cli->idCliente','d_lista_direcciones_envio','$idmenumodulo');";
                $bt->estilos = "";
                $bt->permiso = $permisos;
                $bt->tipo = 3;


                $bt->armar_boton();
			  
			  ?>
			
			
			</th>
	    </tr>
		  
		  
		 <?php
		}while($result_clientes_row_direccion = $db->fetch_assoc($result_clientes_direccion));

	}else
		{
       ?>
		<tr>
		  <th colspan="5" scope="row">
			  NO EXISTE NINGUNA DIRECCION DE ENVIO ESTE MOMENTO
		  </th>
	    </tr>
		<?php
		   }
		  ?> 
	  </tbody>
	</table>

<script type="text/javascript">
	 $('#tabladireccion').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PRESENTACIONES EN LA BASE DE DATOS.",
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
		 	"paging":   true,
		 	"ordering": true,
        	"info":     false


		} );
</script>
    
    