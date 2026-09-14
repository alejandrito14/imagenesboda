<?php
require_once("class.Sesion.php");



class AgregarComplemento
{
	public $db;
	public $pro;
	
	//Variables de objeto de clase

	public $se;
	public $con;
	public $cli;
	
	
	
	//Declaramos los objetos de clase
	function AgregarAComplemento()
	{

		$this->se = new Sesion();

	}
	
	//Funcion que sirve para guardar los productos en el carrito de compras
	public function AgregarAPaquete($idgrupo,$cantidad,$nombre,$sincoprecio,$multiple,$tope)
	{
		$bandera=0;
		
	    	//este if nos sirve para verificar que ya existe la sesion .
		
		if(!isset($_SESSION['CarritoComplemento']))
		{
				//Si no existe la sesion creamos una
			//$this->se->crearSesion('CarritoComplemento',null);
			$_SESSION['CarritoComplemento'] = array();

			$valor=$idgrupo.'|'.$cantidad."|".$nombre."|".$sincoprecio."|".$multiple."|".$tope;

			for ($i=0; $i <$cantidad ; $i++) { 
				array_push($_SESSION['CarritoComplemento'],$valor);

			}





		}else{

			$val=0;
				

					$valor=$idgrupo.'|'.$cantidad."|".$nombre."|".$sincoprecio."|".$multiple."|".$tope;		
					for ($i=0; $i <$cantidad ; $i++) { 
						array_push($_SESSION['CarritoComplemento'],$valor);

					}

					


			//	}




			}  //TERMINA EL ELSE

			
	 } //termina meotdos






	 public function VerCarrito()
	 {
	 	$total=0;

		//este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	 	if(!isset($_SESSION['CarritoComplemento']))
	 	{

	 		$li = '<tr> <td colspan="8" style="text-align: center">
	 		<h4 class="alert_warning">NO EXISTEN COMPLEMENTOS AGREGADOS.</h4>
	 		</td>
	 		</tr>';

	 		echo $li;

	 	}else{
				//Si existe la sesion la recorremos con un ciclo para verificar si el producto que se guardara ya existe
	 		$li = '';
	 		$cantidaddeprodutos = 0;
	 		$contador=0;
	 		$arrayopcion=array('NO','SI');

	 		foreach($_SESSION['CarritoComplemento'] as $k => $v)
	 		{  
	 			$cantidaddeprodutos ++;
	 			$producto_array = $k;	





	 			$producto_valores = explode("|",$v);

	 			$idgrupos = $producto_valores[0];
	 			$cantidad = $producto_valores[1];
	 			$nombre=$producto_valores[2];

	 			$sincoprecio=$producto_valores[3];

	 			$multiple=$producto_valores[4];

	 			$tope=$producto_valores[5];


	 			$li=$li.'<div class="card col-sm-12 col-md-12 complemento" style="float: left;" id="divcomplemento_'.$idgrupos.'" >
	 			<div class="card-header" style="background: #d7d7d7;" id="heading'.$k.'"">
	 			<div class="row">
				 <div class="col-md-2"></div>
				 <div class="col-md-8">
					<h5 class="mb-0" style="font-size: 2em!important;text-align: center;margin-bottom: 1em!important;" data-toggle="collapse" data-target="#collapse'.$k.'" aria-expanded="true" aria-controls="collapseOne">'.$nombre.'</h5>
					</h5>
				 </div>

				 <div class="col-md-2"></div>

	 			</div>

	 			<div class="row">

				 <div class="col-md-6"></div>


				 <div class="col-md-6">
				 
				 <h5 style="margin-left: 1em;" for="" class="mb-0">CON PRECIO: '.$arrayopcion[$sincoprecio].' </h5>
	 			<h5 style="margin-left: 1em;" for="" class="mb-0">OPCIÓN MÚLTIPLE: '.$arrayopcion[$multiple].' </h5>';

	 			 if ($multiple==1){
	 				
	 				$li=$li.'<h5 style="margin-left: 1em;" for="" class="mb-0">¿CUANTAS OPCIONES SE PUEDEN ELEGIR?</h5>';
	 				
	 				 } 



	 				$li=$li.'<div style="margin-top:1em;" class="col-md-4">';



	 				if ($multiple==1) {
	 				
	 			$li=$li.'<input type="number" min="0" class="form-control topes" id="comple_'.$k.'" value="'.$tope.'" onblur="CambiarTope('.$k.','.$tope.')" placeholder="Colocar tope">';
	 				}else{


	 			$li=$li.'<input type="number" min="0" style="display:none;" class="form-control topes" id="comple_'.$k.'" value="'.$tope.'" placeholder="Colocar tope">';

	 				}

				$li=$li.'

					</div>
				 </div>




	 			</div>
	 			<div class="row">
	 			</div>

	 			<div class="row">
	 			<div class="col-md-12">


	 			<div class="col-md-12" style="margin-top: 1em;
	 			">

	 			<button type="button" onclick="EliminarComplemento('.$k.')" class="btn btn-danger">ELIMINAR</button>
	 			</div>
	 			</div>

	 			</div>
	 			</div>

	 			<div id="collapse'.$k.'"" class="collapse " aria-labelledby="heading'.$k.'"" data-parent="#accordion">
	 			<div class="card-body">



	 			<div class="row">

	 			<div class="col-md-12">

	 			<div class="col-md-6" style="float: left;color: #4da84b;">OPCIÓN</div>

	 			<div class="col-md-6" style="float: left;color: #4da84b;">COSTO</div>

	 			</div>

	 			</div>';


	 			$sql="SELECT *FROM grupoopcion WHERE idgrupo=".$idgrupos."";

	 			$obtener=$this->db->consulta($sql);
	 			$numero=$this->db->num_rows($obtener);

	 			if ($numero>0) {
	 				# code...
	 			
	 			while($row=$this->db->fetch_assoc($obtener)){	
	 				
	 				$li=$li.'<div class="row">

	 				<div class="col-md-12">

	 				<div class="col-md-6" style="float: left;">'.$row['opcion'].'</div>

	 				<div class="col-md-6" style="float: left;">$'.$row['costo'].'</div>

	 				</div>

	 				</div>';

	 			} 

	 		}

	 			$li=$li.'</div>

	 			</div>
	 			

	 			</div>';

	 			$contador++;

				}    //TERMINA EL FOREACH
				
				



				echo $li;

			}  //TERMINA EL ELSE


		}



