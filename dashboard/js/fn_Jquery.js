//  GuardarEspecial// JavaScript Document
/************-----------------------*******************-----------*************************/
$(document).ready(function() {
	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
/************-----------------------*******************-----------*************************/
	//On Click Event
	$("ul.tabs li").click(function() {
	
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		
		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	
	var bandera = 0;
	
	$("#icono_menu").click(
	function efecto()
	{
	    $("#sidebar").toggle("slow");
		
		
		if(bandera == 0)
		  {
			  $("#main").css("margin-left","0px");
			   $("#main").css("width","100%");
			   $("#header").css("width","100%");
			   
			  bandera = 1;
		  }else
		  {
			  $("#main").css("margin-left","200px");
			  $("#main").css("width","80%");
			   $("#header").css("width","100%");
			  
			  bandera = 0;
		  }
	});
	

		$(".clasemenu").click(function(){
		var id=$(this).attr('id');
		

		var cortar=id.split('_')[1];
	
/*		console.log($('.'+id+':last').attr('id'));
*/
		var elementos=$('.'+id).length;

		var dividir=parseInt(elementos/2);

				

		var elementoid=0;
		var contador=0;

		if (dividir>=2) {
		$("."+id).each(function( index ) {

		 	if (contador==dividir) {
		 		console.log('asas'+$(this).attr('id'));

		 		elementoid=$(this).attr('id');
		 		return 0;
		 	}
		 	contador++;

			});
		}else{

			elementoid=$('.'+id+':first').attr('id');
		 		console.log('asas'+elementoid);

		}


		

		var ultimo=elementoid;

		 $('html, body').animate({
			 scrollTop: $("#"+ultimo).offset().top-20

			 }, 2000);
		  return false;
		
	});

		$(".submenu").click(function(){
  		  $("html,body").animate({ scrollTop: 0 }, 600);
        return false;
		});
});
/************-----------------------*******************-----------*************************/
$(function(){
        $('.column').equalHeight();
	});
/************-----------------------*******************-----------*************************/
function MostrarAlert(quees)
{
	alert(quees);
}
function new_captcha()
{
	var c_currentTime = new Date();
	var c_miliseconds = c_currentTime.getTime();	
	document.getElementById('captcha').src = 'image.php?x='+ c_miliseconds;
}

//funcion para ocultar los div mostrados despues de cierto tiempo
function OcultarDiv(nombre)
{
	setTimeout(function(){
	$('#'+nombre).slideUp(1000);},6000);	
	}


function f_toogle(id)
{
	 $('#'+id).toggle();
}


//funcion para aparecer los div mostrados despues de cierto tiempo
function AparecerDiv(nombre)
{
	
	$('#'+nombre).css("display","block");	
}


//funcion para ocultar blokes
function overlayclose(subobj)
{
	$("#"+subobj).css('display','none');
}
//funcion para mostrar blokes
function overlayopen(subobj)
{
	$("#"+subobj).css('display','block');
	$("#"+subobj).css('with','200');
}
//funcion para validar caracteres raros
function validateChart(campo) 
{
    var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9])$/;
    var errorMessage = 'Password Incorrecta.';
    if ((campo.match(RegExPattern)) ) 
	{
        return true;
    } 
	else 
	{
		return false;
    } 
}

//funcion para recargar la imagen que aca de ser cargara
function recargarimagen(imagen,id,tipo,nombre)
{
	//alert(imagen);
	//$("#"+imagen).html('<div><img src="images/loader.gif" alt="" /><br />Cargando...</div>');		
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'comunicados/refrescarImagen.php',					  
					  data:'id='+id+"&tipo="+tipo+"&nombre="+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  //alert(msj);					  
						
						$('#'+imagen).attr('src','images/img/mensaje_promocion/'+msj);
						
						 // overlayclose('c_loading');
						 // $("#"+donde).html(msj);
						  //alert(msj);						  
					  }
				  });				  					  
		},800);	
}


//funcion para redimencionar blokes
function Redimencionar(width,height,top,margin,objeto)
{
	var cssSize={"height":height,"width":width};
	var cssMargin={"margin-top":top};
	
	$("#"+objeto).css(cssSize);
	
	if(margin==1) { $("#"+objeto).css(cssMargin);}
}
//barra de navegacion



function BarraNavegacion(nombre,pagina)
{
	var contenido = $('#navegacion');
	$('#navegacion').html('<a href="'+pagina+'">'+nombre+'</a><div class="breadcrumb_divider"></div>');
}
//funcion para obtener la fecha
function Fecha_Actual()
{
	var fech
	var anio
	var mes
	var dia
	
	fech = new Date();
	anio = fech.getFullYear();
	mes = fech.getMonth()+1;
	dia = fech.getDate();
	
	return anio+"-"+mes+"-"+dia;
}



//validacion de formulario
function MM_validateForm() 
{ //v4.0
  if (document.getElementById)
  {
    	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    	for (i=0; i<(args.length-2); i+=3)
		{ 
			test=args[i+2]; 
			val=document.getElementById(args[i]);
      		if (val) 
			{ 
				nm=val.title; 
				if ((val=val.value)!="") 
				{
        			if (test.indexOf('isEmail')!=-1) 
					{ 
						p=val.indexOf('@');
						if (p<1 || p==(val.length-1)) errors+='- '+nm+' Debe de contener una direccion valida de Email.<br>';
						
        			} 
					else if (test!='R') 
					{ 
						num = parseFloat(val);
						if (isNaN(val)) errors+='- '+nm+' Debe de contener un numero.<br>';
						if (test.indexOf('inRange') != -1) 
						{ 
							p=test.indexOf(':');
							min=test.substring(8,p); max=test.substring(p+1);
							if (num<min || max<num) errors+='- '+nm+' Debe de contener un numero entre '+min+' y '+max+'.<br>';
						} 
					}

					else if(val.value==0){
						 errors += '- '+nm+' Es requerido.<br>'; 
					}
				} else if (test.charAt(0) == 'R') errors += '- '+nm+' Es requerido.<br>';


			}
    	} 
		if (errors) 
		{
			//alert('Han ocurrido los siguientes errores:<br>'+errors);
			AbrirNotificacion('Han ocurrido los siguientes errores:<br>'+errors,"mdi-checkbox-marked-circle");
			return 0;
		}
		else
		{
			//alert("entro en 1");
		  return 1;
		}
  }
}





//funcion para validar que una ciudad este seleccionada
function validarCiudad()
{
	if($('#s_ciudad').val()==0)
	{
		alert("Por favor selecciones una ciudad valida ");
		return false;
	}
	else
	{
		return true;
	}
}



//funcion para mostrar modulos deseados
function aparecermodulos(pagina,donde)
{
	console.log(pagina);
	$("#"+donde).html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');		
	setTimeout(function(){
				  $.ajax({
					  type: 'GET',
					  url: pagina,					  
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						 // overlayclose('c_loading');
						  
						  
						  	//realizar una validacion para cuando se rompe la sesion.
						  
						  if(msj == "login")
							  {
								  //loenviamos a login.
								  
								window.location.href = ".";
							  }else
								  {
									   $("#"+donde).html(msj);
						               //alert(msj);		
								  }
						  
						  
						  
						 				  
					  }
				  });				  					  
		},10);		
}

//funcion para mostrar modulos deseados
function aparecermodulos2(pagina,donde,ruta)
{
	console.log(pagina);
	$("#"+donde).html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');		
	setTimeout(function(){
				  $.ajax({
					  type: 'GET',
					  url: pagina,					  
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						 // overlayclose('c_loading');
						  
						  
						  	//realizar una validacion para cuando se rompe la sesion.
						  
						  if(msj == "login")
							  {
								  //loenviamos a login.
								  
								window.location.href = ".";
							  }else
								  {
									   $("#"+donde).html(msj);
						               //alert(msj);	
						               //
						              localStorage.setItem('menu', ruta);

						              $("#menuubicacion").html(ruta);	
								  }
						  
						  
						  
						 				  
					  }
				  });				  					  
		},10);		
}


function MenuNombre(idmenumodulo) {
	alert(idmenumodulo);
}

