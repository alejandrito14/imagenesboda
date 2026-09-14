<?php

class Grupos

{

	public $db;//objeto de la clase de conexcion

	

	public $idgrupos;
	public $nombregrupo;
	public $descripcion;
	public $sinprecio;
	public $multiple;
	public $estatus;
	public $tope;
	public $obligatorio;
	

	
	//Funcion para obtener todos los niveles activos
	public function ObtGruposActivos($busqueda)
	{
		$sql = "SELECT * FROM grupo WHERE estatus = 1 ";
		$sql .= ($busqueda != '') ? " AND nombregrupo LIKE '%{$busqueda}%' ":" ";


		$resp = $this->db->consulta($sql);
		return $resp;
	}



	public function ObtTodosGrupos()
	{
		$sql = "SELECT * FROM grupo";

		$resp = $this->db->consulta($sql);
		
		return $resp;
	}


	public function ObtenerGrupo()
	{
		$sql = "SELECT * FROM grupo WHERE idgrupo=".$this->idgrupos."";
		
		
		$resp = $this->db->consulta($sql);
		
		return $resp;
	}
	

	
		//funcion para guardar Grupos
	
	public function Guardargrupos()
	{
		$query="INSERT INTO grupo (nombregrupo,descripcion,sincoprecio,multiple,estatus,tope,obligatorio) VALUES ('$this->nombregrupo','$this->descripcion','$this->sinprecio','$this->multiple','$this->estatus','$this->tope','$this->obligatorio')";
		
		
		$resp=$this->db->consulta($query);
		$this->idgrupos = $this->db->id_ultimo();
		
		
	}

		//funcion para modificar 
	public function ModificarGrupos()
	{
		$query="UPDATE grupo SET nombregrupo='$this->nombregrupo',
		descripcion='$this->descripcion',
		sincoprecio='$this->sinprecio',
		multiple='$this->multiple',
		estatus='$this->estatus',
		tope='$this->tope',
		obligatorio='$this->obligatorio'
		WHERE idgrupo=$this->idgrupos";

		$resp=$this->db->consulta($query);
	}

	public function ObtenerOpciones($idgrupos)
	{
		$sql = "SELECT * FROM grupoopcion WHERE idgrupo=".$idgrupos."";
		
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

	public function ObtenerGrupoPaquete($idpaquete)
	{
		$sql = "SELECT grupopaquetes.idgrupo,
		grupo.nombregrupo,
		grupo.sincoprecio,
		grupo.estatus,
		grupo.multiple,
		grupo.tope,
		grupopaquetes.topesecundario
		 FROM grupopaquetes INNER JOIN grupo ON grupopaquetes.idgrupo=grupo.idgrupo WHERE idpaquete=".$idpaquete."";

		
		$resp = $this->db->consulta($sql);
		
		return $resp;

	}

	public function EliminarOpciones()
	{
		
		$sql = "DELETE  FROM grupoopcion WHERE idgrupo=".$this->idgrupos."";
		$resp = $this->db->consulta($sql);

	}

	

}

?>