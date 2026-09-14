<?php
require_once("clases/class.Sesion.php");
require_once("clases/class.Funciones.php");
require_once("clases/class.Fechas.php");

error_reporting(E_ALL);

$se = new Sesion();



//primero debemos de obtnre los valores de id de servicio   DB, USAURIO DB, CLAVE DB, IP SERVER DB.
//DEBEMOS DE VALIDAR LA FECHA DE VIGENCIA DEL SERVICIO.


		$codservicio = $_POST['codservicio'];
       // $con2 = mysqli_connect("189.193.4.113","pepe","121275","isadmin");
        $con2 = mysqli_connect("is-software.net","issoftwa_prueba","prueba","issoftwa_admin");

			       //  mysql_select_db("isadmin",$con2);
           //  $con2 = mysqli_connect("192.169.197.189","issoftware","qr=]3JKxsT+3!","isadmin");



		
			$consulta = "SELECT * FROM servicios_clientes WHERE idservicios_clientes = '$codservicio'";
			

			$servicio =  $con2->query($consulta); 
					

			$servicio_row =  mysqli_fetch_assoc($servicio);  
			$servicio_num=mysqli_num_rows($servicio);


		    if( $servicio_num  != 0)
			{
				//obtenemos la fecha de la base de datos en su vigencia.
				
				$f_vigencia = date("Y-m-d",strtotime($servicio_row['vigencia']));
				$f_actual = date("Y-m-d");

				if ($f_actual<=$f_vigencia) {

					$se->crearSesion('db_cliente',$servicio_row['db']);
					$se->crearSesion('idcliente',$servicio_row['idcliente']);
					$se->crearSesion('vigencia_cliente',$servicio_row['vigencia']);
					$se->crearSesion('dbusuario_cliente',$servicio_row['db_usuario']);
					$se->crearSesion('dbclave_cliente',$servicio_row['db_clave']);
					$se->crearSesion('ip_cliente',$servicio_row['db_ip']);
					$se->crearSesion('codservicio',$codservicio);

					$se->crearSesion('carpetaapp',$servicio_row['carpetaapp']);

					$vigente=1;
					
					/*$conexcion->servidor=$servicio_row['db_ip'];
					$conexcion->usuario=$servicio_row['db_usuario'];
					$conexcion->contrase=$servicio_row['db_clave'];
					$conexcion->db=$servicio_row['db'];*/
						include('clases/conexcion.php');

						$conexcion= new MySQL();





					
				}else
				{

					$vigente=0;

				}
				
				
				
			}else{

				$vigente=0;

				
			}
		



//TERMINAMOS DE VALIDAR EL SERVICIO.


if($vigente == 1)
{


	//include('clases/class.Login.php');
	$usuario = $_POST['usuario'];
	$contrasena = $_POST['contrasena'];
	$tabla = "usuarios";

	$query= "SELECT * FROM ".$tabla." WHERE usuario LIKE BINARY'".$usuario."' AND clave LIKE BINARY '".$contrasena."'";


			$resp=$conexcion->consulta($query);
			
			$rows=$conexcion->fetch_assoc($resp);
			$total=$conexcion->num_rows($resp);
		

			if($total>0)
			{
				if($rows['estatus']==0)
				{
					return 2;
				}
				else
				{

					$se->crearSesion('se_SAS',1);
					$se->crearSesion('se_Empleado',$rows['nombre'].' '.$rows['paterno'].' '.$rows['materno']);
					$se->crearSesion('se_sas_Perfil',$rows['idperfiles']);
					$se->crearSesion('se_sas_Usuario',$rows['idusuarios']);
					$se->crearSesion('se_sas_Tipo',$rows['tipo']);

					$queryempresas = "SELECT GROUP_CONCAT(idsucursales) as idempresase FROM acceso_sucursal_empleado WHERE idusuarios=".$rows['idusuarios'];
				
					$resp2=$conexcion->consulta($queryempresas);
					$rows2=$conexcion->fetch_assoc($resp2);
					$total2=$conexcion->num_rows($resp2);

					if ($total2 == 0 || $rows2['idempresase'] == NULL) {
							$se->crearSesion('se_liempresas',0);

					}else{
							$se->crearSesion('se_liempresas',$rows2['idempresase']);

					}

					
	
					//$se->crearSesion('se_sas_Sucursal',$rows['idsucursales']);
									
					$fn=new Funciones();
				
				
					$direccion_ip = $_SERVER['REMOTE_ADDR'];

					$so = $fn->sistema_o();
					$navegador = $fn->navegador();
				    $fe=new Fechas();

					$fecha_ingreso = $fe->fecha_hora_segundos();
					$idusuario=$rows['idusuarios'];
					
					$query_usuario = "INSERT INTO bitacora(direccion_ip,sistema_operativo,navegador,fecha_ingreso,idusuarios) VALUES ('$direccion_ip','$so','$navegador','$fecha_ingreso',$idusuario)";
					$conexcion->consulta($query_usuario);
					$se->crearSesion('idbitacoraSAS',$conexcion->id_ultimo());
					
					//creando sesion para saber el tiempo de entrada
					$se->crearSesion('entradaSAS',time());	



					$ruta=array('catalogos/categoriasproducto/imagenes','catalogos/configuracion/imagenes','catalogos/paquetes/imagenespaquete','catalogos/sucursales/imagenes','catalogos/sucursales/imagenesticket','catalogos/secciones/imagenes','catalogos/secciones/imagenesrevista','catalogos/secciones/imagenespromo','catalogos/secciones/imagenesnoticias','catalogos/secciones/imagenesfecha','catalogos/anuncios/imagenes');


					for ($i=0; $i < count($ruta); $i++) { 

						$nombre_fichero=$ruta[$i].'/'.$codservicio;

						
						if (!file_exists($nombre_fichero)) {
							    
							   mkdir($nombre_fichero,0777, true);
							  // chmod($nombre_fichero, 0777);
							} 
					}
		
					echo  1;
				}
				
				
			}
			else
			{
				//return "El Usuario no existe";
				return 0;
			}

	//$quepaso = $lo->ValidandoDatos();


}else
{


	echo 2;  //este valor es por que la vigencia o servicio no exiten.
}






?>