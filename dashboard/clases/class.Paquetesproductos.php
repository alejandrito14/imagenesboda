<?php
class Paquetesproductos
{
	
	/* ================= DECLARACION DE VARIABLES ====================== */
	
	public $db;
	public $idpaquetesproductos;
	public $idpaquete;
	public $idproducto;
	public $cantidad;
	public $pv;
	public $subtotal;
	public $medida;
	public $subtotalmedida;
	


	
	/* ================================================================= */
	
	/* ================= COMENZAN METODOS DE CLASE ===================== */
	
	//Funcion que sirve para obtener la lista del filtro

	
	//Funcion que sirve para buscar un producto
	public function buscarProducto()
	{
		$query = "SELECT * FROM productos WHERE idproducto = '$this->idproducto'";
		$result = $this->db->consulta($query);
		return $result;
	}
	
	
	public function ObtenerDescripcionPaquete()
	{
		
		$query="SELECT
		paquetesproducto.idproducto,
		paquetesproducto.cantidad,
		paquetesproducto.idpaquete,
		productos.codigoproducto,
		productos.nombre

		FROM
		paquetesproducto
		JOIN productos
		ON paquetesproducto.idproducto = productos.idproducto WHERE paquetesproducto.idpaquete=".$this->idpaquete."";



		$result = $this->db->consulta($query);
		return $result;
	}
	

	
	public function obtenerPrecio()
	{
		
		
		$sql = "select * from categoria_precio where estatus=1";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	
	//Funcion que sirve para guardar un producto
	public function guardarPaqueteDescripcion()
	{
		$query = " INSERT INTO paquetesproducto (idproducto,cantidad,medida,subtotalmedida,idpaquete) VALUES ('$this->idproducto','$this->cantidad','$this->medida','$this->subtotalmedida','$this->idpaquete');";

		$this->db->consulta($query);
		
		//$this->idproductos_descripcion = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modifcar un producto
	public function modificarProducto()
	{
		$query = "UPDATE productos SET idcategoria_precio = '$this->precio', idcategorias = '$this->categoria', nombre = '$this->nombre', descripcion = '$this->descripcion', descuento = '$this->descuento', idtipo_presentacion = '$this->presentacion', estatus = '$this->estatus', idempresas = '$this->empresa' WHERE idproducto = '$this->idproducto'";
		$this->db->consulta($query);
	}
	
	public function ObtenerProductosdescripcion ($codproducto,$empresa)
	{
		
		$sql="SELECT pd.idempresas,
		pd.idproducto,
		pd.subtotalmedida,
		pd.subtotal,
		insumos.idtipo_medida,
		insumos.idinsumos,
		insumos.nombre AS nombreinsumo,
		tipo_medida.nombre AS nombretipomedida FROM productos_descripcion AS pd
		INNER JOIN insumos on pd.idinsumos=insumos.idinsumos AND insumos.idempresas = '$empresa'
		INNER JOIN tipo_medida ON insumos.idtipo_medida = tipo_medida.idtipo_medida

		WHERE pd.idproducto = '$codproducto' AND pd.idempresas='$empresa' ";

		

		$resp=$this->db->consulta($sql);
		return $resp;

	}

	
	

	
}
?>