function GuardarGrupo(form,regresar,donde,idmenumodulo)
{
	var validado=1;
	var faltaopcion=0;
	var faltaocosto=0;
	var topessecundarios=[];
	var nombregrupo=$("#nombregrupo").val();

	if (nombregrupo=='') {
		validado=0;
	}

	$(".opciontitulo").each(function(){

		var valor=$(this).val();

		if (valor=='') {
			validado=0;
			faltaopcion=1;
		}

	});

	var obligatorio=0;

	if ($("#obligatorio").is(':checked')) {

		obligatorio=1;
	}
	


	valorcosto=$("input[name=costoadicional]:checked").val();

	if (valorcosto==1) {

		$(".costoopcion").each(function(){
			var valor=$(this).val();
			if (valor=='') {
				validado=0;
				faltaocosto=1;
			}
		});

	}

	if (validado==1) {



		if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
		{			
		//recibimos todos los datos..
		var datos = ObtenerDatosFormulario(form);


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


		datos=datos+"&opcion="+opcion+"&costo="+costo+"&obligatorio="+obligatorio;

		
		console.log(datos);

		$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Procesando...</div>')

		setTimeout(function(){
			$.ajax({
					url:'catalogos/grupo/ga_grupo.php', //Url a donde la enviaremos
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

}else{

		var texto='';

		if (nombregrupo=='') {
			validado=0;
			texto+='TÍTULO REQUERIDO<br>';

		}


			if (faltaopcion==1) {
			
				texto+='TÍTULO DE OPCIÓN REQUERIDO<br>';
			}

		

		if (faltaocosto==1) {
				texto+='COSTO DE OPCIÓN REQUERIDO<br>';

			}


		AbrirNotificacion(texto,'mdi mdi-checkbox-marked-circle');


	}
}


function ObtenerOpcionesGrupos(idgrupo) {
	var datos="idgrupo="+idgrupo;


		$.ajax({
					url: 'catalogos/grupo/obteneropcionesgrupo.php', //Url a donde la enviaremos
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

						var opciones=msj.respuesta;

						if (opciones.length>0) {
							PintarOpciones(opciones);
						}


					}
				});

}

function PintarOpciones(opciones) {
	var html="";
	for (var i = 0; i <opciones.length; i++) {

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
			<input type="text" class="form-control opciontitulo" value="`+opciones[i].opcion+`" tabindex="`+tabindex+`"  placeholder="">
			</div>
			<div class="col-md-5 costoinput">
			<label>COSTO</label>

			<input type="number" class="form-control costoopcion" value="`+opciones[i].costo+`" tabindex="`+(tabindex+1)+`"  placeholder="$">
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
}

function Checar() {

		if ($("#unica").is(':checked')) {

			$("#colocartope").css('display','block');

			$("#unica").val(1);
			$("#unica2").val(1);

			$("#unica2").attr('checked',false);
			$("#unica").attr('checked',true);

		}

		if ($("#unica2").is(':checked')) {

			$("#colocartope").css('display','none');
			$("#unica").val(0);
			$("#unica2").val(0);

			$("#unica2").attr('checked',true);
			$("#unica").attr('checked',false);

		}

}

