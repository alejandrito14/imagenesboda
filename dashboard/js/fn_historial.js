// JavaScript Document

function BuscarVentasHistorico(idmenumodulo)
{
	
	
	//$('.modal').modal('hide');
	
	
	var no_venta = $('#no_venta').val();
	var v_base_historico = $('#v_base_historico').val();
	var nombrecliente = $('#nombrecliente').val();
	var fechaf = $('#fechaf').val();
	var fechai = $('#fechai').val();
	
	var datos = "idmenumodulo=" + idmenumodulo + "&fechaf=" + fechaf + "&fechai=" + fechai+"&nombrecliente="+nombrecliente+"&no_venta="+no_venta;
	
if(v_base_historico == 1)
	  {
		  var url = 'catalogos/ventas/historico/li_ventashistoricoerp.php';
	  }
	   else{
		  var url = 'catalogos/ventas/historico/li_ventashistorico.php';
	   }
	
	console.log(datos);
	
	$('#contenedor_ventashistorico').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');   
	
	$.ajax({
		type:'POST',
		data: datos,
		url: url,
		cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						 alert(error);						  
					  },
		success : function (msj){
		
			$('#contenedor_ventashistorico').html(msj);   
			}
		}); 
	
	
	
}


function VentaHistoricoDetalle(idventa)
{
	
	$('#modal-filtros3').modal('show');

	$('#VentasHistoricasDetalle').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');   
	
	
	    var datos = "idventa="+idventa;
	
 		$.ajax({
		type:'POST',
		data: datos,
		url: 'catalogos/ventas/historico/de_ventashistorico.php',
		cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						 alert(error);						  
					  },
		success : function (msj){
		
			$('#VentasHistoricasDetalle').html(msj);   
			}
		}); 

	
	
	
}