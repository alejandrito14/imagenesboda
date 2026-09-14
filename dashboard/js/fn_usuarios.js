// JavaScript Document



/*function validarUsuario()

{

	//alert("entro en la funcion");

	var timeSlide = 1000;

	var usuario=$('#usuario').val();

	usuario=usuario.replace(/^\s+|\s+$/g,"");

	//alert(usuario);

	if(usuario=="")

	{

		$('#mensajes').html('<div class="alert_error"></div>');

		$('.alert_error').hide(0).html('El campo Usuario no puede estar vacio');

		$('.alert_error').slideDown(timeSlide);

	}

	else

	{

		$.ajax({

			  type: 'POST',

			  url: 'empresas/va_usuario.php',

			  data: 'usuario='+usuario,

			  success:function(msj){

				  if ( msj == "1" ){

					  //alert(msj);

					  $('#mensajes').html('<div class="alert_success"></div>');

					  $('.alert_success').hide(0).html('Usuario Valido');

					  $('.alert_success').slideDown(timeSlide);

					  $('#user_valid').val("1");

					  //OcultarDiv('mensajes');

				  }

				  else{

					  $('#mensajes').html('<div class="alert_error"></div>');

					  $('.alert_error').hide(0).html('El usuario ya existe');

					  $('.alert_error').slideDown(timeSlide);

					  $('#user_valid').val("no");

					  //OcultarDiv('mensajes');

				  }				  

			  },

			  error:function(XMLHttpRequest, textStatus, errorThrown){

				  console.log(arguments);

				  var error;

				  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 

				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 

				  $('#mensajes').html('<div class="alert_error"></div>');

				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución'+error);

				  $('.alert_error').slideDown(timeSlide);

				  //OcultarDiv('mensajes');							  

			  }

		  });

	}

}

function usuarioValido()

{

	var user =$('#user_valid').val();

	if(user==1)

	{

		return true;

	}

	else

	{

		alert("Debe colocar un usuario v\u00e1lido");

		return false;

	}

}*/





function validarUsuario ()

{

	var usuario = $('#usuario').val();

	

	console.log("entro a validarUsuario con el usuario = "+usuario);

	

	

	$.ajax({

			  type: 'POST',

			  url: 'administrador/validar_usuario.php',

			  data: 'usuario='+usuario,

			  cache:false,

			  success:function(msj){

				  console.log("este es el msj de validarUsuario = "+msj);

				  

				  if(msj == 1)

				  {

					  

					  $('#msj_error').css('color','red');

					  $('#msj_error').html('Error este usuario ya existe');

					  document.getElementById('alt_btn').disabled = true ;

					  

				  }

				  else

				  {

					  $('#msj_error').css('color','green');

					  $('#msj_error').html('Usuario valido');

					  document.getElementById('alt_btn').disabled = false ;

				  }

				  

				  

			  },

			  error:function(XMLHttpRequest, textStatus, errorThrown){

				  console.log(arguments);

				  var error;

				  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 

				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 

				  $('#mensajes').html('<div class="alert_error"></div>');

				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución'+error);

				  $('.alert_error').slideDown(timeSlide);

				  //OcultarDiv('mensajes');							  

			  }

		  });

	

	

}

function AsignarEmpresas(idusuario) {

	var datos="idusuario="+idusuario;
	

				  $.ajax({
					url:'administrador/asignaraccesoempresa.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#empresasasignadas").html(error); 
					  },
					success:function(msj){
							$("#usuarioid").val(idusuario);

					      $("#empresasasignadas").html(msj); 	  
					  	}
				  });				  					  
		

	
	$("#modalempresas").modal('show');
}


function GuardarEmpresasAcceso() {

	var empresa=[];
	var usuarioid=$("#usuarioid").val();

	$( ".accesoempresa" ).each(function( index ) {
		if ($(this).is(':checked')) {
			empresa.push($(this).val());
		}

	});

	var datos="idusuario="+usuarioid+"&sucursales="+empresa;

	 $.ajax({
					url:'administrador/guadarasignacion.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#empresasasignadas").html(error); 
					  },
					success:function(msj){
							$("#modalempresas").modal('hide');
							 document.querySelector('body').classList.remove('modal-open');
							  $('.modal-backdrop').remove();
								aparecermodulos('administrador/vi_usuarios.php?ac=1&msj=Operacion realizada con exito','main');

					  	}
				  });	


}


function SeleccionarTodosAsignados() {
	if ($("#id_0").is(':checked')) {
		$(".accesoempresa").prop('checked',true);
	}else{

		$(".accesoempresa").prop('checked',false);

	}
}