//funcion para recoger los nombre del campo y valores
function ObtenerDatosCampoValor(id)
{
	var campos = "";//varibles que contentra el nombre de los campos de la base de datos de la siguiente forma  nombre:tipo
	var valores = "";//variables que contendra los valores de cada campo que ya se guardaron el la varibles anterior
    var  form = document.getElementById(id);
    var length = form.elements.length;
	var  cadena = "";//varibles que juntara todos los datos y los enviad al archivo para ser guardados
	var cantidad_campos =length-1;
	
    for( var i = 0; i < length; i++ )
    {
        element = form.elements[i];
		 
        if(element.tagName.toLowerCase() == 'textarea' )
        {
			campos +=element.name+",";
			valores +=element.value+",";
        }
		else if(element.tagName.toLowerCase() =='select')
		{
			campos +=element.name+",";
			valores +=element.value+",";
		}
        else if( element.tagName.toLowerCase() == 'input' )
        {
                if( element.type == 'text' || element.type == 'hidden' || element.type == 'password' || element.type == 'date' || element.type == 'time')
                {
					campos +=element.name+",";
					valores +=element.value+",";
                }
                else if( element.type == 'radio' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                              campos +=element.name+",";
							  valores +=element.value+",";
 
                }
                else if( element.type == 'checkbox' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                                campos +=element.name+",";
								valores +=element.value+",";
                }
        }
    }
	campos = campos.substring(0,campos.length-1);
	valores = valores.substring(0,valores.length-1);
	cadena = "campos_base="+campos+"&valores_campos="+valores+"&cantidad_campos="+cantidad_campos;
    return cadena;
}



//funcion para recoger los datos del formulario de la empresa
function ObtenerDatosFormulario(id)
{
	
	var  form = document.getElementById(id);
    var length = form.elements.length;
	var  cadena = "";
	
    for( var i = 0; i < length; i++ )
    {
        element = form.elements[i];
		 
        if(element.tagName.toLowerCase() == 'textarea' )
        {
            cadena +=element.name+"="+element.value+"&";
        }
		else if(element.tagName.toLowerCase() =='select')
		{
			cadena +=element.name+"="+element.value+"&";
		}
        else if( element.tagName.toLowerCase() == 'input' )
        {
                if( element.type == 'text' || element.type == 'hidden' || element.type == 'password' || element.type == 'date' || element.type == 'time' || element.type == 'number' || element.type == 'email')
                {
					cadena +=element.name+"="+element.value+"&";
                }
                else if( element.type == 'radio' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                               cadena +=element.name+"="+element.value+"&";
 
                }
                else if( element.type == 'checkbox')
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                                cadena +=element.name+"="+element.value+"&";
                }
        }
    }
	cadena = cadena.substring(0,cadena.length-1);
    return cadena;
}


//funcion de guardado general para catalogos
function GuardarGeneral(formulario,formulario_extra,archivo_vizualizar,donde_mostrar)
{
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosCampoValor(formulario);//Obteniedo los datos de los campos y valores del formularioque van a ser base de datos
		var datos_extra =ObtenerDatosFormulario(formulario_extra);//obtener datos de campos con valores
		//alert(datos+datos_extra);
		var ArchivoGurardar="guardar_modificar.php";
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: ArchivoGurardar,
					  data: datos+"&"+datos_extra,
					  success:function(msj){
						  if ( msj == 1 ){
							  
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  }
				  });				  					  
		},500);
	}
}
//funcion de guardado especial

function GuardarEspecialClientes(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						   var array = msj.split("|"); 
						  $('.modal').modal('hide');
						  if ( array[0] == '1' ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Operacion realizada con exito&id="+array[1],donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial

function GuardarEspecial(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


function GuardarEspecial2(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  //$('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  $('#modal-forms').modal('hide');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


function GuardarEspecial3(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  $('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  aparecermodulos(archivo_vizualizar+"&ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


function GuardarEspecialMGuia(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  $('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  //alert(archivo_vizualizar+"?sql="+sql_regresar+"&ac=1&msj=Operacion realizada con exito");
							  //aparecermodulos(archivo_vizualizar+"?sql="+sql_regresar+"&ac=1&msj=Operacion realizada con exito",donde_mostrar);
							  b_guias('li_guias');
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


function GuardarEspecialPagoGuia(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"&ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


//funcion para identificar un enter
function identificarEnter(nombre)
{
	//alert("entro a la funcion ---"+nombre);
	$('#'+nombre).keypress(function(e){
			if(e.which==13){ return true;}
			else{ return false;}
		});
}




//funcion para borrar datos de la base de datos
function BorrarDatosVariables(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar,variables)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrar.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?"+variables+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?"+variables+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}// fin de function GuardarEspecial



//funcion para borrar datos de la base de datos
function BorrarDatos(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar,idmodulo)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrar.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmodulo+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmodulo+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}// fin de function GuardarEspecial

//funcion para borrar datos de la base de datos
function BorrarDatosImg(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar,idmodulo,campoimg,carpeta)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo+"&campoimg="+campoimg+"&carpeta="+carpeta;
	
	console.log(cadena);
	
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrarImg.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmodulo+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmodulo+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}// fin de function GuardarEspecial

//funcion para borrar datos de la base de datos
function BorrarDatosGet(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#'+donde_mostrar).html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrar.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}// fin de function GuardarEspecial



//funcion para borrar datos de la base de datos
function BorrarDatos2(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrar.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Registro borrado con exito",donde_mostrar);
							  //$('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  $('#modal-forms').modal('hide');
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial


function BorrarDatosPagoGuia(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrar.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}// fin de function GuardarEspecial

//cargar ciudad //  recibe el ide del estado, el select a cargar se debe de llamar ciudad.
function cargarciudad(idestado)
{
	var idestado = idestado;
	var lista = $('#s_ciudad');
	lista.empty();
	//alert("El estado seleccionado su id es:"+idestado );
	
	$.ajax({
		  type: "POST",
	      url: "xml/xml_ciudades.php",	 
		  dataType: "xml",    
		  data: 'idestado='+idestado,
	      success: function(msj)	 
					 {				
					// alert(msj);
				     $(msj).find('ciudad').each(function()
				     {
					    var nombre = $(this).find('nombre').text();
						var idciudad = $(this).find('idciudad').text();				    
					    lista.append("<option value='"+idciudad +"'>"+nombre+"</option>");
				      }); 							 
				 
										  
		  },
		  error:function(){
			  $('#mensajes').html('<div class="alert-error"></div>');
			  $('.alert-error').hide(0).html('Ha ocurrido un error durante la ejecución');
			  $('.alert-error').slideDown(timeSlide);
			  OcultarDiv('mensajes');
			  $("#validar").html(boton);							  
		  }
	  });
	
	
}// fin de cargarciudad

function BorrarDatosSucursal(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar,variables)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrasucursal.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?"+variables+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?"+variables+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},100);
	}
}



function cargarestados()
{
	
	var idpais = $('#idpais').val();
	console.log(idpais);
	var lista = $('#s_estado');
	lista.empty();
	//alert("El estado seleccionado su id es:"+idestado );
	
	$.ajax({
		  type: "POST",
	      url: "xml/xml_estado.php",	 
		  dataType: "xml",    
		  data: 'idpais='+idpais,
	      success: function(msj)	 
					 {				
					// alert(msj);
				     $(msj).find('estado').each(function()
				     {
					    var nombre = $(this).find('nombre').text();
						var idestado = $(this).find('idestado').text();				    
					    lista.append("<option value='"+idestado +"'>"+nombre+"</option>");
				      }); 							 
				 
										  
		  },
		  error:function(){
			  $('#mensajes').html('<div class="alert-error"></div>');
			  $('.alert-error').hide(0).html('Ha ocurrido un error durante la ejecución');
			  $('.alert-error').slideDown(timeSlide);
			  OcultarDiv('mensajes');
			  $("#validar").html(boton);							  
		  }
	  });
	
	
}// fin de cargarestado



//cargar ciudad //  recibe el ide del estado, el select a cargar se debe de llamar ciudad.
function cargarcuentas(idempresa)
{
	var idempresa = idempresa;	
	var lista = $('#s_cuentas');
	lista.empty();	
	$.ajax({
		  type: "POST",
	      url: "xml/xml_cta_cheque.php",	 
		  dataType: "xml",    
		  data: 'idempresa='+idempresa,
	      success: function(msj)	 
					 {				
					   $(msj).find('chequera').each(function()
				          {
					        var nombre = $(this).find('nombre').text();
						    var cuenta = $(this).find('cuenta').text();				    
					        lista.append("<option value='"+cuenta +"'>"+nombre+"</option>");
				       }); 							 
				 
										  
		  },
		  error:function(){
			  $('#mensajes').html('<div class="alert-error"></div>');
			  $('.alert-error').hide(0).html('Ha ocurrido un error durante la ejecución');
			  $('.alert-error').slideDown(timeSlide);
			  OcultarDiv('mensajes');
			  $("#validar").html(boton);							  
		  }
	  });
	
	
}// fin de cargarciudad



function mostrarImagen(donde,tipo,id)
{
		
		var x = "donde="+donde+"&tipo="+tipo+"&id_producto="+id;
		var height = 0;
		var width = 0;
		if(tipo==1)
		{
			height = '280px';
			width = '280px';
		}
		else
		{
			height = '312px';
			width = '389px';
		}

		$("#"+donde).html('<div align="center" style="height:'+height+'; border-radius:5px; margin-left:10px; width:'+width+'; background: #E0E0E3 url(../images/sidebar.png) repeat"><img style="padding-top:35px; border-radius:5px" src="images/loader.gif" alt="" /><br />Cargando...</div>');		
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/vi_mostrarImagen.php',
					  data: x,					  
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						 // overlayclose('c_loading');
						  $("#"+donde).html(msj);
						  //alert(msj);						  
					  }
				  });				  					  
		},800);	
		
}// fin de mostrarImagen

