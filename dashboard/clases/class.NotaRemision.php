<?php 

/**
 * 
 */
class NotaRemision
{
	
	public $idnota_remision;
	public $db;					//Objeto de conexion
	public $idcliente;
	public $estatus;
	public $idsucursales;
	public $fechainicial;
	public $fechafinal;
	public $idpayment;
	public function ObtenerdetalleNota()
	{
		$sql="SELECT				
		nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.idclientes_envios,
				nota_remision.direcciondeenvio,
				sucursales.sucursal,
				sucursales.tventa,
				sucursales.tproduccion,
				nota_remision.total,
				nota_remision.subtotal,
				nota_remision.fechapedido,
				DATE_FORMAT(nota_remision.fechapedido, '%d/%m/%Y %H:%i:%s') as fechapedidoformato,
				clientes.nombre,
				clientes.paterno,
				clientes.materno,
				clientes.celular,
				nota_remision.rutacomprobante,
				nota_remision.confechaentrega,
				nota_remision.opcionelegidapago,
				nota_remision.opcionelegida,
				nota_remision.formapago,
				nota_remision.metodopago,
				nota_remision.usocfdi,
				usocfdi.descripcion AS usocfdidescripcion,
				metodopago.descripcion AS metodopagodescripcion,
				formapago.descripcion AS formapagodescripcion,
				nota_remision.requierefactura,
				nota_remision.datosfacturacion,
				nota_remision.observacionespedido,
                nota_remision.fechaparaentrega,
                nota_remision.fechaaceptado,
                nota_remision.fechaenviado,
                nota_remision.fechacancelacion,
                nota_remision.montopagocliente,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal,
                nota_remision.sumatotalapagar

				FROM
				nota_remision 
				
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				JOIN clientes
				ON nota_remision.idcliente = clientes.idcliente
				LEFT OUTER JOIN usocfdi
				ON nota_remision.usocfdi = usocfdi.c_uso 
				LEFT OUTER  JOIN metodopago
				ON nota_remision.metodopago = metodopago.c_metodopago 
				LEFT OUTER JOIN formapago
					ON nota_remision.formapago = formapago.cformapago
				WHERE nota_remision.idnota_remision= ".$this->idnota_remision."";

			$resp=$this->db->consulta($sql);
			return $resp;
	}

