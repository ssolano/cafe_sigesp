<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    REPORTE: Reporte de Accidentes
//  ORGANISMO: IPSFA
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
		//	   Creado Por: Ing. Gloriely Fr�itez
		// Fecha Creaci�n: 11/03/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_srh;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_srh->uf_load_seguridad_reporte("SRH","sigesp_rpp_r_listado_accidente.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Gloriely Fr�itez
		// Fecha Creaci�n: 04/03/2008
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(15,40,950,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,510,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		
		$io_pdf->addText(906,560,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(912,553,7,date("h:i a")); // Agregar la Hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');

	    $io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->ezSetY(480);
		$la_data=array(array('titulo1'=>'<b>'.$as_titulo.'</b>'));
					
		$la_columnas=array('titulo1'=>'');
					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' =>16,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>940, // Ancho de la tabla
						 'maxWidth'=>940, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('titulo1'=>array('justification'=>'center','width'=>940))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
	    $io_pdf->ezSetY(450);
		$la_data[1]=array('codigo'=>'<b>C�digo del Personal</b>',
		                     'nombre'=>'<b>                 Nombre y Apellido</b>',
							 'numero'=>'<b>N�mero de registro</b>',
							 'fecha'=>'<b>Fecha</b>',
							 'descripcion'=>'<b>Descripci�n</b>',
							 'testigos'=>'<b>Testigos</b>',
							 'reposo'=>'<b>D�as Reposo</b>');
		$la_columnas=array('codigo'=>'',
						   'nombre'=>'',
						   'numero'=>'',
						   'fecha'=>'',
						   'descripcion'=>'',
						   'testigos'=>'',
						   'reposo'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>940, // Ancho de la tabla
						 'maxWidth'=>940, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
						 			   'numero'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'fecha'=>array('justification'=>'center','width'=>80),
									   'descripcion'=>array('justification'=>'center','width'=>250),
									   'testigos'=>array('justification'=>'center','width'=>150),
									   'reposo'=>array('justification'=>'center','width'=>80))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		unset($la_data);
		unset($la_columnas);
		unset($la_config);
	
		$io_pdf->restoreState();
	    $io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
		
	
	
     }// end function uf_print_encabezado_pagina
	 //-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf)
 	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera_detalle
		//		   Access: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//				 
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime el detalle del reporte.
		//	   Creado Por: Ing. Gloriely Fr�itez
		// Fecha Creaci�n: 04/03/2008 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetY(425);
		$la_columnas=array('codigo'=>'',
							 'nombre'=>'',
							 'numregistro'=>'',
							 'fecha'=>'',
							 'descripcion'=>'',
							 'testigos'=>'',
							 'diasrep'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>940, // Ancho de la tabla
						 'maxWidth'=>940, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('codigo'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
						 			   'numero'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'fecha'=>array('justification'=>'center','width'=>80),
									   'descripcion'=>array('justification'=>'left','width'=>250),
									   'testigos'=>array('justification'=>'center','width'=>150),
									   'diasrep'=>array('justification'=>'center','width'=>80)));// Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------------
    require_once("../../shared/ezpdf/class.ezpdf.php");	
	require_once("class_folder/sigesp_srh_class_report.php");
	$io_report=new sigesp_srh_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/utilidades/class_funciones_srh.php");
	$io_fun_srh=new class_funciones_srh('../../');
	$ls_estmodest=$_SESSION["la_empresa"]["estmodest"];
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
       $ls_titulo="<b>LISTADO DE ACCIDENTES</b>"; 
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_fechades=$io_fun_srh->uf_obtenervalor_get("fechades","");
	$ls_fechahas=$io_fun_srh->uf_obtenervalor_get("fechahas","");
	$ls_codperdes=$io_fun_srh->uf_obtenervalor_get("codperdes","");
	$ls_codperhas=$io_fun_srh->uf_obtenervalor_get("codperhas","");
	$ls_orden=$io_fun_srh->uf_obtenervalor_get("orden","");
	
	//-----------------------------------------------------------------------------------------------------------------------------------
	global $la_data;
	$lb_valido=uf_insert_seguridad($ls_titulo); // Seguridad de Reporte
	if($lb_valido)
	{

		$lb_valido=$io_report->uf_select_listado_accidentes($ls_fechades,$ls_fechahas,$ls_codperdes,$ls_codperhas,$ls_orden); // Cargar el DS con los datos del reporte
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
			$io_pdf=new Cezpdf('LEGAL','landscape'); // Instancia de la clase PDF
			$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
			$io_pdf->ezSetCmMargins(6,3,3,3);  // Configuraci�n de los margenes en cent�metros
			$io_pdf->ezStartPageNumbers(950,50,9,'','',1);; // Insertar el n�mero de p�gina
		  	$li_totrow=$io_report->ds_detalle->getRowCount("codemp");
			for($li_i=1;$li_i<=$li_totrow;$li_i++)
			{
				$ls_codigoper=$io_report->ds_detalle->data["codper"][$li_i];
				$ls_nroreg=$io_report->ds_detalle->data["nroreg"][$li_i];
				$ls_fecha=$io_report->ds_detalle->data["fecacc"][$li_i];
				$ls_descripcion=$io_report->ds_detalle->data["descripcion"][$li_i];
				$ls_testigos=$io_report->ds_detalle->data["testigos"][$li_i];
				$ls_reposo=$io_report->ds_detalle->data["reposo"][$li_i];
				$ls_nombreper=$io_report->ds_detalle->data["nomper"][$li_i];
				$ls_apellidoper=$io_report->ds_detalle->data["apeper"][$li_i];
				$ls_fecha=$io_funciones->uf_formatovalidofecha($ls_fecha);
				$ls_fecha=$io_funciones->uf_convertirfecmostrar($ls_fecha);
				$ls_cadena=$ls_nombreper."  ".$ls_apellidoper;
				$la_data[$li_i]=array('codigo'=>$ls_codigoper,'nombre'=>$ls_cadena,'numregistro'=>$ls_nroreg,'fecha'=>$ls_fecha,
				                      'descripcion'=>$ls_descripcion,'testigos'=>$ls_testigos,'diasrep'=>$ls_reposo);
			}
			uf_print_encabezado_pagina($ls_titulo,$io_pdf);
			uf_print_detalle($la_data,$io_pdf);
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
		 
        }// fin del else
	}
?>


