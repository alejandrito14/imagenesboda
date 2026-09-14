<?php
class Insumos
{
	public $db;
	public $idinsumos;
	public $idtipo_medida;
	public $idempresas;
	public $nombre;
	public $descripcion;
	public $cantidad;
	public $estatus;
	
	
	//datos para guardar los rangos
	
	public $idprecios_rango;
	public $rangoinicial;
	public $rangofinal;
	public $pm;
	
	
	
	
	public $tipo_usuario;
	public $lista_empresas;
	
	public $idcategoriaprecios;
	private $idproductos_modificaciones ;
	public $tipo_medida;

	
	//Funcion que sirve para buscar una paqueteria
	
	public function BuscarInsumosFacturacion()
		{
			$idempresa = $this->idempresas;
			$idinsumo = $this->idinsumos;
			$nombreinsumo = $this->nombre;
			
			
			$sql_idinsumo = ($idinsumo != "") ? " AND i.idinsumos LIKE '%$idinsumo%' " : " ";
			$sql_nombreinsumo = ($nombreinsumo != "") ? " AND i.nombre LIKE '%$nombreinsumo%' " : " ";			
			
			  $sql = "SELECT i.*,em.empresas as nombreempresa FROM insumos i 
			 		INNER JOIN empresas em ON em.idempresas = i.idempresas
			 		WHERE i.idempresas = $idempresa $sql_idinsumo $sql_nombreinsumo";
			
		    $result = $this->db->consulta($sql);
		    return $result;
						
		}
	
	
	
	
	
	
		public function Lista_Insumos()
	{
			
			if($this->tipo_usuario != 0)
			{
				$SQLempresas = " WHERE i.idempresas IN ($this->lista_empresas)";
			}else{
				$SQLempresas = "";
			}
			
			
			
		$sql = "SELECT i.*, e.empresas, tp.nombre as medida FROM insumos i
				INNER JOIN empresas e ON e.idempresas = i.idempresas
				INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
				$SQLempresas ORDER BY  i.idempresas, i.idinsumos";	
		
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	
	
	public function buscar_Insumos()
	{
		$sql = "SELECT * FROM insumos WHERE idinsumos = '$this->idinsumos' and idempresas = '$this->idempresas'";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para guardar una paqueteria
	public function guardar_insumos()
	{
		 $sql = "INSERT INTO insumos (idinsumos,idtipo_medida,nombre,descripcion,cantidad,estatus,idempresas) VALUES ('$this->idinsumos','$this->idtipo_medida','$this->nombre','$this->descripcion','$this->cantidad','$this->estatus','$this->idempresas');";
		$this->db->consulta($sql);
		$this->idinsumos = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modifcar una paqueteria
	public function modificar_insumos()
	{
		$sql = "UPDATE insumos SET 
		      	idtipo_medida='$this->idtipo_medida',
				nombre='$this->nombre',
				descripcion='$this->descripcion',
				cantidad='$this->cantidad',
				estatus='$this->estatus'
				WHERE idinsumos = '$this->idinsumos' AND idempresas='$this->idempresas'";
		      $this->db->consulta($sql);
	}
	
	public function guardar_rango()
	{
		
		//vamos a indentificar si ya existe un rango para esa empresa si no existe vamos a colocar como precio base el preimer precio.
		
		$sql = "SELECT * FROM precios_rango WHERE idinsumos = '$this->idinsumos' AND idempresas = '$this->idempresas'";
		$consulta_base = $this->db->consulta($sql);
		$consulta_base_num = $this->db->num_rows($consulta_base);
		
		if($consulta_base_num != 0)
		{
			$base = 0;
		}
		else
		{
			$base = 1;
		}
		
		
		
		$sql = "INSERT INTO precios_rango (idinsumos,idempresas,ri,rf,pm,bandera_pb) VALUE ('$this->idinsumos','$this->idempresas','$this->rangoinicial','$this->rangofinal','$this->pm','$base')";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
		
	public function modificar_rango()
	{
		
	try{
		
		
   
		
		
		$sql = "UPDATE precios_rango  SET
		ri='$this->rangoinicial',
		rf='$this->rangofinal',
		pm = '$this->pm'
		WHERE  idprecios_rango = '$this->idprecios_rango'";
		$result = $this->db->consulta($sql);

		
		//analizamos si el precio rango es base, si es base entramos a un if para modificar las otras tablasd.
		
		
		$sql = "SELECT * FROM precios_rango WHERE idprecios_rango = '$this->idprecios_rango'";
		$result_base = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result_base);
		
		$valorbase = $result_row ['bandera_pb'];


		
		if($valorbase != 0)
		{
			
			
			
       //buscamos todos los id de los productos a los cuales les afecta el cambio de precio en el insumo
			
			
		 $sql= "SELECT GROUP_CONCAT(idproducto) AS idproductos FROM productos_descripcion
			WHERE idinsumos = '$this->idinsumos' AND idempresas = '$this->idempresas' ";
			
		
		$result = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result);
		$result_num = $this->db->num_rows($result);

		
		
				if($result_row['idproductos'] !=NULL )
				{

					$str = $result_row['idproductos'];
					$array = explode(",",$str);
					$cuantos = count($array);

					   for($i = 0; $i <= $cuantos - 1; $i++ )
						{
						   $idproducto = $array[$i];
						   $idinsumo = $this->idinsumos;
						   $idempresas = $this->idempresas;
						   $pv = $this->pm;


						   
						   
						   
						$sql_producto_descripcion = "UPDATE productos_descripcion SET pv = $pv , subtotal = $pv * subtotalmedida 
														WHERE idinsumos = '$idinsumo' 
														AND idempresas = '$idempresas' 
														AND idproducto = '$idproducto'";
						   
						 $this->db->consulta($sql_producto_descripcion);
						 
						 
						   
						   //con el cambio de precio base volvemos a sumar los otales del producto para actualizar su precio venta.
						   
						  $slq_actualizarProducto = "SELECT  SUM(subtotal) as total from productos_descripcion WHERE idproducto = '$idproducto' AND idempresas = '$idempresas'";
						  $result_suma = $this->db->consulta($slq_actualizarProducto); 
						  $result_suma_total = $this->db->fetch_assoc($result_suma); 
						   
						  $total = $result_suma_total['total'];
						   
				           //actualizamos el precio venta del producto.
						   
						  $sql_precio_venta = "UPDATE productos SET pu = $total WHERE  idproducto = '$idproducto' AND idempresas = '$idempresas'";

						 
						  $this->db->consulta($sql_precio_venta);
						 
						} //cerramos el for
					
				  } //cerramos el if de resultados de id productos.
		  }//cerramos el if de si es valor base
		else
		{
			echo "No Entro a valor base";
		}
		
		return;
	}catch(Exception $e)
		{
			$db->rollback();

			$error = $db->m_error($e->getCode());

			echo $error;
		}
			
	}//cerramos el metodo.
	
		public function BorrarInsumo()
	{
		$sql = "DELETE FROM insumos WHERE idinsumos = '$this->idinsumos' AND idempresas = '$this->idempresas'";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	public function ListadeRangosInsumo()
	{
	      $sql = "SELECT pr.*, i.nombre as insumo, tp.nombre as medida FROM precios_rango pr
		         INNER JOIN insumos i ON i.idinsumos = pr.idinsumos AND i.idempresas = pr.idempresas
				 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
		 		 WHERE pr.idinsumos = '$this->idinsumos' AND pr.idempresas = '$this->idempresas' ";
		$result = $this->db->consulta($sql);
		return $result;
		
	}
	
		public function ObtenerRango()
	{
	      $sql = "SELECT pr.*, i.nombre as insumo, tp.nombre as medida FROM precios_rango pr
		         INNER JOIN insumos i ON i.idinsumos = pr.idinsumos AND i.idempresas = pr.idempresas
				 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
		 		 WHERE pr.idprecios_rango = '$this->idprecios_rango' ";
		$result = $this->db->consulta($sql);
		return $result;
		
	}
	
	public function BorrarRango()
	{
		echo $sql = "DELETE FROM precios_rango WHERE idprecios_rango = '$this->idprecios_rango' ";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
public function ObtenerInsumo($idinsumo,$idempresa)
	{

	$sql="SELECT i.*, e.empresas, tp.nombre as medida FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 	
	 WHERE i.idempresas ='$idempresa' AND i.idinsumos='$idinsumo' 
  	ORDER BY  i.idempresas, i.idinsumos ";

	
	 $result = $this->db->consulta($sql);
	 return $result;
	}
	
	public function ObtenerInsumoSincategoria()
	{

	$sql="SELECT i.*, e.empresas, tp.nombre as medida FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 	
	 WHERE i.idempresas ='$this->lista_empresas'  AND i.idtipo_medida='$this->tipo_medida'
  	ORDER BY  i.idempresas, i.idinsumos ";
  	
  
	
	 $result = $this->db->consulta($sql);
	 return $result;
	}

	public function Lista_InsumosProductos()
	{

	/*$sql="SELECT i.*, e.empresas, tp.nombre as medida,pr.pm as pv FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 	 INNER join precios_rango pr ON pr.idinsumos=i.idinsumos and pr.idempresas=i.idempresas
	 WHERE i.idempresas ='$this->lista_empresas' and pr.bandera_pb=1
  	ORDER BY  i.idempresas, i.idinsumos ";*/

  	$sql="SELECT i.*, 
		tp.nombre AS medida, 
		insumos_categoria_precios.idinsumos, 
		i.idtipo_medida, 
		i.nombre, 
		i.descripcion, 
		i.estatus, 
		i.cantidad, 
		categoria_precios.idcategoria_precios, 
		categoria_precios.categoria, 
		insumos_categoria_precios.idempresas, 
		insumos_categoria_precios.idcategoria_precios
	FROM insumos i INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
		 INNER JOIN insumos_categoria_precios ON insumos_categoria_precios.idinsumos = i.idinsumos
		 INNER JOIN categoria_precios ON insumos_categoria_precios.idcategoria_precios = categoria_precios.idcategoria_precios
		 INNER JOIN empresas ON insumos_categoria_precios.idempresas = empresas.idempresas
	WHERE insumos_categoria_precios.idempresas =$this->lista_empresas AND  insumos_categoria_precios.idcategoria_precios=$this->idcategoriaprecios
	GROUP BY i.idinsumos
	ORDER BY i.idempresas ASC, i.idinsumos ASC ";



	 $result = $this->db->consulta($sql);
	 return $result;
	}
	


	public function Lista_InsumosProductos2($busqueda)
	{

		$sql="SELECT i.*, 
		tp.nombre AS medida, 
		insumos_categoria_precios.idinsumos, 
		i.idtipo_medida, 
		i.nombre, 
		i.descripcion, 
		i.estatus, 
		i.cantidad, 
		categoria_precios.idcategoria_precios, 
		categoria_precios.categoria, 
		insumos_categoria_precios.idempresas, 
		insumos_categoria_precios.idcategoria_precios
	FROM insumos i INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
		 INNER JOIN insumos_categoria_precios ON insumos_categoria_precios.idinsumos = i.idinsumos
		 INNER JOIN categoria_precios ON insumos_categoria_precios.idcategoria_precios = categoria_precios.idcategoria_precios
		 INNER JOIN empresas ON insumos_categoria_precios.idempresas = empresas.idempresas
	WHERE insumos_categoria_precios.idempresas =$this->lista_empresas AND  insumos_categoria_precios.idcategoria_precios=$this->idcategoriaprecios";

	 $sql .= ($busqueda != '') ? " AND i.nombre LIKE '%{$busqueda}%' ":" ";

	  $sql .=  ($busqueda != '') ? " OR i.idinsumos LIKE '%{$busqueda}%' ":" ";

	  $sql.=" GROUP BY i.idinsumos";
  	$sql.=" ORDER BY  i.idempresas, i.idinsumos ";

	 $result = $this->db->consulta($sql);
	 return $result;
	}


	public function Lista_InsumosProductosInventario()
	{

	$sql="SELECT i.*, e.empresas, tp.nombre as medida FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 	
	 WHERE i.idempresas ='$this->lista_empresas' 
  	ORDER BY  i.idempresas, i.idinsumos ";

	
	 $result = $this->db->consulta($sql);
	 return $result;
	}
	
	public function ObtenerInsumoEntrada($idinsumo,$idempresa)
	{

	$sql="SELECT i.*, e.empresas,tp.idtipo_medida, tp.nombre as medida FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 WHERE i.idempresas ='$idempresa' AND i.idinsumos='$idinsumo' 
  	ORDER BY  i.idempresas, i.idinsumos ";

	
	 $result = $this->db->consulta($sql);
	 return $result;
	}


	public function ValidarInsumos($idempresa,$idinsumo)
	{
		
	$sql="SELECT i.*, e.empresas,tp.idtipo_medida, tp.nombre as medida FROM insumos i
	 	 INNER JOIN empresas e ON e.idempresas = i.idempresas
	 	 INNER JOIN tipo_medida tp ON tp.idtipo_medida = i.idtipo_medida
	 WHERE i.idempresas ='$idempresa' AND i.idinsumos='$idinsumo' 
  	ORDER BY  i.idempresas, i.idinsumos ";


	 $result = $this->db->consulta($sql);
	 return $result;
	}


	public function VerificarLoteEntrada()
	{
		$sql="SELECT *FROM";
		
	}
	
	
}
?>