<?php
    session_start();   
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "location.href='../sigesp_inicio_sesion.php'";
		print "</script>";		
	}
	require_once("class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	$ls_logusr=$_SESSION["la_logusr"];
	$io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_r_listadobanco.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	require_once("sigesp_sno.php");
	$io_sno=new sigesp_sno();
	$li_suspendidos=$io_sno->uf_select_config("SNO","CONFIG","EXCLUIR_SUSPENDIDOS","0","I");
	$ls_reporte=$io_sno->uf_select_config("SNR","REPORTE","LISTADO_BANCO","sigesp_snorh_rpp_listadobanco.php","C");
	unset($io_sno);
	$ls_ruta="txt/general/";
	@mkdir($ls_ruta,0755);
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
<title >Reporte Consolidado de  Listado al Banco</title>
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
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/validaciones.js"></script>
<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
<link href="css/nomina.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
	$ls_operacion=$io_fun_nomina->uf_obteneroperacion();
	require_once("sigesp_sno_c_metodo_banco.php");
	$io_metodobanco=new sigesp_sno_c_metodo_banco();
	switch ($ls_operacion) 
	{
		case "GENDISK":
			$ls_codmet=$_POST["txtcodmet"];
			$ls_desmet=rtrim($_POST["txtdesmet"]);
			$ls_codban=$_POST["txtcodban"];
			$ls_nomban=$_POST["txtnomban"];
			$ld_fecpro=$_POST["txtfecpro"];
			$ls_codcue=$_POST["txtcodcue"];
			//$ls_quincena=$_POST["cmdquincena"];
			$ls_quincena=$_POST["cmdquincena"];
			$ls_sc_cuenta=$_POST["txtsc_cuenta"];
			$ls_ctaban=$_POST["txtctaban"];
			$ls_ref=$_POST["txtref"]; 
			$ld_monto=0; // ojo monto a pagar
			$ls_suspendidos=$_POST["txtsuspendidos"];
			$ld_fecdes=$_POST["txtfecdesper"];
			$ld_fechas=$_POST["txtfechasper"];
			$ls_codnomdes=$_POST["txtcodnomdes"];
			$ls_codnomhas=$_POST["txtcodnomhas"];
			$ls_codperdes=$_POST["txtperdes"];
			$ls_codperhas=$_POST["txtperhas"];
			$ls_pagtaqnom=$io_fun_nomina->uf_obtenervalor("chkpagtaqnom","0");
			switch(substr($ld_fechas,3,2))
			{
				case "01":
					$ls_mes="ENERO";
					break;
				case "02":
					$ls_mes="FEBRERO";
					break;
				case "03":
					$ls_mes="MARZO";
					break;
				case "04":
					$ls_mes="ABRIL";
					break;
				case "05":
					$ls_mes="MAYO";
					break;
				case "06":
					$ls_mes="JUNIO";
					break;
				case "07":
					$ls_mes="JULIO";
					break;
				case "08":
					$ls_mes="AGOSTO";
					break;
				case "09":
					$ls_mes="SEPTIEMBRE";
					break;
				case "10":
					$ls_mes="OCTUBRE";
					break;
				case "11":
					$ls_mes="NOVIEMBRE";
					break;
				case "12":
					$ls_mes="DICIEMBRE";
					break;
			}
			$ls_desope=$ls_mes." DEL ".substr($ld_fechas,0,4);
			$ls_peractnom="000";
			$ls_anocurnom=substr($ld_fechas,6,4);
			$lb_valido=$io_metodobanco->uf_listadobanco_gendisk_consolidado($ls_codban,$ls_suspendidos,$ls_quincena,$ls_codnomdes,
																			$ls_codnomhas,$ls_codperdes,$ls_codperhas,$ls_pagtaqnom,
																			$ls_anocurnom,&$rs_data);
			if($lb_valido)
			{
				$lb_valido=$io_metodobanco->uf_load_montototal_consolidado($ls_codban,$ls_suspendidos,$ls_quincena,$ls_codnomdes,
																		   $ls_codnomhas,$ls_codperdes,$ls_codperhas,$ls_pagtaqnom,
																		   $ls_anocurnom,$ld_monto);
			}
			if($lb_valido)
			{
				//$ds_banco=$io_metodobanco->DS;
				$ds_banco=$rs_data;
				$lb_valido=$io_metodobanco->uf_metodo_banco($ls_ruta,$ls_desmet,$ls_peractnom,$ld_fecdes,$ld_fechas,$ld_fecpro,
															$ld_monto,$ls_codcue,$ds_banco,$ls_codmet,$ls_desope,$ls_quincena,
															$ls_ref,$la_seguridad);
			}
			break;
			
		default:
			$ls_codmet="";
			$ls_desmet="";
			$ls_codban="";
			$ls_nomban="";
			$ls_codcue="";
			$ld_fecpro="";
			$ls_sc_cuenta="";
			$ls_ctaban="";
			$ls_pagtaqnom="0";
			break;
	}
	unset($io_metodobanco);
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
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>
  <tr>
    <td height="20" width="25" class="toolbar"><div align="center"><a href="javascript:ue_print();"><img src="../shared/imagebank/tools20/imprimir.gif" title="Imprimir" alt="Imprimir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_gendisk();"><img src="../shared/imagebank/tools20/gendisk.jpg" title="Generar" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_descargar('<?php print $ls_ruta;?>');"><img src="../shared/imagebank/tools20/download.gif" title="Descargar" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_cerrar();"><img src="../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><img src="../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20"></div></td>
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
<table width="650" height="138" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
  <tr>
    <td height="136">
      <p>&nbsp;</p>
      <table width="600" border="0" align="center" cellpadding="1" cellspacing="0" class="formato-blanco">
        <tr class="titulo-ventana">
          <td height="20" colspan="6" class="titulo-ventana">Reporte Consolidado de Listado al Banco </td>
        </tr>
        <tr>
          <td height="61"><div align="right">Quincena</div></td>
          <td><div align="left">
             <select name="cmdquincena" id="cmdquincena">
              <option value="1">Primera Quincena</option>
              <option value="2">Segunda Quincena</option>
			  <option value="3" selected>Ninguno</option>
              <option value="3" selected>Mes Completo</option>
            </select>
          </div>        
          <td colspan="2"><div align="left">La Primera y Segunda Quincena son para aquellas N&oacute;minas que estan configuradas como mensuales y pagan adelato de Quincena o Dividen los Conceptos en Quincena</div> 
        </tr>
        <tr style="display:none">
          <td height="21"><div align="right">Reporte en
            
          </div></td>
          <td ><div align="left">
            <select name="cmbbsf" id="cmbbsf">
              <option value="0" selected>Bs.</option>
              <option value="1">Bs.F.</option>
            </select>        
          </div>
          <td>        
          <td>        </tr>
        <tr>
          <td height="30"><div align="right">N&oacute;mina Desde </div></td>
          <td width="171"><div align="left">
            <input name="txtcodnomdes" type="text" id="txtcodnomdes" size="13" maxlength="10" readonly>
            <a href="javascript: ue_buscarnominadesde();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a>          </div>
          <td width="105"><div align="right">N&oacute;mina Hasta </div>
          <td width="157"><div align="left">
            <input name="txtcodnomhas" type="text" id="txtcodnomhas" size="13" maxlength="10" readonly>
          <a href="javascript: ue_buscarnominahasta();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a> </div>        </tr>
		<tr>
		  <td height="22" colspan="4"><div align="center">Este filtro no sera tomado en cuenta para generar el txt </div></td>
		  </tr>
		<tr>
          <td height="20"><div align="right"> Subn&oacute;mina Desde </div></td>
          <td height="20"><input name="txtcodsubnomdes" type="text" id="txtcodsubnomdes" size="13" maxlength="10" value="" readonly>
            <a href="javascript: ue_buscarsubnominadesde();"><img id="personal" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a></td>
          <td height="20"><div align="right">Subn&oacute;mina Hasta </div></td>
          <td height="20"><input name="txtcodsubnomhas" type="text" id="txtcodsubnomhas" value="" size="13" maxlength="10" readonly>
            <a href="javascript: ue_buscarsubnominahasta();"><img id="personal" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a></td>
        </tr>
        <tr>
          <td height="22"><div align="right">Periodo Desde </div></td>
          <td><div align="left">
            <input name="txtperdes" type="text" id="txtperdes" size="6" maxlength="3" readonly>
            <a href="javascript: ue_buscarperiododesde();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" name="periodo" width="15" height="15" border="0" id="periodo"></a>          
            <input name="txtfecdesper" type="hidden" id="txtfecdesper">
          </div>
          <td><div align="right">Periodo Hasta          </div>
          <td><div align="left">
            <input name="txtperhas" type="text" id="txtperhas" size="6" maxlength="3" readonly>
            <a href="javascript: ue_buscarperiodohasta();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" name="periodo" width="15" height="15" border="0" id="periodo"></a>
            <input name="txtfechasper" type="hidden" id="txtfechasper">
          </div>        </tr>
        <tr>
          <td width="157" height="22"><div align="right">M&eacute;todo a Banco </div></td>
          <td colspan="3"><div align="left">
            <input name="txtcodmet" type="text" id="txtcodmet" size="8" maxlength="4" readonly>
            <a href="javascript: ue_buscarmetodobanco();"><img id="metodobanco" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a>
            <input name="txtdesmet" type="text" class="sin-borde" id="txtdesmet" size="50" maxlength="100" readonly>
            <input name="chkpagtaqnom" type="hidden" id="chkpagtaqnom" value="<?php print $ls_pagtaqnom;?>">
			<input name="txtref" type="hidden" id="txtref">
          </div></tr>
		  <tr>
            <td width="157" height="22"><div align="right">Pago Por Taquilla</div></td>
	   <td> <input name="chkpagtaqnom" type="checkbox" id="chkpagtaqnom"  value='1' <?php if($ls_pagtaqnom==1){ print "checked"; }?> ></td>

</tr>
        <tr>
          <td height="22"><div align="right">Banco</div></td>
          <td colspan="3">        <div align="left">
            <input name="txtcodban" type="text" id="txtcodban" size="6" maxlength="3" readonly>
            <a href="javascript: ue_buscarbanco();"><img id="banco" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a>
            <input name="txtnomban" type="text" class="sin-borde" id="txtnomban" size="40" maxlength="30" readonly>
          </div></tr>
        <tr>
          <td height="22"><div align="right">Cuenta</div></td>
          <td colspan="3"><div align="left"><input name="txtcodcue" type="text" id="txtcodcue" size="30" maxlength="50" readonly>
            <a href="javascript: ue_buscarcuentabanco();"><img id="cuenta" src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a>
            <input name="txtsc_cuenta" type="hidden" id="txtsc_cuenta" value="<?php print $ls_sc_cuenta;?>">
            <input name="txtctaban" type="hidden" id="txtctaban" value="<?php print $ls_ctaban;?>">
          </div></tr>
        <tr>
          <td height="22"><div align="right">Fecha de Procesamiento </div></td>
          <td colspan="3"><div align="left">
            <input name="txtfecpro" type="text" id="txtfecpro" onKeyDown="javascript:ue_formato_fecha(this,'/',patron,true,event);" onBlur="javascript: ue_validar_formatofecha(this);" size="15" maxlength="10" datepicker="true">
          </div></tr>
        <tr class="titulo-celdanew">
          <td height="20" colspan="6"><div align="right" class="titulo-celdanew">Ordenado por </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">C&oacute;digo del Personal</div></td>
          <td colspan="5"><div align="left">
            <input name="rdborden" type="radio" class="sin-borde" value="1" checked>
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">Apellido del Personal </div></td>
          <td colspan="5"><div align="left">
            <input name="rdborden" type="radio" class="sin-borde" value="2">
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">Nombre del Personal </div></td>
          <td colspan="5"><div align="left">
            <input name="rdborden" type="radio" class="sin-borde" value="3">
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right">C&eacute;dula del Personal </div></td>
          <td colspan="5"><div align="left">
            <input name="rdborden" type="radio" class="sin-borde" value="$">
          </div></td>
        </tr>
        <tr>
          <td height="22"><div align="right"><a href="sigesp_sno_cat_directorio.php" target="_blank"></a></div></td>
          <td colspan="5"><div align="right">
            <input name="operacion" type="hidden" id="operacion">
            <input name="txtsuspendidos" type="hidden" id="txtsuspendidos" value="<?php print $li_suspendidos;?>">
            <input name="reporte" type="hidden" id="reporte" value="<?php print $ls_reporte;?>">
			</div></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
</form>      
<p>&nbsp;</p>
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
		reporte=f.reporte.value;
		codban=f.txtcodban.value;
		susp=f.txtsuspendidos.value;
		//quincena=f.cmdquincena.value;
		quincena=f.cmdquincena.value;
		sc_cuenta=f.txtsc_cuenta.value;
		ctaban=f.txtctaban.value;
		fecpro=f.txtfecpro.value;
		codcue=f.txtcodcue.value;
		codnomdes=f.txtcodnomdes.value;
		codnomhas=f.txtcodnomhas.value;
		codsubnomdes=f.txtcodsubnomdes.value;
		codsubnomhas=f.txtcodsubnomhas.value;
		codperdes=f.txtperdes.value;
		codperhas=f.txtperhas.value;
		tiporeporte=f.cmbbsf.value;
		if((codnomdes!="")&&(codnomhas!="")&&(codperdes!="")&&(codperhas!="")&&(codban!="")&&(ctaban!=""))
		{
			orden="";
			if(f.rdborden[0].checked)
			{
				orden="1";
			}
			if(f.rdborden[1].checked)
			{
				orden="2";
			}
			if(f.rdborden[2].checked)
			{
				orden="3";
			}
			if(f.rdborden[3].checked)
			{
				orden="4";
			}
			pagina="reportes/"+reporte+"?codban="+codban+"&susp="+susp+"&quincena="+quincena+"&sc_cuenta="+sc_cuenta;
			pagina=pagina+"&codnomdes="+codnomdes+"&codnomhas="+codnomhas+"&codperdes="+codperdes+"&codperhas="+codperhas;
			pagina=pagina+"&ctaban="+ctaban+"&fecpro="+fecpro+"&orden="+orden+"&codcue="+codcue+"&tiporeporte="+tiporeporte;
			pagina=pagina+"&codsubnomdes="+codsubnomdes+"&codsubnomhas="+codsubnomhas;
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,left=0,top=0,location=no,resizable=yes");
		}
		else
		{
			alert("Debe seleccionar las n�minas, los per�odos, un banco y una cuenta.");
		}
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}		
}

