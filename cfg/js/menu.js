// stm_aix("p1i2","p1i0",[0,"Opci�n 2    ","","",-1,-1,0,""]);
// stm_aix("p1i0","p0i0",[0,"Opci�n 1    ","","",-1,-1,0,"tablas.htm","_self","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);

//-----------------------//
// L�nea de separaci�n
// Para inlcuir l�neas de separaci�n entre las opciones, incoporar la siguiente instrucci�n, entre las opciones a separar
// stm_ai("p1i1",[6,1,"#e6e6e6","",0,0,0]);

//-----------------------//
// Men�es de Tercer Nivel
// Para hacer submen�es, incluir las siguientes l�neas de c�digo
// stm_bpx("pn","p1",[1,4,0,0,2,3,6,7]);   debajo de la l�nea de c�digo de la opci�n principal stm_aix("p0in","p0i0",[0," Opci�n Men� "]);
// luego, buscar la opci�n del men� bajo la cual se abrir� el submen� y agregar al final de esa l�nea de c�digo, los siguientes atributos:
// ,"","",-1,-1,0,"","_self","","","","",6,0,0,"imagebank/arrow.gif","imagebank/arrow.gif",7,7]);
// y justo debajo de esa l�nea agregar las siguientes l�neas de c�digo.
// stm_bpx("p3","p1",[1,2,0,0,2,3,0]);
// Edici�n - Opciones de Tercer Nivel
// stm_aix("p3i0","p1i0",[0,"  Menu Item 1  ","","",-1,-1,0,"","_self","","","","",0]);
// stm_aix("p3i1","p3i0",[0,"  Menu Item 2  "]);
// stm_aix("p3i2","p3i0",[0,"  Menu Item 3  "]);
// stm_aix("p3i3","p3i0",[0,"  Menu Item 4  "]);
// stm_aix("p3i4","p3i0",[0,"  Menu Item 5  "]);
// stm_ep();
// Luego cambiar las opciones "Menu Item 5", por el nombre de la opci�n que corresponda en cada caso.

//-----------------------//
// Hiperv�nculos
// Para incluir los enlaces correspondientes a cada opci�n del men�, se procede de la siguiente manera:
// En aquellas intrucciones, cuyo c�digo es similare a esto:
// stm_aix("p1i0","p0i0",[0,"Opci�n 1    ","","",-1,-1,0,"","_self","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
// agregar el enlace dentro de las comillas, justo delante de "_self"
// En aquellas intrucciones, cuyo c�digo es similare a esto:
// stm_aix("p3i1","p3i0",[0,"  Menu Item 2  "]);
// agregar al final de esta l�nea de c�digo, los siguientes par�metros:
// ,"","",-1,-1,0,"","_self","","","","",0]);
// y luego incorporar el enlace en las comillas que est� justo antes de "_self"

