<?php
$gi_total=12;
$arbol["sistema"][1]="APR";
$arbol["nivel"][1]=0;
$arbol["nombre_logico"][1]="Procesos";
$arbol["nombre_fisico"][1]="";
$arbol["id"][1]="001";
$arbol["padre"][1]="000";
$arbol["numero_hijos"][1]=6;

$arbol["sistema"][2]="APR";
$arbol["nivel"][2]=1;
$arbol["nombre_logico"][2]="Apertura de B.D. Nueva";
$arbol["nombre_fisico"][2]="";
$arbol["id"][2]="002";
$arbol["padre"][2]="001";
$arbol["numero_hijos"][2]=1;

$arbol["sistema"][3]="APR";
$arbol["nivel"][3]=2;
$arbol["nombre_logico"][3]="Sistemas Básicos";
$arbol["nombre_fisico"][3]="sigesp_apr_basicos.php";
$arbol["id"][3]="003";
$arbol["padre"][3]="002";
$arbol["numero_hijos"][3]=0;

$arbol["sistema"][4]="APR";
$arbol["nivel"][4]=1;
$arbol["nombre_logico"][4]="Asociar Cuentas";
$arbol["nombre_fisico"][4]="";
$arbol["id"][4]="004";
$arbol["padre"][4]="001";
$arbol["numero_hijos"][4]=4;

$arbol["sistema"][5]="APR";
$arbol["nivel"][5]=2;
$arbol["nombre_logico"][5]="Cuentas Contables";
$arbol["nombre_fisico"][5]="sigesp_apr_actscgcuentas.php";
$arbol["id"][5]="005";
$arbol["padre"][5]="004";
$arbol["numero_hijos"][5]=0;

$arbol["sistema"][6]="APR";
$arbol["nivel"][6]=2;
$arbol["nombre_logico"][6]="Cuentas Presupuestarias";
$arbol["nombre_fisico"][6]="sigesp_apr_actspgcuentas.php";
$arbol["id"][6]="006";
$arbol["padre"][6]="004";
$arbol["numero_hijos"][6]=0;

$arbol["sistema"][7]="APR";
$arbol["nivel"][7]=2;
$arbol["nombre_logico"][7]="Estructuras Presupuestarias";
$arbol["nombre_fisico"][7]="sigesp_apr_actestructura.php";
$arbol["id"][7]="007";
$arbol["padre"][7]="004";
$arbol["numero_hijos"][7]=0;

$arbol["sistema"][8]="APR";
$arbol["nivel"][8]=2;
$arbol["nombre_logico"][8]="Procesar Cuentas";
$arbol["nombre_fisico"][8]="sigesp_apr_procesarcuentas.php";
$arbol["id"][8]="008";
$arbol["padre"][8]="004";
$arbol["numero_hijos"][8]=0;

$arbol["sistema"][9]="APR";
$arbol["nivel"][9]=1;
$arbol["nombre_logico"][9]="Asiento de Apertura de Contabilidad";
$arbol["nombre_fisico"][9]="sigesp_apr_salcontables.php";
$arbol["id"][9]="009";
$arbol["padre"][9]="001";
$arbol["numero_hijos"][9]=0;

$arbol["sistema"][10]="APR";
$arbol["nivel"][10]=1;
$arbol["nombre_logico"][10]="Traspaso Saldos Bancos y Movimiento en Tránsito";
$arbol["nombre_fisico"][10]="sigesp_apr_banco.php";
$arbol["id"][10]="010";
$arbol["padre"][10]="001";
$arbol["numero_hijos"][10]=0;

$arbol["sistema"][11]="APR";
$arbol["nivel"][11]=1;
$arbol["nombre_logico"][11]="Movimiento Inicial de Existencias";
$arbol["nombre_fisico"][11]="sigesp_apr_inventario.php";
$arbol["id"][11]="011";
$arbol["padre"][11]="001";
$arbol["numero_hijos"][11]=0;

$arbol["sistema"][12]="APR";
$arbol["nivel"][12]=1;
$arbol["nombre_logico"][12]="Traspaso Solicitudes Cuentas por Pagar";
$arbol["nombre_fisico"][12]="sigesp_apr_traspasa_sol_cxp.php";
$arbol["id"][12]="012";
$arbol["padre"][12]="001";
$arbol["numero_hijos"][12]=0;


/*
$arbol["sistema"][2]="APR";
$arbol["nivel"][2]=1;
$arbol["nombre_logico"][2]="APERTURA DE SALDOS CONTABLES";
$arbol["nombre_fisico"][2]="sigesp_apr_p_saldos_contables.php";
$arbol["id"][2]="002";
$arbol["padre"][2]="001";
$arbol["numero_hijos"][2]=0;
 
 */

?>