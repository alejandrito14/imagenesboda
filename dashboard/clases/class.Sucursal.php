<?php
class Sucursal
{
	public $db;
	public $idsucursales;
	public $idempresas;
	public $sucursal;
	public $direccion;
	public $telefono;
	public $idmunicipio;
	public $idestado;
	public $idpais;
	public $email;
	public $estatus;
	public $iva;
	
    public $tipo_usuario;
    public $lista_empresas;
	public $v_pais;
	public $v_estado;
	public $v_municipio;
	public $horainicio;
	public $horafin;
	public $minutosconsiderados;
	public $solicitarfactura;
	public $orden;
	public $dia;
	public $horainiciosemana;
	public $horafinsemana;
	public $opcionepedido;
	public $iddatofiscal;
	public $colonia;
	public $codigopostal;

	public $encabezado;
	public $leyendafinal;
	public $ticketventa;
	public $ticketproduccion;
	public $trecordatorio;
	public $minutosrecordatorio;
	public $mensajesucursal;
	public $mensajecliente;
	public $tipodepago;
	public $habilitarcampomontofactura;
	public $habilitarnotaventa;
	public $mensajesecciontipopago;


	public function ObtenerTodos()
	{
		$query="SELECT * FROM sucursales ";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	
	
	public function ObtenerSucursals()
	{
		$query="SELECT * FROM sucursales WHERE estatus=1";
		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}
	//funcion para guardar los paises 
	
	
	//funcion que sirve para guardar una sucursal 
	public function guardar_sucursal()
	{
		$query = "INSERT INTO sucursales (sucursal,direccion,telefono,email,estatus,iva,pais,estado,municipio,horaentrada,horasalida,minutosconsiderados,solicitarfactura,orden,iddatofiscal,colonia,encabezadoticket,leyendaticket,telefono2,telefono3,telefono4,tventa,tproduccion,codigopostal,trecordatorio,minutosrecordatorio,mensajesucursal,mensajecliente,campomontofactura,habilitarnotaventa,mensajesecciontipopago) VALUES ('$this->sucursal','$this->direccion','$this->telefono','$this->email','$this->estatus','$this->iva','$this->v_pais','$this->v_estado','$this->v_municipio','$this->horainicio','$this->horafin','$this->minutosconsiderados','$this->solicitarfactura','$this->orden','$this->iddatofiscal','$this->colonia','$this->encabezado','$this->leyendafinal','$this->telefono2','$this->telefono3','$this->telefono4','$this->ticketventa','$this->ticketproduccion','$this->codigopostal','$this->trecordatorio','$this->minutosrecordatorio','$this->mensajesucursal','$this->mensajecliente','$this->habilitarcampomontofactura','$this->habilitarnotaventa','$this->mensajesecciontipopago');";

		
	
		$this->db->consulta($query);
		$this->idsucursales = $this->db->id_ultimo();
	}
//funcion que sirve para modificar una sucursal
	public function modificar_sucursal()
	{
		$query = "UPDATE sucursales SET sucursal = '$this->sucursal', direccion = '$this->direccion', telefono = '$this->telefono', email = '$this->email', estatus = '$this->estatus',iva='$this->iva',
			pais='$this->v_pais',estado='$this->v_estado',
			municipio='$this->v_municipio',
			minutosconsiderados='$this->minutosconsiderados',
			solicitarfactura='$this->solicitarfactura',
			orden='$this->orden',
			iddatofiscal='$this->iddatofiscal',
			colonia='$this->colonia',
			encabezadoticket='$this->encabezado',
			leyendaticket='$this->leyendafinal',
			telefono2='$this->telefono2',
			telefono3='$this->telefono3',
			telefono4='$this->telefono4',
			tventa='$this->ticketventa',
			tproduccion='$this->ticketproduccion',
			codigopostal='$this->codigopostal',
			trecordatorio='$this->trecordatorio',
			minutosrecordatorio='$this->minutosrecordatorio',
			mensajesucursal='$this->mensajesucursal',
			mensajecliente='$this->mensajecliente',
			campomontofactura='$this->habilitarcampomontofactura',
			habilitarnotaventa='$this->habilitarnotaventa',
			mensajesecciontipopago='$this->mensajesecciontipopago'
		 WHERE idsucursales = '$this->idsucursales'";

		

		$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function buscar_sucursal()
	{
		$query="SELECT * FROM sucursales WHERE idsucursales=".$this->idsucursales;		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function buscar_sucursalpaquete()
	{
		$query="SELECT * FROM paquetesucursal WHERE idsucursal=".$this->idsucursales;


		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function EliminarDeFolio()
	{
		$query="DELETE FROM sucursales_folios WHERE idsucursales=".$this->idsucursales;


		$resp=$this->db->consulta($query);
		
	}


		public function EliminarSucursales()
	{
		$query="DELETE FROM sucursales WHERE idsucursales=".$this->idsucursales;

		$resp=$this->db->consulta($query);
		
	}

	public function ObtenerImagenesSucursal()
	{
		$sql="SELECT *FROM sucursalesimagenes WHERE idsucursales=".$this->idsucursales."";

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

	public function ObtenerUltimoOrdensucursal()
	{
		$query="SELECT MAX(orden) as ordenar FROM sucursales";		
		$resp=$this->db->consulta($query);
		
		//echo $total;
		return $resp;
	}

	public function GuardarHorarioSemana()
	{
		$query = "INSERT INTO horariosucursal (idsucursal,dia,horainicial,horafinal) VALUES ('$this->idsucursales','$this->dia','$this->horainiciosemana','$this->horafinsemana');";
			
		
		$this->db->consulta($query);



	}

	public function EliminarHorarioSemana()
	{
		$query="DELETE FROM horariosucursal WHERE idsucursal=".$this->idsucursales;

		$resp=$this->db->consulta($query);
	}

	public function ObtenerHorariosSemana()
	{
		$sql="SELECT *FROM horariosucursal WHERE idsucursal=".$this->idsucursales."";

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

	public function GuardarOpcionpedido()
	{
		$query = "INSERT INTO sucursalopcionesentrega (idsucursales,idopcionespedido) VALUES ('$this->idsucursales','$this->opcionepedido');";

	
			
		$this->db->consulta($query);
	}

	public function EliminarOpcionespedido()
	{
		$query="DELETE FROM sucursalopcionesentrega WHERE idsucursales=".$this->idsucursales;

		$resp=$this->db->consulta($query);
	}

	public function ObtenerSucursalesLista()
	{
		$query="SELECT * FROM sucursales WHERE estatus=1";
				
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


	public function GuardarTipodepago()
	{
		$query = "INSERT INTO sucursaltipodepago (idsucursal,idtipodepago) VALUES ('$this->idsucursales','$this->tipodepago');";
			
		$this->db->consulta($query);
	}

	public function EliminarTiposdepago()
	{
		$query="DELETE FROM sucursaltipodepago WHERE idsucursal=".$this->idsucursales;

		

		$resp=$this->db->consulta($query);
	}
	
}
?>