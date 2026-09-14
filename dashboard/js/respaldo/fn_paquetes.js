
function Buscar_Paquetes(idmenu) {

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
			url: 'catalogos/paquetes/li_paquetes.php', //Url a donde la enviaremos
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

function Guardarpaquete(form, regresar, donde, idmenu) {
	var v_insumostabla = $('.insumostabla').length;
		//datos generales
		//
		//
		var idproductos=[];
		var cantidadinsumo=[];
		var insumomedida=[];
		var precioinsumo=0;
		var subtotalinsumo=[];
		var insumosubtotalmedida=[];
		
		var complementos=[];

		var topessecundarios=[];

		$(".idinsummook").each(function(index) {
			console.log($(this).text());
			idproductos.push($(this).text());
		});

		$(".insumocantidad").each(function(index) {
			console.log($(this).text());

			cantidadinsumo.push($(this).text());
		});

		$(".insumomedida").each(function(index) {
			console.log($(this).text());
			insumomedida.push($(this).text());
		});

		$(".insumosubtotalmedida").each(function(index) {
			console.log($(this).text());
			insumosubtotalmedida.push($(this).text());
		});


		$(".complemento").each(function(index) {

			
					console.log($(this).attr('id'));
					var id=$(this).attr('id').split('_')[1];
					complementos.push(id);
 

		});

		$(".topes").each(function(){

		var valort=$(this).val();
		topessecundarios.push(valort);

		});

		 var preciospaquete=[];
		$(".preciospaquete").each(function(index) {
			
			var id=$(this).attr('id').split('_')[1];

			var valor=$(this).val();

			if (valor=='') {
				valor=0;
			}
			var objeto=id+'_'+valor;

			preciospaquete.push(objeto);

		});
	
		$(".subtotal").each(function(index) {
			console.log($(this).val());
			subtotalinsumo.push($(this).val());
		});

		var paquetesvinculados=[];


		$(".paquetevinculado").each(function(index) {

			var idpaquetesv=$(this).attr('id');


			if ($('#'+idpaquetesv).is(':checked')) {

				var idpaquetesv=$(this).attr('id');
				var dividir=idpaquetesv.split('_');
				paquetesvinculados.push(dividir[1]);
			}
			
		});


		var siniva=$("#checkediva").val();
		var valido=0;
		if (siniva==1) {

			var iva=$("#iva").val();

			if (iva>0) {
				valido=1;
			}

		}else{

			valido=1;
		}



		if (v_insumostabla>0 && valido==1) {

			if (confirm("\u00BFDesea realizar esta operaci\u00f3n?")) {




				var v_nombre = $('#v_nombre').val();
				var v_descripcion = $('#v_descripcion').val();
				var precionormal = $("#preciouno").val();

				var idcategoria=$("#v_categoria").val();
				var v_descuento = 0;
				var v_estatus = $('#v_estatus').val();
				var VALIDACION = $('#validacion').val();
				var precioventa=$("#precioventa").val();
				var categoria_producto=$("#v_categoriaprecios").val();

				var conpromo=$("#conpromo").val();
				var confecha=$("#confecha").val();
				var directo=$("#directo").val();

				var fechainicial=$("#fechainicial").val();
				var fechafinal=$("#fechafinal").val();

				var cantidadcobrar=$("#cantidadcobrar").val();
				var cantidadaconsiderar=$("#cantidadaconsiderar").val();
				var servicio=$("#servicio").val();

				var repetitivo=$("#repetitivo").val();
				var lunes=$("#lunes").val();
				var martes=$("#martes").val();
				var miercoles=$("#miercoles").val();
				var jueves=$("#jueves").val();
				var viernes=$("#viernes").val();
				var sabado=$("#sabado").val();
				var domingo=$("#domingo").val();
				var preciofijo=$("#preciofijo").val();

				var horainicio=$("#horainicio").val();
				var horafin=$("#horafin").val();

				var orden=$("#v_orden").val();
				var activarcomentario=$("#v_activarcomentario").val();
				var siniva=$("#checkediva").val();
				var iva=$("#iva").val();
				var mensajev=$("#mensajev").val();

				var id = $('#id').val();
				console.log(id);

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

		//datos generales
		data.append('v_nombre', v_nombre);
		data.append('v_descripcion', v_descripcion);
		data.append('preciounitario',precionormal);
		data.append('v_descuento', v_descuento);
		data.append('v_estatus', v_estatus);
		data.append('VALIDACION', VALIDACION);
		data.append('precioventa',precioventa);

		data.append('id', id);
		data.append('idproductos',idproductos);
		data.append('cantidades',cantidadinsumo);
		data.append('insumomedidas',insumomedida);
		data.append('insumototalmedidas',insumosubtotalmedida);
		data.append('precioinsumos',precioinsumo);
		data.append('subtotalinsumos',subtotalinsumo);
		data.append('categoria_producto',categoria_producto);
		data.append('idcategoria',idcategoria);

		data.append('complementos',complementos);

		data.append('conpromo',conpromo);
		data.append('confecha',confecha);
		data.append('directo',directo);
		data.append('fechainicial',fechainicial);
		data.append('fechafinal',fechafinal);
		data.append('cantidadcobrar',cantidadcobrar);
		data.append('cantidadaconsiderar',cantidadaconsiderar);
		data.append('servicio',servicio);

		data.append('repetitivo',repetitivo);
		data.append('lunes',lunes);
		data.append('martes',martes);
		data.append('miercoles',miercoles);
		data.append('jueves',jueves);
		data.append('viernes',viernes);
		data.append('sabado',sabado);
		data.append('domingo',domingo);
		data.append('preciofijo',preciofijo);
		data.append('preciospaquete',preciospaquete);
		data.append('topessecundarios',topessecundarios);
		data.append('horainicio',horainicio);
		data.append('horafin',horafin);
		data.append('orden',orden);
		data.append('activarcomentario',activarcomentario);
		data.append('siniva',siniva);
		data.append('iva',iva);
		data.append('paquetesvinculados',paquetesvinculados);
		data.append('mensajev',mensajev);
		
		


		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')



		setTimeout(function () {
			$.ajax({
				url: 'catalogos/paquetes/ga_paquetes.php', //Url a donde la enviaremos
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
						if (msj == 1) {


							if (id==0) {

								if(confirm("¿Desea agregar otro producto?"))
									{

										regresar='catalogos/productos/fa_productos.php'
										var URL = regresar + "?idmenumodulo=" + idmenu + "&ac=1&msj=Operacion realizada con exito";
										aparecermodulos(URL, donde);

									}else{

										var URL = regresar + "?idmenumodulo=" + idmenu + "&ac=1&msj=Operacion realizada con exito";
										aparecermodulos(URL, donde);

									}
							}else{

								var URL = regresar + "?idmenumodulo=" + idmenu + "&ac=1&msj=Operacion realizada con exito";
										aparecermodulos(URL, donde);
								
							}

							
							} else {
								aparecermodulos(regresar + "?idmenumodulo=" + idmenu + "&ac=0&msj=Error. " + msj, donde);
							}
						}
					});
			}, 1000);

		}
	}else{
		var mensaje="";

		if (v_insumostabla==0) {

			mensaje+=`AGREGA MÍNIMO UN PRODUCTO AL PAQUETE`+`<br>`;

		}

		if (valido==0) {


			mensaje+=`COLOCAR UN MONTO EN EL CAMPO IVA `+`<br`;
		}
		AbrirNotificacion(mensaje,"mdi-checkbox-marked-circle");

	}

}

