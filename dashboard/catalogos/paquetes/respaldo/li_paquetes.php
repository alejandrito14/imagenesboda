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
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

//validaciones para todo el sistema


/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/


//Importamos nuestras clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Paquetes.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Paquetes();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;
	

//Recibo parametros del filtro
$idproducto = $_GET['id'];
$nombre = $_GET['nombre'];
$empresa = $_GET['empresa'];


//Envio parametros a la clase empresas
$emp->idproducto = $idproducto;
$emp->nombre = $nombre;
$emp->empresa = $empresa;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Realizamos consulta
$resultado_empresas = $emp->obtenerFiltro();
$resultado_empresas_num = $db->num_rows($resultado_empresas);
$resultado_empresas_row = $db->fetch_assoc($resultado_empresas);

//Declaración de variables
$t_estatus = array('DESACTIVADO','ACTIVADO');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
										
?>

<table class="table table-striped table-bordered" id="Paquetes" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead>
		<tr style="text-align: center">
			<th width="50">NOMBRE</th> 
			<th  width="70">DESCRIPCION</th>
			<th width="45">PRECIO</th>
			<th width="45">CATEGORÍA</th>
			<th width="40">ORDEN</th>

			<th width="20">ESTATUS</th> 
			<th width="90">INCLUYE</th>
			<th width="160">PROMOCIÓN</th>

						
			<th width="40">ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
			<?php
			if($resultado_empresas_num == 0){
			?>
			<tr> 
				<td colspan="9" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN PAQUETES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
			<tr>
			  
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['nombrepaquete']); ?></td>
				
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['descripcion']);?></td>
				<td>
					$<?php echo $resultado_empresas_row['precioventa'] ?>
				</td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['categoria']);?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['orden']);?></td>
				
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($t_estatus[$resultado_empresas_row['estatus']]);?></td>


				<?php 

					$emp->idpaquete=$resultado_empresas_row['idpaquete'];
					$result=$emp->Obtenerproductodepaquete();
					$productodescripcion='';
				if (count($result)>0) {
							
					for ($i=0; $i <count($result); $i++) { 
						$codigo =$result[$i]->codigoproducto;
						$nombre=$result[$i]->nombre;

						$productodescripcion.='<p>'.$codigo.'-'.$f->imprimir_cadena_utf8($nombre).'<p>';


					}
				}

				 ?>

				<td>
					
					<?php echo $productodescripcion ?>

				</td>

				<td>

	<?php 	if ($resultado_empresas_row['promocion']==1 ) { ?>

        
        
			
        	<span style="margin-left:.8em;margin-bottom:.8em;background: yellow; border-radius: 40px;">Promoción</span>

   <?php     	if ($resultado_empresas_row['definirfecha']==1) { ?>

        	<div style="margin-left:1.2em;font-size:10px;">Promoción por fechas</div>

        		<div style="margin-left:1.2em;font-size:10px;">De <?php echo date('d-m-Y',strtotime($resultado_empresas_row['fechainicial']))?></div>
        		<div style="margin-left:1.2em;font-size:10px;">Hasta <?php echo date('d-m-Y',strtotime($resultado_empresas_row['fechafinal']))?></div>
	
        <?php 	} ?>

       <?php 	if($resultado_empresas_row['aplicardirecto']==1){ ?>

               <div style="margin-left:1.2em;font-size:10px;">Promoción directa</div>

     <?php   	} ?>

        <?php	if ($resultado_empresas_row['repetitivo']==1) { 

	        		$lunes=1;
					$martes=2;
					$miercoles=3;
					$jueves=4;
					$viernes=5;
					$sabado=6;
					$domingo=7;

        			 $lu="";$ma="";$mie="";$jue="";$vie="";$sa="";$domi="";

					if ($resultado_empresas_row['lunes']==1) {
						$lu="divdias";
					}
					if ($resultado_empresas_row['martes']==1) {
						$ma="divdias";
					}
					if($resultado_empresas_row['miercoles']==1){
						$mie="divdias";
					}
					if($resultado_empresas_row['jueves']==1){
						$jue="divdias";
					}
					if ($resultado_empresas_row['viernes']==1) {
						$vie="divdias";
					}

					if ($resultado_empresas_row['sabado']==1) {
						$sa="divdias";
					}
					if ($resultado_empresas_row['domingo']==1) {
						$domi="divdias";
					}

				
					 $dias='';

					$dias.='<span style="padding:.3em;" class="'.$lu.'">L</span> ';
					$dias.='<span style="padding:.3em;" class="'.$ma.'">M</span> ';
					$dias.='<span style="padding:.3em;" class="'.$mie.'">M</span> ';
					$dias.='<span style="padding:.3em;" class="'.$jue.'">J</span> ';
					$dias.='<span style="padding:.3em;" class="'.$vie.'">V</span> ';
					$dias.='<span style="padding:.3em;" class="'.$sa.'">S</span>  ';
					$dias.='<span style="padding:.3em;" class="'.$domi.'">D</span>';

							?>

       		<div style="font-size:10px;margin-top: 1em;"><?php echo $dias?></div>


        <?php 	} ?>

       <?php 	if ($resultado_empresas_row['considerar']>1) { ?>
        	<div style="margin-left:1.2em;font-size:10px;"><?php echo $resultado_empresas_row['considerar'].'x'.$resultado_empresas_row['cantidad'];?></div>


        <?php 	} ?>


        	
    <?php     } ?>
					
				</td>
		
				<td style="text-align: center; font-size: 15px;">
				   <!--<i class="mdi mdi-table-edit" onclick="aparecermodulos('catalogos/empresas/fa_empresas.php?idempresas=<?php echo $resultado_empresas_row['idempresas'];?>','main')" style="cursor: pointer" title="Modificar Empresas"></i>-->
					
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-table-edit";
						$bt->funcion = "aparecermodulos('catalogos/paquetes/fa_paquetes.php?idpaquete=".$resultado_empresas_row['idpaquete']."&idmenumodulo=$idmenumodulo','main')";
						$bt->estilos = "";
						$bt->permiso = $permisos;
						$bt->title="EDITAR";
						$bt->class='btn btn_colorgray';

						//En este boton estamos validando que para acceder a esta sección tenga permisos de agregar pues dentro de esta sección se permiten agregar sucursales a la empresa, así que validaremos el boton de editar directamente en el formulario. 
						$bt->tipo = 2;

						$bt->armar_boton();
					?>
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-delete-empty";
						$bt->funcion = "BorrarDatosPaquete('".$resultado_empresas_row['idpaquete']."','".$idmenumodulo."')";
						$bt->estilos = "";
						$bt->permiso = $permisos;
						$bt->tipo = 3;
						$bt->title="BORRAR";

						$bt->armar_boton();
					?>

					<button class="btn btn-primary" type="button" onclick="Subirimagenpaquete('<?php echo $resultado_empresas_row['idpaquete'];?>')">
						<i class="mdi mdi-arrow-up-bold-circle"></i>
					</button> 
					
					
						<!--<i class="mdi mdi-delete-empty" style="cursor: pointer" onclick="BorrarDatos('<?php echo $resultado_empresas_row['idempresas'];?>','idempresas','empresas','n','catalogos/empresas/vi_empresas.php','main')" ></i>-->
				</td>
			</tr>
			<?php
				}while($resultado_empresas_row = $db->fetch_assoc($resultado_empresas));
			}
			?>
	</tbody>