//se crea funcion para borrar imagen
function borrarImagen(nombre)
{
	var nombre = nombre;
	
	if (nombre != "")
	{
		$.ajax({
			type:'POST',
			data:'nombre='+nombre,
			url:'productos/borrarImagen.php',
			success: function (msj){
				console.log (msj);
				}
			})
		}
	}

//fin funcion borrar imagen

function comprueba_extension(formulario, archivo, nombrearchivo)
{
	
	if(nombrearchivo == false)
	{
		if(confirm('\u00BFDeseas sustituir la imagen actual por la nueva?'))
	    {
			var extensiones_permitidas = new Array(".jpg","png");
			var mierror = null;
			var extension = null;
			var permitida = null;
					
			if (!archivo) 
			{
				//Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
				mierror = "No has seleccionado ning\u00FAn archivo";
			}// fin de if
			else
			{
				//recupero la extensión de este nombre de archivo
				extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
				//alert (extension);
				//compruebo si la extensión está entre las permitidas
				permitida = false;
				for (var i = 0; i < extensiones_permitidas.length; i++) 
				{
					if (extensiones_permitidas[i] == extension) 
					{
						//alert('extension');
						permitida = true;
						break;
					}// fin de if
				}// fin de for
				if (!permitida) 
				{
					mierror = "Comprueba la extensi\u00f3n de los archivos a subir. \nS\u00f3lo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
				}// fin de if
				else
				{
					//submito!
					 //alert ("Todo correcto. Voy a submitir el formulario.");
					 formulario.submit();
					return 1;
				}// fin de else
			}// fin de else
			//si estoy aqui es que no se ha podido submitir
			alert (mierror);
			return 0;
		}// fin de ifconfirm
	}// if nombre archivo false
	else
	{
		alert("Compruebe que el examinador de archivos no este desahabilitado");
		return 0;
	}
	
}// fin de la clase comprueba_extension


function validarFecha(dia,mes,anio)
{
	var data = new Date(mes+'/'+dia+'/'+anio);
	//alert(data);
	
	var dia2=data.getDate();
	var mes2=data.getMonth()+1;
	var anio2=data.getFullYear();
	
	if (parseInt(dia) != parseInt(dia2)) return false;
	if (parseInt(mes) != parseInt(mes2)) return false;
	if (parseInt(anio) != parseInt(anio2)) return false;
	
	return true;
}// fin de validarFecha

function mostrarDiv(divA,cadenaDiv)
{
	
	$('#'+divA).show(1500);
	
	var arrayDivs = cadenaDiv.split(";");
	
	var longitud = arrayDivs.length;

	var x = 0;
	
	for(x=0;x<=longitud; x++)
	{
		$('#'+arrayDivs[x]).hide("slow");
	}
	
}// fin de mostrarDiv

function calcularDiasMes(anio,mes,diamostrar)
{	
	var anio2 = $('#'+anio).val();
	var mes2 = $('#'+mes).val();
	var dia = 0;
	var listaDia = $('#'+diamostrar);
	listaDia.empty();
	
	var arrayDia = new Array('31','28','31','30','31','30','31','31','30','31','30','31');
	
	if(mes2==2)
	{
		if((anio2%4==0 && anio2%100!=0) || (anio2%400==0))
		{
			dia = 29;
		}
		else
		{
			dia = arrayDia[mes2-1];
		}
	}
	else
	{
		dia = arrayDia[mes2-1];
	}
	//alert(dia);
	for(var x=1;x<=dia;x++)
	{		
		listaDia.append("<option value='"+x +"'>"+x+"</option>");
	}
}//calcularDiasMes

