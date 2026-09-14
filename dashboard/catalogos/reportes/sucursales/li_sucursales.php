<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";
	exit;
}

//Recibo parametros del filtro
$idempresas = $_GET['v_idempresa'];
//$idmenumodulo = $_GET['idmenumodulo'];

//Declaración de variables
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//Importamos nuestras clases
require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Reportes.php");
require_once("../../../clases/class.Sucursales.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$rpt = new Reportes();
$sucursales = new Sucursales();
$f = new Funciones();
$bt = new Botones_permisos();

$rpt->db = $db;
$sucursales->db = $db;
$sucursales->idempresas=$idempresas;

//Realizamos consulta

$result_sucursales = $sucursales->obtener_sucursales_empresa();
$resultado_sucursales_num = $db->num_rows($result_sucursales);
$resultado_sucursales_row = $db->fetch_assoc($result_sucursales);

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
/*
if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
*/
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

				if ($resultado_sucursales_num==0) { ?>
					
					<option value="0">NO SE ENCUENTRAN REGISTROS</option>
					
			<?php	}else{?>

					<option value="0">SELECCIONAR SUCURSAL</option>

						<?php do
								{?>
										<option value="<?php echo $resultado_sucursales_row['idsucursales']?>"><?php echo $f->imprimir_cadena_utf8($resultado_sucursales_row['sucursal']);?></option>
									<?php
										}while($resultado_sucursales_row = $db->fetch_assoc($result_sucursales));
										
													}
				?>