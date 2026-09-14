<?php

/////PENDIENTES///
//checar para tipo de usuario administrador de restaurante que sucursal tiene acceso o no es necesario
//validar que codigo cupon no exista en BD
//opcion modificar cupon
///////Sucursales////////
//verificar que este seleccionado almenos un chekbox del card sucursales
//verificar si se seleccionan todas las sucursales de la lista guardar solo tsucursales
///TAREAS HOY////
//1.Seleccionar para que sucursales o para todas//
//2.Poner select para porcentage o monto en descuentos//

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once "../../clases/class.Sesion.php";
//creamos nuestra sesion.
$se = new Sesion();

if (!isset($_SESSION['se_SAS'])) {
    /*header("Location: ../../login.php"); */echo "login";
    exit;
}

$tipousaurio = $_SESSION['se_sas_Tipo']; //variables de sesion
$lista_empresas = $_SESSION['se_liempresas']; //variables de sesion
$idusuario = $_SESSION['se_sas_Usuario'];
$idmenumodulo = $_GET['idmenumodulo'];

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos nuestras clases
require_once "../../clases/conexcion.php";
require_once "../../clases/class.Cupones.php";
require_once "../../clases/class.Funciones.php";
require_once "../../clases/class.Botones.php";
require_once "../../clases/class.Sucursal.php";
require_once "../../clases/class.AccesoEmpresa.php";
require_once "../../clases/class.Paquetes.php";
require_once("../../clases/class.Clientes.php");

//Se crean los objetos de clase
$db = new MySQL();
$f = new Funciones();
$bt = new Botones_permisos();
$acceso = new AccesoEmpresa();
$acceso->db = $db;

//////PAQUETES//////
$paquetes=new Paquetes();
$paquetes->db=$db;

$su = new Sucursal();
$su->db = $db;

$obj = new Cupones();
$obj->db = $db;
$obj->tipo_usuario = $tipousaurio;
$obj->lista_empresas = $lista_empresas;

$cli = new Clientes();
$cli->db = $db;
$r_clientes = $cli->lista_clientes();
$a_cliente = $db->fetch_assoc($r_clientes);
$r_clientes_num = $db->num_rows($r_clientes);

$r_sucursales = $su->ObtenerTodos();
$r_sucursales_num = $db->num_rows($r_sucursales);
$a_sucursal = $db->fetch_assoc($r_sucursales);

///VALIDAR FORMULARIO NUEVO///
if (!isset($_GET['idcupon'])) {
    //NUEVO//
	$idcupon = 0;
	$obj->idcupon = 0;
    $col = "col-md-12";
    $ver = "display:none;";
    $titulo = 'NUEVO CUPON';
} 

/////INICIA VALIDACIÓN DE RESPUESTA (alertas)/////
if (isset($_GET['ac'])) {
    if ($_GET['ac'] == 1) {
        echo '<script type="text/javascript">AbrirNotificacion("' . $_GET['msj'] . '","mdi-checkbox-marked-circle");</script>';
    } else {
        echo '<script type="text/javascript">AbrirNotificacion("' . $_GET['msj'] . '","mdi-close-circle");</script>';
    }
    echo '<script type="text/javascript">OcultarNotificacion()</script>';
}

///////INICIA RECIBIMOS PARAMETRO DE PERMISOS ////////
if (isset($_SESSION['permisos_acciones_erp'])) {
    //Nombre de sesion | pag-idmodulos_menu
    $permisos = $_SESSION['permisos_acciones_erp']['pag-' . $idmenumodulo];
} else {
    $permisos = '';
}
?>

