<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Catalogo Proveedores</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
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
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="">
  <p align="center">
    <input name="operacion" type="hidden" id="operacion">
</p>
  	 <table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
    	<tr>
     	 	<td width="496" colspan="2" class="titulo-celda">Cat&aacute;logo de Proveedores </td>
    	</tr>
	 </table>
	 <br>
	 <table width="500" border="0" cellpadding="0" cellspacing="0" class="formato-blanco" align="center">
      <tr>
        <td width="67"><div align="right">Codigo</div></td>
        <td width="431" height="22"><div align="left">
          <input name="codigo" type="text" id="codigo">        
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Nombre</div></td>
        <td height="22"><div align="left">
          <input name="nombre" type="text" id="nombre">
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right"><a href="javascript: ue_search();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"> Buscar</a></div></td>
      </tr>
    </table>
	<br>
    <?php
require_once("../shared/class_folder/sigesp_include.php");
$in=new sigesp_include();
$con=$in->uf_conectar();
require_once("../shared/class_folder/class_datastore.php");
$ds=new class_datastore();
require_once("../shared/class_folder/class_sql.php");
$io_sql=new class_sql($con);
require_once("../shared/class_folder/class_mensajes.php");
$io_msg=new class_mensajes();
require_once("../shared/class_folder/class_funciones.php");
$io_fun= new class_funciones();
$arr=$_SESSION["la_empresa"];

if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
	$ls_codigo="%".$_POST["codigo"]."%";
	$ls_nombre="%".$_POST["nombre"]."%";
}
else
{
	$ls_operacion="";

}
print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
print "<tr class=titulo-celda>";
print "<td>C�digo </td>";
print "<td>Nombre del Proveedor</td>";
print "</tr>";
if($ls_operacion=="BUSCAR")
{
	$ls_sql="SELECT cod_pro,nompro,nomreppro,cedrep FROM rpc_proveedor".
			" WHERE cod_pro like '".$ls_codigo."'".
			" AND nompro like '".$ls_nombre."' ";
	$rs_data=$io_sql->select($ls_sql);
	while($row=$io_sql->fetch_row($rs_data))
	{
		print "<tr class=celdas-blancas>";
		$codigo=$row["cod_pro"];
		$nombre=$row["nompro"];
                $representante=$row["nomreppro"];
                $cedrepre=$row["cedrep"];
		print "<td><a href=\"javascript: aceptar('$codigo','$nombre','$representante','$cedrepre');\">".$codigo."</a></td>";
		print "<td>".$nombre."</td>";
		print "</tr>";			
	}
}
print "</table>";
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
  function aceptar(codpro,denpro,nomrep,cedrep)
  {
    ls_opener = opener.document.form1.id;
	if (ls_opener=="sigesp_saf_p_retorno_activos.php")
	   {
		 opener.document.form1.txtcodbenpre.value=codpro;
		 opener.document.form1.txtnombenpre.value=denpro;
	   } 
	else
	   {
		 opener.document.form1.txtcodpro.value=codpro;
		 opener.document.form1.txtdenpro.value=denpro;
                 opener.document.form1.txtcedrepre.value=cedrep;
                 opener.document.form1.txtnomrepre.value=nomrep;

	   }
	close();
  }
  function ue_search()
  {
  f=document.form1;
  f.operacion.value="BUSCAR";
  f.action="sigesp_saf_cat_prov.php";
  f.submit();
  }
</script>
</html>
