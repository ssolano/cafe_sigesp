<?php
  header("Cache-Control:no-cache");
  header("Pragma:no-cache")
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Catálogo de Personal - Liquidación</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!-- LIBRERIAS Y ESTILOS COMUNES EN TODAS LAS PAGINAS -->
<script type="text/javascript" language="JavaScript1.2" src="../../../shared/js/librerias_comunes.js"></script>

<!-- LIBRERIA ESPECIFICA DE ESTA PAGINA -->
<script type="text/javascript" language="javascript1.2" src="../js/sps_cat_rep_liquidacion.js"></script>

<link href="../../../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../../../shared/css/tablas.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="javascript:ue_ver_personal_liq();">
<form name="form1" method="post" action="">
 <table width="500" border="0"  class="formato-blanco" >
	<tr class="titulo-celda">
	  <td colspan="2" class="titulo-ventana">
	    <p>Cat&aacute;logo de Personal - Liquidación </p>
      </td>
	</tr>
	<tr><td colspan="2"><td width="1%"></tr>
	<tr>
	  <td colspan="2">    
	  <td>        </tr>
	<tr>
	  <td width="30%"><div align="right">Nº Personal </div>
	  <td width="69%"><label>
	  <input name="txtcodper" type="text" id="txtcodper" onKeyPress="return validaCajas(this,'i',event,50);" onKeyUp="ue_ver_personal_liq(this);">
	  </label>      
	  <td>        </tr>
	<tr>
	  <td><div align="right">Nombre    </div>
	  <td><label>
	    <input name="txtnomper" type="text" id="txtnomper" onKeyPress="return validaCajas(this,'s',event,50);" onKeyUp="ue_ver_personal_liq(this);">
	  </label>    
	  <td>    
    </tr>
	<tr>
	  <td><div align="right">Apellido    </div>
	  <td><label>
	    <input name="txtapeper" type="text" id="txtapeper" onKeyPress="return validaCajas(this,'s',event,50);" onKeyUp="ue_ver_personal_liq(this);">
	  </label>      
	  <td>        </tr>
	<tr>
	  <td colspan="2">    
	  <td>        </tr>
	<tr><td colspan="2">
	 <!-- Marcador para mostrar la numeracion de los registros -->
	 <div class="estilo-catalogo" id="marcador" name="marcador">Mostrando Registros</div> 
	<td></tr>
 </table>
 
 <!-- Tabla para la cabecera (titulos) -->
 <table id="data_grid_header" width="500" class="fondo-tabla" cellpadding="1" cellspacing="1">
  <tr class="estilo-celda">
   <td width="120" class="titulo-celda"  > Nº Personal </font></td>
   <td width="190" class="titulo-celda"  > Nombre </font></td>
   <td width="190" class="titulo-celda"  > Apellido </font></td>
  </tr>
 </table>
 
 <!-- Div dentro del cual ira la Tabla para mostrar los datos (registros) -->
 <div id="viewPort">
 </div>
 
</form>
</body>
</html>