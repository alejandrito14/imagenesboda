function GuardarProductoPaquete(idsucursal) {



	var arraypaquete=[];
	
	$(".paquetesucursal_"+idsucursal).each(function(){
			var id=$(this).attr('id');
		
			if ($("#"+id).is(':checked')) {

				var separar=id.split('_')[1];
				arraypaquete.push(separar);
			}

		});



	var datos="idsucursal="+idsucursal+"&paquetes="+arraypaquete;

		$.ajax({
					url: 'catalogos/paquetessucursales/ga_paquetessucursales.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
					dataType:'json',
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

					
						if (msj.respuesta==1) {

							AbrirNotificacion("SE ACTUALIZARON LOS PAQUETES EN LA SUCURSAL","mdi-checkbox-marked-circle");
						}

					}
				});

}

function BuscarPaquete(idsucursal) {
	
	var buscador=$("#buscador_"+idsucursal).val().toLowerCase();

	var datos="idsucursal="+idsucursal+"&buscador="+buscador;



	$(".pasu_"+idsucursal).each(function(){
			var id=$(this).attr('id');
			
			obtener=$('#'+id).text().toLowerCase();

					  		cadena=$(this).text().toLowerCase();

		  		if (obtener.indexOf(buscador.toLowerCase())!=-1 ) {

		  			$('#'+id).css('display','block');	

		  		}else{

		  			$('#'+id).css('display','none');	


		  		}


		});
	

}