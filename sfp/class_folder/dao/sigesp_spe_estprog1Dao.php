<?php
require_once("../class_folder/sigesp_conexion_dao.php");
require_once('sigesp_sfp_con_estplandao.php');
class estprog1Dao extends ADODB_Active_Record
{
	var $_table='spe_estpro1';				
	public function FiltrarEst()
	{
		$oNivel=new ConfNivelDao();
		$oNivel->tipo="PL";
		$oNivel->nivel="1";
		$tama = $oNivel->LeerNumCar();
		$pos=(25-$tama)+1;
		global $db;
		$Rs = $db->Execute("select substr(codest1,{$pos},{$tama}) as codest1,denest1 from {$this->_table} where {$this->_table}.codemp='{$this->codemp}'"); 
		return $Rs;
	}

	public function Modificar()
	{
		global $db;
		$db->StartTrans();
		$this->Replace();
		if($db->CompleteTrans())
			{
				return "1";	
			}
			else
			{
				return "0";
			}
		
	}
	
	public function Incluir()
	{
		global $db;
		try
		{
			$db->debug=1;
			$db->StartTrans();
			$this->save();
			if($db->CompleteTrans())
			{
				return "1";	
			}
			else
			{
				return "0";
			}
		}
		catch(exception $e)
		{
			//capturar el error y guardarlo en la bd
			return "0";
		}
	}
	
	public function Eliminar()
	{
		global $db;
		try
		{
			$db->StartTrans();
			$this->delete();
			if($db->CompleteTrans())
			{
				return "1";	
			}
			else
			{
				return "0";
			}
		}
		catch(exception $e)
		{
			//capturar el error y guardarlo en la bd
			return "0";
		}
	}





}
?>