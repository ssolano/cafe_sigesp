<?php
class sigesp_scb_reportbsf
{
	function sigesp_scb_reportbsf($conn)
	{
	  require_once("../../shared/class_folder/class_funciones.php");
  	  require_once("../../shared/class_folder/class_sql.php");
  	  require_once("../../shared/class_folder/class_mensajes.php");
  	  require_once("../../shared/class_folder/class_datastore.php");
	  $this->fun = new class_funciones();
	  $this->SQL= new class_sql($conn);
	  $this->SQL_aux= new class_sql($conn);
	  $this->io_msg= new class_mensajes();		
	  $this->dat_emp=$_SESSION["la_empresa"];
	  $this->ds_disponibilidad=new class_datastore();
	  $this->ds_documentos=new class_datastore();
	}
	function uf_cargar_chq_voucher($ls_numdoc,$ls_voucher,$ls_codban,$ls_ctaban,$ls_codope)
	{
	
		
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		if($ls_voucher=="")
		{
		   $ls_sql="SELECT * 
				 FROM scb_movbco 
				 WHERE codemp='".$ls_codemp."' AND numdoc='".$ls_numdoc."' 
				 AND (chevau='".$ls_voucher."' OR chevau=' ')AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' 
				 AND estmov<>'A' AND estmov<>'O' AND codope='".$ls_codope."'";
		}
	    else
	    {
			$ls_sql="SELECT * 
				 FROM scb_movbco 
				 WHERE codemp='".$ls_codemp."' AND numdoc='".$ls_numdoc."' 
				 AND chevau='".$ls_voucher."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' 
				 AND estmov<>'A' AND estmov<>'O' AND codope='".$ls_codope."'";
		}
		
		$rs_data=$this->SQL->select($ls_sql);
		if($rs_data===false)
		{
			$data=array();
			$this->is_msg_error="Error al cargar cheque voucher, ".$this->fun->uf_convertirmsg($this->SQL->message);
		}
		else
		{
			if($row=$this->SQL->fetch_row($rs_data)){$data=$this->SQL->obtener_datos($rs_data);	}
			else{$data=array();}
			$this->SQL->free_result($rs_data);
		}
		
		return $data;
	}
	
	function uf_actualizar_status_impreso($ls_numdoc,$ls_voucher,$ls_codban,$ls_ctaban,$ls_codope)
	{
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_sql="UPDATE scb_movbco SET estimpche=1 
				 WHERE codemp='".$ls_codemp."' AND numdoc='".$ls_numdoc."' AND chevau='".$ls_voucher."' AND codban='".$ls_codban."' 
				 AND ctaban='".$ls_ctaban."' AND codope='".$ls_codope."'";
		$li_result=$this->SQL->execute($ls_sql);		
		if($li_result===false)
		{
			$this->is_msg_error="Error al actualizar status de impresi�n, ".$this->fun->uf_convertirmsg($this->SQL->message);
			return false;
		}
		else
		{
			return true;
		}	
	}
	
