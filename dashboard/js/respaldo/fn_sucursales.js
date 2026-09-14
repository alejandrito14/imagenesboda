// JavaScript Document
function Guardar_sucursal(form,donde,regresar,idmenumodulo)
{



	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		//var datos = ObtenerDatosFormulario(form);
		
		//var idempresas = $('#idempresas').val();
		var data = new FormData();

		var archivos = document.getElementById("image"); //Damos el valor del input tipo file
		var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
		console.log(archivo);

		//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
		//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
		//que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
		for (i = 0; i < archivo.length; i++) {
			data.append('archivo', archivo[0]);
		}


		var archivosticke = document.getElementById("imagelogo"); //Damos el valor del input tipo file
		var archivot = archivosticke.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo

		for (i = 0; i < archivot.length; i++) {
			data.append('ticket', archivot[0]);
		}

		var trecordatorio=$("#trecordatorio").val();
		var minutosrecordatorio=$("#minutosrecordatorio").val();
		var mensajeempresa=$("#mensajeempresa").val();
		var mensajecliente=$("#mensajecliente").val();
		var idsucursales=$("#id").val();
		var v_sucursal=$("#v_sucursal").val();
		var v_direccion_sucursal=$("#v_direccion_sucursal").val();
		var v_telefono=$("#v_telefono").val();
		var v_telefono2=$("#v_telefono2").val();
		var v_telefono3=$("#v_telefono3").val();
		var v_telefono4=$("#v_telefono4").val();
		var v_email=$("#v_email").val();
		var v_iva=$("#v_iva").val();
		var v_estatus=$("#v_estatus").val();
		var encabezado=$("#encabezado").val();
		var leyendaticket=$("#leyendaticket").val();
		var tventa=$("#tventa").val();
		var tproduccion=$("#tproduccion").val();
		var datofiscal=0;
		var diasemana=[];
		var horainicio=[];
		var horafin=[];
		var opcionepedido=[];
		var tipodepagos=[];
		$(".diasemana").each(function(){
			var valor=$(this).val();
			diasemana.push(valor);
		});


		$(".horainiciodia").each(function(){
			var valor=$(this).val();
			horainicio.push(valor);

		});


		$(".horafindia").each(function(){
			var valor=$(this).val();
			horafin.push(valor);

		});

		$(".opcionespedido").each(function(){

			if ($(this).is(':checked')) {

				var id=$(this).attr('id');
				var dividir=id.split('_')[1];
				opcionepedido.push(dividir);

			}

		});


		$(".tipodepagos").each(function(){

			if ($(this).is(':checked')) {

				var id=$(this).attr('id');
				var dividir=id.split('_')[1];
				tipodepagos.push(dividir);

			}

		});

		$(".datosfiscales").each(function(){

			if ($(this).is(':checked')) {

				var id=$(this).attr('id');
				 datofiscal=id.split('_')[1];

			}

		});
		var tventa=0;
		if ($("#tventa").is(':checked')) {
			tventa=1;
		}

		var tproduccion=0;
		if ($("#tproduccion").is(':checked')) {
			tproduccion=1;
		}
		

		
		var colonia=$("#v_colonia").val();
		var v_pais=$("#v_pais").val();
		var v_estado=$("#v_estado").val();
		var v_municipio=$("#v_municipio").val();
		var codigopostal=$("#v_codigopostal").val();
	/*	var horainicio=$("#horainicio").val();
		var horafin=$("#horafin").val();*/
		var minutosconsiderados=$("#minutosconsiderados").val();
		var solicitarfactura=$("#solicitarfactura").val();
		var habilitarcampomontofactura=$("#habilitarcampomontofactura").val();
		var orden=$("#v_orden").val();
		var notaventa=$("#notaventa").val();
		data.append('idsucursales', idsucursales);
		data.append('v_sucursal', v_sucursal);
		data.append('v_direccion_sucursal', v_direccion_sucursal);
		data.append('v_telefono', v_telefono);
		data.append('v_email', v_email);
		data.append('v_iva', v_iva);
		data.append('v_estatus', v_estatus);
		data.append('v_pais',v_pais);
		data.append('v_estado',v_estado);
		data.append('v_municipio',v_municipio);
	/*	data.append('horainicio',horainicio);
		data.append('horafin',horafin);*/
		data.append('minutosconsiderados',minutosconsiderados);
		data.append('solicitarfactura',solicitarfactura);
		data.append('orden',orden);
		data.append('diasemana',diasemana);
		data.append('horainiciodia',horainicio);
		data.append('horafindia',horafin);
		data.append('opcionepedido',opcionepedido);
		data.append('datofiscal',datofiscal);
		data.append('v_colonia',colonia);
		data.append('v_telefono2',v_telefono2);
		data.append('v_telefono3',v_telefono3);
		data.append('v_telefono4',v_telefono4);
		data.append('tventa',tventa);
		data.append('tproduccion',tproduccion);
		data.append('encabezado',encabezado);
		data.append('leyendaticket',leyendaticket);
		data.append('codigopostal',codigopostal);
		data.append('trecordatorio',trecordatorio);
		data.append('minutosrecordatorio',minutosrecordatorio);
		data.append('mensajeempresa',mensajeempresa);
		data.append('mensajecliente',mensajecliente);
		data.append('tipodepagos',tipodepagos);
		data.append('habilitarcampomontofactura',habilitarcampomontofactura);
		data.append('notaventa',notaventa);



		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')
				

				$.ajax({
				url:'catalogos/sucursales/ga_sucursales.php', //Url a donde la enviaremos
				type: 'POST', //Metodo que usaremos
				contentType: false, //Debe estar en false para que pase el objeto sin procesar
				data: data, //Le pasamos el objeto que creamos con los archivos
				processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
				cache: false, //Para que el formulario no guarde cache,
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
					  },
					success:function(msj){
						   console.log("El resultado de msj es: "+msj);
							$('#modal-forms').modal('hide');
						
						 	if( msj == 1 ){
								aparecermodulos(donde+"?ac=1&msj=Operacion realizada con exito&idmenumodulo="+idmenumodulo,regresar);
						 	 }else{
								aparecermodulos(donde+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,regresar);
						  	}			
					  	}
				  });				  					  
		
	 }
}

