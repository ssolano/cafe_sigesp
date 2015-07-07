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
	require_once("class_folder/class_funciones_ins.php");
	$oi_fun_instala=new class_funciones_ins("../");
	$oi_fun_instala->uf_load_seguridad("INS","sigesp_ins_p_reprocesar_existencias.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
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
<title >Mantenimiento a Modulo de Presupuesto de Gasto </title>
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
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
	require_once("class_folder/sigesp_ins_c_reprocesar_existencias.php");
	$io_class_reprocesar=new sigesp_ins_c_reprocesar_existencias();
	if(array_key_exists("operacion",$_POST))
	{
		$ls_operacion= $_POST["operacion"];
	}
	else
	{
		$ls_operacion= "NUEVO";		
	}
	if($ls_operacion=="EJECUTAR")
	{
		$io_class_reprocesar->io_sql->begin_transaction();
		$lb_valido=$io_class_reprocesar->uf_update_existencias($la_seguridad);
		if($lb_valido)
		{
			$io_class_reprocesar->io_sql->commit();
			$io_class_reprocesar->io_mensajes->message("Proceso Ejecutado Satisfactoriamente");
		}
		else
		{
			$io_class_reprocesar->io_sql->rollback();
			$io_class_reprocesar->io_mensajes->message("Ocurrio un error al reprocesar las existencias");
		}
	}
	unset($io_class_reprocesar);
?>

<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td width="780" height="30" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
  <td width="778" height="20" colspan="11" bgcolor="#E7E7E7">
    <table width="778" border="0" align="center" cellpadding="0" cellspacing="0">			
      <td width="430" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Instala</td>
	  <td width="350" bgcolor="#E7E7E7"><div align="right"><span class="letras-pequenas"><b><?php print $ls_diasem." ".date("d/m/Y")." - ".date("h:i a ");?></b></span></div></td>
	  <tr>
	    <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	<td bgcolor="#E7E7E7"><div align="right" class="letras-pequenas"><b><?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td height="20" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
</table>
<form name="form1" method="post" action="">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$oi_fun_instala->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($oi_fun_instala);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
<p>&nbsp;</p>
<table width="442" height="223" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
  <tr>
    <td width="571" height="221" valign="top">
        <p>&nbsp;</p>
        <table width="360" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
          <tr class="titulo-ventana">
            <td colspan="4"><p>Mantenimiento a Modulo de Inventario</p>            </td>
          </tr>
          <tr class="formato-blanco">
            <td width="72" height="18">&nbsp;</td>
            <td width="286" colspan="3">&nbsp;</td>
          </tr>
          <tr class="formato-blanco">
            <td height="22"><div align="right"></div></td>
            <td colspan="3"><div align="left"></div></td>
          </tr>
          <tr class="formato-blanco">
            <td height="22" colspan="4"><div align="center">
              <input name="botejecutar" type="button" class="boton" id="botejecutar" onClick="javascript:uf_ejecutar();" value="Ejecutar">
            </div></td>
          </tr>
          <tr class="formato-blanco">
            <td height="20">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
        <p>
          <input name="operacion" type="hidden" id="operacion">
          <input name="status" type="hidden" id="status" value="<?php print $ls_status;?>">
        </p>
      </td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</body>
<script language="javascript">
function  uf_ejecutar()
{
	f=document.form1;
	li_ejecutar=f.ejecutar.value;
	if(li_ejecutar==1)
	{
		f.operacion.value="EJECUTAR";
		f.action="sigesp_ins_p_reprocesar_existencias.php";
		f.submit();
	}
	else
	{
      alert("No tiene permiso para realizar esra operacion");	
	}	
}
</script>

</html>