function MostrarAnuncios() {
	var valor=0;
	if($("#v_activaranuncios").is(':checked')){

	   valor=1;
	}
	
		var datos="valor="+valor;
		$.ajax({
				url:'catalogos/anuncios/ga_mostrarAnuncios.php', //Url a donde la enviaremos
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
						AbrirNotificacion("Se realizó el cambio correctamente","mdi-checkbox-marked-circle");
								
						}
			});	

}
function Guardaranuncios(form,regresar,donde,idmenumodulo)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var nombre =$("#v_titulo").val();
		var descripcion=$("#v_descripcion").val();
		var orden=$("#v_orden").val();
		var estatus=$("#v_estatus").val();

		var id=$("#id").val();
		var datos = new FormData();

		var archivos = document.getElementById("image"); //Damos el valor del input tipo file
		var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo

		//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
		//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
		//que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
		for (i = 0; i < archivo.length; i++) {
			datos.append('archivo' + i, archivo[i]);
		}
		datos.append('v_titulo',nombre); 
		datos.append('v_descripcion',descripcion);
		datos.append('v_orden',orden); 
		datos.append('id',id);
		datos.append('v_estatus',estatus);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/anuncios/ga_anuncios.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					contentType: false, //Debe estar en false para que pase el objeto sin procesar
					data: datos, //Le pasamos el objeto que creamos con los archivos
					processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
					cache: false, //Para que˘
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
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito",donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });				  					  
		},1000);
	 }
}

function ColocarCheckbox(valor) {
	
	if (valor==1) {
	$("#v_activaranuncios").prop('checked',true);
	}else{
		$("#v_activaranuncios").prop('checked',false);

	}
}

function ColocarCheckboxOmitirAlfinal(valor) {
	if (valor==1) {
	$("#v_activaromitirfinal").prop('checked',true);
	}else{
		$("#v_activaromitirfinal").prop('checked',false);

	}
}

function MostrarOmitir() {
		var valor=0;
	if($("#v_activaromitirfinal").is(':checked')){

	   valor=1;  
	}
	
		var datos="valor="+valor;
		$.ajax({
				url:'catalogos/anuncios/ga_mostrarOmitirFinal.php', //Url a donde la enviaremos
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
						AbrirNotificacion("Se realizó el cambio correctamente","mdi-checkbox-marked-circle");
								
						}
			});	
}

function Activaranuncios() {
	var valor=1;
	if($("#v_activaranunciocliente").is(':checked')){

	   valor=0;
	}
	
		var datos="valor="+valor;
		$.ajax({
				url:'catalogos/anuncios/ga_activaranuncios.php', //Url a donde la enviaremos
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
						AbrirNotificacion("Se realizó el cambio correctamente","mdi-checkbox-marked-circle");
								
						}
			});	
}