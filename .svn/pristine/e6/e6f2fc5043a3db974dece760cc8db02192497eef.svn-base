<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  ESTE FORMATO SE IMPRIME EN Bs Y EN BsF. SEGUN LO SELECCIONADO POR EL USUARIO
//  MODIFICADO POR: ING.YOZELIN BARRAGAN         FECHA DE MODIFICACION : 27/08/2007
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_start();
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
if (!array_key_exists("la_logusr", $_SESSION)) {
    print "<script language=JavaScript>";
    print "close();";
    print "</script>";
}

//--------------------------------------------------------------------------------------------------------------------------------
function uf_print_encabezado_pagina($as_titulo, $as_cmpmov, $ad_fecha, &$io_pdf) {
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //       Function: uf_print_encabezadopagina
    //		   Access: private
    //	    Arguments: as_titulo // T?tulo del Reporte
    //	    		   as_cmpmov // numero de comprobante de movimiento
    //	    		   ad_fecha // Fecha
    //	    		   io_pdf // Instancia de objeto pdf
    //    Description: funci?n que imprime los encabezados por p?gina
    //	   Creado Por: Ing. Luis Anibal Lang
    // Fecha Creaci?n: 26/04/2006
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $io_encabezado = $io_pdf->openObject();
    $io_pdf->saveState();
    $io_pdf->setStrokeColor(0, 0, 0);
    $io_pdf->rectangle(420, 710, 130, 40);
    $io_pdf->line(420, 730, 550, 730);
    $io_pdf->addJpegFromFile('../../shared/imagebank/' . $_SESSION["ls_logo"], 50, 710, $_SESSION["ls_width"], $_SESSION["ls_height"]); // Agregar Logo
    $li_tm = $io_pdf->getTextWidth(11, $as_titulo);
    $tm = 280 - ($li_tm / 2);
    $io_pdf->addText($tm, 730, 11, $as_titulo); // Agregar el t?tulo
    $io_pdf->addText(424, 735, 11, "No.:");      // Agregar texto
    $io_pdf->addText(456, 735, 11, $as_cmpmov); // Agregar Numero de la solicitud
    $io_pdf->addText(424, 715, 10, "Fecha:"); // Agregar texto
    $io_pdf->addText(456, 715, 10, $ad_fecha); // Agregar la Fecha
    $io_pdf->addText(510, 760, 8, date("d/m/Y")); // Agregar la Fecha
    $io_pdf->addText(516, 753, 7, date("h:i a")); // Agregar la Hora
    // cuadro inferior
    $io_pdf->Rectangle(50, 40, 500, 70);
    $io_pdf->line(50, 53, 550, 53);
    $io_pdf->line(50, 97, 550, 97);
    $io_pdf->line(130, 40, 130, 110);
    $io_pdf->line(240, 40, 240, 110);
    $io_pdf->line(380, 40, 380, 110);
    $io_pdf->addText(60, 102, 7, "ELABORADO POR"); // Agregar el t?tulo
//		$io_pdf->addText(70,43,7,"COMPRAS"); // Agregar el t?tulo
    $io_pdf->addText(157, 102, 7, "VERIFICADO POR"); // Agregar el t?tulo
//		$io_pdf->addText(160,43,7,"PRESUPUESTO"); // Agregar el t?tulo
    $io_pdf->addText(280, 102, 7, "AUTORIZADO POR"); // Agregar el t?tulo
//		$io_pdf->addText(257,43,7,"ADMINISTRACI?N Y FINANZAS"); // Agregar el t?tulo
    $io_pdf->addText(440, 102, 7, "PROVEEDOR"); // Agregar el t?tulo
//		$io_pdf->addText(405,43,7,"FIRMA AUTOGRAFA, SELLO, FECHA"); // Agregar el t?tulo
    $io_pdf->restoreState();
    $io_pdf->closeObject();
    $io_pdf->addObject($io_encabezado, 'all');
}

// end function uf_print_encabezadopagina
//--------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------

