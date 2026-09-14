<?php
class AccesoEmpresa
{
	public $idsucursales;
	public $idusuarios;
	public $db;
	
	//Funcion que nos regresa todos los registros de la tabla empresas
	public function obtenerTodasSucursales()
	{
		$sql = "SELECT * FROM sucursales";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	


	public function AsignarUsuariosEmpresas()
	{
		$sql="INSERT INTO acceso_sucursal_empleado(idsucursales,idusuarios) VALUES ($this->idsucursales,$this->idusuarios)";


		$resp=$this->db->consulta($sql);
	

	}

	public function obtenerSucursalAsignadas()
	{
		$sql="SELECT *FROM  acceso_sucursal_empleado WHERE  idusuarios=$this->idusuarios";

		$resp=$this->db->consulta($sql);
		return $resp;
	}

	public function EliminarAsignacion()
	{
		$sql="DELETE FROM  acceso_sucursal_empleado WHERE  idusuarios=$this->idusuarios";

		$resp=$this->db->consulta($sql);
		return $resp;
	}

	public function obtenerSucursalAsignadasAgrupada()
	{
		$sql="SELECT  GROUP_CONCAT(idsucursales) as idsucursales FROM  acceso_sucursal_empleado WHERE  idusuarios=$this->idusuarios";

		$resp=$this->db->consulta($sql);
		return $resp;
	}
}
?>