<?php
    session_start();   
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
		global $io_fun_scf;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_scf->uf_load_seguridad_reporte("SCF","sigesp_scf_r_listadoplanunico.php",$ls_descripcion);
		return $lb_valido;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_init_niveles()
	{	///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	   Function: uf_init_niveles
		//	     Access: public
		//	    Returns: vacio	 
		//	Description: Este m�todo realiza una consulta a los formatos de las cuentas
		//               para conocer los niveles de la escalera de las cuentas contables  
		//////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_funciones,$ia_niveles_scf;
		
		$ls_formato=""; $li_posicion=0; $li_indice=0;
		$dat_emp=$_SESSION["la_empresa"];
		//contable
		$ls_formato = trim($dat_emp["formcont"])."-";
		$li_posicion = 1 ;
		$li_indice   = 1 ;
		$li_posicion = $io_funciones->uf_posocurrencia($ls_formato, "-" , $li_indice ) - $li_indice;
		do
		{
			$ia_niveles_scf[$li_indice] = $li_posicion;
			$li_indice   = $li_indice+1;
			$li_posicion = $io_funciones->uf_posocurrencia($ls_formato, "-" , $li_indice ) - $li_indice;
		} while ($li_posicion>=0);
	}// end function uf_init_niveles
	//-----------------------------------------------------------------------------------------------------------------------------------

	//---------------------------------------------------------------------------------------------------------------------------
	// para crear el libro excel
		require_once ("../../shared/writeexcel/class.writeexcel_workbookbig.inc.php");
		require_once ("../../shared/writeexcel/class.writeexcel_worksheet.inc.php");
		$lo_archivo = tempnam("/tmp", "listado_cuentas.xls");
		$lo_libro = &new writeexcel_workbookbig($lo_archivo);
		$lo_hoja = &$lo_libro->addworksheet();
	//---------------------------------------------------------------------------------------------------------------------------
	// para crear la data necesaria del reporte
		require_once("sigesp_scf_class_report.php");
		$io_report  = new sigesp_scf_class_report();
		require_once("../../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();
		require_once("../../shared/class_folder/class_fecha.php");
		$io_fecha=new class_fecha();
		require_once("../class_folder/class_funciones_scf.php");
		$io_fun_scf=new class_funciones_scf("../../");
		$ia_niveles_scf[0]="";			
		uf_init_niveles();
		$li_total=count($ia_niveles_scf)-1;
	//---------------------------------------------------------------------------------------------------------------------------
	//Par�metros para Filtar el Reporte
		$ls_cuentadesde=$_GET["cuentadesde"];
		$ls_cuentahasta=$_GET["cuentahasta"];
	//---------------------------------------------------------------------------------------------------------------------------
	//Par�metros del encabezado
		$ls_titulo="Plan Unico de Cuentas ";
		$ls_rango="Desde ".$ls_cuenta_desde." Hasta ".$ls_cuenta_hasta;
	//---------------------------------------------------------------------------------------------------------------------------
	//Busqueda de la data 
	$lb_valido=uf_insert_seguridad("<b>Plan Unico de Cuentas en Excel</b>"); // Seguridad de Reporte
	if($lb_valido)
	{
	    $lb_valido=$io_report->uf_listadocuentas($ls_cuenta_desde,$ls_cuenta_hasta);
	}
	//---------------------------------------------------------------------------------------------------------------------------
	// Impresi�n de la informaci�n encontrada en caso de que exista
		if($lb_valido==false) // Existe alg�n error � no hay registros
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
			$lo_titulo= &$lo_libro->addformat();
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
			$lo_hoja->set_column(1,1,100);
			$lo_hoja->write(0,1,$ls_titulo,$lo_encabezado);
			$lo_hoja->write(1,1,$ls_rango,$lo_encabezado);			
			$lo_hoja->write(3, 0, "Cuenta",$lo_titulo);
			$lo_hoja->write(3, 1, "Denominaci�n",$lo_titulo);
			$li_row=3;
			$li_totrow=$io_report->DS->getRowCount("sc_cuenta");
			for($li_i=1;$li_i<=$li_totrow;$li_i++)
			{
				$ls_cuenta=rtrim($io_report->DS->data["sc_cuenta"][$li_i]);
				$ls_denominacion=rtrim($io_report->DS->data["denominacion"][$li_i]);
				$li_totfil=0;
				$as_cuenta="";
				for($li=$li_total;$li>1;$li--)
				{
					$li_ant=$ia_niveles_scf[$li-1];
					$li_act=$ia_niveles_scf[$li];
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
				$li_fila=$ia_niveles_scf[1]+1;
				$as_cuenta=substr($ls_cuenta,0,$li_fila)."-".$as_cuenta;
				$li_row=$li_row+1;
				$lo_hoja->write($li_row, 0, $as_cuenta, $lo_datacenter);
				$lo_hoja->write($li_row, 1, $ls_denominacion, $lo_dataleft);
			}
			$lo_libro->close();
			header("Content-Type: application/x-msexcel; name=\"listado_cuentas.xls\"");
			header("Content-Disposition: inline; filename=\"listado_cuentas.xls\"");
			$fh=fopen($lo_archivo, "rb");
			fpassthru($fh);
			unlink($lo_archivo);
			print("<script language=JavaScript>");
			print(" close();");
			print("</script>");
		}
?> 