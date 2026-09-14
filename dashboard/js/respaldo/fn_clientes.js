function NuevoDireccionEnvio()
{
	$("#form_cliente")[0].reset();
	$("#btn_agregar_direccion_envio").html("AGREGAR DIRECCIÓN");
	$("#btn_nuevo_direccion_envio").hide();
}

function NuevoDireccionEnvioLimpiar() {
	$("#form_cliente")[0].reset();
	$("#btn_agregar_direccion_envio").html("AGREGAR DIRECCIÓN");
	$("#btn_nuevo_direccion_envio").hide();
}



function ModificarDireccionEnvio(datos)
{
	//alert("Entro a metodo "+datos);
	var content = JSON.stringify(datos); 
	var content = JSON.parse(content);
	var nocliente=content.no_cliente;
	var idempresa=content.idempresa;
	var menumodulo=content.idmenumodulo;


	
	 ModalDireccion(nocliente,idempresa,menumodulo);
	
	$("#v_idclientes_envio").val(content.idclientes_envio);
	$("#v_direccion_envio").val(content.direccion);
	$("#v_no_int_envio"	).val(content.no_int);
	$("#no_ext_envio").val(content.no_ext);
	$("#v_colonia_envio").val(content.col);
	$("#v_cp_envio").val(content.cp);



	$("#v_pais_envio").val(content.pais);
	$('#v_pais_envio').trigger("chosen:updated");

	ObtenerEstadosC(content.estado);

	console.log('estado'+content.estado);

	$("#v_estado_envio").val(content.estado);
	ObtenerMunicipiosC(content.estado,content.municipio);

	console.log('municipio'+content.municipio);

	$("#v_municipio_envio").val(content.municipio);

			//	ObtenerLocalidadesC2(content.municipio,content.ciudad);
			console.log('localidad'+content.ciudad);


				//$("#v_ciudad_envio").val(content.ciudad);
				$("#v_telefono_envio").val(content.telefono);

				$("#v_ciudad_envio").val(content.ciudad);

				$("#v_referencia_envio").val(content.referencia);
				$("#btn_agregar_direccion_envio").html("MODIFICAR");
				//$("#btn_nuevo_direccion_envio").show();


				$("#titulo-modal-forms2").html('MODIFICAR DIRECCIÓN');


				


			}


			function ModificarDireccionEnvio2(datos)
			{
				alert("Entro a metodo "+datos);
				var content = JSON.stringify(datos); 
				var content = JSON.parse(content);




				$("#v_idclientes_envio").val(content.idclientes_envio);
				$("#v_direccion_envio").val(content.direccion);
				$("#v_no_int_envio").val(content.no_int);
				$("#no_ext_envio").val(content.no_ext);
				$("#v_colonia_envio").val(content.col);
				$("#v_cp_envio").val(content.cp);

				

				$("#v_pais_envio").val(content.pais);

				ObtenerEstadosC(content.estado);

				console.log('estado'+content.estado);

				$("#v_estado_envio").val(content.estado);
				ObtenerMunicipiosC(content.estado,content.municipio);

				console.log('municipio'+content.municipio);

				$("#v_municipio_envio").val(content.municipio);

			//	ObtenerLocalidadesC2(content.municipio,content.ciudad);
			console.log('localidad'+content.ciudad);


				//$("#v_ciudad_envio").val(content.ciudad);


				$("#v_ciudad_envio").val(content.ciudad);

				$("#v_referencia_envio").val(content.referencia);
				$("#btn_agregar_direccion_envio").html("MODIFICAR DIRECCIÓN");
				$("#btn_nuevo_direccion_envio").show();




			}



			function GuardarDireccionEnvio(idmenumodulo,idcliente)
			{

				var resp = MM_validateForm('v_direccion_envio','','R','v_colonia_envio','','R','v_ciudad_envio','','R','v_estado_envio','','R','v_pais_envio','','R');  

				if(resp==1)
				{ 

					if(confirm("\u00BFDesea Agregar la dirección de envio del cliente ?"))
					{

						var idclientes_envio = $("#v_idclientes_envio").val();
						var direccion = $("#v_direccion_envio").val();
						var no_int = $("#v_no_int_envio").val();
						var no_ext =  $("#no_ext_envio").val();
						var col = $("#v_colonia_envio").val();
						var cp = $("#v_cp_envio").val();
						var ciudad = $("#v_ciudad_envio").val();
						var estado = $("#v_estado_envio").val();
						var pais = $("#v_pais_envio").val();
						var referencia = $("#v_referencia_envio").val();
						var municipio=$("#v_municipio_envio").val();

						var datos = "direccion="+direccion+"&no_int="+no_int+"&no_ext="+no_ext+"&col="+col+"&cp="+cp+"&ciudad="+ciudad+"&estado="+estado+"&pais="+pais+"&referencia="+referencia+"&idclientes_envio="+idclientes_envio+"&idcliente="+idcliente+"&municipio="+municipio;
						console.log(datos);

						setTimeout(function(){
							$.ajax({
					url:'catalogos/clientes/ga_direccion_envio.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#d_lista_direcciones_envio").html(error); 
						},
						success:function(msj){


							$("#form_cliente")[0].reset();
							$("#btn_agregar_direccion_envio").html("AGREGAR DIRECCIÓN");

							l_direcciones_envio(idcliente,idmenumodulo)	



						}
					});				  					  
						},10);	

					}

				}


			}






			function l_direcciones_envio(idcliente,idmenumodulo)
			{
				
				var datos = "idcliente="+idcliente+"&idmenumodulo="+idmenumodulo;

				setTimeout(function(){
					$.ajax({
					url:'catalogos/clientes/l_direcciones_envio.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#d_lista_direcciones_envio").html(error); 
						},
						success:function(msj){


							$("#d_lista_direcciones_envio").html(msj); 	


						}
					});				  					  
				},10);	

			}


			function Buscar_cliente()
			{
				var nombre = $('#nombre').val();
	//var paterno = $('#paterno').val();
	//var materno = $('#materno').val();
	//var estatus = $('#estatus').val();
	//var razon_social = $('#razon_social').val();
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


function GuardarCliente(form,regresar,donde,idmenu)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		var datos = ObtenerDatosFormulario(form);

		var opcionestipopagobloqueada=[];

		if ($('.tiposdepagos')) {
		$(".tiposdepagos").each(function( index ) {
		  	var idelemento=$(this).attr('id');

		  	if ($("#"+idelemento).is(':checked')) {

		  		var splitelemnto=idelemento.split('_');

		  		var texto=$("#tiposdepagotext_"+splitelemnto[1]).text();

		  		var objeto={
		  			id:splitelemnto[1],
		  			text:texto
		  		};

		  		opcionestipopagobloqueada.push(objeto);

		  	}

		});
	}

	var validacioncel=0;
	if ($("#validaciontelefono")) {

		if ($("#validaciontelefono").is(':checked')) {
			validacioncel=0;
		}else{

			validacioncel=1;
		}

	}

	var bloquearediciondedatos=0;

	if ($("#bloquearediciondedatos")) {

		if ($("#bloquearediciondedatos").is(':checked')) {
			bloquearediciondedatos=1;
		}else{
			bloquearediciondedatos=0;
		}
	}

		if (opcionestipopagobloqueada.length>0) {

				datos+='&opcionestipopagobloqueada='+JSON.stringify(opcionestipopagobloqueada);

		}

		datos+="&validacioncel="+validacioncel+"&bloquearediciondedatos="+bloquearediciondedatos;
		

		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')

		setTimeout(function(){
			$.ajax({
					url:'catalogos/clientes/ga_clientes.php', //Url a donde la enviaremos
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
							if ( msj == 1 ){
								aparecermodulos(regresar+"?ac=1&msj=Operacion realizada con exito&idmenumodulo="+idmenu,donde);
							}else{
								aparecermodulos(regresar+"?ac=0&msj=Error. "+msj+"&idmenumodulo="+idmenu,donde);
							}			
						}
					});				  					  
		},10);
	}
}

