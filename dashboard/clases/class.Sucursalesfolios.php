<?php 

/**
 * 			
 */
class Sucursalesfolios
{
	
	public $db;
	public $campo;
	public $valor;
	public $idsucursal;


	public function GuardarFolio()
	{
		$sql="INSERT INTO sucursales_folios (idsucursales) VALUES ('$this->idsucursal')";
		$this->db->consulta($sql);
		
	}

	public function ActualizarConsecutivo()
	{

		 $sql="SELECT *FROM sucursales_folios where idsucursales='$this->idsucursal'";
		 $resp = $this->db->consulta($sql);
		 $datos=$this->db->fetch_assoc($resp);

		

		 $val=$datos[$this->campo];
		 $this->valor=$val+1;

		$sql="UPDATE sucursales_folios SET ".$this->campo."='$this->valor' where idsucursales='$this->idsucursal'";


		 $resp = $this->db->consulta($sql);
		return $val;
		
	}



	public function ObtenerConsecutivo()
	{
		$sql="SELECT *FROM sucursales_folios where idsucursales='$this->idsucursal'";

		 $resp = $this->db->consulta($sql);
		return $resp;
	}
}

 ?>