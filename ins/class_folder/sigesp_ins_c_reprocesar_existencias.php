<?php
class sigesp_ins_c_reprocesar_existencias
{
	var $io_sql;
	var $io_message;
	var $io_function;
	var $is_msg_error;

	//-----------------------------------------------------------------------------------------------------------------------------------
	function sigesp_ins_c_reprocesar_existencias()
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: sigesp_sep_c_solicitud
		//		   Access: public 
		//	  Description: Constructor de la Clase
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 25/05/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		require_once("../shared/class_folder/sigesp_include.php");
		$io_include=new sigesp_include();
		$io_conexion=$io_include->uf_conectar();
		require_once("../shared/class_folder/class_sql.php");
		$this->io_sql=new class_sql($io_conexion);	
		require_once("../shared/class_folder/class_mensajes.php");
		$this->io_mensajes=new class_mensajes();		
		require_once("../shared/class_folder/class_funciones.php");
		$this->io_funciones=new class_funciones();		
		require_once("../shared/class_folder/sigesp_c_seguridad.php");
		$this->io_seguridad= new sigesp_c_seguridad();
	    require_once("../shared/class_folder/class_fecha.php");		
		$this->io_fecha= new class_fecha();
		require_once("../siv/sigesp_siv_c_movimientoinventario.php");
		$this->io_mov=  new sigesp_siv_c_movimientoinventario();
        $this->ls_codemp=$_SESSION["la_empresa"]["codemp"];
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_existencias($aa_seguridad)
	{
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_update_existencias
		//		   Access: public
		//		 Argument: aa_seguridad  // Arreglo de Registro de Seguridad
		//	  Description: Funci�n que actualiza las existencias de los articulos por almacen
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 25/05/2007								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$lb_valido=$this->uf_siv_update_existencias_cero();
		if($lb_valido)
		{
			$ls_sql="SELECT SUM(canart) AS totartalm,codalm,codart,cosart".
					"  FROM siv_dt_movimiento".
					" WHERE opeinv='ENT'".
					"    OR opeinv='AJE'".
					" GROUP BY  codalm,codart,cosart ".
					" ORDER BY codart";
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_mensajes->message("CLASE->Reprocesar_existencias M�TODO->uf_update_existencias ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				return false;
			}
			else
			{
				while($row=$this->io_sql->fetch_row($rs_data))
				{
					$ai_inicial=0.00;
					$ls_codart=$row["codart"];
					$li_cosart=$row["cosart"];
					$ls_codalm=$row["codalm"];
					$li_totartalm=$row["totartalm"];
					$lb_valido=$this->uf_siv_update_existencias_almacen($ls_codart,$ls_codalm,$ai_inicial,$aa_seguridad);
					if($lb_valido)
					{
						$lb_valido=$this->uf_load_salidas($ls_codart,$ls_codalm,&$li_canartdes);
						if($lb_valido)
						{
							$li_totexialm=($li_totartalm-$li_canartdes);
							if($li_totexialm<0)
							{
								$ld_date=date("Y-m-d");
								$ls_nomsol="Ajuste de Inventario";
								$ls_codusu="SIGESP";
								$lb_valido=$this->io_mov->uf_siv_insert_movimiento(&$ls_nummov,$ld_date,$ls_nomsol,$ls_codusu,$aa_seguridad);
								if($lb_valido)
								{
									$ls_opeinv="ENT";
									$ls_codprodoc="AJE";
									$li_canaju=abs($li_totexialm);
									$ls_promov="TOM";
									$li_candesart=0.00;
									$lb_valido=$this->io_mov->uf_siv_insert_dt_movimiento($this->ls_codemp,$ls_nummov,$ld_date,$ls_codart,$ls_codalm,
																						  $ls_opeinv,$ls_codprodoc,$ls_nummov,$li_canaju,$li_cosart,
																						  $ls_promov,$ls_nummov,$li_candesart,$ld_date,
																						  $aa_seguridad);
									if($lb_valido)
									{
										$li_totexialm=0.00;
										$lb_valido=$this->uf_siv_update_existencias_almacen($ls_codart,$ls_codalm,$li_totexialm,$aa_seguridad);
									}
								}
							}
							else
							{
								$lb_valido=$this->uf_siv_update_existencias_almacen($ls_codart,$ls_codalm,$li_totexialm,$aa_seguridad);
							}
						}
					}
				
				}
			}
		}
		return $lb_valido;
	}// end function uf_load_cargosbienes
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_load_salidas($as_codart,$as_codalm,&$ai_canartdes)
	{
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_salidas
		//		   Access: public
		//		 Argument: as_codart    // Codigo del Articulo
		//                 as_codalm    // Codigo del Almacen
		//                 ai_canartdes // Cantidad de Articulos despachados
		//	  Description: Funci�n que obtiene las salidas de inventario de un articulo en determinado almacen
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 25/05/2007								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		$ai_canartdes=0;
		$lb_valido=true;
		$ls_sql="SELECT SUM(canart) AS canartdes,codalm,codart".
				"  FROM siv_dt_movimiento".
				" WHERE (opeinv='SAL'".
				"        OR (opeinv='REV' AND codprodoc='REV' AND promov='RPC')".
				"        OR opeinv='AJS')".
				"   AND codemp='".$this->ls_codemp."'".
				"   AND codart='".$as_codart."'".
				"   AND codalm='".$as_codalm."'".
				" GROUP BY  codalm,codart";
  		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Reprocesar_existencias M�TODO->uf_load_salidas ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			return false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$ai_canartdes=$row["canartdes"];
			}
		}
		return $lb_valido;
	}// end function uf_load_salidas
	//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_siv_update_existencias_almacen($as_codart,$as_codalm,$ai_canartalm,$aa_seguridad) 
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_siv_update_existencias_almacen
		//         Access: public  
		//      Argumento: $as_codart    // Codigo de Articulo
		//				   $as_codalm    // Codigo de Almacen
		//				   $ai_canartalm // Cantidad de Articulos existentes en el Almacen
		//				   $aa_seguridad // Arreglo de Registro de Seguridad
		//    Description: Funcion que actualiza los totales de articulos por almacen
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 25/05/2007 							
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 	$lb_valido=true;
		$ls_sql= "UPDATE siv_articuloalmacen".
				 "   SET existencia=".$ai_canartalm." ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codart='".$as_codart."'".
				 "   AND codalm='".$as_codalm."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->Reprocesar_existencias M�TODO->uf_siv_update_existencias_almacen ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualiz� la Existencia del Articulo ".$as_codart." en el Almacen ". $as_codalm ." en ". $ai_canartalm ." . Asociado a la Empresa ".$this->ls_codemp;
			$lb_variable= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
										   	   $aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											   $aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
		}
	    return $lb_valido;
	} // end  function uf_siv_update_existencias_almacen
	//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_siv_update_existencias_cero() 
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_siv_update_existencias_almacen
		//         Access: public  
		//      Argumento: 
		//    Description: Funcion que actualiza los totales de articulos por almacen
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 25/05/2007 							
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 	$lb_valido=true;
		$ls_sql= "UPDATE siv_articuloalmacen".
				 "   SET existencia=0.00".
				 " WHERE codemp='".$this->ls_codemp."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->Reprocesar_existencias M�TODO->uf_siv_update_existencias_almacen ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
	    return $lb_valido;
	} // end  function uf_siv_update_existencias_almacen
	//-----------------------------------------------------------------------------------------------------------------------------------

}
?>