function ObtenerEstadosC(idestado) {

	var idpais=$("#v_pais_envio").val();
	var datos="idpais="+idpais;
	setTimeout(function(){
		$.ajax({
							url:'catalogos/prospectos/obtenerestados.php', //Url a donde la enviaremos
							type:'POST', //Metodo que usaremos
							data: datos, //Le pasamos el objeto que creamos con los archivos
							async:false,
							error:function(XMLHttpRequest, textStatus, errorThrown){
								var error;
								console.log(XMLHttpRequest);
								  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
								  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
								  $("#main").html(error); 
								},
								success:function(msj){

									$("#v_estado_envio").html(msj);
									$("#v_estado_envio").chosen({width: "100%"});
									
									//$('#v_estado_envio').trigger("chosen:updated");
									if (idestado>0) {
										$("#v_estado_envio").val(idestado);
										$('#v_estado_envio').trigger("chosen:updated");

									}

								}
							});				  					  
	},10);					
}


function ObtenerMunicipiosC(estado,idmunicipio) {
	
	var datos="idestado="+estado;


	setTimeout(function(){
		$.ajax({
							url:'catalogos/prospectos/obtenermunicipios.php', //Url a donde la enviaremos
							type:'POST', //Metodo que usaremos
							data: datos, //Le pasamos el objeto que creamos con los archivos
							async:false,
							error:function(XMLHttpRequest, textStatus, errorThrown){
								var error;
								console.log(XMLHttpRequest);
								  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
								  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
								  $("#main").html(error); 
								},
								success:function(msj){

									$("#v_municipio_envio").html(msj);
									$("#v_municipio_envio").chosen();
									$('#v_municipio_envio').trigger("chosen:updated");

									if (idmunicipio>0) {
										$("#v_municipio_envio").val(idmunicipio);
										$('#v_municipio_envio').trigger("chosen:updated");

									}
								}
							});				  					  
	},10);	
}


