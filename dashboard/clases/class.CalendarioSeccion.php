<?php 
/**
 * 
 */
class CalendarioSeccion
{
	public $db;

	public $idcalendarioseccion;
	public $imagen;
	public $estatus;
	public $descripcion;
	public $fecha;
	public $idseccion;


	public function GuardarCalendariofecha()
	{
		$query="INSERT INTO calendarioseccion (imagen,descripcion,estatus,idseccion,fecha) VALUES ('$this->imagen','".$this->db->real_escape_string($this->descripcion)."','$this->estatus','$this->idseccion','$this->fecha')";

		
		$resp=$this->db->consulta($query);
		
	}

	public function Obtenercalendario()
	{
		$sql = "SELECT * FROM calendarioseccion WHERE idseccion='$this->idseccion'";

	
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

	public function EliminarCalendariofecha()
	{
		$query = "DELETE from calendarioseccion
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
	}

}

 ?>