<?php
$gi_total=59;



$arbol["sistema"][1]       = "CFG";
$arbol["nivel"][1]         = 0;
$arbol["nombre_logico"][1] = "Sigesp";
$arbol["nombre_fisico"][1] = "";
$arbol["id"][1]            = "001";
$arbol["padre"][1]         = "000";
$arbol["numero_hijos"][1]  = 10;

$arbol["sistema"][2]       = "CFG";
$arbol["nivel"][2]         = 1;
$arbol["nombre_logico"][2] = "Empresa";
$arbol["nombre_fisico"][2] = "sigesp_cfg_d_empresa.php";
$arbol["id"][2]			   = "002";
$arbol["padre"][2]		   = "001";
$arbol["numero_hijos"][2]  = 0;

$arbol["sistema"][3]	   = "CFG";
$arbol["nivel"][3]		   = 1;
$arbol["nombre_logico"][3] = "Procedencias";
$arbol["nombre_fisico"][3] = "sigesp_cfg_d_procedencia.php";
$arbol["id"][3]			   = "003";
$arbol["padre"][3]		   = "001";
$arbol["numero_hijos"][3]  = 0;


$arbol["sistema"][4]       = "CFG";
$arbol["nivel"][4]         = 1;
$arbol["nombre_logico"][4] = "Ubicación Geográfica";
$arbol["nombre_fisico"][4] = "";
$arbol["id"][4]			   = "004";
$arbol["padre"][4]		   = "001";
$arbol["numero_hijos"][4]  = 5;


$arbol["sistema"][5]       = "CFG";
$arbol["nivel"][5]         = 2;
$arbol["nombre_logico"][5] = "Paises";
$arbol["nombre_fisico"][5] = "sigesp_rpc_d_pais.php";
$arbol["id"][5]			   = "005";
$arbol["padre"][5]		   = "004";
$arbol["numero_hijos"][5]  = 0;


$arbol["sistema"][6]	   = "CFG";
$arbol["nivel"][6]		   = 2;
$arbol["nombre_logico"][6] = "Estados";
$arbol["nombre_fisico"][6] = "sigesp_rpc_d_estado.php";
$arbol["id"][6]			   = "006";
$arbol["padre"][6]		   = "004";
$arbol["numero_hijos"][6]  = 0;


$arbol["sistema"][7]       = "CFG";
$arbol["nivel"][7]         = 2;
$arbol["nombre_logico"][7] = "Municipios";
$arbol["nombre_fisico"][7] = "sigesp_rpc_d_municipio.php";
$arbol["id"][7]            = "007";
$arbol["padre"][7]         = "004";
$arbol["numero_hijos"][7]  = 0;


$arbol["sistema"][8]	   = "CFG";
$arbol["nivel"][8]		   = 2;
$arbol["nombre_logico"][8] = "Parroquias";
$arbol["nombre_fisico"][8] = "sigesp_rpc_d_parroquia.php";
$arbol["id"][8]			   = "008";
$arbol["padre"][8]		   = "004";
$arbol["numero_hijos"][8]  = 0;


$arbol["sistema"][9]       = "CFG";
$arbol["nivel"][9]         = 2;
$arbol["nombre_logico"][9] = "Ciudad";
$arbol["nombre_fisico"][9] = "sigesp_scv_d_ciudad.php";
$arbol["id"][9]            = "009";
$arbol["padre"][9]         = "004";
$arbol["numero_hijos"][9]  = 0;


$arbol["sistema"][10]       = "CFG";
$arbol["nivel"][10]         = 1;
$arbol["nombre_logico"][10] = "Comunidad";
$arbol["nombre_fisico"][10] = "sigesp_rpc_d_comunidad.php";
$arbol["id"][10]			   = "010";
$arbol["padre"][10]         = "001";
$arbol["numero_hijos"][10]  = 0;


$arbol["sistema"][11]	   = "CFG";
$arbol["nivel"][11]		   = 1;
$arbol["nombre_logico"][11] = "Control Número";
$arbol["nombre_fisico"][11] = "sigesp_cfg_d_ctrl_numero.php";
$arbol["id"][11]			   = "011";
$arbol["padre"][11]		   = "001";
$arbol["numero_hijos"][11]  = 0;


$arbol["sistema"][12]	   = "CFG";
$arbol["nivel"][12]		   = 1;
$arbol["nombre_logico"][12] = "Unidad Tributaria";
$arbol["nombre_fisico"][12] = "sigesp_cfg_d_unidad_tributaria.php";
$arbol["id"][12]		= "012";
$arbol["padre"][12]		   = "001";
$arbol["numero_hijos"][12]  = 0;


