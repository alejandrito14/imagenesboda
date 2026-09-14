

function ObtenerPais(idpais) {


	$.ajax({
		type: 'GET',
		url:'catalogos/sucursales/obtenerpais.php', //Url a donde la enviaremos
		async:false,
		success: function(datos){

			var respuesta=datos.respuesta;

			console.log(respuesta.length);
			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar país</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option  value="`+respuesta[i].idpais+`">`+respuesta[i].pais+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran país</option>`;



				}

				$("#v_pais").html(html);

				if (idpais>0) {
				$("#v_pais").val(idpais);

				}

			 $('#v_pais').trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  				if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  				if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
						});
}


function ObtenerEstado(idestado,idpais) {
	
	var datos="idpais="+idpais;
	$.ajax({
		type: 'POST',
		url:'catalogos/sucursales/obtenerestados.php', //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		success: function(datos){

			var respuesta=datos.respuesta;

			console.log(respuesta);
			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar estado</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].id+`">`+respuesta[i].nombre+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran estados</option>`;



				}



				$("#v_estado").html(html);

				if (idestado>0) {
					$("#v_estado").val(idestado);
				}
				 $('#v_estado').trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  				if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  				if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
						});
}

function ObtenerMunicipios(idmunicipio,idestado) {
	
	var pagina = "obtenermunicipios.php";
	var datos="idestado="+idestado;
	$.ajax({
		type: 'POST',
		url:'catalogos/sucursales/obtenermunicipios.php', //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		success: function(datos){

			var respuesta=datos.respuesta;

			console.log(respuesta.length);
			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar municipio</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].id+`">`+respuesta[i].nombre+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran municipios</option>`;


				}

				$("#v_municipio").html(html);

				if (idmunicipio>0) {

					$("#v_municipio").val(idmunicipio);
				}
			 $('#v_municipio').trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  				if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  				if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
						});
}


function ObtenerPaisIdelemento(idpais,idelemento) {


	$.ajax({
		type: 'GET',
		url:'catalogos/sucursales/obtenerpais.php', //Url a donde la enviaremos
		async:false,
		success: function(datos){

			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar país</option>`;

				for (var i = 0; i < respuesta.length; i++) {

						html+=`<option  value="`+respuesta[i].idpais+`">`+respuesta[i].pais+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran país</option>`;



				}

				$("#"+idelemento).html(html);

				if (idpais>0) {
				$("#"+idelemento).val(idpais);
		

				}

			        $('#'+idelemento).trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  	if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  	if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
			});
}


function ObtenerEstadoIdElemento(idestado,idpais,elemento) {
	
	var datos="idpais="+idpais;
	$.ajax({
		type: 'POST',
		url:'catalogos/sucursales/obtenerestados.php', //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		async:false,
		success: function(datos){

			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar estado</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].id+`">`+respuesta[i].nombre+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran estados</option>`;



				}



				$("#"+elemento).html(html);

				if (idestado>0) {
					$("#"+elemento).val(idestado);
		
				}
			        $('#'+elemento).trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  				if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  				if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
						});
}


function ObtenerMunicipiosIdElemento(idmunicipio,idestado,elemento) {

	var pagina = "obtenermunicipios.php";
	var datos="idestado="+idestado;
	$.ajax({
		type: 'POST',
		url:'catalogos/sucursales/obtenermunicipios.php', //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		async:false,
		success: function(datos){

			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar municipio</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].id+`">`+respuesta[i].nombre+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran municipios</option>`;


				}

				$("#"+elemento).html(html);

				if (idmunicipio>0) {

					$("#"+elemento).val(idmunicipio);
	
				}
			        $('#'+elemento).trigger("chosen:updated");

			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  				if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  				if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
							}
						});
}


function ObtenerCodigospostalesmunicipios(idpais,idestado,idmunicipio,elemento,codigo) {

	var pais=$("#"+idpais).val();
	var estado=$("#"+idestado).val();
	var municipio=$("#"+idmunicipio).val();
	
	var pagina = "obtenercodigopostalesmunicipio.php";
	var datos="pais="+pais+"&estado="+estado+"&municipio="+municipio;
	$.ajax({
		type: 'POST',
		url:'catalogos/sucursales/'+pagina, //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		async:false,
		success: function(datos){
			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar código postal</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].codigo+`">`+respuesta[i].codigo+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran códigos postales</option>`;


				}

				$("#"+elemento).html(html);


				if (codigo!='') {

				$("#"+elemento).val(codigo);
		
	
				}
			        $('#'+elemento).trigger("chosen:updated");


			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  	if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  	if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
					}
			});
}


function ObtenerTipoAsentamiento(idpais,idestado,idmunicipio,elemento,codigo,tasentamiento) {
	var pais=$("#"+idpais).val();
	var estado=$("#"+idestado).val();
	var municipio=$("#"+idmunicipio).val();

	var codigopostal=$("#"+codigo).val();
	
	var pagina = "ObtenerTipoAsentamiento.php";
	var datos="idpais="+pais+"&idestado="+estado+"&idmunicipio="+municipio+"&codigopostal="+codigopostal;
	$.ajax({
		type: 'POST',
		url:'catalogos/costosenvio/'+pagina, //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		async:false,
		success: function(datos){
			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar tipo asentamiento</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].tipo_asenta+`">`+respuesta[i].tipo_asenta+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran tipo de asentamiento </option>`;


				}

				$("#"+elemento).html(html);


				if (tasentamiento!='') {

				$("#"+elemento).val(tasentamiento);
				}
				

			        $('#'+elemento).trigger("chosen:updated");


			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  	if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  	if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
					}
			});
}

function ObtenerAsentamientos(idpais,idestado,idmunicipio,elemento,codigo,tasentamiento,asenta) {
	var pais=$("#"+idpais).val();
	var estado=$("#"+idestado).val();
	var municipio=$("#"+idmunicipio).val();
	var codigopostal=$("#"+codigo).val();
	var tipoasentamiento=$("#"+tasentamiento).val();

	var pagina = "ObtenerColonias.php";
	var datos="idpais="+pais+"&idestado="+estado+"&idmunicipio="+municipio+"&v_codigopostal="+codigopostal+"&tipoasen="+tipoasentamiento;
	$.ajax({
		type: 'POST',
		url:'catalogos/costosenvio/'+pagina, //Url a donde la enviaremos
		data:datos,
		dataType:'json',
		async:false,
		success: function(datos){
			var respuesta=datos.respuesta;

			var html="";
			if (respuesta.length>0) {
				html+=`<option value="0">Seleccionar asentamiento</option>`;


				for (var i = 0; i < respuesta.length; i++) {

						//armar nivel
						html+=`<option value="`+respuesta[i].asenta+`">`+respuesta[i].asenta+`</option>`;

					}
				}else{
					html+=`<option value="0">No se encuentran asentamientos </option>`;


				}

				$("#"+elemento).html(html);


				if (asenta!='') {

				$("#"+elemento).val(asenta);

				}
			        $('#'+elemento).trigger("chosen:updated");


			},error: function(XMLHttpRequest, textStatus, errorThrown){ 
				var error;
				  	if (XMLHttpRequest.status === 404) error = "Pagina no existe "+pagina+" "+XMLHttpRequest.status;// display some page not found error 
				  	if (XMLHttpRequest.status === 500) error = "Error del Servidor"+XMLHttpRequest.status; // display some server error 
								//alerta("Error leyendo fichero jsonP "+d_json+pagina+" "+ error,"ERROR"); 
								console.log("Error leyendo fichero jsonP "+pagina+" "+ error,"ERROR");
					}
			});
}