<?php
class Productos
{
	
	/* ================= DECLARACION DE VARIABLES ====================== */
	
	public $db;
	public $idproducto;

	public $nombre;
	public $descripcion;
	public $precio;
	public $descuento ;
	public $empresa;
	public $categoria;
	public $presentacion;
	public $estatus ;
	public $precionormal;
	public $precioventa;
	public $lista_empresa;
	public $tipo_usuario;
	public $idcategoria_precios;

	public $idempresa;
	public $idsucursale;
	public $codigoproducto;
	public $v_idtipo_medida;
	/* ================================================================= */
	
	
	
		public function BuscarProductosFacturacion()
		{
			$idempresa = $this->idempresa;
			$idproducto = $this->idproducto;
			$nombreproducto = $this->nombre;
			
			
			$sql_idproducto = ($idinsumo != "") ? " AND p.idproducto LIKE '%$idproducto%' " : " ";
			$sql_nombreproducto = ($nombreinsumo != "") ? " AND p.nombre LIKE '%$nombreproducto%' " : " ";			
			
			$sql = "SELECT p.*, em.empresas as nombreempresa FROM productos p 
			 		INNER JOIN empresas em ON em.idempresas = p.idempresas
			 		WHERE p.idempresas = $idempresa $sql_idproducto $sql_nombreproducto";

		    $result = $this->db->consulta($sql);
		    return $result;
						
		}
	
	
	
	/* ================= COMENZAN METODOS DE CLASE ===================== */
	
	//Funcion que sirve para obtener la lista del filtro
	public function obtenerFiltro()
	{
		/*if($this->tipo_usuario != 0)
		{
			$SQLidempresas = "and empresas.idempresas IN ($this->lista_empresas)";
		}else
		{
			$SQLidempresas = "";
		}*/
		$query = "SELECT
		p.*,
		tipo_medida.nombre as tp
		FROM
		productos p
	
		left JOIN tipo_medida ON tipo_medida.idtipo_medida=p.idtipomedida

		WHERE 1=1 ";
		/*$query .= ($this->nombre != '')? " AND p.nombre LIKE '%$this->nombre%'":"";
		$query .= ($this->idproducto != '')? " AND p.idproducto = '$this->idproducto'":"";*/
		/*$query .= ($this->empresa != '')? " AND empresas.idempresas = '$this->empresa'":"";*/
		$query.=" ORDER BY p.idproducto asc";


		$result = $this->db->consulta($query);
		return $result;
	}
	
