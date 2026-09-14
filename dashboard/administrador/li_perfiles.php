<?php
// header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Paginas.php");

$db= new MySQL();
$pag= new Paginas();
//paginacion 
/*----------------------------------------------------------------------------*/
$limiteRegistros=20;
if (!isset($_GET['pagina']))
{	$paginas = 0;}
else
{   $paginas=$_GET['pagina'];}

if ($paginas == 0) 
{ 	$inicio = 0; $paginas = 1; } 
else 
{ 	$inicio = ($paginas - 1) * $limiteRegistros; }
/*---------------------------------------------------------------------------------*/

$query="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM perfiles";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

$total_paginas = ceil($total / $limiteRegistros);

$query="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM perfiles LIMIT $inicio,$limiteRegistros";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	
	echo $msj;
}

 if($total==0)
		{?>
        <h4 class="alert_warning">No Existen Perfiles en la base de datos</h4>
        <br />
        <?php
		}else{?>
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID PERFIL</th> 
    				<th>PERFIL</th> 
    				<th>ESTATUS</th> 
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
            <?php do{?>
				<tr> 
   					<td><?php echo $rows['idperfiles'];?></td> 
    				<td><?php echo $rows['perfil'];?></td> 
    				<td><?php echo $rows['est'];?></td> 
    				<td>
                    	<input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('administrador/fc_perfiles.php?id=<?php echo $rows['idperfiles'];?>','main')">
                    	<input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarUsuario('<?php echo $rows['idusuarios'];?>')">
                    </td> 
				</tr>
            <?php }while($rows=$db->fetch_assoc($resp));?>
            	<tr>
                	<td colspan="9">
                    <?php
		
	//paginacion 
	/*-----------------------------------------------*/
	$pag->LimitePaginas=5;
	$pag->div_cargar="li_perfiles";
	$pag->pagina="administrador/li_perfiles.php";
	$pag->PaginaActual=$paginas;
	$pag->totalPaginas=$total_paginas;
	$pag->parametros="";
	
	echo '<ul class="tabs">';
	echo  $pag->LinkPagSencillo();
	echo '</ul>';
	/*-----------------------------------------------*/
		?>
		
                    </td>
                </tr>
			</tbody> 
			</table>
	<?php	}?>
        