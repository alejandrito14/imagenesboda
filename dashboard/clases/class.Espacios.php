<?php
class Espacios
{
	public $db;//objeto de la clase de conexcion
	
	public $idespacio;//
	public $nombre;
	public $lugar;
	public $ubicacion;
	public $estatus;
	public $tipo_usuario;
	public $lista_empresas;
	public function ObtenerTodosEspacios()
	{
		$query="SELECT * FROM espacio ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerEspacios()
	{
		$query="SELECT * FROM espacio WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function GuardarEspacio()
	{
		$query="INSERT INTO espacio (nombre,lugar,ubicacion,estatus) VALUES ('$this->nombre','$this->lugar','$this->ubicacion','$this->estatus')";
		
		$resp=$this->db->consulta($query);
		$this->idespacio = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function ModificarEspacio()
	{
		$query="UPDATE espacio SET nombre='$this->nombre',
		lugar='$this->lugar',
		estatus='$this->estatus',
		ubicacion='$this->ubicacion' WHERE idespacio=$this->idespacio";
	
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarEspacio()
	{
		$query="SELECT * FROM espacio WHERE idespacio=".$this->idespacio;
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>