	function uf_select_solicitudes($ls_numdoc,$ls_codban,$ls_ctaban)
	{
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_solicitudes="";	$i=0;
		$ls_sql="SELECT * 
				 FROM cxp_sol_banco 
				 WHERE codemp='".$ls_codemp."' AND numdoc='".$ls_numdoc."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'";
	
		$rs_data=$this->SQL->select($ls_sql);		
		if($rs_data===false)
		{
			$this->is_msg_error="Error al cargar cheque voucher, ".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->SQL->message;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$i=$i+1;
				if($i==1){$ls_solicitudes=$row["numsol"];}
				else{$ls_solicitudes=$ls_solicitudes."-".$row["numsol"];}				
			}
			$this->SQL->free_result($rs_data);
		}
		return $ls_solicitudes;
	}
	function uf_select_solicitudes_con_enter($ls_numdoc,$ls_codban,$ls_ctaban)
	{
		//*Igual que la anterior pero coloca un \n entre las solicitudes*/
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_solicitudes="";	$i=0;
		$ls_sql="SELECT * 
				 FROM cxp_sol_banco 
				 WHERE codemp='".$ls_codemp."' AND numdoc='".$ls_numdoc."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'";
	
		$rs_data=$this->SQL->select($ls_sql);		
		if($rs_data===false)
		{
			$this->is_msg_error="Error al cargar cheque voucher, ".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->SQL->message;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$i=$i+1;
				if($i==1){$ls_solicitudes=$row["numsol"];}
				else{$ls_solicitudes=$ls_solicitudes."-"."\n".$row["numsol"];}				
			}
			$this->SQL->free_result($rs_data);
		}
		return $ls_solicitudes;
	}
	
	function uf_select_data($SQL,$ls_cadena,$ls_campo)
	{
		$data=$SQL->select($ls_cadena);		
		if($row=$SQL->fetch_row($data)){	$ls_result=$row[$ls_campo];}	
		else{$ls_result="";	}
		$SQL->free_result($data);
		return $ls_result;
	}
	
	function uf_select_rowdata($SQL,$ls_cadena)
	{
		$data=$SQL->select($ls_cadena);		
		if($row=$SQL->fetch_row($data)){	$la_result=$row;}	
		else{$la_result=array();	}
		$SQL->free_result($data);
		return $la_result;
	}

	function uf_cargar_dt_scg($as_numdoc,$as_codban,$as_ctaban,$as_codope)
	{
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$dt_scg=array();
		$y=0;
		
		if(!empty($as_codope)){$ls_cad=" AND a.codope='".$as_codope."'";}
		else{$ls_cad="";}
		
		$ls_sql="SELECT   a.scg_cuenta,a.debhab,a.monto,a.desmov,b.denominacion as denominacion,a.codded as codded
				 FROM     scb_movbco_scg a,scg_cuentas b
				 WHERE    a.codemp='".$ls_codemp ."' AND a.numdoc ='".$as_numdoc."' and a.codban='".$as_codban."' and a.ctaban='".$as_ctaban."' AND a.scg_cuenta=b.sc_cuenta ".$ls_cad."	
				 ORDER BY a.debhab asc,a.scg_cuenta asc ";
			

		$rs_scg=$this->SQL->select($ls_sql);		
		if(($rs_scg===false))
		{
			$lb_valido=false;		
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_scg))
			{
				$y=$y+1;
				$dt_scg["scg_cuenta"][$y]=$row["scg_cuenta"];
				$dt_scg["denominacion"][$y]=$row["denominacion"];
				$dt_scg["debhab"][$y]=$row["debhab"];
				$dt_scg["monto"][$y]=$row["monto"];
				$dt_scg["desmov"][$y]=$row["desmov"];			
				$dt_scg["codded"][$y]=$row["codded"];			
			}			
			$this->SQL->free_result($rs_scg);
		}
		return $dt_scg;
	
	}
	
	function uf_cargar_dt_spg($as_numdoc,$as_codban,$as_ctaban,$as_codope)
	{
		$ls_estmodest=$_SESSION["la_empresa"]["estmodest"];
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$ls_gestor = $_SESSION["ls_gestor"];
		$ls_cadena=""	;
		$dt_spg=array();
		$y=0;
		if(!empty($as_codope)){$ls_cad=" AND codope='".$as_codope."'";}
		else{$ls_cad="";}
		if ($ls_gestor=="MYSQL")
			$ls_cadena="CONCAT(b.codestpro1,b.codestpro2,b.codestpro3,b.codestpro4,b.codestpro5)";
		elseif($ls_gestor=="POSTGRE")
			$ls_cadena="(b.codestpro1 || b.codestpro2 || b.codestpro3 || b.codestpro4 || b.codestpro5)";
		$ls_sql="SELECT   a.desmov,a.codestpro as codestpro,a.spg_cuenta as spg_cuenta,a.monto as monto,b.denominacion as denominacion
				 FROM     scb_movbco_spg a,spg_cuentas b
				 WHERE    a.codemp='".$ls_codemp ."' AND a.numdoc ='".$as_numdoc."' 
				 and a.codban='".$as_codban."' and a.ctaban='".$as_ctaban."' 
				 AND a.spg_cuenta=b.spg_cuenta 
				 AND a.codestpro=$ls_cadena
				  ".$ls_cad."	
				 ORDER BY a.codestpro,a.spg_cuenta asc";
		$rs_spg=$this->SQL->select($ls_sql);

		if(($rs_spg===false))
		{
			$lb_valido=false;
			print "Ocurrio error uf_cargar_dt_spg"		;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_spg))
			{
				$y=$y+1;
				$dt_spg["spg_cuenta"][$y]=$row["spg_cuenta"];
				$ls_programatica=$row["codestpro"];
				if($ls_estmodest==2)
				{
					$ls_codestpro1=substr(substr($ls_programatica,0,20),-2);
					$ls_codestpro2=substr(substr($ls_programatica,20,6),-2);
					$ls_codestpro3=substr(substr($ls_programatica,26,3),-2);
					$ls_codestpro4=substr($ls_programatica,29,2);	
					$ls_codestpro5=substr($ls_programatica,31,2);
					$ls_programatica=$ls_codestpro1."-".$ls_codestpro2."-".$ls_codestpro3."-".$ls_codestpro4."-".$ls_codestpro5;
				}
				else
				{
					$ls_programatica=substr($row["codestpro"],0,20)."-".substr($row["codestpro"],20,6)."-".substr($row["codestpro"],26,3);//substr($ls_programatica,0,29);
				}
				$dt_spg["estpro"][$y]=$ls_programatica;
				$dt_spg["denominacion"][$y]=$row["denominacion"];				
				$dt_spg["monto"][$y]=$row["monto"];	
				$dt_spg["desmov"][$y]=$row["desmov"];				
			}
					
			$this->SQL->free_result($rs_spg);
		}
		return $dt_spg;
	
	}

	function uf_cargar_dt_spgop($as_numdoc,$as_codban,$as_ctaban,$as_codope)
	{
		$ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$dt_spg=array();
		$y=0;
		if(!empty($as_codope)){$ls_cad=" AND codope='".$as_codope."'";}
		else{$ls_cad="";}
		$ls_sql="SELECT   a.codestpro as codestpro,a.spg_cuenta as spg_cuenta,a.monto as monto,b.denominacion as denominacion,a.coduniadm as coduniadm
				 FROM     scb_movbco_spgop a,spg_cuentas b
				 WHERE    a.codemp='".$ls_codemp ."' AND a.numdoc ='".$as_numdoc."' and a.codban='".$as_codban."' and a.ctaban='".$as_ctaban."' AND a.spg_cuenta=b.spg_cuenta AND a.codestpro=CONCAT(b.codestpro1,b.codestpro2,b.codestpro3,b.codestpro4,b.codestpro5) ".$ls_cad."	
				 ORDER BY a.codestpro,a.spg_cuenta asc";
		$rs_spg=$this->SQL->select($ls_sql);	

		if(($rs_spg===false))
		{
			$lb_valido=false;		
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_spg))
			{
				$y=$y+1;
				$dt_spg["spg_cuenta"][$y]=$row["spg_cuenta"];
				$dt_spg["estpro"][$y]=substr($row["codestpro"],0,20).substr($row["codestpro"],20,6).substr($row["codestpro"],26,3);
				$dt_spg["denominacion"][$y]=$row["denominacion"];
				$dt_spg["coduniadm"][$y]=$row["coduniadm"];
				$dt_spg["monto"][$y]=$row["monto"];				
			}			
			$this->SQL->free_result($rs_spg);
		}
		return $dt_spg;
	}


	function uf_generar_estado_cuenta($ls_codemp,$ls_codban,$ls_ctaban,$ls_orden,$ld_fecdesde,$ld_fechasta,$ldec_saldoanterior,$ldec_total_debe,$ldec_total_haber,$lb_libro_banco,$as_tiprep,$as_codconmov)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//            Function: uf_generar_estado_cuenta
		//		        Access: private 
		//	    	 Arguments: 
		//      	 $ls_codemp //C�digo de la Empresa.
		//      	 $ls_codban //C�digo del Banco.
		//      	 $ls_ctaban //N�mero de la Cuenta Bancaria asociada al Banco. 
		//            $ls_orden //Par�metro de Orden para la presentaci�n del reporte.
		//         $ld_fecdesde //Fecha a partir del cual se buscaran los registros.
		//         $ld_fechasta //Fecha hasta el cual se buscaran los registros.
		//  $ldec_saldoanterior //Monto total del Saldo anterior de esa cuenta en ese Banco.
		//     $ldec_total_debe //Monto total de movimientos afectando el debe.
		//    $ldec_total_haber //Monto total de movimientos afectando el haber.
		//      $lb_libro_banco 
		//         Description: Funci�n que carga los detalles de los movimientos Bancarios para ser reportados en el Libro a Banco.
		//	        Creado Por: Ing. N�stor Falc�n.                         Modificado Por: Ing. N�stor Falc�n.
		//      Fecha Creaci�n: 24/07/2007                       Fecha �ltima Modificaci�n: 08/08/2007.
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$ldec_creditostmp    = 0; 
		$ldec_creditostmpneg = 0;
		$ldec_debitostmp     = 0; 
		$ldec_debitostmpneg  = 0;
		$ldec_debitosant     = 0;
		$ldec_creditosant    = 0;
		$ldec_saldoanterior  = 0;
		$ldec_total_debe	 = 0;	
		$ldec_total_haber	 = 0;
		
		$ds_edocta   = new  class_datastore();
		$ls_gestor   = $_SESSION["ls_gestor"];
		$ld_fecdesde = $this->fun->uf_convertirdatetobd($ld_fecdesde);
		$ld_fechasta = $this->fun->uf_convertirdatetobd($ld_fechasta);
		
		$ls_sql="SELECT codope ,(montoaux-monretaux) as monto, estmov
				   FROM scb_movbco
				  WHERE codemp='".$ls_codemp."' 
				    AND codban='".$ls_codban."' 
					AND ctaban='".$ls_ctaban."' 
					AND fecmov < '".$ld_fecdesde."'";
		$rs_data = $this->SQL->select($ls_sql);
		if ($rs_data===false)
		   {
			 print $this->SQL->message;
			 return false;
		   }
		else
		   {
			 while($row=$this->SQL->fetch_row($rs_data))
			      {
				    $ls_estmov  = $row["estmov"];
				    $ls_codope  = $row["codope"];
				    $ldec_monto = $row["monto"];
			 	    if((($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))&&($ls_estmov!="A"))	{$ldec_creditostmp=$ldec_creditostmp+$ldec_monto;}
				    if((($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))&&($ls_estmov=="A")) {$ldec_creditostmpneg=$ldec_creditostmpneg+$ldec_monto;}
				    if((($ls_codope=="DP")||($ls_codope=="NC"))&&($ls_estmov!="A")){$ldec_debitostmp=$ldec_debitostmp+$ldec_monto;}
				    if((($ls_codope=="DP")||($ls_codope=="NC"))&&($ls_estmov=="A")){$ldec_debitostmpneg=$ldec_debitostmpneg+$ldec_monto;}
			      }  
			 $this->SQL->free_result($rs_data);
			 $ldec_debitosant    = ($ldec_debitostmp-$ldec_debitostmpneg);
			 $ldec_creditosant   = ($ldec_creditostmp-$ldec_creditostmpneg);
			 $ldec_saldoanterior = ($ldec_debitosant-$ldec_creditosant);
		   }
		switch ($ls_orden){
			case 'D':
				$ls_sql_orden=' ORDER BY scb_movbco.numdoc ASC';
				break;
			case 'F':
				$ls_sql_orden=' ORDER BY scb_movbco.fecmov ASC';
				break;
			case 'B':
				$ls_sql_orden=' ORDER BY scb_movbco.codban ASC';
				break;
			case 'C':
				$ls_sql_orden=' ORDER BY scb_movbco.ctaban ASC';
				break;
			case 'O':
				$ls_sql_orden=' ORDER BY scb_movbco.codope ASC';
				break;
		}							
		  switch ($ls_gestor){
			case 'MYSQL':
			  $ls_straux = " CONCAT(codestpro1,codestpro2,codestpro3,codestpro4,codestpro5) ";
			break;
			case 'POSTGRE':
			  $ls_straux = " codestpro1||codestpro2||codestpro3||codestpro4||codestpro5 ";
			break;
		  }
		
		$ls_tabla   = "";
		$ls_straux2 = "";
	    $ls_cadaux  = "";
		
		if ($as_codconmov!='---')
		   {
		     $ls_tabla  = ', scb_concepto';
			 $ls_straux2 = " AND scb_movbco.codconmov = '".$as_codconmov."'
			                 AND scb_movbco.codconmov=scb_concepto.codconmov";
		   }
		switch ($as_tiprep){
		  case 'C':
			   $ls_sql = "SELECT scb_movbco.fecmov,scb_movbco.codope,scb_movbco.numdoc,scb_movbco.cod_pro,scb_movbco.ced_bene,
								 scb_movbco.nomproben, scb_movbco.estmov, scb_movbco.conmov as concepto, 
								 (scb_movbco.montoaux-scb_movbco.monretaux) as montot
							FROM scb_movbco, scb_banco, scb_ctabanco, scb_tipocuenta
						   WHERE scb_movbco.codemp = '".$ls_codemp."'
							 AND scb_movbco.codban = '".$ls_codban."'
							 AND scb_movbco.ctaban = '".$ls_ctaban."'
							 AND scb_movbco.fecmov BETWEEN '".$ld_fecdesde."' AND '".$ld_fechasta."'
							 AND scb_movbco.codemp = scb_banco.codemp
							 AND scb_movbco.codban = scb_banco.codban
							 AND scb_movbco.codemp = scb_ctabanco.codemp
							 AND scb_movbco.codban = scb_ctabanco.codban
							 AND scb_movbco.ctaban = scb_ctabanco.ctaban
							 AND scb_ctabanco.codtipcta=scb_tipocuenta.codtipcta $ls_sql_orden ";
		  break;
		  case 'D':
			   $ls_sql = "SELECT scb_movbco.fecmov,scb_movbco.codope,scb_movbco.numdoc,scb_movbco.nomproben, scb_movbco_spg.estmov,
								 scb_movbco_spg.spg_cuenta,spg_cuentas.denominacion as denctaspg, scb_movbco_spg.codestpro,scb_movbco.conmov as concepto,
								 scb_movbco_spg.montoaux as monto, (scb_movbco.montoaux - scb_movbco.monretaux) as montot, scb_movbco.cod_pro,
								 scb_movbco.ced_bene, scb_movbco.tipo_destino
						    FROM scb_movbco, scb_movbco_spg, scb_banco, spg_cuentas, scb_ctabanco, scb_tipocuenta $ls_tabla
						   WHERE scb_movbco.codemp = '".$ls_codemp."'
							 AND scb_movbco.codban = '".$ls_codban."'
							 AND scb_movbco.ctaban = '".$ls_ctaban."'
							 AND scb_movbco.fecmov BETWEEN '".$ld_fecdesde."' AND '".$ld_fechasta."' $ls_straux2
							 AND scb_banco.codemp = scb_movbco.codemp
							 AND scb_banco.codban = scb_movbco.codban
							 AND scb_movbco.codemp = scb_ctabanco.codemp
							 AND scb_movbco.codban = scb_ctabanco.codban
							 AND scb_movbco.ctaban = scb_ctabanco.ctaban
							 AND scb_ctabanco.codtipcta = scb_tipocuenta.codtipcta
							 AND scb_movbco.codemp = scb_movbco_spg.codemp
							 AND scb_movbco.codban = scb_movbco_spg.codban
							 AND scb_movbco.ctaban = scb_movbco_spg.ctaban
							 AND scb_movbco.numdoc = scb_movbco_spg.numdoc
							 AND scb_movbco.codope = scb_movbco_spg.codope
							 AND scb_movbco.estmov = scb_movbco_spg.estmov
							 AND scb_movbco_spg.codemp = spg_cuentas.codemp
							 AND scb_movbco_spg.spg_cuenta = spg_cuentas.spg_cuenta
							 AND scb_movbco_spg.codestpro = $ls_straux
							 $ls_sql_orden";
		  break;
		}

		$rs_data = $this->SQL->select($ls_sql); //print $ls_sql;
		if ($rs_data===false)
		   {
			 print $this->SQL->message;
			 return false;
		   }
		else
		   {
			 while($row=$this->SQL->fetch_row($rs_data))
			      {
				    $ldec_creditos    = 0; 
					$ldec_creditosneg = 0; 
					$ldec_debitos     = 0;  
					$ldec_debitosneg  = 0;
				    
					$ls_codope    = $row["codope"];
				    $ls_estmov    = $row["estmov"];
				    $ls_conmov	  = $row["concepto"];
				    $ls_numdoc	  = $row["numdoc"];
				    $ls_nomproben = $row["nomproben"];
				    $ld_fecmov    = $row["fecmov"];
					$ld_montot    = $row["montot"];
				    if ($as_tiprep=='D')
					   {  
					     $ls_codpro    = $row["cod_pro"];
						 $ls_cedben    = $row["ced_bene"];
						 $ls_region    = ""; 
						 $ls_tipproben = $row["tipo_destino"];
						 if ($ls_tipproben=='P')
						    {
							  $ls_codproben = $ls_codpro;
							}
						 elseif($ls_tipproben=='B')
						    {
							  $ls_codproben = $ls_codpro;							
							}
						 if ($ls_tipproben=='B' || $ls_tipproben=='P')
						    {
							  $ls_region = $this->uf_load_region($ls_codemp,$ls_tipproben,$ls_codproben);
							}
						 $ls_codestpro = $row["codestpro"]; 
					     $ls_spgcta    = $row["spg_cuenta"]; 
					     $ls_denctaspg = $row["denctaspg"]; 
					     $ld_monspg    = $row["monto"];
					   }
				    if ((($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))&&($ls_estmov!="A"))
				       {
				         if ($as_tiprep=='C')
						    {
							  $ldec_creditos = ($ldec_creditos+$ld_montot);
							}
						 else 
						    {
							  $ldec_creditos = ($ldec_creditos+$ld_monspg);
							} 
				       }
				    elseif($ls_estmov=="A")
				       {
					     if (($ls_codope!="CH")&&($ls_codope!="ND")&&($ls_codope!="RE"))
					        {					
					          if ($as_tiprep=='C')
						         {
							       $ldec_creditos = ($ldec_creditos+$ld_montot);
							     }
						      else 
						         {
							       $ldec_creditos = ($ldec_creditos+$ld_monspg);
							     }  
						    }
				       }
				    if ((($ls_codope=="DP")||($ls_codope=="NC"))&&($ls_estmov!="A"))	
				       {
				         if ($as_tiprep=='C')
						    {
						      $ldec_debitos=$ldec_debitos+$ld_montot;
							}
						 else 
						    {
							  $ldec_debitos = ($ldec_debitos+$ld_monspg);
							}  
					   }
				    elseif($ls_estmov=="A")
				       {
					     if (($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))
					        {
				              if ($as_tiprep=='C')
						         {
						           $ldec_debitos = ($ldec_debitos+$ld_montot);	
						         }
						      else 
						         {
							       $ldec_debitos = ($ldec_debitos+$ld_monspg);
							     }  
				            }
					   }
				    $ldec_total_debe  = ($ldec_total_debe+$ldec_debitos);
				    $ldec_total_haber = ($ldec_total_haber+$ldec_creditos);
				    if (!$lb_libro_banco)
				       {
				 	     $ls_operacion = $this->fun->iif_string("'".$ls_codope."'=='CH'","Cheque",$this->fun->iif_string("'".$ls_codope."'=='ND'",'Nota Debito',$this->fun->iif_string("'".$ls_codope."'=='RE'",'Retiro',$this->fun->iif_string("'".$ls_codope."'=='NC'",'Nota Credito',$this->fun->iif_string("'".$ls_codope."'=='DP'",'Deposito','')))));
				       }
				    else
				       {
					     $ls_operacion=$ls_codope;
				       }
				    $ds_edocta->insertRow("operacion",$ls_operacion);
				    $ds_edocta->insertRow("conmov",$ls_conmov);
				    $ds_edocta->insertRow("codope",$ls_codope);
				    $ds_edocta->insertRow("estmov",$ls_estmov);
				    $ds_edocta->insertRow("numdoc",$ls_numdoc);
				    $ds_edocta->insertRow("fecmov",$ld_fecmov);
				    $ds_edocta->insertRow("beneficiario",$ls_nomproben);
				    $ds_edocta->insertRow("debitos",$ldec_debitos);
				    $ds_edocta->insertRow("creditos",$ldec_creditos);
			        if ($as_tiprep=='D')
					   {
				         $ds_edocta->insertRow("codestpro",$ls_codestpro);
				         $ds_edocta->insertRow("spg_cuenta",$ls_spgcta);
				         $ds_edocta->insertRow("denctaspg",$ls_denctaspg);
						 $ds_edocta->insertRow("monto",$ld_monspg);
					     $ds_edocta->insertRow("region",$ls_region); 
					   }
				  }
			 $this->SQL->free_result($rs_data);
		   }
		return $ds_edocta->data;
	}

