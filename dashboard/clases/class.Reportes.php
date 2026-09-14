<?php
class Reportes
{
	public $db;
	
	public $idreporte;

	
	//Funcion que sirve para buscar una reporte
		public function Lista_reportes()
	{
		$sql = "SELECT * FROM reportes WHERE estatus=1";

		$result = $this->db->consulta($sql);
		return $result;
	}

	public function buscar_reportes()
	{
		$sql = "SELECT * FROM reportes WHERE idreporte = '$this->idreporte'";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para guardar un reporte
	public function guardar_reporte()
	{
		$sql = "INSERT INTO reportes (nombre,direccion,email,tel,estatus,urlrastreo) VALUES ('$this->nombre','$this->direccion','$this->email','$this->tel','$this->estatus','$this->urlrastreo');";
		$this->db->consulta($sql);
		$this->idpaqueterias = $this->db->id_ultimo();
	}

	//Funcion que sirve para modifcar un reporte
	public function modificar_reporte()
	{
		$sql = "UPDATE reportes SET nombre = '$this->nombre', direccion = '$this->direccion', email = '$this->email', tel = '$this->tel', estatus = '$this->estatus', urlrastreo = '$this->urlrastreo' WHERE idpaqueterias = '$this->idpaqueterias'";
		$this->db->consulta($sql);
	}

	public function lista_empresas()
	{
		$sql= "SELECT * FROM empresas WHERE empresas.estatus = 1 ";
		
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function lista_paqueterias()
	{
		$sql = "SELECT * FROM paqueterias WHERE paqueterias.estatus = 1 ";
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function lista_clientes()
	{
		$sql= "SELECT empresas.empresas, clientes.* FROM clientes INNER JOIN empresas ON clientes.idempresas = empresas.idempresas WHERE clientes.estatus = 1 ";
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function detalle_empresa()
	{
		$sql= "SELECT * FROM empresas WHERE empresas.estatus = 1 and empresas.idempresas = '$this->idempresas'";
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function detalle_cliente()
	{
		$sql= "SELECT * FROM clientes WHERE clientes.idcliente = '$this->idcliente'";
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function detalle_sucursal()
	{
		$sql = "SELECT * FROM empresas INNER JOIN sucursales ON sucursales.idempresas = empresas.idempresas WHERE sucursales.estatus = 1 and sucursales.idsucursales = '$this->idsucursales' ";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	public function mayus($cadena)//convierte a mayusculas
     {
		return mb_strtoupper($cadena,'utf-8');		 
	 }	

	 public function minus($cadena)//convierte a minusculas
     {
		return mb_strtolower($cadena,'utf-8');		 
	 }	
	
	
	public function imprimir_cadena_utf8($cadena)
     {
		return utf8_decode($cadena);		 
	 }	
	
}
?>