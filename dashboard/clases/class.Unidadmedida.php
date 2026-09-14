<?php
class UnidadMedida
{
	
	public $db;
	
	public $idmedida;
	public $nombre;
	public $medida;
	public $estatus;
	
	//validacione de tipo de usuario
	
	public $tipo_usuario;
	public $lista_empresas;
	

	
		//Funcion que nos regresa los registros de la tabla empresas según el filtro
	public function obtenerFiltro()
	{
		
		 $sql = "SELECT * FROM tipo_medida WHERE 1=1 ";
		$sql .= ($this->nombre != '')? " AND nombre LIKE '%$this->nombre%'":"";
		$sql .= ($this->idmedida != '')? " AND idtipo_medida = '$this->idmedida'":"";
		$sql .= ($this->estatus != '')? " AND estatus = '$this->estatus'":"";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function ListaMedidas()
		{
				
		$sql = "SELECT * FROM tipo_medida WHERE estatus = 1";
	
		$resp = $this->db->consulta($sql);
		return $resp;
		
	    }
	



	
	//Funcion que sirve para obtener un registro especifico de la tabla empresas
	public function buscarMedida()
	{
		$sql = "SELECT * FROM tipo_medida WHERE idtipo_medida = '$this->idmedida'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	//Funcion que guarda un registro en la tabla empresas
	public function guardarMedida()
	{
		$sql = "INSERT INTO tipo_medida (nombre,medidaminima,estatus) VALUES ('$this->nombre','$this->medida','$this->estatus');";
		$resp = $this->db->consulta($sql);
		$this->idmedida = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modificar un registro en la tabla empresas
	public function modificarMedida(){
		$sql = "UPDATE tipo_medida SET nombre = '$this->nombre', medidaminima = '$this->medida', estatus = '$this->estatus' WHERE idtipo_medida = '$this->idmedida'";
		$this->db->consulta($sql);
	}


}
?>