<?php
	session_start();
	
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "location.href='../sigesp_inicio_sesion.php'";
		print "</script>";		
	}
	$ls_logusr=$_SESSION["la_logusr"];
	require_once("class_funciones_banco.php");

	$io_fun_banco= new class_funciones_banco();
	$io_fun_banco->uf_load_seguridad("SCB","sigesp_scb_p_pago_caficultores.php",$ls_permisos,$la_seguridad,$la_permisos);

	require_once("sigesp_scb_c_pago_caficultores.php");
	$io_pago_caficultores  = new sigesp_scb_c_pago_caficultores();
	
	$f="txt/transferencia.txt";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$f\"\n");
    $fp=fopen($f,'w+');        
	$cabecera="";
	$debito="";
	$credito="";
	$pie="";
    $cabecera="HEADER  ";
    $resultado=$io_pago_caficultores->uf_crear_lote("00102");
    $lote = $resultado->fields["fn_crear_lote"];
	$cabecera.=str_pad($lote,8,"0",STR_PAD_LEFT); //Identificador del lote
	$cabecera.="00002100"; //Numero Negociacion
	$cabecera.="G200095490"; //Rif CVC
	$cabecera.=date("d/m/Y"); //Fecha propuesta de pago
	$cabecera.=date("d/m/Y"); //Fecha de envio
	fwrite($fp,$cabecera);
    fwrite($fp,"\r\n");
    $total=0;

	
	function sustituirCE($valor)
	{
		$String = ereg_replace("[äáàâãª]","a",$valor);
		$String = ereg_replace("[ÁÀÂÃÄ]","A",$String);
	    $String = ereg_replace("[ÍÌÎÏ]","I",$String);
	    $String = ereg_replace("[íìîï]","i",$String);
	    $String = ereg_replace("[éèêë]","e",$String);
	    $String = ereg_replace("[ÉÈÊË]","E",$String);
	    $String = ereg_replace("[óòôõöº]","o",$String);
	    $String = ereg_replace("[ÓÒÔÕÖ]","O",$String);
	    $String = ereg_replace("[úùûü]","u",$String);
	    $String = ereg_replace("[ÚÙÛÜ]","U",$String);
	    $String = ereg_replace("[\^\´\`\¨\~\&]","",$String);
	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","C",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","N",$String);
	    $String = str_replace("Ý","Y",$String);
	    $String = str_replace("ý","y",$String);
		return $String; 
	}
    
	foreach ($_POST["cxp"] as $key => $value)
    { 
    	$datos=split("\|",$value);
    	$solicitud=$datos[0];
    	$rifProveedor=$datos[1];
		$nombreProveedor=$datos[2];
    	$email=$datos[3];
		$tipoCuenta=$datos[4];
		$cuenta=$datos[5];
    	$monto=$datos[6];
		$swift=$datos[7];
    	$total+=$monto;
    	
		$io_pago_caficultores->uf_pagos_caficultores_transferencia($solicitud,$lote);
    	$debito="DEBITO  ";
    	$debito.=substr($solicitud, -8);// numero de solicitud los 8 caracteres
    	$debito.="G200095490"; //Rif CVC
    	$debito.=str_pad("CORPORACION VENEZOLANA DEL CAFE", 35); //Nombre Ordenante
    	$debito.=date("d/m/Y"); //Fecha de debito
		$debito.="00"; //Cuenta Corriente DEL CVC
    	$debito.="01020552210000046585"; // Cuenta de la corporacion
    	$debito.=str_pad(str_replace(".", ",", number_format($monto,2,',','')),18,"0",STR_PAD_LEFT);
    	$debito.="VEB"; //Valor Fijo para moneda
    	$debito.="40"; //Valor Fijo para proveedores
		//$debito.="    "; //Status
		//$debito.=str_pad(" ",80," ",STR_PAD_RIGHT);//Descripcion de status
    	fwrite($fp,$debito);
    	fwrite($fp,"\r\n");
		$credito="CREDITO ";
		$credito.=substr($solicitud, -8);// numero de referencia los 8 caracteres
		$credito.=substr(str_replace("-","",$rifProveedor),0,10); //Rif o CI del Beneficiario
		$credito.=str_pad(substr(sustituirCE($nombreProveedor),0,30),30," ",STR_PAD_RIGHT);
		//$credito.=str_pad(substr($nombreProveedor,0,30),30," ",STR_PAD_RIGHT);
		if($tipoCuenta==1)
    	{
    		$credito.="00"; //Cuenta Corriente
    	}
    	elseif($tipoCuenta==2)
    	{
    		$credito.="01"; //Cuenta Ahorro
    	}
		$credito.=substr($cuenta,0,20);
		$credito.=str_pad(str_replace(".", ",", number_format($monto,2,',','')),18,"0",STR_PAD_LEFT);
		if(substr($cuenta,0,4)=="0102")
		{
			$credito.="10";	
		}
		else
		{
			$credito.="00";
		}
		$credito.=str_pad($swift,12," ",STR_PAD_RIGHT);
		$credito.="   "; // Duracion del cheque
		$credito.="    "; // Agencia Bancaria
		$credito.=str_pad(substr($email,0,50),50," ",STR_PAD_RIGHT);
		//$credito.="    "; //Status
		//$credito.=str_pad(" ",50," ",STR_PAD_RIGHT);//Descripcion de status
		fwrite($fp,$credito);
    	fwrite($fp,"\r\n");
		
    }            
	$pie="TOTAL   ";
	$pie.=str_pad(count($_POST["cxp"]),5,"0",STR_PAD_LEFT);
	$pie.=str_pad(count($_POST["cxp"]),5,"0",STR_PAD_LEFT);
	$pie.=str_pad(str_replace(".", ",", number_format($total,2,',','')),18,"0",STR_PAD_LEFT);
	fwrite($fp,$pie);
    fwrite($fp,"\r\n");
	fclose($fp); 
	$fp=fopen($f,'r');
    fpassthru($fp);
?> 