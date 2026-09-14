function CargarSucursales()
{
	
	$.ajax({
		type:'GET',
		url: 'catalogos/reportes/li_sucursales.php',
		cache:false,
		async:false,
		error:function(XMLHttpRequest, textStatus, errorThrown){
		 console.log(arguments);
		 var error;
		 if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
		 if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
		alert(error);						  
		 },
		success : function (msj){
		
			$('#v_idsucursales').html(msj);   
			}
		}); 
}


function CargarFiltrosreportes(idreporte) {

	if (idreporte>0) {
	var datos="idreporte="+idreporte;

	$.ajax({
		type:'POST',
		url: 'catalogos/reportes/Obtenerfiltrosreporte.php',
		data:datos,
		dataType:'json',
		cache:false,
		async:false,
		error:function(XMLHttpRequest, textStatus, errorThrown){
		 console.log(arguments);
		 var error;
		 if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
		 if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
		alert(error);						  
		 },
		success : function (msj){
			
			var respuesta=msj.respuesta;
			var habilitarsucursal=respuesta.habilitarsucursal;
			var habilitarfechainicio=respuesta.habilitarfechainicio;
			var habilitarfechafin=respuesta.habilitarfechafinal;
			var funcion=respuesta.funcion;
			var habilitarhorainicio=respuesta.habilitarhorainicio;
			var habilitarhorafin=respuesta.habilitarhorafin;
			//alert(habilitarfechafin);
			Filtrosreportes(habilitarsucursal,habilitarfechainicio,habilitarfechafin,habilitarhorainicio,habilitarhorafin,funcion);
			
			}
		}); 
	}else{

		$("#sucursales").css('display','none');
		$("#fechainicio").css('display','none');
		$("#fechafinal").css('display','none');
		$("#btngenerar").css('display','none');

	}
}

function Filtrosreportes(habilitarsucursales,habilitarfechainicio,habilitarfechafinal,habilitarhorainicio,habilitarhorafin,funcion) {

	$("#sucursales").css('display','none');
	$("#fechainicio").css('display','none');
	$("#fechafinal").css('display','none');
	$("#btngenerar").css('display','block');
	$("#btngenerar").attr('onclick',funcion);
	$("#horainicio").attr('display','none');
	$("#horafin").attr('display','none');

	if (habilitarsucursales==1) {

		CargarSucursales();
		$("#sucursales").css('display','block');
	}

	if (habilitarfechainicio==1) {

		$("#fechainicio").css('display','block');
	
	}

	if (habilitarfechafinal==1) {

		$("#fechafinal").css('display','block');
	
	}

	if (habilitarhorainicio==1) {

		$("#horainicio").css('display','block');
	
	}
	if (habilitarhorafin==1) {
		$("#horafin").css('display','block');
	}
	
}
function CargarCategorias() {

	$.ajax({
		type:'GET',
		url: 'catalogos/reportes/li_categorias.php',
		cache:false,
		async:false,
		error:function(XMLHttpRequest, textStatus, errorThrown){
		 console.log(arguments);
		 var error;
		 if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
		 if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
		alert(error);						  
		 },
		success : function (msj){
		
			$('#v_categoria').html(msj);   
			}
		}); 
}

function GenerarReporteVentas(){

	var idsucursal=$("#v_idsucursales").val();
	var fechainicio=$("#fechainicio1").val();
	var fechafin=$("#fechafin").val();

	var horainicio=$("#v_horainicio").val();
	var horafin=$("#v_horafin").val();

	var fechainicio1=fechainicio.split(' ')[0];
	var fechafin1=fechafin.split(' ')[0];

	var datos="idsucursal="+idsucursal+"&fechainicio="+fechainicio1+"&fechafin="+fechafin1+"&horainicio="+horainicio+"&horafin="+horafin;

	var url='modelosreportes/ventas/excel/rpt_Ventas_general.php?'+datos; 

	//alert(url);
	window.open(url, '_blank');	

}

function GenerarReporteDetalladoVentas(){


	var idsucursal=$("#v_idsucursales").val();
	var fechainicio=$("#fechainicio1").val();
	var fechafin=$("#fechafin").val();

	var horainicio=$("#v_horainicio").val();
	var horafin=$("#v_horafin").val();

	var fechainicio1=fechainicio.split(' ')[0];
	var fechafin1=fechafin.split(' ')[0];

	var datos="idsucursal="+idsucursal+"&fechainicio="+fechainicio1+"&fechafin="+fechafin1+"&horainicio="+horainicio+"&horafin="+horafin;

	var url='modelosreportes/ventas/excel/rpt_Ventas_detalle.php?'+datos; 
	window.open(url, '_blank');

}