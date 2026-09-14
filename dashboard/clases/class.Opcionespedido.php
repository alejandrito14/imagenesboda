<?php

class Opcionespedido

{

	public $db;//objeto de la clase de conexcion

	

	public $idopcionespedido;
	public $nombre;
	public $estatus;
	public $confecha;
	public $condireccionentrega;
	public $idsucursal;
	public $habilitaretiqueta;
	public $nombreetiqueta;
	public $habilitarmensaje;
	public $mensaje;
	public $habilitarsumaenvio;
	//Funcion para obtener todos los Opcionespedido activos
	public function ObtOpcionespedidoActivos()
	{
		$sql = "SELECT * FROM opcionespedido WHERE estatus = 1";
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

	public function ObtenerTodosOpcionespedido()
	{
		$query="SELECT * FROM opcionespedido ";

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerOpcionespedido()
	{
		$query="SELECT * FROM opcionespedido WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardaropcionespedido()
	{
		$query="INSERT INTO opcionespedido (opcionpedido,estatus,confecha,condireccionentrega,habilitaretiqueta,nombreetiqueta,habilitarmensaje,mensaje,habilitarsumaenvio) VALUES ('$this->nombre','$this->estatus','$this->confecha','$this->condireccionentrega','$this->habilitaretiqueta','$this->nombreetiqueta','$this->habilitarmensaje','$this->mensaje','$this->habilitarsumaenvio')";
		$resp=$this->db->consulta($query);
		$this->idopcionespedido = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificaropcionespedido()
	{
		$query="UPDATE opcionespedido SET opcionpedido='$this->nombre',
		estatus='$this->estatus',
		confecha='$this->confecha',
		condireccionentrega='$this->condireccionentrega',
		habilitaretiqueta='$this->habilitaretiqueta',
		nombreetiqueta='$this->nombreetiqueta',
		habilitarmensaje='$this->habilitarmensaje',
		mensaje='$this->mensaje',
		habilitarsumaenvio='$this->habilitarsumaenvio'
		WHERE idopcionespedido=$this->idopcionespedido";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscaropcionespedido()
	{
		$query="SELECT * FROM opcionespedido WHERE idopcionespedido=".$this->idopcionespedido;

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function ObtOpcionespedidoSucursal()
	{
		$sql = "SELECT *from sucursalopcionesentrega WHERE idsucursales=".$this->idsucursal."";

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