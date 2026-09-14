<?php
class SMS
{
	public $db;
	
	
	public function EnviarSMS($sDestination,$sMessage,$debug) {
		$sData ="cmd=sendsms&";
		$sData .="domainId=capsemx&";
		$sData .="login=capsemx&";
		$sData .="passwd=ca16pse5mx&";
		$sData .="dest=".str_replace(",","&dest=",$sDestination)."&";
		$sData .="msg=".urlencode(utf8_encode(substr($sMessage,0,160)));
		$fp = fsockopen("www.altiria.net", 80, $errno, $errstr, 10);
		if (!$fp) {
			//Error de conexion
			$output = "ERROR de conexion: $errno - $errstr<br />\n";
			$output .= "Compruebe que ha configurado correctamente la direccion/url ";
			$output .= "suministrada por altiria<br>";
			return $output;
		} else {
			// Reemplazar la cadena ’/sustituirPOSTsms’ por la parte correspondiente
			// de la URL suministrada por Altiria al dar de alta el servicio
			$buf = "POST  /api/http HTTP/1.0\r\n";
			$buf .= "Host: www.altiria.net\r\n";
			$buf .= "Content-type: application/x-www-form-urlencoded; charset=UTF-8\r\n";
			$buf .= "Content-length: ".strlen($sData)."\r\n";
			$buf .= "\r\n";
			$buf .= $sData;
			fputs($fp, $buf);
			$buf = "";
			while (!feof($fp))
			$buf .= fgets($fp,128);
			fclose($fp);
			//Si la llamada se hace con debug, se muestra la respuesta completa del servidor
			if ($debug){
				print "Respuesta del servidor: <br>".$buf."<br>";
			}
		
			//Se comprueba que se ha conectado realmente con el servidor
			//y que se obtenga un codigo HTTP OK 200
			if (strpos($buf,"HTTP/1.1 200 OK") === false){
				$output = "ERROR. Codigo error HTTP: ".substr($buf,9,3)."<br />\n";
				$output .= "Compruebe que ha configurado correctamente la direccion/url ";
				$output .= "suministrada por Altiria<br>";
				return $output;
			}
			//Se comprueba la respuesta de Altiria
			if (strstr($buf,"ERROR")){
				$output = $buf."<br />\n";
				$output .= " Codigo de error de Altiria. Compruebe la especificacion<br>";
				return $output;
			} else
				return "";
			
		}
	}

	
}
?>