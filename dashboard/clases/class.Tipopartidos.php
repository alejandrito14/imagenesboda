<?php
class Tipopartidos
{
	public $db;//objeto de la clase de conexcion
	
	public $idtipopartido;//
	public $nombre;
	public $estatus;
	public $numeroset;
	public $tipo_usuario;
	public $lista_empresas;
	public function ObtenerTodosTipospartidos()
	{
		$query="SELECT * FROM tipopartido ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerTipospartidos()
	{
		$query="SELECT * FROM tipopartido WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function GuardarTipopartido()
	{
		$query="INSERT INTO tipopartido (nombre,estatus,numerosets) VALUES ('$this->nombre','$this->estatus','$this->numeroset')";
		
		$resp=$this->db->consulta($query);
		$this->idtipopartido = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function ModificarTipopartido()
	{
		$query="UPDATE tipopartido SET nombre='$this->nombre',
		estatus='$this->estatus',numerosets='$this->numeroset' WHERE idtipopartido=$this->idtipopartido";
	
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarTipopartido()
	{
		$query="SELECT * FROM tipopartido WHERE idtipopartido=".$this->idtipopartido;
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
}
?>