// JavaScript Document


$(document).ready(function()
{
		//funcion para validar datos de usuario y permisos
		$('#usuario').keypress(function(e){
			if(e.which==13) $('#validar').click();
		});
	
		$('#password').keypress(function(e){
			if(e.which==13) $('#validar').click();
		});
		
		$("#validar").on("click",function(){
			var errores="";
			var timeSlide = 500;
			var espera = '<img src="images/loader.gif" width="16" height="16" alt="" /> <div style="float:left;">Validando...</div>';
			var boton = '<button class="btn btn-block login-btn mb-4" type="button">Iniciar sesi&oacute;n</button>';
			
			$('.alert').hide();
			
			var codservicio =$("#codservicio").val();
			var user=$("#usuario").val();
			user=user.replace(/^\s+|\s+$/g,"");
			var pass=$("#password").val();
			pass=pass.replace(/^\s+|\s+$/g,"");
			
			$("#validar").html('<div id="validando"></div>');
			$("#validando").hide(0).html(espera);
			$('#validando').slideDown(timeSlide);
			
			
			$('.modal-title').html("Los siguientes campos son requeridos: ");
			
			if(codservicio==""){ errores+='El codigo de servicio es Requerido <br>';}
			if(user==""){ errores+='Usuario es Requerido <br>';}
			if(pass==""){ errores+='Contraseña es Requerido <br>';}
						
			if(errores!="")
			{
				//alert(errores);
				$('.modal-body').html(errores);
				$('.modal').modal();
				$("#validar").html(boton);
			}
			else
			{			
				setTimeout(function(){
					$.ajax({
						  type: 'POST',
						  url: 'validar.php',
						  data: 'usuario='+user+'&contrasena='+pass+'&codservicio='+codservicio,
						  success:function(msj){
							  if ( msj == 1 ){
								  //alert(msj);
								  //$('#mensajes').html('<div class="alert_success"></div>');
								  $('.alert-success').hide(0).html('Datos Correctos');
								  $('.alert-success').slideDown(timeSlide);
								  $("#validando").html("Iniciando Sesion");
								  setTimeout(function(){
										window.location.href = ".";
									},(timeSlide + 500));
							  }
							  else if(msj==2)
							  {
								  //$('#mensajes').html('<div class="alert_warning"></div>');
								  $('.alert-danger').hide(0).html('Tu Usuario esta Desactivado');
								  $('.alert-danger').slideDown(timeSlide);
								  //OcultarDiv('mensajes');
								  Borrar();
								  $("#validar").html(boton);
							  }
							  else{
								  //$('#mensajes').html('<div class="alert_error"></div>');
								  $('.alert-danger').hide(0).html('Datos Incorrectos o vigencia vencida');
								  $('.alert-danger').slideDown(timeSlide);
								  //OcultarDiv('mensajes');
								  Borrar();
								  $("#validar").html(boton);
							  }
							  $('#mensajes').fadeOut(300);setTimeout($('#botones').css('display','block'),7000);
							  
						  },
						  error:function(XMLHttpRequest, textStatus, errorThrown){
							  console.log("El error es :" +arguments);
							  var error;
							  if (XMLHttpRequest.status === 404) error="Pagina no existe "+XMLHttpRequest.status;// display some page not found error 
							  if (XMLHttpRequest.status === 500) error="Error del Servidor "+XMLHttpRequest.status; // display some server error 
							  $('#mensajes').html('<div class="alert_error"></div>');
							  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución '+error);
							  $('.alert_error').slideDown(timeSlide);
							  OcultarDiv('mensajes');
							  $("#validar").html(boton);
						  }
					  });
					
					},timeSlide);
				
			}
			
		});
		
		
		
		//funciones para mostrar el formulario de reculerar clave
		$("#recuperar_pass").on("click",function(){
			$("#login").hide(0);
			$("#recupera").fadeIn(200);
		});
		//funciones para mostrar el formulario de reculerar clave
		$("#cancelar").on("click",function(){
			location.href='login.php';
		});
		
		//funcion para recuperar clave y contraseña del usuario
		$("#enviar").on("click",function(){
			var errores="";
			var timeSlide = 1000;
			var espera = '<img src="images/loading.gif" alt="" /> Validando...';
			var boton = '<input type="submit" value="Cancelar" id="cancelar" />&nbsp;<input type="submit"  class="alt_btn" value="Enviar" id="enviar" name="enviar"  />';
			var email=$("#email").val();
			email=email.replace(/^\s+|\s+$/g,"");
			var codigo=$("#codigo").val();
			codigo=codigo.replace(/^\s+|\s+$/g,"");
			
			$("#validarr").html('<div id="validando"></div>');
			$("#validando").hide(0).html(espera);
			$('#validando').slideDown(timeSlide);
			
			if(codigo==""){ errores+='Email es Requerido\n';}
			if(codigo==""){ errores+='Codigo es Requerido\n';}
			
			if(errores!="")
			{
				alert(errores);
				$("#validarr").html(boton);
			}
			else
			{			
				setTimeout(function(){
					$.ajax({
						  type: 'POST',
						  url: 'EmailRecupera.php',
						  data: 'email='+email+'&codigo='+codigo,
						  success:function(msj){
							  if ( msj == "1" ){
								  //alert(msj);
								  $('#mensajess').html('<div class="alert_success"></div>');
								  $('.alert_success').hide(0).html('Datos Correctos. El correo fue Enviado con Exito');
								  $('.alert_success').slideDown(timeSlide);
								  setTimeout(function(){
										window.location.href = ".";
									},(timeSlide + 500));
							  }
							  else if(msj=="cod")
							  {
								   $('#mensajess').html('<div class="alert_error"></div>');
								   $('.alert_error').hide(0).html('El C&oacute;digo es Incorrecto');
								   $('.alert_error').slideDown(timeSlide);
								   OcultarDiv('mensajess');
								   $("#validarr").html(boton);
							  }
							  else{
								  $('#mensajess').html('<div class="alert_error"></div>');
								  $('.alert_error').hide(0).html('El correo proporcionado no existe en nuestra base de datos');
								  $('.alert_error').slideDown(timeSlide);
								  OcultarDiv('mensajess');
								  Borrar();
								  $("#validarr").html(boton);
							  }							  
						  },
						  error:function(XMLHttpRequest, textStatus, errorThrown){
							  console.log(arguments);
							  var error;
							  if (XMLHttpRequest.status === 404) error="Pagina no existe "+XMLHttpRequest.status;// display some page not found error 
							  if (XMLHttpRequest.status === 500) error="Error del Servidor "+XMLHttpRequest.status; // display some server error 
							  $('#mensajess').html('<div class="alert_error"></div>');
							  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución '+error);
							  $('.alert_error').slideDown(timeSlide);
							  OcultarDiv('mensajess');
							  $("#validarr").html(boton);
							  
						  }
					  });
					
					},timeSlide);
				
			}
		});
});
		
function Borrar()
{
	$("input").val("");
	/*$("#email").val("");
	$("#codigo").val("");*/
}
