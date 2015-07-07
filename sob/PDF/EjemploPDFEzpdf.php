<?Php
//--------------------------------------------------------------------------------------------------------------------------------
	function uf_print_encabezado_pagina($as_titulo,$as_periodo,&$io_pdf)
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
		
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->line(20,40,578,40);
		$io_pdf->addJpegFromFile('cabecera_minfra.jpg',30,700,130); // Agregar Logo
		$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,730,11,$as_titulo); // Agregar el t�tulo
		$li_tm=$io_pdf->getTextWidth(11,$as_periodo);
		$tm=306-($li_tm/2);
		$io_pdf->addText($tm,718,11,$as_periodo); // Agregar el t�tulo
		$io_pdf->addText(500,730,10,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->restoreState();
		$io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');		
	}// end function uf_print_encabezadopagina
	
	require_once("../../shared/ezpdf/class.ezpdf.php");
	//require_once("../shared/class_folder/class_funciones.php");
	//$io_funciones=new class_funciones();				
	//require_once("../shared/class_folder/class_datastore.php");
	//$ds_edocta=new class_datastore();
	$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
	$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
	$io_pdf->ezSetCmMargins(3.5,3.5,3.5,3.5); // Configuraci�n de los margenes en cent�metros
	uf_print_encabezado_pagina("Estado de Cuenta","Del 1/1/2006 al 1/2/2006",$io_pdf); // Imprimimos el encabezado de la p�gina
	$io_pdf->ezStartPageNumbers(550,50,10,'','',1); // Insertar el n�mero de p�gina
	 
	/*if ($io_pdf->ezPageCount==$thisPageNum)
	{// Hacemos el commit de los registros que se desean imprimir*/
		$io_pdf->transaction('commit');
	/*}
	else
	{// Hacemos un rollback de los registros, agregamos una nueva p�gina y volvemos a imprimir
		$io_pdf->transaction('rewind');
		$io_pdf->ezNewPage();
		uf_print_cabecera($ls_numdoc,$ls_codban,$ls_ctaban,$ls_chevau,$io_pdf); // Imprimimos la cabecera del registro
		uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle 
		uf_print_autorizacion($io_pdf);
	}*/
	$io_pdf->ezStopPageNumbers(1,1);
	$io_pdf->ezStream();
	unset($io_pdf);
	
	unset($io_funciones);
?>