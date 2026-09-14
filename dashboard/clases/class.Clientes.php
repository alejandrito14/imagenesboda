<?php
class Clientes
{
	public $db;//objeto de conecxion con la base de datos
	
	public $idCliente;//ide del Cliente  
	public $ultimoIDCliente;//ultimo id del Cliente
	


	//DATOS GENERALES
	
	public $no_tarjeta;
	public $nombre;
	public $paterno;
	public $materno;
	public $direccion;
	public $telefono;
	public $fax;
	public $email;
	public $sexo;
	public $f_nacimiento;
	public $usuario;
	public $clave;
	public $estatus;
	public $descuento;
	public $no_cliente;
	public $direccion_envio;
	public $idprospecto;
	public $idempresa;
	public $referencia;
	public $habilitarobservacion;
	//INFORMACION DE FACTURACION
	
	public $idCliente_fiscal;
	public $fis_tipopersona;
	public $fis_razonsocial;
	public $fis_rfc;
	public $fis_direccion;
	public $fis_no_int;
	public $fis_no_ext;
	public $fis_col;
	public $fis_ciudad;
	public $fis_estado;
	public $fis_pais;
	public $fis_cp;
	public $fis_municipio;
	public $fis_telefono;
	public $fis_correo;

	public $municipio;
	public $estado;
	public $pais;
	public $localidad;
	public $colonia;
	public $no_ext;
	public $no_int;
	public $folio_adminpack;
	
	public $idcliente_monedero;
	
	public $mes;
	public $ano;
	
	public $selected;
	public $cp;
	
	public $idsucursales;
	
	public $tipo_usuario;
	public $lista_empresas;
	public $edad;
	public $celular;
	
	//VARIABLES PARA PODER GUARDAR LAS DIRECCIONES DE ENVIO.
	
	public $idclientes_envios;
	public $envio_direccion;
	public $envio_no_int;
	public $envio_no_ext;
	public $envio_col;
	public $envio_municipio;
	public $envio_ciudad;
	public $envio_estado;
	public $envio_pais;
	public $envio_cp;
	public $envio_referencia;
	public $envio_telefono;
	public $opcionestipopagobloqueada;
	public $validacioncel;
	public $bloquearediciondedatos;
	public $mostraranuncios;
	
	//funcion para guarda una nueva empresas
	public function GuardarNewCliente()
	{
		$query="INSERT INTO clientes (no_tarjeta,nombre,paterno,materno,direccion,telefono,fax,email,sexo,f_nacimiento,fis_razonsocial,fis_rfc,fis_direccion,fis_no_int,fis_no_ext,fis_col,fis_ciudad,fis_estado,fis_cp,usuario,clave,estatus,direccion_envio,cp,no_cliente,referencia,correofiscal,activarobservacion,edad,celular) VALUES ('$this->no_tarjeta','$this->nombre','$this->paterno','$this->materno','$this->direccion','$this->telefono','$this->fax','$this->email','$this->sexo','$this->f_nacimiento','$this->fis_razonsocial','$this->fis_rfc','$this->fis_direccion','$this->fis_no_int','$this->fis_no_ext','$this->fis_col','$this->fis_ciudad','$this->fis_estado','$this->fis_cp','$this->usuario','$this->clave','$this->estatus','$this->direccion_envio','$this->cp','$this->no_cliente','$this->referencia','$this->fis_correo','$this->habilitarobservacion','$this->edad','$this->celular')";

		
		$result=$this->db->consulta($query);
		$this->ultimoIDCliente=$this->db->id_ultimo();
	}
	
	
	//funcion para modificar los datos de la empresas
	public function ModificarCliente()
	{
		$query="UPDATE clientes SET 
		no_tarjeta = '$this->no_tarjeta',	
		nombre='$this->nombre',
		paterno='$this->paterno',
		materno='$this->materno',
		direccion='$this->direccion',
		telefono='$this->telefono',
		fax='$this->fax',
		email='$this->email',
		sexo='$this->sexo',
		f_nacimiento='$this->f_nacimiento',
		fis_razonsocial='$this->fis_razonsocial',
		fis_rfc='$this->fis_rfc',
		fis_direccion='$this->fis_direccion',
		fis_no_int='$this->fis_no_int',
		fis_no_ext='$this->fis_no_ext',
		fis_col='$this->fis_col',
		fis_ciudad='$this->fis_ciudad',
		fis_estado='$this->fis_estado',
		fis_cp='$this->fis_cp',
		fis_municipio='$this->fis_municipio',
		usuario='$this->usuario',
		clave='$this->clave',
		estatus='$this->estatus',
		no_cliente='$this->no_cliente',
		direccion_envio = '$this->direccion_envio',
		cp = '$this->cp',
		idlocalidad='$this->ciudad',
		no_int	='$this->no_int',
		no_ext	='$this->no_ext',
		colonia	='$this->colonia',
		municipio='$this->municipio',
		idlocalidad='$this->ciudad',
		no_int	='$this->no_int',
		no_ext	='$this->no_ext',
		colonia	='$this->colonia',
		folio_adminpack='$this->folio_adminpack',
		referencia='$this->referencia',
		correofiscal='$this->fis_correo',
		activarobservacion='$this->habilitarobservacion',
		edad='$this->edad',
		celular='$this->celular',
		opcionespagobloqueadas='$this->opcionestipopagobloqueada',
		validartelefono='$this->validacioncel',
		bloquearediciondatos='$this->bloquearediciondedatos',
		anunciovisto='$this->mostraranuncios'
		WHERE idcliente = '$this->idCliente'";


		$result = $this->db->consulta($query);
	}
	

