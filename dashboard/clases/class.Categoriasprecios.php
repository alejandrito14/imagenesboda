<?php
class Categoriasprecios
{
	
	public $db;
	
	public $idcategoriaprecios;
	public $nombre;
	public $depende;
	public $empresa;
	public $descripcion;
	public $rango1;
	public $rango2;
	public $precio;
	public $codinsumo;
	public $tipomedida;	//validacione de tipo de usuario
	
	public $tipo_usuario;
	public $lista_empresas;
	

	public function obtenerTodas()
	{
		if($this->tipo_usuario != 0)
		{
			$SQLidempresas = "and E.idempresas IN ($this->lista_empresas)";
		}else
		{
			$SQLidempresas = "";
		}
		
		
		
		$sql = "SELECT C.* FROM categoria_precios C, empresas E where E.idempresas=C.idempresas $SQLidempresas";

		$resp = $this->db->consulta($sql);


		return $resp;
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
	
		//Funcion que nos regresa los registros de la tabla empresas según el filtro
	public function obtenerFiltro()
	{
		
		if($this->tipo_usuario != 0)
		{
			$SQLidempresas = "and E.idempresas IN ($this->lista_empresas)";
		}else
		{
			$SQLidempresas = "";
		}	
		$sql = "SELECT C.*,E.* FROM categoria_precios C, empresas E where E.idempresas=C.idempresas $SQLidempresas";
		$sql .= ($this->nombre != '')? " AND C.categoria LIKE '%$this->nombre%'":"";
		$sql .= ($this->idcategoria != '')? " AND C.idcategoria_precios = '$this->idcategoria'":"";
		$sql .= ($this->empresa != '')? " AND E.idempresas = '$this->empresa'":"";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	public function obtenercategoria_precios()
	{
		
		if($this->tipo_usuario != 0)
		{
			$SQLidempresas = "and E.idempresas IN ($this->lista_empresas)";
		}else
		{
			$SQLidempresas = "";
		}	
		$sql = "SELECT C.*,E.* FROM categoria_precios C, empresas E where E.idempresas=C.idempresas $SQLidempresas";
		

	
		$resp = $this->db->consulta($sql);
		return $resp;
	}


public function obtenercategoria_precios_empresa()
	{
		
		
			$SQLidempresas = "and E.idempresas IN ($this->lista_empresas)";
		
		$sql = "SELECT C.*,E.* FROM categoria_precios C, empresas E where E.idempresas=C.idempresas $SQLidempresas";
		

	
		$resp = $this->db->consulta($sql);
		return $resp;
	}



	
	public function NombreCategoria($id){
		$nombre="";
		if($id==0){
			$nombre= "No Asignado";
		}
		else {
			$sql ="select * from categoria_precios where idcategoria_precios='$id'";
			
			$result=$this->db->consulta($sql);
			$result_row=$this->db->fetch_assoc($result);
			$nombre=$result_row['categoria'];
		}
		
		return $nombre;
	}


	
	//Funcion que sirve para obtener un registro especifico de la tabla empresas
	public function buscarCategoria()
	{
		$sql = "SELECT * FROM categoria_precios WHERE idcategoria_precios = '$this->idcategoriaprecios'";

		$resp = $this->db->consulta($sql);
		return $resp;
	}

	//Funcion que guarda un registro en la tabla empresas
	public function guardarCategoriaPrecio()
	{
		$sql = "INSERT INTO categoria_precios (categoria,descripcion,idempresas,idtipo_medida) VALUES ('$this->nombre','$this->descripcion','$this->empresa','$this->tipomedida');";
		
		$resp = $this->db->consulta($sql);
		$this->idcategoriaprecios = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modificar un registro en la tabla empresas
	public function modificarCategoriaPrecio(){
		$sql = "UPDATE categoria_precios SET
		categoria = '$this->nombre', descripcion = '$this->descripcion', 
		idempresas = '$this->empresa', idtipo_medida='$this->tipomedida' WHERE idcategoria_precios = '$this->idcategoriaprecios'";
		$this->db->consulta($sql);
	}

	public function GuardarRangoPrecios()
	{
		$sql = "INSERT INTO precios_rango (ri,rf,pv,idcategoria_precios) VALUES ('$this->rango1','$this->rango2','$this->precio','$this->idcategoriaprecios');";
		
		$resp = $this->db->consulta($sql);
	}

	public function ObtenerRangosPrecios()
	{
		$sql = "SELECT * FROM precios_rango WHERE idcategoria_precios = '$this->idcategoriaprecios'";


		$resp = $this->db->consulta($sql);
		return $resp;
	}


	public function eliminarrangos()
	{
		$sql = "DELETE  FROM precios_rango WHERE idcategoria_precios = '$this->idcategoriaprecios'";


		$resp = $this->db->consulta($sql);
		return $resp;

	}

	public function EliminarCategoriaPrecios()
	{
		$sql = "DELETE  FROM categoria_precios WHERE idcategoria_precios = '$this->idcategoriaprecios'";

		
		$resp = $this->db->consulta($sql);
	}


	public function ObtenerInsumosAcategoria()
	{
		$sql = "SELECT insumos.idinsumos, 
		insumos.idtipo_medida, 
		insumos.nombre, 
		insumos.descripcion, 
		insumos.cantidad, 
		insumos.estatus, 
		categoria_precios.idcategoria_precios, 
		categoria_precios.categoria, 
		categoria_precios.descripcion, 
		insumos_categoria_precios.idempresas, 
		insumos_categoria_precios.idcategoria_precios
		FROM insumos INNER JOIN insumos_categoria_precios ON insumos.idinsumos = insumos_categoria_precios.idinsumos
		INNER JOIN categoria_precios ON categoria_precios.idcategoria_precios = insumos_categoria_precios.idcategoria_precios WHERE insumos_categoria_precios.idcategoria_precios = '$this->idcategoriaprecios' AND insumos_categoria_precios.idempresas='$this->empresa' GROUP BY insumos.idinsumos";
		
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}

	public function GuardarInsumoCategoria()
	{
		$sql = "INSERT INTO insumos_categoria_precios (idinsumos,idempresas,idcategoria_precios) VALUES ('$this->codinsumo','$this->empresa','$this->idcategoriaprecios');";

		
		$resp = $this->db->consulta($sql);
	}

	public function eliminarInsumoCategoria()
	{
		$sql = "DELETE  FROM insumos_categoria_precios WHERE idcategoria_precios = '$this->idcategoriaprecios' AND idempresas='$this->empresa'";


		$resp = $this->db->consulta($sql);
	}


}
?>