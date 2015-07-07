<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    REPORTE: Historial de Personal
//  ORGANISMO: 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-----------------------------------------------------------------------------------------------------------------------------------
///Elaborado por: Ing. Mar�a Beatriz Unda
//-----------------------------------------------------------------------------------------------------------------------------------
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
		//	   Creado Por: Mar�a Beatriz Unda
		// Fecha Creaci�n: 24/09/2008		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		
		$ls_descripcion="Gener� el Reporte ".$as_titulo;
		$lb_valido=$io_fun_nomina->uf_load_seguridad_reporte("SNO","sigesp_sno_r_reporteencargaduria.php",$ls_descripcion);
		return $lb_valido;
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------	
	function uf_print_encabezado_pagina($as_titulo,&$io_pdf)
	    {
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_encabezado_pagina
		//		   Access: private 
		//	    Arguments: as_titulo // T�tulo del Reporte
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime los encabezados por p�gina
		//	   Creado Por: Mar�a Beatriz Unda
		// Fecha Creaci�n: 24/09/2008		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_encabezado=$io_pdf->openObject();
		$io_pdf->saveState();
		$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],25,705,$_SESSION["ls_width"],$_SESSION["ls_height"]); // Agregar Logo
		
		$io_pdf->addText(540,770,6,date("d/m/Y")); // Agregar la Fecha
		$io_pdf->addText(546,764,6,date("h:i a")); // Agregar la Hora
		
		$io_pdf->ezSetY(715);	
		$la_data=array(array('titulo1'=>'<b>'.($as_titulo).'</b>'));					
		$la_columnas=array('titulo1'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 10, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>570, // Ancho de la tabla
						 'maxWidth'=>570, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('titulo1'=>array('justification'=>'center','width'=>570))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$io_pdf->restoreState();
	    $io_pdf->closeObject();
		$io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezado_pagina	

//-------------------------------------------------------------------------------------------------------------------------------
	
	function uf_print_datos_encargaduria($as_codenc,$ad_fecinienc,$ad_fecfinenc,$as_obsenc,$as_estenc,&$io_pdf)

	{
								  
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_datos_personal
		//		   Access: private 
		//	    Arguments: $as_codenc // c�digo de encargaduria
		//                 $ad_fecinienc // fecha de inicio de la encargadur�a
		//                 $ad_fecfinenc // fecha de finalizacion de la encargadur�a
		//                 $as_obsenc // obsercaci�n 
		//                 $as_estenc // estado
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime los datos del personal
		//	   Creado Por: Mar�a Beatriz Unda
		// Fecha Creaci�n: 02/01/2009
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$io_pdf->ezSetY(680);
		
		$la_data[1]=array('name'=>'<b>C�DIGO ENCARGADUR�A</b>',
		                  'name2'=>'<b>ESTADO</b>');	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>250),
						               'name2'=>array('justification'=>'left','width'=>250))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codenc,
		                  'name2'=>$as_estenc);	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>250),
						               'name2'=>array('justification'=>'left','width'=>250))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>FECHA INICIO</b>',
		                  'name2'=>'<b>FECHA FINALIZACI�N</b>');	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>250),
						               'name2'=>array('justification'=>'left','width'=>250))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$ad_fecinienc,
		                  'name2'=>$ad_fecfinenc);	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>250),
						               'name2'=>array('justification'=>'left','width'=>250))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>OBSERVACI�N</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_obsenc);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
	}// end function uf_print_datos_personal

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
function uf_print_datos_personal($as_titulo,$as_codnom,$as_desnom,$as_codper,$as_nomper,$as_codsubnom,
					              $as_dessubnom,$as_codasicar,$as_denasicar,$as_codcar,$as_descar,
						 	      $as_codtab,$as_destab,$as_codgra,$as_codpas,$as_codunirac,
						   		  $as_coduniadm,$as_desuniadm,$as_coddep,$as_dendep,&$io_pdf)
	{
								  
								  
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//       Function: uf_print_datos_personal
		//		   Access: private 
		//	    Arguments: aa_data // Arreglo con la data del historial
		//	    		   io_pdf // Instancia de objeto pdf
		//    Description: Funci�n que imprime los datos del concursante
		//	   Creado Por: Mar�a Beatriz Unda
		// Fecha Creaci�n: 24/09/2008
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$la_data=array(array('titulo1'=>'<b>'.$as_titulo.'</b>'));					
		$la_columnas=array('titulo1'=>'');					
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>0, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>570, // Ancho de la tabla
						 'maxWidth'=>570, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('titulo1'=>array('justification'=>'center','width'=>570))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>C�DIGO PERSONAL</b>',
		                  'name2'=>'<b>NOMBRE</b>');	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>200),
						               'name2'=>array('justification'=>'left','width'=>300))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codper,
		                  'name2'=>$as_nomper);	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>200),
						               'name2'=>array('justification'=>'left','width'=>300))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>N�MINA</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codnom.' - '.$as_desnom);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>SUBN�MINA</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codsubnom.' - '.$as_dessubnom);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>ASIGNACI�N DE CARGO</b>',
		                  'name2'=>'<b>C�DIGO �NICO RAC</b>');	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>380),
									   'name2'=>array('justification'=>'left','width'=>120)));//Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codasicar.' - '.$as_denasicar,
		                  'name2'=>$as_codunirac);	
		$la_columnas=array('name'=>'',
		                   'name2'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>380),
									   'name2'=>array('justification'=>'left','width'=>120)));//Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>TABULADOR</b>',
		                  'name2'=>'<b>GRADO</b>',
						  'name3'=>'<b>PASO</b>');	
		$la_columnas=array('name'=>'',
		                   'name2'=>'',
						   'name3'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>300),
						               'name2'=>array('justification'=>'left','width'=>100),
									   'name2'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codtab.' - '.$as_destab,
		                  'name2'=>$as_codgra,
						  'name3'=>$as_codpas);	
		$la_columnas=array('name'=>'',
		                   'name2'=>'',
						   'name3'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>300),
						               'name2'=>array('justification'=>'left','width'=>100),
									   'name2'=>array('justification'=>'left','width'=>100))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		
		$la_data[1]=array('name'=>'<b>CARGO</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_codcar.' - '.$as_descar);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>UNIDAD ADMINISTRATIVA</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_coduniadm.' - '.$as_desuniadm);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>'<b>DEPARTAMENTO</b>');	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shadeCol'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shadeCol2'=>array((225/255),(225/255),(225/255)), // Color de la sombra
						 'shaded'=>2, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
		$la_data[1]=array('name'=>$as_coddep.' - '.$as_dendep);	
		$la_columnas=array('name'=>'');					
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 9, // Tama�o de Letras
						 'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
				      	 'cols'=>array('name'=>array('justification'=>'left','width'=>500))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
        unset($la_data);
		unset($la_columnas);
		unset($la_config);
		
 } //fin uf_print_datos_personal
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
	require_once("../../shared/ezpdf/class.ezpdf.php");
	require_once("sigesp_sno_class_report.php");
	$io_report=new sigesp_sno_class_report();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();				
	require_once("../class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
//----------------------------------------------------  Par�metros del encabezado  -------------------------------------------
	$ls_titulo="REPORTE ENCARGADURIA";
//--------------------------------------------------  Par�metros para Filtar el Reporte  -----------------------------------------	
	$ls_codpencdes=$io_fun_nomina->uf_obtenervalor_get("codencdes","");
	$ls_codenchas=$io_fun_nomina->uf_obtenervalor_get("codenchas","");
	$ls_estenc=$io_fun_nomina->uf_obtenervalor_get("estenc","");
	$ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
	$ls_codnom=$_SESSION["la_nomina"]["codnom"];
	$ls_desnom=$_SESSION["la_nomina"]["desnom"];
//---------------------------------------------------------------------------------------------------------------------------------
    $lb_valido=uf_insert_seguridad($ls_titulo); // Seguridad de Reporte
	if($lb_valido)
	{
        $lb_valido=$io_report->uf_select_encargaduria($ls_codencdes,$ls_codenchas,$ls_estenc,$ls_orden);
		if (($lb_valido==false)||($io_report->rs_data->RecordCount()==0))
		{
		    print("<script language=JavaScript>");
			print(" alert('No hay nada que reportar');"); 
			print(" close();");
			print("</script>");
		}		   
		else  // Imprimimos el reporte
		{       
		    error_reporting(E_ALL);
			set_time_limit(1800);
			$io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF
			$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra		
			$io_pdf->ezStartPageNumbers(570,47,8,'','',1); // Insertar el n�mero de p�gina	
			$io_pdf->ezSetCmMargins(4,2.5,3,3); // Configuraci�n de los margenes en cent�metros		
			uf_print_encabezado_pagina($ls_titulo,&$io_pdf);
			$ls_auxcodigo="";
			$li_i=0;	
			$li_total=$io_report->rs_data->RecordCount();	
			while ((!$io_report->rs_data->EOF)&&($lb_valido))
		    {
		   		$ls_codenc=$io_report->rs_data->fields["codenc"];
				$ls_obsenc=trim($io_report->rs_data->fields["obsenc"]);
				$ld_fecinienc=$io_funciones->uf_convertirfecmostrar($io_report->rs_data->fields["fecinienc"]);				
				$ld_fecfinenc=$io_funciones->uf_convertirfecmostrar($io_report->rs_data->fields["fecfinenc"]);
				if ($ld_fecfinenc=='01/01/1900')
				{
					$ld_fecfin='S/F';
				}	
				else
				{
					$ld_fecfin=$ld_fecfinenc;
				}
				$ls_codperenc=$io_report->rs_data->fields["codperenc"];
				$ls_codnomenc=$io_report->rs_data->fields["codnomperenc"];
				$ls_nomperenc=$io_report->rs_data->fields["nomperenc"]." ".$io_report->rs_data->fields["apeperenc"];
				$ls_estenc=$io_report->rs_data->fields["estenc"];	
				if ($ls_estenc=='1')			
				{
					$ls_estenc='ACTIVA';
				}
				else
				{
					$ls_estenc='FINALIZADA';
				}
				$ls_codper=$io_report->rs_data->fields["codper"];				
				$ls_nomper=$io_report->rs_data->fields["nomper"]." ".$io_report->rs_data->fields["apeper"];				
				$ls_codsubnom=$io_report->rs_data->fields["codsubnom"];
				$ls_dessubnom=$io_report->rs_data->fields["dessubnom"];
				$ls_codasicar=$io_report->rs_data->fields["codasicar"];
				$ls_denasicar=$io_report->rs_data->fields["denasicar"];
				$ls_codcar=$io_report->rs_data->fields["codcar"];
				$ls_descar=$io_report->rs_data->fields["descar"];
				$ls_codtab=$io_report->rs_data->fields["codtab"];
				$ls_destab=$io_report->rs_data->fields["destab"];
				$ls_codgra=$io_report->rs_data->fields["codgra"];
				$ls_codpas=$io_report->rs_data->fields["codpas"];
				$ls_codunirac=$io_report->rs_data->fields["codunirac"];
								
				$ls_coduniadm=$io_report->rs_data->fields["minorguniadm"]."-".$io_report->rs_data->fields["ofiuniadm"]."-".$io_report->rs_data->fields["uniuniadm"]."-".$io_report->rs_data->fields["depuniadm"]."-".$io_report->rs_data->fields["prouniadm"];			
				$ls_desuniadm=$io_report->rs_data->fields["desuniadm"];				
				$ls_coddep=$io_report->rs_data->fields["coddep"];
				$ls_dendep=$io_report->rs_data->fields["dendep"];
				
				$ls_desnomenc=$io_report->rs_data->fields["desnomenc"];
				
				$lb_valido=$io_report->uf_select_datos_nomina_personal_encargado($ls_codnomenc,$ls_codperenc,$ls_coduniracenc,$ls_codsubnomenc,$ls_dessubnomenc,$ls_codasicarenc,$ls_denasicarenc,$ls_codtabenc,$ls_destabenc,$ls_codpasenc,$ls_codgraenc,$ls_codcarenc,$ls_descarenc,$ls_coduniadmenc,$ls_desuniadmenc,$ls_gradoenc,$ls_coddepenc,$ls_dendepenc);
				
				if ($lb_valido)
				{
					uf_print_datos_encargaduria($ls_codenc,$ld_fecinienc,$ld_fecfinenc,$ls_obsenc,$ls_estenc,$io_pdf);
												 
					uf_print_datos_personal('DATOS DEL PERSONAL',$ls_codnom,$ls_desnom,$ls_codper,$ls_nomper,$ls_codsubnom,$ls_dessubnom,$ls_codasicar,
					                        $ls_denasicar,$ls_codcar,$ls_descar,$ls_codtab,$ls_destab,$ls_codgra,$ls_codpas,
											$ls_codunirac,$ls_coduniadm,$ls_desuniadm,$ls_coddep,$ls_dendep,$io_pdf);
												 
					uf_print_datos_personal('DATOS DEL PERSONAL ENCARGADO',$ls_codnomenc,$ls_desnomenc,$ls_codperenc,$ls_nomperenc,$ls_codsubnomenc,
					                        $ls_dessubnomenc,$ls_codasicarenc,$ls_denasicarenc,$ls_codcarenc,$ls_descarenc,
											$ls_codtabenc,$ls_destabenc,$ls_codgraenc,$ls_codpasenc,$ls_coduniracenc,
											$ls_coduniadmenc,$ls_desuniadmenc,$ls_coddepenc,$ls_dendepenc,$io_pdf);
					
				}
				
				
				$io_report->rs_data->MoveNext();
				$li_i=$li_i+1;
				if (($li_i!=$li_total)&&($lb_valido))
				{
					$io_pdf->ezNewPage(); // Insertar una nueva p�gina
					$io_pdf->ezSetCmMargins(4,2.5,3,3); // Configuraci�n de los margenes en cent�metros	s
				}
			}	
			$io_report->rs_data->Close();			
   }
 
   if($lb_valido) // Si no ocurrio ning�n error
   {
		$io_pdf->ezStopPageNumbers(1,1); // Detenemos la impresi�n de los n�meros de p�gina
		$io_pdf->ezStream(); // Mostramos el reporte
   }
   else // Si hubo alg�n error
   {
		print("<script language=JavaScript>");
		print(" alert('Ocurri� un error al generar el reporte');"); 
		print(" close();");
		print("</script>");	
   }
	
		
	}	
	
?>	