	 public function ModificarProspectoCliente()
	 {
	 	$query="UPDATE prospecto SET 
		no_tarjeta = '$this->no_tarjeta',	
		nombre='$this->nombre',
		paterno='$this->paterno',
		materno='$this->materno',
		direccion='$this->direccion',
		telefono='$this->telefono',
		fax='$this->fax',
		email='$this->email',
		sexo='$this->sexo',
		f_nacimiento='$this->f_nacimiento',
		fis_razonsocial='$this->fis_razonsocial',
		fis_rfc='$this->fis_rfc',
		fis_direccion='$this->fis_direccion',
		fis_no_int='$this->fis_no_int',
		fis_no_ext='$this->fis_no_ext',
		fis_col='$this->fis_col',
		fis_ciudad='$this->fis_ciudad',
		fis_estado='$this->fis_estado',
		fis_cp='$this->fis_cp',
		usuario='$this->usuario',
		clave='$this->clave',
		estatus='$this->estatus',
		direccion_envio = '$this->direccion_envio',
		idempresas = '$this->idsucursales',
		cp = '$this->cp',
		
		no_int	='$this->no_int',
		no_ext	='$this->no_ext',
		colonia	='$this->colonia',
		fis_municipio='$this->fis_municipio'	
		WHERE idcliente = '$this->idprospecto'";

		/*municipios='$this->municipio',
		idlocalidad='$this->ciudad',
		estados='$this->estado',
		pais = '$this->pais',*/

		
		
		$result = $this->db->consulta($query);
	 }
	

	
	//funcion para obtener la informacion de la empresa
	public function ObtenerInformacionCliente()
	{
		$Query="SELECT c.*,estados.id as estadoid,municipios.id as municipioid FROM clientes  c
	LEFT JOIN municipios ON municipios.id=c.municipio
	LEFT JOIN estados ON estados.id =c.estado
	LEFT JOIN pais ON pais.idpais =c.pais

		 WHERE idcliente='$this->idCliente'";
		
	
		$resp=$this->db->consulta($Query);		
		return $resp;
	}



	public function ObtenerInformacionClientes()
	{
		$Query="SELECT c.*,estados.id as estadoid,municipios.id as municipioid FROM clientes  c
	LEFT JOIN municipios ON municipios.id=c.municipios
	LEFT JOIN estados ON estados.id =c.estados
	LEFT JOIN pais ON pais.idpais =c.pais";
		
		$resp=$this->db->consulta($Query);	


		return $resp;
	}

	public function ObtenerInformacionCliente2(){
		$Query="SELECT c.*,estados.id as estadoid,municipios.id as municipioid FROM clientes  c
	LEFT JOIN municipios ON municipios.id=c.municipios
	LEFT JOIN estados ON estados.id =c.estados
	LEFT JOIN pais ON pais.idpais =c.pais

		 WHERE no_cliente='".$this->no_cliente."' AND idempresas='$this->idempresa'";


		
		$resp=$this->db->consulta($Query);		
		return $resp;


	}
	
