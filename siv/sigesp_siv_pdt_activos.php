<?php
session_start();
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if(!array_key_exists("la_logusr",$_SESSION))
{
	print "<script language=JavaScript>";
	print "close();";
	print "</script>";		
}
$ls_logusr=$_SESSION["la_logusr"];
require_once("class_funciones_inventario.php");
$io_fun_inventario= new class_funciones_inventario();
$io_fun_inventario->uf_load_seguridad("SIV","sigesp_siv_p_recepcion.php",$ls_permisos,$la_seguridad,$la_permisos);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title >Registro de Componentes</title>
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
<script type="text/javascript" language="JavaScript1.2" src="js/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/number_format.js"></script>
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
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
--></head>

<body>
<?php
	require_once("../shared/class_folder/class_mensajes.php");
	$io_msg= new class_mensajes();
	require_once("sigesp_siv_c_registroactivo.php");
	$io_siv= new sigesp_siv_c_registroactivo();
	require_once("../shared/class_folder/grid_param.php");
	$io_grid=new grid_param();
	$ls_codart=$io_fun_inventario->uf_obtenervalor_get("codart","");
	$ls_denart=$io_fun_inventario->uf_obtenervalor_get("denart","");
	$li_canart=$io_fun_inventario->uf_obtenervalor_get("canart",0);
	$ls_numordcom=$io_fun_inventario->uf_obtenervalor_get("numordcom","");
	$ls_numconrec=$io_fun_inventario->uf_obtenervalor_get("numconrec","");
	$ls_operacion=$io_fun_inventario->uf_obteneroperacion();
	$lb_valido=$io_siv->uf_siv_load_codigoactivo($ls_codart,&$ls_codact);
	switch ($ls_operacion)
	{
		case "NUEVO":
			if(($ls_codact!="---------------")&&($lb_valido))
			{
				$lb_valido=$io_siv->uf_siv_make_seriales($ls_codact,$li_canart,&$la_object,&$la_title);
			}
			else
			{
				$io_msg->message("El Articulo no tiene Activo asociado");
			}
		break;
		case "GUARDAR":
			$li_canart=$io_fun_inventario->uf_obtenervalor("totalfilas",0);
			$ls_codart=$io_fun_inventario->uf_obtenervalor("txtcodart","");
			$ls_denart=$io_fun_inventario->uf_obtenervalor("txtdenart","");
			$ls_codact=$io_fun_inventario->uf_obtenervalor("txtcodact","");
			$ls_numordcom=$io_fun_inventario->uf_obtenervalor("txtnumordcom","");
			$ls_numconrec=$io_fun_inventario->uf_obtenervalor("txtnumconrec","");
			$lb_valido=$io_siv->uf_saf_insert_dta($ls_codart,$ls_codact,$li_canart,$ls_numordcom,$ls_numconrec,&$la_object,&$la_title,$la_seguridad);
		break;
	}
?>
<div align="center">
  <table width="632" height="143" border="0" class="formato-blanco">
 <form name="form1" method="post" action="">
    <tr>
      <td width="624" height="137"><div align="left">
<table width="624" height="135" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
  <tr>
    <td height="13" colspan="3" class="titulo-ventana">Registro de Seriales de Activos Fijos </td>
  </tr>
  <tr class="formato-blanco">
    <td height="22" colspan="3">          <div align="left">
              <input name="txtdenart" type="text" class="sin-borde2" id="txtdenart" value="<?php print $ls_denart?>" size="70" readonly="true">
    </div></td>
    </tr>
  <tr class="formato-blanco">
    <td height="22" colspan="2"><div align="right">Activo</div></td>
    <td width="523" height="22"><div align="left">
      <input name="txtcodact" type="text" id="txtcodact" value="<?php print $ls_codact; ?>" readonly style="text-align:center">
    </div></td>
  </tr>
  <tr class="formato-blanco">
    <td height="22" colspan="3"><div align="center">
	<?php	
			$io_grid->makegrid($li_canart,$la_title,$la_object,500,"SERIALES E IDENTIFICADORES","activos");
	?>		</div>	</td>
    </tr>
  <tr class="formato-blanco">
    <td height="22" colspan="3"><div align="center">Los seriales aqui registrados se guadaran en estatus de Registro </div></td>
    </tr>
  <tr class="formato-blanco">
    <td width="42" height="28"><div align="right">
      <input name="txtcodart" type="hidden" id="txtcodart" value="<?php print $ls_codart; ?>">
      <input name="totalfilas" type="hidden" id="totalfilas" value="<?php print $li_canart; ?>">
    </div></td>
    <td height="22" colspan="2"><div align="right"><a href="javascript: ue_guardar();">
      <input name="txtnumordcom" type="hidden" id="txtnumordcom" value="<?php print $ls_numordcom; ?>">
      <input name="txtnumconrec" type="hidden" id="txtnumconrec" value="<?php print $ls_numconrec; ?>">
      <img src="../shared/imagebank/tools20/grabar.gif" alt="Guardar" width="20" height="20" border="0"></a><a href="javascript: ue_guardar();">Guardar</a><a href="javascript: ue_cancelar();"><img src="../shared/imagebank/eliminar.gif" alt="Cancelar" width="15" height="15" border="0"></a><a href="javascript: ue_cancelar();">Cancelar</a> </div></td>
    </tr>
</table>

<div align="center">
  <input name="operacion" type="hidden" id="operacion">
      </div>
      </div></td>
    </tr>
    </form>
  </table>
</div>
<p align="center">&nbsp; </p>
</body>
<script language="javascript">
//Funciones de operaciones sobre el comprobante
function ue_guardar()
{
	f=document.form1;
	totrow=f.totalfilas.value;
	lb_valido=true;
	for (li_row=1; li_row<=totrow ;li_row++)
	{
		ls_seract=eval("f.txtseract"+li_row+".value");
		ls_idact=eval("f.txtidact"+li_row+".value");
		if((ls_seract=="")||(ls_idact==""))
		{
			alert("Debe llenar todos los campos en la linea "+li_row+"");
			lb_valido=false;
		}
	}
	if(lb_valido)
	{
		f.operacion.value="GUARDAR";
		f.action="sigesp_siv_pdt_activos.php";
		f.submit();
	}

}
function ue_cancelar()
{
	window.close();
}
</script> 
</html>