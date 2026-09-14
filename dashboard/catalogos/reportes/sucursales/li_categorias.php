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

$qry="SELECT *
FROM
categorias
WHERE
categorias.idempresas = '".$idempresas."'
ORDER BY
categorias.categoria ASC ";

$sql_result = $db->consulta($qry);
$result_row = $db->fetch_assoc($sql_result);
$result_num = $db->num_rows($sql_result);


if ($result_num==0) { ?>
	
	<option value="0">NO SE ENCUENTRAN REGISTROS</option>
	
<?php	}else{?>

	<option value="0">SELECCIONAR FAMILIA</option>

	<?php do
	{?>
		<option value="<?php echo $result_row['idcategorias']?>"><?php echo $f->imprimir_cadena_utf8($result_row['categoria']);?></option>
		<?php
	}while($result_row = $db->fetch_assoc($sql_result));
	
}
?>