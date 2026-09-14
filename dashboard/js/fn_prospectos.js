

function CerrarSeguimiento(idseguimiento)
{
	if(confirm('¿Deseas Cerrar el seguimiento?'))
				{
					var datos = "idseguimiento="+idseguimiento;	
	 				console.log(datos);
					
				   	setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/cerrar_seguimiento.php', //Url a donde la enviaremos
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

									//CargarHistorialSeguimiento(idseguimiento);
									var idProspecto=$("#v_idprospecto").val();
									ListadeSeguimiento(idProspecto);
								}
						  });				  					  
					},10);					
				}
}

function ObtenerEstados(idestado) {

	var idpais=$("#v_pais").val();
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

									$("#v_estado").html(msj);
									$("#v_estado").chosen();
									
									$('#v_estado').trigger("chosen:updated");
									if (idestado>0) {
									$("#v_estado").val(idestado);
									$('#v_estado').trigger("chosen:updated");

									}

								}
						  });				  					  
					},10);					
				}

function ObtenerMunicipios(idmunicipio) {
	var estado=$("#v_estado").val();

	alert(estado);
	var datos="idestado="+estado;
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

									$("#v_municipio").html(msj);
									$("#v_municipio").chosen();
									$('#v_municipio').trigger("chosen:updated");

									if (idmunicipio>0) {
									$("#v_municipio").val(idmunicipio);
									$('#v_municipio').trigger("chosen:updated");

									}
								}
						  });				  					  
					},10);	
}

function ObtenerMunicipios2(idestado,idmunicipio) {
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

									$("#v_municipio").html(msj);
									$("#v_municipio").chosen();
									$('#v_municipio').trigger("chosen:updated");

									if (idmunicipio>0) {
									$("#v_municipio").val(idmunicipio);
									$('#v_municipio').trigger("chosen:updated");

									}
								}
						  });				  					  
					},10);	
}

function ObtenerLocalidades(idlocalidades) {
		var idmunicipio=$("#v_municipio").val();
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

									$("#v_ciudad").html(msj);
									$("#v_ciudad").chosen();
									$('#v_ciudad').trigger("chosen:updated");
									if (idlocalidades>0) {

									$("#v_ciudad").val(idlocalidades);
									$('#v_ciudad').trigger("chosen:updated");

									}

								}
						  });				  					  
					},10);	
}


function ObtenerEstados(idestado) {

	var idpais=$("#v_pais").val();
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

									$("#v_estado").html(msj);
									$("#v_estado").chosen();
									
									$('#v_estado').trigger("chosen:updated");
									if (idestado>0) {
									$("#v_estado").val(idestado);
									$('#v_estado').trigger("chosen:updated");

									}

								}
						  });				  					  
					},10);					
				}

function ObtenerMunicipios(idmunicipio) {
	var estado=$("#v_estado").val();
	var datos="idestado="+estado;
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

									$("#v_municipio").html(msj);
									$("#v_municipio").chosen();
									$('#v_municipio').trigger("chosen:updated");

									if (idmunicipio>0) {
									$("#v_municipio").val(idmunicipio);
									$('#v_municipio').trigger("chosen:updated");

									}
								}
						  });				  					  
					},10);	
}

function ObtenerMunicipiosP(idestado,idmunicipio) {
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

									$("#v_municipio").html(msj);
									$("#v_municipio").chosen();
									$('#v_municipio').trigger("chosen:updated");

									if (idmunicipio>0) {
									$("#v_municipio").val(idmunicipio);
									$('#v_municipio').trigger("chosen:updated");

									}
								}
						  });				  					  
					},10);	
}

function ObtenerLocalidades(idlocalidades) {
		var idmunicipio=$("#v_municipio").val();
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

									$("#v_ciudad").html(msj);
									$("#v_ciudad").chosen();
									$('#v_ciudad').trigger("chosen:updated");
									if (idlocalidades>0) {

									$("#v_ciudad").val(idlocalidades);
									$('#v_ciudad').trigger("chosen:updated");

									}

								}
						  });				  					  
					},10);	
}

