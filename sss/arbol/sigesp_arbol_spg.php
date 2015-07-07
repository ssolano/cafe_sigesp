<?php

$arbol["sistema"][1]="SPG";
$arbol["nivel"][1]=0;
$arbol["nombre_logico"][1]="Procesos";
$arbol["nombre_fisico"][1]="";
$arbol["id"][1]="001";
$arbol["padre"][1]="000";
$arbol["numero_hijos"][1]=8;

$arbol["sistema"][2]="SPG";
$arbol["nivel"][2]=1;
$arbol["nombre_logico"][2]="Apertura";
$arbol["nombre_fisico"][2]="";
$arbol["id"][2]="002";
$arbol["padre"][2]="001";
$arbol["numero_hijos"][2]=2;

$arbol["sistema"][3]="SPG";
$arbol["nivel"][3]=2;
$arbol["nombre_logico"][3]="Mensual";
$arbol["nombre_fisico"][3]="sigesp_spg_p_apertura.php";
$arbol["id"][3]="003";
$arbol["padre"][3]="002";
$arbol["numero_hijos"][3]=0;

$arbol["sistema"][4]="SPG";
$arbol["nivel"][4]=2;
$arbol["nombre_logico"][4]="Trimestral";
$arbol["nombre_fisico"][4]="sigesp_spg_p_apertura_trim.php";
$arbol["id"][4]="004";
$arbol["padre"][4]="002";
$arbol["numero_hijos"][4]=0;

$arbol["sistema"][5]="SPG";
$arbol["nivel"][5]=1;
$arbol["nombre_logico"][5]="Comprobantes";
$arbol["nombre_fisico"][5]="";
$arbol["id"][5]="005";
$arbol["padre"][5]="001";
$arbol["numero_hijos"][5]=1;

$arbol["sistema"][6]="SPG";
$arbol["nivel"][6]=2;
$arbol["nombre_logico"][6]="Ejecución Financiera";
$arbol["nombre_fisico"][6]="sigesp_spg_p_comprobante.php";
$arbol["id"][6]="006";
$arbol["padre"][6]="005";
$arbol["numero_hijos"][6]=0;

$arbol["sistema"][7]="SPG";
$arbol["nivel"][7]=1;
$arbol["nombre_logico"][7]="Modificaciones Presupuestarias";
$arbol["nombre_fisico"][7]="";
$arbol["id"][7]="007";
$arbol["padre"][7]="001";
$arbol["numero_hijos"][7]=4;

$arbol["sistema"][8]="SPG";
$arbol["nivel"][8]=2;
$arbol["nombre_logico"][8]="Rectificaciones";
$arbol["nombre_fisico"][8]="sigesp_spg_p_rectificaciones.php";
$arbol["id"][8]="008";
$arbol["padre"][8]="007";
$arbol["numero_hijos"][8]=0;

$arbol["sistema"][9]="SPG";
$arbol["nivel"][9]=2;
$arbol["nombre_logico"][9]="Insubsistencias";
$arbol["nombre_fisico"][9]="sigesp_spg_p_insubsistencias.php";
$arbol["id"][9]="009";
$arbol["padre"][9]="007";
$arbol["numero_hijos"][9]=0;

$arbol["sistema"][10]="SPG";
$arbol["nivel"][10]=2;
$arbol["nombre_logico"][10]="Traspasos";
$arbol["nombre_fisico"][10]="sigesp_spg_p_traspaso.php";
$arbol["id"][10]="010";
$arbol["padre"][10]="007";
$arbol["numero_hijos"][10]=0;

$arbol["sistema"][11]="SPG";
$arbol["nivel"][11]=2;
$arbol["nombre_logico"][11]="Credito/Ingreso Adicional";
$arbol["nombre_fisico"][11]="sigesp_spg_p_adicional.php";
$arbol["id"][11]="011";
$arbol["padre"][11]="007";
$arbol["numero_hijos"][11]=0;

$arbol["sistema"][12]="SPG";
$arbol["nivel"][12]=2;
$arbol["nombre_logico"][12]="Transferencias Intercompañias";
$arbol["nombre_fisico"][12]="";
$arbol["id"][12]="012";
$arbol["padre"][12]="001";
$arbol["numero_hijos"][12]=2;

