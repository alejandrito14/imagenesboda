
function Buscar_Productos(idmenu) {

	//var datos = "idmenumodulo=" + idmenu;
	var id = $("#b_id").val();
	var nombre = $("#b_nombre").val();
	var empresa = $("#b_empresa").val();

	var datos = "idmenumodulo=" + idmenu + "&id=" + id + "&nombre=" + nombre + "&empresa=" + empresa;
	console.log(datos);


	cerrar_filtro('modal-filtros');
	$('#modal-filtros').modal('hide');
	$("#contenedor_empresas").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/productos/li_productos.php', //Url a donde la enviaremos
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

function mostrar(){
	var opcionProducto =$("#opcionProducto").val();

	if( opcionProducto ==0){
		$("#v_cantidadTemp").removeAttr("readonly")
	}
	else if( opcionProducto ==1){
		$("#v_cantidadTemp").removeAttr("readonly")
	}
	else if( opcionProducto ==2){
		$("#v_cantidadTemp").attr('readonly', 'readonly');
		$("#v_cantidadTemp").val('0');

	}


}

function verificar(e) {
	// comprovamos con una expresion regular que el caracter pulsado sea
	// una letra, numero o un espacio
	if (e.key.match(/[a-z0-9A-Z]/i) === null) {

		// Si la tecla pulsada no es la correcta, eliminado la pulsación
		e.preventDefault();
	}
}

function Guardarproducto(form, regresar, donde, idmenu) {


		var idinsumos=[];
		var cantidadinsumo=[];
		var insumomedida=[];
		var precioinsumo=0;
		var subtotalinsumo=[];
		var insumosubtotalmedida=[];
		
		


		if (confirm("\u00BFDesea realizar esta operaci\u00f3n?")) {




			var v_nombre = $('#v_nombre').val();
			var v_descripcion = $('#v_descripcion').val();
			var v_precio = 0;
			var v_descuento = 0;
			var v_empresa = $('#v_empresa').val();
			var v_categoria = $('#v_categoria').val();
			var v_presentacion = $('#v_presentacion').val();
			var v_estatus = $('#v_estatus').val();
			var VALIDACION = $('#VALIDACION').val();
			var precioventa=$("#precioventa").val();
			var categoria_producto=$("#v_categoriaprecios").val();
			var codigoproducto=$("#codigoproducto").val();
			var v_idtipo_medida=$("#v_idtipo_medida").val();
			var id = $('#id').val();
			console.log(id);

			var data = new FormData();

		data.append('v_nombre', v_nombre);
		data.append('v_descripcion', v_descripcion);
		data.append('v_precio', v_precio);
		data.append('v_descuento', v_descuento);
		data.append('v_categoria', v_categoria);
		//data.append('v_presentacion', v_presentacion);
		data.append('v_estatus', v_estatus);
		data.append('VALIDACION', VALIDACION);
		data.append('precioventa',precioventa);
		data.append('codigoproducto',codigoproducto);
		data.append('v_idtipo_medida',v_idtipo_medida);

		data.append('id', id);


		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')



			$.ajax({
				url: 'catalogos/productos/ga_productos.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				contentType: false, //Debe estar en false para que pase el objeto sin procesar
				data: data, //Le pasamos el objeto que creamos con los archivos
				processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
				cache: false, //Para que el formulario no guarde cache,
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					var error;
					console.log(XMLHttpRequest);
					if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
					if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
					$('#abc').html('<div class="alert_error">' + error + '</div>');
					//aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
				},
				success: function (msj) {
					console.log("El resultado de msj es: " + msj);

					var productofinal=localStorage.getItem('productofinal');

					var mensaje=msj.split('|');

					if (productofinal==0) {
						if (mensaje[0] == 1) {

							var URL = regresar + "?idmenumodulo=" + idmenu + "&ac=1&msj=Operacion realizada con exito";
							aparecermodulos(URL, donde);
						} else {
							aparecermodulos(regresar + "?idmenumodulo=" + idmenu + "&ac=0&msj=Error. " + msj, donde);
						}

					}



					if (productofinal==1) {

						var idproducto=mensaje[1];
						var url="catalogos/paquetes/fa_paquetes.php?idmenumodulo="+idmenu+"&ac=1&msj=Operacion realizada con exito&idproducto="+idproducto;

						aparecermodulos(url, donde);

					}
				}
			});
		

	}



}


