<?php

class PushNotifications {

	protected $AppBundleId; //com.yourappname.app
    protected $GoogleAPIKey; // API access key from Google API's Console
	protected $http2CurlConnection; // http2 connection
	protected $APNSCertificate; // .pem certificate
	protected $APNSServer; // apple url

	public function __construct($params) {
		$this->AppBundleId = $params['bundleId'];
		$this->GoogleAPIKey = $params['googleAPIKey'];
		$this->APNSCertificate = $params['APNSCertificate'];
		$this->APNSServer = $params['APNSServer'];
    }

	public function sendiOSNotifications($tokens, $message){
		// this is only needed with php prior to 5.5.24
		if (!defined('CURL_HTTP_VERSION_2_0')) {
		  define('CURL_HTTP_VERSION_2_0', 3);
		}

		//open ssl connection
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

		// send push notifications to all tokens
		foreach ($tokens as $token){
			$payload = $this->createiOSMessage($message);
            $this->iOSCurl($ch, $payload, $token);
		}

		// close connection
		curl_close($ch);
	}
    
    public function sendAndroidNotifications($tokens, $message){
		$fields = array(
			'registration_ids' 	=> $tokens,
			'data'			=> $this->createAndroidMessage($message);
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
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
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

    public function createiOSMessage($message){
		$payload['aps'] = array(
			'alert' => array(
				'title' => $message['title'],
				'body' => $message['message']
			),
			'badge' => 1,
			'sound' => 'default'
		);
		return json_encode($payload);
    }
    
    public function createAndroidMessage($message){
        return array(
			'message' 	=> $message['message'],
			'title'		=> $message['title'],
			'vibrate'	=> 1,
			'sound'		=> 1
			// 'subtitle'	=> 'This is a subtitle. subtitle',
			// 'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			// 'largeIcon'	=> 'large_icon',
			// 'smallIcon'	=> 'small_icon'
		);
	}
}
