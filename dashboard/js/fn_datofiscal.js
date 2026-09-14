function Guardardatofiscal(form,regresar,donde,idmenumodulo) {
	
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/datofiscal/ga_datofiscal.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
					success:function(msj){
						var resp = msj.split('|');
						
						   console.log("El resultado de msj es: "+msj);
						 	if( resp[0] == 1 ){
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito&idempresas="+resp[1],donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });				  					  
		},1000);
	 }
}

function Buscarcodigo() {
	var codigo=$("#v_codigopostal").val();
	var tamanio=$("#v_codigopostal").val().length;
	var datos="codigo="+codigo;
	var pagina = "buscarcodigo.php";


	if (tamanio>=5) {

	$.ajax({
 			type: 'POST',
			url:'catalogos/datofiscal/'+pagina, //Url a donde la enviaremos
			data:datos,
			dataType:'json',
 			error:function(XMLHttpRequest, textStatus, errorThrown){
 				console.log(arguments);
 				var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  AbrirNotificacion(error,"mdi-alert-octagon");
						  //$('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
						},
						success:function(msj){

							console.log(msj);

							var json=msj;

							var variables=json.respuesta;
							idestado=variables.idestado;
							idmunicipio=variables.idmunicipio;
							pais=variables.pais;

							

							if (variables.respuesta==1) {

								$("#codigomsj").html('');
								$("#codigomsj").css('visibility','hidden');


								/*ObtenerEstadosCatalogo(idestado,pais,'estado');
								ObtenerMunicipiosCatalogo(idmunicipio,idestado,'municipio');
*/								
								ObtenerEstado(idestado,pais);
								ObtenerMunicipios(idmunicipio,idestado);

								$("#v_pais").val(pais);

								/*$("#v_pais").attr('disabled',true);
								$("#v_estado").attr('disabled',true);
								$("#v_municipio").attr('disabled',true);*/

								/*$("#estado").val(idestado);
								$("#municipio").val(idmunicipio);*/

							}

							if(variables.respuesta==0){

								var texto='<label style="font-size:14px;">'+variables.mensaje+'</label>';
								$("#codigomsj").html(texto);
								$("#codigomsj").css('visibility','visible');


								$("#v_pais").val(0);
								$("#v_estado").val(0);
								$("#v_municipio").val(0);
							}

							if (variables.respuesta==3) {
								$("#codigomsj").css('visibility','hidden');

								$("#codigomsj").html('');
	
							}

							if (variables.respuesta==2) {

								var texto='<label style="font-size:14px;">'+variables.mensaje+'</label>';
								$("#codigomsj").html(texto);
								$("#codigomsj").css('visibility','visible');
								$("#v_pais").val(0);
								$("#v_estado").val(0);
								$("#v_municipio").val(0);
							}
						}

						
	 					
	 				});	

		}else{

			$("#codigomsj").html('');
			$("#pais").val(0);
			$("#estado").val(0);
			$("#municipio").val(0);

		}
}