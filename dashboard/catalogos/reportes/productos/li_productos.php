<?php

/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../../clases/class.Sesion.php");
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
require_once("../../../clases/conexcion.php");
require_once("../../../clases/class.Reportes.php");
require_once("../../../clases/class.Funciones.php");
require_once("../../../clases/class.Botones.php");

//Se crean los objetos de clase
$db = new MySQL();
$rpt = new Reportes();
$f = new Funciones();
$bt = new Botones_permisos();

$rpt->db = $db;

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

//OBTEN4MOS DOS VALORES IMPORATNTS PARA PODER REALIZAR LA CONSULTA ID MPERESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

$idempresa = $_GET['v_idempresa'] ;
$idcategoria = $_GET['v_idcategorias'] ;
$idtipo_presentacion = $_GET['v_idpresentacion'] ;
$idproducto=$_GET['v_idproductos'];
$idstatus=$_GET['v_idstatus'];

//echo "id idproducto: ".$idproducto;
//echo "<br>id idstatus: ".$idstatus;

?>

<div class="row">

	<div class="col-md-12"> 
	<div style="text-align: right">	
	<a class="btn btn-primary" title="Reporte" onClick="rpt_excel_productos(1);" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>	
		</div>	

   <?php
	$tipousaurio = $_SESSION['se_sas_Tipo'];  //variables de sesion
    $lista_empresas = $_SESSION['se_liempresas']; //variables de sesion

    if($tipousaurio != 0)
    {
    	if($idempresa == 0)
    	{
    		$id_empresa ="AND idempresas IN ($lista_empresas)" ;
    	}else
    	{
    		$id_empresa = "AND idempresas IN ($idempresa)";
    	}
    }else
    {
    	if($idempresa == 0)
    	{
    		$id_empresa =" " ;
    	}else
    	{
    		$id_empresa = "AND idempresas IN ($idempresa)";
    	}
    }

        // SI EXISTE UN ID PRODUCTO
        if($idproducto!='0')
        {
            $qry_idproducto = " AND productos.idproducto = '$idproducto' ";

        }else
        { 
            $qry_idproducto = "";

        }// SI EXISTE UN ID ESTATUS
        if($idstatus!=9)
        {
            $qry_idstatus = " AND productos.estatus =  $idstatus ";

        }else
        { 
            $qry_idstatus = "";
        }


    $sql_empresas = " SELECT *  FROM empresas 
    WHERE 1=1
    $id_empresa
    ORDER BY idempresas";

    $sql_empresas_result = $db->consulta($sql_empresas);
    $sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
    $sql_empresas_num = $db->num_rows($sql_empresas_result);
    $flagi=0;
    do
    {
        $flagi++;
    	?>	
    	<br>
    	<h3>EMPRESA: <?php echo $sql_empresas_row['empresas'];?></h3>			

    	<?php

	   //obtenemos la categoria a buscar	

    	if($idcategoria != 0)
    	{
    		$id_categoria = " AND productos.idcategorias = $idcategoria";
			if($idtipo_presentacion!=0)
			{
				$id_categoria= $id_categoria." AND productos.idtipo_presentacion = $idtipo_presentacion";
			}
    	}
    	else
    	{
    		$id_categoria = " ";
    	}

    	//$idproductos_ciclo = $sql_empresas_row['idempresas'];
        /*
    	$sql_sucursales = "SELECT *
    	FROM
    	sucursales s
    	WHERE
    	s.idempresas = '$idempresas_ciclo' $id_sucursal";

    	$result_sucursales = $db->consulta($sql_sucursales);
    	$result_sucursales_row = $db->fetch_assoc($result_sucursales);
        */


       $qry="SELECT
productos.*,
empresas.empresas,
categorias.categoria AS nom_categoria,
tipo_presentacion.nombre as nom_tipo_presentacion
FROM
productos
INNER JOIN empresas ON productos.idempresas = empresas.idempresas
LEFT JOIN tipo_presentacion ON tipo_presentacion.idtipo_presentacion = productos.idtipo_presentacion
LEFT JOIN categorias ON categorias.idempresas = empresas.idempresas AND productos.idcategorias = categorias.idcategorias
WHERE productos.idempresas =  '". $sql_empresas_row['idempresas']."' $id_categoria $qry_idproducto $qry_idstatus";

//echo $qry;

    $sql_result = $db->consulta($qry);
    $result_row = $db->fetch_assoc($sql_result);
    $result_num = $db->num_rows($sql_result);

    	/*
        do
    	{
*/
    		?>
		
    		<table class="table table-striped table-bordered" id="tbl_empresas<?php echo $flagi;?>" cellpadding="0" cellspacing="0" style="overflow: auto">
    			<thead class="thead-dark">
    				<tr style="text-align: center">
    					<th>NUM</th> 
                        <th>ID</th> 
    					<th>EMPRESA</th> 
                        <th>NOMBRE</th> 
                        <th>DESCRIPCI&Oacute;N</th>
    					<th>FAMILIA</th> 
                        <th>TIPO PRESENTACI&Oacute;N</th> 
    					<th>ESTATUS</th>
    					<th>REPORTE</th>
    				</tr>
    			</thead>

    			<tbody>
    				<?php
    				if($result_num == 0){
    					?>
    					<tr> 
    						<td colspan="9" style="text-align: center">
    							<h5 class="alert_warning">NO EXISTEN PRODUCTOS EN LA BASE DE DATOS.</h5>
    						</td>
    					</tr>
    					<?php
    				}else{
                        $num=0;
    					do
    					{
                            $num++;
    						?>
    						<tr onClick="f_toogle('<?php echo $sql_empresas_row['idempresas'].$result_row['idproducto']; ?>');" style="cursor: pointer;">
    							<td style="text-align: center;"><?php echo $num; ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($result_row['idproducto']); ?></td>
    							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_row['empresas']));?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_row['nombre'])); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_row['descripcion'])); ?></td>
    							<td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_row['nom_categoria'])); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($result_row['nom_tipo_presentacion'])); ?></td>    							
    							<td style="text-align: center;"><?php echo $t_estatus[$result_row['estatus']]; ?></td>
    							<td style="text-align: center; font-size: 15px;">
									
									<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" onclick="rpt_excel_productos_id('<?php echo $sql_empresas_row['idempresas']; ?>','<?php echo $result_row['idproducto']; ?>')" ></i>							
    							</td>
    						</tr>

