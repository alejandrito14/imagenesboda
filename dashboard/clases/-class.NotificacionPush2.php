<?php 
 define('API_ACCESS_KEY','AAAAXK-GUvQ:APA91bGkGKIKJtDPriKumepreO21ycvwkmuNdsE_89VgbggDoBHaBlCb-2HA4i4rRD_9PFcS19cg9qPL7IP0F8rbbEVW9Ca9ooSfApT3T24u8yUSchyT1hoh4XMC88hlP7xJUR5mZGF0');

class NotificacionPush2
{


    public $db;
    public $iduseradmin;
    public $idnotificacionadmin;
    public $estatus;
    public $apikey;
    public $valor;
    public $navpage;
    public $idcliente;
    public $idsucursal;
    public $accessToken;
    public $archivo;
    public $nombreproyecto;
       public function __construct() {
       
        $this->accessToken = $this->getAccessToken();
    }

	public function EnviarNotificacionante($listatokens,$titulo,$mensaje)
	{

		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
 	

 		$tokenList=$listatokens;

     $notification = [
            'title' =>$titulo,
            'body' => $mensaje,
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["notification_foreground" => "true", "navigation" => $this->navpage,"valor"=>$this->valor,"idsucursal"=>$this->idsucursal];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
           //'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
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

   /* public function AgregarNotifcacionaUsuarios($idusuario,$texto,$ruta,$valor,$estatus)
    {
       $sql="INSERT INTO notificacionadmin(idusuario,texto,ruta,valor,estatus) VALUES('$idusuario','$texto','$ruta','$valor','$estatus')";

     
        $resp=$this->db->consulta($sql);

    }*/

    /*public function Cambiarestatusnotificacion()
    {
          $query = "UPDATE notificacionadmin SET estatus = '$this->estatus' WHERE idnotificacionadmin = '$this->idnotificacionadmin'";
        $this->db->consulta($query);
    }*/

    public function AgregarNotifcacionaUsuarios($idusuario,$texto,$ruta,$valor,$estatus)
    {
       $sql="INSERT INTO notificacionadmin(idusuario,texto,ruta,valor,estatus) VALUES('$idusuario','$texto','$ruta','$valor','$estatus')";

     
        $resp=$this->db->consulta($sql);

    }

    public function Cambiarestatusnotificacion()
    {
          $query = "UPDATE notificacionadmin SET estatus = '$this->estatus' WHERE idnotificacionadmin = '$this->idnotificacionadmin'";
        $this->db->consulta($query);
    }


    public function getAccessToken() {

        $query = "SELECT *
            FROM 
            pag_configuracion"; 
        $result = $this->db->consulta($query);
        $row=$this->db->fetch_assoc($result);

        $archivo=$row['archivonotificacioncliente'];
        $this->nombreproyecto=$row['proyectofirebase'];
        
        $credentialsPath = '/home/issoftware/public_html/IS-U-ORDER/www/catalogos/notificaciones/llavenotificacion/'.$archivo;  // Asegúrate de que esta ruta sea correcta

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