<?php
class Cupones
{
	public $db;
	public $idcupon;
	public $codigocupon;
	public $fechainicial;
	public $fechafinal;
    public $horainicial;
	public $horafinal;
	public $tipodescuento;
	public $descuento;
	public $limiteusos;
	public $estatus;
	public $tsucursales;
	public $tpaquetes;
	public $tclientes;
	public $montocompra;
	public $cantidadcompra;
	public $secuenciaventa;
	public $lusocliente;
	public $lusosucursal;
	public $lusodia;
	public $lusototal;
	public $aplicarsobrepromo;


	public $lista_empresa;
	public $tipo_usuario;


	public function ObtenerTodos()
	{
		$query = "SELECT cupones.idcupon,cupones.codigocupon,cupones.tipodescuento,cupones.descuento,
			cupones.lusocliente,cupones.lusosucursal,cupones.lusodia,cupones.lusototal,cupones.fechainicial,
			cupones.fechafinal,cupones.horainicial,cupones.montocompra,cupones.secuenciaventa,cupones.cantidadcompra,cupones.aplicarsobrepromo,
			cupones.horafinal,cupones.tsucursales,cupones.tpaquetes,cupones.tclientes,cupones.estatus,cupones.automatico
			FROM 
			cupones";
			
		$result = $this->db->consulta($query);
		return $result;
	}

	public function ObtenerCuponSucursales($idcupon)
	{
		$sql = "SELECT cuponsucursales.idsucursal, sucursales.sucursal FROM cuponsucursales JOIN sucursales ON cuponsucursales.idsucursal = sucursales.idsucursales WHERE cuponsucursales.idcupon = ".$idcupon;
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	public function ObtenerCuponPaquetes($idcupon)
	{
		$sql = "SELECT cuponpaquetes.idpaquete, paquetes.nombrepaquete FROM cuponpaquetes JOIN paquetes ON cuponpaquetes.idpaquete = paquetes.idpaquete WHERE cuponpaquetes.idcupon = ".$idcupon;
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	public function ObtenerCuponClientes($idcupon)
	{
		$sql = "SELECT cuponclientes.idcliente, clientes.nombre, clientes.paterno, clientes.materno FROM cuponclientes JOIN clientes ON cuponclientes.idcliente = clientes.idcliente WHERE cuponclientes.idcupon = ".$idcupon;
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	public function GuardarCupon()
	{
		$query = "INSERT INTO cupones (codigocupon,tipodescuento,descuento,fechainicial,fechafinal,horainicial,horafinal,tsucursales,
		tpaquetes,tclientes,montocompra,cantidadcompra,secuenciaventa,lusocliente,lusodia,lusosucursal,lusototal,aplicarsobrepromo,estatus) 
		VALUES ('".$this->db->real_escape_string($this->codigocupon)."','".$this->db->real_escape_string($this->tipodescuento)."',
		'$this->descuento','".$this->db->real_escape_string($this->fechainicial)."',
		'".$this->db->real_escape_string($this->fechafinal)."','".$this->db->real_escape_string($this->horainicial)."',
		'".$this->db->real_escape_string($this->horafinal)."','".$this->db->real_escape_string($this->tsucursales)."',
	    '".$this->db->real_escape_string($this->tpaquetes)."','".$this->db->real_escape_string($this->tclientes)."',
		'".$this->db->real_escape_string($this->montocompra)."','".$this->db->real_escape_string($this->cantidadcompra)."',
		'".$this->db->real_escape_string($this->secuenciaventa)."',
		'".$this->db->real_escape_string($this->lusocliente)."','".$this->db->real_escape_string($this->lusodia)."',
		'".$this->db->real_escape_string($this->lusosucursal)."','".$this->db->real_escape_string($this->lusototal)."',
		'".$this->db->real_escape_string($this->aplicarsobrepromo)."','".$this->db->real_escape_string($this->estatus)."' );";
		
		$this->db->consulta($query);


		$this->idcupon = $this->db->id_ultimo();
	}

	public function guardarCuponSucursales($idsuc)
	{
		$query = "INSERT INTO cuponsucursales(idcupon,idempresa) VALUES ('".$this->db->real_escape_string($this->idcupon)."','".$this->db->real_escape_string($idsuc)."');";
		$this->db->consulta($query);	
	}

	public function guardarCuponPaquetes($idpaq)
	{
		$query = "INSERT INTO cuponpaquetes(idcupon,idpaquete) VALUES ('".$this->db->real_escape_string($this->idcupon)."','".$this->db->real_escape_string($idpaq)."');";
		$this->db->consulta($query);
	}

	public function guardarCuponClientes($idcli)
	{
		$query = "INSERT INTO cuponclientes(idcupon,idcliente) VALUES ('".$this->db->real_escape_string($this->idcupon)."','".$this->db->real_escape_string($idcli)."');";
		$this->db->consulta($query);
	}

	public function validarCodigoCupon($codigocupon)
	{
		$query = "SELECT idcupon FROM cupones where codigocupon = '".$this->db->real_escape_string($codigocupon)."'";
		$resp = $this->db->consulta($query);
		$ncups = $this->db->num_rows($resp);
		if ($ncups > 0 ){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function ActualizarEstado($idcupon,$state)
	{
		$query = "UPDATE cupones SET  
		 	estatus = $state 
		 	WHERE idcupon = $idcupon ";

		$this->db->consulta($query);

	}

	public function ActualizarAutomaticoCupon($idcupon,$state){
		$query = "UPDATE cupones SET  
		 	automatico = $state 
		 	WHERE idcupon = $idcupon ";

		$this->db->consulta($query);

	}
}
?>