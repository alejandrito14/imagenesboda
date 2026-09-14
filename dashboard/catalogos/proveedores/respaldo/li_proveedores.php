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
require_once("../../clases/class.Proveedores.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$pro = new Proveedores();
$f = new Funciones();
$bt = new Botones_permisos();

$pro->db = $db;
	


//Recibo parametros del filtro
$idproveedor = $_GET['v_idproveedor'];


//Envio parametros a la clase empresas
$pro->idprovedores = $idproveedor;

$pro->tipo_usuario = $tipousaurio;
$pro->lista_empresas = $lista_empresas;

//Realizamos consulta
$resultado_proveedores = $pro->obtenerFiltro();
$resultado_proveedores_num = $db->num_rows($resultado_proveedores);
$resultado_proveedores_row = $db->fetch_assoc($resultado_proveedores);

//Declaración de variables
$t_estatus = array('Desactivado','Activado');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
										
?>

<table class="table table-striped table-bordered" id="tbl_proveedores" cellpadding="0" cellspacing="0" style="overflow: auto">
	<thead>
		<tr style="text-align: center">
		
						<th>EMPRESA</th> 
						<th>CONTACTO</th> 
						<th>TELEFONO</th> 
						<th>EMAIL</th>
						<th>RFC</th>
						<th>DIRECCION</th>
						<th>ACCI&Oacute;N</th>
		</tr>
	</thead>

	<tbody>
			<?php
			if($resultado_proveedores_num== 0){
			?>
			<tr> 
				<td colspan="7" style="text-align: center">
					<h5 class="alert_warning">NO EXISTEN PROVEEDORES EN LA BASE DE DATOS.</h5>
				</td>
			</tr>
			<?php
			}else{
				do
				{
			?>
			<tr>
			    <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_proveedores_row['empresa']); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_proveedores_row['contacto_nombre']); ?></td>
				<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($resultado_proveedores_row['contacto_celular']);?></td>
				<td style="text-align: center;"><?php echo $resultado_proveedores_row['contacto_email'];?></td>
				<td style="text-align: center;"><?php echo $resultado_proveedores_row['fis_rfc'];?></td>
								<td style="text-align: center;"><?php echo $resultado_proveedores_row['fis_direccion'];?></td>

				<td style="text-align: center; font-size: 15px;">
				   <!--<i class="mdi mdi-table-edit" onclick="aparecermodulos('catalogos/empresas/fa_empresas.php?idempresas=<?php echo $resultado_empresas_row['idempresas'];?>','main')" style="cursor: pointer" title="Modificar Empresas"></i>-->
					
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-table-edit";
						$bt->funcion = "aparecermodulos('catalogos/proveedores/fa_proveedores.php?idproveedores=".$resultado_proveedores_row['idproveedores']."&idmenumodulo=$idmenumodulo','main')";
						$bt->estilos = "";
						$bt->permiso = $permisos;
					
						//En este boton estamos validando que para acceder a esta sección tenga permisos de agregar pues dentro de esta sección se permiten agregar sucursales a la empresa, así que validaremos el boton de editar directamente en el formulario. 
						$bt->tipo = 2;
						$bt->title="EDITAR";
						$bt->class='btn btn_colorgray';

						$bt->armar_boton();
					?>
					
					<?php
						//SCRIPT PARA CONSTRUIR UN BOTON
						$bt->titulo = "";
						$bt->icon = "mdi-delete-empty";
						$bt->funcion = "BorrarDatos('".$resultado_proveedores_row['idproveedores']."','idproveedores','proveedores','n','catalogos/proveedores/vi_proveedores.php','main','$idmenumodulo')";
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
				}while($resultado_proveedores_row = $db->fetch_assoc($resultado_proveedores));
			}
			?>
	</tbody>
</table>


<script type="text/javascript">
	 $('#tbl_proveedores').DataTable( {		
		 	"pageLength": 100,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN PROVEEDORES EN LA BASE DE DATOS.",
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