<form id="f_cupon" name="f_cupon" method="post" class="needs-validation" action="" novalidate>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title m-b-0" style="float: left;"><?php echo $titulo; ?></h4>
            <div style="float: right;">
                <?php
                /*
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = 'GUARDAR';
				$bt->icon = "mdi mdi-content-save";
				$bt->funcion = "var resp=MM_validateForm('v_descuento','','R'); if(resp==1){ GuardarCupon('f_cupon','catalogos/cupones/vi_cupones.php','main','$idmenumodulo','$idcupon');}";
				$bt->estilos = 'float: right;"';
				$bt->permiso = $permisos;
				$bt->class = 'btn btn-success';
                
				//validamos permiso de alta o modificacion
				if ($idcupon == 0) {
    				$bt->tipo = 1;
				} else {
    				$bt->tipo = 2;
				}

				$bt->armar_boton();*/
				?>
                <button type="submit" class="btn btn-success" id="sendbtn" style="float: right;" title=""><i
                        class="mdi mdi-arrow-left-box"></i> GUARDAR </button>
                <button type="button"
                    onClick="aparecermodulos('catalogos/cupones/vi_cupones.php?idmenumodulo=<?php echo $idmenumodulo; ?>','main');"
                    class="btn btn-primary" style="float: right; margin-right: 10px;"><i
                        class="mdi mdi-arrow-left-box"></i> LISTADO DE CUPONES </button>
                <div style="clear: both;"></div>

                <input type="hidden" id="id" name="id" value="<?php echo $idcupon; ?>" />
            </div>
            <div style="clear: both;"></div>
        </div>
    </div><!--card-TITTLE-->

    <div class="row">
        <div class="<?php echo $col; ?>">
            <div class="card">
                <div class="card-header" >                
                    <label style="font-size: 16px;">DATOS GENERALES:</label>
                </div>
                <div class="card-body">
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active show" id="generales" role="tabpanel">
                           
                            <div class="col-md-6">
                                    <label class="form-control-label">*CÓDIGO:</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="v_codigo" name="v_codigo" style="text-transform:uppercase;"
                                        value="" title="CODIGO" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10" required>
                                        <div class="input-group-append">
                                            <button id="btnCodeGen" class="btn btn-outline-secondary" type="button">AutoGenerar</button>                     
                                        </div>
                                        <div class="invalid-feedback">Ingresa de 5 a 10 caracteres alfanuméricos (letras y números, sin espacios) Ejemplo: VIVAMX21</div>
                                    </div>      
                            </div>
                        
                            <div class="col-md-6">
                                <div class="form-group m-t-20">
                                    <label;>*TIPO DE DESCUENTO:</label>
                                    <select name="v_tipodescuento" id="v_tipodescuento" title="TipoDescuento" class="form-control" required>
                                        <option selected disabled value="">SELECCIONAR TIPO DE DESCUENTO</option>
                                        <option value="0" >PORCENTAJE</option>
                                        <option value="1" >MONTO</option>
                                    </select>
                                    <div class="invalid-feedback">Selecciona un tipo de descuento</div>
                                    
                                    <label style="margin-top: 1em";>*DESCUENTO:</label>
                                    <input type="text" class="form-control" id="v_descuento" name="v_descuento" pattern="^[0-9]+$"
                                        value="<?php echo $obj->descuento; ?>" title="DESCUENTO"  required>
                                    <div id="inf_descuento" class="invalid-feedback">Ingresa una cantidad (solo números)</div>

                                    <div class="form-group m-t-20" style="margin-top: 1em;">
                                    <label>ESTATUS:</label>
                                    <select name="v_estatus" id="v_estatus" title="Estatus" class="form-control">
                                        <option value="1" <?php if ($obj->estatus == 1) {echo "selected";}?>>ACTIVADO
                                        </option>
                                        <option value="0" <?php if ($obj->estatus == 0) {echo "selected";}?>>DESACTIVO
                                        </option>
                                    </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--card-DG-->
        </div>
    </div>

    <div class="card">
		<div class="card-header">
				<label style="font-size: 16px;">*PAQUETE(S):</label>
			</div>
		<div class="card-body col-md-12">
			<div class="col-md-6" style="float: left;">
				<div class="card-header" style="padding-left: 0.45rem;">CUPÓN VÁLIDO PARA TODOS LOS PAQUETES
				 <input type="checkbox" id="v_tpaquetes"  name="v_tpaquetes" onchange="HabilitarDeshabilitarCheck('#lpaquetesdiv')" value="<?php ?>" title="PROMOCIÓN" placeholder='PROMOCIÓN' <?php  ?> >
				</div>
                <div class="card-body" id="lpaquetesdiv" style="display: block;padding-left: 0;">
                    <div class="form-group m-t-20">	 
						<input type="text" class="form-control" name="buscadorpaq_" id="buscadorpaq_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorpaq_','.pasuc_')">
				    </div>
                    <div class="paquetessucursales"  style="overflow:scroll;height:100px;" id="paquetessucursales_<?php echo $a_sucursal['idsucursales'];?>">
						<?php      
						        $r_paquetes=$paquetes->obtenerFiltro();
				    	        $a_paquete=$db->fetch_assoc($r_paquetes);
				    	        $contar=$db->num_rows($r_paquetes);
						    	if ($contar>0) {
							    	 do {
						    		    ?>
						    		    <div class="form-check pasuc_"  id="pasuc_x_<?php echo $a_paquete['idpaquete'];?>">
						    			<?php 
						    			//$idsucursal=$a_sucursal['idsucursales'];
						    			//$idpaquete=$a_paquete['idpaquete'];
						    			//$estacheckeado=$paquetes->ObtenerPaqueteSucursal($idsucursal,$idpaquete);
						    			$valor="";
						    			if ($a_paquete['estatus']==1) {
						    
						    			?>
									    <input  type="checkbox" value="" class="form-check-input chkpaquete_<?php echo $idcupon;?>" id="inputpaq_<?php echo $a_paquete['idpaquete']?>_<?php echo $a_sucursal['idsucursales'];?>" <?php echo $valor; ?>>
									    <label class="form-check-label" for="flexCheckDefault">
									    <?php echo $a_paquete['nombrepaquete']; 
                                        }?>
									  </label>
									</div>						    		
						    	<?php
						    		} while ($a_paquete = $db->fetch_assoc($r_paquetes));
     					    	 ?>
						    	<?php
                                 } 
                                ?>    
				    </div>
                    
                </div> <!--lpaquetesdiv-->
			</div>
		</div>
    </div><!--card-PAQ-->

	<div class="card">
		<div class="card-header">
				<label style="font-size: 16px;">*SUCURSAL(ES):</label>
		</div>
		<div class="card-body col-md-12">
			<div class="col-md-6" style="float: left;">
				<div class="card-header" style="padding-left: 0.45rem;">CUPÓN VÁLIDO PARA TODAS LAS SUCURSALES
				 <input type="checkbox" id="v_tsucursales" name="v_tsucursales" onchange="HabilitarDeshabilitarCheck('#lsucursalesdiv')" value="" title="TODAS" placeholder='TODAS' <?php  ?> >
				</div>
                <div class="card-body" id="lsucursalesdiv" style="display: block;padding-left: 0;">
                    <div class="form-group m-t-20">	 
						<input type="text" class="form-control" name="buscadorsuc_" id="buscadorsuc_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorsuc_','.suc_')">
				    </div>
                    <div class="sucursales"  style="overflow:scroll;height:100px;overflow-x: hidden" id="sucursales_<?php echo $a_sucursal['idsucursales'];?>">
					    <?php     	
							if ($r_sucursales_num>0) {	
						    	do {
						?>
						    	<div class="form-check suc_"  id="suc_<?php echo $a_sucursal['idsucursales'];?>_<?php echo $a_sucursal['idsucursales'];?>">
						    	    <?php 	
						    			$valor="";
						    		?>
									  <input  type="checkbox" value="" class="form-check-input chksucursal_<?php echo $idcupon;?>" id="inputsuc_<?php echo $a_sucursal['idsucursales']?>_<?php echo $a_sucursal['idsucursales'];?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault"><?php echo $a_sucursal['sucursal']; ?></label>
								</div>						    		
						    	<?php
						    		} while ($a_sucursal = $db->fetch_assoc($r_sucursales));
     					    	 ?>
						    	<?php } ?>    
				    </div>
                </div><!--lsucursalesdiv-->
			</div>
		</div>
    </div><!--card-Suc-->

    <div class="card">
		<div class="card-header">
				<label style="font-size: 16px;">*CLIENTE(S):</label>
			</div>
		<div class="card-body col-md-12">
			<div class="col-md-6" style="float: left;">
				<div class="card-header" style="padding-left: 0.45rem;">CUPÓN VÁLIDO PARA TODOS LOS CLIENTES
				 <input type="checkbox" id="v_tclientes"  name="v_tclientes" onchange="HabilitarDeshabilitarCheck('#lclientesdiv')" value="<?php ?>" title="PROMOCIÓN" placeholder='PROMOCIÓN' <?php  ?> >
				</div>
                <div class="card-body" id="lclientesdiv" style="display: block; padding: 0;">
                
                    <div class="form-group m-t-20">	 
						<input type="text" class="form-control" name="buscadorcli_?>" id="buscadorcli_" placeholder="Buscar" onkeyup="BuscarEnLista('#buscadorcli_','.cli_')">
				    </div>
                    <div class="clientes"  style="overflow:scroll;height:100px;overflow-x: hidden" id="clientes_<?php echo $a_cliente['idcliente'];?>">
					    <?php     	
							if ($r_clientes_num>0) {	
						    	do {
						?>
						    	<div class="form-check cli_"  id="cli_<?php echo $a_cliente['idcliente'];?>_<?php echo $a_cliente['idcliente'];?>">
						    	    <?php 	
						    			$valor="";
                                        $nombre=mb_strtoupper($f->imprimir_cadena_utf8($a_cliente['nombre']." ".$a_cliente['paterno']." ".$a_cliente['materno']));
						    		?>
									  <input  type="checkbox" value="" class="form-check-input chkcliente_<?php echo $idcupon;?>" id="inputcli_<?php echo $a_cliente['idcliente']?>_<?php echo $idcupon;?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault"><?php echo $nombre; ?></label>
								</div>						    		
						    	<?php
						    		} while ($a_cliente = $db->fetch_assoc($r_clientes));
     					    	 ?>
						    	<?php } ?>    
				    </div>
                </div> <!-- lclientesdiv -->
			</div>
		</div>
    </div><!--card-CLI-->

    <div class="card">
        <div class="card-header">
				<label style="font-size: 16px;">FILTROS OPCIONALES:</label>
		</div>
		<div class="card-body col-md-12" style="float: left;">
            <div class="col-md-12" style="float: left;margin-bottom: 1em;">
            <label class="col-md-12 card-header" style="padding-left: 0.45rem;">VIGENCIA:</label>
            </div>
            <div class="col-md-3" style="float: left;">
                    <label>FECHA INICIAL:</label>
                    <input type="date" class="form-control" name="v_fechainicial"
                        id="v_fechainicial" value="<?php echo $obj->fechainicial; ?>">
            </div>
            <div class="col-md-3" style="float: left;">
                <label>FECHA FINAL:</label>
                <input type="date" class="form-control" name="v_fechafinal" id="v_fechafinal"
                       value="<?php echo $obj->fechafinal; ?>">                           
            </div>
            <div class="col-md-3" style="float: left;">
                <label>HORA DE INICIO:</label>                        
                <input type="time" name="v_horainicial" class="form-control" id="v_horainicial"
                        value="<?php echo $obj->horainicial; ?>">                        
            </div>

            <div class="col-md-3" style="float: left;">
                    <label>HORA DE FIN:</label>
                <input type="time" name="v_horafinal" class="form-control" id="v_horafinal"
                    value="<?php echo $obj->horafinal; ?>">
            </div>
            <div class="col-md-12" style="float: left;margin-top: 1em;">
            <label class="col-md-12 card-header" style="padding-left: 0.45rem;">OPCIONES POR COMPRA:</label>
            </div>
            <div class="col-md-6" style="float: left;margin-top: 1em;">
                <label>MONTO TOTAL MÍNIMO DE COMPRA:</label>
                <div class="input-group mb-3">
                            
                    <input type="text" class="form-control" id="v_montocompra" name="v_montocompra" 
                           pattern="^([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$" value="" title="MONTO COMPRA" placeholder="$">
                    <div class="invalid-feedback">Ingresa un monto entero o decimal con dos digitos. Ejemplos: 100 | 100.50 </div>
                </div>
            </div>
            
            <div class="col-md-6" style="float: left;margin-top: 1em;">
                <label >CANTIDAD MÍNIMA DE PAQUETES POR COMPRA:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_cantidadcompra" name="v_cabtidadcompra" pattern="^[0-9]+$"
                           value="" title="CANTIDAD PAQUETES" >
                    <div class="invalid-feedback">Ingresa una cantidad (solo números)</div>
                </div>
            </div>
            <div class="col-md-6" style="float: left;">
                <label >POR SECUENCIA DE VENTAS:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_secuenciaventa" name="v_secuenciaventa" pattern="(\d+)(,\s*\d+)*"
                           value="" maxlength="25" title="CANTIDAD VENTAS" >
                    <div class="invalid-feedback">Ingrese una listado (números separados por coma) Ejemplo: 5, 10, 15  </div>
                </div>
            </div>
            <div class="col-md-6" style="float: left;margin-bottom: 0.5em;">
                <label> APLICA PARA PAQUETE EN PROMOCIÓN:</label>
                <input type="checkbox" id="v_aplicarsobrepromo"  name="v_aplicarsobrepromo"  value="<?php ?>" title="SOBRE PROMOCIÓN">
            </div>

            <div class="col-md-12" style="float: left;margin-bottom: 1em;">
            <label class="col-md-12 card-header" style="padding-left: 0.45rem;">LIMITE DE USOS:</label>
            </div>
            <div class="col-md-2" style="float: left;">
                <label >POR CLIENTE:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_lusocliente" name="v_lusocliente" pattern="^[0-9]+$"
                           value="" title="POR CLIENTE" >
                    <div class="invalid-feedback">Ingresa una cantidad (solo números)</div>
                </div>
            </div>
            <div class="col-md-2" style="float: left;">
                <label >POR DÍA:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_lusodia" name="v_lusodia" pattern="^[0-9]+$"
                           value="" title="POR DESCUENTO" >
                    <div class="invalid-feedback">Ingresa una cantidad (solo números)</div>
                </div>
            </div>

            <div class="col-md-2" style="float: left;">
                <label >POR SUCURSAL:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_lusosucursal" name="v_lusosucursal" pattern="^[0-9]+$"
                           value="" title="POR SUCURSAL" >
                    <div class="invalid-feedback">Ingresa una cantidad (solo números)</div>
                </div>
            </div>  
            <div class="col-md-2" style="float: left;">
                <label >POR USOS TOTALES:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="v_lusototal" name="v_lusototal" pattern="^[0-9]+$"
                           value="" title="POR USO TOTAL" >
                    <div class="invalid-feedback">Ingresa una cantidad (solo números)</div>
                </div>
            </div>                     
        </div>
    </div><!--card-OPC-->

</form>


<script>
validateForm();
validateFormBAK(<?php echo$idmenumodulo ?>);
getCode();
selectD()
</script>
