<?php
include_once('PushNotification.php');




$pushFcm = new PushNotification("AAAA0eFo3eE:APA91bE9CPQmSrF9SbsdKoBqyHhJ0OgOtnkQ-urpz5FDxo7RhoToEtJAkjuUvHd7Zw575LxB6ha_XOsEjWdIEOzlwGUi4hj_akq9IOjq2_1W5UogYd6-HPOpoI_sQTD43Mjf3RBQ9WY0");

// mensaje a enviar a la application
$dataSend = [
"title"=>"Lo logramos",
"body"=>"ESTA ES UNA PRUEBA DE ENVIO FCM"
];
$tokenDevice[] = "f0toxoZcdt8:APA91bGlCDmKS1dk0MPFrCpDeOZXehuISqn1B-JU2eT5AkhIs7gmv5DukR_Fx0Z_Z4dO6iAL4pVP_tLTWuIxdAW-xXApyk--aA5bffdm6P9bHfLDnMGdx7JWc70zgxkVP9CViP2me7mu";

// mandando la notificacion

$response = $pushFcm->sendNotificateFCM($dataSend,$tokenDevice);

echo json_encode($response);


?>