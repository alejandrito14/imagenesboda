<?php

class Galeria

{

	public $db;//objeto de la clase de conexcion
    public $id;
    public $nombre_subida;
    public $nombre_archivo;
    public $fecha_subida;


   


     public function ObtTodosGaleria(){

        $sql = "SELECT * FROM fotos_boda";
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