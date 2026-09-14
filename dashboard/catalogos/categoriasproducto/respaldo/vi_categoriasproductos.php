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

//Importación de clase conexión
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categoriasproductos.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$emp = new Categoriasproductos();
$bt = new Botones_permisos(); 
$fu = new Funciones();

$emp->db = $db;


//obtenemos todas las empreas que puede visualizar el usuario.

$emp->tipo_usuario = $tipousaurio;
$emp->lista_empresas = $lista_empresas;

$l_empresas = $emp->obtenerTodas();
$l_empresas_row = $db->fetch_assoc($l_empresas);
$l_empresas_num = $db->num_rows($l_empresas);


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

<div class="card">
	<div class="card-body">
		<h5 class="card-title" style="float: left;">LISTADO DE CATEGORÍAS</h5>
		
		<div style="float:right;">
			<button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn-primary" style="float: right;display: none;"><i class="mdi mdi-account-search"></i>  BUSCAR</button>			
			
			<?php
			
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVA CATEGORIA";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('catalogos/categoriasproducto/fa_categoriasproductos.php?idmenumodulo=$idmenumodulo','main');";
				$bt->estilos = "float: right; margin-right:10px;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;
				$bt->title="NUEVA FAMILIA DE PRODUCTOS";

				$bt->armar_boton();
			
			?>
			
			<div style="clear: both;"></div>
		</div>
		
		<div style="clear: both;"></div>
	</div>
</div>
	
<div class="card">
	<div class="card-body">
		<div class="table-responsive" id="contenedor_empresas">
			<table id="zero_config" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th> 
						<th>NOMBRE</th> 
						
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<tr> 
						<td colspan="7" style="text-align: center">
	  						<h4 class="alert_warning">NO EXISTEN CATEGORIAS EN LA BASE DE DATOS.</h4>
		  				</td>
	  				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>









<script type="text/javascript">
	Buscar_categoriasproducto(<?php echo $idmenumodulo; ?>);
</script>




<div class="modal" id="modalimagencategoria" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Subir imágenes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
       <input type="hidden" id="idcategoriasproducto" value="">

        
                    <form method="post" action="" enctype="multipart/form-data" id="uploadForm" >
                   
                   
                        <input type="file" class=" inputfile inputfile-1 form-control"   name="file" id="demoimg1" />

                       <label  id="seleccionar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                            <span class="iborrainputfile">Seleccionar archivos</span>
                            </label> 
						<p style="text-align: center;">Dimensiones de la imagen Ancho:640px Alto:426px</p>
                    <div id="vfileNames" class="row"></div>

                    <p></p>

         
                   
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
        $("#demoimg1").click();
    });
    
    //prevent browsers from opening the file when its dragged and dropped
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    //call a function to handle file upload on select file
    $('#demoimg1').on('change', fileUploadCategoria);
});
</script>


<style>
	 .input_container input {
 
  padding: 3px;
  border: 1px solid #cccccc;
  border-radius: 0;
}
.input_container div{
  width: 95%;
  border: 1px solid #fefefe;
  position: absolute;
  z-index: 9;
  background: #f3f3f3;
  list-style: none;
  margin-left: 1px;
}
.input_container div p {
  padding: 2px;
      cursor: pointer;
}
.input_container div p:hover {
  background: #eaeaea;

}
#country_list_id {
  display: none;
}


.box.box-alert{border-top-color:red}
.box.box-ama{border-top-color:#f8e517}

    .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.inputfile + label {
    max-width: 80%;
    font-size: 1.25rem;
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
}

.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    margin-right: 0.25em;
}

.iborrainputfile {
    font-size:16px; 
    font-weight:normal;
    font-family: 'Lato';
}
</style>