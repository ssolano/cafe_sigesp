<?php
$gi_total=27;
$arbol["sistema"][1]="SPI";
$arbol["nivel"][1]=0;
$arbol["nombre_logico"][1]="Procesos";
$arbol["nombre_fisico"][1]="";
$arbol["id"][1]="001";
$arbol["padre"][1]="000";
$arbol["numero_hijos"][1]=4;

$arbol["sistema"][2]="SPI";
$arbol["nivel"][2]=1;
$arbol["nombre_logico"][2]="Apertura";
$arbol["nombre_fisico"][2]="";
$arbol["id"][2]="002";
$arbol["padre"][2]="001";
$arbol["numero_hijos"][2]=2;

$arbol["sistema"][3]="SPI";
$arbol["nivel"][3]=2;
$arbol["nombre_logico"][3]="Mensual";
$arbol["nombre_fisico"][3]="sigesp_spi_p_apertura.php";
$arbol["id"][3]="003";
$arbol["padre"][3]="002";
$arbol["numero_hijos"][3]=0;

$arbol["sistema"][4]="SPI";
$arbol["nivel"][4]=2;
$arbol["nombre_logico"][4]="Trimestral";
$arbol["nombre_fisico"][4]="sigesp_spi_p_apertura_trimestral.php";
$arbol["id"][4]="004";
$arbol["padre"][4]="002";
$arbol["numero_hijos"][4]=0;

$arbol["sistema"][5]="SPI";
$arbol["nivel"][5]=1;
$arbol["nombre_logico"][5]="Comprobantes";
$arbol["nombre_fisico"][5]="";
$arbol["id"][5]="005";
$arbol["padre"][5]="001";
$arbol["numero_hijos"][5]=1;

$arbol["sistema"][6]="SPI";
$arbol["nivel"][6]=2;
$arbol["nombre_logico"][6]="Ejecucion Financiera";
$arbol["nombre_fisico"][6]="sigesp_spi_p_comprobante.php";
$arbol["id"][6]="006";
$arbol["padre"][6]="005";
$arbol["numero_hijos"][6]=0;

$arbol["sistema"][7]="SPI";
$arbol["nivel"][7]=1;
$arbol["nombre_logico"][7]="Modificaciones Presupuestarias";
$arbol["nombre_fisico"][7]="";
$arbol["id"][7]="007";
$arbol["padre"][7]="001";
$arbol["numero_hijos"][7]=4;

$arbol["sistema"][8]="SPI";
$arbol["nivel"][8]=2;
$arbol["nombre_logico"][8]="Aumentos";
$arbol["nombre_fisico"][8]="sigesp_spi_p_aumento.php";
$arbol["id"][8]="008";
$arbol["padre"][8]="007";
$arbol["numero_hijos"][8]=0;

$arbol["sistema"][9]="SPI";
$arbol["nivel"][9]=2;
$arbol["nombre_logico"][9]="Disminuciones";
$arbol["nombre_fisico"][9]="sigesp_spi_p_disminucion.php";
$arbol["id"][9]="009";
$arbol["padre"][9]="007";
$arbol["numero_hijos"][9]=0;

$arbol["sistema"][10]="SPI";
$arbol["nivel"][10]=1;
$arbol["nombre_logico"][10]="Reverso/Cierre de Presupuesto";
$arbol["nombre_fisico"][10]="sigesp_spi_p_cerrarpre.php";
$arbol["id"][10]="010";
$arbol["padre"][10]="001";
$arbol["numero_hijos"][10]=0;

$arbol["sistema"][11]="SPI";
$arbol["nivel"][11]=1;
$arbol["nombre_logico"][11]="Programaci�n de Reportes";
$arbol["nombre_fisico"][11]="";
$arbol["id"][11]="011";
$arbol["padre"][11]="001";
$arbol["numero_hijos"][11]=2;

$arbol["sistema"][12]="SPI";
$arbol["nivel"][12]=2;
$arbol["nombre_logico"][12]="Mensual";
$arbol["nombre_fisico"][12]="sigesp_spi_p_progrep.php";
$arbol["id"][12]="012";
$arbol["padre"][12]="011";
$arbol["numero_hijos"][12]=0;

