<?php
class Partidos
{
	public $db;//objeto de la clase de conexcion
	public $idpartido;
	public $nombre;
	public $idespacio;
	public $idhorario;
	public $estatus;

	public $tipo_usuario;
	public $lista_empresas;

	public function ObtenerTodospartidos()
	{
		$query="SELECT * FROM partido ";
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerPartidos()
	{
		$query="SELECT * FROM partido WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarpartido()
	{
		$query="INSERT INTO partido (nombre,idespacio,idhorario,estatus) VALUES ('$this->nombre','$this->idespacio','$this->idhorario','$this->estatus','$this->estatus')";
		
		
		$resp=$this->db->consulta($query);
		$this->idpartido = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarpartido()
	{
		$query="UPDATE partido SET nombre='$this->nombre',
		idespacio='$this->idespacio',
		idhorario='$this->idhorario',
		estatus='$this->estatus'
		WHERE idpartido=$this->idpartido";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarpartido()
	{
		$query="SELECT * FROM partido WHERE idpartido=".$this->idpartido;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>