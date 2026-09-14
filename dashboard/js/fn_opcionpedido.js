function Guardaropcionpedido(form,regresar,donde,idmenumodulo)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/opcionespedido/ga_opcionespedido.php', //Url a donde la enviaremos
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

function Cambiarfecha() {
	if($("#confecha").is(':checked')){

		$("#confecha").val(1);

	}else{

		$("#confecha").val(0)
	}
}

function habilitardireccion() {
	if($("#condireccionentrega").is(':checked')){

		$("#condireccionentrega").val(1);

	}else{

		$("#condireccionentrega").val(0);
	}
}



function habilitaretiqueta1() {
	
	if($("#habilitaretiqueta").is(':checked')){

		$("#habilitaretiqueta").val(1);
		$("#etiqueta").css('display','block');

	}else{

		$("#habilitaretiqueta").val(0);
		$("#etiqueta").css('display','none');

	}
}

function habilitarmensaje1() {

	if($("#habilitarmensaje").is(':checked')){

		$("#habilitarmensaje").val(1);
		$("#mensaje").css('display','block');

	}else{

		$("#habilitarmensaje").val(0);
		$("#mensaje").css('display','none');

	}
}

function habilitarsumamonto1() {
	
	if ($("#habilitarsumamonto").is(':checked')) {
		$("#habilitarsumamonto").val(1);

	}else{

		$("#habilitarsumamonto").val(0);

	}
}