function ue_gendisk()
{
	f=document.form1;
	li_procesar=f.ejecutar.value;
	if(li_procesar==1)
	{	
		codmet=f.txtcodmet.value;
		codban=f.txtcodban.value;
		codcue=f.txtcodcue.value;
		fecpro=f.txtfecpro.value;
		susp=f.txtsuspendidos.value;
		codnomdes=f.txtcodnomdes.value;
		codnomhas=f.txtcodnomhas.value;
		codperdes=f.txtperdes.value;
		codperhas=f.txtperhas.value;
		
		if((codnomdes!="")&&(codnomhas!="")&&(codperdes!="")&&(codperhas!="")&&(codban!="")&&(codcue!="")&&(fecpro!="")&&(codmet!=""))
		{
			f.operacion.value="GENDISK";
			f.action="sigesp_snorh_r_listadobanco.php";
			f.submit();
		}
		else
		{
			alert("Debe colocar toda la informaci�n.");
		}
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}		
}

function ue_descargar(ruta)
{
	window.open("sigesp_sno_cat_directorio.php?ruta="+ruta+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
}

function ue_buscarnominadesde()
{
	f=document.form1;
	quincena=f.cmdquincena.value; 
	window.open("sigesp_snorh_cat_nomina.php?tipo=replisbandes&quincena="+quincena,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
}

function ue_buscarnominahasta()
{
	f=document.form1;	
	quincena=f.cmdquincena.value; 
	if(f.txtcodnomdes.value!="")
	{
		window.open("sigesp_snorh_cat_nomina.php?tipo=replisbanhas&quincena="+quincena,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar una n�mina desde.");
	}
}
function ue_buscarperiododesde()
{
	f=document.form1;
	codnomdes=f.txtcodnomdes.value;
	codnomhas=f.txtcodnomhas.value;
	if((codnomdes!="")&&(codnomhas!=""))
	{
		window.open("sigesp_sno_cat_hperiodo.php?tipo=replisbandes&codnom="+codnomdes+"&codnomhas="+codnomhas+"","_blank","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=200,top=200,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un rango de n�minas.");
	}
}

function ue_buscarperiodohasta()
{
	f=document.form1;
	codnomdes=f.txtcodnomdes.value;
	codnomhas=f.txtcodnomhas.value;
	if((codnomdes!="")&&(codnomhas!="")&&(f.txtperdes.value!=""))
	{
		window.open("sigesp_sno_cat_hperiodo.php?tipo=replisbanhas&codnom="+codnomdes+"&codnomhas="+codnomhas+"","_blank","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=200,top=200,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un rango de n�minas y aun per�odo desde.");
	}
}

function ue_buscarmetodobanco()
{
	window.open("sigesp_snorh_cat_metodobanco.php?tipo=repconlisban","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
}

function ue_buscarbanco()
{
	codnomdes=f.txtcodnomdes.value;
	codnomhas=f.txtcodnomhas.value;
	if((codnomdes!="")&&(codnomhas!=""))
	{
		window.open("sigesp_snorh_cat_banco.php?tipo=repconlisban&codnomdes="+codnomdes+"&codnomhas="+codnomhas+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un rango de n�minas.");
	}
}

function ue_buscarcuentabanco()
{
	f=document.form1;
	if(f.txtcodban.value!="")
	{
		window.open("sigesp_snorh_cat_cuentabanco.php?codban="+f.txtcodban.value+"&tipo=replisban","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar un banco.");
	}
}

function ue_buscarsubnominadesde()
{
	f=document.form1;
	codnomdes=f.txtcodnomdes.value;
	codnomhas=f.txtcodnomhas.value;
	if((codnomdes==codnomhas)&&(codnomdes!=""))
	{
		window.open("sigesp_snorh_cat_subnomina.php?tipo=reportedesde&codnom="+codnomdes,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Para filtrar por Subn�minas La n�mina desde y hasta debe ser la misma.");
	}
}

function ue_buscarsubnominahasta()
{
	f=document.form1;
	codsubnomdes=f.txtcodsubnomdes.value;
	codnomdes=f.txtcodnomdes.value;
	if(codsubnomdes!="")
	{
		window.open("sigesp_snorh_cat_subnomina.php?tipo=reportehasta&codnom="+codnomdes,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
	}
	else
	{
		alert("Debe seleccionar una subn�mina desde.");
	}
}
</script> 
</html>