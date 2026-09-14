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
//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

require_once("../../clases/class.Grupos.php");

$idmenumodulo = $_GET['idmenumodulo'];
//Se crean los objetos de clase

$db = new MySQL();
$f = new Funciones();
$bt = new Botones_permisos();
$grupos = new Grupos();
$grupos->db=$db;


$busqueda=$_GET['busqueda'];

$obtenergrupos=$grupos->ObtGruposActivos($busqueda);
$num_rows=$db->num_rows($obtenergrupos);
$rowsgrupos=$db->fetch_assoc($obtenergrupos);
$arrayopcion=array('NO','SI');





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

if($num_rows == 0){
	?>

	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">COMPLEMENTO</h5>
				<p class="card-text">COMPLEMENTO NO ENCONTRADO</p>


			</div>
		</div>
	</div>


	<?php
}else{
	

						$contador=0;

						do { 

							?>

<div class="card col-sm-12 col-md-12" style="float: left;" >
										<div class="card-header" style="background: #d7d7d7;" id="headingOne<?php echo $rowsgrupos['idgrupo'];?>">
											<div class="row">
												<div class="col-md-2"></div>
												<div class="col-md-8">
												<h5 class="mb-0" style="font-size: 2em!important;text-align: center;margin-bottom: 1em!important;" data-toggle="collapse" data-target="#collapseOne<?php echo $rowsgrupos['idgrupo'];?>" aria-expanded="true" aria-controls="collapseOne">
												
													<?php echo $rowsgrupos['nombregrupo']; ?>
												</h5>
												</div>
												<div class="col-md-2"></div>

												
											</div>

									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6">
										
										<h5 style="margin-left: 1em;" for="" class="mb-0">CON PRECIO: <?php echo $arrayopcion[$rowsgrupos['sincoprecio']]; ?> </h5>
										<h5 style="margin-left: 1em;" for="" class="mb-0">OPCIÓN MÚLTIPLE: <?php echo $arrayopcion[$rowsgrupos['multiple']]; ?> </h5>

										
										</div>


									</div>

									<div class="row">
									</div>

							<div class="row">
								<div class="col-md-12">

									<div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" style="float: left;" class="btn " onclick="contadormenoscomplemento(<?php echo $rowsgrupos['idgrupo'] ?>)">-</button>

										<div class="input-group-prepend">
											<input style="width: 50px;text-align: center;float: left;" class="form-control" min="1" type="number" value="1" name="numero" id="complemento_<?php echo $rowsgrupos['idgrupo'] ?>">

										</div>

										<button type="button" style="float: left;" class="btn " onclick="contadormascomplemento(<?php echo $rowsgrupos['idgrupo'] ?>)">+</button>
									</div>
									<br>
									<button type="button" style="width: 9.5em;margin-top: 1em;" onclick="AgregarComplemento(<?php echo $rowsgrupos['idgrupo'] ?>);" class="btn btn-primary">AGREGAR</button>

								</div>
								<div class="col-md-12" style="margin-top: 1em;
								">

<!-- 								<button type="button" style="width: 9em;" onclick="AgregarComplemento(<?php echo $rowsgrupos['idgrupo'] ?>);" class="btn btn-primary">AGREGAR</button>
 -->							</div>
						</div>

					</div>
							<div id="collapseOne<?php echo $rowsgrupos['idgrupo'] ?>" class="collapse " aria-labelledby="headingOne<?php echo $rowsgrupos['idgrupo'] ?>" data-parent="#accordion">
								<div class="card-body">

									
									<?php 

									$idgrupo=$rowsgrupos['idgrupo'];

									$obteneropciones=$grupos->ObtenerOpciones($idgrupo);

									if (count($obteneropciones)>0) {
										?>

										<div class="row">

											<div class="col-md-12">

												<div class="col-md-6" style="float: left;color: #4da84b;">OPCIÓN</div>

												<div class="col-md-6" style="float: left;color: #4da84b;">COSTO</div>

											</div>

										</div>

										<?php	for ($i=0; $i <count($obteneropciones) ; $i++) { ?> 

											<div class="row">

												<div class="col-md-12">

													<div class="col-md-6" style="float: left;"><?php echo $obteneropciones[$i]->opcion ?> </div>

													<div class="col-md-6" style="float: left;">$<?php echo $obteneropciones[$i]->costo ?></div>

												</div>

											</div>

											<?php

										}
									}

									?>

								</div>
							</div>
						</div>


					<?php	
						$contador++;
						} while ($rowsgrupos=$db->fetch_assoc($obtenergrupos));

				
}



?>