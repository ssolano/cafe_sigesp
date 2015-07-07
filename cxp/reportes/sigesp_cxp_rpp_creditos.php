<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    REPORTE: Listado de Otros Creditos
//  ORGANISMO: Ninguno en particular
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	function uf_insert_seguridad($as_titulo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 11/03/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_cxp;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_cxp->uf_load_seguridad_reporte("CXP","sigesp_cxp_r_listados.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 11/03/2007
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(15,40,585,40);
        $io_pdf->Rectangle(15,700,570,60);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,705,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(540,770,7,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(546,764,6,date("h:i a")); // Agregar la Hora
		// cuadro inferior
        $io_pdf->Rectangle(15,60,570,70);
		$io_pdf->line(15,73,585,73);		
		$io_pdf->line(15,117,585,117);		
		$io_pdf->line(130,60,130,130);		
		$io_pdf->line(240,60,240,130);		
		$io_pdf->line(380,60,380,130);		
		$io_pdf->addText(40,122,7,"ELABORADO POR"); // Agregar el t�tulo
		$io_pdf->addText(42,63,7,"FIRMA / SELLO"); // Agregar el t�tulo
		$io_pdf->addText(157,122,7,"VERIFICADO POR"); // Agregar el t�tulo
		$io_pdf->addText(145,63,7,"FIRMA / SELLO / FECHA"); // Agregar el t�tulo
		$io_pdf->addText(275,122,7,"AUTORIZADO POR"); // Agregar el t�tulo
		$io_pdf->addText(257,63,7,"ADMINISTRACI�N Y FINANZAS"); // Agregar el t�tulo
		$io_pdf->addText(440,122,7,"CONTRALORIA INTERNA"); // Agregar el t�tulo
		$io_pdf->addText(445,63,7,"FIRMA / SELLO / FECHA"); // Agregar el t�tulo
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
			
	function uf_print_detalle($la_data,$as_titcuentas,$ai_i,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//				   as_titcuentas // titulo de estructura presupuestaria
		//				   ai_i // total de registros
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 10/06/2007 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetDy(-2);
		$la_datatit[1]=array('codcar'=>'<b>C�digo</b>','dencar'=>'<b>Denominaci�n</b>','codestpro'=>'<b>'.$as_titcuentas.'</b>',
							 'spg_cuenta'=>'<b>Cuenta</b>','porcar'=>'<b>%</b>','formula'=>'<b>Formula</b>');
		$la_columnas=array('codcar'=>'',
						   'dencar'=>'',
						   'codestpro'=>'',
						   'spg_cuenta'=>'',
						   'porcar'=>'',
						   'formula'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codcar'=>array('justification'=>'center','width'=>40), // Justificaci�n y ancho de la columna
						 			   'dencar'=>array('justification'=>'center','width'=>165), // Justificaci�n y ancho de la columna
						 			   'codestpro'=>array('justification'=>'center','width'=>160), // Justificaci�n y ancho de la columna
						 			   'spg_cuenta'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'porcar'=>array('justification'=>'center','width'=>35), // Justificaci�n y ancho de la columna
						 			   'formula'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_datatit,$la_columnas,'',$la_config);

		$la_columnas=array('codcar'=>'',
						   'dencar'=>'',
						   'codestpro'=>'',
						   'spg_cuenta'=>'',
						   'porcar'=>'',
						   'formula'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('codcar'=>array('justification'=>'left','width'=>40), // Justificaci�n y ancho de la columna
						 			   'dencar'=>array('justification'=>'left','width'=>165), // Justificaci�n y ancho de la columna
						 			   'codestpro'=>array('justification'=>'center','width'=>160), // Justificaci�n y ancho de la columna
						 			   'spg_cuenta'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
						 			   'porcar'=>array('justification'=>'right','width'=>35), // Justificaci�n y ancho de la columna
						 			   'formula'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$la_datatot[1]=array('titulo'=>'<b>Total de Registros: </b>','total'=>$ai_i);
		$la_columnas=array('titulo'=>'<b>Factura</b>',
						   'total'=>'<b>Total</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>540, // Ancho de la tabla
						 'maxWidth'=>540, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('titulo'=>array('justification'=>'right','width'=>470), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_datatot,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_cxp_class_report.php");
	$io_report=new sigesp_cxp_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_cxp.php");
	$io_fun_cxp=new class_funciones_cxp();
	$ls_estmodest=$_SESSION["la_empresa"]["estmodest"];
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>LISTADO DE OTROS CREDITOS</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_orden=$io_fun_cxp->uf_obtenervalor_get("orden","codigo");
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo); // Seguridad de Reporte
	if($lb_valido)
	{

		$lb_valido=$io_report->uf_select_otros_creditos($ls_orden); // Cargar el DS con los datos del reporte
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
			$io_pdf->ezSetCmMargins(3.6,4.5,3,3); // Configuraci�n de los margenes en cent�metros
			$io_pdf->ezStartPageNumbers(570,47,8,'','',1); // Insertar el n�mero de p�gina
			$li_totrow=$io_report->DS->getRowCount("codigo");
			for($li_i=1;$li_i<=$li_totrow;$li_i++)
			{
				$ls_codcar=$io_report->DS->data["codigo"][$li_i];
				$ls_dencar=$io_report->DS->data["denominacion"][$li_i];
				$ls_codestpro=$io_report->DS->data["codestpro"][$li_i];
				$io_fun_cxp->uf_formatoprogramatica($ls_codestpro,&$ls_programatica);
				$ls_spgcuenta=$io_report->DS->data["spg_cuenta"][$li_i];
				$li_porcar=$io_report->DS->data["porcar"][$li_i];
				$ls_formula=$io_report->DS->data["formula"][$li_i];
				$li_porcar=number_format($li_porcar,2,',','.');
				if($ls_estmodest==1)
				{
					$ls_codestpro=substr($ls_codestpro,0,29);
					$ls_titcuentas="Estructura Presupuestaria";
				}
				else
				{
					$ls_codestpro=substr($ls_codestpro,20,-2)." - ".substr($ls_codestpro,26,-2)." - ".substr($ls_codestpro,29,-2)." - ".substr($ls_codestpro,31,-2)." - ".substr($ls_codestpro,33,-2);
					$ls_titcuentas="Estructura Programatica";
				}
				$la_data[$li_i]=array('codcar'=>$ls_codcar,'dencar'=>$ls_dencar,'codestpro'=>$ls_programatica,
									  'spg_cuenta'=>$ls_spgcuenta,'porcar'=>$li_porcar,'formula'=>$ls_formula);
			}
			uf_print_encabezado_pagina($ls_titulo,&$io_pdf);
			uf_print_detalle($la_data,$ls_titcuentas,$li_totrow,&$io_pdf);
		}
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
		
	}

?>