$arbol["sistema"][13]="SPG";
$arbol["nivel"][13]=2;
$arbol["nombre_logico"][13]="Modificaciones Presupuestarias Aprobadas";
$arbol["nombre_fisico"][13]="sigesp_spg_p_transferir_traspasos.php";
$arbol["id"][13]="013";
$arbol["padre"][13]="012";
$arbol["numero_hijos"][13]=0;

$arbol["sistema"][14]="SPG";
$arbol["nivel"][14]=2;
$arbol["nombre_logico"][14]="Asientos Presupuestarios y Contables";
$arbol["nombre_fisico"][14]="sigesp_spg_p_trans_asipre.php";
$arbol["id"][14]="014";
$arbol["padre"][14]="012";
$arbol["numero_hijos"][14]=0;

$arbol["sistema"][15]="SPG";
$arbol["nivel"][15]=1;
$arbol["nombre_logico"][15]="Reverso/Cierre de Presupuesto de Gasto";
$arbol["nombre_fisico"][15]="sigesp_spg_p_cerrarpre.php";
$arbol["id"][15]="015";
$arbol["padre"][15]="001";
$arbol["numero_hijos"][15]=0;

$arbol["sistema"][16]="SPG";
$arbol["nivel"][16]=1;
$arbol["nombre_logico"][16]="Eliminar Comprobantes";
$arbol["nombre_fisico"][16]="sigesp_spg_p_eliminar_comprobante.php";
$arbol["id"][16]="016";
$arbol["padre"][16]="001";
$arbol["numero_hijos"][16]=0;

$arbol["sistema"][17]="SPG";
$arbol["nivel"][17]=1;
$arbol["nombre_logico"][17]="Programación de Reportes";
$arbol["nombre_fisico"][17]="sigesp_spg_p_progrep.php";
$arbol["id"][17]="017";
$arbol["padre"][17]="001";
$arbol["numero_hijos"][17]=0;

$arbol["sistema"][18]="SPG";
$arbol["nivel"][18]=1;
$arbol["nombre_logico"][18]="Modificación del Presupuesto Programado";
$arbol["nombre_fisico"][18]="";
$arbol["id"][18]="018";
$arbol["padre"][18]="001";
$arbol["numero_hijos"][18]=2;

$arbol["sistema"][19]="SPG";
$arbol["nivel"][19]=2;
$arbol["nombre_logico"][19]="Mensual";
$arbol["nombre_fisico"][19]="sigesp_spg_p_modprog.php";
$arbol["id"][19]="019";
$arbol["padre"][19]="018";
$arbol["numero_hijos"][19]=0;

$arbol["sistema"][20]="SPG";
$arbol["nivel"][20]=2;
$arbol["nombre_logico"][20]="Trimestral";
$arbol["nombre_fisico"][20]="sigesp_spg_p_modprog_trimestral.php";
$arbol["id"][20]="020";
$arbol["padre"][20]="018";
$arbol["numero_hijos"][20]=0;

$arbol["sistema"][21]="SPG";
$arbol["nivel"][21]=0;
$arbol["nombre_logico"][21]="Reportes";
$arbol["nombre_fisico"][21]="";
$arbol["id"][21]="021";
$arbol["padre"][21]="000";
$arbol["numero_hijos"][21]=6;

$arbol["sistema"][22]="SPG";
$arbol["nivel"][22]=1;
$arbol["nombre_logico"][22]="Estandar";
$arbol["nombre_fisico"][22]="";
$arbol["id"][22]="022";
$arbol["padre"][22]="021";
$arbol["numero_hijos"][22]=12;

$arbol["sistema"][23]="SPG";
$arbol["nivel"][23]=2;
$arbol["nombre_logico"][23]="Acumulado por Cuentas";
$arbol["nombre_fisico"][23]="sigesp_spg_r_acum_x_cuentas.php";
$arbol["id"][23]="023";
$arbol["padre"][23]="022";
$arbol["numero_hijos"][23]=0;

$arbol["sistema"][24]="SPG";
$arbol["nivel"][24]=2;
$arbol["nombre_logico"][24]="Mayor Analitico";
$arbol["nombre_fisico"][24]="sigesp_spg_r_mayor_analitico.php";
$arbol["id"][24]="024";
$arbol["padre"][24]="022";
$arbol["numero_hijos"][24]=0;

