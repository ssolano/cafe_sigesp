<?php
/**************************************************************************
* @Modelo para las funciones de proveedor.
* @fecha de creaci�n: 30/09/2008.
* @autor: Ing.Gusmary Balza
**************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
**************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/modelo/sss/sigesp_dao_sss_registroeventos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/modelo/sss/sigesp_dao_sss_registrofallas.php');

class Proveedor extends ADOdb_Active_Record
{
	var $_table = 'rpc_proveedor';
	public $valido = true;
	public $existe = true;
	public $mensaje;
	public $seguridad = true;
	public $codsis;
	public $nomfisico;
	
	
/***********************************************************************************
* @Funci�n para insertar un proveedor.
* @parametros: 
* @retorno:
* @fecha de creaci�n: 30/09/2008.
* @autor: Ing.Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	function incluir()
	{
		global $conexionbd;
		$conexionbd->StartTrans();
		$this->mensaje='Incluyo el Proveedor '.$this->cod_pro;
		try 
		{
			$this->save();
		}		
		catch (exception $e) 
	   	{
			$this->valido  = false;				
			$this->mensaje='Error al Incluir el Proveedor '.$this->cod_pro.' '.$conexionbd->ErrorMsg();
		} 
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}
	
	
/***********************************************************************************
* @Funci�n que Busca proveedor
* @parametros: 
* @retorno:
* @fecha de creaci�n: 16/12/2008
* @autor: Ing. Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
************************************************************************************/		
	public function leer() 
 	{	
 		global $conexionbd; 		
 		try
		{	
			$consulta = " SELECT *,1 as valido ".
						" FROM {$this->_table} ".
						" WHERE {$this->_table}.codemp='$this->codemp' ";
			$cadena=" ";
            $total = count($this->criterio);
            for ($contador = 0; $contador < $total; $contador++)
			{
            	$cadena.= $this->criterio[$contador]['operador']." ".$this->criterio[$contador]['criterio']." ".
 			               $this->criterio[$contador]['condicion']." ".$this->criterio[$contador]['valor']." ";
            }
            $consulta.= $cadena;
		 	$result = $conexionbd->Execute($consulta);
		 	if ($result->EOF)
		 	{
		 		$this->existe = false;
		 	}
		 	return $result;
		}
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar el Proveedor '.$consulta.' '.$conexionbd->ErrorMsg();
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