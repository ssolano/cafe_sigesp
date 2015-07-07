<?php
    session_start();   
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "opener.document.form1.submit();";		
		print "</script>";		
	}
	ini_set('memory_limit','1024M');
	ini_set('max_execution_time','0');

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo,$as_titulo2)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 04/08/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		$ls_descripcion="Gener� el Reporte ".$as_titulo." ".$as_titulo2;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte("SNR","sigesp_snorh_r_retencion_arc.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_titulo2,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 04/08/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_tiporeporte;
		if($ls_tiporeporte==1)
		{
			$ls_titulobs="Bol�vares Fuertes";
		}
		else
		{
			$ls_titulobs="Bol�vares";
		}
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,555,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$as_titulo1="<b>COMPROBANTE DE RETENCI�N DE IMPUESTO SOBRE LA RENTA</b>";
		$as_titulo3="<b>O CESE DE ACTIVIDADES PARA PERSONAS</b>";
		$as_titulo4="<b>RESIDENTES PERCEPTORAS DE SUELDOS</b>";
		$as_titulo5="<b>SALARIOS Y DEM�S REMUNERACIONES SIMILARES</b>";
		$io_pdf->addText(160,750,9,$as_titulo1);
		$io_pdf->addText(205,740,9,$as_titulo3);
		$io_pdf->addText(205,730,9,$as_titulo4);	
		$io_pdf->addText(185,720,9,$as_titulo5);
		$io_pdf->addText(230,710,9,$as_titulo2);
		$io_pdf->addText(270,700,9,$ls_titulobs);
		$io_pdf->addText(512,750,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(518,743,7,date("h:i a")); // Agregar la Hora
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(50,680,500,$io_pdf->getFontHeight(12));
        $io_pdf->setColor(0,0,0);
		$io_pdf->ezSetY(669);
		$io_pdf->addText(55,683,10,'<b>Datos Agentes de Retenci�n</b>'); // Agregar el t�tulo
		$la_data[0]=array('titulo'=>'<b>Nombre</b>','descripcion'=>$_SESSION["la_empresa"]["nombre"]);
		$la_data[1]=array('titulo'=>'<b>Direcci�n</b>','descripcion'=>str_pad($_SESSION["la_empresa"]["direccion"],154," "));
		$la_data[2]=array('titulo'=>'<b>Rif</b>','descripcion'=>$_SESSION["la_empresa"]["rifemp"]);
		$la_columnas=array('titulo'=>'','descripcion'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('titulo'=>array('justification'=>'left','width'=>45), // Justificaci�n y ancho de la columna
						 			   'descripcion'=>array('justification'=>'left','width'=>455))); // Justificaci�n y ancho de la columna
		$io_pdf->ezSetDy(10);
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_nacper,$as_cedper,$as_nomper,&$io_cabecera,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_nacper // nacionalidad del Personal
		//	    		   as_cedper // C�dula del Personal
		//	   			   as_nomper // Nombre del Personal
		//	    		   io_cabecera // objeto cabecera
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime la cabecera por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 04/08/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(50,620,500,$io_pdf->getFontHeight(12));
        $io_pdf->setColor(0,0,0);
		$io_pdf->addText(55,622,10,'<b>Beneficiario de las Remuneraciones</b>'); // Agregar el t�tulo
		$io_pdf->addText(55,610,8,'<b>Apellidos y Nombre</b>  '.$as_nacper.'-'.$as_cedper.'   '.$as_nomper.''); // Agregar el t�tulo
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_cabecera,'all');
	}// end function uf_print_cabecera
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el detalle por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 04/08/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetY(600);
		$la_columnas=array('mes'=>'<b>Mes</b>',
						   'arc'=>'<b>Remuneraciones    Pagadas Abonadas  en Cuenta        </b>',
						   'porcentaje'=>'<b>Porcentaje de         Retenci�n         </b>',
						   'retencion'=>'<b>Impuesto   Retenido   </b>',
						   'arcacum'=>'<b>Remuneraciones    Pagadas Abonadas    en  Cuenta          Acumuladas        </b>',
						   'retencionacum'=>'<b>Impuesto Retenido     Acumulado        </b>',
						   'datos'=>'<b>Datos Obtenidos de la Informaci�n         Suministrada por el   Contribuyente      </b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('mes'=>array('justification'=>'center','width'=>30), // Justificaci�n y ancho de la columna
						 			   'arc'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'porcentaje'=>array('justification'=>'right','width'=>55), // Justificaci�n y ancho de la columna
						 			   'retencion'=>array('justification'=>'right','width'=>55), // Justificaci�n y ancho de la columna
						 			   'arcacum'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'retencionacum'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'datos'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_aporte($la_data,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_aporte
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el detalle por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 07/08/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetDy(-10);
		$la_columnas=array('codigo'=>'<b>C�digo</b>',
						   'nombre'=>'<b>                                   Nombre</b>',
						   'monto'=>'<b>Monto               </b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>360, // Ancho de la tabla
						 'maxWidth'=>360, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'Aporte Patronal',$la_config);
	}// end function uf_print_detalle_aporte
	//-----------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_firmas(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_firmas
		//		   Access: private 
		//    Description: funci�n que imprime las firmas
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 22/05/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data[0]=array('firma1'=>'');
		$la_data[1]=array('firma1'=>'');
		$la_data[2]=array('firma1'=>'');
		$la_data[3]=array('firma1'=>'');
		$la_data[4]=array('firma1'=>'');
		$la_data[5]=array('firma1'=>'');
		$la_data[6]=array('firma1'=>'');
		$la_data[7]=array('firma1'=>'');
		$la_data[8]=array('firma1'=>'LIC. CARLOS MATO');
		$la_data[9]=array('firma1'=>'ADMINISTRADOR');
		$la_data[10]=array('firma1'=>$_SESSION["la_empresa"]["nombre"]);
		$la_columna=array('firma1'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>600, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('firma1'=>array('justification'=>'center','width'=>600))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_firmas
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_snorh_class_report.php");
	$io_report=new sigesp_snorh_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	require_once("../../shared/class_folder/class_fecha.php");
	$io_fecha=new class_fecha();
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>COMPROBANTE DE RETENCI�N DE IMPUESTO SOBRE LA RENTA ANUAL O CESE DE ACTIVIDADES PARA PERSONAS RESIDENTES PRECEPTORAS DE SUELDOS, SALARIOS Y DEM�S REMUNERACIONES SIMILARES</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$li_total=$io_fun_nomina->uf_obtenervalor_get("total","0");
	for($li_i=1;$li_i<=$li_total;$li_i++)
	{
		$la_nominas[$li_i]=$io_fun_nomina->uf_obtenervalor_get("codnom".$li_i,"");
	}
	$ls_codperdes      = $io_fun_nomina->uf_obtenervalor_get("codperdes","");
	$ls_codperhas      = $io_fun_nomina->uf_obtenervalor_get("codperhas","");
	$ls_ano			   = $io_fun_nomina->uf_obtenervalor_get("ano","");
	$ls_conceptoaporte = $io_fun_nomina->uf_obtenervalor_get("conceptoaporte","");
	$ls_excluir		   = $io_fun_nomina->uf_obtenervalor_get("excluir","");
	$ls_orden		   = $io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_titulo2		   = "<b>Periodo</b> 01/01/".$ls_ano." <b>al</b> 31/12/".$ls_ano;
	$ls_tiporeporte	   = $io_fun_nomina->uf_obtenervalor_get("tiporeporte",0);
	global $ls_tiporeporte;
	if($ls_tiporeporte==1)
	{
		require_once("sigesp_snorh_class_reportbsf.php");
		$io_report=new sigesp_snorh_class_reportbsf();
	}
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo,$ls_titulo2); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_retencionarc_personal($la_nominas,$li_total,$ls_ano,$ls_orden,$ls_codperdes,$ls_codperhas); // Cargar el DS con los datos del reporte
	}
	if($lb_valido==false) // Existe alg�n error � no hay registros
	{
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');"); 
		print(" close();");
		print("</script>");
	}
	else  // Imprimimos el reporte
	{
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(3.6,2.5,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$ls_titulo2,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		$li_totrow=$io_report->DS->getRowCount("codper");
		$lb_cabecera=false;
		$lb_print=false;
		for($li_i=1;(($li_i<=$li_totrow)&&($lb_valido));$li_i++)
		{
			$ls_codper=$io_report->DS->data["codper"][$li_i];
			$ls_nomper=$io_report->DS->data["apeper"][$li_i].", ".$io_report->DS->data["nomper"][$li_i];
			$ls_nacper=$io_report->DS->data["nacper"][$li_i];
			$ls_cedper=$io_report->DS->data["cedper"][$li_i];
			$lb_valido=$io_report->uf_retencionarc_meses($ls_codper,$la_nominas,$li_total,$ls_ano); // Obtenemos el detalle del reporte
			if($lb_valido)
			{
				$li_totrow_det=$io_report->DS_detalle->getRowCount("codper");
				$li_arcacum=0;
				$li_islracum=0;
				$lb_arc=false;
				for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
				{
					$ls_codisr=$io_report->DS_detalle->data["codisr"][$li_s];
					$li_porisr=$io_fun_nomina->uf_formatonumerico($io_report->DS_detalle->data["porisr"][$li_s]);
					$li_arcacum=$li_arcacum+abs($io_report->DS_detalle->data["arc"][$li_s]);
					$li_islracum=$li_islracum+abs($io_report->DS_detalle->data["islr"][$li_s]);
					$li_arc=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS_detalle->data["arc"][$li_s]));
					$li_islr=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS_detalle->data["islr"][$li_s]));
					$li_arc_acumulado=$io_fun_nomina->uf_formatonumerico($li_arcacum);
					$li_isl_acumulado=$io_fun_nomina->uf_formatonumerico($li_islracum);
					$ls_mes=strtoupper(substr($io_fecha->uf_load_nombre_mes($ls_codisr),0,3));
					if($li_arc<>"0,00")
					{
						$lb_arc=true;
					}
					$la_data[$li_s]=array('mes'=>$ls_mes,'arc'=>$li_arc,'porcentaje'=>$li_porisr,'retencion'=>$li_islr,
										  'arcacum'=>$li_arc_acumulado,'retencionacum'=>$li_isl_acumulado,'datos'=>'');
				}
				$io_report->DS_detalle->resetds("codper");
				if($li_totrow_det==0)
				{
					$lb_arc=false;
					for($li_s=1;$li_s<=12;$li_s++)
					{
						$ls_codisr=str_pad($li_s,2,"0",0);
						$li_porisr=$io_fun_nomina->uf_formatonumerico(0);
						$li_arcacum=0;
						$li_islracum=0;
						$li_arc=$io_fun_nomina->uf_formatonumerico(0);
						$li_islr=$io_fun_nomina->uf_formatonumerico(0);
						$li_arc_acumulado=$io_fun_nomina->uf_formatonumerico(0);
						$li_isl_acumulado=$io_fun_nomina->uf_formatonumerico(0);
						$ls_mes=strtoupper(substr($io_fecha->uf_load_nombre_mes($ls_codisr),0,3));
						$la_data[$li_s]=array('mes'=>$ls_mes,'arc'=>$li_arc,'porcentaje'=>$li_porisr,'retencion'=>$li_islr,
											  'arcacum'=>$li_arc_acumulado,'retencionacum'=>$li_isl_acumulado,'datos'=>'');
					}
				}

				if($ls_excluir=="1")
				{
					if($lb_arc)
					{				
						$io_cabecera=$io_pdf->openObject(); // Creamos el objeto cabecera
						uf_print_cabecera($ls_nacper,$ls_cedper,$ls_nomper,&$io_cabecera,&$io_pdf); // Imprimimos la cabecera del registro
						$lb_cabecera=true;
						$lb_print=true;
						uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
						unset($la_data);
					}
				}
				else
				{				
					$io_cabecera=$io_pdf->openObject(); // Creamos el objeto cabecera
					uf_print_cabecera($ls_nacper,$ls_cedper,$ls_nomper,&$io_cabecera,&$io_pdf); // Imprimimos la cabecera del registro
					$lb_cabecera=true;
					$lb_print=true;
					uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
					unset($la_data);
					$lb_arc=true;
				}
				if(($lb_valido)&&($lb_arc))// Si no ocurrio ning�n error
				{
					if($ls_conceptoaporte=="1") // Si solicita que se muestren los conceptos de aporte
					{
						$lb_valido=$io_report->uf_retencionarc_aporte($ls_codper,$la_nominas,$li_total,$ls_ano);
						$li_totrow_det=$io_report->DS_detalle->getRowCount("codconc");
						for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
						{
							$ls_codconc=$io_report->DS_detalle->data["codconc"][$li_s];
							$ls_nomcon=$io_report->DS_detalle->data["nomcon"][$li_s];
							$li_monto=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS_detalle->data["monto"][$li_s]));
							$la_data[$li_s]=array('codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'monto'=>$li_monto);
						}
						$io_report->DS_detalle->resetds("codconc");
						if($li_totrow_det>0)
						{
							uf_print_detalle_aporte($la_data,$io_pdf);
						}
					}
				}
				if($lb_cabecera)
				{					
					uf_print_firmas(&$io_pdf);	
					$io_pdf->stopObject($io_cabecera); // Detener el objeto cabecera
					$lb_cabecera=false;
				}
				if(($li_i<$li_totrow)&&($lb_arc))
				{
					$io_pdf->ezNewPage(); // Insertar una nueva p�gina
				}
				unset($io_cabecera);
				unset($la_data);
			}
		}
		$io_report->DS->resetds("codper");
		if($lb_valido) // Si no ocurrio ning�n error
		{
			if($lb_print)
			{
				$io_pdf->ezStopPageNumbers(1,1); // Detenemos la impresi�n de los n�meros de p�gina
				$io_pdf->ezStream(); // Mostramos el reporte
			}
			else
			{
				print("<script language=JavaScript>");
				print(" alert('no hay nada que reportar.');"); 
				print(" close();");
				print("</script>");		
			}
		}
		else // Si hubo alg�n error
		{
			print("<script language=JavaScript>");
			print(" alert('Ocurrio un error al generar el reporte. Intente de Nuevo');"); 
			print(" close();");
			print("</script>");		
		}
		unset($io_pdf);
	}
	unset($io_report);
	unset($io_funciones);
	unset($io_fun_nomina);
	unset($io_fecha);
?> 