function uf_load_region($as_codemp,$as_tipproben,$as_codproben)
{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//            Function: uf_generar_estado_cuenta
//		        Access: private 
//	    	 Arguments: 
//      	 $ls_codemp //C�digo de la Empresa.
//        $as_tipproben //Tipo de P=Proveedor o B=Beneficiario.
//        $as_codproben //C�digo del proveedor o cedula del beneficiario
//         Description: Funci�n que carga el estado de localizaci�n de un proveedor o beneficiario determinado.
//	        Creado Por: Ing. N�stor Falc�n.                         Modificado Por: Ing. N�stor Falc�n.
//      Fecha Creaci�n: 24/07/2007                       Fecha �ltima Modificaci�n: 08/08/2007.
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  if ($as_tipproben=='P')
	 {
	   $ls_campo = 'cod_pro';
	   $ls_tabla = 'rpc_proveedor';
	 }
  else
	 {
	   $ls_campo = 'ced_bene';
	   $ls_tabla = 'rpc_beneficiario';
	 }
  $ls_sql = "SELECT sigesp_estados.desest
			   FROM sigesp_pais, sigesp_estados, $ls_tabla
			  WHERE $ls_tabla.codemp='".$as_codemp."'
				AND $ls_tabla.$ls_campo='".$as_codproben."'
				AND $ls_tabla.codpai=sigesp_pais.codpai
				AND $ls_tabla.codest=sigesp_estados.codest";
  $rs_data = $this->SQL->select($ls_sql);
  if ($rs_data===false)
	 {
	   $lb_valido = false;
	 }
  else
	 {
	   if ($row=$this->SQL->fetch_row($rs_data))
		  {
			$ls_region = $row["desest"];
		  }
	 }
  return $ls_region;
}

