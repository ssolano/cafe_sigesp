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
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezadopagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 21/04/2006 
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(20,40,578,40);
		$io_pdf->setStrokeColor(0,0,0);
		$io_pdf->rectangle(185,710,370,40);
		$io_pdf->line(400,750,400,710);
		$io_pdf->line(400,730,555,730);
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],30,715,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$io_pdf->addText(225,725,11,$as_titulo); // Agregar el t�tulo
		$io_pdf->addText(430,735,10,"Fecha: ".date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(430,715,10,"Hora: ".date("h:i a")); // Agregar la hora
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina
	//--------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------
function uf_print_cabecera_detalle(&$io_pdf)
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Function: uf_print_cabecera_detalle
//		   Access: private 
//	    Arguments: la_data // arreglo de informaci�n
//	   			   io_pdf // Objeto PDF
//    Description: funci�n que imprime el detalle
//	   Creado Por: Ing. Yesenia Moreno
// Fecha Creaci�n: 21/04/2006 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$io_encabezado=$io_pdf->openObject();
	$io_pdf->saveState();
	$io_pdf->ezSetY(700);
	$la_data   =array(array('codigo'=>'<b>C�digo</b>','nombre'=>'<b>Nombre</b>','rif'=>'<b>RIF</b>','nit'=>'<b>NIT</b>','telefono'=>'<b>Tel�fono</b>'));
	$la_columna=array('codigo'=>'','nombre'=>'','rif'=>'','nit'=>'','telefono'=>'');
	$la_config=array('showHeadings'=>0, // Mostrar encabezados
					 'titleFontSize' =>10,  // Tama�o de Letras de los t�tulos
					 'showLines'=>1, // Mostrar L�neas
					 'shaded'=>0,
					 'shadeCol2'=>array(0.86,0.86,0.86),
					 'colGap'=>1,
					 'width'=>520, // Ancho de la tabla
					 'maxWidth'=>520, // Ancho M�ximo de la tabla
					 'xPos'=>296, // Orientaci�n de la tabla
					 'cols'=>array('codigo'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
					 			   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
					 			   'rif'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
					 			   'nit'=>array('justification'=>'center','width'=>85), // Justificaci�n y ancho de la columna
					 			   'telefono'=>array('justification'=>'center','width'=>80)));								   
	$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	$io_pdf->restoreState();
	$io_pdf->closeObject();
	$io_pdf->addObject($io_encabezado,'all');
}// end function uf_print_cabecera_detalle
//------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------
function uf_print_detalle($la_data,&$io_pdf)
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Function: uf_print_detalle
//		   Access: private 
//	    Arguments: la_data // arreglo de informaci�n
//	   			   io_pdf // Objeto PDF
//    Description: funci�n que imprime el detalle
//	   Creado Por: Ing. Yesenia Moreno
// Fecha Creaci�n: 21/04/2006 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$la_columna=array('codigo'=>'<b>C�digo</b>','nombre'=>'<b>Nombre</b>','rif'=>'<b>Rif</b>','nit'=>'<b>Nit</b>','telefono'=>'<b>Tel�fono</b>');
	$la_config=array('showHeadings'=>0, // Mostrar encabezados
					 'fontSize' => 9, // Tama�o de Letras
					 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
					 'showLines'=>0, // Mostrar L�neas
					 'shaded'=>0, // Sombra entre l�neas
					 'shadeCol'=>array(0.8,0.8,0.8),
					 'shadeCol2'=>array(0.9,0.9,0.9),
					 'width'=>520, // Ancho de la tabla
					 'maxWidth'=>520, // Ancho M�ximo de la tabla
					 'xPos'=>300, // Orientaci�n de la tabla
					 'cols'=>array('codigo'=>array('justification'=>'center','width'=>70), // Justificaci�n y ancho de la columna
								   'nombre'=>array('justification'=>'left','width'=>200), // Justificaci�n y ancho de la columna
								   'rif'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
								   'nit'=>array('justification'=>'right','width'=>85), // Justificaci�n y ancho de la columna
								   'telefono'=>array('justification'=>'right','width'=>80))); // Justificaci�n y ancho de la columna
	$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
}// end function uf_print_detalle
//--------------------------------------------------------------------------------------------------------------------------------
	
	//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("../../shared/class_folder/sigesp_include.php");
	$io_in=new sigesp_include();
	$con=$io_in->uf_conectar();
	
	require_once("sigesp_rpc_class_report.php");
	$io_report = new sigesp_rpc_class_report($con);
	
	require_once("../../shared/class_folder/class_sql.php");
	$io_sql = new class_sql($con);
	
	//----------------------------------------------------  Par�metros del encabezado  -----------------------------------------------
	$ls_titulo="<b>Listado de Proveedores</b>";
	//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------
	$ls_codemp=$_SESSION["la_empresa"]["codemp"];
	if (array_key_exists("hidtipo",$_POST))
	   {
		 $ls_tipo=$_POST["hidtipo"];
	   }
	else
	   {
		 $ls_tipo=$_GET["hidtipo"];
	   }
	if (array_key_exists("hidorden",$_POST))
	   {
		 $li_orden=$_POST["hidorden"];
	   }
	else
	   {
		 $li_orden=$_GET["hidorden"];
	   }
	if (array_key_exists("hidcodprov1",$_POST))
	   {
		 $ls_codprov1=$_POST["hidcodprov1"];
	   }
	else
	   {
		 $ls_codprov1=$_GET["hidcodprov1"];
	   }
	if (array_key_exists("hidcodprov2",$_POST))
	   {
		 $ls_codprov2=$_POST["hidcodprov2"];
	   }
	else
	   {
		 $ls_codprov2=$_GET["hidcodprov2"];
	   }
	if (array_key_exists("hidcodesp",$_POST))
	   {
		 $ls_codesp=$_POST["hidcodesp"];
	   }
	else
	   {
		 $ls_codesp=$_GET["hidcodesp"];
	   }
	$lb_valido=true;
	$rs_proveedor=$io_report->uf_load_proveedores($ls_codemp,$li_orden,$ls_tipo,$ls_codprov1,$ls_codprov2,$ls_codesp,$lb_valido);
	if ($lb_valido)
    {
		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(3.8,3,3,3); // Configuraci�n de los margenes en cent�metros
		uf_print_encabezado_pagina($ls_titulo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
		$li_total=$io_sql->num_rows($rs_proveedor);
		$data=$io_sql->obtener_datos($rs_proveedor);
		for ($z=1;$z<=$li_total;$z++)
		{//1
		  $ls_codpro=$data["cod_pro"][$z];
		  $ls_nompro=$data["nompro"][$z];
		  $ls_rifpro=$data["rifpro"][$z];
		  $ls_nitpro=$data["nitpro"][$z];
		  $ls_telpro=$data["telpro"][$z];
  		  $la_data[$z]=array('codigo'=>$ls_codpro,'nombre'=>$ls_nompro,'rif'=>$ls_rifpro,'nit'=>$ls_nitpro,'telefono'=>$ls_telpro);
		}//1
		uf_print_cabecera_detalle($io_pdf);
		uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
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
	else
	 {
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');"); 
		print(" close();");
		print("</script>");
	 }
?> 