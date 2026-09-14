<?php
require_once("class.Funciones.php");
require_once("class.Sesion.php");
class Menu extends Funciones
{   
    public $db;///objeto de la base de datos
    public $idusuario;//id de usuario del cual se va a buscar el menu
	public $idperfil;//id de usuario del cual se va a buscar el menu
    public $idmenu;//id del menu para buscar sus submenus	
	
	private $sesion;	
	
		public function __construct()
	{
		$this->sesion = new Sesion();
	}
	
		
	//funcion para armar el menu principal	
	public function ArmarMenu()
	{
		$menu="";
		$query_modulos="SELECT modulo, idmodulos, estatus,icono as iconomodulo FROM modulos WHERE estatus=1 ORDER BY nivel ";
		$result = $this->db->consulta($query_modulos);
	    $rows = $this->db->fetch_assoc($result);
		$total = $this->db->num_rows($result);

		$contador=0;

			
		$menu.='<br>';
					
		
		if($total>0)
		{
			do

			{
				$query_menu="SELECT modulos_menu.menu,modulos_menu.icono as iconomenu,
				modulos_menu.idmodulos_menu,
		modulos_menu.archivo, 
		modulos_menu.ubicacion_archivo, 
		modulos_menu.estatus,
		perfiles_permisos.insertar,
		perfiles_permisos.borrar,
		perfiles_permisos.modificar
	FROM perfiles_permisos INNER JOIN modulos_menu ON perfiles_permisos.idmodulos_menu = modulos_menu.idmodulos_menu
	WHERE modulos_menu.estatus=1 AND perfiles_permisos.idperfiles=$this->idperfil AND modulos_menu.idmodulos=".$rows['idmodulos']." ORDER BY nivel";

				$resp = $this->db->consulta($query_menu);
				$row = $this->db->fetch_assoc($resp);
				$totalRow = $this->db->num_rows($resp);  

				//$_SESSION['menunombre'][$row['idmodulos_menu']]=$row[''];
				//
				if ($rows['iconomodulo']=='') {
					$rows['iconomodulo']='mdi mdi-file';
				}


					if($totalRow>0)
					{
						if ($row['iconomenu']=='') {
							$row['iconomenu']='mdi mdi-note-outline';
						}
						
						
					
					$isDefaultModule = (int) $rows['idmodulos'] === 46;
					$parentClasses = 'sidebar-item clasemenu' . ($isDefaultModule ? ' selected default-open' : '');
					$linkClasses = 'sidebar-link has-arrow waves-effect waves-dark' . ($isDefaultModule ? ' active' : '');
					$submenuClasses = 'collapse first-level' . ($isDefaultModule ? ' in' : '');
					$expanded = $isDefaultModule ? 'true' : 'false';
					$menu.='<li class="'.$parentClasses.'" id="modulo_'.$this->conver_especial(str_replace(' ','_',$rows['modulo'])).'"> <a class="'.$linkClasses.'" href="javascript:void(0)" aria-expanded="'.$expanded.'"><i class="'.$rows['iconomodulo'].'"></i><span style="font-size:12px!important;" class="hide-menu">'.$rows['modulo'].'</span></a>';
					$menu.='<ul aria-expanded="'.$expanded.'" class="'.$submenuClasses.'">';

					/*$menu.='<li class="sidebar-item"></li>';*/

					
					do
					{


						$permisos = $row['insertar']."|".$row['modificar']."|".$row['borrar'];
						
						
						if(!isset($_SESSION['permisos_acciones_erp'])){
							$this->sesion->crearSesion("permisos_acciones_erp",null);
							$_SESSION['permisos_acciones_erp']['pag-'.$row['idmodulos_menu']] = $permisos;
						}else{
							$_SESSION['permisos_acciones_erp']['pag-'.$row['idmodulos_menu']] = $permisos;
						}
						
						
						$ruta=mb_strtoupper('/ '.$rows['modulo']).' / '.$row['menu'].' /';

						$modulo='modulo_'.$this->conver_especial(str_replace(' ','_',$rows['modulo']));

						$menu.='<li class="sidebar-item '.$modulo.' submenu" id="menu_'.$row['idmodulos_menu'].'" ><a  class="sidebar-link"  onClick="aparecermodulos2(\''.$row['ubicacion_archivo'].$row['archivo'].'?idmenumodulo='.$row['idmodulos_menu'].'\',\'main\',\''.$ruta.'\'); return false;" ><i class="mdi mdi-note-outline"></i><span style="font-size:11px!important;" class="hide-menu">'. $row['menu'].'</span></a></li>';

						
					}while($row = $this->db->fetch_assoc($resp));
					
					$menu.='</ul></li>';
				}
				
				$contador++;
			}while($rows = $this->db->fetch_assoc($result));
		}
		else
		{
			$menu.="No existen modulos";
		}
		$menu.='<br ><li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="logout.php" aria-expanded="false"><i class="mdi mdi-exit-to-app" style="font-size:12px;"></i><span class="hide-menu">SALIR</span></a></li>';
		
		return $menu;
	}
} /* end of class Menu */

?>
