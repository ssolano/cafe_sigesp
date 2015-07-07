<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat�logo de Deducciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	color: #006699;
}
a:visited {
	color: #006699;
}
a:hover {
	color: #006699;
}
a:active {
	color: #006699;
}
-->
</style></head>
<body>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="496" colspan="2" class="titulo-celda">Cat&aacute;logo de Deducciones</td>
    </tr>
</table>
  <div align="center"><br>
    <?php
require_once("../../shared/class_folder/sigesp_include.php");
require_once("../../shared/class_folder/class_datastore.php");
require_once("../../shared/class_folder/class_sql.php");

$io_conect=new sigesp_include();
$con=$io_conect->uf_conectar();
$io_dsdeducciones=new class_datastore();
$io_sql=new class_sql($con);
$arr=$_SESSION["la_empresa"];
$ls_sql=" SELECT a.*,b.denominacion ".
        " FROM sigesp_deducciones a,scg_cuentas b ".
		" WHERE a.sc_cuenta=b.sc_cuenta ".
        " ORDER BY a.codded ASC";

$rs_deduc=$io_sql->select($ls_sql);
$data=$rs_deduc;
if($row=$io_sql->fetch_row($rs_deduc))
{
     $data=$io_sql->obtener_datos($rs_deduc);
	 $arrcols=array_keys($data);
     $totcol=count($arrcols);
     $io_dsdeducciones->data=$data;
     $totrow=$io_dsdeducciones->getRowCount("codded");
	 print "<table width=600 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
	 print "<tr class=titulo-celda>";
	 print "<td>C�digo</td>";
	 print "<td>Denominaci�n</td>";
 	 print "<td>SCG</td>";
	 print "<td>Deducible</td>";
	 print "<td>F�rmula</td>";
	 print "</tr>";	
	 for ($z=1;$z<=$totrow;$z++)
		 {
			print "<tr class=celdas-blancas>";
			$codigo=$data["codded"][$z];
			$denominacion=$data["dended"][$z];
			$porcentaje=$data["porded"][$z];
			$sccuenta=$data["sc_cuenta"][$z];
			$denocuenta=$data["denominacion"][$z];
			$deducible=number_format($data["monded"][$z],2,',','.');
			$formula=$data["formula"][$z];
			$islr=$data["islr"][$z];
			$iva=$data["iva"][$z];
			$estretmun=$data["estretmun"][$z];
 		    if ($islr==1)
			   {
				 $tipodeduccion="S";
		       }
			else
			if ($iva==1)
			   {
			     $tipodeduccion="I";
			   }
			else
			if ($estretmun==1)
			   {
			     $tipodeduccion="M";
			   } 		
		    print "<td style=text-align:center><a href=\"javascript: aceptar('$codigo','$denominacion','$porcentaje','$sccuenta','$denocuenta','$deducible','$formula','$tipodeduccion');\">".$codigo."</a></td>";
			print "<td style=text-align:left>".$denominacion."</td>";
			print "<td style=text-align:right>".$sccuenta."</td>";
			print "<td style=text-align:right width=100>".$deducible."</td>";
			print "<td style=text-align:center>".$formula."</td>";
			print "</tr>";			
		}//End del For...
print "</table>";
$io_sql->free_result($rs_deduc);
}//End del if($row=$io_sql->fetch_row($rs_deduc))... 
else
   {
   ?>
    <script language="javascript">
	alert("No se han creado Deducciones !!!");
	close();
	</script>
   <?php
   }
?>
  </div>
</body>
<script language="JavaScript">
  function aceptar(codigo,denominacion,porcentaje,cuenta,denocuenta,deducible,formula,tipodeduccion)
  {
    opener.document.form1.txtcodigo.value=codigo;
	opener.document.form1.txtcodigo.readOnly=true;
    opener.document.form1.txtdenominacion.value=denominacion;
	opener.document.form1.txtporcentaje.value=porcentaje;
	opener.document.form1.txtcuentaplan.value=cuenta;
    opener.document.form1.txtdencuentaplan.value=denocuenta;
	if (tipodeduccion=="S")
	   {
	     opener.document.form1.radiotipodeduccion[0].checked=true;
	   }
	else   
	if (tipodeduccion=="I")
	   {
	    opener.document.form1.radiotipodeduccion[1].checked=true;
	   }
	else   
    if (tipodeduccion=="M")
	   {
	     opener.document.form1.radiotipodeduccion[2].checked=true;
	   }
	opener.document.form1.txtdeducible.value=deducible;
	opener.document.form1.txtformula.value=formula;
	close();
  }
</script>
</html>