function uf_print_cabecera($ls_codemp, $ls_nomemp, $ls_codcau, $ls_dencau, $ls_descmp, $ls_coduniadm, $ls_denuniadm, $ls_codrespri, $ls_respri, $ls_codresuso, $ls_resuso, $io_pdf) {
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //       Function: uf_print_cabecera
    //		   Access: private
    //	    Arguments: ls_codemp // codigo de empresa
    //	    		   ls_nomemp // nombre de empresa
    //	    		   ls_codcau    // codigo de causa
    //	    		   ls_dencau    // denominacion de causa
    //	    		   ls_descmp    // descripcion del comprobante
    //	    		   ls_coduniadm // codigo de la genrencia
    //	    		   ls_denuniadm // nombre de la gerencia
    //	    		   ls_codrespri // codigo del responsable primario
    //	    		   ls_respri    // nombre del responsable primario
    //	    		   ls_codresuso // codigo del responsable de uso
    //	    		   ls_resuso    // nombre del responsable de uso
    //	    		   io_pdf       // total de registros que va a tener el reporte
    //    Description: funci?n que imprime la cabecera de cada p?gina
    //	   Creado Por: Ing. Yesenia Moreno
    // Fecha Creaci?n: 21/04/2006
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $la_data = array(array('name' => '<b>Organismo:</b>                            ' . $ls_codemp . " - " . $ls_nomemp . ''),
        array('name' => '<b>Causa:</b>                                    ' . $ls_codcau . " - " . $ls_dencau . ''),
        array('name' => '<b>Observaciones:</b>                     ' . $ls_descmp . ''),
        array('name' => '<b>Ubicación Organizacional:</b>   ' . $ls_coduniadm . " - " . $ls_denuniadm . ''),
        array('name' => '<b>Responsable Primario:</b>         ' . $ls_codrespri . " - " . $ls_respri . ''),
        array('name' => '<b>Responsable de Uso:</b>            ' . $ls_codresuso . " - " . $ls_resuso . ''));
    $la_columna = array('name' => '');
    $la_config = array('showHeadings' => 0, // Mostrar encabezados
        'fontSize' => 8, // Tama?o de Letras
        'lineCol' => array(0.9, 0.9, 0.9), // Mostrar L?neas
        'showLines' => 1, // Mostrar L?neas
        'shaded' => 2, // Sombra entre l?neas
        'shadeCol' => array(0.9, 0.9, 0.9), // Color de la sombra
        'shadeCol2' => array(0.9, 0.9, 0.9), // Color de la sombra
        'xOrientation' => 'center', // Orientaci?n de la tabla
        'width' => 500, // Ancho de la tabla
        'maxWidth' => 500); // Ancho M?ximo de la tabla
    $io_pdf->ezTable($la_data, $la_columna, '', $la_config);
}

// end function uf_print_cabecera
//--------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------

function uf_print_detalle($la_data, &$io_pdf) {
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //       Function: uf_print_detalle
    //		   Access: private
    //	    Arguments: la_data // arreglo de informaci?n
    //	   			   io_pdf // Objeto PDF
    //    Description: funci?n que imprime el detalle
    //	   Creado Por: Ing. Yesenia Moreno
    // Fecha Creaci?n: 21/04/2006
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $io_pdf->ezSetDy(-5);
    $la_columna = array('codact' => '<b>Código</b>',
        'denact' => '<b>Activo</b>',
        'ideact' => '<b>Identificador</b>',
        //'desmov' => '<b>Descripción del Movimiento</b>',
        'monact' => '<b>Monto Bs.</b>');
    $la_config = array('showHeadings' => 1, // Mostrar encabezados
        'fontSize' => 8, // Tamaño de Letras
        'titleFontSize' => 8, // Tamaño de Letras de los t?tulos
        'showLines' => 1, // Mostrar L?neas
        'shaded' => 0, // Sombra entre l?neas
        'width' => 500, // Ancho de la tabla
        'maxWidth' => 500, // Ancho Máximo de la tabla
        'xOrientation' => 'center', // Orientación de la tabla
        'cols' => array('codact' => array('justification' => 'left', 'width' => 90), // Justificación y ancho de la columna
            'denact' => array('justification' => 'left', 'width' => 245), // Justificación y ancho de la columna
            'ideact' => array('justification' => 'left', 'width' => 100), // Justificación y ancho de la columna
            //'desmov' => array('justification' => 'left', 'width' => 155), // Justificación y ancho de la columna
            'monact' => array('justification' => 'right', 'width' => 65))); // Justificación y ancho de la columna
    $io_pdf->ezTable($la_data, $la_columna, '', $la_config);
}

