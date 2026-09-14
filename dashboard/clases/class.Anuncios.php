<?php 
/**
 * 
 */
class Anuncios
{
	public $db;
	
	public $valor;
	public $idanuncio;
	public $titulo;
	public $descripcion;
	public $orden;
	public $estatus;
	public $imagen;
	public function ObtenerTodosAnuncios()
	{
		$query = "SELECT *
			FROM 
			anuncios";
			
		$result = $this->db->consulta($query);
		return $result;
	}

	public function buscaranuncio()
	{
		$query = "SELECT *
			FROM 
			anuncios WHERE idanuncio=".$this->idanuncio."";
			
		$result = $this->db->consulta($query);
		return $result;
	}

	public function ActualizarMostrarAnuncios()
	{
		$query="UPDATE pagina_configuracion SET 
		mostraranuncios='$this->valor'
		WHERE idpagina_configuracion = 1";

		$result = $this->db->consulta($query);
	}
	
	public function ObtenerUltimoOrdenanuncio()
	{
		$query="SELECT MAX(orden) as ordenar FROM anuncios";		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function guardarAnuncio($value='')
	{
		$query="INSERT INTO anuncios (titulo,descripcion,estatus,orden) VALUES ('$this->titulo','$this->descripcion','$this->estatus','$this->orden')";
		
		$resp=$this->db->consulta($query);
		$this->idanuncio = $this->db->id_ultimo();
		
	}

	public function modificarAnuncio($value='')
	{
			$query="UPDATE anuncios
			 SET titulo='$this->titulo',
			 descripcion='$this->descripcion',
		     estatus='$this->estatus',
		     orden='$this->orden'
		   	WHERE idanuncio=$this->idanuncio";

		$resp=$this->db->consulta($query);
	}

	public function ActualizarMostrarOmitir($value='')
	{
		$query="UPDATE pagina_configuracion SET 
		activaromitirfinal='$this->valor'
		WHERE idpagina_configuracion = 1";

		$result = $this->db->consulta($query);
	}

	public function ActualizarActivarAnuncios($value='')
	{
		$query="UPDATE clientes SET 
		anunciovisto='$this->valor'";

		

		$result = $this->db->consulta($query);
	}

}

 ?>