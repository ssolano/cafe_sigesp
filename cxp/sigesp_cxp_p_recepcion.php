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
	require_once("class_folder/class_funciones_cxp.php");
	$io_fun_cxp=new class_funciones_cxp();
	$io_fun_cxp->uf_load_seguridad("CXP","sigesp_cxp_p_recepcion.php",$ls_permisos,$la_seguridad,$la_permisos);
	$ls_reporte=$io_fun_cxp->uf_select_config("CXP","REPORTE","FORMATO_RECEPCION","sigesp_cxp_rfs_recepciones.php","C");
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////

   //--------------------------------------------------------------
   function uf_limpiarvariables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_limpiarvariables
		//		   Access: private
		//	  Description: Funci�n que limpia todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 17/03/2007								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
   		global $ls_estatus,$ld_fecregdoc,$ls_tipodestino,$ls_codprovben,$ls_nomprovben,$ls_codtipdoc,$io_fun_cxp;
		global $ls_operacion,$ls_existe,$ls_codcla,$ls_dencondoc,$ld_fecvendoc,$ld_fecemidoc,$ls_numref,$ls_numrecdoc;
		global $ls_codigocuenta,$ls_estatuscontable,$ls_estatuspresupuesto,$ls_codtipdoc,$li_totrowspg,$ls_procede;
		global $ls_tipocontribuyente,$li_totrowscg,$ls_estimpmun,$ls_estlibcom,$ls_parametros,$ls_estmodiva,$li_estaprord;
		global $ls_codfuefin,$ls_denfuefin;
		
		$ls_estatus="REGISTRO";
		$ld_fecregdoc=date("d/m/Y");
		$ls_codprovben="";
		$ls_nomprovben="";
		$ls_codtipdoc="";	
		$ls_tipodestino="";
		$ls_operacion=$io_fun_cxp->uf_obteneroperacion();
		$ls_existe=$io_fun_cxp->uf_obtenerexiste();
		$ls_codcla="";
		$ls_dencondoc="";
		$ld_fecvendoc=date("d/m/Y");
		$ld_fecemidoc=date("d/m/Y");
		$ls_numref="";
		$ls_numrecdoc="";		
		$ls_codigocuenta="";
		$ls_estatuscontable="";
		$ls_estatuspresupuesto="";
		$ls_codtipdoc="";
		$li_totrowspg="";
		$li_totrowscg="";
		$li_estaprord="0";
		$ls_procede="CXPRCD";
		$ls_tipocontribuyente="";
		$ls_estimpmun="1";
		$ls_estlibcom="1";
		$ls_estmodiva=$_SESSION["la_empresa"]["estmodiva"];
		$ls_parametros="";
		$ls_codfuefin="";
		$ls_denfuefin="";
   }
   //--------------------------------------------------------------

   //--------------------------------------------------------------
   function uf_load_variables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_variables
		//		   Access: private
		//	  Description: Funci�n que carga todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 29/04/2007								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
   		global $ld_fecregdoc,$ls_tipodestino,$ls_codprovben,$ls_nomprovben,$ls_codtipdoc,$io_fun_cxp;
		global $ls_operacion,$ls_existe,$ls_codcla,$ls_dencondoc,$ld_fecvendoc,$ld_fecemidoc,$ls_numref,$ls_numrecdoc;
		global $ls_codigocuenta,$ls_estatuscontable,$ls_estatuspresupuesto,$ls_codtipdoc,$li_totrowspg,$ls_procede;
		global $ls_tipocontribuyente,$li_totrowscg,$ls_estimpmun,$ls_estlibcom;
		global $li_subtotal,$li_cargos,$li_total,$li_deducciones,$li_totalgeneral,$lb_valido;
		global $ls_codfuefin,$ls_denfuefin;
	
		$ld_fecregdoc=$io_fun_cxp->uf_obtenervalor("txtfecregdoc",$_POST["fecregdoc"]);
		$ld_fecvendoc=$io_fun_cxp->uf_obtenervalor("txtfecvendoc",$_POST["fecvendoc"]);
		$ld_fecemidoc=$io_fun_cxp->uf_obtenervalor("txtfecemidoc",$_POST["fecemidoc"]);
		$ls_codtipdoc=$io_fun_cxp->uf_obtenervalor("cmbcodtipdoc",$_POST["codtipdoc"]);
		$ls_codcla=$io_fun_cxp->uf_obtenervalor("cmbcodcla",$_POST["codcla"]);
		$ls_tipodestino=$io_fun_cxp->uf_obtenervalor("cmbtipdes",$_POST["tipdes"]);
		$ls_estimpmun=$io_fun_cxp->uf_obtenervalor("chkestimpmun","0");
		$ls_estlibcom=$io_fun_cxp->uf_obtenervalor("chkestlibcom","0");
		$ls_codprovben=$_POST["txtcodigo"];
		$ls_nomprovben=$_POST["txtnombre"];
		$ls_dencondoc=$_POST["txtdencondoc"];
		$ls_numref=$_POST["txtnumref"];
		$ls_numrecdoc=$_POST["txtnumrecdoc"];		
		$ls_codigocuenta=$_POST["codigocuenta"];
		$ls_estatuscontable=$_POST["estatuscontable"];
		$ls_estatuspresupuesto=$_POST["estatuspresupuesto"];
		$li_totrowspg=$_POST["totrowspg"];
		$li_totrowscg=$_POST["totrowscg"];
		$li_estaprord=$_POST["estaprord"];
		$ls_procede=$_POST["procede"];
		$ls_codfuefin=str_pad($_POST["txtcodfuefin"],2,"-",0);
		$ls_denfuefin=$_POST["txtdenfuefin"];
		$ls_tipocontribuyente=$_POST["tipocontribuyente"];	
		$li_subtotal=str_replace(".","",$_POST["txtsubtotal"]);
		$li_subtotal=str_replace(",",".",$li_subtotal);
		$li_cargos=str_replace(".","",$_POST["txtcargos"]);
		$li_cargos=str_replace(",",".",$li_cargos);
		$li_total=str_replace(".","",$_POST["txttotal"]);
		$li_total=str_replace(",",".",$li_total);
		$li_deducciones=str_replace(".","",$_POST["txtdeducciones"]);
		$li_deducciones=str_replace(",",".",$li_deducciones);
		$li_totalgeneral=str_replace(".","",$_POST["txttotalgener"]);
		$li_totalgeneral=str_replace(",",".",$li_totalgeneral);
		$lb_valido=true;
		$ls_operacion=$io_fun_cxp->uf_obteneroperacion();
		$ls_existe=$io_fun_cxp->uf_obtenerexiste();
   }
   //--------------------------------------------------------------

   //--------------------------------------------------------------
   function uf_load_data(&$as_parametros)
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_variables
		//		   Access: private
		//	  Description: Funci�n que carga todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 29/04/2007								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		global $li_subtotal,$li_cargos,$li_total,$li_deducciones,$li_totalgeneral,$li_totrowspg,$ls_numrecdoc,$ls_codigocuenta;
		global $ls_estatuscontable,$ls_estatuspresupuesto, $li_totrowscg;
			
		for($li_fila=1;($li_fila<$li_totrowspg);$li_fila++)
		{
			$ls_nrocomp=$_POST["txtspgnrocomp".$li_fila];
			$ls_codpro=$_POST["txtcodpro".$li_fila];
			$ls_cuenta=$_POST["txtspgcuenta".$li_fila];
			$ls_sccuenta=$_POST["txtspgsccuenta".$li_fila];
			$ls_cargo=$_POST["txtcargo".$li_fila];
			$li_moncue=$_POST["txtspgmonto".$li_fila];
			$li_original=$_POST["txtoriginal".$li_fila];
			$ls_procede=$_POST["txtspgprocededoc".$li_fila];
			$ls_codfuefin=$_POST["txtcodfuefin".$li_fila];

			$as_parametros=$as_parametros."&txtspgnrocomp".$li_fila."=".$ls_nrocomp."&txtcodpro".$li_fila."=".$ls_codpro."".
					   					  "&txtspgcuenta".$li_fila."=".$ls_cuenta."&txtspgsccuenta".$li_fila."=".$ls_sccuenta."".
										  "&txtcargo".$li_fila."=".$ls_cargo."&txtspgmonto".$li_fila."=".$li_moncue."".
										  "&txtoriginal".$li_fila."=".$li_original."&txtspgprocededoc".$li_fila."=".$ls_procede."".
										  "&txtcodfuefin".$li_fila."=".$ls_codfuefin;
		}
		$as_parametros=$as_parametros."&sccuentaprov=".$ls_codigocuenta."&generarcontable=1";
		$as_parametros=$as_parametros."&numrecdoc=".$ls_numrecdoc."&totrowspg=".$li_totrowspg."&estcontable=".$ls_estatuscontable."&estpresupuestario=".$ls_estatuspresupuesto;
		$as_parametros=$as_parametros."&subtotal=".$li_subtotal."&cargos=".$li_cargos."&deducciones=".$li_deducciones."&total=".$li_total."&totgeneral=".$li_totalgeneral;
   }
   //--------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Recepci&oacute;n de Documentos</title>
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/funcion_cxp.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/valida_tecla.js"></script>
<script type="text/javascript" language="javascript" src="../shared/js/number_format.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<script language="javascript">
	if(document.all)
	{ //ie 
		document.onkeydown = function(){ 
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey))
		{
			window.event.keyCode = 505; 
		}
		if(window.event.keyCode == 505){ return false;} 
		} 
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset="><style type="text/css">
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
</style>
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<link href="css/cxp.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style></head>
<body>
<?php
	require_once("class_folder/sigesp_cxp_c_recepcion.php");
	$io_cxp=new sigesp_cxp_c_recepcion("../");
	uf_limpiarvariables();
	switch ($ls_operacion) 
	{
		case "NUEVO":
			unset($_SESSION["cargos"]);
			unset($_SESSION["deducciones"]);
			unset($_SESSION["ls_ajuste"]);
			break;

		case "GUARDAR":
			uf_load_variables();
			$lb_valido=$io_cxp->uf_guardar($ls_existe,$ls_numrecdoc,$ls_tipodestino,$ls_codprovben,$ls_codtipdoc,$ld_fecregdoc,
										   $ld_fecvendoc,$ld_fecemidoc,$ls_codcla,$ls_dencondoc,$ls_procede,$li_cargos,$li_deducciones,
										   $li_totalgeneral,$ls_numref,$ls_estimpmun,$ls_estlibcom,$li_totrowspg,$li_totrowscg,
										   $ls_codfuefin,$la_seguridad);
			uf_load_data(&$ls_parametros);
			if($lb_valido)
			{
				$ls_existe="TRUE";
			}
			break;
			
		case "ELIMINAR":
			uf_load_variables();
			$lb_valido=$io_cxp->uf_delete($ls_numrecdoc,$ls_tipodestino,$ls_codprovben,$ls_codtipdoc,$la_seguridad);
			if($lb_valido==false)
			{
				uf_load_data(&$ls_parametros);
				$ls_existe="TRUE";
			}
			else
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
				unset($_SESSION["cargos"]);
				unset($_SESSION["deducciones"]);
				unset($_SESSION["ls_ajuste"]);
			}
			break;
	}
