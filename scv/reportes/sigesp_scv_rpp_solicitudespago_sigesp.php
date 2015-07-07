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
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_codsolvia,&$io_encabezado,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_codsolvia // C�digo de Solicitud de Viaticos
		//	    		   io_encabezado // Instancia del encabezado
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 26/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
		$io_pdf->line(35,40,570,40);
		$io_pdf->line(30,785,570,785);
		$io_pdf->line(30,700,570,700);
		$io_pdf->line(30,785,30,700);
		$io_pdf->line(150,785,150,700);
		$io_pdf->line(450,785,450,700);
		$io_pdf->line(570,785,570,700);
		$io_pdf->line(450,763.75,570,763.75);
		$io_pdf->line(450,742.5,570,742.5);
		$io_pdf->line(450,721.25,570,721.25);
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(451,764.75,118,$io_pdf->getFontHeight(16.8));
        $io_pdf->filledRectangle(451,722.25,118,$io_pdf->getFontHeight(16.8));
        $io_pdf->setColor(0,0,0);		
		$io_pdf->addText(493,770,11,"FECHA"); // Agregar FECHA
		$io_pdf->addText(483,748,11,date("d/m/Y")); // Agregar FECHA
		$io_pdf->addText(468,727,11,"N� DE CONTROL"); // Agregar NRO DE CONTROL
		$io_pdf->addText(487,706,11,$as_codsolvia); // Agregar NRO DE CONTROL
		$io_pdf->addText(215,740,11,"<b>SOLICITUD PAGO DE VIATICOS</b>"); // Agregar NRO DE CONTROL
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,710,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_cedper,$as_nomper,$as_desuniadm,$as_codcueban,$as_tipcuebanper,$as_desded,$as_destipper,
							  $as_codclavia,$ad_fecsalvia,$ad_fecregvia,$ai_numdiavia,$as_denmis,$ai_acompanante,$as_cargo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: $as_cedper  // C�dula de personal
		//	    		   $as_nomper     // Nombre del personal
		//	    		   $as_desuniadm     // descripci�n de la unidad administrativa
		//	    		   $as_codcueban     // codigo cuenta de banco
		//	    		   $as_tipcuebanper     // tipo de cuenta de banco
		//	    		   $as_desded  // Descripci�n de la dedicaci�n
		//	    		   $as_destipper  // Descripci�n del tipo de personal
		//	    		   $as_codclavia  // Clasificaci�n del viaticos
		//	    		   $ad_fecsalvia  // fecha de salida del viatico
		//	    		   $ad_fecregvia  // fecha de regreso del viatico
		//	    		   $ai_numdiavia     // numero de dias
		//	    		   $as_denmis  // Denominaci�n de las misiones
		//	    		   io_pdf         // Instancia del objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 29/11/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		require_once("../../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();				
		$ad_fecsalvia=$io_funciones->uf_convertirfecmostrar($ad_fecsalvia);
		$ad_fecregvia=$io_funciones->uf_convertirfecmostrar($ad_fecregvia);
		$ai_numdiavia=number_format($ai_numdiavia,2,",",".");
        $io_pdf->setColor(0,0,0);		
		$la_data=array(array('titulo'=>'<b>DATOS DEL FUNCIONARIO ACTUALIZADO PARA LA MISION</b>'));
		$la_columna=array('titulo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->ezSetDy(-2);
		$la_data=array(array('nombre'=>$as_nomper,'cedula'=>$as_cedper,'cargo'=>$as_cargo,'unidad'=>$as_desuniadm,'categoria'=>$as_desded.' '.$as_destipper));
		$la_columna=array('nombre'=>'<b>Nombre del Funcionario</b>','cedula'=>'<b>C�dula de Identidad N�</b>',
						  'cargo'=>'<b>Denominaci�n del Cargo</b>','unidad'=>'<b>Ubicaci�n Administrativa</b>','categoria'=>'<b>Categoria</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0	, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('nombre'=>array('justification'=>'center','width'=>110),
						       		   'cedula'=>array('justification'=>'center','width'=>100),
									   'cargo'=>array('justification'=>'center','width'=>100),
									   'unidad'=>array('justification'=>'center','width'=>100),
									   'categoria'=>array('justification'=>'center','width'=>130))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		switch($as_tipcuebanper)
		{
			case "A": //Ahorro
				$ls_ahorro="X";
				$ls_corriente="";
				break;
			case "C": // Corriente
				$ls_ahorro="";
				$ls_corriente="X";
				break;
		}
		$la_data=array(array('titulo'=>'<b>N� de Cuenta N�mina</b>','corriente'=>$ls_corriente,'titulocorriente'=>'Corriente',
							 'ahorro'=>$ls_ahorro,'tituloahorro'=>'Ahorro','cuenta'=>$as_codcueban));
		$la_columna=array('titulo'=>'','corriente'=>'','titulocorriente'=>'','ahorro'=>'','tituloahorro'=>'','cuenta'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0	, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>110),
						       		   'corriente'=>array('justification'=>'center','width'=>20),
									   'titulocorriente'=>array('justification'=>'center','width'=>80),
									   'ahorro'=>array('justification'=>'center','width'=>20),
									   'tituloahorro'=>array('justification'=>'center','width'=>80),
									   'cuenta'=>array('justification'=>'left','width'=>230))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('titulo'=>'<b>DESCRIPCI�N DE LA SOLICITUD</b>'));
		$la_columna=array('titulo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->ezSetDy(-1.08);
		$ls_acompanante = "";
		if($ai_acompanante==1)
		{
			$ls_acompanante = "NO";
		}
		if($ai_acompanante>1)
		{
			$ls_acompanante = "SI";
		}
		$la_data=array(array('dependencia'=>'<b>Dependencia Solicitante:</b> '.$as_desuniadm,'acompanante'=>'<b>Acompa�antes:</b> '.$ls_acompanante,'categoria'=>'<b>Categoria:</b> '.$as_codclavia));
		$la_columna=array('dependencia'=>'','acompanante'=>'','categoria'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0	, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('dependencia'=>array('justification'=>'left','width'=>380),
						       		   'acompanante'=>array('justification'=>'left','width'=>90),
									   'categoria'=>array('justification'=>'left','width'=>70))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('desde'=>'<b>Periodo Desde:</b> '.$ad_fecsalvia,'hasta'=>'<b>Periodo Hasta:</b> '.$ad_fecregvia,'dias'=>'<b>Total D�as:</b> '.$ai_numdiavia));
		$la_columna=array('desde'=>'','hasta'=>'','dias'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0	, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('desde'=>array('justification'=>'left','width'=>200),
						       		   'hasta'=>array('justification'=>'left','width'=>200),
									   'dias'=>array('justification'=>'left','width'=>140))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('mision'=>'<b>Conceptos de la Misi�n:</b> '.$as_denmis));
		$la_columna=array('mision'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0	, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('mision'=>array('justification'=>'left','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('codigo'=>'<b>C�digo</b>','descripcion'=>'<b>Descripci�n</b>','tarifa'=>'<b>Tarifa</b>',
							 'dias'=>'<b>D�as</b>','subtotal'=>'<b>Subtotal</b>'));
		$la_columna=array('codigo'=>'','descripcion'=>'','tarifa'=>'','dias'=>'','subtotal'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60),
						               'descripcion'=>array('justification'=>'center','width'=>220),
									   'tarifa'=>array('justification'=>'center','width'=>100),
									   'dias'=>array('justification'=>'center','width'=>60),
									   'subtotal'=>array('justification'=>'center','width'=>100))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_asignaciones($la_data,$ai_total,$as_totalletras,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_asignaciones
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('codigo'=>'','descripcion'=>'','tarifa'=>'','dias'=>'','subtotal'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>60),
						               'descripcion'=>array('justification'=>'left','width'=>220),
									   'tarifa'=>array('justification'=>'right','width'=>100),
									   'dias'=>array('justification'=>'center','width'=>60),
									   'subtotal'=>array('justification'=>'right','width'=>100))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('titulo'=>'<b>Total Misi�n Bs.:</b>              ','total'=>$ai_total));
		$la_columna=array('titulo'=>'','total'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo'=>array('justification'=>'right','width'=>440),
									   'total'=>array('justification'=>'right','width'=>100))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('letra'=>'<b>Son:</b> '.$as_totalletras));
		$la_columna=array('letra'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo'=>array('justification'=>'left','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_presupuestario($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_presupuestario
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_datos=array(array('titulo'=>'<b>CONTROL PRESUPUESTARIO</b>'));
		$la_columna=array('titulo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_datos,$la_columna,'',$la_config);	
		unset($la_columna);
		unset($la_config);
		$io_pdf->ezSetDy(-2);
		$la_columna=array('ano'=>'<b>A�o</b>',
   						  'proyecto'=>'<b>'.$_SESSION["la_empresa"]["nomestpro1"].'</b>',
						  'especifica'=>'<b>'.$_SESSION["la_empresa"]["nomestpro2"].'</b>',
						  'cuenta'=>'<b>Cuenta</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('ano'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'proyecto'=>array('justification'=>'center','width'=>190), // Justificaci�n y ancho de la columna
						 			   'especifica'=>array('justification'=>'center','width'=>190), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_firmas(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_firmas
		//		   Access: private 
		//	    Arguments: io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data=array(array('titulo'=>'<b>FIRMAS</b>'));
		$la_columna=array('titulo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('elaborado'=>'<b>Elaborado Por:</b>','revisado'=>'<b>Revisado Por:</b>','autorizado'=>'<b>Autorizado Por:</b>'),
					   array('elaborado'=>'','revisado'=>'','autorizado'=>''),
					   array('elaborado'=>'','revisado'=>'','autorizado'=>''),
					   array('elaborado'=>'','revisado'=>'','autorizado'=>''),
					   array('elaborado'=>'','revisado'=>'','autorizado'=>''),
					   array('elaborado'=>'','revisado'=>'','autorizado'=>''),
					   array('elaborado'=>'','revisado'=>'                      ','autorizado'=>'                     '),
					   array('elaborado'=>'                              ANALISTA','revisado'=>'     SUB-GCIA DE SERVICIOS GENERALES','autorizado'=>'          GERENTE DE ADMINISTRACI�N'));
		$la_columna=array('elaborado'=>'',
   						  'revisado'=>'',
						  'autorizado'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('elaborado'=>array('justification'=>'left','width'=>180), // Justificaci�n y ancho de la columna
						 			   'revisado'=>array('justification'=>'left','width'=>180), // Justificaci�n y ancho de la columna
						 			   'autorizado'=>array('justification'=>'left','width'=>180))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('titulo'=>'<b>FIRMAS</b>'));
		$la_columna=array('titulo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540,
						 'cols'=>array('titulo'=>array('justification'=>'center','width'=>540))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data=array(array('nombre'=>'<b>Nombre y Apellido:</b>','cedula'=>'<b>C.I. No:</b>','firma'=>'<b>Firma:</b>','fecha'=>'<b>Fecha:</b>'),
					   array('nombre'=>'','cedula'=>'','firma'=>'','fecha'=>''),
					   array('nombre'=>'','cedula'=>'','firma'=>'','fecha'=>''),
					   array('nombre'=>'','cedula'=>'','firma'=>'','fecha'=>''),
					   array('nombre'=>'','cedula'=>'','firma'=>'','fecha'=>''));
		$la_columna=array('nombre'=>'',
   						  'cedula'=>'',
   						  'firma'=>'',
						  'fecha'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'rowGap' => 1,
						 'titleFontSize' => 9,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('nombre'=>array('justification'=>'center','width'=>135), // Justificaci�n y ancho de la columna
						 			   'cedula'=>array('justification'=>'center','width'=>135), // Justificaci�n y ancho de la columna
						 			   'firma'=>array('justification'=>'center','width'=>135), // Justificaci�n y ancho de la columna
						 			   'fecha'=>array('justification'=>'center','width'=>135))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_firmas
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_scv_class_report.php");
	$io_report=new sigesp_scv_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_viaticos.php");
	$io_fun_viaticos=new class_funciones_viaticos();
	include("../../shared/class_folder/class_numero_a_letra.php");
	$io_numero_letra= new class_numero_a_letra();
	//imprime numero con los valore por defecto
	//cambia a minusculas
	$io_numero_letra->setMayusculas(1);
	//cambia a femenino
	$io_numero_letra->setGenero(1);
	//cambia moneda
	$io_numero_letra->setMoneda("Bolivares");
	//cambia prefijo
	$io_numero_letra->setPrefijo("");
	//cambia sufijo
	$io_numero_letra->setSufijo("");
	//imprime numero con los cambios
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_codsoldes=$io_fun_viaticos->uf_obtenervalor_get("codsoldes","");
	$ls_codsolhas=$io_fun_viaticos->uf_obtenervalor_get("codsolhas","");
	$ld_desde=$io_fun_viaticos->uf_obtenervalor_get("desde","");
	$ld_hasta=$io_fun_viaticos->uf_obtenervalor_get("hasta","");

	$ls_titulo="<b> SOLICITUD PAGO DE VIATICOS </b>";
	$ls_fecha="Periodo ".$ld_desde." - ".$ld_hasta;
	$ls_modalidad= $_SESSION["la_empresa"]["estmodest"];
	switch($ls_modalidad)
	{
		case "1": // Modalidad por Proyecto
			$ls_titest="Estructura Presupuestaria ";
			break;
			
		case "2": // Modalidad por Presupuesto
			$ls_titest="Estructura Program�tica ";
			break;
	}
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codemp=$_SESSION["la_empresa"]["codemp"];
	$ls_nomemp=$_SESSION["la_empresa"]["nombre"];
	$ls_codsolvia="";
	$li_orden=$io_fun_viaticos->uf_obtenervalor_get("ordenfec","");
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=$io_report->uf_select_solicitudpago_personal($ls_codemp,$ls_codsoldes,$ls_codsolhas,$ld_desde,$ld_hasta,$li_orden); // Cargar el DS con los datos de la cabecera del reporte
	if($lb_valido==false) // Existe alg�n error � no hay registros
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
		$io_pdf->ezSetCmMargins(3.5,3,3,3); // Configuraci�n de los margenes en cent�metros
		$io_pdf->ezStartPageNumbers(545,25,10,'','',1); // Insertar el n�mero de p�gina
		$li_totrow=$io_report->ds->getRowCount("cedper");
		//print $li_totrow;
		for($li_i=1;$li_i<=$li_totrow;$li_i++)
		{
			$ls_codsolvia= $io_report->ds->data["codsolvia"][$li_i];
			$io_encabezado=$io_pdf->openObject();
			uf_print_encabezado_pagina($ls_codsolvia,$io_encabezado,$io_pdf); // Imprimimos el encabezado de la p�gina
			$ls_cedper= $io_report->ds->data["cedper"][$li_i];
			$ls_nomper= $io_report->ds->data["nomper"][$li_i]." ".$io_report->ds->data["apeper"][$li_i];
			$ls_cargo= $io_report->ds->data["cargo"][$li_i];
			$ls_desuniadm= $io_report->ds->data["desuniadm"][$li_i];
			$ls_codcueban = $io_report->ds->data["codcueban"][$li_i];
			$ls_tipcuebanper= $io_report->ds->data["tipcuebanper"][$li_i];
			$ls_desded= $io_report->ds->data["desded"][$li_i];
			$ls_destipper= $io_report->ds->data["destipper"][$li_i];			
			$ls_codclavia= $io_report->ds->data["codclavia"][$li_i];
			$ld_fecsalvia= $io_report->ds->data["fecsalvia"][$li_i];
			$ld_fecregvia= $io_report->ds->data["fecregvia"][$li_i];
			$li_numdiavia= $io_report->ds->data["numdiavia"][$li_i];
			$ls_denmis= $io_report->ds->data["denmis"][$li_i];
			$li_acompanante= $io_report->ds->data["acompanante"][$li_i];
			uf_print_cabecera($ls_cedper,$ls_nomper,$ls_desuniadm,$ls_codcueban,$ls_tipcuebanper,$ls_desded,$ls_destipper,
							  $ls_codclavia,$ld_fecsalvia,$ld_fecregvia,$li_numdiavia,$ls_denmis,$li_acompanante,$ls_cargo,&$io_pdf); // Imprimimos la cabecera del registro
			$lb_valido=$io_report->uf_select_solicitudpago_asignaciones($ls_codemp,$ls_codsolvia);
			if($lb_valido)
			{
				$li_totrow_det=$io_report->ds_detalle->getRowCount("codasi");
				$li_total=0;
				for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
				{
					$ls_codasi= $io_report->ds_detalle->data["codasi"][$li_s];
					$ls_denasi= $io_report->ds_detalle->data["denasi"][$li_s];
					$li_canasi= $io_report->ds_detalle->data["canasi"][$li_s];
					$li_monto= $io_report->ds_detalle->data["monto"][$li_s];
					$li_subtotal = $li_monto*$li_canasi;
					$li_total=$li_total+$li_subtotal;
					$li_canasi=number_format($li_canasi,2,",",".");
					$li_monto=number_format($li_monto,2,",",".");
					$li_subtotal=number_format($li_subtotal,2,",",".");
					$la_data[$li_s]=array('codigo'=>$ls_codasi,'descripcion'=>$ls_denasi,'tarifa'=>$li_monto,'dias'=>$li_canasi,'subtotal'=>$li_subtotal);
				}
				$io_numero_letra->setNumero($li_total);
				$ls_totalletras=$io_numero_letra->letra();
				$li_total=number_format($li_total,2,",",".");
				uf_print_detalle_asignaciones($la_data,$li_total,$ls_totalletras,$io_pdf); // Imprimimos el detalle 
				unset($la_data);
				$io_report->ds_detalle->reset_ds();
				$lb_existe=$io_report->uf_select_solicitudpago_spg($ls_codemp,$ls_codsolvia);
				if($lb_existe)
				{
					$li_totrow_detpres=$io_report->ds_detpresup->getRowCount("spg_cuenta");
					$ls_ano=substr($_SESSION["la_empresa"]["periodo"],0,4);
					for($li_j=1;$li_j<=$li_totrow_detpres;$li_j++)
					{
						$ls_spgcuenta=$io_report->ds_detpresup->data["spg_cuenta"][$li_j];
						$ls_denestpro1=$io_report->ds_detpresup->data["denestpro1"][$li_j];
						$ls_denestpro2=$io_report->ds_detpresup->data["denestpro2"][$li_j];
						$la_data[$li_j]=array('ano'=>$ls_ano,'proyecto'=>$ls_denestpro1,'especifica'=>$ls_denestpro2,'cuenta'=>$ls_spgcuenta);
					}
					uf_print_detalle_presupuestario($la_data,$io_pdf); // Imprimimos el detalle 
					unset($la_data);
				}
			}
			uf_print_firmas($io_pdf);
			$io_pdf->stopObject($io_encabezado); // Detener el objeto cabecera
			unset($io_encabezado);
			if($li_i<$li_totrow)
			{
				$io_pdf->ezNewPage(); // Insertar una nueva p�gina
			}
		}
		if($lb_valido)
		{
			$io_pdf->ezStopPageNumbers(1,1);
			$io_pdf->ezStream();
		}
		unset($io_pdf);
	}
	unset($io_report);
	unset($io_funciones);
	unset($io_fun_viaticos);
?> 