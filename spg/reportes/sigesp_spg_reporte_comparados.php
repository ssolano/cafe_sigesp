<?php
require_once("../../shared/class_folder/class_datastore.php");
require_once("../../shared/class_folder/class_sql.php");
require_once("../../shared/class_folder/class_fecha.php");
require_once("../../shared/class_folder/sigesp_include.php");
require_once("../../shared/class_folder/class_funciones.php");
require_once("../../shared/class_folder/class_mensajes.php");
require_once("../../shared/class_folder/class_sigesp_int.php");
require_once("../../shared/class_folder/class_sigesp_int_scg.php");
require_once("../../shared/class_folder/class_sigesp_int_spg.php");		
require_once("../../shared/class_folder/class_sigesp_int_spi.php");
require_once("sigesp_spg_funciones_reportes.php");	
/********************************************************************************************************************************/	
class sigesp_spg_reporte_comparados
{
    //conexion	
	var $sqlca;   
	//Instancia de la clase funciones.
    var $is_msg_error;
	var $dts_empresa; // datastore empresa
	var $dts_reporte;
	var $dts_cab;
	var $obj="";
	var $SQL;
	var $siginc;
	var $con;
	var $fun;	
	var $io_msg;
	var $io_fecha;
	var $sigesp_int_spg;
	var $dts_prog;
	var $io_spg_report_funciones;
/********************************************************************************************************************************/	
    function  sigesp_spg_reporte_comparados()
    {
		$this->fun=new class_funciones() ;
		$this->siginc=new sigesp_include();
		$this->con=$this->siginc->uf_conectar();
		$this->SQL=new class_sql($this->con);		
		$this->obj=new class_datastore();
		$this->dts_empresa=$_SESSION["la_empresa"];
		$this->dts_cab=new class_datastore();
		$this->dts_reporte=new class_datastore();
		$this->dts_prog=new class_datastore();
		$this->io_fecha = new class_fecha();
		$this->io_msg=new class_mensajes();
		$this->sigesp_int_spg=new class_sigesp_int_spg();
		$this->io_spg_report_funciones=new sigesp_spg_funciones_reportes();
    }
/********************************************************************************************************************************/	
	////////////////////////////////////////////////////////////////////////////
	//   CLASE REPORTES SPG  COMPARADOS " EJECUCION FINANCIERA  FORMATO #3 " //
	///////////////////////////////////////////////////////////////////////////
    function uf_spg_reportes_comparados_ejecucion_financiera_formato3($as_codestpro1_ori,$as_codestpro2_ori,$as_codestpro3_ori,
	                                                                  $as_codestpro4_ori,$as_codestpro5_ori,$as_codestpro1_des,
																	  $as_codestpro2_des,$as_codestpro3_des,$as_codestpro4_des,
																	  $as_codestpro5_des,$as_ctasinmov,$as_ominoprog,
																	  $as_trimestres,$ai_nivel)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reportes_comparados_ejecucion_financiera_formato3
	 //         Access :	private
	 //     Argumentos :    as_codestpro1_ori ... $as_codestpro5_ori //rango nivel estructura presupuestaria origen
	 //                     as_codestpro1_des ... $as_codestpro5_des //rango nivel estructura presupuestaria destino
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida  del Ejecucion Financiera Formato 3
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    30/05/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido = false;	 
		$ls_gestor = $_SESSION["ls_gestor"];
		$ls_codemp = $this->dts_empresa["codemp"];
		$this->dts_cab->resetds("spg_cuenta");
		$ls_seguridad="";
	 	$this->io_spg_report_funciones->uf_filtro_seguridad_programatica('c',$ls_seguridad);
		$ls_estructura_desde=$as_codestpro1_ori.$as_codestpro2_ori.$as_codestpro3_ori.$as_codestpro4_ori.$as_codestpro5_ori;
		$ls_estructura_hasta=$as_codestpro1_des.$as_codestpro2_des.$as_codestpro3_des.$as_codestpro4_des.$as_codestpro5_des;	 
		$li_mesdes=substr($as_trimestres,0,2);
		$li_meshas=substr($as_trimestres,2,2); 
		$ls_tipo="O";//comprometer 
		if($as_ominoprog==1)
		{
		  if (strtoupper($ls_gestor)=="MYSQL")
		  {
			   $ls_cadena="CONCAT(c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5)";
		  }
		  else
		  {
			   $ls_cadena="c.codestpro1||c.codestpro2||c.codestpro3||c.codestpro4||c.codestpro5";
		  }
		  $ls_sql=" SELECT c.spg_cuenta, c.nivel, max(c.denominacion) as denominacion, sum(c.asignado) as asignado, ".
		          "        sum(c.comprometido) as comprometido, sum(c.causado) as causado, sum(c.pagado) as pagado, ".
		          "        sum(c.aumento) as aumento, sum(c.disminucion) as disminucion, sum(c.enero) as enero, ".
		          "        sum(c.febrero) as febrero, sum(c.marzo) as marzo, sum(c.abril) as abril, sum(c.mayo) as mayo, ".
		          "        sum(c.junio) as junio, sum(c.julio) as julio, sum(c.agosto) as agosto, sum(c.septiembre) as septiembre, ".
		          "        sum(c.octubre) as octubre, sum(c.noviembre) as noviembre, sum(c.diciembre) as diciembre, ".
				  "        c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5 ".
                  " FROM   spg_cuentas c, spg_plantillareporte r ".
                  " WHERE  c.codemp=r.codemp AND r.codemp='".$ls_codemp."' AND r.codrep='00003' AND (c.codestpro1=r.codestpro1 AND c.codestpro2=r.codestpro2 AND ".
                  "        c.codestpro3=r.codestpro3 AND c.codestpro4=r.codestpro4 AND c.codestpro5=r.codestpro5) AND ".
                  "        (c.spg_cuenta = r.spg_cuenta) AND (r.status <> 'I') AND ".
		          "        ".$ls_cadena."    between '".$ls_estructura_desde."' AND '".$ls_estructura_hasta."' ".$ls_seguridad." ".
                  " GROUP BY c.spg_cuenta ".
                  " ORDER BY c.spg_cuenta ";
		}
		else
		{
		  if (strtoupper($ls_gestor)=="MYSQL")
		  {
			   $ls_cadena="CONCAT(codestpro1,codestpro2,codestpro3,codestpro4,codestpro5)";
		  }
		  else
		  {
			   $ls_cadena="codestpro1||codestpro2||codestpro3||codestpro4||codestpro5";
		  }
		  $ls_sql=" SELECT spg_cuenta, nivel, max(denominacion) as denominacion, sum(asignado) as asignado, ".
		          "        sum(comprometido) as comprometido, sum(causado) as causado, sum(pagado) as pagado, ".
		          "        sum(aumento) as aumento, sum(disminucion) as disminucion, sum(enero) as enero, ".
		          "        sum(febrero) as febrero, sum(marzo) as marzo, sum(abril) as abril, sum(mayo) as mayo, ".
		          "        sum(junio) as junio, sum(julio) as julio, sum(agosto) as agosto, sum(septiembre) as septiembre, ".
		          "        sum(octubre) as octubre, sum(noviembre) as noviembre, sum(diciembre) as diciembre, ".
				  "        codestpro1,codestpro2,codestpro3,codestpro4,codestpro5  ".
                  " FROM   spg_cuentas  ".
                  " WHERE  codemp='".$ls_codemp."' AND ".$ls_cadena." between '".$ls_estructura_desde."' AND '".$ls_estructura_hasta."' ".$ls_seguridad." ".
                  " GROUP BY spg_cuenta ".
                  " ORDER BY spg_cuenta ";
		}
		$rs_data=$this->SQL->select($ls_sql);
		if($rs_data===false)
		{   // error interno sql
			$this->is_msg_error="Error en consulta metodo uf_spg_reportes_comparados_ejecucion_financiera_formato3".$this->fun->uf_convertirmsg($this->SQL->message);
			$lb_valido = false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
			   $lb_ok=false;
			   $ls_spg_cuenta=$row["spg_cuenta"];
			   $ls_denominacion=$row["denominacion"];
			   $li_nivel=$row["nivel"];
			   $ld_asignado=$row["asignado"];
			   $ld_comprometido=$row["comprometido"];
			   $ld_causado=$row["causado"];
			   $ld_pagado=$row["pagado"];
			   $ld_aumento=$row["aumento"];
			   $ld_disminucion=$row["disminucion"];
			   $ld_enero=$row["enero"];
			   $ld_febrero=$row["febrero"];
			   $ld_marzo=$row["marzo"];
			   $ld_abril=$row["abril"];
			   $ld_mayo=$row["mayo"];
			   $ld_junio=$row["junio"];
			   $ld_julio=$row["julio"];
			   $ld_agosto=$row["agosto"];
			   $ld_septiembre=$row["septiembre"];
			   $ld_octubre=$row["octubre"];
			   $ld_noviembre=$row["noviembre"];
			   $ld_diciembre=$row["diciembre"];
			   
			   if($li_nivel<=$ai_nivel)
			   {
			     $lb_ok=true;
			   }
			   if($lb_ok)
			   {	
			      $ld_monto_programado=0;
				  $ld_monto_acumulado=0;
				  $ls_codrep="00003";
				  $ls_forma="0707";
				  $lb_valido=$this->uf_spg_reporte_calcular_programado_r($ls_codrep,$ls_spg_cuenta,$ls_estructura_desde,
				                                                         $ls_estructura_hasta,$li_mesdes,$li_meshas,
																		 $ld_monto_programado,$ld_monto_acumulado,$ls_forma);
				  if($lb_valido)
				  {
				    if($li_mesdes>3)
					{
					  $ld_monto_ejecutado=0;
					  $lb_valido=$this->uf_spg_reporte_calcular_programado_trimestre_anterior(1,$ld_asignado,$ls_spg_cuenta,
						                                                                      $ls_estructura_desde,$ls_estructura_hasta,
	                                                                                          $li_mesdes,$li_meshas,$ld_monto_ejecutado,
																                              $ls_tipo,$ld_enero,$ld_febrero,$ld_marzo,
																							  $ld_abril,$ld_mayo,$ld_junio,$ld_julio,
																							  $ld_agosto,$ld_septiembre,$ld_octubre,
					                										                  $ld_noviembre,$ld_diciembre);				
			         $ld_prog_trim_ant=$ld_monto_ejecutado;
					 if($lb_valido)
					 {
					   $ld_monto_ejecutado=0;
					   $lb_valido=$this->uf_spg_reporte_calcular_programado_trimestre_anterior(2,$ld_asignado,$ls_spg_cuenta,
						                                                                       $ls_estructura_desde,$ls_estructura_hasta,
	                                                                                           1,$li_meshas,$ld_monto_ejecutado,
																                               $ls_tipo,$ld_enero,$ld_febrero,$ld_marzo,
																							   $ld_abril,$ld_mayo,$ld_junio,$ld_julio,
																							   $ld_agosto,$ld_septiembre,$ld_octubre,
					                										                   $ld_noviembre,$ld_diciembre);				
			           $ld_disponible_fecha=$ld_monto_ejecutado;
					 }//if	
					 if($lb_valido)
					 {
					   $ld_monto_ejecutado=0;     $ls_clave=1;
					   $ld_monto_acumulado=0;     $ld_aumdismes=0;
					   $ld_aumdisacum=0;          $ld_comprometer=0;
					   $ld_causado=0;       	  $ld_pagado=0;
					   $li_mesdes=intval($li_mesdes);
					   $li_meshas=intval($li_meshas); 
					   $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_trimestre($ls_clave,$ls_spg_cuenta,
					                                                                 $ls_estructura_desde,$ls_estructura_hasta,
					                                                                 $li_mesdes,$li_meshas,$ld_monto_ejecutado,
																					 $ld_ejecutado_acumulado,$ld_aumdismes,
																					 $ld_aumdisacum,$ld_comprometer,
														                             $ld_causado,$ld_pagado,$ls_tipo);
					   if(!$lb_valido)
					   {
			              $ld_prog_t_ant=$ld_prog_trim_ant;
					   }	
					   else
					   {
					      $ld_prog_t_ant=$ld_prog_trim_ant;  
						  $ld_ejec_t_ant=($ld_asignado+$ld_aumdismes-$ld_comprometer);
						  $ld_compr_t_ant=0;
						  $ld_aumdis_t_ant=$ld_aumdismes;
					   }//else															 
					 }//if
				    }//if($li_mesdes>3) 
					else
					{
	  				  $ld_aumdis_t_ant=0;
					  $ld_prog_t_ant=0;  
					  $ld_compr_t_ant=0;
			          $ld_disponible_fecha=0;
					  $ld_ejec_t_ant=0;
					}//else
				    $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_trim_actual($ls_spg_cuenta,$ls_estructura_desde,                                                                                    $ls_estructura_hasta,$li_mesdes,
					                                                                $li_meshas,$ld_monto_ejecutado,
	                                                                                $ld_ejecutado_acumulado,$ld_aumdismes,				        																			$ld_aumdisacum,$ld_comprometer,
														                            $ld_causado,$ld_pagado,                																	                                                                                    $ls_tipo,$ld_ejec_acum_t_ant);
				   if($lb_valido)
				   {
						 $ld_reprog_prox_mes=0;
						 $ld_dispon_fecha=$ld_asignado+($ld_aumdismes+$ld_aumdis_t_ant)-($ld_comprometer+$ld_ejec_acum_t_ant);
						 $this->dts_reporte->insertRow("spg_cuenta",$ls_spg_cuenta);
						 $this->dts_reporte->insertRow("denominacion",$ls_denominacion);
						 $this->dts_reporte->insertRow("asignado",$ld_asignado);
						 $this->dts_reporte->insertRow("monto_programado",$ld_monto_programado);
						 $this->dts_reporte->insertRow("monto_acumulado",$ld_monto_acumulado);
						 $this->dts_reporte->insertRow("aumdis_mes",$ld_aumdismes);
						 $this->dts_reporte->insertRow("aumdis_acumulado",$ld_aumdisacum);
						 $this->dts_reporte->insertRow("ejecutado_mes",$ld_monto_ejecutado);
						 $this->dts_reporte->insertRow("ejecutado_acum",$ld_ejecutado_acumulado);
						 $this->dts_reporte->insertRow("reprog_prox_mes",$ld_reprog_prox_mes);
						 $this->dts_reporte->insertRow("compromiso",$ld_comprometer);
						 $this->dts_reporte->insertRow("causado",$ld_causado);					 
						 $this->dts_reporte->insertRow("pagado",$ld_pagado);					 
						 $this->dts_reporte->insertRow("ejec_t_ant",$ld_ejec_t_ant);
						 $this->dts_reporte->insertRow("compr_t_ant",$ld_compr_t_ant);
						 $this->dts_reporte->insertRow("disponible_fecha",$ld_dispon_fecha);
						 $this->dts_reporte->insertRow("nivel",$li_nivel);
				         $lb_valido=true;
				   }//if
				  }//if		
			   }//if
			}//while
			$this->SQL->free_result($rs_data);
		}//else
     return $lb_valido;
    }//fin uf_spg_reportes_comparados_ejecucion_financiera_formato3
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_programado_r($as_codrep,$as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,$ai_mesdes,
	                                              $ai_meshas,&$ad_monto_programado,&$ad_monto_acumulado,$as_forma,$as_codfuefindes,
												  $as_codfuefinhas)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_programado_r
	 //         Access :	private
	 //     Argumentos :    $as_codrep  // codigo del reporte
	 //                     $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_programado // monto programado del mes (referencia)  
	 //                     $ad_monto_acumulado // monto programado del acumulado (referencia)  
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida, calcula los programadas  
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    31/05/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;	 
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  $li_mesdes=intval($ai_mesdes);
	  $li_meshas=intval($ai_meshas);
	  if ($as_forma=="0707")
	  {
		  if (strtoupper($ls_gestor)=="MYSQL")
		  {
			   $ls_cadena="CONCAT(C.codestpro1,C.codestpro2,C.codestpro3,C.codestpro4,C.codestpro5,C.estcla)";
		  }
		  else
		  {
			   $ls_cadena="C.codestpro1||C.codestpro2||C.codestpro3||C.codestpro4||C.codestpro5||C.estcla";
		  }
		  $li_estmodest=$_SESSION["la_empresa"]["estmodest"];
		  if($li_estmodest==1)
		  {
			  $ls_tabla="spg_ep3"; 
			  $ls_cadena_fuefin="AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND C.estcla=EP.estcla";
	      }
		  elseif($li_estmodest==2)
		  {
			  $ls_tabla="spg_ep5";
			  $ls_cadena_fuefin=" AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND ".
								"	  C.codestpro4=EP.codestpro4 AND C.codestpro5=EP.codestpro5 AND C.estcla=EP.estcla";
		  }
		  $ls_sql=" SELECT C.spg_cuenta, max(C.denominacion) as denominacion, sum(C.asignado) as asignado, ".
				  "        sum(C.comprometido) as comprometido, sum(C.causado) as causado, sum(C.pagado) as pagado, ".
				  "        sum(C.aumento) as aumento, sum(C.disminucion) as disminucion, sum(C.enero) as enero, ".
				  "        sum(C.febrero) as febrero, sum(C.marzo) as marzo, sum(C.abril) as abril, sum(C.mayo) as mayo, ".
				  "        sum(C.junio) as junio, sum(C.julio) as julio, sum(C.agosto) as agosto, sum(C.septiembre) as septiembre, ".
				  "        sum(C.octubre) as octubre, sum(C.noviembre) as noviembre, sum(C.diciembre) as diciembre ".
				  " FROM   spg_plantillareporte C, ".$ls_tabla." EP  ".
				  " WHERE  C.codemp='".$ls_codemp."' AND ".$ls_cadena." BETWEEN '".$as_estructura_desde."' AND '".$as_estructura_hasta."' AND ".
				  "        C.codrep='".$as_codrep."' AND  C.spg_cuenta='".$as_spg_cuenta."' AND ".
				  "        EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."'  ".$ls_cadena_fuefin." ".
				  " GROUP BY C.spg_cuenta ".
				  " ORDER BY C.spg_cuenta ";
		  
		  /*$ls_sql=" SELECT spg_cuenta, max(denominacion) as denominacion, sum(asignado) as asignado, ".
				  "        sum(comprometido) as comprometido, sum(causado) as causado, sum(pagado) as pagado, ".
				  "        sum(aumento) as aumento, sum(disminucion) as disminucion, sum(enero) as enero, ".
				  "        sum(febrero) as febrero, sum(marzo) as marzo, sum(abril) as abril, sum(mayo) as mayo, ".
				  "        sum(junio) as junio, sum(julio) as julio, sum(agosto) as agosto, sum(septiembre) as septiembre, ".
				  "        sum(octubre) as octubre, sum(noviembre) as noviembre, sum(diciembre) as diciembre ".
				  " FROM   spg_plantillareporte  ".
				  " WHERE  codemp='".$ls_codemp."' AND ".$ls_cadena." between '".$as_estructura_desde."' AND '".$as_estructura_hasta."' AND ".
				  "        spg_cuenta='".$as_spg_cuenta."' AND codrep='".$as_codrep."' ".
				  " GROUP BY spg_cuenta ".
				  " ORDER BY spg_cuenta ";*/
	 }
	 elseif($as_forma=="0704") 
	 {
		  $ls_sql=" SELECT spg_cuenta, max(denominacion) as denominacion, sum(asignado) as asignado, ".
				  "        sum(comprometido) as comprometido, sum(causado) as causado, sum(pagado) as pagado, ".
				  "        sum(aumento) as aumento, sum(disminucion) as disminucion, sum(enero) as enero, ".
				  "        sum(febrero) as febrero, sum(marzo) as marzo, sum(abril) as abril, sum(mayo) as mayo, ".
				  "        sum(junio) as junio, sum(julio) as julio, sum(agosto) as agosto, sum(septiembre) as septiembre, ".
				  "        sum(octubre) as octubre, sum(noviembre) as noviembre, sum(diciembre) as diciembre ".
				  " FROM   spg_plantillareporte  ".
				  " WHERE  codemp='".$ls_codemp."' AND  spg_cuenta='".$as_spg_cuenta."' AND codrep='".$as_codrep."' ".
				  " GROUP BY spg_cuenta ".
				  " ORDER BY spg_cuenta ";
	 } 
	 $rs_prog=$this->SQL->select($ls_sql);
	 if($rs_prog===false)
	 {   // error interno sql
			$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_programado_r".$this->fun->uf_convertirmsg($this->SQL->message);
			$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_prog))
		{
		   if(!(($li_mesdes>=1)&&($li_meshas<=12)))
		   {
		     return false;
		   }
		   for($i=$li_mesdes;$i<=$li_meshas;$i++)
		   {
		     switch ($li_mesdes)
			 {
			     case 1:
			          $ad_monto_programado=$ad_monto_programado+$row["enero"];
				 break;
			     case 2:
			          $ad_monto_programado=$ad_monto_programado+$row["febrero"];
				 break;
			     case 3:
			          $ad_monto_programado=$ad_monto_programado+$row["marzo"];
				 break;
			     case 4:
			          $ad_monto_programado=$ad_monto_programado+$row["abril"];
				 break;
			     case 5:
			          $ad_monto_programado=$ad_monto_programado+$row["mayo"];
				 break;
			     case 6:
			          $ad_monto_programado=$ad_monto_programado+$row["junio"];
				 break;
			     case 7:
			          $ad_monto_programado=$ad_monto_programado+$row["julio"];
				 break;
			     case 8:
			          $ad_monto_programado=$ad_monto_programado+$row["agosto"];
				 break;
			     case 9:
			          $ad_monto_programado=$ad_monto_programado+$row["septiembre"];
				 break;
			     case 10:
			          $ad_monto_programado=$ad_monto_programado+$row["octubre"];
				 break;
			     case 11:
			          $ad_monto_programado=$ad_monto_programado+$row["noviembre"];
				 break;
			     case 12:
			          $ad_monto_programado=$ad_monto_programado+$row["diciembre"];
				 break;
			 }//switch
		   }//for
		   for($i=1;$i<=$li_meshas;$i++)
		   {
		     switch ($i)
			 {
			     case 1:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["enero"];
				 break;
			     case 2:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["febrero"];
				 break;
			     case 3:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["marzo"];
				 break;
			     case 4:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["abril"];
				 break;
			     case 5:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["mayo"];
				 break;
			     case 6:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["junio"];
				 break;
			     case 7:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["julio"];
				 break;
			     case 8:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["agosto"];
				 break;
			     case 9:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["septiembre"];
				 break;
			     case 10:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["octubre"];
				 break;
			     case 11:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["noviembre"];
				 break;
			     case 12:
			          $ad_monto_acumulado=$ad_monto_acumulado+$row["diciembre"];
				 break;
			 }//switch
		   }//for		   
		}//if
	    $this->SQL->free_result($rs_prog);
     }//else
	 return $lb_valido;
   }//fin uf_spg_reporte_calcular_programado_r
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_programado_trimestre_anterior($as_clave,$ad_asignado,$as_spg_cuenta,$as_estructura_desde,
	                                                               $as_estructura_hasta,$ai_mesdes,$ai_meshas,&$ad_monto_ejecutado,
																   $as_tipo,$ad_enero,$ad_febrero,$ad_marzo,$ad_abril,$ad_mayo,
																   $ad_junio,$ad_julio,$ad_agosto,$ad_septiembre,$ad_octubre,
																   $ad_noviembre,$ad_diciembre)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_programado_trimestre_anterior
	 //         Access :	private
	 //     Argumentos :    $as_codrep  // codigo del reporte
	 //                     $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_clave  // clave
	 //                     $as_tipo  //  tipo
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida  
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    01/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ai_mesdes=intval($ai_mesdes);
     $ai_meshas=intval($ai_meshas);
	 $dt_mesdes=($ai_mesdes-3);
     $dt_meshas=($ai_mesdes-1);
	 $ld_monto_programado=0;
	 $ld_monto_acumulado=0;
	 $lb_valido=$this->uf_spg_reporte_calcular_programado($dt_mesdes,$dt_meshas,$ld_monto_programado,$ld_monto_acumulado,$ad_enero,
	                                                      $ad_febrero,$ad_marzo,$ad_abril,$ad_mayo,$ad_junio,$ad_julio,$ad_agosto,
														  $ad_septiembre,$ad_octubre,$ad_noviembre,$ad_diciembre);
	 $ld_monto_ejecutado=0;
	 $ld_monto_acumulado=0;     $ld_aumdismes=0;
	 $ld_aumdisacum=0;          $ld_comprometer=0;
	 $ld_causado=0;       	    $ld_pagado=0;
	 $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_trimestre($as_clave,$as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,
																   $dt_mesdes,$dt_meshas,$ld_monto_ejecutado,$ld_monto_acumulado,
																   $ld_aumdismes,$ld_aumdisacum,$ld_comprometer,$ld_causado,
																   $ld_pagado,$as_tipo);
     if($lb_valido)
	 {
	   if($as_clave==1)
	   {
	      $ad_monto_ejecutado=$ld_monto_programado;
	   }//if
	   else
	   {
	      $ad_monto_ejecutado=($ad_asignado+$ld_aumdismes+$ld_aumdisacum-$ld_comprometer);
	   }//else
	 }//if
    return  $lb_valido;
   }//fin uf_spg_reporte_calcular_programado_trimestre_anterior
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_programado($ai_mesdes,$ai_meshas,&$ad_monto_programado,&$ad_monto_acumulado,$ad_enero,$ad_febrero,
												$ad_marzo,$ad_abril,$ad_mayo,$ad_junio,$ad_julio,$ad_agosto,$ad_septiembre,
												$ad_octubre,$ad_noviembre,$ad_diciembre)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_programado
	 //         Access :	private
	 //     Argumentos :    $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_programado // monto programado del mes (referencia)  
	 //                     $ad_monto_acumulado // monto programado del acumulado (referencia)  
	 //                     $ad_enero .. $ad_diciembre  // monto programado desde  enero  hasta diciembre  
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	metodo que calcula los montos programados y los acumulados
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    01/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     $lb_valido=true;
     $li_mesdes=intval($ai_mesdes);
     $li_meshas=intval($ai_meshas);
     if(!(($li_mesdes>=1)&&($li_meshas<=12)))
     {
	   $lb_valido=false;
     }
     if($lb_valido)
     {
	   for($i=$li_mesdes;$i<=$li_meshas;$i++)
	   {
		 switch ($li_mesdes)
		 {
			 case 1:
				  $ad_monto_programado=$ad_monto_programado+$ad_enero;
			 break;
			 case 2:
				  $ad_monto_programado=$ad_monto_programado+$ad_febrero;
			 break;
			 case 3:
				  $ad_monto_programado=$ad_monto_programado+$ad_marzo;
			 break;
			 case 4:
				  $ad_monto_programado=$ad_monto_programado+$ad_abril;
			 break;
			 case 5:
				  $ad_monto_programado=$ad_monto_programado+$ad_mayo;
			 break;
			 case 6:
				  $ad_monto_programado=$ad_monto_programado+$ad_junio;
			 break;
			 case 7:
				  $ad_monto_programado=$ad_monto_programado+$ad_julio;
			 break;
			 case 8:
				  $ad_monto_programado=$ad_monto_programado+$ad_agosto;
			 break;
			 case 9:
				  $ad_monto_programado=$ad_monto_programado+$ad_septiembre;
			 break;
			 case 10:
				  $ad_monto_programado=$ad_monto_programado+$ad_octubre;
			 break;
			 case 11:
				  $ad_monto_programado=$ad_monto_programado+$ad_noviembre;
			 break;
			 case 12:
				  $ad_monto_programado=$ad_monto_programado+$ad_diciembre;
			 break;
		 }//switch
	   }//for
	   for($i=1;$i<=$li_meshas;$i++)
	   {
		 switch ($i)
		 {
			 case 1:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_enero;
			 break;
			 case 2:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_febrero;
			 break;
			 case 3:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_marzo;
			 break;
			 case 4:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_abril;
			 break;
			 case 5:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_mayo;
			 break;
			 case 6:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_junio;
			 break;
			 case 7:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_julio;
			 break;
			 case 8:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_agosto;
			 break;
			 case 9:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_septiembre;
			 break;
			 case 10:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_octubre;
			 break;
			 case 11:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_noviembre;
			 break;
			 case 12:
				  $ad_monto_acumulado=$ad_monto_acumulado+$ad_diciembre;
			 break;
		 }//switch
	   }//for		
	   }//if
	   return  $lb_valido; 
   }//fin uf_spg_reporte_calcular_programado
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_ejecutado_trimestre($as_cant_mes,$as_clave,$as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,$ai_mesdes,
	                                                     $ai_meshas,&$ad_monto_ejecutado,&$ad_monto_acumulado,&$ad_aumdismes,&$ad_aumdisacum,
														 &$ad_comprometer,&$ad_causado,&$ad_pagado,$as_tipo,$ad_monto_acum_ant)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_ejecutado_trimestre
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_clave  // clave
	 //                     $as_tipo  //  tipo
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	Reporte que genera salida para el Formato 3 de la ejecucucion financiera
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    01/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;
	  $ld_aumento=0;
	  $ld_disminucion=0;
	  $ld_aumento_acum=0;
	  $ld_disminucion_acum=0;
	  $ldt_periodo=$_SESSION["la_empresa"]["periodo"];
	  $li_ano=substr($ldt_periodo,0,4);
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  if (strtoupper($ls_gestor)=="MYSQL")
	  {
		   $ls_cadena="CONCAT(codestpro1,codestpro2,codestpro3,codestpro4,codestpro5)";
	  }
	  else
	  {
		   $ls_cadena="codestpro1||codestpro2||codestpro3||codestpro4||codestpro5";
	  }
	  if($as_clave==1)
	  {
	     if($ai_mesdes>3)
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-$as_cant_mes),2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-1),2);
         }
		 else
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes-$as_cant_mes,2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas-1,2);
		 }
	     if($ai_mesdes==1)
		 {
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda(1,2);
         }
		 
	  }//if
	  else
	  {
	     if($ai_mesdes==1)
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(1,2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
		 }
		 else
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes,2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
		 }	 
	  }
	  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
	  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer,OP.comprometer, OP.causar, OP.pagar ".
              " FROM   spg_dt_cmp DT, spg_operaciones OP ".
              " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
              "        ".$ls_cadena." between  '".$as_estructura_desde."' AND '".$as_estructura_hasta."'  AND ".
              "        spg_cuenta like '".$as_spg_cuenta."' ";
	  $rs_ejec=$this->SQL->select($ls_sql);
	  if($rs_ejec===false)
	  { // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_ejecutado_trimestre".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	  }
	  else
	  {
		while($row=$this->SQL->fetch_row($rs_ejec))
		{
		  $li_aumento=$row["aumento"];
		  $li_disminucion=$row["disminucion"];
		  $li_precomprometer=$row["precomprometer"];
		  $li_comprometer=$row["comprometer"];
		  $li_causar=$row["causar"];
		  $li_pagar=$row["pagar"];
		  $ld_monto=$row["monto"];
		  $ldt_fecha_db=$row["fecha"];
		  $ldt_fecha=substr($ldt_fecha_db,0,7);
		  if($as_tipo=="O")
		  {
		    if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			 $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<$li_meshas))
			{  
			  $ad_monto_acum_ant=$ad_monto_acum_ant+$ld_monto;
			}//if
		  }//if($as_tipo=="O")
		  if($as_tipo=="C")
		  {
		    if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			  $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_causar)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
		  }//if($as_tipo=="C")
		  
		  //  Comprometer, Causar, Pagar, Aumento, Disminuci�n
		  if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_comprometer=$ad_comprometer+$ld_monto;
		  }//if
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_aumento=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_disminucion=$ld_disminucion+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_aumento_acum=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_disminucion_acum=$ld_disminucion+$ld_monto;
		  }//if
		}//while
		$ad_aumdismes=$ld_aumento-$ld_disminucion;
		$ad_aumdisacum=$ld_aumento_acum-$ld_disminucion_acum;
	   $this->SQL->free_result($rs_ejec);
	  }//else	
	  return $lb_valido;	
   }//fin uf_spg_reporte_calcular_ejecutado_trimestre
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_ejecutado_trim_actual($as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,$ai_mesdes,
	                                                       $ai_meshas,&$ad_monto_ejecutado,&$ad_monto_acumulado,&$ad_aumdismes,
														   &$ad_aumdisacum,&$ad_comprometer,&$ad_causado,&$ad_pagado,$as_tipo,
														   &$ad_ejec_acum_t_ant)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_ejecutado_trimestre
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_tipo  //  tipo
	 //                     $$ad_ejec_acum_t_ant  // ejecutado acumulado del trimetre anterior
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	Reporte que genera salida para el Formato 3 de la ejecucucion financiera
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    02/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;
	  $ld_aumento=0;
	  $ld_disminucion=0;
	  $ld_aumento_acum=0;
	  $ld_disminucion_acum=0;
	  $ad_monto_ejecutado=0;
	  $ad_monto_acumulado=0;
	  $ad_ejec_acum_t_ant=0;
	  $ldt_periodo=$_SESSION["la_empresa"]["periodo"];
	  $li_ano=substr($ldt_periodo,0,4);
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  $li_mesdes=$li_ano."-".$ai_mesdes;
	  $li_meshas=$li_ano."-".$ai_meshas;
	  if (strtoupper($ls_gestor)=="MYSQL")
	  {
		   $ls_cadena="CONCAT(codestpro1,codestpro2,codestpro3,codestpro4,codestpro5)";
	  }
	  else
	  {
		   $ls_cadena="codestpro1||codestpro2||codestpro3||codestpro4||codestpro5";
	  }
	  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
	  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer,OP.comprometer, OP.causar, OP.pagar ".
			  " FROM   spg_dt_cmp DT, spg_operaciones OP ".
			  " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
			  "        ".$ls_cadena." between  '".$as_estructura_desde."' AND '".$as_estructura_hasta."'  AND ".
			  "        spg_cuenta like '".$as_spg_cuenta."' ";
	  $rs_ejec=$this->SQL->select($ls_sql);
	  if($rs_ejec===false)
	  { // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_ejecutado_trimestre".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	  }
	  else
	  {
		while($row=$this->SQL->fetch_row($rs_ejec))
		{
		  $li_aumento=$row["aumento"];
		  $li_disminucion=$row["disminucion"];
		  $li_precomprometer=$row["precomprometer"];
		  $li_comprometer=$row["comprometer"];
		  $li_causar=$row["causar"];
		  $li_pagar=$row["pagar"];
		  $ld_monto=$row["monto"];
		  $ldt_fecha_db=$row["fecha"];
		  $ldt_fecha=substr($ldt_fecha_db,0,7);
		  if($as_tipo=="O")
		  {
		    if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			 $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<$li_mesdes))
			{  
			  $ad_ejec_acum_t_ant=$ad_ejec_acum_t_ant+$ld_monto;
			}//if
		  }//if($as_tipo=="O")
		  if($as_tipo=="C")
		  {
		    if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			  $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_causar)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
		  }//if($as_tipo=="C")
		   /*print " messs::::".$li_mesdes."<br>";
		   print " messs::::".$li_meshas."<br>";
		   print " messs::::".$li_comprometer."<br>";*/
		  //  Comprometer, Causar, Pagar, Aumento, Disminuci�n
		  if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_comprometer=$ad_comprometer+$ld_monto;
		  }//if
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_aumento=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_disminucion=$ld_disminucion+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_aumento_acum=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_disminucion_acum=$ld_disminucion+$ld_monto;
		  }//if
		}//while
		$ad_aumdismes=$ld_aumento-$ld_disminucion;
		$ad_aumdisacum=$ld_aumento_acum-$ld_disminucion_acum;
	   $this->SQL->free_result($rs_ejec);
	  }//else	
	  return $lb_valido;	
   }//fin uf_spg_reporte_calcular_ejecutado_trim_actual
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_denestpro1($as_codestpro1,&$as_denestpro1)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_denestpro1
	 //         Access :	private
	 //     Argumentos :    $as_procede_ori  // procede origen
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la descripcion de la estructura programatica 1
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    27/04/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT denestpro1 ".
             " FROM   spg_ep1 ".
             " WHERE  codemp='".$ls_codemp."' AND codestpro1='".$as_codestpro1."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_denestpro1 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_denestpro1=$row["denestpro1"];
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_denestpro1
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_denestpro2($as_codestpro1,$as_codestpro2,&$as_denestpro2)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_denestpro2
	 //         Access :	private
	 //     Argumentos :    $as_codestpro2 // codigo
	 //                     $as_denestpro2  // denominacion
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la descripcion de la estructura programatica 1
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    27/04/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT denestpro2 ".
             " FROM   spg_ep2 ".
             " WHERE  codemp='".$ls_codemp."' AND  codestpro1='".$as_codestpro1."' AND codestpro2='".$as_codestpro2."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_denestpro2 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_denestpro2=$row["denestpro2"];
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_denestpro1
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_denestpro3($as_codestpro1,$as_codestpro2,$as_codestpro3,&$as_denestpro3)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_denestpro3
	 //         Access :	private
	 //     Argumentos :    $as_codestpro3 // codigo
	 //                     $as_denestpro3  // denominacion
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la descripcion de la estructura programatica 1
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    27/04/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT denestpro3 ".
             " FROM   spg_ep3 ".
             " WHERE  codemp='".$ls_codemp."' AND  codestpro1='".$as_codestpro1."' AND codestpro2='".$as_codestpro2."' AND ".
			 "        codestpro3='".$as_codestpro3."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_denestpro3 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_denestpro3=$row["denestpro3"];
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_denestpro1
/****************************************************************************************************************************************/
    function uf_spg_reportes_select_ejecucion_financiera_formato3($as_codestpro1_ori,$as_codestpro2_ori,$as_codestpro3_ori,
	                                            				  $as_codestpro4_ori,$as_codestpro5_ori,$as_codestpro1_des,
					                                              $as_codestpro2_des,$as_codestpro3_des,$as_codestpro4_des,
											  					  $as_codestpro5_des,$as_codfuefindes,$as_codfuefinhas,
																  $as_estclades,$as_estclahas)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reportes_select_ejecucion_financiera_formato3
	 //         Access :	private
	 //     Argumentos :    $as_codestpro3 // codigo
	 //                     $as_denestpro3  // denominacion
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la descripcion de la estructura programatica 1
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    07/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_seguridad="";
	 $this->io_spg_report_funciones->uf_filtro_seguridad_programatica('C',$ls_seguridad);
	 $ls_estructura_desde=$as_codestpro1_ori.$as_codestpro2_ori.$as_codestpro3_ori.$as_codestpro4_ori.$as_codestpro5_ori.$as_estclades;
	 $ls_estructura_hasta=$as_codestpro1_des.$as_codestpro2_des.$as_codestpro3_des.$as_codestpro4_des.$as_codestpro5_des.$as_estclahas;
	 $ls_gestor = $_SESSION["ls_gestor"];
	 if (strtoupper($ls_gestor)=="MYSQLT")
	 {
	   $ls_cadena="CONCAT(C.codestpro1,C.codestpro2,C.codestpro3,C.codestpro4,C.codestpro5,C.estcla)";
	 }
	 else
	 {
	   $ls_cadena="C.codestpro1||C.codestpro2||C.codestpro3||C.codestpro4||C.codestpro5||C.estcla";
	 }
	 $li_estmodest=$_SESSION["la_empresa"]["estmodest"];
	 if($li_estmodest==1)
	 {
	   $ls_tabla="spg_ep3"; 
	   $ls_cadena_fuefin="AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND C.estcla=EP.estcla";
	 }
	 elseif($li_estmodest==2)
	 {
	   $ls_tabla="spg_ep5";
	   $ls_cadena_fuefin=" AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND ".
						 "	   C.codestpro4=EP.codestpro4 AND C.codestpro5=EP.codestpro5 AND C.estcla=EP.estcla";
	 }
	 $ls_sql=" SELECT distinct ".$ls_cadena." as programatica ".
             " FROM   spg_cuentas C, ".$ls_tabla." EP ".
			 " WHERE  C.codemp='".$ls_codemp."' AND ".$ls_cadena." ".
             "        between '".$ls_estructura_desde."' AND '".$ls_estructura_hasta."' AND ".
			 "        EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."' ".$ls_cadena_fuefin." ".$ls_seguridad;		 
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_denestpro3".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		  $datos=$this->SQL->obtener_datos($rs_data);
		  $this->dts_cab->data=$datos;
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	}//else
	return $lb_valido;
  }//uf_spg_reporte_select_denestpro1