function AgregarNuevoGrupo() {
	localStorage.setItem('contador',0);

	$("#modalgrupo").modal();


}


function AgregarOpciones(){
	obtenerdiv=$("#opciones").html();

	valorseleccion=$("input[name=seleccionmultiple]:checked").val();

	valorcosto=$("input[name=costoadicional]:checked").val();



	contadoropciondegrupo=parseFloat($(".opciondegrupo").length)+1;
	tabindex=parseFloat(6)+parseFloat(contadoropciondegrupo);

	var html=`
	<form class="opciondegrupoform">
		<div class="form-row opciondegrupo" id="contador`+contadoropciondegrupo+`">
			
			
			
			<div class="col-md-5">
			<label>TÍTULO DE OPCÍON</label>
			<input type="text" class="form-control opciontitulo" tabindex="`+tabindex+`"  placeholder="">
			</div>
			<div class="col-md-5 costoinput">
			<label>COSTO</label>

			<input type="number" class="form-control costoopcion" tabindex="`+(tabindex+1)+`"  placeholder="$">
			</div>

			<div class="col-md-1">
			<button type="button" id="buttoneliminaropcion" style="margin-top: 2em;"  onclick="EliminarOpcion(`+contadoropciondegrupo+`)" class="btn btn_rojo"><i class="mdi mdi-delete-empty"></i></button>
			</div>
		</div>
	</form>

	`;

	colocarhtml=obtenerdiv+html;


	


	$("#opciones").append(html);
	if (valorcosto==0) {


		$(".costoinput").css('display','none');
	}

}

