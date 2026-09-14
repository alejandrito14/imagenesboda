<?php

class Posiciones

{

	public $db;//objeto de la clase de conexcion

	

	public $idposicion;
	public $nombre;
	public $estatus;
	
	
	//Funcion para obtener todos los niveles activos
	public function ObtPosicionActivos()
	{
		$sql = "SELECT * FROM posicion WHERE estatus = 1";
		$resp = $this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);



		$array=array();
		$contador=0;

		if ($cont>0) {

			
			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		return $array;
	}


	public function ObtenerTodosposiciones()
	{
		$sql = "SELECT * FROM posicion";

		$resp=$this->db->consulta($sql);
		
		return $resp;
	}
	

	public function ObtenerPosicion()
	{
		$sql = "SELECT * FROM posicion WHERE idposicion='$this->idposicion'";
	
		$resp=$this->db->consulta($sql);
		
		return $resp;
	}


	public function Guardarposicion()
	{
		$query="INSERT INTO posicion (nombre,estatus) VALUES ('$this->nombre','$this->estatus')";
	
		
		$resp=$this->db->consulta($query);
		$this->idespacio = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function ModificarPosicion()
	{
		$query="UPDATE posicion SET nombre='$this->nombre',
		estatus='$this->estatus' WHERE idposicion=$this->idposicion";
	
		$resp=$this->db->consulta($query);
	}
	

}

?>