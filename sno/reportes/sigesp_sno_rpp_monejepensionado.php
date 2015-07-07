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
	function uf_insert_seguridad($as_titulo,$as_desnom,$as_periodo)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 30/06/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;

		$ls_codnom=$_SESSION["la_nomina"]["codnom"];
		$ls_descripcion="Gener� el Reporte ".$as_titulo.". Para ".$as_desnom.". ".$as_periodo;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte_nomina("SNO","sigesp_sno_r_hmonejepensionado.php",$ls_descripcion,$ls_codnom);
		return $lb_valido;
	}
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_desnom,$as_periodo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_desnom // Descripci�n de la n�mina
		//	    		   as_periodo // Per�odo
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 27/06/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,555,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(11,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,720,11,$as_periodo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(10,$as_desnom);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,710,10,$as_desnom); // Agregar el t�tulo
		$io_pdf->addText(512,750,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(518,743,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

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
		$io_pdf->ezSety(705);
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(51,690,500,$io_pdf->getFontHeight(11.5));
        $io_pdf->setColor(0,0,0);
		$la_data[1]=array('codigo'=>'<b>C�digo</b>',
						  'descripcion'=>'<b>Denominaci�n</b>',
						  'cargo'=>'<b>Cargos Ejecutados</b>',
						  'monto'=>'<b>Montos Ejecutados</b>');
		$la_columna=array('codigo'=>'',
						  'descripcion'=>'',
						  'cargo'=>'',
						  'monto'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>50), // Justificaci�n y ancho de la columna
						 			   'descripcion'=>array('justification'=>'center','width'=>250), // Justificaci�n y ancho de la columna
						 			   'cargo'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_cabecera
	//-----------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el detalle por personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 30/06/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('codigo'=>'C�digo',
						  'descripcion'=>'Denominaci�n',
						  'cargo'=>'Cargos Ejecutados',
						  'monto'=>'Montos Ejecutados');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>50), // Justificaci�n y ancho de la columna
						 			   'descripcion'=>array('justification'=>'left','width'=>250), // Justificaci�n y ancho de la columna
						 			   'cargo'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_totales($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_totales
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los totales
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 28/06/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('total'=>'',
						  'cargo'=>'',
						  'monto'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'shadeCol2'=>array((249/255),(249/255),(249/255)), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('total'=>array('justification'=>'right','width'=>300), // Justificaci�n y ancho de la columna
						 			   'cargo'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_totales
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	if($_SESSION["la_nomina"]["tipnom"]==7)
	{
		require_once("../../shared/ezpdf/class.ezpdf.php");
		$ls_tiporeporte="0";
		$ls_bolivares="";
		if (array_key_exists("tiporeporte",$_GET))
		{
			$ls_tiporeporte=$_GET["tiporeporte"];
		}
		switch($ls_tiporeporte)
		{
			case "0":
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
				break;
	
			case "1":
				if($_SESSION["la_nomina"]["tiponomina"]=="NORMAL")
				{
					require_once("sigesp_sno_class_reportbsf.php");
					$io_report=new sigesp_sno_class_reportbsf();
					$li_tipo=1;
				}
				if($_SESSION["la_nomina"]["tiponomina"]=="HISTORICA")
				{
					require_once("sigesp_sno_class_report_historicobsf.php");
					$io_report=new sigesp_sno_class_report_historicobsf();
					$li_tipo=2;
				}	
				$ls_bolivares ="Bs.F.";
				break;
		}
		require_once("../../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();				
		require_once("../../shared/class_folder/class_fecha.php");
		$io_fecha=new class_fecha();				
		require_once("../class_folder/class_funciones_nomina.php");
		$io_fun_nomina=new class_funciones_nomina();
		//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
		$ls_desnom=$_SESSION["la_nomina"]["desnom"];
		$ls_peractnom=$_SESSION["la_nomina"]["peractnom"];
		$ld_fecdesper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fecdesper"]);
		$ld_fechasper=$io_funciones->uf_convertirfecmostrar($_SESSION["la_nomina"]["fechasper"]);
		$ls_titulo="<b>Monto Ejecutado por Tipo de Cargos</b>";
		$ls_periodo="<b>Per�odo Nro ".$ls_peractnom.", ".$ld_fecdesper." - ".$ld_fechasper."</b>";
		//--------------------------------------------------------------------------------------------------------------------------------
		$lb_valido=uf_insert_seguridad($ls_titulo,$ls_desnom,$ls_periodo); // Seguridad de Reporte
		if($lb_valido)
		{
			$lb_valido=$io_report->uf_monejepensionado_programado(); // Obtenemos el detalle del reporte
		}
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
			$io_pdf->ezSetCmMargins(3.5,2.5,3,3); // Configuraci�n de los margenes en cent�metros
			uf_print_encabezado_pagina($ls_titulo,$ls_desnom,$ls_periodo,$io_pdf); // Imprimimos el encabezado de la p�gina
			$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
			$li_totrow=$io_report->DS->getRowCount("codrep");
			$li_totalcargoreal=0;
			$li_totalmontoreal=0;
			uf_print_cabecera($io_pdf);
			for($li_i=1;(($li_i<=$li_totrow)&&($lb_valido));$li_i++)
			{
				$ls_codded=$io_report->DS->data["codded"][$li_i];
				$ls_codtipper=$io_report->DS->data["codtipper"][$li_i];
				switch($ls_codded)
				{
					case "001":
						$ls_desded="DOCENTE";
						break;
					case "002":
						$ls_desded="ADMINISTRATIVO";
						break;
					case "003":
						$ls_desded="OBRERO";
						break;
				}
				switch($ls_codtipper)
				{
					case "0001":
						$ls_destipper="JUBILADO";
						break;
					case "0002":
						$ls_destipper="PENSIONADO";
						break;
					case "0003":
						$ls_destipper="ASIGNACI�N A SOBREVIVIENTE";
						break;
				}
				$li_cargoreal=0;
				$li_montoreal=0;
				$lb_valido=$io_report->uf_monejepensionado_real($ls_codded,$ls_codtipper,$li_cargoreal,$li_montoreal); // Obtenemos los valores reales
				if($lb_valido)
				{
					if($ls_codtipper=="0000")
					{
						$ls_codigo="<b>".$ls_codded."</b>";
						$ls_descripcion="<b>".$ls_desded."</b>";
						$li_totalcargoreal=$li_totalcargoreal+$li_cargoreal;
						$li_totalmontoreal=$li_totalmontoreal+$li_montoreal;
					}
					else
					{
						$ls_codigo=substr($ls_codtipper,1,3);
						$ls_descripcion="					".$ls_destipper;
					}				
					$li_montoreal=$io_fun_nomina->uf_formatonumerico($li_montoreal);
					$la_data[$li_i]=array('codigo'=>$ls_codigo,'descripcion'=>$ls_descripcion,'cargo'=>$li_cargoreal,
										  'monto'=>$li_montoreal);
				}
			}
			uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
			unset($la_data);			
			$li_totalmontoreal=$io_fun_nomina->uf_formatonumerico($li_totalmontoreal);
			$la_data[1]=array('total'=>'<b>Total '.$ls_bolivares.'</b>','cargo'=>$li_totalcargoreal,'monto'=>$li_totalmontoreal);
			uf_print_totales($la_data,$io_pdf); // Imprimimos el detalle 
			unset($la_data);			
			$io_report->DS->resetds("codrep");
			if($lb_valido) // Si no ocurrio ning�n error
			{
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
	}
	else
	{
		print("<script language=JavaScript>");
		print(" alert('Este reporte solo est� disponible para n�minas de jubilados.');"); 
		print(" close();");
		print("</script>");		
	}
?> 