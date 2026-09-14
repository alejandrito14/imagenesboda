function habilitarstripe() {

	if($("#constripe").is(':checked')){

		$("#constripe").val(1);
		$(".publica").css('display','block');
		$(".privada").css('display','block');

	}else{
		$("#constripe").val(0);

		$(".publica").css('display','none');
		$(".privada").css('display','none');

	}
}

function Habilitarfoto() {
	if($("#confoto").is(':checked')){
		$("#confoto").val(1);
			$(".cuenta").css('display','block');

	}else{
		$("#confoto").val(0);
		$(".cuenta").css('display','none');

	}
}


function Guardartipopago(form,regresar,donde,idmenumodulo)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);


		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
			
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/tipodepagos/ga_tipodepagos.php', //Url a donde la enviaremos
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

function habilitarmonto() {
	if($("#habilitarcampomonto").is(':checked')){

		$("#habilitarcampomonto").val(1);

	}else{

		$("#habilitarcampomonto").val(0);
	}
}

function habilitarmontofactura() {

	if($("#habilitarcampomontofactura").is(':checked')){

		$("#habilitarcampomontofactura").val(1);

	}else{

		$("#habilitarcampomontofactura").val(0);
	}
}


function habilitarmercadopago(argument) {
	if($("#conmercadopago").is(':checked')){
		$("#constripe").attr('checked',false);
		$("#conmercadopago").val(1);
		$(".publicamercado").css('display','block');
		$(".privadamercado").css('display','block');

	}else{
		$("#conmercadopago").val(0);
		$("#constripe").attr('checked',false);

		$(".publicamercado").css('display','none');
		$(".privadamercado").css('display','none');

	}
}