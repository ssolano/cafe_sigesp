<?php
/***********************************************************************************
* @Clase para Manejar el menu del sistema
* @fecha de creaci�n: 07/08/2008
* @autor: Ing. Gusmary Balza
* **************************
* @fecha modificacion 
* @autor   
* @descripcion 
***********************************************************************************/

require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');

class Menu extends ADOdb_Active_Record
{
	var $_table='msgmenum';
	public $codusuario;
	public $campo;
	
/***********************************************************************************
* @Funci�n que incluye las opciones de menu 
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 28/08/2008
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
* @Funci�n que busca las opciones de menu
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 28/08/2008
* @autor: Ing. Gusmary Balza
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function obtenerMenu()
	{
		global $conexionbd;
		$consulta = "SELECT codmenu, codsistema, nomlogico, nomfisico, codpadre, nivel, hijo, marco ".
					"  FROM $this->_table ".
					" WHERE $this->_table.codempresa = '$this->codempresa' ". 
					"   AND $this->_table.codsistema = '$this->codsistema' ".
					" ORDER BY nivel, orden";
		$result = $conexionbd->Execute($consulta); 
		return $result;
	
	}

/***********************************************************************************
* @Funci�n que busca las opciones de menu seg�n el usuario
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 28/08/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function obtenerMenuUsuario()
	{
		global $conexionbd;
		$consulta = "SELECT $this->_table.codmenu, $this->_table.codsistema, nomlogico, nomfisico, codpadre, nivel, hijo, marco, orden ".
					"  FROM $this->_table ".
					" WHERE $this->_table.hijo = 1 ".
					"	AND $this->_table.codmenu IN (SELECT $this->_table.codpadre ".
					"  									FROM $this->_table ".
					" 								   INNER JOIN msgperfild ".
					"    								  ON msgperfild.codusuario = '$this->codusuario' ".
					"  									 AND msgperfild.visible = '1' ". 
					"  									 AND $this->_table.codempresa = msgperfild.codempresa ".
					"   								 AND $this->_table.codsistema = msgperfild.codsistema ".
					"   								 AND $this->_table.codmenu = msgperfild.codmenu ".
					" 								   WHERE $this->_table.hijo = 0 ".
					"   								 AND $this->_table.codempresa = '$this->codempresa' ". 
					"   								 AND $this->_table.codsistema = '$this->codsistema') ".
					"   AND $this->_table.codempresa = '$this->codempresa' ". 
					"   AND $this->_table.codsistema = '$this->codsistema' ".
					" UNION ".
					"SELECT $this->_table.codmenu, $this->_table.codsistema, nomlogico, nomfisico, codpadre, nivel, hijo, marco, orden ".
					"  FROM $this->_table ".
					" INNER JOIN msgperfild ".
					"    ON msgperfild.codusuario = '$this->codusuario' ".
					"   AND msgperfild.visible = '1' ". 
					"   AND $this->_table.codempresa = msgperfild.codempresa ".
					"   AND $this->_table.codsistema = msgperfild.codsistema ".
					"   AND $this->_table.codmenu = msgperfild.codmenu ".
					" WHERE $this->_table.hijo = 0 ".
					"   AND $this->_table.codempresa = '$this->codempresa' ". 
					"   AND $this->_table.codsistema = '$this->codsistema' ".
					" ORDER BY nivel, orden";
		$result = $conexionbd->Execute($consulta); 
		return $result;
	}

/***********************************************************************************
* @Funci�n que busca las opciones de la Barra de Herramientas seg�n el usuario
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 29/08/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function obtenerBarraHerramientaUsuario()
	{
		global $conexionbd;
		$consulta = "SELECT msgperfild.visible, msgperfild.leer, msgperfild.incluir, msgperfild.actualizar, msgperfild.eliminar, msgperfild.imprimir, ".
					"		msgperfild.anular, msgperfild.ejecutar, msgperfild.administrativo, msgperfild.ayuda, msgperfild.cancelar ".
					"  FROM $this->_table ".
					" INNER JOIN msgperfild ".
					"    ON msgperfild.codusuario = '$this->codusuario' ".
					"   AND msgperfild.visible = '1' ". 
					"   AND $this->_table.codempresa = msgperfild.codempresa ".
					"   AND $this->_table.codsistema = msgperfild.codsistema ".
					"   AND $this->_table.codmenu = msgperfild.codmenu ".
					" WHERE $this->_table.hijo = 0 ".
					"   AND $this->_table.codempresa = '$this->codempresa' ". 
					"   AND $this->_table.codsistema = '$this->codsistema' ".
					"   AND $this->_table.nomfisico = '$this->nomfisico' ".
					" ORDER BY nivel, orden";
		$result = $conexionbd->Execute($consulta); 
		return $result;
	}


/***********************************************************************************
* @Funci�n que Verifica que el usuario tenga acceso a la funcionalidad y a la acci�n que proceso
* @parametros: 
* @retorno: Verdadero � false seg�n la permisolog�a
* @fecha de creaci�n: 03/09/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	public function verificarUsuario()
	{
		global $conexionbd;
		$usuariovalido=false;
		$consulta = "SELECT $this->_table.codmenu ".
					"  FROM $this->_table ".
					" INNER JOIN msgperfild ".
					"    ON msgperfild.codusuario = '$this->codusuario' ".
					"   AND msgperfild.visible = '1' ". 
					"   AND msgperfild.$this->campo = '1' ". 
					"   AND $this->_table.codempresa = msgperfild.codempresa ".
					"   AND $this->_table.codsistema = msgperfild.codsistema ".
					"   AND $this->_table.codmenu = msgperfild.codmenu ".
					" WHERE $this->_table.hijo = 0 ".
					"   AND $this->_table.codempresa = '$this->codempresa' ". 
					"   AND $this->_table.codsistema = '$this->codsistema' ".
					"   AND $this->_table.nomfisico = '$this->nomfisico' ";
		$result = $conexionbd->Execute($consulta); 
		if(!$result->EOF)
		{   
			$usuariovalido=true;
		}
		$result->Close();
		return $usuariovalido;
	}
	
}

?>