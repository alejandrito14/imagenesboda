<?php

class TipoAsentamiento
{

	public $db;//objeto de la clase de conexcion

	//Funcion para obtener todos los tipodepago activos
	public function ObtenerTiposAsentamiento($c_estado,$c_municipio,$codigo)
	{
		$sql = "SELECT  tipo_asenta from codigopostal WHERE tipo_asenta!='null' AND c_estado=".$c_estado." AND c_municipio=".$c_municipio." and codigo=".$codigo." GROUP BY tipo_asenta";

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