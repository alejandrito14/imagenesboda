function Guardarcodigopostalcosto(form,regresar,donde,idmenumodulo) {

	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/costosenvio/ga_costosenvio.php', //Url a donde la enviaremos
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

function ObtenerCodigospostales() {
	
	  $.ajax({
					url:'catalogos/costosenvio/ObtenerCodigospostales.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
						success:function(msj){

						console.log(msj);
								
					  	}
				  });	
}

function ObtenerProveedores(idproveedor,elemento) {
	 $.ajax({
					url:'catalogos/costosenvio/ObtenerProveedores.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
						success:function(msj){

							var respuesta=msj.proveedores;

							console.log(respuesta.length);
							var html="";
							if (respuesta.length>0) {
								html+=`<option value="0">SELECCIONAR PROVEEDOR</option>`;


								for (var i = 0; i < respuesta.length; i++) {

										//armar nivel
										html+=`<option value="`+respuesta[i].idproveedor+`">`+respuesta[i].empresa+`</option>`;

									}
								}else{
									html+=`<option value="0">No se encuentran proveedores</option>`;


								}

								$("#"+elemento).html(html);

								if (idproveedor>0) {
								$("#"+elemento).val(idproveedor);
	
								}
								
					  	}
				  });	
}

function ObtenerSucursales(idsucursal,elemento) {
	 $.ajax({
					url:'catalogos/costosenvio/ObtenerSucursales.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json',
					async:false,
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
						success:function(msj){

							var respuesta=msj.sucursales;

							var html="";
							if (respuesta.length>0) {
								html+=`<option value="0">SELECCIONAR SUCURSAL</option>`;


								for (var i = 0; i < respuesta.length; i++) {

										//armar nivel
										html+=`<option value="`+respuesta[i].idsucursales+`">`+respuesta[i].sucursal+'-'+respuesta[i].codigopostal+`</option>`;

									}
								}else{
									html+=`<option value="0">No se encuentran sucursales</option>`;


								}

								$("#"+elemento).html(html);

								if (idsucursal>0) {
								$("#"+elemento).val(idsucursal);
	
								}
								
					  	}
				  });	
}