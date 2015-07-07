<?php
/***********************************************************************************
* @Clase para manejar el resultado de las transferencias de usuario.
* @fecha de creaci�n: 19/11/2008.
* @autor: Ing. Gusmary Balza
* **************************
* @fecha modificacion  
* @autor  
* @descripcion  
***********************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/base/librerias/php/general/sigesp_lib_conexion.php');

class ProcCons extends ADOdb_Active_Record
{
	var $_table = 'sigesp_dt_proc_cons';
	public $valido=true;
	public $mensaje;
	public $nomfisico;
	public $criterio;
	public $cadena;
	
	public $servidor;
	public $usuario;
	public $clave;
	public $basedatos;
	public $gestor;
	public $tipoconexionbd = 'DEFECTO';
		
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
* @Funci�n para insertar un resultado de una transferencia.
* @parametros: 
* @retorno:
* @fecha de creaci�n: 19/11/2008.
* @autor: Ing.Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/			
	function incluir()
	{
		global $conexionbd;
		//$conexionbd->debug = 1;
		$this->selecionarConexion (&$conexionbd);
		
		//$conexionbd->StartTrans();
		try 
		{ 
			$this->save();		
		}
		catch (exception $e) 
		{
			$this->valido  = false;	
			$this->mensaje='Error al Incluir el Resultado '.$this->evento.' '.$conexionbd->ErrorMsg();
			$this->incluirSeguridad('INSERTAR',$this->valido);
		}
		//$conexionbd->CompleteTrans();
	}
	
	
/***********************************************************************************
* @Funci�n que Busca uno o todos los eventos
* @parametros: 
* @retorno:
* @fecha de creaci�n: 31/10/2008
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
			$consulta = " SELECT codres,codproc,codsis,fecha,bdorigen,bddestino,descripcion,1 as valido ".
						" FROM {$this->_table}";
			$result = $conexionbd->Execute($consulta);
			return $result;
		}
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar la Transferencia '.$consulta.' '.$conexionbd->ErrorMsg();
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
		$objEvento->codsis = 'SSS';
		$objEvento->nomfisico = $this->nomfisico;
		$objEvento->evento = $evento;
		$objEvento->desevetra = $this->mensaje;
		$objEvento->incluir();
		unset($objEvento);
	}
 	
}	
?>