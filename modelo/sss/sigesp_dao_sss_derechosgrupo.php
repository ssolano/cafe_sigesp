<?php
/************************************************************************** 	
* @Modelo para proceso de asignar perfil a los grupos.
* @versi�n: 1.0      
* @fecha creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza
**********************************************************************
* @fecha modificaci�n: 20/10/2008
* @descripci�n: Incluir seguridad y adaptar a estandares
* @autor:
**************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once('sigesp_dao_sss_registroeventos.php');
require_once('sigesp_dao_sss_registrofallas.php');

class DerechosGrupo extends ADOdb_Active_Record
{
	var $_table = 'sss_derechos_grupos';	
	public $mensaje;
	public $evento;
	public $valido    = true;
	public $seguridad = true;
	public $existe    = true;
	public $cadena;
	public $criterio;
	public $codsis;
	public $nomfisico;

	
/*************************************************************************
* @Funci�n que incluye un perfil para un grupo en un sistema
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
*******************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*************************************************************************/	
	function incluir()
	{
		global $conexionbd;
		$this->mensaje = 'Incluyo el perfil de menu '.$this->codmenu.' para el grupo '.$this->nomgru.' en el sistema '.$this->codsis;
		$conexionbd->StartTrans();
		try 
		{ 		
			$consulta = " INSERT INTO {$this->_table} (codemp,nomgru,codsis,codmenu,        ".
						" 		codintper,visible,enabled,leer,incluir,cambiar,eliminar, 	".
						" 		imprimir,anular,ejecutar,administrativo,ayuda,cancelar, 	".
						" 		enviarcorreo,descargar) 									".
						" 		SELECT '{$this->codemp}','{$this->nomgru}',codsis,codmenu, 	".
						" 		'{$this->codintper}',{$this->visible},1,{$this->leer}, 		".
						" 		{$this->incluir},{$this->cambiar},{$this->eliminar},   		".
						" 		{$this->imprimir},{$this->anular},{$this->ejecutar}, 		".
						" 		{$this->administrativo},{$this->ayuda},{$this->cancelar}, 	".
						"		{$this->enviarcorreo},{$this->descargar} 					".
						" FROM sss_sistemas_ventanas WHERE codsis='{$this->codsis}' 		".
						" AND codmenu={$this->codmenu} AND hijo=0							".
						" AND codmenu NOT IN 
								(SELECT codmenu FROM {$this->_table}
								WHERE codemp='{$this->codemp}' 
								AND nomgru='{$this->nomgru}'
								AND codsis='{$this->codsis}')								";		
			$result = $conexionbd->Execute($consulta);
			
			//$this->objDerechos = new DerechosGrupo();
			$this->nomfisico = $this->nomfisico;
			$this->criterio[0]['operador'] = "WHERE";
			$this->criterio[0]['criterio'] = "codemp";
			$this->criterio[0]['condicion'] = "=";
			$this->criterio[0]['valor'] = "'".$this->codemp."'";
			
			$this->criterio[1]['operador'] = "AND";
			$this->criterio[1]['criterio'] = "nomgru";
			$this->criterio[1]['condicion'] = "=";
			$this->criterio[1]['valor'] = "'".$this->nomgru."'";
			
			$this->criterio[2]['operador'] = "AND";
			$this->criterio[2]['criterio'] = "codsis";
			$this->criterio[2]['condicion'] = "=";
			$this->criterio[2]['valor'] = "'".$this->codsis."'";
			
			$this->criterio[3]['operador'] = "AND";
			$this->criterio[3]['criterio'] = "codintper";
			$this->criterio[3]['condicion'] = "=";
			$this->criterio[3]['valor'] = "'".$this->codintper."'";			
		
			$this->criterio[4]['operador'] = "AND";
			$this->criterio[4]['criterio'] = "codmenu";
			$this->criterio[4]['condicion'] = "=";
			$this->criterio[4]['valor'] = $this->codmenu;
			
			$this->modificar();
		}
		catch (exception $e) 
	   	{
			$this->valido  = false;				
			$this->mensaje='Error al Incluir el Perfil de men� '.$this->codmenu.' para el grupo '.$this->nomgru.' en el sistema '.$this->codsis.' '.$conexionbd->ErrorMsg();
		}  
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}
	
	
/***********************************************************************
* @Funci�n que modifica un perfil de una funcionalidad
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
***********************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************/		
	public function modificar() 
	{
		global $conexionbd;
		$this->mensaje = 'Modifico el perfil de menu '.$this->codmenu.' para el grupo '.$this->nomgru.' en el sistema '.$this->codsis;
		$conexionbd->StartTrans();
		try 
		{
			$consulta = " UPDATE {$this->_table} SET 								".
						" 	visible={$this->visible},enabled=1,leer={$this->leer}, 	". 
						" 	incluir={$this->incluir},cambiar={$this->cambiar}, 		".
						" 	eliminar={$this->eliminar},imprimir={$this->imprimir}, 	".
						" 	administrativo={$this->administrativo},					".
						" 	anular={$this->anular},ejecutar={$this->ejecutar},		".
						" 	ayuda={$this->ayuda},cancelar={$this->cancelar} 		".
						"	enviarcorreo={$this->enviarcorreo},descargar={$this->descargar} ";
			$cadena=" ";
            $total = count($this->criterio);
            for ($contador = 0; $contador < $total; $contador++)
			{
            	$cadena.= $this->criterio[$contador]['operador']." ".$this->criterio[$contador]['criterio']." ".
 			               $this->criterio[$contador]['condicion']." ".$this->criterio[$contador]['valor']." ";
            }
            $consulta.= $cadena;
			$result = $conexionbd->Execute($consulta);	
		}
		catch (exception $e) 
		{
			$this->mensaje='Error al Modificar el Perfil de men� '.$this->codmenu.' para el grupo '.$this->nomgru.' en el sistema '.$this->codsis.' '.$conexionbd->ErrorMsg();
			$this->valido = false;
		}
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('MODIFICAR',$this->valido);
	}	
	
		
