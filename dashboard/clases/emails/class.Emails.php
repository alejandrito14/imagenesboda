<?php
class Emails
{
	//variables requeridas para el envio de this->mailer
	
	public $mailer;//objeto de this->mailerer
	
	//variables par configuracion de servidor de envio.
	
	public $Host;  // CONFIGURACION DEL SERVIDOR  SMTP
	public $Port;  // PUERTO DE SALIDA DEL SMTP
	public $Username; // SMTP USUARIO DE LA CUENTA
	public $Password; //  CONTRASEÑA DE LA CUENTA SMTP 
	
	//termina variables de configuracion de server.
	
	public $destino; //nombre del contacto del cliente.
	public $remitente; //nombre a quien se le envia
	public $destino_nombre;
	public $remitente_nombre;
	public $asunto; //Asunto del correo
	public $nombre;
	public $apellidos;
	public $mensaje;
	
	public $contenido; //Contenido del email
	
	public $email;
	public $msg;
	
	public $url;
	
	public $fecha;
	public $pedido;
	public $totales;
	public $idpedido;
	
	public $usuario;
	public $contrasena;
	
	//Funcion que nos sirve para realizar un envio de correo electronico.
	public function envio_email()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$cuerpo = '<html><head><style>table{border-spacing: 0;} table tr td{ border:solid 1px #000; padding:5px;} table tr th{ background:#eaeaea; border:solid 1px #000; padding:5px; }</style><title>CONTACTO DESDE SITIO WEB!</title></head><body><div style="width:100%; text-align:center; font-weight:bold; font-size:18px; margin-bottom:20px;">'.utf8_decode($this->asunto).'</div><div style="width:100%; text-align:center; font-weight:bold; font-size:18px; margin-bottom:20px;">'.utf8_decode($this->nombre." ".$this->apellidos).'</div><div style="width:100%; text-align:center; font-weight:bold; font-size:18px; margin-bottom:20px;">'.utf8_decode($this->email).'</div><div style="width:100%; text-align:center; font-weight:bold; font-size:18px; margin-bottom:20px;">'.utf8_decode($this->mensaje).'</div></body></html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			

			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_encode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			//EMAIL PARA EDUQUR.
			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddAddress("santillan@capse.mx","CONTACTO"); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();

					//echo 1;

			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
	
	
	public function envio_pedido()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Solicitud de pedido
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#c86cdb">
    	<td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Compra procesada con &eacute;xito!</td>
                            </tr>
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">No. PEDIDO:'.$this->idpedido.' </td>
                            </tr>
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">CLIENTE:'.$this->destino_nombre.' </td>
                            </tr>
                            
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">FECHA:'.$this->fecha.' </td>
                            </tr>
							
							
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;" class="padding">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                    
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%;" align="right">
                                    	<tr>
                                        	<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CLAVE</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRODUCTO</td>
											<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">TALLA</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CANT.</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRECIO</td>
                                            
                                            <!--<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">% DESC</td>
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">DESC</td>-->
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">TOTAL</td>
                                            
                                        </tr>
                                        
                                        <!-- CONTENIDO DEL MAIL DINAMICO -->
                                        '.$this->pedido.'
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" class="mobile-wrapper">
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <!--<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; font-weight: bold;">MONEDERO ELECTRONICO</td>
                                                    </tr>
                                                    <tr>
                                                    
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ANTERIOR</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ACTUAL</td>
                                                    </tr>
                                                </table>-->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">'.$this->totales.'</td>
                                                    </tr>
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">PAGO POR DEPOSITO EN EFECTIVO:</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">Realice el dep&oacute;sito en cualquiera de las siguientes cuentas:</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Dayanara Carrera V&aacute;zquez</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Santander: 5579 0990 1166 1446</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Bancomer: 4152 3133 7424 0070</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banorte: 4915 6630 3632 8178</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Arbey Oremirp L&oacute;pez Hern&aacute;ndez</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banamex: 5256 7827 4642 7494</td>
                                        </tr>
										
