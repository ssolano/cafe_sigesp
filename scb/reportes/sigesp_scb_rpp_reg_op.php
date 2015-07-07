<?php
    session_start(); 
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "opener.document.form1.submit();";
		print "close();";
		print "</script>";		
	}

	//--------------------------------------------------------------------------------------------------------------------------------	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(20,40,578,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,700,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(500,730,10,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_nomban,$as_tipcta,$as_ctaban,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_nomban // Nombre del banco
		//	    		   as_tipcta // tipo de cuenta Banacaria
		//	    		   as_ctaban // n�mero de cuenta banacaria
		//	    		   io_pdf // total de registros que va a tener el reporte
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data[1]=array('banco'=>'<b>Banco</b> '.$as_nomban,'cuenta'=>'<b>Tipo Cuenta</b> '.$as_tipcta);
		$la_columna=array('banco'=>'','cuenta'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('banco'=>array('justification'=>'left','width'=>250), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'left','width'=>250))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('cuenta'=>'<b>Cuenta</b> '.$as_ctaban);
		$la_columna=array('cuenta'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>2, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('cuenta'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($as_numdoc,$ls_codope,$ad_fecmov,$as_nomproben,$adec_monto,$as_estmov,$as_conmov,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: as_numdoc // N�mero del documento
		//	    		   ad_fecmov // fecha del movimiento
		//	    		   as_nomproben // nombre del proveedor
		//	    		   adec_monto // monto
		//	    		   as_estmov // estatus
		//	    		   as_conmov //concepto
		//	    		   io_pdf // objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data[1]=array('documento'=>$as_numdoc,'codope'=>$ls_codope,'fecha'=>$ad_fecmov,'beneficiario'=>$as_nomproben,
						  'monto'=>$adec_monto,'status'=>$as_estmov);
		$la_columna=array('documento'=>'<b>Documento</b>','codope'=>'<b>Operacion</b>','fecha'=>'<b>Fecha</b>','beneficiario'=>'<b>Beneficiario</b>',
						  'monto'=>'<b>Monto</b>','status'=>'<b>Estatus</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'rowGap' => 0.5,
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('documento'=>array('justification'=>'center','width'=>90), // Justificaci�n y ancho de la columna
						 			   'codope'=>array('justification'=>'center','width'=>60), // Justificaci�n y ancho de la columna
									   'fecha'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'beneficiario'=>array('justification'=>'left','width'=>100), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>120), // Justificaci�n y ancho de la columna
						 			   'status'=>array('justification'=>'center','width'=>50))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('concepto'=>'<b>Concepto</b>    '.$as_conmov);
		$la_columna=array('concepto'=>'<b>Concepto</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center'); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_contable($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_contable
		//		   Access: private 
		//	    Arguments: la_data // arreglo con la data a imprimir
		//	    		   io_pdf // objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('cuenta'=>'<b>Cuenta</b>','debe'=>'<b>Debe</b>','haber'=>'<b>Haber</b>',
						  'descripcion'=>'<b>Descripci�n</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'rowGap' => 0.5,
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('cuenta'=>array('justification'=>'left','width'=>80), // Justificaci�n y ancho de la columna
						 			   'debe'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'haber'=>array('justification'=>'right','width'=>80), // Justificaci�n y ancho de la columna
						 			   'descripcion'=>array('justification'=>'left','width'=>260))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'<b>Detalle Contabilidad</b>',$la_config);	
	}// end function uf_print_detalle_contable
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_presupuestario($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_presupuestario
		//		   Access: private 
		//	    Arguments: la_data // arreglo con la data a imprimir
		//	    		   io_pdf // objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('programatica'=>'<b>Program�tica</b>','cuenta'=>'<b>Cuenta</b>','monto'=>'<b>Monto</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' =>8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'rowGap' => 0.5,
						 'width'=>400, // Ancho de la tabla
						 'maxWidth'=>400, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('programatica'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
						 			   'cuenta'=>array('justification'=>'left','width'=>100), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'<b>Detalle Presupuestario de Gasto</b>',$la_config);	
	}// end function uf_print_detalle_presupuestario
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_ingreso($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle_ingreso
		//		   Access: private 
		//	    Arguments: la_data // arreglo con la data a imprimir
		//	    		   io_pdf // objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_columna=array('cuenta'=>'<b>Cuenta</b>','monto'=>'<b>Monto</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' =>8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'rowGap' => 0.5,
						 'width'=>400, // Ancho de la tabla
						 'maxWidth'=>400, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('cuenta'=>array('justification'=>'left','width'=>300), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'<b>Detalle Presupuestario de Ingreso</b>',$la_config);	
	}// end function uf_print_detalle_ingreso
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_fin_detalle(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_fin_detalle
		//		   Access: private 
		//	    Arguments: as_numdoc // N�mero del documento
		//	    		   ad_fecmov // fecha del movimiento
		//	    		   as_nomproben // nombre del proveedor
		//	    		   adec_monto // monto
		//	    		   as_estmov // estatus
		//	    		   as_conmov //concepto
		//	    		   io_pdf // objeto pdf
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data[1]=array('raya'=>'_________________________________________________________________________________________________');
		$la_columna=array('raya'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center'); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
	}// end function uf_print_fin_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_totales($ad_total,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_totales
		//		   Access: private 
		//	    Arguments: ad_total // monto total 
		//	    		   io_pdf // total de registros que va a tener el reporte
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data[1]=array('name'=>'', 'monto'=>'');
		$la_data[2]=array('name'=>'<b>Total:</b>', 'monto'=>$ad_total);
		$la_columna=array('name'=>'','monto'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 10, // Tama�o de Letras
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Justificaci�n y ancho de la columna
						 'cols'=>array('name'=>array('justification'=>'right','width'=>400), // Justificaci�n y ancho de la columna
						 			   'monto'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);	
		unset($la_data);
		unset($la_columna);
		unset($la_config);
	}// end function uf_print_totales
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("../../shared/class_folder/sigesp_include.php");
	$sig_inc=new sigesp_include();
	$con=$sig_inc->uf_conectar();
	require_once("sigesp_scb_class_report.php");
	$class_report=new sigesp_scb_class_report($con);
	require_once("../../shared/class_folder/class_datastore.php");
	$ds_movimientos=new class_datastore();
	$ds_dt_scg=new class_datastore();
	$ds_dt_spg=new class_datastore();
	$ds_dt_spi=new class_datastore();
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ld_fecdesde=$_GET["fecdes"];
	$ld_fechasta=$_GET["fechas"];
	$ls_codope=$_GET["codope"];
	$ls_codban=$_GET["codban"];
	$ls_ctaban=$_GET["ctaban"];
	$ls_codconcep=$_GET["codconcep"];
	$ls_orden=$_GET["orden"];
	$ls_titulo="Listado de Movimientos de Orden de Pago Directa";
	$lb_valido=true;
	$class_report->uf_cargar_documentos_op($ls_codope,$ld_fecdesde,$ld_fechasta,$ls_codban,$ls_ctaban,$ls_codconcep,$ls_orden);
	$ds_movimientos->data=$class_report->ds_documentos->data;
	$ldec_total=0;
	$li_total=$ds_movimientos->getRowCount("numdoc");
	if($li_total>0)
	{
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(3.5,3,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		$ls_nomban1="";
		$ls_tipcta1="";
		$ls_ctaban1="";
		for($i=1;$i<=$li_total;$i++)
		{
			$li_contscg=0;
			$li_contspg=0;
			$ls_numdoc=$ds_movimientos->getValue("numdoc",$i);
			$ls_codban=$ds_movimientos->getValue("codban",$i);
			$ls_codope=$ds_movimientos->getValue("codope",$i);
			$ldec_monto=$ds_movimientos->getValue("monto",$i);
			$ld_fecmov=$ds_movimientos->getValue("fecmov",$i);
			$ld_fecmov=$class_report->fun->uf_convertirfecmostrar($ld_fecmov);
			$ls_nomproben=$ds_movimientos->getValue("nomproben",$i);
			$ls_conmov=$ds_movimientos->getValue("conmov",$i);
			$ls_dencta=$ds_movimientos->getValue("dencta",$i);	
			$ls_estmov=$ds_movimientos->getValue("estmov",$i);
			$ls_nomban=$ds_movimientos->getValue("nomban",$i);
			$ls_tipcta=$ds_movimientos->getValue("nomtipcta",$i);
			$ls_ctaban=$ds_movimientos->getValue("ctaban",$i);
			$ls_nombanbene=$ds_movimientos->getValue("nombanbene",$i);
			$ls_ctabanbene=$ds_movimientos->getValue("ctabanbene",$i);
			if(($ls_nomban1=="")&&($ls_tipcta1=="")&&($ls_ctaban1==""))
			{
				uf_print_cabecera($ls_nomban,$ls_tipcta,$ls_ctaban,$io_pdf);
				$ls_nomban1=$ls_nomban;
				$ls_tipcta1=$ls_tipcta;
				$ls_ctaban1=$ls_ctaban;
			}
			if(($ls_nomban1!=$ls_nomban)&&($ls_tipcta1!=$ls_tipcta)&&($ls_ctaban1!=$ls_ctaban))
			{
				uf_print_cabecera($ls_nomban,$ls_tipcta,$ls_ctaban,$io_pdf);
				$ls_nomban1=$ls_nomban;
				$ls_tipcta1=$ls_tipcta;
				$ls_ctaban1=$ls_ctaban;
			}

			uf_print_detalle($ls_numdoc,$ls_codope,$ld_fecmov,$ls_nomproben,number_format($ldec_monto,2,",","."),$ls_estmov,$ls_conmov,$io_pdf);

			//Obtengo el detalle contable del movimiento.
			unset($ds_dt_scg->data);
			$ds_dt_scg->data=$class_report->uf_cargar_dt_scg($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope,$ls_estmov);
			$li_totscg=$ds_dt_scg->getRowCount("scg_cuenta");
			if($li_totscg>0)
			{
				for($li_a=1;$li_a<=$li_totscg;$li_a++)
				{
					$ls_debhab=$ds_dt_scg->getValue("debhab",$li_a);
					if($ls_debhab=="D")
					{
						$ldec_mondeb=number_format($ds_dt_scg->getValue("monto",$li_a),2,",",".");
						$ldec_monhab="";
					}
					else
					{
						$ldec_monhab=number_format($ds_dt_scg->getValue("monto",$li_a),2,",",".");
						$ldec_mondeb="";
					}
					$la_data[$li_a]=array('cuenta'=>$ds_dt_scg->getValue("scg_cuenta",$li_a),'debe'=>$ldec_mondeb,
										  'haber'=>$ldec_monhab, 'descripcion'=>$ds_dt_scg->getValue("desmov",$li_a));
				}
				uf_print_detalle_contable($la_data,$io_pdf);
				unset($la_data);
			}
			//Obtengo el detalle presupuestario del movimiento.
			unset($ds_dt_spg->data);
			$ds_dt_spg->data=$class_report->uf_cargar_dt_spg_op($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope,$ls_estmov);
			$li_totspg=$ds_dt_spg->getRowCount("spg_cuenta");
			if($li_totspg>0)		
			{
				for($li_b=1;$li_b<=$li_totspg;$li_b++)
				{
					$la_data[$li_b]=array('programatica'=>$ds_dt_spg->getValue("estpro",$li_b),
										  'cuenta'=>$ds_dt_spg->getValue("spg_cuenta",$li_b),
										  'monto'=>number_format($ds_dt_spg->getValue("monto",$li_b),2,",","."));
				}				
				uf_print_detalle_presupuestario($la_data,$io_pdf);
				unset($la_data);
			}

			//Obtengo el detalle presupuestario del movimiento.
			$ds_dt_spi->data=$class_report->uf_cargar_dt_spi($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope,$ls_estmov);
			$li_totspi=$ds_dt_spi->getRowCount("spi_cuenta");
			if($li_totspi>0)		
			{
				for($li_b=1;$li_b<=$li_totspi;$li_b++)
				{				
					$la_data[$li_b]=array('cuenta'=>$ds_dt_spi->getValue("spi_cuenta",$li_b),
										  'monto'=>number_format($ds_dt_spi->getValue("monto",$li_b),2,",","."));
				}
				uf_print_detalle_ingreso($la_data,$io_pdf);
			}
			$ldec_total=$ldec_total+$ldec_monto;
			uf_print_fin_detalle(&$io_pdf);	
		}
		uf_print_totales(number_format($ldec_total,2,",","."),&$io_pdf);
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
	else
	{
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar,para los parametros de Busqueda seleccionados');"); 
		print(" close();");
		print("</script>");
	}
?>