<?php
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//    REPORTE: Retencion Municipales del 1 x 1000
	//  ORGANISMO: REDTV
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
	function uf_insert_seguridad($as_titulo1, $as_titulo2)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 15/07/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_cxp;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo1.$as_titulo2;
		$lb_valido=$io_fun_cxp->uf_load_seguridad_reporte("CXP","sigesp_cxp_r_retencionesmunicipales.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo1,$as_titulo2,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 04/07/2007 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->rectangle(40,75,715,510);
		$li_tm=$io_pdf->getTextWidth(11,'Rep�blica Bolivariana de Venezuela');
		$tm=400-($li_tm/2);
		$io_pdf->addText($tm,570,11,'Rep�blica Bolivariana de Venezuela'); // Agregar el encabezado
		$li_tm=$io_pdf->getTextWidth(11,'Servicio Metropolitano de Administraci�n Tributaria');
		$tm=400-($li_tm/2);
		$io_pdf->addText($tm,560,11,'Servicio Metropolitano de Administraci�n Tributaria'); // Agregar el encabezado
		$li_tm=$io_pdf->getTextWidth(11,'de la Alcald�a del Distrito Metropolitano de Caracas');
		$tm=400-($li_tm/2);
		$io_pdf->addText($tm,550,11,'de la Alcald�a del Distrito Metropolitano de Caracas'); // Agregar el encabezado
		
		$li_tm=$io_pdf->getTextWidth(12,$as_titulo1);
		$tm=396-($li_tm/2);		
		$io_pdf->addText($tm,500,11,$as_titulo1); // Agregar titulo
		
		$li_tm=$io_pdf->getTextWidth(12,$as_titulo2);
		$tm=396-($li_tm/2);		
		$io_pdf->addText($tm,490,11,$as_titulo2); // Agregar titulo
		
		$io_pdf->addText(200,480,9,"Consagrado en el art�culo 9 de la Ordenanza de Timbres Fiscal del Distrito Metropolitano de Caracas"); // Agregar el t�tulo
		
			
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($as_numcon,$as_agenteret,$as_rifagenteret,$as_diragenteret,$as_telagenteret,
	                           $as_nomsujret, $as_rif,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_numcon // N�mero de Comprobante
		//	    		   as_agenteret // agente de Retenci�n
		//	    		   as_rifagenteret // Rif del Agente de Retenci�n
		//	    		   as_diragenteret // Direcci�n del agente de retenci�n
		//	    		   as_nomsujret // Nombre del sujeto retenido
		//	    		   as_rif // Rif del sujeto retenido
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 17/07/2007 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$io_pdf->ezSetY(530);
		$la_data[1]=array('name'=>'<b>N� Correlativo</b> '.$as_numcon);			
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>600, // Orientaci�n de la tabla
						 'width'=>500, // Ancho de la tabla						 
						 'maxWidth'=>500,
						 'cols'=>array('name'=>array('justification'=>'center','width'=>200))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);								 
		
		$io_pdf->ezSetY(460);
		$la_data[1]=array('name'=>'Agente de Retenci�n:  '.$as_agenteret);
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);								 
		$io_pdf->ezSetY(440);
		$la_data[1]=array('name'=>'N� de R.I.F.:  '.$as_rifagenteret);				
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);								 
		$io_pdf->ezSetY(420);
		$la_data[1]=array('name'=>'Domicilio Fiscal:  '.trim ($as_diragenteret));				
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);								 
		$io_pdf->ezSetY(390);
		$la_data[1]=array('name'=>'Tel�fono(s):  '.$as_telagenteret);				
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);	
		$io_pdf->ezSetY(360);
		$la_data[1]=array('name'=>'Contribuyente:  '.$as_nomsujret);				
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);	
		$io_pdf->ezSetY(340);
		$la_data=array (array ('name'=>'Persona Natural _____',
		                       'name2'=>'Persona Jur�dica _____',
							   'name3'=>'C�dula de identidad o R.I.F. N�:  '. $as_rif));					
		$la_columna=array('name'=>'',
		                  'name2'=>'',
						  'name3'=>'',);		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>150),
									   'name2'=>array('justification'=>'left','width'=>160),
						               'name3'=>array('justification'=>'left','width'=>390))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);	
		$io_pdf->ezSetY(320);
		$la_data=array (array ('name'=>'Prestaci�n de servicio _____',
		                       'name2'=>'Adquisici�n de bienes o suministros _____',
							   'name3'=>'Ejecuci�n de Obras _____'));					
		$la_columna=array('name'=>'',
		                  'name2'=>'',
						  'name3'=>'',);		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>200),
									   'name2'=>array('justification'=>'left','width'=>266),
						               'name3'=>array('justification'=>'left','width'=>233))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);	
		
		$io_pdf->ezSetY(300);
		$la_data[1]=array('name'=>'Descripci�n __________________________________________________________________________________ ');			
		$la_columna=array('name'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
										 
									 
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------			
function uf_print_detalle($ai_montobruto, $ai_impuesto, $ai_montoret, $ad_fecret,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: la_data // Arreglo de datos a imprimir
		//	    		   ai_totbasimp // Total de la base imponible
		//	    		   ai_totmonimp // Total monto imponible
		//	    		   as_rifagenteret // Rif del Agente de Retenci�n
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno / Ing. Luis Lang
		// Fecha Creaci�n: 14/07/2007 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetY(260);
		$la_data=array (array('name1'=>'Monto Bruto de la Operaci�n: Bs.  '.$ai_montobruto,		
						        'name2'=>'Impuesto: Bs.  '.$ai_impuesto));
		$la_columna=array('name1'=>'',		
						  'name2'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>400),
   						 			   'name2'=>array('justification'=>'left','width'=>300))); 
		 $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		unset($la_data1);
		unset($la_columna);
		unset($la_config);
		$io_pdf->ezSetY(240);
		$la_data1=array (array('name1'=>'Monto Retenido: Bs.  '.$ai_montoret,		
						       'name2'=>'Fecha de la Retenci�n: Bs.  '.$ad_fecret));
		$la_columna=array('name1'=>'',		
						  'name2'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>400),
   						 			   'name2'=>array('justification'=>'left','width'=>300))); 
		 $io_pdf->ezTable($la_data1,$la_columna,'',$la_config);
		unset($la_data1);
		unset($la_columna);
		unset($la_config);
		$io_pdf->ezSetDy(-20);
		$la_data2[1]=array ('name1'=>'<b>Llenar s�lo en caso de pagos efectuados directamente en las cuentas receptoras de Fondos Distritales:</b>');
		$la_columna=array('name1'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'lrft','width'=>700))); 
		 $io_pdf->ezTable($la_data2,$la_columna,'',$la_config);
		 unset($la_data2);
		 unset($la_columna);
		 unset($la_config);
		//$io_pdf->ezSetY(-10);
		$la_data1=array (array('name1'=>'Banco: __________________________',		
						       'name2'=>'N� de planilla: ____________________'));
		$la_columna=array('name1'=>'',		
						  'name2'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>400),
   						 			   'name2'=>array('justification'=>'left','width'=>300))); 
		 $io_pdf->ezTable($la_data1,$la_columna,'',$la_config);
		 unset($la_data1);
		 unset($la_columna);
		 unset($la_config);	
		 $la_data1=array (array('name1'=>'Monto Pagado: __________________________',		
						       'name2'=>'Fecha de Pago: ____________________'));
		$la_columna=array('name1'=>'',		
						  'name2'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>400),
   						 			   'name2'=>array('justification'=>'left','width'=>300))); 
		 $io_pdf->ezTable($la_data1,$la_columna,'',$la_config);
		 unset($la_data1);
		 unset($la_columna);
		 unset($la_config);	
		 $la_data1=array (array('name1'=>'Agente de Retenci�n: ',		
						        'name2'=>'Firma: '));
		 $la_columna=array('name1'=>'',		
						  'name2'=>'');
		 $la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�nimo de la tabla
						 'xPos'=>415, // Orientaci�n de la tabla
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>400),
   						 			   'name2'=>array('justification'=>'left','width'=>300))); 
		 $io_pdf->ezTable($la_data1,$la_columna,'',$la_config);
		 unset($la_data1);
		 unset($la_columna);
		 unset($la_config);	
		$la_data1[1]=array('name1'=>'Sello:');			
		$la_columna=array('name1'=>'');		
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 12, // Tama�o de Letras
						 'showLines'=>0, // Mostrar Lieas
						 'shaded'=>0, // Sombra entre lineas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xPos'=>415, // Orientaci�n de la tabla
						 'width'=>700, // Ancho de la tabla						 
						 'maxWidth'=>700,
						 'cols'=>array('name1'=>array('justification'=>'left','width'=>700))); // Ancho Minimo de la tabla
        $io_pdf->ezTable($la_data1,$la_columna,'',$la_config);
		unset($la_data);
		unset($la_columna);
		unset($la_config);
		$io_pdf->addText(90,105,9,"(Responsable)");
		$io_pdf->addText(130,90,9,"En cumplimiento a lo dispuesto en el art�culo 5 de la Providencia Administrativa N� DRTI-2004-0022 de fecha 13 de Abril de 2004");
		 
		 	
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------			
//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------

	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_cxp_class_report.php");
	$io_report=new sigesp_cxp_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_cxp.php");
	$io_fun_cxp=new class_funciones_cxp();
	$ls_tiporeporte=$io_fun_cxp->uf_obtenervalor_get("tiporeporte",0);
	
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo1="<b>COMPROBANTE DE RENTENCI�N DEL IMPUESTO</b>";
	$ls_titulo2="<b>DEL UNO POR MIL (1 x 1000)</b>";
	
    $ls_agente=$_SESSION["la_empresa"]["nombre"];
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_comprobantes=$io_fun_cxp->uf_obtenervalor_get("comprobantes","");
	$ls_mes=$io_fun_cxp->uf_obtenervalor_get("mes","");
	$ls_anio=$io_fun_cxp->uf_obtenervalor_get("anio","");
	$ls_agenteret=$_SESSION["la_empresa"]["nombre"];
	$ls_rifagenteret=$_SESSION["la_empresa"]["rifemp"];
	$ls_diragenteret=$_SESSION["la_empresa"]["direccion"];
	$ls_telagenteret=$_SESSION["la_empresa"]["telemp"];
	//--------------------------------------------------------------------------------------------------------------------------------
	$lb_valido=uf_insert_seguridad($ls_titulo1,$ls_titulo2); // Seguridad de Reporte
	if($lb_valido)
	{
		$la_comprobantes=split('-',$ls_comprobantes);
		$la_datos=array_unique($la_comprobantes);
		$li_totrow=count($la_datos);
		sort($la_datos,SORT_STRING);
		if($li_totrow<=0)
		{
			print("<script language=JavaScript>");
			print(" alert('No hay nada que Reportar');"); 
			print(" close();");
			print("</script>");
		}
		else
		{
			error_reporting(E_ALL);
			set_time_limit(1800);
			$io_pdf = new Cezpdf("LETTER","landscape");
			$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm');
			$io_pdf->ezSetCmMargins(7,4,3,3);
			$lb_valido=true;
			for ($li_z=0;($li_z<$li_totrow)&&($lb_valido);$li_z++)
			{
				uf_print_encabezado_pagina($ls_titulo1,$ls_titulo2,$io_pdf);
				$ls_numcom=$la_datos[$li_z];
				$lb_valido=$io_report->uf_retencionesmunicipales_proveedor($ls_numcom,$ls_mes,$ls_anio);
				if($lb_valido)
				{
					$li_total=$io_report->DS->getRowCount("numcom");
					for($li_i=1;$li_i<=$li_total;$li_i++)
					{
						$ls_numcon=$io_report->DS->data["numcom"][$li_i];		 								
						$ls_nomsujret=$io_report->DS->data["nomsujret"][$li_i];	
						$ls_rif=$io_report->DS->data["rif"][$li_i];	
														
					}											
					uf_print_cabecera($ls_numcon,$ls_agenteret,$ls_rifagenteret,$ls_diragenteret,
					                  $ls_telagenteret,$ls_nomsujret, $ls_rif,&$io_pdf);
					
							
					$lb_valido=$io_report->uf_retencionesmunicipales_detalles($ls_numcom);
					if($lb_valido)
					{
						$li_totalbaseimp=0;
						$li_totalmontoimp=0;
						$li_total=$io_report->ds_detalle->getRowCount("numfac");			   
						for($li_i=1;$li_i<=$li_total;$li_i++)
						{
							
												
							$ld_fecfac=$io_funciones->uf_convertirfecmostrar($io_report->ds_detalle->data["fecfac"][$li_i]);	
							           
							$li_baseimp=$io_report->ds_detalle->data["basimp"][$li_i];	
							$li_porimp=$io_report->ds_detalle->data["porimp"][$li_i];	
							$li_totimp=$io_report->ds_detalle->data["iva_ret"][$li_i];	


							$li_totalbaseimp=$li_totalbaseimp + $li_baseimp ;	
							$li_totalmontoimp=$li_totalmontoimp + $li_totimp;	
							$li_baseimp=number_format($li_baseimp,2,",",".");			
							$li_porimp=number_format($li_porimp,4,",",".");			
							$li_totimp=number_format($li_totimp,2,",",".");							
																				
						  }																		 																						  
  						  $li_totalbaseimp= number_format($li_totalbaseimp,2,",","."); 
  						  $li_totalmontoimp= number_format($li_totalmontoimp,2,",","."); 
						   uf_print_detalle($li_totalbaseimp, $li_totimp, $li_totalmontoimp, $ld_fecfac,$io_pdf);			 						  						 						 
					}
				}
				$io_report->DS->reset_ds();
				if($li_z<($li_totrow-1))
				{
					$io_pdf->ezNewPage(); 					  
				}		

			}
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
	}
	unset($io_report);
	unset($io_funciones);
	unset($io_fun_cxp);
?> 