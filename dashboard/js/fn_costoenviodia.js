function Guardarcostodia(form,regresar,donde,idmenumodulo) {

	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);


		var sucursal=$("#sucursal").val();
		var fecha=$("#fecha").val();
		var horainicial=$("#horainicial").val();
		var horafinal=$("#horafinal").val();
		var costoinicial=$("#costoinicial").val();
		var bandera=1;
		if (sucursal==0) {
			bandera=0;
		}
		if (fecha=='') {
			bandera=0;
		}
		if (horainicial=='') {
			bandera=0;
		}
		if (horafinal=='') {
			bandera=0;
		}
		if (costoinicial=='') {
			bandera=0;
		}
		
		if (bandera==1) {
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/costospordia/ga_costosenvio.php', //Url a donde la enviaremos
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
	else{

		var respuesta="";

		

		if (sucursal==0) {
		 respuesta+="-Sucursal es requerido"+"<br>";
		}
		if (fecha=='') {
		 respuesta+="-Fecha es requerido"+"<br>";
		}
		if (horainicial=='') {
		 respuesta+="-Hora inicial es requerido"+"<br>";
		}
		if (horafinal=='') {
		 respuesta+="-Hora final es requerido"+"<br>";
		}
		if (costoinicial=='') {
		 respuesta+="-Costo es requerido"+"<br>";
		}

	

	


		AbrirNotificacion('Han ocurrido los siguientes errores:<br>'+respuesta,"mdi-checkbox-marked-circle");


	}
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

function BorrarCostoEnviodia(idcostoenvio,idmenumodulo) {
	var datos='idcostoenvio='+idcostoenvio;

	var regresar ='catalogos/costospordia/vi_costodia.php';
		var r = confirm("¿SEGURO DE ELIMINAR EL REGISTRO?");
	if (r == true) {

	$.ajax({
					url:'catalogos/costospordia/borrar_costoenvio.php', //Url a donde la enviaremos
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
							var resp = msj;

							console.log("El resultado de msj es: "+msj);
							if( resp == 1 ){
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito",'main');
							}else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,'main');
							}			
						}
					});
	}
}
/*function ObtenerSucursales(idsucursal,elemento) {
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
}*/