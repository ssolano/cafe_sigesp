<?php
	session_start();
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "opener.document.form1.submit();";
		print "</script>";		
	}

   //--------------------------------------------------------------
   function uf_print($as_codmet,$as_desmet)
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_print
		//		   Access: public
		//	    Arguments: as_codmet  // C�digo del m�todo
		//				   as_desmet  // Descripci�n del m�todo
		//				   as_tipo  // Verifica de donde se est� llamando el cat�logo
		//	  Description: Funci�n que obtiene e imprime los resultados de la busqueda
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
		require_once("../shared/class_folder/sigesp_include.php");
		require_once("../shared/class_folder/class_sql.php");
		require_once("../shared/class_folder/class_mensajes.php");
		require_once("../shared/class_folder/class_funciones.php");
		$io_include   = new sigesp_include();
		$io_conexion  = $io_include->uf_conectar();
		$io_sql       = new class_sql($io_conexion);	
		$io_mensajes  = new class_mensajes();		
		$io_funciones = new class_funciones();		
        $ls_codemp    = $_SESSION["la_empresa"]["codemp"];
		print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
		print "<tr class=titulo-celda>";
		print "<td width=50>C�digo</td>";
		print "<td width=400>M�todo</td>";
		print "<td width=50>Tipo</td>";
		print "</tr>";
		$ls_sql = "SELECT codemp,codmet,desmet,tipmet  ".
				  "  FROM sno_metodobanco              ".
				  " WHERE codemp='".$ls_codemp."'      ".
				  "   AND codmet like '".$as_codmet."' ".
				  "   AND desmet like '".$as_desmet."' ".
				  "   AND tipmet='0'                   ".
				  "   AND codmet<>'0100'               ".				 
				  " ORDER BY codmet ASC                ";
		$rs_data=$io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql->message)); 
		}
		else
		{
			while($row=$io_sql->fetch_row($rs_data))
			{
				$ls_codmet=$row["codmet"];
				$ls_desmet=$row["desmet"];
				$ls_tipmet=$row["tipmet"];
				switch ($ls_tipmet)
				{
					case "0";
						$ls_metodo="N�mina";
						break;
				}
				print "<tr class=celdas-blancas>";
				print "<td  width=50  style=text-align:center><a href=\"javascript: uf_aceptar('$ls_codmet','$ls_desmet');\">".$ls_codmet."</a></td>";
				print "<td  width=400 style=text-align:left>".$ls_desmet."</td>";
				print "<td  width=50  style=text-align:center>".$ls_metodo."</td>";
				print "</tr>";		
			}
			$io_sql->free_result($rs_data);
		}
		print "</table>";
		unset($io_include);
		unset($io_conexion);
		unset($io_sql);
		unset($io_mensajes);
		unset($io_funciones);
		unset($ls_codemp);
   }
   //--------------------------------------------------------------
if (array_key_exists("operacion",$_POST))
   {
     $ls_operacion = $_POST["operacion"];
   }
else
   {
     $ls_operacion = "";
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat&aacute;logo de M&eacute;todo Banco</title>
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
  <p align="center">&nbsp;</p>
<table width="500" border="0" cellpadding="1" cellspacing="0" class="formato-blanco" align="center">
      <tr>
        <td height="22" colspan="2" class="titulo-celda">Cat&aacute;logo de M&eacute;todo a Banco<input name="operacion" type="hidden" id="operacion">
        </td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="111" height="22"><div align="right"> M&eacute;todo </div></td>
        <td width="380"><div align="left">
          <input name="txtcodmet" type="text" id="txtcodmet" size="30" maxlength="4" onKeyPress="javascript: ue_mostrar(this,event);">
        </div></td>
      </tr>
      <tr>
        <td height="22"><div align="right">Descripci&oacute;n</div></td>
        <td><div align="left">
          <input name="txtdesmet" type="text" id="txtdesmet" size="60" maxlength="100" onKeyPress="javascript: ue_mostrar(this,event);">
        </div></td>
      </tr>
      <tr>
        <td height="22">&nbsp;</td>
        <td><div align="right"><a href="javascript: ue_search();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"> Buscar</a></div></td>
      </tr>
  </table>
  <br>
<?php
 if ($ls_operacion=="BUSCAR")
	{
		$ls_codmet="%".$_POST["txtcodmet"]."%";
		$ls_desmet="%".$_POST["txtdesmet"]."%";
		uf_print($ls_codmet, $ls_desmet);
	}
	else
	{
		$ls_codmet="%%";
		$ls_desmet="%%";
		uf_print($ls_codmet, $ls_desmet);
	}
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
function uf_aceptar(codmet,desmet)
{
	opener.document.form1.txtmetban.value=codmet;
	opener.document.form1.txtmetban.readOnly=true;
    opener.document.form1.txtnommetban.value=desmet;
	opener.document.form1.txtnommetban.readOnly=true;
	close();
}

function ue_mostrar(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		ue_search();
		return false;
	}
	else
		return true
}

function ue_search()
{
	f=document.form1;
  	f.operacion.value="BUSCAR";
  	f.action="sigesp_scb_cat_metodobanco.php";
  	f.submit();
}
</script>
</html>