//funcion para borrar datos de la base de datos
function borrarDatos2pk(id,campo,tipo,id2,campo2,tipo2,tabla,archivo_vizualizar,donde_mostrar)
{
	var cadena="id="+id+"&campo="+campo+"&tipo="+tipo+"&id2="+id2+"&campo2="+campo2+"&tipo2="+tipo2+"&tabla="+tabla;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'borrar2pk.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Registro borrado con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_error"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial

function compararFechasMayores(anio,mes,dia,anio2,mes2,dia2)
{
	
	var anioo = $('#'+anio).val();
	var mess = $('#'+mes).val();
	var diaa = $('#'+dia).val();
	
	var anioo2 = $('#'+anio2).val();
	var mess2 = $('#'+mes2).val();
	var diaa2 = $('#'+dia2).val();
	
	if(mess<10)
	{
		mess = '0'+mess;		
	}
	
	if(diaa<10)
	{
		diaa = '0'+diaa;
	}
	
	if(diaa2<10)
	{
		diaa2 = '0'+diaa2;
	}
	
	if(mess2<10)
	{
		mess2 = '0'+mess2;
	}
	
	var fecha_inicio = new Date(anioo+'-'+mess+'-'+diaa);
	var fecha_fin = new Date(anioo2+'-'+mess2+'-'+diaa2);
	
	if(fecha_inicio>=fecha_fin)
	{
		alert('La Fecha Inicio de la Promoci\u00F3n no Puede ser Mayor o Igual a la Fecha Fin');
		return false
	}
	
	else
	{
		return true;
	}
}// fin de comprarFechasMayores

function ValidarFechaActual(anio,mes,dia)
{
	
	var anioo = anio;// $('#'+anio).val();
	var mess = mes;//$('#'+mes).val();
	var diaa = dia;//$('#'+dia).val();
	// alert("año"+anio+"mes"+mess+"dia"+diaa);
	var fech	
	fech = new Date();
	var anioo2 = fech.getFullYear();
	var mess2 = fech.getMonth()+1;
	var diaa2 = fech.getDate();
	
	if(mess<10)
	{
		mess = '0'+mess;		
	}
	
	if(diaa<10)
	{
		diaa = '0'+diaa;
	}
	
	if(diaa2<10)
	{
		diaa2 = '0'+diaa2;
	}
	
	if(mess2<10)
	{
		mess2 = '0'+mess2;
	}
	
	var fecha_inicio = new Date(anioo+'-'+mess+'-'+diaa);
	var fecha_fin = new Date(anioo2+'-'+mess2+'-'+diaa2);
	//alert(fecha_inicio);
	if(fecha_inicio<fecha_fin)
	{
		//alert('La Fecha de Envio no puede ser menor a la fecha actual');
		return false
	}
	
	else
	{
		return true;
	}
}// fin de comprarFechasMayores

function verificarBoton(check,boton)
{
	if($('#'+check).is(':checked'))
	{
		$('#'+boton).removeAttr('disabled');
	}
	else
	{
		$('#'+boton).attr('disabled','disabled');
	}
}

function oNumero(numero)

      {

//Propiedades 

this.valor = numero || 0

this.dec = -1;

//Métodos 

this.formato = numFormat;

this.ponValor = ponValor;

//Definición de los métodos


function ponValor(cad)

{

if (cad =='-' || cad=='+') return

if (cad.length ==0) return

if (cad.indexOf('.') >=0)

    this.valor = parseFloat(cad);

else 

    this.valor = parseInt(cad);

} 

function numFormat(dec, miles)

{

var num = this.valor, signo=3, expr;

var cad = ""+this.valor;

var ceros = "", pos, pdec, i;

for (i=0; i < dec; i++)

ceros += '0';

pos = cad.indexOf('.')

if (pos < 0)

    cad = cad+"."+ceros;

else

    {

    pdec = cad.length - pos -1;

    if (pdec <= dec)

        {

        for (i=0; i< (dec-pdec); i++)

            cad += '0';

        }

    else

        {

        num = num*Math.pow(10, dec);

        num = Math.round(num);

        num = num/Math.pow(10, dec);

        cad = new String(num);

        }

    }

pos = cad.indexOf('.')

if (pos < 0) pos = cad.lentgh

if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') 

       signo = 4;

if (miles && pos > signo)

    do{

        expr = /([+-]?\d)(\d{3}[\.\,]\d*)/

        cad.match(expr)

        cad=cad.replace(expr, RegExp.$1+','+RegExp.$2)

        }

while (cad.indexOf(',') > signo)

    if (dec<0) cad = cad.replace(/\./,'')

        return cad;

}

}//Fin del objeto oNumero:

//funcion aparecer modal, nececita un fondo y una ventana, y se ejecuta asi ('display','modal1','ventana1')
   function modal(estado,fondo,ventana)
{
	
  document.getElementById(fondo).style.display=estado;
  document.getElementById(ventana).style.display=estado;
  
	  
}
//termina funcion aparecer modal
//funcion validar producto
function validarProducto(id_producto,btn) {
	var valor = id_producto;
	var idempresa = $("#v_empresa").val();
    console.log("El valor de la empresa es: "+idempresa);
	
	
	//alert ("el vaor es "+id_producto);
	if (valor != "") {
		$.ajax({
			type: 'POST',
			url: 'catalogos/productos/validar_producto.php',
			data: 'idproducto=' + valor+"&idempresa="+idempresa,
			success: function (msj) { //recibira el valor verdadero o falso
				//alert (msj);
				if (msj == '0') // 0 es el valor que retorna el archivo cuando no hay valor en la consulta con el id del producto
				{
					// alert ('entro en 1')
					//$('#categoria').focus();
					// alert ('cool puedes guardar');
					$('#error').css('color', '#0C0');//cambio el color de texto a verde 
					$('#error').css('margin-left', '3%');	//le pongo un margen izquierdo para que el error aparesca alado del input	
					$('#error').html('El Id es Valido'); //iprimo que el id es valido
					$('.habilitarboton').attr('disabled', false);//abilito el boton guardar 
				}
				else if (msj > 0) // uno retorna el archivo cuando si hay una consulta y el id existe
				{
					//alert ("El Id del Producto ya Existe Porfavor Ponga Otro");
					// $('#idproducto').focus();
					$('#error').css('color', '#F00');//cambio el color de texto rojo
					//$('#error').css('margin-left','3%');
					$('#error').html('Este Codigo de Producto Ya Existe '); //imprimo que el id ya existe 
					$('.habilitarboton').attr("disabled", true);//des abilito el boton guardar


				}
			}


		});
	}
}

function validarCliente(no_cliente) {
	var valor = no_cliente

	//alert ("el vaor es "+id_producto);
	if (valor != "") {
		$.ajax({
			type: 'POST',
			url: 'catalogos/clientes/validar_cliente.php',
			data: 'nocliente=' + valor,
			success: function (msj) { //recibira el valor verdadero o falso
				//alert (msj);
				if (msj == 0) // 0 es el valor que retorna el archivo cuando no hay valor en la consulta con el id del producto
				{
					// alert ('entro en 1')
					//$('#categoria').focus();
					// alert ('cool puedes guardar');
					$('#error').css('color', '#0C0');//cambio el color de texto a verde 
					$('#error').css('margin-left', '3%');	//le pongo un margen izquierdo para que el error aparesca alado del input	
					$('#error').html('El Id es Valido'); //iprimo que el id es valido
					$('.alt_btn').attr('disabled', false);//abilito el boton guardar 
				}
				else if (msj > 0) // uno retorna el archivo cuando si hay una consulta y el id existe
				{
					//alert ("El Id del Producto ya Existe Porfavor Ponga Otro");
					// $('#idproducto').focus();
					$('#error').css('color', '#F00');//cambio el color de texto rojo
					//$('#error').css('margin-left','3%');
					$('#error').html('Este Codigo de Cliente Ya Existe '); //imprimo que el id ya existe 
					$('.alt_btn').attr("disabled", true);//des abilito el boton guardar


				}
				else if (msj =="noval") // uno retorna el archivo cuando si hay una consulta y el id existe
				{
					//alert ("El Id del Producto ya Existe Porfavor Ponga Otro");
					// $('#idproducto').focus();
					$('#error').css('color', '#F00');//cambio el color de texto rojo
					//$('#error').css('margin-left','3%');
					$('#error').html('Este Codigo No Valido, Ingresa un Numero '); //imprimo que el id ya existe 
					$('.alt_btn').attr("disabled", true);//des abilito el boton guardar


				}
			}


		});
	}
}


//funcion validar producto
function validarProductoNoexiste (id_producto)
{
	var valor = id_producto;
 
	//alert ("el vaor es "+id_producto);
	if (valor != "" )
	{
	$.ajax({
		type:'POST',
		url:'productos/validar_producto.php',
		data:'idproducto='+valor,
		success:function (msj){ //recibira el valor verdadero o falso
		//alert (msj);
		 if (msj == 0 ) // 0 es el valor que retorna el archivo cuando no hay valor en la consulta con el id del producto
		 {
			 // alert ('entro en 1')
			 //$('#categoria').focus();
			// alert ('cool puedes guardar');
			$('#error').css('color','red');//cambio el color de texto a rojo 
			//$('#error').css('margin-left','3%');	//le pongo un margen izquierdo para que el error aparesca alado del input	
			$('#error').html('ESTE PRODUCTO NO EXISTE'); //iprimo que el id es valido
			 $('.alt_btn').attr('disabled',true);//abilito el boton guardar 
			 }
		 else if (msj > 0) // uno retorna el archivo cuando si hay una consulta y el id existe
		 {
			//alert ("El Id del Producto ya Existe Porfavor Ponga Otro");
			// $('#idproducto').focus();
			 $('#error').css('color','#F00');//cambio el color de texto rojo
			 //$('#error').css('margin-left','3%');
			 $('#error').html(' '); //imprimo que el id ya existe 
			 $('.alt_btn').attr("disabled", false);//des abilito el boton guardar
			 
			 
			 } 	 
			}
		
		
		}); 
	 }
	}
//termina validar producto
























//funcion bloquear "+"
function bloquearMas(a)
{
	a= event.keyCode
	//alert(a);
	 
	if (event.keyCode == 43 || event.keyCode == 38) //pregunto si es "+" o si es "&"
	{
 	event.returnValue = false;;
	}
}

//termina funcion bloquear "+"




function uploadAjax()
{

var inputFileImage = document.getElementById("archivoImage");

var file = inputFileImage.files[0];

var data = new FormData();

data.append("archivo",file);

var url = "clases/upload.php";

$.ajax({

url:url,

type:"POST",

contentType:false,

data:data,

processData:false,

cache:false});

}


//empieza metodo tipo compra


function tipo_compra (s)
{
	
	console.log ('el value del select es : '+s);
	if (s == 0)
	{
		$('#result_select').html('<h4>Id Compra:</h4> <span id="msj_erro"></span> <input type="text" onblur="vallida_compra ()" name="tipo_entrada_comra" id="tipo_entrada_compra" title="Id de la compra " style="width:150px;" placeholder="1" />');
		$('#tipo_entrada_compra').focus();
	}
	else if (s == 1)
	{
		
		eliminarTodoCarrito('itemsEnCestaEntrada','descripcion_carrito');
		
		
		$('#result_select').html('<h4>Id Nota de Remision:</h4> <span id="msj_erro"></span> <input type="text" onblur="vallida_nota ()" name="tipo_entrada_dev" id="tipo_entrada_dev" title="Id de la devolucion " style="width:150px;" placeholder="1" />');
		$('#tipo_entrada_dev').focus();
	}
	
	else if (s == 2)
	{
		$('#result_select').html('<input type="hidden" id="otros" name="otros" value="2" />');
		document.getElementById('btn_agregar').disabled = false ;
		
	}
}




//termina metodo tipo compra


//funcion para verificar si la compra exite 

function vallida_compra ()
{
	var id = document.getElementById('tipo_entrada_compra').value;
	console.log('el id es ='+id);
	if (id != "")
	{
	 $.ajax({
					  type: 'POST',
					  url: 'productos/validar_compra.php',
					  data: 'id='+id,
					  success:function(msj){
						  if ( msj == 1 ){
							  //si existe el id de compra
							  //console.log ('entro en 0 el id ya existe, es correcto el msj es ='+msj);
							  
							  $('#msj_erro').css('color','green');
							  $('#msj_erro').html('Bien el id de compra es correcto');
							  document.getElementById('btn_agregar').disabled = false ;
						  }
						  else{
							  //no existe el id de compra
							 // console.log('entro en 1 el msj es ='+msj);
							  
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Error el id de compra es incorrecto');
							  
							  document.getElementById('btn_agregar').disabled = true ;
							  
							  
						  }							  
					  },
					  error:function(){
						  console.log ('entro en error function');
						  /*$('#'+donde_mostrar).html('<div class="alert_error"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);*/
						  
					  }
				  });	
	}//fin del if
}




//termina funcion para verificar si la compra existe






//empieza metodo tipo compra


function tipo_salida (s)
{
	
	console.log ('el value del select es : '+s);
	if (s == 0)
	{
		$('#result_select').html('<h4>Id Nota de Remision:</h4><span id="msj_erro"></span><input type="text" onblur="vallida_salida ()" name="id_nota_remision" id="id_nota_remision" title="Id de la Nota de Remision " style="width:150px;" placeholder="1" />');
		$('#id_nota_remision').focus();
		
	}
	else
	{
		
		
		
		
		$('#result_select').html('<input name="id_nota_remision" type="hidden" id="id_nota_remision" value="0">');
		
	
		
	}
}




//termina metodo tipo salida













//funcion para verificar si la salida exite 

function vallida_salida ()
{
	var id = document.getElementById('id_nota_remision').value;
	console.log('el id es ='+id);
	if (id != "")
	{
	 $.ajax({
					  type: 'POST',
					  url: 'productos/validar_salida.php',
					  data: 'id='+id,
					  cache:false,
					  success:function(msj){
						  //alert ("el msj = "+msj);
						  if ( msj == 1 ){
							  //si existe el id de compra
							  //console.log ('entro en 0 el id ya existe, es correcto el msj es ='+msj);
							  //alert ("ENTRO EN 1 ");
							  
							  $('#msj_erro').css('color','green');
							  $('#msj_erro').html('Bien el id de nota de remision es correcto');
							  document.getElementById('alt_btn').disabled = false ;
						  }
						  else{
							  //no existe el id de compra
							 // console.log('entro en 1 el msj es ='+msj);
							// alert ("ENTRO EN 0");
							  
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Error el id de nota de remision es incorrecto');
							  
							  document.getElementById('alt_btn').disabled = true ;
							  
							  
						  }							  
					  },
					  error:function(){
						  console.log ('entro en error function');
						  /*$('#'+donde_mostrar).html('<div class="alert_error"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);*/
						  
					  }
				  });	
	}//fin del if
}



//termina funcion para verificar si la salida existe




















//inicia funcion para verificar si la nota de remicion existe



function vallida_nota ()
{
	var id = document.getElementById('tipo_entrada_dev').value;
	console.log('el id es ='+id);
	if (id != "")
	{
	 $.ajax({
					  type: 'POST',
					  url: 'productos/validar_nota.php',
					  data: 'id='+id,
					  success:function(msj){
						  if ( msj == 1 ){
							  //si existe el id de compra
							  //console.log ('entro en 0 el id ya existe, es correcto el msj es ='+msj);
							  
							  $('#msj_erro').css('color','green');
							  $('#msj_erro').html('Bien la nota de remision es correcta');
							  document.getElementById('btn_agregar').disabled = false ;
						  }
						  else{
							  //no existe el id de compra
							 // console.log('entro en 1 el msj es ='+msj);
							  
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Error la nota de remision es incorrecto');
							  
							  document.getElementById('btn_agregar').disabled = true ;
							  
							  
						  }							  
					  },
					  error:function(){
						  console.log ('entro en error function');
						  /*$('#'+donde_mostrar).html('<div class="alert_error"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);*/
						  
					  }
				  });	
	}//fin del if
}





//termina funcion para verificar si la nota de remision existe




//funciones para una modal




function vi_productos (pagina,donde)
		{
			//alert ("entro");
			console.log ("vi_productos : pagina:"+pagina+" donde: "+donde);
			//$('#fondo').slideDown("fast");
			aparecermodulos(pagina,donde);
			//$('#modal').slideDown("slow");
			$('#Modal-productos').modal();	
				
		}
		
		

function cerrarModal (){
			$('#fondo').slideUp("fast");
			$('#modal').slideUp(2000,function ()
			{
				$('#modal').html('');
			});
			}
			$('#fondo').css('display','none');
			$('#modal').css('display','none');
			
		/*$('#x').bind('click' , function ()
		{
			$('#fondo').slideUp("fast");
			$('#modal').slideUp(2000,function ()
			{
				$('#modal').html('');
			});
		});*/
		
function abrirModal (queabrir)
{
			$('#fondo').slideDown("fast");
			//aparecermodulos(queabrir,'modal');
			$('#modal').slideDown("slow");
			$('#fondo').css('display','block');
			$('#modal').css('display','block');
}		
		
		
		$(document).keydown(function (e){
				
					e = e.which // con el which puedo obtener el numero del esc			//e= event.keyCode
					//alert(e);
					 
					 if (e == 27)
					 {
						 $('#fondo').css('display','none');
			            $('#modal').css('display','none');
						$('#fondo').slideUp("fast");
						
						$('#modal').slideUp(2000,function ()
						{
							
							
						});
					 }
					
			
			})

function cerrarModal (){
			$('#fondo').slideUp("fast");
			$('#modal').slideUp(2000,function ()
			{
				//$('#modal').html('');
			});
			}

//terminan funciones para una modal

//funcion abrir iframe para etiquetas


function etiquetaI (id)
{
	$('#etiquetas').attr('src','productos/etiquetas.php?id='+id);
}

//termina funcion abrir iframe para etiqetas




///modalesss

	
function AbrirModalGeneral (modal,ancho,alto)
{
            console.log("Entro "+modal);	
			
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
	        
			console.log("m_ancho"+m_ancho);	
	
			//$('#'.modal).slideDown("fast");
			
			$('#'+modal).css('width',ancho+"px");
			$('#'+modal).css('height',alto+"px");
			$('#'+modal).css('margin-top','-'+m_alto+"px");
			$('#'+modal).css('margin-left','-'+m_ancho+"px");
			
			//modifico el tamaño del contenido de la modal
			
			var m_alto_contenido = parseInt(alto) - 20;
			
			$('#contenido_modal').css('height',m_alto_contenido+"px");
			$('#contenido_modal').css('overflow',"auto");
			
			
			$('#'+modal).css('display','block');
			
			
			console.log("Salio");
}	


function AbrirModalGeneral2(modal,ancho,alto,archivo,titulo)
{
            console.log("Entro "+modal);	
	
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
	
	        
			//console.log("m_ancho"+m_ancho);
			//$('#'.modal).slideDown("fast");
			//$('#'+modal).css('width',ancho+"px");
			//$('#'+modal).css('height',alto+"px");
			//$('#'+modal).css('margin-top','-'+m_alto+"px");
			//$('#'+modal).css('margin-left','-'+m_ancho+"px");
			//modifico el tamaño del contenido de la modal
			//var m_alto_contenido = parseInt(alto) - 20;
			//$('#contenido_modal').css('height',m_alto_contenido+"px");
			//$('#contenido_modal').css('overflow',"auto");
			//$('#contenido_modal').css('text-align','left');		
			//$('#'+modal).css('display','block');			
			//console.log("Salio");
	        $('#titulo-modal-forms').html(titulo);
			aparecermodulos(archivo,'contenedor-modal-forms');
	
	        $('#modal-content').css('width',ancho+"px");
			$('#modal-content').css('height',alto+"px");
			$('#modal-content').css('margin-top','-'+m_alto+"px");
			$('#modal-content').css('margin-left','-'+m_ancho+"px");

	
			$('#modal-forms').modal();
	
}


function AbrirModalGeneral3(modal,ancho,alto,archivo,titulo,max)
{
            console.log("Entro "+modal);	
	
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
	
	      
	        $('#titulo-modal-forms').html(titulo);
			aparecermodulos(archivo,'contenedor-modal-forms');
	
	        $('#modal-content').css('width',ancho+"px");
			$('#modal-content').css('height',alto+"px");
			$('#modal-content').css('margin-top','-'+m_alto+"px");
			$('#modal-content').css('margin-left','-'+m_ancho+"px");
			$('#largomodal').css('max-width',max+"px");
	
			$('#modal-forms').modal();
	
}

function AbrirModalFull(modal,ancho,alto,archivo,titulo)
{
            console.log("Entro "+modal);	
	
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
	
	        
	        $('#titulo-modal-forms-full').html(titulo);
			aparecermodulos(archivo,'contenedor-modal-forms-full');
	
			$('#myModalFullscreen').modal();
	
}


function AbrirModalGuias(modal,ancho,alto,archivo)
{
            console.log("Entro "+modal);	
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
			var sql_regresar = $('#sql_regresar').val();
				
				        
			console.log("m_ancho"+m_ancho);	
	
			
			//alert(archivo+'&sql='+sql_regresar);
					
			aparecermodulos(archivo+'&sql='+sql_regresar,'contenido_modal');
			//$('#'.modal).slideDown("fast");
			
			$('#'+modal).css('width',ancho+"px");
			$('#'+modal).css('height',alto+"px");
			$('#'+modal).css('margin-top','-'+m_alto+"px");
			$('#'+modal).css('margin-left','-'+m_ancho+"px");
			
			//modifico el tamaño del contenido de la modal
			
			var m_alto_contenido = parseInt(alto) - 20;
			
			$('#contenido_modal').css('height',m_alto_contenido+"px");
			$('#contenido_modal').css('overflow',"auto");
			$('#contenido_modal').css('text-align','left');
			
			
			$('#'+modal).css('display','block');
			
			
			console.log("Salio");
}	

function CerrarModalGeneral(modal)
{
            console.log("Entro "+modal);	
			
	  
			$('#'+modal).css('display','none');
			
			console.log("Salio");
}

function AbrirModalSecundaria(modal,ancho,alto)
{
            console.log("Entro "+modal);	
			
	        var m_ancho = parseInt(ancho) / 2;
			var m_alto = parseInt(alto) / 2;
	        
			console.log("m_ancho"+m_ancho);	
	
			//$('#'.modal).slideDown("fast");
			
			$('#'+modal).css('width',ancho+"px");
			$('#'+modal).css('height',alto+"px");
			$('#'+modal).css('margin-top','-'+m_alto+"px");
			$('#'+modal).css('margin-left','-'+m_ancho+"px");
			
			//modifico el tamaño del contenido de la modal
			
			var m_alto_contenido = parseInt(alto) - 20;
			
			$('#contenido_modal_dos').css('height',m_alto_contenido+"px");
			$('#contenido_modal_dos').css('overflow',"auto");
			
			
			$('#'+modal).css('display','block');
			
			
			console.log("Salio");
}



function AbrirModalImagen(ruta,nombre)
{
            
	$('#imagen-colocar-producto').attr("src",ruta);
	$('#Nombre_imagen').html(nombre);
	$('#Modal-fotos').modal();
}	

function AbrirModalImagenTwo(modal,ancho,alto,id)
{
	console.log("Entro "+modal);	
			
	var m_ancho = parseInt(ancho) / 2;
	var m_alto = parseInt(alto) / 2;

	console.log("m_ancho"+m_ancho);	

	//$('#'.modal).slideDown("fast");

	$('#'+modal).css('width',ancho+"px");
	$('#'+modal).css('height',alto+"px");
	$('#'+modal).css('margin-top','-'+m_alto+"px");
	//$('#'+modal).css('margin-left','-'+m_ancho+"px");

	//modifico el tamaño del contenido de la modal

	var m_alto_contenido = parseInt(alto) - 20;

	$('#contenido_modal_img'+id).css('height',m_alto_contenido+"px");
	$('#contenido_modal_img'+id).css('overflow',"auto");


	$('#'+modal).css('display','block');


	console.log("Salio");
}


//funcion para bloquear caracteres especiales 

function bloquear_enie (e)
{
	var e = event.keyCode;
	//alert (e);
	//console.log(e);
	// 42 es * 
	//ESTE IF NOS SIRVE PARA BLOQUEAR EL CTRL + J
	if (/*event.which == 17 */ event.ctrlKey==true && (event.which == '106' || event.which == '74')  )
	{
		//console.log("entro a control");
		event.preventDefault();
		event.returnValue = false;
	}
	//TERMINA EL IF PARA BLOQUEAR EL CTRL +J
	
	if (e == 241 || e == 39 || e == 63 || e == 43 || e == 35 || e == 161 || e == 191 || e == 38 || e == 42 || e == 36 || e == 34 || e == 33 || e == 60 || e == 62 || e == 40 || e == 41 || e == 180 || e == 125 || e == 91 || e == 93 || e == 123 || e == 36 || e == 124 || e == 61 || e == 37 || e == 59  )
	{
		event.returnValue = false;
	}
	
}



//termina funcion para bloquear caracteres especiales


function AgregarCestaEntradaEnter (e)
{
	var e = event.keyCode;
	//console.log(e);
	//console.log('hola accionEnter');
	
	if (e == 13)
	{
		AgregarCestaEntrada();
	}
	
}




///










//metodo para bloquear boton

function bloquear_boton (id)
{
	document.getElementById(id).disabled = true; 	
}


//fin de metodo para bloquear boton


function desbloquear_boton (id)
{
	document.getElementById(id).disabled = false; 	
}


//fin de metodo para bloquear boton
//ver creditos pendientes tbl

function vi_creditos()
{
	$.ajax({
					  type: 'GET',
					  url: 'ventas/vi_pedidosCredito.php',					  
					  
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  //console.log("el msj de generarCreditodeCaja = "+msj);
						$('#tbl_creditos').html(msj);
					  
					  					  
					  }
				  });
}

