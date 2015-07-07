<?php

$arbol["sistema"][1]="RPC";
$arbol["nivel"][1]=0;
$arbol["nombre_logico"][1]="Proveedores";
$arbol["nombre_fisico"][1]="";
$arbol["id"][1]="001";
$arbol["padre"][1]="000";
$arbol["numero_hijos"][1]=5;

$arbol["sistema"][2]="RPC";
$arbol["nivel"][2]=1;
$arbol["nombre_logico"][2]="Parámetro de Calificación";
$arbol["nombre_fisico"][2]="sigesp_rpc_d_clasificacion.php";
$arbol["id"][2]="002";
$arbol["padre"][2]="001";
$arbol["numero_hijos"][2]=0;

$arbol["sistema"][3]="RPC";
$arbol["nivel"][3]=1;
$arbol["nombre_logico"][3]="Maestro de Recaudos";
$arbol["nombre_fisico"][3]="sigesp_rpc_d_documento.php";
$arbol["id"][3]="003";
$arbol["padre"][3]="001";
$arbol["numero_hijos"][3]=0;

$arbol["sistema"][4]="RPC";
$arbol["nivel"][4]=1;
$arbol["nombre_logico"][4]="Especialidad";
$arbol["nombre_fisico"][4]="sigesp_rpc_d_especialidad.php";
$arbol["id"][4]="004";
$arbol["padre"][4]="001";
$arbol["numero_hijos"][4]=0;

$arbol["sistema"][5]="RPC";
$arbol["nivel"][5]=1;
$arbol["nombre_logico"][5]="Tipo Empresa";
$arbol["nombre_fisico"][5]="sigesp_rpc_d_tipoempresa.php";
$arbol["id"][5]="005";
$arbol["padre"][5]="001";
$arbol["numero_hijos"][5]=0;

$arbol["sistema"][6]="RPC";
$arbol["nivel"][6]=1;
$arbol["nombre_logico"][6]="Ficha";
$arbol["nombre_fisico"][6]="sigesp_rpc_d_proveedor.php";
$arbol["id"][6]="006";
$arbol["padre"][6]="001";
$arbol["numero_hijos"][6]=0;

$arbol["sistema"][7]="RPC";
$arbol["nivel"][7]=0;
$arbol["nombre_logico"][7]="Beneficiario";
$arbol["nombre_fisico"][7]="";
$arbol["id"][7]="007";
$arbol["padre"][7]="000";
$arbol["numero_hijos"][7]=1;

$arbol["sistema"][8]="RPC";
$arbol["nivel"][8]=1;
$arbol["nombre_logico"][8]="Ficha";
$arbol["nombre_fisico"][8]="sigesp_rpc_d_beneficiario.php";
$arbol["id"][8]="008";
$arbol["padre"][8]="007";
$arbol["numero_hijos"][8]=0;

$arbol["sistema"][9]="RPC";
$arbol["nivel"][9]=0;
$arbol["nombre_logico"][9]="Procesos";
$arbol["nombre_fisico"][9]="";
$arbol["id"][9]="009";
$arbol["padre"][9]="000";
$arbol["numero_hijos"][9]=3;


$arbol["sistema"][10]="RPC";
$arbol["nivel"][10]=1;
$arbol["nombre_logico"][10]="Transferencia Personal Nómina a Beneficiario";
$arbol["nombre_fisico"][10]="sigesp_rpc_p_transferencia.php";
$arbol["id"][10]="010";
$arbol["padre"][10]="009";
$arbol["numero_hijos"][10]=0;

$arbol["sistema"][11]="RPC";
$arbol["nivel"][11]=1;
$arbol["nombre_logico"][11]="Actualizar Estatus de Proveedor";
$arbol["nombre_fisico"][11]="sigesp_rpc_p_cambioestatus_proveedor.php";
$arbol["id"][11]="011";
$arbol["padre"][11]="009";
$arbol["numero_hijos"][11]=0;

$arbol["sistema"][12]="RPC";
$arbol["nivel"][12]=1;
$arbol["nombre_logico"][12]="Transferencia de Proveedores";
$arbol["nombre_fisico"][12]="sigesp_rpc_p_traspasar_proveedores.php";
$arbol["id"][12]="012";
$arbol["padre"][12]="009";
$arbol["numero_hijos"][12]=0;

$arbol["sistema"][13]="RPC";
$arbol["nivel"][13]=0;
$arbol["nombre_logico"][13]="Reportes";
$arbol["nombre_fisico"][13]="";
$arbol["id"][13]="013";
$arbol["padre"][13]="000";
$arbol["numero_hijos"][13]=3;

$arbol["sistema"][14]="RPC";
$arbol["nivel"][14]=1;
$arbol["nombre_logico"][14]="Fichas";
$arbol["nombre_fisico"][14]="sigesp_rpc_r_fichas.php";
$arbol["id"][14]="014";
$arbol["padre"][14]="013";
$arbol["numero_hijos"][14]=0;

$arbol["sistema"][15]="RPC";
$arbol["nivel"][15]=1;
$arbol["nombre_logico"][15]="Beneficiarios";
$arbol["nombre_fisico"][15]="sigesp_rpc_r_beneficiario.php";
$arbol["id"][15]="015";
$arbol["padre"][15]="013";
$arbol["numero_hijos"][15]=0;

$arbol["sistema"][16]="RPC";
$arbol["nivel"][16]=1;
$arbol["nombre_logico"][16]="Proveedores";
$arbol["nombre_fisico"][16]="sigesp_rpc_r_provxespecia.php";
$arbol["id"][16]="016";
$arbol["padre"][16]="013";
$arbol["numero_hijos"][16]=0;

$gi_total=16;
?>