function ObtenerLocalidades2(idmunicipio,idlocalidades) {
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

									$("#v_ciudad").html(msj);
									$("#v_ciudad").chosen();
									$('#v_ciudad').trigger("chosen:updated");
									if (idlocalidades>0) {

									$("#v_ciudad").val(idlocalidades);
									$('#v_ciudad').trigger("chosen:updated");

									}

								}
						  });				  					  
					},10);	
}

function BorrarHistorialSeguimiento(idprospectos_seguimiento,idseguimiento)
{
	
			if(confirm('¿Deseas Eliminar el historial de este seguimiento?'))
				{
					var datos = "idprospectos_seguimiento="+idprospectos_seguimiento+"&idseguimiento="+idseguimiento;	
	 				console.log(datos);
					
				   	setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/eliminar_historial.php', //Url a donde la enviaremos
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

									CargarHistorialSeguimiento(idseguimiento)

								}
						  });				  					  
					},10);					
				}
	
	
}


function GuardarHistoricoSeguimiento(idseguimiento)
{
	//alert("Guardaremos Historico del seguimiento " + idseguimiento);
	
		var resp= MM_validateForm('v_historico','','R'); 
	    
	if(resp == 1)
		{
			if(confirm('¿Deseas guardar el historial?'))
				{
					
					
					var v_historico = $("#v_historico").val();
					var v_fecha_historico = $("#v_fecha_historico").val();
					var v_hora_historico = $("#v_hora_historico").val();

					
					var datos = "idseguimiento="+idseguimiento+"&v_fecha_historico="+v_fecha_historico+"&v_hora_historico="+v_hora_historico+"&v_historico="+v_historico;	
	 				console.log(datos);
					
				   	setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/ga_historial.php', //Url a donde la enviaremos
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

									CargarHistorialSeguimiento(idseguimiento)

								}
						  });				  					  
					},10);	
	
					
					
					
					
					
					
					
					
				}
		}
	
	
	
	
}

function CargarHistorialSeguimiento(idseguimiento)
{
	
	//alert("Vamos a cargar historial de seguimiento "+idseguimiento);
	//$('#d_historia_seguimiento').html('Probando el cambio con el '+idseguimiento);
	
	
	 var datos = "idseguimiento="+idseguimiento;
	
	 console.log(datos);
				   
				   	setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/vi_historial_seguimientos.php', //Url a donde la enviaremos
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

										$('#d_historia_seguimiento').html(msj);	

								}
						  });				  					  
					},10);	
	
	
	
}





function EliminarSeguimiento(idseguimiento,idprospecto)
{
		if(confirm("Deseas Eliminar el Seguimiento"))
			   {
				   
				  
				   var datos = "idseguimiento="+idseguimiento;
				   
				   	setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/eliminar_seguimiento.php', //Url a donde la enviaremos
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

											ListadeSeguimiento(idprospecto);		

								}
						  });				  					  
					},10);	
				   
				   
				   
				   
				   
				   
				   
			   }
}



function AgregarSeguimiento(idprospecto)
{
	
	var resp=MM_validateForm('v_f_programado','','R','v_tipo_atencion','','R','v_seguimiento','','R'); 
	
	if(resp == 1)
		{
			if ($("#v_tipo_atencion").val()!='t') {
			if(confirm("Deseas Agregar Seguimiento al prospecto"))
			   {

				  	
				   
				   var v_f_programado = $('#v_f_programado').val();
				   var v_fechayhoraProgramada  =$('#v_fechayhoraProgramada').val();
				   var v_tipo_atencion = $('#v_tipo_atencion').val();
				   var v_seguimiento = $('#v_seguimiento').val();
		   
				   
				   var datos = "v_f_programado="+v_f_programado+"&v_tipo_atencion="+v_tipo_atencion+"&v_seguimiento="+v_seguimiento+'&idprospecto='+idprospecto+"&v_h_programado="+v_fechayhoraProgramada;
				   
				   
				    console.log(datos);
				    //return;
				   
					 setTimeout(function(){
						  $.ajax({
							url:'catalogos/prospectos/ga_seguimiento.php', //Url a donde la enviaremos
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

											ListadeSeguimiento(idprospecto);		

								}
						  });				  					  
					},10);	
				   


			   }
			}else{


				AbrirNotificacion('TIPO DE ATENCIÓN REQUERIDO','mdi mdi-alert');

			}
			
			
		}
	
	
}