//fin e ver creditos pendientes tbl

//metodo para busqueda de pago en credito

function buscarCredito ()
{
	var id = $('#id_nota_remision').val();
	console.log("entro al metodo buscarCredito el dinota_remision es = "+id);
	$('#result_historial').html('Buscando historial');
	
	console.log("empezamos primer ajax")
	$.ajax({
					  type: 'POST',
					  url: 'ventas/vi_deudaCredito.php',					  
					  data:"idnota_remision="+id,
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						  	
						  console.log("el msj = "+msj);
						  var cadena = msj.split('|');
						  
						  $('#totalPagos').html(cadena[0]);
						  $('#adeudo').html(cadena[1]);
						  $('#idn').html(cadena[2]);
						  $('#nom_cliente').html(cadena[4]);
						  $('#idcredito').html(cadena[6]);
						  $('#deudatotal').html(cadena[9]);
						  
						  //alert (cadena[8]);
						  
						  if (cadena[5] != ""){
						  	$('#email').html(cadena[5]);
						  }
						  else if (cadena[5]=="")
						  {
							  $('#email').html('No dio email');
						  }
						  //alert (cadena[3]);
						  if (cadena[3]==0)
						  {
							 // alert("cadena[3] entro en 0");
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('<div class="alert_error">Esta nota de remision no tiene credito</div>');
							  
							  $('#totalPagos').html('');
						 $('#adeudo').html('');
						  $('#idn').html('');
						  $('#nom_cliente').html('');
						  //$('#idcredito').html('');
						  $('#email').html('');
							  bloquear_boton('pagar');
							  
						  }
						  else if (cadena[3]==1)
						  {
								$('#msj_erro').html('');
								desbloquear_boton('pagar');
							  
						  }
						  
						  
						  if (cadena[8] == 1 && cadena[3] == 1 && cadena[1] == 0)
						  {
							  //alert ("entro a cadena[8] == 1 && cadena[3] == 1 && cadena[1] == 0 ")
							 $('#msj_erro').css('color','#CC0');
							  $('#msj_erro').html('<div class="alert_warning">Este cliente ya no tiene adeudo</div>'); 
							  bloquear_boton('pagar');
						  }
						  
						  
						  
						   /*if (cadena[7]==1 && cadena[8] == 0 )
						  {
							 // alert ("entro al if abajo de cadena[8] == 1 && cadena[3] == 1 && cadena[1] == 0")
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Este cliente ya hizo un pago el dia de hoy');
							  
							  bloquear_boton('pagar');
							  
							  /*$('#totalPagos').html('');
							  $('#adeudo').html('');
							  $('#idn').html('');
							  $('#nom_cliente').html('');
							  //$('#idcredito').html('');
							  $('#email').html('');
						  }*/
						else if (cadena[7]==0 && cadena[3]==1 && cadena[1] >0 && cadena[8] == 1 && cadena[3] == 1)
						  {
							  //alert ("entro al else if");
							  	$('#msj_erro').html('');
								desbloquear_boton('pagar');
							  
						  }
						  
						  	  
					  }
				  });
					
					
					//le mando a al archivo vi_hisotial el idnota de remision
					
					console.log ("empezamos con otro ajax")
					$.ajax({
					  type: 'POST',
					  url: 'ventas/vi_historial.php',					  
					  data:"idnota_remision="+id,
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msjtbl){
						  
						 // console.log('ya tengo la tabla es = '+msjtbl+" ");
						  
						  $('#result_historial').html(msjtbl);
						  
						  
						  
						  }
						  
						  
						  });
					
					
					
					//fin de mando al archivo vi_historial el idnnota de remision
	
}




