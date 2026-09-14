<?php

class ClientePago

{

	public $db;//objeto de la clase de conexcion

	

	public $idclientepago;
	public $idcliente;
	public $idpago;
	public $foto;
	public $cantidad;


		//Funcion que sirve para guardar el registro de la foto
	public function guardar_registro_fotopago()
	{
		$sql = "INSERT INTO clientepago (idcliente,idpago,cantidad) VALUES ('$this->idcliente','$this->idpago','$this->cantidad');";
		$this->db->consulta($sql);
		$this->idclientepago = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para guardar el nombre de la foto guardada
	public function actualizar_nombre_foto()
	{
		$sql = "UPDATE clientepago SET foto = '$this->foto' WHERE idclientepago = '$this->idclientepago'";
		$this->db->consulta($sql);
	}
	
	
	//Funcion para obtener todos los pagos cliente
	
	

	public function ObtPagosCliente()
	{
		$sql = "SELECT *,clientepago.estatus as estatuspago FROM clientepago INNER JOIN pagos ON clientepago.idpago=pagos.idpagos AND pagos.estatus=1 WHERE idcliente = '$this->idcliente'";

	
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

	public function EliminarPago()
	{
		$sql = "DELETE  FROM clientepago WHERE idclientepago = '$this->idclientepago'";

	
		$this->db->consulta($sql);
	}

	

}

?>