function AgregarGrupo() {

	contador=parseFloat($(".agregaopcion").length)+1


	var titulo=$("#nombregrupo").val();
	var valorseleccion=$("input[name=seleccionmultiple]:checked").val();
	var valorcosto=$("input[name=costoadicional]:checked").val();

	var opcion=[];
	var costo=[];
	$(".opciontitulo").each(function(){

		var valor=$(this).val();
		opcion.push(valor);

	});

	$(".costoopcion").each(function(){
		var valor=$(this).val();
		costo.push(valor);

	});


	const objeto={
		contador:contador,
		nombretitulo:titulo,
		valorseleccion:valorseleccion,
		valorcosto:valorcosto,
		opcion:opcion,
		costo:costo

	};


		let grupos;

	  	grupos = obtenerGruposLocalStorage();

	  	console.log(grupos);
	  	var encontrado=0;

	  	if (grupos.length==null || grupos.length>0) {
	  

	  		guardarGruposLocalStorage(objeto);
	  		
	  		$("#nombregrupo").val('');
	  		$(".opciondegrupoform").remove('');
	  		$("#modalgrupo").modal('hide');

	  		//leerLocalStorage();

	  	}


	  		

}
function EliminarOpcion(contador) {
	

	$("#contador"+contador).remove();
}

function guardarGruposLocalStorage(grupo){

	
	console.log('entro a guardar cariito');
	let grupos;

	grupos = obtenerGruposLocalStorage();
	grupos.push(grupo);


    //curso seleccionado se agrega al arreglo vacio o al final de los elementos existentes
    
    localStorage.setItem('carritogrupo', JSON.stringify(grupos))

    console.log(JSON.parse(localStorage.getItem('carritogrupo')));



}

function obtenerGruposLocalStorage() {
	let grupos;

	console.log(localStorage.getItem('carritogrupo'));
    //comprobar si hay algo en localSotrage
    if(localStorage.getItem('carritogrupo')===null){
    	grupos = [];
    }else{

    	grupos = JSON.parse(localStorage.getItem('carritogrupo'));
    }

    
    return grupos;
}


function leerLocalStorage() {

	console.log('entro leer carrito');
	let grupoLS;

	grupoLS = obtenerGruposLocalStorage();

	console.log(grupoLS);
	var html ='';

	var contador=grupoLS.length;
	var suma=0;
	console.log('contador'+contador);
	/*if(contador>0) {
		grupoLS.forEach(function (grupo) {
        //construir template


        html+=`

       	<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								`+grupo.nombretitulo+`
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<strong>This is the first item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
							</div>
						</div>
					</div>


        `;

   	






    });

		
		

	}else{


		html+=`<div class="card card-outline">
		<div class="card-header"></div>
		<div class="card-content card-content-padding">
		NO CONTIENE GRUPOS

		</div>
		</div>`;
		


	}

	$(".accordionExample").html(html);
*/
}


function contadormenos(idproducto) {
	
	valor=parseInt($("#insumo_"+idproducto).val(),10);

	valor=valor-1;

	if(!isNaN(valor)){

		if(valor >= 0){
			$("#insumo_"+idproducto).val(valor);
		}

	}else{

		$("#insumo_"+idproducto).val(0);
	}


}
function contadormas(idproducto) {
	
	var valor = parseInt($("#insumo_"+idproducto).val(),10);
	
	if(!isNaN(valor)){

		$("#insumo_"+idproducto).val(valor+1);


	}else{
		$("#insumo_"+idproducto).val(0);
	}

}

