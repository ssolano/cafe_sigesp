<?php
class sigesp_scb_c_pago_caficultores
{
	var $io_sql;
	var $fun;
	var $msg;
	var $is_msg_error;	
	var $ds_sol;
	var $dat;
	var $ds_temp;
	var $io_sql_aux;
	
	function sigesp_scb_c_pago_caficultores()
	{
		require_once("class_funciones_banco.php");
		require_once("../shared/class_folder/class_sql.php");
		require_once("../shared/class_folder/class_funciones.php");
		require_once("../shared/class_folder/sigesp_include.php");
		$sig_inc=new sigesp_include();
		$con=$sig_inc->uf_conectar();
		$this->io_sql=new class_sql($con);
		$this->io_sql_aux = new class_sql($con);
		$this->io_funscb  = new class_funciones_banco();
		$this->fun=new class_funciones();
		$this->msg=new class_mensajes();
		$this->dat=$_SESSION["la_empresa"];	
		$this->ls_codemp=$_SESSION["la_empresa"]["codemp"];	
		$this->ds_temp=new class_datastore();
		$this->ds_sol=new class_datastore();
    }

	function  uf_cargar_pago_caficultores()
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_cargar_pago_caficultores
		//		   Access: private
		//	      Returns: rs_pago
		//	  Description: Funcion que genera los datos para crear el archivo de pago de caficultores 
		//	   Creado Por: Robert Aguero
		// Fecha Creación: 09/09/2011. 								Fecha Última Modificación : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$ls_sql = "SELECT * FROM vw_cargar_cxp_transferencia";
		$rs_data = $this->io_sql->select($ls_sql);//echo "SQL=>".$ls_sql.'<br>';
		if ($rs_data===false)
		   {
			 $this->is_msg_error="Error en consulta, ".$this->fun->uf_convertirmsg($this->io_sql->message);
			 echo $this->io_sql->message;
			 $lb_valido=false;
		   }

		   return $rs_data;
		   
	}
	
	function  uf_pagos_caficultores_transferencia($numeroSolicitud,$lote)
	{
		$usuario = $_SESSION["la_logusr"];
		$ls_sql = "select fn_pagos_caficultores_transferencia('$numeroSolicitud',$lote,'$usuario')";
		$rs_data = $this->io_sql->select($ls_sql);//echo "SQL=>".$ls_sql.'<br>';
		if ($rs_data===false)
		   {
			 $this->is_msg_error="Error en consulta, ".$this->fun->uf_convertirmsg($this->io_sql->message);
			 echo $this->io_sql->message;
			 $lb_valido=false;
		   }
		return $rs_data;
	}
	
	function  uf_crear_lote($id_banco)
	{
		$ls_sql = "select fn_crear_lote('$id_banco')";
		$rs_data = $this->io_sql->select($ls_sql);//echo "SQL=>".$ls_sql.'<br>';
		if ($rs_data===false)
		   {
			 $this->is_msg_error="Error en consulta, ".$this->fun->uf_convertirmsg($this->io_sql->message);
			 echo $this->io_sql->message;
			 $lb_valido=false;
		   }
		return $rs_data;
	}

//---------------------------------------------------------------------------------------------------------------------------------------
}// fin de la clase
?>