/****************************************************************************************************************************************/
	////////////////////////////////////////////////////////////////////////////
	//   CLASE REPORTES SPG  COMPARADOS " EJECUCION FINANCIERA  FORMATO #2 " //
	///////////////////////////////////////////////////////////////////////////
    function uf_spg_reportes_comparados_ejecucion_financiera_formato2($as_codestpro1_ori,$as_codestpro2_ori,$as_codestpro3_ori,
	                                                                  $as_codestpro4_ori,$as_codestpro5_ori,$as_codestpro1_des,
																	  $as_codestpro2_des,$as_codestpro3_des,$as_codestpro4_des,
																	  $as_codestpro5_des,$as_ctasinmov,$as_ominoprog,$as_combomes,
																	  $ai_nivel,$as_cant_mes,$as_codfuefindes,$as_codfuefinhas,
																      $as_estclades,$as_estclahas)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reportes_comparados_ejecucion_financiera_formato2
	 //         Access :	private
	 //     Argumentos :    as_codestpro1_ori ... $as_codestpro5_ori //rango nivel estructura presupuestaria origen
	 //                     as_codestpro1_des ... $as_codestpro5_des //rango nivel estructura presupuestaria destino
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida  del Ejecucion Financiera Formato 3
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    12/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido = false;	 
		$ls_gestor = $_SESSION["ls_gestor"];
		$ls_codemp = $this->dts_empresa["codemp"];
		$this->dts_cab->resetds("spg_cuenta");
		$ls_seguridad="";
	 	$this->io_spg_report_funciones->uf_filtro_seguridad_programatica('C',$ls_seguridad);
		$ls_estructura_desde=$as_codestpro1_ori.$as_codestpro2_ori.$as_codestpro3_ori.$as_codestpro4_ori.$as_codestpro5_ori.$as_estclades;
		$ls_estructura_hasta=$as_codestpro1_des.$as_codestpro2_des.$as_codestpro3_des.$as_codestpro4_des.$as_codestpro5_des.$as_estclahas;	 
		$li_mesdes=substr($as_combomes,0,2);
		$li_meshas=substr($as_combomes,2,2);
		$ls_tipo="O";//comprometer
	    $li_estmodest=$_SESSION["la_empresa"]["estmodest"];
	    if($li_estmodest==1)
	    {
		   $ls_tabla="spg_ep3"; 
		   $ls_cadena_fuefin="AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND C.estcla=EP.estcla";
	    }
	    elseif($li_estmodest==2)
	    {
		   $ls_tabla="spg_ep5";
		   $ls_cadena_fuefin=" AND C.codestpro1=EP.codestpro1 AND C.codestpro2=EP.codestpro2 AND C.codestpro3=EP.codestpro3 AND ".
						  "	   C.codestpro4=EP.codestpro4 AND C.codestpro5=EP.codestpro5 AND C.estcla=EP.estcla";
	    }
		if (strtoupper($ls_gestor)=="MYSQL")
		{
			   $ls_cadena="CONCAT(c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5,c.estcla)";
		}
		else
		{
			   $ls_cadena="c.codestpro1||c.codestpro2||c.codestpro3||c.codestpro4||c.codestpro5||c.estcla";
		}
		if($as_ominoprog==1)
		{
		  $ls_sql=" SELECT c.spg_cuenta, c.nivel, max(c.denominacion) as denominacion, sum(c.asignado) as asignado, ".
		          "        sum(c.comprometido) as comprometido, sum(c.causado) as causado, sum(c.pagado) as pagado, ".
		          "        sum(c.aumento) as aumento, sum(c.disminucion) as disminucion, sum(c.enero) as enero, ".
		          "        sum(c.febrero) as febrero, sum(c.marzo) as marzo, sum(c.abril) as abril, sum(c.mayo) as mayo, ".
		          "        sum(c.junio) as junio, sum(c.julio) as julio, sum(c.agosto) as agosto, sum(c.septiembre) as septiembre, ".
		          "        sum(c.octubre) as octubre, sum(c.noviembre) as noviembre, sum(c.diciembre) as diciembre, ".
				  "        c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5,c.estcla ".
                  " FROM   spg_cuentas c, spg_plantillareporte r, ".$ls_tabla." EP ".
                  " WHERE  r.codemp='".$ls_codemp."' AND r.status <> 'I' AND codrep='0707' AND ".
				  "        EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."'  AND ".
				  "        ".$ls_cadena."    between '".$ls_estructura_desde."' AND '".$ls_estructura_hasta."'  AND ".
				  "        c.codemp=r.codemp AND  c.codestpro1=r.codestpro1 AND ".
				  "        c.codestpro2=r.codestpro2 AND c.codestpro3=r.codestpro3 AND ".
				  "        c.codestpro4=r.codestpro4 AND c.codestpro5=r.codestpro5 AND ".
                  "        c.spg_cuenta = r.spg_cuenta  ".$ls_cadena_fuefin."  ".$ls_seguridad.
                  " GROUP BY c.spg_cuenta, c.nivel, c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5,c.estcla ".
                  " ORDER BY c.spg_cuenta ";
		}
		else
		{
		  $ls_sql=" SELECT c.spg_cuenta, c.nivel, max(c.denominacion) as denominacion, sum(c.asignado) as asignado, ".
		          "        sum(c.comprometido) as comprometido, sum(c.causado) as causado, sum(c.pagado) as pagado, ".
		          "        sum(c.aumento) as aumento, sum(c.disminucion) as disminucion, sum(c.enero) as enero, ".
		          "        sum(c.febrero) as febrero, sum(c.marzo) as marzo, sum(c.abril) as abril, sum(c.mayo) as mayo, ".
		          "        sum(c.junio) as junio, sum(c.julio) as julio, sum(c.agosto) as agosto, sum(c.septiembre) as septiembre, ".
		          "        sum(c.octubre) as octubre, sum(c.noviembre) as noviembre, sum(c.diciembre) as diciembre, ".
				  "        c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5,c.estcla  ".
                  " FROM   spg_cuentas c, ".$ls_tabla." EP".
                  " WHERE  c.codemp='".$ls_codemp."'  AND ".$ls_cadena." between '".$ls_estructura_desde."' AND ".
				  "        '".$ls_estructura_hasta."' AND EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."'".
				  "        ".$ls_cadena_fuefin." ".$ls_seguridad.
                  " GROUP BY c.spg_cuenta, c.nivel, c.codestpro1, c.codestpro2, c.codestpro3, c.codestpro4, c.codestpro5, c.estcla ".
                  " ORDER BY c.spg_cuenta ";
		}
		$rs_data=$this->SQL->select($ls_sql);
		if($rs_data===false)
		{   // error interno sql
			$this->is_msg_error="Error en consulta metodo uf_spg_reportes_comparados_ejecucion_financiera_formato2".$this->fun->uf_convertirmsg($this->SQL->message);
			$lb_valido = false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
			   $lb_ok=false;
			   $ls_spg_cuenta=$row["spg_cuenta"];
			   $ls_denominacion=$row["denominacion"];
			   $li_nivel=$row["nivel"];
			   $ld_asignado=$row["asignado"];
			   $ld_comprometido=$row["comprometido"];
			   $ld_causado=$row["causado"];
			   $ld_pagado=$row["pagado"];
			   $ld_aumento=$row["aumento"];
			   $ld_disminucion=$row["disminucion"];
			   $ld_enero=$row["enero"];
			   $ld_febrero=$row["febrero"];
			   $ld_marzo=$row["marzo"];
			   $ld_abril=$row["abril"];
			   $ld_mayo=$row["mayo"];
			   $ld_junio=$row["junio"];
			   $ld_julio=$row["julio"];
			   $ld_agosto=$row["agosto"];
			   $ld_septiembre=$row["septiembre"];
			   $ld_octubre=$row["octubre"];
			   $ld_noviembre=$row["noviembre"];
			   $ld_diciembre=$row["diciembre"];
			   
			   if($li_nivel<=$ai_nivel)
			   {
			     $lb_ok=true;
			   }
			   if($lb_ok)
			   {	
				  $ld_monto_acumulado=0;
				  //$ls_codrep="00003";
				  $ls_forma="0707";
				  $ls_codrep="0707";
                  $ld_monto_programado=0;
 				  $lb_valido=$this->uf_spg_reporte_calcular_programado_r($ls_codrep,$ls_spg_cuenta,$ls_estructura_desde,
				                                                         $ls_estructura_hasta,$li_mesdes,$li_meshas,
																		 $ld_monto_programado,$ld_monto_acumulado,$ls_forma,
																		 $as_codfuefindes,$as_codfuefinhas);
				  if($lb_valido)
				  {
                    $ldt_mesdes=intval($li_mesdes);
					if($ldt_mesdes>3)
					{// calculo la programacion de los meses anteriores
			          $ld_ejec_acum_t_ant=0;
					  $ld_monto_acumulado=0;
                      $ld_monto_ejecutado=0;
					  $ld_comprometer=0;
					  $ld_causado=0;
					  $ld_pagado=0;
                      $lb_valido=$this->uf_spg_reporte_calcular_meses_anteriores($as_cant_mes,1,$ls_spg_cuenta,$li_mesdes,$ls_estructura_desde,
	                                                                             $ls_estructura_hasta,$li_meshas,$ld_monto_ejecutado,
													                             $ld_monto_acumulado,$ld_aumdismes,$ld_aumdisacum,
	                                                                             $ld_comprometer,$ld_causado,$ld_pagado,$ls_tipo,
																				 $ld_ejec_acum_t_ant,$as_codfuefindes,
																				 $as_codfuefinhas);				
																				 
		      	      $ld_monto_ant=$ld_asignado+($ld_aumdismes+$ld_aumdisacum)-($ld_comprometer+$ld_ejec_acum_t_ant);
					  if($lb_valido)
					  {		 
						  $lb_pasar=false;
						  $ld_ejec_acum_t_ant=0;
						  $ld_comprometer=0;
						  $ld_causado=0;
						  $ld_pagado=0;
						  $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_meses($as_cant_mes,1,$ls_spg_cuenta,$li_mesdes,$ls_estructura_desde,
														$ls_estructura_hasta,$li_meshas,$ld_monto_ejecutado,$ld_monto_acumulado,
														$ld_aumdismes,$ld_aumdisacum,$ld_comprometer,$ld_causado,$ld_pagado,$ls_tipo,
														$lb_pasar,$ld_ejec_acum_t_ant,$as_codfuefindes,$as_codfuefinhas);
					 }									
				   }//if($li_mesdes>3) 
				   else
				   {
					  $ld_monto_ant=0;
					  $ld_monto_programado_ant=0;
					 // $ld_monto_programado=0;
					  $ld_monto_ejecutado=0;
				 }//else
				  $lb_pasar=false;
				  $ld_ejec_acum_t_ant=0;
				  $ld_monto_acumulado=0;
				  $ld_monto_ejecutado=0;
				  $ld_comprometer=0;
				  $ld_causado=0;
				  $ld_pagado=0;
				  if($ldt_mesdes>=2)
				  {
					  $lb_valido=$this->uf_spg_reporte_calcular_meses_anteriores($as_cant_mes,1,$ls_spg_cuenta,$li_mesdes,$ls_estructura_desde,$ls_estructura_hasta,
																				 $li_meshas,$ld_monto_ejecutado,
																				 $ld_monto_acumulado,$ld_aumdismes,$ld_aumdisacum,
																				 $ld_comprometer,$ld_causado,$ld_pagado,$ls_tipo,
																				 $ld_ejec_acum_t_ant,$as_codfuefindes,$as_codfuefinhas);				
					  $ld_monto_ant=$ld_asignado+($ld_aumdismes+$ld_aumdisacum)-($ld_comprometer+$ld_ejec_acum_t_ant);
                  }
				  else
				  {
				    $ld_monto_ant=0;
				  }
				  if($lb_valido)
				  {
					  $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_meses($as_cant_mes,1,$ls_spg_cuenta,$li_mesdes,$ls_estructura_desde,
													$ls_estructura_hasta,$li_meshas,$ld_monto_ejecutado,$ld_ejecutado_acumulado,
													$ld_aumdismes,$ld_aumdisacum,$ld_comprometer,$ld_causado,$ld_pagado,$ls_tipo,
													$lb_pasar,$ld_ejec_acum_t_ant,$as_codfuefindes,$as_codfuefinhas);
				 }	
			     if($lb_valido)
			     {
					 $ld_dispon_fecha=$ld_asignado+($ld_aumdismes+$ld_aumdisacum)-($ld_comprometer+$ld_ejec_acum_t_ant);
					 $this->dts_reporte->insertRow("spg_cuenta",$ls_spg_cuenta);
					 $this->dts_reporte->insertRow("denominacion",$ls_denominacion);
					 $this->dts_reporte->insertRow("asignado",$ld_asignado);
					 $this->dts_reporte->insertRow("monto_programado",$ld_monto_programado);
					 $this->dts_reporte->insertRow("monto_acumulado",$ld_monto_acumulado);
					 $this->dts_reporte->insertRow("aumdis_mes",$ld_aumdismes);
					 $this->dts_reporte->insertRow("aumdis_acumulado",$ld_aumdisacum);
					 $this->dts_reporte->insertRow("ejecutado_mes",$ld_monto_ejecutado);
					 $this->dts_reporte->insertRow("ejecutado_acum",$ld_ejecutado_acumulado);
					 $this->dts_reporte->insertRow("compromiso",$ld_comprometer);
					 $this->dts_reporte->insertRow("causado",$ld_causado);					 
					 $this->dts_reporte->insertRow("pagado",$ld_pagado);					 
					 $this->dts_reporte->insertRow("ejec_t_ant",$ld_monto_ant);
					 $this->dts_reporte->insertRow("disponible_fecha",$ld_dispon_fecha);
					 $this->dts_reporte->insertRow("nivel",$li_nivel);
					 $lb_valido=true;
			     }//if
				}//if		
			   }//if
			}//while
			$this->SQL->free_result($rs_data);
		}//else
     return $lb_valido;
    }//fin uf_spg_reportes_comparados_ejecucion_financiera_formato2
