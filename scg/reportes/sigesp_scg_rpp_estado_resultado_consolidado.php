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
		$lb_valido=$io_fun_scg->uf_load_seguridad_reporte("SCG","sigesp_scg_r_estado_resultado_consolidado.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_titulo1,$as_titulo2,$as_titulo3,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		    Acess: private
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. N�stor Falc�n.
		// Fecha Creaci�n: 28/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(20,40,578,40);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,710,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo

		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=330-($li_tm/2);
		$io_pdf->addText($tm,705,11,$as_titulo); // Agregar el t�tulo

		$li_tm=$io_pdf->getTextWidth(11,$as_titulo1);
		$tm=330-($li_tm/2);
		$io_pdf->addText($tm,690,11,$as_titulo1); // Agregar el t�tulo
		
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo2);
		$tm=330-($li_tm/2);
		$io_pdf->addText($tm,680,11,$as_titulo2); // Agregar el t�tulo

		$li_tm=$io_pdf->getTextWidth(11,$as_titulo3);
		$tm=330-($li_tm/2);
		$io_pdf->addText($tm,670,11,$as_titulo3); // Agregar el t�tulo

		$io_pdf->addText(510,725,7,$_SESSION["ls_database"]); // Agregar la Base de datos
		$io_pdf->addText(510,715,8,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(510,705,8,date("h:i a")); // Agregar la hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera_ingreso(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private
		//	    Arguments: io_pdf // Objeto PDF
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. N�stor Falc�n.
		// Fecha Creaci�n: 28/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data=array(array('name'=>'<b>INGRESOS</b> '));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>1, // Mostrar L�neas
						 'fontSize' => 7, // Tama�o de Letras
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.7,0.7,0.7), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>500, // Ancho de la tabla
						 'rowGap'=>2,
						 'colGap'=>3,
						 'maxWidth'=>500); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->ezSetDy(-1);
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera_egreso(&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera_egreso
		//		   Access: private
		//	    Arguments: io_pdf // Objeto PDF
		//    Description: funci�n que imprime la cabecera de cada p�gina
		//	   Creado Por: Ing. N�stor Falc�n.
		// Fecha Creaci�n: 28/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$la_data=array(array('name'=>'<b>EGRESOS</b> '));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>1, // Mostrar L�neas
						 'fontSize' => 7, // Tama�o de Letras
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.7,0.7,0.7), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>500, // Ancho de la tabla
						 'rowGap'=>2,
						 'colGap'=>3,
						 'maxWidth'=>500); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$io_pdf->ezSetDy(-1);
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_ingreso($la_data,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. N�stor Falc�n.
		// Fecha Creaci�n: 28/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap'=>2,
						 'colGap'=>3,
						 'cols'=>array('cuenta'=>array('justification'=>'center','width'=>90), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>110), // Justificaci�n y ancho de la columna
						 			   'saldomay'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
						 			   'saldomen'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
									   'saldo'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$la_columnas=array('cuenta'=>'<b>Cuenta</b>','denominacion'=>'<b>Denominaci�n</b>','saldomay'=>'<b>Saldo</b>','saldomen'=>'','saldo'=>'');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle_egreso($la_data_egr,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. N�stor Falc�n.
		// Fecha Creaci�n: 28/04/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'rowGap'=>2,
						 'colGap'=>3,
						 'cols'=>array('cuenta'=>array('justification'=>'center','width'=>90), // Justificaci�n y ancho de la columna
						 			   'denominacion'=>array('justification'=>'left','width'=>110), // Justificaci�n y ancho de la columna
						 			   'saldomay'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
						 			   'saldomen'=>array('justification'=>'right','width'=>100), // Justificaci�n y ancho de la columna
									   'saldo'=>array('justification'=>'right','width'=>100))); // Justificaci�n y ancho de la columna
		$la_columnas=array('cuenta'=>'<b>Cuenta</b>','denominacion'=>'<b>Denominaci�n</b>','saldomay'=>'<b>Saldo</b>','saldomen'=>'','saldo'=>'');
		$io_pdf->ezTable($la_data_egr,$la_columnas,'',$la_config);
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera_ingreso($ld_total_ingresos,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera
		//		    Acess : private
		//	    Arguments : ad_totaldebe // Total debe
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por : Ing. N�stor Falc�n.
		// Fecha Creaci�n : 18/02/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		
		$la_data=array(array('total'=>'<b>Total Ingreso '.$ls_bolivares.'</b>','saldomay'=>$ld_total_ingresos));
		$la_columna=array('total'=>'','saldomay'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho M�ximo de la tabla
						 'rowGap'=>2,
						 'colGap'=>3,
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('total'=>array('justification'=>'right','width'=>300), // Justificaci�n y ancho de la columna
						 			   'saldomay'=>array('justification'=>'right','width'=>200))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera_egreso($ld_total_egresos,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera_egreso
		//		    Acess : private
		//	    Arguments : ld_total_egresos // Total debe
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por : Ing. N�stor Falc�n.
		// Fecha Creaci�n : 18/02/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		
		$la_data=array(array('total'=>'<b>Total Egreso '.$ls_bolivares.'</b>','saldomay'=>$ld_total_egresos));
		$la_columna=array('total'=>'','saldomay'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 7, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'rowGap'=>2,
						 'colGap'=>3,
						 'width'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('total'=>array('justification'=>'right','width'=>300), // Justificaci�n y ancho de la columna
						 			   'saldomay'=>array('justification'=>'right','width'=>200))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_pie_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_pie_cabecera($ld_total,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function : uf_print_pie_cabecera_egreso
		//		    Acess : private
		//	    Arguments : ld_total // Total 
		//    Description : funci�n que imprime el fin de la cabecera de cada p�gina
		//	   Creado Por : Ing. N�stor Falc�n.
		// Fecha Creaci�n : 18/02/2006
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $ls_bolivares;
		if($ld_total<0)
		{
			$ls_cadena="DESAHORRO";
		}
		else
		{
			$ls_cadena="AHORRO";
		}
		$la_data=array(array('total'=>'<b>Total ('.$ls_cadena.') '.$ls_bolivares.'</b>','saldomay'=>$ld_total));
		$la_columna=array('total'=>'','saldomay'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'rowGap'=>2, // ancho entre lineas 
						 'colGap'=>3, //ancho entre  columnas
						 'width'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				 		 'cols'=>array('total'=>array('justification'=>'right','width'=>300), // Justificaci�n y ancho de la columna
						 			   'saldomay'=>array('justification'=>'right','width'=>200))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$la_data=array(array('name'=>''));
		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center'); // Orientaci�n de la tabla
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
	 require_once("sigesp_scg_reporte.php");
	 require_once("../class_funciones_scg.php");
	 require_once("../../shared/ezpdf/class.ezpdf.php");
	 require_once("../../shared/class_folder/class_fecha.php");
	 require_once("../../shared/class_folder/class_funciones.php");
	 $io_fecha	   = new class_fecha();
	 $io_report    = new sigesp_scg_reporte();
	 $io_fun_scg   = new class_funciones_scg();
	 $io_funciones = new class_funciones();
	 
	 $ia_niveles_scg[0]="";			
	 uf_init_niveles();
	 $li_total=count($ia_niveles_scg)-1;
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	 $ls_hidbot=$_GET["hidbot"];
	 if ($ls_hidbot==true)
	    {
	      $ls_cmbmesdes  = $_GET["cmbmesdes"];
	      $ls_cmbagnodes = $_GET["cmbagnodes"];
		  if ($_SESSION["ls_gestor"]=='INFORMIX')
		     {
			   $fecdes=$ls_cmbagnodes."-".$ls_cmbmesdes."-01";
			   $ldt_fecdes=$ls_cmbagnodes."-".$ls_cmbmesdes."-01";
		     }
		  else 
		     {
			   $fecdes=$ls_cmbagnodes."-".$ls_cmbmesdes."-01"." 00:00:00";
			   $ldt_fecdes=$ls_cmbagnodes."-".$ls_cmbmesdes."-01"." 00:00:00";
		     }
		  $ls_cmbmeshas  = $_GET["cmbmeshas"];
		  $ls_cmbagnohas = $_GET["cmbagnohas"];
		  $ls_last_day	 = $io_fecha->uf_last_day($ls_cmbmeshas,$ls_cmbagnohas);
		  $fechas		 = $ls_last_day;
		  $ldt_fechas	 = $io_funciones->uf_convertirdatetobd($ls_last_day);
	    }
	 elseif($ls_hidbot==false)
	    {
		  $fecdes	  = $_GET["txtfecdes"];
		  $ldt_fecdes = $io_funciones->uf_convertirdatetobd($fecdes);
		  $fechas	  = $_GET["txtfechas"];
		  $ldt_fechas = $io_funciones->uf_convertirdatetobd($fechas);
	    }

		$ldt_periodo=$_SESSION["la_empresa"]["periodo"];
		$li_ano=substr($ldt_periodo,0,4);
		$ls_nombre=$_SESSION["la_empresa"]["nombre"];
		$ld_fecdes=$io_funciones->uf_convertirfecmostrar($fecdes);
		$ld_fechas=$io_funciones->uf_convertirfecmostrar($fechas);
		$ls_titulo="<b>ESTADO DE RESULTADOS CONSOLIDADO</b>";
		$ls_titulo1="<b> ".$ls_nombre." </b>"; 
		$ls_titulo2="<b> al ".$ld_fechas."</b>";
		$ls_titulo3="<b>(Expresado en Bs.)</b>";  
	//--------------------------------------------------------------------------------------------------------------------------------
    // Cargar datastore con los datos del reporte
	error_reporting(E_ALL);
	$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
	$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
	$io_pdf->ezSetCmMargins(4.5,3,3,3); // Configuraci�n de los margenes en cent�metros
	uf_print_encabezado_pagina($ls_titulo,$ls_titulo1,$ls_titulo2,$ls_titulo3,$io_pdf); // Imprimimos el encabezado de la p�gina
	$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
	$lb_valido=uf_insert_seguridad("<b>Estado de Resultado Consolidado en PDF</b>"); // Seguridad de Reporte
	if ($lb_valido)
	   {
	     $lb_valido_ing = $io_report->uf_scg_reporte_estado_de_resultado_ingreso_consolidado($ldt_fecdes,$ldt_fechas);
		 $lb_valido_egr = $io_report->uf_scg_reporte_estado_de_resultado_egreso_consolidado($ldt_fecdes,$ldt_fechas);
	   }
	if ((($lb_valido_ing==false)&&($lb_valido_egr==false))||($lb_valido==false)) // Existe alg�n error � no hay registros
	   {
	     print("<script language=JavaScript>");
	     print(" alert('No hay nada que Reportar');");
		 //print(" close();");
	 	 print("</script>");
	   }
	else
	   {
		  if ($lb_valido_ing)
		     {
			   $li_tot = $io_report->dts_reporte->getRowCount("sc_cuenta");
			   for ($li_i=1;$li_i<=$li_tot;$li_i++)
				   {
					 $io_pdf->transaction('start'); // Iniciamos la transacci�n
					 $thisPageNum=$io_pdf->ezPageCount;
					 $ls_sc_cuenta=trim($io_report->dts_reporte->data["sc_cuenta"][$li_i]);
					 $li_totfil=0;
					 $as_cuenta="";
					 for ($li=$li_total;$li>1;$li--)
					     {
						   $li_ant	  = $ia_niveles_scg[$li-1];
						   $li_act	  = $ia_niveles_scg[$li];
						   $li_fila	  = $li_act-$li_ant;
						   $li_len	  = strlen($ls_sc_cuenta);						
						   $li_totfil = $li_totfil+$li_fila;     
						   $li_inicio = $li_len-$li_totfil;      
						   if ($li==$li_total)
							  {
							    $as_cuenta = substr($ls_sc_cuenta,$li_inicio,$li_fila);
							  }
						   else
							  {
							    $as_cuenta = substr($ls_sc_cuenta,$li_inicio,$li_fila)."-".$as_cuenta;
							  }
					     }
					 $li_fila			= $ia_niveles_scg[1]+1; 
					 $as_cuenta			= substr($ls_sc_cuenta,0,$li_fila)."-".$as_cuenta;
					 $ls_denominacion   = $io_report->dts_reporte->data["denominacion"][$li_i];
					 $ld_saldo			= $io_report->dts_reporte->data["saldo"][$li_i];
					 $ld_total_ingresos = $io_report->dts_reporte->data["total_ingresos"][$li_i];
					 $ls_nivel			= $io_report->dts_reporte->data["nivel"][$li_i];
					 if ($ls_nivel>3)
					    {
						  $ld_saldo=abs($ld_saldo);
						  $ld_saldomay=number_format($ld_saldo,2,",",".");
						  $ld_saldomen="";  
						  $ld_saldo="";
					    }
					 if ($ls_nivel==3)
					    {
						  $ld_saldo	   = abs($ld_saldo);					
						  $ld_saldomay = "";
						  $ld_saldomen = number_format($ld_saldo,2,",",".");  
						  $ld_saldo	   = "";
					    }
					 if (($ls_nivel==1)||($ls_nivel==2))
					    {
						  $ld_saldo	   = abs($ld_saldo);					
						  $ld_saldomay = "";
						  $ld_saldomen = "";  
						  $ld_saldo	   = number_format($ld_saldo,2,",",".");
					    }
					 $la_data[$li_i]=array('cuenta'=>$as_cuenta,'denominacion'=>$ls_denominacion,'saldomay'=>$ld_saldomay,'saldomen'=>$ld_saldomen,'saldo'=>$ld_saldo);
			       }
			   uf_print_cabecera_ingreso($io_pdf);
			   uf_print_detalle_ingreso($la_data,$io_pdf); // Imprimimos el detalle 
			   $ld_total_ingresos=abs($ld_total_ingresos);
			   $ld_total_ingresos=number_format($ld_total_ingresos,2,",",".");
			   uf_print_pie_cabecera_ingreso($ld_total_ingresos,$io_pdf); // Imprimimos pie de la cabecera
		     }
		  if ($lb_valido_egr)
	         {
			   $li_tot = $io_report->dts_egresos->getRowCount("sc_cuenta"); 
			   for ($li_i=1;$li_i<=$li_tot;$li_i++)
				   {
					 $thisPageNum  = $io_pdf->ezPageCount;
					 $ls_sc_cuenta = trim($io_report->dts_egresos->data["sc_cuenta"][$li_i]);
					 $li_totfil	   = 0;
					 $as_cuenta	   = "";
					 for ($li=$li_total;$li>1;$li--)
					     {
						   $li_ant	  = $ia_niveles_scg[$li-1];
						   $li_act	  = $ia_niveles_scg[$li];
						   $li_fila	  = $li_act-$li_ant;
						   $li_len	  = strlen($ls_sc_cuenta);	
						   $li_totfil = $li_totfil+$li_fila;     
						   $li_inicio = $li_len-$li_totfil;      
						   if ($li==$li_total)
							  {
							    $as_cuenta = substr($ls_sc_cuenta,$li_inicio,$li_fila);
							  }
						   else
							  {
							    $as_cuenta = substr($ls_sc_cuenta,$li_inicio,$li_fila)."-".$as_cuenta;
							  }
					     }
					 $li_fila		   = $ia_niveles_scg[1]+1; 
					 $as_cuenta		   = substr($ls_sc_cuenta,0,$li_fila)."-".$as_cuenta;
					 $ls_denominacion  = $io_report->dts_egresos->data["denominacion"][$li_i];
					 $ld_saldo		   = $io_report->dts_egresos->data["saldo"][$li_i];
					 $ld_total_egresos = $io_report->dts_egresos->data["total_egresos"][$li_i];
					 $ls_nivel		   = $io_report->dts_egresos->data["nivel"][$li_i];
					 if ($ls_nivel>3)
					    {
						  $ld_saldo	   = abs($ld_saldo);
						  $ld_saldomay = number_format($ld_saldo,2,",",".");
						  $ld_saldomen = "";  
						  $ld_saldo    = "";
					    }
					 if ($ls_nivel==3)
					    {
						  $ld_saldo	   = abs($ld_saldo);
						  $ld_saldomay = "";
						  $ld_saldomen = number_format($ld_saldo,2,",",".");  
						  $ld_saldo	   = "";
					    }
					 if (($ls_nivel==1)||($ls_nivel==2))
						{
						  $ld_saldo    = abs($ld_saldo);
						  $ld_saldomay = "";
						  $ld_saldomen = "";  
						  $ld_saldo    = number_format($ld_saldo,2,",",".");
						}
					 $la_data_egr[$li_i] = array('cuenta'=>$as_cuenta,'denominacion'=>$ls_denominacion,'saldomay'=>$ld_saldomay,'saldomen'=>$ld_saldomen,'saldo'=>$ld_saldo);
				   }
			   uf_print_cabecera_egreso($io_pdf);
			   uf_print_detalle_egreso($la_data_egr,$io_pdf); // Imprimimos el detalle
			   if ($lb_valido_ing)
			      { 
					$ld_total_ingresos = str_replace('.','',$ld_total_ingresos);
					$ld_total_ingresos = str_replace(',','.',$ld_total_ingresos);	
				  }
			   else
				  {
				    $ld_total_ingresos=0;
				  }
			   $ld_total_egresos=abs($ld_total_egresos);
		       $ld_total=trim($ld_total_ingresos)-($ld_total_egresos);
			   $ld_total_egresos=number_format($ld_total_egresos,2,",",".");
			   uf_print_pie_cabecera_egreso($ld_total_egresos,$io_pdf); // Imprimimos pie de la cabecera	  
			   $ld_total=number_format($ld_total,2,",",".");
               uf_print_pie_cabecera($ld_total,$io_pdf);
		     }
		  
		  unset($la_data,$la_data_egr);		
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
    unset($io_report,$io_funciones);			
?> 