//fin metodo para busqueda de pago en credito




function datosClienteCaja ()
{
	console.log("entro a datosClienteCaja");
	var id = $('#id_nota_remision').val();
	console.log('el de la orden de compra es ='+id);
	
	if (id != "")
	{
	 $.ajax({
					  type: 'POST',
					  url: 'ventas/vi_clienteCaja.php',
					  data: 'id='+id,
					  cache:false,
					  success:function(msj){
						  //alert ("el msj = "+msj);
						  console.log("el msj de datosClienteCaja es=  "+msj);
						  var cadena = msj.split("|");
						  
						  $('#nombre').html(cadena[0]);
						  $('#cantidadp').html(cadena[1]);
						  $('#totalg').val(cadena[2]);
						  
							 						  
					  },
					  error:function(){
						  console.log ('entro en error function');
						 
						  
					  }
				  });
	}//fin del if
	
}














//terminan funciones para CAJA




//funciones para ENTREGAA

function buscarEntrega()
{
	console.log("Entro a buscarEntrega");
	
	var id = document.getElementById('id_nota_remision').value;
	console.log("el idnota de remision es = "+id);
	
	
	$.ajax({
					  type: 'POST',
					  url: 'ventas/vi_datosEntrega.php',					  
					  data:"idnota_remision="+id,
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						  //alert("buscarEntrega = "+msj)
						  console.log("el msj es = "+msj);
						  
						  var cadena = msj.split('|');
						  
						  $('#nombre').html(cadena[0]);
						  $('#candidadP').html(cadena[1]);
						  $('#idPedido').html(id);
						  
						  
						  
					  }//fin success
	});//fin del ajax
	
	
	
	
	console.log ("el otro ajax");
	verTablaProductoEntrega()
	
	
	
	
	
	
}