/****************************************************************************************************************************************/	
function uf_nombre_mes_desde_hasta($ai_mesdes,$ai_meshas)
{
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//	Function: 	  uf_load_nombre_mes
	//	Description:  Funcion que se encarga de obtener el numero de un mes a partir de su nombre.
	//	Arguments:	  - $ls_mes: Mes de la fecha a obtener el ultimo dia.	
	//				  - $ls_ano: A�o de la fecha a obtener el ultimo dia.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $ls_nombre_mesdes=$this->io_fecha->uf_load_nombre_mes($ai_mesdes);
    $ls_nombre_meshas=$this->io_fecha->uf_load_nombre_mes($ai_meshas);
	$ls_nombremes=$ls_nombre_mesdes."-".$ls_nombre_meshas;
  return $ls_nombremes;
 }
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_programado_trimestre_anterior_formato2($as_clave,$ad_asignado,$as_spg_cuenta,$as_estructura_desde,
	                                                               $as_estructura_hasta,$ai_mesdes,$ai_meshas,&$ad_monto_ejecutado,
																   $as_tipo,$ad_enero,$ad_febrero,$ad_marzo,$ad_abril,$ad_mayo,
																   $ad_junio,$ad_julio,$ad_agosto,$ad_septiembre,$ad_octubre,
																   $ad_noviembre,$ad_diciembre,$as_cant_mes)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_programado_trimestre_anterior_formato2
	 //         Access :	private
	 //     Argumentos :    $as_codrep  // codigo del reporte
	 //                     $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_clave  // clave
	 //                     $as_tipo  //  tipo
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida  
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    01/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     $ai_mesdes=intval($ai_mesdes);
     $ai_meshas=intval($ai_meshas);
	 /*$ai_mesdes=($ai_mesdes-3);
     $ai_meshas=($ai_mesdes-1);*/
	 $ld_monto_programado=0;
	 $ld_monto_acumulado=0;
	 $lb_valido=$this->uf_spg_reporte_calcular_programado($ai_mesdes-$as_cant_mes,$ai_meshas-1,$ld_monto_programado,$ld_monto_acumulado,
	                                                      $ad_enero,$ad_febrero,$ad_marzo,$ad_abril,$ad_mayo,$ad_junio,$ad_julio,
	                                                      $ad_agosto,$ad_septiembre,$ad_octubre,$ad_noviembre,$ad_diciembre);
														  
	 $ld_monto_ejecutado=0;     $ls_ejecutado_actual=0;
	 $ld_monto_acumulado=0;     $ld_aumdismes=0;
	 $ld_aumdisacum=0;          $ld_comprometer=0;
	 $ld_causado=0;       	    $ld_pagado=0;
	 $lb_valido=$this->uf_spg_reporte_calcular_ejecutado_trimestre_formato2($as_cant_mes,$as_clave,$as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,
																   $ai_mesdes,$ai_meshas,$ld_monto_ejecutado,$ld_monto_acumulado,
																   $ld_aumdismes,$ld_aumdisacum,$ld_comprometer,$ld_causado,
																   $ld_pagado,$as_tipo,$ls_ejecutado_actual);
     if($lb_valido)
	 {
	   if($as_clave==1)
	   {
	      $ad_monto_ejecutado=$ld_monto_programado;
	   }//if
	   else
	   {
	      $ad_monto_ejecutado=($ad_asignado+$ld_aumdismes+$ld_aumdisacum-$ld_comprometer);
	   }//else
	 }//if
    return  $lb_valido;
   }//fin uf_spg_reporte_calcular_programado_trimestre_anterior_formato2
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_ejecutado_trimestre_formato2($as_cant_mes,$as_clave,$as_spg_cuenta,$as_estructura_desde,$as_estructura_hasta,$ai_mesdes,
	                                                     $ai_meshas,&$ad_monto_ejecutado,&$ad_monto_acumulado,&$ad_aumdismes,&$ad_aumdisacum,
														 &$ad_comprometer,&$ad_causado,&$ad_pagado,$as_tipo,&$as_ejecutado_actual)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_ejecutado_trimestre_formato2
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_clave  // clave
	 //                     $as_tipo  //  tipo
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	Reporte que genera salida para el Formato 3 de la ejecucucion financiera
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    01/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;
	  $ld_aumento=0;
	  $ld_disminucion=0;
	  $ld_aumento_acum=0;
	  $ld_disminucion_acum=0;
	  $ldt_periodo=$_SESSION["la_empresa"]["periodo"];
	  $li_ano=substr($ldt_periodo,0,4);
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  if($as_clave==1)
	  {
	     if($ai_mesdes>3)
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-$as_cant_mes),2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-1),2);
         }
         else
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-$as_cant_mes),2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-1),2);
		 }		
		 if($ai_mesdes==1)
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes,2);
		 }
	  }//if
	  else
	  {
	     if($ai_mesdes==1)
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(1,2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
		 }
		 else
		 {
			 $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes,2);
			 $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
		 }	 
	  }
      if (strtoupper($ls_gestor)=="MYSQL")
	  {
		   $ls_cadena="CONCAT(c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5)";
	  }
	  else
	  {
		   $ls_cadena="c.codestpro1||c.codestpro2||c.codestpro3||c.codestpro4||c.codestpro5";
	  }	  
	  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
	  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer,OP.comprometer, OP.causar, OP.pagar ".
              " FROM   spg_dt_cmp DT, spg_operaciones OP ".
              " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
              "        ".$ls_cadena." between  '".$as_estructura_desde."' AND '".$as_estructura_hasta."'  AND ".
              "        spg_cuenta like '".$as_spg_cuenta."' ";
	  $rs_ejec=$this->SQL->select($ls_sql);
	  if($rs_ejec===false)
	  { // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_ejecutado_trimestre_formato2".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	  }
	  else
	  {
		while($row=$this->SQL->fetch_row($rs_ejec))
		{
		  $li_aumento=$row["aumento"];
		  $li_disminucion=$row["disminucion"];
		  $li_precomprometer=$row["precomprometer"];
		  $li_comprometer=$row["comprometer"];
		  $li_causar=$row["causar"];
		  $li_pagar=$row["pagar"];
		  $ld_monto=$row["monto"];
		  $ldt_fecha_db=$row["fecha"];
		  $ldt_fecha=substr($ldt_fecha_db,0,7);
		  if($as_tipo=="O")
		  {
		    if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			 $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
			
			if(($li_comprometer)&&($ldt_fecha<=$li_mesdes))
			{  
			  $$as_ejecutado_actual=$$as_ejecutado_actual+$ld_monto;
			}//if
			
		  }//if($as_tipo=="O")
		  
		  if($as_tipo=="C")
		  {
		    if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			  $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_causar)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
		  }//if($as_tipo=="C")
		  
		  //  Comprometer 
		  if(($li_comprometer)&&($ldt_fecha>=$li_mesantdes)&&($ldt_fecha<=$li_mesanthas))
		  { 
		    $ad_comprometer=$ad_comprometer+$ld_monto;
		  }//if
		  //Causar
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  //Pagar
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  // Aumento
		  if(($li_aumento)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_aumento=$ld_aumento+$ld_monto;
		  }//if
		  // Disminuci�n
		  if(($li_disminucion)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_disminucion=$ld_disminucion+$ld_monto;
		  }//if
		  // Aumento Acumulado
		  if(($li_aumento)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_aumento_acum=$ld_aumento+$ld_monto;
		  }//if
		  // Disminuci�n Acumulada
		  if(($li_disminucion)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_disminucion_acum=$ld_disminucion+$ld_monto;
		  }//if
		}//while
		$ad_aumdismes=$ld_aumento-$ld_disminucion;
		$ad_aumdisacum=$ld_aumento_acum-$ld_disminucion_acum;
	   $this->SQL->free_result($rs_ejec);
	  }//else	
	  return $lb_valido;	
   }//fin uf_spg_reporte_calcular_ejecutado_trimestre
