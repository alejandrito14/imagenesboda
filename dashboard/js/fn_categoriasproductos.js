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

function PaquetesRelacion(idcategoria,nombre) {

	
	Obtenerpaquetescategorias(idcategoria,nombre);
}

function Obtenerpaquetescategorias(idcategoria,nombre) {

		var datos="id="+idcategoria;

	$.ajax({
					url:'catalogos/categoriasproducto/ga_productos.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json', //Debe estar en false para que pase el objeto sin procesar
					data:datos,
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
					success:function(msj){
							contador=0;
							$("#nombrecategoria").text(nombre);
							$("#modalpaquetes").modal();
							var paquetes=msj.respuesta;
							PintarPaquetescategoria(paquetes,idcategoria);
						
								
					  	}
				  });

	}

	function PintarPaquetescategoria(paquetes,idcategoria) {
		
		var html=``;

		if (paquetes.length>0) {


			for (var i =0; i < paquetes.length; i++) {

				var ruta=paquetes[i].ruta;
				var seleccionado=paquetes[i].visualizarcarrusel;
				checked="";
				if (seleccionado==1) {
					checked="checked";
				}
			html+=`
			<div class="col-md-3 colpaquetes1" id="colpaquetes_`+paquetes[i].idpaquete+`">
			<div class="card" style="width: 100%">
			  <img class="card-img-top" src="`+ruta+`" >
			  <div class="" style="padding-top:1em;">
			    <p class="paquetestexto" id="texto_`+paquetes[i].idpaquete+`"><input type="checkbox" onchange="SeleccionarPaquetes(`+paquetes[i].idpaquete+`)" class="paquetes" id="paquete_`+paquetes[i].idpaquete+`" `+checked+`> `+paquetes[i].nombrepaquete+`</p>

			  </div>
			</div>
			</div>

			`;
		}

			$("#btnguardarpc").css("display","block");
			$("#btnguardarpc").attr("onclick","GuardarPaquetesVisualizar("+idcategoria+")");

		}else{
 			
 			$("#btnguardarpc").css("display","block");

			$("#btnguardarpc").attr("onclick","");


		}
		

		$("#paquetecategoria").html(html);


	}

	function SeleccionarPaquetes(idpaquete) {
	
		var contador=0;
		$(".paquetes").each(function() {

			if ($(this).is(':checked')) {

				contador++;
			}
			  
			});

		
		if (contador<=15) {

			if ($("#paquete_"+idpaquete).is(':checked')) {

				//$("#paquete_"+idpaquete).prop("checked",false);

			}else{

				//$("#paquete_"+idpaquete).prop("checked",true);

			}
		}else{

			$("#paquete_"+idpaquete).prop("checked",false);


		}
	}

	function GuardarPaquetesVisualizar(idcategoria) {
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{
		var paquetes=[];
		$(".paquetes").each(function() {
			
				if ($(this).is(':checked')) {

					var id=$(this).attr('id');

					paquetes.push(id.split('_')[1]);
					
				}
			  
			});

		
			var datos="paquetes="+paquetes+"&idcategoria="+idcategoria;

			$.ajax({
					url:'catalogos/categoriasproducto/guardarpaquetes.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					dataType:'json', //Debe estar en false para que pase el objeto sin procesar
					data:datos,
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
					success:function(msj){

							if (msj.respuesta==1) {

								$("#modalpaquetes").modal('hide');
								AbrirNotificacion("SE ACTUALIZARON LOS PAQUETES EN EL CARRUSEL","mdi-checkbox-marked-circle");
							}
								
					  	}
				  });

				}
	 
	}


	function Buscarpaquete() {

		var buscador=$("#buscarpaquete").val();
		var concidencia=[];
		var listadopaquetes=[];
		$(".paquetestexto").each(function() {
			var id =$(this).attr('id')
			listadopaquetes.push(id);

		});
	
		var i=0;

	if (buscador!='') {
		$(".paquetestexto").each(function() {

				cadena=$(this).text().toLowerCase();

				if (cadena.indexOf(buscador.toLowerCase())!=-1 ) {

				
		  					if (!BuscarEnarray(concidencia,listadopaquetes[i])) {

						  		concidencia.push(listadopaquetes[i]);
						  		
						  

						  	}

		  		}else{


		  					if (BuscarEnarray(concidencia,listadopaquetes[i])) {

		  						posicion=BuscarPosicion(concidencia,listadopaquetes[i]);

		  						concidencia.splice(posicion,posicion);


						  	}



		  		}
		  		i++;
			  
			});

	
			$(".colpaquetes1").css('display','none');
			for (var i = 0; i <concidencia.length; i++) {
				var id=concidencia[i].split('_')[1];

				$("#colpaquetes_"+id).css('display','block');
			}

		}else{

		$(".colpaquetes1").css('display','block');

		}
	}


	function BuscarEnarray(array,elemento) {
	
	for (var i = 0; i <array.length; i++) {
		
		if (array[i]==elemento) {
			return true;
			break;
		}
	}
}

function BuscarPosicion(array,elemento) {
	
	for (var i = 0; i <array.length; i++) {
		
		if (array[i]==elemento) {
			return i;
		}
	}
}