<?php
class Datofiscal
{
	public $db;//objeto de la clase de conexcion
	
	public $nombre;
	public $rfc;
	public $direccion;
	public $nointerior;
	public $noexterior;
	public $colonia;
	public $municipio;
	public $estado;
	public $codigopostal;
	public $correo;
	public $pais;
	public $estatus;
	public $iddatofiscal;

	public function ObtenerTodosdatofiscal()
	{
		$query="SELECT * FROM datofiscal ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerDatofiscal()
	{
		$query="SELECT * FROM datofiscal WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardardatofiscal()
	{
		$query="INSERT INTO datofiscal (nombre,rfc,direccion,nointerior,noexterior,colonia,municipio,estado,codigopostal,correo,pais,estatus) VALUES ('$this->nombre','$this->rfc','$this->direccion','$this->nointerior','$this->noexterior','$this->colonia','$this->municipio','$this->estado','$this->codigopostal','$this->correo','$this->pais','$this->estatus')";
		
		$resp=$this->db->consulta($query);
		$this->iddatofiscal = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificardatofiscal()
	{
		$query="UPDATE datofiscal 
		SET nombre='$this->nombre',
		rfc='$this->rfc',
		direccion='$this->direccion',
		nointerior='$this->nointerior',
		noexterior='$this->noexterior',
		colonia='$this->colonia',
		municipio='$this->municipio',
		estado='$this->estado',
		codigopostal='$this->codigopostal',
		correo='$this->correo',
		pais='$this->pais',
		estatus='$this->estatus'
		 WHERE iddatofiscal=$this->iddatofiscal";
	
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscardatofiscal()
	{
		$query="SELECT * FROM datofiscal WHERE iddatofiscal=".$this->iddatofiscal;
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function ObtenerDatosfiscales()
	{

		$sql="SELECT *FROM datofiscal WHERE estatus=1";


		$resp=$this->db->consulta($sql);
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