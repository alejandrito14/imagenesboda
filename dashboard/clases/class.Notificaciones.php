<?php

class Notificaciones

{

	public $db;//objeto de la clase de conexcion

	

	public $idnotificacion;
	public $titulo;
	public $mensaje;
	public $programado;
	public $seleccionar;
	public $todosclientes;
	public $todosadmin;
	public $estatus;
	public $fechacreacion;
	public $enviado;
	public $idcliente;
	public $idusuario;
	
	//Funcion para obtener todos los Notificaciones activos
	public function ObtNotificacionesActivos()
	{
		$sql = "SELECT * FROM notificacion WHERE estatus = 1";
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

	public function ObtenerTodosNotificaciones()
	{
		$query="SELECT * FROM notificacion ORDER BY idnotificacion desc";
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerNotificaciones()
	{
		$query="SELECT * FROM notificacion WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarnotificacion()
	{
		$query="INSERT INTO notificacion (titulo,mensaje,programado,fechahora,seleccionar,todosclientes,todosadmin,estatus,enviado) VALUES ('$this->titulo','$this->mensaje','$this->programado','$this->fechahora','$this->seleccionar','$this->todosclientes','$this->todosadmin','$this->estatus','$this->enviado')";
		
		
		$resp=$this->db->consulta($query);
		$this->idnotificacion = $this->db->id_ultimo();
		
		
	}


	public function Guardarclientenotificacion()
	{
		$query="INSERT INTO notificacionescliente (idcliente,idnotificacion) VALUES ('$this->idcliente','$this->idnotificacion')";

		
		$resp=$this->db->consulta($query);
	}

	public function Guardarusuarionotificacion()
	{
		$query="INSERT INTO notificacionesusuario (idusuario,idnotificacion) VALUES ('$this->idusuario','$this->idnotificacion')";

		
		$resp=$this->db->consulta($query);
	}
	//funcion para modificar los usuarios
	public function Modificarnotificacion()
	{
		$query="UPDATE notificacion 
		SET titulo='$this->titulo',
		mensaje='$this->mensaje',
		programado='$this->programado',
		fechahora='$this->fechahora',
		seleccionar='$this->seleccionar',
		todosclientes='$this->todosclientes',
		todosadmin='$this->todosadmin',
		estatus='$this->estatus',
		enviado='$this->enviado'
		WHERE idnotificacion=$this->idnotificacion";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarnotificacion()
	{
		$query="SELECT * FROM notificacion WHERE idnotificacion=".$this->idnotificacion;

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function ObterClaveToken()
	{
		$sql = "SELECT * FROM pagina_configuracion LIMIT 1";
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

	public function ObtenerClientesNotificacion()
	{
		$query="SELECT GROUP_CONCAT(idcliente) as clientes FROM notificacionescliente WHERE idnotificacion=".$this->idnotificacion."";
		
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


	public function ObtenerUsuariosNotificacion($value='')
	{
		$query="SELECT GROUP_CONCAT(idusuario) as usuarios FROM notificacionesusuario WHERE idnotificacion=".$this->idnotificacion."";
		
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
	
	public function ObtenerClientesNotificacion2()
	{
		$query="SELECT * FROM notificacionescliente WHERE idnotificacion=".$this->idnotificacion."";
		
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

	public function ObtenerUsuariosNotificacion2($value='')
	{
		$query="SELECT * FROM notificacionesusuario WHERE idnotificacion=".$this->idnotificacion."";

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




	public function EliminarClientesNotificacion()
	{
		$query="DELETE FROM notificacionescliente WHERE idnotificacion='$this->idnotificacion'";
		$resp = $this->db->consulta($query);

	}

	public function EliminarUsuariosNotificacion()
	{
		$query="DELETE FROM notificacionesusuario WHERE idnotificacion='$this->idnotificacion'";
		$resp = $this->db->consulta($query);
	}

}

?>