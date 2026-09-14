<?php
require_once("class.Sesion.php");



class AgregarAproducto
{
	public $db;
	public $pro;
	
	//Variables de objeto de clase

	public $se;
	public $con;
	public $cli;
	
	
	
	//Declaramos los objetos de clase
	function AgregarAproducto()
	{

		$this->se = new Sesion();

	}
	
	//Funcion que sirve para guardar los productos en el carrito de compras
	public function AgregarAdescripcion($idinsumo,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto)
	{
		$bandera=0;
	    	//este if nos sirve para verificar que ya existe la sesion de apunta de venta.
		
		if(!isset($_SESSION['CarritoProducto']))
		{
				//Si no existe la sesion creamos una
			$this->se->crearSesion('CarritoProducto',null);
			$_SESSION['CarritoProducto'] = array();

			$valor=$idinsumo.'|'.$cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida."|".$codigoproducto;



			array_push($_SESSION['CarritoProducto'],$valor);




		}else{

			$val=0;
				//Si existe la sesion la recorremos con un ciclo para verificar si el producto que se guardara ya existe

			foreach($_SESSION['CarritoProducto'] as $k => $v)
			{ 	


				$producto_valores = explode("|",$v);


				

				if ($producto_valores[0]==$idinsumo) {


					$sub=(float)$producto_valores[4]+$subtotal;

					$cant=$producto_valores[1]+$cantidad;
					$subtotalme=$subtotalmedida+$producto_valores[6];

					$med =$medida;

					$valor=$idinsumo.'|'.$cant."|".$nombre."|".$pm."|".$sub."|".$med."|".$subtotalme."|".$tipomedida."|".$codigoproducto;



							//$_SESSION['CarritoProducto'][$k] = $cadena;
					$_SESSION['CarritoProducto'][$val]=$valor;

							//echo $_SESSION['CarritoProducto'][$k];
					$bandera=1;
					


				}
				$val++;

				}    //TERMINA EL FOREACH


				if ($bandera==0) {
					


					$valor =$idinsumo.'|'.$cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida."|".$codigoproducto;
					array_push($_SESSION['CarritoProducto'],$valor);
					


				}



				
			}  //TERMINA EL ELSE

			
	 } //termina meotdos

	 public function AgregarAdescripcion2($idinsumo,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto)
	 {
		 
		$bandera=0;
	    	//este if nos sirve para verificar que ya existe la sesion de apunta de venta.
		
		if(!isset($_SESSION['CarritoProducto']))
		{
				//Si no existe la sesion creamos una
			$this->se->crearSesion('CarritoProducto',null);
			$_SESSION['CarritoProducto'] = array();

			$valor=$idinsumo.'|'.$cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida."|".$codigoproducto;



			array_push($_SESSION['CarritoProducto'],$valor);




		}else{

			$val=0;
				//Si existe la sesion la recorremos con un ciclo para verificar si el producto que se guardara ya existe


			foreach($_SESSION['CarritoProducto'] as $k => $v)
			{ 	


				$producto_valores = explode("|",$v);


				if ($producto_valores[0]==$idinsumo) {


					$sub=0;

					$cant=$cantidad;
					$subtotalme=$subtotalmedida+$producto_valores[6];

					$med =$medida;

					$valor=$idinsumo.'|'.$cant."|".$nombre."|".$pm."|".$sub."|".$med."|".$subtotalme."|".$tipomedida."|".$codigoproducto;


					$_SESSION['CarritoProducto'][$k]=$valor;

							//echo $_SESSION['CarritoProducto'][$k];
					$bandera=1;
					


				}
				$val++;

				}    //TERMINA EL FOREACH


				if ($bandera==0) {
					


					$valor =$idinsumo.'|'.$cantidad."|".$nombre."|".$pm."|".$subtotal."|".$medida."|".$subtotalmedida."|".$tipomedida."|".$codigoproducto;
					array_push($_SESSION['CarritoProducto'],$valor);
					


				}



				
			}  //TERMINA EL ELSE


	 }




