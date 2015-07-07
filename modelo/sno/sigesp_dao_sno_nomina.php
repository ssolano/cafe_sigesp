<?php
/****************************************************************************
* @Modelo para las funciones de nomina.
* @fecha de creaci�n: 09/10/2008.
* @autor: Ing.Gusmary Balza
********************************************************************************
* @fecha modificaci�n: 03/11/2008
* @descripci�n: Se cambio la manera de conectarse a la Base de Datos.
* @autor: Ing. Yesenia Moreno de Lang
*****************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/modelo/sss/sigesp_dao_sss_registroeventos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/modelo/sss/sigesp_dao_sss_registrofallas.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_funciones.php');
require_once('sigesp_dao_sno_periodo.php');

class Nomina extends ADOdb_Active_Record
{
	var $_table = 'sno_nomina';
	public $servidor;
	public $usuario;
	public $clave;
	public $basedatos;
	public $gestor;
	public $tipoconexionbd = 'DEFECTO';
	public $valido = true;
	public $mensaje;
	public $cadena = '';
	public $criterio = '';
	public $seguridad = true;
	public $codsis;
	public $nomfisico;
	public $codnuenom;


/***********************************************************************************
* @Funci�n para seleccionar con que conexion a Base de Datos se va a trabajar
* @parametros: 
* @retorno:
* @fecha de creaci�n: 06/11/2008.
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	public function selecionarConexion (&$conexionbd)
	{
		global $conexionbd;
		
		if ($this->tipoconexionbd != 'DEFECTO')
		{
			$conexionbd = conectarBD($this->servidor, $this->usuario, $this->clave, $this->basedatos, $this->gestor);
		}
	}
	
	
/***********************************************************************************
* @Funci�n para insertar una nomina
* @parametros: 
* @retorno:
* @fecha de creaci�n: 09/10/2008.
* @autor: Ing.Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	function incluir()
	{
		global $conexionbd;
		
		$this->selecionarConexion (&$conexionbd);
		
		$conexionbd->StartTrans();
		$this->mensaje='Incluyo la N�mina '.$this->codnom;
		try 
		{
			$this->save();
		}		
		catch (exception $e) 
	   	{
			$this->valido  = false;				
			$this->mensaje='Error al Incluir la N�mina '.$this->codnom.' '.$conexionbd->ErrorMsg();
		} 
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}
	
	
/***********************************************************************************
* @Funci�n que Busca uno o todas las nominas
* @parametros: 
* @retorno:
* @fecha de creaci�n: 09/10/2008
* @autor: Ing. Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function leer() 
 	{	
 		global $conexionbd;	
 		
 		$this->selecionarConexion(&$conexionbd);
 		
		try
		{
			$consulta = " SELECT codemp, codnom, desnom, 1 as valido, codnom AS codnuenom ".
						" FROM {$this->_table} ".
						" WHERE codemp='{$this->codemp}'";
			if (($this->criterio=='')&&(($this->cadena!='')))
			{
				$consulta .= " AND codnom ='{$this->cadena}'";
			}
			elseif ($this->criterio!='')
			{
				$consulta .= " AND {$this->criterio} like '%{$this->cadena}%'";
		  	}
		  	$consulta.= " ORDER BY codnom";
			$result = $conexionbd->Execute($consulta);
			return $result;		
		}
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar la N�mina '.$consulta.' '.$conexionbd->ErrorMsg();
			$this->incluirSeguridad('CONSULTAR',$this->valido);
	   	} 
	}

/***********************************************************************************
* @Funci�n que Genera los per�odos de una n�mina en especifico
* @parametros: 
* @retorno:
* @fecha de creaci�n: 07/11/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	public function generarPeriodos()
	{
		switch($this->tippernom)
		{
			case '0': // Semanal
				$this->totalperiodos=52;
				break;
			case '1': // Quincenal
				$this->totalperiodos=24;
				break;
			case '2': // Mensual
				$this->totalperiodos=12;
				break;
			case '3': // Anual
				$this->totalperiodos=1;
				break;
		}
		$diasperiodo=round((365/$this->totalperiodos),0);
		$fecha=$this->fecininom;
		$anioinicial=substr($fecha,0,4);
		for ($i = 1; ($i <= $this->totalperiodos) && ($this->valido); $i++)
		{
			$objPeriodo = new Periodo();
			$objPeriodo->codemp = $this->codemp;
			$objPeriodo->codnom = $this->codnom;
			$objPeriodo->codperi = str_pad($i,3,'0',0);
			$objPeriodo->fecdesper = $fecha;
			$objPeriodo->fechasper = $this->obtenerFinalPeriodo($fecha, $diasperiodo);
			$objPeriodo->totper = 0;
			$objPeriodo->cerper = 0;
			$objPeriodo->conper = 0;
			$objPeriodo->apoconper = 0;
			$objPeriodo->ingconper = 0;
			$objPeriodo->fidconper = 0;
			$objPeriodo->peradi = 0;
			$objPeriodo->obsper = '';
			$objPeriodo->incluir();
			$fecha= sumarDias ($objPeriodo->fechasper,1);
			unset($objPeriodo);
			if ($this->tippernom != 0)
			{
				$anioactual=substr($fecha,0,4);
				if ($anioinicial != $anioactual)
				{
					break;
				}
			}		
		}
		$objPeriodo = new Periodo();
		$objPeriodo->codemp = $this->codemp;
		$objPeriodo->codnom = $this->codnom;
		$objPeriodo->codperi = '000';
		$objPeriodo->fecdesper = '1900-01-01';
		$objPeriodo->fechasper = '1900-01-01';
		$objPeriodo->totper = 0;
		$objPeriodo->cerper = 0;
		$objPeriodo->conper = 0;
		$objPeriodo->apoconper = 0;
		$objPeriodo->ingconper = 0;
		$objPeriodo->fidconper = 0;
		$objPeriodo->peradi = 0;
		$objPeriodo->obsper = 'Periodo Nulo';
		$objPeriodo->incluir();
		unset($objPeriodo);
	}

	
/***********************************************************************************
* @Funci�n que obtiene la Fecha final de una per�odo
* @parametros: 
* @retorno:
* @fecha de creaci�n: 07/11/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	function obtenerFinalPeriodo($fecha,$diasperiodo)
	{
		if ((($diasperiodo == 15) && (substr($fecha,8,2) == 16)) || ($diasperiodo == 30))
		{
			$fechafinal = ultimoDiaMes (substr($fecha,5,2), substr($fecha,0,4));
		}
		else
		{
			$fechafinal = sumarDias ($fecha, ($diasperiodo-1));
		}
		if($diasperiodo==365)
		{
			$fechafinal=substr($fecha,0,4).'-12-31';
		}
		return $fechafinal;
	}
	

/***********************************************************************************
* @Funci�n que Incluye el registro de la transacci�n exitosa
* @parametros: $evento
* @retorno:
* @fecha de creaci�n: 10/10/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function incluirSeguridad($evento,$tipotransaccion)
	{
		if($tipotransaccion) // Transacci�n Exitosa
		{
			$objEvento = new RegistroEventos();
		}
		else // Transacci�n fallida
		{
			$objEvento = new RegistroFallas();
		}
		// Registro del Evento
		$objEvento->codemp = $this->codemp;
		$objEvento->codsis = $this->codsis;
		$objEvento->nomfisico = $this->nomfisico;
		$objEvento->evento = $evento;
		$objEvento->desevetra = $this->mensaje;
		$objEvento->incluir();
		unset($objEvento);
	}
		
}	
?>