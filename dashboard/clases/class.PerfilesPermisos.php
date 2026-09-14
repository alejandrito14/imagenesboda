<?php
class PerfilesPermisos
{
	public $db;//obejto de la clase de coneccion
	
	//varibles de guardado
	public $perfil;//nombre del perfil
	public $estatus;//estatus del perfil
	public $idperfiles;//id del perfil para poder realizar la modificacion
	
	public $ultimoperfil;//ultimo id del perfil
	public $idmenu;//id del menu para guardar la relacion  del menu con el perfil
	
	//funcion para dar de alta el perfil
	public function GuardarNewPerfil()
	{
		 $query_up="INSERT INTO perfiles(perfil,estatus)VALUES('$this->perfil',$this->estatus)";
		$result=$this->db->consulta($query_up);
		$this->ultimoperfil=$this->db->id_ultimo();
	}
	
	//funcion para modificar el perfil
	public function ModificarPerfil()
	{
		$query="UPDATE perfiles SET perfil='$this->perfil', estatus=$this->estatus WHERE idperfiles=$this->idperfiles";
		$this->db->consulta($query);
	}
	
	//funcion de guardado de los permisos
	public function Perfiles_Permisos($permiso,$insertar,$modificar,$borrar)
	{
		 $query_menu="INSERT INTO perfiles_permisos(idperfiles,idmodulos_menu,insertar,modificar,borrar)VALUES($this->ultimoperfil,$permiso,$insertar,$modificar,$borrar)";
		$resp =$this->db->consulta($query_menu);			
		$this->db->liberar($resp);
	}
	
	//funcion para borrar los permisos de un perfil
	public function EliminarPermisos()
	{
		$query="DELETE FROM perfiles_permisos WHERE idperfiles=".$this->idperfiles;//query para borrar los permisos existentes de perfil
		$resp=$this->db->consulta($query);
	}
	
	//funcion para obtener la informacion de in perfil
	public function ObtenerInfoPerfil()
	{
		$query="SELECT * FROM perfiles WHERE idperfiles=$this->idperfiles";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total=$this->db->num_rows($resp);
		
		if($total!=0)
		{
			return $rows;
		}
		else
		{
			return 0;
		}
	}
	
	//funcion para armar una cadena con todos lo menus a los que tiene permiso un perfil
	public function ObtenerMenusPerfil()
	{
		//sacando permisos ya colocados
		$per ="SELECT * FROM perfiles_permisos WHERE idperfiles=$this->idperfiles";
		$result= $this->db->consulta($per);
		$row =$this->db->fetch_assoc($result);
		$totalper = $this->db->num_rows($result);
		
		$cadena=array();
		if($totalper==0)
		{
			$cadena=0;
		}
		else
		{
			do
			{
				$cadena[]=$row['idmodulos_menu']."|".$row['insertar']."|".$row['modificar']."|".$row['borrar'];
			}while($row =$this->db->fetch_assoc($result));
		}
		
		return $cadena;
	}
}
?>