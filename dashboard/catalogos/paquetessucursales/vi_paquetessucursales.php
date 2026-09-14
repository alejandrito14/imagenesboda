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
/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Sucursal.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Paquetes.php");

$idmenumodulo = $_GET['idmenumodulo'];

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Sucursal();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$paquetes=new Paquetes();
$paquetes->db=$db;
$obtenersucursales=$emp->ObtenerTodos();
$row=$db->fetch_assoc($obtenersucursales);
$num=$db->num_rows($obtenersucursales);
			

//Validamos si cargar el formulario para nuevo registro o para modificacion

/*======================= INICIA VALIDACIÓN DE RESPUESTA (alertas) =========================*/

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

/*======================= TERMINA VALIDACIÓN DE RESPUESTA (alertas) =========================*/

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

?>

<form id="f_paquetespro" name="f_paquetespro" method="post" action="">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title m-b-0" style="float: left;">ASIGNAR PAQUETES A SUCURSALES</h4>

			<div style="float: right;">
				
				<?php
			
					//SCRIPT PARA CONSTRUIR UN BOTON
					$bt->titulo = "GUARDAR";
					$bt->icon = "mdi mdi-content-save";
					$bt->funcion = " GuardarGrupo('f_paquetespro','catalogos/grupo/vi_grupo.php','main','$idmenumodulo');";
					$bt->estilos = "float: right;";
					$bt->permiso = $permisos;
					$bt->class='btn btn-success';
				
					//validamos que permiso aplicar si el de alta o el de modificacion
				
						$bt->tipo = 1;
					
			
					//$bt->armar_boton();
				?>
				
				<!--<button type="button" onClick="var resp=MM_validateForm('v_empresa','','R','v_direccion','','R','v_tel','','R','v_email','',' isEmail R'); if(resp==1){ GuardarEmpresa('f_empresa','catalogos/empresas/fa_empresas.php','main');}" class="btn btn-success" style="float: right;"><i class="mdi mdi-content-save"></i>  GUARDAR</button>-->
				
				
				<div style="clear: both;"></div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $idgrupo; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" style="padding-bottom: 0; padding-right: 0; padding-left: 0; padding-top: 0;">
					<!--<h5>DATOS</h5>-->

				</div>
				<div class="col-md-12">
				<div class="card-body">
					


            		<?php if ($num==0){ ?>

            			<div class="card" style="width: 18rem;">
						  <img src="..." class="card-img-top" alt="...">
						  <div class="card-body">
						    <h5 class="card-title"></h5>
						    <p class="card-text">No se encuentran sucursales.</p>
						    <a href="#" class="btn btn-primary"></a>
						  </div>
						</div>



            		<?php }else{ ?>

            			<div class="row">
            			<?php	do { ?>
            				<div class="col-md-4">	
            				<div class="card" style="margin: auto;">
						 
						  <img src="./catalogos/sucursales/imagenes/<?php echo $_SESSION['codservicio'].'/'.$row['foto'];?>" class="card-img-top" style="width:40%;margin: auto;" />
						  <div class="card-body">
						    <h5 class="card-title"></h5>
						    <p class="card-text" style="text-align: center;"><?php echo $row['sucursal'];?></p>

						    <div style="margin:auto;">
						    		 
						    		 <input type="text" class="form-control" name="buscador_<?php echo $row['idsucursales'];?>" id="buscador_<?php echo $row['idsucursales'];?>" placeholder="Buscar" onkeyup="BuscarPaquete(<?php echo $row['idsucursales'];?>);">

						    </div>


						    <div class="paquetessucursales"  style="overflow:scroll;height:100px;" id="paquetessucursales_<?php echo $row['idsucursales'];?>">
						    	<?php 

						    	$obtenerpaquetes=$paquetes->obtenerFiltro();
						    	$rowpaquete=$db->fetch_assoc($obtenerpaquetes);
						    	$contar=$db->num_rows($obtenerpaquetes);

						    	if ($contar>0) {
						    		# code...
						    	
						    	do {
						    		?>

						    		<div class="form-check pasu_<?php echo $row['idsucursales'];?>"  id="pasu_<?php echo $row['idsucursales'];?>_<?php echo $rowpaquete['idpaquete'];?>">

						    			<?php 
						    			$idsucursal=$row['idsucursales'];
						    			$idpaquete=$rowpaquete['idpaquete'];
						    			$estacheckeado=$paquetes->ObtenerPaqueteSucursal($idsucursal,$idpaquete);
						    			$valor="";
						    			if ($estacheckeado>0) {
						    				$valor="checked";
						    			}

						    			?>
									  <input  type="checkbox" value="" class="form-check-input paquetesucursal_<?php echo $row['idsucursales'];?>" id="input_<?php echo $rowpaquete['idpaquete']?>_<?php echo $row['idsucursales'];?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault">
									    <?php echo $rowpaquete['nombrepaquete']; ?>
									  </label>
									</div>
						    		
						    	<?php

						    		} while ($rowpaquete = $db->fetch_assoc($obtenerpaquetes));


						    	 ?>
						    	
						    	 <div style="margin:auto;">
						    	 	<button type="button" onclick="GuardarProductoPaquete(<?php echo $row['idsucursales']; ?>)" class="btn btn-success" style="width: 100%;">GUARDAR</button>
						    	 </div>


						    	<?php } ?>
						    
						  </div>
						  </div>
						</div>
					</div>

            			<?php
            		}while($row = $db->fetch_assoc($obtenersucursales)); 

            		?>

            		</div>

            		 



            		<?php } ?>
            			


       





						
							
						</div>
						
						
					
					</div>
				</div>
			</div>
			</div>
		</div>


	</div>
</form>
<script  type="text/javascript" src="./js/mayusculas.js"></script>
<script>

</script>
<style type="text/css">



</style>


<?php

?>