function contadormenos2(idproducto) {
	
	valor=parseInt($("#cantidadpro_"+idproducto).val(),10);


	valor=valor-1;

	if(!isNaN(valor)){

		if(valor > 0){
			$("#cantidadpro_"+idproducto).val(valor);
			RestarProducto(idproducto);

		}else{

			RestarProducto(idproducto);

			
		}
	}else{

		$("#cantidadpro_"+idproducto).val(0);
	}


}
function contadormas2(idproducto) {	
	
	var valor = parseInt($("#cantidadpro_"+idproducto).val(),10);
	
	if(!isNaN(valor)){

		$("#cantidadpro_"+idproducto).val(valor+1);

		SumarProducto(idproducto);

	}else{
		$("#cantidadpro_"+idproducto).val(0);
	
	}

}

function contadormenoscomplemento(idcomple) {
	
	valor=parseInt($("#complemento_"+idcomple).val(),10);

	valor=valor-1;

	if(!isNaN(valor)){

		if(valor >= 0){
			$("#complemento_"+idcomple).val(valor);
		}

	}else{

		$("#complemento_"+idcomple).val(0);
	}


}
function contadormascomplemento(idcomple) {
	
	var valor = parseInt($("#complemento_"+idcomple).val(),10);
	
	if(!isNaN(valor)){

		$("#complemento_"+idcomple).val(valor+1);


	}else{
		$("#complemento_"+idcomple).val(0);
	}

}

