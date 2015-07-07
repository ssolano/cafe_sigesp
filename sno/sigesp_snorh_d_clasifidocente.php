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
	require_once("class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	$io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_d_clasifidocente.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////

   //--------------------------------------------------------------
   function uf_limpiarvariables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_limpiarvariables
		//		   Access: private
		//	  Description: Funci�n que limpia todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
   		global $ls_codescdoc,$ls_desescdoc,$ls_codcladoc,$ls_descladoc,$ls_tiesercladoc,$li_suesupcladoc;
		global $li_suedircladoc,$li_suedoccladoc,$io_fun_nomina,$ls_existe,$ls_operacion;
		
		$ls_codescdoc="";
		$ls_desescdoc="";
		$ls_codcladoc="";
		$ls_descladoc="";
		$ls_tiesercladoc="";
		$li_suesupcladoc=0;
		$li_suedircladoc=0;
		$li_suedoccladoc=0;
		$ls_operacion =$io_fun_nomina->uf_obteneroperacion();
		$ls_existe=$io_fun_nomina->uf_obtenerexiste();
   }
   //--------------------------------------------------------------

   //--------------------------------------------------------------
   function uf_load_variables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_variables
		//		   Access: private
		//	  Description: Funci�n que carga todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 18/03/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
   		global $ls_codescdoc, $ls_desescdoc, $ls_codcladoc,$ls_descladoc,$ls_tiesercladoc,$li_suesupcladoc;
		global $li_suedircladoc,$li_suedoccladoc;
		
		$ls_codescdoc=$_POST["txtcodescdoc"];
		$ls_desescdoc=$_POST["txtdesescdoc"];
		$ls_codcladoc=$_POST["txtcodcladoc"];
		$ls_descladoc=$_POST["txtdescladoc"];
		$ls_tiesercladoc=$_POST["txttiesercladoc"];
		$li_suesupcladoc=$_POST["txtsuesupcladoc"];
		$li_suedircladoc=$_POST["txtsuedircladoc"];
		$li_suedoccladoc=$_POST["txtsuedoccladoc"];
   }
   //--------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<script language="javascript">
	if(document.all)
	{ //ie 
		document.onkeydown = function(){ 
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey)){
		window.event.keyCode = 505; 
		}
		if(window.event.keyCode == 505){ 
		return false; 
		} 
		} 
	}
</script>
<title >Definici&oacute;n de Clasificaci&oacute;n Docente</title>
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
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/funcion_nomina.js"></script>
<link href="css/nomina.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
	require_once("sigesp_snorh_c_clasifidocente.php");
	$io_clasificaciondocente=new sigesp_snorh_c_clasifidocente();
	uf_limpiarvariables();	
	switch ($ls_operacion) 
	{
		case "NUEVO":
		 	$ls_codescdoc=$_GET["codescdoc"];
			$ls_desescdoc=$_GET["desescdoc"];
			break;

		case "GUARDAR":
			uf_load_variables();
			$lb_valido=$io_clasificaciondocente->uf_guardar($ls_existe,$ls_codescdoc,$ls_codcladoc,$ls_descladoc,$ls_tiesercladoc,$li_suesupcladoc,
											 $li_suedircladoc,$li_suedoccladoc,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
				$ls_codescdoc=$_POST["txtcodescdoc"];
				$ls_desescdoc=$_POST["txtdesescdoc"];
			}
			break;

		case "ELIMINAR":
			uf_load_variables();
			$lb_valido=$io_clasificaciondocente->uf_delete_clasifidocente($ls_codescdoc,$ls_codcladoc,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
				$ls_codescdoc=$_POST["txtcodescdoc"];
				$ls_desescdoc=$_POST["txtdesescdoc"];
			}
			break;
	}
	$io_clasificaciondocente->uf_destructor();
	unset($io_clasificaciondocente);