$arbol["sistema"][13]="SPI";
$arbol["nivel"][13]=2;
$arbol["nombre_logico"][13]="Trimestral";
$arbol["nombre_fisico"][13]="sigesp_spi_p_progrep_trimestral.php";
$arbol["id"][13]="013";
$arbol["padre"][13]="011";
$arbol["numero_hijos"][13]=0;

$arbol["sistema"][14]="SPI";
$arbol["nivel"][14]=0;
$arbol["nombre_logico"][14]="Reportes";
$arbol["nombre_fisico"][14]="";
$arbol["id"][14]="014";
$arbol["padre"][14]="000";
$arbol["numero_hijos"][14]=3;

$arbol["sistema"][15]="SPI";
$arbol["nivel"][15]=1;
$arbol["nombre_logico"][15]="Acumulado por Cuentas";
$arbol["nombre_fisico"][15]="sigesp_spi_r_acum_x_cuentas.php";
$arbol["id"][15]="015";
$arbol["padre"][15]="014";
$arbol["numero_hijos"][15]=0;

$arbol["sistema"][16]="SPI";
$arbol["nivel"][16]=1;
$arbol["nombre_logico"][16]="Mayor Analitico";
$arbol["nombre_fisico"][16]="sigesp_spi_r_mayor_analitico.php";
$arbol["id"][16]="016";
$arbol["padre"][16]="014";
$arbol["numero_hijos"][16]=0;

$arbol["sistema"][17]="SPI";
$arbol["nivel"][17]=1;
$arbol["nombre_logico"][17]="Listado de Apertura";
$arbol["nombre_fisico"][17]="sigesp_spi_r_listado_apertura.php";
$arbol["id"][17]="017";
$arbol["padre"][17]="014";
$arbol["numero_hijos"][17]=0;

$arbol["sistema"][18]="SPI";
$arbol["nivel"][18]=1;
$arbol["nombre_logico"][18]="Comprobante";
$arbol["nombre_fisico"][18]="sigesp_spi_r_comprobante_formato1.php";
$arbol["id"][18]="018";
$arbol["padre"][18]="014";
$arbol["numero_hijos"][18]=0;

$arbol["sistema"][19]="SPI";
$arbol["nivel"][19]=1;
$arbol["nombre_logico"][19]="Listado de Cuenta";
$arbol["nombre_fisico"][19]="sigesp_spi_r_cuentas.php";
$arbol["id"][19]="019";
$arbol["padre"][19]="014";
$arbol["numero_hijos"][19]=0;

$arbol["sistema"][20]="SPI";
$arbol["nivel"][20]=1;
$arbol["nombre_logico"][20]="Modificaciones Presupuestarias Aprobadas";
$arbol["nombre_fisico"][20]="sigesp_spi_r_modificaciones_presupuestarias_aprobadas.php";
$arbol["id"][20]="020";
$arbol["padre"][20]="014";
$arbol["numero_hijos"][20]=0;

$arbol["sistema"][21]="SPI";
$arbol["nivel"][21]=1;
$arbol["nombre_logico"][21]="Modificaciones Presupuestarias No Aprobadas";
$arbol["nombre_fisico"][21]="sigesp_spi_r_modificaciones_presupuestarias_no_aprobadas.php";
$arbol["id"][21]="021";
$arbol["padre"][21]="014";
$arbol["numero_hijos"][21]=0;



$arbol["sistema"][22]="SPI";
$arbol["nivel"][22]=1;
$arbol["nombre_logico"][22]="Comparados";
$arbol["nombre_fisico"][22]="";
$arbol["id"][22]="022";
$arbol["padre"][22]="014";
$arbol["numero_hijos"][22]=3;

$arbol["sistema"][23]="SPI";
$arbol["nivel"][23]=2;
$arbol["nombre_logico"][23]="Instructivo 07 - 2008";
$arbol["nombre_fisico"][23]="";
$arbol["id"][23]="023";
$arbol["padre"][23]="022";
$arbol["numero_hijos"][23]=3;

