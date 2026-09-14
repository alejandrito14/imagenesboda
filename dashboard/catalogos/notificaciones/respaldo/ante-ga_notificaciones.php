<?php
/*======================= INICIA VALIDACIÓN DE SESIÓN =========================*/

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	/*header("Location: ../../login.php"); */ echo "login";

	exit;
}

/*======================= TERMINA VALIDACIÓN DE SESIÓN =========================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Notificaciones.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Usuarios.php");
require_once("../../clases/class.NotificacionPush.php");
require_once("../../clases/class.NotificacionPushCliente.php");

try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$notificacion = new Notificaciones();
	$f = new Funciones();
	$md = new MovimientoBitacora();

	$clientes = new Clientes();
	$clientes->db=$db;
	$usuarios=new Usuarios();
	$usuarios->db=$db;
	
	//enviamos la conexión a las clases que lo requieren
	$notificacion->db=$db;
	$md->db = $db;	
	$notificacionpush = new NotificacionPush();
	$notificacionpush->db=$db;
	$notificacionpushcliente=new NotificacionPushCliente();
	$notificacionpushcliente->db=$db;
	$db->begin();
		
		

	//Recbimos parametros
	$notificacion->idnotificacion = trim($_POST['id']);

	$notificacion->titulo = trim($f->guardar_cadena_utf8($_POST['v_titulo']));
	$notificacion->mensaje=$_POST['mensaje'];
	$notificacion->programado=$_POST['programado'];
	$notificacion->seleccionar=$_POST['dirigido'];
	$notificacion->todosclientes=$_POST['v_tclientes'];
	$notificacion->todosadmin=$_POST['v_tusuarios'];
	$notificacion->estatus=$_POST['v_estatus'];
	$notificacion->fechahora='';
	



	if ($notificacion->programado==1) {
			$notificacion->enviado=1;

	}

	if ($notificacion->programado==2) {
			$notificacion->enviado=0;
			$hora=$_POST['horaprogramada'];

			if(count($_POST['horaprogramada'])==5) {

				$hora=$_POST['horaprogramada'].':00';
			}

		$notificacion->fechahora=$_POST['fechaprogramada'].' '.$hora;
	}
		$enviocliente=0;
		$enviousuario=0;

	if ($notificacion->seleccionar==1) {
		$enviocliente=1;
		$enviousuario=0;
	}

	if ($notificacion->seleccionar==2) {
		$enviocliente=0;
		$enviousuario=1;
	}

	if ($notificacion->seleccionar==3) {
		$enviocliente=0;
		$enviousuario=0;
	}

	$clientesvar=$_POST['clientes'];
	$usuariosvar=$_POST['usuarios'];



	
	//Validamos si hacermos un insert o un update
	if($notificacion->idnotificacion == 0)
	{
		//guardando
		$notificacion->Guardarnotificacion();
		$md->guardarMovimiento($f->guardar_cadena_utf8('notificacion'),'notificacion',$f->guardar_cadena_utf8('Nuevo notificacion creado con el ID-'.$notificacion->idnotificacion));


		

	}else{


		$notificacion->Modificarnotificacion();	
		$notificacion->EliminarClientesNotificacion();
		$notificacion->EliminarUsuariosNotificacion();
		$md->guardarMovimiento($f->guardar_cadena_utf8('notificacion'),'notificacion',$f->guardar_cadena_utf8('Modificación de notificacion -'.$notificacion->idnotificacion));


	}


	$arraytokensclientes=array();
		$arraytokensusuarios=array();


		if ($clientesvar!='' && $notificacion->todosclientes==1) {
		
			$arregloclientes=explode(',', $clientesvar);

				for ($i=0; $i < count($arregloclientes); $i++) { 

					$notificacion->idcliente=$arregloclientes[$i];
					$notificacion->Guardarclientenotificacion();
					$clientes->idCliente=$arregloclientes[$i];
					$tokencliente=$clientes->ObtenerTokensfirebaseClientes();

				
					if($tokencliente[0]->token!=''){

						$tokens=explode(',',$tokencliente[0]->token);
						for ($a=0; $a < count($tokens); $a++) { 
							array_push($arraytokensclientes,$tokens[$a]);
						}
						

					}

					/*$texto=$notificacion->titulo.'|'.$notificacion->mensaje;
					$notificacionpushcliente->AgregarNotifcacionaCliente($arregloclientes[$i],$texto,'','',0);*/					
				}
			}

			if ($usuariosvar!='' && $notificacion->todosadmin==1) {
				$arreglousuarios=explode(',', $usuariosvar);

				for ($i=0; $i < count($arreglousuarios); $i++) { 

					$notificacion->idusuario=$arreglousuarios[$i];
					$notificacion->Guardarusuarionotificacion();

					$usuarios->id_usuario=$arreglousuarios[$i];
					$tokenusuarios=$usuarios->ObtenerTokenusuarios();
					if($tokenusuarios[0]->tokenusuario!=''){

						$tokens=explode(',',$tokenusuarios[0]->tokenusuario);
						for ($a=0; $a < count($tokens); $a++) { 
								array_push($arraytokensusuarios,$tokens[$a]);

							}
					
				}

					
				}
			}
				//programado 1= ahora,2=fecha hora
			if ($notificacion->programado==1) {

				
				
				$obtenerclavetoken=$notificacion->ObterClaveToken();
				$tokenadmin=$obtenerclavetoken[0]->clavetokenadministrador;
				$tokenapp=$obtenerclavetoken[0]->clavetokennotificacion;



				
				$notificacionpush->apikey=$tokenadmin;
				$notificacionpushcliente->apikey=$tokenapp;

			
					
				

				$arreglousuarios=explode(',', $usuariosvar);
				$arregloclientes=explode(',', $clientesvar);


			if ($enviousuario==1) {
				if ($arreglousuarios[0]!='') {
				for ($i=0; $i < count($arreglousuarios); $i++) { 

		
					$texto=$notificacion->titulo.'|'.$notificacion->mensaje;
					$notificacionpush->AgregarNotifcacionaUsuarios($arreglousuarios[$i],$texto,'','',0);	
					}

				}else{


					if($notificacion->todosadmin==0){

						$obtenerusuarios=$usuarios->ObtTodosUsuarios();

						for ($i=0; $i < count($obtenerusuarios); $i++) { 
							
					$usuarios->id_usuario=$obtenerusuarios[$i]->idusuarios;
					$tokenusuarios=$usuarios->ObtenerTokenusuarios();
					
					if($tokenusuarios[0]->tokenusuario!=''){

						$tokens=explode(',',$tokenusuarios[0]->tokenusuario);
						for ($a=0; $a < count($tokens); $a++) { 
								array_push($arraytokensusuarios,$tokens[$a]);

							}
					
						}

						$texto=$notificacion->titulo.'|'.$notificacion->mensaje;
					$notificacionpush->AgregarNotifcacionaUsuarios($obtenerusuarios[$i]->idusuarios,$texto,'','',0);	

						}


					}
				}

			}

	if ($enviocliente==1) {
			if ($arregloclientes[0]!='') {

				for ($i=0; $i < count($arregloclientes); $i++) { 

					$texto=$notificacion->titulo.'|'.$notificacion->mensaje;
					$notificacionpushcliente->AgregarNotifcacionaCliente($arregloclientes[$i],$texto,'','',0);					
				}

			}else{


				if($notificacion->todosclientes==0){
					$obtenerclientes=$clientes->Todoslosclientes();


					for ($i=0; $i <count($obtenerclientes) ; $i++) { 
						

					$clientes->idCliente=$obtenerclientes[$i]->idcliente;
					$tokencliente=$clientes->ObtenerTokensfirebaseClientes();

				
							if($tokencliente[0]->token!=''){

								$tokens=explode(',',$tokencliente[0]->token);
								for ($a=0; $a < count($tokens); $a++) { 
									array_push($arraytokensclientes,$tokens[$a]);
								}
								

							}
						}


					}


				}

		}

	

				if ($notificacion->seleccionar==4) {
					
					$obtenerclientes=$clientes->ObtenerTokensfirebase();


					for ($i=0; $i <count($obtenerclientes) ; $i++) { 
		
					array_push($arraytokensclientes,$obtenerclientes[$i]->token);
							
							
						
					}
				}



			}




			$db->commit();


			if ($notificacion->programado==1) {
				
					if (count($arraytokensclientes)>0) {
					
					$notificacionpushcliente->EnviarNotificacion($arraytokensclientes,$notificacion->titulo,$notificacion->mensaje);

				}


				if (count($arraytokensusuarios)>0) {

					$notificacionpush->EnviarNotificacion($arraytokensusuarios,$notificacion->titulo,$notificacion->mensaje);
				}

			}

				
	echo "1|".$notificacion->idnotificacion;
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>