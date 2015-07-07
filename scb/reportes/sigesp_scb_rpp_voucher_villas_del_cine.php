<?PHP
    session_start();   
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//Villas del Cine.
	header("Cache-Control: private",false);
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "opener.document.form1.submit();"	;	
		print "close();";
		print "</script>";		
	}	
	$x_pos=0;//mientras mas grande el numero, mas a la derecha.
	$y_pos=-1;//Mientras mas peque�o el numero, mas alto.
	$ls_directorio="cheque_configurable";
	$ls_archivo="cheque_configurable/medidas.txt";
	$li_medidas=16;
	//-------------------------------------------------------------------------------------------------
	function uf_inicializar_variables($ls_archivo,$ls_contenido,$li_medidas)
	{
		global $valores;
		global $ls_directorio;
		if (!file_exists ($ls_directorio))
		   {
			 $lb_exito=mkdir($ls_directorio,0777);
			 if (!$lb_exito)
			    {
				  print "<script>";
				  print "alert('Error al crear directorio cheque_configurable');";
				  print "close();";
				  print "</script>";
			    }
		   }
		
		if((!file_exists ($ls_archivo)) || (filesize($ls_archivo)==0))
		{	
			if(file_exists ($ls_directorio))
			{
				$archivo = fopen($ls_archivo, "w");			
				fwrite($archivo,$ls_contenido);
				fclose($archivo);
			}
		}
			
		if((file_exists($ls_archivo)) && (filesize($ls_archivo)>0))
		{
			$archivo = fopen($ls_archivo, "r");
			$contenido = fread($archivo, filesize($ls_archivo));			
			fclose($archivo);			
			$valores = explode("-",$contenido);	
			if(count($valores)<>$li_medidas)
			{
				$archivo = fopen($ls_archivo, "w");
				fclose($archivo);			
				print "<script>";
				print "alert('Ocurrio un error, por favor cargue de nuevo el cheque (Las medidas seran inicializadas por fallo de lectura y escritura)');";
				print "close();";
				print "</script>";
			}
		}
		else
		{
			print "<script>";
			print "alert('Ocurrio un error, por favor cargue de nuevo el cheque (Las medidas seran inicializadas por fallo de lectura y escritura)');";
			print "close();";
			print "</script>";
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($ldec_monto,$ls_nomproben,$ls_monto,$ls_fecha,&$io_pdf,$x)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		    Acess: private 
		//	    Arguments: ldec_monto : Monto del cheque
		//	    		   ls_nomproben:  Nombre del proveedor o beneficiario
		//	    		   ls_monto : Monto en letras
		//	    		   ls_fecha : Fecha del cheque
		//				   io_pdf   : Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Nelson Barraez
		// Fecha Creaci�n: 25/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $valores;
		//Imprimo el monto
		$io_pdf->add_texto($valores[0],$valores[1],10,"<b>***".$ldec_monto."***</b>");
		//Beneficiario del Cheque
		$io_pdf->add_texto($valores[2],$valores[3],9,"<b>$ls_nomproben</b>");
		//Monto en letras del Cheque
		//Cortando el monto en caso de que sea muy largo		
		$ls_monto_cortado=wordwrap($ls_monto,70,"?");
		$la_arreglo=array();
		$la_arreglo=explode("?",$ls_monto_cortado);
		if(array_key_exists(0,$la_arreglo))
			$io_pdf->add_texto($valores[4],$valores[5],9,"<b>$la_arreglo[0]</b>");
		if(array_key_exists(1,$la_arreglo))
			$io_pdf->add_texto($valores[6],$valores[7],9,"<b>$la_arreglo[1]</b>");
		$ls_anio=substr($ls_fecha,-4);
		$ls_fecha_corta=substr($ls_fecha,0,(strlen($ls_fecha)-5));	
		//Fecha del Cheque
		$io_pdf->add_texto($valores[8],$valores[9],9,"<b>$ls_fecha_corta</b>");
		$io_pdf->add_texto($valores[10],$valores[11],9,"<b>$ls_anio</b>");	
		//No Endosable
		$io_pdf->add_texto($valores[12],$valores[13],9,"NO ENDOSABLE");
		//Informacion de Caducidad
		$io_pdf->add_texto($valores[14],$valores[15],9,"CADUCA A LOS 90 DIAS");	
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_cabecera($la_title,$ls_numdoc,$ls_nomban,$ls_ctaban,$ls_chevau,$ls_nomproben,$ls_solicitudes,$ls_conmov,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_cabecera
		//		   Access: private 
		//	    Arguments: ls_numdoc : Numero de documento
		//	    		   ls_nomban : Nombre del banco
		//				   ls_cbtan  : Cuenta del banco
		//				   ls_chevau : Voucher del cheuqe
		//				   ls_nomproben: Nombre del proveedor o beneficiario
		//				   ls_solicitudes: Solicitudes canceladas con el cheque					  
		//	    		   io_pdf // total de registros que va a tener el reporte
		//    Description: funci�n que imprime los datos basicos del cheque
		//	   Creado Por: Ing. Nelson Barraez
		// Fecha Creaci�n: 24/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$li_pos=185;
		$io_pdf->convertir_valor_mm_px($li_pos);		
		$io_pdf->ezSetY($li_pos);
		$la_data=array(array('banco'=>'<b>Banco</b>  ','cheque'=>'<b>Cheque N�</b>  ','cuenta'=>'<b>Cuenta N�:</b>  ','voucher'=>'<b>Voucher N�:</b>  '),
						array('banco'=>$ls_nomban,'cheque'=>$ls_numdoc,'cuenta'=>$ls_ctaban,'voucher'=>$ls_chevau));
		$la_columna=array('banco'=>'','cheque'=>'','cuenta'=>'','voucher'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>580, // Ancho de la tabla
						 'maxWidth'=>580,
						 'cols'=>array('banco'=>array('justification'=>'left','width'=>160),'cheque'=>array('justification'=>'left','width'=>100),
						 'cuenta'=>array('justification'=>'left','width'=>160),'voucher'=>array('justification'=>'left','width'=>160))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		$la_data=array(array('ordenes'=>'<b>Orden(es) de Pago(s):</b> '.$ls_solicitudes),
					   array('ordenes'=>'<b>Beneficiario:</b> '.$ls_nomproben),
					   array('ordenes'=>'<b>Concepto:</b> '.$ls_conmov));
		$la_columna=array('ordenes'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>2, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>580, // Ancho de la tabla
						 'maxWidth'=>580,
						 'cols'=>array('ordenes'=>array('justification'=>'left','width'=>580))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
		
		$la_data_title=array($la_title);
		$la_columna=array('title'=>'','title2'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>580, // Ancho de la tabla
						 'maxWidth'=>580,
						 'cols'=>array('title'=>array('justification'=>'center','width'=>350),'title2'=>array('justification'=>'center','width'=>230))); // Ancho M�ximo de la tabla
		$io_pdf->ezTable($la_data_title,$la_columna,'',$la_config);	
		
		$io_pdf->Rectangle(15,60,570,70);
		$io_pdf->line(15,73,585,73);		
		$io_pdf->line(15,117,585,117);		
		$io_pdf->line(140,60,140,130);		
		$io_pdf->line(280,60,280,130);		
		$io_pdf->line(430,60,430,130);		
		$io_pdf->addText(53,121,7,"ELABORADO"); // Agregar el t�tulo
		$io_pdf->addText(55,64,7,"TESORERIA"); // Agregar el t�tulo
		$io_pdf->addText(185,121,7,"VERIFICADO"); // Agregar el t�tulo
		$io_pdf->addText(180,64,7,"CONTABILIDAD"); // Agregar el t�tulo
		$io_pdf->addText(325,121,7,"REVISADO POR"); // Agregar el t�tulo
		$io_pdf->addText(315,64,7,"COORD. DE FINANZAS"); // Agregar el t�tulo
		$io_pdf->addText(480,121,7,"APROBADO POR"); // Agregar el t�tulo
		$io_pdf->addText(445,64,7,"GTE. ADMINISTRACI�N Y FINANZAS"); // Agregar el t�tulo
	}// end function uf_print_cabecera
	//--------------------------------------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_detalle($la_data,&$io_pdf,$x_pos)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_detalle
		//		    Acess: private 
		//	    Arguments: la_data // arreglo de informaci�n
		//	   			   io_pdf // Objeto PDF
		//    Description: funci�n que imprime el detalle
		//	   Creado Por: Ing. Nelson Barraez
		// Fecha Creaci�n: 24/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//Imprimo los detalles tanto `de presupuesto como contablwe del movimiento
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 12,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>580, // Ancho de la tabla
						 'maxWidth'=>580, // Ancho M�ximo de la tabla
						 'colGap'=>1, // Separaci�n entre el Texto y los bordes de la celdas.
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('estpro'=>array('justification'=>'center','width'=>195),
			 						   'spg_cuenta'=>array('justification'=>'center','width'=>80),
									   'monto_spg'=>array('justification'=>'right','width'=>75),
						 			   'scg_cuenta'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'debe'=>array('justification'=>'right','width'=>75), // Justificaci�n y ancho de la columna
						 			   'haber'=>array('justification'=>'right','width'=>75))); // Justificaci�n y ancho de la columna
		$la_columnas=array('estpro'=>'<b>Program�tica</b>',
						   'spg_cuenta'=>'<b>Cuenta</b>',
						   'monto_spg'=>'<b>Monto</b>',
						   'scg_cuenta'=>'<b>Cuenta</b>',
						   'debe'=>'<b>Debe</b>',
						   'haber'=>'<b>Haber</b>');
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		$io_pdf->ezText('                     ',10);//Inserto una linea en blanco
	}// end function uf_print_detalle
	//--------------------------------------------------------------------------------------------------------------------------------
	
	function uf_convertir($ls_numero)
	{
		$ls_numero=str_replace(".","",$ls_numero);
		$ls_numero=str_replace(",",".",$ls_numero);
		return $ls_numero;
	}
	//--------------------------------------------------------------------------------------------------------------------------------
	require_once('../../shared/class_folder/class_pdf.php');
	require_once("../../shared/class_folder/class_funciones.php");
	require_once("../../shared/class_folder/sigesp_include.php");
	require_once("../../shared/class_folder/class_datastore.php");
	require_once("../../shared/class_folder/class_sql.php");
	$in=new sigesp_include();
	$con=$in->uf_conectar();
	$io_sql=new class_sql($con);	
	require_once("sigesp_scb_report.php");
	$class_report=new sigesp_scb_report($con);
	$io_funciones=new class_funciones();				
	$ds_voucher=new class_datastore();	
	$ds_dt_scg=new class_datastore();				
	$ds_dt_spg=new class_datastore();
	//Instancio a la clase de conversi�n de numeros a letras.
	require_once("../../shared/class_folder/cnumero_letra.php");
	$numalet= new cnumero_letra();
	
	$ls_tipimp = "";
	if (array_key_exists("tipimp",$_GET))
	{
		$ls_tipimp = $_GET["tipimp"];
	}	

	if ($ls_tipimp=='lote')
	{
		$ls_codemp		=$_SESSION["la_empresa"]["codemp"];
		$ls_codban      = $_GET["codban"];
		$ls_ctaban      = $_GET["ctaban"];
		$ls_documentos  = $_GET["documentos"];
		$ls_fechas      = $_GET["fechas"];
		$ld_fecdes      = $_GET["fecdesde"];
		$ld_fechas      = $_GET["fechasta"];
		$ls_operaciones = $_GET["operaciones"];
			
		//Descompongo la cadena de documentos en un arreglo tomando como separaci�n el ','
		$arr_documentos = split(",",$ls_documentos);
		$li_totdoc		= count($arr_documentos);
		//Descompongo la cadena de fechas en un arreglo tomando como separaci�n el '-'
		$arr_fecmov = split("-",$ls_fechas);
		$li_totfec  = count($arr_fecmov);
	   //Descompongo la cadena de operaciones en un arreglo tomando como separaci�n el '-'
		$arr_operaciones = split("-",$ls_operaciones);
		$li_totdoc	= count($arr_operaciones);		
		$class_report->uf_buscar_cheques_vouchers($arr_documentos,$arr_fecmov,$arr_operaciones,$ls_codban,$ls_ctaban);
		
		$li_total   = $class_report->ds_voucher1->getRowCount("numdoc");

		if ($li_total>0)
		{	
				error_reporting(E_ALL);
				set_time_limit(1800);
				$io_pdf=new class_pdf('LETTER','portrait'); // Instancia de la clase PDF
				$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra	
				$io_pdf->set_margenes(0,0,$x_pos,0);
				$io_pdf->ezStartPageNumbers(560,45,8,'','',1); // Insertar el n�mero de p�gina
		
			for ($i=1;$i<=$li_total;$i++)
			{
				$ls_numdoc=$class_report->ds_voucher1->getValue("numdoc",$i);
				
				$ls_chevau=$class_report->ds_voucher1->getValue("chevau",$i);
				$ls_codope='CH';
				
				$data=$class_report->uf_cargar_chq_voucher($ls_numdoc,$ls_chevau,$ls_codban,$ls_ctaban,$ls_codope);
				$class_report->SQL->begin_transaction();
				$lb_valido=$class_report->uf_actualizar_status_impreso($ls_numdoc,$ls_chevau,$ls_codban,$ls_ctaban,$ls_codope);
				if(!$lb_valido)
				{
					print "Error al actualizar";
					$class_report->is_msg_error;	
					$class_report->SQL->rollback();
				}
				else
				{
					$class_report->SQL->commit();
				}
				$ds_voucher->data=$data;
			
				if (trim($ls_codban)=="001")//Banco Venezuela.
				   {
					 $ls_archivo="cheque_configurable/medidas_venezuela.txt";
					 $ls_contenido="144.00-0.00-24.00-20.00-26.00-30.00-27.00-33.00-22.00-38.00-79.00-38.00-120.00-60.00-130.00-65.00-10.00-91.00-8.00-100.00-12.00-117.00";
					 $li_medidas=22;
					 $lb_concepto=true;
				   } 
				elseif(trim($ls_codban)=="002")//Banfoandes.
				   {
					 $ls_archivo="cheque_configurable/medidas_banfoandes.txt";
					 $ls_contenido="167.00-132.00-65.00-148.00-65.00-154.00-65.00-157.00-65.00-168.00-80.00-168.00-1000.00-1000.00-1000.00-1000.00";
					 $li_medidas=16;
					 $lb_concepto=false;
				   }
				uf_inicializar_variables($ls_archivo,$ls_contenido,$li_medidas);
				$li_totrow=$ds_voucher->getRowCount("numdoc");
				$io_pdf->transaction('start'); // Iniciamos la transacci�n
				$thisPageNum=$io_pdf->ezPageCount;
				for($li_i=1;$li_i<=$li_totrow;$li_i++)
				{
					unset($la_data);
					$li_totprenom = 0;
					$ldec_mondeb  = 0;
					$ldec_monhab  = 0;
					$li_totant    = 0;
					$ls_numdoc		= trim($ds_voucher->data["numdoc"][$li_i]);
					$ls_codban		= trim($ds_voucher->data["codban"][$li_i]);
					$ls_nomban		= $class_report->uf_select_data($io_sql,"SELECT * FROM scb_banco WHERE codban ='".$ls_codban."' AND codemp='".$ls_codemp."'","nomban");
					$ls_ctaban		= trim($ds_voucher->data["ctaban"][$li_i]);
					$ls_chevau		= trim($ds_voucher->data["chevau"][$li_i]);
					$ld_fecmov		= $io_funciones->uf_convertirfecmostrar($ds_voucher->data["fecmov"][$li_i]);
					$ls_nomproben	= $ds_voucher->data["nomproben"][$li_i];
					$ls_solicitudes = $class_report->uf_select_solicitudes($ls_numdoc,$ls_codban,$ls_ctaban);
					$ls_conmov      = $ds_voucher->getValue("conmov",$li_i);
					$ldec_monret    = $ds_voucher->getValue("monret",$li_i);
					$ldec_monto     = $ds_voucher->getValue("monto",$li_i);
					$ldec_total     = $ldec_monto-$ldec_monret;
					$ls_monto       = $numalet->uf_convertir_letra($ldec_total,'','');
					$io_encabezado  = $io_pdf->openObject();
					
					uf_print_encabezado_pagina(number_format($ldec_total,2,",","."),$ls_nomproben,$ls_monto,$_SESSION["la_empresa"]["ciuemp"].", ".$ld_fecmov,$io_pdf,$y_pos); // Imprimimos el encabezado de la p�gina
					
					uf_print_cabecera(array('title'=>'Detalle Presupuestario Pago','title2'=>'Detalle Contable Pago'),$ls_numdoc,$ls_nomban,$ls_ctaban,$ls_chevau,$ls_nomproben,$ls_solicitudes,$ls_conmov,$io_pdf); // Imprimimos la cabecera del registro
					$io_pdf->closeObject();
					$io_pdf->addObject($io_encabezado,'all');
					$ds_dt_scg->data=$class_report->uf_cargar_dt_scg($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope); // Obtenemos el detalle del reporte
					$ds_dt_spg->data=$class_report->uf_cargar_dt_spg($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope);
					$la_campos=array("scg_cuenta");
					$la_monto=array("monto");
					$ds_dt_scg->group_by($la_campos,$la_monto,"scg_cuenta");
					$la_campos=array("spg_cuenta","estpro");
					$ds_dt_spg->group_by($la_campos,$la_monto,"spg_cuenta");
					$li_totrow_det=$ds_dt_scg->getRowCount("scg_cuenta");
					$li_totrow_spg=$ds_dt_spg->getRowCount("spg_cuenta");
					///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// Hago un ciclo para unir en una sola matriz los detalles de presupuesto y los contables para proceder luego a pintarlos
					if($li_totrow_det>=$li_totrow_spg)
					{
						for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
						{
							$ls_scg_cuenta = trim($ds_dt_scg->data["scg_cuenta"][$li_s]);
							$ls_debhab     = trim($ds_dt_scg->data["debhab"][$li_s]);
							$ldec_monto    = $ds_dt_scg->data["monto"][$li_s];
							if($ls_debhab=='D')
							{
								$ldec_mondeb=number_format($ldec_monto,2,",",".");
								$ldec_monhab=" ";
							}
							else
							{
								$ldec_monhab=number_format($ldec_monto,2,",",".");
								$ldec_mondeb=" ";
							}
							if(array_key_exists("spg_cuenta",$ds_dt_spg->data))
							{
								if(array_key_exists($li_s,$ds_dt_spg->data["spg_cuenta"]))
								{
									$ls_cuentaspg   = trim($ds_dt_spg->getValue("spg_cuenta",$li_s));	
									$ls_estpro      = trim($ds_dt_spg->getValue("estpro",$li_s));	  
									$ldec_monto_spg = number_format($ds_dt_spg->getValue("monto",$li_s),2,",",".");
								}
								else
								{
									$ls_cuentaspg=" ";	
									$ls_estpro=" ";	  
									$ldec_monto_spg=" ";
								}
							}
							else
							{
								$ls_cuentaspg=" ";	
								$ls_estpro=" ";	  
								$ldec_monto_spg=" ";
							}
							$la_data[$li_s]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
						}
					}
			
					if($li_totrow_spg>$li_totrow_det)
					{
						for($li_s=1;$li_s<=$li_totrow_spg;$li_s++)
						{
							if(array_key_exists("scg_cuenta",$ds_dt_scg->data))
							{
								if(array_key_exists($li_s,$ds_dt_scg->data["scg_cuenta"]))
								{
									$ls_scg_cuenta = trim($ds_dt_scg->data["scg_cuenta"][$li_s]);
									$ls_debhab     = trim($ds_dt_scg->data["debhab"][$li_s]);
									$ldec_monto    = $ds_dt_scg->data["monto"][$li_s];
									if($ls_debhab=='D')
									{
										$ldec_mondeb=number_format($ldec_monto,2,",",".");
										$ldec_monhab=" ";
									}
									else
									{
										$ldec_monhab=number_format($ldec_monto,2,",",".");
										$ldec_mondeb=" ";
									}
								}
								else
								{
									$ls_scg_cuenta="";
									$ls_debhab = "";
									$ldec_monto= "";
									$ldec_mondeb="";
									$ldec_monhab="";					
								}
							}
							else
							{
								$ls_scg_cuenta="";
								$ls_debhab = "";
								$ldec_monto= "";
								$ldec_mondeb="";
								$ldec_monhab="";					
							}
							if(array_key_exists("spg_cuenta",$ds_dt_spg->data))
							{
								if(array_key_exists($li_s,$ds_dt_spg->data["spg_cuenta"]))
								{
									$ls_cuentaspg   = trim($ds_dt_spg->getValue("spg_cuenta",$li_s));	
									$ls_estpro      = trim($ds_dt_spg->getValue("estpro",$li_s));	  
									$ldec_monto_spg = number_format($ds_dt_spg->getValue("monto",$li_s),2,",",".");
								}
								else
								{
									$ls_cuentaspg=" ";	
									$ls_estpro=" ";	  
									$ldec_monto_spg=" ";
								}
							}
							else
							{
								$ls_cuentaspg=" ";	
								$ls_estpro=" ";	  
								$ldec_monto_spg=" ";
							}
							$la_data[$li_s]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
						}
					}
			
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					if(empty($la_data))
					{
						$ls_cuentaspg='';
						$ls_estpro='';
						$ldec_monto_spg='';
						$ls_scg_cuenta='';
						$ldec_mondeb='';
						$ldec_monhab='';
						$la_data[1]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
						$la_data[2]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
						$la_data[3]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
					}
					//codigo para unir las cuentas iguales
					$la_dataaux=array();
					for($li_k=1;$li_k<=count($la_data);$li_k++)
					{
						$lb_existe=false;
						$li_pos=0;
						for($li_l=1;$li_l<=count($la_dataaux);$li_l++)
						{
							if(($la_data[$li_k]["spg_cuenta"]==$la_dataaux[$li_l]["spg_cuenta"])
								&& ($la_data[$li_k]["estpro"]==$la_dataaux[$li_l]["estpro"])
								&& ($la_data[$li_k]["scg_cuenta"]==$la_dataaux[$li_l]["scg_cuenta"]))
							{
								$li_pos=$li_i;
								$lb_existe=true;
							}
						}
						if(!$lb_existe)
						{
							$li_index=count($la_dataaux)+1;
							$la_dataaux[$li_index]=$la_data[$li_k];
						}
						else
						{
							
							$ls_monto_spg1=uf_convertir($la_dataaux[$li_pos]["monto_spg"]);
							$ls_monto_spg2=uf_convertir($la_data[$li_k]["monto_spg"]);
							$ls_monto_debe1=uf_convertir($la_dataaux[$li_pos]["debe"]);
							$ls_monto_debe2=uf_convertir($la_data[$li_k]["debe"]);
							$ls_monto_haber1=uf_convertir($la_dataaux[$li_pos]["haber"]);
							$ls_monto_haber2=uf_convertir($la_data[$li_k]["haber"]);
							$la_dataaux[$li_pos]["monto_spg"] = number_format(($ls_monto_spg1 + $ls_monto_spg2),2,",",".");
							if (($ls_monto_debe1 + $ls_monto_debe2) != 0)
								$la_dataaux[$li_pos]["debe"] = number_format(($ls_monto_debe1 + $ls_monto_debe2),2,",",".");
							else
								$la_dataaux[$li_pos]["debe"]="";
							if(($ls_monto_haber1 + $ls_monto_haber2) != 0)
								$la_dataaux[$li_pos]["haber"] = number_format(($ls_monto_haber1 + $ls_monto_haber2),2,",",".");
							else
								$la_dataaux[$li_pos]["haber"]="";
						}
						
					}
					
					$io_pdf->y=190;
					$io_pdf->y=440;	
					$io_pdf->set_margenes(138,70,$x_pos,0);
					uf_print_detalle($la_dataaux,$io_pdf,$x_pos); // Imprimimos el detalle 	
				} // Fin del for 2
			
				if ($i<$li_total)
				{			
					$io_pdf->ezNewPage(); // Insertar una nueva p�gina
				}
		
			}// Fin del for 1
			$io_pdf->ezStopPageNumbers(1,1);
			$io_pdf->ezStream();
			unset($io_pdf,$class_report,$io_funciones,$ds_dt_spg,$ds_dt_scg,$ds_voucher,$la_data);
		}//Fin del if ($li_total>0)
		else
		{
			 print("<script language=JavaScript>");
			 print(" alert('No hay nada que Reportar');"); 
			 print(" close();");
			 print("</script>");	  
		} 
		
	} // Fin de si es lote
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SI NO ES POR LOTE ENTONCES
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else 
	{

		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_codban=$_GET["codban"];
		$ls_ctaban=$_GET["ctaban"];
		$ls_numdoc=$_GET["numdoc"];
		$ls_chevau=$_GET["chevau"];
		$ls_codope=$_GET["codope"];				
	
		$data=$class_report->uf_cargar_chq_voucher($ls_numdoc,$ls_chevau,$ls_codban,$ls_ctaban,$ls_codope);
		$class_report->SQL->begin_transaction();
		$lb_valido=$class_report->uf_actualizar_status_impreso($ls_numdoc,$ls_chevau,$ls_codban,$ls_ctaban,$ls_codope);
		if(!$lb_valido)
		{
			print "Error al actualizar";
			$class_report->is_msg_error;	
			$class_report->SQL->rollback();
		}
		else
		{
			$class_report->SQL->commit();
		}
		$ds_voucher->data=$data;
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new class_pdf('LETTER','portrait'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra	
		$io_pdf->set_margenes(0,0,$x_pos,0);
		if (trim($ls_codban)=="001")//Banco Venezuela.
		   {
			 $ls_archivo="cheque_configurable/medidas_venezuela.txt";
			 $ls_contenido="144.00-0.00-24.00-20.00-26.00-30.00-27.00-33.00-22.00-38.00-79.00-38.00-120.00-60.00-130.00-65.00-10.00-91.00-8.00-100.00-12.00-117.00";
			 $li_medidas=22;
			 $lb_concepto=true;
		   } 
		elseif(trim($ls_codban)=="002")//Banfoandes.
		   {
			 $ls_archivo="cheque_configurable/medidas_banfoandes.txt";
			 $ls_contenido="167.00-132.00-65.00-148.00-65.00-154.00-65.00-157.00-65.00-168.00-80.00-168.00-1000.00-1000.00-1000.00-1000.00";
			 $li_medidas=16;
			 $lb_concepto=false;
		   }
		uf_inicializar_variables($ls_archivo,$ls_contenido,$li_medidas);
		$li_totrow=$ds_voucher->getRowCount("numdoc");
		$io_pdf->transaction('start'); // Iniciamos la transacci�n
		$thisPageNum=$io_pdf->ezPageCount;
		for($li_i=1;$li_i<=$li_totrow;$li_i++)
		{
			unset($la_data);
			$li_totprenom = 0;
			$ldec_mondeb  = 0;
			$ldec_monhab  = 0;
			$li_totant    = 0;
			$ls_numdoc		= trim($ds_voucher->data["numdoc"][$li_i]);
			$ls_codban		= trim($ds_voucher->data["codban"][$li_i]);
			$ls_nomban		= $class_report->uf_select_data($io_sql,"SELECT * FROM scb_banco WHERE codban ='".$ls_codban."' AND codemp='".$ls_codemp."'","nomban");
			$ls_ctaban		= trim($ds_voucher->data["ctaban"][$li_i]);
			$ls_chevau		= trim($ds_voucher->data["chevau"][$li_i]);
			$ld_fecmov		= $io_funciones->uf_convertirfecmostrar($ds_voucher->data["fecmov"][$li_i]);
			$ls_nomproben	= $ds_voucher->data["nomproben"][$li_i];
			$ls_solicitudes = $class_report->uf_select_solicitudes($ls_numdoc,$ls_codban,$ls_ctaban);
			$ls_conmov      = $ds_voucher->getValue("conmov",$li_i);
			$ldec_monret    = $ds_voucher->getValue("monret",$li_i);
			$ldec_monto     = $ds_voucher->getValue("monto",$li_i);
			$ldec_total     = $ldec_monto-$ldec_monret;
			$ls_monto       = $numalet->uf_convertir_letra($ldec_total,'','');
			$io_encabezado  = $io_pdf->openObject();
			
			uf_print_encabezado_pagina(number_format($ldec_total,2,",","."),$ls_nomproben,$ls_monto,$_SESSION["la_empresa"]["ciuemp"].", ".$ld_fecmov,$io_pdf,$y_pos); // Imprimimos el encabezado de la p�gina
			$io_pdf->ezStartPageNumbers(560,45,8,'','',1); // Insertar el n�mero de p�gina
			uf_print_cabecera(array('title'=>'Detalle Presupuestario Pago','title2'=>'Detalle Contable Pago'),$ls_numdoc,$ls_nomban,$ls_ctaban,$ls_chevau,$ls_nomproben,$ls_solicitudes,$ls_conmov,$io_pdf); // Imprimimos la cabecera del registro
			$io_pdf->closeObject();
			$io_pdf->addObject($io_encabezado,'all');
			$ds_dt_scg->data=$class_report->uf_cargar_dt_scg($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope); // Obtenemos el detalle del reporte
			$ds_dt_spg->data=$class_report->uf_cargar_dt_spg($ls_numdoc,$ls_codban,$ls_ctaban,$ls_codope);
			$la_campos=array("scg_cuenta");
			$la_monto=array("monto");
			$ds_dt_scg->group_by($la_campos,$la_monto,"scg_cuenta");
			$la_campos=array("spg_cuenta","estpro");
			$ds_dt_spg->group_by($la_campos,$la_monto,"spg_cuenta");
			$li_totrow_det=$ds_dt_scg->getRowCount("scg_cuenta");
			$li_totrow_spg=$ds_dt_spg->getRowCount("spg_cuenta");
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// Hago un ciclo para unir en una sola matriz los detalles de presupuesto y los contables para proceder luego a pintarlos
			if($li_totrow_det>=$li_totrow_spg)
			{
				for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
				{
					$ls_scg_cuenta = trim($ds_dt_scg->data["scg_cuenta"][$li_s]);
					$ls_debhab     = trim($ds_dt_scg->data["debhab"][$li_s]);
					$ldec_monto    = $ds_dt_scg->data["monto"][$li_s];
					if($ls_debhab=='D')
					{
						$ldec_mondeb=number_format($ldec_monto,2,",",".");
						$ldec_monhab=" ";
					}
					else
					{
						$ldec_monhab=number_format($ldec_monto,2,",",".");
						$ldec_mondeb=" ";
					}
					if(array_key_exists("spg_cuenta",$ds_dt_spg->data))
					{
						if(array_key_exists($li_s,$ds_dt_spg->data["spg_cuenta"]))
						{
							$ls_cuentaspg   = trim($ds_dt_spg->getValue("spg_cuenta",$li_s));	
							$ls_estpro      = trim($ds_dt_spg->getValue("estpro",$li_s));	  
							$ldec_monto_spg = number_format($ds_dt_spg->getValue("monto",$li_s),2,",",".");
						}
						else
						{
							$ls_cuentaspg=" ";	
							$ls_estpro=" ";	  
							$ldec_monto_spg=" ";
						}
					}
					else
					{
						$ls_cuentaspg=" ";	
						$ls_estpro=" ";	  
						$ldec_monto_spg=" ";
					}
					$la_data[$li_s]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
				}
			}
	
			if($li_totrow_spg>$li_totrow_det)
			{
				for($li_s=1;$li_s<=$li_totrow_spg;$li_s++)
				{
					if(array_key_exists("scg_cuenta",$ds_dt_scg->data))
					{
						if(array_key_exists($li_s,$ds_dt_scg->data["scg_cuenta"]))
						{
							$ls_scg_cuenta = trim($ds_dt_scg->data["scg_cuenta"][$li_s]);
							$ls_debhab     = trim($ds_dt_scg->data["debhab"][$li_s]);
							$ldec_monto    = $ds_dt_scg->data["monto"][$li_s];
							if($ls_debhab=='D')
							{
								$ldec_mondeb=number_format($ldec_monto,2,",",".");
								$ldec_monhab=" ";
							}
							else
							{
								$ldec_monhab=number_format($ldec_monto,2,",",".");
								$ldec_mondeb=" ";
							}
						}
						else
						{
							$ls_scg_cuenta="";
							$ls_debhab = "";
							$ldec_monto= "";
							$ldec_mondeb="";
							$ldec_monhab="";					
						}
					}
					else
					{
						$ls_scg_cuenta="";
						$ls_debhab = "";
						$ldec_monto= "";
						$ldec_mondeb="";
						$ldec_monhab="";					
					}
					if(array_key_exists("spg_cuenta",$ds_dt_spg->data))
					{
						if(array_key_exists($li_s,$ds_dt_spg->data["spg_cuenta"]))
						{
							$ls_cuentaspg   = trim($ds_dt_spg->getValue("spg_cuenta",$li_s));	
							$ls_estpro      = trim($ds_dt_spg->getValue("estpro",$li_s));	  
							$ldec_monto_spg = number_format($ds_dt_spg->getValue("monto",$li_s),2,",",".");
						}
						else
						{
							$ls_cuentaspg=" ";	
							$ls_estpro=" ";	  
							$ldec_monto_spg=" ";
						}
					}
					else
					{
						$ls_cuentaspg=" ";	
						$ls_estpro=" ";	  
						$ldec_monto_spg=" ";
					}
					$la_data[$li_s]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
				}
			}
	
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if(empty($la_data))
			{
				$ls_cuentaspg='';
				$ls_estpro='';
				$ldec_monto_spg='';
				$ls_scg_cuenta='';
				$ldec_mondeb='';
				$ldec_monhab='';
				$la_data[1]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
				$la_data[2]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
				$la_data[3]=array('spg_cuenta'=>$ls_cuentaspg,'estpro'=>$ls_estpro,'monto_spg'=>$ldec_monto_spg,'scg_cuenta'=>$ls_scg_cuenta,'debe'=>$ldec_mondeb,'haber'=>$ldec_monhab);
			}
			//codigo para unir las cuentas iguales
			$la_dataaux=array();
			for($li_k=1;$li_k<=count($la_data);$li_k++)
			{
				$lb_existe=false;
				$li_pos=0;
				for($li_l=1;$li_l<=count($la_dataaux);$li_l++)
				{
					if(($la_data[$li_k]["spg_cuenta"]==$la_dataaux[$li_l]["spg_cuenta"])
						&& ($la_data[$li_k]["estpro"]==$la_dataaux[$li_l]["estpro"])
						&& ($la_data[$li_k]["scg_cuenta"]==$la_dataaux[$li_l]["scg_cuenta"]))
					{
						$li_pos=$li_i;
						$lb_existe=true;
					}
				}
				if(!$lb_existe)
				{
					$li_index=count($la_dataaux)+1;
					$la_dataaux[$li_index]=$la_data[$li_k];
				}
				else
				{
					
					$ls_monto_spg1=uf_convertir($la_dataaux[$li_pos]["monto_spg"]);
					$ls_monto_spg2=uf_convertir($la_data[$li_k]["monto_spg"]);
					$ls_monto_debe1=uf_convertir($la_dataaux[$li_pos]["debe"]);
					$ls_monto_debe2=uf_convertir($la_data[$li_k]["debe"]);
					$ls_monto_haber1=uf_convertir($la_dataaux[$li_pos]["haber"]);
					$ls_monto_haber2=uf_convertir($la_data[$li_k]["haber"]);
					$la_dataaux[$li_pos]["monto_spg"] = number_format(($ls_monto_spg1 + $ls_monto_spg2),2,",",".");
					if (($ls_monto_debe1 + $ls_monto_debe2) != 0)
						$la_dataaux[$li_pos]["debe"] = number_format(($ls_monto_debe1 + $ls_monto_debe2),2,",",".");
					else
						$la_dataaux[$li_pos]["debe"]="";
					if(($ls_monto_haber1 + $ls_monto_haber2) != 0)
						$la_dataaux[$li_pos]["haber"] = number_format(($ls_monto_haber1 + $ls_monto_haber2),2,",",".");
					else
						$la_dataaux[$li_pos]["haber"]="";
				}
				
			}
			
			$io_pdf->y=190;
			$io_pdf->y=440;	
			$io_pdf->set_margenes(138,70,$x_pos,0);
			uf_print_detalle($la_dataaux,$io_pdf,$x_pos); // Imprimimos el detalle 	
		}
		$io_pdf->ezStopPageNumbers(1,1);
		$io_pdf->ezStream();
		unset($io_pdf);
		unset($class_report);
		unset($io_funciones);
		
	}
?> 