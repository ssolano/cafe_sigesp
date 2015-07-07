<?php
/***********************************************************************************
* @Clase para Manejar los eventos del sistema
* @fecha de creaci�n: 27/08/2008
* @autor: Ing. Yesenia Moreno de Lang
* **************************
* @fecha modificacion 
* @autor   
* @descripcion 
***********************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');

class Evento extends ADOdb_Active_Record
{
	var $_table='msgeventom';	
	
	public $mensaje;
	public $evento;
	public $valido;
	public $existe;
	public $cadena;
	public $criterio;
		
		
/***********************************************************************************
* @Funci�n que incluye los eventos 
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 27/08/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function incluir()
	{
		global $conexionbd;
		$conexionbd->StartTrans();
		$this->save();
		if ($conexionbd->CompleteTrans())
		{
			$this->valido = true;
		}
		else
		{
			$this->valido = false;
		}
	}	

/***********************************************************************************
* @Funci�n que obtiene los eventos. 
* @parametros: 
* @retorno:
* @fecha de creaci�n: 28/08/2008
* @autor: Ing. Gusmary Balza.
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	public function leer() 
 	{		
		global $conexionbd;
		$conexionbd->StartTrans();
		$consulta = "SELECT codempresa,evento,descripcion FROM {$this->_table} ";
		if ($this->cadena=='')
		{
			$result = $conexionbd->Execute($consulta);
		}
		elseif ($this->criterio=='')
		{
			$consulta .= " WHERE codempresa ='{$this->codempresa}' AND evento ='{$this->cadena}'";
		}
		else
		{
			$consulta .= " WHERE {$this->criterio} like '%{$this->cadena}%'";
	  	}
		$result = $conexionbd->Execute($consulta);
		if ($conexionbd->CompleteTrans())
		{
			return $result;
		}
		else
		{
			echo "Ha ocurrido un error";
		}
	}	
}
?>

