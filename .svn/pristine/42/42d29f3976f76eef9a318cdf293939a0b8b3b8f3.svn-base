<?php
	session_start();
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "location.href='../sigesp_inicio_sesion.php'";
		print "</script>";		
	}
$ls_logusr=$_SESSION["la_logusr"];
require_once("class_funciones_banco.php");
$io_fun_banco= new class_funciones_banco();
$io_fun_banco->uf_load_seguridad("SCB","sigesp_scb_p_pago_caficultores.php",$ls_permisos,$la_seguridad,$la_permisos);
$li_diasem  = date('w');
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
<title>Pago de Caficultores</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../shared/css/general.css"  rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css"   rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/number_format.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/valida_tecla.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/valida_fecha.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/funcion_scb.js"></script>
<script type="text/javascript">
function ChangeImg(nr,before,after)
{
	element = document.getElementById(nr);
	ret = (element.src.indexOf(before)>0);
	path = (ret) ? element.src.replace(before,after) : element.src.replace(after,before)
	element.src = path;
	return ret;
}
function SetAllCheckBoxesCustom(FormName, FieldName, checkAll, startIndex)
{
	CheckValue = ChangeImg(checkAll,'imagenes/ico_selectall.gif','imagenes/ico_selectnone.gif')
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = startIndex; i < countCheckBoxes; i++)
			if(!objCheckBoxes[i].disabled)
				objCheckBoxes[i].checked = CheckValue;
}


function SetAllCheckBoxes(FormName, FieldName) {
	SetAllCheckBoxesCustom(FormName, FieldName, "checkAll",  0);
}
</script>
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
<span class="toolbar"><a name="00"></a></span>
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td height="30" colspan="11" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
  <td height="20" colspan="12" bgcolor="#E7E7E7">
    <table width="778" border="0" align="center" cellpadding="0" cellspacing="0">			
      <td width="430" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Caja y Banco</td>
	  <td width="350" bgcolor="#E7E7E7"><div align="right"><span class="letras-pequenas"><b><?php print $ls_diasem." ".date("d/m/Y")." - ".date("h:i a ");?></b></span></div></td>
	  <tr>
	    <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	<td bgcolor="#E7E7E7"><div align="right" class="letras-pequenas"><b><?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td height="13" class="toolbar">&nbsp;</td>
    <td class="toolbar">&nbsp;</td>
    <td class="toolbar">&nbsp;</td>
    <td class="toolbar">&nbsp;</td>
    <td class="toolbar">&nbsp;</td>
    <td class="toolbar">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" width="22" class="toolbar"><div align="center"><a href="javascript: ue_nuevo();"><img src="../shared/imagebank/tools20/nuevo.gif" alt="Nuevo" title="Nuevo" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="22"><div align="center"><a href="javascript: ue_guardar();"><img src="../shared/imagebank/tools20/grabar.gif" alt="Guardar" title="Guardar" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="22"><div align="center"><a href="javascript:ue_imprimir();"><img src="../shared/imagebank/tools20/imprimir.gif" width="20" height="20" border="0" alt="Imprimir" title="Imprimir"></a></div></td>
    <td class="toolbar" width="22"><div align="center"><a href="sigespwindow_blank.php"><img src="../shared/imagebank/tools20/salir.gif" alt="Salir" title="Salir" width="20" height="20" border="0"></a></div></td>
    <td class="toolbar" width="22"><img src="../shared/imagebank/tools20/ayuda.gif" alt="Ayuda" title="Ayuda" width="20" height="20"></td>
    <td class="toolbar" width="668">&nbsp;</td>
  </tr>
</table>
<?php
require_once("sigesp_scb_c_pago_caficultores.php");
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/grid_param.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/ddlb_conceptos.php");
require_once("../shared/class_folder/class_funciones.php");	
	
$io_msg		= new class_mensajes();	
$io_funcion = new class_funciones();	
$io_include	= new sigesp_include();
$ls_conect	= $io_include->uf_conectar();
$obj_con	= new ddlb_conceptos($ls_conect);
$io_grid	= new grid_param();
$io_pago_caficultores  = new sigesp_scb_c_pago_caficultores();
$resultado = $io_pago_caficultores->uf_cargar_pago_caficultores();

?>