function BuscarInsumos() {
	var valor=$("#FiltrarContenido").val();
	var idempresa=$("#v_empresa").val();
	var idcategoriaprecios=$("#v_categoriaprecios").val();


	var datos="idempresa="+idempresa+"&busqueda="+valor+"&idcategoriaprecios="+idcategoriaprecios;
	$('#contenedor_insumos').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>')


		$.ajax({
					url: 'catalogos/productos/li_insumosbuscador.php', //Url a donde la enviaremos
					type: 'GET', //Metodo que usaremos
					data:datos,
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#contenedor_insumos").html(error);
					},	
					success: function (msj) {
						$("#contenedor_insumos").html(msj);
					}
				});

	
}
function CargaInsumoEmpresa() {
	var idempresa=$("#v_empresa").val();
	var idcategoriaprecios=$("#v_categoriaprecios").val();
	ObtenerInsumos(idempresa,idcategoriaprecios);

	var html=`<tr> 
	<td colspan="8" style="text-align: center">
	<h4 class="alert_warning">NO EXISTEN PRODUCTOS AGREGADOS.</h4>
	</td>
	</tr>`;
	$("#tabla_agregados").html(html);
	EliminarVariableSession();

}

function CargaInsumoEmpresa2(idcategoriaprecios) {
	var idempresa=$("#v_empresa").val();
	ObtenerInsumos(idempresa,idcategoriaprecios);


}


function ObtenerInsumos(idempresa,idcategoriaprecios) {

	var datos="idempresa="+idempresa+"&idcategoriaprecios="+idcategoriaprecios;
	$('#contenedor_insumos').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>')

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/productos/li_insumos.php', //Url a donde la enviaremos
			type: 'GET', //Metodo que usaremos
			data:datos,
			async:false,

			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#contenedor_insumos").html(error);
			},
			success: function (msj) {
				$("#contenedor_insumos").html(msj);
				//$("#tabla_agregados").html("");
			}
		});
	}, 100);
}

function AgregarAproducto(idinsumo) {
	
	var cantidad=$("#insumo_"+idinsumo).val();
	var empresa=$("#v_empresa").val();

	var datos="empresa="+empresa+"&insumo="+idinsumo+"&cantidad="+cantidad;

if (cantidad>0) {

	setTimeout(function () {
		$.ajax({
			url: 'catalogos/productos/agregar.php', //Url a donde la enviaremos
			type: 'POST', //Metodo que usaremos
			data:datos,
			async:false,
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#tabla_agregados").html(error);
			},
			success: function (msj) {



				$("#tabla_agregados").html(msj);

				var suma=0;
				$( ".subtotal" ).each(function( index ) {

					suma=parseFloat(suma)+parseFloat($(this).val());
				});



				$("#preciounitario").val(suma);

			}
		});
	}, 100);
	}else{



		AbrirNotificacion('COLOCA UNA CANTIDAD MAYOR A 0','');
	}
}

