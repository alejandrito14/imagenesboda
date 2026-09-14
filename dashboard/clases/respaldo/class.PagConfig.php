<?php
class Configuracion
{
	public $db;//objeto de conecxion con la base de datos
	
	public $idpagconfig;//ide del Cliente  
	public $ultimoIDConfiguracion;//ultimo id del Cliente
	

		
	public $telefono1;
	public $telefono2 ;
	public $telefono01800;
	
	public $celular ;
	public $celular2;
	public $emailsoporte ;
	public $emailpedido ;
	public $whatsapp;
	public $whatsapp2;
	
	public $cantidadminimo;
	public $costoenvio;
	
	
	
	public $facebook ;
	public $twitter ;
	public $rss ;
	public $delicious ;
	public $linkedin;
	public $flickr;
	public $skype;
	public $instagram ;
	public $googlemap;
	public $spei;
	public $otrometodo;		
	public $tarjeta;
	public $oxxo;
	public $llavepublica;
	public $llaveprivada;
	public $host;
	public $puerto;
	public $usuario;
	public $contrasena; 
	public $remitente;
	public $nombreremitente;
	public $smtauth;
	public $seguridad;
	public $negocio;
	public $bienvenida;
	public $diasvencimiento;
	public $nombrenegocio1;
	public $texto1;
	public $bloquearediciondatoscliente;
	//funcion para guarda una nueva empresas
	public function GuardarNewConfiguracion()
	{
		$query="INSERT INTO pagina_configuracion (telefono, telefono1, cel, cel1, emailsoporte, emailpedidos, facebook, twitter, rss, delicious, linkedin, flickr,  skype, instagram, googlemap,whatsapp,whatsapp2,telefono01800,pagollamada,		
			pagotarjeta,pagooxxopay,setPublicKey,setApikey,host	,puertoenvio,nombreusuario,contrasena, remitente,remitente_nombre,r_autenticacion,r_ssl,pagospei,nombrenegocio,bienvenida,montominimo,costoenvio,dias_vencimiento,nombrenegocio1,texto1,ediciondedatoscliente) VALUES ('$this->telefono1', '$this->telefono2', '$this->celular', '$this->celular2', '$this->emailsoporte', '$this->emailpedido', '$this->facebook', '$this->twitter', '$this->rss', '$this->delicious', '$this->linkedin', '$this->flickr', '$this->skype', '$this->instagram', '$this->googlemap','$this->whatsapp','$this->whatsapp2','$this->telefono01800',''$this->otrometodo','$this->tarjeta','$this->oxxo','$this->llavepublica','$this->llaveprivada','$this->host','$this->puerto','$this->usuario','$this->contrasena','$this->remitente','$this->nombreremitente','$this->smtauth','$this->seguridad','$this->negocio','$this->bienvenida','$this->cantidadminimo','$this->costoenvio','$this->diasvencimiento','$this->nombrenegocio1','$this->texto1','$this->bloquearediciondatoscliente')";
		
		//die ($query);
		$result=$this->db->consulta($query);
		$this->idpagconfig=$this->db->id_ultimo();
	}
	
	
	//funcion para modificar los datos de la empresas
	public function ModificarConfiguracion()
	{
		 $query="UPDATE pagina_configuracion SET
		telefono = '$this->telefono1', 
		telefono1 = '$this->telefono2', 
		cel='$this->celular' , 
		cel1= '$this->celular2', 
		emailsoporte = '$this->emailsoporte', 
		emailpedidos= '$this->emailpedido', 
		facebook='$this->facebook', 
		twitter='$this->twitter', 
		rss='$this->rss', 
		delicious='$this->delicious', 
		linkedin='$this->linkedin', 
		flickr='$this->flickr',  
		skype='$this->skype', 
		instagram='$this->instagram',
		googlemap='$this->googlemap', 
		whatsapp = '$this->whatsapp',
		whatsapp2= '$this->whatsapp2',
		telefono01800 = '$this->telefono01800',
		pagollamada	='$this->otrometodo',		
		pagotarjeta='$this->tarjeta',
		pagooxxopay='$this->oxxo',
		setPublicKey='$this->llavepublica',
		setApikey='$this->llaveprivada',
		host	='$this->host',
		puertoenvio	='$this->puerto',
		nombreusuario	='$this->usuario',
		contrasena	='$this->contrasena', 
		remitente	='$this->remitente',
		remitente_nombre='$this->nombreremitente',
		r_autenticacion	='$this->smtauth',
		r_ssl='$this->seguridad',
		pagospei='$this->spei',
		nombrenegocio='$this->negocio',
		bienvenida='$this->bienvenida',
		montominimo='$this->cantidadminimo',
		costoenvio='$this->costoenvio',
		dias_vencimiento='$this->diasvencimiento',
		nombrenegocio1='$this->nombrenegocio1',
		texto1='$this->texto1',
		ediciondedatoscliente='$this->bloquearediciondatoscliente'
		WHERE idpagina_configuracion = '$this->idpagconfig'";
		
		
		$result = $this->db->consulta($query);
	}

	
	
	//funcion para obtener la informacion de la empresa
	public function ObtenerInformacionConfiguracion()
	{
		
				$query="SELECT  *, count(idpagina_configuracion) as cuantos FROM pagina_configuracion";
				
				$resp=$this->db->consulta($query);
				$rows=$this->db->fetch_assoc($resp);
				$total = $this->db->num_rows($resp);				
				return $rows;
		
	}
	
	
		
}
?>