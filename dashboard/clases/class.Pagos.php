<?php

class Pagos

{

	public $db;//objeto de la clase de conexcion

	

	public $idpagos;
	public $etiqueta;
	public $fechainicial;
	public $fechafinal;
	public $estatus;
	

	
	//Funcion para obtener todos los niveles activos
	public function ObtPagosActivos()
	{
		$sql = "SELECT * FROM pagos WHERE estatus = 1";
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



	public function ObtTodosPagos()
	{
		$sql = "SELECT
		torneocliente.idtorneocliente,
		torneocliente.estatus,
		torneo.idtorneo,
		torneocliente.fecha,
		torneocliente.cantidad,
		torneocliente.foto,
		torneo.fechainicial,
		torneo.fechafinal,
		clientes.nombre,
		clientes.paterno,
		clientes.materno,
		torneocliente.idcliente,
		clientes.email,
		torneo.nombre AS nombretorneo
		FROM
		torneo
		JOIN torneocliente
		ON torneo.idtorneo = torneocliente.idtorneo 
		JOIN clientes
		ON torneocliente.idcliente = clientes.idcliente";
		
		$resp = $this->db->consulta($sql);
		
		return $resp;
	}


	public function buscarpago()
	{
		$sql = "SELECT * FROM pagos WHERE idpagos=".$this->idpagos."";
		

		$resp = $this->db->consulta($sql);
		
		return $resp;
	}
	

	
		//funcion para guardar pagos
	
	public function Guardarpagos()
	{
		$query="INSERT INTO pagos (etiqueta,fechainicial,fechafinal,estatus) VALUES ('$this->etiqueta','$this->fechainicial','$this->fechafinal','$this->estatus')";
		
		
		$resp=$this->db->consulta($query);
		$this->idpagos = $this->db->id_ultimo();
		
		
	}

		//funcion para modificar 
	public function Modificarpagos()
	{
		$query="UPDATE pagos SET etiqueta='$this->etiqueta',
		fechainicial='$this->fechainicial',
		fechafinal='$this->fechafinal',
		estatus='$this->estatus'
		WHERE idpagos=$this->idpagos";

		$resp=$this->db->consulta($query);
	}

	

}

?>