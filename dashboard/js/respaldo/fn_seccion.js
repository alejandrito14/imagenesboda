
function AbrirModal() {
	$("#modalimagenes").modal();
	$("#btnguardardatos").attr('onclick','GuardarDatos(-1)')


}

function AbrirModalPromocion() {
	$("#modalimagenespromocion").modal();
	$("#btnpromoguardar").attr('onclick','GuardarDatosPromo(-1)');

}

function Subirimagenesdeseccion(idseccion) {
	
//	$("#idseccion").val(idsucursal);
	showAttachedFiles(idseccion);
	//$("#modalimagensucursal").modal();
}


function GuardarDatos(posicion) {
	ruta=$(".imagenrevista").attr('src');
	ordenimagen=$("#ordenimagen").val();
	v_estatusimagen=$("#v_estatusimagen").val();
	nombreimagen=ruta.split('/')[5];

	//alert(ruta+'nombreimagen'+nombreimagen);
		if (posicion>-1) {

			//alert('borrando posicion'+posicion);
		
		BorrarImagenseccion("",posicion);
		
		}
	mensaje='';
	if (ruta!='') {
	var obj={
		ruta:ruta,
		ordenimagen:ordenimagen,
		v_estatusimagen:v_estatusimagen,
		nombreimagen:nombreimagen
	};

	imagenesderevista.push(obj);
	$("#modalimagenes").modal('hide');
	PintarImagenesSeccion();
	//console.log(imagenesderevista);
	ReestablecerFormulario()

	}else{

		if (ruta=='') {

			mensaje+="No se ha seleccionado imagen<br>";
		}

		if (ordenimagen=='') {
			mensaje+='Colocar orden<br>';
		}

				AbrirNotificacion(mensaje,'mdi mdi-checkbox-marked-circle');

	}
}

function PintarImagenesSeccion() {
	var html="";


	if (imagenesderevista.length>0) {

		imagenesderevista.sort(function (a, b){
   			 return (a.ordenimagen - b.ordenimagen)
		});

	for (var i = 0; i < imagenesderevista.length; i++) {


		html+=`

		<tr>
		    <td><img src='`+imagenesderevista[i].ruta+`' width="200"></td>
		   
		    <td style="text-align:center;">
		    <label>`+imagenesderevista[i].ordenimagen+`</label>
		    </td>
		     <td style="text-align:center;">`;
		    if (imagenesderevista[i].v_estatusimagen==1) {

		    	html+='<p>ACTIVADO</p>';
		    }else{

				html+='<p>DESACTIVO</p>';
		    }


		   html+=` </td>

		   <td style="text-align: center;">

		   <button type="button" onclick="BorrarImagenseccion(\'`+imagenesderevista[i].nombreimagen+`\',`+i+`)" class="btn btn_rojo" style="" title="BORRAR">
								<i class="mdi mdi-delete-empty"></i>
						</button>

			<button type="button" onclick="EditarImagenSeccion(\'`+imagenesderevista[i].nombreimagen+`\',`+i+`)" class="btn btn_colorgray" style="" title="EDITAR">
								<i class="mdi mdi-table-edit"></i>
						</button>

		   </td>
		  </tr>

		`;
	}

}

	$("#imagenesfilas").html(html);

}

function ReestablecerFormulario(argument) {
	$(".imagenrevista").attr('src','');
	$("#imagerevista").val('');

	$("#d_fotorevista").css('display','block');
	$("#d_fotorevista").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	$("#ordenimagen").val('');
	$("#btnguardardatos").attr('onclick','GuardarDatos(-1)')


}
function ReestablecerFormularioPromo(argument) {
	$(".imagenpromo").attr('src','');
	$("#imagepromo").val('');

	$("#d_fotopromo").css('display','block');
	$("#d_fotopromo").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	$("#ordenpromo").val('');
	$("#btnpromoguardar").attr('onclick','GuardarDatosPromo(-1)');


}

function BorrarImagenseccion(nombreimagen,posicion) {

	
	removeItemFromArr(imagenesderevista,posicion);


	PintarImagenesSeccion();
}