/*stm_bm(["menu08dd",430,"","imagebank/blank.gif",0,"","",0,0,0,0,1000,1,0,0,"","100%",0],this);
stm_bp("p0",[0,4,0,0,1,3,0,0,100,"",-2,"",-2,90,0,0,"#000000","#e6e6e6","",3,0,0,"#000000"]);

// Men� Principal- Archivo
stm_ai("p0i0",[0," Archivo ","","",-1,-1,0,"","_self","","","","",0,0,0,"","",0,0,0,0,1,"#F7F7F7",0,"#f4f4f4",0,"","",3,3,0,0,"#fffff7","#000000","#909090","#909090","8pt 'Tahoma','Arial'","8pt 'Tahoma','Arial'",0,0]);
stm_bp("p1",[1,4,0,0,2,3,6,0,100,"progid:DXImageTransform.Microsoft.Fade(overlap=.5,enabled=0,Duration=0.10)",-2,"",-2,100,2,3,"#999999","#ffffff","",3,1,1,"#F7F7F7"]);
// Archivo - Opciones de Segundo Nivel
stm_aix("p1i0","p0i0",[0,"Nuevo    ","","",-1,-1,0,"javascript:ue_nuevo()","","","","imagebank/tools20/nuevo.gif","imagebank/tools20/nuevo-off.gif",20,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i2","p1i0",[0,"Guardar    ","","",-1,-1,0,"javascript:ue_guardar()","","","","imagebank/tools20/grabar.gif","imagebank/tools20/grabar-off.gif",20,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i4","p1i0",[0,"Eliminar   ","","",-1,-1,0,"javascript:ue_eliminar()","","","","imagebank/tools20/eliminar.gif","imagebank/tools20/eliminar-off.gif",20,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i4","p1i0",[0,"Buscar   ","","",-1,-1,0,"javascript:ue_buscar()","","","","imagebank/tools20/buscar.gif","imagebank/tools20/buscar-off.gif",20,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i4","p1i0",[0,"Cerrar   ","","",-1,-1,0,"sigespwindow_blank.php","","","","imagebank/tools20/salir.gif","imagebank/tools20/salir-off.gif",20,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_ep();


// Men� Principal - Definiciones
stm_aix("p0i2","p0i0",[0," Definiciones "]);
stm_bpx("p4","p1",[1,4,0,0,2,3,6,7]);
stm_aix("p4i0","p1i0",[0," Deducciones   ","","",-1,-1,0,"sigesp_cxp_w_def_deduc.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p4i2","p1i0",[0," Otros Cr�ditos ","","",-1,-1,0,"sigesp_cxp_w_def_otroscre.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p4i4","p1i0",[0," Documentos         ","","",-1,-1,0,"sigesp_cxp_w_def_doc.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p4i6","p1i0",[0,"Clasificador ","","",-1,-1,0,"sigesp_cxp_w_def_clasi.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_ep();

// Men� Principal - Procesos
stm_aix("p0i3","p0i0",[0," Procesos "]);
stm_bpx("p5","p1",[1,4,0,0,2,3,6,7]);
stm_aix("p1i0","p0i0",[0,"Recepci�n de Documentos ","","",-1,-1,0,"sigesp_cxp_w_recep_docume.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i2","p1i0",[0,"Aprobaci�n de Recepci�n de Documentos ","","",-1,-1,0,"sigesp_cxp_w_aprob_rd.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i4","p1i0",[0,"Solicitud de Pagos ","","",-1,-1,0,"sigesp_cxp_w_proc_sol.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i6","p1i0",[0,"Aprobaci�n de Solicitud de Pagos ","","",-1,-1,0,"sigesp_cxp_w_aprob_sol.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_aix("p1i8","p1i0",[0,"Nota de Cr�dito / D�bito ","","",-1,-1,0,"sigesp_cxp_w_NC.php","","","","","",6,0,0,"","",0,0,0,0,1,"#ffffff"]);
stm_ep();

// Men� Principal - Reportes
stm_aix("p0i3","p0i0",[0," Reportes "]);
stm_bpx("p5","p1",[1,4,0,0,2,3,6,7]);
//Reportes - Opciones de Segundo Nivel
stm_aix("p6i2","p1i0",[0,"Listados    ","","",-1,-1,0,"","_self","","","","",6,0,0,"imagebank/arrow.gif","imagebank/arrow.gif",7,7]);
stm_bpx("p6","p1",[1,2,0,0,2,3,0]);
// Reportes - Opciones de Tercer Nivel Para Listados
stm_aix("p3i0","p1i0",[0,"  Otros Cr�ditos  ","","",-1,-1,0,"","_self","","","","",0]);
stm_aix("p3i1","p1i0",[0,"  Deducciones  ","","",-1,-1,0,"","_self","","","","",0]);
stm_aix("p3i1","p1i0",[0,"  Documentos  ","","",-1,-1,0,"","_self","","","","",0]);
stm_ep();
stm_ep();


//Menu Principal de Informes 
stm_aix("p0i3","p0i0",[0," Informes "]);
stm_bpx("p5","p1",[1,4,0,0,2,3,6,7]);
stm_aix("p6i0","p1i0",[0,"  Recepciones  ","","",-1,-1,0,"","_self","","","","",0]);
stm_aix("p6i1","p3i0",[0,"  CXP Detallado  ","","",-1,-1,0,"http://www.google.com/"]);
stm_aix("p6i2","p3i0",[0,"  Solicitudes de Pago "]);
stm_aix("p6i2","p1i0",[0,"  Retenciones    ","","",-1,-1,0,"","_self","","","","",6,0,0,"imagebank/arrow.gif","imagebank/arrow.gif",7,7]);
stm_bpx("p6","p1",[1,2,0,0,2,3,0]);
stm_aix("p6i0","p1i0",[0,"  Comprobante  ","","",-1,-1,0,"","_self","","","","",0]);
stm_aix("p6i1","p1i0",[0,"  Listado General  ","","",-1,-1,0,"","_self","","","","",0]);
stm_aix("p6i1","p1i0",[0,"  Listado Espec�fico  ","","",-1,-1,0,"","_self","","","","",0]);
stm_ep();
stm_aix("p6i4","p3i0",[0,"  CXP Resumido  "]);
stm_aix("p6i2","p3i0",[0,"  Relacion de Facturas "]);
stm_aix("p6i3","p3i0",[0,"  Relaci�n de Saldos por Solicitud"]);
stm_aix("p6i4","p3i0",[0,"  An�lisis de Vencimiento  "]);
stm_ep();



// Men� Principal - Mantenimiento
stm_aix("p0i5","p0i0",[0," Mantenimiento "]);
stm_bpx("p7","p1",[1,4,0,0,2,3,6,7]);
//Mantenimiento - Opciones de Segundo Nivel
stm_aix("p7i0","p1i0",[0,"Configuraci�n    "]);
stm_aix("p7i2","p1i0",[0,"Mantenimientos    ","","",-1,-1,0,"","_self","","","","",6,0,0,"imagebank/arrow.gif","imagebank/arrow.gif",7,7]);
stm_bpx("p7","p1",[1,2,0,0,2,3,0]);
// Mantenimiento - Opciones de Tercer Nivel
stm_aix("p3i0","p1i0",[0,"  Libro de Compras  ","","",-1,-1,0,"","_self","","","","",0]);
stm_ep();
stm_ep();
stm_ep();
stm_em();*/
