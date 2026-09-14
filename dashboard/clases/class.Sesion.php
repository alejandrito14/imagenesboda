<?php
class Sesion 
{
	//funcion contructora de la clase
	public function __construct()
	{
		if(!isset($_SESSION))
		{
			session_start();

			//$inactivo = 20;
		 	$inactivo =43200;
		 
			if(isset($_SESSION['tiempo']) ) {
			$vida_session = time() - $_SESSION['tiempo'];
				if($vida_session > $inactivo)
				{
					session_destroy();
					//header("Location: login.php");
					/*echo '<script type="text/javascript">iraLogin();</script>'; */
				}
			}
		 
			$_SESSION['tiempo'] = time();
		}
		
		//echo $vida_session." - ".$inactivo."  ".$_SESSION['tiempo']." sd";

	}
	//funcion para crear una nueva varibles de secion y asignar un valor
	
	public function crearSesion($nombre, $valor) 
	{
		/*ini_set("session.cookie_lifetime","43200");
		ini_set("session.gc_maxlifetime","43200");*/
		$_SESSION [$nombre] = $valor;


	}
	
	
	//funcion que busca y regresa el valor de una varibles de sesion
	public function obtenerSesion($nombre)
	{
		if (isset ( $_SESSION [$nombre] ))
		{
			return $_SESSION [$nombre];
		}
		else
		{
			return false;
		}
	}

	
	
	
	//funcion para matar todas la varibles de sesion que existan
	public function terminarSesion() 
	{
		$_SESSION = array();
		session_destroy ();
	}
	
	
	
   public function EliminarVariableSesion($nombre)
	{
		
		if(isset($_SESSION[$nombre]))
	  {
			unset($_SESSION[$nombre]);
	  }

	}
	
	
	
}
?>
