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
$busqueda=$_GET['busqueda'];
//validaciones para todo el sistema
$idcategoriaprecios=$_GET['idcategoriaprecios'];


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
$insumos->idcategoriaprecios=$idcategoriaprecios;

//Realizamos consulta
if($lista_empresas!=""){



	$result_insumos = $insumos->Lista_InsumosProductos2($busqueda);



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
			
				 <div class="col-sm-6">
								    <div class="card">
								      <div class="card-body">
								        <h5 class="card-title">INSUMO</h5>
								        <p class="card-text">INSUMOS NO REGISTRADOS</p>
								      
								    
								      </div>
								    </div>
								  </div>


			<?php
			}else{
				while($result_insumos_row = $db->fetch_assoc($result_insumos))
				{
			?>
				
				 <div class="col-sm-6" class="carinsumos">
								    <div class="card">
								      <div class="card-body">
								        <h5 class="card-title"><?php echo $f->imprimir_cadena_utf8($result_insumos_row['nombre']); ?></h5>
								        <p class="card-text"><?php echo $f->imprimir_cadena_utf8($result_insumos_row['descripcion']); ?></p>
								        <p>CODIGO: <?php echo $result_insumos_row['idinsumos']?></p>
								      <p>CONTENIDO: <?php echo $result_insumos_row['cantidad'].$result_insumos_row['medida']?></p>
								      

								      <div id="" style="float: left;">
								        <input style="width: 50px;height: 31px;" min="1" type="number" value="1" name="numero" id="insumo_<?php echo $result_insumos_row['idinsumos'];?>">
								      </div>
								      	<div>
								      	  <a href="#" onclick="AgregarAproducto(<?php echo $result_insumos_row['idinsumos'];?>);" class="btn btn-primary">AGREGAR</a>
										</div>
								      </div>
								    </div>
								  </div>


			<?php
				}
			}

		}else{ ?>

 							<div class="col-sm-6">
								    <div class="card">
								      <div class="card-body">
								        <h5 class="card-title"></h5>
								        <p class="card-text">SELECCIONE UNA EMPRESA</p>
								      
								    
								      </div>
								    </div>
								  </div>

<?php
		
		}?>
