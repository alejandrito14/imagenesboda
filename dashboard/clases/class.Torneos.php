<?php
class Torneos
{
	public $db;//objeto de la clase de conexcion
	
	public $idtorneo;
	public $nombre;
	public $estatus;
	public $costo;
	public $fechainicial;
	public $fechafinal;
	public $tipo_usuario;
	public $lista_empresas;

	public function ObtenerTodosTorneos()
	{
		$query="SELECT * FROM torneo";
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}
	
	
	public function ObtenerTorneosActivos()
	{
		$query="SELECT * FROM torneo WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function GuardarTorneo()
	{
		$query="INSERT INTO torneo (nombre,costo,fechainicial,fechafinal,estatus) VALUES ('$this->nombre','$this->costo','$this->fechainicial','$this->fechafinal','$this->estatus')";
		
		$resp=$this->db->consulta($query);
		$this->idtorneo = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function ModificarTorneo()
	{
		$query="UPDATE torneo SET nombre='$this->nombre',
		costo='$this->costo',
		fechainicial='$this->fechainicial',
		fechafinal='$this->fechafinal',
		estatus='$this->estatus' WHERE idtorneo=$this->idtorneo";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarTorneo()
	{
		$query="SELECT * FROM torneo WHERE idtorneo=".$this->idtorneo;
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>