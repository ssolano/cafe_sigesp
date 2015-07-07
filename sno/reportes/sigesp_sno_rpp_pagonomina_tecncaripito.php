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
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_pagonomina.php",$ls_descripcion,$ls_codnom);
		}
		else
		{
			$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_hpagonomina.php",$ls_descripcion,$ls_codnom);
		}
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_desnom,$as_periodo,&$io_pdf)
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
		// Fecha Creaci�n: 26/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,555,40);
		$io_pdf->line(50,669,555,669);
		$io_pdf->line(50,665,555,665);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,"Rep�blica Bolivariana de Venezuela");
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,760,12,"Rep�blica Bolivariana de Venezuela"); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(12,"Ministerio de Educaci�n Superior");
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,748,12,"Ministerio de Educaci�n Superior"); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(12,"Instituto Universitario de Tecnolog�a Caripito");
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,736,12,"Instituto Universitario de Tecnolog�a Caripito"); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(12,"Oficina de Recursos Humanos");
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,724,12,"Oficina de Recursos Humanos"); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(12,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,712,12,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(12,$as_desnom);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,692,12,$as_desnom); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(11,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,672,11,$as_periodo); // Agregar el t�tulo
		$io_pdf->addText(512,750,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(518,743,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_cedper,$as_apenomper,$as_descar,$as_desuniadm,$ad_fecingper,$as_codcueban,$as_programatica,$as_codgra,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_cedper // c�dula del personal
		//	    		   as_apenomper // apellidos y nombre del personal
		//	    		   as_descar // descripci�n del cargo
		//	    		   as_desuniadm // descripci�n de la unidad administrativa
		//	    		   ad_fecingper // fecha de ingreso
		//	    		   as_codcueban // c�digo de lla cuenta bancaria
		//	    		   as_programatica // Program�tica
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 26/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetDy(-5);
		$la_data[1]=array('cedula'=>'C�dula',
						  'nombre'=>'Apellidos y Nombres',
						  'cargo'=>'Cargo',
						  'programa'=>'Unidad de Adscripci�n');
		$la_data[2]=array('cedula'=>'<b>'.$as_cedper.'</b>',
						  'nombre'=>'<b>'.$as_apenomper.'</b>',
						  'cargo'=>'<b>'.$as_descar.'</b>',
						  'programa'=>'<b>'.$as_desuniadm.'</b>');
		$la_columnas=array('cedula'=>'',
						   'nombre'=>'',
						   'cargo'=>'',
						   'programa'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'width'=>520, // Ancho de la tabla
						 'maxWidth'=>520, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('cedula'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'center','width'=>160), // Justificaci�n y ancho de la columna
						 			   'cargo'=>array('justification'=>'center','width'=>150), // Justificaci�n y ancho de la columna
						 			   'programa'=>array('justification'=>'center','width'=>150))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		unset($la_data);	
		unset($la_columnas);	
		unset($la_config);	
		$la_data[1]=array('fecha'=>'Fecha Ingreso',
						  'fecha1'=>'<b>'.$ad_fecingper.'</b>',
						  'cuenta'=>'Cuenta Bancaria',
						  'cuenta1'=>'<b>'.$as_codcueban.'</b>',
						  'grado'=>'Grado',
						  'grado1'=>'<b>'.$as_codgra.'</b>');
		$la_columnas=array('fecha'=>'',
						   'fecha1'=>'',
						   'cuenta'=>'',
						   'cuenta1'=>'',
						   'grado'=>'',
						   'grado1'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'width'=>520, // Ancho de la tabla
						 'maxWidth'=>520, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('fecha'=>array('justification'=>'left','width'=>70), // Justificaci�n y ancho de la columna
						 			   'fecha1'=>array('justification'=>'left','width'=>70), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'left','width'=>80), // Justificaci�n y ancho de la columna
						 			   'cuenta1'=>array('justification'=>'left','width'=>100), // Justificaci�n y ancho de la columna
						 			   'grado'=>array('justification'=>'left','width'=>50), // Justificaci�n y ancho de la columna
						 			   'grado1'=>array('justification'=>'left','width'=>150))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);	
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
		//    Description: funci�n que imprime el detalle del personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 26/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetDy(-2);
		$la_columnas=array('codigo'=>'C�digo',
						   'denominacion'=>'Concepto',
						   'asignacion'=>'Asignaci�n',
						   'deduccion'=>'Deducci�n',
						   'neto'=>'Neto a Cobrar');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>480, // Ancho de la tabla
						 'maxWidth'=>480, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>160), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'neto'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_piecabecera($as_apenomper,$ai_totalasignacion,$ai_totaldeduccion,$ai_totalaporte,$ai_total_neto,$as_obsrecper,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_piecabecera
		//		   Access: private 
		//	    Arguments: ai_totalasignacion // Total Asignaci�n
		//	   			   ai_totaldeduccion // Total Deduccci�n
		//	   			   ai_totalaporte // Total aporte
		//	   			   ai_total_neto // Total Neto
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 26/04/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		
		$la_data=array(array('totales'=>'Totales '.$ls_bolivares.'...'.$as_apenomper,'asignacion'=>'<b>'.$ai_totalasignacion.'</b>',
							 'deduccion'=>'<b>'.$ai_totaldeduccion.'</b>','neto'=>'<b>'.$ai_total_neto.'</b>'));
		$la_columna=array('totales'=>'','asignacion'=>'','deduccion'=>'','neto'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>480, // Ancho de la tabla
						 'maxWidth'=>480, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('totales'=>array('justification'=>'right','width'=>240), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'neto'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$la_data[0]=array('name'=>'');
		if(trim($as_obsrecper)!='')
		{
			$la_data[0]=array('name'=>'OBSERVACI�N:');
			$la_data[1]=array('name'=>'			'.$as_obsrecper);
			$la_data[2]=array('name'=>'');
		}
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_piecabecera
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_piepagina($ai_totasi,$ai_totded,$ai_totapo,$ai_totgeneral,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_piepagina
		//		   Access: private 
		//	    Arguments: ai_totasi // Total de Asignaciones
		//	   			   ai_totded // Total de Deducciones
		//	   			   ai_totapo // Total de Aportes
		//	   			   ai_totgeneral // Total de Neto a Pagar
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el fin de la cabecera
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 25/05/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		
		$la_data=array(array('name'=>''));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 10, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>500); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		$la_data=array(array('titulo'=>'<b>Total N�mina '.$ls_bolivares.': </b>','asignacion'=>$ai_totasi,
							 'deduccion'=>$ai_totded,'aporte'=>$ai_totapo,'neto'=>$ai_totgeneral));
		$la_columna=array('titulo'=>'','asignacion'=>'','deduccion'=>'','aporte'=>'','neto'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((224/255),(224/255),(224/255)), // Color de la sombra
						 'shadeCol2'=>array((224/255),(224/255),(224/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo'=>array('justification'=>'right','width'=>180), // Justificaci�n y ancho de la columna
						 			   'asignacion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'deduccion'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'aporte'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'neto'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
	}
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
		$la_data[1]=array('firma1'=>'','firma2'=>'','firma3'=>'');
		$la_data[2]=array('firma1'=>'','firma2'=>'','firma3'=>'');
		$la_data[3]=array('firma1'=>'Aprobado Por:','firma2'=>'','firma3'=>'');
		$la_columna=array('firma1'=>'','firma2'=>'','firma3'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>510, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('firma1'=>array('justification'=>'left','width'=>170), // Justificaci�n y ancho de la columna
						 			   'firma2'=>array('justification'=>'center','width'=>170),
						 			   'firma3'=>array('justification'=>'center','width'=>170))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('firma1'=>'<b>Jefe Dpto. R.R.H.H.</b>',
						  'firma2'=>'<b>Jefe Dpto. Control Previo.</b>',
						  'firma3'=>'<b>Presupuesto</b>',
						  'firma4'=>'<b>Sub. Dir. Admin.</b>',
						  'firma5'=>'<b>Direccion</b>',
						  'firma6'=>'<b>Contraloria</b>');
		$la_data[2]=array('firma1'=>'<b>Abo. Francisca Tortello</b>',
						  'firma2'=>'<b>Lic. Miglenys Adrian</b>',
						  'firma3'=>'<b>Lic. Ceryol Villaroel</b>',
						  'firma4'=>'<b>Pro. Alberto Boutto</b>',
						  'firma5'=>'<b>Ing. Heli S. Sulbaran</b>',
						  'firma6'=>'<b>Lic. Petra Salgado</b>');
		$la_columna=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' =>6, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>510, // Ancho de la tabla
						 'maxWidth'=>510, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5,
						 'cols'=>array('firma1'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma2'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma3'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma4'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma5'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma6'=>array('justification'=>'center','width'=>85))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('firma1'=>'Fecha:        /          /  ',
						  'firma2'=>'Fecha:        /          /  ',


						  'firma3'=>'Fecha:        /          /  ',
						  'firma4'=>'Fecha:        /          /  ',
						  'firma5'=>'Fecha:        /          /  ',
						  'firma6'=>'Fecha:        /          /  ');
		$la_columna=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' =>7, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>510, // Ancho de la tabla
						 'maxWidth'=>510, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5,
						 'cols'=>array('firma1'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma2'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma3'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma4'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma5'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma6'=>array('justification'=>'left','width'=>85))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$la_data[1]=array('firma1'=>'Firma:','firma2'=>'Firma:','firma3'=>'Firma:','firma4'=>'Firma:','firma5'=>'Firma:','firma6'=>'Firma:');
		$la_data[2]=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_data[3]=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_data[4]=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_data[5]=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_data[5]=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_columna=array('firma1'=>'','firma2'=>'','firma3'=>'','firma4'=>'','firma5'=>'','firma6'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' =>7, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'width'=>510, // Ancho de la tabla
						 'maxWidth'=>510, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap' => 0.5,
						 'cols'=>array('firma1'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma2'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma3'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma4'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma5'=>array('justification'=>'left','width'=>85), // Justificaci�n y ancho de la columna
						 			   'firma6'=>array('justification'=>'left','width'=>85))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_firmas
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	$ls_tiporeporte="0";
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
	$ls_titulo="<b>Reporte General de Pago</b>";
	$ls_periodo="<b>Per�odo Nro ".$ls_peractnom.", ".$ld_fecdesper." - ".$ld_fechasper."</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codperdes=$io_fun_nomina->uf_obtenervalor_get("codperdes","");
	$ls_codperhas=$io_fun_nomina->uf_obtenervalor_get("codperhas","");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
	$ls_tituloconcepto=$io_fun_nomina->uf_obtenervalor_get("tituloconcepto","");
	$ls_conceptoreporte=$io_fun_nomina->uf_obtenervalor_get("conceptoreporte","");
	$ls_conceptop2=$io_fun_nomina->uf_obtenervalor_get("conceptop2","");
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
		$lb_valido=$io_report->uf_pagonomina_personal($ls_codperdes,$ls_codperhas,$ls_conceptocero,$ls_conceptoreporte,$ls_conceptop2,
													 $ls_codubifis,$ls_codpai,$ls_codest,$ls_codmun,$ls_codpar,$ls_subnomdes,$ls_subnomhas,$ls_orden); // Cargar el DS con los datos de la cabecera del reporte
	}
	$li_totrow=$io_report->rs_data->RecordCount();
	if(($lb_valido==false) || ($li_totrow == 0) )// Existe alg�n error � no hay registros
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
		$io_pdf->ezSetCmMargins(4.5,3,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$ls_desnom,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		$li_totrow=$io_report->rs_data->RecordCount();
		$li_totasi=0;
		$li_totded=0;
		$li_totapo=0;
		$li_totgeneral=0;
		while((!$io_report->rs_data->EOF)&&($lb_valido))
		{
	        $io_pdf->transaction('start'); // Iniciamos la transacci�n
			$li_numpag=$io_pdf->ezPageCount; // N�mero de p�gina
			$li_totalasignacion=0;
			$li_totaldeduccion=0;
			$li_totalaporte=0;
			$li_total_neto=0;
			$ls_codper=$io_report->rs_data->fields["codper"];
			$ls_cedper=$io_report->rs_data->fields["cedper"];
			$ls_apenomper=$io_report->rs_data->fields["apeper"].", ". $io_report->rs_data->fields["nomper"];
			$ls_descar=$io_report->rs_data->fields["descar"];
			$ls_desuniadm=$io_report->rs_data->fields["desuniadm"];
			$ld_fecingper=$io_funciones->uf_convertirfecmostrar($io_report->rs_data->fields["fecingper"]);
			$ls_codcueban=$io_report->rs_data->fields["codcueban"];
			$ls_modalidad=$_SESSION["la_empresa"]["estmodest"];
			$ls_programatica=$io_report->rs_data->fields["codprouniadm"];
			$ls_codgra=$io_report->rs_data->fields["codgra"];
			$ls_obsrecper=$io_report->rs_data->fields["obsrecper"];
			switch($ls_modalidad)
			{
				case "2": // Modalidad por Programa
					$ls_codest1=substr($ls_programatica,0,20);
					$ls_codest1=substr($ls_codest1,(strlen($ls_codest1)-2),2);
					$ls_codest2=substr($ls_programatica,20,6);
					$ls_codest2=substr($ls_codest2,(strlen($ls_codest2)-2),2);
					$ls_codest3=substr($ls_programatica,26,3);
					$ls_codest3=substr($ls_codest3,(strlen($ls_codest3)-2),2);
					$ls_codest4=substr($ls_programatica,29,2);
					$ls_codest4=substr($ls_codest4,(strlen($ls_codest4)-2),2);
					$ls_codest5=substr($ls_programatica,31,2);
					$ls_codest5=substr($ls_codest5,(strlen($ls_codest5)-2),2);
					$ls_programatica=$ls_codest1.$ls_codest2.$ls_codest3.$ls_codest4.$ls_codest5;
					break;
			}
			uf_print_cabecera($ls_cedper,$ls_apenomper,$ls_descar,$ls_desuniadm,$ld_fecingper,$ls_codcueban,$ls_programatica,$ls_codgra,$io_pdf); // Imprimimos la cabecera del registro
			$lb_valido=$io_report->uf_pagonomina_conceptopersonal($ls_codper,$ls_conceptocero,$ls_tituloconcepto,$ls_conceptoreporte,$ls_conceptop2); // Obtenemos el detalle del reporte
			if($lb_valido)
			{
				$li_totrow_res=$io_report->rs_data_detalle->RecordCount();
				$li_s=1;
				while (!$io_report->rs_data_detalle->EOF)
				{
					$ls_codconc=$io_report->rs_data_detalle->fields["codconc"];
					$ls_nomcon=$io_report->rs_data_detalle->fields["nomcon"];
					$ls_tipsal=rtrim($io_report->rs_data_detalle->fields["tipsal"]);
					$li_valsal=abs($io_report->rs_data_detalle->fields["valsal"]);
					switch($ls_tipsal)
					{
						case "A":
							$li_totalasignacion=$li_totalasignacion + $li_valsal;
							$li_asignacion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_deduccion=""; 
							$li_aporte=""; 
							break;
							
						case "V1":
							$li_totalasignacion=$li_totalasignacion + $li_valsal;
							$li_asignacion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_deduccion=""; 
							$li_aporte=""; 
							break;
							
						case "W1":
							$li_totalasignacion=$li_totalasignacion + $li_valsal;
							$li_asignacion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_deduccion=""; 
							$li_aporte=""; 
							break;
							
						case "D":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;
							
						case "V2":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;
							
						case "W2":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;

						case "P1":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;

						case "V3":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;

						case "W3":
							$li_totaldeduccion=$li_totaldeduccion + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_aporte=""; 
							break;

						case "P2":
							$li_totalaporte=$li_totalaporte + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=""; 
							$li_aporte=$io_fun_nomina->uf_formatonumerico($li_valsal);
							break;

						case "V4":
							$li_totalaporte=$li_totalaporte + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=""; 
							$li_aporte=$io_fun_nomina->uf_formatonumerico($li_valsal);
							break;

						case "W4":
							$li_totalaporte=$li_totalaporte + $li_valsal;
							$li_asignacion=""; 
							$li_deduccion=""; 
							$li_aporte=$io_fun_nomina->uf_formatonumerico($li_valsal);
							break;

						case "R":
							$li_asignacion=$io_fun_nomina->uf_formatonumerico($li_valsal);
							$li_deduccion=""; 
							$li_aporte="";
							break;
					}
					$la_data[$li_s]=array('codigo'=>$ls_codconc,'denominacion'=>$ls_nomcon,'asignacion'=>$li_asignacion,
										  'deduccion'=>$li_deduccion,'neto'=>'');
					$li_s++;
					$io_report->rs_data_detalle->MoveNext();					  
				}
  			    uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle  
				$li_total_neto=$li_totalasignacion-$li_totaldeduccion;
				$li_totasi=$li_totasi+$li_totalasignacion;
				$li_totded=$li_totded+$li_totaldeduccion;
				$li_totapo=$li_totapo+$li_totalaporte;
				$li_totgeneral=$li_totgeneral+$li_total_neto;
				$li_totalasignacion=$io_fun_nomina->uf_formatonumerico($li_totalasignacion);
				$li_totaldeduccion=$io_fun_nomina->uf_formatonumerico($li_totaldeduccion);
				$li_totalaporte=$io_fun_nomina->uf_formatonumerico($li_totalaporte);
				$li_total_neto=$io_fun_nomina->uf_formatonumerico($li_total_neto);
				uf_print_piecabecera($ls_apenomper,$li_totalasignacion,$li_totaldeduccion,$li_totalaporte,$li_total_neto,$ls_obsrecper,$io_pdf); // Imprimimos el pie de la cabecera
				if ($io_pdf->ezPageCount==$li_numpag)
				{// Hacemos el commit de los registros que se desean imprimir
					$io_pdf->transaction('commit');
				}
				else
				{// Hacemos un rollback de los registros, agregamos una nueva p�gina y volvemos a imprimir
					$io_pdf->transaction('rewind');
					$io_pdf->ezNewPage(); // Insertar una nueva p�gina
					uf_print_cabecera($ls_cedper,$ls_apenomper,$ls_descar,$ls_desuniadm,$ld_fecingper,$ls_codcueban,$ls_programatica,$ls_codgra,$io_pdf); // Imprimimos la cabecera del registro
					uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
					uf_print_piecabecera($ls_apenomper,$li_totalasignacion,$li_totaldeduccion,$li_totalaporte,$li_total_neto,$io_pdf); // Imprimimos el pie de la cabecera
				}
			}
			unset($la_data);			
			$io_report->rs_data->MoveNext();			
		}
		$li_totasi=$io_fun_nomina->uf_formatonumerico($li_totasi);
		$li_totded=$io_fun_nomina->uf_formatonumerico($li_totded);
		$li_totapo=$io_fun_nomina->uf_formatonumerico($li_totapo);
		$li_totgeneral=$io_fun_nomina->uf_formatonumerico($li_totgeneral);
		uf_print_piepagina($li_totasi,$li_totded,$li_totapo,$li_totgeneral,$io_pdf);
    	uf_print_firmas(&$io_pdf);
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