function AgregarAproducto2(idproducto) {
	
	var cantidad=1;
	var empresa=$("#v_empresa").val();

	var datos="empresa="+empresa+"&insumo="+idproducto+"&cantidad="+cantidad;


		$.ajax({
			url: 'catalogos/paquetes/agregar.php', //Url a donde la enviaremos
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

function RestarProducto(idproducto) {

	var cantidad=-1;
	var empresa=$("#v_empresa").val();

	var datos="empresa="+empresa+"&insumo="+idproducto+"&cantidad="+cantidad;



		$.ajax({
			url: 'catalogos/productos/restar.php', //Url a donde la enviaremos
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

function SumarProducto(idproducto) {

	var cantidad=1;
	var empresa=$("#v_empresa").val();

	var datos="empresa="+empresa+"&insumo="+idproducto+"&cantidad="+cantidad;



		$.ajax({
			url: 'catalogos/productos/sumar.php', //Url a donde la enviaremos
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


function ObtenerOpcionesdelPaquete(idpaquete) {

	var datos="idpaquete="+idpaquete;

	$.ajax({
			url: 'catalogos/paquetes/obtenercomplementos.php', //Url a donde la enviaremos
			type: 'GET', //Metodo que usaremos
			data: datos, //Le pasamos el objeto que creamos con los archivos
			dataType:'json',
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				var error;
				console.log(XMLHttpRequest);
				if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
				if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
				$("#contenedor_empresas").html(error);
			},
			success: function (msj) {
				
				var complementos=msj.complementos;
				if (complementos.length>0) {

					for (var i = 1; i <complementos.length; i++) {
						
						$("#sele_"+complementos[i].idgrupo).prop('checked',true);
					}
				}

			}
		});
}

function BuscarComplemento() {

	var valor=$("#FiltrarContenido2").val();
	var idcategoriaprecios=$("#v_categoriaprecios").val();


	var datos="busqueda="+valor;
	$('#cargarcomplementos').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>')

	setTimeout(function () {
		$.ajax({
					url: 'catalogos/paquetes/li_complementos.php', //Url a donde la enviaremos
					type: 'GET', //Metodo que usaremos
					data:datos,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#contenedor_insumos").html(error);
					},	
					success: function (msj) {

						$("#cargarcomplementos").html(msj);
					}
				});

	}, 100);
}

function AgregarComplemento(idgrupo) {

	var cantidad=$("#complemento_"+idgrupo).val();

	var datos="idgrupo="+idgrupo+"&cantidad="+cantidad;

			$.ajax({
					url: 'catalogos/paquetes/agregarcomplemento.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						$("#complementosagregados").html(msj);
					}
				});
}

function EliminarComplemento(variable) {


	var datos="variable="+variable;

	$.ajax({
					url: 'catalogos/paquetes/eliminarcomplemento.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {

						$("#complementosagregados").html(msj);
					}
				});

}

function BorrarDatosPaquete(idpaquete,idmenumodulo) {

	var datos="idpaquete="+idpaquete;

	if (confirm("\u00BFDesea realizar esta operaci\u00f3n?")) {

	
	$.ajax({
					url: 'catalogos/paquetes/eliminarpaquete.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {
						var archivo_vizualizar="catalogos/paquetes/vi_paquetes.php";
						var	donde_mostrar="main";
						if (msj==1) {
							
							aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmenumodulo+"&ac=1&msj=Registro borrado con exito",donde_mostrar);

						}else{

						aparecermodulos(archivo_vizualizar+"?idmenumodulo="+idmenumodulo+"&ac=0&msj="+msj,donde_mostrar);
		
						}
					}
				});

	}
}

function Habilitarpromo() {
	
	if($("#conpromo").is(':checked')){

		$("#conpromo").val(1);
		$("#promociondiv").css('display','block');
		$("#opcionesdepromocion").css('display','block');
		$("#vincularpaquete").css('display','block');
	}else{

		$("#promociondiv").css('display','none');
		$("#opcionesdepromocion").css('display','none');
		$("#conpromo").val(0);
		$("#vincularpaquete").css('display','none');

	}
}

function Promo() {

	if ($("#confecha").is(':checked')) {
		$("#confecha").val(1);
		$("#directo").val(0);
		$("#repetitivo").val(0);
		$("#todosdias").prop('checked',false);
		SeleccionarTodos();
	}


	if ($("#repetitivo").is(':checked')) {

		$("#repetitivo").val(1);
		$("#confecha").val(0);
		$("#directo").val(0);
		$("#fechainicial").val('');
		$("#fechafinal").val('');
	}

	if ($("#directo").is(':checked')) {

		$("#repetitivo").val(0);
		$("#confecha").val(0);
		$("#directo").val(1);
		$("#fechainicial").val('');
		$("#fechafinal").val('');

		$("#todosdias").prop('checked',false);
		SeleccionarTodos();

	}
	

}

function Habilitarservicio() {
	
	if ($("#servicio").is(':checked')) {

		$("#servicio").val(1);

	}else{

		$("#servicio").val(0);
	
	}
}


function Habilitarcomentario() {
	
	if ($("#v_activarcomentario").is(':checked')) {

		$("#v_activarcomentario").val(1);

	}else{

		$("#v_activarcomentario").val(0);
	
	}
}

function ObtenerPrecios() {
	
	$.ajax({
					url: 'catalogos/paquetes/obtenerprecios.php', //Url a donde la enviaremos
					type: 'GET', //Metodo que usaremos
					dataType:'json',
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {

						console.log(msj);
						var precios=msj.precios;
						PintarPrecio(precios);
						
					}
				});
}

function PintarPrecio(precios) {
	var html='';
	
		if (precios.length>0) {

			html+=`<option value="0">SELECCIONAR PRECIO</option>`;

			for (var i = 0; i <precios.length; i++) {
				
				html+=`<option value="`+precios[i].idprecio+`">`+precios[i].precio+`</option>`;
			}

		}else{

			html+=`<option value="0">SELECCIONAR PRECIO</option>`;

		}

		$("#v_precio").html(html);

	}

function SeleccionarTodos() {
	if ($("#todosdias").is(':checked')) {

		$("#lunes").val(1);
		$("#martes").val(1);
		$("#miercoles").val(1);
		$("#jueves").val(1);
		$("#viernes").val(1);
		$("#sabado").val(1);
		$("#domingo").val(1);


		$("#lunes").prop('checked',true);
		$("#martes").prop('checked',true);
		$("#miercoles").prop('checked',true);
		$("#jueves").prop('checked',true);
		$("#viernes").prop('checked',true);
		$("#sabado").prop('checked',true);
		$("#domingo").prop('checked',true);
	}else{

		

		$("#lunes").prop('checked',false);
		$("#martes").prop('checked',false);
		$("#miercoles").prop('checked',false);
		$("#jueves").prop('checked',false);
		$("#viernes").prop('checked',false);
		$("#sabado").prop('checked',false);
		$("#domingo").prop('checked',false);

		$("#lunes").val(0);
		$("#martes").val(0);
		$("#miercoles").val(0);
		$("#jueves").val(0);
		$("#viernes").val(0);
		$("#sabado").val(0);
		$("#domingo").val(0);
	}
}

function Seleccionchek(id) {

		if ($("#"+id).is(':checked')) {

			$("#"+id).val(1);
			$("#"+id).prop('checked',true);	
		}else{
			$("#"+id).val(0);
			$("#"+id).prop('checked',false);
		}

		

	
}

function AbrirModalPrecios(idpaquete) {
	
			
			if (idpaquete>0) {


			}
		$("#Modalprecios").modal();


}


function ObtenerTablaprecios() {


	$.ajax({
					url: 'catalogos/paquetes/obtenerprecios.php', //Url a donde la enviaremos
					type: 'GET', //Metodo que usaremos
					dataType:'json',
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {

						console.log(msj);
						var precios=msj.precios;
						
						
				


				var html=`<table class="table">
						  <thead>
						   
						  </thead>
						  <tbody>`;
						  

	
					if (precios.length>0) {


						for (var i = 0; i <precios.length; i++) {
							var htmlicon="";
							html+=` <tr>
						      <th scope="row">`+precios[i].precio+`</th>
						      <td> <input type="number" class="form-control preciospaquete"  id="precio_`+precios[i].idprecio+`"> </td>
						     `;

						     	if (precios[i].principal==1) {

						     		htmlicon=`<span><i class="mdi mdi-checkbox-marked"></i><span>`;
						     		}

						    html+=`

						      <td>`+htmlicon+`</td>
						      <td></td>
						    </tr>`;

							
						}

					}else{

						html+=` <tr>
							      <th scope="row">NO SE ENCONTARON PRECIOS</th>
							     
							    </tr>`;

					}


					  html+=`</tbody>
				        	</table>`;



					$("#Colocarbody").html(html);


					}
				});

}

function ObtenerPreciosPaquete(idpaquete) {

		var datos="idpaquete="+idpaquete
	
			$.ajax({
					url: 'catalogos/paquetes/obtenerpreciospaquete.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					data:datos,
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {

					console.log(msj);

					var preciospaquete=msj.preciospaquete;

					if (preciospaquete.length>0) {

						for (var i = 0; i <preciospaquete.length; i++) {
							

							$("#precio_"+preciospaquete[i].idprecio).val(preciospaquete[i].precio);
						}
					}
						
				}
		});
}

function Precioprincipal(idpaquete) {
		var datos="idpaquete="+idpaquete
	
			$.ajax({
					url: 'catalogos/paquetes/obtenerprecioprincipal.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					dataType:'json',
					data:datos,
					async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#complementosagregados").html(error);
					},	
					success: function (msj) {

					var preciospaquete=msj.precioprincipal;

					$("#verprecio").css('display','block');

					$("#precioprincipal").text(preciospaquete.precio);	
				}
		});
}

function CambiarTope(posicion,tope) {
	

	var valor=$("#comple_"+posicion).val();

	if (valor<=tope) {
	var datos="posicion="+posicion+"&valor="+valor;

	$.ajax({
					url: 'catalogos/grupo/cambiarvalortope.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

					$("#complementosagregados").html(msj);


					}
				});
		}else{

			$("#comple_"+posicion).val(tope);

			AbrirNotificacion('El tope excede al que se encuentra en la configuración del complemento',"mdi-checkbox-marked-circle");
		}
}

function ObtenerOrden() {

	var categoria=$("#v_categoria").val();
	var datos="categoria="+categoria;

	$.ajax({
			url: 'catalogos/paquetes/ObtenerOrdenporCategoria.php', //Url a donde la enviaremos
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

						var odenamiento=parseFloat(msj.orden)+parseFloat(1);
						$("#v_orden").val(msj.orden);

					}
				});
}

