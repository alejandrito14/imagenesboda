<?php
class PushNotification {
	private static $apiServerKey = "";// Key del servidor para hacer el envio
	public function __construct($apiServerKey)
	{
		self::$apiServerKey = $apiServerKey;
	}
    /**
     * Funcion para realozar el envio de la notificaión al servidor de FCM
     * @param  array | Array con la información de la notificación. Campos "title" y "body"
     * @param  array | Array con los Token de los dispositivos para el envío de la notificación
     * @return [type]
     */

	public function sendNotificateFCM($dataMessages=[],$notifyDevice=[])
	{
		$urlFcmServices = "https://fcm.googleapis.com/fcm/send";
		$fields = array(
            'registration_ids' => $notifyDevice,
            'priority' => 10,
            'notification' => array(
            	'title' =>  $dataMessages['title'], 
            	'body'  =>  $dataMessages['body'] ,
            	'sound' => 'Default',
            	'image' => 'Notification Image' ),
        );
        $headers = array(
            'Authorization:key=' . self::$apiServerKey,
            'Content-Type:application/json'
        );
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $urlFcmServices); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
        return $result;
	}
}