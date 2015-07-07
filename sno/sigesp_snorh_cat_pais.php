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
   function uf_print($as_codpai, $as_despai, $as_tipo)
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_print
		//		   Access: public
		//	    Arguments: as_codpai  // C�digo de Pa�s
		//				   as_despai  // Descripci�n de Pa�s
		//				   as_tipo  // Tipo de llamada al cat�logo
		//	  Description: Funci�n que obtiene e imprime los resultados de la busqueda
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		//////////////////////////////////////////////////////////////////////////////
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
		print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
		print "<tr class=titulo-celda>";
		print "<td width=60>C�digo</td>";
		print "<td width=440>Descripci�n</td>";
		print "</tr>";
		$ls_sql="SELECT codpai,despai ".
				"  FROM sigesp_pais ".
				" WHERE codpai <> '---' ".
				"	AND codpai like '".$as_codpai."' ".
				"   AND despai like '".$as_despai."'".
				" ORDER BY codpai";
		$rs_data=$io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql->message)); 
		}
		else
		{
			while($row=$io_sql->fetch_row($rs_data))
			{
				$ls_codpai=$row["codpai"];
				$ls_despai=$row["despai"];
				switch($as_tipo)
				{
					case "":
						print "<tr class=celdas-blancas>";
						print "<td><a href=\"javascript: aceptar('$ls_codpai','$ls_despai');\">".$ls_codpai."</a></td>";
						print "<td>".$ls_despai."</td>";
						print "</tr>";
					break;
					case "NACIMIENTO":
						print "<tr class=celdas-blancas>";
						print "<td><a href=\"javascript: aceptarnacimiento('$ls_codpai','$ls_despai');\">".$ls_codpai."</a></td>";
						print "<td>".$ls_despai."</td>";
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
   //--------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat&aacute;logo de Pais</title>
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
      <td width="496" height="20" colspan="2" class="titulo-ventana">Cat&aacute;logo de Pais </td>
    </tr>
  </table>
<br>
    <table width="500" border="0" cellpadding="1" cellspacing="0" class="formato-blanco" align="center">
      <tr>
        <td width="67" height="22"><div align="right">C&oacute;digo</div></td>
        <td width="431"><div align="left">
          <input name="txtcodpai" type="text" id="txtcodpai" size="30" maxlength="3" onKeyPress="javascript: ue_mostrar(this,event);">        
        </div></td>
      </tr>
      <tr>
        <td height="22"><div align="right">Descripci&oacute;n</div></td>
        <td><div align="left">
          <input name="txtdespai" type="text" id="txtdespai" size="30" maxlength="50" onKeyPress="javascript: ue_mostrar(this,event);">
        </div></td>
      </tr>
      <tr>
        <td height="22">&nbsp;</td>
        <td><div align="right"><a href="javascript: ue_search();"><img src="../shared/imagebank/tools20/buscar.gif" title='Buscar' alt="Buscar" width="20" height="20" border="0"> Buscar</a></div></td>
      </tr>
  </table>
  <br>
<?php
	require_once("class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	$ls_operacion =$io_fun_nomina->uf_obteneroperacion();
	$ls_tipo=$io_fun_nomina->uf_obtenertipo();
	if($ls_operacion=="BUSCAR")
	{
		$ls_codpai="%".$_POST["txtcodpai"]."%";
		$ls_despai="%".$_POST["txtdespai"]."%";
		uf_print($ls_codpai, $ls_despai, $ls_tipo);
	}
	else
	{
		$ls_codpai="%%";
		$ls_despai="%%";
		uf_print($ls_codpai, $ls_despai, $ls_tipo);
	}
	unset($io_fun_nomina);
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
function aceptar(codigo,descripcion)
{
	opener.document.form1.txtcodpai.value=codigo;
	opener.document.form1.txtcodpai.readOnly=true;
    opener.document.form1.txtdespai.value=descripcion;
	opener.document.form1.txtcodest.value="";
	opener.document.form1.txtcodest.readOnly=true;
    opener.document.form1.txtdesest.value="";
	opener.document.form1.txtcodmun.value="";
	opener.document.form1.txtcodmun.readOnly=true;
    opener.document.form1.txtdesmun.value="";
	opener.document.form1.txtcodpar.value="";
	opener.document.form1.txtcodpar.readOnly=true;
    opener.document.form1.txtdespar.value="";
	close();
}

function aceptarnacimiento(codigo,descripcion)
{
	opener.document.form1.txtcodpainac.value=codigo;
	opener.document.form1.txtcodpainac.readOnly=true;
    opener.document.form1.txtdespainac.value=descripcion;
	opener.document.form1.txtcodestnac.value="";
	opener.document.form1.txtcodestnac.readOnly=true;
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
  	f.action="sigesp_snorh_cat_pais.php?tipo=<?php print $ls_tipo;?>";
  	f.submit();
}
</script>
</html>
