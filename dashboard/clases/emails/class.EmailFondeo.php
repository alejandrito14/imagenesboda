 <?php
class Email_Fondeo
{
	//variables requeridas para el envio de this->mailer
	
	public $mailer;//objeto de this->mailerer
	
	public $email_facturacion;  //email a quien se le enviara el email	
	public $nombre_empleado; //nombre de la persona o personas encargadas de recibir el email de facturacion
	public $empresa_facturadora; //empresa que realizara la factura.
	
	public $email_operaciones; //email de la persona encargada de la plaza en operaciones
	public $nombre_empleado_operaciones; //nombre de la persona encargada de operaciones
		
	public $nombre_promotor; //nombre del empleado que hizo el negocio
	public $tipo_operacion; //tipo de operacion que se realizar flujo o nomina
	public $porc_negociado; //porcentaje que se pacto cobrarle al cliente
	public $no_fondeo; //no consecutivo del fondeo en le sistema
	public $f_fondeo; //fecha en que se realizo el fondeo
	public $cliente; //razon social de la empresa
	public $rfc; //rfc de la empresa a facturar
	public $direccion_fiscal; //direccion fiscal
	public $no_int; //no. interior
	public $no_ext; //no. exterior
	public $cp_fiscal; //CP codigo postal de la direccion fiscal
	public $colonia_fiscal; //colonia de la direccion fiscal
	public $ciudad_fiscal;//ciudad de la direccion fiscal
	public $estado_fiscal;//estado de la direccion fiscal
	
	public $nombrecontacto_cliente; //nombre del contacto del cliente.
	public $celularcontacto_cliente; //celulares del contacto cliente
	public $emailcontacto_cliente; //email de contacto del cliente
	
	
	public $iva; //iva con el que se hara la factura.
	public $subtotal; // subtotal de la operacion
	public $total_iva; //total del iva a cobrar
	public $total; //total sumatoria del subtotal mas iva = al flujo
	public $concepto_factura;//concepto de la factura
	public $devolucion; //cantidad a regresarle al cliente
	
	public $pedido;
	public $totales;
	public $no_venta;
	public $socio;
	public $fecha;
	public $nivel;
	public $saldos;
	
	public $sucursal;
	
		
	//funcion de envio de this->mailer para recuperar clave
	public function Envio_Email_facturacion()
	{		
		   //envio del ethis->mailer al Nuevo Socio 
			  $asunto="Generacion de Factura";
			  $cuerpo = '<html><style>
body{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	color:#333;
	font-size: .5em;
			
	}
	
table{
	width: 800px;
	
}


table fieldset
{
	background-color: #999;
	
	border:#666 solid 1px;
	padding: 3px;
	margin-bottom: 10px;
	

}

table fieldset legend
{
	background-color:#333;
	color:#CCC;
	padding-left: 5PX;
	padding-right:5PX;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:13px;
	
	
	
}

table fieldset label
{
	color:#CCC;
	font-size:13px;
}

table fieldset span
{
	color: #333;
	font-size: 13px;
}

table fieldset p
{
	color: #333;
	background-color: #FFF;
	font-size: 12px;
	padding:8px;
	border-radius: 7px;
	
}

#central{
	margin: auto;
	text-align:center;

}

#central h1{
	font-size:18px;
	color:#FFF;
	text-align:	center;
	padding: 10PX;
	background-color:#333;
	
	
	
}



</style>


