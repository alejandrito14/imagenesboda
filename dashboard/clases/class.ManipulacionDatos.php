<?php

require_once('conexcion.php');

require_once('class.MovimientoBitacora.php');



class ManipulacionDatos

{

	/**** Atributo de tipo objeto ****/

	public $db;

	

	

	/**** Datos que se reciben ****/

	public $campos;

	public $ciclo;

	public $cuantos;

	public $tabla;

	public $variables;

	public $accion;

	public $id;

	public $campoid;

	public $tipo;

	public $id2;

	public $campoid2;

	public $tipo2;

	public $carpeta;
	public $campoimg;
	

	/**** Datos de retorno ****/

	public $row_fetch_datos;

	public $totalRowsDatos;

	public $resultado_consulta;

	

	/**** Datos que se crean ****/

	private $sub_campos;

	private $sub_valores;

	private $sub_updates;

	private $movimientoBitacora ;

	

	

	function ManipulacionDatos()

	{

		$this->db = new MySQL();

		$this->movimientoBitacora = new MovimientoBitacora();

	}

	

	public function evaluarMovimientoDatos()

	{

		$Reemplazar="%trazzosmas";

		$CadenaNueva="\+";

		

		

		//hacer strin para meter los valores en el sql

		$cadenacampos = "";

		$cadenavalores = "";

		$cadenaupdate ="";

		

		//Realizo la primera separacion de lacadena con split, tomado en cuenta que me queda aun las cadenas con los limitadores :

		$s_campos = explode(",",$this->campos);

		$s_variables = explode(",",$this->variables);

		//Realio el ciclo hasta que se acabe la matriz creada por al separacion con el split

		for ($i=0;$s_campos[$i];$i++)

		{

			//Realizo una segunda separacion del campo y su tipo con el limitador :

			$s_solocampo = explode(":",$s_campos[$i]);

			//imprimio si realmente el campo tiene su variable de tipo

			//echo $s_campos[$i],"<br>";

			//realizo la concatenacion de los campos sin su tipo

			$cadenacampos=$cadenacampos.$s_solocampo[0].",";

			$cadenaupdate=$cadenaupdate.$s_solocampo[0]."=";

			//impreison para comprobar que valor me da en la matriz 0 o 1

			//echo $s_solocampo[0],"<br>";

			//echo $s_solocampo[1],"<br>";

			

			//realizo la condicion para empezar a armar el stin que contendra los valores que se envian desde el formulario

			$quevalor=$s_variables[$i];

			$quevalor= eregi_replace($Reemplazar,$CadenaNueva,$quevalor); 

			//echo $quevalor." ";

			

			if ($s_solocampo[1]=="n")

			{

				$cadenavalores=$cadenavalores.$quevalor.",";

				$cadenaupdate.=$quevalor.",";

				//echo "El campo es numerico<br>".$_GET[$s_variables[$i]];

			

			}// fin de if

			

			else

			{

				$cadenavalores=$cadenavalores."'".$quevalor."'".",";

				//echo "El Campo es varchar<br>".$_GET[$s_variables[$i]];

				$cadenaupdate.="'".$quevalor."'".",";

			}// fin de else

			

		}// if de fin de for

		

		$longitudcadenacampos=strlen($cadenacampos);

		$longitudcadenavalores=strlen($cadenavalores);

		$longitudcadenaupdate=strlen($cadenaupdate);

		

		$this->sub_campos = substr($cadenacampos,0,$longitudcadenacampos-1);

		$this->sub_valores = substr($cadenavalores,0,$longitudcadenavalores-1);

		$this->sub_updates = substr($cadenaupdate,0,$longitudcadenaupdate-1);

		

		if($this->accion=="g")

		{

			$this->guardarDatos();

		}

		else

		{

			$this->modificarDatos();

		}

	}//fin de evaluarMovimientoDatos

	

	public function guardarDatos()

	{

		try

		{

			$this->db->begin();

			$this->mov = 'GUARDAR';

			$query="INSERT INTO $this->tabla ($this->sub_campos) VALUES ($this->sub_valores)";

			$result = $this->db->consulta($query);

			$idtabla = $this->db->id_ultimo();

			$this->db->commit();

			

			echo '1';

		}// fin de try

		

		catch (Exception $e)

		{

			echo "Error MySQL ".$e;

			$db->rollback();

			echo '0';

		}// fin de catch

	}// fin de guardarDatos

	

	public function modificarDatos()

	{

		try

		{

			$this->db->begin();

			$this->mov = 'ACTUALIZAR';

			

			if($tipo=='n')

			{

				$variable=$this->id;

			}// fin de if

			else

			{

				$variable = "'".$this->id."'";

			}// fin de else

			$query="UPDATE $this->tabla SET $this->sub_updates WHERE $this->campoid=$variable";

			$result = $this->db->consulta($query);

			$this->db->commit();

			echo '1';

			

		}// fin de try

		

		catch (Exception $e)

		{

			echo "Error MySQL ".$e;

			$db->rollback();

			echo '0';

		}

	}// fin de modificarDatos

	

	public function borrarDatos()