$arbol["sistema"][13]	   = "CFG";
$arbol["nivel"][13]		   = 1;
$arbol["nombre_logico"][13] = "Consolidación";
$arbol["nombre_fisico"][13] = "sigesp_cfg_d_consolidacion.php";
$arbol["id"][13]			   = "013";
$arbol["padre"][13]		   = "001";
$arbol["numero_hijos"][13]  = 0;


$arbol["sistema"][14]	   = "CFG";
$arbol["nivel"][14]		   = 1;
$arbol["nombre_logico"][14] = "Moneda";
$arbol["nombre_fisico"][14] = "sigesp_cfg_d_moneda.php";
$arbol["id"][14]			   = "014";
$arbol["padre"][14]		   = "001";
$arbol["numero_hijos"][14]  = 0;


$arbol["sistema"][15]	   = "CFG";
$arbol["nivel"][15]		   = 1;
$arbol["nombre_logico"][15] = "Correo Electrónico";
$arbol["nombre_fisico"][15] = "sigesp_cfg_d_correo.php";
$arbol["id"][15]            = "015";
$arbol["padre"][15]		   = "001";
$arbol["numero_hijos"][15]  = 0;


$arbol["sistema"][16]	   = "CFG";
$arbol["nivel"][16]		   = 0;
$arbol["nombre_logico"][16] = "Contabilidad Patrimonial/Fiscal";
$arbol["nombre_fisico"][16] = "";
$arbol["id"][16]			   = "016";
$arbol["padre"][16]		   = "000";
$arbol["numero_hijos"][16]  = 4;


$arbol["sistema"][17]	   = "CFG";
$arbol["nivel"][17]		   = 1;
$arbol["nombre_logico"][17] = "Plan de Cuentas Patrimoniales";
$arbol["nombre_fisico"][17] = "sigesp_scg_d_plan_unico.php";
$arbol["id"][17]			   = "017";
$arbol["padre"][17]		   = "016";
$arbol["numero_hijos"][17]  = 0;

$arbol["sistema"][18]	   = "CFG";
$arbol["nivel"][18]		   = 1;
$arbol["nombre_logico"][18] = "Catálogo de Recursos y Egresos";
$arbol["nombre_fisico"][18] = "sigesp_scg_d_plan_unicore.php";
$arbol["id"][18]			   = "018";
$arbol["padre"][18]		   = "016";
$arbol["numero_hijos"][18]  = 0;


$arbol["sistema"][19]	   = "CFG";
$arbol["nivel"][19]		   = 1;
$arbol["nombre_logico"][19] = "Plan de Cuentas";
$arbol["nombre_fisico"][19] = "sigesp_scg_d_plan_ctas.php";
$arbol["id"][19]			   = "019";
$arbol["padre"][19]		   = "016";
$arbol["numero_hijos"][19]  = 0;


$arbol["sistema"][20]	   = "CFG";
$arbol["nivel"][20]		   = 1;
$arbol["nombre_logico"][20] = "Casamiento Presupuesto";
$arbol["nombre_fisico"][20] = "sigesp_scg_d_casamientopresupuesto.php";
$arbol["id"][20]			   = "020";
$arbol["padre"][20]		   = "016";
$arbol["numero_hijos"][20]  = 0;


$arbol["sistema"][21]       = "CFG";
$arbol["nivel"][21]         = 0;
$arbol["nombre_logico"][21] = "Presupuesto de Ingreso";
$arbol["nombre_fisico"][21] = "";
$arbol["id"][21]			   = "021";
$arbol["padre"][21]         = "000";
$arbol["numero_hijos"][21]  = 1;


$arbol["sistema"][22]	   = "CFG";
$arbol["nivel"][22] 		   = 1;
$arbol["nombre_logico"][22] = "Plan de Cuentas";
$arbol["nombre_fisico"][22] = "sigesp_spi_d_planctas.php";
$arbol["id"][22]			   = "022";
$arbol["padre"][22]		   = "021";
$arbol["numero_hijos"][22]  = 0;


$arbol["sistema"][23]	   = "CFG";
$arbol["nivel"][23]		   = 0;
$arbol["nombre_logico"][23] = "Presupuesto de Gasto";
$arbol["nombre_fisico"][23] = "";
$arbol["id"][23]			   = "023";
$arbol["padre"][23]		   = "000";
$arbol["numero_hijos"][23]  = 12;


