<?php 

class NotificacionPushCliente 
{

    public $apikey;
    public $db;
    public $idnotificacioncliente;
    public $estatus;


	public function EnviarNotificacion($listatokens,$titulo,$mensaje)
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


	
}


 ?>