<?PHP
    session_start();
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "close();";
		print "opener.document.form1.submit();";
		print "</script>";
	}
	ini_set('memory_limit','256M');
	ini_set('max_execution_time','0');
        $file='archivo.txt';

        $ls_delimitador=',';
        exec('rm *.txt');


    require_once("sigesp_snorh_class_report.php");
    $io_report=new sigesp_snorh_class_report();
    require_once("../class_folder/class_funciones_nomina.php");
    $io_fun_nomina=new class_funciones_nomina();
    $ls_codnomdes=$io_fun_nomina->uf_obtenervalor_get("codnomdes","");
    $ls_codnomhas=$io_fun_nomina->uf_obtenervalor_get("codnomhas","");
    $ls_codconc=$io_fun_nomina->uf_obtenervalor_get("codconc","");
    $ls_nomcon=$io_fun_nomina->uf_obtenervalor_get("nomcon","");
    $ls_anodes=$io_fun_nomina->uf_obtenervalor_get("anodes","");
    $ls_mesdes=$io_fun_nomina->uf_obtenervalor_get("mesdes","");
    $ls_anohas=$io_fun_nomina->uf_obtenervalor_get("anohas","");
    $ls_meshas=$io_fun_nomina->uf_obtenervalor_get("meshas","");
    $ls_perdes=$io_fun_nomina->uf_obtenervalor_get("perdes","");
    $ls_perhas=$io_fun_nomina->uf_obtenervalor_get("perhas","");
    $ls_orden=$io_fun_nomina->uf_obtenervalor_get("orden","1");
    $ls_conceptocero=$io_fun_nomina->uf_obtenervalor_get("conceptocero","");
    $ls_faov=$io_fun_nomina->uf_obtenervalor_get("faov","");

    //Para el nombre del archivo
    $nro_cuenta = '03212001025271153762';
    $file = 'N'.$nro_cuenta.$ls_mesdes.$ls_anodes.'.txt';

    $io_report->uf_faov($ls_codnomdes,$ls_codnomhas,$ls_anodes,$ls_mesdes,$ls_anohas,$ls_meshas,$ls_perdes,$ls_perhas,$ls_codconc,$ls_conceptocero,$ls_orden); // Cargar el DS con los datos del reporte
    $li_totrow= $io_report->DS->getRowCount("cedper");
    if($li_totrow):
        $txt = fopen($file,"a+");
        $temporal='';
        $total=0;
        $temp='';
        if($ls_faov==='false'){
            for($li_s=1;$li_s<=$li_totrow;$li_s++):
                $cedulaPer=rtrim($io_report->DS->data["cedper"][$li_s]);
                $nacionalidad= rtrim($io_report->DS->data["nacper"][$li_s]).$ls_delimitador;
                $temp=rtrim($io_report->DS->data["nomper"][$li_s]);
                $nombre=  separar($temp);
                $temp=rtrim($io_report->DS->data["apeper"][$li_s]);
                $apellido= separar($temp);
                $total=$io_report->DS->data["valsal"][$li_s];
                $ingreso=rtrim(formato_fecha($io_report->DS->data["fecingper"][$li_s]));
          //       $egreso= rtrim($io_report->DS->data["fecegrper"][$li_s]);

                fwrite($txt,$nacionalidad);
                fwrite($txt,$cedulaPer.$ls_delimitador);
                fwrite($txt,str_replace(".","",$nombre));
                fwrite($txt,str_replace(".","",$apellido));
             //   $total= explode(".", $total);
		$total = number_format($total,2,"","");
               //fwrite($txt,str_replace(".","",str_replace("-","",$total[0].$total[1][0].$total[1][1])).$ls_delimitador);
                fwrite($txt,$total.$ls_delimitador);
                fwrite($txt,$ingreso.$ls_delimitador);
             //   fwrite($txt,str_replace(".","",str_replace("-","",rtrim(formato_fecha($io_report->DS->data["fecingper"][$li_s])))).$ls_delimitador);
                   if($egreso==='1900-01-01'){
                    fwrite($txt,str_replace(".","",str_replace("-","",$egreso)).$ls_delimitador);
                   }
             //   fwrite($txt,$egreso);
                fwrite($txt,chr(13).chr(10));
                $total=0;
            endfor;
        }else{
            for($li_s=1;$li_s<=$li_totrow;$li_s++):
                $cedulaPer=rtrim($io_report->DS->data["cedper"][$li_s]);
                $nacionalidad= rtrim($io_report->DS->data["nacper"][$li_s]).$ls_delimitador;
                $temp=rtrim($io_report->DS->data["nomper"][$li_s]);
                $nombre=  separar($temp);
                $temp=rtrim($io_report->DS->data["apeper"][$li_s]);
                $apellido= separar($temp);
                $total=$io_report->DS->data["valsal"][$li_s];
		$fecha_ingreso=$io_report->DS->data["fecingper"][$li_s];
		$fecha_egreso=$io_report->DS->data["fecegrper"][$li_s];
		
		if ($fecha_egreso === null || $fecha_egreso == '1900-01-01'):
			$fecha_egreso = '';
		else:
			$fecha_egreso = date("dmY",strtotime($fecha_egreso));
		endif;  
		
                //$total= (($total*3)/100);
		//$total= ($total*100); //CAMB para quitar los dos decimales

                fwrite($txt,$nacionalidad);
                fwrite($txt,$cedulaPer.$ls_delimitador);
                fwrite($txt,str_replace(".","",$apellido));
                fwrite($txt,str_replace(".","",$nombre));
		fwrite($txt,number_format($total,2,"","").$ls_delimitador);
              //  $total= explode(".", $total);
             //   fwrite($txt,str_replace(".","",str_replace("-","",$total[0].$total[1][0].$total[1][1])).$ls_delimitador);
                //fwrite($txt,'000');
		fwrite($txt,date("dmY",strtotime($fecha_ingreso)).$ls_delimitador);
		fwrite($txt,$fecha_egreso);
                fwrite($txt,chr(13).chr(10));
                $total=0;
            endfor;
        }
        $archivo=$file;
            if (is_file($archivo)):
		    $size = filesize($archivo);
		    if (function_exists('mime_content_type')) {
			$type = mime_content_type($archivo);
		    } else if (function_exists('finfo_file')) {
			$info = finfo_open(FILEINFO_MIME);
			$type = finfo_file($info, $archivo);
			finfo_close($info);
		    }
		    if ($type == '') {
			$type = "application/force-download";
		    }
		    // envia Headers
		    header("Content-Type: $type");
		    header("Content-Disposition: attachment; filename=$file");
		    header("Content-Transfer-Encoding: binary");
		    header("Content-Length: " . $size);
		    // descarga de archivos
		    readfile($archivo);
           else:
			print("<script language=JavaScript>");
			print(" alert('Ocurrio un error al generar el reporte. Intente de Nuevo');");
			print(" close();");
			print("</script>");	
	  endif;
    else:
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');");
	//	print(" close();");
		print("</script>");
    endif;







function formato_fecha($fecha_datetime){
    return date("dmY",strtotime($fecha_datetime));
}

function periodo(){
    $dia=date('d');
    $mes=date('m');
    $periodo=0;

    if($dia>=15){
       $periodo= $mes*2;
       $periodo=($periodo>9)?'0'.$periodo:'00'.$periodo;
    }else{
        if($mes>1){
           $periodo= (($mes+$mes)-2);
           $periodo=($periodo>9)?'0'.$periodo:'00'.$periodo;
        }else{
           $periodo= (($mes+$mes)-1);
           $periodo=($periodo>9)?'0'.$periodo:'00'.$periodo;
        }
    }
    return $periodo;
}

function separar($cadena){
    global $ls_delimitador;
    for($i=0;$i<strlen($cadena);$i++):
        if($cadena[$i]===" "):
            $valor.=$ls_delimitador;
            break;
        else:
            $valor.=$cadena[$i];
        endif;
    endfor;

    for($j=$i,$l=0;$j<strlen($cadena);$j++,$l++):
        if($l!==0):
         $valor.=$cadena[$j];
        endif;
    endfor;
    $valor.=($j!==$i)?$ls_delimitador:$ls_delimitador.$ls_delimitador;
    return $valor;
}
