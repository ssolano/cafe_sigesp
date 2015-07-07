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
	function uf_print_encabezado_pagina($as_titulo,$as_fecha,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		    Acess: private
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   as_periodo_comp // Descripci�n del periodo del comprobante
		//	    		   as_fecha_comp // Descripci�n del per�odo de la fecha del comprobante
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing.Yozelin Barrag�n
		// Fecha Creaci�n: 21/04/2006
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(10,40,578,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,720,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,10,$as_titulo); // Agregar el t�tulo
		
		$li_tm=$io_pdf->getTextWidth(11,$as_fecha);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,720,10,$as_fecha); // Agregar el t�tulo

		$io_pdf->addText(500,730,9,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(500,720,9,date("h:i a")); // Agregar la hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($io_cabecera,$as_programatica,$as_denestpro,&$io_pdf)
	{
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: privates
		//	    Arguments: as_programatica // programatica del comprobante
		//	    		   as_denestpro5 // denominacion de la programatica del comprobante
		//	    		   io_pdf // Objeto PDF
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing.Yozelin Barrag�n
		// Fecha Creaci�n: 21/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
		$io_pdf->ezSetY(720);
		if ($_SESSION["la_empresa"]["estmodest"] == 2)
		{
			$la_data=array(array('name'=>'<b>Programatica</b> '.$as_programatica.''),
		               array('name'=>'<b></b> '.$as_denestpro.''));
			$la_columna=array('name'=>'');
			$la_config=array('showHeadings'=>0, // Mostrar encabezados
							 'fontSize' => 8, // Tama�o de Letras
							 'showLines'=>0, // Mostrar L�neas
							 'shaded'=>0, // Sombra entre l�neas
							 'shadeCol'=>array(0.9,0.9,0.9),
							 'shadeCo2'=>array(0.9,0.9,0.9),
							 'colGap'=>1, // separacion entre tablas
							 'xOrientation'=>'center', // Orientaci�n de la tabla
							 'xPos'=>299, // Orientaci�n de la tabla
							 'width'=>550, // Ancho de la tabla
							 'maxWidth'=>550); // Ancho M�ximo de la tabla
			$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
			$io_pdf->restoreState();
			$io_pdf->closeObject();
			$io_pdf->addObject($io_cabecera,'all');
		}
		else
		{
		 	$ls_loncodestpro1 = $_SESSION["la_empresa"]["loncodestpro1"];
	 		$ls_loncodestpro2 = $_SESSION["la_empresa"]["loncodestpro2"];
	 		$ls_loncodestpro3 = $_SESSION["la_empresa"]["loncodestpro3"];
	 
	 		$la_datatit=array(array('name'=>'<b>ESTRUCTURA PRESUPUESTARIA </b>'));
	 
	 		$la_columnatit=array('name'=>'');
	 
	 		$la_configtit=array('showHeadings'=>0, // Mostrar encabezados
								 'showLines'=>0, // Mostrar L�neas
								 'shaded'=>0, // Sombra entre l�neas
								 'fontSize' => 8, // Tama�o de Letras
								 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
								 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
								 'colGap'=>1, // separacion entre tablas
								 'xOrientation'=>'center', // Orientaci�n de la tabla
								 'xPos'=>299, // Orientaci�n de la tabla
								 'width'=>550, // Ancho de la tabla
								 'maxWidth'=>550);// Ancho M�ximo de la tabla
	 
	 		$io_pdf->ezTable($la_datatit,$la_columnatit,'',$la_configtit);	
	 
			 $la_data=array(array('name'=>substr($as_programatica,0,$ls_loncodestpro1).'</b>','name2'=>$as_denestpro[0]),
							array('name'=>substr($as_programatica,$ls_loncodestpro1,$ls_loncodestpro2),'name2'=>$as_denestpro[1]),
							array('name'=>substr($as_programatica,$ls_loncodestpro1+$ls_loncodestpro2,$ls_loncodestpro3),'name2'=>$as_denestpro[2]));
							
			 $la_columna=array('name'=>'','name2'=>'');
			 $la_config=array('showHeadings'=>0, // Mostrar encabezados
							 'showLines'=>0, // Mostrar L�neas
							 'shaded'=>0, // Sombra entre l�neas
							 'fontSize' => 8, // Tama�o de Letras
							 'shadeCol'=>array(0.98,0.98,0.98), // Color de la sombra
							 'shadeCol2'=>array(0.98,0.98,0.98), // Color de la sombra
							 'colGap'=>1, // separacion entre tablas
							 'xOrientation'=>'center', // Orientaci�n de la tabla
							 'xPos'=>299, // Orientaci�n de la tabla
							 'width'=>560, // Ancho de la tabla
							 'maxWidth'=>560,// Ancho M�ximo de la tabla
							 'cols'=>array('name'=>array('justification'=>'right','width'=>50), // Justificaci�n y ancho de la columna
										   'name2'=>array('justification'=>'left','width'=>510))); // Justificaci�n y ancho de la columna
			 $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
			 $io_pdf->restoreState();
			 $io_pdf->closeObject();
			 $io_pdf->addObject($io_cabecera,'all');
		}		
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera_detalle($io_encabezado,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera_detalle
		//		    Acess: private
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing.Yozelin Barrag�n
		// Fecha Creaci�n: 21/04/2006
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->saveState();
		$io_pdf->ezSetY(643);
		$la_data=array(array('cuenta'=>'<b>Cuenta</b>','denominacion'=>'<b>Denominaci�n</b>','asignado'=>'<b>Asignado</b>',
		                     'acumulado'=>'<b>Ejecutado Acumulado</b>','ejecutado'=>'<b>Ejecutado</b>',
							 'disponibilidad'=>'<b>Disponibilidad</b>'));
		$la_columnas=array('cuenta'=>'','denominacion'=>'','asignado'=>'','acumulado'=>'','ejecutado'=>'','disponibilidad'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xPos'=>299, // Orientaci�n de la tabla
						 'cols'=>array('cuenta'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la 
						 			   'denominacion'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la
						 			   'asignado'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la 
						 			   'acumulado'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la 
						 			   'ejecutado'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la 
									   'disponibilidad'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho 
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_cabecera_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing.Yozelin Barrag�n
		// Fecha Creaci�n: 21/04/2006
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetY(630);
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>550, // Ancho de la tabla
						 'maxWidth'=>550, // Ancho M�ximo de la tabla
						 'xPos'=>299, // Orientaci�n de la tabla
						 'cols'=>array('cuenta'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la 
						 			   'denominacion'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la
						 			   'asignado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
						 			   'acumulado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
						 			   'ejecutado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
									   'disponibilidad'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho 
		$la_columnas=array('cuenta'=>'<b>Cuenta</b>',
						   'denominacion'=>'<b>Denominaci�n</b>',
						   'asignado'=>'<b>Asignado</b>',
						   'acumulado'=>'<b>Ejecutado Acumulado</b>',
						   'ejecutado'=>'<b>Ejecutado</b>',
						   'disponibilidad'=>'<b>Disponibilidad</b>');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera($ad_totalasignado,$ad_totaldisponible,$ad_totalejecutado,$ad_totalacumulado,$as_denominacion,&$io_pdf)
	{
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera
		//		    Acess : private
		//	    Arguments : ad_total // Total General
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por: Ing.Yozelin Barrag�n
		// Fecha Creaci�n : 18/02/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data=array(array('total'=>'<b> Total '.$as_denominacion.' </b>','asignado'=>$ad_totalasignado,'acumulado'=>$ad_totalacumulado,
		                     'ejecutado'=>$ad_totalejecutado,'disminucion'=>$ad_totaldisponible));
		$la_columna=array('total'=>'','asignado'=>'','acumulado'=>'','ejecutado'=>'','disminucion'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>299, // Orientaci�n de la tabla
						 'colGap'=>1,
				 		 'cols'=>array('total'=>array('justification'=>'right','width'=>150), // Justificaci�n y ancho de la columna
						 	           'asignado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
						 	           'acumulado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
						 	           'ejecutado'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la 
							           'disminucion'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la

		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$la_data=array(array('name'=>''));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>550, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center'); // Orientaci�n de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------
		require_once("../../shared/ezpdf/class.ezpdf.php");
		require_once("sigesp_spg_funciones_reportes.php");
		$io_function_report = new sigesp_spg_funciones_reportes();
		require_once("../../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();
		require_once("../../shared/class_folder/class_fecha.php");
		$io_fecha = new class_fecha();
		$ls_tipoformato=$_GET["tipoformato"];
	//-----------------------------------------------------------------------------------------------------------------------------
		 global $ls_tipoformato;
		 if($ls_tipoformato==1)
		 {
			require_once("sigesp_spg_reporte_bsf.php");
			$io_report = new sigesp_spg_reporte_bsf();
		 }
		 else
		 {
			require_once("sigesp_spg_reporte.php");
		    $io_report = new sigesp_spg_reporte();
		 }	
		 require_once("../../shared/class_folder/sigesp_c_reconvertir_monedabsf.php");
		 $io_rcbsf= new sigesp_c_reconvertir_monedabsf();
		 $li_candeccon=$_SESSION["la_empresa"]["candeccon"];
		 $li_tipconmon=$_SESSION["la_empresa"]["tipconmon"];
		 $li_redconmon=$_SESSION["la_empresa"]["redconmon"];
    //--------------------------------------------------  Par�metros para Filtar el Reporte  --------------------------------------
		$li_estmodest		= $_SESSION["la_empresa"]["estmodest"];
		$ls_codestpro1_min  = $_GET["codestpro1"];
		$ls_codestpro2_min  = $_GET["codestpro2"];
		$ls_codestpro3_min  = $_GET["codestpro3"];
		$ls_codestpro1h_max = $_GET["codestpro1h"];
		$ls_codestpro2h_max = $_GET["codestpro2h"];
		$ls_codestpro3h_max = $_GET["codestpro3h"];
	    $ls_estclades       = $_GET["estclades"];
	    $ls_estclahas       = $_GET["estclahas"];
		if($li_estmodest==1)
		{
			$ls_codestpro4_min  = "0000000000000000000000000";
			$ls_codestpro5_min  = "0000000000000000000000000";
			$ls_codestpro4h_max = "0000000000000000000000000";
			$ls_codestpro5h_max = "0000000000000000000000000";
			if(($ls_codestpro1_min=="")&&($ls_codestpro2_min=="")&&($ls_codestpro3_min==""))
			{
			  if($io_function_report->uf_spg_reporte_select_min_programatica($ls_codestpro1_min,$ls_codestpro2_min,                                                                             $ls_codestpro3_min,$ls_codestpro4_min,
			                                                                 $ls_codestpro5_min,$ls_estclades))
			  {
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			  }
			}
			else
			{
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			}
			if(($ls_codestpro1h_max=="")&&($ls_codestpro2h_max=="")&&($ls_codestpro3h_max==""))
			{
			  if($io_function_report->uf_spg_reporte_select_max_programatica($ls_codestpro1h_max,$ls_codestpro2h_max,
																			 $ls_codestpro3h_max,$ls_codestpro4h_max,
																			 $ls_codestpro4h_max,$ls_estclahas))
			  {
					$ls_codestpro1h  = $ls_codestpro1h_max;
					$ls_codestpro2h  = $ls_codestpro2h_max;
					$ls_codestpro3h  = $ls_codestpro3h_max;
					$ls_codestpro4h  = $ls_codestpro4h_max;
					$ls_codestpro5h  = $ls_codestpro5h_max;
			  }
			}
			else
			{
					$ls_codestpro1h  = $ls_codestpro1h_max;
					$ls_codestpro2h  = $ls_codestpro2h_max;
					$ls_codestpro3h  = $ls_codestpro3h_max;
					$ls_codestpro4h  = $ls_codestpro4h_max;
					$ls_codestpro5h  = $ls_codestpro5h_max;
			}
		}
		elseif($li_estmodest==2)
		{
			$ls_codestpro4_min = $_GET["codestpro4"];
			$ls_codestpro5_min = $_GET["codestpro5"];
			$ls_codestpro4h_max = $_GET["codestpro4h"];
			$ls_codestpro5h_max = $_GET["codestpro5h"];
			if(($ls_codestpro1_min=="")&&($ls_codestpro2_min=="")&&($ls_codestpro3_min=="")&&($ls_codestpro4_min=="")&&
			   ($ls_codestpro5_min==""))
			{
			  if($io_function_report->uf_spg_reporte_select_min_programatica($ls_codestpro1_min,$ls_codestpro2_min,                                                                             $ls_codestpro3_min,$ls_codestpro4_min,
			                                                                 $ls_codestpro5_min,$ls_estclades))
			  {
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			  }
			}
			else
			{
					$ls_codestpro1  = $ls_codestpro1_min;
					$ls_codestpro2  = $ls_codestpro2_min;
					$ls_codestpro3  = $ls_codestpro3_min;
					$ls_codestpro4  = $ls_codestpro4_min;
					$ls_codestpro5  = $ls_codestpro5_min;
			}
			if(($ls_codestpro1h_max=="")&&($ls_codestpro2h_max=="")&&($ls_codestpro3h_max=="")&&($ls_codestpro4h_max=="")&&
			   ($ls_codestpro5h_max==""))
			{
			  if($io_function_report->uf_spg_reporte_select_max_programatica($ls_codestpro1h_max,$ls_codestpro2h_max,
																			 $ls_codestpro3h_max,$ls_codestpro4h_max,
																			 $ls_codestpro4h_max,$ls_estclahas))
			  {
				$ls_codestpro1h  = $ls_codestpro1h_max;
				$ls_codestpro2h  = $ls_codestpro2h_max;
				$ls_codestpro3h  = $ls_codestpro3h_max;
				$ls_codestpro4h  = $ls_codestpro4h_max;
				$ls_codestpro5h  = $ls_codestpro5h_max;
			  }
			}
			else
			{
				$ls_codestpro1h  = $ls_codestpro1h_max;
				$ls_codestpro2h  = $ls_codestpro2h_max;
				$ls_codestpro3h  = $ls_codestpro3h_max;
				$ls_codestpro4h  = $ls_codestpro4h_max;
				$ls_codestpro5h  = $ls_codestpro5h_max;
			}
		}	
		
		
	    $ls_cuentades_min=$_GET["txtcuentades"];
	    $ls_cuentahas_max=$_GET["txtcuentahas"];
		if($ls_cuentades_min=="")
		{
		   if($io_function_report->uf_spg_reporte_select_min_cuenta($ls_cuentades_min))
		   {
		     $ls_cuentades=$ls_cuentades_min;
		   } 
		   else
		   {
				print("<script language=JavaScript>");
				print(" alert('No hay cuentas presupuestraias');"); 
				print(" close();");
				print("</script>");
		   }
		}
		else
		{
		    $ls_cuentades=$ls_cuentades_min;
		}
		if($ls_cuentahas_max=="")
		{
		   if($io_function_report->uf_spg_reporte_select_max_cuenta($ls_cuentahas_max))
		   {
		     $ls_cuentahas=$ls_cuentahas_max;
		   } 
		   else
		   {
				print("<script language=JavaScript>");
				print(" alert('No hay cuentas presupuestarias');"); 
				print(" close();");
				print("</script>");
		   }
		}
		else
		{
		    $ls_cuentahas=$ls_cuentahas_max;
		}
	   $ldt_fecdes=$_GET["txtfecdes"];
	   $ldt_fechas=$_GET["txtfechas"];
	   $ls_fecha_titulo=$io_funciones->uf_convertirfecmostrar($ldt_fechas);

	   $ls_codfuefindes=$_GET["txtcodfuefindes"];
	   $ls_codfuefinhas=$_GET["txtcodfuefinhas"];
	   if (($ls_codfuefindes=='')&&($ls_codfuefindes==''))
	   {
		  if($io_function_report->uf_spg_select_fuentefinanciamiento(&$ls_minfuefin,&$ls_maxfuefin))
		  {
		     $ls_codfuefindes=$ls_minfuefin;
		     $ls_codfuefinhas=$ls_maxfuefin;
		  } 
	   }
	 /////////////////////////////////         SEGURIDAD               ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $ls_programatica_desde=$ls_codestpro1.$ls_codestpro2.$ls_codestpro3.$ls_codestpro4.$ls_codestpro5;
	 $ls_programatica_hasta=$ls_codestpro1h.$ls_codestpro2h.$ls_codestpro3h.$ls_codestpro4h.$ls_codestpro5h;
	 
	 $ls_desc_event="Solicitud de Reporte disponibilidad Presupuestaria Desde la Cuenta ".$ls_cuentades." hasta ".$ls_cuentahas." ,  Desde la Programatica  ".$ls_programatica_desde." hasta ".$ls_programatica_hasta;
	 $io_function_report->uf_load_seguridad_reporte("SPG","sigesp_spg_r_disponibilidad.php",$ls_desc_event);
	////////////////////////////////         SEGURIDAD               ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   //----------------------------------------------------  Par�metros del encabezado  ----------------------------------------------------------------------------------------------------------------------------------------
		$ls_titulo="<b>  DISPONIBILIDAD PRESUPUESTARIAS FORMATO # 2 </b> "; 
		$ls_fecha="<b> HASTA LA FECHA ".$ls_fecha_titulo." </b>";      
   //-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Cargar el dts_cab con los datos de la cabecera del reporte( Selecciono todos comprobantes )
	$ls_codestpro1  = $io_funciones->uf_cerosizquierda($ls_codestpro1_min,25);
	$ls_codestpro2  = $io_funciones->uf_cerosizquierda($ls_codestpro2_min,25);
	$ls_codestpro3  = $io_funciones->uf_cerosizquierda($ls_codestpro3_min,25);
	$ls_codestpro4  = $io_funciones->uf_cerosizquierda($ls_codestpro4_min,25);
	$ls_codestpro5  = $io_funciones->uf_cerosizquierda($ls_codestpro5_min,25);
	
	$ls_codestpro1h  = $io_funciones->uf_cerosizquierda($ls_codestpro1h_max,25);
	$ls_codestpro2h  = $io_funciones->uf_cerosizquierda($ls_codestpro2h_max,25);
	$ls_codestpro3h  = $io_funciones->uf_cerosizquierda($ls_codestpro3h_max,25);
	$ls_codestpro4h  = $io_funciones->uf_cerosizquierda($ls_codestpro4h_max,25);
	$ls_codestpro5h  = $io_funciones->uf_cerosizquierda($ls_codestpro5h_max,25);
    $lb_valido=$io_report->uf_spg_reporte_disponibilidad_formato2($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,
	                                                              $ls_codestpro5,$ls_codestpro1h,$ls_codestpro2h,$ls_codestpro3h,
																  $ls_codestpro4h,$ls_codestpro5h,$ldt_fecdes,$ldt_fechas,
								                                  $ls_cuentades,$ls_cuentahas,$ls_codfuefindes,$ls_codfuefinhas,
																  $ls_estclades,$ls_estclahas);
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
		$io_pdf->ezSetCmMargins(5.7,3,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$ls_fecha,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		$io_report->dts_reporte->group_noorder("programatica");
		$li_tot=$io_report->dts_reporte->getRowCount("spg_cuenta");
		$ld_totalasignado=0;
		$ld_totaldisponible=0;
		$ld_totalejecutado=0;
		$ld_totalacumulado=0;
		$ls_loncodestpro1 = $_SESSION["la_empresa"]["loncodestpro1"];
		$ls_loncodestpro2 = $_SESSION["la_empresa"]["loncodestpro2"];
		$ls_loncodestpro3 = $_SESSION["la_empresa"]["loncodestpro3"];
		$ls_loncodestpro4 = $_SESSION["la_empresa"]["loncodestpro4"];
		$ls_loncodestpro5 = $_SESSION["la_empresa"]["loncodestpro5"];
		$ls_progaux = "";
		for($z=1;$z<=$li_tot;$z++)
		{
		    $li_tmp=($z+1);
			$thisPageNum=$io_pdf->ezPageCount;
			$ls_progaux=$io_report->dts_reporte->data["programatica"][$z];
			if ($ls_progaux !="") 
			{
			 $ls_programatica = $ls_progaux; 
			}
			$ls_estcla=substr($ls_programatica,-1);
		    $ls_codestpro1=substr($ls_programatica,0,25);
		    $ls_denestpro1="";
		    $lb_valido=$io_report->uf_spg_reporte_select_denestpro1($ls_codestpro1,$ls_denestpro1,$ls_estcla);
		    if($lb_valido)
		    {
			  $ls_denestpro1=trim($ls_denestpro1);
		    }
		    $ls_codestpro2=substr($ls_programatica,25,25);
		    if($lb_valido)
		    {
			  $ls_denestpro2="";
			  $lb_valido=$io_report->uf_spg_reporte_select_denestpro2($ls_codestpro1,$ls_codestpro2,$ls_denestpro2,$ls_estcla);
			  $ls_denestpro2=trim($ls_denestpro2);
		    }
		    $ls_codestpro3=substr($ls_programatica,50,25);
		    if($lb_valido)
		    {
			  $ls_denestpro3="";
			  $lb_valido=$io_report->uf_spg_reporte_select_denestpro3($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_denestpro3,$ls_estcla);
			  $ls_denestpro3=trim($ls_denestpro3);
		    }
			$ls_spg_cuenta=$io_report->dts_reporte->data["spg_cuenta"][$z];
		    if ($z<$li_tot)
		    {
				$ls_programatica_next=$io_report->dts_reporte->data["programatica"][$li_tmp]; 
		    }
		    elseif($z=$li_tot)
		    {
				$ls_programatica_next='no_next';
		    }
			if(empty($ls_programatica_next)||(!empty($ls_programatica)))
			{
			    $ls_programatica_ant=$io_report->dts_reporte->data["programatica"][$z];
				if($li_estmodest==2)
				{
					$ls_codestpro4=substr($ls_programatica,75,25);
					if($lb_valido)
					{
					  $ls_denestpro4="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro4($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_denestpro4,$ls_estcla);
					  $ls_denestpro4=trim($ls_denestpro4);
					}
					$ls_codestpro5=substr($ls_programatica,100,25);
					if($lb_valido)
					{
					  $ls_denestpro5="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro5($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_codestpro5,$ls_denestpro5,$ls_estcla);
					  $ls_denestpro5=trim($ls_denestpro5);
					}
					$ls_denestpro_ant=trim($ls_denestpro1)." , ".trim($ls_denestpro2)." , ".trim($ls_denestpro3)." , ".trim($ls_denestpro4)." , ".trim($ls_denestpro5);
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1)."-".substr($ls_codestpro2,-$ls_loncodestpro2)."-".substr($ls_codestpro3,-$ls_loncodestpro3)."-".substr($ls_codestpro4,-$ls_loncodestpro4)."-".substr($ls_codestpro5,-$ls_loncodestpro5);
				}
				else
				{
			        //$ls_denestpro_ant=$ls_denestpro1." , ".$ls_denestpro2." , ".$ls_denestpro3;
					$ls_denestpro_ant = array();
					$ls_denestpro_ant[0]=$ls_denestpro1;
					$ls_denestpro_ant[1]=$ls_denestpro2;
					$ls_denestpro_ant[2]=$ls_denestpro3;
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1).substr($ls_codestpro2,-$ls_loncodestpro2).substr($ls_codestpro3,-$ls_loncodestpro3);
				}
			}
			elseif(!empty($ls_programatica_next)||(!empty($ls_programatica)))
			{
			    $ls_programatica_ant=$io_report->dts_reporte->data["programatica"][$z];
				if($li_estmodest==2)
				{
					$ls_codestpro4=substr($ls_programatica,75,25);
					if($lb_valido)
					{
					  $ls_denestpro4="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro4($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_denestpro4,$ls_estcla);
					  $ls_denestpro4=trim($ls_denestpro4);
					}
					$ls_codestpro5=substr($ls_programatica,100,25);
					if($lb_valido)
					{
					  $ls_denestpro5="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro5($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_codestpro5,$ls_denestpro5,$ls_estcla);
					  $ls_denestpro5=trim($ls_denestpro5);
					}
					$ls_denestpro_ant=trim($ls_denestpro1)." , ".trim($ls_denestpro2)." , ".trim($ls_denestpro3)." , ".trim($ls_denestpro4)." , ".trim($ls_denestpro5);
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1)."-".substr($ls_codestpro2,-$ls_loncodestpro2)."-".substr($ls_codestpro3,-$ls_loncodestpro3)."-".substr($ls_codestpro4,-$ls_loncodestpro4)."-".substr($ls_codestpro5,-$ls_loncodestpro5);
				}
				else
				{
			        //$ls_denestpro_ant=$ls_denestpro1." , ".$ls_denestpro2." , ".$ls_denestpro3;
					$ls_denestpro_ant = array();
					$ls_denestpro_ant[0]=$ls_denestpro1;
					$ls_denestpro_ant[1]=$ls_denestpro2;
					$ls_denestpro_ant[2]=$ls_denestpro3;
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1).substr($ls_codestpro2,-$ls_loncodestpro2).substr($ls_codestpro3,-$ls_loncodestpro3);
				}
			}
			if($li_tot==1)
			{
			    $ls_programatica_ant=$io_report->dts_reporte->data["programatica"][$z];
				if($li_estmodest==2)
				{
					$ls_codestpro4=substr($ls_programatica,75,25);
					if($lb_valido)
					{
					  $ls_denestpro4="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro4($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_denestpro4,$ls_estcla);
					  $ls_denestpro4=trim($ls_denestpro4);
					}
					$ls_codestpro5=substr($ls_programatica,100,25);
					if($lb_valido)
					{
					  $ls_denestpro5="";
					  $lb_valido=$io_report->uf_spg_reporte_select_denestpro5($ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,$ls_codestpro5,$ls_denestpro5,$ls_estcla);
					  $ls_denestpro5=trim($ls_denestpro5);
					}
					$ls_denestpro_ant=trim($ls_denestpro1)." , ".trim($ls_denestpro2)." , ".trim($ls_denestpro3)." , ".trim($ls_denestpro4)." , ".trim($ls_denestpro5);
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1)."-".substr($ls_codestpro2,-$ls_loncodestpro2)."-".substr($ls_codestpro3,-$ls_loncodestpro3)."-".substr($ls_codestpro4,-$ls_loncodestpro4)."-".substr($ls_codestpro5,-$ls_loncodestpro5);
				}
				else
				{
			        //$ls_denestpro_ant=$ls_denestpro1." , ".$ls_denestpro2." , ".$ls_denestpro3;
					$ls_denestpro_ant = array();
					$ls_denestpro_ant[0]=$ls_denestpro1;
					$ls_denestpro_ant[1]=$ls_denestpro2;
					$ls_denestpro_ant[2]=$ls_denestpro3;
					$ls_programatica_ant=substr($ls_codestpro1,-$ls_loncodestpro1).substr($ls_codestpro2,-$ls_loncodestpro2).substr($ls_codestpro3,-$ls_loncodestpro3);
				}
			}
			$ls_denominacion=trim($io_report->dts_reporte->data["denominacion"][$z]);
			$ld_asignado=$io_report->dts_reporte->data["asignado"][$z];
			$ld_disponible=$io_report->dts_reporte->data["disponible"][$z];
			$ld_monto_ejecutado=$io_report->dts_reporte->data["monto_ejecutado"][$z];
			$ld_monto_acumulado=$io_report->dts_reporte->data["monto_acumulado"][$z];
			$ls_status=$io_report->dts_reporte->data["status"][$z];
	
			if($ls_status=="C")
			{
				$ld_totalasignado=$ld_totalasignado+$ld_asignado;
				$ld_totaldisponible=$ld_totaldisponible+$ld_disponible;
				$ld_totalejecutado=$ld_totalejecutado+$ld_monto_ejecutado;
				$ld_totalacumulado=$ld_totalacumulado+$ld_monto_acumulado;
			}
			if (!empty($ls_programatica))
		    {
				$ld_asignado=number_format($ld_asignado,2,",",".");
				$ld_disponible=number_format($ld_disponible,2,",",".");
				$ld_monto_ejecutado=number_format($ld_monto_ejecutado,2,",",".");
				$ld_monto_acumulado=number_format($ld_monto_acumulado,2,",",".");
			   
				$la_data[$z]=array('cuenta'=>$ls_spg_cuenta,'denominacion'=>$ls_denominacion,
								   'asignado'=>$ld_asignado,'acumulado'=>$ld_monto_acumulado,
								   'ejecutado'=>$ld_monto_ejecutado,'disponibilidad'=>$ld_disponible);
			   
				$ld_asignado=str_replace('.','',$ld_asignado);
				$ld_asignado=str_replace(',','.',$ld_asignado);		
				$ld_disponible=str_replace('.','',$ld_disponible);
				$ld_disponible=str_replace(',','.',$ld_disponible);	
				$ld_monto_ejecutado=str_replace('.','',$ld_monto_ejecutado);
				$ld_monto_ejecutado=str_replace(',','.',$ld_monto_ejecutado);	
				$ld_monto_acumulado=str_replace('.','',$ld_monto_acumulado);
				$ld_monto_acumulado=str_replace(',','.',$ld_monto_acumulado);	
					
			}
			else
			{
				$ld_asignado=number_format($ld_asignado,2,",",".");
				$ld_disponible=number_format($ld_disponible,2,",",".");
				$ld_monto_ejecutado=number_format($ld_monto_ejecutado,2,",",".");
				$ld_monto_acumulado=number_format($ld_monto_acumulado,2,",",".");
				
				$la_data[$z]=array('cuenta'=>$ls_spg_cuenta,'denominacion'=>$ls_denominacion,
								   'asignado'=>$ld_asignado,'acumulado'=>$ld_monto_acumulado,
								   'ejecutado'=>$ld_monto_ejecutado,'disponibilidad'=>$ld_disponible);
			   
				$ld_asignado=str_replace('.','',$ld_asignado);
				$ld_asignado=str_replace(',','.',$ld_asignado);		
				$ld_disponible=str_replace('.','',$ld_disponible);
				$ld_disponible=str_replace(',','.',$ld_disponible);		
				$ld_monto_ejecutado=str_replace('.','',$ld_monto_ejecutado);
				$ld_monto_ejecutado=str_replace(',','.',$ld_monto_ejecutado);	
				$ld_monto_acumulado=str_replace('.','',$ld_monto_acumulado);
				$ld_monto_acumulado=str_replace(',','.',$ld_monto_acumulado);	
					
			}
			if (!empty($ls_programatica_next))
			{
				 if($ls_tipoformato==1)
				 {
						$ld_asignado=number_format($ld_asignado,2,",",".");
						$ld_disponible=number_format($ld_disponible,2,",",".");
						$ld_monto_ejecutado=number_format($ld_monto_ejecutado,2,",",".");
						$ld_monto_acumulado=number_format($ld_monto_acumulado,2,",",".");
						
						$la_data[$z]=array('cuenta'=>$ls_spg_cuenta,'denominacion'=>$ls_denominacion,
										   'asignado'=>$ld_asignado,'acumulado'=>$ld_monto_acumulado,
										   'ejecutado'=>$ld_monto_ejecutado,'disponibilidad'=>$ld_disponible);
						
						$io_cabecera=$io_pdf->openObject();
						uf_print_cabecera($io_cabecera,$ls_programatica_ant,$ls_denestpro_ant,$io_pdf);
						$io_encabezado=$io_pdf->openObject();
						uf_print_cabecera_detalle($io_encabezado,$io_pdf);
						uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
						$ld_totalasignado=number_format($ld_totalasignado,2,",",".");
						$ld_totaldisponible=number_format($ld_totaldisponible,2,",",".");
						$ld_totalejecutado=number_format($ld_totalejecutado,2,",",".");
						$ld_totalacumulado=number_format($ld_totalacumulado,2,",",".");
						uf_print_pie_cabecera($ld_totalasignado,$ld_totaldisponible,$ld_totalejecutado,$ld_totalacumulado,'BsF.',$io_pdf);				
						$ld_totalasi=$ld_totalasignado;
						$ld_totaldis=$ld_totaldisponible;
						$ld_totalejec=$ld_totalejecutado;
						$ld_totalacum=$ld_totalacumulado;
						$ld_totalasignado=0;
						$ld_totaldisponible=0;
						$ld_totalejecutado=0;
						$ld_totalacumulado=0;
						$io_pdf->stopObject($io_cabecera);
						$io_pdf->stopObject($io_encabezado);
						if ((!empty($ls_programatica_next))&&($z<$li_tot))
						{
						 $io_pdf->ezNewPage(); // Insertar una nueva p�gina
						} 
						unset($la_data);
				 }
				 else
				 {
					
						$ld_asignado=number_format($ld_asignado,2,",",".");
						$ld_disponible=number_format($ld_disponible,2,",",".");
						$ld_monto_ejecutado=number_format($ld_monto_ejecutado,2,",",".");
						$ld_monto_acumulado=number_format($ld_monto_acumulado,2,",",".");
						
						$la_data[$z]=array('cuenta'=>$ls_spg_cuenta,'denominacion'=>$ls_denominacion,
										   'asignado'=>$ld_asignado,'acumulado'=>$ld_monto_acumulado,
										   'ejecutado'=>$ld_monto_ejecutado,'disponibilidad'=>$ld_disponible);
						
						$io_cabecera=$io_pdf->openObject();
						uf_print_cabecera($io_cabecera,$ls_programatica_ant,$ls_denestpro_ant,$io_pdf);
						$io_encabezado=$io_pdf->openObject();
						uf_print_cabecera_detalle($io_encabezado,$io_pdf);
						uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
						
						$ld_totalasignado_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_totalasignado, $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
						$ld_totaldisponible_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_totaldisponible, $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
						$ld_totalejecutado_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_totalejecutado, $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
						$ld_totalacumulado_bsf   = $io_rcbsf->uf_convertir_monedabsf($ld_totalacumulado, $li_candeccon,$li_tipconmon,1000,$li_redconmon);	
						
						$ld_totalasignado=number_format($ld_totalasignado,2,",",".");
						$ld_totaldisponible=number_format($ld_totaldisponible,2,",",".");
						$ld_totalejecutado=number_format($ld_totalejecutado,2,",",".");
						$ld_totalacumulado=number_format($ld_totalacumulado,2,",",".");
						uf_print_pie_cabecera($ld_totalasignado,$ld_totaldisponible,$ld_totalejecutado,$ld_totalacumulado,'Bs.',$io_pdf);	
						
						$ld_totalasignado_bsf=number_format($ld_totalasignado_bsf,2,",",".");
						$ld_totaldisponible_bsf=number_format($ld_totaldisponible_bsf,2,",",".");
						$ld_totalejecutado_bsf=number_format($ld_totalejecutado_bsf,2,",",".");
						$ld_totalacumulado_bsf=number_format($ld_totalacumulado_bsf,2,",",".");
						//uf_print_pie_cabecera($ld_totalasignado_bsf,$ld_totaldisponible_bsf,$ld_totalejecutado_bsf,$ld_totalacumulado_bsf,'BsF.',$io_pdf);													
						
						$ld_totalasi=$ld_totalasignado;
						$ld_totaldis=$ld_totaldisponible;
						$ld_totalejec=$ld_totalejecutado;
						$ld_totalacum=$ld_totalacumulado;
						$ld_totalasignado=0;
						$ld_totaldisponible=0;
						$ld_totalejecutado=0;
						$ld_totalacumulado=0;
						$io_pdf->stopObject($io_cabecera);
						$io_pdf->stopObject($io_encabezado);
						if ((!empty($ls_programatica_next))&&($z<$li_tot))
						{
						 $io_pdf->ezNewPage(); // Insertar una nueva p�gina
						} 
						unset($la_data);
				 }//if
			}//if
	    }//for
			
		$io_pdf->ezStopPageNumbers(1,1);
		if (isset($d) && $d)
		{
			$ls_pdfcode = $io_pdf->ezOutput(1);
		  	$ls_pdfcode = str_replace("\n","\n<br>",htmlspecialchars($ls_pdfcode));
		  	echo '<html><body>';
		  	echo trim($ls_pdfcode);
		  	echo '</body></html>';
		}
		else
		{
			$io_pdf->ezStream();
		}
		unset($io_pdf);
	}
	unset($io_report);
	unset($io_funciones);
	unset($io_function_report);
?> 