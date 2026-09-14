<?php
class Tipojuego
{
	public $db;//objeto de la clase de conexcion
	public $idtipojuego;
	public $nombre;
	public $numerocontendiente;
	public $numeroadversario;
	public $estatus;

	public $tipo_usuario;
	public $lista_empresas;

	public function ObtenerTodostipojuego()
	{
		$query="SELECT * FROM tipojuego ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenertipojuego()
	{
		$query="SELECT * FROM tipojuego WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardartipojuego()
	{
		$query="INSERT INTO tipojuego (nombre,numerocontendientes,numeroadversarios,estatus) VALUES ('$this->nombre','$this->numerocontendiente','$this->numeroadversario','$this->estatus')";
		
		
		$resp=$this->db->consulta($query);
		$this->idtipojuego = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificartipojuego()
	{
		$query="UPDATE tipojuego SET 
		nombre='$this->nombre',
		numerocontendientes='$this->numerocontendiente',
		numeroadversarios='$this->numeroadversario',
		estatus='$this->estatus'
		WHERE idtipojuego=$this->idtipojuego";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscartipojuego()
	{
		$query="SELECT * FROM tipojuego WHERE idtipojuego=".$this->idtipojuego;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>