<!-- Inicia la tabla segundo nivel -->
                                <tr id="<?php echo $sql_empresas_row['idempresas'].$result_row['idproducto']; ?>" style="background-color: #fff; display: none;">
                            <th colspan="9" align="center" style="text-align: center; color: #000;" >

                                <table width="100%" border="1" id="otra" class="table table-striped table-bordered">
                                    <tbody>
                                        <tr style="background-color: #b3afaf; font-weight: bold">
                                            <td colspan="9">DETALLE DE INSUMOS</td>
                                        </tr>   
                                        <tr style="background-color: #DCDADA; font-weight: bold">
                                            <td align="center" >C&Oacute;DIGO</td>
                                            <td align="center" >NOMBRE INSUMO</td>
                                            <td align="center" >CANTIDAD</td>
                                            <td align="center" >MEDIDA</td> 
                                            <td align="center" >PESO EN KG</td>                                            
                                        </tr>

                                        <?php                                       

                                        //CONSULTA DE LAS SALIDAS CON DETALLES SEGUN EMPRESA, SUCURSAL E ID INSUMO, FILTRO FECHA ETC.
                                        $qry_salida_detalles = " SELECT pd.*,
                                            i.nombre AS nombre_insumo, 
                                            tm.nombre AS nombre_tipomedida
                                            FROM productos_descripcion AS pd
                                            INNER JOIN insumos i ON i.idinsumos = pd.idinsumos AND i.idempresas = '".$sql_empresas_row['idempresas']."'  
                                            LEFT JOIN tipo_medida tm ON tm.idtipo_medida = i.idtipo_medida
                                            WHERE pd.idproducto = '".$result_row['idproducto']."' AND pd.idempresas = '".$sql_empresas_row['idempresas']."'  ";

                                        //echo $qry_salida_detalles;

                                        $result_salida_detalles = $db->consulta($qry_salida_detalles);
                                        $result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles);
                                        $result_salida_detalles_num = $db->num_rows($result_salida_detalles);
                                        $total=0;

                                        do{

                                            if($result_salida_detalles_num==0)
                                            {
                                                ?>
                                                <tr> 
                                                    <td colspan="5" style="text-align: center; ">
                                                        <h5 class="alert_warning">NO EXISTEN DETALLES DE INSUMOS.</h5>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            else
                                            {
                                                $medida = $f->imprimir_cadena_utf8($f->mayus($result_salida_detalles_row['nombre_tipomedida']));
                                            ?>
                                            <tr style="color: #000;">
                                                <td><?php echo $result_salida_detalles_row['idinsumos']; ?></td> 
                                                <td><?php echo $f->imprimir_cadena_utf8($f->mayus($result_salida_detalles_row['nombre_insumo'])); ?></td>
                                                <td><?php echo $result_salida_detalles_row['cantidad']; ?></td>
                                                <td><?php echo $result_salida_detalles_row['medida'] ." ".$medida; ?></td> 
                                                <td><?php echo $result_salida_detalles_row['subtotalmedida'] ." ".$medida;; ?></td>
                                                
                                            </tr> 
                                            <?php
                                            } // else 

                                            ?>

                                        <?php
                                        }while($result_salida_detalles_row = $db->fetch_assoc($result_salida_detalles)); //terminamos el while de las salidas con detalles por id insumos etc..
                                        ?>
                                      
                                    </tbody>
                                </table>
                            </th>
                        </tr>



<!-- termina la tabla segundo nivel -->

    						<?php
    					}while($result_row = $db->fetch_assoc($sql_result));
    				}
    				?>
    			</tbody>
    		</table>

    		<?php
	   //}while($result_sucursales_row = $db->fetch_assoc($result_sucursales)); //tyerminamos el while de sucursales por empresa

	}while($sql_empresas_row = $db->fetch_assoc($sql_empresas_result));	 //temrinamos el while de mpersas.
	?>	
	
</div>

</div>

