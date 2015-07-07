<?php
    session_start();   
	ini_set('memory_limit','512M');
	ini_set('max_execution_time','0');

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_seguridad($as_titulo,$as_desnom,$as_periodo)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_insert_seguridad
		//		   Access: private 
		//	    Arguments: as_titulo // Título del Reporte
		//    Description: función que guarda la seguridad de quien generó el reporte
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creación: 21/06/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		$ls_descripcion="Generó el Reporte ".$as_titulo.". Para ".$as_desnom.". ".$as_periodo;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte("SNR","sigesp_snorh_r_aportepatronal.php",$ls_descripcion);
		return $lb_valido;
	}
	//--------------------------------------------------------------------------------------------------------------------------------

	//---------------------------------------------------------------------------------------------------------------------------
	// para crear el libro excel
	require_once ("../../shared/writeexcel/class.writeexcel_workbookbig.inc.php");
	require_once ("../../shared/writeexcel/class.writeexcel_worksheet.inc.php");
	$lo_archivo = tempnam("/tmp", "aporte_patronal.xls");
	$lo_libro = &new writeexcel_workbookbig($lo_archivo);
	$lo_hoja = &$lo_libro->addworksheet();
	//---------------------------------------------------------------------------------------------------------------------------
	// para crear la data necesaria del reporte
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_snorh_class_report.php");
	$io_report=new sigesp_snorh_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
        require_once("../../shared/class_folder/class_fecha.php");
	$io_fecha=new class_fecha();
	//----------------------------------------------------  Parámetros del encabezado  -----------------------------------------------
	$ls_titulo="Retenciones y Aportes Patronales en Excel";
	//--------------------------------------------------  Parámetros para Filtar el Reporte  -----------------------------------------
	$ls_codnomdes=$io_fun_nomina->uf_obtenervalor_get("codnomdes","");
	$ls_codnomhas=$io_fun_nomina->uf_obtenervalor_get("codnomhas","");
        $ls_desnomdes=$io_fun_nomina->uf_obtenervalor_get("desnomdes","");
	$ls_codconc=$io_fun_nomina->uf_obtenervalor_get("codconc","");
	$ls_nomcon=$io_fun_nomina->uf_obtenervalor_get("nomcon","");
	$ls_anodes=$io_fun_nomina->uf_obtenervalor_get("anodes","");
	$ls_mesdes=$io_fun_nomina->uf_obtenervalor_get("mesdes","");
	$ls_anohas=$io_fun_nomina->uf_obtenervalor_get("anohas","");
	$ls_meshas=$io_fun_nomina->uf_obtenervalor_get("meshas","");
	$ls_perdes=$io_fun_nomina->uf_obtenervalor_get("perdes","");
	$ls_perhas=$io_fun_nomina->uf_obtenervalor_get("perhas","");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
	$ls_tiporeporte=$io_fun_nomina->uf_obtenervalor_get("tiporeporte",0);
	$ls_subnomdes=$io_fun_nomina->uf_obtenervalor_get("codsubnomdes","");
	$ls_subnomhas=$io_fun_nomina->uf_obtenervalor_get("codsubnomhas","");
	global $ls_tiporeporte;
	$ls_bolivares="Bs.";
	if($ls_tiporeporte==1)
	{
		require_once("sigesp_snorh_class_reportbsf.php");
		$io_report=new sigesp_snorh_class_reportbsf();
		$ls_bolivares="Bs.F.";
	}
	$ls_rango= "Nómina Desde: ".$ls_codnomdes." Nómina Hasta: ".$ls_codnomhas;
	if($ls_anodes==$ls_anohas)
	{
		$ls_des_ano=$ls_anodes;
	}
	else
	{
		$ls_des_ano=$ls_anodes." al ".$ls_anohas;
	}
	if($ls_mesdes==$ls_meshas)
	{
		$ls_des_mes=$io_fecha->uf_load_nombre_mes($ls_mesdes);
	}
	else
	{
		$ls_des_mes=$io_fecha->uf_load_nombre_mes($ls_mesdes)." a ".$io_fecha->uf_load_nombre_mes($ls_meshas);
	}
	if($ls_perdes==$ls_perhas)
	{
		$ls_des_periodo=$ls_perdes;
	}
	else
	{
		$ls_des_periodo=$ls_perdes." al ".$ls_perhas;
	}

	$ls_periodo= "Año: ".$ls_des_ano." Mes: ".$ls_des_mes." - Período ".$ls_des_periodo;
	//---------------------------------------------------------------------------------------------------------------------------
	//Busqueda de la data 
	$lb_valido=uf_insert_seguridad($ls_titulo,$ls_rango,$ls_periodo); // Seguridad de Reporte
	if($lb_valido)
	{
		$lb_valido=$io_report->uf_aportepatronal_personal($ls_codnomdes,$ls_codnomhas,$ls_anodes,$ls_mesdes,$ls_anohas,$ls_meshas,
														  $ls_perdes,$ls_perhas,$ls_codconc,$ls_conceptocero,$ls_subnomdes,$ls_subnomhas,$ls_orden); // Cargar el DS con los datos del reporte
	}
	if($lb_valido==false) // Existe algún error ó no hay registros
	{
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');"); 
		print(" close();");
		print("</script>");
	}
	else // Imprimimos el reporte
	{
		$lo_encabezado= &$lo_libro->addformat();
		$lo_encabezado->set_bold();
		$lo_encabezado->set_font("Verdana");
		$lo_encabezado->set_align('center');
		$lo_encabezado->set_size('11');
                $lo_concepto= &$lo_libro->addformat();
		$lo_concepto->set_bold();
		$lo_concepto->set_font("Verdana");
		$lo_concepto->set_align('left');
		$lo_concepto->set_size('10');
		$lo_titulo= &$lo_libro->addformat();
		$lo_titulo->set_text_wrap();
		$lo_titulo->set_bold();
		$lo_titulo->set_font("Verdana");
		$lo_titulo->set_align('center');
		$lo_titulo->set_size('9');		
		$lo_datacenter= &$lo_libro->addformat();
		$lo_datacenter->set_font("Verdana");
		$lo_datacenter->set_align('center');
		$lo_datacenter->set_size('9');
		$lo_dataleft= &$lo_libro->addformat();
		$lo_dataleft->set_text_wrap();
		$lo_dataleft->set_font("Verdana");
		$lo_dataleft->set_align('left');
		$lo_dataleft->set_size('9');
		$lo_dataright= &$lo_libro->addformat(array(num_format => '#,##0.00'));
		$lo_dataright->set_font("Verdana");
		$lo_dataright->set_align('right');
		$lo_dataright->set_size('9');
		$lo_hoja->set_column(0,0,20);
		$lo_hoja->set_column(1,1,60);
		$lo_hoja->set_column(2,2,15);
		$lo_hoja->set_column(3,3,15);
		$lo_hoja->set_column(4,4,15);
                $lo_hoja->set_column(5,5,15);
		
                $lo_hoja->write(0,1,$ls_titulo,$lo_encabezado);
                $lo_hoja->write(1,1,$ls_rango,$lo_encabezado);
                $lo_hoja->write(2,1,$ls_periodo,$lo_encabezado);
                $lo_hoja->write(3,1,$ls_desnomdes,$lo_encabezado);
                $lo_hoja->write(4,0,"Concepto: ".$ls_codconc."-".$ls_nomcon,$lo_concepto);
		
		
		$lo_hoja->write(5, 0, "Cédula de Identidad",$lo_titulo);
		$lo_hoja->write(5, 1, "Apellidos y Nombres",$lo_titulo);
                $lo_hoja->write(5, 2, "Fecha Ingreso",$lo_titulo);
		$lo_hoja->write(5, 3, "Empleado",$lo_titulo);
		$lo_hoja->write(5, 4, "Patrón",$lo_titulo);
		$lo_hoja->write(5, 5, "Total",$lo_titulo);
		


		$li_row=5;

                $li_totrow=$io_report->DS->getRowCount("cedper");
		$li_totper=0;
		$li_totpat=0;
		for($li_i=1;$li_i<=$li_totrow;$li_i++)
		{
			$li_row=$li_row+1;
                        $ls_cedper=$io_report->DS->data["cedper"][$li_i];
			$ls_nomper=$io_report->DS->data["apeper"][$li_i].", ".$io_report->DS->data["nomper"][$li_i];
                        $ld_fecingper=$io_funciones->uf_convertirfecmostrar($io_report->DS->data["fecingper"][$li_i]);
			$li_personal=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS->data["personal"][$li_i]));
			$li_patron=$io_fun_nomina->uf_formatonumerico(abs($io_report->DS->data["patron"][$li_i]));
			$li_total=abs($io_report->DS->data["personal"][$li_i]+$io_report->DS->data["patron"][$li_i]);
			$li_total=$io_fun_nomina->uf_formatonumerico($li_total);
			$li_totper=$li_totper+abs($io_report->DS->data["personal"][$li_i]);
			$li_totpat=$li_totpat+abs($io_report->DS->data["patron"][$li_i]);
			$li_totalgeneral=$li_totper+$li_totpat;
			$lo_hoja->write($li_row, 0, $ls_cedper, $lo_datacenter);
                        $lo_hoja->write($li_row, 1, $ls_nomper, $lo_dataleft);
                        $lo_hoja->write($li_row, 2, $ld_fecingper, $lo_datacenter);
                        $lo_hoja->write($li_row, 3, $li_personal, $lo_dataright);
                        $lo_hoja->write($li_row, 4, $li_patron, $lo_dataright);
                        $lo_hoja->write($li_row, 5, $li_total, $lo_dataright);
		}
                $li_row=$li_row+1;

                $lo_hoja->write($li_row, 1, "TOTAL APORTE BS.", $lo_dataright);
                $lo_hoja->write($li_row, 3, $li_totper, $lo_dataright);
                $lo_hoja->write($li_row, 4, $li_totpat, $lo_dataright);
                $lo_hoja->write($li_row, 5, $li_totalgeneral, $lo_dataright);
		$io_report->DS->resetds("cedper");
		$lo_libro->close();
		header("Content-Type: application/x-msexcel; name=\"aporte_patronal.xls\"");
		header("Content-Disposition: inline; filename=\"aporte_patronal.xls\"");
		$fh=fopen($lo_archivo, "rb");
		fpassthru($fh);
		unlink($lo_archivo);
		print("<script language=JavaScript>");
		print(" close();");
		print("</script>");
		unset($io_pdf);
	}
	unset($io_report);
	unset($io_funciones);
	unset($io_fun_nomina);
?> 