function ListadeSeguimiento(idProspecto)
{
	var datos = "idprospecto="+idProspecto;
	console.log(datos);

	setTimeout(function(){
				  $.ajax({
					url:'catalogos/prospectos/li_seguimientos.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#l_seguimiento").html(error); 
					  },
					success:function(msj){
						
					      $("#l_seguimiento").html(msj); 
						
					  	}
				  });				  					  
		},10);	
}


function CrearloCliente(idprospecto,idempresa,idmenumodulo)
{
	if(confirm("¿Deseas convertir a tu prospecto a cliente?"))
		{
	
	var datos = "idprospecto="+idprospecto+"&idempresa="+idempresa;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	$("#main").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/prospectos/ga_cliente.php', //Url a donde la enviaremos
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
					      //$("#main").html(msj); 
						  
                           aparecermodulos('catalogos/prospectos/vi_prospectos.php?idmenumodulo='+idmenumodulo,'main'); 
						
					  	}
				  });				  					  
		},10);	
	
	}
}

function CrearloCliente2(idprospecto,idempresa,idmenumodulo)
{
	if(confirm("¿Deseas convertir a tu prospecto a cliente?"))
		{
	
	var datos = "idprospecto="+idprospecto+"&idempresa="+idempresa;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	$("#main").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/prospectos/ga_cliente.php', //Url a donde la enviaremos
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
					      //$("#main").html(msj); 
						  
                           aparecermodulos('catalogos/ventas/vi_clientesventas.php?idmenumodulo='+idmenumodulo,'main'); 
						
					  	}
				  });				  					  
		},10);	
	
	}
}





function Buscar_prospetos()
{
	var nombre = $('#nombre').val();
	var paterno = $('#paterno').val();
	var materno = $('#materno').val();
	var idempresas = $('#idempresas').val();
	
	var datos = "nombre="+nombre+"&idempresas="+idempresas;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	$("#contenedor_clientes").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/clientes/li_clientes.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#contenedor_clientes").html(error); 
					  },
					success:function(msj){
					      $("#contenedor_clientes").html(msj); 	  
					  	}
				  });				  					  
		},10);	
}


function GuardarProspecto(form,regresar,donde,idmenu)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		var datos = ObtenerDatosFormulario(form);
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/prospectos/ga_prospecto.php', //Url a donde la enviaremos
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
						    $('#modal-forms').modal('hide');
						    console.log("El resultado de msj es: "+msj);
						
						     var respuesta = msj.split("|");
						    console.log("el primero arreglo es"+respuesta[0])
						
						
						    
						    
						
						   if ( 1 == respuesta[0] ){
								aparecermodulos(regresar+"?ac=1&msj=Operacion realizada con exito&idmenumodulo="+idmenu+"&idcliente="+respuesta[1],donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&msj=Error. "+msj+"&idmenumodulo="+idmenu+"&idcliente="+respuesta[1],donde);
						  	}		
					  	}
				  });				  					  
		},1000);
	 }
}

function ObtenerTiposAtencion() {

	setTimeout(function(){
				  $.ajax({
					url:'catalogos/prospectos/obtenertiposatencion.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#l_seguimiento").html(error); 
					  },
					success:function(msj){
						
					      $("#v_tipo_atencion").html(msj); 
						
					  	}
				  });				  					  
		},10);	
}

