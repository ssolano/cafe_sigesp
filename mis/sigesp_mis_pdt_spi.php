<?php
	session_start();
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "opener.document.form1.submit();";
		print "</script>";		
	}
	$ls_modalidad=$_SESSION["la_empresa"]["estmodest"];
	switch($ls_modalidad)
	{
		case "1": // Modalidad por Proyecto
			$ls_titulo="Estructura Presupuestaria ";
			$li_len1=20;
			$li_len2=6;
			$li_len3=3;
			$li_len4=2;
			$li_len5=2;
			break;
			
		case "2": // Modalidad por Presupuesto
			$ls_titulo="Estructura Program�tica ";
			$li_len1=2;
			$li_len2=2;
			$li_len3=2;
			$li_len4=2;
			$li_len5=2;
			break;
	}

   //----------------------------------------------------------------------------------------------------------------------------
   function uf_imprimirresultados($as_codcom,$as_procede)
   {
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_imprimirresultados
		//		   Access: private
		//	    Arguments: as_codcom  // Comprobante
		//	    		   as_procede  // Procede del Documento
		//	  Description: Funci�n que Imprime los detalles del comprobante
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 31/10/2006 								Fecha �ltima Modificaci�n : 
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $in_class_mis;
		global $ls_titulo, $li_len1, $li_len2, $li_len3, $li_len4, $li_len5;
		
		require_once("../shared/class_folder/sigesp_include.php");
		$in=new sigesp_include();
		$con=$in->uf_conectar();
		require_once("../shared/class_folder/class_mensajes.php");
		$io_mensajes=new class_mensajes();
		require_once("../shared/class_folder/class_sql.php");
		$io_sql=new class_sql($con);
		require_once("../shared/class_folder/class_sql.php");
		$io_sql2=new class_sql($con);
		require_once("../shared/class_folder/class_funciones.php");
		$io_funciones=new class_funciones();
        $ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_sql="SELECT comprobante,fecha,procede,descripcion ". 
				"  FROM sigesp_cmp_md ".
				" WHERE codemp = '".$ls_codemp."' ".
				"   AND procede = '".$as_procede."' ".
				"   AND comprobante = '".$as_codcom."' ";
		$rs_data=$io_sql->select($ls_sql);
		if($rs_data===false)
		{
        	$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql->message)); 
		}
		else
		{
			while($row=$io_sql->fetch_row($rs_data))
			{
				$ls_comprobante=$row["comprobante"];
				$ld_fecha=$io_funciones->uf_convertirfecmostrar($row["fecha"]);
				$ls_procede=$row["procede"];
				$ls_descripcion=$row["descripcion"];

				print "<table width='450' height='20' border='0' align='center' cellpadding='0' cellspacing='0'>";
				print "	<tr>";
				print "		<td width='450' class='titulo-ventana'>Informaci�n del Comprobante</td>";
				print " </tr>";
				print "</table>";
				print "<table width='450' border=0 cellpadding=1 cellspacing=1 align='center' class='formato-blanco'>";
				print "  <tr>";
				print "		<td width='100'><div align='right' class='texto-azul'>Comprobante</div></td>";
				print "		<td width='350'><div align='left'>".$ls_comprobante."</div></td>";
				print "  </tr>";
				print "  <tr>";
				print "		<td><div align='right' class='texto-azul'>Fecha </div></td>";
				print "		<td><div align='justify'>".$ld_fecha."</div></td>";
				print "  </tr>";
				print "  <tr>";
				print "		<td><div align='right' class='texto-azul'>Procede</div></td>";
				print "		<td><div align='left'>".$ls_procede."</div></td>";
				print "  </tr>";
				print "  <tr>";
				print "		<td><div align='right' class='texto-azul'>Descripci�n</div></td>";
				print "		<td><div align='left'>".$ls_descripcion."</div></td>";
				print "  </tr>";
				print "  <tr>";
				print "		<td><div align='right' class='texto-azul'></div></td>";
				print "		<td><div align='left'></div></td>";
				print "  </tr>";
				print "</table>";
				$ls_sql="SELECT spi_cuenta, monto, codestpro1,  codestpro2, codestpro3,  codestpro4, codestpro5,estcla ".
						"  FROM spi_dtmp_cmp ".
						" WHERE codemp = '".$ls_codemp."' ".
						"   AND procede = '".$as_procede."' ".
						"   AND comprobante = '".$as_codcom."' ";
				$rs_data2=$io_sql2->select($ls_sql);
				if($rs_data2===false)
				{
					$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql2->message)); 
				}
				else
				{
					//-------------------------------------------------
						$ls_estpreing=$_SESSION["la_empresa"]["estpreing"];
						$ls_estmodest     = $_SESSION["la_empresa"]["estmodest"];
						$li_loncodestpro1 = $_SESSION["la_empresa"]["loncodestpro1"];
						$li_loncodestpro2 = $_SESSION["la_empresa"]["loncodestpro2"];
						$li_loncodestpro3 = $_SESSION["la_empresa"]["loncodestpro3"];
						$li_loncodestpro4 = $_SESSION["la_empresa"]["loncodestpro4"];
						$li_loncodestpro5 = $_SESSION["la_empresa"]["loncodestpro5"];
					//--------------------------------------------------
					if ($ls_estpreing==0)
					{
						print "<table width='450' height='20' border='0' align='center' cellpadding='0' cellspacing='0' class='formato-blanco'>";
						print "	<tr>";
						print "		<td colspan='2' class='titulo-celdanew'>Detalle Presupuestario de Ingreso</td>";
						print " </tr>";
						print " <tr class=titulo-celdanew>";
						print "		<td width='150'>Cuenta</td>";
						print "		<td width='150'>Monto</td>";
						print "	</tr>";
					}
					else
					{
						print "<table width='450' height='20' border='0' align='center' cellpadding='0' cellspacing='0' class='formato-blanco'>";
						print "	<tr>";
						print "		<td colspan='12' class='titulo-celdanew'>Detalle Presupuestario de Ingreso</td>";
						print " </tr>";
						print " <tr class=titulo-celdanew>";
						print "		<td width='150'>Estructura Presupuestaria</td>";
						print "		<td width='150'>Estatus</td>";
						print "		<td width='150'>Cuenta</td>";
						print "		<td width='150'>Monto</td>";
						print "	</tr>";
					}
					$li_total=0;
					while($row=$io_sql2->fetch_row($rs_data2))
					{
						$ls_cuenta=$row["spi_cuenta"];
						$li_total=$li_total+$row["monto"];
						$li_monto=$in_class_mis->uf_formatonumerico($row["monto"]);
						//--------------------------------------------------------
						$ls_estcla=$row["estcla"];
						$ls_estatus='';
						switch($ls_estcla)
						{
							case "A":
								$ls_estatus="Acci�n";
								break;
							case "P":
								$ls_estatus="Proyecto";
								break;
						}
						$ls_codestpro1    = trim(substr(substr($rs_data2->fields["codestpro1"],0,25),-$li_loncodestpro1));
						$ls_codestpro2    = trim(substr(substr($rs_data2->fields["codestpro2"],0,25),-$li_loncodestpro2));
						$ls_codestpro3    = trim(substr(substr($rs_data2->fields["codestpro3"],0,25),-$li_loncodestpro3));
						if ($ls_estmodest==2)
						{
						  $ls_denestcla="";
						  $ls_codestpro4   = trim(substr(substr($rs_data2->fields["codestpro4"],0,25),-$li_loncodestpro4));
						  $ls_codestpro5   = trim(substr(substr($rs_data2->fields["codestpro5"],0,25),-$li_loncodestpro5));
						  $ls_programatica = $ls_codestpro1."-".$ls_codestpro2."-".$ls_codestpro3."-".$ls_codestpro4."-".$ls_codestpro5;			
						  }
						  else
						  {
							$ls_programatica = $ls_codestpro1."-".$ls_codestpro2."-".$ls_codestpro3;			
						  }
					    //---------------------------------------------------------------------------------------------------------
						if ($ls_estpreing==0)
						{
							print "<tr class=celdas-blancas>";
							print "<td align=center width='150'>".$ls_cuenta."</td>";
							print "<td align=right width='150'>".$li_monto."  </td>";
							print "</tr>";	
						}
						else
						{
							print "<tr class=celdas-blancas>";
							print "<td align=center width='150'>".$ls_programatica."</td>";
							print "<td align=center width='150'>".$ls_estatus."</td>";
							print "<td align=center width='150'>".$ls_cuenta."</td>";
							print "<td align=right width='150'>".$li_monto."  </td>";
							print "</tr>";
						}				
					}
					$li_total=$in_class_mis->uf_formatonumerico($li_total);
					if ($ls_estpreing==0)
					{
						print "	<tr class=celdas-blancas>";
						print "		<td width='150' align='right' class='texto-azul'>Total</td>";
						print "		<td width='150' align='right' class='texto-azul'>".$li_total."</td>";
						print " </tr>";
						print "</table>";
					}
					else
					{
						print "	<tr class=celdas-blancas>";
						print "		<td colspan='3' align='right' class='texto-azul'>Total</td>";
						print "		<td width='100' align='right' class='texto-azul'>".$li_total."</td>";
						print " </tr>";
						print "</table>";	
					}
				}
				$io_sql2->free_result($rs_data2);
				$ls_sql="SELECT sc_cuenta, debhab, monto ".
						"  FROM scg_dtmp_cmp ".
						" WHERE codemp = '".$ls_codemp."' ".
						"   AND procede = '".$as_procede."' ".
						"   AND comprobante = '".$as_codcom."' ".
						" ORDER BY  debhab ";
				$rs_data2=$io_sql2->select($ls_sql);
				if($rs_data2===false)
				{
					$io_mensajes->message("ERROR->".$io_funciones->uf_convertirmsg($io_sql2->message)); 
				}
				else
				{
					$li_total_deb=0;
					$li_total_hab=0;
					print "<table width='450' height='20' border='0' align='center' cellpadding='0' cellspacing='0' class='formato-blanco'>";
					print "	<tr>";
					print "		<td colspan='3' class='titulo-celdanew'>Detalle Contable</td>";
					print " </tr>";
					print " <tr class=titulo-celdanew>";
					print "		<td width='100'>Cuenta</td>";
					print "		<td width='100'>Debe</td>";
					print "		<td width='100'>Haber</td>";
					print "	</tr>";
					while($row=$io_sql2->fetch_row($rs_data2))
					{
						$ls_cuenta=$row["sc_cuenta"];
						$li_monto=$row["monto"];
						$ls_debhab=$row["debhab"];
						switch($ls_debhab)
						{
							case "D":
								$li_debe=$li_monto;
								$li_debe=$in_class_mis->uf_formatonumerico($li_debe);
								$li_haber="0,00";
								$li_total_deb=$li_total_deb+$li_monto;
								break;
							case "H":
								$li_debe="0,00";
								$li_haber=$li_monto;
								$li_haber=$in_class_mis->uf_formatonumerico($li_haber);
								$li_total_hab=$li_total_hab+$li_monto;
								break;
						}
						print "<tr class=celdas-blancas>";
						print "<td align=center width='100'>".$ls_cuenta."</td>";
						print "<td align=right width='100'>".$li_debe."</td>";
						print "<td align=right width='100'>".$li_haber."</td>";
						print "</tr>";			
					}
					$li_total_deb=$in_class_mis->uf_formatonumerico($li_total_deb);
					$li_total_hab=$in_class_mis->uf_formatonumerico($li_total_hab);
					print "	<tr>";
					print "		<td align=right class='texto-azul'>Total</td>";
					print "		<td align=right class='texto-azul'>".$li_total_deb."</td>";
					print "		<td align=right class='texto-azul'>".$li_total_hab."</td>";
					print " </tr>";
					print "</table>";
				}
				$io_sql2->free_result($rs_data2);
				print "<br><br>";	
			}
		}
		$io_sql->free_result($rs_data);	
   }
   //----------------------------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<script language="javascript">
	if(document.all)
	{ //ie 
		document.onkeydown = function(){ 
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey)){
		window.event.keyCode = 505; 
		}
		if(window.event.keyCode == 505){ 
		return false; 
		} 
		} 
	}
</script>
<title>Detalle Comprobante</title>
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
<?php
	require_once("class_folder/class_funciones_mis.php");
	$in_class_mis=new class_funciones_mis();
	$ls_codcom=$in_class_mis->uf_obtenervalor_get("codcom","");
	$ls_procede=$in_class_mis->uf_obtenervalor_get("procede","");
	uf_imprimirresultados($ls_codcom,$ls_procede);
?>
</div>
</form>
</body>
</html>