</table>


<div class="modal" id="modalimagenpaquete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Subir imágenes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
       <input type="hidden" id="idpaquete" value="">

        
                    <form method="post" action="" enctype="multipart/form-data" id="uploadForm" >
                   
                   
                        <input type="file" class=" inputfile inputfile-1 form-control"   name="file" id="demoimg" />

                       <label  id="seleccionar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                            <span class="iborrainputfile">Seleccionar archivos</span>
                            </label> 

                   <p style="text-align: center;">Dimensiones de la imagen Ancho:640px Alto:426px</p>


                    <div id="vfileNames" class="row"></div>

                    <p></p>

                 
			<!-- 
                    <div class='progress' ><div id='progress_id' class='progress-bar progress-bar-striped active'role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%'></div>

                  </div>
                      <div style="margin-left: 86%;padding-top: 0px;" class='percent' id='percent'>0%</div>
 -->
                   
		                	<div id="contador"></div>
                    <div id="cargado"></div>
                      <div id='salidaImagen'></div>

                  </form>


       <div class="tbl"></div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

<script>	
       $(function(){

    //file input field trigger when the drop box is clicked
    $("#seleccionar").click(function(){
        $("#demoimg").click();
    });
    
    //prevent browsers from opening the file when its dragged and dropped
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    //call a function to handle file upload on select file
    $('#demoimg').on('change', fileUploadPaquete);
});
</script>

<script type="text/javascript">
	 $('#Paquetes').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PAQUETES EN LA BASE DE DATOS.",
						"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
						"sInfoEmpty": "desde 0 a 0 de 0 records",
						"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
						"sSearch": "Buscar",
						"oPaginate": {
									 "sFirst":    "Inicio",
									 "sPrevious": "Anterior",
									 "sNext":     "Siguiente",
									 "sLast":     "Ultimo"
									 }
						},
		   "sPaginationType": "full_numbers", 
		 	"paging":   true,
		 	"ordering": true,
        	"info":     false


		} );
</script>

<style type="text/css">
	.divdias{
       background: #eb5d35;
    font-weight: bold;
    color: white;
}
</style>