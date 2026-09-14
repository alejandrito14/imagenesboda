$(document).ready(function() {
    aparecermodulos('catalogos/dashboard/vi_dashboard.php','main');
});

function ObtenerClientesAndroidios() {

	
	$.ajax({
					url: 'catalogos/dashboard/obteneroclientesandroidios.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						$("#usuariosios").text(msj.respuesta[0].ios);
						$("#usuariosandroid").text(msj.respuesta[0].android);

					
					}
				});
}

function Obtenerregistrados(argument) {
	$.ajax({
					url: 'catalogos/dashboard/obteneroclientesregistrados.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						$("#usuariosregistrados").text(msj.respuesta[0].cantidad);

					
					}
				});
}
function clientesensession(argument) {
	
	$.ajax({
					url: 'catalogos/dashboard/obteneroclientessession.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						$("#clientessession").text(msj.respuesta[0].clientessession);

					
					}
				});
}

function ObtenerClientesVersion() {
	
	$.ajax({
					url: 'catalogos/dashboard/obteneroclientesversion.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {
						$("#versionactualdiv").css('display','none');

						if (msj.respuesta[0].actual!=0) {

						$("#versionactualdiv").css('display','block');
						$("#totalversionactual").text(msj.respuesta[0].actual);
						$("#totalversionesanteriores").text(msj.respuesta[0].anterior);
						$("#versionactual").text("("+msj.respuesta[0].versionactual+")");

						}
					}
				});
}