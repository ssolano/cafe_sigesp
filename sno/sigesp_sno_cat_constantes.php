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
   function uf_print($as_codigo, $as_denominacion, $as_tipo)
   {
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_print
		//		   Access: public
		//	    Arguments: as_codigo  // c�digo de constantes
		//				   as_denominacion  // Denominaci�n de las constantes
		//				   as_tipo  // Verifica de donde se est� llamando el cat�logo
		//	  Description: Funci�n que obtiene e imprime los resultados de la busqueda
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 01/01/2006 								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		require_once("../shared/class_folder/sigesp_include.php");
		$io_include=new sigesp_include();
		$io_conexion=$io_include->uf_conectar();
		require_once("../shared/class_folder/class_sql.php");
		$io_sql=new class_sql($io_conexion);	
		require_once("../shared/class_folder/class_mensajes.php");
		$io_mensajes=new class_mensajes();		
		require_once("../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();		
		require_once("sigesp_sno_c_constantes.php");
		$io_constante=new sigesp_sno_c_constantes();		
        $ls_codemp=$_SESSION["la_empresa"]["codemp"];
        $ls_codnom=$_SESSION["la_nomina"]["codnom"];
		print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
		print "<tr class=titulo-celda>";
		print "<td width=100>C�digo</td>";
		print "<td width=400>Denominaci�n</td>";
		print "</tr>";
		$ls_sql= "SELECT codcons, nomcon, unicon, equcon, topcon, valcon, reicon, tipnumcon, conespseg, esttopmod,conperenc ".
				 "  FROM sno_constante ".
				 " WHERE codemp='".$ls_codemp."' ".
				 "   AND codnom='".$ls_codnom."'  ".
				 "   AND codcons like '".$as_codigo."' ".
				 "   AND nomcon like '".$as_denominacion."' ".
				 " ORDER BY codcons ASC";
		$rs_data=$io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql->message)); 
		}
		else
		{
			while($row=$io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
				$ls_codcons=$row["codcons"];
				$ls_nomcon=$row["nomcon"];
				$ls_unicon=$row["unicon"];
				$ls_topcon=number_format($row["topcon"],2,",",".");
				$ls_valcon=number_format($row["valcon"],2,",",".");
				$ls_reicon=$row["reicon"];
				$ls_esttopmod=$row["esttopmod"];
				$ls_conespseg=$row["conespseg"];
				$ls_perenc=$row["conperenc"];
				$ls_total=$io_constante->uf_select_valor($ls_codcons);
				if($ls_conespseg=="1")
				{
					$lb_valido=$io_constante->uf_check_seguridad($ls_codcons);
				}
				switch($as_tipo)
				{
					case "":
						if($lb_valido)
						{
							print "<tr class=celdas-blancas>";
							print "<td ><a href=\"javascript: aceptar('$ls_codcons','$ls_nomcon','$ls_unicon','$ls_topcon','$ls_valcon','$ls_reicon','$ls_total','$ls_conespseg','$ls_esttopmod','$ls_perenc');\">".$ls_codcons."</a></td>";
							print "<td>".$ls_nomcon."</td>";
							print "</tr>";			
						}
						else
						{
							print "<tr class=celdas-blancas>";
							print "<td>".$ls_codcons."</td>";
							print "<td>".$ls_nomcon."</td>";
							print "</tr>";			
						}
						break;
					case "IMPORTAR":
						if($lb_valido)
						{
							print "<tr class=celdas-blancas>";
							print "<td ><a href=\"javascript: aceptarimportar('$ls_codcons');\">".$ls_codcons."</a></td>";
							print "<td>".$ls_nomcon."</td>";
							print "</tr>";			
						}
						else
						{
							print "<tr class=celdas-blancas>";
							print "<td>".$ls_codcons."</td>";
							print "<td>".$ls_nomcon."</td>";
							print "</tr>";			
						}
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
		unset($io_constante);
   }
   //--------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat&aacute;logo de Constantes</title>
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
<style type="text/css">
<!--
.Estilo1 {font-size: 11px}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <p align="center">
    <input name="operacion" type="hidden" id="operacion">
</p>
  	 <table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
    	<tr>
     	 	<td width="500" height="20" colspan="2" class="titulo-ventana">Cat&aacute;logo de Constantes</td>
    	</tr>
	 </table>
	 <br>
	 <table width="500" border="0" cellpadding="1" cellspacing="0" class="formato-blanco" align="center">
      <tr>
        <td width="100" height="22"><div align="right">Codigo</div></td>
        <td width="400"><div align="left">
          <input name="codigo" type="text" id="codigo" onKeyPress="javascript: ue_mostrar(this,event);">        
        </div></td>
      </tr>
      <tr>
        <td height="22"><div align="right">Denominacion</div></td>
        <td><div align="left">
          <input name="denominacion" type="text" id="denominacion" onKeyPress="javascript: ue_mostrar(this,event);">
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
		$ls_codigo="%".$_POST["codigo"]."%";
		$ls_denominacion="%".$_POST["denominacion"]."%";
		uf_print($ls_codigo, $ls_denominacion, $ls_tipo);
	}
	else
	{
		$ls_codigo="%%";
		$ls_denominacion="%%";
		uf_print($ls_codigo, $ls_denominacion, $ls_tipo);
	}	
	unset($io_fun_nomina);
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
function aceptar(codcons,nomcon,unicon,topcon,valcon,reicon,total,conespseg,esttopmod,perenc)
{
	opener.document.form1.txtcodcons.value=codcons;
	opener.document.form1.txtcodcons.readOnly=true;
	opener.document.form1.txtnomcon.value=nomcon;
	opener.document.form1.txtunicon.value=unicon;
	opener.document.form1.txttopcon.value=topcon;
	opener.document.form1.txtvalcon.value=valcon;
	if(reicon==1) 
	{
		opener.document.form1.checkreicon.checked=true;
	}
	else
	{
		opener.document.form1.checkreicon.checked=false;
	} 
	if(conespseg==1) 
	{
		opener.document.form1.chkconespseg.checked=true;
	}
	else
	{
		opener.document.form1.chkconespseg.checked=false;
	} 
	if(esttopmod==1) 
	{
		opener.document.form1.chkesttopmod.checked=true;
	}
	else
	{
		opener.document.form1.chkesttopmod.checked=false;
	} 
	if(perenc==1) 
	{
		opener.document.form1.chkperenc.checked=true;
	}
	else
	{
		opener.document.form1.chkperenc.checked=false;
	} 
	opener.document.form1.btnaplicar.disabled=false;
	opener.document.form1.btnpersonal.disabled=false;
	opener.document.form1.existe.value="TRUE";
	close();
}

function aceptarimportar(codcons)
{
	opener.document.form1.txtcodcons.value=codcons;
	opener.document.form1.txtcodcons.readOnly=true;
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
	f.action="sigesp_sno_cat_constantes.php";
	f.submit();
}
</script>
</html>