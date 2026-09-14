



        function ObtenerMunicipiosCatalogo(idmunicipio,idestado,idelemento) {


        	var datos="idestado="+idestado;
        	setTimeout(function(){
        		$.ajax({
							url:'catalogos/prospectos/obtenermunicipios.php', //Url a donde la enviaremos
							type:'POST', //Metodo que usaremos
							data: datos, //Le pasamos el objeto que creamos con los archivos
							error:function(XMLHttpRequest, textStatus, errorThrown){
								var error;
								console.log(XMLHttpRequest);
								  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
								  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
								  $("#main").html(error); 
								},
								success:function(msj){

									$("#"+idelemento).html(msj);
									$('#'+idelemento).chosen({width:"100%"});

									$('#'+idelemento).trigger("chosen:updated");

									if (idmunicipio>0) {
										$("#"+idelemento).val(idmunicipio);
										$('#'+idelemento).trigger("chosen:updated");

									}
								}
							});				  					  
        	},10);	
        }

        function ObtenerEstadosCatalogo(idestado,idpais,idelemento) {

        
        	var datos="idpais="+idpais;

        	setTimeout(function(){
        		$.ajax({
							url:'catalogos/prospectos/obtenerestados.php', //Url a donde la enviaremos
							type:'POST', //Metodo que usaremos
							data: datos, //Le pasamos el objeto que creamos con los archivos
							error:function(XMLHttpRequest, textStatus, errorThrown){
								var error;
								console.log(XMLHttpRequest);
								  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
								  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
								  $("#main").html(error); 
								},
								success:function(msj){

									$("#"+idelemento).html(msj);
									$('#'+idelemento).chosen({width:"100%"});
									
									$('#'+idelemento).trigger("chosen:updated");
									if (idestado>0) {
										$("#"+idelemento).val(idestado);
										$('#'+idelemento).trigger("chosen:updated");

									}

								}
							});				  					  
        	},10);					
        }


        function ObtenerEstadosCatalogo2(idestado,idpais,idelemento) {


        	console.log(idelemento);

        	var elementos=idelemento.split(",");




        	ObtenerEstadosCatalogo(idestado,idpais,elementos[0]);
        	ObtenerEstadosCatalogo(idestado,idpais,elementos[1]);



        }

        function ObtenerLocalidadesCatalogo(idlocalidades,idmunicipio,idelemento) {
        	var datos="idmunicipio="+idmunicipio;

        	setTimeout(function(){
        		$.ajax({
							url:'catalogos/prospectos/obtenerlocalidades.php', //Url a donde la enviaremos
							type:'POST', //Metodo que usaremos
							data: datos, //Le pasamos el objeto que creamos con los archivos
							error:function(XMLHttpRequest, textStatus, errorThrown){
								var error;
								console.log(XMLHttpRequest);
								  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
								  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
								  $("#main").html(error); 
								},
								success:function(msj){

									$("#"+idelemento).html(msj);
									$('#'+idelemento).chosen({width:"100%"});
									$('#'+idelemento).trigger("chosen:updated");
									if (idlocalidades>0) {

										$("#"+idelemento).val(idlocalidades);
										$('#'+idelemento).trigger("chosen:updated");

									}

								}
							});				  					  
        	},10);	
        }

        function trim(str) {
        return str.replace(/^\s+|\s+$/g,"");
			}