/*******************************************************************************
* @Funci�n que verifica el perfil de una funcionalidad
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
***********************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*********************************************************************************/		
	public function verificarPerfilUno()
	{
		global $conexionbd;
		try
		{
			$consulta = " SELECT codemp,codsis,nomgru,codmenu,codintper,visible,leer, 			".
						" 	incluir,cambiar,eliminar,imprimir,anular,ejecutar,administrativo, 	".
						" 	ayuda,cancelar,enviarcorreo,descargar 								".
						" FROM {$this->_table} 													". 
						" WHERE codemp='{$this->codemp}' 										".
						" AND nomgru='{$this->nomgru}' 											".
						" AND codsis='{$this->codsis}'											".
						" AND codmenu={$this->codmenu} 											".
						" AND codintper='{$this->codintper}'									";
			$result = $conexionbd->Execute($consulta);
			if ($result->EOF)
			{		
				$this->existe = false;		
			}
			$result->Close(); 
		}
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar el Perfil '.$consulta.' '.$conexionbd->ErrorMsg();
			$this->incluirSeguridad('CONSULTAR',$this->valido);	
		}		
	}	
	
		
/************************************************************************************
* @Funci�n que incluye un perfil a todas las funcionalidades
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*************************************************************************************/		
	public function insertarPermisosGlobales() 
	{
		global $conexionbd;
		$this->mensaje = 'Incluyo el perfil para el grupo '.$this->nomgru.' en el sistema '.$this->codsis;
		$conexionbd->StartTrans();
		try
		{
			$consulta = " INSERT INTO {$this->_table} 				  	".
						"	(codemp,nomgru,codsis,codmenu, 			  	".
						" 	codintper,visible,enabled,leer,			  	".
						"	incluir,cambiar,eliminar,imprimir,		  	".
						"	anular,ejecutar,administrativo, 		  	".
						" 	ayuda,cancelar,enviarcorreo,descargar)    	".
						" SELECT '{$this->codemp}','{$this->nomgru}', 	".
						"	codsis,codmenu,'{$this->codintper}',      	".
						" 	visible,enabled,leer,incluir,	    		".
						" 	cambiar,eliminar,imprimir,			   		".
						"   anular,ejecutar,administrativo, 	 		".						
						" 	ayuda,cancelar,enviarcorreo,descargar		".
						" FROM sss_sistemas_ventanas ".
						" WHERE codsis='{$this->codsis}' ".
						" AND hijo=0".
						" AND codmenu NOT IN 
							(SELECT codmenu 
								FROM {$this->_table}
								WHERE codemp='{$this->codemp}' 
								AND nomgru='{$this->nomgru}'
								AND codsis='{$this->codsis}')";
			$result = $conexionbd->Execute($consulta);
			
			$this->nomfisico = $this->nomfisico;
			$this->criterio[0]['operador'] = "WHERE";
			$this->criterio[0]['criterio'] = "codemp";
			$this->criterio[0]['condicion'] = "=";
			$this->criterio[0]['valor'] = "'".$this->codemp."'";
			
			$this->criterio[1]['operador'] = "AND";
			$this->criterio[1]['criterio'] = "nomgru";
			$this->criterio[1]['condicion'] = "=";
			$this->criterio[1]['valor'] = "'".$this->nomgru."'";
			
			$this->criterio[2]['operador'] = "AND";
			$this->criterio[2]['criterio'] = "codsis";
			$this->criterio[2]['condicion'] = "=";
			$this->criterio[2]['valor'] = "'".$this->codsis."'";
			
			$this->criterio[3]['operador'] = "AND";
			$this->criterio[3]['criterio'] = "codintper";
			$this->criterio[3]['condicion'] = "=";
			$this->criterio[3]['valor'] = "'".$this->codintper."'";
			
			$this->modificar();
			//$this->modificarTodos();
		}
		catch (exception $e) 
		{
			
			$this->valido  = false;	
			$this->mensaje=' Error al Incluir el Perfil al Grupo '.$this->nomgru.' en el sistema '.' '.$conexionbd->ErrorMsg();
		}	
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('INSERTAR',$this->valido);
	}
	
	
