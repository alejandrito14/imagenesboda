// JavaScript 

//============== MODAL DE NOTIFICACION ======================//
function AbrirNotificacion(msj,icon)
{
	$('#modal-notificacion #modal-body').css({"text-align": "center","font-size":"45px","color":"#4CAF50"});
	$('#modal-notificacion #modal-title').html(msj);
	$('#modal-notificacion #modal-body').html('<i class="mdi '+icon+'"></i>');
	$('#modal-notificacion').modal();
}

function AbrirNotificacionError(msj,icon)
{
	$('#modal-notificacion #modal-body').css({"text-align": "center","font-size":"45px","color":"#F00"});
	$('#modal-notificacion #modal-title').html(msj);
	$('#modal-notificacion #modal-body').html('<i class="mdi '+icon+'"></i>');
	$('#modal-notificacion').modal();
}

//funcion para ocultar los div mostrados despues de cierto tiempo
function OcultarNotificacion()
{
	setTimeout(function(){
		$('#modal-notificacion').modal('hide');
	},2000);	
}
 