function uf_generar_estado_cuenta_resumido($ls_codban,$ls_ctaban,$ld_fecdesde,$ld_fechasta,$ldec_saldoanterior,$ldec_total_debe,$ldec_total_haber,$ls_nomban,$ls_nomtipcta)
	{
		$ldec_creditostmp=0; $ldec_creditostmpneg=0; $ldec_debitostmp=0; $ldec_debitostmpneg=0;	$ldec_debitosant=0; $ldec_creditosant=0; $ldec_saldoanterior=0;
		$ldec_total_debe=0;	$ldec_total_haber=0;
		$ds_edocta=new class_datastore();
		$ld_fecdesde=$this->fun->uf_convertirdatetobd($ld_fecdesde);
		$ld_fechasta=$this->fun->uf_convertirdatetobd($ld_fechasta);
		$ls_sql="SELECT A.codope as codope ,(A.montoaux-A.monretaux) as monto, A.estmov as estmov,B.nomban as nomban,D.nomtipcta as nomtipcta
				 FROM   scb_movbco A,scb_banco B,scb_ctabanco C,scb_tipocuenta D
				 WHERE  A.codban='".$ls_codban."'  AND  A.ctaban='".$ls_ctaban."' AND A.fecmov < '".$ld_fecdesde."' 
				 AND    A.codban=B.codban AND A.codban=C.codban AND A.ctaban=C.ctaban AND C.codtipcta=D.codtipcta";
		$rs_data=$this->SQL->select($ls_sql);
		if( $rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_estmov=$row["estmov"];
				$ls_codope=$row["codope"];
				$ldec_monto=$row["monto"];
				if((($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))&&($ls_estmov!="A")){$ldec_creditostmp=$ldec_creditostmp+$ldec_monto;}
				if((($ls_codope=="CH")||($ls_codope=="ND")||($ls_codope=="RE"))&&($ls_estmov=="A")){$ldec_creditostmpneg=$ldec_creditostmpneg+$ldec_monto;}
				if((($ls_codope=="DP")||($ls_codope=="NC"))&&($ls_estmov!="A")){$ldec_debitostmp=$ldec_debitostmp+$ldec_monto;}
				if((($ls_codope=="DP")||($ls_codope=="NC"))&&($ls_estmov=="A")){$ldec_debitostmpneg=$ldec_debitostmpneg+$ldec_monto;}
			}
			$this->SQL->free_result($rs_data);
			$ldec_debitosant = $ldec_debitostmp-$ldec_debitostmpneg;
			$ldec_creditosant = $ldec_creditostmp-$ldec_creditostmpneg;
			$ldec_saldoanterior = $ldec_debitosant-$ldec_creditosant;
		}
		
		$ls_sql="SELECT A.nomban as nomban,C.nomtipcta as nomtipcta
				 FROM scb_banco A,scb_ctabanco B,scb_tipocuenta C
				 WHERE A.codban=B.codban AND B.codtipcta=C.codtipcta AND A.codban='".$ls_codban."' AND B.ctaban='".$ls_ctaban."'";
		$rs_data=$this->SQL->select	($ls_sql);
		if($rs_data==false)
		{
			return false;
		}
		else
		{
			if($row=$this->SQL->fetch_row($rs_data))
			{	
				$ls_nomtipcta=$row["nomtipcta"];
				$ls_nomban=$row["nomban"];
			}
		}
		
		
		$ls_sql="SELECT (CASE codope
							WHEN 'CH' THEN 'Cheque'
							WHEN 'ND' THEN 'Nota de Debito'
							WHEN 'RE' then 'Retiro'
							ELSE ' '
							END ) AS operacion,0 as debitos,sum(montoaux-monretaux) as creditos ,count(*) as cantidad
				FROM scb_movbco
				WHERE codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
				AND (fecmov >= '".$ld_fecdesde."' AND fecmov <= '".$ld_fechasta."')
				AND (codope='CH' OR codope='ND' OR codope='RE') 
				GROUP BY codope,fecmov
				ORDER BY fecmov";
		$ls_sql2="SELECT (CASE codope
						WHEN 'NC' THEN 'Nota de Credito'
						WHEN 'DP' THEN 'Deposito'
						ELSE ' '
						END ) AS operacion,sum(montoaux-monretaux) as debitos,0 as creditos ,count(*) as cantidad
				FROM scb_movbco
				WHERE codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
				AND (fecmov >= '".$ld_fecdesde."' AND fecmov <= '".$ld_fechasta."')
				AND (codope='DP' OR codope='NC')  
				GROUP BY codope ,fecmov
				ORDER BY fecmov ";
		$rs_data=$this->SQL->select($ls_sql);
		if( $rs_data===false)
		{
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ldec_creditos=0; $ldec_creditosneg=0; $ldec_debitos=0; $ldec_debitosneg=0;
				$ldec_debitos=$row["debitos"];
				$ldec_creditos=$row["creditos"];
				$ldec_total_debe = $ldec_total_debe+$ldec_debitos;
				$ldec_total_haber= $ldec_total_haber+$ldec_creditos;
				$ls_operacion=$row["operacion"];
				$li_cantidad=$row["cantidad"];
				$ds_edocta->insertRow("operacion",$ls_operacion);
				$ds_edocta->insertRow("debitos",$ldec_debitos);
				$ds_edocta->insertRow("creditos",$ldec_creditos);
				$ds_edocta->insertRow("cantidad",$li_cantidad);
			}
			$this->SQL->free_result($rs_data);			
		}	
		$rs_data=$this->SQL->select($ls_sql2);
		if( $rs_data===false)
		{
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ldec_creditos=0; $ldec_creditosneg=0; $ldec_debitos=0; $ldec_debitosneg=0;
				$ldec_debitos=$row["debitos"];
				$ldec_creditos=$row["creditos"];
				$ldec_total_debe = $ldec_total_debe+$ldec_debitos;
				$ldec_total_haber= $ldec_total_haber+$ldec_creditos;
				$ls_operacion=$row["operacion"];
				$li_cantidad=$row["cantidad"];
				$ds_edocta->insertRow("operacion",$ls_operacion);
				$ds_edocta->insertRow("debitos",$ldec_debitos);
				$ds_edocta->insertRow("creditos",$ldec_creditos);
				$ds_edocta->insertRow("cantidad",$li_cantidad);
			}
			$this->SQL->free_result($rs_data);			
		}	
				
		return $ds_edocta->data;
	}
