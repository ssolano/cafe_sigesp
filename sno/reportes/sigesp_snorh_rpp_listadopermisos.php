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

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 20/07/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte("SNR","sigesp_snorh_r_listadopermisos.php",$ls_descripcion);
		if($lb_valido==false)
		{
			print("<script language=JavaScript>");
			print(" close();");
			print("</script>");
		}
		return $lb_valido;
	}
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 20/07/2007
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(50,40,755,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,530,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(13,$as_titulo);
		$tm=396-($li_tm/2);
		$io_pdf->addText($tm,540,13,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(712,560,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(718,553,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_cedper,$as_nomper,$as_apeper,$as_estper,$as_dirper,$as_telhabper,$as_telmovper,$as_coreleper,
							   &$io_cabecera,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: as_cedper // C�dula del Personal
		//	    		   as_nomper // Nombre del Personal
		//	    		   as_apeper // Apellido del Personal
		//	    		   as_estper // Estatus del Personal
		//	    		   as_dirper // Direcci�n del Personal
		//	    		   as_telhabper // Tel�fono de Habitaci�n del Personal
		//	    		   as_telmovper // Tel�fono M�vil del Personal
		//	    		   as_coreleper // Correo Electr�nico del Personal
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los datos del Personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 20/07/2007 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
        $io_pdf->setColor(0.9,0.9,0.9);
        $io_pdf->filledRectangle(40,505,705,$io_pdf->getFontHeight(16));
        $io_pdf->setColor(0,0,0);
		$io_pdf->addText(45,510,12,'<b>Datos del Personal</b>'); // Agregar el t�tulo
		$io_pdf->ezSetY(500);
		$la_data[1]=array('titulo1'=>'<b>C�dula</b>','cedula'=>$as_cedper,
						  'titulo2'=>'<b>Nombres</b>','nombre'=>$as_nomper,
						  'titulo3'=>'<b>Apellidos</b>','apellido'=>$as_apeper);
		$la_columna=array('titulo1'=>'','cedula'=>'','titulo2'=>'','nombre'=>'','titulo3'=>'','apellido'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 11, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>690, // Ancho de la tabla
						 'maxWidth'=>690, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'rowGap'=>4,
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo1'=>array('justification'=>'left','width'=>50), // Justificaci�n y ancho de la columna
						 			   'cedula'=>array('justification'=>'left','width'=>80), // Justificaci�n y ancho de la columna
						 			   'titulo2'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>220), // Justificaci�n y ancho de la columna
						 			   'titulo3'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'apellido'=>array('justification'=>'left','width'=>220))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('titulo1'=>'<b>Tel�fono Hab.</b>','habitacion'=>$as_telhabper,
						  'titulo2'=>'<b>Tel�fono Mov.</b>','movil'=>$as_telmovper,
						  'titulo3'=>'<b>Email</b>','email'=>$as_coreleper);
		$la_columna=array('titulo1'=>'','habitacion'=>'','titulo2'=>'','movil'=>'','titulo3'=>'','email'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 11, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>690, // Ancho de la tabla
						 'maxWidth'=>690, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'rowGap'=>4,
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo1'=>array('justification'=>'left','width'=>90), // Justificaci�n y ancho de la columna
						 			   'habitacion'=>array('justification'=>'left','width'=>140), // Justificaci�n y ancho de la columna
						 			   'titulo2'=>array('justification'=>'left','width'=>90), // Justificaci�n y ancho de la columna
						 			   'movil'=>array('justification'=>'left','width'=>140), // Justificaci�n y ancho de la columna
						 			   'titulo3'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'email'=>array('justification'=>'left','width'=>170))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_data[1]=array('titulo1'=>'<b>Direcci�n</b>','direccion'=>$as_dirper);
		$la_columna=array('titulo1'=>'','direccion'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 10, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>690, // Ancho de la tabla
						 'maxWidth'=>690, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				         'outerLineThickness'=>0.5,
						 'innerLineThickness' =>0.5,
						 'rowGap'=>4,
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('titulo1'=>array('justification'=>'left','width'=>60), // Justificaci�n y ancho de la columna
						 			   'direccion'=>array('justification'=>'left','width'=>630))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$la_datos[1]=array('numper'=>'<b>Nro</b>','feciniper'=>'<b>Inicio</b>','fecfinper'=>'<b>Fin</b>','numdiaper'=>'<b>Nro de D�as</b>',
						   'afevacper'=>'<b>Afecta Vacaciones</b>','remper'=>'<b>Remunerado</b>','tipper'=>'<b>Tipo</b>','obsper'=>'<b>Observaci�n</b>');
		$la_columna=array('numper'=>'','feciniper'=>'','fecfinper'=>'','numdiaper'=>'','afevacper'=>'','remper'=>'','tipper'=>'','obsper'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 11, // Tama�o de Letras
						 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>690, // Ancho de la tabla
						 'maxWidth'=>90, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('numper'=>array('justification'=>'center','width'=>40),
						 			   'feciniper'=>array('justification'=>'center','width'=>70),
									   'fecfinper'=>array('justification'=>'center','width'=>70),
									   'numdiaper'=>array('justification'=>'center','width'=>50),
									   'afevacper'=>array('justification'=>'center','width'=>80),
									   'remper'=>array('justification'=>'center','width'=>90),
									   'tipper'=>array('justification'=>'center','width'=>90),
									   'obsper'=>array('justification'=>'center','width'=>210))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_datos,$la_columna,'',$la_config);	
		unset($la_datos);
		unset($la_columna);
		unset($la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_cabecera,'all');
	}// end function uf_print_cabecera
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_datos($la_data,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_datos
		//		   Access: private 
		//	    Arguments: la_data // Arreglo con loa datos
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los datos del Personal
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 20/07/2007 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetDy(-1);
		$la_columna=array('numper'=>'','feciniper'=>'','fecfinper'=>'','numdiaper'=>'','afevacper'=>'','remper'=>'','tipper'=>'','obsper'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>690, // Ancho de la tabla
						 'maxWidth'=>90, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('numper'=>array('justification'=>'center','width'=>40),
						 			   'feciniper'=>array('justification'=>'center','width'=>70),
									   'fecfinper'=>array('justification'=>'center','width'=>70),
									   'numdiaper'=>array('justification'=>'center','width'=>50),
									   'afevacper'=>array('justification'=>'center','width'=>80),
									   'remper'=>array('justification'=>'center','width'=>90),
									   'tipper'=>array('justification'=>'center','width'=>90),
									   'obsper'=>array('justification'=>'left','width'=>210))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
	}// end function uf_print_datos
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_snorh_class_report.php");
	$io_report=new sigesp_snorh_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>Permisos por Personal</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codnomdes=$io_fun_nomina->uf_obtenervalor_get("codnomdes","");
	$ls_codnomhas=$io_fun_nomina->uf_obtenervalor_get("codnomhas","");
	$ls_codperdes=$io_fun_nomina->uf_obtenervalor_get("codperdes","");
	$ls_codperhas=$io_fun_nomina->uf_obtenervalor_get("codperhas","");
	$ls_activo=$io_fun_nomina->uf_obtenervalor_get("activo","");
	$ls_egresado=$io_fun_nomina->uf_obtenervalor_get("egresado","");
	$ls_causaegreso=$io_fun_nomina->uf_obtenervalor_get("causaegreso","");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_activono=$io_fun_nomina->uf_obtenervalor_get("activono","");
	$ls_vacacionesno=$io_fun_nomina->uf_obtenervalor_get("vacacionesno","");
	$ls_suspendidono=$io_fun_nomina->uf_obtenervalor_get("suspendidono","");
	$ls_egresadono=$io_fun_nomina->uf_obtenervalor_get("egresadono","");
	$ls_masculino=$io_fun_nomina->uf_obtenervalor_get("masculino","");
	$ls_femenino=$io_fun_nomina->uf_obtenervalor_get("femenino","");

	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_permisospersonal_personal($ls_codnomdes,$ls_codnomhas,$ls_codperdes,$ls_codperhas,$ls_activo,
														    $ls_egresado,$ls_causaegreso,$ls_activono,$ls_vacacionesno,
														    $ls_suspendidono,$ls_egresadono,$ls_masculino,$ls_femenino,$ls_orden); // Obtenemos el detalle del reporte
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
		$io_pdf=new Cezpdf('LETTER','landscape'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(7.2,2.2,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(750,50,10,'','',1); // Insertar el n�mero de p�gina
		$li_totrow=$io_report->DS->getRowCount("codper");
		for($li_i=1;(($li_i<=$li_totrow)&&($lb_valido));$li_i++)
		{
			$ls_codper=$io_report->DS->data["codper"][$li_i];
			$ls_cedper=$io_report->DS->data["cedper"][$li_i];
			$ls_nomper=$io_report->DS->data["nomper"][$li_i];
			$ls_apeper=$io_report->DS->data["apeper"][$li_i];
			$ls_estper=$io_report->DS->data["estper"][$li_i];
			$ls_dirper=$io_report->DS->data["dirper"][$li_i];
			$ls_telhabper=$io_report->DS->data["telhabper"][$li_i];
			$ls_telmovper=$io_report->DS->data["telmovper"][$li_i];
			$ls_coreleper=$io_report->DS->data["coreleper"][$li_i];
			switch ($ls_estper)
			{
				case "0":
					$ls_estper="Pre-Ingreso";
					break;
				case "1":
					$ls_estper="Activo";
					break;
				case "2":
					$ls_estper="N/A";
					break;
				case "3":
					$ls_estper="Egresado";
					break;
			}
			$io_cabecera=$io_pdf->openObject(); // Creamos el objeto cabecera
			uf_print_cabecera($ls_cedper,$ls_nomper,$ls_apeper,$ls_estper,$ls_dirper,$ls_telhabper,$ls_telmovper,$ls_coreleper,
							  &$io_cabecera,&$io_pdf);
			$lb_valido=$io_report->uf_permisospersonal_permiso($ls_codper); // Obtenemos el detalle del reporte
			if($lb_valido)
			{
				$li_total=$io_report->DS_detalle->getRowCount("numper");
				for($li_j=1;(($li_j<=$li_total)&&($lb_valido));$li_j++)
				{
					$li_numper=$io_report->DS_detalle->data["numper"][$li_j];
					$ld_feciniper=$io_funciones->uf_convertirfecmostrar($io_report->DS_detalle->data["feciniper"][$li_j]);
					$ld_fecfinper=$io_funciones->uf_convertirfecmostrar($io_report->DS_detalle->data["fecfinper"][$li_j]);
					$li_numdiaper=$io_report->DS_detalle->data["numdiaper"][$li_j];
					$ls_afevacper=$io_report->DS_detalle->data["afevacper"][$li_j];
					switch($ls_afevacper)
					{
						case "1":
							$ls_afevacper="NO";
							break;
						
						default:
							$ls_afevacper="SI";
							break;
					}
					$ls_remper=$io_report->DS_detalle->data["remper"][$li_j];
					switch($ls_remper)
					{
						case "1":
							$ls_remper="SI";
							break;
						
						default:
							$ls_remper="NO";
							break;
					}
					$ls_tipper=$io_report->DS_detalle->data["tipper"][$li_j];
					switch($ls_tipper)
					{
						case "1":
							$ls_tipper="Estudio";
							break;
						
						case "2":
							$ls_tipper="M�dico";
							break;
						case "3":
							$ls_tipper="Tramites";
							break;

						case "4":
							$ls_tipper="Otro";
							break;
						
						default:
							$ls_tipper="";
							break;
					}
					$ls_obsper=rtrim($io_report->DS_detalle->data["obsper"][$li_j]);
					$la_data[$li_j]=array('numper'=>$li_numper,'feciniper'=>$ld_feciniper,'fecfinper'=>$ld_fecfinper,
										  'numdiaper'=>$li_numdiaper,'afevacper'=>$ls_afevacper,'remper'=>$ls_remper,
										  'tipper'=>$ls_tipper,'obsper'=>$ls_obsper);
				}
				uf_print_datos($la_data,&$io_pdf);
				unset($la_data);
				$io_report->DS_detalle->resetds("numper");
			}
			$io_pdf->stopObject($io_cabecera); // Detener el objeto cabecera
			if($li_i<$li_totrow)
			{
				$io_pdf->ezNewPage(); // Insertar una nueva p�gina
			}
		}
		$io_report->DS->resetds("codper");
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