<?php
session_start();
$dat = $_SESSION["la_empresa"];
if(!array_key_exists("la_logusr",$_SESSION))
{
	print "<script language=JavaScript>";
	print "location.href='../../sigesp_inicio_sesion.php'";
	print "</script>";		
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>selecci&oacute;n de Partida Presupuestaria de Ingresos.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-color: #EAEAEA;
	margin-left: 0px;
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
.Estilo5 {
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo6 {
	color: #006699;
	font-size: 12px;
}
.Estilo8 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo10 {font-size: 10px}
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo13 {font-size: 12px}
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<link href="../css/cfg.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="../spi/js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../../shared/js/valida_tecla.js"></script>
<!--<script type="text/javascript" language="JavaScript1.2" src="../../shared/js/disabled_keys.js"></script>
--><script language="javascript">
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

<style type="text/css">
<!--
a:hover {
	color: #006699;
}
-->
</style></head>
<body>
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td height="20" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="../spi/js/menu.js"></script></td>
  </tr>
  <tr>
    <td height="13" class="toolbar">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="toolbar"><div align="left"><a href="javascript: ue_nuevo();"><img src="../../shared/imagebank/tools20/nuevo.gif" title="Nuevo" alt="Nuevo" width="20" height="20" border="0"></a><a href="javascript: ue_guardar();"><img src="../../shared/imagebank/tools20/grabar.gif" title="Guardar" alt="Grabar" width="20" height="20" border="0"></a><a href="javascript: ue_buscar();"></a><a href="javascript: ue_eliminar();"></a><a href="javascript: ue_buscar();"><img src="../../shared/imagebank/tools20/buscar.gif" title="Buscar" alt="Buscar" width="20" height="20" border="0"><a href="javascript: ue_eliminar();"><img src="../../shared/imagebank/tools20/eliminar.gif" title="Eliminar" alt="Eliminar" width="20" height="20" border="0"></a><a href="javascript: ue_cerrar();"><img src="../../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0"></a><img src="../../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20"></div>      
    <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
</table>
<?php
	require_once("../../shared/class_folder/class_mensajes.php");
	require_once("../../shared/class_folder/class_funciones.php");
	require_once("../../shared/class_folder/class_datastore.php");
	require_once("../../shared/class_folder/class_sigesp_int.php");
	require_once("../../shared/class_folder/class_fecha.php");
	require_once("../../shared/class_folder/class_sql.php");
	require_once("../../shared/class_folder/sigesp_include.php");
	require_once("class_folder/sigesp_spi_c_partingresos.php");
	require_once("../../shared/class_folder/grid_param.php");
	
	$io_grid    = new grid_param();
	$io_fun     = new class_funciones();
	$io_msg     = new class_mensajes();
	$spicta = new sigesp_spi_c_partingresos();
	
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	require_once("../../shared/class_folder/sigesp_c_seguridad.php");
	$io_seguridad= new sigesp_c_seguridad();
	
	$arre       = $_SESSION["la_empresa"];
	$ls_empresa = $arre["codemp"];
	$ls_codemp  = $ls_empresa;
	require_once("../class_folder/class_funciones_configuracion.php");
    $io_fun_cfg=new class_funciones_configuracion();
    $ls_destino=$io_fun_cfg->uf_obtenervalor_get("destino","");
	
	if(array_key_exists("la_logusr",$_SESSION))
	{
	$ls_logusr=$_SESSION["la_logusr"];
	}
	else
	{
	$ls_logusr="";
	}
	$ls_sistema     = "CFG";
	$ls_ventanas    = "sigesp_spi_d_planctas.php";
	$li_estmodest   = $arre["estmodest"];
	$la_security[1] = $ls_empresa;
	$la_security[2] = $ls_sistema;
	$la_security[3] = $ls_logusr;
	$la_security[4] = $ls_ventanas;

	if (array_key_exists("permisos",$_POST)||($ls_logusr=="PSEGIS"))
	{	
		if($ls_logusr=="PSEGIS")
		{
			$ls_permisos="";
			$la_accesos=$io_seguridad->uf_sss_load_permisossigesp();
		}
		else
		{
			$ls_permisos            = $_POST["permisos"];
			$la_accesos["leer"]     = $_POST["leer"];
			$la_accesos["incluir"]  = $_POST["incluir"];
			$la_accesos["cambiar"]  = $_POST["cambiar"];
			$la_accesos["eliminar"] = $_POST["eliminar"];
			$la_accesos["imprimir"] = $_POST["imprimir"];
			$la_accesos["anular"]   = $_POST["anular"];
			$la_accesos["ejecutar"] = $_POST["ejecutar"];
		}
	}
	else
	{
		$la_accesos["leer"]     = "";
		$la_accesos["incluir"]  = "";
		$la_accesos["cambiar"]  = "";
		$la_accesos["eliminar"] = "";
		$la_accesos["imprimir"] = "";
		$la_accesos["anular"]   = "";
		$la_accesos["ejecutar"] = "";
		$ls_permisos            = $io_seguridad->uf_sss_load_permisos($ls_empresa,$ls_logusr,$ls_sistema,$ls_ventanas,$la_accesos);
	}
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if  (array_key_exists("status",$_POST))
	{
  	  $ls_estatus=$_POST["status"];
	}
else
	{
	  $ls_estatus="NUEVO";	  
	}	
	

	$ls_formato    = trim($dat["formspi"]);
	$ls_formatoaux = str_replace( "-", "",$ls_formato);
	$li_size_cta   = strlen($ls_formatoaux);
	if (array_key_exists("operacion",$_POST))
	   {
		 $ls_operacion = $_POST["operacion"];
		 $ls_codestpro1     = $_POST["txtcodestpro1"];
		 $ls_codestpro2     = $_POST["txtcodestpro2"];
		 $ls_codestpro3     = $_POST["txtcodestpro3"];
		 $ls_codestpro4     = $_POST["txtcodestpro4"];
		 $ls_codestpro5     = $_POST["txtcodestpro5"];
		 $ls_estcla	       = $_POST["txtestcla"];
	   }
	else
	   {
		 $ls_operacion = "NUEVO";
		 $ls_codestpro1     = $_GET["txtcodestpro1"];
		 $ls_codestpro2     = $_GET["txtcodestpro2"];
		 $ls_codestpro3     = $_GET["txtcodestpro3"];
		 $ls_codestpro4     = $_GET["txtcodestpro4"];
		 $ls_codestpro5     = $_GET["txtcodestpro5"];
		 $ls_estcla	       = $_GET["txtestcla"];		
	   }
	 	 //Titulos de la grid de Cuentas Presupuestarias.
		$title[1]="Cuenta de Ingreso"; $title[2]="Denominaci�n";  $title[3]="Edici�n";
  		//Nombr del grid
		$grid1="grid";	
		//Total de filas iniciales del grid
		$total=50;
//////////////////////////////////////////////////// N U E V O///////////////////////////////////////////////////////////////////
 if ($ls_operacion=="NUEVO")
	{
	  for ($i=1;$i<=$total;$i++)
		  {
			//Object que contiene los objetos y valores	iniciales del grid.	
			$object[$i][1]="<input type=text name=txtcuentaspi".$i." value='' id=txtcuentaspi".$i."  class=sin-borde style=text-align:center size=20 maxlength=".$li_size_cta." onKeyPress=return keyRestrict(event,'1234567890'); onClick=javascript:uf_rellenar_cuenta('".$li_size_cta."','".$i."');>";		
			$object[$i][2]="<input type=text name=txtdencuenta".$i." value=''  class=sin-borde style=text-align:left size=60 maxlength=254>";
			$object[$i][3] ="<a href=javascript:uf_delete_dt('".$i."');><img src=../../shared/imagebank/tools15/eliminar.gif alt=Cancelar Registro de Detalle Presupuestario width=15 height=15 border=0></a>";
		  }
	  $lastrow      = 0;
	}
	
////////////////////////////////////////////////// G U A R D A R///////////////////////////////////////////////////////////////////
	if($ls_operacion=="GUARDAR")
	{
		$total=$_POST["total"];
		$lastrow=$_POST["lastrow"];
		$li_error=0;
		$li_save=0;
		$ls_estcla 	= $_POST["txtestcla"];
		$ls_codestpro1 = $_POST["txtcodestpro1"];
		$ls_codestpro2 = $_POST["txtcodestpro2"];
	  	$ls_codestpro3 = $_POST["txtcodestpro3"];
		$ls_estcla  = $ls_estcla;
	 	if ($li_estmodest=='2')
		{
		  $ls_codestpro4 = $_POST["txtcodestpro4"];
		  $ls_codestpro5 = $_POST["txtcodestpro5"];
		  $ls_codestpro4  = str_pad($ls_codestpro4,25,0,0);
		  $ls_codestpro5  = str_pad($ls_codestpro5,25,0,0);
		}
		else
		{
		  $ls_codestpro4 = str_pad('',25,0,0);
		  $ls_codestpro5  = str_pad('',25,0,0);
		}
		$ls_codestpro1= str_pad($ls_codestpro1,25,0,0);
	 	$ls_codestpro2= str_pad($ls_codestpro2,25,0,0);
	    $ls_codestpro3= str_pad($ls_codestpro3,25,0,0);
		for($i=1;$i<=$total;$i++)
		{
			$ls_cuentaspi   = $_POST["txtcuentaspi".$i];			
			$ls_dencuentaspi= $_POST["txtdencuenta".$i];
			if(($ls_cuentaspi!="")&&($ls_dencuentaspi!=""))
			{
				$li_len=strlen($ls_cuentaspi);
				if($li_len!=$li_size_cta)
				{
					$ls_cuentaspi=$io_fun->uf_cerosderecha($ls_cuentaspi, $li_size_cta);
				}
			    $lb_valido=$spicta->uf_buscar_contable($ls_cuentaspi,&$ls_cuentascg);
				//if($lb_valido)
				//{
				    $lb_valido=$spicta->uf_valida_cuenta($ls_cuentaspi,$ls_cuentascg);
					if($lb_valido)//Si la cuenta es valida me permite insertar la cuenta
					{
						$lb_valido=$spicta->uf_procesar_cuentas($ls_cuentaspi,$ls_dencuentaspi,$ls_cuentascg,
						                                            $ls_codestpro1,$ls_codestpro2,$ls_codestpro3,$ls_codestpro4,
																	$ls_codestpro5,$ls_estcla,$la_security);
						if(!$lb_valido)//No pudo procesar la cuenta
						{
							$li_error=$li_error+1;
						}
						else//Genero correctamente la cuenta
						{
							$li_save=$li_save+1;
						}
					}
					else//La cuenta no es valida
					{
						$li_error=$li_error+1;
					}
			   // }
			}
			
			//Object que contiene los objetos y valores
			$object[$i][1]="<input type=text name=txtcuentaspi".$i." value='".$ls_cuentaspi."' class=sin-borde style=text-align:center size=20 maxlength=".$li_size_cta." onKeyPress=\"return keyRestrict(event,'1234567890');\" onClick=javascript:uf_rellenar_cuenta('".$li_size_cta."','".$total."');>";		
			$object[$i][2]="<input type=text name=txtdencuenta".$i." value='".$ls_dencuentaspi."' class=sin-borde style=text-align:left size=60 maxlength=254>";
			$object[$i][3]="<a href=javascript:uf_delete_dt('".$i."');><img src=../../shared/imagebank/tools15/eliminar.gif alt=Cancelar Registro de Detalle Presupuestario width=15 height=15 border=0>";
		}
		$io_msg->message("$li_save Cuenta(s) guardada(s) ,$li_error Cuenta(s) con error");
	}
	
	/////////////////////// D E L E T E/////////////////////////////////////////////////////////////////
	//Elimina la fila presionada
	if($ls_operacion=="DELETE")
	{
		$li_fila_del   = $_POST["filadelete"];
		$total         = $_POST["total"];
		$lastrow       = $_POST["lastrow"];
		$lastrow       = $lastrow-1;
		$li_error      = 0;
		$li_save       = 0;
		$li_no_existen = 0;
		$li_temp       = 0;
		for($i=1;$i<=$total;$i++)
		{
			$ls_cuentaspi    = $_POST["txtcuentaspi".$i];
			$ls_dencuentaspi = $_POST["txtdencuenta".$i];
			if($i!=$li_fila_del)
			{
				$li_temp=$li_temp+1;
				$object[$li_temp][1]="<input type=text name=txtcuentaspi".$li_temp." value='".$ls_cuentaspi."' class=sin-borde style=text-align:center size=20 maxlength=".$li_size_cta." onKeyPress=\"return keyRestrict(event,'1234567890');\" onClick=javascript:uf_rellenar_cuenta('".$li_size_cta."','".$total."');>";		
				$object[$li_temp][2]="<input type=text name=txtdencuenta".$li_temp." value='".$ls_dencuentaspi."' class=sin-borde style=text-align:left size=60 maxlength=254>";
		    	$object[$li_temp][3]="<a href=javascript:uf_delete_dt('".$i."');><img src=../../shared/imagebank/tools15/eliminar.gif alt=Cancelar Registro de Detalle Presupuestario width=15 height=15 border=0>";
			}
			else
			{   
			   $object[$total][1]="<input type=text name=txtcuentaspi".$total." value='".$ls_cuentaspi."' class=sin-borde style=text-align:center size=20 maxlength=".$li_size_cta." onKeyPress=\"return keyRestrict(event,'1234567890');\" onClick=javascript:uf_rellenar_cuenta('".$li_size_cta."','".$total."');>";		
			   $object[$total][2]="<input type=text name=txtdencuenta".$total." value='".$ls_dencuentaspi."' class=sin-borde style=text-align:left size=60 maxlength=254>";
			   $object[$total][3]="<a href=javascript:uf_delete_dt('".$total."');><img src=../../shared/imagebank/tools15/eliminar.gif alt=Cancelar Registro de Detalle Presupuestario width=15 height=15 border=0></a>";
			//$io_msg->message("$li_save Cuenta(s) borrada(s) ,$li_error Cuenta(s) con error,$li_no_existen cuentas no existen");

		  }
	 }
  }

	/////////////////////// D E L E T E A L L ///////////////////////////////////////////////////////////////////	
	// Elimina todos las cuentas del detalle
	if($ls_operacion=="DELETEALL")
	{
			$total=$_POST["total"];
			$lastrow=$_POST["lastrow"];
			$li_error=0;
			$li_save=0;
			$li_no_existen=0;
			for($i=1;$i<=$total;$i++)
			{
				$ls_cuentaspi   = $_POST["txtcuentaspi".$i];
				$ls_dencuentaspi= $_POST["txtdencuenta".$i];
				if(($ls_cuentaspi!="")&&($ls_dencuentaspi!=""))			
				{
				    $lb_valido=$spicta->uf_buscar_contable($ls_cuentaspi,&$ls_cuentascg);
					$lb_valido=$spicta->uf_procesar_delete_cuenta($ls_cuentaspi,$ls_dencuentaspi,$ls_cuentascg,
					                                             &$lb_existe,$ls_codestpro1,$ls_codestpro2,$ls_codestpro3,
																 $ls_codestpro4,$ls_codestpro5,$ls_estcla,$la_security);
					if((!$lb_valido)&&(!$lb_existe))
					{
						$li_no_existen=$li_no_existen+1;
						$ls_cuentaspi   = "";
						$ls_dencuentaspi= "";
					}
					elseif((!$lb_valido)&&($lb_existe))
					{
						$li_error=$li_error+1;						
					}
					elseif(($lb_valido)&&($lb_existe))
					{
						$li_save=$li_save+1;
						$ls_cuentaspi   = "";
						$ls_dencuentaspi= "";
					}
				}		
				$object[$i][1]="<input type=text name=txtcuentaspi".$i." value='".$ls_cuentaspi."' class=sin-borde style=text-align:center size=20 maxlength=".$li_size_cta." onKeyPress=\"return keyRestrict(event,'1234567890');\"  onClick=javascript:uf_rellenar_cuenta('".$li_size_cta."','".$total."');>";		
				$object[$i][2]="<input type=text name=txtdencuenta".$i." value='".$ls_dencuentaspi."' class=sin-borde style=text-align:left size=60 maxlength=254>";
				$object[$i][3] ="<a href=javascript:uf_delete_dt('".$i."');><img src=../../shared/imagebank/tools15/eliminar.gif alt=Cancelar Registro de Detalle Presupuestario width=15 height=15 border=0></a>";
			    $lastrow      = 0;
		   }
		   $io_msg->message("$li_save Cuenta(s) Eliminada(s) ,$li_error Cuenta(s) con error,$li_no_existen cuentas no existen"); 		
	}
	

?>
<p>&nbsp;</p>
<div align="center">
  <table width="718" height="223" border="0" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr>
        <td width="716" height="221" valign="top">
		<form name="form1" method="post" action="" >
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if (($ls_permisos)||($ls_logusr=="PSEGIS"))
{
	print("<input type=hidden name=permisos id=permisos value='$ls_permisos'>");
	print("<input type=hidden name=leer     id=permisos value='$la_accesos[leer]'>");
	print("<input type=hidden name=incluir  id=permisos value='$la_accesos[incluir]'>");
	print("<input type=hidden name=cambiar  id=permisos value='$la_accesos[cambiar]'>");
	print("<input type=hidden name=eliminar id=permisos value='$la_accesos[eliminar]'>");
	print("<input type=hidden name=imprimir id=permisos value='$la_accesos[imprimir]'>");
	print("<input type=hidden name=anular   id=permisos value='$la_accesos[anular]'>");
	print("<input type=hidden name=ejecutar id=permisos value='$la_accesos[ejecutar]'>");
}
else
{
	
	print("<script language=JavaScript>");
	print(" location.href='sigespwindow_blank.php'");
	print("</script>");
}
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
		
          <p>&nbsp;</p>
          <table width="644" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
              <tr class="titulo-ventana">
                <td colspan="2">Selecci&oacute;n de  Cuentas de Ingreso</td>
              </tr>
              <tr class="formato-blanco">
                <td width="142" height="20">&nbsp;</td>
                <td width="500"><input name="status" type="hidden" id="status" value="<?php print $ls_estatus ?>"></td>
              </tr>
  
            <tr class="formato-blanco">
              <td height="30" colspan="2">&nbsp;&nbsp;
              <div align="left"> &nbsp;<a href="javascript: uf_agregar_cuentas();"><img src="../../shared/imagebank/tools20/nuevo.gif" width="20" height="20" border="0">Agregar Cuentas </a><a href="javascript:uf_delete_all();"><img src="../../shared/imagebank/tools20/deshacer.gif" alt="Borrar todas las cuentas" width="20" height="20" border="0"></a><a href="javascript:uf_delete_all();">Borrar Todas</a> </div>
              ��</td>
            </tr>
            <tr class="formato-blanco">
              <td height="22" colspan="2"><p align="center">
                <?php $io_grid->makegrid($total,$title,$object,580,'Detalles Cuenta',$grid1);?>
                <input name="total" type="hidden" id="total" value="<?php print $total?>">
</p>              </td>
            </tr>
          </table>
            <p align="center">&nbsp;          </p>
            <p align="center">
              <input name="operacion"  type="hidden" id="operacion" >
              <input name="lastrow"    type="hidden" id="lastrow"    value="<?php print $lastrow;?>" >
              <input name="filadelete" type="hidden" id="filadelete">
              <input name="txtcodestpro1" type="hidden" id="txtcodestpro1" value="<?php print $ls_codestpro1;?>">
              <input name="txtcodestpro2" type="hidden" id="txtcodestpro2" value="<?php print $ls_codestpro2;?>">
              <input name="txtcodestpro3" type="hidden" id="txtcodestpro3" value="<?php print $ls_codestpro3;?>">
              <input name="txtcodestpro4" type="hidden" id="txtcodestpro4" value="<?php print $ls_codestpro4 ?>">
              <input name="txtcodestpro5" type="hidden" id="txtcodestpro5" value="<?php print $ls_codestpro5 ?>">
              <input name="txtestcla" type="hidden" id="txtestcla" value="<?php print $ls_estcla ?>" size="2">
            </p>
		</form></td>
      </tr>
  </table>
</div>
</body>
<script language="javascript">
function ue_nuevo()
{
  f=document.form1;
  li_incluir=f.incluir.value;
  if (li_incluir==1)
	 {	
	   f.operacion.value ="NUEVO";
	   f.action="sigesp_spi_d_partingresos.php";
	   f.submit();
	 }
  else
     {
 	   alert("No tiene permiso para realizar esta operaci�n");
	 }
}

function ue_guardar()
{
f=document.form1;
li_incluir=f.incluir.value;
li_cambiar=f.cambiar.value;
lb_status=f.status.value;
if (((lb_status=="C")&&(li_cambiar==1))||(lb_status!="C")&&(li_incluir==1))
   {
	  f.operacion.value ="GUARDAR";
	  f.action="sigesp_spi_d_partingresos.php";
	  f.submit();
    }
 else
    {
 	  alert("No tiene permiso para realizar esta operaci�n");
	}	
}					

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
	   {
	      window.open("sigesp_spi_cat_ctaspi.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=600,height=400,left=50,top=50,location=no,resizable=yes");
       }
    else
 	   {
 	     alert("No tiene permiso para realizar esta operaci�n");
	   }
}

function ue_eliminar()
{
f=document.form1;
li_eliminar=f.eliminar.value;
if (li_eliminar==1)
   {	
	  if (confirm("� Esta seguro de Eliminar todas las Cuentas ?"))
	     {
		    f.operacion.value ="DELETEALL";
			f.action="sigesp_spi_d_partingresos.php";
			f.submit();
	     }
	}
  else
    {
      alert("No tiene permiso para realizar esta operaci�n");
	}
}
function cat_plan(fila)
{
	
	f=document.form1;
	ls_cuentaspi=eval("f.txtcuentaspi"+fila+".value;");
	ls_dencuenta=eval("f.txtdencuenta"+fila+".value;");
	if((ls_cuentaspi!="")&&(ls_dencuenta!=""))
	{
		window.open("sigesp_sel_scg_plancuentaspi.php?fila="+fila,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
	}
	else
	{
		alert("Seleccione la cuenta presupuestaria");
	}
}
function ue_cerrar()
{
	f=document.form1;
	f.action="sigespwindow_blank.php";
	f.submit();
}

function  uf_agregar_cuentas()
{
	  f=document.form1;
	  li_last=f.lastrow.value;
	  li_total=f.total.value;
	  ls_cuentas="";
	  ls_codestpro1 = f.txtcodestpro1.value;
      ls_codestpro2 = f.txtcodestpro2.value;
      ls_codestpro3 = f.txtcodestpro3.value;
      li_estmodest  = "<?php print $li_estmodest ?>"; 
      if (li_estmodest=='2')
	  {
		ls_codestpro4 = f.txtcodestpro4.value;
		ls_codestpro5 = f.txtcodestpro5.value;
	  }
      else
	  {
		ls_codestpro4 = "00";
		ls_codestpro5 = "00";
	  }
	  ls_estcla=f.txtestcla.value;
	  for(li_i=1;li_i<=li_total;li_i++)
	  {
		ls_cuentaspi=eval("f.txtcuentaspi"+li_i+".value");
		if(ls_cuentaspi!="")
		{
			if(ls_cuentas.length>0)
			{
				ls_cuentas=ls_cuentas+"-"+ls_cuentaspi;
			}
			else
			{
				ls_cuentas=ls_cuentaspi;
			}
		}
	  }
	ls_pagina = "sigesp_sel_ctaspi.php?txtcodestpro1="+ls_codestpro1+"&txtcodestpro2="+ls_codestpro2+"&txtcodestpro3="+ls_codestpro3+"&txtcodestpro4="+ls_codestpro4+"&txtcodestpro5="+ls_codestpro5+"&txtestcla="+ls_estcla+"&lastrow="+li_last+"&cuentas="+ls_cuentas;
	window.open(ls_pagina,"_blank","menubar=no,toolbar=no,scrollbars=yes,width=750,height=450,left=50,top=50,location=no,resizable=no,dependent=yes");
}
function uf_delete_dt(fila)
{
	f=document.form1;
	if(confirm("�Est� seguro de eliminar la Cuenta ?"))
	{
		f.operacion.value  = "DELETE";
		f.filadelete.value = fila;
		f.action           = "sigesp_spi_d_partingresos.php";
		f.submit();
	}
}
function uf_delete_all()
{
	f=document.form1;
	if(confirm("Seguro de Eliminar todas las Cuentas ?"))
	{
		f.operacion.value="DELETEALL";
		f.action="sigesp_spi_d_partingresos.php";
		f.submit();		
	}
}

function uf_rellenar_cuenta(longitud,li_i)
{
		cadena_ceros="";
		f=document.form1;
		cadena=	eval("f.txtcuentaspi"+li_i+".value");
		lencad=cadena.length;
		total=longitud-lencad;
		for(i=1;i<=total;i++)
		{
			cadena_ceros=cadena_ceros+"0";
		}
		cadena=cadena+cadena_ceros;
		eval("document.form1.txtcuentaspi"+li_i+".value="+cadena);
}

function ue_buscar()
{
    f=document.form1;
	li_leer=f.leer.value;
	 ls_codestpro1 = f.txtcodestpro1.value;
      ls_codestpro2 = f.txtcodestpro2.value;
      ls_codestpro3 = f.txtcodestpro3.value;
      li_estmodest  = "<?php print $li_estmodest ?>"; 
      if (li_estmodest=='2')
	  {
		ls_codestpro4 = f.txtcodestpro4.value;
		ls_codestpro5 = f.txtcodestpro5.value;
	  }
      else
	  {
		ls_codestpro4 = "00";
		ls_codestpro5 = "00";
	  }
	  ls_estcla=f.txtestcla.value;
	if (li_leer==1)
	   {
		   window.open("sigesp_spg_cat_ctaspi.php?destino=destino&txtcodestpro1="+ls_codestpro1+"&txtcodestpro2="+ls_codestpro2
		             +"&txtcodestpro3="+ls_codestpro3+"&txtcodestpro4="+ls_codestpro4+"&txtcodestpro5="+ls_codestpro5
					 +"&txtestcla="+ls_estcla,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=600,height=400,left=50,top=50,location=no,resizable=yes");
      }
    else
 	   {
 	     alert("No tiene permiso para realizar esta operaci�n !!!");
	   }
}
</script>
</html>