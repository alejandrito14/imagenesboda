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

$query="SELECT usuarios.idusuarios, 
	usuarios.idperfiles, 
	usuarios.nombre, 
	usuarios.paterno, 
	usuarios.materno, 
	usuarios.telefono, 
	usuarios.celular, 
	usuarios.email, 
	usuarios.usuario, 
	usuarios.clave, 
	usuarios.estatus,
	IF(usuarios.estatus,'Activo','Inactivo')AS est,
	perfiles.perfil
FROM perfiles INNER JOIN usuarios ON perfiles.idperfiles = usuarios.idperfiles ";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

$total_paginas = ceil($total / $limiteRegistros);

$query="SELECT usuarios.idusuarios, 
	usuarios.idperfiles, 
	usuarios.nombre, 
	usuarios.paterno, 
	usuarios.materno, 
	usuarios.telefono, 
	usuarios.celular, 
	usuarios.email, 
	usuarios.usuario, 
	usuarios.clave, 
	usuarios.estatus, 
	IF(usuarios.estatus,'Activo','Inactivo')AS est,
	perfiles.perfil
FROM perfiles INNER JOIN usuarios ON perfiles.idperfiles = usuarios.idperfiles  LIMIT $inicio,$limiteRegistros";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

 if($total==0)
		{?>
        <h4 class="alert_warning">No Existen Usuarios en la base de datos</h4>
        <?php
		}else{?>
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr>
				  	<th>PERFIL</th> 
    				<th>USUARIO</th> 
    				<th>CLAVE</th> 
    				<th>NOMBRE</th> 
    				<th>CELULAR</th>
                    <th>TEL&Eacute;FONO</th> 
                    <th>EMAIL</th>
                    <th>ESTATUS</th>
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
            <?php do{?>
				<tr>
				  	<td><?php echo $rows['perfil'];?></td> 
    				<td><?php echo $rows['usuario'];?></td> 
    				<td><?php echo $rows['clave'];?></td> 
    				<td><?php echo $rows['nombre']." ".$rows['paterno']." ".$rows['materno'];?></td>
                    <td><?php echo $rows['celular'];?></td>
                    <td><?php echo $rows['telefono'];?></td>
                    <td><?php echo $rows['email'];?></td>
                    <td><?php echo $rows['est'];?></td> 
    				<td><input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('administrador/fc_usuarios.php?id=<?php echo $rows['idempresasusuarios'];?>','main')">
                    	<input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarDatos('<?php echo $rows['idusuarios'];?>','idusuarios','usuarios','n','administrador/vi_usuarios.php','main')">

                    	<button onclick="AsignarEmpresas();" class="btn btn-primary"><i class="mdi mdi-clipboard-check"></i></button>
                    </td> 
				</tr>
            <?php }while($rows=$db->fetch_assoc($resp));?>
            
            <tr>
                	<td colspan="9">
                    <?php
		
	//paginacion 
	/*-----------------------------------------------*/
	$pag->LimitePaginas=5;
	$pag->div_cargar="li_usuarios";
	$pag->pagina="empresas/li_usuarios.php";
	$pag->PaginaActual=$paginas;
	$pag->totalPaginas=$total_paginas;
	$pag->parametros="";
	
	echo '<ul class="tabs">';
	echo  $pag->LinkPagSencillo();
	echo '</ul>';
	/*-----------------------------------------------*/
		
		
		}?>
                    </td>
                </tr>
			</tbody> 
			</table>
        <div class="clear"></div>