function Subirimagenpaquete(idpaquete) {
	
	$("#idpaquete").val(idpaquete);
	showAttachedFilesPaquetes(idpaquete);
	$("#modalimagenpaquete").modal();
}


function ObtenerPaquetesSinpomocion() {
		

	$.ajax({
			url: 'catalogos/paquetes/ObtenerPaquetesSinpomocion.php', //Url a donde la enviaremos
			type: 'POST', //Metodo que usaremos
			dataType:'json',
			async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						var respuesta=msj.respuesta;
						PintarPaquetes(respuesta);

					}
				});
}

function PintarPaquetes(respuesta) {

	var html='';
	if (respuesta.length>0) {

		html+=`<div class="row">
						<div class="col-md-4"></div>
						  <div class="col-md-3">
						  		<label>Todos</label>	
						  </div>
						  <div class="col-md-2">
						  	<input type="checkbox" class="paquetevinculado" name="" id="paquetevinculado_0" onchange="SeleccionarPaquetevinculado(0)"></div>
						 
						</div>`;
		for (var i = 0; i <respuesta.length; i++) {
			html+=`

			<div class="row">
						<div class="col-md-4"></div>
						  <div class="col-md-3">
						  		<label>`+respuesta[i].nombrepaquete+`</label>	
						  </div>
						  <div class="col-md-2">
						  	<input type="checkbox" class="paquetevinculado" name="" id="paquetevinculado_`+respuesta[i].idpaquete+`" onchange="SeleccionarPaquetevinculado(`+respuesta[i].idpaquete+`)"></div>
						 
						</div>


			`;

		}
	}else{

		html+=`<div class="row">
						<div class="col-md-4"></div>
						  <div class="col-md-2">
						  		<label>NO SE ENCONTRARON PAQUETES</label>	
						  </div>
						  <div class="col-md-2">
						 
						</div>`;


	}


	$("#paquetesnopromocion").html(html);
}

