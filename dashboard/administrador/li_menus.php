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
require_once("../clases/class.ModulosMenu.php");

$db= new MySQL();
$pag= new Paginas();

$mm= new ModulosMenu();
$mm->db=$db;
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
	//sacando los menus del sistema
	$queryMenu="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM  modulos_menu";
	$respmenu=$db->consulta($queryMenu);
	$rowsmenu=$db->fetch_assoc($respmenu);
	$totalmenu=$db->num_rows($respmenu);
	
	$total_paginas = ceil($total / $limiteRegistros);
	
	$queryMenu="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM  modulos_menu LIMIT $inicio,$limiteRegistros";
	$respmenu=$db->consulta($queryMenu);
	$rowsmenu=$db->fetch_assoc($respmenu);
	$totalmenu=$db->num_rows($respmenu);


 if($total==0)
		{?>
        <h4 class="alert_warning">No Existen Menus  en la base de datos</h4>
        <br />
        <?php
		}else{?>
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID MENU</th>
                    <th>MODULO</th>
    				<th>MENU</th>
                    <th>ARCHIVO</th>
                    <th>UBICACI&Oacute;N</th>
    				<th>ESTATUS</th> 
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
            <?php do{?>
				<tr> 
   					<td><?php echo $rowsmenu['idmodulos_menu'];?></td> 
                    <td><?php $mm->idmodulo=$rowsmenu['idmodulos']; $datos=$mm->ObtenerInfoModulo(); echo $datos['modulo'];?></td>
    				<td><?php echo $rowsmenu['menu'];?></td> 
                    <td><?php echo $rowsmenu['archivo'];?></td> 
                    <td><?php echo $rowsmenu['ubicacion_archivo'];?></td> 
    				<td><?php echo $rowsmenu['est'];?></td> 
    				<td><input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('administrador/fc_perfiles.php?id=<?php echo $rows['idusuarios'];?>','main')">
                    	<input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarUsuario('<?php echo $rows['idusuarios'];?>')">
                    </td> 
				</tr>
            <?php }while($rowsmenu=$db->fetch_assoc($respmenu));?>
            	<tr>
                	<td colspan="9">
                    <?php
		
	//paginacion 
	/*-----------------------------------------------*/
	$pag->LimitePaginas=5;
	$pag->div_cargar="li_menus";
	$pag->pagina="administrador/li_menus.php";
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