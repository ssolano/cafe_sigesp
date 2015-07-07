<?php
/***********************************************************************************
* @Modelo para proceso de asignaci�n de usuarios a sistema.
* @fecha de creaci�n: 30/09/2008.
* @autor: Ing.Gusmary Balza
* **************************
* @fecha modificacion  
* @autor 
* @descripcion  
***********************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');

class UsuarioSistema extends ADOdb_Active_Record
{
	var $_table='sss_usuario_sistema';
	
	public $mensaje;
	public $evento;
	public $valido=true;
	public $existe = true;
	public $nomfisico;
	
	
/***********************************************************************************
* @Funci�n que incluye un usuario en un sistema
* @parametros: 
* @retorno:
* @fecha de creaci�n: 08/08/2008
* @autor: Ing. Gusmary Balza
************************************************************************************
* @fecha modificaci�n: 10/10/2008
* @descripci�n: Se agrego la seguridad
* @autor: Ing. Yesenia Moreno de Lang
***********************************************************************************/	
	public function incluir()
	{
		global $conexionbd;
		$this->mensaje='Incluyo el Usuario '.$this->codusu.' en el Sistema '.$this->codsis;
		$this->save();
		if($conexionbd->HasFailedTrans())
		{
			$this->valido  = false;	
			$this->mensaje=$conexionbd->ErrorMsg();
		}
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}

	
/***********************************************************************************
* @Funci�n que Elimina el usuario de un sistema
* @parametros: 
* @retorno:
* @fecha de creaci�n: 10/10/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	public function eliminar()
	{
		global $conexionbd;
		$this->mensaje='Elimino el Usuario '.$this->codusu.' del Sistema '.$this->codsis;
		$this->delete();
		if($conexionbd->HasFailedTrans())
		{
			$this->valido  = false;	
			$this->mensaje=$conexionbd->ErrorMsg();
		}
		$this->incluirSeguridad('ELIMINAR',$this->valido);
	}

	
/***********************************************************************************
* @Funci�n que Elimina todos los usuarios de un Sistema
* @parametros: 
* @retorno:
* @fecha de creaci�n: 14/10/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/	
	public function eliminarTodos()
	{
		global $conexionbd;
		$this->mensaje='Elimino los Usuarios del Sistema '.$this->codsis;
		$consulta = "DELETE FROM $this->_table ".
					" WHERE codemp = '$this->codemp' ".
					"   AND codsis = '$this->codsis' ";
		$result = $conexionbd->Execute($consulta);
		if($conexionbd->HasFailedTrans())
		{
			$this->valido  = false;	
			$this->mensaje=$conexionbd->ErrorMsg;
		}
		$this->incluirSeguridad('ELIMINAR',$this->valido);
	}	
	
	
/***************************************************************************
* @Funci�n que verifica si un usuario est� en un sistema
* @parametros: 
* @retorno:
* @fecha de creaci�n: 06/08/2008
* @autor: Ing. Gusmary Balza
***************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
****************************************************************************/		
	function buscarUsuarioSistema()
	{
		global $conexionbd;
		try
		{	
			$consulta = " SELECT codsis,codusu ". 
						" FROM $this->_table ".
						" WHERE codemp='{$this->codemp}' ".
						" AND codusu='{$this->codusu}' ";
			$result = $conexionbd->Execute($consulta);
			if ($result->EOF)
			{
				$this->existe = false;
			}			
		}
		catch (exception $e) 
		{
			$this->valido  = false;	
			$this->mensaje='Error al consultar el Usuario '.$this->codusu.' en los Sistemas '.' '.$conexionbd->ErrorMsg();
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