function BorrarInsumoProducto(idinsumo) {
	var datos="insumoid="+idinsumo;

	setTimeout(function () {
		$.ajax({
						url: 'catalogos/productos/eliminar.php', //Url a donde la enviaremos
						type: 'POST', //Metodo que usaremos
						data:datos,
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							var error;
							console.log(XMLHttpRequest);
							if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
							if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
							$("#tabla_agregados").html(error);
						},
						success: function (msj) {

							$("#insumota_"+idinsumo).remove();
							$("#tabla_agregados").html(msj);


							var suma=0;
							$( ".subtotal" ).each(function( index ) {

								suma=parseFloat(suma)+parseFloat($(this).val());
							});

							$("#preciounitario").val(suma);


						}
					});
	}, 100);
}
function BorrarDatosProducto(idproducto,idempresa,idmenumodulo)
{
	var cadena="idproducto="+idproducto+"&idempresa="+idempresa;
	archivo_vizualizar="catalogos/productos/vi_productos.php";
	donde_mostrar="main";
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
			$.ajax({
				type: 'POST',
					  url: 'catalogos/productos/eliminarProducto.php', //Url a donde la enviaremos
					  data: cadena,
					  dataType:'json',
					  success:function(msj){
					  	console.log(msj);
					  	if ( msj.respuesta ==0 ){

					  		aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmenumodulo+"&ac=1&msj=Registro borrado con exito",donde_mostrar);
					  	}
					  	else{
					  		var mensaje="No se puede eliminar producto,se encuentra en paquetes";
					  		aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmenumodulo+"&ac=0&msj="+mensaje+". ",donde_mostrar);
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

function PreguntarSiesproducto(form, regresar, donde, idmenu) {
	var productofinal=0;

	var idproducto=$("#id").val();

	if (idproducto==0) {
		if(confirm("¿Es un producto final?"))
		{
			productofinal=1;
		}
	}

	localStorage.setItem('productofinal',productofinal);

	Guardarproducto(form, regresar, donde, idmenu);
}

function ObtenerCategoriasPrecios(idcategoriaprecios,idcategoria) {
	//PreciosCategorias(idcategoriaprecios);
	ObtenerCategoriasweb(idcategoria);
}

function PreciosCategorias(idcategoriaprecios) {
	var empresa=$("#v_empresa").val();
	var cadena="empresa="+empresa;
	
	setTimeout(function(){
		$.ajax({
			type: 'POST',
					  url: 'catalogos/productos/li_categoriasprecio.php', //Url a donde la enviaremos
					  data: cadena,
					  async:false,
					  success:function(msj){
					  	$("#v_categoriaprecios").html(msj);
					 
					  	$('#v_categoriaprecios').trigger("chosen:updated");

					  	if (idcategoriaprecios>0) {

					  			$("#v_categoriaprecios").val(idcategoriaprecios);
					  			$('#v_categoriaprecios').trigger("chosen:updated");

					  	}


					  },
					  error:function(){
					  	$('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
					  	$('.alert_error').slideDown(timeSlide);

					  }
					});				  					  
	},100);
}

function ObtenerCategoriasweb(idcategoria) {

	var empresa=$("#v_empresa").val();
	var cadena="empresa="+empresa;
	
	setTimeout(function(){
		$.ajax({
			type: 'POST',
					  url: 'catalogos/productos/li_categoriasweb.php', //Url a donde la enviaremos
					  data: cadena,
					  async:false,
					  success:function(msj){
					  	$("#v_categoria").html(msj);

					  	$('#v_categoria').trigger("chosen:updated");


					  	if (idcategoria>0) {
					  		
					  		$("#v_categoria").val(idcategoria);
					  		$('#v_categoria').trigger("chosen:updated");

					  	}
					  	

					  },
					  error:function(){
					  	$('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
					  	$('.alert_error').slideDown(timeSlide);

					  }
					});				  					  
	},100);
}


function EliminarVariableSession() {
	
	setTimeout(function(){
		$.ajax({
			type: 'GET',
					  url: 'catalogos/productos/variablesession.php', //Url a donde la enviaremos
					  async:false,
					  alert_success:function(msj){
					  	console.log(msj);
					  	$("#tabla_agregados").html(msj);



					  },
					  error:function(){
					  	$('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
					  	$('.alert_error').slideDown(timeSlide);

					  }
					});				  					  
	},100);
}

function Subirimagen(idproducto,idempresa) {

	$("#idproductos").val(idproducto);
	$("#idempresas").val(idempresa);


	showAttachedFiles(idproducto,idempresa)

	$("#modalimagen").modal();
}



function BuscarProductosLista() {

	var valor=$("#FiltrarContenido").val();
	var idempresa=$("#v_empresa").val();
	var idcategoriaprecios=$("#v_categoriaprecios").val();


	var datos="busqueda="+valor;
	$('#contenedor_insumos').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>')

		$.ajax({
					url: 'catalogos/paquetes/li_productosbuscador.php', //Url a donde la enviaremos
					type: 'GET', //Metodo que usaremos
					data:datos,
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#contenedor_insumos").html(error);
					},	
					success: function (msj) {
						$("#contenedor_insumos").html(msj);
					}
				});

	
}


function AgregarCantidad(idinsumo){

		var cantidad=$("#cantidadpro_"+idinsumo).val();
		var datos="empresa="+0+"&insumo="+idinsumo+"&cantidad="+cantidad;


	$.ajax({
		url: 'catalogos/paquetes/agregarcantidad.php', //Url a donde la enviaremos
		type: 'POST', //Metodo que usaremos
		data:datos,
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			var error;
			console.log(XMLHttpRequest);
			if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
			if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
			$("#tabla_agregados").html(error);
		},	
		success: function (msj) {
			$("#tabla_agregados").html(msj);
		}
	});


}

function ObtenerProductoPaquete(idproducto) {

	

	var datos="idproducto="+idproducto;
	
	$.ajax({
		url: 'catalogos/paquetes/obtenerproducto.php', //Url a donde la enviaremos
		type: 'POST', //Metodo que usaremos
		dataType:'json',
		data:datos,
		async:false,
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			var error;
			console.log(XMLHttpRequest);
			if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
			if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
			$("#tabla_agregados").html(error);
		},	
		success: function (msj) {

			var producto=msj.producto;

			$("#v_nombre").val(producto.nombre);
			$("#v_descripcion").val(producto.descripcion);

			$("#insumo_"+idproducto).val(1);

			AgregarAproducto(idproducto);
			
		}
	});
}