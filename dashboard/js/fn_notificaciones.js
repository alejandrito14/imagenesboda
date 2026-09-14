function dirigira() {

var valor=$("#dirigido").val();


	if (valor==0) {
		$(".clienteslistado").css('display','none');
		$(".usuarioslista").css('display','none');

	}
	if (valor==1) {

		$(".clienteslistado").css('display','flex');
		$(".usuarioslista").css('display','none');


	}
	if (valor==2) {
		$(".clienteslistado").css('display','none');
		$(".usuarioslista").css('display','flex');

	}

	if (valor==3) {
		$(".clienteslistado").css('display','flex');
		$(".usuarioslista").css('display','flex');


	}

	if (valor==4) {
		$(".clienteslistado").css('display','none');
		$(".usuarioslista").css('display','none');
	}
}

function programar() {

var programdo=$("#programado").val();		
$("#mostrarfecha").css('display','none');

	if (programdo==2) {
		$("#mostrarfecha").css('display','block');

		CargarClientes()
		CargarUsuarios();
	}

	if (programdo==1) {


		CargarClientesToken();
		CargarUsuariosToken();
	}
			// body...
}

function CargarClientesToken() {

			$.ajax({
					url:'catalogos/notificaciones/ObtenerClientesToken.php', //Url a donde la enviaremos
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
							
							var clientes=msj.clientes;

						
							PintarClientes(clientes);	
						}
					});
	
}


function CargarClientes() {

			$.ajax({
					url:'catalogos/notificaciones/ObtenerClientes.php', //Url a donde la enviaremos
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
							
							var clientes=msj.clientes;

						
							PintarClientes(clientes);	
						}
					});
	
}

function PintarClientes(clientes) {
	var html="";

	if (clientes.length>0) {

		for (var i = 0; i < clientes.length; i++) {
			html+=`
				<div class="form-check cli_"  id="cli_`+clientes[i].idcliente+`_`+clientes[i].idcliente+`">`;
						    	
                             var nombre=clientes[i].nombre+" "+clientes[i].paterno+" "+clientes[i].materno;
						    		
					html+=`	  <input  type="checkbox" onchange="ClienteSeleccionado()"  value="`+clientes[i].idcliente+`" class="form-check-input chkcliente" id="inputcli_`+clientes[i].idcliente+`" >
						<label class="form-check-label" for="flexCheckDefault">`+nombre+`</label>
					</div>	

			`;
		}
	}

	$(".clientes").html(html);

}


function CargarUsuariosToken() {
	
		$.ajax({
					url:'catalogos/notificaciones/ObtenerUsuariosToken.php', //Url a donde la enviaremos
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
							
							var usuarios=msj.usuarios;

						
							PintarUsuarios(usuarios);	
						}
					});
}


function CargarUsuarios() {
	
		$.ajax({
					url:'catalogos/notificaciones/ObtenerUsuarios.php', //Url a donde la enviaremos
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
							
							var usuarios=msj.usuarios;

						
							PintarUsuarios(usuarios);	
						}
					});
}

function PintarUsuarios(usuarios) {
	var html="";
	if (usuarios.length>0) {
		for (var i = 0; i <usuarios.length; i++) {
			
			html+=`
			<div class="form-check usu_"  id="usu_`+usuarios[i].idusuarios+`_`+usuarios[i].idusuarios+`">`;
							    	   	
	            var nombre=usuarios[i].nombre+" "+usuarios[i].paterno+" "+usuarios[i].materno;
							    		
				 html+=` <input  type="checkbox"  onchange="UsuarioSeleccionado()" value="`+usuarios[i].idusuarios+`" class="form-check-input chkusuario" id="inputusuario_`+usuarios[i].idusuarios+`">
						 <label class="form-check-label" for="flexCheckDefault">`+nombre+`</label>
					</div>


			`;
		}
	}

	$(".usuarios").html(html);
}

