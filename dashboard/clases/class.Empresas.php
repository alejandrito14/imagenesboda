<?php
class Empresas
{
	
	public $db;
	
	public $idempresas;
	public $empresas;
	public $direccion;
	public $telefono;
	public $email;
	public $contactos;
	public $f_rfc;
	public $f_razonsocial;
	public $f_calle;
	public $f_no_ext;
	public $f_no_int;
	public $f_colonia;
	public $f_ciudad;
	public $f_estado;
	public $f_cp;
	public $estatus;
	public $f_pais;
	public $f_municipio;
	
	//validacione de tipo de usuario
	
	public $tipo_usuario;
	public $lista_empresas;
	
	
	
	//Funcion que nos regresa todos los registros de la tabla empresas
	public function obtenerTodas()
	{

		//echo $this->tipo_usuario.'-'.$this->lista_empresas;
		if($this->tipo_usuario != 0)
		{
		  
			if($this->lista_empresas != 0)
			{
				$SQLidempresas = " AND idempresas IN ($this->lista_empresas)";
			}else
			{
				$SQLidempresas = "";
			}
				
		}else
		{
		   $SQLidempresas = "";
		}
		
		
		
		 $sql = "SELECT * FROM empresas WHERE 1=1 $SQLidempresas";

		//echo $sql;
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
		//Funcion que nos regresa los registros de la tabla empresas según el filtro
	public function obtenerFiltro()
	{
		
		
		if($this->tipo_usuario != 0)
		{
		  
				if($this->idempresas != 0)
				{

					$SQLidempresas = "AND idempresas = $this->idempresas";
				}else
				{
				   $SQLidempresas = "AND idempresas IN ($this->lista_empresas)";
				}
		
		}else
		{
			$SQLidempresas = "";
		}
		
		
		 $sql = "SELECT * FROM empresas WHERE estatus = '$this->estatus'  $SQLidempresas ";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	//Funcion que regresa empresas que estan habilitadas en su estatus como activado
	public function obtenerActivadas()
	{
		$sql = "SELECT * FROM empresas WHERE estatus = '1'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}


	
	//Funcion que sirve para obtener un registro especifico de la tabla empresas
	public function buscarEmpresa()
	{
		$sql = "SELECT * FROM empresas
		LEFT JOIN municipios ON municipios.id=empresas.f_municipio
		LEFT JOIN estados ON estados.id =empresas.f_estado
		LEFT JOIN pais ON pais.idpais=empresas.f_pais
		 WHERE idempresas = '$this->idempresas'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	//Funcion que guarda un registro en la tabla empresas
	public function guardarEmpresa()
	{
		$sql = "INSERT INTO empresas (empresas,direccion,telefono,email,contactos,f_rfc,f_razonsocial,f_calle,f_no_ext,f_no_int,f_colonia,f_ciudad,f_estado,f_cp,estatus,f_pais,f_municipio) VALUES ('$this->empresas','$this->direccion','$this->telefono','$this->email','$this->contactos','$this->f_rfc','$this->f_razonsocial','$this->f_calle','$this->f_no_ext','$this->f_no_int','$this->f_colonia','$this->f_ciudad','$this->f_estado','$this->f_cp','$this->estatus','$this->f_pais','$this->f_municipio');";
		$resp = $this->db->consulta($sql);
		$this->idempresas = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modificar un registro en la tabla empresas
	public function modificarEmpresa(){
		$sql = "UPDATE empresas SET empresas = '$this->empresas', direccion = '$this->direccion', telefono = '$this->telefono', email = '$this->email', contactos = '$this->contactos', f_rfc = '$this->f_rfc', f_razonsocial = '$this->f_razonsocial', f_calle = '$this->f_calle', f_no_ext = '$this->f_no_ext', f_no_int = '$this->f_no_int', f_colonia = '$this->f_colonia', f_ciudad = '$this->f_ciudad', f_estado = '$this->f_estado', f_cp = '$this->f_cp', estatus = '$this->estatus',f_pais='$this->f_pais',f_municipio='$this->f_municipio' WHERE idempresas = '$this->idempresas'";
		$this->db->consulta($sql);
	}

	public function AsignarUsuariosEmpresas()
	{
		$sql="INSERT INTO acceso_empresa_empleado(idempresas,idusuarios) VALUES ($idempresas,$idusuarios)";

		$this->db->consulta($sql);
	}

	public function guardarEnFoliosEmpresas()
	{
		$sql="INSERT INTO empresas_folios (idempresas) VALUES ($this->idempresas)";

		$this->db->consulta($sql);
	}
	

	
	
	
}
?>