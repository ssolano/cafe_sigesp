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
	function uf_print_encabezado_pagina($as_titulo,$as_cmpent,$ad_fecha,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_cmpent // numero de comprobante de entrega
		//	    		   ad_fecha // Fecha 
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 26/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->rectangle(261,530,325,25);
		$io_pdf->rectangle(290,535,10,10);
		$io_pdf->line(290,535,300,545);		
		$io_pdf->line(290,545,300,535);		
		$io_pdf->addText(305,535,10,"BIENES MUEBLES"); // Agregar texto
		$io_pdf->rectangle(420,535,10,10);
		$io_pdf->addText(435,535,10,"MATERIALES Y SUMINISTROS"); // Agregar texto
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],12,540,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$io_pdf->addText(45,542,8,"<b>Coordinaci�n de Bienes Nacionales</b>"); // Agregar la Fecha
		$io_pdf->addText(65,532,8,"<b>Ministerio de Finanzas</b>"); // Agregar la Fecha
		$io_pdf->addText(70,523,8,"<b>Sistema SIGECOF</b>"); // Agregar la Fecha
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=386-($li_tm/2);
		$io_pdf->addText($tm,560,11,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(650,550,10,"No.:  ".$as_cmpent); // Agregar la Fecha
		$io_pdf->addText(650,530,10,"FECHA:  ".$ad_fecha); // Agregar la Fecha
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_codemp,$as_nomemp,$as_coduniadm,$as_denuniadm,$as_codunisol,$as_denunisol,$as_cedres,$as_nomres,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_codemp     // codigo de empresa
		//	    		   as_nomemp     // nombre de empresa
		//	    		   ls_coduniadm  // codigo de unidad administrativas
		//	    		   ls_denuniadm  // denominacion de unidad administrativas
		//	    		   ls_codres     // codigo de responsable
		//	    		   ls_nomres     // nombre de responsable
		//	    		   io_pdf        // total de registros que va a tener el reporte
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Arnaldo Su�rez
		// Fecha Creaci�n: 09/06/2008 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->rectangle(17,400,748,120);
		$io_pdf->addText(45,511,9,"<b>ORGANISMO</b>"); // Agregar texto
		$io_pdf->addText(30,495,9,"Codigo: ".$as_codemp); // Agregar texto
		$io_pdf->addText(135,495,9,"Denominacion: ".$as_nomemp); // Agregar texto
		$io_pdf->line(130,508,130,492);   //linea vertical
		$io_pdf->line(17,508,765,508);
		$io_pdf->line(17,490,765,490);  // linea horizontal
		$io_pdf->addText(45,479,9,"<b>UNIDAD ADMINISTRADORA</b>"); // Agregar texto
		$io_pdf->addText(30,461,9,"Codigo: ".$as_coduniadm); // Agregar texto
		$io_pdf->addText(135,461,9,"Denominacion: ".$as_denuniadm); // Agregar texto
		$io_pdf->line(130,475,130,456);
		$io_pdf->line(17,475,765,475);
		$io_pdf->line(17,455,765,455);  // linea horizontal
		$io_pdf->addText(45,445,9,"<b>DEPENDENCIA USUARIA (UNIDAD SOLICITANTE)</b>"); // Agregar texto
		$io_pdf->line(17,440,765,440);  // linea horizontal
		$io_pdf->line(130,420,130,440);   //linea vertical
		$io_pdf->addText(30,430,9,"Codigo: ".$as_codunisol); // Agregar texto
		$io_pdf->addText(135,427,9,"Denominacion:".$as_denunisol); // Agregar texto
		$io_pdf->line(17,420,765,420);  // linea horizontal
		$io_pdf->addText(45,410,9,"<b>ALMACEN </b>"); // Agregar texto
		$io_pdf->ezSetY(402);
		$la_data[1]=array('cantidad'=>'<b>C�digo</b>',
						  'catalogo'=>'<b>Denominaci�n</b>',
						  'codact'=>'<b>RESPONSABLE</b>');
		$la_columna=array('cantidad'=>'',
						  'catalogo'=>'',
						  'codact'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>760, // Ancho de la tabla
						 'maxWidth'=>760, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('cantidad'=>array('justification'=>'center','width'=>118), // Justificaci�n y ancho de la columna
						 			   'catalogo'=>array('justification'=>'center','width'=>220), // Justificaci�n y ancho de la columna
						 			   'codact'=>array('justification'=>'center','width'=>409))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columnas);
		unset($la_config);
		$la_data[2]=array('canti'=>'<b></b>',
						  'cata'=>'<b> COORDINACION DE ALMACEN </b>',
						  'coda'=>'<b> C.I.      </b>'.$as_cedres.'             Apellidos y Nombres: '.$as_nomres);
		$la_columna=array('canti'=>'',
						  'cata'=>'',
						  'coda'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>760, // Ancho de la tabla
						 'maxWidth'=>760, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('canti'=>array('justification'=>'center','width'=>118), // Justificaci�n y ancho de la columna
						 			   'cata'=>array('justification'=>'left','width'=>220), // Justificaci�n y ancho de la columna
						 			   'coda'=>array('justification'=>'left','width'=>409))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
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
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//$io_pdf->ezSetY(362);
		$la_data_tit[1]=array('cantidad'=>'<b>Cantidad</b>',
						      'catalogo'=>'<b>C�digo del Cat�logo</b>',
						      'codact'=>'<b>Numero de Inventario del bien (Solo para Bienes Muebles)</b>',
						      'denact'=>'<b>Descripci�n</b>',
						      'costo'=>'<b>Valor Unitario</b>',
						      'total'=>'<b>Valor Total</b>');
		$la_columna=array('cantidad'=>'',
						  'catalogo'=>'',
						  'codact'=>'',
						  'denact'=>'',
						  'costo'=>'',
						  'total'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('cantidad'=>array('justification'=>'center','width'=>45), // Justificaci�n y ancho de la columna
						 			   'catalogo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'codact'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'denact'=>array('justification'=>'center','width'=>253), // Justificaci�n y ancho de la columna
						 			   'costo'=>array('justification'=>'center','width'=>145), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'center','width'=>145))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data_tit,$la_columna,'',$la_config);
		unset($la_data_tit);
		unset($la_columnas);
		unset($la_config);
		$la_columna=array('cantidad'=>'',
						  'catalogo'=>'',
						  'codact'=>'',
						  'denact'=>'',
						  'costo'=>'',
						  'total'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('cantidad'=>array('justification'=>'center','width'=>45), // Justificaci�n y ancho de la columna
						 			   'catalogo'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
						 			   'codact'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'denact'=>array('justification'=>'left','width'=>253), // Justificaci�n y ancho de la columna
						 			   'costo'=>array('justification'=>'right','width'=>145), // Justificaci�n y ancho de la columna
						 			   'total'=>array('justification'=>'right','width'=>145))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_totales($as_nomrec,$as_cedrec,$as_carrec,$as_nomdes,$as_ceddes,$as_cardes,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_totales
		//		   Access: private 
		//	    Arguments: as_nomrec  // nombre del receptor
		//	   			   as_cedrec  // cedula del receptor
		//	   			   as_carrec  // cargo del receptor
		//                 as_nomdes  // nombre del despachador
		//	   			   as_ceddes  // cedula del despachador
		//	   			   as_cardes  // cargo del despachador
		//	   			   io_pdf // Instancia de objeto pdf
		//    Description: funcion que imprime el cuadro inferior del responsable
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 27/09/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->rectangle(17,30,748,120);
		$io_pdf->line(17,125,765,125);
		$io_pdf->line(17,110,765,110);
		$io_pdf->line(17,95,765,95);
		$io_pdf->addText(165,135,9,"<b>DESPACHADOR</b>"); // Agregar texto
		$io_pdf->addText(18,115,9,"<b>Apellidos y Nombres</b>"); // Agregar texto
		$io_pdf->addText(120,115,9,$as_nomdes); // Agregar texto
		$io_pdf->addText(18,100,9,"<b>C�dula de Identidad</b>"); // Agregar texto
		$io_pdf->line(374,30,374,150); // Linea del Centro
		$io_pdf->addText(120,100,9,$as_ceddes); // Agregar texto
		$io_pdf->addText(180,100,9,"<b>Cargo</b>"); // Agregar texto
		$io_pdf->addText(300,100,9,$as_cardes); // Agregar texto
		$io_pdf->addText(539,135,9,"<b>RECEPTOR</b>"); // Agregar texto
		$io_pdf->addText(375,115,9,"<b>Apellidos y Nombres</b>"); // Agregar texto
		$io_pdf->addText(475,115,9,$as_nomrec); // Agregar texto
		$io_pdf->addText(375,100,9,"<b>C�dula de Identidad</b>"); // Agregar texto
		$io_pdf->addText(475,100,9,$as_cedrec); // Agregar texto
		$io_pdf->addText(537,100,9,"<b>Cargo</b>"); // Agregar texto
		$io_pdf->addText(595,100,9,$as_carrec); // Agregar texto
		$io_pdf->line(75,50,300,50); // Linea de Firma de Despachador
		$io_pdf->addText(150,40,9,"<b>FIRMA Y SELLO</b>"); // Firma y Sello del Despachador
		$io_pdf->line(460,50,685,50); // Linea de Firma de Receptor
		$io_pdf->addText(540,40,9,"<b>FIRMA Y SELLO</b>"); // Firma y Sello del Receptor
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_totales
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_funciones_activos.php");
	$io_fun_activos=new class_funciones_activos("../../");
	require_once("sigesp_saf_class_report.php");
	$io_report=new sigesp_saf_class_report();
	$ls_titulo_report="Bs.";
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>COMPROBANTE DE ENTREGA </b>";
	$ls_fecha="";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$arre=$_SESSION["la_empresa"];
	$ls_codemp=$arre["codemp"];
	$ls_nomemp=$arre["nombre"];
	$ls_cmpent=$io_fun_activos->uf_obtenervalor_get("cmpent","");
	$ld_feccmp=$io_fun_activos->uf_obtenervalor_get("feccmp","");
	$ls_coduniadm=$io_fun_activos->uf_obtenervalor_get("coduniadm","");
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=$io_report->uf_saf_load_cmpentrega($ls_codemp,$ls_cmpent,$ld_feccmp,$ls_coduniadm); // Cargar el DS con los datos de la cabecera del reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_saf_load_unidadadministrativas($ls_codemp,$ls_coduniadm,$ls_denuniadm);
		$ls_codunisol=$io_report->ds->data["codunisol"][1];
		if ($ls_codunisol != '----------')
		{
		 $lb_valido=$io_report->uf_saf_load_unidadadministrativas($ls_codemp,$ls_codunisol,$ls_denunisol);
		}
		else
		{
		 $ls_codunisol = "";
		 $ls_denunisol = "";
		}
		if($lb_valido)
		{
			$lb_valido = $io_report->uf_saf_load_dt_cmpentrega($ls_codemp,$ls_cmpent,$ld_feccmp,$ls_coduniadm);
		}
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
		/////////////////////////////////         SEGURIDAD               ////////////////////////////////////////////////////////
		$ls_desc_event=" Gener� el reporte de Comprobante de Entrega. ";
		$io_fun_activos->uf_load_seguridad_reporte("SAF","sigesp_saf_p_entrega.php",$ls_desc_event);
		////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////////////////
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','landscape'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(8.35,5.5,3,3); // Configuraci�n de los margenes en cent�metros
		$ld_fecha=$io_report->ds->data["feccmp"][1];
		$ld_fecha=$io_funciones->uf_convertirfecmostrar($ld_fecha);
		uf_print_encabezado_pagina($ls_titulo,$ls_cmpent,$ld_fecha,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->transaction('start'); // Iniciamos la transacci�n
		$li_numpag=$io_pdf->ezPageCount; // N�mero de p�gina
		$ls_cmpent=$io_report->ds->data["cmpent"][1];
		$ld_fecent=$io_report->ds->data["fecent"][1];
		$ls_nomres=$io_report->ds->data["nomres"][1];
		$ls_nomrec=$io_report->ds->data["nomrec"][1];
		$ls_nomdes=$io_report->ds->data["nomdes"][1];
		$ls_codres=$io_report->ds->data["cedres"][1];
		$ls_codrec=$io_report->ds->data["cedrec"][1];
		$ls_coddes=$io_report->ds->data["ceddes"][1];
		$ls_carres=$io_report->ds->data["carres"][1];
		$ls_carrec=$io_report->ds->data["carrec"][1];
		$ls_cardes=$io_report->ds->data["cardes"][1];
		uf_print_cabecera($ls_codemp,$ls_nomemp,$ls_coduniadm,$ls_denuniadm,$ls_codunisol,$ls_denunisol,$ls_codres,$ls_nomres,$io_pdf); // Imprimimos la cabecera del registro
		uf_print_totales($ls_nomrec,$ls_codrec,$ls_carrec,$ls_nomdes,$ls_coddes,$ls_cardes,$io_pdf);
		if($lb_valido)
		{
			$li_totrow_det=$io_report->ds_detalle->getRowCount("codact");
			for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
			{   
			    $ls_codart=       $io_report->ds_detalle->data["codact"][$li_s];
				$ls_denart=       $io_report->ds_detalle->data["denact"][$li_s];
				$ls_catalogo=     $io_report->ds_detalle->data["catalogo"][$li_s];
				$li_costo=        $io_report->ds_detalle->data["costo"][$li_s];
				$li_cantidad=     $io_report->ds_detalle->data["cantidad"][$li_s];
				$li_total=($li_costo * $li_cantidad);
				$li_cantidad=$io_fun_activos->uf_formatonumerico($li_cantidad);
				$li_costo=$io_fun_activos->uf_formatonumerico($li_costo);
				$li_total=$io_fun_activos->uf_formatonumerico($li_total);
			    $la_data[$li_s]=array('cantidad'=>$li_cantidad,'catalogo'=>$ls_catalogo,'codact'=>$ls_codart,'denact'=>$ls_denart,'costo'=>$li_costo,'total'=>$li_total);
				}
			}
			uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
		}
		unset($la_data);			
		unset($la_datat);			
		if($lb_valido)
		{
			$io_pdf->ezStopPageNumbers(1,1);
			$io_pdf->ezStream();
		}
	unset($io_pdf);
	unset($io_report);
	unset($io_funciones);
	unset($io_fun_nomina);
?> 