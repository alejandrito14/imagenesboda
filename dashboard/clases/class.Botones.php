<?php
class Botones_permisos
{
	/*================================*
	*  Proyecto: IIS	  *
	*  Compañia: CAPSE 				  *
	*  Fecha: 24/08/2019     		  *
	* MSD. José Luis Gómez Aguilar   *
	*=================================*/
	
	
	/* ============== Declaración de variables ==============*/
	
	public $titulo;
    public $title;
	public $funcion;
	public $permiso;
	public $icon;
	public $estilos;
	
	 // 1 = guardar, 2 = modificar, 3 = eliminar 
	public $tipo;
	public $class;
	
	/*=======================================================*/
	/* ============ Inicia metodos de clase =================*/
	
	//Funcion que sirve para construir un boton de acuerdo a la configuracion de permisos
	public function armar_boton()
	{
		$permisos = explode("|",$this->permiso);


		if ($this->class=='') {
			
			$this->class='btn btn-primary';

		}
		switch($this->tipo)
		{
			case 1:
		


					if($permisos[0] == 1){

						
?>
						<button type="button" onClick="<?php echo $this->funcion; ?>" class="<?php echo $this->class; ?>" style="<?php echo $this->estilos; ?>" title="<?php echo $this->title; ?>">
<?php
							if($this->icon != ''){
?>
								<i class="mdi <?php echo $this->icon ?>"></i>
<?php
							}
							echo $this->titulo;
?>
						</button>

<?php
					}else{
						return;
					}
				break;
			case 2:
				if($permisos[1] == 1){

				//	$this->class='btn btn_colorgray';

?>
						<button type="button" onClick="<?php echo $this->funcion; ?>" class="<?php echo $this->class; ?>" style="<?php echo $this->estilos; ?>" title="<?php echo $this->title; ?>">
<?php
							if($this->icon != ''){
?>
								<i class="mdi <?php echo $this->icon ?>"></i>
<?php
							}
							echo $this->titulo;
?>
						</button>

<?php
					}else{
						return;
					}
				break;
			case 3:
				if($permisos[2] == 1){

					$this->class='btn btn_rojo';
?>
						<button type="button" onClick="<?php echo $this->funcion; ?>" class="<?php echo $this->class; ?>" style="<?php echo $this->estilos; ?>" title="<?php echo $this->title; ?>">
<?php
							if($this->icon != ''){
?>
								<i class="mdi <?php echo $this->icon ?>"></i>
<?php
							}
							echo $this->titulo;
?>
						</button>

<?php
					}else{
						return;
					}

					break;

						case 4:
				

					$this->class='btn btn_accion';
?>
						<button type="button" onClick="<?php echo $this->funcion; ?>" class="<?php echo $this->class; ?>" style="<?php echo $this->estilos; ?>" title="<?php echo $this->title; ?>">
<?php
							if($this->icon != ''){
?>
								<i class="mdi <?php echo $this->icon ?>"></i>
<?php
							}
							echo $this->titulo;
?>
						</button>

<?php
					
				break;


						case 5:
				if($permisos[0] == 1){

						


					$this->class='btn btn_azul';
?>
						<button type="button" onClick="<?php echo $this->funcion; ?>" class="<?php echo $this->class; ?>" style="<?php echo $this->estilos; ?>" title="<?php echo $this->title; ?>">
<?php
							if($this->icon != ''){
?>
								<i class="mdi <?php echo $this->icon ?>"></i>
<?php
							}
							echo $this->titulo;
?>
						</button>

<?php
				}else{
						return;
					}
					
				break;
				
		}		
	}
}
?>