	public function obtenerFiltroporEmpresa()
	{
		$sql = " SELECT productos.idproducto, 
		tipo_presentacion.nombre as presentacion, 
		productos.nombre, 
		productos.foto, 
		productos.pv
		FROM productos INNER JOIN tipo_presentacion ON productos.idtipo_presentacion = tipo_presentacion.idtipo_presentacion
		WHERE productos.idempresas = $this->lista_empresa";		
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	
	
	//Funcion que sirve para buscar un producto
	public function buscarProducto()
	{
		$query = "SELECT * FROM productos WHERE idproducto = '$this->idproducto'";
		$result = $this->db->consulta($query);
		return $result;
	}
	
	public function NombreCategoria($id){
		$nombre="";
		if($id==0){
			$nombre= "No Asignado";
		}
		else {
			$sql ="select * from categorias where idcategorias='$id'";
			
			$result=$this->db->consulta($sql);
			$result_row=$this->db->fetch_assoc($result);
			$nombre=$result_row['categoria'];
		}
		
		return $nombre;
	}
	
	public function obtenerEmpresas()
	{
		if($this->tipo_usuario != 0)
		{
			$SQLidempresas = "and idempresas IN ($this->lista_empresas)";
		}else
		{
			$SQLidempresas = "";
		}
		
		
		
		$sql = "SELECT * FROM empresas where estatus=1 $SQLidempresas";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function obtenerCategorias()
	{
			
		$sql = "SELECT * FROM categorias ";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function obtenerPresentacion()
	{
		
		
		$sql = "select * from tipo_presentacion";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function obtenerPrecio()
	{
		
		
		$sql = "select * from categoria_precio where estatus=1";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	
	//Funcion que sirve para guardar un producto
	public function guardarProducto()
	{
		$query = "INSERT INTO productos (codigoproducto,idcategorias,nombre,descripcion,estatus,idtipomedida) VALUES ('$this->codigoproducto','$this->categoria','".$this->db->real_escape_string($this->nombre)."','".$this->db->real_escape_string($this->descripcion)."','$this->estatus','$this->v_idtipo_medida');";

	
		$this->db->consulta($query);

		$this->idproducto = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modifcar un producto
	public function modificarProducto()
	{
		$query = "UPDATE productos SET   
			codigoproducto='$this->codigoproducto',
			idcategorias = '$this->categoria', 
			nombre = '$this->nombre', 
			descripcion = '$this->descripcion',
/*		    idtipo_presentacion = '$this->presentacion',
*/		    estatus = '$this->estatus',
		    idtipomedida='$this->v_idtipo_medida'

		 WHERE idproducto = '$this->idproducto' ";


		
		$this->db->consulta($query);
	}
	
	
	public function validarProducto()
	{   

		
		
		$query="SELECT * FROM productos WHERE codigoproducto = '$this->idproducto'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total = $this->db->num_rows($resp);
		
		return $total;
		

	}

	public function ActualizarPrecioProducto()
	{
		$query = "UPDATE productos SET pu='$this->precio' WHERE  
		idproducto ='$this->idproducto' AND idempresas='$this->empresa'";


		$this->db->consulta($query);

	}

	public function VerificarSiestaEnCompra($idproducto,$idempresa)
	{
		$query = "SELECT * FROM productos INNER JOIN nota_remision_descripcion ON nota_remision_descripcion.idproducto=productos.idproducto AND nota_remision_descripcion.idempresas=productos.idempresas WHERE productos.idproducto = '$idproducto'";
		
		$result = $this->db->consulta($query);
		return $result;

	}

	public function EliminarProductosDescripcion()
	{
		$sql = "DELETE from productos_descripcion where   idempresas='$this->empresa' and idproducto='$this->idproducto'";

		
		$resp = $this->db->consulta($sql);
		return $resp;
	}


	public function EliminarProducto()
	{
		$sql="DELETE from productos where  idproducto='$this->idproducto'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}


	public function ObtenerProductoInventario($idempresas,$idsucursales)
	{
		$query = "SELECT productos.idproducto,productos.nombre,productos.pv,productos.pu,tipo_presentacion.nombre as presentacion,
SUBSTR(productos.idproducto,5,1) as letra,SUBSTR(productos.idproducto,1,4) as numero  from inventario 
		INNER JOIN insumos on inventario.idinsumos=insumos.idinsumos 
		INNER join productos_descripcion ON productos_descripcion.idinsumos=insumos.idinsumos
		INNER JOIN productos on productos_descripcion.idproducto=productos.idproducto
		INNER join tipo_presentacion on productos.idtipo_presentacion=tipo_presentacion.idtipo_presentacion

		where inventario.idempresas=".$idempresas." and inventario.idsucursales=".$idsucursales."  and productos.idempresas=".$idempresas."
		GROUP BY productos.idproducto ORDER BY FIELD(letra,'N') desc,numero asc";


		$result = $this->db->consulta($query);
		return $result;
	}


	
	public function VerificarsiexisteInsumodeProducto()
	{
		
	}

	public function ObtenerProductoMasvendidoNotas($idempresas,$idsucursales)
	{
		$query="SELECT MAX(suma),idproducto,nombre,presentacion from(SELECT
			nota_remision_descripcion.idproducto,nota_remision.idempresas,nota_remision.idsucursales,SUM(nota_remision_descripcion.cantidad) AS suma,
			nota_remision_descripcion.nombre,nota_remision_descripcion.presentacion
		FROM
			nota_remision
			INNER JOIN nota_remision_descripcion ON
			nota_remision.idnota_remision = nota_remision_descripcion.idnota_remision
			
			WHERE nota_remision.idempresas='$idempresas' AND nota_remision.idsucursales='$idsucursales'

		GROUP BY nota_remision.idempresas,nota_remision.idsucursales,nota_remision_descripcion.idproducto)as tabla";


		$result = $this->db->consulta($query);
		return $result;
	}


	public function ObtenerImagenes($idproducto,$idempresas)
	{
		$sql="SELECT *FROM productos_imagenes where idproducto='".$idproducto."' and idempresas=".$idempresas."";

		$result=$this->db->consulta($sql);
		return $result;
	}

	public function Lista_Productos2($busqueda)
	{
		$sql="SELECT i.*, 
	
		i.nombre, 
		i.descripcion, 
		i.estatus
		FROM productos i  
		 WHERE 1=1" ;

	 $sql .= ($busqueda != '') ? " AND i.nombre LIKE '%{$busqueda}%' ":" ";

	  $sql .=  ($busqueda != '') ? " OR i.codigoproducto LIKE '%{$busqueda}%' ":" ";
	
	 $result = $this->db->consulta($sql);
	 return $result;
	}


	



public function ObtenerProducto($idproducto)
	{

	$sql="SELECT i.* FROM productos i
	 WHERE  i.idproducto='$idproducto'";

	
	 $result = $this->db->consulta($sql);
	 return $result;
	}

	public function Verificar()
	{
		$sql="SELECT *FROM paquetesproducto WHERE idproducto=".$this->idproducto."";
		$result = $this->db->consulta($sql);
	 	return $result;

	}

}
?>