?>
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td width="780" height="30" colspan="11" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="432" height="20" colspan="11" bgcolor="#E7E7E7">
		<table width="762" border="0" align="center" cellpadding="0" cellspacing="0">
			<td width="432" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Sistema de N�mina</td>
			<td width="346" bgcolor="#E7E7E7" class="letras-pequenas"><div align="right"><b><?php print date("j/n/Y")." - ".date("h:i a");?></b></div></td>
	  	    <tr>
	  	      <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	      <td bgcolor="#E7E7E7" class="letras-pequenas"><div align="right"><b><?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td></tr>
        </table>
	 </td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>
  <tr>
    <td height="20" width="25" class="toolbar"><div align="center"><a href="javascript: ue_nuevo();"><img src="../shared/imagebank/tools20/nuevo.gif"  title="Nuevo" alt="Nuevo" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_guardar();"><img src="../shared/imagebank/tools20/grabar.gif"  title="Guardar" alt="Grabar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_buscar();"><img src="../shared/imagebank/tools20/buscar.gif" title="Buscar" alt="Buscar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_eliminar();"><img src="../shared/imagebank/tools20/eliminar.gif" title="Eliminar" alt="Eliminar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_volver();"><img src="../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_ayuda();"><img src="../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="530">&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<form name="form1" method="post" action="">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_nomina->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigesp_snorh_d_escaladocente.php'");
	unset($io_fun_nomina);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>		  
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
  <tr>
    <td height="136">
      <p>&nbsp;</p>
      <table width="550" border="0" align="center" cellpadding="1" cellspacing="0" class="formato-blanco">
        <tr>
          <td colspan="2"><input name="txtdesescdoc" type="text" class="sin-borde2" id="txtdesescdoc" value="<?php print $ls_desescdoc;?>" size="60" readonly>
            <input name="txtcodescdoc" type="hidden" id="txtcodescdoc" value="<?php print $ls_codescdoc;?>"></td>
        </tr>
        <tr class="titulo-ventana">
          <td height="20" colspan="2" class="titulo-ventana">Definici&oacute;n de Clasificaci&oacute;n Docente </td>
        </tr>
        <tr>
          <td width="151" height="22">&nbsp;</td>
          <td width="305">&nbsp;</td>
        </tr>
        <tr>
          <td height="22"><div align="right">C&oacute;digo </div></td>
          <td><div align="left">
            <input name="txtcodcladoc" type="text" id="txtcodcladoc" size="7" maxlength="4" value="<?php print $ls_codcladoc;?>" onKeyUp="javascript: ue_validarnumero(this);" onBlur="javascript: ue_rellenarcampo(this,4);">
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">Descripci&oacute;n </div></td>
          <td><div align="left">
            <input name="txtdescladoc" type="text" id="txtdescladoc" size="60" maxlength="100" value="<?php print $ls_descladoc;?>" onKeyUp="ue_validarcomillas(this);">
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">Tiempo de Servicio </div></td>
          <td>
            <div align="left">
              <input name="txttiesercladoc" type="text" id="txttiesercladoc" value="<?php print $ls_tiesercladoc;?>" size="60" maxlength="100" onKeyUp="ue_validarcomillas(this);">
              </div></td></tr>
        <tr>
          <td height="22"><div align="right">Sueldo Supervisores</div></td>
          <td>
            <div align="left">
              <input name="txtsuesupcladoc" type="text" id="txtsuesupcladoc" value="<?php print $li_suesupcladoc;?>" size="23" maxlength="20" style="text-align:right" onKeyPress="return(ue_formatonumero(this,'.',',',event))">
              </div></td></tr>
        <tr>
          <td height="22"><div align="right">Sueldo Dir/Sub-Dir/Coordinador</div></td>
          <td>
            <div align="left">
              <input name="txtsuedircladoc" type="text" id="txtsuedircladoc" value="<?php print $li_suedircladoc;?>" size="23" maxlength="20" style="text-align:right" onKeyPress="return(ue_formatonumero(this,'.',',',event))">
              </div></td></tr>
        <tr>
          <td height="22"><div align="right">Sueldo Docente Aula </div></td>
          <td>
            <div align="left">
              <input name="txtsuedoccladoc" type="text" id="txtsuedoccladoc" value="<?php print $li_suedoccladoc;?>" size="23" maxlength="20" style="text-align:right" onKeyPress="return(ue_formatonumero(this,'.',',',event))">
              </div></td></tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="operacion" type="hidden" id="operacion">
            <input name="existe" type="hidden" id="existe" value="<?php print $ls_existe;?>"></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
