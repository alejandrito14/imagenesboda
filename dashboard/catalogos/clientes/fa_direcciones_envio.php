<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	//header("Location: ../login.php");
	echo "login";
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Clientes.php");



$db = new MySQL();
$bt = new Botones_permisos(); 
$fu = new Funciones();
$cli = new Clientes();


$cli->db = $db;

$idmenumodulo = $_GET['idmenumodulo'];



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



if(!isset($_GET['idcliente']))
{
	$idcliente = 0;
	$$v_idempresa = "";
	$iddireccionenvio = 0;
	
	
}else
{
	
	$idcliente = $_GET['idcliente'];
	$iddireccionenvio = $_GET['iddireccionenvio'];
	
	//buscamos la información del cliente..
	
	$cli->idCliente = $idcliente;
	$cliente = $cli->ObtenerInformacionCliente();
	$cliente_row = $db->fetch_assoc($cliente);

	$cliente_num = $db->num_rows($cliente);


	$v_no_cliente=$cliente_row['no_cliente'];
	$idempresa=$cliente_row['idempresas'];
	$cli->idCliente=$v_no_cliente;
	$cli->idempresa=$idempresa;
	//echo "Entro por que tiene un id de lciente.";
	$clientesdirecciones = $cli->ObtenerDirecciones();
	$result_clientes_row_direccion = $db->fetch_assoc($clientesdirecciones);
	$result_clientes_num_direccion = $db->num_rows($clientesdirecciones);


	//echo "Entro por que tiene un id de lciente.";
	
	
	
	
	$v_nombre = $fu->imprimir_cadena_utf8($cliente_row['nombre']);
	$v_paterno =$fu->imprimir_cadena_utf8($cliente_row['paterno']);
	$v_materno = $fu->imprimir_cadena_utf8($cliente_row['materno']);
	

	
}


$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion



?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("LISTA DE DIRECCIONES ");
</script>





<div class="card">
	<div class="car-boddy">
		<button id="agregardireccion" class="btn btn_azul" onclick="ModalDireccion('<?php echo $v_no_cliente;?>','<?php echo $idempresa;?>','<?php echo $idmenumodulo;?>')" style="float: right;">NUEVA DIRECCIÓN</button>

		
	</div>
</div>

<div id="d_lista_direcciones_envio" class="table-responsive">

	<table class="table" id="tabladireccion">
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
	  <tbody id="">



		  
	  </tbody>
	</table>

</div>



<script  type="text/javascript" src="./js/mayusculas.js"></script>

<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
	jQuery('#v_f_nacimiento').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
	
	l_direcciones_envio(<?php echo $idcliente ?>,<?php echo $idmenumodulo ?>);

	ObtenerEstadosC(0);
	
</script>