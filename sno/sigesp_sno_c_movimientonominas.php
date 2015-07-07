<?php
class sigesp_sno_c_movimientonominas
{
	var $io_sql;
	var $io_mensajes;
	var $io_funciones;
	var $io_seguridad;
	var $io_personalnomina;
	var $ls_codemp;
	var $ls_codnom;
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function sigesp_sno_c_movimientonominas()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: sigesp_sno_c_movimientonominas
		//		   Access: public 
		//	  Description: Constructor de la Clase
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/03/2006 								Fecha �ltima Modificaci�n : 
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
        $this->ls_codnom=$_SESSION["la_nomina"]["codnom"];
		
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_destructor()
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_destructor
		//		   Access: public (sigesp_sno_p_movimientonominas)
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
        unset($this->ls_codnom);
        
	}// end function uf_destructor
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_existeregistro($as_sql)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_existeregistro
		//		   Access: private
		//      Arguments: as_sql  // sentencia SQL
		//	      Returns: lb_existe True si existe � False si no existe
		//	  Description: Funcion que busca si existe un registro
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/03/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_existe=true;
		$rs_data=$this->io_sql->select($as_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Movimiento N�minas M�TODO->uf_existeregistro ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_existe=false;
		}
		else
		{
			if(!($row=$this->io_sql->fetch_row($rs_data)))
			{
				$lb_existe=false;
			}
			$this->io_sql->free_result($rs_data);	
		}
		return $lb_existe;
	}// end function uf_existeregistro
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_nomina($as_codper,&$aa_nominanormal,&$aa_nominaespecial)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_nomina
		//		   Access: public (sigesp_sno_p_movimientonominas.php)
		//	    Arguments: as_codper  // C�digo de Personal
		//				   aa_nominanormal  // N�minas Normales
		//				   aa_nominaespecial  // N�minas Especiales
		//	      Returns: lb_valido True si se ejecuto el select � False si hubo error en el select
		//	  Description: Funci�n que obtiene las n�minas normales y especiales donde no se encuentra el personal seleccionado
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/03/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="SELECT codnom, desnom ".
				"  FROM sno_nomina ".
				" WHERE codemp='".$this->ls_codemp."' ".
				"   AND codnom<>'".$this->ls_codnom."' ".
				"   AND espnom='0'".
				"   AND codnom NOT IN (SELECT codnom ".
				"						 FROM sno_personalnomina ".
				"						WHERE codper='".$as_codper."' ".
				"						GROUP BY codnom) ";
	
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Movimiento N�minas M�TODO->uf_select_nomina ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
			$lb_valido=false;
		}
		else
		{
			$li_i=0;
			while($row=$this->io_sql->fetch_row($rs_data))
			{
				$aa_nominanormal["codnom"][$li_i]=$row["codnom"];
				$aa_nominanormal["desnom"][$li_i]=$row["desnom"];
				$li_i=$li_i+1;
			}
			$this->io_sql->free_result($rs_data);		
		}
		if($lb_valido)
		{
			$ls_sql="SELECT codnom, desnom ".
					"  FROM sno_nomina ".
					" WHERE codemp='".$this->ls_codemp."' ".
					"   AND codnom<>'".$this->ls_codnom."' ".
					"   AND espnom='1'".
					"   AND codnom NOT IN (SELECT codnom ".
					"						 FROM sno_personalnomina ".
					"						WHERE codper='".$as_codper."' ".
					"						GROUP BY codnom) ";
		
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_mensajes->message("CLASE->Movimiento N�minas M�TODO->uf_select_nomina ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message)); 
				$lb_valido=false;
			}
			else
			{
				$li_i=0;
				while($row=$this->io_sql->fetch_row($rs_data))
				{
					$aa_nominaespecial["codnom"][$li_i]=$row["codnom"];
					$aa_nominaespecial["desnom"][$li_i]=$row["desnom"];
					$li_i=$li_i+1;
				}
				$this->io_sql->free_result($rs_data);		
			}
		}
		return $lb_valido;
	}// end function uf_select_nomina
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_mover_a_nomina($as_codper,$as_egenom,$ad_fecegrper,$as_cauegrper,$ai_totnomnor,$aa_nominanormal,$ai_totnomesp,
							   $aa_nominaespecial,$as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,
							   $ai_sueper,$as_codded,$as_codtipper,$as_coduniadm, $aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_mover_a_nomina
		//		   Access: public (sigesp_sno_p_movimientonominas.php)
		//	    Arguments: as_codper  // C�digo de Personal
		//				   as_egenom  // Egresar de la n�mina actual
		//				   ad_fecegrper  // Fecha de Egreso del Personal
		//				   as_cauegrper  // Causa de Egreso del Personal
		//				   ai_totnomnor  // total de N�minas Normales Seleccionadas
		//				   aa_nominanormal  // Arreglo de N�minas Normales seleccionadas
		//				   ai_totnomesp  // total de N�minas Especiales Seleccionadas
		//				   aa_nominaespecial  // Arreglo de N�minas Especiales Seleccionadas
		//				   as_codsubnom  // C�digo de Subn�mina
		//				   as_codcar  // C�digo de Cargo
		//				   as_codasicar  // C�digo de Asignaci�n de Cargo
		//				   as_codtab  // C�digo de Tabla
		//				   as_codpas  // C�digo de  Paso
		//				   as_codgra  // C�digo de Grado
		//				   aa_seguridad  // Arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el procedimiento correctamente � False si hubo error en el proceso
		//	  Description: Funci�n que egresa al personal de la n�mina actual y mueve los datos del personal de una n�mina a otra
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/03/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ad_fecegrper=$this->io_funciones->uf_convertirdatetobd($ad_fecegrper);		
		$this->io_sql->begin_transaction();
		if($as_egenom=="1")
		{
			$lb_valido=$this->io_personalnomina->uf_update_estatus($as_codper,"3",$ad_fecegrper,$as_cauegrper,"3",$aa_seguridad);
		}
		// Verifico y Registro la informaci�n en las n�minas normales
		for($li_i=0;(($li_i<$ai_totnomnor)&&($lb_valido));$li_i++) 
		{
			$ls_codnom=$aa_nominanormal[$li_i];
			if($lb_valido)
			{
				$lb_valido=$this->uf_verificarintegridad($as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$ls_codnom);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_personalnomina($as_codper,$as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$ls_codnom,$ai_sueper,$as_codded,$as_codtipper,$as_coduniadm,$aa_seguridad);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_conceptospersonal($as_codper,$ls_codnom,$aa_seguridad);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_constantespersonal($as_codper,$ls_codnom,$aa_seguridad);
			}
		}		
		// Verifico y Registro la informaci�n en las n�minas especiales
		for($li_i=0;(($li_i<$ai_totnomesp)&&($lb_valido));$li_i++) 
		{
			$ls_codnom=$aa_nominaespecial[$li_i];
			if($lb_valido)
			{
				$lb_valido=$this->uf_verificarintegridad($as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$ls_codnom);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_personalnomina($as_codper,$as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$ls_codnom,$ai_sueper,$as_codded,$as_codtipper,$as_coduniadm,$aa_seguridad);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_conceptospersonal($as_codper,$ls_codnom,$aa_seguridad);
			}
			if($lb_valido)
			{
				$lb_valido=$this->uf_insert_constantespersonal($as_codper,$ls_codnom,$aa_seguridad);
			}
		}		
		if($lb_valido)
		{	
			$this->io_mensajes->message("El movimiento entre n�minas fue realizado.");
			$this->io_sql->commit();
		}
		else
		{
			$this->io_mensajes->message("Ocurrio un Error al hacer el movimiento entre n�minas"); 
			$this->io_sql->rollback();
		}
		
		return $lb_valido;
	}// end function uf_mover_a_nomina
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_verificarintegridad($as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$as_codnom)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_verificarintegridad
		//		   Access: private
		//	    Arguments: as_codnom  // C�digo de N�mina
		//				   as_codsubnom  // C�digo de Subn�mina
		//				   as_codcar  // C�digo de Cargo
		//				   as_codasicar  // C�digo de Asignaci�n de Cargo
		//				   as_codtab  // C�digo de Tabla
		//				   as_codpas  // C�digo de  Paso
		//				   as_codgra  // C�digo de Grado
		//	      Returns: lb_valido True si se ejecuto el procedimiento correctamente � False si hubo error en el proceso
		//	  Description: Funci�n que verifica que las Tablas, Grados, Cargos, Asignaci�n de Cargo, Subn�minas Existan en a n�mina
		//				   donde se quiere exportar
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 02/03/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		// Verifico si existe la Tabla en la n�mina Seleccionada
		$ls_sql="SELECT codtab ".
				"  FROM sno_tabulador ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'".
				"   AND codtab='".$as_codtab."'";
		if(!$this->uf_existeregistro($ls_sql))
		{
			$lb_valido=false;
			$this->io_mensajes->message("No Existe el Tabulador ".$ls_codtab." en la N�mina ".$as_codnom.".");
		}				
		// Verifico si existe El Grado y Paso en la n�mina Seleccionada
		$ls_sql="SELECT codgra ".
				"  FROM sno_grado ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'".
				"   AND codtab='".$as_codtab."'".
				"   AND codgra='".$as_codgra."'".
				"   AND codpas='".$as_codpas."'";
		if(!$this->uf_existeregistro($ls_sql))
		{
			$lb_valido=false;
			$this->io_mensajes->message("No Existe El Grado ".$ls_codgra." y Paso ".$ls_codpas." de la Tabla ".$ls_codtab." en la N�mina ".$as_codnom.".");
		}				
		// Verifico si existe el cargo en la n�mina Seleccionada
		$ls_sql="SELECT codcar ".
				"  FROM sno_cargo ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'".
				"   AND codcar='".$as_codcar."'";
		if(!$this->uf_existeregistro($ls_sql))
		{
			$lb_valido=false;
			$this->io_mensajes->message("No Existe El Cargo ".$as_codcar." en la N�mina ".$as_codnom.".");
		}				
		// Verifico si existe la Asignaci�n de cargo en la n�mina Seleccionada
		$ls_sql="SELECT codasicar ".
				"  FROM sno_asignacioncargo ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'".
				"   AND codasicar='".$as_codasicar."'";
		if(!$this->uf_existeregistro($ls_sql))
		{
			$lb_valido=false;
			$this->io_mensajes->message("No Existe La Asignaci�n Cargo ".$ls_codasicar." en la N�mina ".$as_codnom.".");
		}				
		// Verifico si existe La Subn�mina en la n�mina Seleccionada
		$ls_sql="SELECT codsubnom ".
				"  FROM sno_subnomina ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'".
				"   AND codsubnom='".$as_codsubnom."'";
		if(!$this->uf_existeregistro($ls_sql))
		{
			$lb_valido=false;
			$this->io_mensajes->message("No Existe La Subnomina ".$ls_codsubnom." en la N�mina ".$as_codnom.".");
		}				
		return $lb_valido;
	}// end function uf_verificarintegridad
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_personalnomina($as_codper,$as_codsubnom,$as_codcar,$as_codasicar,$as_codtab,$as_codpas,$as_codgra,$as_codnom,$ai_sueper,$as_codded,$as_codtipper,$as_coduniadm,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_personalnomina
		//		   Access: private
		//	    Arguments: as_codper  // C�digo de Personal
		//				   as_codsubnom  // C�digo de Subn�mina
		//				   as_codcar  // C�digo de Cargo
		//				   as_codasicar  // C�digo de Asignaci�n de Cargo
		//				   as_codtab  // C�digo de Tabla
		//				   as_codpas  // C�digo de  Paso
		//				   as_codgra  // C�digo de Grado
		//				   as_codnom  // C�digo de N�mina
		//				   aa_seguridad  // Arreglo de las variables de seguridad
		//	      Returns: lb_valido True si se ejecuto el Insert correctamente � False si hubo error en el insert
		//	  Description: Funci�n que inserta de una n�mina a otra el personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 02/03/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		if ($as_coduniadm=="")
		{
		
			$ls_sql= " INSERT INTO sno_personalnomina (codemp, codnom, codper,codsubnom, codtab, codasicar,  codgra, codpas, sueper, ".
					 "			   horper, minorguniadm, ofiuniadm, uniuniadm, depuniadm, prouniadm, pagbanper, codban, codcueban, ".
					 "             tipcuebanper, codcar, fecingper, staper, cueaboper, fecculcontr, codded, codtipper, quivacper, ".
					 "             codtabvac, sueintper, pagefeper, sueproper, codage, fecegrper, fecsusper,cauegrper, codescdoc, ".
					 "             codcladoc, codubifis, tipcestic, conjub, catjub, codclavia, codunirac, fecascper, pagtaqper, ".
					 "             grado, descasicar, coddep,salnorper,estencper,obsrecper) ".
					 "      SELECT codemp, '".$as_codnom."' as codnom, codper, '".$as_codsubnom."' AS codsubnom, '".$as_codtab."' AS codtab, ".
					 "			   '".$as_codasicar."' AS codasicar, '".$as_codgra."' AS codgra, '".$as_codpas."' AS codpas, sueper, ".
					 "             horper, minorguniadm,  ofiuniadm, uniuniadm, depuniadm, prouniadm, pagbanper, codban, codcueban, ".
					 "             tipcuebanper, '".$as_codcar."' AS codcar, '".date("Y/m/d")."' as fecingper, '1' as staper, cueaboper, fecculcontr, codded, ".
					 "             codtipper, quivacper, codtabvac, sueintper, pagefeper, sueproper, codage, '1900-01-01' as fecegrper, ".
					 "             '1900-01-01' as fecsusper, '' as cauegrper, codescdoc, codcladoc, codubifis, tipcestic, conjub, catjub, ".
					 "			   codclavia, codunirac, fecascper, pagtaqper, grado, descasicar, coddep, salnorper,estencper,obsrecper ".
					 " 		  FROM sno_personalnomina ".
					 "       WHERE codemp='".$this->ls_codemp."' ".
					 "		   AND codnom='".$this->ls_codnom."' ".
					 "		   AND codper='".$as_codper."' ";
		}
		else
		{
			$ls_minorguniadm = substr($as_coduniadm,0,4);
			$ls_ofiuniadm = substr($as_coduniadm,5,2);
			$ls_uniuniadm = substr($as_coduniadm,8,2);
			$ls_depuniadm = substr($as_coduniadm,11,2);
			$ls_prouniadm = substr($as_coduniadm,14,2);			
			$ai_sueper=str_replace(".","",$ai_sueper);
			$ai_sueper=str_replace(",",".",$ai_sueper);
			
			$ls_sql= " INSERT INTO sno_personalnomina (codemp, codnom, codper,codsubnom, codtab, codasicar,  codgra, codpas, sueper, ".
                 "			   horper, minorguniadm, ofiuniadm, uniuniadm, depuniadm, prouniadm, pagbanper, codban, codcueban, ".
				 "             tipcuebanper, codcar, fecingper, staper, cueaboper, fecculcontr, codded, codtipper, quivacper, ".
				 "             codtabvac, sueintper, pagefeper, sueproper, codage, fecegrper, fecsusper,cauegrper, codescdoc, ".
				 "             codcladoc, codubifis, tipcestic, conjub, catjub, codclavia, codunirac, fecascper, pagtaqper, ".
				 "             grado, descasicar, coddep, salnorper,estencper,obsrecper) ".
                 "      SELECT codemp, '".$as_codnom."' AS codnom, codper, '".$as_codsubnom."' AS codsubnom, ".
				 "              '".$as_codtab."' AS codtab, '".$as_codasicar."' AS codasicar, '".$as_codgra."' AS codgra, ".
				 "              '".$as_codpas."' AS codpas, ".$ai_sueper." AS sueper, ".
				 "              horper, '".$ls_minorguniadm."' AS minorguniadm,  '".$ls_ofiuniadm."' AS ofiuniadm, '".$ls_uniuniadm."' AS uniuniadm, '".$ls_depuniadm."' AS depuniadm, '".$ls_prouniadm."' AS prouniadm, pagbanper, codban, codcueban, ".
				 "             tipcuebanper, '".$as_codcar."' AS codcar, '".date("Y/m/d")."' as fecingper, '1' as staper, cueaboper, fecculcontr,'".$as_codded."' AS codded, ".
				 "       '".$as_codtipper."' AS codtipper, quivacper, codtabvac, sueintper, pagefeper, sueproper, codage, '1900-01-01' as fecegrper, ".
				 "             '1900-01-01' as fecsusper, '' as cauegrper, codescdoc, codcladoc, codubifis, tipcestic, conjub, catjub, ".
				 "			   codclavia, codunirac, fecascper, pagtaqper, grado, descasicar, coddep, salnorper,estencper,obsrecper ".
                 " 		  FROM sno_personalnomina ".
                 "       WHERE codemp='".$this->ls_codemp."' ".
				 "		   AND codnom='".$this->ls_codnom."' ".
				 "		   AND codper='".$as_codper."' ";
		
		
		}
					 
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
 			$lb_valido=false;
			$this->io_mensajes->message("CLASE->Movimiento N�minas M�TODO->uf_insert_personalnomina ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
			$ls_evento="INSERT";
			$ls_descripcion ="Insert� el personal n�mina ".$as_codper." asociado a la n�mina ".$this->ls_codnom;
			$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
		}
		return $lb_valido;
	}// end function uf_insert_personalnomina
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_constantespersonal($as_codper,$as_codnom,$aa_seguridad)
	{
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_constantespersonal
		//		   Access: private
		//	    Arguments: as_codper  // c�digo de personal
		//	    		   as_codnom  // c�digo de n�mina
		//	    		   aa_seguridad  // arreglo de seguridad
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funci�n que graba las constantes a personal n�mina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 02/03/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="SELECT codcons,valcon,topcon ".
				"  FROM sno_constante ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'";
				
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Movimientos N�mina M�TODO->uf_insert_constantespersonal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			while(($row=$this->io_sql->fetch_row($rs_data))&&($lb_valido))
			{
				$ls_codcons=$row["codcons"];
				$li_valcon=$row["valcon"];
				$li_topcon=$row["topcon"];
				$ls_sql="INSERT INTO sno_constantepersonal(codemp,codnom,codper,codcons,moncon,montopcon)".
						"VALUES('".$this->ls_codemp."','".$as_codnom."','".$as_codper."','".$ls_codcons."','".$li_valcon."','".$li_topcon."')";

				$li_row=$this->io_sql->execute($ls_sql);
				if($li_row===false)
				{
					$lb_valido=false;
					$this->io_mensajes->message("CLASE->Movimientos N�mina M�TODO->uf_insert_constantespersonal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				}
				else
				{
					/////////////////////////////////         SEGURIDAD               /////////////////////////////		
					$ls_evento="INSERT";
					$ls_descripcion ="Insert� la constantepersonal constante ".$ls_codcons." personal n�mina ".$as_codper." asociado a la n�mina ".$as_codnom;
					$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
													$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
													$aa_seguridad["ventanas"],$ls_descripcion);
					/////////////////////////////////         SEGURIDAD               /////////////////////////////		
				}
			}
			$this->io_sql->free_result($rs_data);		
		}
		return $lb_valido;
	}// end function uf_insert_constantespersonal
	//-----------------------------------------------------------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_conceptospersonal($as_codper,$as_codnom,$aa_seguridad)
	{
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_conceptospersonal
		//		   Access: private
		//	    Arguments: as_codper  // c�digo de personal
		//	    		   as_codnom  // c�digo de n�mina
		//	    		   aa_seguridad  // arreglo de seguridad
		//	      Returns: lb_valido True si se ejecuto el insert � False si hubo error en el insert
		//	  Description: Funci�n que graba los conceptos a personal n�mina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 02/03/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql="SELECT codconc ".
				"  FROM sno_concepto ".
				" WHERE codemp='".$this->ls_codemp."'".
				"   AND codnom='".$as_codnom."'";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->Movimientos N�mina M�TODO->uf_insert_conceptospersonal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			while(($row=$this->io_sql->fetch_row($rs_data))&&($lb_valido))
			{
				$ls_codconc=$row["codconc"];
				$ls_sql="INSERT INTO sno_conceptopersonal(codemp,codnom,codper,codconc,aplcon,valcon,acuemp,acuiniemp,acupat,acuinipat)".
						"VALUES('".$this->ls_codemp."','".$as_codnom."','".$as_codper."','".$ls_codconc."',0,0,0,0,0,0)";
				$li_row=$this->io_sql->execute($ls_sql);
				if($li_row===false)
				{
					$lb_valido=false;
					$this->io_mensajes->message("CLASE->Movimientos N�mina M�TODO->uf_insert_conceptospersonal ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				}
				else
				{
					/////////////////////////////////         SEGURIDAD               /////////////////////////////		
					$ls_evento="INSERT";
					$ls_descripcion ="Insert� el conceptopersonal concepto ".$ls_codconc." personal n�mina ".$as_codper." asociado a la n�mina ".$as_codnom;
					$lb_valido= $this->io_seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
													$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
													$aa_seguridad["ventanas"],$ls_descripcion);
					/////////////////////////////////         SEGURIDAD               /////////////////////////////		
				}
			}
			$this->io_sql->free_result($rs_data);		
		}
		return $lb_valido;
	}// end function uf_insert_conceptospersonal
	//-----------------------------------------------------------------------------------------------------------------------------------	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>