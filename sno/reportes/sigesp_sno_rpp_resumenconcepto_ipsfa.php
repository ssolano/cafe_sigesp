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
	ini_set('memory_limit','256M');
	ini_set('max_execution_time','0');

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo,$as_desnom,$as_periodo,$ai_tipo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_desnom // Descripci�n de la n�mina
		//	    		   as_periodo // Descripci�n del per�odo
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		
		$ls_codnom=$_SESSION["la_nomina"]["codnom"];
		$ls_descripcion="Gener� el Reporte ".$as_titulo.". Para ".$as_desnom.". ".$as_periodo;
		if($ai_tipo==1)
		{
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_resumenconcepto.php",$ls_descripcion,$ls_codnom);
		}
		else
		{
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_hresumenconcepto.php",$ls_descripcion,$ls_codnom);
		}
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_desnom,$as_periodo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_desnom // Descripci�n de la n�mina
		//	    		   as_periodo // Descripci�n del per�odo
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 26/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,755,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,530,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=396-($li_tm/2);
		$io_pdf->addText($tm,545,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(11,$as_periodo);
		$tm=396-($li_tm/2);
		$io_pdf->addText($tm,535,11,$as_periodo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(10,$as_desnom);
		$tm=396-($li_tm/2);
		$io_pdf->addText($tm,525,10,$as_desnom); // Agregar el t�tulo
		$io_pdf->addText(712,560,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(718,553,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera(&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el detalle por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/07/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->ezSety(520);
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(40,505,700,$io_pdf->getFontHeight(11.5));
        $io_pdf->setColor(0,0,0);
		$la_data[1]=array('nro'=>'<b>Nro</b>',
					      'codigo'=>'<b>C�digo</b>',
						  'nombre'=>'<b>Denominaci�n</b>',
					      'partida'=>'<b>Partida</b>',
					      'personal'=>'<b>Nro Personas</b>',
						  'asignacion'=>'<b>Asignaci�n</b>',
						  'deduccion'=>'<b>Deducci�n</b>',
						  'aporte'=>'<b>Aporte Patronal</b>');
		$la_columna=array('nro'=>'',
						  'codigo'=>'',
						  'nombre'=>'',
					      'partida'=>'',
					      'personal'=>'',
						  'asignacion'=>'',
						  'deduccion'=>'',
						  'aporte'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('nro'=>array('justification'=>'center','width'=>30), // Justificaci�n y ancho de la columna
						 			   'codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'center','width'=>200), // Justificaci�n y ancho de la columna
						 			   'partida'=>array('justification'=>'center','width'=>90), // Justificaci�n y ancho de la columna
						 			   'personal'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'center','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
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
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columnas=array('nro'=>'<b>Nro</b>',
						   'codigo'=>'<b>C�digo</b>',
						   'nombre'=>'<b>                  Denominaci�n</b>',
					       'partida'=>'<b>Partida</b>',
					       'personal'=>'<b>Nro Personas</b>',
						   'asignacion'=>'<b>Asignaci�n      </b>',
						   'deduccion'=>'<b>Deducci�n       </b>',
						   'aporte'=>'<b>Aporte Patronal</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('nro'=>array('justification'=>'center','width'=>30), // Justificaci�n y ancho de la columna
						 			   'codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
						 			   'partida'=>array('justification'=>'center','width'=>90), // Justificaci�n y ancho de la columna
						 			   'personal'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_piecabecera($ai_totasi,$ai_totded,$ai_totapo,$ai_totgeneral,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_piecabecera
		//		   Access: private 
		//	    Arguments: ai_totasi // Total de Asignaciones
		//	   			   ai_totded // Total de Deducciones
		//	   			   ai_totapo // Total de Aportes
		//	   			   ai_totgeneral // Total de Neto a Pagar
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		$la_data=array(array('titulo'=>'<b>Totales '.$ls_bolivares.'</b>','asignacion'=>$ai_totasi,'deduccion'=>$ai_totded,'aporte'=>$ai_totapo));
		$la_columna=array('titulo'=>'','asignacion'=>'','deduccion'=>'','aporte'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo'=>array('justification'=>'right','width'=>460),
						 			   'asignacion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	

		$la_data=array(array('name'=>''));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 10, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>500); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	


		$la_data=array(array('name'=>'<b>Neto a Pagar '.$ls_bolivares.': </b>','total'=>$ai_totgeneral));
		$la_columna=array('name'=>'','total'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize'=> 9, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((224/255),(224/255),(224/255)), // Color de la sombra
						 'shadeCol2'=>array((224/255),(224/255),(224/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('name'=>array('justification'=>'right','width'=>600), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	if($_SESSION["la_nomina"]["tiponomina"]=="NORMAL")
	{
		require_once("sigesp_sno_class_report.php");
		$io_report=new sigesp_sno_class_report();
		$li_tipo=1;
	}
	if($_SESSION["la_nomina"]["tiponomina"]=="HISTORICA")
	{
		require_once("sigesp_sno_class_report_historico.php");
		$io_report=new sigesp_sno_class_report_historico();
		$li_tipo=2;
	}	
	$ls_bolivares ="Bs.";
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_desnom=$_SESSION["la_nomina"]["desnom"];
	$ls_peractnom=$_SESSION["la_nomina"]["peractnom"];
	$ld_fecdesper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fecdesper"]);
	$ld_fechasper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fechasper"]);
	$ls_titulo="<b>Resumen de Conceptos</b>";
	$ls_periodo="<b>Per�odo Nro ".$ls_peractnom.", ".$ld_fecdesper." - ".$ld_fechasper."</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codconcdes=$io_fun_nomina->uf_obtenervalor_get("codconcdes","");
	$ls_codconchas=$io_fun_nomina->uf_obtenervalor_get("codconchas","");
	$ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
	$ls_aportepatronal=$io_fun_nomina->uf_obtenervalor_get("aportepatronal","");
	$ls_subnomdes=$io_fun_nomina->uf_obtenervalor_get("subnomdes","");
	$ls_subnomhas=$io_fun_nomina->uf_obtenervalor_get("subnomhas","");
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo,$ls_desnom,$ls_periodo,$li_tipo); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_resumenconcepto_conceptos($ls_codconcdes,$ls_codconchas,$ls_aportepatronal,$ls_conceptocero,$ls_subnomdes,
															$ls_subnomhas,&$rs_data); // Cargar el DS con los datos de la cabecera del reporte
	}
	if(($lb_valido==false)||($rs_data->RecordCount()==0)) // Existe alg�n error � no hay registros
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
		$io_pdf=new Cezpdf('LETTER','landscape'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(4,2.5,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$ls_desnom,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(750,50,10,'','',1); // Insertar el n�mero de p�gina
		$li_totrow=$rs_data->RecordCount();
		$li_totasi=0;
		$li_totded=0;
		$li_totapo=0;
		uf_print_cabecera($io_pdf);
		$li_i=1;
		$la_data="";
		while ((!$rs_data->EOF)&&($lb_valido))
		//for($li_i=1;(($li_i<=$li_totrow)&&($lb_valido));$li_i++)
		{
			$ls_codconc=$rs_data->fields["codconc"];
			$ls_nomcon=$rs_data->fields["nomcon"];
			$li_monto=$io_fun_nomina->uf_formatonumerico(abs($rs_data->fields["monto"]));
			$ls_tipsal=rtrim($rs_data->fields["tipsal"]);
			$li_totalpersonal=number_format($rs_data->fields["total"],0,"",".");
			$ls_cueprecon=rtrim($rs_data->fields["cueprecon"]);
			$ls_cueprepatcon=rtrim($rs_data->fields["cueprepatcon"]);
			switch($ls_tipsal)
			{
				case "A": // Asignaci�n
					$li_totasi=$li_totasi+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>$li_monto,'deduccion'=>'','aporte'=>'');
					break;

				case "V1": // Asignaci�n
					$li_totasi=$li_totasi+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>$li_monto,'deduccion'=>'','aporte'=>'');
					break;

				case "W1": // Asignaci�n
					$li_totasi=$li_totasi+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>$li_monto,'deduccion'=>'','aporte'=>'');
					break;

				case "D": // Deducci�n
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "V2": // Deducci�n
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "W2": // Deducci�n
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "P1": // Aporte Empleado
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "V3": // Aporte Empleado
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "W3": // Aporte Empleado
					$li_totded=$li_totded+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprecon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>$li_monto,'aporte'=>'');
					break;

				case "P2": // Aporte Patr�n
					$li_totapo=$li_totapo+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprepatcon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>'','aporte'=>$li_monto);
					break;

				case "V4": // Aporte Patr�n
					$li_totapo=$li_totapo+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprepatcon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>'','aporte'=>$li_monto);
					break;

				case "W4": // Aporte Patr�n
					$li_totapo=$li_totapo+abs($rs_data->fields["monto"]);
					$la_data[$li_i]=array('nro'=>$li_i,'codigo'=>$ls_codconc,'nombre'=>$ls_nomcon,'partida'=>$ls_cueprepatcon,'personal'=>$li_totalpersonal,'asignacion'=>'','deduccion'=>'','aporte'=>$li_monto);
					break;
			}
			$li_i++;
			$rs_data->MoveNext();
		}
		//$io_report->DS->resetds("codconc");
		if ($la_data!="")
		{
			uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
		}
		else
		{
			print("<script language=JavaScript>");
			print(" alert('No hay nada que reportar!');"); 
			print(" close();");
			print("</script>");		
		}
		$li_totgeneral=$li_totasi-$li_totded;
		$li_totasi=$io_fun_nomina->uf_formatonumerico($li_totasi);
		$li_totded=$io_fun_nomina->uf_formatonumerico($li_totded);
		$li_totapo=$io_fun_nomina->uf_formatonumerico($li_totapo);
		$li_totgeneral=$io_fun_nomina->uf_formatonumerico($li_totgeneral);
		uf_print_piecabecera($li_totasi,$li_totded,$li_totapo,$li_totgeneral,$io_pdf); // Imprimimos el pie de la cabecera
		if($lb_valido) // Si no ocurrio ning�n error
		{
			$io_pdf->ezStopPageNumbers(1,1); // Detenemos la impresi�n de los n�meros de p�gina
			$io_pdf->ezStream(); // Mostramos el reporte
		}
		else  // Si hubo alg�n error
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
?> 