										<tr>
											<td>Favor de no realizar el pago total de tu pedido hasta que no recibas la confirmaci&oacute;n de existencia en los modelos que solic&iacute;taste (Realice &uacute;nicamente el deposito del anticipo).</td>
										</tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; margin-top:15px; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">COSTOS DE ENV&Iacute;O:</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">
												Estafeta V&iacute;a Terrestre:<br>
												$ 250.00 (Hasta 15 kg)<br>
												$ 320.00 (Hasta 30 kg)<br>
												$ 9.50 (Kilo extra)<br>
												Seguro: $ 99.00 (Por cada $1,000)<br>
												Tiempo de Entrega Estimado: 2 a 4 d&iacute;as h&aacute;biles<br><br>

												Nota: Pedidos pagados antes de las 12:00 pm ser&aacute;n enviados el mismo d&iacute;a excepto pagos por Banamex, ser&aacute;n enviados al d&iacute;a siguiente de la fecha de pago, debido a que estos pagos se reflejan 24 hrs despu&eacute;s.<br><br> 


												DHL Express:<br>
												$ 300.00 (Hasta 15 kg)<br>
												$ 370.00 (Hasta 30 kg)<br>
												Tiempo de Entrega Estimado: 24 hrs despu&eacute;s d&iacute;a h&aacute;bil, siempre y cuando no sea zona extendida.<br><br>