		public function CambiarValortope($posicion,$valor)
		{

			if(isset($_SESSION['CarritoComplemento']))
			{

				$itemsEnCesta = $_SESSION['CarritoComplemento'];
				$cantidad = count($itemsEnCesta); 

					foreach($_SESSION['CarritoComplemento'] as $k => $v)
					{ 

						if ($k==$posicion) {

								$producto_array = $k;	

					 			$producto_valores = explode("|",$v);

					 			$idgrupo = $producto_valores[0];
					 			$cantidad = $producto_valores[1];
					 			$nombre=$producto_valores[2];

					 			$sincoprecio=$producto_valores[3];

					 			$multiple=$producto_valores[4];

					 			$tope=$valor;

								$valor=$idgrupo.'|'.$cantidad."|".$nombre."|".$sincoprecio."|".$multiple."|".$tope;

								$_SESSION['CarritoComplemento'][$posicion] = $valor;

						}

						$contador++;


					}
				
			} 
	}// fin de método delProducto
	


		public function EliminarComplemento($variable)
		{

			if(isset($_SESSION['CarritoComplemento']))
			{

				$itemsEnCesta = $_SESSION['CarritoComplemento'];
				$cantidad = count($itemsEnCesta); 


				if($cantidad == 1){
					unset($_SESSION['CarritoComplemento']);
				}


				if ($cantidad>1) {
				# code...
					$contador=0;

					foreach($_SESSION['CarritoComplemento'] as $k => $v)
					{ 

						if ($k==$variable) {

							unset($_SESSION['CarritoComplemento'][$k]);

						}

						$contador++;


					}
				}
			} 
	}// fin de método delProducto
	
	
	public function EliminarCarrito()
	{
		
		if(isset($_SESSION['CarritoComplemento']))
		{
			unset($_SESSION['CarritoComplemento']);
		}

	}


	public function Reordenar()
	{

		array_values($_SESSION['CarritoComplemento']);

		
	}


	public function EliminarSillevaCero()
	{
		$contador=0;


		foreach($_SESSION['CarritoComplemento'] as $k => $v)
		{ 


			$producto_valores = explode("|",$v);

			$idgrupos = $producto_valores[0];
			$cantidad = $producto_valores[1];

			if ($cantidad<=0) {
				$this->EliminarProductoCarrito($contador);
			}

			$contador++;


		}
	}



	public function RestaraProducto($idproducto,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto)
	{

		$val=0;
		foreach($_SESSION['CarritoComplemento'] as $k => $v)
		{ 	


			$producto_valores = explode("|",$v);


						//En caso de que encuentre el producto le sumamos la cantidad agregada con la que ya tenia guardad
						//

			if ($producto_valores[0]==$idproducto) {


				$sub=(float)$producto_valores[4]+$subtotal;

				$cant=$producto_valores[1]-1;

				if ($cant<=0) {

					unset($_SESSION['CarritoComplemento'][$k]);



				}else{



					$subtotalme=$subtotalmedida+$producto_valores[6];

					$med =$medida;

					$valor=$idproducto.'|'.$cant."|".$nombre."|".$pm."|".$sub."|".$med."|".$subtotalme."|".$tipomedida."|".$codigoproducto;



					$_SESSION['CarritoComplemento'][$k]=$valor;
				}


			}


			$val++;
		}



	}


	public function SumaraProducto($idproducto,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto)
	{

		$val=0;
		foreach($_SESSION['CarritoComplemento'] as $k => $v)
		{ 	


			$producto_valores = explode("|",$v);


						//En caso de que encuentre el producto le sumamos la cantidad agregada con la que ya tenia guardad
						//

			if ($producto_valores[0]==$idproducto) {


				$sub=(float)$producto_valores[4]+$subtotal;

				$cant=$producto_valores[1]+1;




				$subtotalme=$subtotalmedida+$producto_valores[6];

				$med =$medida;

				$valor=$idproducto.'|'.$cant."|".$nombre."|".$pm."|".$sub."|".$med."|".$subtotalme."|".$tipomedida."|".$codigoproducto;



				$_SESSION['CarritoComplemento'][$k]=$valor;
				


			}


			$val++;
		}



	}

}