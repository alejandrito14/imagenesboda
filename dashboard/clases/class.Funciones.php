<?php
class Funciones
{



	/* public function __construct() {

	   	date_default_timezone_set('America/Mexico_City');


	   }*/

	//funciones de cadenas 
	 public function mayus($cadena)//convierte a mayusculas
     {
		return strtoupper($cadena);		 
	 }	
	  
  	 public function minus($cadena)//convernte a minusculas
     {
	    return strtolower($cadena);	 
	 }
	 
	 public function parra($cadena)
     {
		return ucfirst(strtolower($cadena)); 
	 }
	 
	 public function elimina_acentos($cadena)
	 {	
		$tofind = utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ");
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		return(strtr($cadena,$tofind,$replac));
	 }
	 
	 //funcion  para el porcentaje
	 public function porcentaje($valor,$totalvalor)
     {
		if($totalvalor == 0)
		  {
			return 0;	  
		  }else
		  {
			$p = ($valor * 100) / $totalvalor;
	  	     return $p;			
		  }
	 }
	 
	 //funcpara sacar  el numero de tarjeta
	 public function aumentarceros($longitud,$total,$valor)
	   {
		   $c_ceros = $total - $longitud;		   
		  if($longitud != $total)
			 {
				 for($i=1; $i<= $c_ceros; $i++)
				  {
					$cadena = $cadena."0";
				  }				  
			   $cadena = $cadena.$valor;		  
			 }
			 else
			 {	
				   $cadena = $valor;	   
			 }
		  return $cadena;	     
	   }
	   
	   //funciones para obtener la informacion del navegador, sistema operativo y ip de donde ingreso
	   //funcion de que devuelbe el nombre del navegador
	 
