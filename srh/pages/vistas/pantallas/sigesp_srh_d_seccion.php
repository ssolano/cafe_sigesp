<?php
session_start();
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if(!array_key_exists("la_logusr",$_SESSION))
{
	print "<script language=JavaScript>";
	print "location.href='../sigesp_inicio_sesion.php'";
	print "</script>";		
}
$ls_logusr=$_SESSION["la_logusr"];
require_once("../../../class_folder/utilidades/class_funciones_srh.php");
$io_fun_srh=new class_funciones_srh('../../../../');
$io_fun_srh->uf_load_seguridad("SRH","sigesp_srh_d_seccion.php",$ls_permisos,$la_seguridad,$la_permisos);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title >Definici&oacute;n de Secciones</title>
<meta http-equiv="imagetoolbar" content="no"> 
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #EFEBEF;
}

a:link {
	color: #006699;
}
a:visited {
	color: #006699;
}
a:active {
	color: #006699;
}

-->
</style>
<script type="text/javascript" language="JavaScript1.2" src="../../../public/js/librerias_comunes.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../../js/sigesp_srh_js_seccion.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../../../../sno/js/funcion_nomina.js"></script>

<style type="text/css">
<!--
.style1 {color: #EBEBEB}
-->
</style>
</head>
<body onLoad="javascript: ue_nuevo();">
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td height="30" colspan="11" class="cd-logo"><img src="../../../public/imagenes/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="432" height="20" colspan="11" bgcolor="#E7E7E7">
		<table width="762" border="0" align="center" cellpadding="0" cellspacing="0">
			  <td width="432" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Sistema de Recursos Humanos</td>
			    <td width="346" bgcolor="#E7E7E7"><div align="right"><span class="letras-pequenas"><b><?PHP print date("j/n/Y")." - ".date("h:i a");?></b></span></div></td>
				<tr>
	  	      <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	      <td bgcolor="#E7E7E7" class="letras-pequenas"><div align="right"><b><?PHP print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td> </tr>
	  	</table>
	 </td>
  </tr>
 <tr>
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="../../js/menu/menu.js"></script></td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>

  <tr>
    <td height="20" width="20" class="toolbar"><div align="center"><a href="javascript: ue_nuevo();"><img src="../../../public/imagenes/nuevo.gif" alt="Nuevo" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="22"><div align="center"><a href="javascript: ue_guardar();"><img src="../../../public/imagenes/grabar.gif" alt="Grabar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="22"><div align="center"><a href="javascript: ue_buscar();"><img src="../../../public/imagenes/buscar.gif" alt="Buscar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="24"><div align="center"><a href="javascript: ue_eliminar();"><img src="../../../public/imagenes/eliminar.gif" alt="Eliminar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="24"><div align="center"><a href="javascript: ue_cerrar();"><img src="../../../public/imagenes/salir.gif" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="24"><div align="center"><img src="../../../public/imagenes/ayuda.gif" alt="Ayuda" width="20" height="20"></div></td>
    <td class="toolbar" width="24"><div align="center"></div></td>
    <td class="toolbar" width="618">&nbsp;</td>
  </tr>
</table>



<p>&nbsp;</p>
<div align="center">
  <table width="655" height="211" border="0" class="formato-blanco">
    <tr>
      <td width="649" height="207"><div align="left">
          <form name="form1" method="post" action="">
  <?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_srh->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_srh);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>

<table width="621" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">

  <tr>
    <td colspan="3" class="titulo-ventana">Definici&oacute;n de Secci&oacute;n</td>
  </tr>
  <tr class="formato-blanco">
    <td width="137" height="19">&nbsp;</td>
    
    <td colspan="2"></td>
  </tr>
  <tr class="formato-blanco">
    <td height="29"><div align="right">C&oacute;digo</div></td>
    <td width="159" height="29"><input name="txtcodsec" type="text" id="txtcodsec"  size="16" maxlength="15"  onBlur="javascript: ue_rellenarcampo(this,15); ue_validaexiste();"   onKeyUp="javascript: ue_validarnumero(this); ue_validarcomillas(this);"   style="text-align:center ">
    <input name="hidstatus" type="hidden" id="hidstatus">  </td>
    <td width="325" ><div id="existe" style="display:none"></div></td>
  </tr>
  <tr class="formato-blanco">
    <td height="28"><div align="right">Denominaci&oacute;n</div></td>
    <td height="28" colspan="2"><input name="txtdensec" type="text" id="txtdensec" onKeyUp="ue_validarcomillas(this);" size="60" maxlength="254"></td>
  </tr>
  
  <tr class="formato-blanco"> 
 <td height="28"><div align="right">Departamento</div></td>
  <td height="28" valign="middle" width="159"><input name="txtcoddep" type="text" id="txtcoddep"  size="16" maxlength="15" style="text-align:center" readonly>
          <a href="javascript:catalogo_departamento();"><img src="../../../public/imagenes/buscar.gif" alt="Cat&aacute;logo Departamento" name="buscartip" width="15" height="15" border="0" id="buscartip"></a></td>
         <td> <input name="txtdendep" type="text" class="sin-borde" id="txtdendep" size="40" maxlength="80" readonly></td>
  </tr>
</table>

            <input name="operacion" type="hidden" id="operacion">
     
          </form>
      </div>      </td>
    </tr>
  </table>
<span class="style1">a</span></div>


<div align="center" class="style1" id="mostrar" ></div>
<p align="center">&nbsp;</p>
</body>


<script language="javascript">
//Funciones de operaciones 


function catalogo_departamento()
{
      f= document.form1;
      ls_coddep = f.txtcoddep.value;   
  
   pagina="../catalogos/sigesp_srh_cat_departamento.php?valor_cat=0&tipo=1";
  
  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=520,height=400,resizable=yes,location=no,dependent=yes");
}

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if(li_leer==1)
	{
		window.open("../catalogos/sigesp_srh_cat_seccion.php?valor_cat=1","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
		
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}
}



function ue_cerrar()
{
	window.location.href="sigespwindow_blank.php";
}



</script> 
</html>
