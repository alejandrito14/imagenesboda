function Buscar_Cupones(idmenu) {

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
			url: 'catalogos/cupones/li_cupones.php', //Url a donde la enviaremos
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


function GuardarCupon(form,regresar,donde,idmenumodulo,idcupon)
{
    //alert("idmenumodulo: " + idmenumodulo);
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var codigo =$("#v_codigo").val();
		var tipodescuento=$("#v_tipodescuento").val();
		var descuento=$("#v_descuento").val();
		var limiteusos=$("#v_limiteusos").val();
		var sucursal=$("#v_sucursal").val();
		var estatus=$("#v_estatus").val();
        var fechainicial=$("#v_fechainicial").val();
        var fechafinal= $("#v_fechafinal").val();
        var horainicial=$("#v_horainicial").val();
        var horafinal= $("#v_horafinal").val();
		var montocompra= $("#v_montocompra").val();
		var cantidadcompra= $("#v_cantidadcompra").val();
		var secuenciaventa= $("#v_secuenciaventa").val();
		var lusocliente= $("#v_lusocliente").val();
		var lusosucursal= $("#v_lusosucursal").val();
		var lusodia= $("#v_lusodia").val();
		var lusototal= $("#v_lusototal").val();
		
		var aplicarsobrepromo=0
		if ($("#v_aplicarsobrepromo").is(':checked'))
			 aplicarsobrepromo=1;

		var tsucursales=0
		if ($("#v_tsucursales").is(':checked'))
		    tsucursales=1;

		var arraysucursales=[];
		$(".chksucursal_"+idcupon).each(function(){
			var id=$(this).attr('id');
			if ($("#"+id).is(':checked')) {
				var separar=id.split('_')[1];
				arraysucursales.push(separar);
			}
		});

		var tpaquetes=0
		if ($("#v_tpaquetes").is(':checked'))
		    tpaquetes=1;

		var arraypaquetes=[];
		$(".chkpaquete_"+idcupon).each(function(){
			var id=$(this).attr('id');
			if ($("#"+id).is(':checked')) {
				var separar=id.split('_')[1];
				arraypaquetes.push(separar);
			}
		});

		var tclientes=0
		if ($("#v_tclientes").is(':checked'))
		    tclientes=1;

		var arrayclientes=[];
		$(".chkcliente_"+idcupon).each(function(){
			var id=$(this).attr('id');
			if ($("#"+id).is(':checked')) {
				var separar=id.split('_')[1];
				arrayclientes.push(separar);
			}
		});
		

		var id=$("#id").val();
		var data = new FormData();

		//var archivos = document.getElementById("image"); //Damos el valor del input tipo file
		//var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
		//console.log(archivo);

		//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
		//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
		//que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
		//for (i = 0; i < archivo.length; i++) {
		//	data.append('archivo' + i, archivo[i]);
		//}
        
		data.append('v_codigo',codigo);
		data.append('v_tipodescuento',tipodescuento);
		data.append('v_descuento',descuento);
		data.append('v_limiteusos',limiteusos);
		data.append('v_sucursal',sucursal);
		data.append('id',id);
		data.append('v_estatus',estatus);
		data.append('v_fechainicial', fechainicial);
		data.append('v_fechafinal', fechafinal);
		data.append('v_horainicial', horainicial);
		data.append('v_horafinal', horafinal);
		data.append('v_montocompra', montocompra);
		data.append('v_cantidadcompra', cantidadcompra);
		data.append('v_secuenciaventa', secuenciaventa);
		data.append('v_lusocliente', lusocliente);
		data.append('v_lusodia', lusodia);
		data.append('v_lusosucursal', lusosucursal);	
		data.append('v_lusototal', lusototal);
		data.append('v_tsucursales', tsucursales);
		data.append('v_aplicarsobrepromo', aplicarsobrepromo);
		data.append('v_estatus', estatus);
		data.append('v_sucursales', JSON.stringify(arraysucursales));
		data.append('v_tpaquetes', tpaquetes);
		data.append('v_paquetes', JSON.stringify(arraypaquetes));
		data.append('v_tclientes', tclientes);
		data.append('v_clientes', JSON.stringify(arrayclientes));
		//alert("hola");
		//alert("horainicial" + horainicial + " horafinal: " + horafinal);
	
		// $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					  url:'catalogos/cupones/ga_cupones.php', //Url a donde la enviaremos
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
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito",donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });				  					  
		},1000);
	 }
}

function HabilitarDeshabilitarCheck(divid) {	
	if($(divid).css('display') == 'none'){
		$(divid).css('display','block');
	}else{
		$(divid).css('display','none');
	}
}