function verTablaProductoEntrega()
{
	var id = document.getElementById('id_nota_remision').value;
	console.log("entro a vertablaproductoentrega con el idnotaremision = "+id);
	
	
	$.ajax({
					  type: 'POST',
					  url: 'ventas/vi_productos_entrega.php',					  
					  data:"idnota_remision="+id,
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						  
						 // console.log("el msj del otro ajax es = "+msj);
						  
						  $('#tabla_result').html("");
						  $('#tabla_result').html(msj);
						  
						  
					  }//fin success
	});//fin del ajax
}


function reporteEntrega ()
{
	var id = document.getElementById('id_nota_remision').value ;
	
	$('#reporteEntrega').slideDown();
	
	$('#reporteEntrega').html('<div id="impresionEntrega"><center><iframe src="ventas/pdf/recibo_entrega.php?idnota_remision='+id+'" width="500" height="700"></iframe></center></div>');
	//$('#impresionEntrega').attr('src','ventas/pdf/recibo_entrega.php?idnota_remision='+id);
	
	
}


function vallida_idnota_remision_Entrega ()
{
	var id = document.getElementById('id_nota_remision').value;
	console.log('entro a validaridnotaremisionentrega el id es ='+id);
	if (id != "")
	{
	 $.ajax({
					  type: 'POST',
					  url: 'ventas/validar_nota_remision.php',
					  data: 'id='+id,
					  cache:false,
					  success:function(msj){
						  //alert ("el msj = "+msj);
						  console.log("el msj de validar nota de remision entrega es "+msj);
						  var cadena = msj.split("|");
						  if ( cadena[0] == 1 && cadena[1] == 0  ){
							  //si existe el id de compra
							  //console.log ('entro en 0 el id ya existe, es correcto el msj es ='+msj);
							  //alert ("ENTRO EN 1 ");
							  
							  $('#msj_erro').css('color','green');
							  $('#msj_erro').html('Bien el id de nota de remision es correcto');
							  document.getElementById('alt_btn').disabled = false ;
							  document.getElementById('ent_btn').disabled = false ;
						  }
						  else if (cadena[0] == 0){
							  //no existe el id de compra
							 // console.log('entro en 1 el msj es ='+msj);
							// alert ("ENTRO EN 0");
							  
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Error el id de nota de remision es incorrecto O no esta pagada');
							  
							  document.getElementById('alt_btn').disabled = true ;
							  
							  document.getElementById('ent_btn').disabled = true ;							  
							  
						  }		
						  else if (cadena[1] == 1 )
						  {
							  $('#msj_erro').css('color','red');
							  $('#msj_erro').html('Error el id de nota de remision ya esta entregada');
							  
							  document.getElementById('alt_btn').disabled = true ;
							  
							  document.getElementById('ent_btn').disabled = true ;
						  }					  
					  },
					  error:function(){
						  console.log ('entro en error function');
						  /*$('#'+donde_mostrar).html('<div class="alert_error"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);*/
						  
					  }
				  });	
	}//fin del if
}




// terminan funciones para ENTREGA

// function para validar usuario de clientes

