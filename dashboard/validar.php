<?php
require_once("clases/class.Sesion.php");
require_once("clases/class.Funciones.php");
require_once("clases/class.Fechas.php");
require_once("clases/class.Codservicio.php");

error_reporting(E_ALL);

$se = new Sesion();
$conexcion="";


//primero debemos de obtnre los valores de id de servicio   DB, USAURIO DB, CLAVE DB, IP SERVER DB.
//DEBEMOS DE VALIDAR LA FECHA DE VIGENCIA DEL SERVICIO.


			$codservicio = $_POST['codservicio'] ?? 0;
			
      	//	$clave="issoftware";
		//	$cod=new Codservicio();
		//	$rowservicio=$cod->Obtenerconexcion($codservicio,$clave);
			$servicio_num=1;
			//$servicio_row=$rowservicio['datosservidor'];
			//print_r($rowservicio['datosservidor']['vigencia']);die();

			$servicio_row=array('vigencia'=>'2029-01-01',
								'idcliente'=>'0',
								'db'=>'baseboda',
								'db_usuario'=>'root',
								'db_clave'=>'root',
								'db_ip'=>'localhost',
								'codservicio'=>0,
								'carpetaapp'=>'boda',
								'vigente'=>'1'
								);
								
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

			
							$se->crearSesion('se_liempresas','1,2,3');

				

					
	
					//$se->crearSesion('se_sas_Sucursal',$rows['idsucursales']);
									
				
				

					$so = '';
					$navegador ='';

					$fecha_ingreso = '';
					$idusuario=$rows['idusuarios'];
					
				//	$query_usuario = "INSERT INTO bitacora(direccion_ip,sistema_operativo,navegador,fecha_ingreso,idusuarios) VALUES ('$direccion_ip','$so','$navegador','$fecha_ingreso',$idusuario)";
				//	$conexcion->consulta($query_usuario);
					$se->crearSesion('idbitacoraSAS',1);
					
					//creando sesion para saber el tiempo de entrada
					$se->crearSesion('entradaSAS','');	



					
		
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
