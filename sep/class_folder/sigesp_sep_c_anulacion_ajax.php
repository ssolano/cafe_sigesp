<?php
	session_start();  
	require_once("../../shared/class_folder/grid_param.php");
	$io_grid=new grid_param();
	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();
	require_once("class_funciones_sep.php");
	$io_funciones_sep=new class_funciones_sep();
	require_once("sigesp_sep_c_anulacion.php");
	$io_anulacion=new sigesp_sep_c_anulacion('../../');
	$ruta = '../../';
	require_once("../../shared/class_folder/sigesp_conexiones.php");
    $io_conexiones=new conexiones();
	$io_conexiones->decodificar_post();

	// tipo de SEP si es de BIENES � de SERVICIOS
	$ls_tipo=$io_funciones_sep->uf_obtenervalor("tipo","-");
	// proceso a ejecutar
	$ls_proceso=$io_funciones_sep->uf_obtenervalor("proceso","");
	// numero de sep
	$ls_numsol=$io_funciones_sep->uf_obtenervalor("numsol","");
	// codigo de unidad ejecutora
	$ls_coduniadm=$io_funciones_sep->uf_obtenervalor("coduniadm","");
	// fecha(registro) de inicio de busqueda
	$ld_fecregdes=$io_funciones_sep->uf_obtenervalor("fecregdes","");
	// fecha(registro) de fin de busqueda
	$ld_fecreghas=$io_funciones_sep->uf_obtenervalor("fecreghas","");
	// codigo de proveedor/beneficiario
	$ls_proben=$io_funciones_sep->uf_obtenervalor("proben","");
	// tipo proveedor/beneficiario
	$ls_tipproben=$io_funciones_sep->uf_obtenervalor("tipproben","");
	// tipo de operacion aprobacion/reverso
	$ls_tipooperacion=$io_funciones_sep->uf_obtenervalor("tipooperacion","");
	switch($ls_proceso)
	{
		case "BUSCAR":
			uf_print_solicitudes($ls_numsol,$ls_tipo,$ls_coduniadm,$ld_fecregdes,$ld_fecreghas,$ls_tipproben,$ls_proben,$ls_tipooperacion);
			break;
	}

	//-----------------------------------------------------------------------------------------------------------------------------------
	function uf_print_solicitudes($as_numsol,$as_tipo,$as_coduniadm,$ad_fecregdes,$ad_fecreghas,$as_tipproben,$as_proben,$as_tipooperacion)
	{	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_print_solicitudes
		//		   Access: private
		//		 Argument: as_numsol        // Numero de la solicitud de ejecucion presupuestaria
		//                 as_tipo          // Indica si es de Bienes o de servicios
		//                 as_coduniadm     // Codigo de la Unidad Ejecutora
		//                 ad_fecregdes     // Fecha (Registro) de inicio de la Busqueda
		//                 ad_fecreghas     // Fecha (Registro) de fin de la Busqueda
		//                 as_tipproben     // Tipo proveedor/ beneficiario
		//                 as_proben        // Codigo de proveedor/ beneficiario
		//                 as_tipooperacion // Codigo de la Unidad Ejecutora
		//	  Description: M�todo que impirme el grid de las solicitudes que pueden ser anuladas � que se pueden reversar la anulaci�n
		//	   Creado Por: Ing. Yesenia Moreno/ Ing. Luis Lang
		// Fecha Creaci�n: 17/03/2007								Fecha �ltima Modificaci�n : 
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		global $io_grid, $io_funciones_sep, $io_funciones, $io_anulacion, $io_mensajes;
		
		// Titulos del Grid de Solicitudes
		$lo_title[1]="";
		$lo_title[2]="Numero de Solicitud";
		$lo_title[3]="Unidad Ejecutora";
		$lo_title[4]="Proveedor / Beneficiario";
		$lo_title[5]="Estatus";
		$lo_title[6]="Monto";
		if($as_tipo=="-")
		{
			$as_tipo="";
		}	
		$ad_fecregdes=$io_funciones->uf_convertirdatetobd($ad_fecregdes);
		$ad_fecreghas=$io_funciones->uf_convertirdatetobd($ad_fecreghas);
		$as_tipo="%".$as_tipo."%";
		$as_numsol="%".$as_numsol."%";
		$as_coduniadm="%".$as_coduniadm."%";
		$as_proben="%".$as_proben."%";
		$rs_datasol=$io_anulacion->uf_load_solicitudes($as_numsol,$as_tipo,$as_coduniadm,$ad_fecregdes,$ad_fecreghas,$as_tipproben,$as_proben,$as_tipooperacion);
		$li_fila=0;
		while($row=$io_anulacion->io_sql->fetch_row($rs_datasol))
		{
			$li_fila= $li_fila + 1;
			$ls_numsol=$row["numsol"];
			$ls_denuniadm=$row["denuniadm"];
			$ls_estsol=$row["estsol"];
			$ls_proben=$row["nombre"];
			$li_monto=number_format($row["monto"],2,',','.');
			switch ($ls_estsol)
			{
				case "A":
					$ls_estatus="Anulada";	
					break;
				case "E":
					$ls_estatus="Emitida";	
					break;
				case "R":
					$ls_estatus="Registrada";	
					break;
			}
			$lo_object[$li_fila][1]="<input type=checkbox name=chkaprobacion".$li_fila.">";
			$lo_object[$li_fila][2]="<input type=text name=txtnumsol".$li_fila."    id=txtnumsol".$li_fila."    class=sin-borde style=text-align:center size=20 value='".$ls_numsol."'    readonly>";
			$lo_object[$li_fila][3]="<input type=text name=txtdenuniadm".$li_fila." id=txtdenuniadm".$li_fila." class=sin-borde style=text-align:left   size=30 value='".$ls_denuniadm."' readonly>"; 
			$lo_object[$li_fila][4]="<input type=text name=txtproben".$li_fila."    id=txtproben".$li_fila."    class=sin-borde style=text-align:left   size=25 value='".$ls_proben."' readonly>"; 
			$lo_object[$li_fila][5]="<input type=text name=txtestapr".$li_fila."    id=txtestapr".$li_fila."    class=sin-borde style=text-align:left   size=20 value='".$ls_estatus."'   readonly>";
			$lo_object[$li_fila][6]="<input type=text name=txtmonto".$li_fila."     id=txtmonto".$li_fila."     class=sin-borde style=text-align:right  size=15 value='".$li_monto."' 	  readonly>";
		}
		if($li_fila==0)
		{
			$io_anulacion->io_mensajes->message("No se encontraron resultados");
			$li_fila=1;
			$lo_object[$li_fila][1]="<input type=checkbox name=chkaprobacion value=1 disabled/>";
			$lo_object[$li_fila][2]="<input type=text name=txtnumsol".$li_fila."    class=sin-borde style=text-align:center size=20 readonly>";
			$lo_object[$li_fila][3]="<input type=text name=txtdenuniadm".$li_fila." class=sin-borde style=text-align:left   size=30 readonly>"; 
			$lo_object[$li_fila][4]="<input type=text name=txtproben".$li_fila."    class=sin-borde style=text-align:left   size=25 readonly>"; 
			$lo_object[$li_fila][5]="<input type=text name=txtestapr".$li_fila."    class=sin-borde style=text-align:left   size=20 readonly>";
			$lo_object[$li_fila][6]="<input type=text name=txtmonto".$li_fila."     class=sin-borde style=text-align:right  size=15 readonly>";
		}

		$io_grid->makegrid($li_fila,$lo_title,$lo_object,700,"Solicitudes de Ejecucion Presupuestaria","gridsolicitudes");
	}// end function uf_print_solicitudes
	//-----------------------------------------------------------------------------------------------------------------------------------
	
?>