$arbol["sistema"][25]="SPG";
$arbol["nivel"][25]=2;
$arbol["nombre_logico"][25]="Listado de Apertura";
$arbol["nombre_fisico"][25]="sigesp_spg_r_listado_apertura.php";
$arbol["id"][25]="025";
$arbol["padre"][25]="022";
$arbol["numero_hijos"][25]=0;

$arbol["sistema"][26]="SPG";
$arbol["nivel"][26]=2;
$arbol["nombre_logico"][26]="Modificaciones Presupuestarias No Aprobadas";
$arbol["nombre_fisico"][26]="sigesp_spg_r_modificaciones_presupuestarias.php";
$arbol["id"][26]="026";
$arbol["padre"][26]="022";
$arbol["numero_hijos"][26]=0;

$arbol["sistema"][27]="SPG";
$arbol["nivel"][27]=2;
$arbol["nombre_logico"][27]="Modificaciones Presupuestarias Aprobadas";
$arbol["nombre_fisico"][27]="sigesp_spg_r_modificaciones_presupuestarias_aprobadas.php";
$arbol["id"][27]="027";
$arbol["padre"][27]="022";
$arbol["numero_hijos"][27]=0;

$arbol["sistema"][28]="SPG";
$arbol["nivel"][28]=2;
$arbol["nombre_logico"][28]="Comprobantes";
$arbol["nombre_fisico"][28]="";
$arbol["id"][28]="028";
$arbol["padre"][28]="022";
$arbol["numero_hijos"][28]=2;

$arbol["sistema"][29]="SPG";
$arbol["nivel"][29]=3;
$arbol["nombre_logico"][29]="Formato 1";
$arbol["nombre_fisico"][29]="sigesp_spg_r_comprobante_formato1.php";
$arbol["id"][29]="029";
$arbol["padre"][29]="028";
$arbol["numero_hijos"][29]=0;

$arbol["sistema"][30]="SPG";
$arbol["nivel"][30]=3;
$arbol["nombre_logico"][30]="Formato 2";
$arbol["nombre_fisico"][30]="sigesp_spg_r_comprobante_formato2.php";
$arbol["id"][30]="030";
$arbol["padre"][30]="028";
$arbol["numero_hijos"][30]=0;

$arbol["sistema"][31]="SPG";
$arbol["nivel"][31]=2;
$arbol["nombre_logico"][31]="Disponibilidad Presupuestaria";
$arbol["nombre_fisico"][31]="sigesp_spg_r_disponibilidad.php";
$arbol["id"][31]="031";
$arbol["padre"][31]="022";
$arbol["numero_hijos"][31]=0;

$arbol["sistema"][32]="SPG";
$arbol["nivel"][32]=2;
$arbol["nombre_logico"][32]="Disponibilidad Presupuestaria Formato # 2";
$arbol["nombre_fisico"][32]="sigesp_spg_r_disponibilidad_formato2.php";
$arbol["id"][32]="032";
$arbol["padre"][32]="022";
$arbol["numero_hijos"][32]=0;

$arbol["sistema"][33]="SPG";
$arbol["nivel"][33]=2;
$arbol["nombre_logico"][33]="Listado de Cuentas Presupuestarias";
$arbol["nombre_fisico"][33]="sigesp_spg_r_cuentas.php";
$arbol["id"][33]="033";
$arbol["padre"][33]="022";
$arbol["numero_hijos"][33]=0;

$arbol["sistema"][34]="SPG";
$arbol["nivel"][34]=2;
$arbol["nombre_logico"][34]="Resumen de Ejecucion Financiera de Presupuesto de Gasto";
$arbol["nombre_fisico"][34]="sigesp_spg_r_resumen_ejecucion_financiera.php";
$arbol["id"][34]="034";
$arbol["padre"][34]="022";
$arbol["numero_hijos"][34]=0;

$arbol["sistema"][63]="SPG";
$arbol["nivel"][63]=2;
$arbol["nombre_logico"][63]="Ejecucion Financiera de Presupuesto de Gasto";
$arbol["nombre_fisico"][63]="sigesp_spg_r_ejecucion_financiera.php";
$arbol["id"][63]="063";
$arbol["padre"][63]="022";
$arbol["numero_hijos"][63]=0;