function removeItemFromArr ( arr, item ) {

	//alert('posicion'+item);

	//console.log(imagenesderevista);
		if (imagenesderevista.length>0) {
		//for (var i = 0; i < imagenesderevista.length; i++) {

			//if (imagenesderevista[i].nombreimagen==item) {

				imagenesderevista.splice(item, 1);
			//}

		//}
			//console.log(imagenesderevista);

	}
}
function Guardarseccion(form,regresar,donde,idmenumodulo) {
	var id=$("#id").val();
	var v_titulo=$("#v_seccion").val();
	var v_descripcion=$("#v_descripcion").val();
	var v_estatus=$("#v_estatus").val();
	var v_tipo=$("#v_tipo").val();
	var sucursalvinculados=[];
	$(".sucursalvinculado").each(function(index) {

			var idsucursalv=$(this).attr('id');

			if ($('#'+idsucursalv).is(':checked')) {
				var idsucursalv=$(this).attr('id');
				var dividir=idsucursalv.split('_');
				sucursalvinculados.push(dividir[1]);
			}
			
		});

 	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{	
 	var datos="idsecciones="+id+"&titulo="+v_titulo+"&descripcion="+v_descripcion+"&estatus="+v_estatus+"&tipo="+v_tipo+"&imagenesderevista="+JSON.stringify(imagenesderevista)+"&imagenprincipal="+imagenprincipal+"&sucursalvinculados="+sucursalvinculados+"&imagenespromo="+JSON.stringify(imagenespromo);
	 $.ajax({
					url:'catalogos/secciones/ga_seccion.php', //Url a donde la enviaremos
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
								aparecermodulos(regresar+"?ac=1&idmenumodulo="+idmenumodulo+"&msj=Operacion realizada con exito",donde);
						 	 }else{
								aparecermodulos(regresar+"?ac=0&idmenumodulo="+idmenumodulo+"&msj=Error. "+msj,donde);
						  	}			
					  	}
				  });
	}
}

function EditarImagenSeccion(imagen,posicion) {

	//alert('posicion editar'+posicion);

	var orden="";
	var estatus="";
	var nombreimagen="";
	var rutaimagen="";

	for (var i = 0; i < imagenesderevista.length; i++) {

			if (imagenesderevista[i].nombreimagen==imagen) {

				rutaimagen=imagenesderevista[i].ruta;
				orden=imagenesderevista[i].ordenimagen;
				estatus=imagenesderevista[i].v_estatusimagen;
				nombreimagen=imagenesderevista[i].nombreimagen;
				
			}

		}



	$("#modalimagenes").modal();
	$("#ordenimagen").val(orden);
	$("#v_estatusimagen").val(estatus);
	if (nombreimagen!='') {

	$(".imagenrevista").attr('src',rutaimagen);
	$("#d_fotorevista").css('display','none');

	}else{
	$(".imagenrevista").attr('src','');

	$("#d_fotorevista").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	}
	//alert('btn '+posicion);

	$("#btnguardardatos").attr('onclick',"GuardarDatos("+posicion+")")
}

function EditarImagenSeccionpromo(imagen,posicion) {
	var orden="";
	var estatus="";
	var nombreimagen="";
	var rutaimagen="";

	for (var i = 0; i < imagenespromo.length; i++) {

			if (imagenespromo[i].nombreimagen==imagen) {

				rutaimagen=imagenespromo[i].ruta;
				orden=imagenespromo[i].ordenimagen;
				estatus=imagenespromo[i].v_estatusimagen;
				nombreimagen=imagenespromo[i].nombreimagen;
				
			}

		}



	$("#modalimagenespromocion").modal();
	$("#ordenpromo").val(orden);
	$("#v_estatusimagenpromo").val(estatus);
	if (nombreimagen!='') {

	$(".imagenpromo").attr('src',rutaimagen);
	$("#d_fotopromo").css('display','none');

	}else{
	$(".imagenpromo").attr('src','');

	$("#d_fotopromo").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	}


	$("#btnpromoguardar").attr('onclick','GuardarDatosPromo('+posicion+')');
}

