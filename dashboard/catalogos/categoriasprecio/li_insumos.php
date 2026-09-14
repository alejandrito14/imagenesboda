<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";

	exit;
}

$idmenumodulo = $_GET['idmenumodulo'];

//validaciones para todo el sistema





$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_GET['idempresa']; //variables de sesion
$tipo_medida=$_GET['v_idtipo_medida'];
//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Insumos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$insumos = new Insumos();
$f = new Funciones();
$bt = new Botones_permisos();

$insumos->db = $db;
	




$insumos->tipo_usuario = $tipousaurio;
$insumos->lista_empresas = $lista_empresas;
$insumos->tipo_medida=$tipo_medida;

//Realizamos consulta
if($lista_empresas!=""){



	$result_insumos = $insumos->ObtenerInsumoSincategoria();



$resultado_insumos_num = $db->num_rows($result_insumos);
$result_insumos_row = $db->fetch_assoc($result_insumos_row);



}

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
										
?>
	
			<?php

			if ($lista_empresas!="") {
				# code...
			
			if($resultado_insumos_num == 0){
			?>
			

				<option value="0">SELECCIONAR INSUMO</option>


			<?php
			}else{?>

				<option value="0">SELECCIONAR INSUMO</option>

				<?php while($result_insumos_row = $db->fetch_assoc($result_insumos))
				{
			?>


			<option value="<?php echo $result_insumos_row['idinsumos']?>"><?php echo $result_insumos_row['idinsumos'].'-'.$f->imprimir_cadena_utf8($result_insumos_row['nombre']); ?></option>
				


			<?php
				}
			}

		}else{ ?>

 							

<?php
		
		}?>