<?php
class Configuracion
{
	public $db;//objeto de conecxion con la base de datos
	
	public $idConfiguracion;//ide del Cliente  
	public $ultimoIDConfiguracion;//ultimo id del Cliente
	

		
	//DATOS GENERALES
	
	public $nombre_empresa;
	public $direccion;
	public $telefonos;
	public $email;
	public $email_pedido;
	public $url;
	public $clave_caja;
	public $notas_print;
	public $porc_comision;
	
	//DATOS FISCALES
	
	public $razon_social;
	public $rfc;
	public $direccion_fiscal;
	public $no_int_fiscal;
	public $no_ext_fiscal;
	public $estado_fiscal;
	public $ciudad_fiscal;
	public $colonia_fiscal;
	public $cp_fiscal;
	
		
	//CONFIGURACION TIENDA
	
	public $cuentasbancarias;
	public $moneda;
	public $iva;
	public $t_descuento;
	
	//CONFIGURACION EMAILS ENVIOS
	
	public $v_e_cuenta;
	public $v_e_clave;
	public $v_e_pop;
	public $v_e_pentrante;
	public $v_e_smtp;
	public $v_e_psaliente;
	public $v_e_autenticacion;
	public $v_e_ss;
	public $diasvencimiento;
	
	
	//funcion para guarda una nueva empresas
	public function GuardarNewConfiguracion()
	{
		$query="INSERT INTO configuracion (nombre_empresa, direccion, telefonos, email, url, razon_social, rfc, direccion_fiscal, no_int_fiscal, no_ext_fiscal, estado_fiscal, ciudad_fiscal,  colonia_fiscal, cp_fiscal, cuentasbancarias, moneda, iva, t_descuento,e_cuenta,e_clave,e_pop,e_pentrante,e_smtp,e_psaliente,e_autentication,e_ss,clave_caja,notas_print,porc_comision,email_pedido,dias_vencimiento) VALUES ('$this->nombre_empresa', '$this->direccion', '$this->telefonos', '$this->email', '$this->url', '$this->razon_social', '$this->rfc', '$this->direccion_fiscal', '$this->no_int_fiscal', '$this->no_ext_fiscal', '$this->estado_fiscal', '$this->ciudad_fiscal', '$this->colonia_fiscal', '$this->cp_fiscal', '$this->cuentasbancarias', '$this->moneda', '$this->iva', '$this->t_descuento','$this->v_e_cuenta','$this->v_e_clave','$this->v_e_pop','$this->v_e_pentrante','$this->v_e_smtp','$this->v_e_psaliente','$this->v_e_autenticacion','$this->v_e_ss','$this->clave_caja','$this->notas_print','$this->porc_comision','$this->email_pedido','$this->diasvencimiento')";
		
		$result=$this->db->consulta($query);
		$this->ultimoIDConfiguracion=$this->db->id_ultimo();
	}
	
	
	//funcion para modificar los datos de la empresas
	public function ModificarConfiguracion()
	{
		 $query="UPDATE configuracion SET
		nombre_empresa = '$this->nombre_empresa', 
		direccion = '$this->direccion', 
		telefonos='$this->telefonos' , 
		email= '$this->email', 
		url = '$this->url', 
		razon_social= '$this->razon_social', 
		rfc='$this->rfc', 
		direccion_fiscal='$this->direccion_fiscal', 
		no_int_fiscal='$this->no_int_fiscal', 
		no_ext_fiscal='$this->no_ext_fiscal', 
		estado_fiscal='$this->estado_fiscal', 
		ciudad_fiscal='$this->ciudad_fiscal',  
		colonia_fiscal='$this->colonia_fiscal', 
		cp_fiscal='$this->cp_fiscal', 
		cuentasbancarias='$this->cuentasbancarias', 
		moneda='$this->moneda', 
		iva='$this->iva', 
		t_descuento='$this->t_descuento',
		e_cuenta='$this->v_e_cuenta',
		e_clave='$this->v_e_clave',
		e_pop='$this->v_e_pop',
		e_pentrante='$this->v_e_pentrante',
		e_smtp='$this->v_e_smtp',
		e_psaliente='$this->v_e_psaliente',
		e_autentication='$this->v_e_autenticacion',
		e_ss='$this->v_e_ss', clave_caja = '$this->clave_caja', 
		notas_print = '$this->notas_print', porc_comision = '$this->porc_comision', email_pedido = '$this->email_pedido',
		dias_vencimiento='$this->diasvencimiento'		
		WHERE idconfiguracion = '$this->idConfiguracion'";


		//echo $query;die();
		
		$result = $this->db->consulta($query);
	}

	
	
	//funcion para obtener la informacion de la empresa
	public function ObtenerInformacionConfiguracion()
	{
		
				$query="SELECT  *, count(idconfiguracion) as cuantos FROM configuracion";
				
				$resp=$this->db->consulta($query);
				$rows=$this->db->fetch_assoc($resp);
				$total = $this->db->num_rows($resp);				
				return $rows;
		/*var_dump($rows);die();*/
	}
	
	
		
}
?>