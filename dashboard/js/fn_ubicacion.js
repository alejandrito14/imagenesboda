// JavaScript Document

function Buscar_Pais(idmenumodulo)
{
	var id = $('#b_id').val();
	var nombre = $('#b_nombre').val();
	var empresa = $('#b_empresa').val();

	
	var datos = "idcategoria="+id+"&nombre="+nombre+"&empresa="+empresa+"&idmenumodulo="+idmenumodulo;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	
	$("#contenedor_paices").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		setTimeout(function(){
				  $.ajax({
					  url:'catalogos/ubicacion/li_pais.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						$("#contenedor_paices").html(error); 
					  },
					success:function(msj){
						$("#contenedor_paices").html(msj); 	  
					  	}
				  });				  					  
		},1000);	
}

function Buscar_Estado(idmenumodulo) {
	var id = $('#b_id').val();
	var nombre = $('#b_nombre').val();
	var empresa = $('#b_empresa').val();


	var datos = "idcategoria=" + id + "&nombre=" + nombre + "&empresa=" + empresa + "&idmenumodulo=" + idmenumodulo;

	console.log(datos);

	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');

	$("#contenedor_estados").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/ubicacion/li_estado.php', //Url a donde la enviaremos
			type: 'GET', //Metodo que usaremos
			data: datos, //Le pasamos el objeto que creamos con los archivos
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#contenedor_estados").html(error);
			},
			success: function (msj) {
				$("#contenedor_estados").html(msj);
			}
		});
	}, 1000);
}

function Buscar_Ciudad(idmenumodulo) {
	var id = $('#b_id').val();
	var nombre = $('#b_nombre').val();
	var empresa = $('#b_empresa').val();


	var datos = "idcategoria=" + id + "&nombre=" + nombre + "&empresa=" + empresa + "&idmenumodulo=" + idmenumodulo;

	console.log(datos);

	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');

	$("#contenedor_ciudades").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/ubicacion/li_ciudad.php', //Url a donde la enviaremos
			type: 'GET', //Metodo que usaremos
			data: datos, //Le pasamos el objeto que creamos con los archivos
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#contenedor_ciudades").html(error);
			},
			success: function (msj) {
				$("#contenedor_ciudades").html(msj);
			}
		});
	}, 1000);
}

function modalpais(archivo,donde) {
	aparecermodulos(archivo, donde);
	$('#titulo-visor').html('PAIS')
	$('#Modal-visor').modal('show');
}

function modalestado(archivo, donde) {
	aparecermodulos(archivo, donde);
	$('#titulo-visor').html('ESTADO')
	$('#Modal-visor').modal('show');
}

function modalciudad(archivo, donde) {
	aparecermodulos(archivo, donde);
	$('#titulo-visor').html('CIUDAD')
	$('#Modal-visor').modal('show');
}

function GuardarPais(form,regresar,donde,idmenumodulo)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		$('#Modal-visor').modal('hide');
		console.log(datos);
	
		$('#contenedor_paices').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					  url:'catalogos/ubicacion/ga_pais.php', //Url a donde la enviaremos
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

function GuardarEstado(form, regresar, donde, idmenumodulo) {
	if (confirm("\u00BFDesea realizar esta operaci\u00f3n?")) {
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		$('#Modal-visor').modal('hide');
		console.log(datos);

		$('#contenedor_estados').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')

		setTimeout(function () {
			$.ajax({
				url: 'catalogos/ubicacion/ga_estado.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				data: datos, //Le pasamos el objeto que creamos con los archivos
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					var error;
					console.log(XMLHttpRequest);
					if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
					if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
					$('#abc').html('<div class="alert_error">' + error + '</div>');
					//aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
				},
				success: function (msj) {
					var resp = msj.split('|');

					console.log("El resultado de msj es: " + msj);
					if (resp[0] == 1) {
						aparecermodulos(regresar + "?ac=1&idmenumodulo=" + idmenumodulo + "&msj=Operacion realizada con exito&idempresas=" + resp[1], donde);
					} else {
						aparecermodulos(regresar + "?ac=0&idmenumodulo=" + idmenumodulo + "&msj=Error. " + msj, donde);
					}
				}
			});
		}, 1000);
	}
}

function GuardarCiudad(form, regresar, donde, idmenumodulo) {
	if (confirm("\u00BFDesea realizar esta operaci\u00f3n?")) {
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		$('#Modal-visor').modal('hide');
		console.log(datos);

		$('#contenedor_ciudades').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')

		setTimeout(function () {
			$.ajax({
				url: 'catalogos/ubicacion/ga_ciudad.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				data: datos, //Le pasamos el objeto que creamos con los archivos
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					var error;
					console.log(XMLHttpRequest);
					if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
					if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
					$('#abc').html('<div class="alert_error">' + error + '</div>');
					//aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
				},
				success: function (msj) {
					var resp = msj.split('|');

					console.log("El resultado de msj es: " + msj);
					if (resp[0] == 1) {
						aparecermodulos(regresar + "?ac=1&idmenumodulo=" + idmenumodulo + "&msj=Operacion realizada con exito&idempresas=" + resp[1], donde);
					} else {
						aparecermodulos(regresar + "?ac=0&idmenumodulo=" + idmenumodulo + "&msj=Error. " + msj, donde);
					}
				}
			});
		}, 1000);
	}
}

function ObtenerMunicipioslista() {

	var estado=$("#estado").val();

	var datos="estado="+estado;
			$('#table').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>')

		setTimeout(function () {
			$.ajax({
				url: 'catalogos/ubicacion/obtenermunicipios.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				data: datos, //Le pasamos el objeto que creamos con los archivos
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					var error;
					console.log(XMLHttpRequest);
					if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
					if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
					$('#abc').html('<div class="alert_error">' + error + '</div>');
					//aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
				},
				success: function (msj) {

					$("#table").html(msj);
				}
			});
		}, 1000);
}

function HabilitarMun(idmunicipio) {
		var habilitado=0;

		if($("#municipo_"+idmunicipio).is(':checked')){
			habilitado=1;
		}
	

		var datos="idmunicipio="+idmunicipio+"&habilitado="+habilitado;

		setTimeout(function () {
			$.ajax({
				url: 'catalogos/ubicacion/habilitar.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				data: datos, //Le pasamos el objeto que creamos con los archivos
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					var error;
					console.log(XMLHttpRequest);
					if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status;// display some page not found error 
					if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
					$('#abc').html('<div class="alert_error">' + error + '</div>');
					//aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
				},
				success: function (msj) {

					if (msj==1) {

						AbrirNotificacion('SE MODIFICO SATISFACTORIAMENTE','');
					}
				}
			});
		}, 1000);
}