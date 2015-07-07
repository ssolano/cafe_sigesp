<?php
/********************************************************** 	
* @Modelo para proceso de asignaci�n de usuarios a grupo.
* @versi�n: 1.0      
* @autor: Ing. Gusmary Balza
* @fecha creaci�n: 15/08/2008
********************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once('sigesp_dao_msg_registroeventos.php');

class Usuariogrupo extends ADOdb_Active_Record
{
	var $_table='msgusuariogrupod';
	var $usuario = array();
	public $mensaje;
	public $evento;
	public $valido;
	public $existe;

/*****************************************************
* @Funci�n que incluye en un grupo sus usuarios
* @parametros: 
* @retorno:
* @fecha de creaci�n: 15/08/2008
* @autor: Ing. Gusmary Balza
******************************************************/		
	public function incluirTodos()
	{
		global $conexionbd;
		$conexionbd->StartTrans();
		for ($i=0; $i<count($this->usuario); $i++)
		{	
			$this->usuario[$i]->codempresa = $this->codempresa;
			$this->usuario[$i]->incluir();
		}
		if ($conexionbd->CompleteTrans())
		{
			$this->valido = true;
		}
		else
		{
			$this->valido = false;
		}	
	}	

/*****************************************************
* @Funci�n que incluye un usuario para un grupo
* @parametros: 
* @retorno:
* @fecha de creaci�n: 15/08/2008
* @autor: Ing. Gusmary Balza
******************************************************/		
	public function incluir()
	{
		global $conexionbd;
		$conexionbd->StartTrans();
		$this->save();
		if ($conexionbd->CompleteTrans())
		{
			$this->mensaje = "Inserto nuevo usuario: ".$this->codusuario." en el grupo ".$this->codgrupo;
			$this->evento  = "INSERT";
			//$this->incluirSeguridad();	
			$this->valido = true;				
		}
		else
		{
			$this->mensaje = $conexionbd->ErrorMsg();
			$this->valido  = false;
		}
	}

/*****************************************************
* @Funci�n que busca los usuarios de un grupo
* @parametros: 
* @retorno:
* @fecha de creaci�n: 15/08/2008
* @autor: Ing. Gusmary Balza
******************************************************/		
	public function obtenerUsuarios()
	{
		global $conexionbd;
		$objUsuario = new Usuario();
		$consulta =" SELECT msggrupom.codempresa,msggrupom.codgrupo,msggrupom.nombre as nomgrupo, ".
				   " msgusuariom.codusuario,msgusuariom.nombre,msgusuariom.apellido ".
					" FROM msggrupom, msgusuariom,msgusuariogrupod WHERE msggrupom.codempresa='{$this->codempresa}' ".
					" AND msggrupom.codgrupo='{$this->codgrupo}' AND msggrupom.codempresa=msgusuariom.codempresa ".
					" AND msggrupom.codempresa=msgusuariogrupod.codempresa AND msggrupom.codgrupo=msgusuariogrupod.codgrupo ".
					" AND msgusuariom.codusuario=msgusuariogrupod.codusuario";
		$result = $conexionbd->Execute($consulta);
		return $result;	
	}
	
/*****************************************************
* @Funci�n que elimina un usuario de un grupo
* @parametros: 
* @retorno:
* @fecha de creaci�n: 15/08/2008
* @autor: Ing. Gusmary Balza
******************************************************/		
	public function eliminarUsuarios()
	{
		global $conexionbd;
		$objUsuario = new Usuario();
		$consulta = " DELETE FROM msgusuariogrupod WHERE codempresa='{$this->codempresa}' ". 
					" AND  codgrupo= '{$this->codgrupo}' AND codusuario='{$this->codusuario}'";
		$result = $conexionbd->Execute($consulta);
		return $result;		
	}	
	
	
	public function incluirSeguridad()
	{
		$objRegistro = new RegistroEventos();
		$objRegistro->codempresa  = $this->codempresa;  //asi
		//$objRegistro->codempresa    = '00001'; 
		$objRegistro->codsistema    = 'MSG'; //obtener
		$objRegistro->codusuario    = $this->codusuario;           
		$objRegistro->evento        = $this->evento;
		$objRegistro->funcionalidad = 'sigesp_vis_msg_usuariogrupo';    //obtener
		$objRegistro->desevento     = $this->mensaje;
		$objRegistro->codinterno    = '';	
		$objRegistro->insertarEvento();
	}	

}
?>
