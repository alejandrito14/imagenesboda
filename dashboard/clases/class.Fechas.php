<?php
  class Fechas
  {
	  public $diasSemana = array('domingo','lunes','marte','miercoles','jueves','viernes','sabado');
	  public $mesesAnho = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	  public $mesesAnho3 = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	  public $mesessms = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	
	public function Fechas()
	{
		date_default_timezone_set("UTC");
	}  
		
	
	public function semanaano()
	{
		$semanaano = date('W');
		return $semanaano;
	}
	
	public function diasemana()
	{
	    $diaSemana = date('w');
		return $diaSemana;
	}
	  
	public function diames()
	{
 		$diaMes = date('j');
		return $diaMes;
	}
	
	public function diamesDosdigitos()
	{
 		$diaMes = date('d');
		return $diaMes;
	} 
	 
	public function mesAnho()
	{
		$mesAnho = date('n');
		return $mesAnho;
	}
	  
	public function mesAnhoDosdigitos()
	{
		$mesAnho = date('m');
		return $mesAnho;
	}
	 
	public function anho()
	{
	   $anho = date("Y");
	   return $anho;
	}
	 
	public function anomes()
	{
		 $anomes = date("Y-m");
		 return $anomes;
	}
	  
	public function fechaaYYYY_mm_dd_guion()
	{
		 $fechaactual=date("Y-m-d");
		 return $fechaactual;
	} 
	 
	public function fechaaYYYY_mm_dd_entre()
	{
		$fechaactual=date("Y/m/d");
		return $fechaactual;
	} 
	  
	 public function fechaadd_mm_YYYY_guion()
	 {
		 $fechaactual=date("d-m-Y");
		 return $fechaactual;
	 } 
	 
	 public function fechaadd_mm_YYYY_entre()
	 {
		 $fechaactual=date("d/m/Y");
		 return $fechaactual;
	 } 
	 
	 public function hora()
	 {
		 $purahora=date('H');
		 return $purahora;
	 }
	 
	 public function hh_mm_ss()
	 {
		   $hora = date('H');
	       $hora .= ":";
	       $hora .= date('i');
	       $hora.= ":";
	       $hora.= date('s');
		   return $hora;
	 }
	  
	 public function fecha_hora_segundosentre()
	 {
	     $fechahora = $this->fechaaYYYY_mm_dd_entre()." ".$this->hh_mm_ss(); //fecha mas hora
		 return $fechahora;
	 }
	  
	 public function fecha_hora_segundos()
	 {
	     $fechahora = $this->fechaaYYYY_mm_dd_guion()." ".$this->hh_mm_ss(); //fecha mas hora
		 return $fechahora;
	 }
	 
     public function fecha_hora_parrafo($tipo)
	 {
		 if($tipo==1)
		 {
	        $fecha = $this->diasSemana[$this->diasemana()]." ".$this->diames()." de ".$this->mesesAnho[$this->mesAnho()-1]." del ".$this->anho()." A Las ".$this->hh_mm_ss(); //fecha y hora en parrafo.
		 }
		 else
		 {
		    $fecha =  $this->diasSemana[$this->diasemana()]." ".$this->diames()." de ".$this->mesesAnho[$this->mesAnho()-1]." del ".$this->anho(); //fecha en parrafo
		 }
		 
		 return $fecha;
	 }
//setlocale(LC_TIME, "es_ES"); //hora en español.
//funcion que me da la semana del año.
	public function weekyear ($date)
    {
		$date = substr($date,0,10);	
		list($year, $month, $day) = explode('-', $date);
		return strftime("%W", mktime(0,0,0,$month,$day,$year));
    }

//funcion que me da el dia de la semana
	public function dayweek($date)
	{
	  $date = substr($date,0,10);	
	  //echo $date;
	  list($year, $month, $day) = explode('-', $date);
	  return strftime("%w", mktime(0,0,0,$month,$day,$year));
	}

//funcion que me da el dia del mes
	public function diadelmes($date)
	{
		  $date = substr($date,0,10);	
		  //echo $date;
		  list($year, $month, $day) = explode('-', $date);
		  return strftime("%d", @mktime(0,0,0,$month,$day,$year));
	}
	

//funcion ue me da el mes del año
	public function mesdelano($date)
	{
		$date = substr($date,0,10);	
		//echo $date;
		list($year, $month, $day) = explode('-', $date);
		return strftime("%m", @mktime(0,0,0,$month,$day,$year));
	}

//funcion que me regresa el año solamente
	public function elano($date)
	{
		$date = substr($date,0,10);	
		//echo $date;
		list($year, $month, $day) = explode('-', $date);
		return strftime("%Y", @mktime(0,0,0,$month,$day,$year));
	}
	
//funcion que me regresa la fecha solamente de un date time
	public function sub_fecha($date)
   {
	 $sub = substr($date,0,10);	
	 return $sub;
   }

  	public function sub_hora($date)
   {
	 $sub = substr($date,11,18);	
	 return $sub;
   } 

//funcion que cambia el formato de la fecha a mexicana  
	public function f_esp($fecha)
	{
		$a = $this->elano($fecha);
		$m = $this->mesdelano($fecha);
		$d = $this->diadelmes($fecha);
		$f = $d."/".$m."/".$a;
		return $f;		
	 }

//esta repeteida esta funcion
	public function fecha_esp($fecha)
	{		
		$a = $this->elano($fecha);
		$m = $this->mesdelano($fecha);
		$d = $this->diadelmes($fecha);
		$f = $d."-".$m."-".$a;
		return $f;			
	}	 


//compara dos fechas.. si la fecha uno es mayor que la fecha dos.
	public function datecmp($f1, $f2)
	{
		
		$fecha1=strtotime($f1);
		$fecha2=strtotime($f2);
	
     	if($fecha1 >= $fecha2)
	    {
           return 1;
	    }
		  else
	    {
		  return 0;
	    }
	} 
// Fecha en formato dd/mm/yyyy o dd-mm-yyyy retorna la diferencia en dias
	public function restaFechas($dFecIni, $dFecFin)
    {
	  $dFecIni = str_replace("-","",$dFecIni);
	  $dFecIni = str_replace("/","",$dFecIni);
	  $dFecFin = str_replace("-","",$dFecFin);
	  $dFecFin = str_replace("/","",$dFecFin);
	  
	  @ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	  @ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
	  
	  //echo $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	  //echo "<br>";
	  //echo $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
	  
	  return round(($date2 - $date1) / (60 * 60 * 24));
    }
	

//fucion que suma dias a una fecha	
	public function sumaDia($fecha,$dia)
	{
	   list($year,$mon,$day) = explode('-',$fecha);
	   return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));
	}	
	
	
	public function restaDia($fecha,$dia)
	{
	   list($year,$mon,$day) = explode('-',$fecha);
	   return date('Y-m-d',mktime(0,0,0,$mon,$day-$dia,$year));
	}	
	
	
	public function sumaAnho($fecha,$anhos)
	{
	   list($year,$mon,$day) = explode('-',$fecha);
	   return date('Y-m-d',mktime(0,0,0,$mon,$day,$year+$anhos));
	}
	
	public function sumaMes($fecha,$mes)
	{
	   list($year,$mon,$day) = explode('-',$fecha);
	   return date('Y-m-d',mktime(0,0,0,$mon+$mes,$day,$year));
	}		