	  public function navegador()
	  {
		 $datos = $_SERVER["HTTP_USER_AGENT"];
		 $t = strtolower($datos);

        // If the string *starts* with the string, strpos returns 0 (i.e., FALSE). Do a ghetto hack and start with a space.
        // "[strpos()] may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE."
        //     http://php.net/manual/en/function.strpos.php
        $t = " " . $t;

        // Humans / Regular Users     
        if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;
        elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;
        elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;
        elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;
        elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;
        elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';

        // Search Engines 
        elseif (strpos($t, 'google'    )                           ) return '[Bot] Googlebot'   ;
        elseif (strpos($t, 'bing'      )                           ) return '[Bot] Bingbot'     ;
        elseif (strpos($t, 'slurp'     )                           ) return '[Bot] Yahoo! Slurp';
        elseif (strpos($t, 'duckduckgo')                           ) return '[Bot] DuckDuckBot' ;
        elseif (strpos($t, 'baidu'     )                           ) return '[Bot] Baidu'       ;
        elseif (strpos($t, 'yandex'    )                           ) return '[Bot] Yandex'      ;
        elseif (strpos($t, 'sogou'     )                           ) return '[Bot] Sogou'       ;
        elseif (strpos($t, 'exabot'    )                           ) return '[Bot] Exabot'      ;
        elseif (strpos($t, 'msn'       )                           ) return '[Bot] MSN'         ;

        // Common Tools and Bots
        elseif (strpos($t, 'mj12bot'   )                           ) return '[Bot] Majestic'     ;
        elseif (strpos($t, 'ahrefs'    )                           ) return '[Bot] Ahrefs'       ;
        elseif (strpos($t, 'semrush'   )                           ) return '[Bot] SEMRush'      ;
        elseif (strpos($t, 'rogerbot'  ) || strpos($t, 'dotbot')   ) return '[Bot] Moz or OpenSiteExplorer';
        elseif (strpos($t, 'frog'      ) || strpos($t, 'screaming')) return '[Bot] Screaming Frog';
       
        // Miscellaneous
        elseif (strpos($t, 'facebook'  )                           ) return '[Bot] Facebook'     ;
        elseif (strpos($t, 'pinterest' )                           ) return '[Bot] Pinterest'    ;
       
        // Check for strings commonly used in bot user agents  
        elseif (strpos($t, 'crawler' ) || strpos($t, 'api'    ) ||
                strpos($t, 'spider'  ) || strpos($t, 'http'   ) ||
                strpos($t, 'bot'     ) || strpos($t, 'archive') ||
                strpos($t, 'info'    ) || strpos($t, 'data'   )    ) return '[Bot] Other'   ;
       
        return 'Other (Unknown)';
	  }
	 
	 
	  //funcion que devuelve la ip
	  public function d_ip()
 	 {	  
	  	return $_SERVER['HTTP_CLIENT_IP'];
	 }
	
	
	 //funcionde devuelve el nombre del sistems operativo 
	 public function sistema_o()
	 {

	 	$user_agent = $_SERVER["HTTP_USER_AGENT"];

   		 $os_array =  array(
                    '/windows nt 10/i'      =>  'Windows 10',
                    '/windows nt 6.3/i'     =>  'Windows 8.1',
                    '/windows nt 6.2/i'     =>  'Windows 8',
                    '/windows nt 6.1/i'     =>  'Windows 7',
                    '/windows nt 6.0/i'     =>  'Windows Vista',
                    '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                    '/windows nt 5.1/i'     =>  'Windows XP',
                    '/windows xp/i'         =>  'Windows XP',
                    '/windows nt 5.0/i'     =>  'Windows 2000',
                    '/windows me/i'         =>  'Windows ME',
                    '/win98/i'              =>  'Windows 98',
                    '/win95/i'              =>  'Windows 95',
                    '/win16/i'              =>  'Windows 3.11',
                    '/macintosh|mac os x/i' =>  'Mac OS X',
                    '/mac_powerpc/i'        =>  'Mac OS 9',
                    '/linux/i'              =>  'Linux',
                    '/ubuntu/i'             =>  'Ubuntu',
                    '/iphone/i'             =>  'iPhone',
                    '/ipod/i'               =>  'iPod',
                    '/ipad/i'               =>  'iPad',
                    '/android/i'            =>  'Android',
                    '/blackberry/i'         =>  'BlackBerry',
                    '/webos/i'              =>  'Mobile'
                  );
		    //
		    $os_platform = "Unknown OS Platform";
		    foreach ($os_array as $regex => $value) { 
		        if (preg_match($regex, $user_agent)) {
		            $os_platform = $value;
		        }
		    }
		    return $os_platform;  
	 }
	 	
	
	// funcion de letras pra la buscueda
	public function abc($pagina,$mensaje,$donde)
	{	
		for($i=65;$i<91;$i++)
		{
		$letra = chr($i);
	?>
		   <a href='#' onclick="aparecermodulos('<?php echo $pagina;?>=<?php echo $letra;?>','<?php echo $mensaje;?>','<?php echo $donde;?>')"> <?php echo $letra;?></a>
	<?php
		}
		  $letra="Todos";	
	 ?>
		<a href='#' onclick="aparecermodulos('<?php echo $pagina;?>=<?php echo $letra;?>','<?php echo $mensaje;?>','<?php echo $donde;?>')"> <?php echo $letra;?></a>
	<?php
	}
		
	
	//funcion que nos sirve para saber los permisos de un usuario
	public function p_permisos($permisos,$idmodulo)
	{
		$array = explode("|",$permisos);	
		$l_array = count($array);
		
		for($x=0;$x<=$l_array-1;$x++)
		{
			if($array[$x]==$idmodulo)
			{
				$valor = 1;
				$x=$l_array-1;
			}
			else
			{
				$valor = 0;
			}
		}				
		
		if($valor == 0)
		{
		   header("location: ../accesodenegado.php");  
		   exit;
		}
	}
	