$arbol["sistema"][35]="SPG";
$arbol["nivel"][35]=2;
$arbol["nombre_logico"][35]="Ejecución Presupuestaria Mensual de Gasto";
$arbol["nombre_fisico"][35]="sigesp_spg_r_ejecucion_financiera_mensual.php";
$arbol["id"][35]="035";
$arbol["padre"][35]="022";
$arbol["numero_hijos"][35]=0;

$arbol["sistema"][36]="SPG";
$arbol["nivel"][36]=1;
$arbol["nombre_logico"][36]="Otros";
$arbol["nombre_fisico"][36]="";
$arbol["id"][36]="036";
$arbol["padre"][36]="021";
$arbol["numero_hijos"][36]=12;

$arbol["sistema"][37]="SPG";
$arbol["nivel"][37]=2;
$arbol["nombre_logico"][37]="Distribucion Mensual del Presupuesto";
$arbol["nombre_fisico"][37]="sigesp_spg_r_distribucion_mensual_presupuesto.php";
$arbol["id"][37]="037";
$arbol["padre"][37]="036";
$arbol["numero_hijos"][37]=0;

$arbol["sistema"][38]="SPG";
$arbol["nivel"][38]=2;
$arbol["nombre_logico"][38]="Distribucion Trimestral del Presupuesto";
$arbol["nombre_fisico"][38]="sigesp_spg_r_distribucion_trimestral_presupuesto.php";
$arbol["id"][38]="038";
$arbol["padre"][38]="036";
$arbol["numero_hijos"][38]=0;

$arbol["sistema"][39]="SPG";
$arbol["nivel"][39]=2;
$arbol["nombre_logico"][39]="Unidades Ejecutoras";
$arbol["nombre_fisico"][39]="sigesp_spg_r_unidades_ejecutoras.php";
$arbol["id"][39]="039";
$arbol["padre"][39]="036";
$arbol["numero_hijos"][39]=0;

$arbol["sistema"][40]="SPG";
$arbol["nivel"][40]=2;
$arbol["nombre_logico"][40]="Ejecucion de Compromisos";
$arbol["nombre_fisico"][40]="sigesp_spg_r_ejecucion_compromisos.php";
$arbol["id"][40]="040";
$arbol["padre"][40]="036";
$arbol["numero_hijos"][40]=0;

$arbol["sistema"][41]="SPG";
$arbol["nivel"][41]=2;
$arbol["nombre_logico"][41]="Compromisos no Causados";
$arbol["nombre_fisico"][41]="sigesp_spg_r_compromisos_no_causados.php";
$arbol["id"][41]="041";
$arbol["padre"][41]="036";
$arbol["numero_hijos"][41]=0;

$arbol["sistema"][42]="SPG";
$arbol["nivel"][42]=2;
$arbol["nombre_logico"][42]="Compromisos Causados Parcialmente";
$arbol["nombre_fisico"][42]="sigesp_spg_r_compromisos_causados_parcialmente.php";
$arbol["id"][42]="042";
$arbol["padre"][42]="036";
$arbol["numero_hijos"][42]=0;

$arbol["sistema"][43]="SPG";
$arbol["nivel"][43]=2;
$arbol["nombre_logico"][43]="Compromisos Causados no Pagados";
$arbol["nombre_fisico"][43]="sigesp_spg_r_compromisos_causados_no_pagados.php";
$arbol["id"][43]="043";
$arbol["padre"][43]="036";
$arbol["numero_hijos"][43]=0;

$arbol["sistema"][44]="SPG";
$arbol["nivel"][44]=2;
$arbol["nombre_logico"][44]="Operacion por Especifica";
$arbol["nombre_fisico"][44]="sigesp_spg_r_operacion_por_especifica.php";
$arbol["id"][44]="044";
$arbol["padre"][44]="036";
$arbol["numero_hijos"][44]=0;

