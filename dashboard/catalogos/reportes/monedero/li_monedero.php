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
$t_tipo = array('CARGO','ABONO');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_erp'])){
                        //Nombre de sesion | pag-idmodulos_menu
    $permisos = $_SESSION['permisos_acciones_erp']['pag-'.$idmenumodulo];   
}else{
    $permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

//OBTEN4MOS DOS VALORES IMPORATNTS PARA PODER REALIZAR LA CONSULTA ID MPERESA Y LA SUCURSAL PUEDEN SER 0 AMBAS = A TODAS

$idempresa = $_GET['v_idempresa'];
$nombre = $_GET['v_nombre'];
$paterno = $_GET['v_paterno'];
$materno = $_GET['v_materno'];
//$idcategoria = $_GET['v_idmedidas'] ;

//echo "id empresa: ".$idempresa;
//echo "<>id categoria: ".$idcategoria;
?>

<div class="row">

    <div class="col-md-12"> 
    <div style="text-align: right"> 
    <a class="btn btn-primary" title="Reporte" onClick="rpt_excel_monedero();" style="margin-top: 5px; color: #ffffff"><i class="mdi mdi-account-search"></i>  REPORTE EXCEL</a>   
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

    $sql_empresas = " SELECT *  FROM empresas 
    WHERE 1=1
    $id_empresa
    ORDER BY idempresas";

    $sql_empresas_result = $db->consulta($sql_empresas);
    $sql_empresas_row = $db->fetch_assoc($sql_empresas_result);
    $sql_empresas_num = $db->num_rows($sql_empresas_result);
    $i=0;
	// iniciamos primer while de la empresa	
	do
	{   
    $i++;
    
    ?> 

        <br>
        <h3>EMPRESA: <?php echo $sql_empresas_row['empresas']; ?> </h3>          

        
            <table class="table table-striped table-bordered" id="tbl_tabla<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="overflow: auto">
                <thead class="thead-dark">
                    <tr style="text-align: center">
                        <th>No. DE CLIENTE</th> 
                        <th>NOMBRE</th> 
                        <th>APELLIDO PATERNO</th> 
                        <th>APELLIDO MATERNO</th> 
                        <th>FOLIO ADMIN PACK</th> 
                        <th>SALDO AL MONEDERO</th>                    
                        <th>REPORTE</th>
                    </tr>
                </thead>

                <tbody>
					
				<?php
					$sql_clientes="SELECT
						clientes.idcliente,
						clientes.no_cliente,
						clientes.nombre,
						clientes.paterno,
						clientes.materno,
						clientes.estatus,
						clientes.saldo_monedero,
						clientes.idempresas,
						empresas.empresas,
                        clientes.folio_adminpack
						FROM
						clientes
						INNER JOIN empresas ON clientes.idempresas = empresas.idempresas
						WHERE
						clientes.idempresas = '".$sql_empresas_row['idempresas']."' AND
                        clientes.nombre LIKE '%$nombre%'AND
                        clientes.paterno LIKE '%$paterno%'AND
                        clientes.materno LIKE '%$materno%' ORDER BY clientes.saldo_monedero ASC ";

                        //echo $sql_clientes;
	
						    $sql_clientes_result = $db->consulta($sql_clientes);
    						$sql_clientes_row = $db->fetch_assoc($sql_clientes_result);
    						$sql_clientes_num = $db->num_rows($sql_clientes_result);

                       $qry_found_vacia="SELECT
                        count(*) as  found
                        FROM
                        clientes
                        WHERE
                        idempresas = '".$sql_empresas_row['idempresas']."' AND clientes.saldo_monedero > 0"; 
                        $sql_vacia_result = $db->consulta($qry_found_vacia);
                        $sql_vacia_row = $db->fetch_assoc($sql_vacia_result);    
					
					if($sql_clientes_num == 0)
					{
				?>	
					<tr> 
    						<td colspan="7" style="text-align: center">
    							<h5 class="alert_warning">NO EXISTEN CLIENTES EN LA BASE DE DATOS.</h5>
    						</td>
    				</tr>
				<?php		
					}
					else{
					       // si en la empresa no se encuentran ningun saldo mayor a cero
                           if($sql_vacia_row['found']==0)
                           {
                                ?>  
                                <tr> 
                                        <td colspan="7" style="text-align: center">
                                            <h5 class="alert_warning">NO EXISTEN SALDOS AL MONEDERO DIFERENTES DE CERO.</h5>
                                        </td>
                                </tr>
                               <?php   

                           }
                          else
                          {
                           // caso contrario si hay saldo al monedero mayor que cero se muestran los registros

						$num=0;
						do
						{

                            if($sql_clientes_row['saldo_monedero']!=0)
                            { 
                            $num++;   
		
				?>	
                           
                            <tr onClick="f_toogle(<?php echo $sql_clientes_row['idcliente'] ?>);"  style="cursor: pointer;">
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($sql_clientes_row['no_cliente']); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($sql_clientes_row['nombre']));?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($sql_clientes_row['paterno'])); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($sql_clientes_row['materno'])); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($sql_clientes_row['folio_adminpack'])); ?></td>
                                <td style="text-align: center;"><?php echo $f->imprimir_cadena_utf8($f->mayus($sql_clientes_row['saldo_monedero'])); ?></td>   
								<td style="text-align: center; font-size: 15px;">                               
									
									<i class="btn btn-primary mdi mdi-file-excel" style="cursor: pointer" onClick="rpt_excel_monedero_id('<?php echo $sql_empresas_row['idempresas']; ?>','<?php echo $sql_clientes_row['idcliente']; ?>');" ></i>		
									
                              </td>
                            </tr>

                            <?php
                        }
                            ?>

                            <!-- se agrega la siguente tabla  $result_row['idcategoria_precios'] -->
                    <tr id="<?php echo $sql_clientes_row['idcliente'] ?>" style="background-color: #fff; display: none;">
                            <th colspan="7" align="center" style="text-align: center; color: #000;" >
                                                      
                                                      <table width="100%" border="0" class="table table-striped table-bordered">
                                                          <tbody>
                                                            <tr style="background-color: #b3afaf; font-weight: bold;">
                                                                <td colspan="6">HISTORIAL DEL MONEDERO</td>
                                                             </tr>   
                                                            <tr style="background-color: #DCDADA; font-weight: bold;">
                                                              <td align="center" >NUM</td>
                                                              <td align="center" >FECHA</td>
                                                              <td align="center" >TIPO DE MOVIMIENTO</td>
                                                              <td align="center" >MONTO</td>
                                                              <td align="center" >SALDO ACTUAL</td> 
                                                              <td align="center" >NOTA DE REMISI&Oacute;N</td>	
                                                            </tr>
                                                            <?php 

                                                            $qry_hist_monedero="SELECT
                                                                cliente_monedero.*
                                                                FROM
                                                                cliente_monedero
                                                                WHERE
                                                                cliente_monedero.idcliente = '".$sql_clientes_row['idcliente']."' ";

                                                            $result_hist  = $db->consulta($qry_hist_monedero);
                                                            $result_hist_row = $db->fetch_assoc($result_hist);
                                                            $numr=0;

                                                            do
                                                            {
                                                            $numr++; 
                                                            $fecha = date("d-m-Y H:i:s",strtotime($result_hist_row['fecha']));

                                                            ?>

                                                            <tr style="color: #000;">
                                                              <td><?php echo $f->imprimir_cadena_utf8($numr); ?></td> 
                                                              <td><?php echo $f->imprimir_cadena_utf8($fecha); ?></td>
                                                               <td><?php echo $t_tipo[$result_hist_row['tipo']]; ?></td>
                                                              <td><?php echo $result_hist_row['monto']; ?></td>
                                                              <td><?php echo $f->imprimir_cadena_utf8($result_hist_row['saldo_act']); ?></td> 
                                                               <td><?php echo $f->imprimir_cadena_utf8($result_hist_row['idnota_remision']); ?></td>																
                                                            </tr>
                                                            <?php
                                                            }while($result_hist_row = $db->fetch_assoc($result_hist));
                                                                
                                                            ?>
                                                          </tbody>
                                                    </table>
                                                </td>
                                              </tr>  

					<?php
						}while($sql_clientes_row = $db->fetch_assoc($sql_clientes_result));	 //terminamos el segundo while de clientes.
                    } // si no hay monederos mayor a cero
					}// SI esta vacio de clientes
               		?>
                 
                </tbody>
            </table>

 <script type="text/javascript">
    $('#tbl_tabla<?php echo $i;?>').DataTable( {     
        "pageLength": 100,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ ",
            "sZeroRecords": "NO EXISTEN EMPRESAS EN LA BASE DE DATOS.",
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
        "ordering": false,
        "info":     false

    } );
</script>
		
	<?php
	   
	}while($sql_empresas_row = $db->fetch_assoc($sql_empresas_result));	 //terminamos el primer while de empersas.
	     
    ?>
</div>

</div>

