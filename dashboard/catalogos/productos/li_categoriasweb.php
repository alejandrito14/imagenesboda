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
$lista_empresas = $_POST['empresa']; //variables de sesion


//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$f = new Funciones();
$bt = new Botones_permisos();
$cat=new Categoriasproductos();
	
$cat->db=$db;



$cat->tipo_usuario = $tipousaurio;
$cat->lista_empresas = $lista_empresas;

//Realizamos consulta


	$result_categorias = $cat->buscarCategoriaporempresa();


	$result_categorias_num = $db->num_rows($result_categorias);

	$result_categorias_row = $db->fetch_assoc($result_categorias);



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

		
				# code...
			
			if($result_categorias_num == 0){
			?>
			

				<option value="0">SELECCIONAR CATEGORIA </option>


			<?php
			}else{?>

				<option value="0" >SELECCIONAR CATEGORIA </option>

				<?php 
				do{
			?>


			<option value="<?php echo $result_categorias_row['idcategorias']?>"><?php echo $f->imprimir_cadena_utf8($result_categorias_row['categoria']); ?></option>
				


			<?php
				}while($result_categorias_row = $db->fetch_assoc($result_categorias));
			}

		 ?>
			
 							

		