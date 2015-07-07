<?php
 ////////////////////////////////////////////////////////////////////////////////////////////////////////
 //       Class : class_sigesp_sno_integracion_php                                                     //    
 // Description : Esta clase tiene todos los metodos necesario para el manejo de la rutina integradora //
 //               de las nominas y aportes															   //
 ////////////////////////////////////////////////////////////////////////////////////////////////////////
class class_sigesp_spi_integracion
{
	//Instancia de la clase funciones.
    var $is_msg_error;
	var $obj="";
	var $io_sql;
	var $io_siginc;
	var $io_conect;
	var $io_function;	
    var $io_sigesp_int;
	var $io_fecha;
	var $io_msg;
    var $io_codemp;	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function class_sigesp_spi_integracion()
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: class_sigesp_spi_integracion
		//		   Access: public 
		//	  Description: Constructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Modificado Por: 										Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		require_once("../shared/class_folder/class_sql.php");  
		require_once("../shared/class_folder/class_datastore.php");
		require_once("../shared/class_folder/sigesp_include.php");
		require_once("../shared/class_folder/class_funciones.php");
		require_once("../shared/class_folder/class_sigesp_int.php");
		require_once("../shared/class_folder/class_sigesp_int_int.php");
		require_once("../shared/class_folder/class_sigesp_int_spg.php");
		require_once("../shared/class_folder/class_sigesp_int_scg.php");
		require_once("../shared/class_folder/class_sigesp_int_spi.php");
		require_once("../shared/class_folder/class_fecha.php");
		require_once("../shared/class_folder/class_mensajes.php");
		require_once("../shared/class_folder/sigesp_c_seguridad.php");
		require_once("class_funciones_mis.php");
	    $this->io_fun_mis=new class_funciones_mis();
		$this->io_seguridad=new sigesp_c_seguridad();		
	    $this->io_fecha=new class_fecha();
        $this->io_sigesp_int=new class_sigesp_int_int();
		$this->io_sigesp_spg=new class_sigesp_int_spg();
		$this->io_sigesp_spi=new class_sigesp_int_spi();
		$this->io_function=new class_funciones() ;
		$this->io_siginc=new sigesp_include();
		$this->io_connect=$this->io_siginc->uf_conectar();
		$this->io_sql=new class_sql($this->io_connect);		
		$this->io_msg=new class_mensajes();		
		$this->io_codemp=$_SESSION["la_empresa"]["codemp"];
		$this->as_procede="";
		$this->as_comprobante="";
		$this->ad_fecha="";
		$this->as_codban="";
		$this->as_ctaban="";
	}// end function class_sigesp_spi_integracion
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_destroy_objects()
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_destroy_objects
		//		   Access: public 
		//	  Description: Destructor de los objectos de la Clase
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 										Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if( is_object($this->io_fecha) ) { unset($this->io_fecha);  }
		if( is_object($this->io_sigesp_int) ) { unset($this->io_sigesp_int);  }
		if( is_object($this->io_sigesp_spg) ) { unset($this->io_sigesp_spg);  }
		if( is_object($this->io_sigesp_spi) ) { unset($this->io_sigesp_spi);  }
		if( is_object($this->io_function) ) { unset($this->io_function);  }
		if( is_object($this->io_siginc) ) { unset($this->io_siginc);  }
		if( is_object($this->io_connect) ) { unset($this->io_connect);  }
		if( is_object($this->io_sql) ) { unset($this->io_sql);  }	   
		if( is_object($this->io_msg) ) { unset($this->io_msg);  }	   
	}// end function uf_destroy_objects
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_procesar_contabilizacion_comprobantes_spi($as_comprobante,$ad_fecha,$as_procede,$as_descripcion,
														  $ld_fecaprob,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_procesar_contabilizacion_comprobantes_spi
		//		   Access: public (sigesp_mis_p_contabiliza_mp_spi.php)
		//	    Arguments: as_comprobante  // C�digo de Comprobante
		//				   ad_fecha  // Fecha de contabilizaci�n
		//				   as_procede  // Procede del Documento
		//				   as_descripcion  // Descripci�n del Documento
		//				   ld_fecaprob  // Fecha de aprobaci�n
		//				   aa_seguridad  // Arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: Funcion que procesa la contabilizaci�n de las modificaciones presupuestarias de ingreso
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 									Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
        $ls_codemp=$this->io_codemp;
		$ls_comprobante=$this->io_sigesp_int->uf_fill_comprobante(trim($as_comprobante));
		$ls_procede=$as_procede;
		$ld_fecha=$ad_fecha;
		$ls_ced_bene="----------";		
		$ls_cod_pro="----------";		
        $ls_tipo_destino="-";		
		$ldt_fecope=$ld_fecha;
		$ls_descripcion=$as_descripcion;
		$ls_codigo_destino="----------";
		$ldt_fecope=$this->io_function->uf_convertirdatetobd($ldt_fecope);
		$ldt_fecha=$this->io_function->uf_convertirdatetobd($ld_fecaprob);
		if(!$this->io_fecha->uf_comparar_fecha($ldt_fecope,$ldt_fecha))
		{
		   $this->io_msg->message("ERROR -> La fecha de contabilizacion es menor que la fecha del comprobante ".$as_comprobante);
		   return false;
		}
		$ls_codban="---";
		$ls_ctaban="-------------------------";
		$li_tipo_comp=2; // comprobante de tipo Modificacion presupuestaria
		$this->as_procede=$ls_procede;
		$this->as_comprobante=$ls_comprobante;
		$this->ad_fecha=$ldt_fecha;
		$this->as_codban=$ls_codban;
		$this->as_ctaban=$ls_ctaban;
		$lb_valido=$this->io_sigesp_int->uf_int_init($ls_codemp,$ls_procede,$ls_comprobante,$ld_fecaprob,$ls_descripcion,
													 $ls_tipo_destino,$ls_codigo_destino,false,$ls_codban,$ls_ctaban,
													 $li_tipo_comp);
		if (!$lb_valido)
		{   
           $this->io_msg->message("ERROR -> ".$this->io_sigesp_int->is_msg_error); 
		   return false;		   		   
		}
		$this->io_sigesp_int->uf_int_init_transaction_begin(); // inicia transacci�n SQL
		$lb_valido = $this->uf_procesar_detalles_contable_spi($ls_codemp,$ls_procede,$ls_comprobante,$ldt_fecope,$ls_descripcion,$ls_tipo_destino,$ls_codigo_destino);
		if(!$lb_valido)
		{
			$this->io_msg->message("ERROR -> No se pudo procesar los detalles contables.");
		}        
	    if($lb_valido)
		{
			$lb_valido = $this->uf_procesar_detalles_ingreso_spi($ls_codemp,$ls_procede,$ls_comprobante,$ldt_fecope,$ls_descripcion,$ls_tipo_destino,$ls_codigo_destino);
			if(!$lb_valido)
			{
				$this->io_msg->message("ERROR -> No se pudo procesar los detalles de gastos.");
			}
		}
        if($lb_valido)
		{
			$lb_valido = $this->io_sigesp_int->uf_init_end_transaccion_integracion($aa_seguridad); 
			if ( $lb_valido===false)
			{		   	 
				$this->io_msg->message("ERROR -> ".$this->io_sigesp_int->is_msg_error);
			}
		}
	    if($lb_valido)
		{
			$lb_valido = $this->uf_update_estatus_modificacion_spi($ls_codemp,$ls_procede,$ls_comprobante,$ldt_fecope,$ls_descripcion,$ls_tipo_destino,1);
			if(!$lb_valido)
			{
				$this->io_msg->message("ERROR -> No se pudo actualizar estatus de las Modificaciones");
			}
		}
		if($lb_valido)
		{
			$lb_valido = $this->uf_update_fecha_contabilizado_spi($ls_codemp,$ldt_fecope,$ls_comprobante,$as_procede,$ldt_fecha,'1900-01-01');
		}
		if($lb_valido)
		{	

			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
			$ls_evento="PROCESS";
			$ls_descripcion="Aprob� las Modificaciones Presupuestarias de Ingreso Comprobante <b>".$ls_comprobante."</b>, ".
							"Procede <b>".$ls_procede."</b>, Fecha Documento <b>".$ldt_fecope."</b>, ".
							"Fecha de Aprobaci�n <b>".$ldt_fecha."</b>";
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// PARA LA CONVERSI�N MONETARIA
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/*if($lb_valido)
		{
			$lb_valido=$this->io_fun_mis->uf_convertir_sigespcmp($this->as_procede,$this->as_comprobante,$this->ad_fecha,
																 $this->as_codban,$this->as_ctaban,$aa_seguridad);
		}
		if($lb_valido)
		{
			$lb_valido=$this->io_fun_mis->uf_convertir_spidtcmp($this->as_procede,$this->as_comprobante,$this->ad_fecha,
																$this->as_codban,$this->as_ctaban,$aa_seguridad);
		}
		if($lb_valido)
		{
			$lb_valido=$this->io_fun_mis->uf_convertir_scgdtcmp($this->as_procede,$this->as_comprobante,$this->ad_fecha,
																$this->as_codban,$this->as_ctaban,$aa_seguridad);
		}*/
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->io_sigesp_int->uf_sql_transaction($lb_valido);
		return $lb_valido;
    }// end function uf_procesar_contabilizacion_comprobantes_spi
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_procesar_detalles_contable_spi($ls_codemp,$ls_procede,$ls_comprobante,$ad_fecha,$ls_descripcion,$ls_tipo_destino,
											   $ls_codigo_destino)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_procesar_detalles_contable_spi
		//		   Access: private
		//	    Arguments: ls_codemp  // C�digo de Empresa
		//				   ls_procede  // Procede del Documento
		//				   ls_comprobante  // N�mero de comprobante
		//				   ad_fecha  // Fecha de Contabilizaci�n
		//				   ls_descripcion  // descripci�n del Comprobante
		//				   ls_tipo_destino  // Destino de la contabilizaci�n
		//				   ls_codigo_destino  // C�digo del Destino
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: M�todo que genera los asientos contables a partir de los movmientos de notas de creditos o d�bitos
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 											Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    $lb_valido=true;		
		$ls_sql="SELECT * ".
                "  FROM scg_dtmp_cmp ".
                " WHERE codemp='".$ls_codemp."' ".
				"   AND comprobante='".$ls_comprobante."' ".
				"   AND fecha='".$ad_fecha."' ".
                "   AND procede='".$ls_procede."'";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{   
			$lb_valido=false;
            $this->io_msg->message("CLASE->Integraci�n SPI M�TODO->uf_procesar_detalles_contable_spi ERROR->".$this->io_function->uf_convertirmsg($this->io_sql->message));			
		}
		else
		{           
			while($row=$this->io_sql->fetch_row($rs_data) and ($lb_valido))
			{
				$ls_scg_cuenta=$row["sc_cuenta"];
				$ls_debhab=$row["debhab"];				
				$ldec_monto=$row["monto"];				
				$ls_documento=$row["documento"];
				$lb_valido=$this->io_sigesp_int->uf_scg_insert_datastore($ls_codemp,$ls_scg_cuenta,$ls_debhab,$ldec_monto,$ls_documento,$ls_procede,$ls_descripcion);								
				if ($lb_valido===false)
				{  
					$this->io_msg->message("ERROR -> ".$this->io_sigesp_int->is_msg_error);
					break;
				}
			} // end while
			$this->io_sql->free_result($rs_data);	 
		}
		return $lb_valido;
    }// end function uf_procesar_detalles_contable_spi
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_procesar_detalles_ingreso_spi($as_codemp,$as_procede,$as_comprobante,$ad_fecha,$as_descripcion,$as_tipo_destino,$as_codigo_destino)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_procesar_detalles_ingreso_spi
		//		   Access: private
		//	    Arguments: ls_codemp  // C�digo de Empresa
		//				   ls_procede  // Procede del Documento
		//				   ls_comprobante  // N�mero de comprobante
		//				   ad_fecha  // Fecha de Contabilizaci�n
		//				   ls_descripcion  // descripci�n del Comprobante
		//				   ls_tipo_destino  // Destino de la contabilizaci�n
		//				   ls_codigo_destino  // C�digo del Destino
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: M�todo que genera los asientos presupuestarios de ingreso a partirde los movmientos de notas de creditos o d�bitos
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 										Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    $lb_valido=true;		
		$ls_sql="SELECT spi_cuenta, monto, documento, procede_doc, operacion, descripcion, orden, ".
		        "        codestpro1,  codestpro2,  codestpro3,  codestpro4,  codestpro5, estcla   ".
                "  FROM spi_dtmp_cmp ".
                " WHERE codemp='".$as_codemp."' ".
				"   AND comprobante='".$as_comprobante."' ".
				"   AND procede='".$as_procede."' ".
                "   AND fecha='".$ad_fecha."' ".
				" ORDER BY orden";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{   
            $this->io_msg->message("CLASE->Integraci�n SPI M�TODO->uf_procesar_detalles_ingreso_spi ERROR->".$this->io_function->uf_convertirmsg($this->io_sql->message));			
			return false;
		}
		else
		{           
   	       while($row=$this->io_sql->fetch_row($rs_data) and ($lb_valido))
		   {
				$ls_spi_cuenta=$row["spi_cuenta"];
				$ldec_monto=$row["monto"];
				$ls_documento=$row["documento"];
				$ls_procede=$row["procede_doc"];	
				$ls_operacion=$row["operacion"];
				//------------------------------------------------------------------------------
				$ls_codestpro1=$row["codestpro1"];
				$ls_codestpro2=$row["codestpro2"];
				$ls_codestpro3=$row["codestpro3"];
				$ls_codestpro4=$row["codestpro4"];
				$ls_codestpro5=$row["codestpro5"];
				$ls_estcla    =$row["estcla"];
				//------------------------------------------------------------------------------
				$ls_mensaje=$this->io_sigesp_spi->uf_operacion_codigo_mensaje($row["operacion"]);
				$ls_spi_cuenta=$this->io_sigesp_spi->uf_spi_pad_cuenta($ls_spi_cuenta);
				$lb_valido=$this->io_sigesp_int->uf_spi_insert_datastore($as_codemp,$ls_spi_cuenta,$ls_operacion,
																		 $ldec_monto,$ls_documento,$ls_procede,$as_descripcion,
																		 $ls_codestpro1,$ls_codestpro2,$ls_codestpro3,
																		 $ls_codestpro4,$ls_codestpro5, $ls_estcla);				
				if ($lb_valido===false)
				{  
					$this->io_msg->message("ERROR ->".$this->io_sigesp_int->is_msg_error);
					break;
				}
		   } // end while
		}
		$this->io_sql->free_result($rs_data);	 
		return $lb_valido;
    }// end function uf_procesar_detalles_gasto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_estatus_modificacion_spi($as_codemp,$as_procede,$as_comprobante,$ad_fecha,$as_descripcion,$as_tipo_destino,$li_estcon)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_update_estatus_modificacion_spi
		//		   Access: private
		//	    Arguments: as_codemp  // C�digo de Empresa
		//				   as_procede  // Procede del Documento
		//				   as_comprobante  // N�mero de comprobante
		//				   ad_fecha  // Fecha de Contabilizaci�n
		//				   as_descripcion  // descripci�n del Comprobante
		//				   as_tipo_destino  // Destino de la contabilizaci�n
		//				   li_estcon  // estatus de aprobaci�n
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: M�todo que actualiza la solicitud en estatus contabilizado
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 											Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $lb_valido=true;
		$ad_fecha=$this->io_function->uf_convertirdatetobd($ad_fecha);
		$ls_sql="UPDATE sigesp_cmp_md ".
		        "   SET estapro=".$li_estcon.
                " WHERE codemp='".$as_codemp."' ".
				"   AND procede='".$as_procede."' ".
                "   AND comprobante='".$as_comprobante."' ".
				"   AND fecha='".$ad_fecha."' ";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
            $this->io_msg->message("CLASE->Integraci�n SPI M�TODO->uf_update_estatus_modificacion_spi ERROR->".$this->io_function->uf_convertirmsg($this->io_sql->message));			
			$lb_valido=false;
		}
		return $lb_valido;
	}// end function uf_update_estatus_modificacion_spi
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
    function uf_reversar_contabilizacion_modpre_spi($as_comprobante,$ad_fecha,$as_procede,$as_descripcion,$ad_fechaconta,$aa_seguridad)	
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_reversar_contabilizacion_modpre_spi
		//		   Access: public (sigesp_mis_p_reverso_mp_spi.php)
		//	    Arguments: as_comprobante  // C�digo de Comprobante
		//				   ad_fecha  // Fecha de contabilizaci�n
		//				   as_procede  // Procede del Documento
		//				   as_descripcion  // Descripci�n del Documento
		//				   ad_fechaconta  // Fecha de Contabilizaci�n
		//				   aa_seguridad  // Arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: Funcion que procesa el reverso de aprobaci�n de las modificaciones presupuestarias de ingreso
		//	   Creado Por: Ing. Yesenia Moreno	
		// Modificado Por: 										Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   	    $adt_fecha=$ad_fechaconta;
		$lb_valido=false;
        $ls_codemp=$this->io_codemp;
        $ls_procede=$as_procede; 
		$ad_fecha=$this->io_function->uf_convertirdatetobd($ad_fecha);
        $ls_comprobante=$this->io_sigesp_int->uf_fill_comprobante(trim($as_comprobante));
        $ls_tipo_destino="-" ;
		$ls_ced_bene="----------"; 
		$ls_cod_pro="----------";	
		$ls_codban="---";
		$ls_ctaban="-------------------------";
	    $lb_valido=$this->io_sigesp_int->uf_obtener_comprobante($ls_codemp,$ls_procede,$ls_comprobante,$adt_fecha,$ls_codban,
																$ls_ctaban,$ls_tipo_destino,$ls_ced_bene,$ls_cod_pro);
		if ($lb_valido===false) 
		{ 
  			$this->io_msg->message("ERROR-> No existe el comprobante N� ".$ls_comprobante."-".$ls_procede.".");	
			return false;
		}
		$lb_check_close=false;
		$lb_valido = $this->io_sigesp_int->uf_init_delete($ls_codemp,$ls_procede,$ls_comprobante,$adt_fecha,$ls_tipo_destino,
														  $ls_ced_bene,$ls_cod_pro,$lb_check_close,$ls_codban,$ls_ctaban);
		if($lb_valido===false )	
		{ 
 		   $this->io_msg->message("ERROR-> ".$this->io_sigesp_int->is_msg_error);
		   return false; 
		}
        $this->io_sigesp_int->uf_int_init_transaction_begin();	
	    if  ($lb_valido)
		{
			$lb_valido = $this->io_sigesp_int->uf_init_end_transaccion_integracion($aa_seguridad); 
			if ( $lb_valido===false)
			{
				$this->io_msg->message("ERROR-> ".$this->io_sigesp_int->is_msg_error);
			}		   
		}
		if ($lb_valido) 
		{ 
			$lb_valido=$this->uf_update_estatus_modificacion_spi($ls_codemp,$ls_procede,$ls_comprobante,$ad_fecha,$as_descripcion,$ls_tipo_destino,0);
		}
		if ($lb_valido===false)
		{
		   $this->io_msg->message("ERROR-> al cambiar estatus de Modificacion presupuestaria  ".$as_comprobante);
		}
		if($lb_valido)
		{
			$lb_valido = $this->uf_update_fecha_contabilizado_spi($ls_codemp,$ad_fecha,$ls_comprobante,$as_procede,'1900-01-01','1900-01-01');
		}
		if($lb_valido)
		{
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
			$ls_evento="PROCESS";
			$ls_descripcion="Revers� las Modificaciones Presupuestarias de Ingreso Comprobante <b>".$as_comprobante."</b>, ".
							"Procede <b>".$as_procede."</b>, Fecha Documento <b>".$ad_fecha."</b>";
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
		}
		$this->io_sigesp_int->uf_sql_transaction($lb_valido);
		return $lb_valido;
	}// end function uf_reversar_contabilizacion_modpre_spi
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_fecha_contabilizado_spi($as_codemp,$ad_fecha,$as_comprobante,$as_procede,$ad_fechaconta,$ad_fechaanula)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_update_fecha_contabilizado_spi
		//		   Access: private
		//	    Arguments: as_codemp  // C�digo
		//                 ad_fecha  // Fecha de Comprobante
		//                 as_comprobante  // N�mero de Comprobante 
		//                 as_procede  // Procede del Documento
		//                 ad_fechaconta  // Fecha de contabilizaci�n
		//                 ad_fechaanula  // Fecha de Anulaci�n
		//	      Returns: lb_valido True si se ejecuto la contabilizaci�n correctamente
		//	  Description: M�todo que actualiza la solicitud en estatus contabilizado
		//	   Creado Por: Ing. Wilmer Brice�o
		// Modificado Por: Ing. Yesenia Moreno								Fecha �ltima Modificaci�n : 07/11/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $lb_valido=true;
		$ls_campo1="";
		$ls_campo2="";
		if($ad_fechaconta!="")
		{
			$ls_campo1=" fechaconta='".$ad_fechaconta."' ";
		}
		if($ad_fechaanula!="")
		{
			$ls_campo2=" fechaanula='".$ad_fechaanula."' ";
		}
		if($ls_campo1!="")
		{
			if($ls_campo2!="")
			{
				$ls_campos=$ls_campo1.", ".$ls_campo2;
			}
			else
			{
				$ls_campos=$ls_campo1;
			}
		}
		else
		{
			$ls_campos=$ls_campo2;
		}
		$ls_sql="UPDATE sigesp_cmp_md ".
		        "   SET ".$ls_campos.
                " WHERE codemp='".$as_codemp."' ".
				"   AND procede ='".$as_procede."' ".
				"   AND fecha='".$ad_fecha."' ".
				"   AND comprobante='".$as_comprobante."' ";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
            $this->io_msg->message("CLASE->Integraci�n SPI M�TODO->uf_update_fecha_contabilizado_spi ERROR->".$this->io_function->uf_convertirmsg($this->io_sql->message));			
			$lb_valido=false;
		}
		return $lb_valido;
	}// end function uf_update_fecha_contabilizado_spi
	//-----------------------------------------------------------------------------------------------------------------------------------
}
?>