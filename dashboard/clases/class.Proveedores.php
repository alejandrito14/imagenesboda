<?php
class Proveedores
{
	public $db;//objeto de la clase de conexcion
	public $idproveedor;
	public $empresa;
	public $nombre;
	public $celular;
	public $telefono;
	public $email;
	public $estatus;
	public $tipo_usuario;
	public $lista_empresas;
	public $idpais;
	public $idestado;
	public $idmunicipio;

	public function ObtenerTodosProveedores()
	{
		$query="SELECT * FROM proveedor ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerProveedores()
	{
		$query="SELECT * FROM proveedor WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function guardarProveedor()
	{
		$query="INSERT INTO proveedor (empresa,nombre,celular,telefono,email,estatus,idpais,idestado,idmunicipio) VALUES ('$this->empresa','$this->nombre','$this->celular','$this->telefono','$this->email','$this->estatus','$this->idpais','$this->idestado','$this->idmunicipio')";
		
		$resp=$this->db->consulta($query);
		$this->idproveedor = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function modificarProveedor()
	{
		$query="UPDATE proveedor SET empresa='$this->empresa',
		nombre='$this->nombre',
		celular='$this->celular',
		telefono='$this->telefono',
		email='$this->email',
		estatus='$this->estatus',
		idpais='$this->idpais',
		idestado='$this->idestado',
		idmunicipio='$this->idmunicipio'
		WHERE idproveedor=$this->idproveedor";
	

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarproveedor()
	{
		$query="SELECT * FROM proveedor WHERE idproveedor=".$this->idproveedor;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function ObtenerTablarelacion()
	{
		$query="SELECT * FROM codigopostalcosto WHERE idproveedor=".$this->idproveedor;

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	public function Eliminarproveedor()
	{
		$query="DELETE FROM proveedor WHERE idproveedor=".$this->idproveedor;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function ObtenerProveedoresLista()
	{
		$query="SELECT * FROM proveedor WHERE estatus=1";
				
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
	
}
?>