function ObtenerLocalidadesC(idlocalidades) {
	var idmunicipio=$("#v_municipio_envio").val();

	var datos="idmunicipio="+idmunicipio;
//	alert(idlocalidades);
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

									$("#v_ciudad_envio").html(msj);
									$("#v_ciudad_envio").chosen();
									$('#v_ciudad_envio').trigger("chosen:updated");
									/*if (idlocalidades>0) {

									$("#v_ciudad_envio").val(idlocalidades);
									$('#v_ciudad_envio').trigger("chosen:updated");

								}*/

							}
						});				  					  
},10);	
}

function ObtenerLocalidadesC2(idmunicipio,idlocalidades) {


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

									$("#v_ciudad_envio").html(msj);
									$("#v_ciudad_envio").chosen();
									$('#v_ciudad_envio').trigger("chosen:updated");
									if (idlocalidades>0) {

										$("#v_ciudad_envio").val(idlocalidades);
										$('#v_ciudad_envio').trigger("chosen:updated");

									}

								}
							});				  					  
	},10);	
}


function EstablecerEstado(idestado,idmunicipio,idlocalidades) {
	var idpais=$("#v_fis_pais").val();

	ObtenerEstadosCatalogo(idestado,idpais,'v_fis_estado');
	ObtenerMunicipiosCatalogo(idmunicipio,idestado,'v_fis_municipio');
	ObtenerLocalidadesCatalogo(idlocalidades,idmunicipio,'v_fis_ciudad');
}

function Establecer(idestado) {
	alert(idestado);
	$("#v_fis_estado").val(idestado);
}

function EstablecerEstado1() {

	ObtenerEstadosCatalogo(0,idpais,idelemento);

}

function BorrarCliente(idcliente,nombre,idmenumodulo) {

	var r = confirm("¿SEGURO DE ELIMINAR CLIENTE "+nombre+" ?");
	if (r == true) {



		var datos='idcliente='+idcliente;

		$.ajax({
							url:'catalogos/clientes/eliminarcliente.php', //Url a donde la enviaremos
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

									if (msj==0) {
										AbrirNotificacion('EL CLIENTE TIENE COMPRAS ','mdi mdi-checkbox-marked-circle');

									}

									if (msj==1) {

											AbrirNotificacion('SE HA ELIMINADO CORRECTAMENTE','mdi mdi-checkbox-marked-circle');

											aparecermodulos('catalogos/clientes/vi_clientes.php?idmenumodulo='+idmenumodulo,'main');
	
									}

								}
							});

	} 
}



function ModificarRfcCliente(idcliente,idrfc,idmenumodulo)
   {
	   //alert("eliminaremos al rfc del cliente "+idcliente + " idrfc "+ idrfc);
	   
	   if(confirm("Desea Eliminar el RFC del cliente"))
		   {
	   	var datos='idrfc='+idrfc+"&idcliente="+idcliente;
		$.ajax({
							url:'catalogos/facturacion/rfcclientes/b_rfc_clientes.php', //Url a donde la enviaremos
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

									if (msj==1) {
										
										//alert("El rfc fue borrado correcdtamente.");
										var que = 'catalogos/facturacion/rfcclientes/li_clientesrfc.php?id='+idcliente+'&idmenumodulo='+idmenumodulo;
										
						                aparecermodulos2(que,'listas_clientes_rfc','/ FACTURACION / RFC CLIENTES /');


									}

								
								}
							});
	   
	   
	   
		   }
	   
	   
   }