	public function Obtenerdescripcion()
	{
		$sql="SELECT
				nota_remision_descripcion.nombre,
				nota_remision_descripcion.descripcion,
				nota_remision_descripcion.cantidad,
				nota_remision_descripcion.precio,
				nota_remision_descripcion.complementos,
				nota_remision_descripcion.promocion,
				nota_remision_descripcion.cantidadpromo,
				nota_remision_descripcion.considerar,
				nota_remision_descripcion.porfechas,
				nota_remision_descripcion.directo,
				nota_remision_descripcion.repetitivo,
		 		nota_remision_descripcion.idpaquete,
				nota_remision_descripcion.idnota_remision,
				nota_remision_descripcion.idnota_remision_descripcion,
				paquetes.foto as img,
				nota_remision_descripcion.preciooriginal,
				nota_remision_descripcion.productos,
				nota_remision_descripcion.comentario,
				nota_remision_descripcion.tituloscomplementos

				FROM
				nota_remision
				JOIN nota_remision_descripcion
				ON nota_remision.idnota_remision = nota_remision_descripcion.idnota_remision 
				JOIN paquetes
				ON nota_remision_descripcion.idpaquete = paquetes.idpaquete
				WHERE nota_remision.idnota_remision=".$this->idnota_remision."";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}

	public function ObtenerTodosPedidos()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
               	nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal


				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus=".$this->estatus."";
				}

				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}





	public function ObtenerTodosPedidosAdmin($min,$max)
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				clientes.nombre,
				clientes.paterno,
				clientes.materno,
				clientes.celular,
				nota_remision.fechapedido,
				nota_remision.fechaaceptado,
				nota_remision.fechaenviado,
				nota_remision.fechacancelacion,
				nota_remision.montopagocliente,
				nota_remision.opcionelegida,
				nota_remision.etiquetamostrar,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                  nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra
				
				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				JOIN clientes
				ON nota_remision.idcliente = clientes.idcliente
				WHERE 1=1  AND sucursales.idsucursales=".$this->idsucursales."";

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus IN(".$this->estatus.")";
				}

				if ($min!='') {

					$sql.=" AND (nota_remision.fechapedido BETWEEN '".$min."' AND '".$max."')";
				}

				if ($this->fechainicial!='' && $this->fechafinal!='') {
				
				$sql.=" AND (nota_remision.fechapedido BETWEEN '".$this->fechainicial."' AND '".$this->fechafinal."')";

				}

				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}

	



	public function CambiarEstatusPedido()
	{
		$query="UPDATE nota_remision SET estatus='$this->estatus'
		 WHERE idnota_remision=$this->idnota_remision";
	
		$resp=$this->db->consulta($query);
	}

	 public function CambiarEstatusPedido2()
        {
            $query="UPDATE nota_remision SET estatus='$this->estatus'
             WHERE idnota_remision=$this->idnota_remision";

        
            $resp=$this->db->consulta($query);
        }



	public function Actualizarfecha($campo,$fechaactual)
	{
		$query="UPDATE nota_remision SET $campo='$fechaactual'	
		 WHERE idnota_remision=$this->idnota_remision";
	
		$resp=$this->db->consulta($query);
	}


	public function Actualizarfechaaceptadoenviado()
	{
		$query="UPDATE nota_remision SET fechaaceptado='',
						fechaenviado=''
		 WHERE idnota_remision=$this->idnota_remision";
	
		$resp=$this->db->consulta($query);
	}

	public function ObtenerTodosPedidosEstatus()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.etiquetamostrar,
				nota_remision.montopagocliente,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                  nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                 nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal


				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus=".$this->estatus."";
				}

			


				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function AgregarRegistroCambio($comentario,$estatusanterior,$estatus,$idnota_remision,$idusuario)
	{
		$query="INSERT INTO comentariosnota (comentario,estatusanterior,estatus,idnota_remision,idusuario) VALUES ('$comentario','$estatusanterior','$estatus','$idnota_remision','$idusuario');";
		$resp=$this->db->consulta($query);
	}

	public function ObtenerComentarios()
	{
		$sql="SELECT
				comentariosnota.idcomentariosnota,
				comentariosnota.comentario,
				comentariosnota.estatusanterior,
				comentariosnota.estatus,
				comentariosnota.idusuario,
				comentariosnota.idnota_remision,
				estatus.comentariodefault,
				comentariosnota.fecha
				FROM
				comentariosnota
				JOIN estatus
				ON comentariosnota.estatus = estatus.codigoestatus
				WHERE idnota_remision=".$this->idnota_remision." ORDER BY fecha ASC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function ObtenerTodosPedidosClienteEstatus()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.etiquetamostrar,
				nota_remision.montopagocliente,
				nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                nota_remision.nuevototal,
                nota_remision.montodescontado,
                nota_remision.codigocupon,
                nota_remision.idcupon,
                nota_remision.datoscupon,
                 nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal


				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus IN(".$this->estatus.")";
				}

				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function obtenerImagenesComprobantes()
	{
			$sql="SELECT
					rutacomprobante,
					fecha,
					idnota_remision,
					idimagencomprobante,
					estatus,
					comentario
					FROM
					imagencomprobante  
					WHERE idnota_remision=".$this->idnota_remision." ORDER BY fecha ASC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function ObtenerUltimoComentario()
	{
		
		$sql="SELECT *FROM comentariosnota  WHERE idnota_remision='$this->idnota_remision' order by idcomentariosnota desc limit 1";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	

	}


		public function ObtenerTodosPedidosEstatusdia()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.etiquetamostrar,
				nota_remision.montopagocliente,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                nota_remision.nuevototal,
                nota_remision.montodescontado,
                nota_remision.codigocupon,
                nota_remision.idcupon,
                nota_remision.datoscupon,
                 nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal

				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus=".$this->estatus."";
				}

				$sql.=" AND (nota_remision.fechapedido BETWEEN '".$this->fechainicial."' AND '".$this->fechafinal."')";
			


				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}
	/* public function CambiarEstatusPedido2()
        {
            $query="UPDATE nota_remision SET estatus='$this->estatus'
             WHERE idnota_remision=$this->idnota_remision";

        
            $resp=$this->db->consulta($query);
        }*/


      public function CambiarEstatusPagoNorealizado()
	{
		$query="UPDATE nota_remision SET estatus='$this->estatus'	
		 WHERE idnota_remision=$this->idnota_remision";
	
		$resp=$this->db->consulta($query);
	}


	public function ActualizaridStripe()
	{
		$query="UPDATE nota_remision SET idtransaccionstripe='$this->idpayment'	
		 WHERE idnota_remision=$this->idnota_remision";
	
		$resp=$this->db->consulta($query);
	}



	public function ObtenerTodosPedidosAdmin2($min,$max)
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				clientes.nombre,
				clientes.paterno,
				clientes.materno,
				clientes.celular,
				nota_remision.fechapedido,
				nota_remision.fechaaceptado,
				nota_remision.fechaenviado,
				nota_remision.fechacancelacion,
				nota_remision.montopagocliente,
				nota_remision.opcionelegida,
				nota_remision.etiquetamostrar,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                  nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra
				
				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				JOIN clientes
				ON nota_remision.idcliente = clientes.idcliente
				WHERE 1=1  AND sucursales.idsucursales=".$this->idsucursales."";

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus IN(".$this->estatus.")";
				}

				if ($min!='') {

					$sql.=" AND (nota_remision.fechapedido BETWEEN '".$min."' AND '".$max."')";
				}

				if ($this->fechainicial!='' && $this->fechafinal!='') {
				
				$sql.=" AND (nota_remision.fechapedido BETWEEN '".$this->fechainicial."' AND '".$this->fechafinal."')";

				}

				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function ObtenerTodosPedidosEstatusdia2()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.etiquetamostrar,
				nota_remision.montopagocliente,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                  nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.sumatotalapagar


				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus=".$this->estatus."";
				}

				$sql.=" AND (nota_remision.fechapedido BETWEEN '".$this->fechainicial."' AND '".$this->fechafinal."')";
			


				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


	public function ObtenerdetalleNota2()
	{
		$sql="SELECT				
		nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.idclientes_envios,
				nota_remision.direcciondeenvio,
				sucursales.sucursal,
				sucursales.tventa,
				sucursales.tproduccion,
				nota_remision.total,
				nota_remision.subtotal,
				nota_remision.fechapedido,
				DATE_FORMAT(nota_remision.fechapedido, '%d/%m/%Y %H:%i:%s') as fechapedidoformato,
				clientes.nombre,
				clientes.paterno,
				clientes.materno,
				clientes.celular,
				nota_remision.rutacomprobante,
				nota_remision.confechaentrega,
				nota_remision.opcionelegidapago,
				nota_remision.opcionelegida,
				nota_remision.formapago,
				nota_remision.metodopago,
				nota_remision.usocfdi,
				usocfdi.descripcion AS usocfdidescripcion,
				metodopago.descripcion AS metodopagodescripcion,
				formapago.descripcion AS formapagodescripcion,
				nota_remision.requierefactura,
				nota_remision.datosfacturacion,
				nota_remision.observacionespedido,
                nota_remision.fechaparaentrega,
                nota_remision.fechaaceptado,
                nota_remision.fechaenviado,
                nota_remision.fechacancelacion,
                nota_remision.montopagocliente,
                nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                nota_remision.idcupon,
                nota_remision.codigocupon,
                nota_remision.montodescontado,
                nota_remision.nuevototal,
                nota_remision.datoscupon,
                nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal,
                nota_remision.sumatotalapagar,
                nota_remision.totalantivaenvio,
                nota_remision.datostarjeta,
                nota_remision.datostarjeta2,
                nota_remision.datostarjeta2,
                nota_remision.montonuevoafacturar

				FROM
				nota_remision 
				
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				JOIN clientes
				ON nota_remision.idcliente = clientes.idcliente
				LEFT OUTER JOIN usocfdi
				ON nota_remision.usocfdi = usocfdi.c_uso 
				LEFT OUTER  JOIN metodopago
				ON nota_remision.metodopago = metodopago.c_metodopago 
				LEFT OUTER JOIN formapago
					ON nota_remision.formapago = formapago.cformapago
				WHERE nota_remision.idnota_remision= ".$this->idnota_remision."";

			$resp=$this->db->consulta($sql);
			return $resp;
	}


	public function Obtenerdescripcion2()
	{
		$sql="SELECT
				nota_remision_descripcion.nombre,
				nota_remision_descripcion.descripcion,
				nota_remision_descripcion.cantidad,
				nota_remision_descripcion.precio,
				nota_remision_descripcion.complementos,
				nota_remision_descripcion.promocion,
				nota_remision_descripcion.cantidadpromo,
				nota_remision_descripcion.considerar,
				nota_remision_descripcion.porfechas,
				nota_remision_descripcion.directo,
				nota_remision_descripcion.repetitivo,
				nota_remision_descripcion.idpaquete,
				nota_remision_descripcion.idnota_remision,
				nota_remision_descripcion.idnota_remision_descripcion,
				paquetes.foto as img,
				nota_remision_descripcion.preciooriginal,
				nota_remision_descripcion.productos,
				nota_remision_descripcion.comentario,
				nota_remision_descripcion.tituloscomplementos,
				nota_remision_descripcion.totpaq,
				nota_remision_descripcion.totantespagar,
				nota_remision_descripcion.ivapaquete,
				nota_remision_descripcion.totpaqdespuesiva,
				nota_remision_descripcion.totpaquedesc

				

				FROM
				nota_remision
				JOIN nota_remision_descripcion
				ON nota_remision.idnota_remision = nota_remision_descripcion.idnota_remision 
				JOIN paquetes
				ON nota_remision_descripcion.idpaquete = paquetes.idpaquete
				WHERE nota_remision.idnota_remision=".$this->idnota_remision."";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}


public function ObtenerTodosPedidosClienteEstatus2()
	{
		$sql="SELECT
				nota_remision.idnota_remision,
				nota_remision.idsucursales,
				nota_remision.folio,
				nota_remision.idcliente,
				nota_remision.idusuarios,
				nota_remision.fechapedido,
				nota_remision.fecha_pago,
				nota_remision.tipo_pago,
				nota_remision.no_seguridad,
				nota_remision.facturado,
				nota_remision.estatus,
				nota_remision.direcciondeenvio,
				nota_remision.usocfdi,
				nota_remision.idcliente_monedero2,
				nota_remision.metodopago,
				nota_remision.formapago,
				sucursales.sucursal,
				nota_remision.total,
				nota_remision.etiquetamostrar,
				nota_remision.montopagocliente,
				nota_remision.datoscosto,
                nota_remision.confoto,
                nota_remision.habilitarsumaenvio,
                nota_remision.nuevototal,
                nota_remision.montodescontado,
                nota_remision.codigocupon,
                nota_remision.idcupon,
                nota_remision.datoscupon,
                 nota_remision.montoafacturar,
                nota_remision.ivacompra,
                nota_remision.comision,
                nota_remision.comisiontotal,
                nota_remision.comisionmonto,
                nota_remision.impuestototal,
                nota_remision.sumatotalapagar,
                nota_remision.totalantivaenvio

				FROM
				nota_remision 
				INNER JOIN sucursales ON nota_remision.idsucursales=sucursales.idsucursales
				WHERE nota_remision.idcliente=".$this->idcliente."" ;

				if ($this->estatus!='') {
					$sql.=" AND nota_remision.estatus IN(".$this->estatus.")";
				}

				$sql.=" ORDER BY nota_remision.idnota_remision DESC";

		$resp=$this->db->consulta($sql);
		$cont = $this->db->num_rows($resp);


		$array=array();
		$contador=0;
		if ($cont>0) {

			while ($objeto=$this->db->fetch_object($resp)) {

				$array[$contador]=$objeto;
				$contador++;
			} 
		}
		
		return $array;
	}

}

 ?>
