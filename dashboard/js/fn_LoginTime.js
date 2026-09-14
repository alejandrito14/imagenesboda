// JavaScript Document
/*$(document).ready(function() {

setInterval(function(){
				var ArchivoGurardar="checkSesion.php";
				//alert("entra en la funcion -----"+ArchivoGurardar);
					$.ajax({
						type: 'POST',
						url: ArchivoGurardar,
						data:'valid=1',
						success:function(msj){
							//alert(msj);
							if ( msj == "1" )
							{
								if(confirm("Tu Sesi\u00f3n esta por terminar \n \u00BFDeseas continuar en el sistema?"))
								{
									$.ajax({
										type: 'POST',
										url: ArchivoGurardar,
										data:'recargar=1',
										success:function(msj){
											
											$.ajax({
												  type: 'POST',
												  url: 'checkSesionTime.php',					  
												  error:function(XMLHttpRequest, textStatus, errorThrown){
													 
											  var error;
											  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
											  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
													  console.log("No se pudo agregar session en bitacora = "+msj);				  
												  },
												  success:function(msj){
													console.log("Se agrego Bitacora correctamente de inicio de mas tiempo");	
											 
													
												  }
											  });		
											
											
											
											},
											error:function(XMLHttpRequest, textStatus, errorThrown){
												console.log(arguments);
												var error;
												if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
												if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
												//alert("Error ."+error);
											}
										});
									//ValidarSesionActiva('recargar=1');
								}
								else
								{
									$.ajax({
										type: 'POST',
										url: ArchivoGurardar,
										data:'destroyer=1',
										success:function(msj){
											//alert(msj);
											
											var pagina="login.php";					  
											window.location.href=pagina;
											
											},
											error:function(XMLHttpRequest, textStatus, errorThrown){
												console.log(arguments);
												var error;
												if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
												if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
												//alert("Error ."+error);
											}
										});
									//ValidarSesionActiva('recargar=1');
									//ValidarSesionActiva('destroyer=1');
									
								}
							}						  
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							console.log(arguments);
							var error;
							if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
							if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
							//alert("Error ."+error);
						}
					});
				
				},10000);
});*/


function Guardar_activaciondesesion()
{
	$.ajax({
						type: 'POST',
						url: 'checkSesionTime.php',
						success:function(msj){
							//alert(msj);
							if ( msj == "1" )
							{
								if(confirm("Tu Sesi\u00f3n esta por terminar \n \u00BFDeseas continuar en el sistema?"))
								{
									$.ajax({
										type: 'POST',
										url: ArchivoGurardar,
										data:'recargar=1',
										success:function(msj){
											
											//alert(msj);
											//window.location.href=".";
											},
											error:function(XMLHttpRequest, textStatus, errorThrown){
												console.log(arguments);
												var error;
												if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
												if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
												//alert("Error ."+error);
											}
										});
									//ValidarSesionActiva('recargar=1');
								}
								else
								{
									$.ajax({
										type: 'POST',
										url: ArchivoGurardar,
										data:'destroyer=1',
										success:function(msj){
											//alert(msj);
											
											var pagina="login.php";					  
											window.location.href=pagina;
											
											},
											error:function(XMLHttpRequest, textStatus, errorThrown){
												console.log(arguments);
												var error;
												if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
												if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
												//alert("Error ."+error);
											}
										});
									//ValidarSesionActiva('recargar=1');
									//ValidarSesionActiva('destroyer=1');
									
								}
							}						  
						},
						error:function(XMLHttpRequest, textStatus, errorThrown){
							console.log(arguments);
							var error;
							if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
							if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error
							//alert("Error ."+error);
						}
					});
}