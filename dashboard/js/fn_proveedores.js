function Buscar_proveedores(idmenumodulo) {
	


	$('#modal-filtros').modal('hide');
	$("#contenedor_empresas").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/proveedores/li_proveedores.php', //Url a donde la enviaremos
			type: 'GET', //Metodo que usaremos
			data: datos, //Le pasamos el objeto que creamos con los archivos
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#contenedor_empresas").html(error);
			},
			success: function (msj) {
				$("#contenedor_empresas").html(msj);
			}
		});
	}, 1000);
}


function GuardarProveedor(form,regresar,donde,idmenumodulo) {
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		var v_pais=$("#v_pais").val();
		var v_estados=$("#v_estado").val();
		var v_municipio=$("#v_municipio").val();
		var datos="v_pais="+v_pais+"&v_estados="+v_estados+"&v_municipio="+v_municipio+"&"+datos;
				
		
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/proveedores/ga_proveedores.php', //Url a donde la enviaremos
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

function Borrarproveedor(idproveedor,idmenumodulo) {
	
	var datos='idproveedor='+idproveedor;

	if(confirm("¿Esta seguro de realizar esta operaci\u00f3n?"))
	{	
				  $.ajax({
					url:'catalogos/proveedores/Borrarproveedor.php', //Url a donde la enviaremos
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

						regresar='catalogos/proveedores/vi_proveedores.php';
						donde='main';
						
						   console.log("El resultado de msj es: "+msj);
						 	if( resp[0] == 1 ){
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito&idempresas="+resp[1],donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });				  					  
	 }
}

function ColocarPais(idpais){
	alert('es'+idpais);

	if (idpais>0) {

		$("#v_pais").val(idpais).trigger("chosen:updated");

		ObtenerEstado(0,idpais);

	}

}
function ColocarEstado(idestado){
	if (idestado>0) {
		
		$("#v_estado").val(idestado).trigger("chosen:updated");

		ObtenerMunicipios(0,idestado);
	}
}
function ColocarMunicipio(idmunicipio){
	if (idmunicipio>0) {
		alert('muni'+idmunicipio);

	 $("#v_municipio").val(idmunicipio).trigger("chosen:updated");

	}
}