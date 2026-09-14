function g_Configuracion()
{
	//recibimos todos los datos...
	
  var archivos = document.getElementById("v_logo");//Damos el valor del input tipo file
  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
 


   var v_id = $('#v_id').val();
  
	var telefono1 = $('#telefono1').val();
	var telefono2 = $('#telefono2').val();
	var telefono01800 = $('#telefono01800').val();
	var celular = $('#celular').val();
	var celular2 = $('#celular2').val();
	var emailsoporte = $('#emailsoporte').val();
	var emailpedido = $('#emailpedido').val();	
	var cantidadminimo = $('#cantidadminimo').val();	
	var costoenvio = $('#costoenvio').val();	
		
	var facebook = $('#facebook').val();
	var twitter = $('#twitter').val();
	var rss = $('#rss').val();
	var delicious = $('#delicious').val();
	var linkedin = $('#linkedin').val();
	var flickr = $('#flickr').val();
	var skype = $('#skype').val();
	var instagram = $('#instagram').val();
	var googlemap = $('#googlemap').val();
	var whatsapp = $('#whatsapp').val();
	var whatsapp2 = $('#whatsapp2').val();
	var otro=0;
	var tarjeta=0;
	var oxxo=0;
	var spei=0;
	var negocio=$("#negocio").val();
	var diasvencimiento=$("#diasvencimiento").val();

	var bienvenida = CKEDITOR.instances['descripcion'].getData();

	if ($('#otro').is(':checked')) {
		otro=1;
	}
	if ($('#tarjeta').is(':checked')) {
		tarjeta=1;
	}
  
  	if ($('#oxxo').is(':checked')) {
		oxxo=1;
	}
	if ($("#spei").is(':checked')) {
		spei=1;
	}

	var llavepublica=$("#llavepublica").val();
	var llaveprivada=$("#llaveprivada").val();
	var host=$("#host").val();
  	var puerto=$("#puerto").val();
  	var usuario=$("#usuario").val();
  	var contrasena=$("#contrasena").val();
  	var remitente=$("#remitente").val();
  	var nombreremitente=$("#nombreremitente").val();
  	var nombrenegocio1=$("#nombrenegocio1").val();
  	var texto1=$("#texto1").val();
	var smtauth='false';  	

	if ($('#smtauth').is(':checked')) {
		smtauth='true';
	}
	var seguridad=$("#smtpseguridad").val();
  //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
  var data = new FormData();

   data.append('v_id',v_id);

  //Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
  //objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
  //que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
  for(i=0; i<archivo.length; i++){
    data.append('archivo'+i,archivo[i]);
  }
  

	data.append('telefono1', telefono1);
	data.append('telefono2', telefono2);
	data.append('celular', celular);
	data.append('celular2', celular2);
	
	data.append('telefono01800', telefono01800);
	data.append('emailsoporte', emailsoporte);
	data.append('emailpedido', emailpedido);
	data.append('whatsapp', whatsapp);
	data.append('whatsapp2', whatsapp2);
	data.append('cantidadminimo', cantidadminimo);
	data.append('costoenvio', costoenvio);
  
  
	data.append('facebook', facebook);
	data.append('twitter', twitter);
	data.append('rss', rss);
	data.append('delicious', delicious);
	data.append('linkedin', linkedin);
	data.append('flickr', flickr);
	data.append('skype', skype);
	data.append('instagram', instagram);
	data.append('googlemap', googlemap);

	data.append('otrometodo',otro);
  	data.append('tarjeta',tarjeta);
	data.append('oxxo',oxxo);
	data.append('spei',spei);
	data.append('negocio',negocio);

	data.append('llavepublica',llavepublica);
 	data.append('llaveprivada',llaveprivada);
 	data.append('host',host);
	data.append('puerto',puerto);
	data.append('usuario',usuario);
	data.append('contrasena',contrasena);
	data.append('remitente',remitente);
	data.append('nombreremitente',nombreremitente);
	data.append('smtauth',smtauth);
	data.append('seguridad',seguridad);
	data.append('bienvenida',bienvenida);
	data.append('diasvencimiento',diasvencimiento);
	data.append('nombrenegocio1',nombrenegocio1);
	data.append('texto1',texto1);
	
$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')


  $.ajax({
	  url:'catalogos/configuracion/ga_pagconfig.php', //Url a donde la enviaremos
    type:'POST', //Metodo que usaremos
    contentType:false, //Debe estar en false para que pase el objeto sin procesar
    data:data, //Le pasamos el objeto que creamos con los archivos
    processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
    cache:false, //Para que el formulario no guarde cache,
	error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos("catalogos/configuracion/vi_pagconfig.php?ac=0&msj=Error. "+error,'main');
					  },
         }).done(function(msg)
           {
			   console.log(msg);
	            if(msg == 1)
	                   {
					aparecermodulos('catalogos/configuracion/vi_pagconfig.php?ac=1&msj=Operacion realizada con exito','main');
					   }else
					   {

					aparecermodulos('catalogos/configuracion/vi_pagconfig.php?ac=1&msj=Operacion no fue realizada','main');
						 }
	  
            });
  

	
	
	
}


function VerificarEmail(donde)
{

    //verificaremos el sistema haciendo un tester de la configuración.
	$("#"+donde).html("Realizando Prueba");
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'administrador/testerEmail.php',					  
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					  $("#"+donde).html(msj);
					  
					  	/*if(msj == 1)
						   {
						      $("#"+donde).html(msj);  
						   }else
						   {
                            $("#"+donde).html(msj); 
							}
						*/
						
						
					  }
				  });				  					  
		},800);	
		
		


}