//funcion de fecha  tipo  dia de mes del año
	public function fecha_texto($fecha)
	{
				
		$a = $this->elano($fecha);
		$m = $this->mesdelano($fecha);
		$d = $this->diadelmes($fecha);
		
		//$m = str_replace("0","",$m);
		
		$m = $this->mesesAnho[$m-1];
		$f = $d." de ".$m." del ".$a;
		return $f;
	}
	
	public function fecha_textoguion($fecha)
	{
				
		$a = $this->elano($fecha);
		$m = $this->mesdelano($fecha);
		$d = $this->diadelmes($fecha);
		
		//$m = str_replace("0","",$m);
		
		$m = $this->mesesAnho[$m-1];
		$f = $d."-".$m."-".$a;
		return $f;
	}
	
	public function fecha_textoguion3($fecha)
	{
				
		$a = $this->elano($fecha);
		$m = $this->mesdelano($fecha);
		$d = $this->diadelmes($fecha);
		
		//$m = str_replace("0","",$m);
		
		$m = $this->mesesAnho3[$m-1];
		$f = $d."-".$m."-".$a;
		return $f;
	}


//funcion restar horas.
	public function restarhoras($horaini,$horafin)
	{
		$horai=substr($horaini,0,2);
		$mini=substr($horaini,3,2);
		//$segi=substr($horaini,6,2);
	 
		$horaf=substr($horafin,0,2);
		$minf=substr($horafin,3,2);
		//$segf=substr($horafin,6,2);
	 
		$ini=((($horai*60)*60)+($mini*60)/*+$segi*/);
		$fin=((($horaf*60)*60)+($minf*60)/*+$segf*/);
	 
		$dif=$fin-$ini;
	 
		$difh=floor($dif/3600);
		$difm=floor(($dif-($difh*3600))/60);
		//$difs=$dif-($difm*60)-($difh*3600);
		return date("H:i",mktime($difh,$difm));
		//return date("H-i-s",mktime($difh,$difm,$difs));
	}
	
	public function restaMes($fecha,$mes)
    {
	   list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon-$mes,$day,$year));
    }
	
	
	//saber cuantos dias tiene el mes del año
	
	function DiasDelMes($Month, $Year)
		{
		   //Si la extensión que mencioné está instalada, usamos esa.
		   if( is_callable("cal_days_in_month"))
				 {
					return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
				 }
				 else
				 {
					//Lo hacemos a mi manera.
					return date("d",mktime(0,0,0,$Month+1,0,$Year));
				 }
		}
	
	
	//funcion para saber los dias de diferencia en tre 2 fechas
	public function DiferenciaDias($fechaActual,$fechaFutura)
	{
		//defino fecha 1 
		$ano1 = $this->elano($fechaActual);
		$mes1 = $this->mesdelano($fechaActual);
		$dia1 = $this->diadelmes($fechaActual);
		
		//defino fecha 2 
		$ano2 = $this->elano($fechaFutura); 
		$mes2 = $this->mesdelano($fechaFutura); 
		$dia2 = $this->diadelmes($fechaFutura);
		
		//calculo timestam de las dos fechas 
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
		$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2); 
		
		//resto a una fecha la otra 
		$segundos_diferencia = $timestamp1 - $timestamp2; 
		//echo $segundos_diferencia; 
		
		//convierto segundos en días 
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
		
		//obtengo el valor absoulto de los días (quito el posible signo negativo) 
		$dias_diferencia = abs($dias_diferencia); 
		
		//quito los decimales a los días de diferencia 
		$dias_diferencia = floor($dias_diferencia); 
		
		return $dias_diferencia;
	}
	
	//funcion para obtener solo la fecha de un campo datetime de la base de datos  
	public function fecha_date($date)
	{
		$fecha1 = explode("-",$date);
		$dia = explode(" ",$fecha1[2]);
		
		$fecha_final = $fecha1[0]."-".$fecha1[1]."-".$dia[0];
		return $fecha_final;
		
	}
	
	public function diaultimodelsiguientemes()
	{
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		
		$f = explode('-',$nuevafecha);
		$month = $f[1];
		$year = $f[0];
		$day = date("d",mktime(0,0,0, $month+1, 0, $year));
		
		$nuevafecha = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
		
		return $nuevafecha;
	}
	
	public function ultimodiadelmes()
	{
		$fecha = date('Y-m-j');
		//$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		//$nuevafecha = date ( 'Y-m-j' , $fecha );
			
		$f = explode('-',$fecha);
		$month = $f[1];
		$year = $f[0];
		$day = date("d",mktime(0,0,0, $month+1, 0, $year));
		
		$nuevafecha = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
		
		return $nuevafecha;
	}

		    /** Obtener el ultimo dia del mes actual **/
  function Ultimodia_mes_actual() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  }
 
  /** Obtener el primerdia del mes actual **/
  function Primerdia_mes_actual() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }  
  

  }
?>