<?php

class Tipodepagos

{

	public $db;//objeto de la clase de conexcion

	

	public $idtipodepago;
	public $tipo;
	public $estatus;
	public $habilitarfoto;
	public $habilitarstripe;
	public $clavepublica;
	public $claveprivada;
	public $cuenta;
	public $habilitarcampomonto;

	
	//Funcion para obtener todos los tipodepago activos
	public function ObttipodepagoActivos()
	{
		$sql = "SELECT * FROM tipodepago WHERE estatus = 1";
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

	public function ObtenerTodostipodepago()
	{
		$query="SELECT * FROM tipodepago ";

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenertipodepago()
	{
		$query="SELECT * FROM tipodepago WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardartipodepagos()
	{
		$query="INSERT INTO tipodepago (tipo,estatus,habilitarfoto,constripe,claveprivada,clavepublica,cuenta,habilitarcampomonto) 
		VALUES ('$this->tipo','$this->estatus','$this->habilitarfoto','$this->habilitarstripe','$this->claveprivada','$this->clavepublica','$this->cuenta','$this->habilitarcampomonto')";
		
		$resp=$this->db->consulta($query);
		$this->idtipodepago = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificartipodepagos()
	{
		$query="UPDATE tipodepago 
		SET tipo='$this->tipo',
		estatus='$this->estatus',
		habilitarfoto='$this->habilitarfoto',
		constripe='$this->habilitarstripe',
		clavepublica='$this->clavepublica',
		claveprivada='$this->claveprivada',
		cuenta='$this->cuenta',
		habilitarcampomonto='$this->habilitarcampomonto'
		WHERE idtipodepago=$this->idtipodepago";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscartipodepago()
	{
		$query="SELECT * FROM tipodepago WHERE idtipodepago=".$this->idtipodepago;

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	


	

}

?>