	 public function VerCarrito()
	 {
	 	$total=0;


		//este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	 	if(!isset($_SESSION['CarritoProducto']))
	 	{

	 		$li = '<tr> <td colspan="8" style="text-align: center">
	 		<h4 class="alert_warning">NO EXISTEN PRODUCTOS AGREGADOS.</h4>
	 		</td>
	 		</tr>';

	 		echo $li;

	 	}else{
				//Si existe la sesion la recorremos con un ciclo para verificar si el producto que se guardara ya existe
	 		$li = '';
	 		$cantidaddeprodutos = 0;
	 		$contador=0;

	 		foreach($_SESSION['CarritoProducto'] as $k => $v)
	 		{  
	 			$cantidaddeprodutos ++;
	 			$producto_array = $k;	





	 			$producto_valores = explode("|",$v);

	 			//print_r($producto_valores);

	 			$idinsumos = $producto_valores[0];
	 			$cantidad = $producto_valores[1];
	 			$nombre=$producto_valores[2];

	 			$pv = $producto_valores[3];
	 			$subtotal = $producto_valores[4];
	 			$medida = $producto_valores[5];
	 			$subtotalmedida=$producto_valores[6];

	 			$codigoproducto=$producto_valores[8];
	 			//$codigoproducto=$producto_valores[8];

	 			$li = $li .'<tr class="insumostabla" id="insumota_'.$idinsumos.'"> 

	 			<td align="center" style="text-align: center;" class="idinsummook" id="insumo_'.$idinsumos.'">'.$codigoproducto.'</td>
	 			<td align="center" style="text-align: center;" class="insumonombre" id="insumonombre_'.$idinsumos.'">'.$nombre.'</td>
	 			<td align="center" id="cantidad_'.$idinsumos.'" class="" style="text-align:center"> 

	 			<div class="btn-group" role="group" aria-label="Basic example">
	 			<button type="button" style="float: left;" class="btn " onclick="contadormenos2('.$idinsumos.')">-</button>

	 			<div class="input-group-prepend">
	 			<input style="width: 50px;text-align: center;float: left;" class="form-control insumocantidad" min="1" type="number" value="'.$cantidad.'" id="cantidadpro_'.$idinsumos.'" onblur="AgregarCantidad('.$idinsumos.')">

	 			</div>
	 			<button type="button" style="float: left;" class="btn " onclick="contadormas2('.$idinsumos.')">+</button>
	 			</div>


	 			</td>'  ;



	 			$li=$li."<td  align='center'>
	 			<button type='button' onclick='BorrarInsumoProducto(".$k.")' class='btn btn_rojo' style=' margin-right:10px;' title=''>
	 			<i class='mdi mdi-delete-empty'></i>
	 			</button>
	 			</td> 
	 			</tr>

	 			";

	 			$contador++;

				}    //TERMINA EL FOREACH
				
				   /*   $li = $li . '</ul>
					  					<BR>
										<h5>TOTAL</h5>
										<ul class="list-group">
											  <li class="list-group-item" style="text-align: right">CANTIDAD DE PRODUCTOS <span>'.$cantidaddeprodutos.'</span></li>
											  <li class="list-group-item" style="text-align: right">TOTAL $ <b>'. number_format($total,2,'.',',') .'</b></li>
											  <li class="list-group-item" style="text-align: CENTER"><a href="#" class="btn btn-success" onclick="ValidarToken(); "> GENERAR ORDEN</a> </li>

										</ul>	
										';*/




										echo $li;

			}  //TERMINA EL ELSE


		}



		public function EliminarProductoCarrito($idproducto)
		{

			if(isset($_SESSION['CarritoProducto']))
			{

				$itemsEnCesta = $_SESSION['CarritoProducto'];
				$cantidad = count($itemsEnCesta); 


				if($cantidad == 1){
					unset($_SESSION['CarritoProducto']);
				}


				if ($cantidad>1) {
				# code...
					$contador=0;

					foreach($_SESSION['CarritoProducto'] as $k => $v)
					{ 

						echo 'idproducto'.$idproducto.'-'.$k;



						if ($k==$idproducto) {

						
		//var_dump($_SESSION['CarritoProducto'][$idproducto]);
							unset($_SESSION['CarritoProducto'][$k]);




						}

						$contador++;


					}
				}
			} 
	}// fin de método delProducto
	
	
	public function EliminarCarrito()
	{
		
		if(isset($_SESSION['CarritoProducto']))
		{
			unset($_SESSION['CarritoProducto']);
		}

	}


	public function Reordenar()
	{

		array_values($_SESSION['CarritoProducto']);

		
	}


	public function EliminarSillevaCero()
	{
		$contador=0;


		foreach($_SESSION['CarritoProducto'] as $k => $v)
		{ 


			$producto_valores = explode("|",$v);

			$idinsumos = $producto_valores[0];
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
		foreach($_SESSION['CarritoProducto'] as $k => $v)
		{ 	


			$producto_valores = explode("|",$v);


						//En caso de que encuentre el producto le sumamos la cantidad agregada con la que ya tenia guardad
						//

			if ($producto_valores[0]==$idproducto) {


				$sub=(float)$producto_valores[4]+$subtotal;

				$cant=$producto_valores[1]-1;

				if ($cant<=0) {
					  		
					  	unset($_SESSION['CarritoProducto'][$k]);



				}else{



					$subtotalme=$subtotalmedida+$producto_valores[6];

					$med =$medida;

					$valor=$idproducto.'|'.$cant."|".$nombre."|".$pm."|".$sub."|".$med."|".$subtotalme."|".$tipomedida."|".$codigoproducto;



					$_SESSION['CarritoProducto'][$k]=$valor;
				}


			}


			$val++;
		}



	}


	public function SumaraProducto($idproducto,$cantidad,$nombre,$pm,$subtotal,$medida,$subtotalmedida,$tipomedida,$codigoproducto)
	{

		$val=0;
		foreach($_SESSION['CarritoProducto'] as $k => $v)
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



					$_SESSION['CarritoProducto'][$k]=$valor;
				


			}


			$val++;
		}



	}

}