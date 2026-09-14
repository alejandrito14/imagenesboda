<?php
class Juego
{
	public $db;//objeto de la clase de conexcion
	public $idjuego;
	public $nombre;
	public $descripcion;
	public $idtorneo;
	public $idtipojuego;
	public $idtipopartido;
	public $idespacio;
	public $fechahora;
	public $tipo_usuario;
	public $lista_empresas;

	public function ObtenertodosJuegos()
	{
		$query="SELECT
		juego.idjuego,
		juego.nombre,
		juego.descripcion,
		juego.idtorneo,
		juego.idespacio,
		juego.idhorario,
		juego.estatus,
		juego.idtipojuego,
		juego.idtipopartido,
		juego.marcador1,
		juego.marcador2,
		juego.jugado,
		juegocliente.idcliente,
		espacio.nombre as nombreespacio,
		CONCAT(horario.hora,' ',horario.dia,'/',horario.mes,'/',horario.anio) as fecha,
		tipojuego.nombre as nombretipojuego,
		torneo.nombre as nombretorneo
		FROM
		juego

		INNER JOIN juegocliente ON juegocliente.idjuego =juego.idjuego
		INNER JOIN espacio ON espacio.idespacio=juego.idespacio
		INNER JOIN horario ON horario.idhorario=juego.idhorario
		INNER JOIN tipojuego ON tipojuego.idtipojuego=juego.idtipojuego
		INNER JOIN torneo ON torneo.idtorneo=juego.idtorneo
		GROUP BY idjuego ";

		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function Obtenerjuegos()
	{
		$query="SELECT * FROM juego WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	public function Guardarjuego()
	{
		$query="INSERT INTO juego (nombre,descripcion,idtorneo,idespacio,idhorario,estatus,idtipojuego,idtipopartido) VALUES ('$this->nombre','$this->descripcion','$this->idtorneo','$this->idespacio','$this->fechahora','$this->estatus','$this->idtipojuego','$this->idtipopartido')";
		
		
		$resp=$this->db->consulta($query);
		$this->idjuego = $this->db->id_ultimo();
		
		
	}
	//funcion para modificar los usuarios
	public function Modificarjuego()
	{
		$query="UPDATE juego SET nombre='$this->nombre',
		descripcion='$this->descripcion',
		idtorneo='$this->idtorneo',
		idespacio='$this->idespacio',
		idespacio='$this->idespacio',
		idhorario='$this->fechahora',
		estatus='$this->estatus',
		idtipojuego='$this->idtipojuego',
		idtipopartido='$this->idtipopartido'
		WHERE idjuego=$this->idjuego";

		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscarjuego()
	{
		$query="SELECT
		juego.idjuego,
		juego.nombre,
		juego.descripcion,
		juego.idtorneo,
		juego.idespacio,
		juego.idhorario,
		juego.estatus,
		juego.idtipojuego,
		juego.idtipopartido,
		juego.marcador1,
		juego.marcador2,
		juego.jugado,
		espacio.nombre as nombreespacio,
		CONCAT(horario.hora,' ',horario.dia,'/',horario.mes,'/',horario.anio) as fecha,
		tipojuego.nombre as nombretipojuego,
		torneo.nombre as nombretorneo
		FROM
		juego

		INNER JOIN espacio ON espacio.idespacio=juego.idespacio
		INNER JOIN horario ON horario.idhorario=juego.idhorario
		INNER JOIN tipojuego ON tipojuego.idtipojuego=juego.idtipojuego
		INNER JOIN torneo ON torneo.idtorneo=juego.idtorneo
		WHERE juego.idjuego=".$this->idjuego."";

		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	

	public function GuardarClienteJuego($idcliente,$equipo)
	{
		$query="INSERT INTO juegocliente (idcliente,idjuego,equipo) VALUES ('$idcliente','$this->idjuego','$equipo')";
		
		
		$resp=$this->db->consulta($query);
	}

	public function borrarJuego()
	{
		$query="DELETE FROM juego WHERE idjuego='$this->idjuego'";
		$resp=$this->db->consulta($query);
	}

	public function obtenerjugadores()
	{
		$sql = "SELECT
		juegocliente.idcliente,
		clientes.nombre,
		clientes.paterno,
		clientes.materno,
		clientes.foto,
		clientes.posicion,
		clientes.nivel,
		clientes.email,
		juegocliente.equipo,
		juegocliente.idjuego
		FROM
		juegocliente
		JOIN clientes
		ON juegocliente.idcliente = clientes.idcliente 
		WHERE juegocliente.idjuego='$this->idjuego'";
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

	public function CrearSets($i)
	{
		$i=$i+1;
		$query="INSERT INTO sets (idjuego,numeroset) VALUES ('$this->idjuego','$i')";
		
		
		$resp=$this->db->consulta($query);
	}
	
}
?>