function BorrarSucursal(idsucursal,idmenumodulo) {


	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos ='idempresas='+0+'&idsucursales='+idsucursal;
		
		
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'catalogos/sucursales/ga_borrar.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
					  },
					success:function(msj){
						   console.log("El resultado de msj es: "+msj);
							$('#modal-forms').modal('hide');
							
						
						 	if(msj ==1){
								aparecermodulos("catalogos/sucursales/vi_sucursal.php?ac=1&msj=Operacion realizada con exito&idmenumodulo="+idmenumodulo,"main");
						 	 }else{
						 	 	AbrirNotificacion('NO SE PUDO REALIZAR LA ELIMINACION','');
								aparecermodulos("catalogos/sucursales/vi_sucursal.php?ac=0&msj=Error."+msj,"main");
						  	}			
					  	}
				  });				  					  
		},1000);
	 }
}


function Subirimagensucursal(idsucursal) {
	
	$("#idsucursales").val(idsucursal);
	showAttachedFiles(idsucursal);
	$("#modalimagensucursal").modal();
}

function Habilitarfacturacion() {
	
	if ($("#solicitarfactura").is(':checked')) {

		$("#solicitarfactura").val(1);

	}else{

		$("#solicitarfactura").val(0);
	
	}
}

function AgregarHorario(){

		contadorhorarioatencion=parseFloat($(".horariosatencion").length)+1;

		tabindex=parseFloat(6)+parseFloat(contadorhorarioatencion);


	var html=`
					<div class="row horariosatencion" id="contador`+contadorhorarioatencion+`">
										<div class="col-md-3">
									<label>DIA</label>	

									<select class="form-control diasemana" tabindex="`+tabindex+`">
										<option value="t">SELECCIONAR DIA</option>
										<option value="0">DOMINGO</option>
										<option value="1">LUNES</option>
										<option value="2">MARTES</option>
										<option value="3">MIÉRCOLES</option>
										<option value="4">JUEVES</option>
										<option value="5">VIERNES</option>
										<option value="6">SÁBADO</option>

									</select>
									</div>
									<div class="col-md-4">
									<label>HORA INICIO:</label>
										<div class="form-group mb-2" style="">
											<input type="time"  class="form-control horainiciodia" tabindex="`+(tabindex+1)+`"  >
										</div>

									</div>

								
									<div class="col-md-4">

										<label>HORA FIN:</label>
										<div class="form-group mb-2" style="">
											<input type="time"  class="form-control horafindia" tabindex="`+(tabindex+1)+`" >
										</div>
									</div>
									<div class="col-md-1">
										<button type="button"  style="margin-top: 2em;" onclick="EliminarOpcionHorario(`+contadorhorarioatencion+`)" class="btn btn_rojo"><i class="mdi mdi-delete-empty"></i></button>
									</div>
								</div>

	`;


	$("#horarios").append(html)



}

function EliminarOpcionHorario(contador) {

		$("#contador"+contador).remove();

}

function ObtenerHorariosSemana(idsucursal) {
	var datos="idsucursal="+idsucursal;


		$.ajax({
					url: 'catalogos/sucursales/ObtenerHorariosSemana.php', //Url a donde la enviaremos
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

						var horarios=msj.respuesta;

						if (horarios.length>0) {
							PintarHorariosSemana(horarios);
						}


					}
				});
}