$arbol["sistema"][45]="SPG";
$arbol["nivel"][45]=2;
$arbol["nombre_logico"][45]="Ejecutado por Partida";
$arbol["nombre_fisico"][45]="sigesp_spg_r_ejecutado_por_partida.php";
$arbol["id"][45]="045";
$arbol["padre"][45]="036";
$arbol["numero_hijos"][45]=0;

$arbol["sistema"][46]="SPG";
$arbol["nivel"][46]=2;
$arbol["nombre_logico"][46]="Operación por Banco";
$arbol["nombre_fisico"][46]="sigesp_spg_r_operacion_por_banco.php";
$arbol["id"][46]="046";
$arbol["padre"][46]="036";
$arbol["numero_hijos"][46]=0;

$arbol["sistema"][47]="SPG";
$arbol["nivel"][47]=2;
$arbol["nombre_logico"][47]="Resumen Proveedor/Beneficiario";
$arbol["nombre_fisico"][47]="sigesp_spg_r_resumen_prov_bene.php";
$arbol["id"][47]="047";
$arbol["padre"][47]="036";
$arbol["numero_hijos"][47]=0;

$arbol["sistema"][48]="SPG";
$arbol["nivel"][48]=2;
$arbol["nombre_logico"][48]="Cuadro Resumen de Fideicomisos";
$arbol["nombre_fisico"][48]="sigesp_spg_r_resumen_fideicomiso.php";
$arbol["id"][48]="048";
$arbol["padre"][48]="036";
$arbol["numero_hijos"][48]=0;

$arbol["sistema"][49]="SPG";
$arbol["nivel"][49]=1;
$arbol["nombre_logico"][49]="Comparados";
$arbol["nombre_fisico"][49]="";
$arbol["id"][49]="049";
$arbol["padre"][49]="021";
$arbol["numero_hijos"][49]=2;

$arbol["sistema"][50]="SPG";
$arbol["nivel"][50]=2;
$arbol["nombre_logico"][50]="Instructivo 06 - 2008";
$arbol["nombre_fisico"][50]="";
$arbol["id"][50]="050";
$arbol["padre"][50]="049";
$arbol["numero_hijos"][50]=3;

$arbol["sistema"][51]="SPG";
$arbol["nivel"][51]=3;
$arbol["nombre_logico"][51]="Ejecucion Financiera de los Proyectos / Acciones Centralizadas del Organo";
$arbol["nombre_fisico"][51]="sigesp_spg_r_instructivo_06_ejec_fin_pry_acc.php";
$arbol["id"][51]="051";
$arbol["padre"][51]="050";
$arbol["numero_hijos"][51]=0;

$arbol["sistema"][52]="SPG";
$arbol["nivel"][52]=3;
$arbol["nombre_logico"][52]="Ejecucion Financiera de las Acciones Especificas del Organo";
$arbol["nombre_fisico"][52]="sigesp_spg_r_instructivo_06_ejec_fin_acc_esp.php";
$arbol["id"][52]="052";
$arbol["padre"][52]="050";
$arbol["numero_hijos"][52]=0;

$arbol["sistema"][53]="SPG";
$arbol["nivel"][53]=3;
$arbol["nombre_logico"][53]="Informacion Mensual de la Ejecucion Financiera";
$arbol["nombre_fisico"][53]="sigesp_spg_r_instructivo_06_inf_men_eje_fin.php";
$arbol["id"][53]="053";
$arbol["padre"][53]="050";
$arbol["numero_hijos"][53]=0;

$arbol["sistema"][54]="SPG";
$arbol["nivel"][54]=2;
$arbol["nombre_logico"][54]="Instructivo 07 - 2008";
$arbol["nombre_fisico"][54]="";
$arbol["id"][54]="054";
$arbol["padre"][54]="049";
$arbol["numero_hijos"][54]=3;

$arbol["sistema"][55]="SPG";
$arbol["nivel"][55]=3;
$arbol["nombre_logico"][55]="Ejecucion Trimestral de Gastos y Aplicaciones Financieras";
$arbol["nombre_fisico"][55]="sigesp_spg_r_ejecucion_trimestral.php";
$arbol["id"][55]="055";
$arbol["padre"][55]="054";
$arbol["numero_hijos"][55]=0;