<div id="central">

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <h1>GENERACION DE FACTURA  DEL FONDEO NO. '. $this->no_fondeo .'</h1>
    </td>
  </tr>
  <tr>
    <td><br>
     <fieldset>
      <legend>INFORMACION DE LA FACTURA </legend><label>FECHA DE FONDEO: </label><span> '.$this->f_fondeo.'</span>
        
        <br>
        <label>PROMOTOR: </label>
        <span>'.$this->nombre_promotor.'</span><br>
        <label>TIPO DE OPERACION: </label>
        <span>'.$this->tipo_operacion.'</span>
        <label><br>
          PORCENTAJE NEGOCIADO: </label>
        <span>'.$this->porc_negociado.' %<br>
        <span>
        <label>IVA:</label>
        <span>'.$this->iva.' %</span></span>        <br>
        <label>EMPRESA FACTURADORA: </label>
        <span>'. $this->empresa_facturadora.'</span>        <br>
        </span>
      
     </fieldset>
     
     <fieldset>
        <legend>DATOS DEL FONDEO</legend>
        <label><br>
          CLIENTE A FACTURAR: </label>
        <span>'. $this->cliente.'</span><br>
        <label>RFC: </label>
        <span>'. $this->rfc.'</span><br>
        <label>DIRECCION: </label>
        <span>'. $this->direccion_fiscal.'</span> 
        <label>No. Int.: </label>
        <span>'. $this->no_int.'</span> 
        <label>No. Ext.: </label>
        <span>'. $this->no_ext.'</span> 
        <label>C.P. : </label>
        <span>'. $this->cp_fiscal.'</span><br>
        <label>COLONIA: </label>
        <span>'. $this->colonia_fiscal.'</span> 
        <label>CIUDAD: </label>
        <span>'. $this->ciudad_fiscal.' 
        <label>ESTADO: </label>
        <span>'. $this->estado_fiscal.'</span></span><br>
        <br>
     </fieldset>
     
     
     <fieldset>
     <legend>CONCEPTO DE FACTURACION</legend>
     <br>
        
     
        <p>
         '.
		 $this->concepto_factura.'
          </p>
          <div style="text-align:right; padding-right: 10px;">
            <label>SUB - TOTAL: </label><span>$ '.$this->subtotal.'</span>
        <label><br>
          I.V.A.:</label><span> $ '.$this->total_iva.'</span>
          <br>
          <label>TOTAL: </label><span>$ '.$this->total.'  </span>
          </div>
     </fieldset>
    
    
      
    
    </td>
  </tr>
 
</table>





</div></html>
			  ';
			  		  
					  $this->mailer->IsSMTP(); // telling the class to use SMTP
					  try
					  {
			  //clase de php this->mailerer para enviar los correo
				
				$this->mailer->SMTPAuth      = false;                  // enable SMTP authentication
				$this->mailer->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
				$this->mailer->Host          = "corpsoluciones.com.mx"; // sets the SMTP server
				$this->mailer->Port          = 26;                    // set the SMTP port for the GMAIL server
				$this->mailer->Username      = "corpsolu@corpsoluciones.com.mx"; // SMTP account username
				$this->mailer->Password      = "=ITk!0XLa9c&";        // SMTP account password
				$this->mailer->SetFrom('corpsolu@corpsoluciones.com.mx', 'CORP SOLUCIONES SA DE CV');
			
				
				//$mail->AddReplyTo('list@mydomain.com', 'List manager');
				
				  $this->mailer->Subject    = utf8_encode($asunto);
				  $this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
				  $this->mailer->MsgHTML($cuerpo);
				  
				  //EMAIL PARA FACTURACION
				  $this->mailer->AddAddress($this->email_facturacion,$this->nombre_empleado); // CORREO DEL EMPLEADO
				  $this->mailer->AddAddress('jlgomeza@gmail.com', 'DEPTO DE FACTURACION'); // CORREO DEL EMPLEADO
				  //$this->mailer->AddReplyTo('jlgomeza@gmail.com', 'DEPTO DE FACTURACION'); //CORREO DE FACTURACION
				  
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
	
	
	
	
	
	function Envio_Email_Operacion()
	 {
	  //envio del ethis->mailer al Nuevo Socio 
			  $asunto="Devoluci�n de Fondeo al Cliente";
			  $cuerpo = '<html><style>
body{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	color:#333;
	font-size: .5em;
			
	}
	
table{
	width: 800px;
	
}


table fieldset
{
	background-color: #999;
	
	border:#666 solid 1px;
	padding: 3px;
	margin-bottom: 10px;
	

}

table fieldset legend
{
	background-color:#333;
	color:#CCC;
	padding-left: 5PX;
	padding-right:5PX;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:13px;
	
	
	
}

table fieldset label
{
	color:#CCC;
	font-size:13px;
}

table fieldset span
{
	color: #333;
	font-size: 13px;
}

table fieldset p
{
	color: #333;
	background-color: #FFF;
	font-size: 12px;
	padding:8px;
	border-radius: 7px;
	
}

#central{
	margin: auto;
	text-align:center;

}

#central h1{
	font-size:18px;
	color:#FFF;
	text-align:	center;
	padding: 10PX;
	background-color:#333;
	
	
	
}



</style>


