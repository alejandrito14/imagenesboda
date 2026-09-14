<?php
//////PENDIENTES///////
//quitar campos fechainicial horainicial agregar campo estado mostrar caducado-vigente
//depurar codigo quitar lo innecesario
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
require_once("../../clases/class.Cupones.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

//Declaración de objeto de clase conexión
$db = new MySQL();
$cups = new Cupones();
$bt = new Botones_permisos(); 
$f = new Funciones();
$cups->db = $db;

//obtenemos todas las empreas que puede visualizar el usuario.
$cups->tipo_usuario = $tipousaurio;
$cups->lista_empresas = $lista_empresas;

$r_cupones = $cups->ObtenerTodos();
$a_cupon = $db->fetch_assoc($r_cupones);
$r_cupones_num = $db->num_rows($r_cupones);

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

<div class="card tittle-newbtn">
    <div class="card-body">
        <h5 class="card-title" style="float: left;">LISTADO DE CUPONES </h5>

        <div style="float:right;">
            <button type="button" onClick="abrir_filtro('modal-filtros');" class="btn btn-primary"
                style="float: right;display: none;"><i class="mdi mdi-account-search"></i> BUSCAR</button>

            <?php
			
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "NUEVO CUPÓN";
				$bt->icon = "mdi-plus-circle";
				$bt->funcion = "aparecermodulos('catalogos/cupones/fa_cupones.php?idmenumodulo=$idmenumodulo','main');";
				$bt->estilos = "float: right; margin-right:10px;";
				$bt->permiso = $permisos;
				$bt->tipo = 5;
				$bt->title="NUEVO CUPÓN";
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
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">CÓDIGO</th>
                        <th style="text-align: center;">SUCURSAL</th>
                        <th style="text-align: center;">PAQUETES</th>
                        <th style="text-align: center;">CLIENTES</th>
                        <th style="text-align: center;">DESCUENTO</th>
                        <th style="text-align: center;">ESTADO</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
					if ($r_cupones_num==0) {
                    ?>
                        <tr>
                        <td colspan="7" style="text-align: center">
                            <h4 class="alert_warning">NO EXISTEN CUPONES EN LA BASE DE DATOS.</h4>
                        </td>
                    </tr>
                    <?php	
                    }else{ 

	  				  $s_paquetes = "";
                        ////por cada cupón hacer///
		  				do { 
                            $s_sucursales = "";
                            if ($a_cupon['tsucursales'] == 1){
                                $s_sucursales ="Todas";
                            }
                            else{
                                $r_cuponsucursales = $cups->ObtenerCuponSucursales($a_cupon['idcupon']);
                                $a_cuponsucursales = $db->fetch_assoc($r_cuponsucursales);
                                do{
                                    $s_sucursales = $s_sucursales."".$a_cuponsucursales['sucursal'].", ";
                                }while ($a_cuponsucursales = $db->fetch_assoc($r_cuponsucursales));
                                $s_sucursales= substr_replace($s_sucursales ,"", -2);
                            }
                            
                            $s_paquetes = "";
                            if ($a_cupon['tpaquetes'] == 1){
                                $s_paquetes ="Todos";
                            }
                            else{
		  					    $r_paquetes = $cups->ObtenerCuponPaquetes($a_cupon['idcupon']); 
			                    $a_paquete = $db->fetch_assoc($r_paquetes);
                                $r_paquetes_num = $db->num_rows($r_paquetes);
              
                                do {
                                    $s_paquetes = $s_paquetes."".$a_paquete['nombrepaquete'].", ";            	                
                                }while($a_paquete =$db->fetch_assoc($r_paquetes));
                                $s_paquetes= substr_replace($s_paquetes ,"", -2);
                            }

                            $s_clientes = "";
                            if ($a_cupon['tclientes'] == 1){
                                $s_clientes ="Todos";
                            }
                            else{
                                $r_cuponclientes = $cups->ObtenerCuponClientes($a_cupon['idcupon']);
                                $a_cuponcliente = $db->fetch_assoc($r_cuponclientes);
                                do{
                                    $s_clientes = $s_clientes."".$a_cuponcliente['nombre']." ".$a_cuponcliente['paterno'].", ";
                                }while ($a_cuponcliente = $db->fetch_assoc($r_cuponclientes));
                                $s_clientes= substr_replace($s_clientes ,"", -2);
                            }
                            
                            if ($a_cupon['estatus'] == 0)
                                $switchstate="";
                            else
                                $switchstate="checked";
		  					?>
                    <tr>

                        <td rowspan="2" style="text-align: center;">
                            <?php echo $f->imprimir_cadena_utf8($a_cupon['idcupon']); ?></td>
                        <td style="text-align: center;">
                            <?php echo $f->imprimir_cadena_utf8($a_cupon['codigocupon']); ?></td>

                        <td style="text-align: center;">
                            <?php echo $f->imprimir_cadena_utf8($s_sucursales); ?>  
                        </td>
                        <td style="text-align: center;">
                            <?php echo $f->imprimir_cadena_utf8($s_paquetes); ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $f->imprimir_cadena_utf8($s_clientes);?>
                        </td>         
                        <td style="text-align: center;">
                            <?php 
                            $lbl_descuento ="";
                            if($a_cupon['tipodescuento'] == 1){
                                $lbl_descuento = "$".$a_cupon['descuento']." MNX";
                            }
                            else{
                                $lbl_descuento = intval($a_cupon['descuento'])."%";
                            }
                            echo $f->imprimir_cadena_utf8($lbl_descuento); ?>
                            </td>
                         

                        <td rowspan="1" style="text-align: center; font-size: 15px;">
                        <label class="switch ">
                        <input id="btnState_<?php echo $a_cupon['idcupon'] ?>" type="checkbox" class="cuswitch success" <?php echo $switchstate?>>
                        <span class="slider"></span>
                        </label>
                        </td>
                       
                    </tr>
                    <?php 
                        $strfiltros="FILTROS: ";
                        if($a_cupon['fechainicial'] != ""){
                        $fechainicial = date_create($a_cupon['fechainicial']);
                        $fechainicial = date_format($fechainicial,"d/M/Y");
                        $strfiltros.="[FechaInicial:" . $fechainicial . "] ";
                        }
                        if($a_cupon['fechafinal'] != ""){
                        $fechafinal = date_create($a_cupon['fechafinal']);
                        //"d \d\\e M \d\\e\l Y"
                        $fechafinal = date_format($fechafinal,"d/M/Y");
                        $strfiltros.="[FechaFinal:" . $fechafinal . "] ";
                        }
                        if($a_cupon['horainicial'] != "")
                            $strfiltros.="[HoraInicial:" . $a_cupon['horainicial'] . "] ";
                        if($a_cupon['horafinal'] != "")
                            $strfiltros.="[HoraFinal:" . $a_cupon['horafinal'] . "] ";
                        if($a_cupon['montocompra'] != 0)
                        $strfiltros.="[MontoMínimoDeCompra:$" . $a_cupon['montocompra'] . "] ";
                        if($a_cupon['cantidadcompra'] != 0)
                            $strfiltros.="[CantidadMínimaDePaquetes:" . $a_cupon['cantidadcompra'] . "] ";
                        if($a_cupon['secuenciaventa'] != 0)
                            $strfiltros.="[SecuenciaDeVentas:" . $a_cupon['secuenciaventa'] . "] ";
                        if($a_cupon['aplicarsobrepromo'] != 0)
                            $strfiltros.="[AplicaSobrePromoción]";
                        if($a_cupon['lusocliente'] != 0)
                            $strfiltros.="[LimitePorCliente:" . $a_cupon['lusocliente'] . "] ";
                        if($a_cupon['lusodia'] != 0)
                            $strfiltros.="[LimitePorDía:" . $a_cupon['lusodia'] . "] ";
                        if($a_cupon['lusosucursal'] != 0)
                            $strfiltros.="[LimitePorSucursal:" . $a_cupon['lusosucursal'] . "] ";
                        if($a_cupon['lusototal'] != 0)
                            $strfiltros.="[LimitePorUsoTotal:" . $a_cupon['lusototal'] . "] ";
                        if ($strfiltros == "FILTROS: ")
                            $strfiltros = "FILTROS: [Ninguno]";
                
                    ?>
                    <tr><th style="background-color: rgba(0,0,0,0.05);" colspan="6"><?php echo $f->imprimir_cadena_utf8($strfiltros); ?></th></tr>
                    
                    <?php
              $s_paquetes = "";
		  				}while($a_cupon =$db->fetch_assoc($r_cupones));
	  				} ?>


                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.input_container input {
    padding: 3px;
    border: 1px solid #cccccc;
    border-radius: 0;
}

.input_container div {
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

.box.box-alert {
    border-top-color: red
}

.box.box-ama {
    border-top-color: #f8e517
}

.inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.inputfile+label {
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

.inputfile+label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    margin-right: 0.25em;
}

.iborrainputfile {
    font-size: 16px;
    font-weight: normal;
    font-family: 'Lato';
}
</style>

<script type="text/javascript">
//Buscar_Presentacion(<?php echo $idmenumodulo; ?>);
changeCouponState();
</script>