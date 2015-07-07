<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat�logo de Beneficiarios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
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

<?php
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("class_folder/sigesp_rpc_c_beneficiario.php");

$io_beneficiario = new sigesp_rpc_c_beneficiario();
$io_include      = new sigesp_include();
$ls_conect       = $io_include->uf_conectar();
$io_sql          = new class_sql($ls_conect);
$io_msg          = new class_mensajes();
$ls_codemp       = $_SESSION["la_empresa"]["codemp"];

if (array_key_exists("operacion",$_POST))
   {
	 $ls_operacion=$_POST["operacion"];
   }
else
   {
	$ls_operacion="";
   }
?>
<br>
<form name="form1" method="post" action="">
<table width="473" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr class="titulo-celda">
        <td height="20" colspan="4" style="text-align:center">Cat&aacute;logo de Beneficiarios</td>
      </tr>
      <tr>
        <td height="13" align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="64" height="22" align="right">C&eacute;dula</td>
        <td width="139" height="22"><input name="txtcedula" type="text" id="txtcedula" maxlength="10" style="text-align:center"></td>
        <td width="58" height="22" align="right">Apellido</td>
        <td width="210" height="22"><input name="txtapellido" type="text" id="txtapellido" size="25">
        </td>
      </tr>
      <tr>
        <td height="22" align="right">Nombre</td>
        <td height="22"><input name="txtnombre" type="text" id="nombre" maxlength="100" style="text-align:left"></td>
        <td height="22" align="right">Banco</td>
        <td height="22">
		<?php
		$rs_ben=$io_beneficiario->uf_select_banco($ls_codemp);
		?>  
          <select name="cmbbanco" id="cmbbanco" style="width:150px " >
            <option value="---">---seleccione---</option>
            <?php
		while ($row=$io_sql->fetch_row($rs_ben))
  			  {
			    $ls_codban=$row["codban"];
			    $ls_nomban=$row["nomban"];
			    if ($ls_codban==$ls_banco)
			 	   {
					 print "<option value='$ls_codban' selected>$ls_nomban</option>";
				   }
			    else
				   {
					 print "<option value='$ls_codban'>$ls_nomban</option>";
				   }
			  } 
	  ?>
          </select>
        <input name="operacion" type="hidden" id="operacion"> 
      <tr>
        <td height="21" align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td>      <div align="right"><a href="javascript: ue_search();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0">Buscar</a></div>
  </table> 
<p align="center">
<?php
print "<table width=700 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
print "<tr class=titulo-celda>";
print "<td width=70   style=text-align:center>C�dula</td>";
print "<td width=300  style=text-align:left>Nombre</td>";
print "<td width=230  style=text-align:left>Direcci�n</td>";
print "<td width=100  style=text-align:center>Tel�fono</td>";
print "</tr>";

if ($ls_operacion=="BUSCAR")
   {
     $ls_cedbene = $_POST["txtcedula"];
   	 $ls_nombene = $_POST["txtnombre"];
	 $ls_apebene = $_POST["txtapellido"];
	 $ls_codban  = $_POST["cmbbanco"];
	 $ls_sql = "SELECT rpc_beneficiario.ced_bene,rpc_beneficiario.nombene,rpc_beneficiario.dirbene,
	                   rpc_beneficiario.telbene,scg_cuentas.denominacion
		          FROM rpc_beneficiario, scg_cuentas
				 WHERE rpc_beneficiario.ced_bene like '%".$ls_cedbene."%' 
				   AND rpc_beneficiario.nombene  like '%".$ls_nombene."%'
			       AND rpc_beneficiario.apebene  like '%".$ls_apebene."%' 
				   AND rpc_beneficiario.codban   like '%".$ls_codban."%'
				   AND rpc_beneficiario.sc_cuenta=scg_cuentas.sc_cuenta 
				   AND rpc_beneficiario.ced_bene<>'----------'
				 ORDER BY rpc_beneficiario.ced_bene ASC";
	 $rs_data = $io_sql->select($ls_sql);
	 if ($rs_data===false)
		{
		  $io_msg->message("Error en Consulta, Contacte al Administrador del Sistema !!!");
		}
	 else
		{
		  $li_numrows = $io_sql->num_rows($rs_data);
		  if ($li_numrows>0)
		     {
		       while (!$rs_data->EOF)
				     {
						echo "<tr class=celdas-blancas>";
						$ls_cedbene = trim($rs_data->fields["ced_bene"]);
						$ls_nombene = $rs_data->fields["nombene"];
						$ls_dirbene = $rs_data->fields["dirbene"];
						$ls_telbene = $rs_data->fields["telbene"];						
						echo "<td  width=70   style=text-align:center><a href=\"javascript: aceptar('$ls_cedbene');\">".$ls_cedbene."</a></td>";
						echo "<td  width=300  style=text-align:left>".$ls_nombene."</td>";
						echo "<td  width=230  style=text-align:left>".$ls_dirbene."</td>";
						echo "<td  width=100  style=text-align:right>".$ls_telbene."</td>";
						echo "</tr>";
						$rs_data->MoveNext();
					 }
			 } 
		  else
		     {
			   $io_msg->message("No se han definido Beneficiario para este Criterio !!!");
			 }
		}
   }
echo "</table>";
?>
</p>
</form>
</body>
<script language="JavaScript">
function aceptar(cedula)
{
  buscar=opener.document.form1.hidrango.value;
  if (buscar=="1")
     {
	   opener.document.form1.txtcedula1.value=cedula;
     }
  else
     {
	   opener.document.form1.txtcedula2.value=cedula;   
     }
  close();
}

function ue_search()
{
  f=document.form1;
  f.operacion.value="BUSCAR";
  f.action="sigesp_catdin_bene.php";
  f.submit();
}
</script>
</html>