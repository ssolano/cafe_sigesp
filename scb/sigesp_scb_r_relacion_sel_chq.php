<?Php
session_start();
if (!array_key_exists("la_logusr",$_SESSION))
   {
	 print "<script language=JavaScript>";
	 print "location.href='sigesp_inicio_sesion.php'";
	 print "</script>";		
   }
$ls_logusr = $_SESSION["la_logusr"];
require_once("class_funciones_banco.php");
$io_fun_banco= new class_funciones_banco();
$io_fun_banco->uf_load_seguridad("SCB","sigesp_scb_r_relacion_sel_chq.php",$ls_permisos,$la_seguridad,$la_permisos);
$ls_reporte   = $io_fun_banco->uf_select_config("SCB","REPORTE","RELACION_CHEQUE","sigesp_scb_rpp_relacion_chq.php","C");
$ls_reporte2  = $io_fun_banco->uf_select_config("SCB","REPORTE","CHEQUE_VOUCHER","sigesp_scb_rpp_voucher_pdf.php","C");
$li_diasem = date('w');
switch ($li_diasem){
  case '0': $ls_diasem='Domingo';
  break; 
  case '1': $ls_diasem='Lunes';
  break;
  case '2': $ls_diasem='Martes';
  break;
  case '3': $ls_diasem='Mi&eacute;rcoles';
  break;
  case '4': $ls_diasem='Jueves';
  break;
  case '5': $ls_diasem='Viernes';
  break;
  case '6': $ls_diasem='S&aacute;bado';
  break;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Relaci&oacute;n Selectiva de Cheques</title>
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
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
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr> 
    <td height="30" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <td width="778" height="20" colspan="11" bgcolor="#E7E7E7">
    <table width="778" border="0" align="center" cellpadding="0" cellspacing="0">			
      <td width="430" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Caja y Banco</td>
	  <td width="350" bgcolor="#E7E7E7"><div align="right"><span class="letras-pequenas"><b><?php print $ls_diasem." ".date("d/m/Y")." - ".date("h:i a ");?></b></span></div></td>
	  <tr>
	    <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	<td bgcolor="#E7E7E7"><div align="right" class="letras-pequenas"><b><?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td>
      </tr>
    </table>
  </td>
  <tr>
    <td height="20" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td height="13" bgcolor="#FFFFFF" class="toolbar">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" bgcolor="#FFFFFF" class="toolbar"><a href="javascript:ue_imprimir('<?php print $ls_reporte ?>','<?php print $ls_reporte2 ?>');"><img src="../shared/imagebank/tools20/imprimir.gif" alt="Imprimir" title="Imprimir" width="20" height="20" border="0"></a><a href="javascript:ue_openexcel();"><img src="../shared/imagebank/tools20/excel.jpg" alt="Excel" title="Excel" width="20" height="20" border="0"></a><a href="sigespwindow_blank.php"><img src="../shared/imagebank/tools20/salir.gif" alt="Salir" title="Salir" width="20" height="20" border="0"></a><img src="../shared/imagebank/tools20/ayuda.gif" alt="Ayuda" title="Ayuda" width="20" height="20"></td>
  </tr>
</table>
  <?Php
require_once("../shared/class_folder/grid_param.php");
$io_grid=new grid_param();

require_once("../shared/class_folder/sigesp_include.php");
$sig_inc=new sigesp_include();
$con=$sig_inc->uf_conectar();

$la_emp=$_SESSION["la_empresa"];
if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
	$ls_codban=$_POST["txtcodban"];
	$ls_ctaban=$_POST["txtcuenta"];
	$ls_denban=$_POST["txtdenban"];
	$ls_dencta=$_POST["txtdenominacion"];
	$ld_fecdesde=$_POST["txtfecdesde"];
	$ld_fechasta=$_POST["txtfechasta"];
	$ls_tiprep=$_POST["cmbtiprep"];
	switch ($ls_tiprep)
	{
		case '1':
			$la_tiprep[0]="selected";
			$la_tiprep[1]="";
		break;
		
		case '2' :
			$la_tiprep[1]="selected";
			$la_tiprep[0]="";
		break;
		
		case '' :
			$la_tiprep[1]="";
			$la_tiprep[0]="";
		break;
	
	}
}
else
{
	$ls_operacion="";	
	$ls_codban="";
	$ls_ctaban="";
	$ls_denban="";
	$ls_dencta="";
	$ld_fecdesde=date("01/m/Y");
	$ld_fechasta=date("d/m/Y");
	$li_row=1;
	$li_total=1;
	$ls_numdoc = "";
	$ld_fecmov = "";
	$ls_conmov = "";
	$ldec_total= "";
	$ls_nomproben="";
	$ls_tiprep="";
	$la_tiprep[0]="";
	$la_tiprep[1]="";
	$object_bancos[$li_row][1]="<input type=checkbox name=chksel".$li_row."  id=chksel".$li_row." value=1 style=width:15px;height:15px>";		
	$object_bancos[$li_row][2]="<input type=text name=txtnumdoc".$li_row."   value='".$ls_numdoc."'  class=sin-borde readonly style=text-align:center size=16 maxlength=15>";
	$object_bancos[$li_row][3]="<input type=text name=txtconmov".$li_row."   value='".$ls_conmov."'  title='".$ls_conmov."' class=sin-borde readonly style=text-align:left size=45 maxlength=255>";
	$object_bancos[$li_row][4]="<input type=text name=txtnomproben".$li_row."   value='".$ls_nomproben."'  title='".$ls_nomproben."' class=sin-borde readonly style=text-align:left size=40 maxlength=255>";
	$object_bancos[$li_row][5]="<input type=text name=txtfecmov".$li_row."   value='".$ld_fecmov."'  class=sin-borde readonly style=text-align:center size=12 maxlength=10>";
	$object_bancos[$li_row][6]="<input type=text name=txtmonto".$li_row."    value='".number_format($ldec_total,2,",",".")."' class=sin-borde readonly style=text-align:right size=22 maxlength=22>";
}

   if($ls_operacion=="CARGAR_DT")
   {
   		uf_cargar_bancos(&$object_bancos,&$li_total,$ls_codban,$ls_ctaban,$ld_fecdesde,$ld_fechasta);
   }
   $title[1]="<input name=chkall type=checkbox id=chkall value=1 style=width:15px;height:15px class=sin-borde onClick=javascript:uf_select_all();>";    $title[2]="Documento";     $title[3]="Concepto"; $title[4]="Proveedor/Beneficiario";  $title[5]="Fecha";   $title[6]="Monto"; 
   $grid="grid";

	function uf_cargar_bancos($object_bancos,$li_row,$ls_codban,$ls_ctaban,$ld_fecdesde,$ld_fechasta) 
	{
	//////////////////////////////////////////////////////////////////////////////
	//
	//	Metodo: uf_cargar_bancos
	//
	//	Access:  public
	//
	//
	//	Returns:		
	//  $object_bancos=  Arreglo de los bancos para enviarlo a la clase grid_param
	//
	//	Description:  Funci�n que se encarga de seleccionar los   bancos y retornarlos en un arreglo de object
	//
	//////////////////////////////////////////////////////////////////////////////
	  
	  $ls_codemp=$_SESSION["la_empresa"]["codemp"];
	  $li_row=0;
	  global $con;
	  require_once("../shared/class_folder/class_sql.php");	
	  require_once("../shared/class_folder/class_funciones.php");	
	  $io_sql=new class_sql($con);	
	  $io_fun=new class_funciones();
	  $ld_fecdesde=$io_fun->uf_convertirdatetobd($ld_fecdesde);	
	  $ld_fechasta=$io_fun->uf_convertirdatetobd($ld_fechasta);	
	  $ls_sql="SELECT   codban, numdoc, codope, ctaban, fecmov, MAX(conmov) AS conmov, SUM(monto-monret) AS total, MAX(nomproben) AS nomproben
	  		   FROM     scb_movbco 
			   WHERE    codemp='".$ls_codemp."' AND codope='CH' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND fecmov between '".$ld_fecdesde."' AND '".$ld_fechasta."'
			   GROUP BY numdoc,codban,ctaban,fecmov,codope
			   ORDER BY numdoc,fecmov ASC";
	 
	   $rs_bancos=$io_sql->select($ls_sql);
	   
	   if (($rs_bancos===false))
	   {
			$lb_valido=false;		
	   }
	   else
	   {
		   while($row=$io_sql->fetch_row($rs_bancos))
		   {
				$li_row++;
				$ls_numdoc    = $row["numdoc"];
				$ld_fecmov    = $io_fun->uf_formatovalidofecha($row["fecmov"]);
				$ld_fecmov    = $io_fun->uf_convertirfecmostrar($ld_fecmov);
				$ls_conmov    = $row["conmov"];
				$ldec_total   = $row["total"];
				$ls_nomproben = $row["nomproben"];
				$object_bancos[$li_row][1]="<input type=checkbox name=chksel".$li_row."  id=chksel".$li_row." value=1 style=width:15px;height:15px>";		
				$object_bancos[$li_row][2]="<input type=text name=txtnumdoc".$li_row."     value='".$ls_numdoc."'     class=sin-borde readonly style=text-align:center size=16 maxlength=15>";
				$object_bancos[$li_row][3]="<input type=text name=txtconmov".$li_row."     value='".$ls_conmov."'     title='".$ls_conmov."' class=sin-borde readonly style=text-align:left size=45 maxlength=255>";
				$object_bancos[$li_row][4]="<input type=text name=txtnomproben".$li_row."  value='".$ls_nomproben."'  title='".$ls_nomproben."' class=sin-borde readonly style=text-align:left size=40 maxlength=255>";
				$object_bancos[$li_row][5]="<input type=text name=txtfecmov".$li_row."     value='".$ld_fecmov."'     class=sin-borde readonly style=text-align:center size=12 maxlength=10>";
			    $object_bancos[$li_row][6]="<input type=text name=txtmonto".$li_row."      value='".number_format($ldec_total,2,",",".")."' class=sin-borde readonly style=text-align:right size=22 maxlength=22>";
		   }
		   if($li_row==0)
		   {
				$li_row=1;
				$object_bancos[$li_row][1]="<input type=checkbox name=chksel".$li_row."  id=chksel".$li_row." value=1          style=width:15px;height:15px>";		
				$object_bancos[$li_row][2]="<input type=text name=txtnumdoc".$li_row."     value=''  class=sin-borde readonly  style=text-align:center  size=16 maxlength=15>";
				$object_bancos[$li_row][3]="<input type=text name=txtconmov".$li_row."     value=''  class=sin-borde readonly  style=text-align:left    size=45 maxlength=255>";
				$object_bancos[$li_row][4]="<input type=text name=txtnomproben".$li_row."  value=''  class=sin-borde readonly  style=text-align:left    size=40 maxlength=255>";
				$object_bancos[$li_row][5]="<input type=text name=txtfecmov".$li_row."     value=''  class=sin-borde readonly  style=text-align:center  size=12 maxlength=10>";
			    $object_bancos[$li_row][6]="<input type=text name=txtmonto".$li_row."      value=''  class=sin-borde readonly  style=text-align:right   size=22 maxlength=22>";
		   }
		   $io_sql->free_result($rs_bancos);
	   }
	}//fin de uf_cargar_bancos
