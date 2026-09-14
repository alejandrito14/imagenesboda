<?php
require_once("class.Sesion.php");


class MySQL
{  

     private $conexion = null;
     private $se;
     private $servidor;
     private $usuario;
     private $contrase;
     private $db;

	 //funcion de coneccion con la base de datos
	 public function __construct()
	 {  
	 	$this->se=new Sesion();
	 	$this->servidor='127.0.0.1';
	 	$this->usuario=$this->se->obtenerSesion('dbusuario_cliente');
	 	$this->contrase=$this->se->obtenerSesion('dbclave_cliente');
	 	$this->db=$this->se->obtenerSesion('db_cliente');

		;
	 	if(!isset($this->conexion))
		{  
		  	
				//realizamos conexcion a la base de datos..						
			
			//Conexion en localhost
			 $this->conexion = new mysqli($this->servidor,$this->usuario,$this->contrase,$this->db,8889);

                if ($this->conexion->connect_errno) {
  
   
                   echo "Fallo al contenctar a MySQL |" .$this->conexion->connect_errno;
 


                }
 
                 mysqli_set_charset($this->conexion ,"utf8");
             

			//$this->conexion = mysql_connect("localhost","wwgrup_db","@JoseLuis2010");
			//@mysql_select_db("wwgrup_seguimiento",$this->conexion);
		}  

		
		if(!$this->conexion)
	    {
			//esto es lo magico.
		   throw new Exception('No Funciona la conexcion. El Error es el siguiente: |1');
		}
		

	}  
	
	//funcion de consulta con la base. parametro el query
	public function consulta($consulta)
{ 

		 $resultado =@mysqli_query($this->conexion,$consulta);
		
        if(!$resultado){
                throw new Exception("Existio un error en la consulta ".$this->conexion->errno,$this->conexion->errno);
        }else
				{
                return $resultado;
        }

       
	}		
	
	//funcion para la cracion de los array. paramentro el resultado de la consulta	  
	public function fetch_array($consulta)
	{   
		return @mysqli_fetch_array($consulta);  
		
	}  
				  
	public function fetch_row($consulta)
	{   
		return @mysqli_fetch_row($consulta);  
		
		
	}  
	
	public function fetch_object($consulta)

		{
		return @mysqli_fetch_object($consulta);
		} 
				  
	public function mysqlresult($consulta,$numero,$letra)
	{
		return @mysql_result($consulta,$numero,$letra);
	}
				  
	public function fetch_assoc($consulta)
	{   
		//return @mysql_fetch_assoc($consulta);  
		return @mysqli_fetch_assoc($consulta);
	}  
	
	//funcion para obtener el todal de filas consultadas. parametro  resultado de la consulta
	public function num_rows($consulta)
	{   
		return @mysqli_num_rows($consulta);
	}
	
	
	public function mysql_num_field($consulta)
	{
		//return @mysql_num_fields($consulta);
	return @mysqli_num_rows($consulta);

	}
	
	
	//funcion que obtiene el ultimo id que fue ingrsado
	public function id_ultimo()
	{
		//return @mysql_insert_id();  
	return @mysqli_insert_id($this->conexion);

	}  
	//preparando la base para insercion de datos
	public function begin()
    {
       @mysqli_query($this->conexion,"BEGIN;");
    }
         
	public function commit()
    {
    	@mysqli_query($this->conexion,"COMMIT;");
    }
			  
	public function rollback()
    {
    	//@mysqli_query($this->conexion,"ROLLBACK;");
		@mysqli_rollback($this->conexion);
    }
			 
	public function liberar($q)
    {   
    	@mysqli_free_result($q); 
    }

    public function real_escape_string($texto)
    {   
    	return @mysqli_real_escape_string($this->conexion,$texto); 
    }
	
	public function m_error($err)
     {
		
		
		   $e =  array(
		        1=>'Huvo un error al intentar conectarse a la base de datos, revise su usuario y contraseña',
		        2000=>"No conoce este Error en Mysql",
		        1451=>"Este campo ya tiene un historial u otra tabla esta usando su llave primaria",
				1146=>"Huvo un error al hacer la consulta tal vez la tabla no existe o esta mal escrita",
				1064=>"La sentencia sql no esta bien escrita error en una palabra reservada o la llave primaria es nula",   
				1054=>"Un campo en la consulta no existe o esta mal escrito",
				1062=>"la llave primaria no tiene valor AI, o estas repitiendo una llave primaria",
				10000=>"No existe Valores en la Matriz de la Sesion",
				1452=>"esperando solucion a este problema"
					   );
		   
		   	   
		   return $e[$err];
			 
	 }
	 
	 
	 
	 
	 /* Realizamos el backup de una tabla o de todas */
public function backup_tables($tables = '*')
{
	
	//Conseguimos todas las tablas
	if($tables == '*')
	{
		$tables = array();
		$result = $this->consulta('SHOW TABLES');
		while($row = $this->fetch_row($result))
		{
			//echo $row[0]."<br>" ;
			
			$tables[] = $row[0];
		}
		
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	$return="";
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return .= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query('SHOW CREATE TABLE '.$table));
		
		$return.= "\n\n".$row2[1].";\n\n";
		
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = preg_replace('/\n/','/\\n/',$row[$j]); 
					//$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$file = date("Y-m-d").'--SisVenta'.'.txt';
	$nombrefile ='../backup/'.time().$file;
	$handle = fopen($nombrefile,'w+');
	fwrite($handle,$return);
	fclose($handle); 
	echo '1|<h4 class="alert_success">LA BASE DE DATOS SE RESPALDO CORRECTAMENTE<br>NOMBRE: <a href="backup/'.$nombrefile.'" >'.$file.'</h4>';
	
}
	 
	

	
}
?>