$arbol["sistema"][24]="SPI";
$arbol["nivel"][24]=3;
$arbol["nombre_logico"][24]="Ejecucion Trimestral de Presupuesto de Ingreso y Fuentes Financieras";
$arbol["nombre_fisico"][24]="sigesp_spi_r_ejecucion_trimestral.php";
$arbol["id"][24]="024";
$arbol["padre"][24]="023";
$arbol["numero_hijos"][24]=0;

$arbol["sistema"][25]="SPI";
$arbol["nivel"][25]=3;
$arbol["nombre_logico"][25]="Consolidado de Ejecucion Trimestral de Ingresos Financieros";
$arbol["nombre_fisico"][25]="sigesp_spi_r_instructivo_consolidado_ejecucion_trimestral.php";
$arbol["id"][25]="025";
$arbol["padre"][25]="023";
$arbol["numero_hijos"][25]=0;

$arbol["sistema"][26]="SPI";
$arbol["nivel"][26]=3;
$arbol["nombre_logico"][26]="Presupuesto de Caja";
$arbol["nombre_fisico"][26]="sigesp_spi_r_instructivo_presupuesto_caja.php";
$arbol["id"][26]="026";
$arbol["padre"][26]="023";
$arbol["numero_hijos"][26]=0;

$arbol["sistema"][27]="SPI";
$arbol["nivel"][27]=1;
$arbol["nombre_logico"][27]="Ejecucion Presupuestaria Mensual de Ingreso";
$arbol["nombre_fisico"][27]="sigesp_spi_r_ejecucion_financiera_mensual.php";
$arbol["id"][27]="027";
$arbol["padre"][27]="014";
$arbol["numero_hijos"][27]=0;
/*
$arbol["sistema"][28]="SPI";
$arbol["nivel"][28]=2;
$arbol["nombre_logico"][28]="Instructivo 08 - 2009";
$arbol["nombre_fisico"][28]="";
$arbol["id"][28]="028";
$arbol["padre"][28]="022";
$arbol["numero_hijos"][28]=3;

$arbol["sistema"][29]="SPI";
$arbol["nivel"][29]=3;
$arbol["nombre_logico"][29]="Ejecucion Trimestral de Presupuesto de Ingreso y Fuentes Financieras";
$arbol["nombre_fisico"][29]="sigesp_spi_r_ejecucion_trimestral_inst_8_2009.php";
$arbol["id"][29]="029";
$arbol["padre"][29]="028";
$arbol["numero_hijos"][29]=0;

$arbol["sistema"][30]="SPI";
$arbol["nivel"][30]=3;
$arbol["nombre_logico"][30]="Consolidado de Ejecucion Trimestral de Ingresos Financieros";
$arbol["nombre_fisico"][30]="sigesp_spi_r_instructivo_consolidado_ejecucion_trimestral_inst_08_2009.php";
$arbol["id"][30]="030";
$arbol["padre"][30]="028";
$arbol["numero_hijos"][30]=0;

$arbol["sistema"][31]="SPI";
$arbol["nivel"][31]=3;
$arbol["nombre_logico"][31]="Presupuesto de Caja";
$arbol["nombre_fisico"][31]="sigesp_spi_r_instructivo_presupuesto_caja_inst_08_2009.php";
$arbol["id"][31]="031";
$arbol["padre"][31]="028";
$arbol["numero_hijos"][31]=0;

$arbol["sistema"][32]="SPI";
$arbol["nivel"][32]=1;
$arbol["nombre_logico"][32]="Consolidacion Presupuestaria";
$arbol["nombre_fisico"][32]="sigesp_spi_p_consolidacion_empresas.php";
$arbol["id"][32]="032";
$arbol["padre"][32]="001";
$arbol["numero_hijos"][32]=0;

$arbol["sistema"][33]="SPI";
$arbol["nivel"][33]=1;
$arbol["nombre_logico"][33]="Eliminar Comprobantes";
$arbol["nombre_fisico"][33]="sigesp_spi_p_eliminar_comprobante.php";
$arbol["id"][33]="033";
$arbol["padre"][33]="001";
$arbol["numero_hijos"][33]=0;
*/
?>