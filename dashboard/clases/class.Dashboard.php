<?php 
/**
 * 
 */
class Dashboard
{
	public $db;
	
	

	public function Descargas($value='')
	{
		$query="CALL descargasapp()";

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

	public function Registrados($value='')
	{
		$query="SELECT COUNT(*) AS cantidad FROM clientes";
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



	public function ClientesLogeados($value='')
	{
		$query="SELECT COUNT(*)  AS clientessession from (
		SELECT
		clientes.idcliente,
		clientetoken.token,
		clientetoken.dispositivo,
		clientetoken.uuid,
		clientetoken.idclientetoken,
		clientetoken.fecharegistro
		FROM
		clientes
		JOIN clientetoken
		ON clientes.idcliente = clientetoken.idcliente WHERE clientetoken.uuid!='undefined' and clientetoken.uuid!='' and clientetoken.token!='null' GROUP BY idcliente)as tab";

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

	public function VersionActualAnterior($value='')
	{
		$query="CALL versionactual()";

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

	public function ObtenerTodasversiones()
	{
		$query="SELECT DISTINCTROW SUBSTRING(versionactual,1,1)AS v1,SUBSTRING(versionactual,3,1) as v2,SUBSTRING(versionactual,5,5) as v3  from clientes WHERE versionactual is not null";


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


	public function Obtenerporversion($version)
	{
		$sql="SELECT COUNT(idcliente) as total from clientes WHERE versionactual='".$version."'";


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

	public function ContarMenosActuales($version)
	{
		$sql="SELECT COUNT(idcliente) as total from clientes WHERE versionactual IS NULL or versionactual NOT IN ('".$version."')";
		
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