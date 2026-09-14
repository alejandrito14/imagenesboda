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
require_once("../../clases/class.PaquetesSucursales.php");
require_once("../../clases/class.Funciones.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Paquetes.php");



try
{
	//declaramos los objetos de clase
	$db = new MySQL();
	$paquetessucursales = new PaquetesSucursales();
	$f = new Funciones();
	$md = new MovimientoBitacora();
	
	//enviamos la conexión a las clases que lo requieren
	$paquetessucursales->db=$db;
	$md->db = $db;	

	$paquetes=new Paquetes();

	$paquetes->db=$db;
	
	$db->begin();
		

	//Recbimos parametros
	$paquetessucursales->idsucursal = trim($_POST['idsucursal']);
	$idsucursal=$_POST['idsucursal'];

	$paquetes->nombre=$_POST['buscador'];

	$seleccionar=$paquetes->FiltrarPaquetes();
	$cont = $db->num_rows($seleccionar);
	$rowpaquete=$db->fetch_assoc($seleccionar);


	do { ?>

		<div class="form-check pasu_<?php echo $row['idsucursales'];?>"  id="pasu_<?php echo $row['idsucursales'];?>">

						    			<?php 

						    			$idpaquete=$rowpaquete['idpaquete'];
						    			$estacheckeado=$paquetes->ObtenerPaqueteSucursal($idsucursal,$idpaquete);
						    			$valor="";
						    			if ($estacheckeado>0) {
						    				$valor="checked";
						    			}

						    			?>
									  <input  type="checkbox" value="" class="form-check-input paquetesucursal_<?php echo $row['idsucursales'];?>" id="input_<?php echo $rowpaquete['idpaquete']?>_<?php echo $row['idsucursales'];?>" <?php echo $valor; ?>>
									  <label class="form-check-label" for="flexCheckDefault">
									    <?php echo $rowpaquete['nombrepaquete']; ?>
									  </label>
									</div>

		
	<?php } while ($rowpaquete =$db->fetch_assoc($seleccionar));

		
		



	
	
}catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>