?>
</div> 
<p>&nbsp;</p>
<form name="form1" method="post" action="">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_banco->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_banco);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
  <table width="524" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
   
    <tr>
      <td width="64"></td>
    </tr>
    <tr class="titulo-ventana">
      <td height="22" colspan="2" align="center">Relacion Selectiva de Cheques </td>
    </tr>
    <tr>
      <td height="13" colspan="2" style="text-align:left">&nbsp;</td>
    </tr>
    <tr style="visibility:hidden">
      <td height="22" colspan="2" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reporte en
          <select name="cmbbsf" id="cmbbsf">
            <option value="0" selected>Bs.</option>
            <option value="1">Bs.F.</option>
          </select>
          <input name="txttipocuenta" type="hidden" id="txttipocuenta">      <input name="txtdentipocuenta" type="hidden" id="txtdentipocuenta">
          <input name="txtcuenta_scg" type="hidden" id="txtcuenta_scg" style="text-align:center" value="<?php print $ls_cuenta_scg;?>" size="24" readonly>
          <input name="txtdisponible" type="hidden" id="txtdisponible" style="text-align:right" size="24" readonly></td>
    </tr>
    <tr>
      <td height="22" style="text-align:right">Banco</td>
      <td width="458" height="22" style="text-align:left"><input name="txtcodban" type="text" id="txtcodban"  style="text-align:center" size="10" value="<?php print $ls_codban;?>" readonly>
        <a href="javascript:cat_bancos();"><img src="../shared/imagebank/tools15/buscar.gif" width="15" height="15" border="0" alt="Cat&aacute;logo de Bancos"></a>
        <input name="txtdenban" type="text" id="txtdenban" size="65" class="sin-borde" readonly value="<?php print $ls_denban;?>">      </td>
    </tr>
    <tr>
      <td height="22" style="text-align:right">Cuenta</td>
      <td height="22" style="text-align:left"><input name="txtcuenta" type="text" id="txtcuenta" style="text-align:center" size="30" maxlength="25" value="<?php print $ls_ctaban;?>" readonly>
        <a href="javascript:catalogo_cuentabanco();"><img src="../shared/imagebank/tools15/buscar.gif" width="15" height="15" border="0" alt="Cat&aacute;logo de Cuentas Bancarias"></a>
        <input name="txtdenominacion" type="text" class="sin-borde" id="txtdenominacion" style="text-align:left" size="48" maxlength="254" readonly value="<?php print $ls_dencta;?>">      </td>
    </tr>
    <tr>
      <td height="22" colspan="2" align="center"><div align="right"></div>        <table width="483" border="0" cellspacing="0" class="formato-blanco">
          <tr class="titulo-celda">
            <td colspan="4" align="center"><strong>Intervalo de Fechas </strong></td>
          </tr>
          <tr>
            <td width="56" height="22" align="right">Desde</td>
            <td width="177" align="left"><input name="txtfecdesde" type="text" id="txtfecdesde" value="<?php print $ld_fecdesde;?>" style="text-align:center" datepicker="true" onKeyPress="javascript:currencyDate(this)" size=18 maxlength="10">            </td>
            <td width="51" align="right">Hasta</td>
            <td width="186" align="left"><input name="txtfechasta" type="text" id="txtfechasta" value="<?php print $ld_fechasta;?>" style="text-align:center" datepicker="true" onKeyPress="javascript:currencyDate(this)" size=18 maxlength="10">            </td>
          </tr>
		 
      </table></td>
    </tr>
	 <tr >
			<td height="28" align="right">Tipo de Reporte</td>
			<td height="28" colspan="2">
			  <select name="cmbtiprep" id="cmbtiprep">
				<option value="" selected>--Seleccione--</option>
				<option value="1" <?php print $la_tiprep[0];?>>Listado de Relaci&oacute;n de Cheques</option>
				<option value="2" <?php print $la_tiprep[1];?>>Cheque Vouchers</option>				
				</select>
			</td>
 		 </tr>
    <tr>
      <td height="22" align="center">     <div align="left"><span class="Estilo1">
        <input name="operacion"   type="hidden"   id="operacion"   value="<?php print $ls_operacion;?>">
      </span></div></td>
      <td height="22" align="center"><div align="left"><a href="javascript: uf_cargar_dt();">Cargar Movimientos</a></div></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <p>&nbsp;</p>
        <?php $io_grid->makegrid($li_total,$title,$object_bancos,400,'Bancos ',$grid);?></td>
    </tr>
  </table>
 
