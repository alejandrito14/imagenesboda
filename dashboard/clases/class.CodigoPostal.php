<?php
class CodigoPostal
{

	
	public $db;
	public $codigopostal;
	public $clavemunicipio;
	public $claveestado;
	public $idestado;
	public $idmunicipio;
	
	public function Obtenercodigopostal()
	{
		$sql = "SELECT * FROM codigopostal WHERE codigo =".$this->codigopostal." ";


		$result = $this->db->consulta($sql);
		return $result;	
		
	}


	public function ObtenerEstadoMunicipio()
	{
		$sql="SELECT *from (SELECT municipios.id as idmunicipio,municipios.estado_id,municipios.clave as clavemunicipio,municipios.nombre,
		municipios.web,estados.id as estadosid,estados.clave as claveestado,estados.nombre as nombreestado,estados.idpais
		FROM municipios INNER JOIN estados WHERE estados.id=municipios.estado_id )as consulta
		WHERE clavemunicipio='$this->clavemunicipio' and claveestado='$this->claveestado' and web =1";

		

		$result=$this->db->consulta($sql);
		return $result;
	}


	public function ObtenerTodoscodigopostal()
	{

		$query="SELECT *from codigopostal WHERE codigo";		
		$resp=$this->db->consulta($query);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		$numero=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {


				$array[$contador]=$objeto;
				$contador++;
			} 

			
		}

		return $numero;

		
	}



		public function obtenerClaveestado()
	{
		$sql = "SELECT * FROM estados WHERE id =".$this->idestado." ";

		$result = $this->db->consulta($sql);
		return $result;	
	}


	public function obtenerClavemunicipio()
	{
		$sql = "SELECT * FROM municipios WHERE id =".$this->idmunicipio." ";
		

		$result = $this->db->consulta($sql);
		return $result;	
	}

	public function Obtenercodigospostalesclave($idestado,$idmunicipio)
	{

		$sql = "SELECT * FROM codigopostal WHERE c_estado=".$idestado." AND c_municipio=".$idmunicipio." GROUP BY codigo";

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


	public function obtenerestado($estado)
	{
		$query="SELECT * FROM estados WHERE clave=".$estado."";
		$resp=$this->db->consulta($query);
		
		
		return $resp;
	}

		public function obtenermunicipio($municipio,$estado)
	{
		$query="SELECT * FROM municipios WHERE clave=".$municipio." AND estado_id=".$estado."";

		$resp=$this->db->consulta($query);
		
		
		return $resp;
	}

	public function ObtenerClaveMunicipioEstado()
	{
		$sql = "SELECT * FROM codigopostal WHERE codigo =".$this->codigopostal." ";

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
		

		$estado=$array[0]->c_estado;
		$municipio=$array[0]->c_municipio;


		$obtener=$this->obtenerestado($estado);
		$row=$this->db->fetch_assoc($obtener);

		$obtenerm=$this->obtenermunicipio($municipio,$estado);
		$row2=$this->db->fetch_assoc($obtenerm);

		$idpais=$row['idpais'];
		$idestado=$row['id'];
		$idmunicipio=$row2['id'];

		$arreglo = array('idpais' =>$idpais ,'idestado'=>$idestado,'idmunicipio'=>$idmunicipio );
		return $arreglo;

	}

		public function ObtenerColonias($codigo,$cestado,$cmunicipio,$asenta)
	{

		$sql = "SELECT  * from codigopostal WHERE codigo=".$codigo." AND  c_estado=".$cestado." AND c_municipio=".$cmunicipio." AND tipo_asenta='".$asenta."'";

	
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