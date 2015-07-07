<?php
class sigesp_snorh_c_ubicacionfisica
{
	var $io_sql;
	var $io_mensajes;
	var $io_funciones;
	var $io_seguridad;
	var $io_personalnomina;
	var $ls_codemp;

	//-----------------------------------------------------------------------------------------------------------------------------------
	function sigesp_snorh_c_ubicacionfisica()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: sigesp_snorh_c_ubicacionfisica
		//		   Access: public (sigesp_snorh_d_ubicacionfisica)
		//	  Description: Constructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
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
		require_once("sigesp_sno_c_personalnomina.php");
		$this->io_personalnomina=new sigesp_sno_c_personalnomina();
        $this->ls_codemp=$_SESSION["la_empresa"]["codemp"];
	}// end function sigesp_snorh_c_ubicacionfisica
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_destructor()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_destructor
		//		   Access: public (sigesp_snorh_d_ubicacionfisica)
		//	  Description: Destructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		unset($io_include);
		unset($io_conexion);
		unset($this->io_sql);	
		unset($this->io_mensajes);		
		unset($this->io_funciones);		
		unset($this->io_seguridad);
		unset($this->io_personalnomina);
        unset($this->ls_codemp);
	}// end function uf_destructor
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_ubicacionfisica($as_codubifis)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_ubicacionfisica
		//		   Access: private
		//	    Arguments: as_codubifis  // c�digo de la ubicaci�n f�sica
		//	      Returns: lb_existe True si existe � False si no existe
		//	  Description: Funcion que verifica si la profesi�n est� registrada
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_existe=true;
		$ls_sql="SELECT codubifis FROM sno_ubicacionfisica ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codubifis='".$as_codubifis."'";
				
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_select_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$lb_existe=false;
		}
		else
		{
			if(!$row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_existe=false;
			}
			$this->io_sql->free_result($rs_data);
		}
		return $lb_existe;
	}// end function uf_select_ubicacionfisica
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_ubicacionfisica($as_codubifis,$as_desubifis,$as_codpai,$as_codest,$as_codmun,$as_codpar,$as_dirubifis,
									   $aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_ubicacionfisica
		//		   Access: private
		//	    Arguments: as_codubifis  // c�digo de la ubicaci�n f�sica
		//				   as_desubifis  // descripci�n de la ubicaci�n f�sica
		//				   as_codpai  // C�digo del Pa�s
		//				   as_codest  // C�digo del Estado
		//				   as_codmun  // C�digo del Municipio
		//				   as_codpar  // C�digo de Parroquia
		//				   as_dirubifis  // Direcci�n de la Ubicaci�n F�sica
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funcion que inserta en la tabla sno_ubicacionfisica
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="INSERT INTO sno_ubicacionfisica(codemp,codubifis,desubifis,codpai,codest,codmun,codpar,dirubifis) ".
				" VALUES('".$this->ls_codemp."','".$as_codubifis."','".$as_desubifis."','".$as_codpai."','".$as_codest."', ".
				"'".$as_codmun."','".$as_codpar."','".$as_dirubifis."')";
		$this->io_sql->begin_transaction()	;
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
 			$lb_valido=false;
			$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_insert_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="INSERT";
			$ls_descripcion ="Insert� la Ubicaci�n f�sica ".$as_codubifis;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
			if($lb_valido)
			{	
				$this->io_mensajes->message("La Ubiciaci�n F�sica fue Registrada.");
				$this->io_sql->commit();
			}
			else
			{
				$lb_valido=false;
				$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_insert_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				$this->io_sql->rollback();
			}
		}
		return $lb_valido;
	}// end function uf_insert_ubicacionfisica	
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_ubicacionfisica($as_codubifis,$as_desubifis,$as_codpai,$as_codest,$as_codmun,$as_codpar,$as_dirubifis,
									   $aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_update_ubicacionfisica
		//		   Access: private
		//	    Arguments: as_codubifis  // c�digo de la ubicaci�n f�sica
		//				   as_desubifis  // descripci�n de la ubicaci�n f�sica
		//				   as_codpai  // C�digo del Pa�s
		//				   as_codest  // C�digo del Estado
		//				   as_codmun  // C�digo del Municipio
		//				   as_codpar  // C�digo de Parroquia
		//				   as_dirubifis  // Direcci�n de la Ubicaci�n F�sica
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el update � False si hubo error en el update
		//	  Description: Funcion que actualiza en la tabla sno_profesi�n
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="UPDATE sno_ubicacionfisica ".
				"   SET desubifis='".$as_desubifis."', ".
				"   	codpai='".$as_codpai."', ".
				"   	codest='".$as_codest."', ".
				"   	codmun='".$as_codmun."', ".
				"   	codpar='".$as_codpar."', ".
				"   	dirubifis='".$as_dirubifis."' ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codubifis='".$as_codubifis."'";
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$lb_valido=false;
			$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_update_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$this->io_sql->rollback();
		}
		else
		{
			////////////////////////////////         SEGURIDAD               //////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualiz� la Ubicaci�n F�sica ".$as_codubifis;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
			if($lb_valido)
			{	
				$this->io_mensajes->message("La Ubiciaci�n F�sica fue Actualizada.");
				$this->io_sql->commit();
			}
			else
			{
				$lb_valido=false;
				$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_update_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				$this->io_sql->rollback();
			}
		}
		return $lb_valido;
	}// end function uf_update_ubicacionfisica		
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_guardar($as_existe,$as_codubifis,$as_desubifis,$as_codpai,$as_codest,$as_codmun,$as_codpar,$as_dirubifis,
						$aa_seguridad)
	{		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_guardar
		//		   Access: public (sigesp_snorh_d_ubicacionfisica)
		//	    Arguments: as_codubifis  // c�digo de la ubicaci�n f�sica
		//				   as_desubifis  // descripci�n de la ubicaci�n f�sica
		//				   as_codpai  // C�digo del Pa�s
		//				   as_codest  // C�digo del Estado
		//				   as_codmun  // C�digo del Municipio
		//				   as_codpar  // C�digo de Parroquia
		//				   as_dirubifis  // Direcci�n de la Ubicaci�n F�sica
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el guardar � False si hubo error en el guardar
		//	  Description: Funcion que guarda en la tabla sno_ubicacionfisica
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;		
		switch ($as_existe)
		{
			case "FALSE":
				if(!($this->uf_select_ubicacionfisica($as_codubifis)))
				{
					$lb_valido=$this->uf_insert_ubicacionfisica($as_codubifis,$as_desubifis,$as_codpai,$as_codest,$as_codmun,
																$as_codpar,$as_dirubifis,$aa_seguridad);
				}
				else
				{
					$this->io_mensajes->message("La Ubiciaci�n F�sica ya existe, no la puede incluir.");
				}
				break;

			case "TRUE":
				if(($this->uf_select_ubicacionfisica($as_codubifis)))
				{
					$lb_valido=$this->uf_update_ubicacionfisica($as_codubifis,$as_desubifis,$as_codpai,$as_codest,$as_codmun,
																$as_codpar,$as_dirubifis,$aa_seguridad);
				}
				else
				{
					$this->io_mensajes->message("La Ubiciaci�n F�sica no existe, no la puede actualizar.");
				}
				break;
		}
		return $lb_valido;
	}// end function uf_guardar		
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
    function uf_integridad_personal($as_codubifis)
    {
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	Function:     uf_integridad_personal
		//	Arguments:    as_codubifis  // c�digo de la ubicaci�n f�sica
		//	Returns:	  $lb_valido True si existe la ubicacionfisica en la tabla personal False si no existe
		//	Description:  Funcion que valida que ning�n personal tenga relacionada esa profesi�n
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 		$lb_existe=false;
       	$ls_sql="SELECT COUNT(codemp) as total ".
				"  FROM sno_personalnomina ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codubifis='".$as_codubifis."'";
		
       	$rs_per=$this->io_sql->select($ls_sql);
       	if ($rs_per==false)
       	{
        	$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_integridad_personal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
       	}
       	else
       	{
			if ($row=$this->io_sql->fetch_row($rs_per))
         	{
            	$li_row=$row["total"];
            	if ($li_row>0)  
				{
               		$lb_existe=true;
				}
         	}
       	}
		$this->io_sql->free_result($rs_per);
		return $lb_existe ;    
	}// end function uf_integridad_personal		
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_delete_ubicacionfisica($as_codubifis,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	Function:     uf_delete_ubicacionfisica
		//	Arguments:    as_codubifis  // c�digo de la ubicaci�n f�sica
		//				  aa_seguridad  // arreglo de las variables de seguridad
		//	Returns:	  $lb_valido True si se ejecuto el delete � False si hubo error en el delete
		//	Description:  Funcion que elimina de la tabla sno_profesi�n
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
        if ($this->io_personalnomina->uf_select_personalnomina("codubifis",$as_codubifis,"0")===false)   
		{
			$ls_sql="DELETE FROM sno_ubicacionfisica ".
					" WHERE codemp='".$this->ls_codemp."'".
					"   AND codubifis='".$as_codubifis."'";
					
        	$this->io_sql->begin_transaction();
		   	$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$lb_valido=false;
				$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_delete_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				$this->io_sql->rollback();
			}
			else
			{
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="DELETE";
				$ls_descripcion ="Elimin� la Ubicaci�n F�sica ".$as_codubifis;
				$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////	
				if($lb_valido)
				{	
					$this->io_mensajes->message("La Ubiciaci�n F�sica fue Eliminada.");
					$this->io_sql->commit();
				}
				else
				{
					$lb_valido=false;
					$this->io_mensajes->message("CLASE->Ubicaci�n F�sica M�TODO->uf_delete_ubicacionfisica ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
					$this->io_sql->rollback();
				}
			}
		} 
		else
		{
			$this->io_mensajes->message("No se puede eliminar la Ubiciaci�n F�sica. Hay personal asociado a esta.");
			$lb_valido=false;
		}       
		return $lb_valido;
    }// end function uf_delete_ubicacionfisica
	//-----------------------------------------------------------------------------------------------------------------------------------
}
?>