// end function uf_print_detalle
//--------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------

function uf_print_totales($la_data, &$io_pdf) {
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //       Function: uf_print_totales
    //		   Access: private
    //	    Arguments: la_data // arreglo de informaci?n
    //	   			   io_pdf // Instancia de objeto pdf
    //    Description: funci?n que imprime el detalle por personal
    //	   Creado Por: Ing. Yesenia Moreno
    // Fecha Creaci?n: 06/07/2006
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $la_columna = array('total' => '',
        'monact' => '');
    $la_config = array('showHeadings' => 0, // Mostrar encabezados
        'fontSize' => 8, // Tama?o de Letras
        'titleFontSize' => 11, // Tama?o de Letras de los t?tulos
        'showLines' => 1, // Mostrar L?neas
        'shaded' => 0, // Sombra entre l?neas
        'width' => 500, // Ancho de la tabla
        'maxWidth' => 500, // Ancho M?ximo de la tabla
        'xOrientation' => 'center', // Orientaci?n de la tabla
        'cols' => array('total' => array('justification' => 'right', 'width' => 435), // Justificaci?n y ancho de la columna
            'monact' => array('justification' => 'right', 'width' => 65))); // Justificaci?n y ancho de la columna
    $io_pdf->ezTable($la_data, $la_columna, '', $la_config);
    $la_data = array(array('name' => ''));
    $la_columna = array('name' => '');
    $la_config = array('showHeadings' => 0, // Mostrar encabezados
        'showLines' => 0, // Mostrar L?neas
        'shaded' => 0, // Sombra entre l?neas
        'width' => 500, // Ancho M?ximo de la tabla
        'xOrientation' => 'center'); // Orientaci?n de la tabla
    $io_pdf->ezTable($la_data, $la_columna, '', $la_config);
}

// end function uf_print_totales
//--------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
require_once("../../shared/ezpdf/class.ezpdf.php");
require_once("../../shared/class_folder/class_funciones.php");
$io_funciones = new class_funciones();
require_once("../class_funciones_activos.php");
$io_fun_activos = new class_funciones_activos();
require_once("sigesp_saf_class_report.php");
$io_report = new sigesp_saf_class_report();
$ls_titulo_report = "Bs.";
//----------------------------------------------------  Parámetros del encabezado  -----------------------------------------------
$ls_fecrec = $io_fun_activos->uf_obtenervalor_get("fecrec", "");

