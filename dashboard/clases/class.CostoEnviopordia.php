<?php
class CostoEnviopordia
{
	public $db;//objeto de la clase de conexcion
	public $idfechaenvio;
	public $fecha;//
	public $horainicial;
	public $horafinal;
	public $idsucursal;
	public $costo;
	public $estatus;

	

	public function ObtenerTodos()
	{
		$query="SELECT
				
				fechaenviocosto.costo as costoinicial,
				fechaenviocosto.estatus,
				fechaenviocosto.fecha,
				fechaenviocosto.horainicial,
				fechaenviocosto.horafinal,
				sucursales.sucursal,
				fechaenviocosto.idsucursal,
				fechaenviocosto.idfechaenvio
				FROM
				fechaenviocosto
				
				JOIN sucursales
				ON sucursales.idsucursales = fechaenviocosto.idsucursal";

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenercodigopostalcosto()
	{
		$query="SELECT * FROM fechaenviocosto WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarenviocosto()
	{
		

		$query="INSERT INTO fechaenviocosto( fecha, horainicial, horafinal, idsucursal, costo, estatus) VALUES ( '$this->fecha', '$this->horainicial', '$this->horafinal', '$this->idsucursal', '$this->costo', '$this->estatus')";


		
		$resp=$this->db->consulta($query);
		$this->idfechaenvio = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarenviocosto()
	{
		$query="UPDATE fechaenviocosto SET 
			fecha = '$this->fecha', 
			horainicial = '$this->horainicial', 
			horafinal = '$this->horafinal', 
			idsucursal = '$this->idsucursal', 
			costo = '$this->costo', 
			estatus = '$this->estatus'
			WHERE 
			idfechaenvio ='$this->idfechaenvio'";
	
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarcostoenvio()
	{
		$query="SELECT * FROM fechaenviocosto WHERE idfechaenvio=".$this->idfechaenvio;
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}

	public function BuscarMunicipioEstado()
	{
		$query="SELECT * FROM codigopostalcosto WHERE idcodigopostalcosto=".$this->idcodigopostalcosto;
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}

	public function borrarfechaenviodia()
	{
		$query="DELETE FROM fechaenviocosto WHERE idfechaenvio=".$this->idfechaenvio;
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}

	
	
}
?>