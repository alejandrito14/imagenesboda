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
$result_clientes_direccion = $cli->ListaDatosfiscales();
$result_clientes_row_direccion = $db->fetch_assoc($result_clientes_direccion);
$result_clientes_num_direccion = $db->num_rows($result_clientes_direccion);


$resultadocliente=$cli->ObtenerInformacionCliente();
$resultado_row=$db->fetch_assoc($resultadocliente);


//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



   ?>

  

 <table class="table" id="tablafiscal" class="table-striped table-bordered ">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">RAZÓN SOCIAL</th>

		  <th scope="col">RFC</th>
	
		  <th scope="col">CALLE</th>
		  <th scope="col">NO.EXT</th>
		  <th scope="col">NO.INT</th>
		  <th scope="col">TIPO ASENTAMIENTO</th>
		  <th scope="col">ASENTAMIENTO</th>
		  <th scope="col">CÓDIGO POSTAL</th>

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
			$razonsocial=$f->imprimir_cadena_utf8($result_clientes_row_direccion['nombre']);
			$rfc=$f->imprimir_cadena_utf8($result_clientes_row_direccion['rfc']);
			$calle=$f->imprimir_cadena_utf8($result_clientes_row_direccion['calle']);
			$noext=$result_clientes_row_direccion['noexterior'];
			$noint=$result_clientes_row_direccion['nointerior'];
			$tipoasentamiento=$result_clientes_row_direccion['asentamiento'];
			$asentamiento=$result_clientes_row_direccion['colonia'];
			$codigo=$result_clientes_row_direccion['codigopostal'];

			/*$direccion = $f->imprimir_cadena_utf8($result_clientes_row_direccion['direccion'].' No. Int. '.$result_clientes_row_direccion['no_int'].' No. Ext. '.$result_clientes_row_direccion['no_ext'].' Col. '.$result_clientes_row_direccion['col'].' CP. '.$result_clientes_row_direccion['cp'].' Referencia:  '.$result_clientes_row_direccion['referencia'] );
	$v_telefono=$result_clientes_row_direccion['telefono'];*/

?>
		  
		<tr>
		  <th scope="row"><?php echo $razonsocial; ?></th>
		  <th scope="row"><?php echo $rfc; ?></th>

		  <th scope="row"><?php echo $calle; ?></th>
		 
		  <th scope="row"><?php echo $noext; ?></th>
		  <th scope="row"><?php echo $noint; ?></th>
		  <th scope="row"><?php echo $tipoasentamiento; ?></th>
		  <th scope="row"><?php echo $asentamiento; ?></th>
		  <th scope="row"><?php echo $codigo; ?></th>


		   <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombremunicipio'])); ?></th>
		  <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombreestado'])); ?></th>
		  <th scope="row"><?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_clientes_row_direccion['nombrepais'])); ?></th>
		  <th scope="row" style="text-align: center;">
			<?php
			
			   
			
			
				//SCRIPT PARA CONSTRUIR UN BOTON
                $bt->titulo = "";
                $bt->icon = "mdi-table-edit";
                $bt->funcion = "ModificarDireccionEnvio()";
                $bt->estilos = "";
                $bt->permiso = $permisos;
                $bt->tipo = 2;
                $bt->class='btn btn_colorgray';

               // $bt->armar_boton();
			
			
			
			
                //SCRIPT PARA CONSTRUIR UN BOTON
                $bt->titulo = "";
                $bt->icon = "mdi-delete-empty";
                $bt->funcion = "BorrarDatosGet();";
                $bt->estilos = "";
                $bt->permiso = $permisos;
                $bt->tipo = 3;


               // $bt->armar_boton();
			  
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
			  NO EXISTE NINGUN DATO FISCAL REGISTRADO
		  </th>
	    </tr>
		<?php
		   }
		  ?> 
	  </tbody>
	</table>

<script type="text/javascript">
	 $('#tablafiscal').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN DIRECCIONES EN LA BASE DE DATOS.",
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
    