<div id="central">

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <h1>DEVOLUCION DE FONDEO NO. '. $this->no_fondeo .' AL CLIENTE.</h1>
    </td>
  </tr>
  <tr>
    <td><br>
     <fieldset>
      <legend>INFORMACION DE LA DEVOLUCI�N </legend><label><br>
        FECHA DE FONDEO: </label><span> '.$this->f_fondeo.'</span>
        
        <br>
        <label>PROMOTOR: </label>
        <span>'.$this->nombre_promotor.'</span><br>
        <label>TIPO DE OPERACION: </label>
        <span>'.$this->tipo_operacion.'</span><span><br>
        <label>EMPRESA FACTURADORA: </label>
        <span>'. $this->empresa_facturadora.'</span>        <br>
        </span>
      
     </fieldset>
     
     
     <fieldset>
      <legend>DATOS DEL CLIENTE </legend>
      <label><br>
        RAZON SOCIAL: </label>
      <span> '.$this->cliente.'</span>
        
        <br>
       
          NOMBRE DEL CONTACTO: </label>
        <span>'.$this->nombrecontacto_cliente.'</span><br>
        <label>EMAIL DEL CONTACTO: </label>
        <span>'.$this->emailcontacto_cliente.'</span><span><br>
        <label>CELULAR DEL CONTACTO: </label>
        <span>'. $this->celularcontacto_cliente.'</span>        <br>
        </span>
      
     </fieldset>
     
     <fieldset>
        <legend>DEVOLUCI�N</legend>
        <label><br>
        </label>
        <span style="font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-size:2em; text-align:center">$ '.number_format($this->devolucion,2,'.',',').'</span><br>
        <br>
     </fieldset>
     
     
     
    </td>
  </tr>
 
</table>