<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
    <tr class="titulo-ventana">
      <td height="22" colspan="4"><input name="hidtotfilsel" type="hidden" id="hidtotfilsel" value="<?php echo $li_totfilsel; ?>">
		Transferencias Masivas por el Banco de Venezuela       
      <input name="hidestciescg" type="hidden" id="hidestciescg" value="<?php echo $li_estciescg; ?>">
      <input name="hidestciespg" type="hidden" id="hidestciespg" value="<?php echo $li_estciespg; ?>">
      <input name="hidestciespi" type="hidden" id="hidestciespi" value="<?php echo $li_estciespi; ?>">
      <input name="hidcodtipfon" type="hidden" id="hidcodtipfon" value="<?php echo $ls_codtipfon; ?>">
      <input name="hiddentipfon" type="hidden" id="hiddentipfon">
      <input name="hidmonmaxmov" type="hidden" id="hidmonmaxmov" value="<?php echo $ld_monmaxmov; ?>"></td>
    </tr>
    <tr>
      <td height="22" colspan="4">
      <?php 
      if(!$resultado->EOF)
		{
	
			?>	 
	
	<form name ="listForm" id='listForm' action="sigesp_scb_generar_archivo_txt.php" method="POST" target="_blank">
      <table>
      	<tr>
      		<td colspan="7">
	      		<a href="javascript:;" onclick="SetAllCheckBoxes('listForm', 'selectedIds')">
					<img id="checkAll" name="checkAll" src="imagenes/ico_selectall.gif" title="Seleccionar todos" alt="Seleccionar todos" width="15" height="16" border="0">
				</a>
			</td>
      	</tr>
      	<tr class=titulo-celdanew>
	      	<td>Pagar</td>
	      	<td>Nro. Solicitud</td>
	      	<td>Rif/C.I.</td>
	      	<td>Nombre</td>
			<td>Email</td>
	      	<td>Tipo de Cuenta</td>
	      	<td>Nro. de Cuenta</td>
	      	<td>Monto Factura</td>
      	</tr>
      	
    	<?php 
    	$resultado->MoveFirst();
    	while (!$resultado->EOF)
    	{
    		?>
    	<tr class=celdas-blancas >
    	<td><input type="checkbox" id="selectedIds" name="cxp[]" value="<?php echo $resultado->fields["numsol"]."|".$resultado->fields["rifpro"]."|".$resultado->fields["nompro"]."|".$resultado->fields["email"]."|".$resultado->fields["tipoctaban"]."|".$resultado->fields["ctaban"]."|".$resultado->fields["monsol"]."|".$resultado->fields["swift"];?>"></td>
      	<td><?php echo $resultado->fields["numsol"];?></td>
      	<td><?php echo $resultado->fields["rifpro"];?></td>
      	<td><?php echo $resultado->fields["nompro"];?></td>
		<td><?php echo $resultado->fields["email"];?></td>		
      	<td><?php 
      	if($resultado->fields["tipoctaban"]==1)
      	{
      		echo "Corriente";
      	}
      	elseif($resultado->fields["tipoctaban"]==2)
      	{
			echo "Ahorro"; 		
      	}
      	else
      	{
      		echo "No especificado";
      	}
      	?>
      	</td>
      	<td>
	      	<?php echo $resultado->fields["ctaban"];?>
	    </td>
      	<td>
      		<?php echo $resultado->fields["monsol"];?></td>
    	</tr>
    		<?php 
    		$resultado->MoveNext();
    	}
    	
    	?>  
    	<tr>
    		<td colspan="7" align="center">&nbsp;    </td>
    	</tr>
    	<tr>
    		<td colspan="7" align="center">
    		
    		<input type="button" onClick="javascript: submitform()" value="Generar txt" /></td>
    	</tr>
      </table>
      </form>
		<script type="text/javascript">
			function IsChk(chkName)
			{
				var found = false;
				var chk = document.getElementsByName(chkName+'[]');
				for (var i=0 ; i < chk.length ; i++)
				{
				found = chk[i].checked ? true : found;
				}
				return found;
			}

			function validate(){
				if (IsChk('cxp'))
				{
					return true;
				} 
				else 
				{
					alert ('Debe elegir al menos un caficultor para realizar la transferencia');
					return false;
				}
			}
			 
			function submitform()
			{
			  if(validate())
			  {
				  document.listForm.submit();
				  window.location.reload();
			  }

			}


		</script>
<?php 
		}
		else 
		{
?>
		<p align="center">En estos momentos no hay pagos pendientes por realizar</p>
<?php 			
		}
?> 

      
      &nbsp;</td>
    </tr>
  </table>


</body>	
</script>

<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
</html>