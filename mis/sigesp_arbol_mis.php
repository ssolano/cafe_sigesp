<?php
$li_i=0;

$li_i++; // 001
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=0;
$arbol["nombre_logico"][$li_i]="Sistemas";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="000";
$arbol["numero_hijos"][$li_i]=8;

$li_i++; // 002
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Solicitud de Ejecuci�n Presupuestaria";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=3;

$li_i++; // 003
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Compras";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 004
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 005
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Solicitudes Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="004";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 006
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Notas de Debitos/Cr�ditos Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="004";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 007
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Caja y Banco";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=3;

$li_i++; // 008
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Movimientos de Caja y Banco";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="007";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 009
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Colocaciones de Caja y Banco";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="007";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 010
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Orden de Pago Directa de Caja y Banco";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="007";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 011
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="N�mina";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 012
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Obras";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 013
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Asignaci�n";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="012";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 014
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Contratos";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="012";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 015
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Anticipos";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="012";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 016
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Valuaci�n";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="012";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 017
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Contabilidad Presupuestaria de Gasto";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 018
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Contabilidad Presupuestaria de Ingreso";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=2;

$li_i++; // 019
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Activos Fijo";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=1;


$li_i++; // 020
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Depreciaciones";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="019";
$arbol["numero_hijos"][$li_i]=1;


$li_i++; // 021
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=0;
$arbol["nombre_logico"][$li_i]="Mantenimiento";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="000";
$arbol["numero_hijos"][$li_i]=1;

$li_i++; // 022
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Recepciones de Documento";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="004";
$arbol["numero_hijos"][$li_i]=4;

$li_i++; // 023
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=0;
$arbol["nombre_logico"][$li_i]="Control de Cr�ditos";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="000";
$arbol["numero_hijos"][$li_i]=1;

$li_i++; // 024
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Inventario";
$arbol["nombre_fisico"][$li_i]="";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="001";
$arbol["numero_hijos"][$li_i]=2;

//--------------------------------------------- SEP -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Contabilizar Solicitud de Ejecuci�n Presupuestaria";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_sep.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="002";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar Solicitud de Ejecuci�n Presupuestaria";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_sep.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="002";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Anular Solicitud de Ejecuci�n Presupuestaria";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_sep.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="002";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SOC -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Contabilizar Ordenes de Compra ";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_soc.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="003";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar Ordenes de Compra ";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_soc.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="003";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Anular Ordenes de Compra ";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_soc.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="003";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar Anulaci�n de  Ordenes de Compra ";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anula_soc.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="003";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- CXP -----------------------------------------------------------

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Solicitudes de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_cxp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="005";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Solicitudes de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_cxp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="005";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anular Solicitudes de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_cxp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="005";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reverso Anular de Solicitudes de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anula_cxp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="005";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Notas de Cr�dito/D�bito de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_ncd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="006";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Notas de Cr�dito/D�bito de Ordenes de Pago";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_ncd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="006";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Recepciones de Documento";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_rd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="022";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Recepciones de Documento";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_rd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="022";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anular Recepciones de Documento";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_rd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="022";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Anulaci�n Recepciones de Documento";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anula_rd.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="022";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SCB -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Movimientos Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_scb.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="008";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Movimientos Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_scb.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="008";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anulaci�n de Movimientos Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_scb.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="008";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reverso Anulaci�n de  Movimientos Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anula_scb.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="008";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Colocaciones Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_scbcol.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="009";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Colocaciones Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_scbcol.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="009";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizaci�n Orden de Pago Directo Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_scbop.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="010";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reverso Orden de Pago Directo Caja y Banco";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_scbop.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="010";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SNO -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Contabilizaci�n de N�mina";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_sno.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="011";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reverso de N�mina";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_sno.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="011";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SOB -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Asignaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_asignacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="013";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Asignaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_asignacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="013";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anular Asignaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_asignacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="013";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Anulaci�n Asignaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_revanula_asignacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="013";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Contrato Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_contrato_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="014";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Contrato Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_contrato_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="014";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anular Contrato Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_anula_contrato_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="014";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Anulaci�n de Contrato Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_revanula_contrato_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="014";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizaci�n Anticipo Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_anticipo_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="015";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Anticipo Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anticipo_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="015";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Valuaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_valuacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="016";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Valuaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_valuacion_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="016";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Anular Valuaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_anula_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="016";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Anulaci�n Valuaci�n Obras";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_revanula_sob.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="016";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SPG -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Aprobaci�n de Modificaciones Presupuestarias";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_mp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="017";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar de Modificaciones Presupuestarias";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reversa_mp.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="017";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SPI -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Aprobaci�n de Modificaciones Presupuestarias Ingreso";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_mp_spi.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="018";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar de Modificaciones Presupuestarias Ingreso";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_mp_spi.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="018";
$arbol["numero_hijos"][$li_i]=0;

//--------------------------------------------- SAF -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="SAF";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Contabilizar Depreciaci�n Activos Fijos";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_depreciacion_saf.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="020";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="SAF";
$arbol["nivel"][$li_i]=3;
$arbol["nombre_logico"][$li_i]="Reversar Depreciaci�n Activos Fijos";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_depreciacion_saf.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="020";
$arbol["numero_hijos"][$li_i]=0;

//---------------------------------------- CONTROL DE CR�DITOS ------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Aprobaci�n";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_aprobacioncontrolcreditos.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="023";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Cuentas por cobrar";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_cuentasporcobrar.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="023";
$arbol["numero_hijos"][$li_i]=0;

//---------------------------------------- MANTENIMIENTO ------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=1;
$arbol["nombre_logico"][$li_i]="Configuraci�n";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_configuracion.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="021";
$arbol["numero_hijos"][$li_i]=0;
//--------------------------------------------- SIV -----------------------------------------------------------
$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Contabilizar Despachos";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_contabiliza_siv.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="024";
$arbol["numero_hijos"][$li_i]=0;

$li_i++;
$arbol["sistema"][$li_i]="MIS";
$arbol["nivel"][$li_i]=2;
$arbol["nombre_logico"][$li_i]="Reversar Despachos";
$arbol["nombre_fisico"][$li_i]="sigesp_mis_p_reverso_siv.php";
$arbol["id"][$li_i]=$li_i;
$arbol["padre"][$li_i]="024";
$arbol["numero_hijos"][$li_i]=0;

$gi_total=$li_i;
?>