<?php
class sigesp_snorh_c_proyecto
{
	var $io_sql;
	var $io_mensajes;
	var $io_funciones;
	var $io_seguridad;
	var $io_personal;
	var $ls_codemp;

	//-----------------------------------------------------------------------------------------------------------------------------------
	function sigesp_snorh_c_proyecto()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: sigesp_snorh_c_proyecto
		//		   Access: public (sigesp_snorh_d_proyecto)
		//	  Description: Constructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
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
		$this->io_seguridad=new sigesp_c_seguridad();
        $this->ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$this->ls_codnom="0000";
		if(array_key_exists("la_nomina",$_SESSION))
		{
        	$this->ls_codnom=$_SESSION["la_nomina"]["codnom"];
		}
	}// end function sigesp_snorh_c_proyecto
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_destructor()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_destructor
		//		   Access: public (sigesp_snorh_d_proyecto)
		//	  Description: Destructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		unset($io_include);
		unset($io_conexion);
		unset($this->io_sql);	
		unset($this->io_mensajes);		
		unset($this->io_funciones);		
		unset($this->io_seguridad);
        unset($this->ls_codemp);
	}// end function uf_destructor
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_proyecto($as_codproy)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_proyecto
		//		   Access: private
 		//	    Arguments: as_codproy  // c�digo del proyecto
		//	      Returns: lb_existe True si existe � False si no existe
		//	  Description: Funcion que verifica si el proyecto existe
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_existe=true;
		$ls_sql= "SELECT codemp ".
				 "  FROM sno_proyecto ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codproy='".$as_codproy."' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_select_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
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
	}// end function uf_select_proyecto
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_proyecto($as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_proyecto
		//		   Access: private
		//	    Arguments: as_codproy  // c�digo del Proyecto
		//				   as_nomproy  // descripci�n del Proyecto
		//				   as_codpro  // Estructura program�tica 5 niveles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funcion que inserta en la tabla sno_proyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql= "INSERT INTO sno_proyecto (codemp,codproy,nomproy,estproproy,estcla)VALUES('".$this->ls_codemp."','".$as_codproy."','".$as_nomproy."','".$as_codpro."','".$as_estcla."')";
		$this->io_sql->begin_transaction()	;
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
 			$lb_valido=false;
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_insert_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$this->io_sql->rollback();
		}
		else
		{
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="INSERT";
			$ls_descripcion ="Insert� el Proyecto ".$as_codproy;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
			if($lb_valido)
			{	
				$this->io_mensajes->message("El Proyecto fue Registrado.");
				$this->io_sql->commit();
			}
			else
			{
				$lb_valido=false;
        		$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_insert_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				$this->io_sql->rollback();
			}
		}
		return $lb_valido;
	}// end function uf_insert_proyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_proyecto($as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//    	 Function: uf_update_proyecto
		//		   Access: private
		//	    Arguments: as_codproy  // c�digo del Proyecto
		//				   as_nomproy  // descripci�n del Proyecto
		//				   as_codpro  // Estructura program�tica  5 niveles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el update � False si hubo error en el update
		//	  Description: Funcion que actualiza en la tabla sno_proyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql= "UPDATE sno_proyecto ".
				 "   SET nomproy='".$as_nomproy."', ".
				 "       estproproy='".$as_codpro."', ".
				 "        estcla= '".$as_estcla."'".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codproy='".$as_codproy."' ";
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$lb_valido=false;
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$this->io_sql->rollback();
		}
		else
		{
			////////////////////////////////         SEGURIDAD               //////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualiz� el Proyecto ".$as_codproy;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
			if($lb_valido)
			{	
				$this->io_mensajes->message("El Proyecto fue Actualizado.");
				$this->io_sql->commit();
			}
			else
			{
				$lb_valido=false;
        		$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				$this->io_sql->rollback();
			}
		}
		return $lb_valido;
	}// end function uf_update_proyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_guardar($as_existe,$as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad)
	{		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_guardar
		//		   Access: public (sigesp_snorh_d_proyecto)
		//	    Arguments: as_codproy  // c�digo del Proyecto
		//				   as_nomproy  // descripci�n del Proyecto
		//				   as_codpro  // Estructura program�tica 5 Niveles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el guardar � False si hubo error en el guardar
		//	  Description: Funcion que guarda en la tabla sno_proyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;		
		switch ($as_existe)
		{
			case "FALSE":
				if($this->uf_select_proyecto($as_codproy)===false)
				{
					$lb_valido=$this->uf_insert_proyecto($as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad);
				}
				else
				{
					$this->io_mensajes->message("El Proyecto ya existe, no lo puede incluir.");
				}
				break;

			case "TRUE":
				if(($this->uf_select_proyecto($as_codproy)))
				{
					$lb_valido=$this->uf_update_proyecto($as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad);
				}
				else
				{
					$this->io_mensajes->message("El Proyecto no existe, no lo puede actualizar.");
				}
				break;
		}
		return $lb_valido;
	}// end function uf_guardar
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_proyectopersonal($as_codproy)
	{
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_proyectopersonal
		//		   Access: private
		//	    Arguments: as_codproy  // c�digo del Proyecto
		//	      Returns: lb_existe True si existe � False si no existe
		//	  Description: Funcion que verifica si el personal tiene asociado este Proyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		$lb_existe=true;
		$ls_sql="SELECT codper ".
				"  FROM sno_proyectopersonal ".
				" WHERE codemp='".$this->ls_codemp."'".
				 "  AND codproy='".$as_codproy."' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_select_proyectopersonal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
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
	}// end function uf_select_proyectopersonal
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_delete_proyecto($as_codproy,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_delete_proyecto
		//		   Access: public (sigesp_snorh_d_proyecto)
		//	    Arguments: as_codproy  // c�digo del Proyecto
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el delete � False si hubo error en el delete
		//	  Description: Funcion que elimina de la tabla sno_proyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
        if($this->uf_select_proyectopersonal($as_codproy)===false)
		{
			$ls_sql="DELETE ".
			        "  FROM sno_proyecto ".
				    " WHERE codemp='".$this->ls_codemp."' ".
				    "   AND codproy='".$as_codproy."' ";
        	$this->io_sql->begin_transaction();
		   	$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$lb_valido=false;
        		$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_delete_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				$this->io_sql->rollback();
			}
			else
			{
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="DELETE";
				$ls_descripcion ="Elimin� el Proyecto ".$as_codproy;
				$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////	
				if($lb_valido)
				{	
					$this->io_mensajes->message("El Proyecto fue Eliminado.");
					$this->io_sql->commit();
				}
				else
				{
					$lb_valido=false;
        			$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_delete_proyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
					$this->io_sql->rollback();
				}
			}
		} 
		else
		{
			$lb_valido=false;
			$this->io_mensajes->message("No se puede eliminar el Proyecto, hay personal relacionado a este.");
		}       
		return $lb_valido;
    }// end function uf_delete_proyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_load_personalproyecto($as_codper,&$ai_totdiaper,&$ai_porcentaje,&$ai_totrows,&$aa_object)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_personalproyecto
		//		   Access: public (sigesp_sno_d_personaproyecto.php)
		//	    Arguments: as_codper  // C�digo de personal
		//				   ai_totdiaper  // Total de D�as del periodo
		//				   ai_porcentaje  // Total de Porcentaje 
		//				   ai_totrows  // Total de Filas
		//				   aa_object  //  Arreglo de objectos que se van a imprimir
		//	      Returns: $lb_valido True si se ejecuto el select � False si hubo error en el select
		//	  Description: Funci�n que obtiene los proyectos asociados a la persona
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ai_totdiaper=0;
		$ai_porcentaje=0;
		$ls_sql="SELECT sno_proyecto.codproy, sno_proyecto.nomproy, sno_proyectopersonal.totdiaper, sno_proyectopersonal.totdiames, ".
				"		sno_proyectopersonal.pordiames ".
				"  FROM sno_proyecto, sno_proyectopersonal ".
				" WHERE sno_proyecto.codemp='".$this->ls_codemp."' ".
				"   AND sno_proyectopersonal.codnom='".$this->ls_codnom."' ".
				"   AND sno_proyectopersonal.codper='".$as_codper."' ".
				"   AND sno_proyecto.codemp = sno_proyectopersonal.codemp ".
				"   AND sno_proyecto.codproy = sno_proyectopersonal.codproy ".
				" ORDER BY codproy ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_load_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$lb_valido=false;
		}
		else
		{
			$ai_totrows=0;
			while($row=$this->io_sql->fetch_row($rs_data))
			{
				$ai_totrows++;
				$ls_codproy=$row["codproy"];  
				$ls_nomproy=$row["nomproy"];
				$li_totdiaper=number_format($row["totdiaper"],0);
				$li_totdiames=number_format($row["totdiames"],2,",",".");
				$li_pordiames=number_format(($row["pordiames"]*100),2,",",".");
				$ai_porcentaje=$ai_porcentaje+($row["pordiames"]*100);
				$aa_object[$ai_totrows][1]="<div align='center'><a href=javascript:ue_eliminarproyecto('$ls_codproy');><img src='../shared/imagebank/tools20/eliminar.gif' alt='Eliminar' width='15' height='15' border='0'></a></div>";
				$aa_object[$ai_totrows][2]="<input type=text   name=txtcodproy".$ai_totrows."   id=txtcodproy".$ai_totrows."   value='".$ls_codproy."'   size=12 class=sin-borde readonly>";
				$aa_object[$ai_totrows][3]="<input type=text   name=txtnomproy".$ai_totrows."   id=txtnomproy".$ai_totrows."   value='".$ls_nomproy."'   size=50 class=sin-borde readonly >";
				$aa_object[$ai_totrows][4]="<input type=text   name=txtpordiames".$ai_totrows." id=txtpordiames".$ai_totrows." value='".$li_pordiames."' size=8  class=sin-borde maxlength=6 style=text-align:right onKeyPress=return(ue_formatonumero(this,'.',',',event)) onBlur=javascript:uf_sumar(".$ai_totrows.")>".
										   "<input type=hidden name=txttotdiames".$ai_totrows." id=txttotdiames".$ai_totrows." value='".$li_totdiames."'>";
			}
			$this->io_sql->free_result($rs_data);		
			$ai_porcentaje=number_format($ai_porcentaje,2,",",".");
		}
		return $lb_valido;
	}// end function uf_load_personalproyecto	
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_porcentajeproyecto($as_codper,$as_codproy,&$ai_porcentaje)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_porcentajeproyecto
		//		   Access: private
 		//	    Arguments: as_codper  // c�digo del personal
		//				   as_codproy  // c�digo del proyecto
		//				   ai_porcentaje  // Porcentaje
		//	      Returns: lb_valido True si la funci�n es v�lida � false si ocurre alg�n error
		//	  Description: Funcion que obtiene la suma de los porcentajes
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 31/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql= "SELECT sum(pordiames) as porcentaje ".
				 "  FROM sno_proyectopersonal ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codper<>'".$as_codper."' ".
				 "   AND codproy='".$as_codproy."' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_select_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$lb_valido=false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$ai_porcentaje=$row["porcentaje"];
			}
			$this->io_sql->free_result($rs_data);
		}
		return $lb_valido;
	}// end function uf_select_porcentajeproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_personalproyecto($as_codper,$as_codproy)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_personalproyecto
		//		   Access: private
 		//	    Arguments: as_codproy  // c�digo del proyecto
		//	      Returns: lb_existe True si existe � False si no existe
		//	  Description: Funcion que verifica si la persona tiene el proyecto asociado existe
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_existe=true;
		$ls_sql= "SELECT codemp ".
				 "  FROM sno_proyectopersonal ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codnom='".$this->ls_codnom."' ".
				 "   AND codper='".$as_codper."' ".
				 "   AND codproy='".$as_codproy."' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_select_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
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
	}// end function uf_select_personalproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_personalproyecto($as_codper,$as_codproy,$ai_totdiaper,$ai_totdiames,$ai_pordiames,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_personalproyecto
		//		   Access: private
		//	    Arguments: as_codper  // c�digo del Personal
		//				   as_codproy  // C�digo del proyecto
		//				   ai_totdiaper  // total de d�as Habiles del periodo
		//				   ai_totdiames  // total de d�as h�biles de las personas en el proyecto
		//				   ai_pordiames  // procentaje del total de d�as h�biles del proyecto con respecto a los d�as habiles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funcion que inserta en la tabla sno_proyectopersonal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="INSERT INTO sno_proyectopersonal (codemp,codnom,codproy,codper,totdiaper,totdiames,pordiames) VALUES ".
				"('".$this->ls_codemp."','".$this->ls_codnom."','".$as_codproy."','".$as_codper."',".$ai_totdiaper.", ".
				"".$ai_totdiames.",".$ai_pordiames.")";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
 			$lb_valido=false;
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_insert_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
		}
		else
		{
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="INSERT";
			$ls_descripcion ="Insert� el Proyecto Personal ".$as_codproy." - ".$as_codper;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
		}
		return $lb_valido;
	}// end function uf_insert_personalproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_personalproyecto($as_codper,$as_codproy,$ai_totdiaper,$ai_totdiames,$ai_pordiames,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//    	 Function: uf_update_personalproyecto
		//		   Access: private
		//	    Arguments: as_codper  // c�digo del Personal
		//				   as_codproy  // C�digo del proyecto
		//				   ai_totdiaper  // total de d�as Habiles del periodo
		//				   ai_totdiames  // total de d�as h�biles de las personas en el proyecto
		//				   ai_pordiames  // procentaje del total de d�as h�biles del proyecto con respecto a los d�as habiles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el update � False si hubo error en el update
		//	  Description: Funcion que actualiza en la tabla sno_proyectopersonal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql= "UPDATE sno_proyectopersonal ".
				 "   SET totdiaper=".$ai_totdiaper.", ".
				 "       totdiames=".$ai_totdiames.", ".
				 "       pordiames=".$ai_pordiames." ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codnom='".$this->ls_codnom."' ".
				 "   AND codproy='".$as_codproy."' ".
				 "   AND codper='".$as_codper."' ";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$lb_valido=false;
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
		}
		else
		{
			////////////////////////////////         SEGURIDAD               //////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualiz� el Proyecto Personal ".$as_codproy." - ".$as_codper;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////	
		}
		return $lb_valido;
	}// end function uf_update_personalproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_guardar_personalproyecto($as_codper,$as_codproy,$ai_totdiaper,$ai_totdiames,$ai_pordiames,$aa_seguridad)
	{		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_guardar_personalproyecto
		//		   Access: public (sigesp_sno_d_personaproyecto)
		//	    Arguments: as_codper  // c�digo del Personal
		//				   as_codproy  // C�digo del proyecto
		//				   ai_totdiaper  // total de d�as Habiles del periodo
		//				   ai_totdiames  // total de d�as h�biles de las personas en el proyecto
		//				   ai_pordiames  // procentaje del total de d�as h�biles del proyecto con respecto a los d�as habiles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el guardar � False si hubo error en el guardar
		//	  Description: Funcion que guarda en la tabla sno_proyectopersonal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;	
		//$li_porcentaje=0;
		//$lb_valido=$this->uf_select_porcentajeproyecto($as_codper,$as_codproy,&$li_porcentaje);
		//if($lb_valido)
		//{
			//$li_porcentaje=($li_porcentaje+$ai_pordiames)*100;
			//if($li_porcentaje<=100)
			//{
				if($this->uf_select_personalproyecto($as_codper,$as_codproy)===false)
				{
					$lb_valido=$this->uf_insert_personalproyecto($as_codper,$as_codproy,$ai_totdiaper,$ai_totdiames,$ai_pordiames,
																 $aa_seguridad);
				}
				else
				{
					$lb_valido=$this->uf_update_personalproyecto($as_codper,$as_codproy,$ai_totdiaper,$ai_totdiames,$ai_pordiames,
																 $aa_seguridad);
				}
			//}
			//else
			//{
			//	$lb_valido=false;
			//	$this->io_mensajes->message("ERROR-> Para el Proyecto ".$as_codproy." hay mas del 100 % Asignado"); 
			//}
		//}
		return $lb_valido;
	}// end function uf_guardar_personalproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_delete_personalproyecto($as_codper,$as_codproy,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_delete_personalproyecto
		//		   Access: public (sigesp_sno_d_personaproyecto)
		//	    Arguments: as_codper  // c�digo del Personal
		//				   as_codproy  // C�digo del proyecto
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el delete � False si hubo error en el delete
		//	  Description: Funcion que elimina de la tabla sno_proyectopersonal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 09/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		if($this->uf_select_personalproyecto($as_codper,$as_codproy))
		{
			$ls_sql="DELETE ".
					"  FROM sno_proyectopersonal ".
					" WHERE codemp='".$this->ls_codemp."' ".
					"   AND codnom='".$this->ls_codnom."' ".
					"   AND codproy='".$as_codproy."' ".
					"   AND codper='".$as_codper."' ";
			$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$lb_valido=false;
				$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_delete_personalproyecto ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			}
			else
			{
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="DELETE";
				$ls_descripcion ="Elimin� el Proyecto Personal ".$as_codproy." - ".$as_codper;
				$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////	
			}
		}
		return $lb_valido;
    }// end function uf_delete_personalproyecto
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_update_proyecto_historico($as_codproy,$as_nomproy,$as_codpro,$as_estcla,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//    	 Function: uf_update_proyecto_historico
		//		   Access: private
		//	    Arguments: as_codproy  // c�digo del proyecto
		//				   as_nomproy  // nombre del proyecto
		//				   as_codpro  // Estructura program�tica  5 niveles
		//				   aa_seguridad  // arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el update � False si hubo error en el update
		//	  Description: Funcion que actualiza en la tabla sno_hproyecto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 20/07/2007 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql= "UPDATE sno_hproyecto ".
				 "   SET nomproy='".$as_nomproy."', ".
				 "       estproproy='".$as_codpro."', ".
				 "       estcla='".$as_estcla."' ".
				 " WHERE codemp='".$this->ls_codemp."' ".
				 "   AND codproy='".$as_codproy."' ".
				 "   AND codnom='".$_SESSION["la_nomina"]["codnom"]."'".
				 "	 AND anocur='".$_SESSION["la_nomina"]["anocurnom"]."'".
				 "	 AND codperi='".$_SESSION["la_nomina"]["peractnom"]."'";
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$lb_valido=false;
        	$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_proyecto_historico ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$this->io_sql->rollback();
		}
		else
		{
			$ls_sql= "UPDATE sno_thproyecto ".
					 "   SET nomproy='".$as_nomproy."', ".
					 "       estproproy='".$as_codpro."', ".
					 "       estcla='".$as_estcla."' ".
					 " WHERE codemp='".$this->ls_codemp."' ".
					 "   AND codproy='".$as_codproy."' ".
					 "   AND codnom='".$_SESSION["la_nomina"]["codnom"]."'".
					 "	 AND anocur='".$_SESSION["la_nomina"]["anocurnom"]."'".
					 "	 AND codperi='".$_SESSION["la_nomina"]["peractnom"]."'";
			$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$lb_valido=false;
				$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_proyecto_historico ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				$this->io_sql->rollback();
			}
			else
			{
				////////////////////////////////         SEGURIDAD               //////////////////////////////
				$ls_evento="UPDATE";
				$ls_descripcion ="Actualiz� el proyecto hist�rico ".$as_codproy;
				$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////	
				if($lb_valido)
				{	
					$this->io_mensajes->message("El Proyecto fue Actualizado.");
					$this->io_sql->commit();
				}
				else
				{
					$lb_valido=false;
					$this->io_mensajes->message("CLASE->Proyecto M�TODO->uf_update_proyecto_historico ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
					$this->io_sql->rollback();
				}
			}
		}
		return $lb_valido;
	}// end function uf_update_proyecto_historico
	//--------------------------------------------------------------------------------------------------------------------------------------
	function uf_validarcierre_gastos_ingreso(&$as_statusg,&$as_statusi)
	{
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_validarcierre_gastos_ingreso
		//		   Access: private
		//     Argumentos: 
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funcion que buscas los estatus de cierre del presuepuesto de gastos i de ingreso
		//	   Creado Por: Ing. Jennifer Rivero
		// Fecha Creaci�n: 28/08/2008 								Fecha �ltima Modificaci�n : 
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="SELECT estciespg, estciespi FROM sigesp_empresa where codemp='".$this->ls_codemp."'";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{ 
			$this->io_mensajes->message("CLASE->Cierre Periodo M�TODO->SELECT->uf_validarcierre_gastos_ingreso ERROR->"
			                            .$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			while(($row=$this->io_sql->fetch_row($rs_data))&&($lb_valido))
			{
				$as_statusg= $row["estciespg"];
				$as_statusi= $row["estciespi"];				
			}
		}
		return 	$lb_valido;
	}//fin de uf_validarcierre_gastos_ingreso
//--------------------------------------------------------------------------------------------------------------------------------------
}
?>