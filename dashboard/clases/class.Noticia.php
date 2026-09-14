<?php 
/**
 * 
 */
class Noticia
{
	public $db;

	public $idnoticia;
	public $titulo;
	public $descripcion;
	public $imagennoticia;
	public $enlace;
	public $orden;
	public $estatus;
	public $idseccion;
	public $fechapublicacion;

	public function GuardarNoticia()
	{
		$query="INSERT INTO noticias (titulo,descripcion,orden,estatus,imagen,enlace,idseccion,fecha) VALUES ('$this->titulo','".$this->db->real_escape_string($this->descripcion)."','$this->orden','$this->estatus','$this->imagennoticia','$this->enlace','$this->idseccion','$this->fechapublicacion')";
		
		$resp=$this->db->consulta($query);
		
	}

	public function Obtenernoticias()
	{
		$sql = "SELECT * FROM noticias WHERE idseccion='$this->idseccion'";
	
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

	public function EliminarNoticiasseccion()
	{
		$query = "DELETE from noticias
				  WHERE idseccion ='$this->idseccion'";

		$resp = $this->db->consulta($query);
	}

}

 ?>