/****************************************************************************************************************************************/	
    function uf_spg_reporte_calcular_ejecutado_meses($as_cant_mes,$as_clave,$as_spg_cuenta,$ai_mesdes,$as_estructura_desde,
	                                                 $as_estructura_hasta,$ai_meshas,&$ad_monto_ejecutado,&$ad_monto_acumulado,
													 &$ad_aumdismes,&$ad_aumdisacum,&$ad_comprometer,&$ad_causado,
	                                                 &$ad_pagado,$as_tipo,$ab_pasar,$ad_ejec_acum_t_ant,$as_codfuefindes,
													 $as_codfuefinhas)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_ejecutado_trimestre
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_tipo  //  tipo
	 //                     $$ad_ejec_acum_t_ant  // ejecutado acumulado del trimetre anterior
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	Reporte que genera salida para el Formato 3 de la ejecucucion financiera
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    02/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;
	  $ld_aumento=0;
	  $ld_disminucion=0;
	  $ld_aumento_acum=0;
	  $ld_disminucion_acum=0;
	  $ad_monto_ejecutado=0;
	  $ad_monto_acumulado=0;
	  $ldt_periodo=$_SESSION["la_empresa"]["periodo"];
	  $li_ano=substr($ldt_periodo,0,4);
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes,2);
	  $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
	  if($ab_pasar)
	  {
		  if($li_mesdes>3)
		  {
				$li_mesantdes=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-3),2);
				$li_mesanthas=$li_ano."-".$this->fun->uf_cerosizquierda(($ai_mesdes-1),2);
		  }
		  else
		  {
				$li_mesantdes=$li_ano."-".$this->fun->uf_cerosizquierda($ai_mesdes,2);
				$li_mesanthas=$li_ano."-".$this->fun->uf_cerosizquierda($ai_meshas,2);
		  }	  
		  
		  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
		  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer,OP.comprometer, OP.causar, OP.pagar ".
				  " FROM   spg_dt_cmp DT, spg_operaciones OP ".
				  " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
				  "        spg_cuenta like '".$as_spg_cuenta."' ";
	 }
	 else
	 {
		  if (strtoupper($ls_gestor)=="MYSQL")
		  {
			   $ls_cadena="CONCAT(DT.codestpro1,DT.codestpro2,DT.codestpro3,DT.codestpro4,DT.codestpro5,DT.estcla)";
		  }
		  else
		  {
			   $ls_cadena="DT.codestpro1||DT.codestpro2||DT.codestpro3||DT.codestpro4||DT.codestpro5||DT.estcla";
		  }	  
		  $li_estmodest=$_SESSION["la_empresa"]["estmodest"];
		  if($li_estmodest==1)
		  {
			  $ls_tabla="spg_ep3"; 
			  $ls_cadena_fuefin="AND DT.codestpro1=EP.codestpro1 AND DT.codestpro2=EP.codestpro2 AND DT.codestpro3=EP.codestpro3 AND DT.estcla=EP.estcla";
	      }
		  elseif($li_estmodest==2)
		  {
			  $ls_tabla="spg_ep5";
			  $ls_cadena_fuefin=" AND DT.codestpro1=EP.codestpro1 AND DT.codestpro2=EP.codestpro2 AND DT.codestpro3=EP.codestpro3 AND ".
								"	  DT.codestpro4=EP.codestpro4 AND DT.codestpro5=EP.codestpro5 AND DT.estcla=EP.estcla ";
		  }
		  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
		  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer, ". 
				  "		   OP.comprometer, OP.causar, OP.pagar ".
				  "	FROM   spg_dt_cmp DT, spg_operaciones OP , ".$ls_tabla." EP ".
				  "	WHERE  DT.codemp='".$ls_codemp."' AND  ".
				  "		   ".$ls_cadena."  BETWEEN '".$as_estructura_desde."' AND '".$as_estructura_hasta."' AND ".
				  "		   spg_cuenta like '".$as_spg_cuenta."' AND     ".
				  "		   EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."' AND  ".  
				  "		   DT.codemp=EP.codemp AND DT.operacion = OP.operacion   ".$ls_cadena_fuefin."  ";
		  
		  /*$as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
		  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer,OP.comprometer, OP.causar, OP.pagar ".
				  " FROM   spg_dt_cmp DT, spg_operaciones OP ".
				  " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
				  "        ".$ls_cadena." between  '".$as_estructura_desde."' AND '".$as_estructura_hasta."'  AND ".
				  "        spg_cuenta like '".$as_spg_cuenta."' ";*/
	  }
	  $rs_ejec=$this->SQL->select($ls_sql);
	  if($rs_ejec===false)
	  { // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_ejecutado_trimestre".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	  }
	  else
	  {
		while($row=$this->SQL->fetch_row($rs_ejec))
		{
		  $li_aumento=$row["aumento"];
		  $li_disminucion=$row["disminucion"];
		  $li_precomprometer=$row["precomprometer"];
		  $li_comprometer=$row["comprometer"];
		  $li_causar=$row["causar"];
		  $li_pagar=$row["pagar"];
		  $ld_monto=$row["monto"];
		  $ldt_fecha_db=$row["fecha"];
		  $ldt_fecha=substr($ldt_fecha_db,0,7);
		  
		  if($as_tipo=="O")
		  {
		    if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			 $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
	        if($ab_pasar==false)
			{
				if(($li_comprometer)&&($ldt_fecha<$li_mesdes))
				{  
				  $ad_ejec_acum_t_ant=$ad_ejec_acum_t_ant+$ld_monto;
				}//if
			}	
		  }//if($as_tipo=="O")
		  if($as_tipo=="C")
		  {
		    if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			  $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_causar)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
		  }//if($as_tipo=="C")
		  //Comprometer, Causar, Pagar, Aumento, Disminuci�n
		   if($ab_pasar)
		   {
			  if(($li_comprometer)&&($ldt_fecha>=$li_mesantdes)&&($ldt_fecha<=$li_mesanthas))
			  { 
				$ad_comprometer=$ad_comprometer+$ld_monto;
			  }//if
		  }  
		  else
		  {
			  if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			  { 
				$ad_comprometer=$ad_comprometer+$ld_monto;
			  }//if
		  }	  
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_aumento=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_disminucion=$ld_disminucion+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_aumento_acum=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_disminucion_acum=$ld_disminucion+$ld_monto;
		  }//if
		}//while
		$ad_aumdismes=$ld_aumento-$ld_disminucion;
		$ad_aumdisacum=$ld_aumento_acum-$ld_disminucion_acum;
	   $this->SQL->free_result($rs_ejec);
	  }//else	
	  return $lb_valido;	
   }//fin uf_spg_reporte_calcular_ejecutado_trim_actual
