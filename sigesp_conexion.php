<?php 
session_start(); 
require_once("sigesp_config.php");
require_once("shared/class_folder/class_sql.php");
require_once("cfg/class_folder/sigesp_cfg_c_empresa.php");
require_once("shared/class_folder/sigesp_include.php");
require_once("shared/class_folder/class_sql.php");
require_once("shared/class_folder/class_funciones.php");
require_once("shared/class_folder/class_mensajes.php");
$io_conect = new sigesp_include();
$msg=new class_mensajes();
?>
<html>
<head>
<title>Sistema Kepein - Corporaci&oacute;n Venezolana de Cafe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body>
<script language="javascript">
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
<?php
	if(array_key_exists("OPERACION",$_POST))
	{
		$operacion=$_POST["OPERACION"];
		
		if ($operacion=="SELECT")
		   {
			$posicion=$_POST["cmbdb"];
			//Realizo la conexion a la base de datos
			if($posicion=="")
			  {
			
			  }
			else
			  {
				$_SESSION["ls_database"] = $empresa["database"][$posicion];
				$_SESSION["ls_hostname"] = $empresa["hostname"][$posicion];
				$_SESSION["ls_login"]    = $empresa["login"][$posicion];
				$_SESSION["ls_password"] = $empresa["password"][$posicion];
				$_SESSION["ls_gestor"]   = strtoupper($empresa["gestor"][$posicion]);	
				$_SESSION["ls_port"]     = $empresa["port"][$posicion];	
				$_SESSION["ls_width"]    = $empresa["width"][$posicion];
				$_SESSION["ls_height"]   = $empresa["height"][$posicion];	
				$_SESSION["ls_logo"]     = $empresa["logo"][$posicion];	
				
				$conn=$io_conect->uf_conectar();//Asignacion de valor a la variable $conn a traves del metodo uf_conectar de la clase sigesp_include.
				if($conn)
				{
				$io_empresa = new sigesp_cfg_c_empresa($conn);
				$obj_sql=new class_sql($conn);
				$ls_sql="SELECT * FROM sigesp_empresa ";
				$result=$obj_sql->select($ls_sql);
				if($result===false)
				{
					$msg->message("No pudo conectar a la tabla empresa en la base de datos, contacte al administrador del sistema");				
				}
				else
				{
				   if (!$row=$obj_sql->fetch_row($result))
				   {
				     $io_empresa->uf_insert_empresa();
				   }
			    }
				$result=$obj_sql->select($ls_sql);
				$li_pos=0;
				if($result===false)
				{
					
				}
				else
				{
					while ($row=$obj_sql->fetch_row($result))
				      {
					    $li_pos=$li_pos+1;
					    $la_empresa["codemp"][$li_pos]=$row["codemp"];   
					    $la_empresa["nombre"][$li_pos]=$row["nombre"];   				
				      }
				}
			 }
			}
		}
		elseif($operacion="SELEMPRESA")
		{
			
			$ls_codemp=$_POST["cmbempresa"];
			$con=$io_conect->uf_conectar();
			$obj_sql=new class_sql($con);
			$ls_sql="SELECT * FROM sigesp_empresa where codemp='".$ls_codemp."' ";
			$result=$obj_sql->select($ls_sql);
			$li_row=$obj_sql->num_rows($result);
			$li_pos=0;
			if($row=$obj_sql->fetch_row($result))
			{
				$la_empresa=$row;   
				$_SESSION["la_empresa"]=$la_empresa;
				$_SESSION["la_empresa"]["periodo"]=date("Y-m-d",strtotime($_SESSION["la_empresa"]["periodo"]));
				$_SESSION['sigesp_sitioweb']=$_SESSION["la_empresa"]["dirvirtual"];
				$_SESSION['sigesp_servidor']=$_SESSION["ls_hostname"];
				$_SESSION['sigesp_usuario']=$_SESSION["ls_login"];
				$_SESSION['sigesp_clave']=$_SESSION["ls_password"];
				$_SESSION['sigesp_basedatos']=$_SESSION["ls_database"];
				$_SESSION['sigesp_gestor']=$_SESSION["ls_gestor"];
				
				$_SESSION['sigesp_servidor_apr']=$_SESSION["ls_hostname"];
				$_SESSION['sigesp_usuario_apr']=$_SESSION["ls_login"];
				$_SESSION['sigesp_clave_apr']=$_SESSION["ls_password"];
				$_SESSION['sigesp_basedatos_apr']=$_SESSION["ls_database"];
				$_SESSION['sigesp_gestor_apr']=$_SESSION["ls_gestor"];

				//$a=$_SESSION["la_empresa"];
				print "<script language=JavaScript>";
				print "location.href='sigesp_inicio_sesion.php'" ;
				print "</script>";
			}
		}
		
	}
	else
	{ 
		$operacion="";
		$arr=array_keys($_SESSION);	
		$li_count=count($arr);
		for($i=0;$i<$li_count;$i++)
		{
			$col=$arr[$i];
			unset($_SESSION["$col"]);
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
				
				<label id="label_username" for="login_username">Base de Datos</label> 
				<?php
				$li_total = count($empresa["database"]);
				?>
				<select name="cmbdb" onChange="javascript:selec();">
				  <option value="">Seleccione....</option>
				  <?php
				
				for($i=1; $i <= $li_total ; $i++)
				{
					if($posicion==$i)
					{
						$selected="selected";
				}
				else
				{
					$selected="";
				}
				?>
				  <option value="<?php echo $i;?>" <?php print $selected; ?>>
				  <?php
				echo $empresa["database"][$i] ;
				  ?>
				  </option>
				  <?php
				}
				?>
				</select>
				</div>			
				
				<div>
				<label id="label_password" for="login_password">Empresa</label>
				<select name="cmbempresa">
				  <option value="">Seleccione....</option>
				  <?php
				if($operacion=="SELECT")
				{
					$li_total=count($la_empresa["codemp"]);
				for($i=1; $i <= $li_total ; $i++)
				{
				?>
				  <option value="<?php echo $la_empresa["codemp"][$i];?>">
				  <?php
				echo $la_empresa["nombre"][$i] ;
				  ?>
				  </option>
				  <?php
					}
				}	
				?>
				</select>
				</div>
				
				<div class="submit">
				<input name="Button" type="button" value="Aceptar" onClick="javascript:uf_selempresa();">
				  <input name="OPERACION" type="hidden" id="OPERACION" value="<?php $_REQUEST["OPERACION"] ?>">
				  <input type="hidden" name="system" value="true">    
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
