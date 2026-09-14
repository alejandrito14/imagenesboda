<?php

class Precios

{

	public $db;//objeto de la clase de conexcion

	

	public $idprecio;
	public $nombre;
	public $estatus;
	public $principal;
	
	
	//Funcion para obtener todos los niveles activos
	public function ObtprecioActivos()
	{
		$sql = "SELECT * FROM precio WHERE estatus = 1";
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


	public function ObtenerTodosPrecios()
	{
		$sql = "SELECT * FROM precio";

		$resp=$this->db->consulta($sql);
		
		return $resp;
	}
	

	public function Obtenerprecio()
	{
		$sql = "SELECT * FROM precio WHERE idprecio='$this->idprecio'";
	
		$resp=$this->db->consulta($sql);
		
		return $resp;
	}


	public function Guardarprecio()
	{
		$query="INSERT INTO precio (precio,estatus) VALUES ('$this->nombre','$this->estatus')";
		
		$resp=$this->db->consulta($query);
		$this->idespacio = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarprecio()
	{
		$query="UPDATE precio SET precio='$this->nombre',
		estatus='$this->estatus',
		principal='$this->principal'
		 WHERE idprecio=$this->idprecio";
	
		$resp=$this->db->consulta($query);
	}

	public function Actualizarpincipal()
	{

		$query="UPDATE precio SET principal=0";
	
		$resp=$this->db->consulta($query);

		$query="UPDATE precio SET principal=1 WHERE idprecio=$this->idprecio";
	
		$resp=$this->db->consulta($query);
	}
	

}

?>