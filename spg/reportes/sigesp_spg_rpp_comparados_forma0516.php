<?php
    session_start();   
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "</script>";		
	}
  	ini_set('memory_limit','1024M');
	ini_set('max_execution_time ','0');
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		    Acess: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_periodo_comp // Descripci�n del periodo del comprobante
		//	    		   as_fecha_comp // Descripci�n del per�odo de la fecha del comprobante 
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(10,30,1000,30);
		
		$io_pdf->rectangle(10,480,985,110);
		$li_tm=$io_pdf->getTextWidth(16,$as_titulo);
		
		$li_tm=$io_pdf->getTextWidth(16,$as_titulo);
		$tm=505-($li_tm/2);
		$io_pdf->addText($tm,530,16,$as_titulo); // Agregar el t�tulo
		
		$io_pdf->addText(900,550,10,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(900,540,10,date("h:i a")); // Agregar la hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_titulo_reporte($ai_ano,$as_mes,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		    Acess: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_periodo_comp // Descripci�n del periodo del comprobante
		//	    		   as_fecha_comp // Descripci�n del per�odo de la fecha del comprobante 
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->ezSetY(515);
		$ls_codorgsig=$_SESSION["la_empresa"]["codorgsig"];
		$ls_nombre=$_SESSION["la_empresa"]["nombre"];
		$la_data=array(array('name'=>'<b>CODIGO DEL ENTE   </b> '.'<b>'.$ls_codorgsig.'</b>'),
		               array('name'=>'<b>DENOMINACI�N   </b>'.'<b>'.$ls_nombre.'</b>'));
		$la_columna=array('name'=>'','name'=>'','name'=>'');
		$la_config =array('showHeadings'=>0,     // Mostrar encabezados
						 'fontSize' => 8,       // Tama�o de Letras
						 'titleFontSize' => 8, // Tama�o de Letras de los t�tulos
						 'showLines'=>0,        // Mostrar L�neas
						 'shaded'=>0,           // Sombra entre l�neas
						 'xPos'=>264,//65
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>900, // Ancho de la tabla
						 'maxWidth'=>900,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>500),
									   'name'=>array('justification'=>'left','width'=>500)));
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_titulo(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_titulo
		//		   Access: private 
		//	    Arguments: as_codper // total de registros que va a tener el reporte
		//	    		   as_nomper // total de registros que va a tener el reporte
		//	    		   io_pdf // total de registros que va a tener el reporte
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
        $io_pdf->ezSetDy(-20);
		$la_data   =array(array('name1'=>'<b></b>','name2'=>'<b>PROGRAMADO</b>',
		                        'name3'=>'<b>EJECUTADO</b>','name4'=>'<b>VARIACION MES</b>',
								'name5'=>'<b>VARIACION ACUMULADA</b>','name6'=>'<b>REVISION PROXIMO MES</b>'));
		$la_columna=array('name1'=>'','name2'=>'','name3'=>'','name4'=>'','name5'=>'','name6'=>'');
		$la_config =array('showHeadings'=>0,     // Mostrar encabezados
						 'fontSize' => 7,       // Tama�o de Letras
						 'titleFontSize' => 7, // Tama�o de Letras de los t�tulos
						 'showLines'=>1,        // Mostrar L�neas
						 'shaded'=>0,           // Sombra entre l�neas
						 'xPos'=>509,
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>900, // Ancho de la tabla
						 'maxWidth'=>900,
						 'cols'=>array('name1'=>array('justification'=>'center','width'=>220),// Justificaci�n y ancho de la columna
						               'name2'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name3'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name4'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name5'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name6'=>array('justification'=>'center','width'=>85))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_titulo
	//--------------------------------------------------------------------------------------------------------------------------------	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_titulo_proyecto(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_titulo_proyecto
		//		   Access: private 
		//	    Arguments: io_pdf // total de registros que va a tener el reporte 
		//    Description: funci�n que imprime la cabecera del los proyectos 
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		//$io_pdf->ezSetY(500);
		$la_data   =array(array('name1'=>'<b>PROYECTO</b>','name2'=>'',
		                        'name3'=>'','name4'=>'',
								'name5'=>'','name6'=>''));
		$la_columna=array('name1'=>'','name2'=>'','name3'=>'','name4'=>'','name5'=>'','name6'=>'');
		$la_config =array('showHeadings'=>0,     // Mostrar encabezados
						 'fontSize' => 7,       // Tama�o de Letras
						 'titleFontSize' => 7, // Tama�o de Letras de los t�tulos
						 'showLines'=>1,        // Mostrar L�neas
						 'shaded'=>0,           // Sombra entre l�neas
						 'xPos'=>509,
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>900, // Ancho de la tabla
						 'maxWidth'=>900,
						 'cols'=>array('name1'=>array('justification'=>'center','width'=>220),// Justificaci�n y ancho de la columna
						               'name2'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name3'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name4'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name5'=>array('justification'=>'center','width'=>170),// Justificaci�n y ancho de la columna
									   'name6'=>array('justification'=>'center','width'=>85))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');

	}// end function uf_print_titulo
	//--------------------------------------------------------------------------------------------------------------------------------	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_etiqueta,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_codper // total de registros que va a tener el reporte
		//	    		   as_nomper // total de registros que va a tener el reporte
		//	    		   io_pdf // total de registros que va a tener el reporte
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		if($as_etiqueta=="Mensual")
		{
		   $ls_etiqueta="Mensual";
		}
		if($as_etiqueta=="Bi-Mensual")
		{
		   $ls_etiqueta="Bimestre";
		}
		if($as_etiqueta=="Trimestral")
		{
		   $ls_etiqueta="Trimestre";
		}
		if($as_etiqueta=="Semestral")
		{
		   $ls_etiqueta="Semestre";
		}
		$la_data=array(array('codigo'=>'<b>Codigo</b>','denominacion'=>'<b>Denominaci�n</b>','pres_anual'=>'<b>'.strtoupper($ls_etiqueta).'</b>',
		                     'prog_acum'=>'<b>Acumulado</b>','monto_eject'=>'<b>'.strtoupper($ls_etiqueta).'</b>','acum_eject'=>'<b>Acumulado</b>',
							 'varia_abs'=>'<b>Absoluta</b>','varia_porc'=>'<b>Porcentaje (%)</b>','varia_abs_acum'=>'<b>Absoluta</b>',
							 'varia_porc_acum'=>'<b>Pocentaje (%)</b>','reprog_prox_mes'=>''));
		$la_columna=array('codigo'=>'','denominacion'=>'','pres_anual'=>'','prog_acum'=>'','monto_eject'=>'','acum_eject'=>'',
		                  'varia_abs'=>'','varia_porc'=>'','varia_abs_acum'=>'','varia_porc_acum'=>'','reprog_prox_mes'=>'');
		$la_config=array('showHeadings'=>0,     // Mostrar encabezados
						 'fontSize' => 7,       // Tama�o de Letras
						 'titleFontSize' => 7, // Tama�o de Letras de los t�tulos
						 'showLines'=>2,        // Mostrar L�neas
						 'shaded'=>0,           // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990,
						 'colGap'=>0,
						 //'xPos'=>520,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'center','width'=>150), // Justificaci�n y ancho de la columna
						 			   'pres_anual'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'center','width'=>85))); // Justificaci�n y ancho de la columna
	$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	$io_pdf->restoreState();
	$io_pdf->closeObject();
	$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_proyectos($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_proyectos
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>0, // separacion entre tablas
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 //'xPos'=>520,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>150), // Justificaci�n y ancho de la columna
						 			   'pres_anual'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'right','width'=>85))); // Justificaci�n y ancho de la columna
		
		$la_columnas=array('codigo'=>'<b></b>',
						   'denominacion'=>'<b></b>',
						   'pres_anual'=>'<b></b>',
						   'prog_acum'=>'<b></b>',
						   'monto_eject'=>'<b></b>',
						   'acum_eject'=>'<b></b>',
						   'varia_abs'=>'<b></b>',
						   'varia_porc'=>'<b></b>',
						   'varia_abs_acum'=>'<b></b>',
						   'varia_porc_acum'=>'<b></b>',
						   'reprog_prox_mes'=>'<b></b>');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_acciones($la_data_a,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>0, // separacion entre tablas
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 //'xPos'=>520,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>150), // Justificaci�n y ancho de la columna
						 			   'pres_anual'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'right','width'=>85))); // Justificaci�n y ancho de la columna
		
		$la_columnas=array('codigo'=>'<b></b>',
						   'denominacion'=>'<b></b>',
						   'pres_anual'=>'<b></b>',
						   'prog_acum'=>'<b></b>',
						   'monto_eject'=>'<b></b>',
						   'acum_eject'=>'<b></b>',
						   'varia_abs'=>'<b></b>',
						   'varia_porc'=>'<b></b>',
						   'varia_abs_acum'=>'<b></b>',
						   'varia_porc_acum'=>'<b></b>',
						   'reprog_prox_mes'=>'<b></b>');
		$io_pdf->ezTable($la_data_a,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera_proyecto($la_data_totales,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera_proyecto
		//		    Acess : private 
		//	    Arguments : ad_total // Total General
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>0, // separacion entre tablas
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('total'=>array('justification'=>'right','width'=>220), // Justificaci�n y ancho de la columna
									   'pres_anual'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'right','width'=>85))); // Justificaci�n y ancho de la columna
		
		$la_columnas=array('total'=>'',
		                   'pres_anual'=>'',
						   'prog_acum'=>'',
						   'monto_eject'=>'',
						   'acum_eject'=>'',
						   'varia_abs'=>'',
						   'varia_porc'=>'',
						   'varia_abs_acum'=>'',
						   'varia_porc_acum'=>'',
						   'reprog_prox_mes'=>'');
		$io_pdf->ezTable($la_data_totales,$la_columnas,'',$la_config);
	}// end function uf_print_pie_cabecera_proyecto
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera_acciones($la_data_tot_a,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera_acciones
		//		    Acess : private 
		//	    Arguments : ad_total // Total General
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>0, // separacion entre tablas
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('total'=>array('justification'=>'right','width'=>220), // Justificaci�n y ancho de la columna
									   'pres_anual'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'right','width'=>85))); // Justificaci�n y ancho de la columna
		
		$la_columnas=array('total'=>'',
		                   'pres_anual'=>'',
						   'prog_acum'=>'',
						   'monto_eject'=>'',
						   'acum_eject'=>'',
						   'varia_abs'=>'',
						   'varia_porc'=>'',
						   'varia_abs_acum'=>'',
						   'varia_porc_acum'=>'',
						   'reprog_prox_mes'=>'');
		$io_pdf->ezTable($la_data_tot_a,$la_columnas,'',$la_config);
	}// end function uf_print_pie_cabecera_acciones
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera($la_data_tot,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera
		//		    Acess : private 
		//	    Arguments : ad_total // Total General
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por: Ing. Yozelin Barrag�n
		// Fecha Creaci�n: 19/10/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>0, // separacion entre tablas
						 'width'=>990, // Ancho de la tabla
						 'maxWidth'=>990, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('total'=>array('justification'=>'right','width'=>220), // Justificaci�n y ancho de la columna
									   'pres_anual'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
						 			   'prog_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'monto_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'acum_eject'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_abs_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'varia_porc_acum'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
									   'reprog_prox_mes'=>array('justification'=>'right','width'=>85))); // Justificaci�n y ancho de la columna
		
		$la_columnas=array('total'=>'',
		                   'pres_anual'=>'',
						   'prog_acum'=>'',
						   'monto_eject'=>'',
						   'acum_eject'=>'',
						   'varia_abs'=>'',
						   'varia_porc'=>'',
						   'varia_abs_acum'=>'',
						   'varia_porc_acum'=>'',
						   'reprog_prox_mes'=>'');
		$io_pdf->ezTable($la_data_tot,$la_columnas,'',$la_config);
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------
		require_once("../../shared/ezpdf/class.ezpdf.php");
		require_once("sigesp_spg_reporte_comparados_forma05.php");
		$io_report = new sigesp_spg_reporte_comparados_forma05();
		require_once("../../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();		
		require_once("sigesp_spg_funciones_reportes.php");
		$io_function_report = new sigesp_spg_funciones_reportes();
		require_once("../../shared/class_folder/class_fecha.php");
		$io_fecha = new class_fecha();
		$ls_tipoformato=$_GET["tipoformato"];
	//-----------------------------------------------------------------------------------------------------------------------------
		global $ls_tipoformato;
		global $ld_total_porc_comprometer;
		global $ld_total_porc_causado;	
		global $la_data_totales_bsf;
		if($ls_tipoformato==1)
		{
			require_once("sigesp_spg_reporte_comparados_forma05_bsf.php");
			$io_report = new sigesp_spg_reporte_comparados_forma05_bsf();
		}
		else
		{
			require_once("sigesp_spg_reporte_comparados_forma05.php");
			$io_report = new sigesp_spg_reporte_comparados_forma05();
		}	
		 require_once("../../shared/class_folder/sigesp_c_reconvertir_monedabsf.php");
		 $io_rcbsf= new sigesp_c_reconvertir_monedabsf();
		 $li_candeccon=$_SESSION["la_empresa"]["candeccon"];
		 $li_tipconmon=$_SESSION["la_empresa"]["tipconmon"];
		 $li_redconmon=$_SESSION["la_empresa"]["redconmon"];
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
		$ldt_periodo=$_SESSION["la_empresa"]["periodo"];
		$li_ano=substr($ldt_periodo,0,4);
		$li_estmodest=$_SESSION["la_empresa"]["estmodest"];
		$ls_codestpro1_min  = $_GET["codestpro1"];
		$ls_codestpro2_min  = $_GET["codestpro2"];
		$ls_codestpro3_min  = $_GET["codestpro3"];
		$ls_codestpro1h_max = $_GET["codestpro1h"];
		$ls_codestpro2h_max = $_GET["codestpro2h"];
		$ls_codestpro3h_max = $_GET["codestpro3h"];
	    $ls_estclades       = $_GET["estclades"];
	    $ls_estclahas       = $_GET["estclahas"];
		if($li_estmodest==1)
		{
			$ls_codestpro4_min  = "0000000000000000000000000";
			$ls_codestpro5_min  = "0000000000000000000000000";
			$ls_codestpro4h_max = "0000000000000000000000000";
			$ls_codestpro5h_max = "0000000000000000000000000";
			if(($ls_codestpro1_min=="")&&($ls_codestpro2_min=="")&&($ls_codestpro3_min==""))
			{
			  if($io_function_report->uf_spg_reporte_select_min_programatica($ls_codestpro1_min,$ls_codestpro2_min,
			                                                                 $ls_codestpro3_min,$ls_codestpro4_min,
			                                                                 $ls_codestpro5_min,$ls_estclades))
			  {
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			  }
			}
			else
			{
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			}
			if(($ls_codestpro1h_max=="")&&($ls_codestpro2h_max=="")&&($ls_codestpro3h_max==""))
			{
			  if($io_function_report->uf_spg_reporte_select_max_programatica($ls_codestpro1h_max,$ls_codestpro2h_max,
																			 $ls_codestpro3h_max,$ls_codestpro4h_max,
																			 $ls_codestpro4h_max,$ls_estclahas))
			  {
					$ls_codestpro1h  = $ls_codestpro1h_max;
					$ls_codestpro2h  = $ls_codestpro2h_max;
					$ls_codestpro3h  = $ls_codestpro3h_max;
					$ls_codestpro4h  = $ls_codestpro4h_max;
					$ls_codestpro5h  = $ls_codestpro5h_max;
			  }
			}
			else
			{
					$ls_codestpro1h  = $ls_codestpro1h_max;
					$ls_codestpro2h  = $ls_codestpro2h_max;
					$ls_codestpro3h  = $ls_codestpro3h_max;
					$ls_codestpro4h  = $ls_codestpro4h_max;
					$ls_codestpro5h  = $ls_codestpro5h_max;
			}
		}
		elseif($li_estmodest==2)
		{
			$ls_codestpro4_min = $_GET["codestpro4"];
			$ls_codestpro5_min = $_GET["codestpro5"];
			$ls_codestpro4h_max = $_GET["codestpro4h"];
			$ls_codestpro5h_max = $_GET["codestpro5h"];
			
			
			if(($ls_codestpro1_min=='**') ||($ls_codestpro1_min==''))
			{
				$ls_codestpro1_min='';
			}
			else
			{
			    $ls_codestpro1_min  = $io_funciones->uf_cerosizquierda($ls_codestpro1_min,25);
			}
			if(($ls_codestpro2_min=='**') ||($ls_codestpro2_min==''))
			{
				$ls_codestpro2_min='';
			}
			else
			{
				$ls_codestpro2_min  = $io_funciones->uf_cerosizquierda($ls_codestpro2_min,25);
			
			}
			if(($ls_codestpro3_min=='**')||($ls_codestpro3_min==''))
			{
				$ls_codestpro3_min='';
			}
			else
			{
			
				$ls_codestpro3_min  = $io_funciones->uf_cerosizquierda($ls_codestpro3_min,25);
			}
			if(($ls_codestpro4_min=='**') ||($ls_codestpro4_min==''))
			{
				$ls_codestpro4_min='';
			}
			else
			{
				$ls_codestpro4_min  = $io_funciones->uf_cerosizquierda($ls_codestpro4_min,25);
	
			
			}
			if(($ls_codestpro5_min=='**') ||($ls_codestpro5_min==''))
			{
				$ls_codestpro5_min='';
			}else
			{
					$ls_codestpro5_min  = $io_funciones->uf_cerosizquierda($ls_codestpro5_min,25);
			}
			
			
			if(($ls_codestpro1h_max=='**')||($ls_codestpro1h_max==''))
			{
				$ls_codestpro1h_max='';
			}
			else
			{
				$ls_codestpro1h_max  = $io_funciones->uf_cerosizquierda($ls_codestpro1h_max,25);
			}
			if(($ls_codestpro2h_max=='**') ||($ls_codestpro2h_max==''))
			{
				$ls_codestpro2h_max='';
			}else
			{
				$ls_codestpro2h_max  = $io_funciones->uf_cerosizquierda($ls_codestpro2h_max,25);
			}
			if(($ls_codestpro3h_max=='**') ||($ls_codestpro3h_max==''))
			{
				$ls_codestpro3h_max='';
			}else
			{
				$ls_codestpro3h_max  = $io_funciones->uf_cerosizquierda($ls_codestpro3h_max,25);
			}
			if(($ls_codestpro4h_max=='**')  ||($ls_codestpro4h_max==''))
			{
				$ls_codestpro4h_max='';
			}else
			{
				$ls_codestpro4h_max  = $io_funciones->uf_cerosizquierda($ls_codestpro4h_max,25);
			}
			if(($ls_codestpro5h_max=='**')  || ($ls_codestpro5h_max==''))
			{
				$ls_codestpro5h_max='';
			}else
			{
				$ls_codestpro5h_max  = $io_funciones->uf_cerosizquierda($ls_codestpro5h_max,25);
			}
			
			if(($ls_codestpro1_min=="")||($ls_codestpro2_min=="")||($ls_codestpro3_min=="")||($ls_codestpro4_min=="")||
			   ($ls_codestpro5_min==""))
			{
			  if($io_function_report->uf_spg_reporte_select_min_programatica($ls_codestpro1_min,$ls_codestpro2_min,$ls_codestpro3_min,
			                                                                 $ls_codestpro4_min,$ls_codestpro5_min,$ls_estclades))
			  {
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			  }
			}
			else
			{
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			}
			if(($ls_codestpro1h_max=="")||($ls_codestpro2h_max=="")||($ls_codestpro3h_max=="")||($ls_codestpro4h_max=="")||
			   ($ls_codestpro5h_max==""))
			{
			  if($io_function_report->uf_spg_reporte_select_max_programatica($ls_codestpro1h_max,$ls_codestpro2h_max,
																			 $ls_codestpro3h_max,$ls_codestpro4h_max,
																			 $ls_codestpro5h_max,$ls_estclahas))
			  {
				$ls_codestpro1h  = $ls_codestpro1h_max;
				$ls_codestpro2h  = $ls_codestpro2h_max;
				$ls_codestpro3h  = $ls_codestpro3h_max;
				$ls_codestpro4h  = $ls_codestpro4h_max;
				$ls_codestpro5h  = $ls_codestpro5h_max;
			  }
			}
			else
			{
				$ls_codestpro1h  = $ls_codestpro1h_max;
				$ls_codestpro2h  = $ls_codestpro2h_max;
				$ls_codestpro3h  = $ls_codestpro3h_max;
				$ls_codestpro4h  = $ls_codestpro4h_max;
				$ls_codestpro5h  = $ls_codestpro5h_max;
			}
		}	
		$ls_codestpro1  = $io_funciones->uf_cerosizquierda($ls_codestpro1_min,25);
		$ls_codestpro2  = $io_funciones->uf_cerosizquierda($ls_codestpro2_min,25);
		$ls_codestpro3  = $io_funciones->uf_cerosizquierda($ls_codestpro3_min,25);
		$ls_codestpro4  = $io_funciones->uf_cerosizquierda($ls_codestpro4_min,25);
		$ls_codestpro5  = $io_funciones->uf_cerosizquierda($ls_codestpro5_min,25);
		
		$ls_codestpro1h  = $io_funciones->uf_cerosizquierda($ls_codestpro1h_max,25);
		$ls_codestpro2h  = $io_funciones->uf_cerosizquierda($ls_codestpro2h_max,25);
		$ls_codestpro3h  = $io_funciones->uf_cerosizquierda($ls_codestpro3h_max,25);
		$ls_codestpro4h  = $io_funciones->uf_cerosizquierda($ls_codestpro4h_max,25);
		$ls_codestpro5h  = $io_funciones->uf_cerosizquierda($ls_codestpro5h_max,25);
		
		$ls_cmbmes=$_GET["cmbmes"];
		$li_mes=substr($ls_cmbmes,0,2);
		$ldt_fecdes=$li_ano."-".$li_mes."-01";
		$ldt_ult_dia=$io_fecha->uf_last_day($li_mes,$li_ano);
		$fechas=$ldt_ult_dia;
		$ldt_fechas=$io_funciones->uf_convertirdatetobd($fechas);
		$ls_mes=$io_fecha->uf_load_nombre_mes($li_mes);
	    $ls_codfuefindes=$_GET["txtcodfuefindes"];
	    $ls_codfuefinhas=$_GET["txtcodfuefinhas"];
		if (($ls_codfuefindes=='')&&($ls_codfuefindes==''))
		{
		   if($io_function_report->uf_spg_select_fuentefinanciamiento(&$ls_minfuefin,&$ls_maxfuefin))
		   {
		     $ls_codfuefindes=$ls_minfuefin;
		     $ls_codfuefinhas=$ls_maxfuefin;
		   } 
		}
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
		$ls_titulo="<b>EJECUCI�N FINANCIERA DE LOS PROYECTOS DEL ENTE (FORMA 0516)</b>";  
	//--------------------------------------------------------------------------------------------------------------------------------
    // Cargar el dts_cab con los datos de la cabecera del reporte( Selecciono todos comprobantes )	
     $lb_valido_proyectos=$io_report->uf_spg_reportes_comparados_forma0516_proyectos($ls_codestpro1,$ls_codestpro2,
	                                                                                 $ls_codestpro3,$ls_codestpro4,
																				     $ls_codestpro5,$ls_codestpro1h,
																	  			     $ls_codestpro2h,$ls_codestpro3h,
																	                 $ls_codestpro4h,$ls_codestpro5h,
																				     $ldt_fecdes,$ldt_fechas,$ls_codfuefindes,
																					 $ls_codfuefinhas,$ls_estclades,$ls_estclahas);
	 if($lb_valido_proyectos==false) // Existe alg�n error � no hay registros
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
		$io_pdf=new Cezpdf('LEGAL','landscape'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(6.6,3,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$io_pdf); // Imprimimos el encabezado de la p�gina
 	    $io_pdf->ezStartPageNumbers(980,40,10,'','',1); // Insertar el n�mero de p�gina
		$ld_total_pres_anual=0;
		$ld_total_programada_acumulado=0;
		$ld_total_monto_ejecutado=0;
		$ld_total_ejecutado_acumulado=0;
		$ld_total_variacion_absoluta=0;
		$ld_total_porcentaje_variacion=0;
		$ld_total_variacion_abs_acum=0;
		$ld_total_porcentaje_variacion_acum=0;
		$ld_total_reprog_prox_mes=0;
		$li_total=$io_report->dts_reporte->getRowCount("asignado");
		$ls_loncodestpro1 = $_SESSION["la_empresa"]["loncodestpro1"];
		$ls_loncodestpro2 = $_SESSION["la_empresa"]["loncodestpro2"];
		$ls_loncodestpro3 = $_SESSION["la_empresa"]["loncodestpro3"];
		$ls_loncodestpro4 = $_SESSION["la_empresa"]["loncodestpro4"];
		$ls_loncodestpro5 = $_SESSION["la_empresa"]["loncodestpro5"];
		for($z=1;$z<=$li_total;$z++)
		{
			$thisPageNum=$io_pdf->ezPageCount;
			$ld_asignado=$io_report->dts_reporte->data["asignado"][$z];
			$ld_monto_programado=$io_report->dts_reporte->data["monto_programado"][$z];
			$ld_monto_acumulado=$io_report->dts_reporte->data["monto_acumulado"][$z];
			$ld_aumdismes=$io_report->dts_reporte->data["aumdis_mes"][$z];
			$ld_aumdisacum=$io_report->dts_reporte->data["aumdis_acumulado"][$z];
			$ld_monto_ejecutado=$io_report->dts_reporte->data["ejecutado_mes"][$z];
			$ld_ejecutado_acumulado=$io_report->dts_reporte->data["ejecutado_acum"][$z];
			$ld_reprog_prox_mes=$io_report->dts_reporte->data["reprog_prox_mes"][$z];
			$ld_comprometer=$io_report->dts_reporte->data["compromiso"][$z];
			$ld_causado=$io_report->dts_reporte->data["causado"][$z];
			$ld_pagado=$io_report->dts_reporte->data["pagado"][$z];
			$ld_compr_t_ant=$io_report->dts_reporte->data["compr_t_ant"][$z];
			$ld_prog_t_ant=$io_report->dts_reporte->data["prog_t_ant"][$z];
			$ls_programatica=$io_report->dts_reporte->data["programatica"][$z];
		    $ls_estcla=substr($ls_programatica,-1);
		    $ls_codestpro1=substr($ls_programatica,0,25);
		    $ls_denestpro1="";
		    $lb_valido=$io_function_report->uf_spg_reporte_select_denestpro1($ls_codestpro1,$ls_denestpro1,$ls_estcla);
		    if($lb_valido)
		    {
			  $ls_denestpro1=$ls_denestpro1;
		    }
		    $ls_codestpro2=substr($ls_programatica,25,25);
		    if($lb_valido)
		    {
			  $ls_denestpro2="";
			  $lb_valido=$io_function_report->uf_spg_reporte_select_denestpro2($ls_codestpro1,$ls_codestpro2,$ls_denestpro2,$ls_estcla);
			  $ls_denestpro2=$ls_denestpro2;
		    }
		    $ls_codestpro3=substr($ls_programatica,50,25);
		    if($lb_valido)
		    {
			  $ls_denestpro3="";
			  $lb_valido=$io_function_report->uf_spg_reporte_select_denestpro3($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_denestpro3,$ls_estcla);
			  $ls_denestpro3=$ls_denestpro3;
		    }
			$ls_denestpro=$ls_denestpro1;//." , ".$ls_denestpro2." , ".$ls_denestpro3;
			if($li_estmodest==2)
			{
				$ls_codestpro4=substr($ls_programatica,75,25);
				if($lb_valido)
				{
				  $ls_denestpro4="";
				  $lb_valido=$io_function_report->uf_spg_reporte_select_denestpro4($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_denestpro4,$ls_estcla);
				  $ls_denestpro4=trim($ls_denestpro4);
				}
				$ls_codestpro5=substr($ls_programatica,100,25);
				if($lb_valido)
				{
				  $ls_denestpro5="";
				  $lb_valido=$io_function_report->uf_spg_reporte_select_denestpro5($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_codestpro5,$ls_denestpro5,$ls_estcla);
				  $ls_denestpro5=trim($ls_denestpro5);
				}
			    //$ls_denestpro=trim($ls_denestpro1)." , ".trim($ls_denestpro2)." , ".trim($ls_denestpro3)." , ".trim($ls_denestpro4)." , ".trim($ls_denestpro5);
			    $ls_programatica=substr($ls_codestpro1,-$ls_loncodestpro1)."-".substr($ls_codestpro2,-$ls_loncodestpro2)."-".substr($ls_codestpro3,-$ls_loncodestpro3)."-".substr($ls_codestpro4,-$ls_loncodestpro4)."-".substr($ls_codestpro5,-$ls_loncodestpro5);
			}
			else
			{
			    //$ls_denestpro=trim($ls_denestpro1)." , ".trim($ls_denestpro2)." , ".trim($ls_denestpro3);
				$ls_programatica=substr($ls_codestpro1,-$ls_loncodestpro1)."-".substr($ls_codestpro2,-$ls_loncodestpro2)."-".substr($ls_codestpro3,-$ls_loncodestpro3);
			}
			$ld_pres_anual=$ld_monto_programado+$ld_aumdismes;  //programado de los meses
			$ld_programada_acumulado=$ld_monto_acumulado+$ld_aumdisacum;	//acumulado programado de los meses  
			$ld_monto_ejecutado=$ld_monto_ejecutado;   // monto ejecutado de los meses 
			$ld_ejecutado_acumulado=$ld_ejecutado_acumulado; // monto ejecutado acumulado de los meses 
			
			if($ld_pres_anual>$ld_monto_ejecutado)
			{
			   $ld_variacion_absoluta=0-($ld_pres_anual-$ld_monto_ejecutado); //variacion absoluta  del monto ejecutado
			}
			else
			{
			   if($ld_pres_anual==0){ $ld_variacion_absoluta=$ld_monto_ejecutado; } 
			   else { $ld_variacion_absoluta=$ld_pres_anual-$ld_monto_ejecutado;  }
			}
			//variacion porcentual  del monto ejecutado
			if($ld_pres_anual>0){ $ld_porcentaje_variacion=(($ld_pres_anual-$ld_monto_ejecutado)/$ld_pres_anual)*100; }
			else{ $ld_porcentaje_variacion=0; }
			if($ld_programada_acumulado==0)
			{
  			   $ld_varia_acum=$ld_ejecutado_acumulado;
			}
			else
			{
  			   $ld_varia_acum=$ld_programada_acumulado-$ld_ejecutado_acumulado;
			}
			//variacion absoluta  del monto acumulado
			if($ld_programada_acumulado>$ld_ejecutado_acumulado)
			{
			   $ld_variacion_abs_acum=0-($ld_varia_acum);
			}
			else
			{
			   $ld_variacion_abs_acum=$ld_varia_acum;
			}
			//variacion porcentual del monto acumulado
			if($ld_programada_acumulado>0)
			{ 
			  $ld_porcentaje_variacion_acum=(($ld_programada_acumulado-$ld_ejecutado_acumulado)/$ld_programada_acumulado)*100; 
			}
			else
			{ 
			  $ld_porcentaje_variacion_acum=0; 
			}
			$ld_reprog_prox_mes=$ld_reprog_prox_mes;

			$ld_total_pres_anual=$ld_total_pres_anual+$ld_pres_anual;
			$ld_total_programada_acumulado=$ld_total_programada_acumulado+$ld_programada_acumulado;
			$ld_total_monto_ejecutado=$ld_total_monto_ejecutado+$ld_monto_ejecutado;
			$ld_total_ejecutado_acumulado=$ld_total_ejecutado_acumulado+$ld_ejecutado_acumulado;
			$ld_total_variacion_absoluta=$ld_total_variacion_absoluta+$ld_variacion_absoluta;
			$ld_total_porcentaje_variacion=$ld_total_porcentaje_variacion+$ld_porcentaje_variacion;
			$ld_total_variacion_abs_acum=$ld_total_variacion_abs_acum+$ld_variacion_abs_acum;
			$ld_total_porcentaje_variacion_acum=$ld_total_porcentaje_variacion_acum+$ld_porcentaje_variacion_acum;
			$ld_total_reprog_prox_mes=$ld_total_reprog_prox_mes+$ld_reprog_prox_mes;

			$ld_pres_anual=number_format($ld_pres_anual,2,",",".");
			$ld_programada_acumulado=number_format($ld_programada_acumulado,2,",",".");
			$ld_monto_ejecutado=number_format($ld_monto_ejecutado,2,",",".");
			$ld_ejecutado_acumulado=number_format($ld_ejecutado_acumulado,2,",",".");
			$ld_variacion_absoluta=number_format($ld_variacion_absoluta,2,",",".");
			$ld_porcentaje_variacion=number_format($ld_porcentaje_variacion,2,",",".");
			$ld_variacion_abs_acum=number_format($ld_variacion_abs_acum,2,",",".");
			$ld_porcentaje_variacion_acum=number_format($ld_porcentaje_variacion_acum,2,",",".");
			$ld_reprog_prox_mes=number_format($ld_reprog_prox_mes,2,",",".");
			
			$la_data[$z]=array('codigo'=>$ls_programatica,'denominacion'=>$ls_denestpro,'pres_anual'=>$ld_pres_anual,
							   'prog_acum'=>$ld_programada_acumulado,'monto_eject'=>$ld_monto_ejecutado,
							   'acum_eject'=>$ld_ejecutado_acumulado,'varia_abs'=>$ld_variacion_absoluta,
							   'varia_porc'=>$ld_porcentaje_variacion,'varia_abs_acum'=>$ld_variacion_abs_acum,
							   'varia_porc_acum'=>$ld_porcentaje_variacion_acum,'reprog_prox_mes'=>$ld_reprog_prox_mes);
								  
			$ld_pres_anual=str_replace('.','',$ld_pres_anual);
			$ld_pres_anual=str_replace(',','.',$ld_pres_anual);		
			$ld_programada_acumulado=str_replace('.','',$ld_programada_acumulado);
			$ld_programada_acumulado=str_replace(',','.',$ld_programada_acumulado);		
			$ld_monto_ejecutado=str_replace('.','',$ld_monto_ejecutado);
	  	    $ld_monto_ejecutado=str_replace(',','.',$ld_monto_ejecutado);		
			$ld_ejecutado_acumulado=str_replace('.','',$ld_ejecutado_acumulado);
			$ld_ejecutado_acumulado=str_replace(',','.',$ld_ejecutado_acumulado);
			$ld_variacion_absoluta=str_replace('.','',$ld_variacion_absoluta);
		    $ld_variacion_absoluta=str_replace(',','.',$ld_variacion_absoluta);
			$ld_porcentaje_variacion=str_replace('.','',$ld_porcentaje_variacion);
			$ld_porcentaje_variacion=str_replace(',','.',$ld_porcentaje_variacion);		
			$ld_variacion_abs_acum=str_replace('.','',$ld_variacion_abs_acum);
			$ld_variacion_abs_acum=str_replace(',','.',$ld_variacion_abs_acum);	
			$ld_porcentaje_variacion_acum=str_replace('.','',$ld_porcentaje_variacion_acum);
			$ld_porcentaje_variacion_acum=str_replace(',','.',$ld_porcentaje_variacion_acum);		
			$ld_reprog_prox_mes=str_replace('.','',$ld_reprog_prox_mes);
			$ld_reprog_prox_mes=str_replace(',','.',$ld_reprog_prox_mes);		
			
			if($z==$li_total)
			{
				 $ld_total_pres_anual=number_format($ld_total_pres_anual,2,",",".");
				 $ld_total_programada_acumulado=number_format($ld_total_programada_acumulado,2,",",".");
				 $ld_total_monto_ejecutado=number_format($ld_total_monto_ejecutado,2,",",".");
				 $ld_total_ejecutado_acumulado=number_format($ld_total_ejecutado_acumulado,2,",",".");
				 $ld_total_variacion_absoluta=number_format($ld_total_variacion_absoluta,2,",",".");
				 $ld_total_porcentaje_variacion=number_format($ld_total_porcentaje_variacion,2,",",".");
				 $ld_total_variacion_abs_acum=number_format($ld_total_variacion_abs_acum,2,",",".");
				 $ld_total_porcentaje_variacion_acum=number_format($ld_total_porcentaje_variacion_acum,2,",",".");
				 $ld_total_reprog_prox_mes=number_format($ld_total_reprog_prox_mes,2,",",".");
				 
				 $la_data_tot[$z]=array('total'=>'<b>SUB-TOTALES</b>','pres_anual'=>$ld_total_pres_anual,'prog_acum'=>$ld_total_programada_acumulado,
										'monto_eject'=>$ld_total_monto_ejecutado,'acum_eject'=>$ld_total_ejecutado_acumulado,
										'varia_abs'=>$ld_total_variacion_absoluta,'varia_porc'=>$ld_total_porcentaje_variacion,
										'varia_abs_acum'=>$ld_total_variacion_abs_acum,'varia_porc_acum'=>$ld_total_porcentaje_variacion_acum,
										'reprog_prox_mes'=>$ld_total_reprog_prox_mes);
		  
				$ld_total_pres_anual=str_replace('.','',$ld_total_pres_anual);
				$ld_total_pres_anual=str_replace(',','.',$ld_total_pres_anual);		
				$ld_total_programada_acumulado=str_replace('.','',$ld_total_programada_acumulado);
				$ld_total_programada_acumulado=str_replace(',','.',$ld_total_programada_acumulado);		
				$ld_total_monto_ejecutado=str_replace('.','',$ld_total_monto_ejecutado);
				$ld_total_monto_ejecutado=str_replace(',','.',$ld_total_monto_ejecutado);		
				$ld_total_ejecutado_acumulado=str_replace('.','',$ld_total_ejecutado_acumulado);
				$ld_total_ejecutado_acumulado=str_replace(',','.',$ld_total_ejecutado_acumulado);
				$ld_total_variacion_absoluta=str_replace('.','',$ld_total_variacion_absoluta);
				$ld_total_variacion_absoluta=str_replace(',','.',$ld_total_variacion_absoluta);
				$ld_total_porcentaje_variacion=str_replace('.','',$ld_total_porcentaje_variacion);
				$ld_total_porcentaje_variacion=str_replace(',','.',$ld_total_porcentaje_variacion);		
				$ld_total_variacion_abs_acum=str_replace('.','',$ld_total_variacion_abs_acum);
				$ld_total_variacion_abs_acum=str_replace(',','.',$ld_total_variacion_abs_acum);	
				$ld_total_porcentaje_variacion_acum=str_replace('.','',$ld_total_porcentaje_variacion_acum);
				$ld_total_porcentaje_variacion_acum=str_replace(',','.',$ld_total_porcentaje_variacion_acum);		
				$ld_total_reprog_prox_mes=str_replace('.','',$ld_total_reprog_prox_mes);
				$ld_total_reprog_prox_mes=str_replace(',','.',$ld_total_reprog_prox_mes);		
		   }//if
		 }//for
		uf_print_titulo_reporte($li_ano,$ls_mes,$io_pdf);
		uf_print_titulo($io_pdf);
		uf_print_cabecera("Mensual",$io_pdf);
        uf_print_titulo_proyecto($io_pdf);
		uf_print_detalle_proyectos($la_data,$io_pdf); // Imprimimos el detalle 
	
        if ($ls_tipoformato==1)
		{
			 $ld_total_c1=$ld_total_pres_anual;
			 $ld_total_c2=$ld_total_programada_acumulado;
			 $ld_total_c3=$ld_total_monto_ejecutado;
			 $ld_total_c4=$ld_total_ejecutado_acumulado;
			 $ld_total_c5=$ld_total_variacion_absoluta;
			 $ld_total_c6=$ld_total_porcentaje_variacion;
			 $ld_total_c7=$ld_total_variacion_abs_acum;
			 $ld_total_c8=$ld_total_porcentaje_variacion_acum;
			 $ld_total_c9=$ld_total_reprog_prox_mes;
			 
			 $ld_total_c1=number_format($ld_total_c1,2,",",".");
			 $ld_total_c2=number_format($ld_total_c2,2,",",".");
			 $ld_total_c3=number_format($ld_total_c3,2,",",".");
			 $ld_total_c4=number_format($ld_total_c4,2,",",".");
			 $ld_total_c5=number_format($ld_total_c5,2,",",".");
			 $ld_total_c6=number_format($ld_total_c6,2,",",".");
			 $ld_total_c7=number_format($ld_total_c7,2,",",".");
			 $ld_total_c8=number_format($ld_total_c8,2,",",".");
			 $ld_total_c9=number_format($ld_total_c9,2,",",".");
	
			 $la_data_totales[$z]=array('total'=>'<b>TOTAL BsF.</b>','pres_anual'=>$ld_total_c1,'prog_acum'=>$ld_total_c2,
										'monto_eject'=>$ld_total_c3,'acum_eject'=>$ld_total_c4,
										'varia_abs'=>$ld_total_c5,'varia_porc'=>$ld_total_c6,
										'varia_abs_acum'=>$ld_total_c7,'varia_porc_acum'=>$ld_total_c8,
										'reprog_prox_mes'=>$ld_total_c9);
			uf_print_pie_cabecera($la_data_totales,$io_pdf);
	  }
	  else
	  {
			 $ld_total_c1=$ld_total_pres_anual;
			 $ld_total_c2=$ld_total_programada_acumulado;
			 $ld_total_c3=$ld_total_monto_ejecutado;
			 $ld_total_c4=$ld_total_ejecutado_acumulado;
			 $ld_total_c5=$ld_total_variacion_absoluta;
			 $ld_total_c6=$ld_total_porcentaje_variacion;
			 $ld_total_c7=$ld_total_variacion_abs_acum;
			 $ld_total_c8=$ld_total_porcentaje_variacion_acum;
			 $ld_total_c9=$ld_total_reprog_prox_mes;
			 
			 $ld_total_c1_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c1 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c2_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c2 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c3_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c3 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c4_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c4 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c5_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c5 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c6_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c6 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c7_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c7 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c8_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c8 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 $ld_total_c9_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_total_c9 , $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
			 
			 $ld_total_c1=number_format($ld_total_c1,2,",",".");
			 $ld_total_c2=number_format($ld_total_c2,2,",",".");
			 $ld_total_c3=number_format($ld_total_c3,2,",",".");
			 $ld_total_c4=number_format($ld_total_c4,2,",",".");
			 $ld_total_c5=number_format($ld_total_c5,2,",",".");
			 $ld_total_c6=number_format($ld_total_c6,2,",",".");
			 $ld_total_c7=number_format($ld_total_c7,2,",",".");
			 $ld_total_c8=number_format($ld_total_c8,2,",",".");
			 $ld_total_c9=number_format($ld_total_c9,2,",",".");
	
			 $la_data_totales[$z]=array('total'=>'<b>TOTAL Bs.</b>','pres_anual'=>$ld_total_c1,'prog_acum'=>$ld_total_c2,
										'monto_eject'=>$ld_total_c3,'acum_eject'=>$ld_total_c4,
										'varia_abs'=>$ld_total_c5,'varia_porc'=>$ld_total_c6,
										'varia_abs_acum'=>$ld_total_c7,'varia_porc_acum'=>$ld_total_c8,
										'reprog_prox_mes'=>$ld_total_c9);
										
			 $ld_total_c1_bsf=number_format($ld_total_c1_bsf,2,",",".");
			 $ld_total_c2_bsf=number_format($ld_total_c2_bsf,2,",",".");
			 $ld_total_c3_bsf=number_format($ld_total_c3_bsf,2,",",".");
			 $ld_total_c4_bsf=number_format($ld_total_c4_bsf,2,",",".");
			 $ld_total_c5_bsf=number_format($ld_total_c5_bsf,2,",",".");
			 $ld_total_c6_bsf=number_format($ld_total_c6_bsf,2,",",".");
			 $ld_total_c7_bsf=number_format($ld_total_c7_bsf,2,",",".");
			 $ld_total_c8_bsf=number_format($ld_total_c8_bsf,2,",",".");
			 $ld_total_c9_bsf=number_format($ld_total_c9_bsf,2,",",".");
										
			$la_data_totales_bsf[$z]=array('total'=>'<b>TOTAL BsF.</b>','pres_anual'=>$ld_total_c1_bsf,'prog_acum'=>$ld_total_c2_bsf,									'monto_eject'=>$ld_total_c3_bsf,'acum_eject'=>$ld_total_c4_bsf,
										'varia_abs'=>$ld_total_c5_bsf,'varia_porc'=>$ld_total_c6_bsf,
										'varia_abs_acum'=>$ld_total_c7_bsf,'varia_porc_acum'=>$ld_total_c8_bsf,
										'reprog_prox_mes'=>$ld_total_c9_bsf);
			uf_print_pie_cabecera($la_data_totales,$io_pdf);
			//uf_print_pie_cabecera_proyecto($la_data_tot,$io_pdf);	
			//uf_print_pie_cabecera_proyecto($la_data_totales_bsf,$io_pdf);	
	
	
	}
	
	
	unset($la_data_totales);
	unset($la_data_totales_bsf);
	unset($la_data);
	unset($la_data_tot);
	if($z<$li_total)
	{
	 $io_pdf->ezNewPage(); // Insertar una nueva p�gina
	} 
	$io_pdf->ezStopPageNumbers(1,1);
	if (isset($d) && $d)
	{
		$ls_pdfcode = $io_pdf->ezOutput(1);
		$ls_pdfcode = str_replace("\n","\n<br>",htmlspecialchars($ls_pdfcode));
		echo '<html><body>';
		echo trim($ls_pdfcode);
		echo '</body></html>';
	}
	else
	{
		$io_pdf->ezStream();
	}
	unset($io_pdf);
	}//else
	unset($io_report);
	unset($io_funciones);
?> 