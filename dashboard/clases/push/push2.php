<?php
//$token = '76d2fbcf8c5dfaccb64a467596e24b296ab415a0d6d92bc20a8781c00cfd66e4'; //token pepe
$token = '6d30fe29d1b155f0e127f7b0e47796262960c44df4191707240ec972a9721750'; //token con
$phrase = '121275';
$message = 'Hola creo que si funciono';

require_once('PushNotification2.php');

$push = new PushNotifications(array(
	'bundleId' => 'mx.capse.aexa',
	'googleAPIKey' => 'AAAATnCgOac:APA91bGIUUHwdt0GaIo-Rcu71_pzIUQnF4ulWzN2HeJEnJBW59Pm2Ly3o8gCWLdVL6cshd1VPu8ij5Q47THyRts4W1IQrz-f719l5Q_MgAN42lpM571qEU3IG7FdwlHmRail8k6bIsWu',
    'APNSCertificate' => 'ck.pem',     
    'APNSServer' => 'https://api.development.push.apple.com'
));

// APNSServer for production => https://api.push.apple.com
// Remember change APNSCertificate if u are in production to

$iOSTokens = ['6d30fe29d1b155f0e127f7b0e47796262960c44df4191707240ec972a9721750'];
//$androidTokens = ['token1', 'token2'];

$message = array('title' => 'Notification title', 'message' => 'your message');

//$push->sendAndroidNotifications($androidTokens, $message);
$push->sendiOSNotifications($iOSTokens, $message);

?>