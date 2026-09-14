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


$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$ca = new Categoriasproductos();
$f = new Funciones();
$bt = new Botones_permisos();

$ca->db = $db;
	


//Recibo parametros del filtro


//Envio parametros a la clase empresas


//Realizamos concalta
$resultado_categorias = $ca->obtenerTodas();
$resultado_categorias_num = $db->num_rows($resultado_categorias);
$resultado_categorias_row = $db->fetch_assoc($resultado_categorias);


?>

   <option value="0">TODAS LAS CATEGORIAS</option>

<?PHP
	do
	{
?>
      <option value="<?php echo $resultado_categorias_row['idcategorias']; ?>"><?php echo $resultado_categorias_row['categoria']; ?> </option>
<?php
	}while($resultado_categorias_row = $db->fetch_assoc($resultado_categorias));
?>