	//funcion para obtener la informacion de la empresa
	public function ValidarNoCliente()
	{
		$Query="SELECT * FROM clientes WHERE no_cliente=".$this->no_cliente;
		
		$resp=$this->db->consulta($Query);		
		return $resp;
	}
	//funcion para obtener la informacion de la empresa
	public function lista_clientes()
	{
				
		$sql = "SELECT clientes.* FROM clientes  ";
	
	
		$resp = $this->db->consulta($sql);

		return $resp;
	}

	public function lista_prospectos()
	{
		if($this->tipo_usuario != 0)
		{
			$SQLidempresas = " where clientes.idempresas IN($this->lista_empresas) ";

		}else
		{
			$SQLidempresas = " ";
		}
		
		$sql = "SELECT clientes.*, empresas.empresas,clientes.idlocalidad as nombrelocalidad
		 FROM clientes
		INNER JOIN empresas ON empresas.idempresas = clientes.idempresas
		".$SQLidempresas." 	GROUP BY clientes.idcliente";

		
		
		$resp = $this->db->consulta($sql);

		return $resp;
	}
	
	public function ObtenerInformacionClientesResult()
	{
		$sql = "SELECT * FROM clientes order by nombre asc";
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	public function ObtenerInformacionClienteResult()
	{
		$sql = "SELECT * FROM clientes order by nombre asc";
		$resp = $this->db->consulta($sql);
		return $resp;
	}		
	
	
	
	
	
	function validarUsuarioCliente ()
	{
		$r ;
		$sql_cliente = "SELECT * FROM clientes WHERE usuario = '$this->usuario'";
		
		$result_cliente = $this->db->consulta($sql_cliente);
		$result_cliente_row = $this->db->fetch_assoc($result_cliente);
		$result_cliente_row_num = $this->db->num_rows($result_cliente);
		
		
		if ($result_cliente_row_num != 0)
		{
			$r = 1 ;
			
		}
		else
		{
			$r = 0;

		}
		return $r ;
		
		
	}
	
	public function validarEmailCliente ()
	{
		$r ;
		$sql_client = "SELECT * FROM clientes WHERE email = '$this->email'";
		$result_cliente = $this->db->consulta($sql_client);
		$result_cliente_row = $this->db->fetch_assoc($result_cliente);
		$result_cliente_row_num = $this->db->num_rows($result_cliente);
		
		
		if ($result_cliente_row_num != 0)
		{
			$r = 1 ;
			
		}
		else
		{
			$r = 0;

		}
		return $r ;
		
		
	}
	
	
	public function buscarMovimientosMonederoAbonos()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente = '$this->idCliente' AND tipo = '0' ORDER BY fecha DESC";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarMovimientosMonederoCargos()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente = '$this->idCliente' AND tipo = '1' ORDER BY fecha DESC";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarMovimientoMonedero()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente_monedero = '$this->idcliente_monedero'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	//Funcion que sirve para obtener la cantidad en dinero vendida de un cliente
	public function ObtVentasCliente()
	{
		//$sql = "SELECT SUM(total) as total FROM nota_remision WHERE idcliente = '$this->idCliente' AND MONTH(fechapedido) = '$this->mes' AND estatus = '1'";
		
		$sql = "SELECT SUM(monto_efec+monto_transfer+monto_deposito+monto_cheque+monto_tc-cambio) as total FROM nota_remision WHERE idcliente = '$this->idCliente' AND MONTH(fechapedido) = '$this->mes' AND YEAR(fechapedido) = '$this->ano' AND estatus = '1'";
		$result = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result);	
		return $result_row;
	}
	
