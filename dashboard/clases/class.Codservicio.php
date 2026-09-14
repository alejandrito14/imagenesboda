<?php 

class Codservicio 
{


	public function Obtenerbasedecodigo1($codservicio)
	{
		
		//$codservicio = $_POST['codservicio'];
       // $con2 = mysqli_connect("189.193.4.113","pepe","121275","isadmin");
        $con2 = mysqli_connect("is-software.net","issoftwa_prueba","prueba","issoftwa_admin");


			       //  mysql_select_db("isadmin",$con2);
           //  $con2 = mysqli_connect("192.169.197.189","issoftware","qr=]3JKxsT+3!","isadmin");
		
			$consulta = "SELECT * FROM servicios_clientes WHERE idservicios_clientes = '$codservicio'";
			


			$servicio =  $con2->query($consulta); 
		
			$servicio_row =  mysqli_fetch_assoc($servicio);  

			$servicio_num=mysqli_num_rows($servicio);

			print_r($servicio_row);die();

			return $servicio_row;
	}

	public function Obtenerbasedecodigo($codservicio)
	{
		$clave="issoftware";
		if (!$codservicio) {
		    die("Error: No se ha recibido el código de servicio.");
		}

		// URL a la que se hará la solicitud cURL
		$url = "https://iss2.mx/is-admin/obtenerservidorapp.php";

		// Configuración de la solicitud cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);

		// Parámetros POST a enviar
		$fields = [
		    'clave' => $clave,
		    'codservicio' => $codservicio
		];
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Ejecuta la solicitud y almacena la respuesta
		$response = curl_exec($ch);
		
		// Verifica si hubo un error en la solicitud
		if (curl_errno($ch)) {
		    die("Error en cURL: " . curl_error($ch));
		}

		// Cierra la conexión cURL
		curl_close($ch);

		// Procesa la respuesta (asumiendo que es JSON)
		$servicio_data = json_decode($response, true);
		

		$array = $servicio_data['datosservidor'];

		//print_r($array);die();
		return $array;
	}


	public function Obtenerconexcion($codservicio,$clave)
	{
		
		if (!$codservicio) {
		    die("Error: No se ha recibido el código de servicio.");
		}

		// URL a la que se hará la solicitud cURL
		$url = "https://iss2.mx/is-admin/obtenerservidorapp.php";

		// Configuración de la solicitud cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);

		// Parámetros POST a enviar
		$fields = [
		    'clave' => $clave,
		    'codservicio' => $codservicio
		];
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Ejecuta la solicitud y almacena la respuesta
		$response = curl_exec($ch);
		
		// Verifica si hubo un error en la solicitud
		if (curl_errno($ch)) {
		    die("Error en cURL: " . curl_error($ch));
		}

		// Cierra la conexión cURL
		curl_close($ch);

		// Procesa la respuesta (asumiendo que es JSON)
		$servicio_data = json_decode($response, true);
		//print_r($servicio_data);die();

		return $servicio_data;
	}

}


 ?>