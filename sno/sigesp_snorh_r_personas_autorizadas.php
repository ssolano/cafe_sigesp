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
	$io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_r_personas_autorizadas.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$ld_fecdes="01/01/".date('Y');
	$ld_fechas=date('d/m/Y');
	
	require_once("sigesp_sno.php");
	$io_sno=new sigesp_sno();
	$ls_reporte=$io_sno->uf_select_config("SNR","REPORTE","PAGOS_AUTORIZADOS","sigesp_snorh_rpp_personas_autorizadas.php","C");
	unset($io_sno);
	///////////////// PAGINACION ///////////////////////////////////////////////////////////////////////////////////////////////
	$li_registros = 3500;
	$ls_codperdes="";
	$ls_codperhas="";
	$li_pagina=$io_fun_nomina->uf_obtenervalor_get("pagina",0); 
	if (!$li_pagina)
	{ 
		$li_inicio = 0; 
		$li_pagina = 1; 
	} 
	else 
	{ 
		$li_inicio = ($li_pagina - 1) * $li_registros; 
	} 
	$li_totpag=0;	
	require_once("sigesp_sno_c_pagonomina.php");
	$io_pagonomina=new sigesp_sno_c_pagonomina();
	$ls_valor=0;
	$io_pagonomina->uf_buscar_beneficiario($ls_valor,$li_inicio,$li_registros,$li_totpag,$ls_codperdes,$ls_codperhas);
	if ($ls_valor<$li_registros)
	{
	  $ls_codperhas="";
	  $ls_codperdes="";
	}		
	///////////////// PAGINACION   /////////////////////////////////////////////////////////////////////////////////////////////
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
<title >Reporte Pagos Autorizados</title>
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
<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<link href="css/nomina.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
</head>

<body>
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
        </table>	 </td>
  </tr>
  <tr>
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>
  <tr>
    <td height="20" width="25" class="toolbar"><div align="center"><a href="javascript: ue_print();"><img src="../shared/imagebank/tools20/imprimir.gif" title="Imprimir" alt="Imprimir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_openexcel();"></a><a href="javascript: ue_cerrar();"><img src="../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><img src="../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
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
	$io_fun_nomina->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_nomina);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>		  
<table width="600" height="138" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
  <tr>
    <td height="136">
       <p>
         <input name="reporte" type="hidden" id="reporte"  value="<?php print  $ls_reporte; ?>"></p>
       <p>&nbsp;</p>
       <table width="550" border="0" align="center" cellpadding="1" cellspacing="0" class="formato-blanco">
        <tr class="titulo-ventana">
          <td height="20" colspan="5" class="titulo-ventana">Reporte Pagos Autorizados </td>
        </tr>
     	<tr>
		<?php
		if ($ls_valor>$li_registros)
		{		
			print "<center>";
			if(($li_pagina - 1) > 0) 
			{
				print "<a href='sigesp_snorh_r_personas_autorizadas.php?&pagina=".($li_pagina-1)."'>< Anterior</a> ";
			}
			for ($li_i=1; $li_i<=$li_totpag; $li_i++)
			{ 
				if ($li_pagina == $li_i) 
				{
					print "<b>".$li_pagina."</b> "; 
				}
				else
				{
					print "<a href='sigesp_snorh_r_personas_autorizadas.php?&pagina=".($li_i)."'>$li_i</a> "; 
				}
			}
			if(($li_pagina + 1)<=$li_totpag) 
			{
				print " <a href='sigesp_snorh_r_personas_autorizadas.php?&pagina=".($li_pagina+1)."'>Siguiente ></a>";
			}
			
			print "</center>";
		}		
		?>
		</tr>
        <tr>
          <td height="20" colspan="5" class="titulo-celdanew">Intervalo de Personal </td>
          </tr>
        <tr>
          <td width="141" height="22"><div align="right"> Desde </div></td>
          <td width="119"><div align="left">
            <input name="txtcodperdes" type="text" id="txtcodperdes" size="13" maxlength="10" value="<?php print $ls_codperdes;?>" readonly>
            <a href="javascript: ue_buscarpersonaldesde();"><img id="personal" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a></div></td>
          <td width="104"><div align="right">Hasta </div></td>
          <td width="129" colspan="2"><div align="left">
            <input name="txtcodperhas" type="text" id="txtcodperhas" value="<?php print $ls_codperhas;?>" size="13" maxlength="10" readonly>
            <a href="javascript: ue_buscarpersonalhasta();"><img id="personal" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a></div></td>
        </tr>
        
        <tr>
          <td height="22">&nbsp;</td>
          <td colspan="4"> <div align="right"></div></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
</form>      
</body>
<script language="javascript">

var patron = new Array(2,2,4);
var patron2 = new Array(1,3,3,3,3);
function ue_cerrar()
{
	location.href = "sigespwindow_blank.php";
}

function ue_print()
{
	f=document.form1;
	li_imprimir=f.imprimir.value; 
	if(li_imprimir==1)
	{	
		codperdes=f.txtcodperdes.value;
		codperhas=f.txtcodperhas.value;
		reporte=f.reporte.value;
		if(codperdes<=codperhas)
		{				
			pagina="reportes/"+reporte+"?codperdes="+codperdes+"&codperhas="+codperhas;
			//pagina=pagina+"&codbenedes="+codbenedes+"&codbenehas="+codbenehas+"&orden="+orden;
					
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,left=0,top=0,location=no,resizable=yes");
		}
		else
		{
			alert("El rango del personal est� erroneo");
		}				
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operaci�n");
   	}		
}


function ue_buscarpersonaldesde()
{
	window.open("sigesp_snorh_cat_personal.php?tipo=replisperdes","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
}

function ue_buscarpersonalhasta()
{
	f=document.form1;
	if(f.txtcodperdes.value!="")
	{
		window.open("sigesp_snorh_cat_personal.php?tipo=replisperhas","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un personal desde.");
	}
}

function ue_buscarbenedesde()
{
   codper="";
   f=document.form1;
   codperdes=f.txtcodperdes.value;
   codperhas=f.txtcodperhas.value;
   if((codperdes!="")&&(codperhas!=""))
   {
   		window.open("sigesp_snorh_cat_beneficiario.php?tipo=benedes&codper="+codper+"&codperdes="+codperdes+"&codperhas="+codperhas+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
   }
   else
	{
		alert("Debe seleccionar un rango de personal.");
	}
}

function ue_buscarbenehasta()
{
	f=document.form1;
	codperdes=f.txtcodperdes.value;
    codperhas=f.txtcodperhas.value;
	if((f.txtcodbenedes.value!="")&&(codperdes!="")&&(codperhas!=""))
	{
		window.open("sigesp_snorh_cat_beneficiario.php?tipo=benehas&codper="+codper+"&codperdes="+codperdes+"&codperhas="+codperhas+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un Beneficiario desde.");
	}
}

</script> 
</html>