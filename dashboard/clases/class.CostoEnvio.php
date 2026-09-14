<?php
class CostoEnvio
{
	public $db;//objeto de la clase de conexcion
	public $idcodigopostalcosto;
	public $codigopostalinicial;//
	public $codigopostalfinal;
	public $costoinicial;
	public $costofinal;
	public $idproveedor;
	public $estatus;

	public $idpais1;
	public $idpais2;
	public $idestado1;
	public $idestado2;

	public $idmunicipio1;
	public $idmunicipio2;

	public $tipo_usuario;
	public $lista_empresas;
	public $idsucursal;
	public $tipoasentamiento;
	public $asentamiento;

	public function ObtenerTodoscodigopostalcosto()
	{
		$query="SELECT
				sucursales.codigopostal as codigoinicial,
				sucursal_proveedor_codigo.codigofinal,
				sucursal_proveedor_codigo.costoinicial,
				sucursal_proveedor_codigo.costofinal,
				proveedor.empresa,
				sucursal_proveedor_codigo.idsucursal_proveedor_codigo,
				sucursales.sucursal,
				sucursal_proveedor_codigo.estatus,
				sucursal_proveedor_codigo.tipoasentamiento,
				sucursal_proveedor_codigo.asentamiento

				FROM
				sucursal_proveedor_codigo
				JOIN proveedor
				ON sucursal_proveedor_codigo.idproveedor = proveedor.idproveedor 
				JOIN sucursales
				ON sucursales.idsucursales = sucursal_proveedor_codigo.idsucursal";

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenercodigopostalcosto()
	{
		$query="SELECT * FROM espacio WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarcodigopostalcosto()
	{
		

		$query="INSERT INTO sucursal_proveedor_codigo (idsucursal,codigofinal,costoinicial,costofinal,estatus,idproveedor,tipoasentamiento,asentamiento) VALUES ('$this->idsucursal','$this->codigopostalfinal','$this->costoinicial','$this->costofinal','$this->estatus','$this->idproveedor','$this->tipoasentamiento','$this->asentamiento')";


		
		$resp=$this->db->consulta($query);
		$this->idcodigopostalcosto = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarcodigopostalcosto()
	{
		$query="UPDATE sucursal_proveedor_codigo
		 SET idsucursal='$this->idsucursal',
		codigofinal='$this->codigopostalfinal',
		costoinicial='$this->costoinicial',
		costofinal='$this->costofinal',
		estatus='$this->estatus',
		tipoasentamiento='$this->tipoasentamiento',
		asentamiento='$this->asentamiento'
	
		WHERE idsucursal_proveedor_codigo=$this->idcodigopostalcosto";
	
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarcodigopostalcosto()
	{
		$query="SELECT * FROM sucursal_proveedor_codigo WHERE idsucursal_proveedor_codigo=".$this->idcodigopostalcosto;
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}

	public function BuscarMunicipioEstado()
	{
		$query="SELECT * FROM codigopostalcosto WHERE idcodigopostalcosto=".$this->idcodigopostalcosto;
		
		$resp=$this->db->consulta($query);
		
		return $resp;
	}



	
	
}
?>