function validarUsuarioCliente ()
{
	var usuario = $('#v_usuario').val();
	
	console.log("entro a validarUsuarioCliente con el usuario = "+usuario);
	
	
	$.ajax({
			  type: 'POST',
			  url: 'catalogos/validar_usuarioCliente.php',
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


// termina funcion para validar usuario clientes



//termina funcion para hacer el reporte de pedido


//*************metodo para el filtro de inventario***************************************

function buscarPedido(formulario)
{
	//alert ("entro a buscarPedido");
	console.log("entro a buscarPedido");
	var cadena = ObtenerDatosFormulario(formulario);
	
	
	$.ajax({
			  type: 'POST',
			  url: 'ventas/bu_pedidos.php',
			  data: cadena,
			  cache:false,
			  success:function(msj){
				  $('#li_pedidos').html(msj);
				  
				  
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $("#li_pedidos").html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución'+error);
				  $('.alert_error').slideDown(timeSlide);
				  //OcultarDiv('mensajes');							  
			  }
		  });
}

//*************fin del metodo para filto de inventario***********************************



//************impresion de pedido pagado*************************************************

function impresionPedidoPagado (id)
{
	console.log("entro a impresionPedidoPagado con el id = "+id);
	$('#impresion').fadeIn();
	
	$('#recibo').slideDown();
	
	$('#recibo').html('<div id="impresionEntrega"><center><iframe src="ventas/pdf/pedidoPagado.php?id='+id+'" width="500" height="700"></iframe></center></div>');
	//$('#impresionEntrega').attr('src','ventas/pdf/recibo_entrega.php?idnota_remision='+id);
	
	
}





//************fin de impresion de pedido pagado *****************************************


//************metodo para cancelar pedido pagado **********************************************

function cancelarPedidoPagado(id)
{
	console.log('id de nota remision: '+id);
	if(confirm("¿Esta seguro que desea cancelar el pedido ?"+id)){
	
	$.ajax({
					  type: 'POST',
					  url: "ventas/g_cancelarPedido.php",
					  data: "id="+id,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  aparecermodulos("ventas/vi_pedidos.php?ac=1&msj=Operacion realizada con exito",'main');
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos("ventas/vi_pedidos.php?ac=0&msj=Error. ",'main');
						  }	
					  }
				  });	
	}//fin del ifconfirm
		
	
}



//************fin del metodo para cancelar pedido pagado **************************************

//**********************************************************************************************
//* 																						   *
//*										METODOS DE SALIDA									   *
//* 																						   *
//**********************************************************************************************

function listaSalidas()
{
	
}

function reporteSalida(id)
{
	console.log("entro a reporteSalida con el id = "+id);
	$('#impresion').fadeIn();
	
	$('#recibo').slideDown();
	
	$('#recibo').html('<div id="impresionEntrega"><center><iframe border="0" src="productos/pdf/reporteSalida.php?id='+id+'" width="90%" height="400"></iframe></center></div>');
}


function reporteEntrada(id)
{
	console.log("entro a reporteEntrada con el id = "+id);
	$('#impresion').fadeIn();
	
	$('#recibo').slideDown();
	
	$('#recibo').html('<div id="impresionEntrega"><center><iframe border="0" src="productos/pdf/reporteEntradas.php?id='+id+'" width="90%" height="400"></iframe></center></div>');
}
     
	 
function ventanaSecundaria (theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}      

function imprimirPDF(URL){
		//$('#contenido_modal').html('<iframe src="'+URL+'" width="100%" height="100%" scrolling="no"></iframe>');
	$('#contenedor-modal-reportes').html('<iframe src="'+URL+'" width="100%" height="100%" scrolling="no"></iframe>');
		//AbrirModalGeneral('ModalPrincipal',800,500);
	$('#modal-reportes').modal();
	
	//onClick="ventanaSecundaria('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>','Imp. Consiganción','',600,500,'true');"
	
	//onClick="imprimirPDF('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>');"
	}
	
	
	
function imprimirPDFSecundaria(URL){
		$('#contenido_modal_dos').html('<iframe src="'+URL+'" width="100%" height="100%" scrolling="no"></iframe>');	
		AbrirModalSecundaria('ModalSecundaria',800,500);	
	
	//onClick="ventanaSecundaria('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>','Imp. Consiganción','',600,500,'true');"
	
	//onClick="imprimirPDF('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>');"
	}



function abrir_filtro(modal)
{
	$('#'+modal).modal();
}

function cerrar_filtro(modal)
{
	$('#'+modal).modal('hide');
}  

function phoneFormatter(element) { 
 
$('#'+element).attr({ placeholder : '(___) ___-____' }); 
 
    $('#'+element+'[tabindex="111"]').on('input', function() { 
 
    var number = $(this).val().replace(/[^\d]/g, '') 
 
    if (number.length == 7) { 
 
     number = number.replace(/(\d{3})(\d{4})/, "$1-$2"); 
 
    } else if (number.length == 10) { 
 
     number = number.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"); 
 
     
 
    } 
 
    $(this).val(number) 
 
    $('#'+element).attr({ maxLength:10}); 
 
    
 
    }); 
 
}     


function phoneFormatter2(element) { 

 
$('#'+element).attr({ placeholder : '(___) ___-____' }); 
 
    $('#'+element).on('input', function() { 
 
    var number = $(this).val().replace(/[^\d]/g, '') 
 
    if (number.length == 7) { 
 
     number = number.replace(/(\d{3})(\d{4})/, "$1-$2"); 
 
    } else if (number.length == 10) { 
 
     number = number.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"); 
 
     
 
    } 

 
    $(this).val(number) 
 
    $('#'+element).attr({ maxLength:10}); 
 
    
 
    }); 
 
} 

	function phoneFormattercel(element) { 

	 
	$('#'+element).attr({ placeholder : '(___) ___-____' }); 
	 
	   
	 
	    var number = $('#'+element).val().replace(/[^\d]/g, '') 
	 
	    if (number.length == 7) { 
	 
	     number = number.replace(/(\d{3})(\d{4})/, "$1-$2"); 
	 
	    } else if (number.length == 10) { 
	 
	     number = number.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"); 
	 
	     
	 
	    } 

	 
	 
	    $('#'+element).val(number) 
	 
	    $('#'+element).attr({ maxLength:10}); 
	 
	    
	 
	 
	}

function RFCFormatter(element) { 
 
$('#'+element).attr({ placeholder : 'RFC' }); 
 
    $('#'+element).on('input', function() { 
 
    var number = $(this).val().replace(/[^\w]/g, '') 
 
    if (number.length == 7) { 
 
     number = number.replace(/(\w{3})(\w{4})/, "$1$2"); 
 
    } else if (number.length == 10) { 
 
     number = number.replace(/(\w{3})(\w{3})(\w{4})/, "$1$2$3"); 
 
     
 
    } 

    else if (number.length == 13) { 
 
     number = number.replace(/(\w{4})(\w{4})(\w{5})/, "$1$2$3"); 
 
     
 
    } 
 
    $(this).val(number) 
 
    $('#'+element).attr({ maxLength : 13 }); 
 
    
 
    }); 
 
}                   




//**********************************************************************************************
//* 																						   *
//*										METODOS DE FORMULARIOS									   *
//* 																						   *
//**********************************************************************************************


function eliminarFormulario(formulario)
{
	   console.log("Ingreso a eliminar el formulario "+formulario);
	   $("#"+formulario)[0].reset();
   
}



function GuardarEspecial4(formulario,archivo_envio,archivo_vizualizar,donde_mostrar)
{
	//alert(archivo_envio);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		var datos = ObtenerDatosFormulario4(formulario);//obteniedo los datos del formulario
		console.log(datos);
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: archivo_envio,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+error,donde_mostrar);
					  },
					  success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  if ( msj == 1 ){
							  overlayclose('ventana');
							  overlayclose('abc');
							  $('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Operacion realizada con exito",donde_mostrar);
						  }
						  else{
							  overlayclose('ventana');
							 overlayclose('abc');
							 aparecermodulos(archivo_vizualizar+"&ac=0&msj=Error. "+msj,donde_mostrar);
						  }	
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial
function ObtenerDatosFormulario4(id)
{
	
	var  form = document.getElementById(id);
    var length = form.elements.length;
	var  cadena = "";
	
    for( var i = 0; i < length; i++ )
    {
        element = form.elements[i];
		 
        if(element.tagName.toLowerCase() == 'textarea' )
        {
            cadena +=element.name+"="+element.value+"&";
        }
		else if(element.tagName.toLowerCase() =='select')
		{
			cadena +=element.name+"="+element.value+"&";
		}
        else if( element.tagName.toLowerCase() == 'input' )
        {
                if( element.type == 'text' || element.type == 'hidden' || element.type == 'password' || element.type == 'date' || element.type == 'time' || element.type == 'number' || element.type=='email')
                {
					cadena +=element.name+"="+element.value+"&";
                }
                else if( element.type == 'radio' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                               cadena +=element.name+"="+element.value+"&";
 
                }
                else if( element.type == 'checkbox' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on";
                        else
                                cadena +=element.name+"="+element.value+"&";
                }
        }
    }
	cadena = cadena.substring(0,cadena.length-1);
    return cadena;
}

