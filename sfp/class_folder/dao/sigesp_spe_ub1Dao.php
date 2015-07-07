<?php
require_once("../class_folder/sigesp_conexion_dao.php");
class ub1Dao extends ADODB_Active_Record
{
var $_table='sigesp_ub1';				
public function FiltrarEst($Cond='')
{
	global $db;
	//$db->debug=true;
	$Rs = $db->Execute("select * from {$this->_table} where {$this->_table}.codemp='{$this->codemp}'"); 
	return $Rs;
}
}
?>