function SeleccionarPaquetevinculado(idpaquete) {

	if ($("#paquetevinculado_0").is(':checked')) {

		if (idpaquete==0) {

		$(".paquetevinculado").attr('checked',true);
		}

	}else{

		if (idpaquete==0) {

			$(".paquetevinculado").attr('checked',false);
		}
	}


	if (idpaquete!=0) {

		if($("#paquetevinculado_"+idpaquete).is(':checked')){

			$("#paquetevinculado_"+idpaquete).attr('checked',true);

		}else{

			$("#paquetevinculado_"+idpaquete).attr('checked',false);
	
		}

	}
	
}
function ObtenerPaquetesVinculados(idpaquete) {

		var datos='idpaquete='+idpaquete;
	
	$.ajax({
			url: 'catalogos/paquetes/ObtenerVinculados.php', //Url a donde la enviaremos
			type: 'POST', //Metodo que usaremos
			dataType:'json',
			data:datos,
			async:false,
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						var error;
						console.log(XMLHttpRequest);
						if (XMLHttpRequest.status === 404) error = "Pagina no existe" + XMLHttpRequest.status; // display some page not found error 
						if (XMLHttpRequest.status === 500) error = "Error del Servidor" + XMLHttpRequest.status; // display some server error 
						$("#divcomplementos").html(error);
					},	
					success: function (msj) {

						var respuesta=msj.respuesta;
						ColocarVinculados(respuesta);

					}
				});
}

function ColocarVinculados(respuesta) {
	if (respuesta.length>0) {

		for (var i = 0; i < respuesta.length; i++) {
			$("#paquetevinculado_"+respuesta[i].idpaquete).attr('checked',true);
		}

		if (($(".paquetevinculado").length-1) == respuesta.length) {

			$("#paquetevinculado_0").attr('checked',true);
		}
	}
}

function ColocarIva() {
	if ($("#checkediva").is(':checked')) {

		$("#checkediva").val(1);
	}else{
		$("#checkediva").val(0);
	}
}
