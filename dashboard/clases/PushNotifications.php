<?php
class PushNotifications {

	protected $AppBundleId; //com.yourappname.app
    protected $GoogleAPIKey; // API access key from Google API's Console
	protected $http2CurlConnection; // http2 connection
	protected $APNSCertificate; // .pem certificate
	protected $APNSServer; // apple url
    protected $Phrase; // clave de pem

	public function __construct($params) {
		$this->AppBundleId = $params['bundleId'];
		$this->GoogleAPIKey = $params['googleAPIKey'];
		$this->APNSCertificate = $params['APNSCertificate'];
		$this->APNSServer = $params['APNSServer'];
        $this->Phrase = $params['Phrase'];
    }

	public function sendiOSNotifications($tokens, $message){

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->APNSCertificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->Phrase);
        
        //servidor de desarrollo de apple
         $fp = stream_socket_client($this->APNSServer, $err,$errstr, 200, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		
		
        
        /*$body['aps'] = array(
            'alert' => $message['message'],
            'title' => $message['title'],
            'sound' => 'tada.mp3',
            'badge' => +0,
            'additionalData' => array(
                'tipo' => 1,
                'modulo' => 2
             ),
            );*/
		
        
        $body['aps'] = array('alert' => array(
                                              'title' => $message['title'],
                                              'body' => $message['message']											  
                                              ),
							'badge' => 0,
							'sound' => 'tada.mp3',
							'variables' => $message['variables']
							           
		);

        
        
        
        $payload = json_encode($body);
        
        	// ENVIAMOS LA NOTIFICCIONES A LOS TOKENS
		foreach ($tokens as $token){
			
            $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));  
            if (!$result)
                echo 'Message not delivered NO INDICA ERRROR' . PHP_EOL . $result;
            
		}
        
       
            fclose($fp);
        
	}
    
    public function sendAndroidNotifications($tokens, $message){
		$fields = array(
			'registration_ids' 	=> $tokens,
			'data'			=> $this->createAndroidMessage($message)
		);

		$headers = array(
			'Authorization: key=' . $this->GoogleAPIKey,
			'Content-Type: application/json'
		);

		return $this->androidCurl($headers, $fields);
    }

    public function iOSCurl($ch, $payload, $token) {
	    $url = "{$this->APNSServer}/3/device/{$token}";

	    $cert = realpath($this->APNSCertificate);

	    $headers = array(
	        "apns-topic: {$this->AppBundleId}",
	        "User-Agent: My Sender"
	    );

	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_PORT => 443,
	        CURLOPT_HTTPHEADER => $headers,
	        CURLOPT_POST => TRUE,
	        CURLOPT_POSTFIELDS => $payload,
	        CURLOPT_RETURNTRANSFER => TRUE,
	        CURLOPT_TIMEOUT => 30,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_SSLCERT => $cert,
	        CURLOPT_HEADER => 1
	    ));

	    $result = curl_exec($ch);
	    if ($result === FALSE) {
	      throw new Exception("Curl failed: " .  curl_error($ch));
	    }

		return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    
    public function androidCurl($headers, $fields) {
        $ch = curl_init();
		//curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch);
	    if ($result === FALSE) {
	      throw new Exception("Curl failed: " .  curl_error($ch));
	    }
        curl_close( $ch );
        return $result;
    }
                                          

    
    public function createAndroidMessage($message){
        return array(
			'message' 	=> $message['message'],
			'title'		=> $message['title'],
			'vibrate'	=> 1,
			'sound'		=> 1,
            'variables' => $message['variables']
			// 'subtitle'	=> 'This is a subtitle. subtitle',
			// 'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			// 'largeIcon'	=> 'large_icon',
			// 'smallIcon'	=> 'small_icon'
		);
	}
}