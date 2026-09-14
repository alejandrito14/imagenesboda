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
	public $porcentajecomision;
	public $montotransaccion;
	public $porcentajeimpuesto;
	public $cuenta;
	public $habilitarcampomonto;
	public $habilitarcampomontofactura;
	public $habilitarmercadopago;
	public $claveprivadamercado;
	public $clavepublicamercaoo;
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
		$query="INSERT INTO tipodepago (tipo,estatus,habilitarfoto,constripe,claveprivada,clavepublica,comisionporcentaje,comisionmonto,impuesto,cuenta,habilitarcampomonto,habilitarcampomontofactura,habilitarmercadopago,keyprivadamercado,keypublicamercado) 
		VALUES ('$this->tipo','$this->estatus','$this->habilitarfoto','$this->habilitarstripe','$this->claveprivada','$this->clavepruebamercado','$this->porcentajecomision','$this->montotransaccion','$this->porcentajeimpuesto','$this->cuenta','$this->habilitarcampomonto','$this->habilitarcampomontofactura','$this->habilitarmercadopago','$this->claveprivadamercado','$this->clavepublicamercaoo')";
		
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
		comisionporcentaje='$this->porcentajecomision',
		comisionmonto='$this->montotransaccion',
		impuesto='$this->porcentajeimpuesto',
		cuenta='$this->cuenta',
		habilitarcampomonto='$this->habilitarcampomonto',
		habilitarcampomontofactura='$this->habilitarcampomontofactura',
		habilitarmercadopago='$this->habilitarmercadopago',
		keyprivadamercado='$this->claveprivadamercado',
		keypublicamercado='$this->clavepublicamercaoo'
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

	
	public function ObtTipopagosSucursal()
	{
		$sql = "SELECT *from sucursaltipodepago WHERE idsucursal=".$this->idsucursal."";

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


	

}

?>