</form>      
<p>&nbsp;</p>
</body>
<script language="javascript">
function ue_nuevo()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{	
		f.operacion.value="NUEVO";
		f.existe.value="FALSE";		
		codescdoc=ue_validarvacio(f.txtcodescdoc.value);
		desescdoc=ue_validarvacio(f.txtdesescdoc.value);
		f.action="sigesp_snorh_d_clasifidocente.php?codescdoc="+codescdoc+"&desescdoc="+desescdoc;
		f.submit();
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_guardar()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_existe=f.existe.value;
	if(((lb_existe=="TRUE")&&(li_cambiar==1))||(lb_existe=="FALSE")&&(li_incluir==1))
	{
		codescdoc=ue_validarvacio(f.txtcodescdoc.value);
		codcladoc=ue_validarvacio(f.txtcodcladoc.value);
		descladoc=ue_validarvacio(f.txtdescladoc.value);
		tiesercladoc=ue_validarvacio(f.txttiesercladoc.value);
		suesupcladoc=ue_validarvacio(f.txtsuesupcladoc.value);
		suedircladoc=ue_validarvacio(f.txtsuedircladoc.value);
		suedoccladoc=ue_validarvacio(f.txtsuedoccladoc.value);
		if ((codescdoc!="")&&(codcladoc!="")&&(descladoc!="")&&(tiesercladoc!="")&&(suesupcladoc!="")&&(suedircladoc!="")&&(suedoccladoc!=""))
		{
			f.operacion.value="GUARDAR";
			f.action="sigesp_snorh_d_clasifidocente.php";
			f.submit();
		}
		else
		{
			alert("Debe llenar todos los datos.");
		}
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_eliminar()
{
	f=document.form1;
	li_eliminar=f.eliminar.value;
	if(li_eliminar==1)
	{	
		if(f.existe.value=="TRUE")
		{
			codescdoc=ue_validarvacio(f.txtcodescdoc.value);
			codcladoc=ue_validarvacio(f.txtcodcladoc.value);
			if ((codescdoc!="")&&(codcladoc!=""))
			{
				if(confirm("�Desea eliminar el Registro actual?"))
				{
					f.operacion.value="ELIMINAR";
					f.action="sigesp_snorh_d_clasifidocente.php";
					f.submit();
				}
			}
			else
			{
				alert("Debe buscar el registro a eliminar.");
			}
		}
		else
		{
			alert("Debe buscar el registro a eliminar.");
		}
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}
}

function ue_cerrar()
{
	location.href = "sigespwindow_blank.php";
}

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
   	{
		codescdoc=ue_validarvacio(f.txtcodescdoc.value);
		window.open("sigesp_snorh_cat_clasifidocente.php?codescdoc="+codescdoc+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}
}

function ue_ayuda()
{
	width=(screen.width);
	height=(screen.height);
	//window.open("../hlp/index.php?sistema=SNO&subsistema=SNR&nomfis=sno/sigesp_hlp_snr_escaladocente.php","Ayuda","menubar=no,toolbar=no,scrollbars=yes,width="+width+",height="+height+",resizable=yes,location=no");
}

function ue_volver()
{
	f=document.form1;
	f.operacion.value="BUSCAR";
	f.existe.value="TRUE";	
	codescdoc=ue_validarvacio(f.txtcodescdoc.value);
	f.action="sigesp_snorh_d_escaladocente.php?codescdoc="+codescdoc;
	f.submit();
}
</script> 
</html>