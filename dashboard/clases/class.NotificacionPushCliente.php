<?php 

class NotificacionPushCliente 
{

    public $apikey;
    public $db;
    public $idnotificacioncliente;
    public $estatus;
    public $idsucursal;
    public $accessToken;
    public $archivo;
    public $nombreproyecto;

     public function __construct($db) {
          if (!$db) {
            throw new Exception("Conexión a la base de datos no válida");
        }
        $this->db = $db;
        $this->accessToken = $this->getAccessToken();
    }

	public function EnviarNotificacion2($listatokens,$titulo,$mensaje)
	{

		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
 	

 		$tokenList=$listatokens;

     $notification = [
            'title' =>$titulo,
            'body' => $mensaje,
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
           //'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $this->apikey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


       // echo $result;
	
	}


      public function AgregarNotifcacionaCliente($idcliente,$texto,$ruta,$valor,$estatus)
    { 
       $sql="INSERT INTO notificacioncliente(idcliente,texto,ruta,valor,estatus) VALUES('$idcliente','$texto','$ruta','$valor','$estatus')";

     
        $resp=$this->db->consulta($sql);

    }

    public function CambiarEstatusNotificacion()
    {
        $query = "UPDATE notificacioncliente SET estatus = '$this->estatus' WHERE idnotificacioncliente = '$this->idnotificacioncliente'";
        $this->db->consulta($query);
    }



     public function getAccessToken() {

        $query = "SELECT *
            FROM 
            pagina_configuracion"; 
        $result = $this->db->consulta($query);
        $row=$this->db->fetch_assoc($result);

        $archivo=$row['archivonotificacioncliente'];
        $this->nombreproyecto=$row['proyectofirebase'];
       
        $credentialsPath = '/home/issoftware/public_html/IS-U-ORDER/catalogos/notificaciones/llavenotificacion/'.$archivo;  // Asegúrate de que esta ruta sea correcta

    // Cargar credenciales de archivo JSON
    $credentials = json_decode(file_get_contents($credentialsPath), true);
   
    // Parámetros del JWT
    $jwtHeader = [
        'alg' => 'RS256',
        'typ' => 'JWT'
    ];

    $jwtPayload = [
        'iss' => $credentials['client_email'],
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'exp' => time() + 3600, // 1 hora de validez
        'iat' => time()
    ];

    // Codificar JWT Header y Payload
    $header = base64_encode(json_encode($jwtHeader));
    $payload = base64_encode(json_encode($jwtPayload));
    $signatureInput = $header . '.' . $payload;

    // Firmar el JWT
    $privateKey = openssl_pkey_get_private($credentials['private_key']);
    openssl_sign($signatureInput, $signature, $privateKey, 'SHA256');
    $signature = base64_encode($signature);

    $jwt = $header . '.' . $payload . '.' . $signature;

    // Solicitar el token de acceso
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die('Error:' . curl_error($ch));
    }
    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['access_token'];
    
}



function EnviarNotificacion($tokenList, $title, $message) {

    if ($this->accessToken != null) {
    // Datos adicionales para la notificación
    $extraNotificationData = [
        "notification_foreground" => "true",
        "navigation" =>(string)$this->navpage,
        "valor" => (string)$this->valor,
        "idsucursal" => (string)$this->idsucursal
    ];

    // URL de la API de Firebase
    $url = "https://fcm.googleapis.com/v1/projects/".$this->nombreproyecto."/messages:send";
    
    // Headers para la petición cURL
    $headers = [
        'Authorization: Bearer ' . $this->accessToken,
        'Content-Type: application/json'
    ];

    // Enviar notificación a cada token
    foreach ($tokenList as $token) {
        if ($token!=null) {
            // code...
        
        // Construir el mensaje
        $data = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body" => $message
                ],
                "data" => $extraNotificationData
            ]
        ];

        // Convertir el array a JSON
        $data_string = json_encode($data);

        // Inicializar cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Ejecutar cURL y obtener resultado
        $result = curl_exec($ch);
        //print_r($result);die();
        if (curl_errno($ch)) {
            // Manejar el error
            error_log('Error en cURL: ' . curl_error($ch));
        } else {
            // Ver el resultado si es necesario
            error_log('Resultado de Firebase: ' . $result);
        }

        // Cerrar cURL
        curl_close($ch);
      }
    }
}
}


	
}


 ?>