$arbol["sistema"][24]       = "CFG";
$arbol["nivel"][24]		   = 1;
$arbol["nombre_logico"][24] = "Fuente de Financiamiento";
$arbol["nombre_fisico"][24] = "sigesp_spg_d_fuentfinan.php";
$arbol["id"][24]			   = "024";
$arbol["padre"][24]		   = "023";
$arbol["numero_hijos"][24]  = 0;


$arbol["sistema"][25]	   = "CFG";
$arbol["nivel"][25]		   = 1;
$arbol["nombre_logico"][25] = "Estructura Presupuestaria 1";
$arbol["nombre_fisico"][25] = "sigesp_spg_d_estprog1.php";
$arbol["id"][25]			   = "025";
$arbol["padre"][25]		   = "023";
$arbol["numero_hijos"][25]  = 0;


$arbol["sistema"][27]       = "CFG";
$arbol["nivel"][27]		   = 1;
$arbol["nombre_logico"][27] = "Estructura Presupuestaria 2";
$arbol["nombre_fisico"][27] = "sigesp_spg_d_estprog2.php";
$arbol["id"][27]			   = "027";
$arbol["padre"][27]         = "023";
$arbol["numero_hijos"][27]  = 0;


$arbol["sistema"][28]       = "CFG";
$arbol["nivel"][28]         = 1;
$arbol["nombre_logico"][28] = "Estructura Presupuestaria 3";
$arbol["nombre_fisico"][28] = "sigesp_spg_d_estprog3.php";
$arbol["id"][28]			   = "028";
$arbol["padre"][28]		   = "023";
$arbol["numero_hijos"][28]  = 0;


$arbol["sistema"][29]	   = "CFG";
$arbol["nivel"][29]		   = 1;
$arbol["nombre_logico"][29] = "Estructura Presupuestaria 4";
$arbol["nombre_fisico"][29] = "sigesp_spg_d_estprog4.php";
$arbol["id"][29]			   = "029";
$arbol["padre"][29]		   = "023";
$arbol["numero_hijos"][29]  = 0;


$arbol["sistema"][30]	   = "CFG";
$arbol["nivel"][30]		   = 1;
$arbol["nombre_logico"][30] = "Estructura Presupuestaria 5";
$arbol["nombre_fisico"][30] = "sigesp_spg_d_estprog5.php";
$arbol["id"][30]			   = "030";
$arbol["padre"][30]		   = "023";
$arbol["numero_hijos"][30]  = 0;


$arbol["sistema"][31]	   = "CFG";
$arbol["nivel"][31]		   = 1;
$arbol["nombre_logico"][31] = "Casamiento Estructura Presupuestaria - Fuentes de Financiamiento";
$arbol["nombre_fisico"][31] = "sigesp_spg_d_codestpro_codfuefin.php";
$arbol["id"][31]			   = "031";
$arbol["padre"][31]		   = "023";
$arbol["numero_hijos"][31]  = 0;


$arbol["sistema"][32]	   = "CFG";
$arbol["nivel"][32]		   = 1;
$arbol["nombre_logico"][32] = "Plan de Cuentas";
$arbol["nombre_fisico"][32] = "sigesp_spg_d_planctas.php";
$arbol["id"][32]			   = "032";
$arbol["padre"][32]		   = "023";
$arbol["numero_hijos"][32]  = 0;


$arbol["sistema"][33]	   = "CFG";
$arbol["nivel"][33]		   = 1;
$arbol["nombre_logico"][33] = "Unidad Administradora";
$arbol["nombre_fisico"][33] = "sigesp_spg_d_uniadm.php";
$arbol["id"][33]			   = "033";
$arbol["padre"][33]		   = "023";
$arbol["numero_hijos"][33]  = 0;


$arbol["sistema"][34]	   = "CFG";
$arbol["nivel"][34]		   = 1;
$arbol["nombre_logico"][34] = "Unidad Ejecutora";
$arbol["nombre_fisico"][34] = "sigesp_spg_d_unidad.php";
$arbol["id"][34]			   = "034";
$arbol["padre"][34]		   = "023";
$arbol["numero_hijos"][34]  = 0;


$arbol["sistema"][35]	   = "CFG";
$arbol["nivel"][35]		   = 1;
$arbol["nombre_logico"][35] = "Validación Presupuestaria";
$arbol["nombre_fisico"][35] = "sigesp_spg_d_validaciones.php";
$arbol["id"][35]			   = "035";
$arbol["padre"][35]		   = "023";
$arbol["numero_hijos"][35]  = 0;


