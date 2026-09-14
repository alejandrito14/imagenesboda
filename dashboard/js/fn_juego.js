var validado=1;
function GenerarSelectPlayer1(jugadores) {

	var html="";
	for (var i = 0; i <jugadores; i++) {

		html+=`

		<label>JUGADOR `+(i+1)+` </label>
		<select name="v_clientes1" id="v_contendientes`+i+`" class="v_clientes1 form-control" onchange="Seleccionjugador('v_contendientes`+i+`')">
		<option value="0">SELECCIONAR JUGADOR</option>

		</select>


		`;		
	}

	$("#player1").html(html);

	LlenarContendientes(jugadores);

}

function GenerarSelectPlayer2(jugadores) {
	var html="";

	for (var i = 0; i <jugadores; i++) {
		html+=`
		<label>JUGADOR `+(i+1)+` </label>
		<select name="v_clientes2" id="v_adversario`+i+`" class="v_clientes2 form-control" onchange="Seleccionjugador('v_adversario`+i+`')">
		<option value="0">SELECCIONAR JUGADOR</option>

		</select>


		`;	
	}
	$("#player2").html(html);

	LlenarAdversarios(jugadores);

}

function LlenarContendientes(jugadores) {

	var clientes='';

	var idtorneo=$("#v_torneo").val();

	var datos="idtorneo="+idtorneo;

	$.ajax({
					url:'catalogos/armarjuego/obtenerclientesTorneo.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
						},
						success:function(msj){
							
							clientes=msj.respuesta;

							var html="";
							html+='<option value="0">SELECCIONAR JUGADOR</option>';

							for (var i = 0; i <clientes.length; i++) {

								html+='<option value='+clientes[i].idcliente+'>'+clientes[i].nombre+' '+clientes[i].paterno+' '+clientes[i].materno+'</option>';


							}

							for (var i = 0; i <jugadores; i++) {

								$("#v_contendientes"+i).html(html);


								$("#v_contendientes"+i).chosen({width: "100%"}); 


							}

						}
					});





}
function LlenarAdversarios(jugadores) {
	var idtorneo=$("#v_torneo").val();
	var datos="idtorneo="+idtorneo;

	$.ajax({
					url:'catalogos/armarjuego/obtenerclientesTorneo.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
						},
						success:function(msj){
							
							clientes=msj.respuesta;

							var html="";
							html+='<option value="0">SELECCIONAR JUGADOR</option>';

							for (var i = 0; i <clientes.length; i++) {

								html+='<option value='+clientes[i].idcliente+'>'+clientes[i].nombre+' '+clientes[i].paterno+' '+clientes[i].materno+'</option>';


							}

							for (var i = 0; i <jugadores; i++) {

								$("#v_adversario"+i).html(html);
								$("#v_adversario"+i).chosen({width: "100%"}); 

							}

						}
					});
}


function Seleccionjugador(idselect) {


	var arregloclientes1=[];
	
	$(".v_clientes1").each(function(){

		var valor=$(this).val();
		var id=$(this).attr('id');

		if (valor>0) {

			const clientes1 = {
				id : id,
				valor : valor,
				
			}
			arregloclientes1.push(clientes1);
		}

	});

	$(".v_clientes2").each(function(){

		var valor=$(this).val();
		var id=$(this).attr('id');

		if (valor>0) {

			const clientes2 = {
				id : id,
				valor : valor,
				
			}
			arregloclientes1.push(clientes2);
		}

	});

	$(".v_clientes1").each(function(){

		var id=$(this).attr('id');

		$("#"+id+" option").each(function(){

			//$(this).prop("disabled",false);
			$(this).attr('disabled',false).trigger("chosen:updated");

		});

	});


	$(".v_clientes2").each(function(){
		var id=$(this).attr('id');

		$("#"+id+" option").each(function(){
			//$(this).prop("disabled",false);
			$(this).attr('disabled',false).trigger("chosen:updated");

		});

	});


	



	for (var i =0; i < arregloclientes1.length; i++) {

		var valor1=arregloclientes1[i].valor;
		var id=arregloclientes1[i].id;

		//console.log(arregloclientes1[i]);
		if (valor1>0) {

			//$(".v_clientes1").find("option[value='"+valor1+"']").prop("disabled",true);
			//$(".v_clientes2").find("option[value='"+valor1+"']").prop("disabled",true);

			//$("#"+id).find("option[value='"+valor1+"']").prop("disabled",false);
			$(".v_clientes2").find("option[value='"+valor1+"']").attr('disabled',true).trigger("chosen:updated");

			$(".v_clientes1").find("option[value='"+valor1+"']").attr('disabled',true).trigger("chosen:updated");

			$("#"+id).find("option[value='"+valor1+"']").attr('disabled',false).trigger("chosen:updated");
		}

	}




}

function Comparar(array,valor) {
	for (var i = 0; i <array.length; i++) {
		
		if (array[i]==valor) {

			return true;
		}

	}
}

function CambiarTorneo() {

	ObtenerNumeroJugadores();
}