?>
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td width="780" height="30" colspan="11" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="432" height="20" colspan="11" bgcolor="#E7E7E7"><table width="762" border="0" align="center" cellpadding="0" cellspacing="0">
        <td width="432" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Cuentas por Pagar </td>
            <td width="346" bgcolor="#E7E7E7"><div align="right"><span class="letras-peque&ntilde;as"><b><?PHP print date("j/n/Y")." - ".date("h:i a");?></b></span></div></td>
      </table></td>
  </tr>
  <tr>
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>
  <tr>
    <td height="20" width="25" class="toolbar"><div align="center"><a href="javascript: ue_nuevo();"><img src="../shared/imagebank/tools20/nuevo.gif" alt="Nuevo" width="20" height="20" border="0" title="Nuevo"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_guardar();"><img src="../shared/imagebank/tools20/grabar.gif" alt="Grabar" width="20" height="20" border="0" title="Guardar"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_buscar();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0" title="Buscar"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_eliminar();"><img src="../shared/imagebank/tools20/eliminar.gif" alt="Eliminar" width="20" height="20" border="0" title="Eliminar"></a></div></td>
    <td class="toolbar" width="25"><a href="javascript: ue_imprimir();"><img src="../shared/imagebank/tools20/imprimir.gif" alt="Imprimir" width="20" height="20" border="0" title="Imprimir"></a></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_cerrar();"><img src="../shared/imagebank/tools20/salir.gif" alt="Salir" width="20" height="20" border="0" title="Salir"></a></div></td>
    <td class="toolbar" width="25"><div align="center"><a href="javascript: ue_ayuda();"><img src="../shared/imagebank/tools20/ayuda.gif" alt="Ayuda" width="20" height="20" border="0" title="Ayuda"></a></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="530">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
  <form name="formulario" method="post" action="" id="formulario">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_cxp->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_cxp);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
    <table width="796" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr>
        <td  height="136"><p>&nbsp;</p>
            <table width="785" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
              <tr>
                <td colspan="4" class="titulo-ventana">Registro de Recepci&oacute;n de Documentos </td>
              </tr>
              <tr>
                <td height="22">Reporte en
                  <select name="cmbbsf" id="cmbbsf">
                    <option value="0" selected>Bs.</option>
                    <option value="1">Bs.F.</option>
                  </select></td>
                <td height="22">&nbsp;</td>
                <td height="22">&nbsp;</td>
                <td height="22">&nbsp;</td>
              </tr>
              <tr>
                <td width="165" height="22"><div align="right">Estatus</div></td>
                <td width="392" height="22"><input name="txtestatus" type="text" class="sin-borde2" id="txtestatus" value="<?php print $ls_estatus; ?>" size="20" readonly>                </td>
                <td width="109" height="22"><div align="right">Fecha de Registro </div></td>
                <td width="119" height="22"><input name="txtfecregdoc" type="text" id="txtfecregdoc" onKeyDown="javascript:ue_formato_fecha(this,'/',patron,true,event);" onBlur="javascript: ue_validar_formatofecha(this);" value="<?php print $ld_fecregdoc;?>" size="17"  style="text-align:center" datepicker="true"></td>
              </tr>
              <tr>
                <td height="22"><div align="right">Tipo de Documento </div></td>
                <td height="22" colspan="3"><?php $io_cxp->uf_load_tipodocumento($ls_codtipdoc,"P");?></td>
              </tr>
              <tr>
                <td height="22" align="right">
                  <select name="cmbtipdes" id="cmbtipdes" onChange="javascript: ue_cambiardestino();" >
                    <option value="-" selected>-- Seleccione Uno --</option>
                    <option value="P" <?php if($ls_tipodestino=="P"){ print "selected";} ?>>PROVEEDOR</option>
                    <option value="B" <?php if($ls_tipodestino=="B"){ print "selected";} ?>>BENEFICIARIO</option>
                  </select>                </td>
                <td height="22" align="left"><div align="left">
                  <input name="txtcodigo" type="text" id="txtcodigo" value="<?php print $ls_codprovben;?>" size="15" maxlength="10" readonly>
                  <input name="txtnombre" type="text" class="sin-borde" id="txtnombre" value="<?php print $ls_nomprovben;?>" size="45" maxlength="30" readonly>                
                </div></td>
                <td height="22" align="right">Rif</td>
                <td height="22"><input name="txtrifpro" type="text" class="sin-borde" id="txtrifpro" size="15" readonly></td>
              </tr>
              <tr>
                <td height="22" colspan="4" class="titulo-celdanew">Informaci&oacute;n del Documento </td>
              </tr>
              <tr>
                <td height="22" colspan="4">
				<table width="785" border="0" cellpadding="0" cellspacing="1" class="celdas-blancas">
                  <tr>
                    <td width="184" height="22"><div align="right">N&uacute;mero de Documento </div></td>
                    <td width="200" height="22"><div align="left">
                      <input name="txtnumrecdoc" type="text" id="txtnumrecdoc"  onKeyPress="return keyRestrict(event,'1234567890'+'abcdefghijklmnopqrstuvwxyz')" value="<?php print $ls_numrecdoc;?>" size="20" maxlength="15" >
                    </div></td>
                    <td width="193" height="22"><div align="right">N&uacute;mero de Control </div></td>
                    <td width="203" height="22"><div align="left">
                      <input name="txtnumref" type="text" id="txtnumref"  onKeyPress="return keyRestrict(event,'1234567890'+'abcdefghijklmnopqrstuvwxyz')" value="<?php print $ls_numref;?>" size="20" maxlength="15"  >
                    </div></td>
                  </tr>
                  <tr>
                    <td height="22"><div align="right">Fecha de Emisi&oacute;n </div></td>
                    <td height="22"><div align="left">
                      <input name="txtfecemidoc" type="text" id="txtfecemidoc" style="text-align:center" value="<?php print $ld_fecemidoc;?>" size="17"  onKeyDown="javascript:ue_formato_fecha(this,'/',patron,true,event);" onBlur="javascript: ue_validar_formatofecha(this);" datepicker="true">
                    </div></td>
                    <td height="22"><div align="right">Fecha de Vencimiento </div></td>
                    <td height="22"><div align="left">
                      <input name="txtfecvendoc" type="text" id="txtfecvendoc" style="text-align:center" value="<?php print $ld_fecvendoc;?>" size="17"  onKeyDown="javascript:ue_formato_fecha(this,'/',patron,true,event);" onBlur="javascript: ue_validar_formatofecha(this);" datepicker="true">
                    </div></td>
                  </tr>
                  <tr>
                    <td height="22"><div align="right">Fuente de Financiamiento</div></td>
                    <td height="22" colspan="3"><div align="left">
                      <input name="txtcodfuefin" type="text" id="txtcodfuefin" style="text-align:center" value="<?php print $ls_codfuefin;?>" size="5" maxlength="2" readonly>
                      <a href="javascript: ue_fuentefinanciamiento();"><img src="../shared/imagebank/tools15/buscar.gif" alt="Buscar" width="15" height="15" border="0"></a>
                      <input name="txtdenfuefin" type="text" class="sin-borde" id="txtdenfuefin" value="<?php print $ls_denfuefin;?>" size="50" readonly>
                    </div></td>
                  </tr>
                  <tr>
                    <td height="22"><div align="right">Clasificaci&oacute;n del Concepto </div></td>
                    <td height="22" colspan="3"><?php $io_cxp->uf_load_clasificacionconcepto($ls_codcla);?></td>
                  </tr>
                  <tr>
                    <td height="22"><div align="right">Concepto</div></td>
                    <td colspan="3" rowspan="2"><textarea name="txtdencondoc" cols="100" rows="3" id="txtdencondoc"  onKeyPress="return keyRestrict(event,'1234567890'+'abcdefghijklmn�opqrstuvwxyz����� ()@#!%/[]*-+_');"><?php print $ls_dencondoc;?></textarea></td>
                  </tr>
                  <tr>
                    <td height="22">&nbsp;</td>
                  </tr>
				 <tr>
                    <td height="22">&nbsp;</td>
                    <td height="22"><div align="left">
                      <div align="right">Asociado al Libro de Compras
                        <input name="chkestlibcom" type="checkbox" class="sin-borde" id="chkestlibcom" value="1" <?php if($ls_estlibcom!=""){print "checked";}?>>
                      </div>
                    </div>
                    <div align="right"></div></td>
                    <td height="22"><div align="right">Impuesto Municipal
                        <input name="chkestimpmun" type="checkbox" class="sin-borde" id="chkestimpmun" value="1" <?php if($ls_estimpmun!=""){print "checked";}?>>
                    </div></td>
                    <td height="22">&nbsp;</td>
                  </tr>
				  <tr>
		<table width="791" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><div id="cuentas"></div></td>
              </tr>
          </table>
				  </tr>
                </table>				</td>
              </tr>
            </table>
        <p> 
          <input name="operacion" type="hidden" id="operacion" value="<?php print $ls_operacion;?>">
          <input name="existe" type="hidden" id="existe" value="<?php print $ls_existe;?>">
          <input name="codtipdoc" type="hidden" id="codtipdoc" value="<?php print $ls_codtipdoc;?>">
          <input name="tipdes" type="hidden" id="tipdes" value="<?php print $ls_tipodestino;?>">
          <input name="fecregdoc" type="hidden" id="fecregdoc" value="<?php print $ld_fecregdoc;?>">
          <input name="fecvendoc" type="hidden" id="fecvendoc" value="<?php print $ld_fecvendoc;?>">
          <input name="fecemidoc" type="hidden" id="fecemidoc" value="<?php print $ld_fecemidoc;?>">
          <input name="codcla" type="hidden" id="codcla" value="<?php print $ls_codcla;?>">
          <input name="estatuspresupuesto" type="hidden" id="estatuspresupuesto" value="<?php print $ls_estatuspresupuesto;?>">
          <input name="estatuscontable" type="hidden" id="estatuscontable" value="<?php print $ls_estatuscontable;?>">
          <input name="codigocuenta" type="hidden" id="codigocuenta" value="<?php print $ls_codigocuenta;?>">
          <input name="totrowspg" type="hidden" id="totrowspg" value="<?php print $li_totrowspg;?>">
          <input name="totrowscg" type="hidden" id="totrowscg" value="<?php print $li_totrowscg;?>">
          <input name="estaprord" type="hidden" id="estaprord" value="<?php print $li_estaprord;?>">
          <input name="procede" type="hidden" id="procede" value="<?php print $ls_procede;?>">
          <input name="tipocontribuyente" type="hidden" id="tipocontribuyente" value="<?php print $ls_tipocontribuyente;?>">
          <input name="generarcontable" type="hidden" id="generarcontable" value="1">
          <input name="estmodiva" type="hidden" id="estmodiva" value="<?php print $ls_estmodiva;?>">
          <input name="causadoparcial" type="hidden" id="causadoparcial"    value="0">
          <input name="parametros"     type="hidden" id="parametros"    value="<?php print $ls_parametros;?>">
          <input name="formato"    type="hidden" id="formato"    value="<?php print $ls_reporte; ?>">
          <input name="cerrarasiento" type="hidden" id="cerrarasiento" value="0">
        </p></td>
      </tr>
    </table>
