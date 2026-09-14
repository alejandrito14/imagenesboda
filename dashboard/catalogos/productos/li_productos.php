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
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$emp = new Productos();
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

<table class="table table-striped table-bordered" id="productos" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead>
		<tr style="text-align: center">
			<th width="50">CÓDIGO</th> 
			<th width="50">NOMBRE</th> 
 			<th width="50">MEDIDA</th> 
 
			<th width="50">ESTATUS</th> 
						
			<th width="50">ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
			<?php
			if($resultado_empresas_num == 0){
			?>
			<tr> 
				<td colspan="7" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN PRODUCTOS EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
			<tr>
			    <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['codigoproducto']); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['nombre']); ?></td>
				
			

				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_empresas_row['tp']);?></td>

				
			

				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($t_estatus[$resultado_empresas_row['estatus']]);?></td>
		
				<td style="text-align: center; font-size: 15px;">
				   <!--<i class="mdi mdi-table-edit" onclick="aparecermodulos('catalogos/empresas/fa_empresas.php?idempresas=<?php echo $resultado_empresas_row['idempresas'];?>','main')" style="cursor: pointer" title="Modificar Empresas"></i>-->
					
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-table-edit";
						$bt->funcion = "aparecermodulos('catalogos/productos/fa_productos.php?idproducto=".$resultado_empresas_row['idproducto']."&idmenumodulo=$idmenumodulo','main')";
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
						$bt->funcion = "BorrarDatosProducto('".$resultado_empresas_row['idproducto']."','".$resultado_empresas_row['idempresas']."','".$idmenumodulo."')";
						$bt->estilos = "";
						$bt->permiso = $permisos;
						$bt->tipo = 3;
						$bt->title="BORRAR";

						$bt->armar_boton();
					?>

					
					
					
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
	 $('#productos').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PRODUCTOS EN LA BASE DE DATOS.",
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