function PintarHorariosSemana(horarios) {

	var html="";
	for (var i = 0; i <horarios.length; i++) {

		obtenerdiv=$("#horarios").html();



	contadorhorarioatencion=parseFloat($(".horariosatencion").length)+1;
	tabindex=parseFloat(6)+parseFloat(contadorhorarioatencion);

	var html=`
					<div class="row horariosatencion" id="contador`+contadorhorarioatencion+`">
										<div class="col-md-3">
									<label>DIA</label>	

									<select class="form-control diasemana" id="diasemana_`+contadorhorarioatencion+`" tabindex="`+tabindex+`">
										<option value="t">SELECCIONAR DIA</option>
										<option value="0">DOMINGO</option>
										<option value="1">LUNES</option>
										<option value="2">MARTES</option>
										<option value="3">MIÉRCOLES</option>
										<option value="4">JUEVES</option>
										<option value="5">VIERNES</option>
										<option value="6">SÁBADO</option>

									</select>
									</div>
									<div class="col-md-4">
									<label>HORA INICIO:</label>
										<div class="form-group mb-2" style="">
											<input type="time" id="horai_`+contadorhorarioatencion+`"  class="form-control horainiciodia" tabindex="`+(tabindex+1)+`"  >
										</div>

									</div>

								
									<div class="col-md-4">

										<label>HORA FIN:</label>
										<div class="form-group mb-2" style="">
											<input type="time" id="horaf_`+contadorhorarioatencion+`" class="form-control horafindia" tabindex="`+(tabindex+1)+`" >
										</div>
									</div>
									<div class="col-md-1">
										<button type="button"  style="margin-top: 2em;" onclick="EliminarOpcionHorario(`+contadorhorarioatencion+`)" class="btn btn_rojo"><i class="mdi mdi-delete-empty"></i></button>
									</div>
								</div>

	`;



	colocarhtml=obtenerdiv+html;


	var diasemana=horarios[i].dia;
	var horai=horarios[i].horainicial;
	var horaf=horarios[i].horafinal;


	$("#horarios").append(html)

	$("#diasemana_"+contadorhorarioatencion).val(diasemana);
	$("#horai_"+contadorhorarioatencion).val(horai);
 	$("#horaf_"+contadorhorarioatencion).val(horaf);
	
		
	}
			
}

function ObtenerOpcionespedido() {

		$.ajax({
					url: 'catalogos/sucursales/ObtenerOpcionespedido.php', //Url a donde la enviaremos
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

						var datos=msj.respuesta;
						PintarOpcionespedido(datos);

					}
				});

	}

	function PintarOpcionespedido(datos) {


		var html="";
		if (datos.length>0) {
		for (var i = 0; i <datos.length; i++) {
			
			html+=`
				<div class="form-check " >
				  <input type="checkbox" class="form-check-input opcionespedido" id="opcionespedido_`+datos[i].idopcionespedido+`" >
				  <label class="form-check-label" for="flexCheckDefault">
							`+datos[i].opcionpedido+`							  
						</label>
					</div>
					`;
		}
	}else{
		html+=`
				<div class="form-check " >
				  <label class="form-check-label" for="flexCheckDefault">
						No se encuentran registradas opciones de pedido.						  

						</label>
					</div>
					`;

	}

		$("#opcionespedidolista").html(html);
	}

	function ObtenerOpcionespedido2(opcion) {

		$.ajax({
					url: 'catalogos/sucursales/ObtenerOpcionespedido.php', //Url a donde la enviaremos
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

						var datos=msj.respuesta;
						PintarOpcionespedido2(datos,opcion);

					}
				});

	}


	function PintarOpcionespedido2(datos,opcion) {

		alert('aq'+opcion);
		var html="";
		if (datos.length>0) {
		for (var i = 0; i <datos.length; i++) {

			var checked="";
			if (opcion==datos[i].idopcionespedido) {
				checked="checked";	
			}
			
			html+=`
				<div class="form-check " >
				  <input type="checkbox" class="form-check-input opcionespedido" id="opcionespedido_`+datos[i].idopcionespedido+`" `+checked+`>
				  <label class="form-check-label" for="flexCheckDefault">
							`+datos[i].opcionpedido+`							  
						</label>
					</div>
					`;
		}
	}else{
		html+=`
				<div class="form-check " >
				  <label class="form-check-label" for="flexCheckDefault">
						No se encuentran registradas opciones de pedido.						  

						</label>
					</div>
					`;

	}

		$("#opcionespedidolista").html(html);
	}

	function ObtenerOpcionespedidoSucursal(idsucursal) {
		var datos="idsucursal="+idsucursal;

		$.ajax({
					url: 'catalogos/sucursales/ObtenerOpcionespedidoSucursal.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
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

					var datos=msj.respuesta;

					ColocarCheckopcionespedido(datos);

					}
				});
	}

	

	function ColocarCheckopcionespedido(datos) {
		if (datos.length>0) {

			for (var i = 0; i <datos.length; i++) {
				
				$("#opcionespedido_"+datos[i].idopcionespedido).prop("checked",true);

			}

		}
	}

	function ObtenerDatosfiscales() {
		$.ajax({
					url: 'catalogos/sucursales/ObtenerDatosfiscales.php', //Url a donde la enviaremos
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

						var datos=msj.respuesta;
						PintarDatosfiscales(datos);

					}
				});
	}

	function PintarDatosfiscales(datos) {


		var html="";
		if (datos.length>0) {
			for (var i = 0; i <datos.length; i++) {
				
				html+=`
					<div class="form-check " >
					  <input type="radio" name="fiscal" class="form-check-input datosfiscales" id="datofiscal_`+datos[i].iddatofiscal+`" >
					  <label class="form-check-label" for="flexCheckDefault">
								RAZÓN SOCIAL: `+datos[i].nombre+`<br>
								RFC: `+datos[i].rfc+`<br>
								CORREO: `+datos[i].correo+`<br>

							</label>
						</div>
						`;
			}
		}else{
			html+=`
					<div class="form-check " >
					  <label class="form-check-label" for="flexCheckDefault">
							No se encuentran registradas datos fiscales.						  

							</label>
						</div>
						`;

		}

		$("#listadatosfiscales").html(html);
	}

	function Cambioticketventa() {
			if ($("#tventa").is(':checked')) {

				$("#tventa").val(1);
				$("#tventa").attr('checked',true);
			}else{
				$("#tventa").val(0);
				$("#tventa").attr('checked',false);

			}
			
		}	


	function Cambioticketproduccion(){

	 		if ($("#tproduccion").is(':checked')) {
				$("#tproduccion").val(1);
				$("#tproduccion").attr('checked',true);

			}else{
				$("#tproduccion").val(0);

				$("#tproduccion").attr('checked',false);

			}
	 } 


