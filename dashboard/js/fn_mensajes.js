// JavaScript Document

function Buscar_mensajes()
{
	var idempleado = document.getElementById("idempleado").value;
	var idempleadoenvia = document.getElementById("idempleadoenvia").value;
	var fecha =document.getElementById("fecha").value; 

	var datos = "idempleado="+idempleado+"&idempleadoenvia="+idempleadoenvia+"&fecha="+fecha;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	
	$("#contenedor_mensajes").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		setTimeout(function(){
				  $.ajax({
					url:'servicios/mensajes/li_mensajes.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#contenedor_mensajes").html(error); 
					  },
					success:function(msj){
					      $("#contenedor_mensajes").html(msj); 	  
					  	}
				  });				  					  
		},1000);	
}



function GuardarMensaje(form,regresar,donde)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		var datos = ObtenerDatosFormulario(form);
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'servicios/mensajes/ga_mensajes.php', //Url a donde la enviaremos
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
						   console.log("El resultado de msj es: "+msj);
						   if ( msj == 1 ){
								aparecermodulos(regresar+"?ac=1&msj=Operacion realizada con exito",donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });				  					  
		},1000);
	 }
}