function SeleccionarSucursalesvinculado(idsucursal) {

	if ($("#sucursalvinculado_0").is(':checked')) {

		if (idsucursal==0) {

		$(".sucursalvinculado").attr('checked',true);
		}

	}else{

		if (idsucursal==0) {

			$(".sucursalvinculado").attr('checked',false);
		}
	}


	if (idsucursal!=0) {

		if($("#sucursalvinculado_"+idsucursal).is(':checked')){

			$("#sucursalvinculado_"+idsucursal).attr('checked',true);

		}else{

			$("#sucursalvinculado_"+idsucursal).attr('checked',false);
	
		}

	}
	
}

function ObtenerSucursalesVinculadas(idseccion) {
	var datos="idseccion="+idseccion;
	 $.ajax({
			url:'catalogos/secciones/obtenersucursalesvinculadas.php', //Url a donde la enviaremos
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

					var respuesta=msj.respuesta;

					if (respuesta.length>0) {

						ColocarVinculados(respuesta);
					}
					
								
				}
		 });

}

function ColocarVinculados(respuesta) {
	
		for (var i = 0; i <respuesta.length; i++) {
			
			$("#sucursalvinculado_"+respuesta[i].idsucursales).attr('checked',true);
	
		}
}


function GuardarDatosPromo(posicion) {
	ruta=$(".imagenpromo").attr('src');
	ordenimagen=$("#ordenpromo").val();
	v_estatusimagen=$("#v_estatusimagenpromo").val();
	nombreimagen=ruta.split('/')[5];

	//alert(ruta +' nombreimagen '+  nombreimagen);

	if (posicion>-1) {

		BorrarImagenseccionpromo("",posicion);
	
	}

	mensaje='';
	if (ruta!='') {
	var obj={
		ruta:ruta,
		ordenimagen:ordenimagen,
		v_estatusimagen:v_estatusimagen,
		nombreimagen:nombreimagen
	};

	imagenespromo.push(obj);
	$("#modalimagenespromocion").modal('hide');
	PintarImagenesSeccionPromo();
	//console.log(imagenespromo);
	ReestablecerFormularioPromo()

	}else{

		if (ruta=='') {

			mensaje+="No se ha seleccionado imagen<br>";
		}

		if (ordenimagen=='') {
			mensaje+='Colocar orden<br>';
		}

				AbrirNotificacion(mensaje,'mdi mdi-checkbox-marked-circle');

	}
}


function BorrarImagenseccionpromo(imagen,posicion) {

	
	removeItemFromArr1(imagenespromo,posicion);


	PintarImagenesSeccionPromo();
}

function removeItemFromArr1(arr, item) {

		if (imagenespromo.length>0) {

		//for (var i = 0; i < imagenespromo.length; i++) {

				imagenespromo.splice(item, 1);
			
		//}
	}
}

function PintarImagenesSeccionPromo() {
	var html="";


	if (imagenespromo.length>0) {

		imagenespromo.sort(function (a, b){
   			 return (a.ordenimagen - b.ordenimagen)
		});

	for (var i = 0; i < imagenespromo.length; i++) {


		html+=`

		<tr>
		    <td><img src='`+imagenespromo[i].ruta+`' width="200"></td>
		   
		    <td style="text-align:center;">
		    <label>`+imagenespromo[i].ordenimagen+`</label>
		    </td>
		     <td style="text-align:center;">`;
		    if (imagenespromo[i].v_estatusimagen==1) {

		    	html+='<p>ACTIVADO</p>';
		    }else{

				html+='<p>DESACTIVO</p>';
		    }


		   html+=` </td>

		   <td style="text-align: center;">

		   <button type="button" onclick="BorrarImagenseccionpromo(\'`+imagenespromo[i].nombreimagen+`\','`+i+`')" class="btn btn_rojo" style="" title="BORRAR">
								<i class="mdi mdi-delete-empty"></i>
						</button>

			<button type="button" onclick="EditarImagenSeccionpromo(\'`+imagenespromo[i].nombreimagen+`\','`+i+`')" class="btn btn_colorgray" style="" title="EDITAR">
								<i class="mdi mdi-table-edit"></i>
						</button>

		   </td>
		  </tr>

		`;
	}

}

	$("#imagenespromocionales").html(html);

}
