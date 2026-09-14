<?php
class Presentacion
{
	
	public $db;
	
	public $idpresentacion;
	public $nombre;
	public $descripcion;
	
	//validacione de tipo de usuario
	
	public $tipo_usuario;
	public $lista_empresas;
	

	
		//Funcion que nos regresa los registros de la tabla empresas según el filtro
	public function obtenerFiltro()
	{
		
		 $sql = "SELECT * FROM tipo_presentacion WHERE 1=1 ";
		 $sql .= ($this->nombre != '')? " AND nombre LIKE '%$this->nombre%'":"";
		$sql .= ($this->idpresentacion != '')? " AND idtipo_presentacion = '$this->idpresentacion'":"";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	



	
	//Funcion que sirve para obtener un registro especifico de la tabla empresas
	public function buscarPresentacion()
	{
		$sql = "SELECT * FROM tipo_presentacion WHERE idtipo_presentacion = '$this->idpresentacion'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	//Funcion que guarda un registro en la tabla empresas
	public function guardarPresentacion()
	{
		$sql = "INSERT INTO tipo_presentacion (nombre,descripcion) VALUES ('$this->nombre','$this->descripcion');";
		$resp = $this->db->consulta($sql);
		$this->idpresentacion = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modificar un registro en la tabla empresas
	public function modificarPresentacion(){
		$sql = "UPDATE tipo_presentacion SET nombre = '$this->nombre', descripcion = '$this->descripcion' WHERE idtipo_presentacion = '$this->idpresentacion'";
		$this->db->consulta($sql);
	}


	public function BuscarPresentacionArray($array,$idtipopresentacion)
	{
		
			for($i=0; $i < count($array); $i++) { 

				//print_r($array[$i]);

				if ($array[$i]['idtipopresentacion']==$idtipopresentacion) {

					return true;
				}
			}

			
	}

	public function Buscarposicion($array,$idtipopresentacion)
	{
		for($i=0; $i < count($array); $i++) { 
			if($array[$i]['idtipopresentacion']==$idtipopresentacion) {

				return $i;
				
			}
		}
		
	}



	public function BuscarPresentacionArray2($array,$idtipopresentacion)
	{
		
			for($i=0; $i < count($array); $i++) { 

				//print_r($array[$i]);

				if ($array[$i]['nombre']==$idtipopresentacion) {

					return true;
				}
			}

			
	}

	public function Buscarposicion2($array,$idtipopresentacion)
	{
		for($i=0; $i < count($array); $i++) { 
			if($array[$i]['nombre']==$idtipopresentacion) {

				return $i;
				
			}
		}
		
	}

}
?>