function Habilitarrecordatorio(argument) {
	
	if ($("#trecordatorio").is(':checked')) {
				$("#trecordatorio").val(1);
				$("#trecordatorio").attr('checked',true);
				$("#mostrarminutos").css('display','block');

			}else{

				$("#trecordatorio").val(0);
				$("#trecordatorio").attr('checked',false);
				$("#mostrarminutos").css('display','none');

			}
}


function ObtenerTipospago() {

		$.ajax({
					url: 'catalogos/sucursales/ObtenerTipagos.php', //Url a donde la enviaremos
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

						var datos=msj.respuesta;
						PintarTipospagos(datos);

					}
				});

	}

	function PintarTipospagos(datos) {


		var html="";
		if (datos.length>0) {
		for (var i = 0; i <datos.length; i++) {
			
			html+=`
				<div class="form-check " >
				  <input type="checkbox" class="form-check-input tipodepagos" id="tipodepagos_`+datos[i].idtipodepago+`" >
				  <label class="form-check-label" for="flexCheckDefault">
							`+datos[i].tipo+`							  
						</label>
					</div>
					`;
		}
	}else{
		html+=`
				<div class="form-check " >
				  <label class="form-check-label" for="flexCheckDefault">
						No se encuentran registradas tipos de pagos.						  

						</label>
					</div>
					`;

	}

		$("#tipodepagoslista").html(html);
	}


	function ObtenerTipospagosSucursal(idsucursal) {
			var datos="idsucursal="+idsucursal;

		$.ajax({
					url: 'catalogos/sucursales/ObtenerTipospagoSucursal.php', //Url a donde la enviaremos
					type: 'POST', //Metodo que usaremos
					data:datos,
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

					var datos=msj.respuesta;

					ColocarChecktipopagos(datos);

					}
				});
	}

	function ColocarChecktipopagos(datos) {
		if (datos.length>0) {

			for (var i = 0; i <datos.length; i++) {
				
				$("#tipodepagos_"+datos[i].idtipodepago).prop("checked",true);

			}

		}
	}

	function habilitarcampomontofactura1(){


	if ($("#habilitarcampomontofactura").is(':checked')) {

		$("#habilitarcampomontofactura").val(1);

			}else{

			$("#habilitarcampomontofactura").val(0);
				
		}
	}

	function CambioNotaventa(argument) {

		if($("#notaventa").is(':checked')) {

		$("#notaventa").val(1);

			}else{

			$("#notaventa").val(0);
				
		}
	}
