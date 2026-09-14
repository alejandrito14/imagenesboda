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
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Categoriasproductos();
$f = new Funciones();
$bt = new Botones_permisos();

$emp->db = $db;
	

//Recibo parametros del filtro
$idcategoria = $_GET['idcategoria'];
$nombre = $_GET['nombre'];
$empresa = $_GET['empresa'];


//Envio parametros a la clase empresas
$emp->idcategoria = $idcategoria;
$emp->nombre = $nombre;
$emp->empresa = $empresa;

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

//Realizamos consulta
$resultado_empresas = $emp->obtenerFiltro();
$resultado_empresas_num = $db->num_rows($resultado_empresas);
$resultado_empresas_row = $db->fetch_assoc($resultado_empresas);

//Declaración de variables
$estatus = array('DESACTIVADO','ACTIVADO');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
										
?>

<table class="table table-striped table-bordered" id="tbl_presentaciones" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead>
		<tr style="text-align: center">
<!-- 			<th>ID</th> 
 -->			<th>NOMBRE</th> 
			<th>ORDEN</th> 
				<th>ESTATUS</th> 

			<th>ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
			<?php
			if($resultado_empresas_num == 0){
			?>
			<tr> 
				<td colspan="7" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN PRESENTACIONES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
			<tr>
			   <!--  <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['idcategorias']); ?></td> -->
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['categoria']); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['orden']); ?></td>
				
				<td style="text-align: center;"><?php echo $estatus[$resultado_empresas_row['estatus']];?></td>

				<td style="text-align: center; font-size: 15px;">
				   <!--<i class="mdi mdi-table-edit" onclick="aparecermodulos('catalogos/empresas/fa_empresas.php?idempresas=<?php echo $resultado_empresas_row['idempresas'];?>','main')" style="cursor: pointer" title="Modificar Empresas"></i>-->
					
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-table-edit";
						$bt->funcion = "aparecermodulos('catalogos/categoriasproducto/fa_categoriasproductos.php?idcategoria=".$resultado_empresas_row['idcategorias']."&idmenumodulo=$idmenumodulo','main')";
						$bt->estilos = "";
						$bt->permiso = $permisos;
					
						//En este boton estamos validando que para acceder a esta sección tenga permisos de agregar pues dentro de esta sección se permiten agregar sucursales a la empresa, así que validaremos el boton de editar directamente en el formulario. 
						$bt->tipo = 2;
						$bt->class='btn btn_colorgray';
						$bt->title="EDITAR";

						$bt->armar_boton();
					?>
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-delete-empty";
						$bt->funcion = "BorrarCategoria('".$resultado_empresas_row['idcategorias']."','idcategorias','categorias','n','catalogos/categoriasproducto/vi_categoriasproductos.php','main','$idmenumodulo')";

						$bt->estilos = "";
						$bt->permiso = $permisos;
						$bt->tipo = 3;
						$bt->title="BORAR";

						$bt->armar_boton();
					?>


					<button class="btn btn-primary" type="button" onclick="Subirimagencategoria(<?php echo $resultado_empresas_row['idcategorias']; ?>)" title="SUBIR IMAGENES">
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


<script type="text/javascript">
	 $('#tbl_presentaciones').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PRESENTACIONES EN LA BASE DE DATOS.",
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