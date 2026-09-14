<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	/* header("Location: ../login.php"); */ echo "login";
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Usuarios.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once("../clases/class.Funciones.php");
require_once("../clases/class.AccesoEmpresa.php");



try
{
	$db= new MySQL();
	$us= new Usuarios();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	$acceso=new AccesoEmpresa();
	
	$us->db=$db;
	$md->db = $db;	
	$acceso->db=$db;
	
	$db->begin();
		
	$id = $_GET['idusuario'];
	$acceso->idusuarios=$id;

	$empresas=$acceso->obtenerTodasSucursales();
	$empresas_row=$db->fetch_assoc($empresas);
	$arrayempresa=array();
	do {

		$empresa=array('idsucursales'=>$empresas_row['idsucursales'],'sucursal'=>$empresas_row['sucursal']);

		array_push($arrayempresa, $empresa);
		
	} while ($empresas_row=$db->fetch_assoc($empresas));

		
	$empresaasignada=$acceso->obtenerSucursalAsignadas();
	$empresaasignada_rows=$db->fetch_assoc($empresaasignada);

	$arrayempresa2=array();

		do {

		$empresa2=array('idsucursales'=>$empresaasignada_rows['idsucursales']);

		array_push($arrayempresa2, $empresa2);
		
	} while ($empresaasignada_rows=$db->fetch_assoc($empresaasignada));


	$html="";
	$resul=0;

		for ($i=0; $i <count($arrayempresa); $i++) { 
			$valor=$arrayempresa[$i]['idsucursales'];

				for ($j=0; $j <count($arrayempresa2); $j++) { 
					
					$valor2=$arrayempresa2[$j]['idsucursales'];
					
				if ($valor==$valor2) {
					$resul=1;
					}
				}

				if ($resul==1) {
				$html.='<div class="form-check">
							  <input class="form-check-input position-static accesoempresa" type="checkbox"  id="id_'.$arrayempresa[$i]['idsucursales'].'" value="'.$arrayempresa[$i]['idsucursales'].'" aria-label="" checked>
							    <label class="form-check-label" for="gridCheck">
						       '.$arrayempresa[$i]['sucursal'].'
						      </label>
							</div>';
								$resul=0;

						
				}else{

					$html.='<div class="form-check">
							  <input class="form-check-input position-static accesoempresa" type="checkbox" id="id_'.$arrayempresa[$i]['idsucursales'].'" value="'.$arrayempresa[$i]['idsucursales'].'" aria-label="">
							    <label class="form-check-label" for="gridCheck">
						       '.$arrayempresa[$i]['sucursal'].'
						      </label>
							</div>';
						
				}

		}

		$htmlt='';

		if (count($arrayempresa)==count($arrayempresa2)) {
			
			$htmlt='<div class="form-check">
							  <input class="form-check-input position-static " type="checkbox"  id="id_0" value="0" aria-label="" onchange="SeleccionarTodosAsignados()" checked>
							    <label class="form-check-label" for="gridCheck">
						        Seleccionar todos

						      </label>
							</div>';
		}else{


			$htmlt='<div class="form-check">
							  <input class="form-check-input position-static " type="checkbox" id="id_0" value="0" aria-label="" onchange="SeleccionarTodosAsignados()">
							    <label class="form-check-label" for="gridCheck">
						       Seleccionar todos
						      </label>
							</div>';


		}

	
	$db->commit();
	echo $htmlt.$html;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>