$arbol["sistema"][56]="SPG";
$arbol["nivel"][56]=3;
$arbol["nombre_logico"][56]="Consolidado de Ejecucion Trimestral de Gastos y Aplicaciones Financieras";
$arbol["nombre_fisico"][56]="sigesp_spg_r_instructivo_consolidado_ejecucion_trimestral.php";
$arbol["id"][56]="056";
$arbol["padre"][56]="054";
$arbol["numero_hijos"][56]=0;

$arbol["sistema"][57]="SPG";
$arbol["nivel"][57]=3;
$arbol["nombre_logico"][57]="Estado de Resultado";
$arbol["nombre_fisico"][57]="sigesp_spg_r_instructivo_estado_resultado.php";
$arbol["id"][57]="057";
$arbol["padre"][57]="054";
$arbol["numero_hijos"][57]=0;

$arbol["sistema"][58]="SPG";
$arbol["nivel"][58]=1;
$arbol["nombre_logico"][58]="Traspasos Intercompañías";
$arbol["nombre_fisico"][58]="";
$arbol["id"][58]="058";
$arbol["padre"][58]="021";
$arbol["numero_hijos"][58]=1;

$arbol["sistema"][59]="SPG";
$arbol["nivel"][59]=2;
$arbol["nombre_logico"][59]="Resultado de Traspasos Presupuestarios Intercompañia";
$arbol["nombre_fisico"][59]="sigesp_spg_r_traspasos.php";
$arbol["id"][59]="059";
$arbol["padre"][59]="058";
$arbol["numero_hijos"][59]=0;

$arbol["sistema"][60]="SPG";
$arbol["nivel"][60]=1;
$arbol["nombre_logico"][60]="Modificaciones Presupuestarias";
$arbol["nombre_fisico"][60]="";
$arbol["id"][60]="060";
$arbol["padre"][60]="021";
$arbol["numero_hijos"][60]=1;

$arbol["sistema"][61]="SPG";
$arbol["nivel"][61]=2;
$arbol["nombre_logico"][61]="Presupuesto Modificado Detallado por Fuentes de Financiamiento";
$arbol["nombre_fisico"][61]="sigesp_spg_r_modif_fuente_finan.php";
$arbol["id"][61]="061";
$arbol["padre"][61]="060";
$arbol["numero_hijos"][61]=0;

$arbol["sistema"][62]="SPG";
$arbol["nivel"][62]=1;
$arbol["nombre_logico"][62]="Modificaciones al Programado";
$arbol["nombre_fisico"][62]="sigesp_spg_r_modif_programado.php";
$arbol["id"][62]="062";
$arbol["padre"][62]="021";
$arbol["numero_hijos"][62]=0;

/*
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Resumen del Presupuesto de Gasto Por Partida(0704)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0704.php";
$arbol["id"][$li_i]="024";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Resumen del Presupuesto (0705)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0705.php";
$arbol["id"][$li_i]="025";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ejecución Financiera  del Presupuesto de Gastos(0707)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_ejecucion_financiera_formato3.php";
$arbol["id"][$li_i]="026";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ejecución Financiera Mensual del Presupuesto de Gastos(0402)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0402.php";
$arbol["id"][$li_i]="027";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ejecución Financiera de los Proyectos del Ente(0413)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0413.php";
$arbol["id"][$li_i]="028";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ejecución Financiera de las Acciones Centralizadas del Ente(0414)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0414.php";
$arbol["id"][$li_i]="029";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ejecución Financiera de las Acciones Especificas(0415)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0415.php";
$arbol["id"][$li_i]="030";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Presupuesto de Caja (0717)";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_comparados_forma0717.php";
$arbol["id"][$li_i]="031";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
















$li_i++;













$li_i++;

$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Presupuesto Modificado Detallado por Fuente de Financiamiento";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_modif_fuente_finan.php";
$arbol["id"][$li_i]="064";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;

$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Modificaciones al Programado";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_r_modif_programado.php";
$arbol["id"][$li_i]="065";
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
$li_i++;

$li_i++;
$arbol["sistema"][$li_i]="SPG";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Consolidación Presupuestaria";
$arbol["nombre_fisico"][$li_i]="sigesp_spg_p_consolidacion_empresas.php";
$arbol["id"][$li_i]="066";
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=0;

*/
$gi_total=63;
?>