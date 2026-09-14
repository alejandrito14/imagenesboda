// JavaScript Document

function abrir_modal_formulario(archivo,titulo)
{
	
	$('#titulo-modal-forms').html(titulo);
	aparecermodulos(archivo,'contenedor-modal-forms');
	$('#modal-forms').modal();
	
	$('#titulo-modal-forms').css('text-transform','uppercase');
}