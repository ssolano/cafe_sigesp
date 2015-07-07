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
	ini_set('memory_limit','512M');
	ini_set('max_execution_time','0');

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//    Description: funci�n que guarda la seguridad de quien gener� el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 22/09/2006 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_scg;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_scg->uf_load_seguridad_reporte("SCG","sigesp_scg_r_comparados_est_resultado.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_titulo2,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		    Acess: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(20,40,960,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,530,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo		
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=500-($li_tm/2);
		$io_pdf->addText($tm,550,11,$as_titulo); // Agregar el t�tulo		
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo2);
		$tm=500-($li_tm/2);
		$io_pdf->addText($tm,530,11,$as_titulo2); // Agregar el t�tulo
		$io_pdf->addText(910,540,7,$_SESSION["ls_database"]); // Agregar la Base de datos
		$io_pdf->addText(910,530,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(910,520,8,date("h:i a")); // Agregar la hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_2=$io_pdf->openObject();
		$io_pdf->saveState();
		$li_pos=180;
		$io_pdf->convertir_valor_mm_px(&$li_pos);
		$io_pdf->ezSetY($li_pos);
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>700, // Ancho de la tabla
						 'maxWidth'=>700, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>450,
						 'cols'=>array('cuentas'=>array('justification'=>'center','width'=>200), // Justificaci�n y ancho de la columna
						 			   'programado'=>array('justification'=>'center','width'=>200), // Justificaci�n y ancho de la columna
						 			   'real'=>array('justification'=>'center','width'=>200), // Justificaci�n y ancho de la columna
						 			   'variacion'=>array('justification'=>'center','width'=>220))); // Justificaci�n y ancho de la columna
		$la_columnas=array('cuentas'=>' ',
						   'programado'=>' ',
						   'real'=>' ',
						   'variacion'=>' ');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_2,'all');
	}// end function uf_print_detalle
	//-------------------------------------------------------------------------------------------------------------------------------

	function uf_print_encabezado_reprog($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_3=$io_pdf->openObject();
		$io_pdf->saveState();
		$li_pos=180;
		$io_pdf->convertir_valor_mm_px(&$li_pos);
		$io_pdf->ezSetY($li_pos);
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>120, // Ancho de la tabla
						 'maxWidth'=>120, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>910,
						 'cols'=>array('cuentas'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$la_columnas=array('cuentas'=>' ');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_3,'all');
	}// end function uf_print_detalle
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado2($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_4=$io_pdf->openObject();
		$io_pdf->saveState();
		$li_pos=175.3;
		$io_pdf->convertir_valor_mm_px(&$li_pos);
		$io_pdf->ezSetY($li_pos);
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>820, // Ancho de la tabla
						 'maxWidth'=>820, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>340,
						 'cols'=>array('cuentas'=>array('justification'=>'center','width'=>50), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'center','width'=>150), // Justificaci�n y ancho de la columna
						 			   'periodo1'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'acumulado1'=>array('justification'=>'center','width'=>100), // Justificaci�n y ancho de la columna
						 			   'periodo2'=>array('justification'=>'center','width'=>100),
									   'acumulado2'=>array('justification'=>'center','width'=>100))); // Justificaci�n y ancho de la columna
		$la_columnas=array('cuentas'=>' ','denominacion'=>' ' ,'periodo1'=>' ',
							  'acumulado1'=>' ','periodo2'=>' ','acumulado2'=>' ');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_4,'all');
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------
	
	function uf_print_detalle($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$li_pos=166;
		$io_pdf->convertir_valor_mm_px(&$li_pos);
		$io_pdf->ezSetY($li_pos);
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 7,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>820, // Ancho de la tabla
						 'maxWidth'=>820, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>500,
						 'cols'=>array('cuentas'=>array('justification'=>'center','width'=>50), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>150), // Justificaci�n y ancho de la columna
						 			   'periodo1'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
						 			   'acumulado1'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
						 			   'periodo2'=>array('justification'=>'right','width'=>100),
									   'acumulado2'=>array('justification'=>'right','width'=>100),
									   'absoluta1'=>array('justification'=>'right','width'=>80),
									   'porc1'=>array('justification'=>'right','width'=>30),
									   'absoluta2'=>array('justification'=>'right','width'=>80),
									   'porc2'=>array('justification'=>'right','width'=>30),
									   'reprox'=>array('justification'=>'right','width'=>100))); 
		$la_columnas=array('cuentas'=>' ','denominacion'=>' ' ,'periodo1'=>' ',
							  'acumulado1'=>' ','periodo2'=>' ','acumulado2'=>' ','absoluta1'=>' ','porc1'=>' ','absoluta2'=>' ','porc2'=>' ','reprox'=>' ');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//-----------------------------------------------------------------------------------------------------------------------------

	function uf_print_absolutos($ls_etiqueta,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaci�n: 28/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_5=$io_pdf->openObject();
		$io_pdf->saveState();
		$li_pos=175.3;
		$io_pdf->convertir_valor_mm_px(&$li_pos);
		$io_pdf->ezSetY($li_pos);
		$la_data[1]=array('absoluta1'=>strtoupper($ls_etiqueta),'absoluta2'=>'  Acumulado ');			
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>200, // Ancho de la tabla
						 'maxWidth'=>200, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>750,
						 'cols'=>array('absoluta1'=>array('justification'=>'center','width'=>110), // Justificaci�n y ancho de la columna
						 			   'absoluta2'=>array('justification'=>'center','width'=>110))); // Justificaci�n y ancho de la columna
		$la_columnas=array('absoluta1'=>'  ','absoluta2'=>'  ' );
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		
		$la_data[1]=array('absoluta1'=>'Absoluta','porc1'=>' % ','absoluta2'=>'  Absoluta ','porc2'=>' % ' );			
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'colGap'=>1, // separacion entre tablas
						 'width'=>200, // Ancho de la tabla
						 'maxWidth'=>200, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'xPos'=>750,
						 'cols'=>array('absoluta1'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'porc1'=>array('justification'=>'center','width'=>30),
						 			   'absoluta2'=>array('justification'=>'center','width'=>80),
									   'porc2'=>array('justification'=>'center','width'=>30))); // Justificaci�n y ancho de la columna
		$la_columnas=array('absoluta1'=>'  ','porc1'=>' ' ,'absoluta2'=>'  ','porc2'=>'  ' );
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_5,'all');
	}// end function uf_print_detalle
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera($ld_total,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera
		//		    Acess : private
		//	    Arguments : ad_totaldebe // Total debe
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por : Ing. Yozelin Barragan
		// Fecha Creaci�n : 18/02/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data=array(array('total'=>'<b>Total Pasivo + Capital + Resultado del Ejercicio</b>','totalgen'=>$ld_total));
		$la_columna=array('total'=>'','totalgen'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>0, // Mostrar L�neas
						 'fontSize' => 9, // Tama�o de Letras
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>530, // Ancho M�ximo de la tabla
						 'colGap'=>1, // separacion entre tablas
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('total'=>array('justification'=>'right','width'=>290), // Justificaci�n y ancho de la columna
						 			   'totalgen'=>array('justification'=>'right','width'=>240))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_init_niveles()
	{	///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	   Function: uf_init_niveles
		//	     Access: public
		//	    Returns: vacio	 
		//	Description: Este m�todo realiza una consulta a los formatos de las cuentas
		//               para conocer los niveles de la escalera de las cuentas contables  
		//////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_funciones,$ia_niveles_scg;
		
		$ls_formato=""; $li_posicion=0; $li_indice=0;
		$dat_emp=$_SESSION["la_empresa"];
		//contable
		$ls_formato = trim($dat_emp["formcont"])."-";
		$li_posicion = 1 ;
		$li_indice   = 1 ;
		$li_posicion = $io_funciones->uf_posocurrencia($ls_formato, "-" , $li_indice ) - $li_indice;
		do
		{
			$ia_niveles_scg[$li_indice] = $li_posicion;
			$li_indice   = $li_indice+1;
			$li_posicion = $io_funciones->uf_posocurrencia($ls_formato, "-" , $li_indice ) - $li_indice;
		} while ($li_posicion>=0);
	}// end function uf_init_niveles
	//-----------------------------------------------------------------------------------------------------------------------------------

	 require_once("../../shared/class_folder/class_pdf.php");
	 require_once("../../shared/class_folder/sigesp_include.php");
	 require_once("../../shared/class_folder/class_funciones.php");
	 $io_funciones=new class_funciones();
	 require_once("../../shared/class_folder/class_fecha.php");
	 $io_fecha=new class_fecha();
	 require_once("../../shared/class_folder/class_sigesp_int.php");
	 require_once("../../shared/class_folder/class_sigesp_int_scg.php");
 	 require_once("../../shared/class_folder/class_sigesp_int_spi.php");
 	 require_once("../../shared/class_folder/class_sigesp_int_spg.php");
	 require_once("../class_funciones_scg.php");
	 $io_fun_scg=new class_funciones_scg();
		$ls_tiporeporte="0";
		$ls_bolivares="";
		if (array_key_exists("tiporeporte",$_GET))
		{
			$ls_tiporeporte=$_GET["tiporeporte"];
		}
		switch($ls_tiporeporte)
		{
			case "0":
				require_once("sigesp_scg_class_comparados.php");
				$io_report  = new sigesp_scg_class_comparados();
				$ls_bolivares ="Bs.";
				break;
	
			case "1":
				require_once("sigesp_scg_class_comparadosbsf.php");
				$io_report  = new sigesp_scg_class_comparadosbsf();
				$ls_bolivares ="Bs.F.";
				break;
		}
	$ia_niveles_scg[0]="";			
	uf_init_niveles();
	$li_total=count($ia_niveles_scg)-1;
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	   	$ldt_periodo=$_SESSION["la_empresa"]["periodo"];
		$li_ano=substr($ldt_periodo,0,4);
		
		$ls_etiqueta=$_GET["txtetiqueta"];
		if($ls_etiqueta=="Mensual")
		{
			$ls_combo=$_GET["combo"];
			$ls_combomes=$_GET["combomes"];
			$li_mesdes=substr($ls_combo,0,2);
			$li_meshas=substr($ls_combomes,0,2); 
			$li_mesdes=intval($li_mesdes);
			$li_meshas=intval($li_meshas); 
			$li_cant_mes=1;
			if($li_meshas==12)
			{
				$io_report->li_mes_prox=0;
			}
			elseif($li_meshas<=11)
			{
				$io_report->li_mes_prox=1;
			}
            $ls_meses=$io_report->uf_nombre_mes_desde_hasta($li_mesdes,$li_meshas);
			$ls_combo=$ls_combo.$ls_combomes;
		}
		else
		{
			$ls_combo=$_GET["combo"];
			$li_mesdes=substr($ls_combo,0,2);
			$li_meshas=substr($ls_combo,2,2); 
			$li_mesdes=intval($li_mesdes);
			$li_meshas=intval($li_meshas); 
			if($ls_etiqueta=="Bi-Mensual")
			{
				$li_cant_mes=2;
				if($li_meshas==12)
				{
					$io_report->li_mes_prox=0;
				}
				elseif($li_meshas<=10)
				{
					$io_report->li_mes_prox=2;
				}
				$ls_meses=$io_report->uf_nombre_mes_desde_hasta($li_mesdes,$li_meshas);
			}
			if($ls_etiqueta=="Trimestral")
			{
				$li_cant_mes=3;
				if($li_meshas==12)
				{
					$io_report->li_mes_prox=0;
				}
				elseif($li_meshas<=9)
				{
					$io_report->li_mes_prox=3;
				}
				$ls_meses=$io_report->uf_nombre_mes_desde_hasta($li_mesdes,$li_meshas);
			}
			if($ls_etiqueta=="Semestral")
			{
				$li_cant_mes=6;
				if($li_meshas==12)
				{
					$io_report->li_mes_prox=0;
				}
				elseif($li_meshas<=6)
				{
					$io_report->li_mes_prox=6;
				}
				$ls_meses=$io_report->uf_nombre_mes_desde_hasta($li_mesdes,$li_meshas);
			}
		}
		$ls_mesdes=substr($ls_combo,0,2);
		$ls_meshas=substr($ls_combo,2,2);
		$ls_diades="01";
		$ls_diahas=$io_fecha->uf_last_day($ls_meshas,$li_ano);
		$ldt_fecdes=$ls_diades."/".$ls_mesdes."/".$li_ano;
		$ldt_fechas=$ls_diahas;
		$ld_fechas=$io_funciones->uf_convertirfecmostrar($ldt_fechas);
		$ls_titulo="<b>COMPARADO ESTADO RESULTADO</b>";
		$ls_titulo1="<b>".$ls_titulo."  (Expresado en ".$ls_bolivares.")   al  </b>"."<b>".$ld_fechas."</b>";
	//--------------------------------------------------------------------------------------------------------------------------------
    // Cargar datastore con los datos del reporte
	$lb_valido=uf_insert_seguridad("<b>Instructivo 04 Comparado Estado de Resultado</b>"); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_crear_reporte($ldt_fecdes,$ldt_fechas,$li_cant_mes);
	}
		if($lb_valido==false) // Existe alg�n error � no hay registros
		{
			/*print("<script language=JavaScript>");
			print(" alert('No hay nada que Reportar');"); 
			print(" close();");                                        
			print("</script>");*/
		}	
		else// Imprimimos el reporte
		{
			error_reporting(E_ALL);
			//set_time_limit(1800);
			$io_pdf=new class_pdf('LEGAL','landscape'); // Instancia de la clase PDF
			$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
			$io_pdf->ezSetCmMargins(5,3,3,3); // Configuraci�n de los margenes en cent�metros
			uf_print_encabezado_pagina($ls_titulo,$ls_titulo1,$io_pdf); // Imprimimos el encabezado de la p�gina
			$io_pdf->ezStartPageNumbers(940,50,10,'','',1); // Insertar el n�mero de p�gina
			$li_tot=$io_report->ds_cuentas->getRowCount("sc_cuenta");			
       	    $ld_saldo4="";
		    $ld_saldo3="";  
		    $ld_saldo2="";
			$ld_total=0;
			$la_data[1]=array('cuentas'=>'CUENTAS','programado'=>'BALANCE PROGRAMADO','real'=>'BALANCE REAL','variacion'=>'VARIACION','reprog'=>'REPROGRAMACION');			
			uf_print_encabezado($la_data,$io_pdf); // Imprimimos el detalle 
			
			$la_data[1]=array('cuentas'=>'REPROGRAMACION');			
			$la_data[2]=array('cuentas'=>'PROXIMO'       );			
			$la_data[3]=array('cuentas'=>strtoupper($ls_etiqueta));			
			$io_pdf->transaction('start'); // Iniciamos la transacci�n
			uf_print_encabezado_reprog($la_data,$io_pdf); // Imprimimos el detalle 
			$thisPageNum=$io_pdf->ezPageCount;
			unset($la_data);
			$la_data[1]=array('cuentas'=>'           ','denominacion'=>'     ','periodo1'=>'     ','acumulado1'=>'        ','periodo2'=> '           ','acumulado2'=>'      ');			
			$la_data[2]=array('cuentas'=>'Codigo','denominacion'=>'Denominacion','periodo1'=>strtoupper($ls_etiqueta),
							  'acumulado1'=>'Acumulado','periodo2'=>strtoupper($ls_etiqueta),'acumulado2'=>'Acumulado');
			uf_print_encabezado2($la_data,$io_pdf);
			uf_print_absolutos($ls_etiqueta,&$io_pdf);			
			//print_r($io_report->ds_cuentas->data);
			for($li_i=1;$li_i<=$li_tot;$li_i++)
			{
				$ls_cuenta       = substr($io_report->ds_cuentas->getValue("sc_cuenta",$li_i),0,9);	
				$ls_denominacion = $io_report->ds_cuentas->getValue("denominacion",$li_i);
				$ls_tipo         = $io_report->ds_cuentas->getValue("tipo",$li_i);	
				switch($ls_tipo){
					case '0':
						$ls_denominacion="   ".$ls_denominacion."";
						break;
					case '1':
						$ls_denominacion="          -  ".$ls_denominacion;
						break;	
				}	
				$ldec_programado = $io_report->ds_cuentas->getValue("programado",$li_i);	
				$ldec_programado_acum  = $io_report->ds_cuentas->getValue("programado_acum",$li_i);	
				$ldec_s_ant      = $io_report->ds_cuentas->getValue("s_ant",$li_i);	
				$ldec_saldo_ant  = $io_report->ds_cuentas->getValue("saldo_ant",$li_i);	
				$ldec_prevproxmes = $io_report->ds_cuentas->getValue("prevproxmes",$li_i);
				$ldec_s1         = $io_report->ds_cuentas->getValue("s_1",$li_i);
				$ldec_s2         = $io_report->ds_cuentas->getValue("s_2",$li_i);
				$ldec_s3         = $io_report->ds_cuentas->getValue("s_3",$li_i);
				$ldec_s4         = $io_report->ds_cuentas->getValue("s_4",$li_i);
				$ldec_s5         = $io_report->ds_cuentas->getValue("s_5",$li_i);
				$ldec_s6         = $io_report->ds_cuentas->getValue("s_6",$li_i);																
				$ldec_s7         = $io_report->ds_cuentas->getValue("s_7",$li_i);
				$ls_nivel        = $io_report->ds_cuentas->getValue("nivel",$li_i);
				$ldec_ejecutado   = $io_report->ds_cuentas->getValue("ejecutado",$li_i);
				$ldec_ejecutado_acum   = $io_report->ds_cuentas->getValue("ejecutado_acum",$li_i);
				$ldec_porc1      = abs($io_report->ds_cuentas->getValue("p1",$li_i));
				$ldec_porc2      = abs($io_report->ds_cuentas->getValue("p2",$li_i));
				$ldec_variacion  = abs($io_report->ds_cuentas->getValue("variacion",$li_i));
				$ldec_variacionacum  = abs($io_report->ds_cuentas->getValue("variacion_acum",$li_i));	
				
/*
					$li_totfil=0;
					$as_cuenta="";
					for($li=$li_total;$li>1;$li--)
					{
						$li_ant=$ia_niveles_scg[$li-1];
						$li_act=$ia_niveles_scg[$li];
						$li_fila=$li_act-$li_ant;
						$li_len=strlen($ls_cuenta);
						$li_totfil=$li_totfil+$li_fila;
						$li_inicio=$li_len-$li_totfil;
						if($li==$li_total)
						{
							$as_cuenta=substr($ls_cuenta,$li_inicio,$li_fila);
						}
						else
						{
							$as_cuenta=substr($ls_cuenta,$li_inicio,$li_fila)."-".$as_cuenta;
						}
					}
					$li_fila=$ia_niveles_scg[1]+1;
					$as_cuenta=substr($ls_cuenta,0,$li_fila)."-".$as_cuenta;*/


				$la_data[$li_i]=array('cuentas'=>$ls_cuenta,'denominacion'=>$ls_denominacion ,'periodo1'=>number_format($ldec_programado,2,",","."),
							  'acumulado1'=>number_format($ldec_programado_acum,2,",","."),'periodo2'=>number_format($ldec_ejecutado,2,",","."),'acumulado2'=>number_format($ldec_ejecutado_acum,2,",","."),'absoluta1'=>number_format($ldec_variacion,2,",","."),'porc1'=>number_format($ldec_porc1,2,",","."),'absoluta2'=>number_format($ldec_variacionacum,2,",","."),'porc2'=>number_format($ldec_porc2,2,",","."),'reprox'=>number_format($ldec_prevproxmes,2,",","."));
			}//for
			uf_print_detalle($la_data,$io_pdf);
			$ld_total=abs($ld_total);
			$ld_total=number_format($ld_total,2,",",".");
			//uf_print_pie_cabecera($ld_total,$io_pdf); // Imprimimos pie de la cabecera
			unset($la_data);		
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
		 }//else
		unset($io_report);
	    unset($io_funciones);			
?> 