</form>
</body>
<script language="javascript">
var patron = new Array(2,2,4);
var patron2 = new Array(1,3,3,3,3);

function ue_nuevo()
{
	f=document.formulario;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{	
		f.operacion.value="NUEVO";
		f.existe.value="FALSE";		
		f.action="sigesp_cxp_p_recepcion.php";
		f.submit();
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_guardar()
{
	f=document.formulario;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_existe=f.existe.value;
	if(((lb_existe=="TRUE")&&(li_cambiar==1))||(lb_existe=="FALSE")&&(li_incluir==1))
	{
		estaprord=f.estaprord.value;
		if(estaprord=="1")
		{
			alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
		}
		else
		{
			valido=true;
			codtipdoc=ue_validarvacio(f.cmbcodtipdoc.value);
			codigo=ue_validarvacio(f.txtcodigo.value);
			numrecdoc=ue_validarvacio(f.txtnumrecdoc.value);
			dencondoc=ue_validarvacio(f.txtdencondoc.value);
			fecregdoc=ue_validarvacio(f.txtfecregdoc.value);
			fecemidoc=ue_validarvacio(f.txtfecemidoc.value);
			fecvendoc=ue_validarvacio(f.txtfecvendoc.value);
			subtotal=ue_validarvacio(f.txtsubtotal.value);
			cargos=ue_validarvacio(f.txtcargos.value);
			totaldebe=ue_validarvacio(f.txttotaldebe.value);
			totalhaber=ue_validarvacio(f.txttotalhaber.value);
			totalgeneral=ue_formato_calculo(ue_validarvacio(f.txttotalgener.value));
			totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
			f.totrowspg.value=totrowspg;
			totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
			f.totrowscg.value=totrowscg;
			contable=codtipdoc.substr(6,1);
			presupuestario=codtipdoc.substr(8,1);
			montoproveedor=0;
			if(valido)
			{
				valido=ue_validarcampo(codtipdoc,"El Tipo de Documento no puede estar vacio.",f.cmbcodtipdoc);
			}
			if(valido)
			{
				valido=ue_validarcampo(codigo,"El Proveedor � Beneficiario no puede estar vacio.",f.txtcodigo);
			}
			if(valido)
			{
				valido=ue_validarcampo(numrecdoc,"El N�mero de Recepci�n no puede estar vacio.",f.txtnumrecdoc);
			}
			if(valido)
			{
				valido=ue_validarcampo(dencondoc,"El Concepto no puede estar vacio.",f.txtdencondoc);
			}
			if(valido)
			{
				valido=ue_validarcampo(fecregdoc,"La Fecha de Recepci�n no puede estar vacia.",f.txtfecregdoc);
			}
			if(valido)
			{
				valido=ue_validarcampo(fecemidoc,"La Fecha dee Emisi�n no puede estar vacia.",f.txtfecemidoc);
			}
			if(valido)
			{
				valido=ue_validarcampo(fecvendoc,"La Fecha de Vencimiento no puede estar vacia.",f.txtfecvendoc);
			}
			if(valido)
			{
				if((presupuestario=="1")||(presupuestario=="2")) // Causa � compromete y causa
				{
					if(totrowspg==0)
					{
						alert("Debe colocar Detalles Presupuestarios.");
						valido=false;
					}
					li_subtotal=0;
					li_cargos=0;
					for(j=1;(j<totrowspg)&&(valido);j++)
					{
						carg=eval("f.txtcargo"+j+".value");
						spgmonto=eval("f.txtspgmonto"+j+".value");
						if(carg=="0")
						{
							li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(spgmonto));
						}
						else
						{
							li_cargos=eval(li_cargos+"+"+ue_formato_calculo(spgmonto));
						}
					}
					for(j=1;(j<totrowscg)&&(valido);j++)
					{
						estatus=eval("f.txtestatus"+j+".value");
						debhab=eval("f.txtdebhab"+j+".value");
						if(estatus=="M")
						{
							if(debhab=="D")
							{
								monto=eval("f.txtmondeb"+j+".value");
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(monto));
							}
							else
							{
								monto=eval("f.txtmonhab"+j+".value");
								li_subtotal=eval(li_subtotal+"-"+ue_formato_calculo(monto));
							}
						}
					}
					li_subtotal=redondear(li_subtotal,2);
					li_cargos=redondear(li_cargos,2);
					subtotal=ue_formato_calculo(subtotal);
					cargos=ue_formato_calculo(cargos);
					if(parseFloat(subtotal)!=parseFloat(li_subtotal))
					{
						alert("La suma de los detalles Presupuestarios del Gasto Difiere con el Subtotal.");
						valido=false;
					}
					if(parseFloat(cargos)!=parseFloat(li_cargos))
					{
						alert("La suma de los detalles Presupuestarios del Cargo Difiere con los Otros Cr�ditos.");
						valido=false;
					}
				}
			}			
			if(valido)
			{
				if(contable=="1") // Contable
				{
					if(totrowscg==0)
					{
						alert("Debe colocar Detalles Contables.");
						valido=false;
					}
				}			
			}			
			if(valido)
			{
				if (totaldebe!=totalhaber)
				{
					alert("La Recepci�n est� descuadrada Contablemente.");
					valido=false;
				}
			}
			if(valido)
			{
				if(parseFloat(totalgeneral)<=0)
				{
					alert("La Recepci�n Debe ser Mayor que Cero.");
					valido=false;
				}
			}
			if(valido)
			{
				f.operacion.value="GUARDAR";
				f.action="sigesp_cxp_p_recepcion.php";
				f.submit();		
			}
		}
	}
	else
	{
		alert("No tiene permiso para realizar esta operaci�n");
	}
}

function ue_buscar()
{
	window.open("sigesp_cxp_cat_recepcion.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=650,height=400,left=50,top=50,location=no,resizable=no");
}

function ue_fuentefinanciamiento()
{
	f=document.formulario;
	totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
	f.totrowspg.value=totrowspg;
	totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
	f.totrowscg.value=totrowscg;
	if((totrowspg==1)&&(totrowscg==1))
	{
		window.open("sigesp_cxp_cat_fuente.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=no");
	}
}