function BorrarRfcCliente(idcliente,idrfc,idmenumodulo)
   {
	   //alert("eliminaremos al rfc del cliente "+idcliente + " idrfc "+ idrfc);
	   
	   if(confirm("Desea Eliminar el RFC del cliente"))
		   {
	   	var datos='idrfc='+idrfc+"&idcliente="+idcliente;

		$.ajax({
							url:'catalogos/facturacion/rfcclientes/b_rfc_clientes.php', //Url a donde la enviaremos
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

									if (msj==1) {
										
										//alert("El rfc fue borrado correcdtamente.");
										var que = 'catalogos/facturacion/rfcclientes/li_clientesrfc.php?id='+idcliente+'&idmenumodulo='+idmenumodulo;
										
						                aparecermodulos2(que,'listas_clientes_rfc','/ FACTURACION / RFC CLIENTES /');


									}

								
								}
							});
	   
	   
	   
		   }
	   
	   
   }

function PrincipalRfcCliente(idcliente,idrfc,idmenumodulo)
{
	
	   
	   if(confirm("Desea hacer este RFC del cliente como principal"))
		   {
	   	var datos='idrfc='+idrfc+"&idcliente="+idcliente;

		$.ajax({
							url:'catalogos/facturacion/rfcclientes/g_rfc_Principalclientes.php', //Url a donde la enviaremos
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

									if (msj==1) {
										
										//alert("El rfc fue borrado correcdtamente.");
										var que = 'catalogos/facturacion/rfcclientes/li_clientesrfc.php?id='+idcliente+'&idmenumodulo='+idmenumodulo;
										
						                aparecermodulos2(que,'listas_clientes_rfc','/ FACTURACION / RFC CLIENTES /');


									}

								
								}
							});
	   
	   
	   
		   }
	
}

function HabilitarObservaciones() {

	if ($("#habilitarobservaciones").is(':checked')) {

		$("#habilitarobservaciones").val(1);
		$("#habilitarobservaciones").attr('checked',true);

	}else{

		$("#habilitarobservaciones").val(0);
		$("#habilitarobservaciones").attr('checked',false);
	}
}

function AbrirModalDireccionesEnvio(idcliente,idmenumodulo) {

	var datos="idcliente="+idcliente+"&idmenumodulo="+idmenumodulo;

			$.ajax({
					url:'catalogos/clientes/obtenerdireccionesenvio.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
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

						$("#contenedor-direcciones").html(msj);
						$("#modaldirecciones").modal();
			
					  	}
				  });
}

function AbrirModalDatosFiscales(idcliente,idmenumodulo) {

	var datos="idcliente="+idcliente+"&idmenumodulo="+idmenumodulo;

			$.ajax({
					url:'catalogos/clientes/obtenerdatosfiscales.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
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

						$("#contenedor-direccionesfiscales").html(msj);
						$("#modaldireccionesfiscales").modal();
			
					  	}
				  });
}

function OpcionesPago(opcionespago) {
	
		$.ajax({
			url:'catalogos/clientes/obteneropcionespago.php', //Url a donde la enviaremos
			type:'POST', //Metodo que usaremos
			dataType:'json',
			error:function(XMLHttpRequest, textStatus, errorThrown){
				var error;
				console.log(XMLHttpRequest);
				  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $("#main").html(error); 
				},
				success:function(msj){

					PintarOpcionesPago(msj,opcionespago);
								
				}
			});
}

function PintarOpcionesPago(respuesta,opcionespago) {
		var html="";
	for (var i = 0; i <respuesta.length; i++) {
		html+=`


					<div class="form-check " id="">
						   <input type="checkbox" value="`+respuesta[i].idtipodepago+`" class="form-check-input tiposdepagos" id="tiposdepago_`+respuesta[i].idtipodepago+`" >
						 <label class="form-check-label" for="flexCheckDefault" id="tiposdepagotext_`+respuesta[i].idtipodepago+`">`+respuesta[i].tipo+`</label>
					</div>

		`;
	}

	$("#opcionestipopago").html(html);

	if (opcionespago!=0) {
		var opcionespago2=JSON.parse(opcionespago);
		for (var i = 0; i <opcionespago2.length; i++) {
			
			$("#tiposdepago_"+opcionespago2[i].id).attr('checked',true);
		}

	}
}

function validartelefonocheck(validar) {
	
	if (validar==1) {
		$("#validaciontelefono").attr('checked',false);
	}
	else{
		$("#validaciontelefono").attr('checked',true);

	}
}

function validarbloquearediciondatos(validar) {
	if (validar==1) {
		$("#bloquearediciondedatos").attr('checked',true);
	}
	else{
		$("#bloquearediciondedatos").attr('checked',false);

	}
}
