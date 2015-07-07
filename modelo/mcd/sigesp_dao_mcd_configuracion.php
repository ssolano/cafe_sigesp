<?php
/**
* @Clase compartida para las funciones de Configuraci�n.
* @fecha de creaci�n: 14/08/2008.
* @autor: Ing. Yesenia Moreno de Lang
**/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION["sigesp_sitioweb"].'/base/librerias/php/general/sigesp_lib_conexion.php');

class Configuracion extends ADODB_Active_Record
{
	var $_table = 'mcdconfiguracionm';
	public $mensaje;
	public $valido;


/***********************************************************************************
* @Funci�n que busca la configuraci�n de la empresa
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 25/08/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function obtenerConfiguracion()
	{
		global $conexionbd;
		$conexionbd->StartTrans();
		$ls_sql = "SELECT msjenvio, msjsmtp, msjservidor, msjpuerto, msjhtml ".
				  "  FROM {$this->_table} ".
				  " WHERE codempresa = '".$this->codempresa."'";
		$result = $conexionbd->Execute($ls_sql); 
		if ($conexionbd->CompleteTrans())
		{
			while (!$result->EOF)
			{
				$this->msjenvio =$result->fields["msjenvio"];
				$this->msjsmtp =$result->fields["msjsmtp"];
				$this->msjservidor =$result->fields["msjservidor"];
				$this->msjpuerto =$result->fields["msjpuerto"];
				$this->msjhtml =$result->fields["msjhtml"];
				$result->MoveNext();
			}
			$this->valido = true;
			$this->mensaje = "";
		}
		else
		{
			$this->valido = false;
			$this->mensaje = "No se ha encontrado la configuraci�n";
		}
	}
}
?>