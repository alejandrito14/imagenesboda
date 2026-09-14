<?php

class Seccion

{

	public $db;//objeto de la clase de conexcion

	

	public $idseccion;
	public $titulo;
	public $descripcion;
	public $estatus;
	public $tipo;
	public $foto;
	public $idsucursal;
	public $orden;

	//imagenes
	public $rutaimagen;
	public $estatusimagen;
	public $ordenimagen;



	

	//Funcion para obtener todos los niveles activos
	public function ObtseccionActivos()
	{
		$sql = "SELECT * FROM seccion WHERE estatus = 1";
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


	public function ObtenerTodosseccion()
	{
		$sql = "SELECT * FROM seccion";

		$resp=$this->db->consulta($sql);
		
		return $resp;
	}
	

	public function Obtenerseccion()
	{
		$sql = "SELECT * FROM seccion WHERE idseccion='$this->idseccion'";
	
		$resp=$this->db->consulta($sql);
		
		return $resp;
	}


	public function guardar_seccion()
	{
		$query="INSERT INTO seccion (titulo,descripcion,tipo,estatus,foto,ordenseccion) VALUES ('$this->titulo','".$this->db->real_escape_string($this->descripcion)."','$this->tipo','$this->estatus','$this->foto','$this->orden')";
		
		$resp=$this->db->consulta($query);
		$this->idseccion = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarseccion()
	{
		$query="UPDATE seccion SET titulo='$this->titulo',
		descripcion='".$this->db->real_escape_string($this->descripcion)."',
		tipo='$this->tipo',
		estatus='$this->estatus',
		foto='$this->foto',
		ordenseccion='$this->orden'
		 WHERE idseccion=$this->idseccion";

	
		$resp=$this->db->consulta($query);
	}

	public function Eliminarimagenesrevista()
	{
		$query = "DELETE from imagenesrevista
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
	}

	public function Actualizarpincipal()
	{

		$query="UPDATE seccion SET principal=0";
	
		$resp=$this->db->consulta($query);

		$query="UPDATE seccion SET principal=1 WHERE idseccion=$this->idseccion";
	
		$resp=$this->db->consulta($query);
	}

	public function GuardarImagenesRevista($value='')
	{
		
		$query="INSERT INTO imagenesrevista (ruta,idseccion,estatus,orden) VALUES ('$this->rutaimagen','$this->idseccion','$this->estatusimagen','$this->ordenimagen')";
		
		$resp=$this->db->consulta($query);
		return $resp;		
	}
 
 	public function GuardarImagenesPromo($value='')
 	{
 		$query="INSERT INTO imagenpromocional (ruta,idseccion,estatus,orden) VALUES ('$this->rutaimagen','$this->idseccion','$this->estatusimagen','$this->ordenimagen')";
		
		$resp=$this->db->consulta($query);
		return $resp;
 	}

	public function Obtenerimagenesrevista()
	{
		$query = "SELECT *from imagenesrevista
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
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

	public function Obtenerimagenespromocion($value='')
	{
		$query = "SELECT *from imagenpromocional
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
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

	public function VincularSeccion()
	{
		$query="INSERT INTO sucursalseccion (idseccion,idsucursales) VALUES ('$this->idseccion','$this->idsucursal')";
		
		$resp=$this->db->consulta($query);
		return $resp;		
	}

	public function Eliminarvinculacion()
	{
		$query = "DELETE from sucursalseccion
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
	}

	public function ObtenerSucursalesVinculadas()
	{
		$query = "SELECT *from sucursalseccion
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
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
	
	public function EliminarimagenPromocionales()
	{
		$query = "DELETE from imagenpromocional
				  WHERE idseccion ='$this->idseccion'";



		$resp = $this->db->consulta($query);
	}


	public function ActualizarOrdenSeccion()
	{
		$query = "UPDATE seccion SET  
			ordenseccion='$this->orden'
			WHERE idseccion = '$this->idseccion' ";

			
		$this->db->consulta($query);
	}
}

?>