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
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo,$as_desnom,$as_rango2,$as_periodo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del reporte
		//	    		   as_desnom // descripci�n de la n�mina
		//	    		   as_periodo // per�odo actual de la n�mina
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		$ls_descripcion="Gener� el Reporte ".$as_titulo.". Para ".$as_desnom." ".$as_rango2.". ".$as_periodo;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte("SNR","sigesp_snorh_r_aportepatronal.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_desnom,$as_rango2,$as_periodo,&$io_pdf)
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
		// Fecha Creaci�n: 27/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,555,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,740,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(11,$as_desnom);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_desnom); // Agregar el t�tulo

		$li_tm=$io_pdf->getTextWidth(11,$as_rango2);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,720,11,$as_rango2); // Agregar el t�tulo



		$li_tm=$io_pdf->getTextWidth(11,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,710,11,$as_periodo); // Agregar el t�tulo
		$io_pdf->addText(512,750,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(518,743,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina
	//-----------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_codconc,$as_nomcon,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_codconc // C�digo de Concepto
		//	   			   as_nomcon // Nombre de Concepto
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime la cabecera por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_cabecera=$io_pdf->openObject();
		$io_pdf->saveState();
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(50,690,501.5,$io_pdf->getFontHeight(14));
        $io_pdf->setColor(0,0,0);
		$io_pdf->addText(55,695,11,'<b>Concepto</b>  '.$as_codconc.' - '.$as_nomcon.''); // Agregar el t�tulo
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
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSety(688);
		$la_columnas=array('nro'=>'<b>Nro</b>',
						   'cedula'=>'<b>C�dula</b>',
						   'nombre'=>'<b>            Apellidos y Nombres</b>',
						   'personal'=>'<b>Empleado     </b>',
						   'patron'=>'<b>Patr�n          </b>',
						   'total'=>'<b>Total          </b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('nro'=>array('justification'=>'center','width'=>30), // Justificaci�n y ancho de la columna
						 			   'cedula'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>160), // Justificaci�n y ancho de la columna
						 			   'personal'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'patron'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_piecabecera($ai_personal,$ai_patron,$ai_total,$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_piecabecera
		//		   Access: private 
		//	    Arguments: ai_personal // Total por personal
		//	   			   ai_patron // Total por patr�n
		//	   			   ai_total // Total 
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera por concepto
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		
		$la_data=array(array('name'=>'<b>Total Aporte '.$ls_bolivares.'</b>','personal'=>$ai_personal,'aporte'=>$ai_patron,'total'=>$ai_total));
		$la_columna=array('name'=>'','personal'=>'','aporte'=>'','total'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('name'=>array('justification'=>'right','width'=>260), // Justificaci�n y ancho de la columna
						 			   'personal'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
        $io_pdf->setColor(0,0,0);
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

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
	$ls_titulo="<b>Retenciones y Aportes Patronales</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codnomdes=$io_fun_nomina->uf_obtenervalor_get("codnomdes","");
	$ls_codnomhas=$io_fun_nomina->uf_obtenervalor_get("codnomhas","");
	$ls_codconc=$io_fun_nomina->uf_obtenervalor_get("codconc","");
	$ls_nomcon=$io_fun_nomina->uf_obtenervalor_get("nomcon","");
	$ls_anodes=$io_fun_nomina->uf_obtenervalor_get("anodes","");
	$ls_mesdes=$io_fun_nomina->uf_obtenervalor_get("mesdes","");
	$ls_anohas=$io_fun_nomina->uf_obtenervalor_get("anohas","");
	$ls_meshas=$io_fun_nomina->uf_obtenervalor_get("meshas","");
	$ls_perdes=$io_fun_nomina->uf_obtenervalor_get("perdes","");
	$ls_perhas=$io_fun_nomina->uf_obtenervalor_get("perhas","");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
	$ls_subnomdes=$io_fun_nomina->uf_obtenervalor_get("codsubnomdes","");
	$ls_subnomhas=$io_fun_nomina->uf_obtenervalor_get("codsubnomhas","");
	$ls_desnomdes=$io_report->uf_select_nombrenomina($ls_codnomdes);
	$ls_desnomhas=$io_report->uf_select_nombrenomina($ls_codnomhas);
	$ls_rango= "N�mina Desde: ".$ls_desnomdes;
	$ls_rango2=" N�mina Hasta: ".$ls_desnomhas;
	$ls_tiporeporte=$io_fun_nomina->uf_obtenervalor_get("tiporeporte",0);
	global $ls_tiporeporte;
	$ls_bolivares="Bs.";
	if($ls_tiporeporte==1)
	{
		require_once("sigesp_snorh_class_reportbsf.php");
		$io_report=new sigesp_snorh_class_reportbsf();
		$ls_bolivares="Bs.F.";
	}
	if($ls_anodes==$ls_anohas)
	{
		$ls_des_ano=$ls_anodes;
	}
	else
	{
		$ls_des_ano=$ls_anodes." al ".$ls_anohas;
	}
	if($ls_mesdes==$ls_meshas)
	{
		$ls_des_mes=$io_fecha->uf_load_nombre_mes($ls_mesdes);
	}
	else
	{
		$ls_des_mes=$io_fecha->uf_load_nombre_mes($ls_mesdes)." a ".$io_fecha->uf_load_nombre_mes($ls_meshas);
	}
	if($ls_perdes==$ls_perhas)
	{
		$ls_des_periodo=$ls_perdes;
	}
	else
	{
		$ls_des_periodo=$ls_perdes." al ".$ls_perhas;
	}
	
	$ls_periodo= "A�o: ".$ls_des_ano." Mes: ".$ls_des_mes." - Per�odo ".$ls_des_periodo;
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo,$ls_rango,$ls_rango2,$ls_periodo); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_aportepatronal_personal($ls_codnomdes,$ls_codnomhas,$ls_anodes,$ls_mesdes,$ls_anohas,$ls_meshas,
														  $ls_perdes,$ls_perhas,$ls_codconc,$ls_conceptocero,$ls_subnomdes,$ls_subnomhas,$ls_orden); // Cargar el DS con los datos del reporte
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
		$io_pdf->ezSetCmMargins(3.60,2.5,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$ls_rango,$ls_rango2,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		uf_print_cabecera($ls_codconc,$ls_nomcon,$io_pdf); // Imprimimos la cabecera del registro
		$li_totrow=$io_report->DS->getRowCount("cedper");
		$li_totper=0;
		$li_totpat=0;
		for($li_i=1;$li_i<=$li_totrow;$li_i++)
		{
			$ls_cedper=$io_report->DS->data["cedper"][$li_i];
			$ls_nomper=$io_report->DS->data["apeper"][$li_i].", ".$io_report->DS->data["nomper"][$li_i];
			$li_personal=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS->data["personal"][$li_i]));
			$li_patron=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS->data["patron"][$li_i]));
			$li_total=abs($io_report->DS->data["personal"][$li_i]+$io_report->DS->data["patron"][$li_i]);
			$li_total=$io_fun_nomina->uf_formatonumerico($li_total);
			$li_totper=$li_totper+abs($io_report->DS->data["personal"][$li_i]);
			$li_totpat=$li_totpat+abs($io_report->DS->data["patron"][$li_i]);
			$li_totalgeneral=$li_totper+$li_totpat;
			$la_data[$li_i]=array('nro'=>$li_i,'cedula'=>$ls_cedper,'nombre'=>$ls_nomper,'personal'=>$li_personal,'patron'=>$li_patron,'total'=>$li_total);
		}
		$io_report->DS->resetds("cedper");
		uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
		$li_totper=$io_fun_nomina->uf_formatonumerico($li_totper);
		$li_totpat=$io_fun_nomina->uf_formatonumerico($li_totpat);
		$li_totalgeneral=$io_fun_nomina->uf_formatonumerico($li_totalgeneral);
		uf_print_piecabecera($li_totper,$li_totpat,$li_totalgeneral,$io_pdf); // Imprimimos el fin del reporte
		if($lb_valido) // Si no ocurrio ning�n error
		{
			$io_pdf->ezStopPageNumbers(1,1); // Detenemos la impresi�n de los n�meros de p�gina
			$io_pdf->ezStream(); // Mostramos el reporte
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
?> 