/****************************************************************************************************************************************/
    function uf_spg_reporte_calcular_meses_anteriores($as_cant_mes,$as_clave,$as_spg_cuenta,$ai_mesdes,$as_estructura_desde,
	                                                  $as_estructura_hasta,$ai_meshas,&$ad_monto_ejecutado,&$ad_monto_acumulado,
													  &$ad_aumdismes,&$ad_aumdisacum,&$ad_comprometer,&$ad_causado, 
	                                                  &$ad_pagado,$as_tipo,$ad_ejec_acum_t_ant,$as_codfuefindes,$as_codfuefinhas)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_calcular_meses_anteriores
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta
	 //                     $as_estructura_desde  // codigo programatico desde
	 //                     $as_estructura_hasta  //  codigo programatico hasta
	 //                     $as_mesdes  // mes  desde
     //              	    $as_meshas  // mes hasta
	 //                     $ad_monto_ejecutado // monto ejecutado (referencia)  
	 //                     $as_tipo  //  tipo
	 //                     $$ad_ejec_acum_t_ant  // ejecutado acumulado del trimetre anterior
     //	       Returns :	Retorna true o false si se realizo el metodo para el reporte
	 //	   Description :	Reporte que genera salida para el Formato 3 de la ejecucucion financiera
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    02/06/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $lb_valido = true;
	  $ld_aumento=0;
	  $ld_disminucion=0;
	  $ld_aumento_acum=0;
	  $ld_disminucion_acum=0;
	  $ad_monto_ejecutado=0;
	  $ad_monto_acumulado=0;
	  $ldt_periodo=$_SESSION["la_empresa"]["periodo"];
	  $li_ano=substr($ldt_periodo,0,4);
	  $ls_gestor = $_SESSION["ls_gestor"];
	  $ls_codemp = $this->dts_empresa["codemp"];
	  $li_mesd=intval($ai_mesdes);
	  $li_mesh=intval($ai_meshas);
	  if($li_mesd>3)
	  {
		  $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(($li_mesd-$as_cant_mes),2);
		  $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($li_mesh-$as_cant_mes,2);
	  }
	  else
	  {
		  if($li_mesd==1)
		  {
			  $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda($li_mesd,2);
			  $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($li_mesh,2);
		  }
		  else
		  {
			  $li_mesdes=$li_ano."-".$this->fun->uf_cerosizquierda(($li_mesd-$as_cant_mes),2);
			  $li_meshas=$li_ano."-".$this->fun->uf_cerosizquierda($li_mesh-$as_cant_mes,2);
		  }
	  }
	  if (strtoupper($ls_gestor)=="MYSQL")
	  {
		   $ls_cadena="CONCAT(DT.codestpro1,DT.codestpro2,DT.codestpro3,DT.codestpro4,DT.codestpro5,DT.estcla)";
	  }
	  else
	  {
		   $ls_cadena="DT.codestpro1||DT.codestpro2||DT.codestpro3||DT.codestpro4||DT.codestpro5||DT.estcla";
	  }	 
	  $li_estmodest=$_SESSION["la_empresa"]["estmodest"];
	  if($li_estmodest==1)
	  {
		  $ls_tabla="spg_ep3"; 
		  $ls_cadena_fuefin="AND DT.codestpro1=EP.codestpro1 AND DT.codestpro2=EP.codestpro2 AND DT.codestpro3=EP.codestpro3 AND DT.estcla=EP.estcla";
	  }
	  elseif($li_estmodest==2)
	  {
		  $ls_tabla="spg_ep5";
		  $ls_cadena_fuefin=" AND DT.codestpro1=EP.codestpro1 AND DT.codestpro2=EP.codestpro2 AND DT.codestpro3=EP.codestpro3 AND ".
							"	  DT.codestpro4=EP.codestpro4 AND DT.codestpro5=EP.codestpro5 AND DT.estcla=EP.estcla ";
	  }
	  $as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
	  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer, ". 
			  "		   OP.comprometer, OP.causar, OP.pagar ".
			  "	FROM   spg_dt_cmp DT, spg_operaciones OP , ".$ls_tabla." EP ".
			  "	WHERE  DT.codemp='".$ls_codemp."' AND  ".
			  "		   ".$ls_cadena."  BETWEEN '".$as_estructura_desde."' AND '".$as_estructura_hasta."' AND ".
			  "		   spg_cuenta like '".$as_spg_cuenta."' AND     ".
			  "		   EP.codfuefin BETWEEN '".$as_codfuefindes."' AND '".$as_codfuefinhas."' AND  ".  
			  "		   DT.codemp=EP.codemp AND DT.operacion = OP.operacion   ".$ls_cadena_fuefin."  ";
	  /*$as_spg_cuenta=$this->sigesp_int_spg->uf_spg_cuenta_sin_cero($as_spg_cuenta)."%";
	  $ls_sql=" SELECT DT.fecha, DT.monto, OP.aumento, OP.disminucion, OP.precomprometer, ".
	          "        OP.comprometer, OP.causar, OP.pagar ".
			  " FROM   spg_dt_cmp DT, spg_operaciones OP ".
			  " WHERE  DT.codemp='".$ls_codemp."' AND (DT.operacion = OP.operacion) AND ".
			  "        ".$ls_cadena." between  '".$as_estructura_desde."' AND '".$as_estructura_hasta."'  AND ".
			  "        spg_cuenta like '".$as_spg_cuenta."' ";*/
	  $rs_ejec=$this->SQL->select($ls_sql);
	  if($rs_ejec===false)
	  { // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_calcular_meses_anteriores".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
 	  }
	  else
	  {
		while($row=$this->SQL->fetch_row($rs_ejec))
		{
		  $li_aumento=$row["aumento"];
		  $li_disminucion=$row["disminucion"];
		  $li_precomprometer=$row["precomprometer"];
		  $li_comprometer=$row["comprometer"];
		  $li_causar=$row["causar"];
		  $li_pagar=$row["pagar"];
		  $ld_monto=$row["monto"];
		  $ldt_fecha_db=$row["fecha"];
		  $ldt_fecha=substr($ldt_fecha_db,0,7);
		  
		  if($as_tipo=="O")
		  {
		    if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			 $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
			if(($li_comprometer)&&($ldt_fecha<$li_mesdes))
			{  
			  $ad_ejec_acum_t_ant=$ad_ejec_acum_t_ant+$ld_monto;
			}//if
		  }//if($as_tipo=="O")
		  if($as_tipo=="C")
		  {
		    if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
			{ 
			  $ad_monto_ejecutado=$ad_monto_ejecutado+$ld_monto;
			}//if
			if(($li_causar)&&($ldt_fecha<=$li_meshas))
			{  
			  $ad_monto_acumulado=$ad_monto_acumulado+$ld_monto;
			}//if
		  }//if($as_tipo=="C")
		  //Comprometer, Causar, Pagar, Aumento, Disminuci�n
		  if(($li_comprometer)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
			$ad_comprometer=$ad_comprometer+$ld_monto;
	      }	  
		  if(($li_causar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_causado=$ad_causado+$ld_monto;
		  }//if
		  if(($li_pagar)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ad_pagado=$ad_pagado+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_aumento=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha>=$li_mesdes)&&($ldt_fecha<=$li_meshas))
		  { 
		    $ld_disminucion=$ld_disminucion+$ld_monto;
		  }//if
		  if(($li_aumento)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_aumento_acum=$ld_aumento+$ld_monto;
		  }//if
		  if(($li_disminucion)&&($ldt_fecha<=$li_meshas))
		  {  
			  $ld_disminucion_acum=$ld_disminucion+$ld_monto;
		  }//if
		}//while
		$ad_aumdismes=$ld_aumento-$ld_disminucion;
		$ad_aumdisacum=$ld_aumento_acum-$ld_disminucion_acum;
	   $this->SQL->free_result($rs_ejec);
	  }//else	
	  return $lb_valido;	
   }//fin uf_spg_reporte_calcular_meses_anteriores
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_proyecto( $as_codestpro1_ori,$as_codestpro2_ori,$as_codestpro3_ori,$as_codestpro4_ori,$as_codestpro5_ori,
	                                         $as_codestpro1_des,$as_codestpro2_des,$as_codestpro3_des,$as_codestpro4_des,$as_codestpro5_des,
											 $as_estcla)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_apertura
	 //         Access :	private
	 //     Argumentos :    as_codestpro1_ori ... $as_codestpro5_ori //rango nivel estructura presupuestaria origen
	 //                     as_codestpro1_des ... $as_codestpro5_des //rango nivel estructura presupuestaria destino
	 //                     adt_fecini  // fecha  desde 
     //              	    adt_fecfin  // fecha hasta 
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	Reporte que genera salida  del listado de apertura  
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    09/05/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $lb_valido = true;	 
	 $ls_gestor = $_SESSION["ls_gestor"];
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $this->dts_prog->resetds("spg_cuenta");
	 $ls_estructura_desde=$as_codestpro1_ori.$as_codestpro2_ori.$as_codestpro3_ori.$as_codestpro4_ori.$as_codestpro5_ori;
	 $ls_estructura_hasta=$as_codestpro1_des.$as_codestpro2_des.$as_codestpro3_des.$as_codestpro4_des.$as_codestpro5_des;	 
	 if (strtoupper($ls_gestor)=="MYSQL")
	 {
	   $ls_cadena="CONCAT(c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5)";
	 }
	 else
	 {
	   $ls_cadena="c.codestpro1||c.codestpro2||c.codestpro3||c.codestpro4||c.codestpro5";
	 }
     $ls_sql=" SELECT  distinct concat(c.codestpro1,c.codestpro2,c.codestpro3,c.codestpro4,c.codestpro5) as programatica ".
             " FROM   spg_cuentas c, spg_plantillareporte r, spg_ep1 p ".
             " WHERE  c.codemp=r.codemp AND r.codemp=p.codemp AND p.codemp='".$ls_codemp."' AND (c.codestpro1=r.codestpro1 AND ".
             "        p.estcla='".$as_estcla."' AND  r.codestpro1=p.codestpro1 AND c.codestpro2=r.codestpro2 AND c.codestpro3=r.codestpro3 AND ".
             "        c.codestpro4=r.codestpro4 AND c.codestpro5=r.codestpro5) AND (c.spg_cuenta = r.spg_cuenta) AND ".
             "        (r.status <> 'I') AND ".$ls_cadena." ".
             "        between '".$ls_estructura_desde."' AND '".$ls_estructura_hasta."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {
		  $lb_valido=false;
		  $this->io_msg->message("CLASE->sigesp_spg_class_report M�TODO->uf_spg_reporte_select_proyecto ERROR->".$this->fun->uf_convertirmsg($this->SQL->message));
	 }
	else
	{
		if($row=$this->SQL->fetch_row($rs_data))
		{
		  $datos=$this->SQL->obtener_datos($rs_data);
		  $this->dts_prog->data=$datos;				
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);   
     }//else
	return $lb_valido;
   }//	uf_spg_reporte_select_apertura	
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_min_programatica(&$as_codestpro1,&$as_codestpro2,&$as_codestpro3)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_min_programatica
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta maxima (referencias)
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la cuenta minima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /*$lb_valido=$this->uf_spg_reporte_select_min_codestpro1(&$as_codestpro1);
	 if($lb_valido)
	 {
		 $lb_valido=$this->uf_spg_reporte_select_min_codestpro2($as_codestpro1,&$as_codestpro2);
	 }
	 if($lb_valido)
	 {
		 $lb_valido=$this->uf_spg_reporte_select_min_codestpro3($as_codestpro1,$as_codestpro2,&$as_codestpro3);
	 }*/
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT a.codestpro1 as codestpro1,a.denestpro1 as denestpro1,b.codestpro2 as codestpro2, ".
 		     "        b.denestpro2 as denestpro2,c.codestpro3 as codestpro3,c.denestpro3 as denestpro3 ".
             " FROM   spg_ep1 a,spg_ep2 b,spg_ep3 c ".
             " WHERE  a.codemp=b.codemp AND a.codemp=c.codemp AND a.codemp='".$ls_codemp."' AND a.codestpro1=b.codestpro1 AND ".
             "        a.codestpro1=c.codestpro1  AND b.codestpro2=c.codestpro2  AND c.codestpro3 like '%' AND c.denestpro3 like '%' ".
             " ORDER BY  codestpro1  limit 1 ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_min_codestpro1 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro1=$row["codestpro1"];
		   $as_codestpro2=$row["codestpro2"];
		   $as_codestpro3=$row["codestpro3"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_max_cuenta
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_min_codestpro1(&$as_codestpro1)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_min_codestpro1
	 //         Access :	private
	 //     Argumentos :    $as_codestpro1  // codigo de estructura programatica 1 (referencia)
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1  minima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT min(codestpro1) as codestpro1 ".
             " FROM   spg_ep1 ".
             " WHERE  codemp = '".$ls_codemp."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_min_codestpro1 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro1=$row["codestpro1"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_min_codestpro1
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_min_codestpro2($as_codestpro1,&$as_codestpro2)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_min_codestpro2
	 //         Access :	private
	 //     Argumentos :    $as_codestpro2  // codigo de estructura programatica 2 (referencia)
	 //                     $as_codestpro1  // codigo de estructura programatica 1           
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1  minima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT min(codestpro2) as codestpro2 ".
             " FROM   spg_ep2 ".
             " WHERE  codemp = '".$ls_codemp."' AND codestpro1='".$as_codestpro1."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_min_codestpro2 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro2=$row["codestpro2"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_min_codestpro2
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_min_codestpro3($as_codestpro1,$as_codestpro2,&$as_codestpro3)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_min_codestpro3
	 //         Access :	private
	 //     Argumentos :    $as_codestpro3  // codigo de estructura programatica 3 (referencia)
	 //                     $as_codestpro1  // codigo de estructura programatica 1 
	 //                     $as_codestpro2  // codigo de estructura programatica 2           
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1  minima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT min(codestpro3) as codestpro3 ".
             " FROM   spg_ep3 ".
             " WHERE  codemp = '".$ls_codemp."' AND codestpro1='".$as_codestpro1."' AND codestpro2='".$as_codestpro2."'";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_min_codestpro3 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro3=$row["codestpro3"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_min_codestpro3
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_max_programatica(&$as_codestpro1,&$as_codestpro2,&$as_codestpro3)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_max_programatica
	 //         Access :	private
	 //     Argumentos :    $as_spg_cuenta  // cuenta maxima (referencias)
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve la cuenta minima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /*$lb_valido=$this->uf_spg_reporte_select_max_codestpro1(&$as_codestpro1);
	 if($lb_valido)
	 {
		 $lb_valido=$this->uf_spg_reporte_select_max_codestpro2($as_codestpro1,&$as_codestpro2);
	 }
	 if($lb_valido)
	 {
		 $lb_valido=$this->uf_spg_reporte_select_max_codestpro3($as_codestpro1,$as_codestpro2,&$as_codestpro3);
	 }*/
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT a.codestpro1 as codestpro1,a.denestpro1 as denestpro1,b.codestpro2 as codestpro2, ".
 		     "        b.denestpro2 as denestpro2,c.codestpro3 as codestpro3,c.denestpro3 as denestpro3 ".
             " FROM   spg_ep1 a,spg_ep2 b,spg_ep3 c ".
             " WHERE  a.codemp=b.codemp AND a.codemp=c.codemp AND a.codemp='".$ls_codemp."' AND a.codestpro1=b.codestpro1 AND ".
             "        a.codestpro1=c.codestpro1  AND b.codestpro2=c.codestpro2  AND c.codestpro3 like '%' AND c.denestpro3 like '%' ".
             " ORDER BY  codestpro1 desc limit 1 ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_min_codestpro1 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro1=$row["codestpro1"];
		   $as_codestpro2=$row["codestpro2"];
		   $as_codestpro3=$row["codestpro3"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_max_programatica
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_max_codestpro1(&$as_codestpro1)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_max_codestpro1
	 //         Access :	private
	 //     Argumentos :    $as_codestpro1  // codigo de estructura programatica 1 (referencia)
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1  maxima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT max(codestpro1) as codestpro1 ".
             " FROM   spg_ep1 ".
             " WHERE  codemp = '".$ls_codemp."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_max_codestpro1 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro1=$row["codestpro1"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_max_codestpro1
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_max_codestpro2($as_codestpro1,&$as_codestpro2)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_max_codestpro2
	 //         Access :	private
	 //     Argumentos :    $as_codestpro2  // codigo de estructura programatica 2 (referencia)
	 //                     $as_codestpro1  // codigo de estructura programatica 1           
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1  maxima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT max(codestpro2) as codestpro2 ".
             " FROM   spg_ep2 ".
             " WHERE  codemp = '".$ls_codemp."' AND codestpro1='".$as_codestpro1."' ";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_max_codestpro2 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro2=$row["codestpro2"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_max_codestpro2
/****************************************************************************************************************************************/
    function uf_spg_reporte_select_max_codestpro3($as_codestpro1,$as_codestpro2,&$as_codestpro3)
    {//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 //	      Function :	uf_spg_reporte_select_max_codestpro3
	 //         Access :	private
	 //     Argumentos :    $as_codestpro3  // codigo de estructura programatica 3 (referencia)
	 //                     $as_codestpro1  // codigo de estructura programatica 1 
	 //                     $as_codestpro2  // codigo de estructura programatica 2           
     //	       Returns :	Retorna true o false si se realizo la consulta para el reporte
	 //	   Description :	devuelve el codigo de estructura programatica 1 maxima de la tabla spg_cuentas
	 //     Creado por :    Ing. Yozelin Barrag�n.
	 // Fecha Creaci�n :    19/07/2006          Fecha �ltima Modificacion :      Hora :
  	 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_codemp = $this->dts_empresa["codemp"];
	 $lb_valido=true;
	 $ls_sql=" SELECT max(codestpro3) as codestpro3 ".
             " FROM   spg_ep3 ".
             " WHERE  codemp = '".$ls_codemp."' AND codestpro1='".$as_codestpro1."' AND codestpro2='".$as_codestpro2."'";
	 $rs_data=$this->SQL->select($ls_sql);
	 if($rs_data===false)
	 {   // error interno sql
		$this->is_msg_error="Error en consulta metodo uf_spg_reporte_select_max_codestpro3 ".$this->fun->uf_convertirmsg($this->SQL->message);
		$lb_valido = false;
	 }
	 else
	 {
		if($row=$this->SQL->fetch_row($rs_data))
		{
		   $as_codestpro3=$row["codestpro3"];
		}
		else
		{
		   $lb_valido = false;
		}
		$this->SQL->free_result($rs_data);
	 }//else
	return $lb_valido;
  }//uf_spg_reporte_select_max_codestpro3
/****************************************************************************************************************************************/
}//fin de clase
?>