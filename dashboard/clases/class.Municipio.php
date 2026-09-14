<?php
class Municipio
{
	public $db;//objeto de la clase de conexcion
	
	public $id_estado;//identificador del estado
	public $id_pais;//identificador del pais
	public $estado;//nombre del estado
	public $descripcion;//descripcion del estado
	
	
	
	public function ObtenerMunicipios($idestado)
	{
		$query="SELECT * FROM municipios WHERE estado_id='$idestado'";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	//funcion para guardar los estados 
	
	public function GuardarEstado()
	{
		$query="INSERT INTO estado (idpais,estado,descripcion) VALUES ($this->id_pais,'$this->estado','$this->descripcion')";
		$resp=$this->db->consulta($query);
		$this->id_estado = $this->db->id_ultimo();
		
		
		
	}
	//funcion para modificar estado
	public function ModificarEstado()
	{
		$query="UPDATE estado SET idpais=$this->id_pais, estado='$this->estado' , descripcion='$this->descripcion'  WHERE idestado=$this->id_estado";
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function ObtenerDatosEstado()
	{
		$query="SELECT * FROM estado WHERE idestado=".$this->id_estado;
		$resp=$this->db->consulta($query);
		
		
		return $resp;
	}

	public function Habilitarparaweb($idmunicipio,$habilitado)
	{
		$query="UPDATE municipios SET  web='$habilitado'   WHERE id=$idmunicipio";
	
	
		$resp=$this->db->consulta($query);
	}
	
	
}
?>