function GuardarJuego(form,regresar,donde,idmenumodulo){

	ValidarNombre();


	if(validado==1){
	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);
		
		console.log(datos);

		var equipo1=[];
		var equipo2=[];
		$(".v_clientes1").each(function(){
			var id=$(this).attr('id');
			var valor=$(this).val();
			equipo1.push(valor);
		});


		$(".v_clientes2").each(function(){
			var id=$(this).attr('id');
			var valor=$(this).val();
			equipo2.push(valor);
		});

		variables="&equipo1="+equipo1+"&equipo2="+equipo2;
		datos=datos+variables;

		console.log(datos);




		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')

		setTimeout(function(){
			$.ajax({
					url:'catalogos/armarjuego/ga_juego.php', //Url a donde la enviaremos
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
	
}

function BorrarJuego(idjuego,idmenumodulo) {

	var datos='idjuego='+idjuego;

	var donde ='catalogos/armarjuego/vi_juego.php';
	
	$.ajax({
					url:'catalogos/armarjuego/borrar_juego.php', //Url a donde la enviaremos
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
							var resp = msj.split('|');

							console.log("El resultado de msj es: "+msj);
							if( resp[0] == 1 ){
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito&idempresas="+resp[1],donde);
							}else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
							}			
						}
					});

}

function detallejuego(idjuego) {
	
	var datos='idjuego='+idjuego;

	
	$.ajax({
					url:'catalogos/armarjuego/obtenerdetallejuego.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					dataType:'json',
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
						},
						success:function(msj){

							var respuesta=msj.respuesta.juego;

							$("#titulo-modal-forms3").text('DETALLE DE JUEGO');

							var html=`<div class="card w-75">
							<div class="card-body">
							<p class="card-text">TORNEO: `+respuesta.nombretorneo+`</p>
							<p class="card-text">ESPACIO: `+respuesta.nombreespacio+`</p>
							<p class="card-text">FECHA: `+respuesta.fecha+`</p>
							<p class="card-text">TIPO DE JUEGO: `+respuesta.nombretipojuego+`</p>

							</div>
							</div>`;

							html+=`

							<div class="row">
							<div class="col-md-12">
							<div class="col-md-6" style="float: left;">
							<h4 style="text-align: center;">EQUIPO1</h4>

							
							<div id="player1"></div>

							</div>
							<div class="col-md-6" style="float: right;">
							<h4 style="text-align: center;">EQUIPO2</h4>
							<div id="player2"></div>

							</div>
							</div>
							</div>

							`;
							$("#contenedor-modal-forms3").html(html);


							var jugadores=msj.respuesta.jugadores;
							var equipo1='';
							var equipo2='';


							for (var i = 0; i < jugadores.length; i++) {

								if (jugadores[i].equipo==1) {

									equipo1+=`
									<div class="col-xl-12 col-sm-12 col-md-12"> 
										<div class="card">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="align-self-center">`


														if (jugadores[i].foto==null) {
														equipo1+=`<i class="fa fa-user-circle primary float-left" style="font-size:4em;"></i>`;
														
														}else{

														equipo1+=`<img src="https://issoftware.com.mx/apptennis/php/upload/perfil/`+jugadores[i].foto+`" style="width: 4em; border-radius: 20px!important;">`;

														}

														equipo1+=`</div>
														<div class="media-body">
														<h4>`+jugadores[i].nombre+' '+
																jugadores[i].paterno+' '+
																jugadores[i].materno +`</h4>
														<span></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


									`;


								}else{

									equipo2+=`

										<div class="col-xl-12 col-sm-12 col-md-12"> 
										<div class="card">
											<div class="card-content">
												<div class="card-body">
													<div class="media d-flex">
														<div class="align-self-center">`
													
													if (jugadores[i].foto==null) {
														equipo2+=`<i class="fa fa-user-circle primary float-left" style="font-size:4em;"></i>`;
														
														}else{

														equipo2+=`<img  src="https://issoftware.com.mx/apptennis/php/upload/perfil/`+jugadores[i].foto+`" style="width: 4em;border-radius: 20px!important;">`;

														}

													equipo2+=`</div>
														<div class="media-body ">
														<h4>`+jugadores[i].nombre+' '+
																jugadores[i].paterno+' '+
																jugadores[i].materno +`</h4>
														<span></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									`;

								}
								

							}


							$("#player1").html(equipo1);
							$("#player2").html(equipo2);

							$("#modal-forms3").modal();
							


						}
					});
}

function ValidarNombre() {
	var nombre=$("#v_nombre").val();

	var datos ='nombre='+nombre;
	
	$.ajax({
					url:'catalogos/armarjuego/validarnombre.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					async:false,
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error;
						console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
						},
						success:function(msj){
							console.log('nombre '+ msj);
							if (msj==1) {
								validado=0;

								AbrirNotificacion("NOMBRE EXISTENTE EN LA BASE DE DATOS","mdi-checkbox-marked-circle");

							}else{
								validado=1;
							}

									
						}
					});
}