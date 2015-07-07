<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    REPORTE: Reporte de Recepciones de Documentos
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
		$lb_valido=$io_fun_cxp->uf_load_seguridad_reporte("CXP","sigesp_cxp_r_ubicacion_recepciondocumento.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_tipproben,$as_codprobendes,$as_codprobenhas,$as_nomprobendes,$as_nomprobenhas,&$io_pdf)
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
		$io_pdf->line(15,40,775,40);
        $io_pdf->Rectangle(10,530,762,60);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,535,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=396-($li_tm/2);
		$io_pdf->addText($tm,570,11,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(730,598,7,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(736,591,6,date("h:i a")); // Agregar la Hora
		if(($as_codprobendes!="")&&($as_codprobendes!=""))
		{
			switch($as_tipproben)
			{
				case"P":
					if($as_codprobendes==$as_codprobenhas)
					{
						$ls_criterio="Proveedor: ".$as_codprobendes." - <b>".$as_nomprobendes."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,540,8,$ls_criterio); // Agregar el t�tulo
					
					}
					else
					{
						$ls_criterio="Proveedores: ";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,555,8,$ls_criterio); // Agregar el t�tulo
						$ls_criterio="Desde: ".$as_codprobendes." - <b>".$as_nomprobendes."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,545,8,$ls_criterio); // Agregar el t�tulo
						$ls_criterio="Hasta: ".$as_codprobenhas." - <b>".$as_nomprobenhas."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,535,8,$ls_criterio); // Agregar el t�tulo
					}
				break;
				case"B":
					if($as_codprobendes==$as_codprobenhas)
					{
						$ls_criterio="Beneficiario: ".$as_codprobendes." - <b>".$as_nomprobendes."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,540,8,$ls_criterio); // Agregar el t�tulo
					
					}
					else
					{
						$ls_criterio="Beneficiarios: ";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,555,8,$ls_criterio); // Agregar el t�tulo
						$ls_criterio="Desde: ".$as_codprobendes." - <b>".$as_nomprobendes."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,545,8,$ls_criterio); // Agregar el t�tulo
						$ls_criterio="Hasta: ".$as_codprobenhas." - <b>".$as_nomprobenhas."</b>";
						$li_tm=$io_pdf->getTextWidth(8,$ls_criterio);
						$tm=396-($li_tm/2);
						$io_pdf->addText($tm,535,8,$ls_criterio); // Agregar el t�tulo
					}
				break;
			}
		}
		// cuadro inferior
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_recepcion($la_data,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//				   li_totaldoc // acumulado del total
		//				   li_totalcar // acumulado de los cargos
		//				   li_totalded // acumulado de las deducciones
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime el detalle de las recepciones de documentos
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 20/05/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->ezSetY(520);

		$la_datatit[1]=array('numrecdoc'=>'<b>Nro de Recepci�n</b>',
							 'tipo'=>'<b>Tipo de Recepci�n</b>',
							 'nombre'=>'<b>Proveedor / Beneficiario</b>',
							 'estatus'=>'<b>Estatus de Recepci�n</b>',
							 'solicitud'=>'<b>Solicitud de Pago</b>',
							 'estatussol'=>'<b>Estatus Solicitud</b>');
		$la_columnas=array('numrecdoc'=>'<b>Nro de Recepci�n</b>',
						   'tipo'=>'<b>Tipo de Recepci�n</b>',
						   'nombre'=>'<b>Proveedor / Beneficiario</b>',
						   'estatus'=>'<b>Estatus de Recepci�n</b>',
						   'solicitud'=>'<b>Solicitud de Pago</b>',
						   'estatussol'=>'<b>Estatus Solicitud</b>');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>760, // Ancho de la tabla
						 'maxWidth'=>760, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'cols'=>array('numrecdoc'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'tipo'=>array('justification'=>'center','width'=>120), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'center','width'=>260), // Justificaci�n y ancho de la columna
						 			   'estatus'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'solicitud'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'estatussol'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_datatit,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');

		$la_columnas=array('numrecdoc'=>'<b>Nro de Recepci�n</b>',
						   'tipo'=>'<b>Tipo de Recepci�n</b>',
						   'nombre'=>'<b>Proveedor / Beneficiario</b>',
						   'estatus'=>'<b>Estatus de Recepci�n</b>',
						   'solicitud'=>'<b>Solicitud de Pago</b>',
						   'estatussol'=>'<b>Estatus Solicitud</b>');
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
						 'cols'=>array('numrecdoc'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'tipo'=>array('justification'=>'center','width'=>120), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>260), // Justificaci�n y ancho de la columna
						 			   'estatus'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'solicitud'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'estatussol'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------

	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_cxp_class_report.php");
	$io_report=new sigesp_cxp_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_cxp.php");
	$io_fun_cxp=new class_funciones_cxp();
	//Instancio a la clase de conversi�n de numeros a letras.
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>UBICACI�N DE RECEPCIONES DE DOCUMENTOS</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_tipproben=$io_fun_cxp->uf_obtenervalor_get("tipproben","");
	$ls_codprobendes=trim($io_fun_cxp->uf_obtenervalor_get("codprobendes",""));
	$ls_codprobenhas=trim($io_fun_cxp->uf_obtenervalor_get("codprobenhas",""));
	$ld_fecregdes=$io_fun_cxp->uf_obtenervalor_get("fecregdes","");
	$ld_fecreghas=$io_fun_cxp->uf_obtenervalor_get("fecreghas","");
	$ls_codtipdoc=$io_fun_cxp->uf_obtenervalor_get("codtipdoc","");
	$ls_registrada=$io_fun_cxp->uf_obtenervalor_get("registrada","");
	$ls_anulada=$io_fun_cxp->uf_obtenervalor_get("anulada","");
	$ls_procesada=$io_fun_cxp->uf_obtenervalor_get("procesada","");
	$ls_orden=$io_fun_cxp->uf_obtenervalor_get("orden","");
	$ls_numrecdoc=$io_fun_cxp->uf_obtenervalor_get("numrecdoc","");
	$ls_nomprobendes="";
	$ls_nomprobenhas="";
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo); // Seguridad de Reporte
	if($lb_valido)
	{

		$lb_valido=$io_report->uf_select_ubicacion_recepciones($ls_tipproben,$ls_codprobendes,$ls_codprobenhas,$ld_fecregdes,$ld_fecreghas,
													 		   $ls_codtipdoc,$ls_registrada,$ls_anulada,$ls_procesada,$ls_orden,$ls_numrecdoc); // Cargar el DS con los datos del reporte
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
			$io_pdf=new Cezpdf('LETTER','landscape'); // Instancia de la clase PDF
			$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
			$io_pdf->ezSetCmMargins(4.1,3,3,3); // Configuraci�n de los margenes en cent�metros
			$io_pdf->ezStartPageNumbers(770,47,8,'','',1); // Insertar el n�mero de p�gina
			if($ls_codprobendes!="")
			{
				$ls_nomprobendes=$io_report->uf_select_proveedores($ls_tipproben,$ls_codprobendes);
			}
			if($ls_codprobenhas!="")
			{
				$ls_nomprobenhas=$io_report->uf_select_proveedores($ls_tipproben,$ls_codprobenhas);
			}
			$li_i=0;
			while (!$io_report->rs_data->EOF)
			{
				$ls_numrecdoc= $io_report->rs_data->fields["numrecdoc"];
				$ls_nombre= $io_report->rs_data->fields["nombre"]; 
				$ls_dentipdoc= $io_report->rs_data->fields["dentipdoc"]; 
				$ls_estprodoc= $io_report->rs_data->fields["estprodoc"]; 
				$ls_numsol= $io_report->rs_data->fields["numsol"]; 
				$ls_estprosol= $io_report->rs_data->fields["estprosol"]; 
				switch($ls_estprodoc)
				{
					case "R": 
						$ls_estprodoc="Recibida";
						break;
					case "E": 
						$ls_estprodoc="Emitida";
						break;
					case "C": 
						$ls_estprodoc="Contabilizada";
						break;
					case "A": 
						$ls_estprodoc="Anulada";
						break;
				}
				switch ($ls_estprosol)
				{
					case "R":
						$ls_estprosol="Registro";
						break;
						
					case "S":
						$ls_estprosol="Programaci�n de Pago";
						break;
						
					case "P":
						$ls_estprosol="Cancelada";
						break;

					case "A":
						$ls_estprosol="Anulada";
						break;
						
					case "C":
						$ls_estprosol="Contabilizada";
						break;
						
					case "E":
						$ls_estprosol="Emitida";
						break;
						
					case "N":
						$ls_estprosol="Anulada Sin Afectaci�n";
						break;
				}
				$la_data[$li_i]=array('numrecdoc'=>$ls_numrecdoc,'tipo'=>$ls_dentipdoc, 'nombre'=>$ls_nombre,'estatus'=>$ls_estprodoc,'solicitud'=>$ls_numsol,
									  'estatussol'=>$ls_estprosol);
				$li_i++;
				$io_report->rs_data->MoveNext();
			}
			uf_print_encabezado_pagina($ls_titulo,$ls_tipproben,$ls_codprobendes,$ls_codprobenhas,$ls_nomprobendes,$ls_nomprobenhas,&$io_pdf);
			uf_print_detalle_recepcion($la_data,&$io_pdf);
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
	}

?>