function BuscarEnLista(idbuscador,clista) {

		var buscador=$(idbuscador).val().toLowerCase();
		//var datos="idsucursal="+idsucursal+"&buscador="+buscador;
	
		$(clista).each(function(){
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

function BuscarEnListaBAK(idbuscador,idlista,idsucursal) {

		var buscador=$(idbuscador+idsucursal).val().toLowerCase();
		var datos="idsucursal="+idsucursal+"&buscador="+buscador;
	
		$(idlista+idsucursal).each(function(){
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

function validateFormBAK(idmodulo) {
		'use strict'

		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.querySelectorAll('.needs-validation')
	  
		// Loop over them and prevent submission
		Array.prototype.slice.call(forms)
		  .forEach(function (form) {
			form.addEventListener('submit', function (event) {
			  if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
				var resp=MM_validateForm('v_codigo','','R','v_descuento','','R');				 
			  }
			  else{
				event.preventDefault();
				event.stopPropagation();
				var resp=MM_validateForm('v_codigo','','R','v_descuento','','R'); 
				if(resp==1){ 
					GuardarCupon('f_cupon','catalogos/cupones/vi_cupones.php','main',idmodulo,'0');
				}
			  }
			  form.classList.add('was-validated')
			}, false)
		  })
}

function validateForm(){
	'use strict';
	
	  // fetch all the forms we want to apply custom style
	var inputs = document.getElementsByClassName('form-control')
	/*
	var inputsmax  = document.querySelectorAll("[maxlength]")
	var maxval = Array.prototype.filter.call(inputsmax, function(inputmax) {
		inputmax.addEventListener('keyup', function (event) {
		    //var max = inputmax.maxLength
			//inputmax.value = inputmax.value.substring(0,max)
		})
	})*/
	
	// loop over each input and watch blur event
	var validation = Array.prototype.filter.call(inputs, function(input) {
		input.addEventListener('input', function(event) {
		  // reset
		  input.classList.remove('is-invalid')
		  input.classList.remove('is-valid')
  
		  if (input.checkValidity() === false) {
			  input.classList.add('is-invalid')
			  //input.addEventListener('input', function(){
			//	  input.value = 'VIVAMEXICO'
		//		  input.checkValidity()}, true)			 
			}	
		  else {
			  input.classList.add('is-valid') 
		  }
		}, false)
	  })
}

function getCode(){
	$("#btnCodeGen").click(function (e) {
		$.post("catalogos/cupones/xs_cupones.php",
		{
			fname: "getCode",
		})
		.done(function (result, status, xhr) {
			var input = $("#v_codigo");
			input.val(result)
			input.addClass('is-valid');
			input.removeClass('is-invalid')
		})
		.fail(function (xhr, status, error) {
			var form = $("#f_cupon").first();
			let field = form.find('[name="' + "v_codigo" + '"]');
            field.addClass("is-invalid");
            var immediateSibling = field.next();
			immediateSibling = immediateSibling.next();
            if (immediateSibling.hasClass('invalid-feedback')) {
                immediateSibling.text("Intente de nuevo");
            } else {
                field.after("<div class='invalid-feedback'>" + error + "</div>")
            }
			//$("#message").html("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
		});
	});
	
}

function changeCouponState(){
	var cswitches = document.getElementsByClassName('cuswitch');
	Array.prototype.slice.call(cswitches)
		  .forEach(function (cswitch) {
			cswitch.addEventListener('click', function (event) {
				var btnstate=0;
				var idcupon = cswitch.id.split("_")[1];
				if($('#'+cswitch.id).is(":checked"))
					btnstate=1;

				$.post("catalogos/cupones/xs_cupones.php",
				{
					fname: "changeCouponState",
					state: btnstate,
					id: idcupon,
				})
				.done(function (result, status, xhr) {
					
				})
				.fail(function (xhr, status, error) {
					
				});
			}, false)
		})
	
	//foreach clas switch
	//en id #btnState_idcupon
	$("#btnState").click(function (e) {
		var btnstate=0;
		var idcupon = 0;
		if($("#btnState").is(":checked"))
			btnstate=1;

		$.post("catalogos/cupones/xs_cupones.php",
		{
			fname: "changeCouponState",
			state: btnstate,
			id: idcupon,
		})
		.done(function (result, status, xhr) {
			
		})
		.fail(function (xhr, status, error) {
			
		});
	});
	
}

function selectD(){
$('#v_tipodescuento').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

	if (valueSelected == 0){
		$('#v_descuento').attr("pattern", '^[1-9][0-9]?$|^100$');
		$('#v_descuento').attr("placeholder", "%");
		var text = $('#inf_descuento').text();
		$('#inf_descuento').text("Ingresa un numero entero del 1 al 100. Ejemplo: 15");
	}
	else{
		$('#v_descuento').attr("pattern", '^([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$');
		$('#v_descuento').attr("placeholder", "$");
		$('#inf_descuento').text("Ingresa un monto entero o decimal con dos digitos. Ejemplos: 100 | 100.50 ");
	}
});

}



function changeCouponState2(){
	var cswitches = document.getElementsByClassName('cuswitch2');
	Array.prototype.slice.call(cswitches)
		  .forEach(function (cswitch) {
			cswitch.addEventListener('click', function (event) {
				var btnstate=0;
				var idcupon = cswitch.id.split("_")[1];
				if($('#'+cswitch.id).is(":checked"))
					btnstate=1;

				$.post("catalogos/cupones/xs_cupones.php",
				{
					fname: "changeCouponState2",
					state: btnstate,
					id: idcupon,
				})
				.done(function (result, status, xhr) {
					
				})
				.fail(function (xhr, status, error) {
					
				});
			}, false)
		})
	
	//foreach clas switch
	//en id #btnState_idcupon
/*	$("#btnautomatico").click(function (e) {
		var btnstate1=0;
		var idcupon = 0;
		if($("#btnautomatico").is(":checked"))
			btnstate1=1;

		$.post("catalogos/cupones/xs_cupones.php",
		{
			fname: "changeCouponState2",
			state: btnstate1,
			id: idcupon,
		})
		.done(function (result, status, xhr) {
			
		})
		.fail(function (xhr, status, error) {
			
		});
	});*/
	
}

