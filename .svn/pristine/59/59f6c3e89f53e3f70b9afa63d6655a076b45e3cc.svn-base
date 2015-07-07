<?php 
ini_set('precision ','20');
session_start(); 
if((!array_key_exists("ls_database",$_SESSION))||(!array_key_exists("ls_hostname",$_SESSION))||(!array_key_exists("ls_gestor",$_SESSION))||(!array_key_exists("ls_login",$_SESSION))||(!array_key_exists("la_logusr",$_SESSION))||(!array_key_exists("la_empresa",$_SESSION)||(!array_key_exists("ls_password",$_SESSION))))
{
	print "<script language=JavaScript>";
	print "location.href='sigesp_inicio_sesion.php'";
	print "</script>";		
}
$ls_tipocontabilidad=$_SESSION["la_empresa"]["esttipcont"];
$ls_usuario=$_SESSION["la_codusu"];
$ls_clave=$_SESSION["la_pasusu"];

if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
}
else
{
	$ls_operacion="";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema Kepein - Corporaci&oacute;n Venezolana de Cafe , <?php print $_SESSION["ls_database"] ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
</head>

<body>

<div id="sistema">
	<div class="logo">
		<span class="imglogogobierno"></span>
		<span class="imglogobi"></span>
	</div>
	<div class="iterno">
		<div class="izsistema">
			<h1>Menu Principal</h1>
			<div class="menuprincipalhome">
				<p class="botonmenuprincipal">
					<a href="saf/sigespwindow_blank.php" class="logomenuprincipal">Activos Fijos <span class="b1"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="scb/sigespwindow_blank.php" class="logomenuprincipal">Caja y Bancos <span class="b2"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="soc/sigespwindow_blank.php" class="logomenuprincipal">Ordenes de Compra <span class="mod b3"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="scg/sigespwindow_blank.php" class="logomenuprincipal">Contabilidad Patrimonial <span class="mod b4"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="cxp/sigespwindow_blank.php" class="logomenuprincipal">Cuentas por Pagar <span class="mod b6"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="sep/sigespwindow_blank.php" class="logomenuprincipal">Solicitudes de Ejecuci&oacute;n Presupuestaria <span class="mod2 b7"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="spg/sigespwindow_blank.php" class="logomenuprincipal">Contabilidad Presupuestaria de Gasto <span class="mod3 b8"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="spi/sigespwindow_blank.php" class="logomenuprincipal">Contabilidad Presupuestaria de Ingreso <span class="mod3 b9"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="sno/sigespwindow_blank.php" class="logomenuprincipal">Nomina <span class="b10"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="rpc/sigespwindow_blank.php" class="logomenuprincipal">Proveedores y Beneficiarios <span class="mod b12"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="scv/sigespwindow_blank.php" class="logomenuprincipal">Control Viaticos <span class="mod b13"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="cfg/index.php" class="logomenuprincipal">Configuraci&oacute;n <span class="b14"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="siv/sigespwindow_blank.php" class="logomenuprincipal">Inventario <span class="b15"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="mis/sigespwindow_blank.php" class="logomenuprincipal">Modulo Integrador <span class="mod b16"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="srh/pages/vistas/pantallas/sigespwindow_blank.php" class="logomenuprincipal">Recursos Humanos <span class="mod b17"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="sps/pages/html/sigespwindow_blank.php" class="logomenuprincipal">Prestaciones Sociales <span class="mod b18"></span></a>
				</p>		
			</div>
			<h1>Herramientas del Sistema</h1>
			<div class="menuprincipalhome">
				<p class="botonmenuprincipal">
					<a href="apr/sigesp_apr_conexion.php" class="logomenuprincipal">Apertura <span class="b19"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="sss/sigespwindow_blank.php" class="logomenuprincipal">Seguridad <span class="b20"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="ins/sigespwindow_blank.php" class="logomenuprincipal">Instala <span class="b21"></span></a>
				</p>
				<p class="botonmenuprincipal">
					<a href="sigesp_conexion.php" class="logomenuprincipal">Salir del Sistema <span class="mod b22"></span></a>
				</p>
			</div>
		</div>
	</div>
	<div class="dreservados">
		<p>Kepein Software Libre Desarrollado por la Corporaci&oacute;n Venezolana de Caf&eacute;, basado en <b>SIGESP</b></p>
	</div>
</div>	
<form name="form1" method="post" action="">
<input name="hidclave" id="hidclave" type="hidden"   value="<?PHP print $ls_clave; ?>">
<input name="hidusuario" id="hidusuario" type="hidden" value="<?PHP print $ls_usuario; ?>">
<input name="operacion" id="operacion" type="hidden" value="<?PHP print $ls_opreacion; ?>">
<?php 
	switch ($ls_operacion) 
	{
		case "CAMBIO_BD":
		   	
			/// validacion del release necesario
			require_once("shared/class_folder/sigesp_release.php");
			$io_release= new sigesp_release();
			
			$lb_valido=$io_release->io_function_db->uf_select_column('sigesp_empresa','estcamemp');
			if($lb_valido==false)
			{
				?>
	           <script language="javascript">
			   alert("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_2_53 ");
			   close();
			   </script>
	          <?php	
			}
			else
			{
				require_once("shared/class_folder/sigesp_include.php");
				require_once("shared/class_folder/class_mensajes.php");
				require_once("shared/class_folder/class_sql.php");
				$in=new sigesp_include();
				$con=$in->uf_conectar();
				$msg=new class_mensajes();
				$io_sql=new class_sql($con);
				
				$ls_codemp= $_SESSION["la_empresa"]["codemp"];
				$ls_sql  =" SELECT estcamemp ".
						  " FROM sigesp_empresa".
						  " WHERE codemp = '".$ls_codemp."' ";
						 
				$rs_data=$io_sql->select($ls_sql);
				
				if ($rs_data===false) 
				{
				  ?>
				   <script language="javascript">
				   alert("No se puede efectuar la operacion");
				   close();
				   </script>
				  <?php
				  $lb_valido = false;
				} 
				else
				{
				  $li_numrows = $io_sql->num_rows($rs_data);
				  if ($li_numrows>0)
				  {
					   if($row=$io_sql->fetch_row($rs_data))
						{
						 
							  $ls_estcamemp = $row["estcamemp"];
							  if ($ls_estcamemp==0)
							  {
									?>
									<script language="javascript">
										document.form1.action="sigesp_conexion.php";
										document.form1.submit();
									</script>
								   <?php
							  }
							  else
							   {
									?>
									<script language="javascript">
									codusu=document.form1.hidusuario.value;
									codpas=document.form1.hidclave.value
									window.open("sigesp_cambio_db.php?codusu="+codusu+"&codpas="+codpas,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=440,left=50,top=50,location=no,resizable=yes");
									</script>
								   <?php
							  }		
						}
				 }
				 else
				 {?>
				   <script language="javascript">
				   alert("No se puede efectuar la operacion");
				   close();
				   </script>
				  <?php
				 }	
			}
		}// Fin del else que chequea el release
			
		break;
	}
	
	
?>
</form>
</body>
</html>