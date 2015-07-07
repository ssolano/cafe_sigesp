<?php
	session_start();
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "opener.document.form1.submit();";
		print "</script>";		
	}

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print($as_codestprog1, $as_codestprog2, $as_codigo, $as_denominacion, $as_tipo)
   	{
		//////////////////////////////////////////////////////////////////////////////
		//	   Function: uf_print
		//	  Arguments: as_codestprog1  // C�digo de la estructura Program�tica 1
		//	  			 as_codestprog2  // C�digo de la estructura Program�tica 2
		//	  			 as_codigo  // C�digo de la estructura Program�tica
		//				 as_denominacion // Denominaci�n de la estructura program�tica
		//				 as_tipo  // Tipo de Llamada del cat�logo
		//	Description: Funci�n que obtiene e imprime los resultados de la busqueda
		//////////////////////////////////////////////////////////////////////////////
		global $io_fun_nomina;
		require_once("../shared/class_folder/sigesp_include.php");
		$io_include=new sigesp_include();
		$io_conexion=$io_include->uf_conectar();
		require_once("../shared/class_folder/class_sql.php");
		$io_sql=new class_sql($io_conexion);	
		require_once("../shared/class_folder/class_mensajes.php");
		$io_mensajes=new class_mensajes();		
		require_once("../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();		
        $ls_codemp=$_SESSION["la_empresa"]["codemp"];
		print "<table width=550 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
		print "<tr class=titulo-celda>";
		print "<td>".$_SESSION["la_empresa"]["nomestpro1"]."</td>";
		print "<td>".$_SESSION["la_empresa"]["nomestpro2"]."</td>";
		print "<td>C�digo </td>";
		print "<td>Denominaci�n</td>";
		print "</tr>";
		$ls_sql="SELECT codestpro1,codestpro2,codestpro3,denestpro3 ".
				"  FROM spg_ep3 ".
				" WHERE codemp='".$ls_codemp."' ".
				"   AND codestpro1 ='".$as_codestprog1."' ".
				"   AND codestpro2 ='".$as_codestprog2."' ".
				"   AND codestpro3 like '".$as_codigo."' ".
				"   AND denestpro3 like '".$as_denominacion."' ".
				" ORDER BY codestpro1,codestpro2,codestpro3";
		$rs_data=$io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql->message)); 
		}
		else
		{
			while($row=$io_sql->fetch_row($rs_data))
			{
				$codestprog1=$row["codestpro1"];
				$codestprog2=$row["codestpro2"];
				$codigo=$row["codestpro3"];
				$denominacion=$row["denestpro3"];
				switch($as_tipo)
				{
					case "":
						print "<tr class=celdas-blancas>";
						print "<td width=30 align=\"center\"><a href=\"javascript: aceptar('$codigo','$denominacion');\">".trim($codestprog1)."</td>";
						print "<td width=30 align=\"center\"><a href=\"javascript: aceptar('$codigo','$denominacion');\">".trim($codestprog2)."</td>";
						print "<td width=30 align=\"center\"><a href=\"javascript: aceptar('$codigo','$denominacion');\">".trim($codigo)."</a></td>";
						print "<td width=130 align=\"left\">".trim($denominacion)."</td>";
						print "</tr>";			
						break;

					case "asignacioncargo":
						print "<tr class=celdas-blancas>";
						print "<td width=30 align=\"center\"><a href=\"javascript: aceptarasignacion('$codigo','$denominacion');\">".trim($codestprog1)."</td>";
						print "<td width=30 align=\"center\">".trim($codestprog2)."</td>";
						print "<td width=30 align=\"center\">".trim($codigo)."</td>";
						print "<td width=130 align=\"left\">".trim($denominacion)."</td>";
						print "</tr>";			
						break;
				}
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
	//-----------------------------------------------------------------------------------------------------------------------------------
	$ls_codestprog1="";
	$ls_denestprog1="";
	$ls_codestprog2="";
	$ls_denestprog2="";
	if(array_key_exists("codestpro1",$_GET))
	{
		$ls_codestprog1=$_GET["codestpro1"];
		$ls_denestprog1=$_GET["denestpro1"];
	}
	if(array_key_exists("codestpro1",$_POST))
	{
		$ls_codestprog1=$_POST["codestpro1"];
		$ls_denestprog1=$_POST["denestpro1"];
	}
	if(array_key_exists("codestpro2",$_GET))
	{
		$ls_codestprog2=$_GET["codestpro2"];
		$ls_denestprog2=$_GET["denestpro2"];
	}
	if(array_key_exists("codestpro2",$_POST))
	{
		$ls_codestprog2=$_POST["codestpro2"];
		$ls_denestprog2=$_POST["denestpro2"];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Catalogo de Programatica Nivel 3 <?php print $_SESSION["la_empresa"]["nomestpro3"];?> </title>
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
  	 <table width="550" border="0" align="center" cellpadding="1" cellspacing="1">
    	<tr>
     	 	<td width="496" height="20" colspan="2" class="titulo-ventana">Cat&aacute;logo <?php print $_SESSION["la_empresa"]["nomestpro3"];?>  </td>
    	</tr>
	 </table>
	 <br>
	 <table width="550" border="0" cellpadding="1" cellspacing="0" class="formato-blanco" align="center">
      <tr>
        <td width="118" height="22"><div align="right"><?php print $_SESSION["la_empresa"]["nomestpro1"]; ?></div></td>
        <td width="380"><div align="left">
          <input name="codestpro1" type="text" id="codestpro1" value="<?php print $ls_codestprog1; ?>" size="22" maxlength="20" readonly style="text-align:center">        
          <input name="denestpro1" type="text" class="sin-borde" id="denestpro1" size="50" value="<?php print $ls_denestprog1; ?>" readonly>
        </div></td>
      </tr>
      <tr>
        <td height="22"><div align="right"><?php print $_SESSION["la_empresa"]["nomestpro2"]; ?></div></td>
        <td><div align="left">
          <input name="codestpro2" type="text" id="codestpro2" value="<?php print  $ls_codestprog2; ?>" size="22" maxlength="6" readonly style="text-align:center">
          <input name="denestpro2" type="text" id="denestpro2" value="<?php print $ls_denestprog2; ?>" size="50" class="sin-borde" readonly>
        </div></td>
      </tr>
      <tr>
        <td height="22"><div align="right">Codigo</div></td>
        <td><input name="txtcodestprog3" type="text" id="txtcodestprog3"  size="22" maxlength="3" style="text-align:center"></td>
      </tr>
      <tr>
        <td height="22"><div align="right">Denominacion</div></td>
        <td><div align="left">
          <input name="denominacion" type="text" id="denominacion"  size="72" maxlength="100">
        </div></td>
      </tr>
      <tr>
        <td height="22">&nbsp;</td>
        <td><div align="right"><a href="javascript: ue_search();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"> Buscar</a></div></td>
      </tr>
  </table>
	<br>
<?php
	require_once("class_funciones_inventario.php");
	$io_fun_nomina=new class_funciones_inventario();
	$ls_operacion =$io_fun_nomina->uf_obteneroperacion();
	$ls_tipo=$io_fun_nomina->uf_obtenertipo();
	if($ls_operacion=="BUSCAR")
	{
		$ls_codigo="%".$_POST["txtcodestprog3"]."%";
		$ls_denominacion="%".$_POST["denominacion"]."%";
		uf_print($ls_codestprog1, $ls_codestprog2, $ls_codigo, $ls_denominacion, $ls_tipo);
	}
	else
	{
		$ls_codigo="%%";
		$ls_denominacion="%%";
		uf_print($ls_codestprog1, $ls_codestprog2, $ls_codigo, $ls_denominacion, $ls_tipo);
	}
	unset($io_fun_nomina);
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
	function aceptar(codestprog2,deno)
	{
		opener.document.form1.denestpro3.value=deno;
		opener.document.form1.codestpro3.value=codestprog2;
		close();
	}
	function aceptarasignacion(codestprog3,deno)
	{
		opener.document.form1.txtdenestpro3.value=deno;
		opener.document.form1.txtcodestpro3.value=codestprog3;
		close();
	}
	function ue_search()
	{
		f=document.form1;
		f.operacion.value="BUSCAR";
		f.action="sigesp_siv_cat_estpro3.php?tipo=<?PHP print $ls_tipo;?>";
		f.submit();
	}
</script>
</html>