$arbol["sistema"][36]       = "CFG";
$arbol["nivel"][36]         = 1;
$arbol["nombre_logico"][36] = "Tipo de Modificaciones Presupuestarias ";
$arbol["nombre_fisico"][36] = "sigesp_spg_d_tipomodificaciones.php";
$arbol["id"][36]			   = "037";
$arbol["padre"][36]		   = "023";
$arbol["numero_hijos"][36]  = 0;


$arbol["sistema"][37]       = "CFG";
$arbol["nivel"][37]         = 0;
$arbol["nombre_logico"][37] = "Cuentas Por Pagar";
$arbol["nombre_fisico"][37] = "";
$arbol["id"][37]            = "037";
$arbol["padre"][37]         = "000";
$arbol["numero_hijos"][37]  = 4;


$arbol["sistema"][38]       = "CFG";
$arbol["nivel"][38]         = 1;
$arbol["nombre_logico"][38] = "Deducciones";
$arbol["nombre_fisico"][38] = "sigesp_cxp_d_deducciones.php";
$arbol["id"][38]            = "038";
$arbol["padre"][38]         = "037";
$arbol["numero_hijos"][38]  = 0;


$arbol["sistema"][39]       = "CFG";
$arbol["nivel"][39]         = 1;
$arbol["nombre_logico"][39] = "Otros Créditos";
$arbol["nombre_fisico"][39] = "sigesp_cxp_d_otroscreditos.php";
$arbol["id"][39]            = "039";
$arbol["padre"][39]         = "037";
$arbol["numero_hijos"][39]  = 0;


$arbol["sistema"][40]       = "CFG";
$arbol["nivel"][40]         = 1;
$arbol["nombre_logico"][40] = "Documentos";
$arbol["nombre_fisico"][40] = "sigesp_cxp_d_documentos.php";
$arbol["id"][40]            = "040";
$arbol["padre"][40]         = "037";
$arbol["numero_hijos"][40]  = 0;


$arbol["sistema"][41]       = "CFG";
$arbol["nivel"][41]         = 1;
$arbol["nombre_logico"][41] = "Clasificador";
$arbol["nombre_fisico"][41] = "sigesp_cxp_d_clasificador.php";
$arbol["id"][41]            = "042";
$arbol["padre"][41]         = "037";
$arbol["numero_hijos"][41]  = 0;


$arbol["sistema"][42]       = "CFG";
$arbol["nivel"][42]         = 0;
$arbol["nombre_logico"][42] = "Solicitud de Ejecución Presupuestaria";
$arbol["nombre_fisico"][42] = "";
$arbol["id"][42]            = "042";
$arbol["padre"][42]         = "000";
$arbol["numero_hijos"][42]  = 2;


$arbol["sistema"][43]	   = "CFG";
$arbol["nivel"][43]		   = 1;
$arbol["nombre_logico"][43] = "Tipo";
$arbol["nombre_fisico"][43] = "sigesp_sep_d_tipo.php";
$arbol["id"][43]			   = "043";
$arbol["padre"][43]         = "042";
$arbol["numero_hijos"][43]  = 0;


$arbol["sistema"][44]	   = "CFG";
$arbol["nivel"][44]		   = 1;
$arbol["nombre_logico"][44] = "Concepto";
$arbol["nombre_fisico"][44] = "sigesp_sep_d_concepto.php";
$arbol["id"][44]            = "045";
$arbol["padre"][44]         = "042";
$arbol["numero_hijos"][44]  = 0;


$arbol["sistema"][45]	   = "CFG";
$arbol["nivel"][45]		   = 0;
$arbol["nombre_logico"][45] = "Ordenes de Compras";
$arbol["nombre_fisico"][45] = "";
$arbol["id"][45]			   = "045";
$arbol["padre"][45]		   = "000";
$arbol["numero_hijos"][45]  = 1;


$arbol["sistema"][46]	   = "CFG";
$arbol["nivel"][46]		   = 1;
$arbol["nombre_logico"][46] = "Tipo de Servicios";
$arbol["nombre_fisico"][46] = "sigesp_soc_d_tiposer.php";
$arbol["id"][46]			   = "046";
$arbol["padre"][46]		   = "045";
$arbol["numero_hijos"][46]  = 0;


$arbol["sistema"][47]	   = "CFG";
$arbol["nivel"][47]		   = 1;
$arbol["nombre_logico"][47] = "Servicios";
$arbol["nombre_fisico"][47] = "sigesp_soc_d_servicio.php";
$arbol["id"][47]			   = "047";
$arbol["padre"][47]		   = "045";
$arbol["numero_hijos"][47]  = 0;