	{

		if ($this->tipo=='n')

		{

			$variable=$this->id;
			


		}

		else

		{

			$variable = "'".$this->id."'";
			

		}

		

		try

		{

			$this->db->begin();
			
			$query = "DELETE FROM $this->tabla  WHERE $this->campoid=".$variable;
		
			$this->db->consulta($query);
			
			$this->db->commit();

			$this->movimientoBitacora->db = $this->db;
			$this->movimientoBitacora->guardarMovimiento(utf8_decode($this->tabla),$this->tabla,utf8_decode('Se elimino el Id :'.$this->id));

			echo '1';
		}// fin de try

		catch (Exception $e)

		{

			$this->db->rollback();	

		  $v = explode ('|',$e);

		  $n = explode ("'",$v[1]);

		  echo "EL REGISTRO SE ENCUENTRA RELACIONADO ". $this->db->m_error($n[0]);

		}// fin de catch

	}// fin de borrarDatos

	public function borrarSucursal()

	{

		if ($this->tipo=='n')

		{

			$variable=$this->id;
			


		}

		else

		{

			$variable = "'".$this->id."'";
			

		}

		

		try

		{

			$this->db->begin();
			
			$query = "DELETE FROM $this->tabla  WHERE $this->campoid=".$variable;
		
			$this->db->consulta($query);
			
			$this->db->commit();

			$this->movimientoBitacora->db = $this->db;
			$this->movimientoBitacora->guardarMovimiento(utf8_decode($this->tabla),$this->tabla,utf8_decode('Se elimino el Id :'.$this->id));

			echo '1';
		}// fin de try

		catch (Exception $e)

		{

			$this->db->rollback();	

		  $v = explode ('|',$e);

		  $n = explode ("'",$v[1]);

		  echo "Se hizo rollback ". $this->db->m_error($n[0]);

		}// fin de catch

	}// fin de borrarDatos


	

	public function obtenerDatosID($condicion)

	{

		$consulta = "SELECT * FROM $this->tabla WHERE $this->campoid = $this->id ".$condicion;

		$this->resultado_consulta = $this->db->consulta($consulta);

		$this->row_fetch_datos = $this->db->fetch_assoc($this->resultado_consulta);

		$this->totalRowsDatos = $this->db->num_rows($this->resultado_consulta);

		

	}// fin de de obtemerDatosId

	

	public function obtenerDatosGenerales($campos,$condicion,$ordenacion)

	{

		

		if($campos=="")

		{

			$campos = '*';

		}

		$consulta = "SELECT ".$campos." FROM $this->tabla ".$condicion." ".$ordenacion;

		$this->resultado_consulta = $this->db->consulta($consulta);

		$this->row_fetch_datos = $this->db->fetch_assoc($this->resultado_consulta);

		$this->totalRowsDatos = $this->db->num_rows($this->resultado_consulta);

		

	}// fin de obtenerDatosGenerales

	

	public function borrarDatos2pk()

	{

		if ($this->tipo=='n')

		{

			$variable=$this->id;

		}

		else

		{

			$variable = "'".$this->id."'";

		}

		

		if ($this->tipo2=='n')

		{

			$variable2=$this->id2;

		}

		else

		{

			$variable2 = "'".$this->id2."'";

		}

		

		try

		{

			$this->db->begin();

			$query = "DELETE FROM $this->tabla  WHERE $this->campoid = ".$variable." AND $this->campoid2 = ".$variable2;

			$this->db->consulta($query);

			$this->db->commit();

			echo '1';

		}// fin de try

		catch (Exception $e)

		{

			echo $e;

			$this->db->rollback();

			echo '0';

		}// fin de catch

	}// fin de borrarDatos

	
	
	public function borrarDatosImg()

	{
		if ($this->tipo=='n')
		{
			$variable=$this->id;
		}else{
			$variable = "'".$this->id."'";
		}

		
		try
		{

			$this->db->begin();
			$ruta="../".$this->carpeta;
						
						
			//obtenemos el nombre del archivo anterior para ser eliminado si existe
			$sql = "SELECT $this->campoimg FROM $this->tabla WHERE $this->campoid = '".$variable."'";
			$result_borrar = $this->db->consulta($sql);
			$result_borrar_row = $this->db->fetch_assoc($result_borrar);
			$nombreborrar = $result_borrar_row[$this->campoimg];
						
			if($nombreborrar != "")
			{
				unlink($ruta.$nombreborrar);	
			}
			
			$query = "DELETE FROM $this->tabla  WHERE $this->campoid= '".$variable."'";

			$this->db->consulta($query);
			
			$this->db->commit();

			$this->movimientoBitacora->db = $this->db;
			$this->movimientoBitacora->guardarMovimiento(utf8_decode($this->tabla),$this->tabla,utf8_decode('Se elimino el Id :'.$this->id));

			echo '1';
		}// fin de try

		catch (Exception $e)
		{
			$this->db->rollback();	
		 	 $v = explode ('|',$e);
		 	 $n = explode ("'",$v[1]);
		  	echo "Se hizo rollback ". $this->db->m_error($n[0]);
		}// fin de catch

	}// fin de borrarDatos

}//fin de clases ManipulacionDatos

?>