	//Funcion que sirve para obtener la cantidad en dinero devuelta de un cliente
	public function obtDevolucionesCliente()
	{
		$sql = "SELECT SUM(cd.total) as total  FROM nota_remision nr, cliente_devolucion cd WHERE idcliente = '$this->idCliente' AND nr.idnota_remision = cd.idnota_remision AND MONTH(fechapedido) = '$this->mes'";
		$result = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result);
		return $result_row;
	}
	
	//Funcion que sirve para actualizar el nivel del cliente a 60%
	public function actualizarNivel60()
	{
		$sql = "UPDATE clientes SET idniveles = '6' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	//Funcion que sirve actualizar el nivel del cliente a 50%
	public function actualizarNivel50()
	{
		$sql = "UPDATE clientes SET idniveles = '5' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	//Funcion que sirve para actualizar el nivel del cliente a 62%
	public function actualizarNivel62()
	{
		$sql = "UPDATE clientes SET idniveles = '7' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	
	//Funcion que nos sirve para obtener a todos los clientes que tienen dado de alta un numero telefonico
	public function clientesTelefono()
	{
		$sql = "SELECT * FROM clientes WHERE telefono != ''";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	//Funciones que sirve para obtener los cumpleañeros del dia
	public function obtener_cumpleanos_diario()
	{
		$sql = "SELECT * FROM clientes WHERE MONTH(f_nacimiento) = '$this->mes' AND DAY(f_nacimiento) = '$this->dia'";
		$result = $this->db->consulta($sql);
		return $result;
	}

	public function ObtenerInformacionClientesResult2($idempresa)
	{
		$sql = "SELECT * FROM clientes WHERE idempresas=".$idempresa." order by nombre asc";


		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	public function GuardarDireccionEnvio()
	{
		$sql = "INSERT INTO clientes_envios (idcliente,direccion,no_ext,no_int,col,ciudad,estado,pais,cp,referencia,municipio,telefono) 
		VALUES ('$this->idCliente','$this->envio_direccion','$this->envio_no_ext','$this->envio_no_int','$this->envio_col','$this->envio_ciudad','$this->envio_estado','$this->envio_pais','$this->envio_cp','$this->envio_referencia','$this->envio_municipio','$this->envio_telefono')	";
	
		
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	
	public function ModificarDireccionEnvio()
	{
		$sql = "UPDATE clientes_envios SET 
		idcliente='$this->idCliente',
		direccion='$this->envio_direccion',
		no_ext='$this->envio_no_ext',
		no_int='$this->envio_no_int',
		col='$this->envio_col',
		municipio='$this->envio_municipio',
		ciudad='$this->envio_ciudad',
		estado='$this->envio_estado',
		pais='$this->envio_pais',
		cp='$this->envio_cp',
		referencia='$this->envio_referencia',
		telefono='$this->envio_telefono'
		WHERE idclientes_envios='$this->idclientes_envios'";
		$r = $this->db->consulta($sql);
		return $r; 
	}
	
	public function ListaDireccionesEnvios()
	{
		$sql = "SELECT 
		clientes_envios.*,

		pais.idpais as idpais,
		pais.pais as nombrepais,
		estados.id as idestado,
		estados.nombre as nombreestado,
		municipios.id AS idmunicipio,
		municipios.nombre AS nombremunicipio
	
		
		FROM
		clientes_envios
		LEFT JOIN municipios ON municipios.id =clientes_envios.municipio
		LEFT join estados ON estados.id=clientes_envios.estado
		LEFT JOIN pais ON pais.idpais=clientes_envios.pais
		WHERE idcliente = $this->idCliente";

		
		$lista = $this->db->consulta($sql);
		return $lista;
	}


	public function ListaDatosfiscales()
	{
		$sql = "SELECT 
		clientes_datosfiscales.*,

		pais.idpais as idpais,
		pais.pais as nombrepais,
		estados.id as idestado,
		estados.nombre as nombreestado,
		municipios.id AS idmunicipio,
		municipios.nombre AS nombremunicipio
	
		
		FROM
		clientes_datosfiscales
		LEFT JOIN municipios ON municipios.id =clientes_datosfiscales.municipio
		LEFT join estados ON estados.id=clientes_datosfiscales.estado
		LEFT JOIN pais ON pais.idpais=clientes_datosfiscales.pais
		WHERE idcliente = $this->idCliente";

		
		$lista = $this->db->consulta($sql);
		return $lista;
	}

	public function ObtenerDirecciones()
	{
		$sql = "SELECT clientes_envios.idclientes_envios,clientes_envios.direccion,clientes_envios.no_ext,clientes_envios.no_int,clientes_envios.col,clientes_envios.ciudad,clientes_envios.estado,clientes_envios.pais,clientes_envios.cp,pais.idpais as idpais,
				pais.pais as nombrepais,
				estados.id as idestado,
				estados.nombre as nombreestado,
				municipios.id AS idmunicipio,
				municipios.nombre AS nombremunicipio,
				clientes.idcliente,
			clientes_envios.referencia,clientes_envios.telefono

		FROM clientes_envios 
		INNER JOIN clientes ON clientes.idcliente=clientes_envios.idcliente
		LEFT JOIN municipios ON municipios.id =clientes_envios.municipio
		LEFT join estados ON estados.id=clientes_envios.estado
		LEFT JOIN pais ON pais.idpais=clientes_envios.pais
		WHERE clientes.no_cliente ='$this->no_cliente'   AND clientes.idempresas='$this->idempresa'";
		
	
		$lista = $this->db->consulta($sql);
		return $lista;
	}

		public function ObtenerDirecciones2()
	{
		$sql = "SELECT clientes_envios.idclientes_envios,clientes_envios.direccion,clientes_envios.no_ext,clientes_envios.no_int,clientes_envios.col,clientes_envios.ciudad,clientes_envios.estado,clientes_envios.pais,clientes_envios.cp,pais.idpais as idpais,
				pais.pais as nombrepais,
				estados.id as idestado,
				estados.nombre as nombreestado,
				municipios.id AS idmunicipio,
				municipios.nombre AS nombremunicipio,
				clientes.idcliente,
			clientes_envios.referencia,clientes_envios.telefono


		FROM clientes_envios 
		INNER JOIN clientes ON clientes.idcliente=clientes_envios.idcliente
		LEFT JOIN municipios ON municipios.id =clientes_envios.municipio
		LEFT join estados ON estados.id=clientes_envios.estado
		LEFT JOIN pais ON pais.idpais=clientes_envios.pais
		WHERE clientes.idcliente ='$this->idCliente'   AND clientes.idempresas='$this->idempresa'";
		
	
		$lista = $this->db->consulta($sql);
		return $lista;
	}
	

	public function ActualizarTelefono()
	{
		$sql = "UPDATE clientes SET telefono='$this->telefono'
		WHERE idcliente='$this->idCliente'";
		$r = $this->db->consulta($sql);
		return $r; 
	}
	
	public function Obtenerdireccion($iddireccion)
	{
		$sql = "SELECT 
		clientes_envios.*,

		pais.idpais as idpais,
		pais.pais as nombrepais,
		estados.id as idestado,
		estados.nombre as nombreestado,
		municipios.id AS idmunicipio,
		municipios.nombre AS nombremunicipio
	
		
		FROM
		clientes_envios
		LEFT JOIN municipios ON municipios.id =clientes_envios.municipio
		LEFT join estados ON estados.id=clientes_envios.estado
		LEFT JOIN pais ON pais.idpais=clientes_envios.pais
		 clientes_envios.idclientes_envios=".$iddireccion."";

	
		$lista = $this->db->consulta($sql);
		return $lista;
	}

	public function ObtenerMonedero()
	{
		$sql="SELECT *from cliente_monedero WHERE idcliente=$this->idCliente";

		$lista = $this->db->consulta($sql);
		return $lista;
	}


		public function ActualizarClienteRFC()
	{
		$query="UPDATE clientes SET 
		fis_razonsocial='$this->fis_razonsocial',
		fis_rfc='$this->fis_rfc',
		fis_direccion='$this->fis_direccion',
		fis_no_int='$this->fis_no_int',
		fis_no_ext='$this->fis_no_ext',
		fis_col='$this->fis_col',
		fis_ciudad='$this->fis_ciudad',
		fis_estado='$this->fis_estado',
		fis_cp='$this->fis_cp',
		fis_municipio='$this->fis_municipio',
		correofiscal='$this->fis_correo'
		WHERE idcliente = '$this->idCliente'";
		
		
		
		$result = $this->db->consulta($query);
	}

	public function obtenerTorneos($idCliente)
	{
		$sql="SELECT *FROM torneocliente WHERE idcliente=".$idCliente."" ;
		$this->db->consulta($sql);
	}

	public function EliminarCliente()
	{
		$sql="DELETE FROM clientes where idcliente='$this->idCliente'";
		
		$this->db->consulta($sql);
	}
	
	
   public function ClienteRfc()
	{
		
		$sql="SELECT * FROM clientes_rfc WHERE idclientes_rfc='$this->idCliente_fiscal'";
		$rfc = $this->db->consulta($sql);
		return $rfc;
	}
	
	public function ClientesRfcs()
	{
		
		$sql="SELECT *FROM nota_remision WHERE no_cliente='".$nocliente."' and idempresas=".$idempresas."";
		$rfc = $this->db->consulta($sql);
		return $rfc;
	}
	
	public function GuardarClientesRfc()
	{
		
				$query="INSERT INTO clientes_rfc ( idcliente, tipo_persona,rfc, razonsocial, direccion, no_int, no_ext, col, ciudad, estado,pais, cp,email,telefono) VALUES ( '$this->idCliente','$this->fis_tipopersona', '$this->fis_rfc', '$this->fis_razonsocial', '$this->fis_direccion','$this->fis_no_int','$this->fis_no_ext', '$this->fis_col','$this->fis_ciudad','$this->fis_estado','$this->fis_pais' ,'$this->fis_cp','$this->fis_correo','$this->fis_telefono')";
				$result=$this->db->consulta($query);
				$this->idCliente_fiscal=$this->db->id_ultimo();
	}
	
	public function ModificarClienteRfc()
	{
		 $query="UPDATE clientes_rfc SET 
		tipo_persona = '$this->fis_tipopersona',
		razonsocial='$this->fis_razonsocial',
		rfc='$this->fis_rfc',
		direccion='$this->fis_direccion',
		no_int='$this->fis_no_int',
		no_ext='$this->fis_no_ext',
		col='$this->fis_col',
		ciudad='$this->fis_ciudad',
		estado='$this->fis_estado',
		pais = '$this->fis_pais',
		cp='$this->fis_cp',
		email='$this->fis_correo',
		telefono = '$this->fis_telefono'
		WHERE idclientes_rfc = '$this->idCliente_fiscal' ";
		
		
		
		$result = $this->db->consulta($query);
	}
	
	public function EliminarClientesRfc()
	{
		
			$sql="DELETE FROM clientes_rfc where idclientes_rfc='$this->idCliente_fiscal'";		
		    $this->db->consulta($sql);
		
	}
	
	public function PrincipalClientesRfc()
	{
		
		
		    $sql = "UPDATE clientes_rfc SET principal = 0 WHERE idcliente = $this->idCliente";
		    $this->db->consulta($sql);
		
			$sql="UPDATE clientes_rfc SET principal = 1 where idclientes_rfc='$this->idCliente_fiscal'";		
		    $this->db->consulta($sql);
		
	}

	public function ObtenerTokensfirebaseClientes()
	{
		$sql="SELECT GROUP_CONCAT(token) as token FROM clientetoken WHERE idcliente='$this->idCliente' ORDER BY idclientetoken ";

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


	public function Todoslosclientes()
	{
				
		$sql = "SELECT clientes.* FROM clientes  ";
	
	
		
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


	public function ObtenerClientesToken()
	{
		$sql = "SELECT
				clientes.nombre,
				clientes.paterno,
				clientes.materno,
				clientes.idcliente
				FROM
				clientetoken
				JOIN clientes
				ON clientetoken.idcliente = clientes.idcliente
				GROUP BY clientes.idcliente  ";
	
	
		
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


	public function ObtenerTokensfirebase()
	{
		$sql = "SELECT
				DISTINCT
			clientetoken.token,
			clientetoken.dispositivo,
			 clientetoken.uuid
		
			FROM
			clientetoken
			WHERE
			clientetoken.token !='null' and idcliente=0 and	clientetoken.token !='' ";
	
	
		
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
	

	public function ActualizarAnunciovisto()
	{
		$sql = "UPDATE clientes SET anunciovisto='$this->mostraranuncios'
		WHERE idcliente='$this->idCliente'";
		$r = $this->db->consulta($sql);
		return $r; 
	}
	
}
?>