function uf_obtener_mov_conciliacion($ls_mesano,$ls_codban,$ls_ctaban,$ldec_salseglib,$ldec_salsegbco)
	{
		$io_fecha=new class_fecha();
		$ds_mov=new class_datastore();
		$ds_movimientos=new class_datastore();
		$ls_codemp=$this->dat_emp["codemp"];
		$ld_fechasta=$io_fecha->uf_last_day(substr($ls_mesano,0,2),substr($ls_mesano,2,4));
		$ld_fechasta=$this->fun->uf_convertirdatetobd($ld_fechasta);
		$ld_fecdesde="01/".substr($ls_mesano,0,2)."/".substr($ls_mesano,2,4);
		$ld_fecdesde=$this->fun->uf_convertirdatetobd($ld_fecdesde);

		$ls_sql="SELECT * 
				 FROM scb_movbco
				 WHERE codemp='".$ls_codemp."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND fecmov <='".$ld_fechasta."' AND (estreglib='' OR (estreglib<>'' AND feccon<>'".$ld_fecdesde."'))";
				 
		$rs_data=$this->SQL->select($ls_sql);	
	 
		if($rs_data===false)
		{
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_codban=$row["codban"];
				$ds_mov->insertRow("codban",$ls_codban);
				$ls_ctaban=$row["ctaban"];
				$ds_mov->insertRow("ctaban",$ls_ctaban);
				$ls_numdoc=$row["numdoc"];
				$ds_mov->insertRow("numdoc",$ls_numdoc);
				$ls_nomproben=$row["nomproben"];
				$ds_mov->insertRow("nomproben",$ls_nomproben);
				$ld_fecmov=$row["fecmov"];
				$ds_mov->insertRow("fecmov",$ld_fecmov);
				$ldec_monto=$row["monto"];
				$ds_mov->insertRow("monto",$ldec_monto);
				$ls_conmov=$row["conmov"];
				$ds_mov->insertRow("conmov" ,$ls_conmov);	
				$ls_estmov=$row["estmov"];
				$ds_mov->insertRow("estmov" ,$ls_estmov);	
			}
			$this->SQL->free_result($rs_data);
		}		
		$ldec_saldo_ant=$this->uf_calcular_saldolibro($ls_codban,$ls_ctaban,$ld_fechasta);

		if(abs($ldec_saldo_ant-$ldec_salseglib)>0.01)
		{
			$this->io_msg->message("Vuelva a modulo conciliaci�n ya que hay movimientos no registrados");
			return false;
		}
		else
		{
			$this->io_msg->message("Todo Bien");
		}
		
			$ls_sql= "SELECT '01' as tipo, '-' as suma, numdoc , nomproben, fecmov , monto-monret as monto, codope  
					  FROM scb_movbco
					  WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND 
					        estreglib=''  AND ((feccon > '".$ld_fecdesde."'  ) OR (feccon='1900-01-01')) AND 
					       (((codope='CH' OR codope='ND' OR codope='RE') AND estmov<>'A') OR ((codope='DP' OR codope='NC') AND estmov='A'))";


		
		$rs_data= $this->SQL->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message($this->uf_convertirmsg($this->SQL->message));
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}


			$ls_sql= "SELECT '02' as tipo, '+' as suma, numdoc, nomproben, fecmov, monto-monret as monto, codope
					  FROM   scb_movbco
					  WHERE  fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND estreglib=''
					  AND ((feccon > '".$ld_fecdesde."' ) OR (feccon='1900-01-01'))
					  AND (((codope='CH' OR codope='ND' OR codope='RE') AND estmov='A') OR ((codope='DP' OR codope='NC') AND estmov<>'A'))";
		
		$rs_data= $this->SQL->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message($this->uf_convertirmsg($this->SQL->message));
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}
			
		// No Registradas en Libros
		
		   $ls_sql = "SELECT 'A1' as tipo, '+' as suma, numdoc, conmov as nomproben,fecmov, monto-monret as monto, codope
					  FROM   scb_movbco
					  WHERE  fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
					  AND  feccon='".$ld_fecdesde."' AND estreglib='A' AND (((codope='CH' OR codope='ND' OR codope='RE') AND estmov<>'A') OR 
					  ((codope='DP' OR codope='NC') AND estmov='A'))"; 
		
		$rs_data= $this->SQL->select($ls_sql);		

		if($rs_data===false)
		{
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);

		}		
		
		$ls_sql="SELECT 'A2' as tipo, '-' as suma, numdoc, conmov as nomproben, fecmov, monto-monret as monto, codope 
				 FROM  scb_movbco
				 WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
				 AND feccon='".$ld_fecdesde."' AND estreglib='A' 
				 AND (((codope='CH' OR codope='ND' OR codope='RE') AND estmov='A') OR ((codope='DP' OR codope='NC') AND estmov<>'A'))";
			
		$rs_data= $this->SQL->select($ls_sql);		

		if($rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}		
				
		// Error Libro
		$ls_sql="SELECT 'B1' as tipo, '+' as suma, numdoc, conmov as nomproben, fecmov , monto-monret as monto, codope 
				FROM scb_movbco
				WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
				AND feccon='".$ld_fecdesde."' AND estreglib='B' 
				AND (((codope='CH' OR codope='ND' OR codope='RE') AND estmov<>'A') OR ((codope='DP' OR codope='NC') AND estmov='A')) ";
			
		$rs_data= $this->SQL->select($ls_sql);		

		if($rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}				
		
		$ls_sql="SELECT 'B2' as tipo, '-' as suma, numdoc, conmov as nomproben, fecmov , monto-monret as monto, codope 
				FROM scb_movbco
				WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."'
				AND feccon='".$ld_fecdesde."' AND estreglib='B' 
				AND  (((codope='CH' OR codope='ND' OR codope='RE') AND estmov='A') OR ((codope='DP' OR codope='NC') AND estmov<>'A')) ";
		
		$rs_data= $this->SQL->select($ls_sql);		

		if($rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);

		}
				
		// Error Banco
		$ls_sql="SELECT 'C1' as tipo, '-' as suma, numdoc, conmov as nomproben, fecmov, monmov as monto, codope 
				 FROM scb_errorconcbco 
				 WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND 
				 fecmesano='".$ld_fecdesde."' AND esterrcon='C' AND 
				 (((codope='CH' OR codope='ND' OR codope='RE') AND estmov<>'A') OR ((codope='DP' OR codope='NC') AND estmov='A')) ";
			
		$rs_data= $this->SQL->select($ls_sql);		
	
		if($rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}
		
		$ls_sql="SELECT 'C2' as tipo, '+' as suma, numdoc, conmov as nomproben, fecmov , monmov as monto, codope 
				 FROM  scb_errorconcbco 
		 		 WHERE fecmov <='".$ld_fechasta."' AND codban='".$ls_codban."' AND ctaban='".$ls_ctaban."' AND 
				 fecmesano='".$ld_fecdesde."' and esterrcon='C' AND 
				 (((codope='CH' OR codope='ND' OR codope='RE') AND estmov='A') OR ((codope='DP' OR codope='NC') AND estmov<>'A')) ";
		
		$rs_data= $this->SQL->select($ls_sql);		
		if($rs_data===false)
		{
			print $this->SQL->message;
			return false;
		}
		else
		{
			while($row=$this->SQL->fetch_row($rs_data))
			{
				$ls_tipo=$row["tipo"];
				$ds_movimientos->insertRow("tipo",$ls_tipo);
				$ls_suma=$row["suma"];
				$ds_movimientos->insertRow("suma",$ls_suma);
				$ls_numdoc=$row["numdoc"];
				$ds_movimientos->insertRow("numdoc",$ls_numdoc);
				$ls_cedbene=$row["nomproben"];
				$ds_movimientos->insertRow("nomproben",$ls_cedbene);
				$ls_fecha=$this->fun->uf_convertirfecmostrar($row["fecmov"]);
				$ds_movimientos->insertRow("fecmov",$ls_fecha);
				$ldec_monto=$row["monto"];
				$ds_movimientos->insertRow("monto",$ldec_monto);
				$ls_codope=$row["codope"];
				$ds_movimientos->insertRow("codope",$ls_tipo);
			}
			$this->SQL->free_result($rs_data);
		}					
		return $ds_movimientos->data;	
	}
			
	function uf_calcular($data,$ls_mesano)		 
	{
		$ds_mov=new class_datastore();	
		$ds_mov->data=$data;
		$li_total=$ds_mov->getRowCount("numdoc");
		$ldec_CreditosTmp=0;
		$ldec_CreditosTmpNeg=0;
		$ldec_DebitosTmp=0;
		$ldec_DebitosTmpNeg=0;
		for($li_i=1;$li_i<=$li_total;$li_i++)
		{
			$ls_codope=$ds_mov->getValue("codope",$li_i);
			$ls_estmov=$ds_mov->getValue("estmov",$li_i);
			$ldec_monto=$ds_mov->getValue("monto",$li_i);
			if((($ls_codope=='CH')||($ls_codope=='ND')||($ls_codope=='RE'))&&($ls_estmov<>'A')){$ldec_CreditosTmp=$ldec_CreditosTmp+$ldec_monto;}
			if((($ls_codope=='CH')||($ls_codope=='ND')||($ls_codope=='RE'))&&($ls_estmov=='A')){$ldec_CreditosTmpNeg=$ldec_CreditosTmpNeg+$ldec_monto;}
			if((($ls_codope=='DP')||($ls_codope=='NC'))&&($ls_estmov<>'A'))	{$ldec_DebitosTmp=$ldec_DebitosTmp+$ldec_monto;	}
			if((($ls_codope=='DP')||($ls_codope=='NC'))&&($ls_estmov=='A'))	{$ldec_DebitosTmpNeg=$ldec_DebitosTmpNeg+$ldec_monto;}
		}
		$ldec_DebitosAnt = $ldec_DebitosTmp-$ldec_DebitosTmpNeg;
		$ldec_CreditosAnt = $ldec_CreditosTmp-$ldec_CreditosTmpNeg;
		$ldec_SaldoAnterior = $ldec_DebitosAnt - $ldec_CreditosAnt;				
		return round($ldec_SaldoAnterior,2);	
	}
	
	function uf_calcular_saldolibro($as_codban,$as_ctaban,$ad_fecha)
	{
	/////////////////////////////////////////////////////////////////////////////
	// Funtion	    :  uf_calcular_saldolibro
	//
	//	Return	    :  ldec_saldo
	//
	//	Descripcion :  Fucnion que se encarga de obtener el saldo de los movimientos registrdos en libro
	///////////////////////////////////////////////////////////////////////////// 
	$ldec_monto_haber=0;$ldec_monto_debe=0;$ldec_saldo=0;
	
	$ls_codemp = $this->dat_emp["codemp"];		
	$ld_fecha = $this->fun->uf_convertirdatetobd($ad_fecha);
		
	$ls_sql="SELECT monhab,mondeb,(mondeb - monhab) As saldo
			 FROM ( SELECT COALESCE( SUM(monto - monret),0) As monhab
				   FROM  scb_movbco 
				   WHERE codban='".$as_codban."' AND ctaban='".$as_ctaban."' AND  
	  			   (codope='RE' OR codope='ND' OR codope='CH') AND  estmov<>'A' AND estmov<>'O' AND (estreglib<>'A' or (estreglib='A' AND estcon=1)) AND codemp='".$ls_codemp."' AND fecmov<='".$ld_fecha."') D,
				 ( SELECT COALESCE( SUM(monto - monret),0) As mondeb
				   FROM scb_movbco
				   WHERE codban='".$as_codban."' AND ctaban='".$as_ctaban."' AND  
	 			   (codope='NC' OR codope='DP') AND estmov<>'A' AND estmov<>'O' AND (estreglib<>'A' or (estreglib='A' AND estcon=1)) AND codemp='".$ls_codemp."' AND fecmov<='".$ld_fecha."') H ";												
		
	$rs_saldos=$this->SQL->select($ls_sql);		
		if(($rs_saldos==false)&&($this->SQL->message!=""))
		{
			print "Saldolibro".$this->SQL->message;
		}
		else
		{		
			if($row=$this->SQL->fetch_row($rs_saldos))
			{
				$ldec_mondeb=$row["mondeb"];
				$ldec_monhab=$row["monhab"];
				$ldec_saldo=$row["saldo"];				
				if(is_null($ldec_saldo)){$ldec_saldo=0;}
				if( (is_null($ldec_monto_debe) )&&($ldec_monto_haber>0) ){$ldec_saldo=$ldec_monto_haber;} 
				if( (is_null($ldec_monto_haber))&&($ldec_monto_debe>0) ){$ldec_saldo=$ldec_monto_debe;}
			}
			$this->SQL->free_result($rs_saldos);			
		}			
		return  $ldec_saldo;
	}
	
	function uf_listado_cheques($ls_codban,$ls_cuenta,$ls_chequera)
	{
		/////////////////////////////////////////////////////////////////////////////
		// Funtion	    :  uf_listado_cheques		
		//	Return	    :  la_data		
		//	Descripcion :  Fucnion que se encarga de retornar los cheques pertenecnientes a una cuenta y a un banco
		///////////////////////////////////////////////////////////////////////////// 
		$ls_codemp = $this->dat_emp["codemp"];		
		$la_data=array();
		$ls_sql="SELECT a.codban,a.ctaban,a.numchequera,a.numche,b.nomproben,b.fecmov,a.estche,b.montoaux as monto,b.numdoc
				   FROM scb_cheques a LEFT OUTER JOIN scb_movbco b
				     ON (a.codban=b.codban AND a.ctaban=b.ctaban AND a.numche=b.numdoc AND b.codope='CH')
				  WHERE a.codban='$ls_codban' AND a.ctaban='$ls_cuenta' and a.numchequera='$ls_chequera'";												
			
		    $rs_data=$this->SQL->select($ls_sql);		
			if(($rs_data==false)&&($this->SQL->message!=""))
			{
				print $this->SQL->message;
			}
			else
			{		
				if($row=$this->SQL->fetch_row($rs_data))
				{
					$la_data=$this->SQL->obtener_datos($rs_data);					
				}
				$this->SQL->free_result($rs_data);			
			}			
			return  $la_data;		
	}
	
	function uf_comprobante_retencion($ls_numcom,$ls_fechainicio,$ls_fechafin)
	{
		/////////////////////////////////////////////////////////////////////////////
		// Funtion	    :  uf_comprobante_retencion
		//	Return	    :  la_data		
		//	Descripcion :  Funcion que se encarga de retornar los datos de los comprobantes de retencion asociados al codigo dado
		//  Autor       :  Ing. Laura Cabr�
		//  Fecha       :  03/10/2006
		///////////////////////////////////////////////////////////////////////////// 
		$ls_codemp = $this->dat_emp["codemp"];		
		$la_data=array();
					
	    $ls_sql = "SELECT scb_cmp_ret.nomsujret, scb_cmp_ret.rif, scb_cmp_ret.estcmpret, scb_cmp_ret.numlic,
				 	      scb_dt_cmp_ret.numfac, scb_dt_cmp_ret.fecfac, scb_dt_cmp_ret.numcon, scb_dt_cmp_ret.numsop,
					      scb_dt_cmp_ret.basimpaux as basimp, scb_dt_cmp_ret.porimp, scb_dt_cmp_ret.iva_retaux as iva_ret
 					 FROM scb_cmp_ret, scb_dt_cmp_ret
				    WHERE scb_cmp_ret.codemp='".$ls_codemp."'
				      AND scb_cmp_ret.numcom='".$ls_numcom."'
					  AND scb_cmp_ret.codret='0000000003'
					  AND scb_cmp_ret.fecrep BETWEEN '".$ls_fechainicio."' AND '".$ls_fechafin."'
					  AND scb_cmp_ret.codemp=scb_dt_cmp_ret.codemp
					  AND scb_cmp_ret.codret=scb_dt_cmp_ret.codret
					  AND scb_cmp_ret.numcom=scb_dt_cmp_ret.numcom";
			$rs_data=$this->SQL->select($ls_sql);//print $ls_sql;
			if($rs_data===false)
			{
				print $this->SQL->message;
			}
			else
			{		
				if($row=$this->SQL->fetch_row($rs_data))
				{
					$la_data=$this->SQL->obtener_datos($rs_data);					
				}
				$this->SQL->free_result($rs_data);			
			}			
			return  $la_data;	
	}
	
	
	
	function uf_formato_cartaorden($as_codigo,&$la_data)
	{
		/////////////////////////////////////////////////////////////////////////////
		// Funtion	    :  uf_comprobante_retencion
		//	Return	    :  la_data		
		//	Descripcion :  Funcion que se encarga de retornar los datos de los comprobantes de retencion asociados al codigo dado
		//  Autor       :  Ing. Laura Cabr�
		//  Fecha       :  03/10/2006
		///////////////////////////////////////////////////////////////////////////// 
		$ls_codemp = $this->dat_emp["codemp"];		
		$la_data=array();
		$ls_sql="SELECT * 
				FROM scb_cartaorden
				WHERE codemp='$ls_codemp' and codigo='$as_codigo'";
			$rs_data=$this->SQL->select($ls_sql);		
			if(($rs_data==false)&&($this->SQL->message!=""))
			{
				print $this->SQL->message;
				return false;
			}
			else
			{		
				if($row=$this->SQL->fetch_row($rs_data))
				{
					$la_data=$this->SQL->obtener_datos($rs_data);
					return true;					
				}
				else
					return false;
				$this->SQL->free_result($rs_data);			
			}			
			
	}
	function uf_select_cartaorden($as_numdoc,$as_codban,$as_ctaban)
	{
	  /*--------------------------------------------------------------
		Function:	    uf_select_cartaorden
		   Description: Funcion que se buscar los datos de una carta orden especifica
		         Fecha: 26/12/2006
		         Autor: Ing. Laura Cabre
		Modificado Por: Ing. N�stor Falc�n.    Fecha �ltima Modificaci�n: 22/08/2007.
	  ----------------------------------------------------------------------------------*/
		$ls_codemp=$this->dat_emp["codemp"];
		
		$ls_sql = "SELECT max(scb_movbco.numcarord) as numcarord,scb_movbco.numdoc,max(scb_movbco.ctaban) as ctaban, max(scb_movbco.monto) as monto,
						  max(scb_banco.nomban) as nomban,max(scb_banco.gerban) as gerban,max(scb_tipocuenta.nomtipcta) as nomtipcta 
					 FROM scb_movbco, scb_banco, scb_ctabanco , scb_tipocuenta 
					WHERE scb_movbco.codemp='".$ls_codemp."' 
					  AND scb_movbco.numcarord='".$as_numdoc."' 
					  AND scb_movbco.codban='".$as_codban."' 
					  AND scb_movbco.ctaban='".$as_ctaban."' 
					  AND scb_movbco.estmov<>'A' 
					  AND scb_movbco.estmov<>'O' 
					  AND scb_movbco.codope='ND' 
					  AND scb_movbco.codemp=scb_banco.codemp 
					  AND scb_movbco.codban=scb_banco.codban 
					  AND scb_movbco.codemp=scb_ctabanco.codemp 
					  AND scb_movbco.codban=scb_ctabanco.codban 
					  AND scb_movbco.ctaban=scb_ctabanco.ctaban 
					  AND scb_ctabanco.codtipcta=scb_tipocuenta.codtipcta
					GROUP BY scb_movbco.numdoc;";
					
		$rs_data=$this->SQL->select($ls_sql);
		if($rs_data===false)
		{
			$data=array();
			$this->is_msg_error="Error uf_select_cartaorden, ".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->is_msg_error;
			return false;
		}
		else
		{
			if($row=$this->SQL->fetch_row($rs_data))
			{
			  $data=$this->SQL->obtener_datos($rs_data);
			}
			else
			{
			  $data=array();
			}
			$this->SQL->free_result($rs_data);
		}
		return $data;
	}
	
	function uf_check_tipo_cartaorden($as_numdoc,$as_codban,$as_ctaban)
	{
	  /*--------------------------------------------------------------
		Function:	    uf_select_cartaorden
		Description:	Funcion que se buscar los datos de una carta orden especifica
		Fecha: 26/12/2006
		Autor: Ing. Laura Cabre
	               
	----------------------------------------------------------------------------*/
		$ls_codemp=$this->dat_emp["codemp"];
		$ls_sql="SELECT a.numdoc,b.numdoc
				 FROM   scb_movbco a,scb_dt_movbco b
				 WHERE a.codemp='".$ls_codemp."' 
				AND a.codemp=b.codemp AND a.codban=b.codban AND a.numdoc='$as_numdoc' 
				AND a.codban='$as_codban' AND a.ctaban='$as_ctaban' 
				AND a.codope='ND' AND a.ctaban=b.ctaban  AND a.codope=b.codope";	
		$rs_data=$this->SQL->select($ls_sql);
		
		if($rs_data===false)
		{
			$data=array();
			$this->is_msg_error="Error uf_check_tipo_cartaorden, ".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->is_msg_error;
			return false;
		}
		else
		{
			if($row=$this->SQL->fetch_row($rs_data))
			{
			   $lb_existe=true;
			}
			else
			{
			   $lb_existe=false;
			}
			$this->SQL->free_result($rs_data);
		}
		return $lb_existe;	
	}
	
	
	
	function uf_select_dt_cartaorden($as_numdoc,$as_codban,$as_ctaban,$as_tipproben)
	{
	  /*--------------------------------------------------------------
		Function:	    uf_select_cartaorden
		Description:	Funcion que se buscar los datos de una carta orden especifica
		Fecha: 26/12/2006
		Autor: Ing. Laura Cabre
	               
	----------------------------------------------------------------------------*/
		$ls_straux = "";
		$ls_codemp=$this->dat_emp["codemp"];
		if ($as_tipproben=='P')
		   {
		     $ls_campo  = "cod_pro";
		     $ls_tabla  = "rpc_proveedor";
		     $ls_straux = ", max(rpc_proveedor.nompro) as nompro";
			 $ls_group1 = "";		   
		     $ls_group2 = " GROUP BY scb_movbco.cod_pro,scb_movbco.ctaban";
		   }
		else
		   {
		     $ls_campo  = "ced_bene";
		     $ls_tabla  = "rpc_beneficiario";
		     $ls_straux = ", max(rpc_beneficiario.nombene) as nombene,max(rpc_beneficiario.apebene) as apebene ";
		     $ls_group1 = " GROUP BY scb_dt_movbco.ced_bene,scb_dt_movbco.ctabanbene";
		     $ls_group2 = " GROUP BY scb_movbco.ced_bene,scb_movbco.ctaban";
		   }
		if($this->uf_check_tipo_cartaorden($as_numdoc,$as_codban,$as_ctaban))
		{
			$ls_sql=  "SELECT max(scb_dt_movbco.ctabanbene) as ctaban,scb_dt_movbco.ced_bene,".
			          "       sum(scb_dt_movbco.monsolpag) as monto $ls_straux          ".
					  "  FROM scb_dt_movbco, $ls_tabla			 						".
					  " WHERE scb_dt_movbco.codemp='".$ls_codemp."' 					".
					  "   AND scb_dt_movbco.numdoc='".$as_numdoc."' 					".
					  "   AND scb_dt_movbco.codban='".$as_codban."' 					".
					  "   AND scb_dt_movbco.ctaban='".$as_ctaban."' 					".
					  "   AND scb_dt_movbco.codemp=$ls_tabla.codemp 					".
					  "   AND scb_dt_movbco.$ls_campo=$ls_tabla.$ls_campo $ls_group1	";
		}
		else
		{
			$ls_sql = "  SELECT max($ls_tabla.ctaban) as ctaban,scb_movbco.$ls_campo, ".
			          "         sum(scb_movbco.monto) as monto $ls_straux   	      ".
					  "    FROM scb_movbco, $ls_tabla 					    	      ".
					  "   WHERE scb_movbco.codemp='".$ls_codemp."' 				      ".
					  "     AND scb_movbco.numcarord='".$as_numdoc."' 			      ".
					  "     AND scb_movbco.codban='".$as_codban."' 				      ".
					  "     AND scb_movbco.ctaban='".$as_ctaban."' 				      ".
					  "     AND scb_movbco.codemp=$ls_tabla.codemp 				      ".
					  "     AND scb_movbco.$ls_campo=$ls_tabla.$ls_campo $ls_group2 ";
		}
		$rs_data=$this->SQL->select($ls_sql);
		if($rs_data===false)
		{
			$la_data=array();
			$this->is_msg_error="Error uf_select_dt_cartaorden, ".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->SQL->message;
			return false;
		}
		else
		{
			$li=0;
			if ($as_tipproben=='B')
			   {
			     while ($row=$this->SQL->fetch_row($rs_data))
			           {
				         $li++;
				         $la_data[$li]=array('cedbene'=>$row["ced_bene"],'nombene'=>$row["nombene"].$row["apebene"],'ctaban'=>$row["ctaban"],'monto'=>number_format($row["monto"],2,",","."));
			           }
			   }
			elseif($as_tipproben=='P')
			   {
			     while ($row=$this->SQL->fetch_row($rs_data))
					   {
					     $li++;
						 $la_data[$li]=array('cod_pro'=>$row["cod_pro"],'nompro'=>$row["nompro"],'ctaban'=>$row["ctaban"],'monto'=>number_format($row["monto"],2,",","."));
					   }
			   }
			$this->SQL->free_result($rs_data);
		}
		
		return $la_data;
	}
	
