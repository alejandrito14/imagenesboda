<?php
require_once ("../clases/class.phpmailer.php");
require_once ("../clases/class.Configuracion.php");
require_once ("../clases/conexcion.php");

$db = new MySQL();
$conf = new Configuracion();



$conf->db = $db;


$datos_conf = $conf->ObtenerInformacionConfiguracion();



if($datos_conf['e_verificado'] == 0)
  {

echo "Empresa: " .$empresa = $datos_conf['nombre_empresa'];
echo "<br> cuenta: ".$e_envia = $datos_conf['e_cuenta'];
echo "<br>clave: ".$e_clave = $datos_conf['e_clave'];
echo "<br>puerto: ".$p_envio = $datos_conf['e_psaliente'];
echo "<br>smtp: ".$smtp = $datos_conf['e_smtp'];
echo "<br>email: ".$email   =   $datos_conf['email'];
echo "<br>asunto: ".$asunto  =  "Prueba";
echo "<br>ensaje: ".$mensaje =  "Prueba de envio";


 
 if($datos_conf['e_autentication'] ==  1)
   {
    echo $SMTPAuth = true;
   }else{
	echo $SMTPAuth = false;
   }





$mail = new PHPMailer(); 
 
//Luego tenemos que iniciar la validación por SMTP: 
$mail->IsSMTP(); 
$mail->SMTPAuth = $SMTPAuth; // True para que verifique autentificación de la cuenta 
$mail->Username = $e_envia; // Cuenta de e-mail 
$mail->Password = $e_clave; // Password 
$mail->Port = $p_envio; //puerto saliente de envio de mail
$mail->Host = $smtp; 
$mail->From = $e_envia;
$mail->FromName = $empresa;
$mail->Subject = "Probando Email";
$mail->AddAddress($email,$empresa);
$mail->WordWrap = 50;

//$mail->AddAttachment("../tmp/prueba.pdf");
 


$mail->Body = $mensaje; 
 
if ($mail->Send())
{ 
   echo 1;
   
   $sql = "UPDATE configuracion SET e_verificado=1";
   $db->consulta($sql);
   
}
else 
{
	$mail->ErrorInfo ;
	echo $mail->ErrorInfo ;
	exit;
	}
	 
  }
  else
  {
	  echo 0;
  }
?>