/*****************************************************************************************
* @Funci�n que elimina el perfil a una o todas las funcionalidades
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
**************************************************************************
* @fecha modificaci�n: 28/10/2008
* @descripci�n: Se englobaron las funciones de eliminar para varios casos
* @autor: Ing. Gusmary Balza.
******************************************************************************************/			//para proceso asignar usuarios a personal
	public function eliminarTodosPrueba()
	{
		global $conexionbd;
		$this->mensaje = 'Elimino el perfil para el grupo '.$this->nomgru.' en el sistema '.$this->codsis;
		$conexionbd->StartTrans();
		try
		{
			$consulta = " UPDATE {$this->_table} SET 						".
						"	visible=0,enabled=0,leer=0,incluir=0,cambiar=0, ".
						" 	eliminar=0,imprimir=0,anular=0,ejecutar=0, 		".
						" 	administrativo=0,ayuda=0,cancelar=0,			".
						"	enviarcorreo=0,descargar=0 						".
						" WHERE codemp='{$this->codemp}'";
			$cadena=" ";
            $total = count($this->criterio);
            for ($contador = 0; $contador < $total; $contador++)
			{
            	$cadena.= $this->criterio[$contador]['operador']." ".$this->criterio[$contador]['criterio']." ".
 			               $this->criterio[$contador]['condicion']." ".$this->criterio[$contador]['valor']." ";
            }
            $consulta.= $cadena;
			$result = $conexionbd->Execute($consulta);
		}	
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje=' Error al Eliminar el perfil para el usuario '.$this->codusu.' en el sistema '.$this->codsis.$conexionbd->ErrorMsg();
	   	} 
	   	$conexionbd->CompleteTrans();
		$this->incluirSeguridad('ELIMINAR',$this->valido);
	}
	
	
/*************************************************************************
* @Funci�n que inserta los derechos de grupo (asignar permisos a grupos)
* @parametros: 
* @retorno:
* @fecha de creaci�n: 03/11/2008
* @autor: Ing. Gusmary Balza
**************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*************************************************************************/		
	function cargarDerechos()
	{
		global $conexionbd;
		//$conexionbd->debug = 1;
		$this->mensaje = 'Incluyo los derechos al Grupo '.$this->nomgru. ' para el sistema '.$this->codsis;
		$conexionbd->StartTrans();
		try
		{
			$consulta = " INSERT INTO {$this->_table} 										".
						" 	(codemp,nomgru,codsis,codmenu,codintper,visible,enabled,leer, 	". 
						" 	incluir,cambiar,eliminar,imprimir,administrativo,anular,ejecutar, ".
						" 	ayuda,cancelar,enviarcorreo,descargar) 							".
						" 	SELECT '{$this->codemp}','{$this->codusu}',codsis,codmenu, 		".
						" 	'{$this->codintper}',visible,enabled,leer,incluir,cambiar,		".
						" 	eliminar, imprimir,administrativo,anular,ejecutar,ayuda,cancelar, ".
						"	enviarcorreo,descargar											".
						" FROM {$this->_table}												".
						" WHERE codemp= '{$this->codemp}' 									".
						"   AND nomgru= '{$this->nomgru}' 									".
						"   AND codsis='{$this->codsis}' 									";
			$result = $conexionbd->Execute($consulta);
		}	
		catch (exception $e) 
		{
			$this->mensaje='Error al eliminar los derechos al grupo '.$this->nomgru.' '.$conexionbd->ErrorMsg();
			$this->valido = false;
		}	
		$conexionbd->CompleteTrans();	
		$this->incluirSeguridad('INSERTAR',$this->valido);	
	}	
	
		
/***********************************************************************************
* @Funci�n que busca el perfil de una funcionalidad
* @parametros:
* @retorno:
* @fecha de creaci�n: 22/08/2008
* @autor: Ing. Gusmary Balza.
************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*************************************************************************************/		
	public function leerUno()
	{
		global $conexionbd;
		try
		{
			$consulta = " SELECT codemp,nomgru,codmenu,codintper,visible,leer,incluir, ".
						" cambiar,eliminar,imprimir,anular,ejecutar,administrativo,ayuda, ".
						" cancelar, 1 as valido FROM {$this->_table} ".
						" WHERE codemp='{$this->codemp}'  AND nomgru='{$this->nomgru}' ".
						" AND codsis='{$this->codsis}' AND codmenu='{$this->codmenu}' ". 
						" AND codintper='{$this->codintper}'";
			$result = $conexionbd->Execute($consulta);
			return $result;
		}	
		catch (exception $e) 
		{ 
			$this->valido  = false;	
			$this->mensaje='Error al consultar el Perfil '.$consulta.' '.$conexionbd->ErrorMsg();
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
************************************************************************************/
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