function ue_eliminar()
{
	f=document.formulario;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_existe=f.existe.value;
	if(((lb_existe=="TRUE")&&(li_cambiar==1))||(lb_existe=="FALSE")&&(li_incluir==1))
	{
		if(lb_existe=="FALSE")
		{
			alert("Debe seleccionar una Recepci�n de Documentos.");
		}
		else
		{
			estaprord=f.estaprord.value;
			if(estaprord=="1")
			{
				alert("La Recepci�n de Documentos, no se puede eliminar ha sido Aprobada.");
			}
			else
			{
				procede=f.procede.value;
				if(procede=="CXPRCD")
				{		
					if(confirm("�Desea eliminar el Registro actual?"))
					{
						valido=true;
						codtipdoc=ue_validarvacio(f.cmbcodtipdoc.value);
						codigo=ue_validarvacio(f.txtcodigo.value);
						numrecdoc=ue_validarvacio(f.txtnumrecdoc.value);
						totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
						f.totrowspg.value=totrowspg;
						totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
						f.totrowscg.value=totrowscg;
						if(valido)
						{
							valido=ue_validarcampo(codtipdoc,"El Tipo de Documento no puede estar vacio.",f.cmbcodtipdoc);
						}
						if(valido)
						{
							valido=ue_validarcampo(codigo,"El Proveedor � Beneficiario no puede estar vacio.",f.txtcodigo);
						}
						if(valido)
						{
							valido=ue_validarcampo(numrecdoc,"El N�mero de Recepci�n no puede estar vacio.",f.txtnumrecdoc);
						}
						if(valido)
						{
							f.operacion.value="ELIMINAR";
							f.action="sigesp_cxp_p_recepcion.php";
							f.submit();		
						}
					}
				}
				else
				{
					alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede eliminar");
				}
			}
		}
	}
	else
	{
		alert("No tiene permiso para realizar esta operaci�n");
	}
}

