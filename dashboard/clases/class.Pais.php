<?php
class Paises
{
	public $db;//objeto de la clase de conexcion
	
	public $id_pais;//identificador del pais
	public $pais;//nombre del pais
	
	
	public function ObtenerPaices()
	{
		$query="SELECT * FROM pais ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function GuardarPais()
	{
		$query="INSERT INTO pais (pais) VALUES ('$this->pais')";
		
		$resp=$this->db->consulta($query);
		$this->id_pais = $this->db->id_ultimo();
		
		
		
	}
	//funcion para modificar los usuarios
	public function ModificarPais()
	{
		$query="UPDATE pais SET pais='$this->pais' WHERE idpais=$this->id_pais";
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function ObtenerDatosPais()
	{
		$query="SELECT * FROM pais WHERE idpais=".$this->id_pais;
		
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>