<?php

class Niveles

{

	public $db;//objeto de la clase de conexcion

	

	public $idnivel;
	public $nombre;
	public $estatus;
	
	
	//Funcion para obtener todos los niveles activos
	public function ObtNivelesActivos()
	{
		$sql = "SELECT * FROM nivel WHERE estatus = 1";
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

	public function ObtenerTodosniveles()
	{
		$query="SELECT * FROM nivel ";
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenerniveles()
	{
		$query="SELECT * FROM nivel WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarnivel()
	{
		$query="INSERT INTO nivel (nivel,estatus) VALUES ('$this->nombre','$this->estatus')";
		
		$resp=$this->db->consulta($query);
		$this->idnivel = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarnivel()
	{
		$query="UPDATE nivel SET nivel='$this->nombre',
		estatus='$this->estatus'
		WHERE idnivel=$this->idnivel";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarnivel()
	{
		$query="SELECT * FROM nivel WHERE idnivel=".$this->idnivel;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	


	

}

?>