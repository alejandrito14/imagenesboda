<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";
	exit;
}

//Recibo parametros del filtro
$idempresas = $_GET['v_idempresa'];
//$idinsumo = $_GET['v_idsucursal'];
//$idmenumodulo = $_GET['idmenumodulo'];

//Declaración de variables
$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//Importamos nuestras clases
require_once("../../../../clases/conexcion.php");
require_once("../../../../clases/class.Reportes.php");
require_once("../../../../clases/class.Unidadmedida.php");
require_once("../../../../clases/class.Funciones.php");
require_once("../../../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$rpt = new Reportes();
$unidadmedida = new UnidadMedida();
$f = new Funciones();
$bt = new Botones_permisos();

$rpt->db = $db;

//Realizamos consulta


        $qry="SELECT
insumos.idinsumos,
insumos.idempresas,
insumos.nombre
FROM
insumos
WHERE
insumos.idempresas = '".$idempresas."' ";


    $result_unidadmedida = $db->consulta($qry);
    $resultado_row = $db->fetch_assoc($result_unidadmedida);
    $resultado_num = $db->num_rows($result_unidadmedida);


				if ($resultado_num==0) { ?>
					
					<option value="0">NO SE ENCONTRARON REGISTROS</option>
					
			<?php	}else{?>

					<option value="0">SELECCIONAR INSUMOS</option>

						<?php do
								{?>
										<option value="<?php echo $resultado_row['idinsumos']?>">

											<?php 

											 echo $resultado_row['idinsumos'] ." - " .$rpt->mayus($f->imprimir_cadena_utf8($resultado_row['nombre']));?></option>
									<?php
										}while($resultado_row = $db->fetch_assoc($result_unidadmedida));
										
													}
				?>