</div></html>
			  ';
			  		  
					  $this->mailer->IsSMTP(); // telling the class to use SMTP
					  try
					  {
			  //clase de php this->mailerer para enviar los correo
				
				$this->mailer->SMTPAuth      = false;                  // enable SMTP authentication
				$this->mailer->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
				$this->mailer->Host          = "corpsoluciones.com.mx"; // sets the SMTP server
				$this->mailer->Port          = 26;                    // set the SMTP port for the GMAIL server
				$this->mailer->Username      = "corpsolu@corpsoluciones.com.mx"; // SMTP account username
				$this->mailer->Password      = "=ITk!0XLa9c&";        // SMTP account password
				$this->mailer->SetFrom('corpsolu@corpsoluciones.com.mx', 'CORP SOLUCIONES SA DE CV');
			
				
				//$mail->AddReplyTo('list@mydomain.com', 'List manager');
				
				  $this->mailer->Subject    = utf8_encode($asunto);
				  $this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
				  $this->mailer->MsgHTML($cuerpo);
				  
				  //EMAIL PARA FACTURACION
				  $this->mailer->AddAddress($this->email_operaciones,$this->nombre_empleado_operaciones); // CORREO DEL EMPLEADO
				  $this->mailer->AddAddress('jlgomeza@gmail.com', 'DEPTO DE OPERACIONES'); // CORREO DEL EMPLEADO
				  //$this->mailer->AddReplyTo('jlgomeza@gmail.com', 'DEPTO DE FACTURACION'); //CORREO DE FACTURACION
				  
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
	 
	 
	 
	 
	  public function Envio_Email_Nota()
	{
		   //envio del ethis->mailer al Nuevo Socio 
			  $asunto="Nota de Compra en JoyeriaKl";
			  $cuerpo = '<!DOCTYPE html>
<html>
<head>
<title>.:: SHOPPING CART ::.</title>
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
    
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#2C88D3">
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
                        <a href="http://joyeriakl.com" target="_blank">
                            <!--<img alt="Logo" src="http://joyeriakl.com/images/logokl.png" width="224" height="60" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">-->
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
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Compra procesada con &eacute;xito!</td>
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
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;" class="responsive-table">
				<tr>
								<td align="left" style="padding: 20px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">NO. PEDIDO:'.$this->no_venta.' </td>
								
                                <td align="right" style="padding: 20px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">FECHA:'.$this->fecha.' </td>
                            </tr>
							
							<tr>
								<td align="left" style="padding: 0px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">NIVEL:'.$this->nivel.' </td>
								
								<td align="right" style="padding: 0px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">SOCIO:'.$this->socio.' </td>
                            </tr>
							
							<tr>
								<td align="left" style="padding: 0px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">SUCURSAL:'.$this->sucursal.' </td>
								
								<td align="right" style="padding: 0px 0 0 0; width="50%" font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">&nbsp;</td>
                            </tr>
							
							<tr>
								
							</tr>
			
                <tr style="padding-top:10px;">
                    <td colspan="2">
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                    
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style=" margin-top: 30px; width:100%; " align="right">
                                    	<tr>
                                        	<td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">CLAVE</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">CAT</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">PRODUCTO</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">CANT.</td>
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">PRECIO</td>
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">% DESC</td>
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">DESC</td>
                                            
                                            <td align="center" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">TOTAL</td>
                                            
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
                    <td colspan="2" style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                        <!-- TWO COLUMNS -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td valign="top" class="mobile-wrapper">
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    '.$this->saldos.'
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    '.$this->totales.'
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
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding: 0 0 0 0; font-size: 14px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #aaaaaa; font-style: italic;" class="padding-copy">En caso de que el pedido no sea correcto o necesite alguna aclaraci&oacute;n enviar correco eletr&oacute;nico a la siguiente direcci&oacute;n: &nbsp;</td>
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
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tr>
                    <td>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                            <tr>
                                <!-- COPY -->
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">How did we do?</td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius, leo a ullamcorper feugiat, ante purus sodales justo, a faucibus libero lacus a est. Aenean at mollis ipsum.</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <!-- BULLETPROOF BUTTON -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="padding-top: 25px;" class="padding">
                                                <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                                    <tr>
                                                        <td align="center" style="border-radius: 3px;" bgcolor="#256F9C"><a href="https://litmus.com" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;" class="mobile-button">Let Us Know</a></td>
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
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
            <td align="center" valign="top" width="500">
            <![endif]-->
            <!-- UNSUBSCRIBE COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px; display:none;" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                       SUCURSALES
                        <br><br>
                        <div style="width:241px; text-align:center; padding-right: 8px;">
                        	(MATRIZ) 6 PTE SUR No. 707 - D <br>Tel: 9612157462 <br>Email: ventas@joyeriakl.com 
						</div>
                        <!--<span style="font-family: Arial, sans-serif; font-size: 12px; float:left; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <!--<div style="float:left; width:241px; text-align:center; padding-left:8px;">
                        	(5 NORTE) 5 NTE. PTE. 1402 <br>Tel: 9616114876 <br>Email: 5norte@joyeriakl.com 
						</div>-->
                        
                        <div style="clear:both;"></div>
                        <br>
                        
                        <!--<a href="http://litmus.com" target="_blank" style="color: #666666; text-decoration: none;">Unsubscribe</a>
                        <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>-->
                        <a href="http://www.joyeriakl.com" target="_blank" style="color: #666666; text-decoration: none;">Copyright � 2016, JoyeriaKl</a>
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
</html>
';
			  		  
					  $this->mailer->IsSMTP(); // telling the class to use SMTP
					  try
					  {
			  //clase de php this->mailerer para enviar los correo
				
				$this->mailer->SMTPAuth      = true;                  // enable SMTP authentication
				$this->mailer->SMTPKeepAlive = false;                  // SMTP connection will not close after each email sent
				$this->mailer->SMTPDebug  = 1; 
				$this->mailer->Host          = "mail.joyeriakl.com"; // sets the SMTP server
				$this->mailer->Port          = 26;                    // set the SMTP port for the GMAIL server
				$this->mailer->Username      = "ventas@joyeriakl.com"; // SMTP account username
				$this->mailer->Password      = "@ventas2010";        // SMTP account password
				$this->mailer->SetFrom('ventas@joyeriakl.com', 'JOYERIAKL ');
			
				
				//$mail->AddReplyTo('list@mydomain.com', 'List manager');
				
				  $this->mailer->Subject    = utf8_encode($asunto);
				  $this->mailer->AltBody    = "Para poder visualizar este email es necesario que tengas activo HTML!"; // optional, comment out and test
				  $this->mailer->MsgHTML($cuerpo);
				  
				  //EMAIL PARA RESTABLECER CONTRASE?A
				  $this->mailer->AddAddress($this->email_facturacion,$this->nombre_empleado); // CORREO DEL EMPLEADO
				  //$this->mailer->AddAddress('jlgomeza@gmail.com', 'CONFIRMACION DE LA CUENTA'); // CORREO DEL EMPLEADO
				  //$this->mailer->AddReplyTo('jlgomeza@gmail.com', 'DEPTO DE FACTURACION'); //CORREO DE FACTURACION
				  
				  //$this->mailer->			
				  $this->mailer->Send();
				 
				  // Clear all addresses and attachments for next loop
				  $this->mailer->ClearAddresses();
				  $this->mailer->ClearBCCs();
				  $this->mailer->ClearCCs();
				  $this->mailer->ClearAttachments();
				  $this->mailer->CharSet = 'UTF-8';
				  
					  }catch (phpmailerException $e) {
							  echo $e->errorMessage(); //Pretty error messages from PHPMailer
							} catch (Exception $e) {
							  echo $e->getMessage(); //Boring error messages from anything else!
							}		  
	}
	 
	 
	
}
?>