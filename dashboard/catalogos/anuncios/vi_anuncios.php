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
require_once("../../clases/class.Anuncios.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.PagConfig.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$Anuncios = new Anuncios();
$bt = new Botones_permisos(); 
$f = new Funciones();
$confi=new Configuracion();
$confi->db=$db;
$Anuncios->db = $db;
$configuracion=$confi->ObtenerInformacionConfiguracion();
$valorcheckebox=$configuracion['mostraranuncios'];

$activaromitir=$configuracion['activaromitirfinal'];
//obtenemos todas las empreas que puede visualizar el usuario.

$Anuncios->tipo_usuario = $tipousaurio;
$Anuncios->lista_empresas = $lista_empresas;

$l_Anuncios = $Anuncios->ObtenerTodosAnuncios();
$l_Anuncios_row = $db->fetch_assoc($l_Anuncios);


$l_Anuncios_num = $db->num_rows($l_Anuncios);

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



$estatus=array('DESACTIVADO','ACTIVADO');

?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title" style="float: left;">LISTADO DE ANUNCIOS</h5>
    
    <div style="float:right;">
      <button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn-primary" style="float: right;display: none;"><i class="mdi mdi-account-search"></i>  BUSCAR</button>      
      
      <?php
    
        //SCRIPT PARA CONSTRUIR UN BOTON
        $bt->titulo = "NUEVO ANUNCIO";
        $bt->icon = "mdi-plus-circle";
        $bt->funcion = "aparecermodulos('catalogos/anuncios/fa_anuncios.php?idmenumodulo=$idmenumodulo','main');";
        $bt->estilos = "float: right; margin-right:10px;";
        $bt->permiso = $permisos;
        $bt->tipo = 5;
        $bt->title="NUEVO ANUNCIO";
        

        $bt->armar_boton();
      
      ?>
      
      <div style="clear: both;"></div>
    </div>
    
    <div style="clear: both;"></div>
  </div>
</div>


<div class="card" style="display: none;">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <!-- 
         <div class="form-group">
                <label>MOSTRAR ANUNCIOS EN LA APLICACIÓN

                  <input type="checkbox" name="v_activaranuncios" onchange="MostrarAnuncios()" value="0" id="v_activaranuncios" style="margin-left: 1em; position: absolute;">
                </label>
              </div> -->
      </div>
            <div class="col-md-12">
               <!-- <div class="form-group">
                <label>OBLIGAR A VISUALIZAR TODO EL ANUNCIO
                  <input type="checkbox" name="v_activaromitirfinal" onchange="MostrarOmitir()" value="0" id="v_activaromitirfinal" style="margin-left: 1em; position: absolute;">
                </label>
              </div> -->
            </div>


            <div class="col-md-12">
              <!--  <div class="form-group">
                <label>ACTIVAR ANUNCIOS PARA TODOS
                  <input type="checkbox" name="v_activaranunciocliente" onchange="Activaranuncios()" value="0" id="v_activaranunciocliente" style="margin-left: 1em; position: absolute;">
                </label>
              </div> -->
            </div>

    </div>
     

              
    </div>
  </div>


<div class="card">
  <div class="card-body">
    <div class="table-responsive" id="contenedor_Anuncios">
      <table id="tbl_Anuncios" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
        <thead>
          <tr>
             
            <th style="text-align: center;">TITULO</th> 
            <th style="text-align: center;">DESCRIPCIÓN</th> 

            <th style="text-align: center;">ESTATUS</th>

            <th style="text-align: center;">ACCI&Oacute;N</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          if($l_Anuncios_num== 0){
            ?>
            <tr> 
              <td colspan="6" style="text-align: center">
                <h5 class="alert_warning">NO EXISTEN REGISTROS EN LA BASE DE DATOS.</h5>
              </td>
            </tr>
            <?php
          }else{
            do
            {
              ?>
              <tr>
              
            
              
              <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($l_Anuncios_row['titulo']);?></td>

                  <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($l_Anuncios_row['descripcion']);?></td>

            
              <td style="text-align: center;"><?php echo $estatus[$l_Anuncios_row['estatus']];?></td>

              <td style="text-align: center; font-size: 15px;">

                  <?php
                          //SCRIPT PARA CONSTRUIR UN BOTON
                  $bt->titulo = "";
                  $bt->icon = "mdi-table-edit";
                  $bt->funcion = "aparecermodulos('catalogos/anuncios/fa_anuncios.php?idmenumodulo=$idmenumodulo&idanuncio=".$l_Anuncios_row['idanuncio']."','main')";
                  $bt->estilos = "";
                  $bt->permiso = $permisos;
                  $bt->tipo = 2;
                  $bt->title="EDITAR";
                  $bt->class='btn btn_colorgray';
                  $bt->armar_boton();


                  ?>

                    <?php
            //SCRIPT PARA CONSTRUIR UN BOTON
            $bt->titulo = "";
            $bt->icon = "mdi-delete-empty";
            $bt->funcion = "BorrarDatos('".$l_Anuncios_row['idanuncio']."','idanuncio','anuncios','n','catalogos/anuncios/vi_anuncios.php','main','$idmenumodulo')";
            $bt->estilos = "";
            $bt->permiso = $permisos;
            $bt->tipo = 3;
            $bt->title="BORRAR";

            $bt->armar_boton();
          ?>
          

                </td>


              </tr>
              <?php
            }while($l_Anuncios_row = $db->fetch_assoc($l_Anuncios));
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<script type="text/javascript">

  var valor='<?php echo $valorcheckebox ?>';

var activaromitir='<?php echo $activaromitir; ?>';

  ColocarCheckbox(valor);
  ColocarCheckboxOmitirAlfinal(activaromitir);
   $('#tbl_Anuncios').DataTable( {   
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