$arbol["sistema"][48]	   = "CFG";
$arbol["nivel"][48]		   = 1;
$arbol["nombre_logico"][48] = "Clausulas";
$arbol["nombre_fisico"][48] = "sigesp_soc_d_clausulas.php";
$arbol["id"][48]			   = "048";
$arbol["padre"][48]		   = "045";
$arbol["numero_hijos"][48]  = 0;


$arbol["sistema"][49]	   = "CFG";
$arbol["nivel"][49]		   = 1;
$arbol["nombre_logico"][49] = "Modalidad de Clausulas";
$arbol["nombre_fisico"][49] = "sigesp_soc_d_modcla.php";
$arbol["id"][49]			   = "050";
$arbol["padre"][49]		   = "045";
$arbol["numero_hijos"][49]  = 0;


$arbol["sistema"][50]	   = "CFG";
$arbol["nivel"][50]		   = 0;
$arbol["nombre_logico"][50] = "Banco";
$arbol["nombre_fisico"][50] = "";
$arbol["id"][50]			   = "050";
$arbol["padre"][50]		   = "000";
$arbol["numero_hijos"][50]  = 8;


$arbol["sistema"][51]	   = "CFG";
$arbol["nivel"][51]		   = 1;
$arbol["nombre_logico"][51] = "Bancos";
$arbol["nombre_fisico"][51] = "sigesp_scb_d_banco.php";
$arbol["id"][51]			   = "051";
$arbol["padre"][51]		   = "050";
$arbol["numero_hijos"][51]  = 0;


$arbol["sistema"][52]	   = "CFG";
$arbol["nivel"][52]		   = 1;
$arbol["nombre_logico"][52] = "Tipo de Cuenta";
$arbol["nombre_fisico"][52] = "sigesp_scb_d_tipocta.php";
$arbol["id"][52]			   = "052";
$arbol["padre"][52]		   = "050";
$arbol["numero_hijos"][52]  = 0;


$arbol["sistema"][53]       = "CFG";
$arbol["nivel"][53]		   = 1;
$arbol["nombre_logico"][53] = "Cuenta Banco";
$arbol["nombre_fisico"][53] = "sigesp_scb_d_ctabanco.php";
$arbol["id"][53]			   = "053";
$arbol["padre"][53]		   = "050";
$arbol["numero_hijos"][53]  = 0;


$arbol["sistema"][54]	   = "CFG";
$arbol["nivel"][54]		   = 1;
$arbol["nombre_logico"][54] = "Chequera";
$arbol["nombre_fisico"][54] = "sigesp_scb_d_chequera.php";
$arbol["id"][54]			   = "054";
$arbol["padre"][54]		   = "050";
$arbol["numero_hijos"][54]  = 0;


$arbol["sistema"][55]	   = "CFG";
$arbol["nivel"][55]		   = 1;
$arbol["nombre_logico"][55] = "Tipo de Colocación";
$arbol["nombre_fisico"][55] = "sigesp_scb_d_tipocolocacion.php";
$arbol["id"][55]			   = "055";
$arbol["padre"][55]		   = "050";
$arbol["numero_hijos"][55]  = 0;


$arbol["sistema"][56]	   = "CFG";
$arbol["nivel"][56]		   = 1;
$arbol["nombre_logico"][56] = "Colocación";
$arbol["nombre_fisico"][56] = "sigesp_scb_d_colocacion.php";
$arbol["id"][56]			   = "056";
$arbol["padre"][56]         = "050";
$arbol["numero_hijos"][56]  = 0;


$arbol["sistema"][57]	   = "CFG";
$arbol["nivel"][57]		   = 1;
$arbol["nombre_logico"][57] = "Conceptos de Movimientos";
$arbol["nombre_fisico"][57] = "sigesp_scb_d_conceptos.php";
$arbol["id"][57]			   = "057";
$arbol["padre"][57]		   = "050";
$arbol["numero_hijos"][57]  = 0;


$arbol["sistema"][58]       = "CFG";
$arbol["nivel"][58]		   = 1;
$arbol["nombre_logico"][58] = "Agencias";
$arbol["nombre_fisico"][58] = "sigesp_scb_d_agencia.php";
$arbol["id"][58]			   = "058";
$arbol["padre"][58]         = "050";
$arbol["numero_hijos"][58]  = 0;


$arbol["sistema"][59]       = "CFG";
$arbol["nivel"][59]		   = 1;
$arbol["nombre_logico"][59] = "Tipo de Fondo de Avance";
$arbol["nombre_fisico"][59] = "sigesp_scb_d_tipofondo.php";
$arbol["id"][59]			   = "059";
$arbol["padre"][59]         = "050";
$arbol["numero_hijos"][59]  = 0;


?>