$ls_titulo = "<b>Comprobante de Incorporación " . $ls_titulo_report . "</b>";
$ls_fecha = $ls_fecrec;
//--------------------------------------------------  Parámetros para Filtar el Reporte  -----------------------------------------
$arre = $_SESSION["la_empresa"];
$ls_codemp = $arre["codemp"];
$ls_nomemp = $arre["nombre"];
$ls_cmpmov = $io_fun_activos->uf_obtenervalor_get("cmpmov", "");
//--------------------------------------------------------------------------------------------------------------------------------
$lb_valido = $io_report->uf_saf_load_movimiento($ls_codemp, $ls_cmpmov, "", "", "I", "", "", ""); // Cargar el DS con los datos de la cabecera del reporte
if ($lb_valido == false) { // Existe algún error ? no hay registros
    print("<script language=JavaScript>");
    print(" alert('No hay nada que Reportar');");
    print(" close();");
    print("</script>");
} else // Imprimimos el reporte {
{
    error_reporting(E_ALL);
    set_time_limit(1800);
    $io_pdf = new Cezpdf('LETTER', 'portrait'); // Instancia de la clase PDF
    $io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
    $io_pdf->ezSetCmMargins(3.5, 4, 3, 3); // Configuraci?n de los margenes en cent?metros
    $ld_fecha = $io_report->ds->data["feccmp"][1];
    $ld_fecha = $io_funciones->uf_convertirfecmostrar($ld_fecha);
    uf_print_encabezado_pagina($ls_titulo, $ls_cmpmov, $ld_fecha, $io_pdf); // Imprimimos el encabezado de la p?gina
    $li_totrow = $io_report->ds->getRowCount("cmpmov");
    for ($li_i = 1; $li_i <= $li_totrow; $li_i++) {
        $io_pdf->transaction('start'); // Iniciamos la transacci?n
        $li_numpag = $io_pdf->ezPageCount; // N?mero de p?gina
        $li_totprenom = 0;
        $li_totant = 0;
        $ls_codcau = $io_report->ds->data["codcau"][$li_i];
        $ls_dencau = $io_report->ds->data["dencau"][$li_i];
        $ls_descmp = $io_report->ds->data["descmp"][$li_i];
        $ls_coduniadm = $io_report->ds->data["coduniadm"][$li_i];
        $ls_denuniadm = $io_report->ds->data["denuniadm"][$li_i];
        $ls_codrespri = $io_report->ds->data["codrespri"][$li_i];
        $ls_respri = $io_report->ds->data["respri"][$li_i];
        $ls_codresuso = $io_report->ds->data["codresuso"][$li_i];
        $ls_resuso = $io_report->ds->data["resuso"][$li_i];

        uf_print_cabecera($ls_codemp, $ls_nomemp, $ls_codcau, $ls_dencau, $ls_descmp, $ls_coduniadm, $ls_denuniadm, $ls_codrespri, $ls_respri, $ls_codresuso, $ls_resuso, $io_pdf); // Imprimimos la cabecera del registro
        $lb_valido = $io_report->uf_saf_load_dt_movimiento($ls_codemp, $ls_cmpmov, $ls_codcau); // Obtenemos el detalle del reporte
        if ($lb_valido) {
            $li_montot = 0;
            $li_totrow_det = $io_report->ds_detalle->getRowCount("codact");
            for ($li_s = 1; $li_s <= $li_totrow_det; $li_s++) {
                $ls_codart = $io_report->ds_detalle->data["codact"][$li_s];
                $ls_denart = $io_report->ds_detalle->data["denact"][$li_s];
                $li_ideact = $io_report->ds_detalle->data["ideact"][$li_s];
                //$ls_desmov = $io_report->ds_detalle->data["desmov"][$li_s];
                $li_monact = $io_report->ds_detalle->data["monact"][$li_s];
                $li_montot = $li_montot + $li_monact;
                $li_monact = $io_fun_activos->uf_formatonumerico($li_monact);
                $la_data[$li_s] = array('codact' => $ls_codart, 'denact' => $ls_denart, 'ideact' => $li_ideact, 'monact' => $li_monact);
            }
            $li_montot = $io_fun_activos->uf_formatonumerico($li_montot);
            uf_print_detalle($la_data, $io_pdf); // Imprimimos el detalle
            $la_datat[1] = array('total' => "Total", 'monact' => $li_montot);
            uf_print_totales($la_datat, &$io_pdf);
            if ($io_pdf->ezPageCount == $li_numpag) {// Hacemos el commit de los registros que se desean imprimir
                $io_pdf->transaction('commit');
            } else {// Hacemos un rollback de los registros, agregamos una nueva p?gina y volvemos a imprimir
                $io_pdf->transaction('rewind');
                if ($li_numpag != 1) {
                    $io_pdf->ezNewPage(); // Insertar una nueva p?gina
                }
                //uf_print_cabecera($ls_codemp, $ls_nomemp, $ls_codcau, $ls_dencau, $ls_descmp, $io_pdf);  // Imprimimos la cabecera del registro
                uf_print_cabecera($ls_codemp, $ls_nomemp, $ls_codcau, $ls_dencau, $ls_descmp, $ls_coduniadm, $ls_denuniadm, $ls_codrespri, $ls_respri, $ls_codresuso, $ls_resuso, $io_pdf); // Imprimimos la cabecera del registro
                uf_print_detalle($la_data, $io_pdf); // Imprimimos el detalle
                uf_print_totales($la_datat, &$io_pdf);
            }
        }
        unset($la_data);
    }
    if ($lb_valido) {
        $io_pdf->ezStopPageNumbers(1, 1);
        $io_pdf->ezStream();
    }
    unset($io_pdf);
}
unset($io_report);
unset($io_funciones);
unset($io_fun_nomina);
?> 