<?php
class PaquetesSucursales
{
	
	/* ================= DECLARACION DE VARIABLES ====================== */
	
	public $db;
	public $idpaquetesucursal;
	public $idpaquete;
	public $idsucursal;


	public function guardar()
	{
		$sql="INSERT INTO paquetesucursal(idpaquete,idsucursal) VALUES (".$this->idpaquete.",".$this->idsucursal.")";	
		
		$this->db->consulta($sql);
	}

	public function EliminarPaquetesSucursal()
	{
		$sql="DELETE FROM paquetesucursal WHERE idsucursal=".$this->idsucursal."";
		$this->db->consulta($sql);
	}
	

	public function SeleccionarPaquetes()
	{
	 $sql="SELECT *FROM paquetesucursal WHERE idsucursal=".$this->idsucursal."";

	 $resul=$this->db->consulta($sql);

	 return $resul;

	}



}


?>