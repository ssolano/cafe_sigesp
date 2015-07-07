<?php
/****************************************************************************
* @Modelo para las funciones de unidades administrativas.
* @fecha de creaci�n: 01/10/2008.
* @autor: Ing.Gusmary Balza
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
****************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/modelo/sss/sigesp_dao_sss_registroeventos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/modelo/sss/sigesp_dao_sss_registrofallas.php');

class UnidadAdministrativa extends ADOdb_Active_Record
{
	var $_table = 'spg_unidadadministrativa';
	public $valido = true;
	public $seguridad = true;
	public $mensaje;
	public $cadena;
	public $criterio;
	public $codsis;
	public $nomfisico;
	
/***********************************************************************************
* @Funci�n para insertar una unidad administrativa.
* @parametros: 
* @retorno:
* @fecha de creaci�n: 01/10/2008.
* @autor: Ing.Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	function incluir()
	{
		global $conexionbd;
		$this->mensaje = 'Incluyo la Unidad Administrativa '.$this->coduniadm;
		$conexionbd->StartTrans();
		try 
		{ 
			$this->save();
		}	
		catch (exception $e) 
	   	{
			$this->valido  = false;				
			$this->mensaje='Error al Incluir la Unidad Administrativa '.$this->coduniadm.' '.$conexionbd->ErrorMsg();
		} 
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}
	
	
/***********************************************************************************
* @Funci�n que Busca una,varias o todas las unidades administrativas
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
		try
		{
			$consulta = " SELECT codemp,coduniadm,denuniadm, 1 as valido ".
						" FROM {$this->_table} ".
						" WHERE coduniadm<>'----------' AND coduniadm<>'---'";
			if (($this->criterio=='')&&(($this->cadena!='')))
			{
				$consulta .= " AND codemp='{$this->codemp}' AND coduniadm ='{$this->cadena}'";
			}
			elseif ($this->criterio!='')
			{
				$consulta .= " AND {$this->criterio} like '%{$this->cadena}%'";
		  	}
		  	$consulta.= " ORDER BY coduniadm";
		 	$result = $conexionbd->Execute($consulta);	
		 	return $result;
		}		
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar la Unidad Administrativa '.$consulta.' '.$conexionbd->ErrorMsg();
			$this->incluirSeguridad('CONSULTAR',$this->valido);
	   	} 
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