<?php
//$token = '76d2fbcf8c5dfaccb64a467596e24b296ab415a0d6d92bc20a8781c00cfd66e4'; //token pepe
$token = '6d30fe29d1b155f0e127f7b0e47796262960c44df4191707240ec972a9721750'; //token con
$phrase = '121275';
$message = 'Hola creo que si funciono';

$ctx = stream_context_create();

stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $phrase);

//serevidor produccion de apple
//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 200, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

//servidor de desarrollo de apple
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 200, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


if (!$fp)
{
	    exit("Failed to connect: $err $errstr" . PHP_EOL);  
}
else
{
		echo 'Connected to APNS' . PHP_EOL;
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'tada.mp3',
			'badge' => +0
			);
		$payload = json_encode($body);
		$msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
		$result = fwrite($fp, $msg, strlen($msg));
		if (!$result)
			echo 'Message not delivered' . PHP_EOL;
		else
			echo 'Message successfully delivered' . PHP_EOL;
		fclose($fp);
}
	   