function Guardarnotificacion(form,regresar,donde,idmenumodulo)
{

	var v_tclientes=$("#v_tclientes").val();
	var v_tusuarios=$("#v_tusuarios").val();
	var dirigido=$("#dirigido").val();

	var programado=$("#programado").val();
	var mensaje=$("#mensaje").val();
	var fecha=$("#fechaprogramada").val();
	var horaprogramada=$("#horaprogramada").val();
	var bandera=1;

	if (mensaje=='') {
		bandera=0;

	}
	if (programado==0) {

		bandera=0;
	}

	if (programado==2) {

		if (existeFecha(fecha)!=true) {

			bandera=0;

		}

		if (horaprogramada=='') {
			bandera=0;
		}


	}


	if (dirigido==0) {
		bandera=0;
	}
if ( dirigido==1 || dirigido==3) {
	if (v_tclientes==2) {

		bandera=0;
	}

	if (v_tclientes==1) {
		bandera=0
		$(".chkcliente").each(function(index) {
			if($(this).is(':checked')){
				bandera=1;
			}

		});

	}

}

if ( dirigido==2 || dirigido==3) {

	if (v_tusuarios==2) {

		bandera=0;
	}

	if (v_tusuarios==1) {
		bandera=0
		$(".chkusuario").each(function(index) {
				if($(this).is(':checked')){
				 		bandera=1;
				 	}
				});

	}
}



	if (bandera==1) {
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);

		var clientes=[];
		var usuarios=[];
				$(".chkcliente").each(function(index) {
				 	if($(this).is(':checked')){
				 		var val=$(this).val();
				 		clientes.push(val);
				 	}
				});

				$(".chkusuario").each(function(index) {

				 	if($(this).is(':checked')){
				 		var val=$(this).val();
				 		usuarios.push(val);
				 	}
				});

		datos1="clientes="+clientes+"&usuarios="+usuarios+"&todosadmin="+v_tusuarios+"&"+datos;
	
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/notificaciones/ga_notificaciones.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos1, //Le pasamos el objeto que creamos con los archivos
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


	}else{

		var respuesta="";

		if (mensaje=='') {
				bandera=0;
			    respuesta+="-Mensaje es requerido"+"<br>";

			}

		if (programado==0) {

				bandera=0;
			    respuesta+="-Programación es requerido"+"<br>";

			}


	if (programado==2) {

		if (existeFecha(fecha)!=true) {

			    respuesta+="-Fecha es requerida"+"<br>";

		}

		if (horaprogramada=='') {
			
				respuesta+="-Hora es requerida"+"<br>";

		}


	}

		if (dirigido==0) {
			respuesta+="-Dirigido a es requerido"+"<br>";

			}

		
	if ( dirigido==1 || dirigido==3) {

			if (v_tclientes==2) {

					bandera=0;
					noencontro=0;
				}


				if (v_tclientes==1) {
					bandera=0
					noencontro=0;
					$(".chkcliente").each(function(index) {
						if($(this).is(':checked')){
							bandera=1;
						noencontro=1;
						}

					});

				}

				if (noencontro==0) {

					respuesta+="-Clientes es requerido"+"<br>";
				}

			}

	if ( dirigido==2 || dirigido==3) {

		if (v_tusuarios==2) {

				bandera=0;
				nousuario=0;

			}

			if (v_tusuarios==1) {
					bandera=0
					nousuario=0;
					$(".chkusuario").each(function(index) {
						if($(this).is(':checked')){
							 	bandera=1;
							 	nousuario=1;
							 }
					});

				}

			if (nousuario==0) {

					respuesta+="-Clientes es requerido"+"<br>";
				}

		}

		AbrirNotificacion('Han ocurrido los siguientes errores:<br>'+respuesta,"mdi-checkbox-marked-circle");


	}
}

function HabilitarDeshabilitarCheck2(divid) {	
	if($(divid).css('display') == 'none'){
		$(divid).css('display','block');
		$("#v_tclientes").val(1);
	}else{
		$(divid).css('display','none');
		$("#v_tclientes").val(0);
		$(".chkcliente").prop('checked',false);
	}
}

function HabilitarDeshabilitarCheck3(divid) {
	if($(divid).css('display') == 'none'){
		$(divid).css('display','block');
		$("#v_tusuarios").val(1);
	}else{
		$(divid).css('display','none');
		$("#v_tusuarios").val(0);
		$(".chkusuario").prop('checked',false);

	}


	

}

function ClienteSeleccionado() {
	
	bandera=2;
	$(".chkcliente").each(function(index) {
				 	if($(this).is(':checked')){
				 		bandera=1;
				 	}
				});
	$("#v_tclientes").val(bandera);
}


function UsuarioSeleccionado() {
	
	bandera=2;
	$(".chkusuario").each(function(index) {
				 	if($(this).is(':checked')){
				 		bandera=1;
				 	}
				});
	$("#v_tusuarios").val(bandera);
}

function existeFecha(fecha){

      var fechaf = fecha.split("-");

     if (fechaf[0]!='' && fechaf[1]!='' && fechaf[2]!='') {

      var day = fechaf[2];
      var month = fechaf[1];
      var year = fechaf[0];
      var date = new Date(year,month,'0');


      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;

  }else{

  	return false;
  }


}


function ObtenerClientesNotificacion(idnotificacion) {
	 	var datos='idnotificacion='+idnotificacion;

 	$.ajax({
				url:'catalogos/notificaciones/ObtenerClientesNotifcacion.php', //Url a donde la enviaremos
				type:'POST', //Metodo que usaremos
				dataType:'json',
				data:datos,
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
						
							var clientes=msj.clientes;

						
							PintarClientesNotificacion(clientes);	
						}
			});
 } 

 function ObtenerUsuariosNotificacion(idnotificacion) {

 			var datos='idnotificacion='+idnotificacion;
 				$.ajax({
					url:'catalogos/notificaciones/ObtenerUsuariosNotifcacion.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json',
					data:datos,
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
							
							var usuarios=msj.usuarios;

						
							PintarUsuariosNotificacion(usuarios);	
						}
					});
 }

 function PintarClientesNotificacion(clientes) {
 	
 	if (clientes.length>0) {
 		for (var i =0; i <clientes.length; i++) {

 
 			$("#inputcli_"+clientes[i].idcliente).prop('checked',true);
 			
 		}
 	}
 }
 function PintarUsuariosNotificacion(usuarios) {

 	if (usuarios.length>0) {
 		for (var i = 0; i<usuarios.length; i++) {
 			
 		 	$("#inputusuario_"+usuarios[i].idusuario).prop('checked',true);

 		}
 	}
 }