function ue_imprimir()
{
	f=document.formulario;
	li_imprimir=f.imprimir.value;
	lb_existe=f.existe.value;
	if(li_imprimir==1)
	{
		if(lb_existe=="TRUE")
		{
			numrecdoc=f.txtnumrecdoc.value;
			tipdes=f.cmbtipdes.value;
			if(tipdes=="P")
			{
				codpro=f.txtcodigo.value;
				cedben="----------";
			}
			else
			{
				codpro="----------";
				cedben=f.txtcodigo.value;			
			}
			tipodocumento=f.cmbcodtipdoc.value;
			codtipdoc=tipodocumento.substr(0,5);
			tiporeporte= f.cmbbsf.value;
			formato=f.formato.value;
			window.open("reportes/"+formato+"?numrecdoc="+numrecdoc+"&codpro="+codpro+"&cedben="+cedben+"&codtipdoc="+codtipdoc+"&tiporeporte="+tiporeporte+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,left=0,top=0,location=no,resizable=yes");
		}
		else
		{
			alert("Debe existir un documento a imprimir");
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

function ue_cambiartipodocumento()
{
	f=document.formulario;
	tipodocumento=f.cmbcodtipdoc.value;
	codtipdoc=tipodocumento.substr(0,5);
	contable=tipodocumento.substr(6,1);
	presupuestario=tipodocumento.substr(8,1);
	f.estatuspresupuesto.value=presupuestario;
	f.estatuscontable.value=contable;
	f.codtipdoc.value=codtipdoc;
	f.totrowspg.value=1;
	f.totrowscg.value=1;
	ls_proceso="";
	if(presupuestario=="1") // Causa
	{
		ls_proceso="CAUSA";
	}
	if(presupuestario=="2") // Compromete y Causa
	{
		ls_proceso="COMPROMETECAUSA";
	}
	if((presupuestario=="3")||(presupuestario=="4")) // Sin afectaci�n presupuestaria
	{
		if(contable=="1")
		{
			ls_proceso="CONTABLE";
		}
	}
	// Div donde se van a cargar los resultados
	divgrid = document.getElementById('cuentas');
	// Instancia del Objeto AJAX
	ajax=objetoAjax();
	// Pagina donde est�n los m�todos para buscar y pintar los resultados
	ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divgrid.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	// Enviar todos los campos a la pagina para que haga el procesamiento
	ajax.send("proceso="+ls_proceso+"&totrowspg=1&totrowscg=1&estcontable="+contable+"&estpresupuestario="+presupuestario+"&generarcontable=1");
}

function ue_cambiardestino()
{
	f=document.formulario;
	// Se verifica si el destino es un proveedor � beneficiario y se carga el catalogo
	// dependiendo de esa informaci�n
	f.txtcodigo.value="";
	f.txtnombre.value="";
	tipdes=ue_validarvacio(f.cmbtipdes.value);
	if(tipdes!="-")
	{
		if(tipdes=="P")
		{
			window.open("sigesp_cxp_cat_proveedor.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
		}
		else
		{
			window.open("sigesp_cxp_cat_beneficiario.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
		}	
	}
}

function ue_agregarconcepto()
{
	f=document.formulario;
	id=f.cmbcodcla.selectedIndex;
	if(id>0)
	{
		texto=f.cmbcodcla[id].text;
		f.txtdencondoc.value=f.txtdencondoc.value+texto;
	}
}

function ue_catalogo_cuentas_spg()
{
	f=document.formulario;
	estaprord = f.estaprord.value;
	if(estaprord!="1")
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			numdoc=f.txtnumrecdoc.value;
			codtipdoc=f.cmbcodtipdoc.value;
			codproben=f.txtcodigo.value;
			codigocuenta=f.codigocuenta.value;
			presupuesto=f.estatuspresupuesto.value;
			if((presupuesto=="3")||(presupuesto=="4")) // Ninguna � Sin afectaci�n
			{
				alert("El Documento Seleccionado no permite Comprometer");
			}
			else
			{
				li_cargos=ue_formato_calculo(f.txtcargos.value);
				li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
				if((parseFloat(li_cargos)>0)||(parseFloat(li_deducciones)>0))
				{
					alert("Ya agrego Cargos y/o Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
				}
				else
				{
					if((codtipdoc!='-')&&(codproben!='')&&(numdoc!=''))
					{
						pagina="sigesp_cxp_pdt_spgcuentas.php?documento="+numdoc+"&sccuenta="+codigocuenta;
						window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=no,width=705,height=270,resizable=no,location=no,dependent=yes");
						f.fecregdoc.value=f.txtfecregdoc.value;
						f.fecvendoc.value=f.txtfecvendoc.value;
						f.fecemidoc.value=f.txtfecemidoc.value;
						f.codtipdoc.value=f.cmbcodtipdoc.value;
						f.tipdes.value=f.cmbtipdes.value;
						f.txtnumrecdoc.readOnly=true;
						f.cmbcodtipdoc.disabled=true;
						f.txtfecregdoc.disabled=true;
						f.txtfecemidoc.disabled=true;
						f.txtfecvendoc.disabled=true;
						f.cmbtipdes.disabled=true;
					}
					else
					{
						alert("Debe seleccionar el Tipo de Documento, Proveedor/Beneficiario y Escribir el N�mero de Documento");
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
	else
	{
		alert("La Recepi�n esta Aprobada no puede realizar ning�n cambio.");
	}
}

function ue_catalogo_cuentas_scg()
{
	f=document.formulario;
	estaprord = f.estaprord.value;
	if(estaprord!="1")
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			numdoc=f.txtnumrecdoc.value;
			codtipdoc=f.cmbcodtipdoc.value;
			codproben=f.txtcodigo.value;
			codigocuenta=f.codigocuenta.value;
			contable=f.estatuscontable.value;
			presupuestario=f.estatuspresupuesto.value;
			if(contable=="2") // Ninguna � Sin afectaci�n
			{
				alert("El Documento Seleccionado no permite Afectaci�n contable");
			}
			else
			{			
				li_cargos=ue_formato_calculo(f.txtcargos.value);
				if(presupuestario==1)
				{
					li_cargos=0;
				}
				li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
				if((parseFloat(li_cargos)>0)||(parseFloat(li_deducciones)>0))
				{
					alert("Ya agrego Cargos y/o Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
				}
				else
				{
					if((codtipdoc!='-')&&(codproben!='')&&(numdoc!=''))
					{
						pagina="sigesp_cxp_pdt_scgcuentas.php?documento="+numdoc+"&sccuenta="+codigocuenta;
						window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=no,width=705,height=270,resizable=no,location=no,dependent=yes");
						f.fecregdoc.value=f.txtfecregdoc.value;
						f.fecvendoc.value=f.txtfecvendoc.value;
						f.fecemidoc.value=f.txtfecemidoc.value;
						f.codtipdoc.value=f.cmbcodtipdoc.value;
						f.tipdes.value=f.cmbtipdes.value;
						f.txtnumrecdoc.readOnly=true;
						f.cmbcodtipdoc.disabled=true;
						f.txtfecregdoc.disabled=true;
						f.txtfecemidoc.disabled=true;
						f.txtfecvendoc.disabled=true;
						f.cmbtipdes.disabled=true;
					}
					else
					{
						alert("Debe seleccionar el Tipo de Documento, Proveedor/Beneficiario y Escribir el N�mero de Documento");
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
	else
	{
		alert("La Recepi�n esta Aprobada no puede realizar ning�n cambio.");
	}
}

function ue_catalogo_compromisos()
{
	f=document.formulario;
	estaprord = f.estaprord.value;
	if(estaprord!="1")
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			numdoc=f.txtnumrecdoc.value;
			codtipdoc=f.cmbcodtipdoc.value;
			codproben=f.txtcodigo.value;
			presupuesto=f.estatuspresupuesto.value;
			if((presupuesto=="3")||(presupuesto=="4")) // Ninguna � Sin afectaci�n
			{
				alert("El Documento Seleccionado no permite Causar");
			}
			else
			{			
				li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
				if(parseFloat(li_deducciones)>0)
				{
					alert("Ya agrego Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
				}
				else
				{
					if((codtipdoc!='-')&&(codproben!='')&&(numdoc!=''))
					{
						pagina="sigesp_cxp_pdt_compromisos.php";
						window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=650,height=325,resizable=no,location=no,dependent=yes");
						f.fecregdoc.value=f.txtfecregdoc.value;
						f.fecvendoc.value=f.txtfecvendoc.value;
						f.fecemidoc.value=f.txtfecemidoc.value;
						f.codtipdoc.value=f.cmbcodtipdoc.value;
						f.tipdes.value=f.cmbtipdes.value;
						f.txtnumrecdoc.readOnly=true;
						f.cmbcodtipdoc.disabled=true;
						f.txtfecregdoc.disabled=true;
						f.txtfecemidoc.disabled=true;
						f.txtfecvendoc.disabled=true;
						f.cmbtipdes.disabled=true;
					}
					else
					{
						alert("Debe seleccionar el Tipo de Documento, Proveedor/Beneficiario y Escribir el N�mero de Documento");
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
	else
	{
		alert("La Recepi�n esta Aprobada no puede realizar ning�n cambio.");
	}
}

function ue_catalogocreditos()
{
	f = document.formulario;
	numrecdoc=f.txtnumrecdoc.value;
	subtotal=ue_formato_calculo(f.txtsubtotal.value);
	contable=f.estatuscontable.value;
	presupuesto=f.estatuspresupuesto.value;
	comprobantes="";
	estaprord=f.estaprord.value;
	codproben=f.txtcodigo.value;
	tipocontribuyente=f.tipocontribuyente.value;
	estmodiva=f.estmodiva.value;
	causadoparcial=f.causadoparcial.value;
	totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
	f.totrowspg.value=totrowspg;
	if (estaprord!='1') // No est� Aprobada
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			if(tipocontribuyente!="F") // No es un Contribuyente formal
			{
				if ((contable=='1' && presupuesto=='2')||(causadoparcial=='1')||((estmodiva=='1')&&(contable=='1' && presupuesto=='1'))) // Compromete y causa  � si se puede modificar el IVA
				{  // Numero que me indica si el Documento es de tipo Compromete y Causa o
				   // ha reprocesado algun documento Tipo Causa para darle acceso al catalogo de otros Creditos.
					if((numrecdoc=="")||(parseFloat(subtotal)<=0)||(codproben==""))
					{
						alert("Debe Seleccionar un proveedor � Beneficiario, escribir el N�mero de Documento \n y el Monto del Subtotal Debe ser Mayor que Cero");
					}
					else
					{	
						tipodestino=f.cmbtipdes.value;
						if(tipodestino=="P")
						{
							codpro=f.txtcodigo.value;
							cedbene= "----------";
						}
						else
						{
							codpro="----------";
							cedbene=f.txtcodigo.value;
						}    
						codtipdoc=f.cmbcodtipdoc.value;
						procede=f.procede.value;
						estatus=f.txtestatus.value;
						for(i=1;i<totrowspg;i++)
						{
							documento=eval("f.txtspgnrocomp"+i+".value");
							procededoc=eval("f.txtspgprocededoc"+i+".value");
							if(comprobantes.length>0)
							{
								if(comprobantes.indexOf(documento+procededoc)==-1)
								{							
									comprobantes=comprobantes+"="+documento+procededoc;
								}
							}
							else
							{
								comprobantes=documento+procededoc;
							}
						}
						li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
						if(parseFloat(li_deducciones)>0)
						{
							alert("Ya agrego Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
						}
						else
						{
							if(	presupuesto=="2")
							{
								pagina="sigesp_cxp_pdt_otroscreditos.php?numrecdoc="+numrecdoc+"&subtotal="+subtotal+"&procede="+procede+"";
							}
							else
							{
								if((estmodiva=='1')||(causadoparcial='1'))
								{
									pagina="sigesp_cxp_pdt_otroscreditosparcial.php?numrecdoc="+numrecdoc+"&subtotal="+subtotal;
									pagina=pagina+"&procede="+procede+"&comprobantes="+comprobantes;
								}
							}
							window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=700,height=300,resizable=yes,location=no");
						}
					}
				}
				else
				{
					alert("El Tipo de Documento, no admite Otros Cr�ditos. ");
				}
			}
			else
			{
				alert("El contribuyente es formal no se le aplican Otros Cr�ditos");
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
	else
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
}	

function ue_catalogodeducciones()
{
	f=document.formulario;
	numrecdoc=f.txtnumrecdoc.value;
	subtotal=ue_formato_calculo(f.txtsubtotal.value);
	cargos=f.txtcargos.value;
	totalgeneral=f.txttotalgener.value;
	contable=f.estatuscontable.value;
	presupuesto=f.estatuspresupuesto.value;
	totrowspg=f.totrowspg.value;
	comprobantes="";
	estaprord=f.estaprord.value;
	codproben=f.txtcodigo.value;
	if (estaprord!='1') // No est� Aprobada
	{
		if((numrecdoc=="")||(parseFloat(subtotal)<=0)||(codproben==""))
		{
			alert("Debe Seleccionar un proveedor � Beneficiario, escribir el N�mero de Documento \n y el Monto del Subtotal Debe ser Mayor que Cero");
		}
		else
		{	
			if(totalgeneral=="0,00")
			{
				alert("El monto de la Recepci�n debe ser Mayor a Cero.");
			}
			else
			{
				if (procede!='SNOCNO')
				{
					tipodestino=f.cmbtipdes.value;
					if(tipodestino=="P")
					{
						codpro=f.txtcodigo.value;
						cedbene= "----------";
					}
					else
					{
						codpro="----------";
						cedbene=f.txtcodigo.value;
					}    
					codtipdoc=f.cmbcodtipdoc.value;
					scgnumcomp=f.txtscgnrocomp1.value;
					procede=f.procede.value;
					estatus=f.txtestatus.value;
					for(i=1;i<totrowspg;i++)
					{
						documento=eval("f.txtspgnrocomp"+i+".value");
						if(comprobantes.length>0)
						{
							comprobantes=comprobantes+"-"+documento;
						}
						else
						{
							comprobantes=documento;
						}
					}
					if(comprobantes=='')
					{
						comprobantes=scgnumcomp;
					}
					pagina="sigesp_cxp_pdt_deducciones.php?numrecdoc="+numrecdoc+"&subtotal="+subtotal+"&procede="+procede+"&cargos="+cargos;
					window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=640,height=300,resizable=yes,location=no");
				}
				else
				{
					alert("La N�mina no puede ser objeto de Deducciones.");
				}
			}
		}
	}
	else
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
}

function ue_delete_spg_cuenta(fila)
{
	f=document.formulario;
	estaprord=f.estaprord.value;
	if(estaprord=="1")
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
	else
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			li_cargos=ue_formato_calculo(f.txtcargos.value);
			li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
			if((parseFloat(li_cargos)>0)||(parseFloat(li_deducciones)>0))
			{
				alert("Ya agrego Cargos y/o Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
			}
			else
			{
				if(confirm("�Desea eliminar el Registro actual?"))
				{
					parametros="";
					generarcontable=f.generarcontable.value;
					totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
					f.totrowspg.value=totrowspg;
					totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
					f.totrowscg.value=totrowscg;
					li_i=0;
					li_subtotal=0;
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas presupuestarias
					//---------------------------------------------------------------------------------
					for(j=1;(j<totrowspg);j++)
					{
						if(fila!=j)
						{
							li_i=li_i+1;
							cargo=eval("f.txtcargo"+j+".value");
							spgnrocomp=eval("f.txtspgnrocomp"+j+".value");
							programatica=eval("f.txtprogramatica"+j+".value");
							spgcuenta=eval("f.txtspgcuenta"+j+".value");
							spgmonto=eval("f.txtspgmonto"+j+".value");
							codpro=eval("f.txtcodpro"+j+".value");
							original=eval("f.txtoriginal"+j+".value");
							spgsccuenta=eval("f.txtspgsccuenta"+j+".value");
							procede=eval("f.txtspgprocededoc"+j+".value");
							codfuefin=eval("f.txtcodfuefin"+j+".value");
							if(cargo=="0")
							{
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(spgmonto));
							}
							parametros=parametros+"&txtspgnrocomp"+li_i+"="+spgnrocomp+"&txtprogramatica"+li_i+"="+programatica+""+
									   "&txtspgcuenta"+li_i+"="+spgcuenta+"&txtspgmonto"+li_i+"="+spgmonto+""+
									   "&txtcodpro"+li_i+"="+codpro+"&txtcargo"+li_i+"="+cargo+""+ "&txtoriginal"+li_i+"="+original+
									   "&txtspgsccuenta"+li_i+"="+spgsccuenta+ "&txtspgprocededoc"+li_i+"="+procede+
									   "&txtcodfuefin"+li_i+"="+codfuefin;
						}
					}
					totalcuentasspg=eval(li_i+"+1");
					parametros=parametros+"&totrowspg="+totalcuentasspg+"";
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas contables
					//---------------------------------------------------------------------------------
					li_i=0;
					for(j=1;(j<totrowscg);j++)
					{
						scgnrocomp=eval("f.txtscgnrocomp"+j+".value");
						scgcuenta=eval("f.txtscgcuenta"+j+".value");
						mondeb=eval("f.txtmondeb"+j+".value");
						monhab=eval("f.txtmonhab"+j+".value");
						debhab=eval("f.txtdebhab"+j+".value");
						estatus=eval("f.txtestatus"+j+".value");
						scgprocededoc=eval("f.txtscgprocededoc"+j+".value");
						if(estatus=="M")
						{
							if(debhab=="D")
							{
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(mondeb));
							}
							else
							{
								li_subtotal=eval(li_subtotal+"-"+ue_formato_calculo(monhab));
							}
							li_i=li_i+1;
							parametros=parametros+"&txtscgnrocomp"+li_i+"="+scgnrocomp+"&txtscgcuenta"+li_i+"="+scgcuenta+""+
												  "&txtmondeb"+li_i+"="+mondeb+"&txtmonhab"+li_i+"="+monhab+"&txtdebhab"+li_i+"="+debhab+
												  "&txtestatus"+li_i+"="+estatus+"&txtscgprocededoc"+li_i+"="+scgprocededoc;
						}
					}
					totrowscg=li_i+1;
					parametros=parametros+"&totrowscg="+totrowscg+"";
					presupuestario=f.estatuspresupuesto.value;
					contable=f.estatuscontable.value;
					sccuentaprov=f.codigocuenta.value;
					li_cargos=ue_formato_calculo(f.txtcargos.value);
					li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
					li_total=eval(li_subtotal+"+"+li_cargos);
					li_totalgeneral=eval(li_total+"-"+li_deducciones);
					ls_numrecdoc=f.txtnumrecdoc.value;
					parametros=parametros+"&estcontable="+contable+"&estpresupuestario="+presupuestario+"&sccuentaprov="+sccuentaprov;
					parametros=parametros+"&subtotal="+li_subtotal+"&cargos="+li_cargos+"&total="+li_total+"&numrecdoc="+ls_numrecdoc;
					parametros=parametros+"&deducciones="+li_deducciones+"&totgeneral="+li_totalgeneral+"&generarcontable="+generarcontable;
					if(parametros!="")
					{
						// Div donde se van a cargar los resultados
						divgrid = document.getElementById("cuentas");
						// Instancia del Objeto AJAX
						ajax=objetoAjax();
						// Pagina donde est�n los m�todos para buscar y pintar los resultados
						ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
						ajax.onreadystatechange=function(){
							if(ajax.readyState==1)
							{
								//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
							}
							else
							{
								if(ajax.readyState==4)
								{
									if(ajax.status==200)
									{//mostramos los datos dentro del contenedor
										divgrid.innerHTML = ajax.responseText
									}
									else
									{
										if(ajax.status==404)
										{
											divgrid.innerHTML = "La p�gina no existe";
										}
										else
										{//mostramos el posible error     
											divgrid.innerHTML = "Error:".ajax.status;
										}
									}
									
								}
							}
						}	
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						// Enviar todos los campos a la pagina para que haga el procesamiento
						ajax.send("proceso=COMPROMETECAUSA"+parametros);
						f.totrowspg.value=totalcuentasspg;
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
}

function ue_delete_scg_cuenta(fila)
{
	f=document.formulario;
	estaprord=f.estaprord.value;
	presupuestario=f.estatuspresupuesto.value;
	causadoparcial=f.causadoparcial.value;
	contable=f.estatuscontable.value;
	ls_proceso="";
	if(presupuestario=="1") // Causa
	{
		ls_proceso="CAUSA";
		if(causadoparcial=="1")
		{
			ls_proceso="CAUSAPARCIAL";
		}
	}
	if(presupuestario=="2") // Compromete y Causa
	{
		ls_proceso="COMPROMETECAUSA";
	}
	if((ls_proceso=="")&&(contable=="1"))// Contable
	{
		ls_proceso="CONTABLE";
	}
	if(estaprord=="1")
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
	else
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			li_cargos=ue_formato_calculo(f.txtcargos.value);
			if(presupuestario==1)
			{
				li_cargos=0;
			}
			li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
			if((parseFloat(li_cargos)>0)||(parseFloat(li_deducciones)>0))
			{
				alert("Ya agrego Cargos y/o Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
			}
			else
			{
				if(confirm("�Desea eliminar el Registro actual?"))
				{
					parametros="";
					generarcontable=f.generarcontable.value;
					totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
					f.totrowspg.value=totrowspg;
					totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
					f.totrowscg.value=totrowscg;
					li_i=0;
					li_subtotal=0;
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas presupuestarias
					//---------------------------------------------------------------------------------
					for(li_i=1;(li_i<totrowspg);li_i++)
					{
						cargo=eval("f.txtcargo"+li_i+".value");
						spgnrocomp=eval("f.txtspgnrocomp"+li_i+".value");
						programatica=eval("f.txtprogramatica"+li_i+".value");
						spgcuenta=eval("f.txtspgcuenta"+li_i+".value");
						spgmonto=eval("f.txtspgmonto"+li_i+".value");
						codpro=eval("f.txtcodpro"+li_i+".value");
						original=eval("f.txtoriginal"+li_i+".value");
						spgsccuenta=eval("f.txtspgsccuenta"+li_i+".value");
						procede=eval("f.txtspgprocededoc"+li_i+".value");
						codfuefin=eval("f.txtcodfuefin"+li_i+".value");
						if(cargo=="0")
						{
							li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(spgmonto));
						}
						parametros=parametros+"&txtspgnrocomp"+li_i+"="+spgnrocomp+"&txtprogramatica"+li_i+"="+programatica+""+
								   "&txtspgcuenta"+li_i+"="+spgcuenta+"&txtspgmonto"+li_i+"="+spgmonto+""+
								   "&txtcodpro"+li_i+"="+codpro+"&txtcargo"+li_i+"="+cargo+""+ "&txtoriginal"+li_i+"="+original+
								   "&txtspgsccuenta"+li_i+"="+spgsccuenta+ "&txtspgprocededoc"+li_i+"="+procede+
								   "&txtcodfuefin"+li_i+"="+codfuefin;
					}
					parametros=parametros+"&totrowspg="+totrowspg+"";
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas contables
					//---------------------------------------------------------------------------------
					li_i=0;
					for(j=1;(j<totrowscg);j++)
					{
						if(fila!=j)
						{
							scgnrocomp=eval("f.txtscgnrocomp"+j+".value");
							scgcuenta=eval("f.txtscgcuenta"+j+".value");
							mondeb=eval("f.txtmondeb"+j+".value");
							monhab=eval("f.txtmonhab"+j+".value");
							debhab=eval("f.txtdebhab"+j+".value");
							estatus=eval("f.txtestatus"+j+".value");
							scgprocededoc=eval("f.txtscgprocededoc"+j+".value");
							if(estatus=="M")
							{
								if(debhab=="D")
								{
									li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(mondeb));
								}
								else
								{
									if(ls_proceso!="CONTABLE")
									{
										li_subtotal=eval(li_subtotal+"-"+ue_formato_calculo(monhab));
									}
								}
								li_i=li_i+1;
								parametros=parametros+"&txtscgnrocomp"+li_i+"="+scgnrocomp+"&txtscgcuenta"+li_i+"="+scgcuenta+""+
													  "&txtmondeb"+li_i+"="+mondeb+"&txtmonhab"+li_i+"="+monhab+"&txtdebhab"+li_i+"="+debhab+
													  "&txtestatus"+li_i+"="+estatus+"&txtscgprocededoc"+li_i+"="+scgprocededoc;
							}
						}
					}
					totrowscg=li_i+1;
					parametros=parametros+"&totrowscg="+totrowscg+"";
					sccuentaprov=f.codigocuenta.value;
					li_cargos=ue_formato_calculo(f.txtcargos.value);
					li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
					li_total=eval(li_subtotal+"+"+li_cargos);
					li_totalgeneral=eval(li_total+"-"+li_deducciones);
					ls_numrecdoc=f.txtnumrecdoc.value;
					parametros=parametros+"&estcontable="+contable+"&estpresupuestario="+presupuestario+"&sccuentaprov="+sccuentaprov;
					parametros=parametros+"&subtotal="+li_subtotal+"&cargos="+li_cargos+"&total="+li_total+"&numrecdoc="+ls_numrecdoc;
					parametros=parametros+"&deducciones="+li_deducciones+"&totgeneral="+li_totalgeneral+"&generarcontable="+generarcontable;
					if(parametros!="")
					{
						// Div donde se van a cargar los resultados
						divgrid = document.getElementById("cuentas");
						// Instancia del Objeto AJAX
						ajax=objetoAjax();
						// Pagina donde est�n los m�todos para buscar y pintar los resultados
						ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
						ajax.onreadystatechange=function(){
							if(ajax.readyState==1)
							{
								//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
							}
							else
							{
								if(ajax.readyState==4)
								{
									if(ajax.status==200)
									{//mostramos los datos dentro del contenedor
										divgrid.innerHTML = ajax.responseText
									}
									else
									{
										if(ajax.status==404)
										{
											divgrid.innerHTML = "La p�gina no existe";
										}
										else
										{//mostramos el posible error     
											divgrid.innerHTML = "Error:".ajax.status;
										}
									}
									
								}
							}
						}	
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						// Enviar todos los campos a la pagina para que haga el procesamiento
						ajax.send("proceso="+ls_proceso+""+parametros);
						f.totrowspg.value=totalcuentasspg;
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
}

function ue_delete_compromiso(fila)
{
	f=document.formulario;
	estaprord=f.estaprord.value;
	if(estaprord=="1")
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
	else
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
			if(parseFloat(li_deducciones)>0)
			{
				alert("Ya agrego Deducciones debe proceder a eliminar los movimientos para poder agregar otras cuentas.");
			}
			else
			{
				if(confirm("�Desea eliminar el Registro actual?"))
				{
					parametros="";
					generarcontable=f.generarcontable.value;
					totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
					f.totrowspg.value=totrowspg;
					totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
					f.totrowscg.value=totrowspg;
					li_i=0;
					li_subtotal=0;
					li_cargos=0;
					comprobante=eval("f.txtspgnrocomp"+fila+".value")
					procededoc=eval("f.txtspgprocededoc"+fila+".value")
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas presupuestarias
					//---------------------------------------------------------------------------------
					for(j=1;(j<totrowspg);j++)
					{
						spgnrocomp=eval("f.txtspgnrocomp"+j+".value");
						procede=eval("f.txtspgprocededoc"+j+".value");
						if((spgnrocomp!=comprobante)||(procede!=procededoc))
						{
							li_i=li_i+1;
							cargo=eval("f.txtcargo"+j+".value");
							programatica=eval("f.txtprogramatica"+j+".value");
							spgcuenta=eval("f.txtspgcuenta"+j+".value");
							spgmonto=eval("f.txtspgmonto"+j+".value");
							codpro=eval("f.txtcodpro"+j+".value");
							original=eval("f.txtoriginal"+j+".value");
							spgsccuenta=eval("f.txtspgsccuenta"+j+".value");
							codfuefin=eval("f.txtcodfuefin"+j+".value");
							if(cargo=="0")
							{
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(spgmonto));
							}
							else
							{
								li_cargos=eval(li_cargos+"+"+ue_formato_calculo(spgmonto));
							}
							parametros=parametros+"&txtspgnrocomp"+li_i+"="+spgnrocomp+"&txtprogramatica"+li_i+"="+programatica+""+
									   "&txtspgcuenta"+li_i+"="+spgcuenta+"&txtspgmonto"+li_i+"="+spgmonto+""+
									   "&txtcodpro"+li_i+"="+codpro+"&txtcargo"+li_i+"="+cargo+""+ "&txtoriginal"+li_i+"="+original+
									   "&txtspgsccuenta"+li_i+"="+spgsccuenta+ "&txtspgprocededoc"+li_i+"="+procede+
									   "&txtcodfuefin"+li_i+"="+codfuefin;
						}
					}
					totalcuentasspg=eval(li_i+"+1");
					parametros=parametros+"&totrowspg="+totalcuentasspg+"";
					//---------------------------------------------------------------------------------
					// recorremos grid de las cuentas contables
					//---------------------------------------------------------------------------------
					li_i=0;
					for(j=1;(j<totrowscg);j++)
					{
						scgnrocomp=eval("f.txtscgnrocomp"+j+".value");
						scgcuenta=eval("f.txtscgcuenta"+j+".value");
						mondeb=eval("f.txtmondeb"+j+".value");
						monhab=eval("f.txtmonhab"+j+".value");
						debhab=eval("f.txtdebhab"+j+".value");
						estatus=eval("f.txtestatus"+j+".value");
						scgprocededoc=eval("f.txtscgprocededoc"+j+".value");
						if(estatus=="M")
						{
							if(debhab=="D")
							{
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(mondeb));
							}
							else
							{
								li_subtotal=eval(li_subtotal+"-"+ue_formato_calculo(monhab));
							}
							li_i=li_i+1;
							parametros=parametros+"&txtscgnrocomp"+li_i+"="+scgnrocomp+"&txtscgcuenta"+li_i+"="+scgcuenta+""+
												  "&txtmondeb"+li_i+"="+mondeb+"&txtmonhab"+li_i+"="+monhab+"&txtdebhab"+li_i+"="+debhab+
												  "&txtestatus"+li_i+"="+estatus+"&txtscgprocededoc"+li_i+"="+scgprocededoc;
						}
					}
					totrowscg=li_i+1;
					parametros=parametros+"&totrowscg="+totrowscg+"";
					presupuestario=f.estatuspresupuesto.value;
					contable=f.estatuscontable.value;
					sccuentaprov=f.codigocuenta.value;
					li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
					li_total=eval(li_subtotal+"+"+li_cargos);
					li_totalgeneral=eval(li_total+"-"+li_deducciones);
					ls_numrecdoc=f.txtnumrecdoc.value;
					parametros=parametros+"&eliminarcargo=1&compromiso="+comprobante+"&procededoc="+procededoc;
					parametros=parametros+"&estcontable="+contable+"&estpresupuestario="+presupuestario+"&sccuentaprov="+sccuentaprov;
					parametros=parametros+"&subtotal="+li_subtotal+"&cargos="+li_cargos+"&total="+li_total+"&numrecdoc="+ls_numrecdoc;
					parametros=parametros+"&deducciones="+li_deducciones+"&totgeneral="+li_totalgeneral+"&generarcontable="+generarcontable;
					if(parametros!="")
					{
						// Div donde se van a cargar los resultados
						divgrid = document.getElementById("cuentas");
						// Instancia del Objeto AJAX
						ajax=objetoAjax();
						// Pagina donde est�n los m�todos para buscar y pintar los resultados
						ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
						ajax.onreadystatechange=function(){
							if(ajax.readyState==1)
							{
								//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
							}
							else
							{
								if(ajax.readyState==4)
								{
									if(ajax.status==200)
									{//mostramos los datos dentro del contenedor
										divgrid.innerHTML = ajax.responseText
									}
									else
									{
										if(ajax.status==404)
										{
											divgrid.innerHTML = "La p�gina no existe";
										}
										else
										{//mostramos el posible error     
											divgrid.innerHTML = "Error:".ajax.status;
										}
									}
									
								}
							}
						}	
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						// Enviar todos los campos a la pagina para que haga el procesamiento
						ajax.send("proceso=CAUSA"+parametros);
						f.totrowspg.value=totalcuentasspg;
					}
				}
			}
		}
		else
		{
			alert("La Recepci�n de Documentos, Fu� generada desde otro m�dulo no se puede modificar");
		}
	}
}

function ue_procesar_comprobante(fila)
{
	f=document.formulario;
	estaprord=f.estaprord.value;
	presupuestario=f.estatuspresupuesto.value;
	contable=f.estatuscontable.value;
	lb_valido=true;
	if(estaprord=="1")
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
	else
	{
		li_cargos=ue_formato_calculo(f.txtcargos.value);
		if(presupuestario==1)
		{
			li_cargos=0;
		}
		li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
		if((parseFloat(li_cargos)>0)||(parseFloat(li_deducciones)>0))
		{
			alert("Ya agrego Cargos y/o Deducciones debe proceder a eliminar los movimientos para poder modificar los montos.");
		}
		else
		{
			procede=f.procede.value;
			if(procede=="CXPRCD")
			{		
				compromiso=eval("f.txtspgnrocomp"+fila+".value");
				procededoc=eval("f.txtspgprocededoc"+fila+".value");
				parametros="";
				generarcontable=f.generarcontable.value;
				totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
				f.totrowspg.value=totrowspg;
				totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
				f.totrowscg.value=totrowscg;
				f.causadoparcial.value="1";
				li_i=0;
				li_cargos=0;
				li_subtotal=0;
				//---------------------------------------------------------------------------------
				// recorremos grid de las cuentas presupuestarias
				//---------------------------------------------------------------------------------
				for(j=1;(j<totrowspg);j++)
				{
					cargo=eval("f.txtcargo"+j+".value");
					spgnrocomp=eval("f.txtspgnrocomp"+j+".value");
					programatica=eval("f.txtprogramatica"+j+".value");
					spgcuenta=eval("f.txtspgcuenta"+j+".value");
					spgmonto=eval("f.txtspgmonto"+j+".value");
					codpro=eval("f.txtcodpro"+j+".value");
					original=eval("f.txtoriginal"+j+".value");
					spgsccuenta=eval("f.txtspgsccuenta"+j+".value");
					procede=eval("f.txtspgprocededoc"+j+".value");
					codfuefin=eval("f.txtcodfuefin"+j+".value");
					if(parseFloat(ue_formato_calculo(spgmonto))<=parseFloat(original))
					{
						if((cargo=="0")||(((compromiso==spgnrocomp)&&(procededoc==procede))==false))
						{
							li_i=li_i+1;
							if(cargo=="0")
							{
								li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(spgmonto));
							}
							else
							{
								li_cargos=eval(li_cargos+"+"+ue_formato_calculo(spgmonto));	
							}
							parametros=parametros+"&txtspgnrocomp"+li_i+"="+spgnrocomp+"&txtprogramatica"+li_i+"="+programatica+""+
									   "&txtspgcuenta"+li_i+"="+spgcuenta+"&txtspgmonto"+li_i+"="+spgmonto+""+
									   "&txtcodpro"+li_i+"="+codpro+"&txtcargo"+li_i+"="+cargo+""+ "&txtoriginal"+li_i+"="+original+
									   "&txtspgsccuenta"+li_i+"="+spgsccuenta+ "&txtspgprocededoc"+li_i+"="+procede+
									   "&txtcodfuefin"+li_i+"="+codfuefin;
						}
					}
					else
					{
						alert("El monto Causado de la cuenta "+spgcuenta+" es mayor que el del Compromiso");
						lb_valido=false;
						j=totrowspg+1;
					}
				}
				li_i=li_i+1;
				parametros=parametros+"&totrowspg="+li_i+"";
				//---------------------------------------------------------------------------------
				// recorremos grid de las cuentas contables
				//---------------------------------------------------------------------------------
				li_i=0;
				for(j=1;(j<totrowscg);j++)
				{
					scgnrocomp=eval("f.txtscgnrocomp"+j+".value");
					scgcuenta=eval("f.txtscgcuenta"+j+".value");
					mondeb=eval("f.txtmondeb"+j+".value");
					monhab=eval("f.txtmonhab"+j+".value");
					debhab=eval("f.txtdebhab"+j+".value");
					estatus=eval("f.txtestatus"+j+".value");
					scgprocededoc=eval("f.txtscgprocededoc"+j+".value");
					if(estatus=="M")
					{
						if(debhab=="D")
						{
							li_subtotal=eval(li_subtotal+"+"+ue_formato_calculo(mondeb));
						}
						else
						{
							li_subtotal=eval(li_subtotal+"-"+ue_formato_calculo(monhab));
						}
						li_i=li_i+1;
						parametros=parametros+"&txtscgnrocomp"+li_i+"="+scgnrocomp+"&txtscgcuenta"+li_i+"="+scgcuenta+""+
											  "&txtmondeb"+li_i+"="+mondeb+"&txtmonhab"+li_i+"="+monhab+"&txtdebhab"+li_i+"="+debhab+
											  "&txtestatus"+li_i+"="+estatus+"&txtscgprocededoc"+li_i+"="+scgprocededoc;
					}
				}
				totrowscg=li_i+1;
				parametros=parametros+"&totrowscg="+totrowscg+"";
				sccuentaprov=f.codigocuenta.value;
				li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
				li_total=eval(li_subtotal+"+"+li_cargos);
				li_totalgeneral=eval(li_total+"-"+li_deducciones);
				ls_numrecdoc=f.txtnumrecdoc.value;
				parametros=parametros+"&compromiso="+compromiso+"&procededoc="+procededoc+"&eliminarcargo=1";
				parametros=parametros+"&estcontable="+contable+"&estpresupuestario="+presupuestario+"&sccuentaprov="+sccuentaprov;
				parametros=parametros+"&subtotal="+li_subtotal+"&cargos="+li_cargos+"&total="+li_total+"&numrecdoc="+ls_numrecdoc;
				parametros=parametros+"&deducciones="+li_deducciones+"&totgeneral="+li_totalgeneral+"&generarcontable="+generarcontable;
				if((parametros!="")&&(lb_valido))
				{
					// Div donde se van a cargar los resultados
					divgrid = document.getElementById("cuentas");
					// Instancia del Objeto AJAX
					ajax=objetoAjax();
					// Pagina donde est�n los m�todos para buscar y pintar los resultados
					ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
					ajax.onreadystatechange=function(){
						if(ajax.readyState==1)
						{
							//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
						}
						else
						{
							if(ajax.readyState==4)
							{
								if(ajax.status==200)
								{//mostramos los datos dentro del contenedor
									divgrid.innerHTML = ajax.responseText
								}
								else
								{
									if(ajax.status==404)
									{
										divgrid.innerHTML = "La p�gina no existe";
									}
									else
									{//mostramos el posible error     
										divgrid.innerHTML = "Error:".ajax.status;
									}
								}
								
							}
						}
					}	
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					// Enviar todos los campos a la pagina para que haga el procesamiento
					ajax.send("proceso=CAUSAPARCIAL"+parametros);
				}
			}
		}
	}
}

function ue_cerrar_asiento()
{
	f=document.formulario;
	estaprord=f.estaprord.value;
	lb_valido=true;
	if(estaprord=="1")
	{
		alert("La Recepci�n de Documentos, no se puede modificar ha sido Aprobada.");
	}
	else
	{
		procede=f.procede.value;
		if(procede=="CXPRCD")
		{		
			totrowspg=ue_calcular_total_fila_local("txtspgnrocomp");
			f.totrowspg.value=totrowspg;
			totrowscg=ue_calcular_total_fila_local("txtscgnrocomp");
			f.totrowscg.value=totrowscg;
			if((totrowspg>1)||(totrowscg>1))
			{
				//---------------------------------------------------------------------------------
				// Cargar las Cuentas del opener y el seleccionado
				//---------------------------------------------------------------------------------
				parametros="";
				for(j=1;(j<totrowspg);j++)
				{
					spgnrocomp=eval("f.txtspgnrocomp"+j+".value");
					programatica=eval("f.txtprogramatica"+j+".value");
					spgcuenta=eval("f.txtspgcuenta"+j+".value");
					spgmonto=eval("f.txtspgmonto"+j+".value");
					codpro=eval("f.txtcodpro"+j+".value");
					cargo=eval("f.txtcargo"+j+".value");
					original=eval("f.txtoriginal"+j+".value");
					procededoc=eval("f.txtspgprocededoc"+j+".value");
					spgsccuenta=eval("f.txtspgsccuenta"+j+".value");
					codfuefin=eval("f.txtcodfuefin"+j+".value");
					parametros=parametros+"&txtspgnrocomp"+j+"="+spgnrocomp+"&txtprogramatica"+j+"="+programatica+""+
							   "&txtspgcuenta"+j+"="+spgcuenta+"&txtspgmonto"+j+"="+spgmonto+""+
							   "&txtcodpro"+j+"="+codpro+"&txtcargo"+j+"="+cargo+"&txtoriginal"+j+"="+original+
							   "&txtspgsccuenta"+j+"="+spgsccuenta+"&txtspgprocededoc"+j+"="+procededoc+
							   "&txtcodfuefin"+j+"="+codfuefin;
				}
				parametros=parametros+"&totrowspg="+totrowspg+"";
				//---------------------------------------------------------------------------------
				// recorremos grid de las cuentas contables
				//---------------------------------------------------------------------------------
				li_i=0;
				for(j=1;(j<totrowscg);j++)
				{
					scgnrocomp=eval("f.txtscgnrocomp"+j+".value");
					scgcuenta=eval("f.txtscgcuenta"+j+".value");
					mondeb=eval("f.txtmondeb"+j+".value");
					monhab=eval("f.txtmonhab"+j+".value");
					debhab=eval("f.txtdebhab"+j+".value");
					estatus=eval("f.txtestatus"+j+".value");
					scgprocededoc=eval("f.txtscgprocededoc"+j+".value");
					if(estatus=="M")
					{
						li_i=li_i+1;
						parametros=parametros+"&txtscgnrocomp"+li_i+"="+scgnrocomp+"&txtscgcuenta"+li_i+"="+scgcuenta+""+
											  "&txtmondeb"+li_i+"="+mondeb+"&txtmonhab"+li_i+"="+monhab+"&txtdebhab"+li_i+"="+debhab+
											  "&txtestatus"+li_i+"="+estatus+"&txtscgprocededoc"+li_i+"="+scgprocededoc;
					}
				}
				totrowscg=li_i+1;
				parametros=parametros+"&totrowscg="+totrowscg+"";
				presupuestario=f.estatuspresupuesto.value;
				causadoparcial=f.causadoparcial.value;
				contable=f.estatuscontable.value;
				ls_proceso="";
				if(presupuestario=="1") // Causa
				{
					ls_proceso="CAUSA";
					if(causadoparcial=="1")
					{
						ls_proceso="CAUSAPARCIAL";
					}
				}
				if(presupuestario=="2") // Compromete y Causa
				{
					ls_proceso="COMPROMETECAUSA";
				}
				if((ls_proceso=="")&&(contable=="1"))// Contable
				{
					ls_proceso="CONTABLE";
				}
				sccuentaprov=f.codigocuenta.value;
				li_subtotal=ue_formato_calculo(f.txtsubtotal.value);
				li_cargos=ue_formato_calculo(f.txtcargos.value);
				li_total=ue_formato_calculo(f.txttotal.value);
				li_deducciones=ue_formato_calculo(f.txtdeducciones.value);
				li_totalgeneral=ue_formato_calculo(f.txttotalgener.value);
				ls_numrecdoc=f.txtnumrecdoc.value;
				parametros=parametros+"&estcontable="+contable+"&estpresupuestario="+presupuestario+"&sccuentaprov="+sccuentaprov;
				parametros=parametros+"&subtotal="+li_subtotal+"&cargos="+li_cargos+"&total="+li_total+"&numrecdoc="+ls_numrecdoc;
				parametros=parametros+"&deducciones="+li_deducciones+"&totgeneral="+li_totalgeneral+"&generarcontable=1";
				if(parametros!="")
				{
					// Div donde se van a cargar los resultados
					divgrid = document.getElementById("cuentas");
					// Instancia del Objeto AJAX
					ajax=objetoAjax();
					// Pagina donde est�n los m�todos para buscar y pintar los resultados
					ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
					ajax.onreadystatechange=function(){
						if(ajax.readyState==1)
						{
							//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
						}
						else
						{
							if(ajax.readyState==4)
							{
								if(ajax.status==200)
								{//mostramos los datos dentro del contenedor
									divgrid.innerHTML = ajax.responseText
								}
								else
								{
									if(ajax.status==404)
									{
										divgrid.innerHTML = "La p�gina no existe";
									}
									else
									{//mostramos el posible error     
										divgrid.innerHTML = "Error:".ajax.status;
									}
								}
								
							}
						}
					}	
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					// Enviar todos los campos a la pagina para que haga el procesamiento
					ajax.send("proceso="+ls_proceso+""+parametros);
				}
			}
			else
			{
				alert("Debe Tener Detalles Preuspuestarios � contables para poder Cerrar el asiento.");
			}
		}
	}
}

function ue_reload()
{
	f=document.formulario;
	f.txtnumrecdoc.readOnly=true;
	f.cmbcodtipdoc.disabled=true;
	f.txtfecregdoc.disabled=true;
	f.txtfecemidoc.disabled=true;
	f.txtfecvendoc.disabled=true;
	f.cmbtipdes.disabled=true;
	presupuestario=f.estatuspresupuesto.value;
	causadoparcial=f.causadoparcial.value;
	contable=f.estatuscontable.value;
	ls_proceso="";
	if(presupuestario=="1") // Causa
	{
		ls_proceso="CAUSA";
		if(causadoparcial=="1")
		{
			ls_proceso="CAUSAPARCIAL";
		}
	}
	if(presupuestario=="2") // Compromete y Causa
	{
		ls_proceso="COMPROMETECAUSA";
	}
	if((ls_proceso=="")&&(contable=="1")) // Contable
	{
		ls_proceso="CONTABLE";
	}
	parametros=f.parametros.value;
	if(parametros!="")
	{
		// Div donde se van a cargar los resultados
		divgrid = document.getElementById("cuentas");
		// Instancia del Objeto AJAX
		ajax=objetoAjax();
		// Pagina donde est�n los m�todos para buscar y pintar los resultados
		ajax.open("POST","class_folder/sigesp_cxp_c_recepcion_ajax.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==1)
			{
				//divgrid.innerHTML = "";//<-- aqui iria la precarga en AJAX 
			}
			else
			{
				if(ajax.readyState==4)
				{
					if(ajax.status==200)
					{//mostramos los datos dentro del contenedor
						divgrid.innerHTML = ajax.responseText
					}
					else
					{
						if(ajax.status==404)
						{
							divgrid.innerHTML = "La p�gina no existe";
						}
						else
						{//mostramos el posible error     
							divgrid.innerHTML = "Error:".ajax.status;
						}
					}
					
				}
			}
		}	
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		// Enviar todos los campos a la pagina para que haga el procesamiento
		ajax.send("proceso="+ls_proceso+""+parametros);
	}
}
</script>
<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/validaciones.js"></script>
<?php
if(($ls_operacion=="GUARDAR")||(($ls_operacion=="ELIMINAR")&&(!$lb_valido)))
{
	print "<script language=JavaScript>";
	print "   ue_reload();";
	print "</script>";
}
?>		  
</html>