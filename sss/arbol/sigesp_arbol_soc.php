<?php

$arbol["sistema"][1]	    = "SOC";
$arbol["nivel"][1]         = 0;
$arbol["nombre_logico"][1] = "Cotizaciones";
$arbol["nombre_fisico"][1] = "";
$arbol["id"][1]			= "001";
$arbol["padre"][1]		    = "000";
$arbol["numero_hijos"][1]  = 5;

$arbol["sistema"][2]       = "SOC";
$arbol["nivel"][2]         = 1;
$arbol["nombre_logico"][2] = "Solicitud de Cotización";
$arbol["nombre_fisico"][2] = "sigesp_soc_p_solicitud_cotizacion.php";
$arbol["id"][2]            = "002";
$arbol["padre"][2]         = "001";
$arbol["numero_hijos"][2]  = 0;

$arbol["sistema"][3]		= "SOC";
$arbol["nivel"][3]			= 1;
$arbol["nombre_logico"][3] = "Registro de Cotización";
$arbol["nombre_fisico"][3] = "sigesp_soc_p_registro_cotizacion.php";
$arbol["id"][3]			= "003";
$arbol["padre"][3]			= "001";
$arbol["numero_hijos"][3]	= 0;

$arbol["sistema"][4]		= "SOC";
$arbol["nivel"][4]			= 1;
$arbol["nombre_logico"][4] = "Análisis de Cotizaciones";
$arbol["nombre_fisico"][4] = "sigesp_soc_p_analisis_cotizacion.php";
$arbol["id"][4]			= "004";
$arbol["padre"][4]			= "001";
$arbol["numero_hijos"][4]  = 0;

$arbol["sistema"][5]	= "SOC";
$arbol["nivel"][5]		= 1;
$arbol["nombre_logico"][5] = "Aprobaci&oacute;n An&aacute;lisis de Cotizaciones";
$arbol["nombre_fisico"][5] = "sigesp_soc_p_aprobacion_analisis_cotizacion.php";
$arbol["id"][5]		= "005";
$arbol["padre"][5]		= "001";
$arbol["numero_hijos"][5]  = 0;

$arbol["sistema"][6]	 = "SOC";
$arbol["nivel"][6]         = 1;
$arbol["nombre_logico"][6] = "Generaci&oacute;n de Ordenes de Compra";
$arbol["nombre_fisico"][6] = "sigesp_soc_p_generar_orden_analisis.php";
$arbol["id"][6]		= "006";
$arbol["padre"][6]		= "001";
$arbol["numero_hijos"][6]	= 0;

$arbol["sistema"][7]		= "SOC";
$arbol["nivel"][7]         = 0;
$arbol["nombre_logico"][7] = "Orden de Compra";
$arbol["nombre_fisico"][7] = "";
$arbol["id"][7]			= "007";
$arbol["padre"][7]			= "000";
$arbol["numero_hijos"][7]	= 4;

$arbol["sistema"][8]       = "SOC";
$arbol["nivel"][8]			= 1;
$arbol["nombre_logico"][8] = "Registro de Ordenes de Compra";
$arbol["nombre_fisico"][8]	= "sigesp_soc_p_registro_orden_compra.php";
$arbol["id"][8]			= "008";
$arbol["padre"][8]			= "007";
$arbol["numero_hijos"][8]  = 0;

$arbol["sistema"][9] 		= "SOC";
$arbol["nivel"][9]			= 1;
$arbol["nombre_logico"][9] = "Aprobación de Ordenes de Compra";
$arbol["nombre_fisico"][9] = "sigesp_soc_p_aprobacion_orden_compra.php";
$arbol["id"][9]			= "009";
$arbol["padre"][9]			= "007";
$arbol["numero_hijos"][9]  = 0;

$arbol["sistema"][10]       = "SOC";
$arbol["nivel"][10]         = 1;
$arbol["nombre_logico"][10] = "Anulaci&oacute;n de Ordenes de Compra";
$arbol["nombre_fisico"][10] = "sigesp_soc_p_anulacion_orden_compra.php";
$arbol["id"][10]            = "010";
$arbol["padre"][10]         = "007";
$arbol["numero_hijos"][10]  = 0;

$arbol["sistema"][11] 		= "SOC";
$arbol["nivel"][11]			= 1;
$arbol["nombre_logico"][11] = "Aceptación/Reverso de Servicios";
$arbol["nombre_fisico"][11] = "sigesp_soc_p_aceptacion_servicios.php";
$arbol["id"][11]			= "011";
$arbol["padre"][11]			= "007";
$arbol["numero_hijos"][11]  = 0;

$arbol["sistema"][12]		= "SOC";
$arbol["nivel"][12]			= 1;
$arbol["nombre_logico"][12] = "Reportes";
$arbol["nombre_fisico"][12] = "";
$arbol["id"][12]			= "012";
$arbol["padre"][12]			= "000";
$arbol["numero_hijos"][12]	= 6;

$arbol["sistema"][13]		= "SOC";
$arbol["nivel"][13]			= 1;
$arbol["nombre_logico"][13] = "Ordenes de Compra";
$arbol["nombre_fisico"][13] = "sigesp_soc_r_orden_compra.php";
$arbol["id"][13]			= "013";
$arbol["padre"][13]			= "012";
$arbol["numero_hijos"][13]	= 0;

$arbol["sistema"][14]       = "SOC";
$arbol["nivel"][14]         = 1;
$arbol["nombre_logico"][14] = "Solicitud de Cotizaciones";
$arbol["nombre_fisico"][14] = "sigesp_soc_r_solicitud_cotizacion.php";
$arbol["id"][14]            = "014";
$arbol["padre"][14]			= "012";
$arbol["numero_hijos"][14]  = 0;

$arbol["sistema"][15]		= "SOC";
$arbol["nivel"][15]         = 1;
$arbol["nombre_logico"][15] = "Registro de Cotizaciones";
$arbol["nombre_fisico"][15] = "sigesp_soc_r_registro_cotizacion.php";
$arbol["id"][15]            = "015";
$arbol["padre"][15]         = "012";
$arbol["numero_hijos"][15]  = 0;

$arbol["sistema"][16]       = "SOC";
$arbol["nivel"][16]         = 1;
$arbol["nombre_logico"][16] = "Análisis de Cotizaciones";
$arbol["nombre_fisico"][16] = "sigesp_soc_r_analisis_cotizacion.php";
$arbol["id"][16]            = "016";
$arbol["padre"][16]         = "012";
$arbol["numero_hijos"][16]  = 0;

$arbol["sistema"][17]       = "SOC";
$arbol["nivel"][17]         = 1;
$arbol["nombre_logico"][17] = "Acta de Aceptación de Servicios";
$arbol["nombre_fisico"][17] = "sigesp_soc_r_aceptacion_servicios.php";
$arbol["id"][17]            = "017";
$arbol["padre"][17]         = "012";
$arbol["numero_hijos"][17]  = 0;

$arbol["sistema"][18]       = "SOC";
$arbol["nivel"][18]         = 1;
$arbol["nombre_logico"][18] = "Ubicacion de Orden de Compra";
$arbol["nombre_fisico"][18] = "sigesp_soc_r_orden_ubicacioncompra.php";
$arbol["id"][18]            = "018";
$arbol["padre"][18]         = "012";
$arbol["numero_hijos"][18]  = 0;


$gi_total=18;
?>