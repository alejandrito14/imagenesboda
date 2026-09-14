
function AbrirModal() {
	$("#modalimagenes").modal();
	$("#btnguardardatos").attr('onclick','GuardarDatos(-1)')


}

function AbrirModalPromocion() {
	$("#modalimagenespromocion").modal();
	$("#btnpromoguardar").attr('onclick','GuardarDatosPromo(-1)');

}

function AbrirModalNoticias(argument) {
	$("#modalnoticias").modal();
	$("#btnnoticiaguardar").attr('onclick','GuardarDatosNoticia(-1)');

}

function AbrirModalFechas(argument) {
	$("#modalfechas").modal();
	
	$("#btnfechaguardar").attr('onclick','GuardarDatosfecha(-1)');

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


		if (imagenesderevista.length>0) {
		
				imagenesderevista.splice(item, 1);
		
	}
}
function Guardarseccion(form,regresar,donde,idmenumodulo) {
	var id=$("#id").val();
	var v_titulo=$("#v_seccion").val();
	var v_descripcion=$("#v_descripcion").val();
	var v_estatus=$("#v_estatus").val();
	var v_tipo=$("#v_tipo").val();
	var v_orden=$("#v_orden").val();
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
 	var datos="idsecciones="+id+"&titulo="+v_titulo+"&descripcion="+v_descripcion+"&estatus="+v_estatus+"&tipo="+v_tipo+"&imagenesderevista="+JSON.stringify(imagenesderevista)+"&imagenprincipal="+imagenprincipal+"&sucursalvinculados="+sucursalvinculados+"&imagenespromo="+JSON.stringify(imagenespromo)+"&imagenesdenoticia="+JSON.stringify(imagenesdenoticia)+"&v_orden="+v_orden+"&imagenescalendario="+JSON.stringify(imagenescalendario);
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



function GuardarDatosNoticia(posicion) {

	ruta=$(".imagennoticia").attr('src');
	titulonoticia=$("#titulonoticia").val();
	txtdescripcion=$("#txtdescripcion").val();
	ordennoticia=$("#ordennoticia").val();
	v_estatusnoticia=$("#v_estatusnoticia").val();
	txtenlace=$("#txtenlace").val();
	fechapublicacion=$("#fechapublicacion").val();
	nombreimagen=ruta.split('/')[5];
	//alert(ruta+'nombreimagen'+nombreimagen);
		if (posicion>-1) {
			//alert('borrando posicion'+posicion);
		
		BorrarImagennoticia("",posicion);
		
		}
	mensaje='';
	
	var obj={
		ruta:ruta,
		ordennoticia:ordennoticia,
		v_estatusnoticia:v_estatusnoticia,
		titulonoticia:titulonoticia,
		enlace:txtenlace,
		descripcion:txtdescripcion,
		nombreimagen:nombreimagen,
		fechapublicacion:fechapublicacion
	};
	
	imagenesdenoticia.push(obj);
	$("#modalnoticias").modal('hide');
	PintarImagenesNoticia();
	//console.log(imagenesderevista);
	ReestablecerFormularioNoticia()



		/*if (ruta=='') {

			mensaje+="No se ha seleccionado imagen<br>";
		}

		if (ordenimagen=='') {
			mensaje+='Colocar orden<br>';
		}

				AbrirNotificacion(mensaje,'mdi mdi-checkbox-marked-circle');
*/
	
}

function BorrarImagennoticia(nombreimagen,posicion) {

	
	removeItemFromArrnoti(imagenesdenoticia,posicion);


	PintarImagenesNoticia();
}

function removeItemFromArrnoti(arr, item ) {

		if (imagenesdenoticia.length>0) {
		
		 imagenesdenoticia.splice(item, 1);
		
	}
}

function PintarImagenesNoticia() {
	var html="";


	if (imagenesdenoticia.length>0) {

		imagenesdenoticia.sort(function (a, b){
   			 return (a.ordennoticia - b.ordennoticia)
		});

	for (var i = 0; i < imagenesdenoticia.length; i++) {


		html+=`

		<tr>
		    <td>`;

		    if (imagenesdenoticia[i].ruta!='') {

		      html+=`  <img src='`+imagenesdenoticia[i].ruta+`' width="200">`;
	
		    }

		   html+= `</td> 
		   
		    <td style="text-align:center;">
		    <label>`+imagenesdenoticia[i].titulonoticia+`</label>
		    </td>
		     <td style="text-align:center;">
		    <label>`+imagenesdenoticia[i].descripcion+`</label>
		    </td>
		     <td style="text-align:center;">
		    <label>`+imagenesdenoticia[i].enlace+`</label>
		    </td>
		     <td style="text-align:center;">
		    <label>`+imagenesdenoticia[i].ordennoticia+`</label>
		    </td>
		    
		     <td style="text-align:center;">`;
		    if (imagenesdenoticia[i].v_estatusnoticia==1) {

		    	html+='<p>ACTIVADO</p>';
		    }else{

				html+='<p>DESACTIVO</p>';
		    }


		   html+=` </td>

		   <td style="text-align: center;">

		   <button type="button" onclick="BorrarImagennoticia(\'`+imagenesdenoticia[i].nombreimagen+`\','`+i+`')" class="btn btn_rojo" style="" title="BORRAR">
								<i class="mdi mdi-delete-empty"></i>
						</button>

			<button type="button" onclick="EditarImagennoticia(\'`+imagenesdenoticia[i].nombreimagen+`\','`+i+`')" class="btn btn_colorgray" style="" title="EDITAR">
								<i class="mdi mdi-table-edit"></i>
						</button>

		   </td>
		  </tr>

		`;
	}

}

	$("#imagenesdenoticia").html(html);

}

function ReestablecerFormularioNoticia(argument) {
	$(".imagennoticia").attr('src','');
	$("#imagennoticia").val('');

	$("#d_fotonoticia").css('display','block');
	$("#d_fotonoticia").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	$("#ordennoticia").val('');
	$("#btnnoticiaguardar").attr('onclick','GuardarDatosNoticia(-1)')
	$("#titulonoticia").val('');
	$("#txtdescripcion").val('');
	$("#txtenlace").val('');

}

function EditarImagennoticia(imagen,posicion) {

	//alert('posicion editar'+posicion);

	var orden="";
	var estatus="";
	var nombreimagen="";
	var rutaimagen="";

	for (var i = 0; i < imagenesdenoticia.length; i++) {

			if (imagenesdenoticia[i].nombreimagen==imagen) {

				rutaimagen=imagenesdenoticia[i].ruta;
				orden=imagenesdenoticia[i].ordennoticia;
				estatus=imagenesdenoticia[i].v_estatusnoticia;
				nombreimagen=imagenesdenoticia[i].nombreimagen;
				titulo=imagenesdenoticia[i].titulonoticia;
				descripcion=imagenesdenoticia[i].descripcion;
				enlace=imagenesdenoticia[i].enlace;
				fechapublicacion=imagenesdenoticia[i].fechapublicacion;
			}

		}


	$("#modalnoticias").modal();
	$("#ordennoticia").val(orden);
	$("#v_estatusnoticia").val(estatus);
	$("#titulonoticia").val(titulo);
	$("#txtdescripcion").val(descripcion);
	$("#txtenlace").val(enlace);
	$("#fechapublicacion").val(fechapublicacion);

	if (nombreimagen!='') {

	$(".imagennoticia").attr('src',rutaimagen);
	$("#d_fotonoticia").css('display','none');

	}else{
	$(".imagennoticia").attr('src','');

	$("#d_fotonoticia").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	}
	//alert('btn '+posicion);

	$("#btnnoticiaguardar").attr('onclick',"GuardarDatosNoticia("+posicion+")")
}

//fechas

function GuardarDatosfecha(posicion) {


	ruta=$(".imagenfecha").attr('src');
	txtdescripcion=$("#txtdescripcionfecha").val();
	ordenfecha=$("#ordenfecha").val();
	v_estatusfecha=$("#v_estatusnoticia").val();
	fecha=$("#fechacalendario").val();
	nombreimagen=ruta.split('/')[5];
	//alert(ruta+'nombreimagen'+nombreimagen);
		if (posicion>-1) {

			//alert('borrando posicion'+posicion);
		
		BorrarImagencalendario("",posicion);
		
		}
	mensaje='';
	
	var obj={
		ruta:ruta,
		ordenfecha:ordenfecha,
		v_estatusfecha:v_estatusfecha,
		descripcion:txtdescripcion,
		nombreimagen:nombreimagen,
		fecha:fecha
	};
	
	imagenescalendario.push(obj);
	$("#modalfechas").modal('hide');
	PintarImagenescalendario();
	//console.log(imagenesderevista);
	ReestablecerFormulariocalendario()




	
}

function BorrarImagencalendario(nombreimagen,posicion) {

	
	removeItemFromArrcalendario(imagenescalendario,posicion);


	PintarImagenescalendario();
}

function removeItemFromArrcalendario( arr, item ) {


		if (imagenescalendario.length>0) {
		
		 imagenescalendario.splice(item, 1);
		
	}
}


function PintarImagenescalendario() {
	var html="";


	if (imagenescalendario.length>0) {

		imagenescalendario.sort(function (a, b){
   			 return (a.ordenfecha - b.ordenfecha)
		});

	for (var i = 0; i < imagenescalendario.length; i++) {


		html+=`

		<tr>
		    <td>`;

		    if (imagenescalendario[i].ruta!='') {

		      html+=`  <img src='`+imagenescalendario[i].ruta+`' width="200">`;
	
		    }

		   html+= `</td> 
		   
		   
		     <td style="text-align:center;">
		    <label>`+imagenescalendario[i].fecha+`</label>
		    </td>
		   
		     <td style="text-align:center;">
		    <label>`+imagenescalendario[i].descripcion+`</label>
		    </td>
		    
		     <td style="text-align:center;">`;
		    if (imagenescalendario[i].v_estatusfecha==1) {

		    	html+='<p>ACTIVADO</p>';
		    }else{

				html+='<p>DESACTIVO</p>';
		    }


		   html+=` </td>

		   <td style="text-align: center;">

		   <button type="button" onclick="BorrarImagencalendario(\'`+imagenescalendario[i].nombreimagen+`\','`+i+`')" class="btn btn_rojo" style="" title="BORRAR">
								<i class="mdi mdi-delete-empty"></i>
						</button>

			<button type="button" onclick="EditarImagencalendario(\'`+imagenescalendario[i].nombreimagen+`\','`+i+`')" class="btn btn_colorgray" style="" title="EDITAR">
								<i class="mdi mdi-table-edit"></i>
						</button>

		   </td>
		  </tr>

		`;
	}

}

	$("#imagenesdecalendario").html(html);

}

function ReestablecerFormulariocalendario(argument) {
	$(".imagenfecha").attr('src','');
	$("#imagefecha").val('');

	$("#d_fotofecha").css('display','block');
	$("#d_fotofecha").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	$("#ordenfecha").val('');
	$("#btnfechaguardar").attr('onclick','GuardarDatosfecha(-1)')
	$("#txtdescripcionfecha").val('');
	var fecha=fechaactual();
	$("#fechacalendario").val(fecha);
}

function fechaactual() {      
    var currentDate = new Date()
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var my_date =year+"/"+ month+"/"+day;
    return my_date;    
}


function EditarImagencalendario(imagen,posicion) {
	//alert('posicion editar'+posicion);

	var orden="";
	var estatus="";
	var nombreimagen="";
	var rutaimagen="";
	var descripcion="";
	for (var i = 0; i < imagenescalendario.length; i++) {

			if (imagenescalendario[i].nombreimagen==imagen) {

				rutaimagen=imagenescalendario[i].ruta;
				orden=imagenescalendario[i].ordenfecha;
				estatus=imagenescalendario[i].v_estatusfecha;
				nombreimagen=imagenescalendario[i].nombreimagen;
				descripcion=imagenescalendario[i].descripcion;
				fecha=imagenescalendario[i].fecha;
			}

		}


	$("#modalfechas").modal();
	$("#ordenfecha").val(orden);
	$("#v_estatusfecha").val(estatus);
	$("#txtdescripcionfecha").val(descripcion);
	$("#fechacalendario").val(fecha);

	if (nombreimagen!='') {

	$(".imagenfecha").attr('src',rutaimagen);
	$("#d_fotofecha").css('display','none');

	}else{
	$(".imagenfecha").attr('src','');

	$("#d_fotofecha").html('<img src="images/sinfoto.png" class="card-img-top" alt="" style="border: 1px #777 solid">');
	}
	//alert('btn '+posicion);

	$("#btnfechaguardar").attr('onclick',"GuardarDatosfecha("+posicion+")")

}

function SeleccionarTipo() {
	
	var v_tipo=$("#v_tipo").val();

	if (v_tipo==0) {

		$(".divrevista").css('display','none');
		$(".divnoticias").css('display','none');
		$(".divcalendario").css('display','none');

	}

	if (v_tipo==1) {

		$(".divrevista").css('display','block');
		$(".divnoticias").css('display','none');
		$(".divcalendario").css('display','none');
	}
	if (v_tipo==2) {

		$(".divrevista").css('display','none');
		$(".divnoticias").css('display','block');
		$(".divcalendario").css('display','none');
	}
	if (v_tipo==3) {

		$(".divrevista").css('display','none');
		$(".divnoticias").css('display','none');
		$(".divcalendario").css('display','block');
	}
}

function ActualizarOrdenSeccion(idseccion,orden) {
	
	var html="";

	html+=`<input id="orden_`+idseccion+`" type="text" value="`+orden+`">`;
	html+=`<button type="button" onclick="CancelarOrdenSeccion(`+idseccion+`,`+orden+`)" class="btn btn_rojo"><i class="mdi mdi-close"></i></button>`;

	html+=`<button type="button" onclick="ActualizarOrdenSecc(`+idseccion+`)" class="btn btn_rojo" style="background:#28b779;"><i class="mdi mdi-content-save"></i></button>`;


	$("#pintar_"+idseccion).append(html);
	$("#span_"+idseccion).css('display','none');
}

function CancelarOrdenSeccion(idseccion,orden) {

		$("#pintar_"+idseccion).html('');
		$("#span_"+idseccion).css('display','block');

}
function ActualizarOrdenSecc(idseccion) {

	if(confirm("\u00BFDesea realizar esta operaci\u00f3n?"))
	{			
		
	 var orden=$("#orden_"+idseccion).val();
	 var datos="idseccion="+idseccion+"&orden="+orden;

	 $.ajax({
					url:'catalogos/secciones/ordenseccion.php', //Url a donde la enviaremos
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
						
						CancelarOrdenSeccion(idseccion,orden);
						$("#span_"+idseccion).text(orden);
						$("#span_"+idseccion).css('display','block');

					  	}
				  });				  		
	}
}
