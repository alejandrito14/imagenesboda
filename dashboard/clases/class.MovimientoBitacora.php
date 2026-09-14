<?php
require_once('class.Sesion.php');
require_once('class.Fechas.php');

 class MovimientoBitacora
 {
	 public $db;
	 private $sesion;
	 private $f;
	 public function MovimientoBitacora()
	 {
         
		 $this->sesion = new Sesion();
		 $this->f = new Fechas();
		 
		 		 
	 }// fin de MovimientoBitacora
	 
	 public function guardarMovimiento($modulo,$tabla,$descripcion)
	 {
		
		   
		   //$fechaactual = $this->f->fechaaYYYY_mm_dd_guion();
		   $idbitacora = $this->sesion->obtenerSesion('idbitacoraSAS');
		   
		   $query_movimiento = "INSERT INTO bitacora_movimientos (idbitacora,modulo,descripcion) VALUES ($idbitacora,'$modulo','$descripcion');";
		   
		 
		   
		  // echo $query_movimiento;
		   $this->db->consulta($query_movimiento);
		 
	 }// fin de guardarMovimiento
	 
 }// fin de clase MovimientoBitacora
?>