</table>

<input name="total" type="hidden" id="total" value="<?php print $li_total;?>">
</p>
</form>      
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
f = document.form1;
	function ue_imprimir(ls_reporte,ls_reporte2)
	{
	  li_total       = f.total.value;
	  ls_documentos  = "";
	  ls_fechas      = "";
	  ls_operaciones = "";
	  ls_codban      = f.txtcodban.value;
	  ls_denban      = f.txtdenban.value;
	  ls_ctaban		 = f.txtcuenta.value;
	  ls_dencta		 = f.txtdenominacion.value;	  
	  ld_fecdes      = f.txtfecdesde.value;
	  ld_fechas      = f.txtfechasta.value;
	  ls_tiporeporte = f.cmbbsf.value;
	  li_imprimir    = f.imprimir.value;
	  ls_tiprep	     = f.cmbtiprep.value;
	  if (li_imprimir=='1')
	     {
			  if (ls_tiprep=="")
			  {
			    alert ('Debe seleccionar el Tipo de Reporte');
			  
			  }
			  else if (ls_tiprep=="1")
			  {
			  
					  for(li_i=1;li_i<=li_total;li_i++)
					  {
						ls_numdoc=eval("f.txtnumdoc"+li_i+".value");
						ld_fecmov=eval("f.txtfecmov"+li_i+".value");
						ls_codope='CH';
						if(eval("f.chksel"+li_i+".checked==true"))
						{
							if(ls_documentos.length>0)
							{
								ls_documentos=ls_documentos+","+ls_numdoc;
								ls_fechas=ls_fechas+"-"+ld_fecmov;
								ls_operaciones=ls_operaciones+"-"+ls_codope;
							}
							else
							{
								ls_documentos=ls_numdoc;
								ls_fechas=ld_fecmov;
								ls_operaciones=ls_codope;
							}
						}
					  }
					  if(ls_documentos.length>0)
					  {
							  pagina="reportes/"+ls_reporte+"?codban="+ls_codban+"&ctaban="+ls_ctaban+"&hidnomban="+ls_denban+"&dencta="+ls_dencta+"&documentos="+ls_documentos+"&fechas="+ls_fechas+"&operaciones="+ls_operaciones+"&fecdesde="+ld_fecdes+"&fechasta="+ld_fechas+"&tiporeporte="+ls_tiporeporte;  	
							  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,resizable=yes,location=no");		  
					  }
					  else
					  {
							alert("Debe seleccionar al menos un documento !!!");
					  }
			}
			else
			{
				for(li_i=1;li_i<=li_total;li_i++)
					  {
						ls_numdoc=eval("f.txtnumdoc"+li_i+".value");
						ld_fecmov=eval("f.txtfecmov"+li_i+".value");
						ls_codope='CH';
						if(eval("f.chksel"+li_i+".checked==true"))
						{
							if(ls_documentos.length>0)
							{
								ls_documentos=ls_documentos+","+ls_numdoc;
								ls_fechas=ls_fechas+"-"+ld_fecmov;
								ls_operaciones=ls_operaciones+"-"+ls_codope;
							}
							else
							{
								ls_documentos=ls_numdoc;
								ls_fechas=ld_fecmov;
								ls_operaciones=ls_codope;
							}
						}
					  }
					  if(ls_documentos.length>0)
					  {                         
							  pagina="reportes/"+ls_reporte2+"?codban="+ls_codban+"&ctaban="+ls_ctaban+"&hidnomban="+ls_denban+"&dencta="+ls_dencta+"&documentos="+ls_documentos+"&fechas="+ls_fechas+"&operaciones="+ls_operaciones+"&fecdesde="+ld_fecdes+"&fechasta="+ld_fechas+"&tiporeporte="+ls_tiporeporte+"&tipimp=lote";  	
							  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,resizable=yes,location=no");		  
					  }
					  else
					  {
							alert("Debe seleccionar al menos un documento !!!");
					  }
			}
		 }
	  else
	     {
	       alert("No tiene permiso para realizar esta operaci�n !!!");
		 }
	}

	function ue_openexcel()
	{
	  f				 = document.form1;
	  li_total		 = f.total.value;
	  ls_documentos  = "";
	  ls_fechas		 = "";
	  ls_operaciones = "";
	  ls_codban		 = f.txtcodban.value;
	  ls_denban		 = f.txtdenban.value;
	  ls_ctaban		 = f.txtcuenta.value;
	  ls_dencta		 = f.txtdenominacion.value;
	  ls_tiporeporte = f.cmbbsf.value;	  
	  ld_fecdes      = f.txtfecdesde.value;
	  ld_fechas      = f.txtfechasta.value;
	  li_imprimir    = f.imprimir.value;
	  ls_tiprep	     = f.cmbtiprep.value;
	  if (li_imprimir=='1')
	     {
			 if (ls_tiprep=="")
			 {
			    alert ('Debe seleccionar el Tipo de Reporte');
			  
			 }
			 else if (ls_tiprep=="2")
			 {
			 	alert ('No puede generar un reporte en Excel de Cheque Vouchers');
			 }
			 else
			 {
					 for(li_i=1;li_i<=li_total;li_i++)
					  {
						ls_numdoc=eval("f.txtnumdoc"+li_i+".value");
						ld_fecmov=eval("f.txtfecmov"+li_i+".value");
						ls_codope='CH';
						if(eval("f.chksel"+li_i+".checked==true"))
						{
							if(ls_documentos.length>0)
							{
								ls_documentos=ls_documentos+","+ls_numdoc;
								ls_fechas=ls_fechas+"-"+ld_fecmov;
								ls_operaciones=ls_operaciones+"-"+ls_codope;
							}
							else
							{
								ls_documentos=ls_numdoc;
								ls_fechas=ld_fecmov;
								ls_operaciones=ls_codope;
							}
						}
					  }
					  if(ls_documentos.length>0)
					  {
							pagina="reportes/sigesp_scb_rpp_relacion_chq_excel.php?codban="+ls_codban+"&ctaban="+ls_ctaban+"&hidnomban="+ls_denban+"&dencta="+ls_dencta+"&documentos="+ls_documentos+"&fechas="+ls_fechas+"&operaciones="+ls_operaciones+"&tiporeporte="+ls_tiporeporte+"&fecdesde="+ld_fecdes+"&fechasta="+ld_fechas;    	
							  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,resizable=yes,location=no");		  
					  }
					  else
					  {
							alert("Debe seleccionar al menos un documento !!!");
					  }
			 }
		}
	  else
	     {
	       alert("No tiene permiso para realizar esta operaci�n !!!");
		 }
	}
	
	
	function uf_cargar_dt()
	{
		f=document.form1;
		ls_codban=f.txtcodban.vlaue;
		ls_ctaban=f.txtcuenta.value;
		ld_fecdesde=f.txtfecdesde.value;
		ld_fechasta=f.txtfechasta.value;	
		if((ls_codban!="")&&(ls_ctaban!="")&&(ld_fecdesde!="")&&(ld_fechasta!=""))
		{
			f.operacion.value='CARGAR_DT';
			f.action='sigesp_scb_r_relacion_sel_chq.php';	
			f.submit();
		}
		else
		{
			alert("Seleccione los par�metros de b�squeda !!!");
		}	
	}


	function catalogo_cuentabanco()
	 {
	   f=document.form1;
	   ls_codban=f.txtcodban.value;
	   ls_nomban=f.txtdenban.value;
	  	   if((ls_codban!=""))
		   {
			   pagina="sigesp_cat_ctabanco.php?codigo="+ls_codban+"&hidnomban="+ls_nomban;
			   window.open(pagina,"_blank","menubar=no,toolbar=no,scrollbars=yes,width=630,height=400,resizable=yes,location=no");
		   }
		   else
		   {
				alert("Seleccione el Banco !!!");   
		   }	  
	 }	
	 	 
	 function cat_bancos()
	 {
	   f=document.form1;
	   pagina="sigesp_cat_bancos.php";
	   window.open(pagina,"_blank","menubar=no,toolbar=no,scrollbars=yes,width=560,height=400,resizable=yes,location=no");
	 }

	function uf_select_all()
	{
		  f=document.form1;
		  total=f.total.value;
		  sel_all=f.chkall.value;
		  if(f.chkall.checked)
		  {
			  for(i=1;i<=total;i++)	
			  {
				eval("f.chksel"+i+".checked=true");
			  }		  
		 }
		 else
		 {
			 for(i=1;i<=total;i++)	
			  {
				eval("f.chksel"+i+".checked=false");
			  }		  
		 }
	}
	
	
function currencyDate(date)
  { 
	ls_date=date.value;
	li_long=ls_date.length;
	f=document.form1;
			 
		if(li_long==2)
		{
			ls_date=ls_date+"/";
			ls_string=ls_date.substr(0,2);
			li_string=parseInt(ls_string,10);

			if((li_string>=1)&&(li_string<=31))
			{
				date.value=ls_date;
			}
			else
			{
				date.value="";
			}
			
		}
		if(li_long==5)
		{
			ls_date=ls_date+"/";
			ls_string=ls_date.substr(3,2);
			li_string=parseInt(ls_string,10);
			if((li_string>=1)&&(li_string<=12))
			{
				date.value=ls_date;
			}
			else
			{
				date.value=ls_date.substr(0,3);
			}
		}
		if(li_long==10)
		{
			ls_string=ls_date.substr(6,4);
			li_string=parseInt(ls_string,10);
			if((li_string>=1900)&&(li_string<=2090))
			{
				date.value=ls_date;
			}
			else
			{
				date.value=ls_date.substr(0,6);
			}
		}
   }
</script>
<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
</html>