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
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$insumos = new Productos();
$f = new Funciones();
$bt = new Botones_permisos();

$insumos->db = $db;





$insumos->tipo_usuario = $tipousaurio;
$insumos->lista_empresas = $lista_empresas;
$insumos->idcategoriaprecios=$idcategoriaprecios;

//Realizamos consulta



$result_insumos = $insumos->Lista_Productos2($busqueda);
$resultado_insumos_num = $db->num_rows($result_insumos);
$result_insumos_row = $db->fetch_assoc($result_insumos);



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

if($resultado_insumos_num == 0){
	?>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">PRODUCTO</h5>
				<p class="card-text">PRODUCTO NO ENCONTRADO</p>


			</div>
		</div>
	</div>


	<?php
}else{
	do{
		?>

		<div class="col-sm-12" class="carinsumos">
			<div class="card" style="background: #d7d7d7">
				<div class="card-body">
					<h5 class="card-title" style="text-align:center;font-size:25px!important;margin-bottom: 1em;font-weight: bold;"> <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_insumos_row['nombre'])); ?></h5>
				


					<div id="row" >

						<div class="col-md-12 col-sm-12">

						<div class="col-md-5" style="float:left;">
							<div class="btn-group" role="group" aria-label="Basic example">
								<button type="button" style="float: left;" class="btn " onclick="contadormenos(<?php echo $result_insumos_row['idproducto'];?>)">-</button>

								<div class="input-group-prepend">
								<input style="width: 50px;text-align: center;float: left;" class="form-control" min="1" type="number" value="1" name="numero" id="insumo_<?php echo $result_insumos_row['idproducto'];?>">

								</div>
									<button type="button" style="float: left;" class="btn " onclick="contadormas(<?php echo $result_insumos_row['idproducto'];?>)">+</button>
								</div>


								<button type="button" style="margin-top:1em;width: 9.5em;" onclick="AgregarAproducto2(<?php echo $result_insumos_row['idproducto'];?>);" class="btn btn-primary">AGREGAR</button>
	
							
							</div>
						
							


						
						<div class="col-md-7" style="float:left;">
						<p class="card-text" style="font-size:16px;"> <?php echo mb_strtoupper($f->imprimir_cadena_utf8($result_insumos_row['descripcion'])); ?></p>
						<p><?php echo $result_insumos_row['codigoproducto']?></p>

						
						</div>


				

						</div>

					</div>

					<div class="row" style="padding-top: 1em;">
						<div class="col-md-12 col-sm-12">
							<div class="col-md-4" style="float: left;">
<!-- 								<button type="button" style="margin-left: 1em;width:9em;" onclick="AgregarAproducto(<?php echo $result_insumos_row['idproducto'];?>);" class="btn btn-primary">AGREGAR</button>
 -->							</div>
														<div class="col-md-4" style="float: left;"></div>
							<div class="col-md-4" style="float: left;"></div>


							
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php
	}while($result_insumos_row = $db->fetch_assoc($result_insumos));

}



?>