	public function obtenerUltimoDiaMes($fecha)
	{
		
		$fechaArray = explode('-',$fecha);
		
		$anio = $fechaArray[0];
		$mes = $fechaArray[1];
		
	
		for ($dia=28;$dia<=31;$dia++)
		{
		   if(@checkdate($mes,$dia,$anio))
		   {
		        $fecha= $anio.'-'.$mes.'-'.$dia;
		   }
		}
      return $fecha; 
		
	}// fin de método obtenerUltimoDiaMes
	
	public function espanol($frace)
      {
	     return utf8_encode($frace);
      }

   public function enutf8($frace)
     {
      return utf8_decode($frace);	   
     }
	 
	public function CortarFrase($frase,$cant_maxima)
	{
		$long = strlen($frase);//obteniedo la longitud del texto a mostrar
		
		$nombrecorto = strtoupper(substr($frase,0,$cant_maxima));
		
		if($long >= $cant_maxima)
		{ 
			$nombrecorto.= '<span >...</span>'; 
		}
		
		return $nombrecorto;
	}
	
	public function Hora12($hora,$conMinutos)
	{
		//min es para saber si trae minutos o no
		$horafinal="";
		$minutos="";
		$arrayhora=explode(":",$hora);
		$horas=intval($arrayhora[0]);
		
		if($conMinutos==1)
		{
			if($arrayhora[1]!="00")
			{
				$minutos=$arrayhora[1];
			}
			else
			{
				$minutos=$arrayhora[1];
			}
		}
		else
		{
			$minutos="00";	
		}
		//echo $arrayhora[0];
		$arrayHora12= array(0=>'12:00:am',1=>'1:00:am',2=>'2:00:am',3=>'3:00:am',4=>'4:00:am',5=>'5:00:am',6=>'6:00:am',7=>'7:00:am',8=>'8:00:am',9=>'9:00:am',10=>'10:00:am',11=>'11:00:am',12=>'12:00:pm',13=>'1:00:pm',14=>'2:00:pm',15=>'3:00:pm',16=>'4:00:pm',17=>'5:00:pm',18=>'6:00:pm',19=>'7:00:pm',20=>'8:00:pm',21=>'9:00:pm',22=>'10:00:pm',23=>'11:00:pm');
		
		$hora12=explode(":",$arrayHora12[intval($arrayhora[0])]);
	
		$horafinal=$hora12[0].":".$minutos." ".$hora12[2];
		
		return $horafinal;
	
	}
	
	
	
	public function redondear_dos_decimal($valor)
	 { 
       $float_redondeado=round($valor * 100) / 100; 
       return $float_redondeado; 
     } 
	 
	 
	 function conver_especial($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        array("\\", "¨", "º", "-", "~",
             "|gato", "@", "|", "!", "\"",
             "·", "$", "capse", "&", "/",
             "(", ")", "?", "comilla", "¡",
             "¿", "[", "^", "`", "]",
             "mas", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", "espacio"),
        $string
    );


    return $string;
}

 function desconver_especial($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "|gato", "@", "|", "!", "\"",
             "·", "$", "capse", "&", "/",
             "(", ")", "?", "comilla", "¡",
             "¿", "[", "^", "`", "]",
             "mas", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", "espacio"),
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        $string
    );


    return $string;
}


//Funcion que sirve para encriptar una cadena para poder pasarla por GET en la URL
function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}


//Funcion que sirve para desencriptar una cadena al momento de recibirla por GET string = cadena y key es una clave que ponemos para poder desencriptar
function decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
	 
	 


function imprimir_cadena_utf8($cadena){
		$flag = 0; //0 No decodifica nada  //1 decodifica utf8_encode
		if($flag == 0){
			return $cadena;	
		}else{
			return utf8_encode($cadena);
		}
	}
	
	function guardar_cadena_utf8($cadena){
		$flag = 0;
		if($flag == 0){
			return $cadena;
		}else{
			return utf8_decode($cadena);
		}
	}
	
	
}