												Nota: Los env&iacute;os realizados a trav&eacute;s de esta paqueter&iacute;a, se env&iacute;an un d&iacute;a despu&eacute;s del pago, no incluyen seguro, y cualquier retraso no depender&aacute; de la empresa, ya que somos externos a la empresa de paqueter&iacute;a.
											</td>
                                        </tr>
									</table>
									
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #aaaaaa; font-style: italic;" class="padding-copy">En caso de que el pedido no sea correcto o necesite alguna aclaraci&oacute;n favor de enviar un correo eletr&oacute;nico a la siguiente direcci&oacute;n: ventas@calzadodayanara.com</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
						 Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
						</div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_encode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			$this->mailer->AddAddress("ventas@calzadodayanara.com",$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();


			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
	

 public function envio_detallepedido()
    {       
        //$asunto = "ENVIO DE EMAILS";
        $cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    Solicitud de pedido
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr bgcolor="#c86cdb">
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Compra procesada con &eacute;xito!</td>
                            </tr>
                            
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">No. PEDIDO:'.$this->idpedido.' </td>
                            </tr>
                            
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">CLIENTE:'.$this->destino_nombre.' </td>
                            </tr>
                            
                            
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">FECHA:'.$this->fecha.' </td>
                            </tr>
                            
                            
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;" class="padding">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                    
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%;" align="right">
                                        <tr>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CLAVE</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRESENTACIÓN</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRODUCTO</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CANT.</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRECIO</td>
                                            
                                           
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">IMPORTE</td>
                                            
                                        </tr>


            
                                        
                                        <!-- CONTENIDO DEL MAIL DINAMICO -->
                                        '.$this->pedido.'
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" class="mobile-wrapper">
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <!--<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; font-weight: bold;">MONEDERO ELECTRONICO</td>
                                                    </tr>
                                                    <tr>
                                                    
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ANTERIOR</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ACTUAL</td>
                                                    </tr>
                                                </table>-->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">'.$this->totales.'</td>
                                                    </tr>
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">PAGO POR DEPOSITO EN EFECTIVO:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">Realice el dep&oacute;sito en cualquiera de las siguientes cuentas:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Dayanara Carrera V&aacute;zquez</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Santander: 5579 0990 1166 1446</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Bancomer: 4152 3133 7424 0070</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banorte: 4915 6630 3632 8178</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Arbey Oremirp L&oacute;pez Hern&aacute;ndez</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banamex: 5256 7827 4642 7494</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Favor de no realizar el pago total de tu pedido hasta que no recibas la confirmaci&oacute;n de existencia en los modelos que solic&iacute;taste (Realice &uacute;nicamente el deposito del anticipo).</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; margin-top:15px; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">COSTOS DE ENV&Iacute;O:</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">
                                                Estafeta V&iacute;a Terrestre:<br>
                                                $ 250.00 (Hasta 15 kg)<br>
                                                $ 320.00 (Hasta 30 kg)<br>
                                                $ 9.50 (Kilo extra)<br>
                                                Seguro: $ 99.00 (Por cada $1,000)<br>
                                                Tiempo de Entrega Estimado: 2 a 4 d&iacute;as h&aacute;biles<br><br>

                                                Nota: Pedidos pagados antes de las 12:00 pm ser&aacute;n enviados el mismo d&iacute;a excepto pagos por Banamex, ser&aacute;n enviados al d&iacute;a siguiente de la fecha de pago, debido a que estos pagos se reflejan 24 hrs despu&eacute;s.<br><br> 


                                                DHL Express:<br>
                                                $ 300.00 (Hasta 15 kg)<br>
                                                $ 370.00 (Hasta 30 kg)<br>
                                                Tiempo de Entrega Estimado: 24 hrs despu&eacute;s d&iacute;a h&aacute;bil, siempre y cuando no sea zona extendida.<br><br>

                                                Nota: Los env&iacute;os realizados a trav&eacute;s de esta paqueter&iacute;a, se env&iacute;an un d&iacute;a despu&eacute;s del pago, no incluyen seguro, y cualquier retraso no depender&aacute; de la empresa, ya que somos externos a la empresa de paqueter&iacute;a.
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #aaaaaa; font-style: italic;" class="padding-copy">En caso de que el pedido no sea correcto o necesite alguna aclaraci&oacute;n favor de enviar un correo eletr&oacute;nico a la siguiente direcci&oacute;n: ventas@calzadodayanara.com</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
                         Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
                        </div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
                        </div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
                    
        $this->mailer->IsSMTP();                                // telling the class to use SMTP
        try
        {
            $this->mailer->SMTPAuth      = true;                // enable SMTP authentication
            $this->mailer->SMTPKeepAlive = true;                // SMTP connection will not close after each email sent
            $this->mailer->Host          = $this->Host;         // sets the SMTP server
            $this->mailer->Port          = $this->Port;         // set the SMTP port for the GMAIL server
            $this->mailer->Username      = $this->Username;     // SMTP account username
            $this->mailer->Password      = $this->Password;     // SMTP account password
            $this->mailer->SMTPSecure = 'ssl';
            $this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
            
            //$mail->AddReplyTo('list@mydomain.com', 'List manager');

            $this->mailer->Subject    = utf8_encode($this->asunto);
            $this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
            $this->mailer->MsgHTML($cuerpo);

            $this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
            //$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');                         
            //$this->mailer->AddAttachment('clases/emails/revista.pdf');


            //$this->mailer->           
            $this->mailer->Send();

            // Clear all addresses and attachments for next loop
            $this->mailer->ClearAddresses();
            $this->mailer->ClearBCCs();
            $this->mailer->ClearCCs();
            $this->mailer->ClearAttachments();


            }catch (phpmailerException $e) {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
                } catch (Exception $e) {
                echo $e->getMessage(); //Boring error messages from anything else!
                }   
    }
	
	
	public function envio_ticket_pedido()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Solicitud de pedido
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#c86cdb">
    	<td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Compra procesada con &eacute;xito!</td>
                            </tr>
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">No. PEDIDO:'.$this->idpedido.' </td>
                            </tr>
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">CLIENTE:'.$this->destino_nombre.' </td>
                            </tr>
                            
							
							<tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">FECHA:'.$this->fecha.' </td>
                            </tr>
							
							
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;" class="padding">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                    
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%;" align="right">
                                    	<tr>
                                        	<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CLAVE</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRODUCTO</td>
											<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">TALLA</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">CANT.</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">PRECIO</td>
                                            
                                            <!--<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">% DESC</td>
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">DESC</td>-->
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold; padding:7px;">TOTAL</td>
                                            
                                        </tr>
                                        
                                        <!-- CONTENIDO DEL MAIL DINAMICO -->
                                        '.$this->pedido.'
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" class="mobile-wrapper">
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <!--<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; font-weight: bold;">MONEDERO ELECTRONICO</td>
                                                    </tr>
                                                    <tr>
                                                    
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ANTERIOR</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ACTUAL</td>
                                                    </tr>
                                                </table>-->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">'.$this->totales.'</td>
                                                    </tr>
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">PAGO POR DEPOSITO EN EFECTIVO:</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">Realice el dep&oacute;sito en cualquiera de las siguientes cuentas:</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Dayanara Carrera V&aacute;zquez</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Santander: 5579 0990 1166 1446</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Bancomer: 4152 3133 7424 0070</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banorte: 4915 6630 3632 8178</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">T&iacute;tular: Arbey Oremirp L&oacute;pez Hern&aacute;ndez</td>
                                        </tr>
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">Banamex: 5256 7827 4642 7494</td>
                                        </tr>
										
										<tr>
											<td>Favor de no realizar el pago total de tu pedido hasta que no recibas la confirmaci&oacute;n de existencia en los modelos que solic&iacute;taste (Realice &uacute;nicamente el deposito del anticipo).</td>
										</tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; margin-top:15px; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px; font-weight:bold;" class="padding-copy">COSTOS DE ENV&Iacute;O:</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-bottom:15px;" class="padding-copy">
												Estafeta V&iacute;a Terrestre:<br>
												$ 250.00 (Hasta 15 kg)<br>
												$ 320.00 (Hasta 30 kg)<br>
												$ 9.50 (Kilo extra)<br>
												Seguro: $ 99.00 (Por cada $1,000)<br>
												Tiempo de Entrega Estimado: 2 a 4 d&iacute;as h&aacute;biles<br><br>

												Nota: Pedidos pagados antes de las 12:00 pm ser&aacute;n enviados el mismo d&iacute;a excepto pagos por Banamex, ser&aacute;n enviados al d&iacute;a siguiente de la fecha de pago, debido a que estos pagos se reflejan 24 hrs despu&eacute;s.<br><br> 


												DHL Express:<br>
												$ 300.00 (Hasta 15 kg)<br>
												$ 370.00 (Hasta 30 kg)<br>
												Tiempo de Entrega Estimado: 24 hrs despu&eacute;s d&iacute;a h&aacute;bil, siempre y cuando no sea zona extendida.<br><br>

												Nota: Los env&iacute;os realizados a trav&eacute;s de esta paqueter&iacute;a, se env&iacute;an un d&iacute;a despu&eacute;s del pago, no incluyen seguro, y cualquier retraso no depender&aacute; de la empresa, ya que somos externos a la empresa de paqueter&iacute;a.
											</td>
                                        </tr>
									</table>
									
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #aaaaaa; font-style: italic;" class="padding-copy">En caso de que el pedido no sea correcto o necesite alguna aclaraci&oacute;n favor de enviar un correo eletr&oacute;nico a la siguiente direcci&oacute;n: ventas@calzadodayanara.com</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
						 Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
						</div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_encode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();


			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
	
	
	public function envio_registro()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Bienvenido a Calzado Dayanara
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#c86cdb">
    	<td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" alt="LOGO" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">&#33;Bienvenido(a) a Calzado Dayanara!</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; padding-bottom:15px;" class="padding-copy">Al crear esta cuenta, podr&aacute;s realizar compras a trav&eacute;s del portal <a href="https://www.calzadodayanara.com" target="_blank">www.calzadodayanara.com</a>, adem&aacute;s de ello contar&aacute;s con una &aacute;rea espec&iacute;fica para el cliente en la que podr&aacute;s llevar el control de tus pedidos realizados, cancelados y/o pagados.</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; padding-bottom:15px; font-weight: bold;" class="padding-copy">Acceso a tu cuenta</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">USUARIO: '.$this->usuario.'</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">CONTRASE&Ntilde;A: '.$this->contrasena.'</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-top:15px; padding-bottom:15px;" class="padding-copy">nos complace resolver todas sus dudas. Cont&Aacute;ctanos a trav&eacute;s de los siguientes medios:<br><br>
											</td>
                                        </tr>
									</table>
									
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
						 Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
						</div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_encode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddAddress("ventas@todoamayoreo.com",$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();


			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
	
	
	public function envio_recuperacion()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$nombre_boton = "Reestablecer contraseña";
		$name = "contraseña";
		$cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Bienvenido a calzado dayanara
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#c86cdb">
    	<td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" alt="LOGO" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Recueperaci&oacute;n de acceso a su cuenta de Calzado Dayanara</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; padding-bottom:15px;" class="padding-copy">Para reestablecer su '.utf8_decode($name).' entre al enlace.</td>
                                        </tr>
										
										<tr>
                                            <td align="center" class="padding-copy">
												<a href="'.$this->url.'" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">'.utf8_decode($nombre_boton).'</a>
											</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-top:15px; padding-bottom:15px;" class="padding-copy">nos complace resolver todas sus dudas. Cont&Aacute;ctanos a trav&eacute;s de los siguientes medios:<br><br>
											</td>
                                        </tr>
									</table>
									
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
						 Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
						</div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_decode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddAddress("ventas@todoamayoreo.com",$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();


			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
	
	
	public function envio_confirmacion_clave()
	{		
		//$asunto = "ENVIO DE EMAILS";
		$cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>CALZADO DAYANARA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
            max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .padding-copy {
             padding: 10px 5% 10px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
	Bienvenido a calzado dayanara
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#c86cdb">
    	<td>&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 15px 0;" class="logo">
                        <a href="https://www.calzadodayanara.com" target="_blank">
                            <img alt="Logo" src="https://www.calzadodayanara.com/images/logo.png" width="120" alt="LOGO" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                        </a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Los datos de acceso de su cuenta han sido reestablecidos</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; padding-bottom:15px;" class="padding-copy">Tu Cuenta te permite realizar compras a trav&eacute;s del portal <a href="https://www.calzadodayanara.com" target="_blank">www.calzadodayanara.com</a>, adem&aacute;s de un &aacute;rea para el control de los pedidos realizados.</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; padding-bottom:15px; font-weight: bold;" class="padding-copy">Acceso a tu cuenta</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">USUARIO: '.$this->usuario.'</td>
                                        </tr>
										
										<tr>
                                            <td align="center" style="padding: 10px; font-weight:bold; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; background:#eaeaea;" class="padding-copy">CONTRASE&Ntilde;A: '.$this->contrasena.'</td>
                                        </tr>
										
										<tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #222; text-transform:uppercase; padding-top:15px; padding-bottom:15px;" class="padding-copy">nos complace resolver todas sus dudas. Cont&Aacute;ctanos a trav&eacute;s de los siguientes medios:<br><br>
											</td>
                                        </tr>
									</table>
									
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       Tel&eacute;fono: 993 279 2072  -
						 Email: ventas@calzadodayanara.com
                        <br><br>
                        <div style="float:left; width:241px; text-align:center; padding-right: 8px;">
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <div style="float:left; width:241px; text-align:center; padding-left:8px;">
						</div>
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="https://www.calzadodayanara.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright &copy; 2019, Calzado Dayanara</a>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>';
					
		$this->mailer->IsSMTP(); 								// telling the class to use SMTP
		try
		{
			$this->mailer->SMTPAuth      = true;               	// enable SMTP authentication
			$this->mailer->SMTPKeepAlive = true;               	// SMTP connection will not close after each email sent
			$this->mailer->Host          = $this->Host; 		// sets the SMTP server
			$this->mailer->Port          = $this->Port;       	// set the SMTP port for the GMAIL server
			$this->mailer->Username      = $this->Username; 	// SMTP account username
			$this->mailer->Password      = $this->Password;    	// SMTP account password
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->SetFrom($this->remitente, $this->remitente_nombre);
			
			//$mail->AddReplyTo('list@mydomain.com', 'List manager');

			$this->mailer->Subject    = utf8_decode($this->asunto);
			$this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
			$this->mailer->MsgHTML($cuerpo);

			$this->mailer->AddAddress($this->destino,$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddAddress("ventas@todoamayoreo.com",$this->destino_nombre); // CORREO DEL ENCARGADO DE TOMAR LA INFORMACION DE LA PAGINA.
			//$this->mailer->AddCC('jlgomeza@gmail.com','jose luis');						  
			//$this->mailer->AddAttachment('clases/emails/revista.pdf');


			//$this->mailer->			
			$this->mailer->Send();

			// Clear all addresses and attachments for next loop
			$this->mailer->ClearAddresses();
			$this->mailer->ClearBCCs();
			$this->mailer->ClearCCs();
			$this->mailer->ClearAttachments();


			}catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				}	
	}
}
?>