function uf_generar_cmpret_ordendepagodirecta($ls_codemp,$ls_numdoc,$ls_codban,$ls_ctaban,$ls_tipodestino,$ls_codpro,$ls_cedben,$ls_fecrep,$la_data_cmpret)
	{
		$lb_valido=false;
			 
		$ls_sql="SELECT a.numdoc,a.codban,a.ctaban,a.codope,a.baseimp,b.monobjret as monobjret,a.monto as monto_iva,b.monto as monto_ret,a.codcar,b.codded,d.porcar,c.porded,
						c.estretmun,c.islr,c.iva,a.documento 
				FROM scb_movbco_spgop a,scb_movbco_scg b,sigesp_deducciones c,sigesp_cargos d
				WHERE a.codemp='".$ls_codemp."' AND a.numdoc='".$ls_numdoc."' AND a.codban='".$ls_codban."' AND a.ctaban='".$ls_ctaban."' AND a.codope='OP' AND a.numdoc=b.numdoc AND a.codope=b.codope AND a.codban=b.codban AND a.ctaban=b.ctaban
				AND a.codcar<>'' AND b.codded<>'0000' AND b.codded<>'00000' AND b.codded=c.codded AND a.codcar=d.codcar AND concat(a.codemp,a.numdoc,a.codban,a.ctaban,a.codope) not in (SELECT concat(codemp,numdoc,codban,ctaban,codope) FROM scb_dt_cmp_ret_op)";
		//print $ls_sql;		 
		$rs_data=$this->SQL_aux->select($ls_sql);
		if($rs_data===false)
		{
			$this->is_msg_error="Error uf_generar_cmpret_ordendepagodirecta, ".$this->fun->uf_convertirmsg($this->SQL_aux->message);
			print $this->SQL_aux->message;
			return false;
		}
		else
		{
			$li_control_mun=0;
			$li_control_iva=0;
			$li_control_islr=0;
			$ls_tipocomp="";
			$this->SQL->begin_transaction();
			while($row=$this->SQL_aux->fetch_row($rs_data))
			{				
			
				$li_estretmun=$row["estretmun"];
				$li_iva=$row["iva"];
				$li_islr=$row["islr"];
				$ldec_baseimp=$row["baseimp"];
				$ldec_monobjret=$row["monobjret"];
				$ldec_porded=$row["porded"];
				$ldec_porcar=$row["porcar"];
				$ldec_monret=$row["monto_ret"];
				$ldec_iva=$row["monto_iva"];
				$ldec_monto=$la_data_cmpret['monto'];
				$ldec_totcmpsiniva=($ldec_monto-$ldec_iva);
				$ls_numdocres=$la_data_cmpret['numdocres'];
				$ls_fecdocres=$la_data_cmpret['fecdocres'];
				$ls_nrocontrol=$la_data_cmpret['nrocontrol'];
				$ls_desope=$la_data_cmpret["desope"];
				$ls_numsop=$row["documento"];
				if($li_estretmun==1)
				{
					$li_control_iva=0;
					$li_control_islr=0;
					$li_control_mun++;
					if($li_control_mun==1)
					{
						$ls_tipocomp=" MUNICIPAL ";
						$ls_retid='0000000003';
						$lb_valido=$this->uf_guardar_cmpret($ls_codemp,$ls_retid,&$ls_nrocomp,$ls_fecrep,$ls_tipodestino,$ls_codpro,$ls_cedben,$ls_tipocomp,$ls_numdoc);
					}
			
					$this->uf_guardar_dt_cmpret($ls_codemp,$ls_retid,$ls_nrocomp,$li_control_mun,$ls_fecdocres,$ls_numdocres,$ls_nrocontrol,'', 
								  '', '01-reg',$ldec_totcmpsiniva,$ldec_monto,$ldec_monobjret,$ldec_porded,
								  $ldec_monret,$ldec_monret,$ls_desope,$ls_numsop,$ls_codban,$ls_ctaban,$ls_numdoc,'OP');
				}
				if($li_iva==1)
				{
					$li_control_mun=0;
					$li_control_islr=0;
					$li_control_iva++;
					if($li_control_iva==1)
					{
						$ls_tipocomp=" IVA ";	
						$ls_retid='0000000001';
						$lb_valido=$this->uf_guardar_cmpret($ls_codemp,$ls_retid,&$ls_nrocomp,$ls_fecrep,$ls_tipodestino,$ls_codpro,$ls_cedben,$ls_tipocomp,$ls_numdoc);
					}	
														
					$lb_valido=$this->uf_guardar_dt_cmpret($ls_codemp,$ls_retid,$ls_nrocomp,$li_control_iva,$ls_fecdocres,$ls_numdocres,$ls_nrocontrol,'', 
								  '', '01-reg',$ldec_totcmpsiniva,$ldec_monto,$ldec_baseimp,$ldec_porcar,
								  $ldec_iva,$ldec_monret,$ls_desope,$ls_numsop,$ls_codban,$ls_ctaban,$ls_numdoc,'OP');
				}
							
			}//End while	
			if($lb_valido)
			{
				$this->SQL->commit();		
			}
			else
			{
				$this->SQL->rollback();		
			}	
		}	
	}
	
	function uf_guardar_dt_cmpret($ls_codemp,$ls_codret,$ls_numcom,$ls_numope,$ld_fecfac,$ls_numfac,$ls_numcon,$ls_numnd, 
								  $ls_numnc,$ls_tiptrans,$ldec_totcmpsiniva,$ldec_totcmpconiva,$ldec_basimp,$ldec_porimp,
								  $ldec_totimp,$ldec_ivaret,$ls_desope,$ls_numsop,$ls_codban,$ls_ctaban,$ls_numdoc,$ls_codope)
	{
		$ls_sql="INSERT INTO scb_dt_cmp_ret_op(codemp, codret, numcom, numope, fecfac, numfac, numcon, numnd, 
											  numnc, tiptrans, totcmp_sin_iva, totcmp_con_iva, basimp, porimp,
											   totimp, iva_ret, desope, numsop, codban, ctaban, numdoc, codope)
				 VALUES('".$ls_codemp."','".$ls_codret."','".$ls_numcom."','".$ls_numope."','".$this->fun->uf_convertirdatetobd($ld_fecfac)."','".$ls_numfac."','".$ls_numcon."','".$ls_numnd."', 
						'".$ls_numnc."','".$ls_tiptrans."','".$ldec_totcmpsiniva."','".$ldec_totcmpconiva."','".$ldec_basimp."','".$ldec_porimp."',
						'".$ldec_totimp."','".$ldec_ivaret."','".$ls_desope."','".$ls_numsop."','".$ls_codban."','".$ls_ctaban."','".$ls_numdoc."','OP')";							   
		
		$li_result=$this->SQL->execute($ls_sql);	
		if($li_result===false)
		{
			$this->is_msg_error="Error en guardar_dt_cmp".$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->SQL->message;
			return false;			
		}
		else
		{
			return true;
		}
	}
	
	function uf_select_dt_sujret($ls_tipodestino,$ls_codproben,$ls_codemp)
	{	
		if($ls_tipodestino=='P')
		{
			$rs_provben=$this->uf_select_rowdata($this->SQL,"SELECT nompro as nomproben,dirpro as dirproben,rifpro as rifproben,nitpro as nitproben FROM rpc_proveedor WHERE cod_pro ='".$ls_codproben."' AND codemp='".$ls_codemp."'");
		}
		else
		{
			if($_SESSION["ls_gestor"]=="MYSQL")
			{
				$ls_aux=" concat(nombene,apebene) as nomproben";
			}
			else
			{
				$ls_aux=" nombene||apebene as nomproben";
			}
			$rs_provben=$this->uf_select_rowdata($this->SQL,"SELECT ".$ls_aux.",dirbene as dirproben,rifbene as rifproben,ced_bene as nitproben FROM rpc_beneficiario WHERE ced_bene ='".$ls_codproben."' AND codemp='".$ls_codemp."'");
		}
	    return $rs_provben;
	}
	

	function uf_guardar_cmpret($ls_codemp,$ls_codret,$ls_nrocomp,$ls_fecrep,$ls_tipodestino,$ls_codpro,$ls_cedben,$ls_tipocomp,$ls_numdoc)
	{
		$ls_perfiscal=substr($ls_fecrep,-4).substr($ls_fecrep,3,2);
		$ld_fecha=$this->fun->uf_convertirdatetobd($ls_fecrep);
	    require_once("../../shared/class_folder/sigesp_c_seguridad.php");
	    $this->io_seguridad= new sigesp_c_seguridad();
		if($ls_tipodestino=='P')
		{
			$ls_destino=" Proveedor " ;
			$ls_codproben=$ls_codpro;
		}
		else
		{
			$ls_destino=" Beneficiario ";		
			$ls_codproben=$ls_cedben;
		}
		$la_provbene=$this->uf_select_dt_sujret($ls_tipodestino,$ls_codproben,$ls_codemp);
		$this->uf_ccr_get_nro($ls_perfiscal,&$ls_nrocomp,$ls_codret);
		$ls_sql="INSERT INTO scb_cmp_ret_op(codemp, codret, numcom, fecrep, perfiscal, codsujret,
											nomsujret, dirsujret, rif, nit, estcmpret, codusu, numlic,origen)
				 VALUES('".$ls_codemp."','".$ls_codret."','".$ls_nrocomp."','".$ld_fecha."','".$ls_perfiscal."','".$ls_codproben."',
				 		'".$la_provbene["nomproben"]."','".$la_provbene["dirproben"]."','".$la_provbene["rifproben"]."','".$la_provbene["nitproben"]."',
						1,'".$_SESSION["la_logusr"]."','','A')";

		$li_result=$this->SQL->execute($ls_sql);	
		if(($li_result===false))
		{
			$this->is_msg_error="Fallo insercion de movimiento detalle de orden de pago, ".$this->fun->uf_convertirmsg($this->SQL->message);
			return false;
		}
		else
		{
			$this->is_msg_error="El movimiento fue registrado";
			///////////////////////////////////Parametros de seguridad/////////////////////////////////////////////////
			$ls_evento="INSERT";			
			$ls_descripcion="Genero el Comprobante de Retencion ".$ls_tipocomp." para la Orden de Pago Directa numero ".$ls_numdoc." para el ".$ls_destino.$la_provbene["nomproben"]." de codigo ".$ls_codproben;
			$lb_valido = $this->io_seguridad->uf_sss_insert_eventos_ventana($ls_codemp,'SCB',"INSERT",$_SESSION["la_logusr"],"sigesp_scb_rpp_ordenpago.php",$ls_descripcion);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////
			return true;		
		}	
	}
	
	function uf_ccr_get_nro($ls_periodofiscal,$ls_nrocomp,$ls_retid)
	{
		$ls_codemp=$this->dat_emp["codemp"];	
		$ls_sql="SELECT substr(numcom,7,14) as numcom 
				 FROM   scb_cmp_ret_op 
				 WHERE  codemp='".$ls_codemp."' AND codret = '".$ls_retid."' AND perfiscal = '".$ls_periodofiscal."'
				 ORDER  by numcom desc ";
		
		$rs_result=$this->SQL->select($ls_sql);		
		if($rs_result===false)
		{
			$this->is_msg_error=$this->fun->uf_convertirmsg($this->SQL->message);
			print $this->is_msg_error;
			return false;			
		}
		else
		{
			if ($row=$this->SQL->fetch_row($rs_result))
			{ 
			   $codigo=$row["numcom"];
			   settype($codigo,'int');                             // Asigna el tipo a la variable.
			   $codigo = $codigo + 1;                              // Le sumo uno al entero.
			   settype($codigo,'string');                          // Lo convierto a varchar nuevamente.
			   $ls_nrocomp=$ls_periodofiscal.$this->fun->uf_cerosizquierda($codigo,8);
			   $this->SQL->free_result($rs_result);
			   return true;
		    }
		    else
		    {
			   $codigo="1";
			   $ls_nrocomp=$ls_periodofiscal.$this->fun->uf_cerosizquierda($codigo,8);
			   $this->SQL->free_result($rs_result);
   			   return true;
		    }
		}
	}//fin uf_ccr_get_nro
	
	function uf_comprobante_retencion_mun($ls_numcom)
	{
		/////////////////////////////////////////////////////////////////////////////
		// Funtion	    :  uf_comprobante_retencion
		//	Return	    :  la_data		
		//	Descripcion :  Funcion que se encarga de retornar los datos de los comprobantes de retencion asociados al codigo dado
		//  Autor       :  Ing. Laura Cabr�
		//  Fecha       :  03/10/2006
		///////////////////////////////////////////////////////////////////////////// 
		$ls_codemp = $this->dat_emp["codemp"];		
		$la_data=array();
		$ls_sql="SELECT c.*,d.* 
				FROM scb_cmp_ret_op c, scb_dt_cmp_ret_op d 
				WHERE c.codret='0000000003' AND
				c.codemp='$ls_codemp' AND c.codemp=d.codemp AND c.codret=d.codret AND d.numdoc='$ls_numcom' AND c.numcom=d.numcom";												
			$rs_data=$this->SQL->select($ls_sql);		
			if(($rs_data==false)&&($this->SQL->message!=""))
			{
				print $this->SQL->message;
			}
			else
			{		
				if($row=$this->SQL->fetch_row($rs_data))
				{
					$la_data=$this->SQL->obtener_datos($rs_data);					
				}
				$this->SQL->free_result($rs_data);			
			}			
			return  $la_data;	
	}
	
}
?>
