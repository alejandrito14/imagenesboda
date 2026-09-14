// JavaScript Document

function Buscar_categoriasproducto(idmenumodulo)
{
	var id = $('#b_id').val();
	var nombre = $('#b_nombre').val();
	var empresa = $('#b_empresa').val();

	
	var datos = "idcategoria="+id+"&nombre="+nombre+"&empresa="+empresa+"&idmenumodulo="+idmenumodulo;
	
	console.log(datos);
	
	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	
	$("#contenedor_empresas").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
		
				  $.ajax({
					  url:'catalogos/categoriasproducto/li_categoriasproductos.php', //Url a donde la enviaremos
					type:'GET', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $("#contenedor_empresas").html(error); 
					  },
					success:function(msj){
					      $("#contenedor_empresas").html(msj); 	  
					  	}
				  });				  					  
			
}


function GuardarCategorias(form,regresar,donde,idmenumodulo)
{
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var nombre =$("#v_nombre").val();
		var depende=$("#v_depende").val();
		var orden=$("#v_orden").val();
		var estatus=$("#v_estatus").val();

		var id=$("#id").val();
		var data = new FormData();

		var archivos = document.getElementById("image"); //Damos el valor del input tipo file
		var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
		console.log(archivo);

		//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
		//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
		//que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
		for (i = 0; i < archivo.length; i++) {
			data.append('archivo' + i, archivo[i]);
		}

		data.append('v_nombre',nombre);
		data.append('v_depende',depende);
		data.append('v_orden',orden);
		data.append('id',id);
		data.append('v_estatus',estatus);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					  url:'catalogos/categoriasproducto/ga_categoriasproductos.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					contentType: false, //Debe estar en false para que pase el objeto sin procesar
					data: data, //Le pasamos el objeto que creamos con los archivos
					processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
					cache: false, //Para que˘
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

function BorrarCategoria(idcategoria,campo,tabla,valor,regresar,donde,idmenumodulo) {
	
var datos='idcategoria='+idcategoria;
	$.ajax({
		url:'catalogos/categoriasproducto/borrarCategoria.php', //Url a donde la enviaremos
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
		  var resp = msj;
		  
			 console.log("El resultado de msj es: "+msj);
			   if( resp == 0 ){
				  aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito",donde);
				}else{
				  aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=La categoría se encuentra relacionada con un producto. "+msj,donde);
				}			
			}
	});
}


function Subirimagencategoria(idcategoria) {
	
	$("#idcategoriasproducto").val(idcategoria);
	showAttachedFiles1(idcategoria);
	$("#modalimagencategoria").modal();
}