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

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo,$as_desnom,$as_periodo,$ai_tipo)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // Arreglo de las variables de seguridad
		//	    		   as_desnom // Arreglo de las variables de seguridad
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		
		$ls_codnom=$_SESSION["la_nomina"]["codnom"];
		$ls_descripcion="Gener� el Reporte ".$as_titulo.". Para ".$as_desnom.". ".$as_periodo;
		if($ai_tipo==1)
		{
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_recibopago.php",$ls_descripcion,$ls_codnom);
		}
		else
		{
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_hrecibopago.php",$ls_descripcion,$ls_codnom);
		}
		return $lb_valido;
	}
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina1($as_titulo,$as_desnom,$as_periodo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina1
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_desnom // Descripci�n de la n�mina
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(9,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,710,9,$as_periodo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(9,$as_desnom);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,720,9,$as_desnom); // Agregar el t�tulo
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina1
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina2($as_titulo,$as_desnom,$as_periodo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_desnom // Descripci�n de la n�mina
		//	    		   as_periodo // Descripci�n del per�odo
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,320,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,340,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(9,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,320,9,$as_periodo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(9,$as_desnom);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,330,9,$as_desnom); // Agregar el t�tulo
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera1($as_codper,$as_cedper,$as_nomper,$as_descar,$as_codcueban,$as_desuniadm,$ad_fecingper,$ai_sueper,
							    &$io_cabecera,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera1
		//		   Access: private 
		//	    Arguments: as_cedper // C�dula del personal
		//	    		   as_nomper // Nombre del personal
		//	    		   as_descar // Decripci�n del cargo
		//	    		   io_cabecera // objeto cabecera
		//	    		   io_pdf // Objeto PDF
		//    Description: funci�n que imprime la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
		$io_pdf->ezSetDy(-5);
		$la_data[1]=array('codigo'=>'C�digo',
						  'cedula'=>'C�dula',
						  'nombre'=>'Apellidos y Nombres', 
						  'fechaingreso'=>'Fecha Ingreso',
						  'cuenta'=>'Cta. Bancaria');
		$la_data[2]=array('codigo'=>$as_codper,
		                  'cedula'=>$as_cedper,
						  'nombre'=>$as_nomper,
						  'fechaingreso'=>$ad_fecingper,
						  'cuenta'=>$as_codcueban);
		$la_columna=array('codigo'=>'C�digo',
						  'cedula'=>'C�dula',
		                  'nombre'=>'Apellidos y Nombres', 
						  'fechaingreso'=>'Fecha Ingreso',
						  'cuenta'=>'Cta. Bancaria');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'xPos'=>315,
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5 ,
						 'cols'=>array('codigo'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'cedula'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>270), // Justificaci�n y ancho de la columna
						 			   'fechaingreso'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('cargo'=>'Cargo', 'departamento'=>'Departamento');
		$la_data[2]=array('cargo'=>$as_descar, 'departamento'=>$as_desuniadm);
		$la_columna=array('cargo'=>'','departamento'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'xPos'=>315,
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5 ,
						 'cols'=>array('cargo'=>array('justification'=>'left','width'=>275), // Justificaci�n y ancho de la columna
						 			   'departamento'=>array('justification'=>'left','width'=>275))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_columna=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xPos'=>315,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>210), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		$io_pdf->addText(45,654,'10','________________________________________________________________________________________________');
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_cabecera,'all');
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera2($as_codper,$as_cedper,$as_nomper,$as_descar,$as_codcueban,$as_desuniadm,$ad_fecingper,$ai_sueper,
								&$io_cabecera,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_cedper // C�dula del personal
		//	    		   as_nomper // Nombre del personal
		//	    		   as_descar // Decripci�n del cargo
		//	    		   io_cabecera // objeto cabecera
		//	    		   io_pdf // Objeto PDF
		//    Description: funci�n que imprime la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
		$io_pdf->ezSetDy(-137);
		$la_data[1]=array('codigo'=>'C�digo',
						  'cedula'=>'C�dula',
						  'nombre'=>'Apellidos y Nombres', 
						  'fechaingreso'=>'Fecha Ingreso',
						  'cuenta'=>'Cta. Bancaria');
		$la_data[2]=array('codigo'=>$as_codper,
		                  'cedula'=>$as_cedper,
						  'nombre'=>$as_nomper,
						  'fechaingreso'=>$ad_fecingper,
						  'cuenta'=>$as_codcueban);
		$la_columna=array('codigo'=>'C�digo',
						  'cedula'=>'C�dula',
		                  'nombre'=>'Apellidos y Nombres', 
						  'fechaingreso'=>'Fecha Ingreso',
						  'cuenta'=>'Cta. Bancaria');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'xPos'=>315,
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5 ,
						 'cols'=>array('codigo'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'cedula'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>270), // Justificaci�n y ancho de la columna
						 			   'fechaingreso'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('cargo'=>'Cargo', 'departamento'=>'Departamento');
		$la_data[2]=array('cargo'=>$as_descar, 'departamento'=>$as_desuniadm);
		$la_columna=array('cargo'=>'','departamento'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'xPos'=>315,
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5 ,
						 'cols'=>array('cargo'=>array('justification'=>'left','width'=>275), // Justificaci�n y ancho de la columna
						 			   'departamento'=>array('justification'=>'left','width'=>275))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_columna=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xPos'=>315,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>210), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		$io_pdf->addText(45,265,'10','________________________________________________________________________________________________');
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_cabecera,'all');
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xPos'=>315,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>210), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera1($ai_toting,$ai_totded,$ai_totnet,$as_codcueban,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_pie_cabecera1
		//		   Access: private 
		//	    Arguments: ai_toting // Total Ingresos
		//	   			   ai_totded // Total Deducciones
		//	   			   ai_totnet // Total Neto
		//	   			   as_codcueban // Codigo cuenta bancaria
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares, $io_monedabsf, $ls_tiporeporte;
		
		$io_piepagina=$io_pdf->openObject(); // Creamos el objeto pie de p�gina
		$io_pdf->saveState();
		$io_pdf->ezSety(480);
		$io_pdf->addText(320,475,'10','------------------------------------------------------------');
		$io_pdf->ezSety(480);
		$la_data[1]=array('codigo'=>'', 
		                  'denominacion'=>'', 
						  'asignacion'=>$ai_toting,
						  'deduccion'=>$ai_totded,
						  'aporte'=>'');
		$la_columna=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xPos'=>315,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>210), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->addText(320,462,'10','------------------------------------------------------------');
		$io_pdf->addText(320,460,'10','------------------------------------------------------------');
		$io_pdf->addText(50,464,'10','_________________________________');
		$la_data[1]=array('firma'=>'                    RECIBE CONFORME', 
		                  'blanco'=>'', 
						  'neto'=>'<b>Total a Cobrar '.$ls_bolivares.':</b>  '.$ai_totnet,
						  'blanco1'=>'');
		$la_columna=array('firma'=>'','blanco'=>'','neto'=>'','blanco1'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('firma'=>array('justification'=>'center','width'=>150),
						 			   'blanco'=>array('justification'=>'left','width'=>100), // Justificaci�n y ancho de la columna
						 			   'neto'=>array('justification'=>'right','width'=>200), // Justificaci�n y ancho de la columna
						 			   'blanco1'=>array('justification'=>'right','width'=>50))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_piepagina,'all');
		$io_pdf->stopObject($io_piepagina); // Detener el objeto pie de p�gina
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera2($ai_toting,$ai_totded,$ai_totnet,$as_codcueban,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_pie_cabecera
		//		   Access: private 
		//	    Arguments: ai_toting // Total Ingresos
		//	   			   ai_totded // Total Deducciones
		//	   			   ai_totnet // Total Neto
		//	   			   as_codcueban // Codigo cuenta bancaria
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 10/09/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares, $io_monedabsf, $ls_tiporeporte;
		
		$io_piepagina=$io_pdf->openObject(); // Creamos el objeto pie de p�gina
		$io_pdf->saveState();
		$io_pdf->addText(320,85,'10','------------------------------------------------------------');
		$io_pdf->ezSety(90);
		$la_data[1]=array('codigo'=>'', 
		                  'denominacion'=>'', 
						  'asignacion'=>$ai_toting,
						  'deduccion'=>$ai_totded,
						  'aporte'=>'');
		$la_columna=array('codigo'=>'<b>C�DIGO</b>', 
						  'denominacion'=>'<b>DENOMINACI�N</b>', 
						  'asignacion'=>'<b>ASIGNACI�N</b>',
						  'deduccion'=>'<b>DEDUCCI�N</b>',
						  'aporte'=>'<b>APORTE</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xPos'=>315,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>210), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>90), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>90))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->addText(320,72,'10','------------------------------------------------------------');
		$io_pdf->addText(320,70,'10','------------------------------------------------------------');
		$io_pdf->addText(50,74,'10','_________________________________');
		$la_data[1]=array('firma'=>'                    RECIBE CONFORME', 
		                  'blanco'=>'', 
						  'neto'=>'<b>Total a Cobrar '.$ls_bolivares.':</b>  '.$ai_totnet,
						  'blanco1'=>'');
		$la_columna=array('firma'=>'','blanco'=>'','neto'=>'','blanco1'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('firma'=>array('justification'=>'center','width'=>150),
						 			   'blanco'=>array('justification'=>'left','width'=>100), // Justificaci�n y ancho de la columna
						 			   'neto'=>array('justification'=>'right','width'=>200), // Justificaci�n y ancho de la columna
						 			   'blanco1'=>array('justification'=>'right','width'=>50))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_piepagina,'all');
		$io_pdf->stopObject($io_piepagina); // Detener el objeto pie de p�gina
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	$ls_tiporeporte="0";
	$ls_bolivares ="Bs.";
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
	require_once("../../shared/class_folder/sigesp_c_reconvertir_monedabsf.php");
	$io_monedabsf=new sigesp_c_reconvertir_monedabsf();				
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_desnom=$_SESSION["la_nomina"]["desnom"];
	$ls_peractnom=$_SESSION["la_nomina"]["peractnom"];
	$li_adelanto=$_SESSION["la_nomina"]["adenom"];
	$ld_fecdesper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fecdesper"]);
	$ld_fechasper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fechasper"]);
	$ls_titulo="<b>".$_SESSION["la_empresa"]["nombre"]."</b>";
	$ls_periodo="Periodo: <b>".$ls_peractnom."</b> del <b>".$ld_fecdesper."</b> al <b>".$ld_fechasper."</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codperdes=$io_fun_nomina->uf_obtenervalor_get("codperdes","");
	$ls_codperhas=$io_fun_nomina->uf_obtenervalor_get("codperhas","");
	$ls_coduniadm=$io_fun_nomina->uf_obtenervalor_get("coduniadm","");
	$ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
	$ls_conceptop2=$io_fun_nomina->uf_obtenervalor_get("conceptop2","");
	$ls_conceptoreporte=$io_fun_nomina->uf_obtenervalor_get("conceptoreporte","");
	$ls_tituloconcepto=$io_fun_nomina->uf_obtenervalor_get("tituloconcepto","");
	$ls_quincena=$io_fun_nomina->uf_obtenervalor_get("quincena","-");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_codubifis=$io_fun_nomina->uf_obtenervalor_get("codubifis","");
	$ls_codpai=$io_fun_nomina->uf_obtenervalor_get("codpai","");
	$ls_codest=$io_fun_nomina->uf_obtenervalor_get("codest","");
	$ls_codmun=$io_fun_nomina->uf_obtenervalor_get("codmun","");
	$ls_codpar=$io_fun_nomina->uf_obtenervalor_get("codpar","");
	$ls_subnomdes=$io_fun_nomina->uf_obtenervalor_get("subnomdes","");
	$ls_subnomhas=$io_fun_nomina->uf_obtenervalor_get("subnomhas","");
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo,$ls_desnom,$ls_periodo,$li_tipo); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_recibopago_personal($ls_codperdes,$ls_codperhas,$ls_coduniadm,$ls_conceptocero,$ls_conceptop2,
													  $ls_conceptoreporte,$ls_codubifis,$ls_codpai,$ls_codest,$ls_codmun,$ls_codpar,
													  $ls_subnomdes,$ls_subnomhas,$ls_orden); // Cargar el DS con los datos de la cabecera del reporte
	}
	if(($lb_valido==false) || ($io_report->rs_data->RecordCount()==0)) // Existe alg�n error � no hay registros
	{
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');"); 
		print(" close();");
		print("</script>");
	}
	else // Imprimimos el reporte
	{
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(3,1,1,2); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina1($ls_titulo,$ls_desnom,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
		uf_print_encabezado_pagina2($ls_titulo,$ls_desnom,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$li_totrow=$io_report->rs_data->RecordCount();
		$li_reg=1;
		$li_i=1;
		while((!$io_report->rs_data->EOF)&&($lb_valido))
		{
			$li_toting=0;
			$li_totded=0;
			$ls_codper=$io_report->rs_data->fields["codper"];
			$ls_cedper=$io_report->rs_data->fields["cedper"];
			$ls_nomper=$io_report->rs_data->fields["apeper"].", ".$io_report->rs_data->fields["nomper"];
			$ls_descar=$io_report->rs_data->fields["descar"];
			$ls_codcueban=$io_report->rs_data->fields["codcueban"];
			$ls_desuniadm=$io_report->rs_data->fields["desuniadm"];
			$ld_fecingper=$io_funciones->uf_convertirfecmostrar($io_report->rs_data->fields["fecingper"]);
			$li_sueper=number_format($io_report->rs_data->fields["sueper"],2,",",".");
			$ls_pagbanper=$io_report->rs_data->fields["pagbanper"];
			$ls_pagefeper=$io_report->rs_data->fields["pagefeper"];
			$li_total=$io_report->rs_data->fields["total"];
			$io_cabecera=$io_pdf->openObject(); // Creamos el objeto cabecera
			if($li_reg==1)
			{
				uf_print_cabecera1($ls_codper,$ls_cedper,$ls_nomper,$ls_descar,$ls_codcueban,$ls_desuniadm,$ld_fecingper,
								   $li_sueper,$io_cabecera,$io_pdf); // Imprimimos la cabecera del registro
			}
			else 
			{
				uf_print_cabecera2($ls_codper,$ls_cedper,$ls_nomper,$ls_descar,$ls_codcueban,$ls_desuniadm,$ld_fecingper,
								   $li_sueper,$io_cabecera,$io_pdf); // Imprimimos la cabecera del registro
			}

			$lb_valido=$io_report->uf_recibopago_conceptopersonal($ls_codper,$ls_conceptocero,$ls_conceptop2,
																  $ls_conceptoreporte,$ls_tituloconcepto,$ls_quincena); // Obtenemos el detalle del reporte
			if($lb_valido)
			{
				$li_totrow_det=$io_report->rs_data_detalle->RecordCount();
				$li_asig=0;
				$li_dedu=0;
				$li_apor=0;
				if($li_adelanto==1)// Utiliza el adelanto de quincena
				{
					switch($ls_quincena)
					{
						case "1": // primera quincena;
							$li_asig=$li_asig+1;
							$ls_codconc="----------";
							$ls_nomcon="ADELANTO 1ra QUINCENA";
							$li_valsal=round($li_total/2,2);
							$li_toting=$li_toting+$li_valsal;
							$li_valsal=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$la_data_a[$li_asig]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
							break;
							
						case "2": // segunda quincena;
							while(!$io_report->rs_data_detalle->EOF)
							{
								$ls_tipsal=rtrim($io_report->rs_data_detalle->fields["tipsal"]);
								if(($ls_tipsal=="A") || ($ls_tipsal=="V1") || ($ls_tipsal=="V2") || ($ls_tipsal=="R")) // Buscamos las asignaciones
								{
									$li_asig=$li_asig+1;
									$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
									$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
									if ($ls_tipsal!="R")
									{
										$li_toting=$li_toting+abs($io_report->rs_data_detalle->fields["valsal"]);
									}
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
									$la_data_a[$li_asig]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								if(($ls_tipsal=="D") || ($ls_tipsal=="V2") || ($ls_tipsal=="W2") ||
								   ($ls_tipsal=="P1") || ($ls_tipsal=="V3") || ($ls_tipsal=="W3") ) // Buscamos las deducciones
								{
									$li_dedu=$li_dedu+1;
									$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
									$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
									$li_totded=$li_totded+abs($io_report->rs_data_detalle->fields["valsal"]);
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
									$la_data_d[$li_dedu]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								if(($ls_tipsal=="P2") || ($ls_tipsal=="V4") || ($ls_tipsal=="W4") ) // Buscamos los aportes
								{
									$li_apor=$li_apor+1;
									$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
									$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];									
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
									$la_data_p[$li_apor]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								$io_report->rs_data_detalle->MoveNext();
							}
							$li_dedu=$li_dedu+1;
							$ls_codconc="----------";
							$ls_nomcon="ADELANTO 1ra QUINCENA";
							$li_valsal=round($li_total/2,2);
							$li_totded=$li_totded+$li_valsal;
							$li_valsal=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$la_data_d[$li_dedu]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
							break;
							
						case "3": // Mes Completo;
							while(!$io_report->rs_data_detalle->EOF)
							{
								$ls_tipsal=rtrim($io_report->rs_data_detalle->fields["tipsal"]);
								if(($ls_tipsal=="A") || ($ls_tipsal=="V1") || ($ls_tipsal=="V2") || ($ls_tipsal=="R")) // Buscamos las asignaciones
								{
									$li_asig=$li_asig+1;
									$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
									$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
									if ($ls_tipsal!="R")
									{
										$li_toting=$li_toting+abs($io_report->rs_data_detalle->fields["valsal"]);
									}
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
									$la_data_a[$li_asig]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								if(($ls_tipsal=="D") || ($ls_tipsal=="V2") || ($ls_tipsal=="W2") ||
								   ($ls_tipsal=="P1") || ($ls_tipsal=="V3") || ($ls_tipsal=="W3") ) // Buscamos las deducciones
								{
									$li_dedu=$li_dedu+1;
									$ls_codconc=$io_report->DS_detalle->data["codconc"][$li_s];
									$ls_nomcon=$io_report->DS_detalle->data["nomcon"][$li_s];
									$li_totded=$li_totded+abs($io_report->DS_detalle->data["valsal"][$li_s]);
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS_detalle->data["valsal"][$li_s]));
									$la_data_d[$li_dedu]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								if(($ls_tipsal=="P2") || ($ls_tipsal=="V4") || ($ls_tipsal=="W4") ) // Buscamos los aportes
								{
									$li_apor=$li_apor+1;
									$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
									$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
									$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
									$la_data_p[$li_apor]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
								}
								$io_report->rs_data_detalle->MoveNext();
							}
							break;
					}
				}
				else// No utiliza adelanto de quincena
				{
					while(!$io_report->rs_data_detalle->EOF)
					{
						$ls_tipsal=rtrim($io_report->rs_data_detalle->fields["tipsal"]);
						if(($ls_tipsal=="A") || ($ls_tipsal=="V1") || ($ls_tipsal=="V2") || ($ls_tipsal=="R")) // Buscamos las asignaciones
						{
							$li_asig=$li_asig+1;
							$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
							$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
							if ($ls_tipsal!="R")
							{
								$li_toting=$li_toting+abs($io_report->rs_data_detalle->fields["valsal"]);
							}
							$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
							$la_data_a[$li_asig]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
						}
						if(($ls_tipsal=="D") || ($ls_tipsal=="V2") || ($ls_tipsal=="W2") ||
						   ($ls_tipsal=="P1") || ($ls_tipsal=="V3") || ($ls_tipsal=="W3") ) // Buscamos las deducciones
						{
							$li_dedu=$li_dedu+1;
							$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
							$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
							$li_totded=$li_totded+abs($io_report->rs_data_detalle->fields["valsal"]);
							$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
							$la_data_d[$li_dedu]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
						}
						if(($ls_tipsal=="P2") || ($ls_tipsal=="V4") || ($ls_tipsal=="W4") ) // Buscamos los aportes
						{
							$li_apor=$li_apor+1;
							$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
							$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
							$li_valsal=$io_fun_nomina->uf_formatonumerico(abs($io_report->rs_data_detalle->fields["valsal"]));
							$la_data_p[$li_apor]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'valor'=>$li_valsal);
						}
						$io_report->rs_data_detalle->MoveNext();
					}
				}
				$li_count=0;
				for($li_s=1;$li_s<=$li_asig;$li_s++) 
				{
					$li_count++;
					$la_data[$li_count]=array('order'=>$la_data_a[$li_s]["codigo"],
											  'codigo'=>$la_data_a[$li_s]["codigo"], 
									          'denominacion'=>$la_data_a[$li_s]["denominacion"], 
									          'asignacion'=>$la_data_a[$li_s]["valor"],
									          'deduccion'=>'',
									          'aporte'=>'');
				}
				for($li_s=1;$li_s<=$li_dedu;$li_s++) 
				{
					$li_count++;
					$la_data[$li_count]=array('order'=>$la_data_d[$li_s]["codigo"]."0",
											  'codigo'=>$la_data_d[$li_s]["codigo"], 
									          'denominacion'=>$la_data_d[$li_s]["denominacion"], 
									          'asignacion'=>'',
									          'deduccion'=>$la_data_d[$li_s]["valor"],
									          'aporte'=>'');
				}
				for($li_s=1;$li_s<=$li_apor;$li_s++) 
				{
					$li_count++;
					$la_data[$li_count]=array('order'=>$la_data_p[$li_s]["codigo"]."2",
											  'codigo'=>$la_data_p[$li_s]["codigo"], 
									          'denominacion'=>$la_data_p[$li_s]["denominacion"], 
									          'asignacion'=>'',
									          'deduccion'=>'',
									          'aporte'=>$la_data_p[$li_s]["valor"]);
				}
				sort($la_data);
				uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
				$li_totnet=$li_toting-$li_totded;
				$li_toting=$io_fun_nomina->uf_formatonumerico($li_toting);
				$li_totded=$io_fun_nomina->uf_formatonumerico($li_totded);
				$li_totnet=$io_fun_nomina->uf_formatonumerico($li_totnet);
				if($li_reg==1)
				{
					uf_print_pie_cabecera1($li_toting,$li_totded,$li_totnet,$ls_codcueban,$io_pdf); // Imprimimos pie de la cabecera
				}
				else
				{
					uf_print_pie_cabecera2($li_toting,$li_totded,$li_totnet,$ls_codcueban,$io_pdf); // Imprimimos pie de la cabecera
				}
				unset($la_data_a);
				unset($la_data_d);
				unset($la_data_p);
				unset($la_data);
				$io_pdf->stopObject($io_cabecera); // Detener el objeto cabecera
				if(($li_i<$li_totrow)&&($li_reg==2))
				{
					$io_pdf->ezNewPage(); // Insertar una nueva p�gina
					$li_reg=1;
				}
				else
				{
					$li_reg=2;
				}
			}
			$li_i++;
			$io_report->rs_data->MoveNext();
		}
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