<?php
require_once("conexcion.php");
require_once("class.Sesion.php");
require_once("class.Funciones.php");
require_once("class.Fechas.php");

class Login
{
	private $db;//objeto de la clase de conexcion d la base de datos
	private $se;//objeto de la clase de sesion para crear sesiones en el servidor
	private $em;//objeto de la clase de empresas
	private $fn;//objeto de la clase de funciones
	private $fe;//objeto de la clase de fechas
	
	public $usuario;//nombre del usuario que quiere ingresar
	public $contrasena;//clave secreta del ususario que quiere ingresar
	public $tabla;//varibles que contendra el nombre de la tabla a usar para validar los datos
	public $email;//email del usuario que quiere recuperar su contraseña
	public $codservicio; //este valor lo ingresa el cliente, es el codigo de servicio.
	
	
	//funcion contructora de la clase
	public function Login()
	{
		$this->db = new MySQL();
		$this->se = new Sesion();
		$this->fn = new Funciones();
		$this->fe = new Fechas();
	}
	
	//funcion para comprobar la validez de los datos recibidos
	public function ValidandoDatos()
	{
		try
		{
			$db->conexcion();
			$query= "SELECT * FROM ".$this->tabla." WHERE usuario LIKE BINARY'".$this->usuario."' AND clave LIKE BINARY '".$this->contrasena."'";
			$resp=$this->db->consulta($query);


			$rows=$this->db->fetch_assoc($resp);
			$total=$this->db->num_rows($resp);
			
			if($total>0)
			{
				if($rows['estatus']==0)
				{
					return 2;
				}
				else
				{
					$this->se->crearSesion('se_SAS',1);
					$this->se->crearSesion('se_Empleado',$rows['nombre']);
					$this->se->crearSesion('se_sas_Perfil',$rows['idperfiles']);
					$this->se->crearSesion('se_sas_Usuario',$rows['idusuarios']);
					$this->se->crearSesion('se_sas_Tipo',$rows['tipo']);
					
					//$this->se->crearSesion('se_sas_Sucursal',$rows['idsucursales']);
																		
					$direccion_ip = $this->fn->d_ip();
					$so = $this->fn->sistema_o();
					$navegador = $this->fn->navegador();
					$fecha_ingreso = $this->fe->fecha_hora_segundos();
					$idusuario=$rows['idusuarios'];
					
					$query_usuario = "INSERT INTO bitacora(direccion_ip,sistema_operativo,navegador,fecha_ingreso,idusuarios) VALUES ('$direccion_ip','$so','$navegador','$fecha_ingreso',$idusuario)";
					$this->db->consulta($query_usuario);
					$this->se->crearSesion('idbitacoraSAS',$this->db->id_ultimo());
					
					//creando sesion para saber el tiempo de entrada
					$this->se->crearSesion('entradaSAS',time());			
					return 1;
				}
				
				
			}
			else
			{
				//return "El Usuario no existe";
				return 0;
			}
			
		}
		catch(Exception $e)
		{
			echo "Error. ".$e;
		}
	}
	//funcion para terminar una sesion activa en el sistema
	public function CerrarSesion()
	{
	}
	//funcion para recuperar clave
	public function RecuperarClave()
	{
		echo $query_clave="SELECT * FORM ".$this->tabla." WHERE email='".$this->email."' AND estatus=1";
		$resp= $this->db->consulta($query_clave);
		$rows= $this->db->fetch_assoc($resp);
		$total= $this->db->num_rows($resp);
		
		if($total==0)
		{ return 0;}
		else
		{ return $rows['nombre'].",".$rows['clave'].",".$rows['usuario'];}
	}
	
	

	
	
}
?>