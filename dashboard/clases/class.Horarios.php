<?php
class Horarios
{
	public $db;//objeto de la clase de conexcion
	public $idhorario;
	public $dia;
	public $mes;
	public $anio;
	public $hora;
	public $estatus;
	public $tipo_usuario;
	public $lista_empresas;
	public function ObtenerTodosHorarios()
	{
		$query="SELECT * FROM horario ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerHorarios()
	{
		$query="SELECT * FROM horario WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarhorario()
	{
		$query="INSERT INTO horario (dia,mes,anio,hora,estatus) VALUES ('$this->dia','$this->mes','$this->anio','$this->hora','$this->estatus')";
		
		
		$resp=$this->db->consulta($query);
		$this->idhorario = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarhorario()
	{
		$query="UPDATE horario SET dia='$this->dia',
		mes='$this->mes',
		anio='$this->anio',
		hora='$this->hora',
		estatus='$this->estatus'
		WHERE idhorario=$this->idhorario";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarhorario()
	{
		$query="SELECT * FROM horario WHERE idhorario=".$this->idhorario;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>