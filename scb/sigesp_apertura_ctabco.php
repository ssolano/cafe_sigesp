<?php਀ऀ挀氀愀猀猀 猀椀最攀猀瀀开愀瀀攀爀琀甀爀愀开挀琀愀戀挀漀 
	{਀ऀऀ瘀愀爀 ␀匀儀䰀㬀 
		var $fun;਀ऀऀ瘀愀爀 ␀椀漀开洀猀最㬀 
		var $is_msg_error;	਀ऀऀ瘀愀爀 ␀搀愀琀㬀 
		var $ds_data;਀ऀऀ 
		਀ऀऀ昀甀渀挀琀椀漀渀 猀椀最攀猀瀀开愀瀀攀爀琀甀爀愀开挀琀愀戀挀漀⠀⤀ 
		{਀ऀऀऀ爀攀焀甀椀爀攀开漀渀挀攀⠀∀⸀⸀⼀猀栀愀爀攀搀⼀挀氀愀猀猀开昀漀氀搀攀爀⼀挀氀愀猀猀开猀焀氀⸀瀀栀瀀∀⤀㬀 
			require_once("../shared/class_folder/class_funciones.php");਀ऀऀऀ爀攀焀甀椀爀攀开漀渀挀攀⠀∀⸀⸀⼀猀栀愀爀攀搀⼀挀氀愀猀猀开昀漀氀搀攀爀⼀挀氀愀猀猀开洀攀渀猀愀樀攀猀⸀瀀栀瀀∀⤀㬀 
			require_once("../shared/class_folder/sigesp_include.php");਀ऀऀऀ爀攀焀甀椀爀攀开漀渀挀攀⠀∀⸀⸀⼀猀栀愀爀攀搀⼀挀氀愀猀猀开昀漀氀搀攀爀⼀挀氀愀猀猀开昀攀挀栀愀⸀瀀栀瀀∀⤀㬀 
			$sig_inc=new sigesp_include();਀ऀऀऀ␀挀漀渀㴀␀猀椀最开椀渀挀ⴀ㸀甀昀开挀漀渀攀挀琀愀爀⠀⤀㬀 
			$this->io_sql=new class_sql($con);਀ऀऀऀ␀琀栀椀猀ⴀ㸀匀儀䰀开愀甀砀㴀渀攀眀 挀氀愀猀猀开猀焀氀⠀␀挀漀渀⤀㬀 
			$this->io_funcion=new class_funciones();਀ऀऀऀ␀琀栀椀猀ⴀ㸀椀漀开昀攀挀栀愀㴀渀攀眀 挀氀愀猀猀开昀攀挀栀愀⠀⤀㬀 
			$this->io_msg=new class_mensajes();਀ऀऀऀ␀琀栀椀猀ⴀ㸀搀愀琀㴀␀开匀䔀匀匀䤀伀一嬀∀氀愀开攀洀瀀爀攀猀愀∀崀㬀ऀ 
			$this->ds_data=new class_datastore();			਀ऀऀ紀 
		਀ऀऀ昀甀渀挀琀椀漀渀 甀昀开挀愀氀挀甀氀愀爀开猀愀氀搀漀开挀漀氀漀挀愀挀椀漀渀⠀␀愀猀开挀漀搀戀愀渀Ⰰ␀愀猀开挀琀愀戀愀渀⤀  
		{਀ऀऀऀ⼀⨀ⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀ 
		    	- Funcion que calcula el saldo de las colocaciones਀ऀऀऀऀⴀ 刀攀琀漀爀渀愀 攀氀 猀愀氀搀漀 猀椀 猀攀 攀樀攀挀甀琀漀 挀漀爀爀攀挀琀愀洀攀渀琀攀Ⰰ 搀攀 氀漀 挀漀渀琀爀愀爀椀漀 
				  retorna falso.਀ऀऀऀऀⴀ 䔀氀愀戀漀爀愀搀漀 瀀漀爀 䤀渀最⸀ 䰀愀甀爀愀 䌀愀戀爀⸀ 
				- Fecha: 12/01/2007			਀ऀऀऀ⼀⼀ⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀⴀ⨀⼀ 
			$lb_valido=false;਀ऀऀऀ⼀⼀䌀愀氀挀甀氀愀渀搀漀 攀氀 洀漀渀琀漀 搀攀 氀漀猀 䌀爀攀搀椀琀漀猀 瀀漀猀椀琀椀瘀漀猀 ⠀渀漀 愀渀甀氀愀搀漀猀⤀ 
			$ls_codemp=$this->dat["codemp"];਀ऀऀऀ␀氀猀开猀焀氀㨀∀匀䔀䰀䔀䌀吀 䌀伀䄀䰀䔀匀䌀䔀⠀匀唀䴀⠀洀漀渀洀漀瘀挀漀氀⤀Ⰰ　⤀ 䄀匀 洀漀渀琀漀 
					FROM scb_movcol਀ऀऀऀऀऀ圀䠀䔀刀䔀 挀漀搀攀洀瀀㴀✀␀氀猀开挀漀搀攀洀瀀✀ 䄀一䐀 挀漀搀戀愀渀㴀✀␀愀猀开挀漀搀戀愀渀✀ 䄀一䐀 挀琀愀戀愀渀㴀✀␀愀猀开挀琀愀戀愀渀✀ 䄀一䐀  
					(codope='CH' OR codope='ND' OR codope='RE')	AND estcol<>'A'";਀ऀऀऀ␀爀猀开搀愀琀漀猀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀猀攀氀攀挀琀⠀␀氀猀开猀焀氀⤀㬀 
			if(($rs_datos==false))਀ऀऀऀ笀 
				$lb_valido=false;਀ऀऀऀऀ␀琀栀椀猀ⴀ㸀椀猀开洀猀最开攀爀爀漀爀㴀␀琀栀椀猀ⴀ㸀椀漀开昀甀渀挀椀漀渀ⴀ㸀甀昀开挀漀渀瘀攀爀琀椀爀洀猀最⠀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀洀攀猀猀愀最攀⤀㬀ऀऀ 
				print "Error en uf_calcular_saldo_colocacion ".$this->is_msg_error;਀ऀऀऀ紀 
			else਀ऀऀऀ笀 
				if($row=$this->io_sql->fetch_row($rs_datos))਀ऀऀऀऀ笀 
					$ldec_creditostmp=$row["monto"];਀ऀऀऀऀऀ␀氀戀开瘀愀氀椀搀漀㴀琀爀甀攀㬀ऀऀऀऀऀ 
				}			਀ऀऀऀ紀 
			if($lb_valido)//  Calculando el monto de los Creditos negativos (anulados)਀ऀऀऀ笀 
				$ls_sql="SELECT COALESCE(SUM(monmovcol),0) AS monto਀ऀऀऀऀऀऀ䘀刀伀䴀 猀挀戀开洀漀瘀挀漀氀 
						WHERE codemp='$ls_codemp' AND codban='$as_codban' AND ctaban='$as_ctaban' AND਀ऀऀऀऀऀऀ⠀挀漀搀漀瀀攀㴀✀䌀䠀✀ 伀刀 挀漀搀漀瀀攀㴀✀一䐀✀ 伀刀 挀漀搀漀瀀攀㴀✀刀䔀✀⤀ 䄀一䐀 攀猀琀挀漀氀㴀✀䄀✀∀㬀 
				$rs_datos=$this->io_sql->select($ls_sql);਀ऀऀऀऀ椀昀⠀⠀␀爀猀开搀愀琀漀猀㴀㴀昀愀氀猀攀⤀⤀ 
				{਀ऀऀऀऀऀ␀氀戀开瘀愀氀椀搀漀㴀昀愀氀猀攀㬀 
					$this->is_msg_error=$this->io_funcion->uf_convertirmsg($this->io_sql->message);		਀ऀऀऀऀऀ瀀爀椀渀琀 ∀䔀爀爀漀爀 攀渀 甀昀开挀愀氀挀甀氀愀爀开猀愀氀搀漀开挀漀氀漀挀愀挀椀漀渀 ∀⸀␀琀栀椀猀ⴀ㸀椀猀开洀猀最开攀爀爀漀爀㬀 
				}਀ऀऀऀऀ攀氀猀攀 
				{਀ऀऀऀऀऀ椀昀⠀␀爀漀眀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀昀攀琀挀栀开爀漀眀⠀␀爀猀开搀愀琀漀猀⤀⤀ 
					{਀ऀऀऀऀऀऀ␀氀搀攀挀开挀爀攀搀椀琀漀猀开渀攀最愀琀椀瘀漀猀琀洀瀀㴀␀爀漀眀嬀∀洀漀渀琀漀∀崀㬀 
						$lb_valido=true;					਀ऀऀऀऀऀ紀 
				਀ऀऀऀऀ紀ऀऀऀऀ 
			}਀ऀऀऀ椀昀⠀␀氀戀开瘀愀氀椀搀漀⤀⼀⼀  䌀愀氀挀甀氀愀渀搀漀 攀氀 洀漀渀琀漀 搀攀 氀漀猀 䐀攀戀椀琀漀猀 瀀漀猀椀琀椀瘀漀猀 ⠀渀漀 愀渀甀氀愀搀漀猀⤀ 
			{਀ऀऀऀऀ␀氀猀开猀焀氀㴀∀匀䔀䰀䔀䌀吀 䌀伀䄀䰀䔀匀䌀䔀⠀匀唀䴀⠀洀漀渀洀漀瘀挀漀氀⤀Ⰰ　⤀ 䄀匀 洀漀渀琀漀 
						FROM scb_movcol਀ऀऀऀऀऀऀ圀䠀䔀刀䔀 挀漀搀攀洀瀀㴀✀␀氀猀开挀漀搀攀洀瀀✀ 䄀一䐀 挀漀搀戀愀渀㴀✀␀愀猀开挀漀搀戀愀渀✀ 䄀一䐀 挀琀愀戀愀渀㴀✀␀愀猀开挀琀愀戀愀渀✀ 
						AND (codope='DP' OR codope='NC') AND estcol<>'A'";਀ऀऀऀऀ␀爀猀开搀愀琀漀猀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀猀攀氀攀挀琀⠀␀氀猀开猀焀氀⤀㬀 
				if(($rs_datos==false))਀ऀऀऀऀ笀 
					$lb_valido=false;਀ऀऀऀऀऀ␀琀栀椀猀ⴀ㸀椀猀开洀猀最开攀爀爀漀爀㴀␀琀栀椀猀ⴀ㸀椀漀开昀甀渀挀椀漀渀ⴀ㸀甀昀开挀漀渀瘀攀爀琀椀爀洀猀最⠀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀洀攀猀猀愀最攀⤀㬀ऀऀ 
					print "Error en uf_calcular_saldo_colocacion ".$this->is_msg_error;਀ऀऀऀऀ紀 
				else਀ऀऀऀऀ笀 
					if($row=$this->io_sql->fetch_row($rs_datos))਀ऀऀऀऀऀ笀 
						$ldec_debitostmp=$row["monto"];਀ऀऀऀऀऀऀ␀氀戀开瘀愀氀椀搀漀㴀琀爀甀攀㬀ऀऀऀऀऀ 
					}				਀ऀऀऀऀ紀ऀऀऀऀ 
			}਀ऀऀऀ椀昀⠀␀氀戀开瘀愀氀椀搀漀⤀⼀⼀  䌀愀氀挀甀氀愀渀搀漀 攀氀 洀漀渀琀漀 搀攀 氀漀猀 䐀攀戀椀琀漀猀 渀攀最愀琀椀瘀漀猀 ⠀愀渀甀氀愀搀漀猀⤀ 
			{਀ऀऀऀऀ␀氀猀开猀焀氀㴀∀匀䔀䰀䔀䌀吀 䌀伀䄀䰀䔀匀䌀䔀⠀匀唀䴀⠀洀漀渀洀漀瘀挀漀氀⤀Ⰰ　⤀ 䄀匀 洀漀渀琀漀 
						FROM scb_movcol਀ऀऀऀऀऀऀ圀䠀䔀刀䔀 挀漀搀攀洀瀀㴀✀␀氀猀开挀漀搀攀洀瀀✀ 䄀一䐀 挀漀搀戀愀渀㴀✀␀愀猀开挀漀搀戀愀渀✀ 䄀一䐀 挀琀愀戀愀渀㴀✀␀愀猀开挀琀愀戀愀渀✀ 
						AND (codope='DP' OR codope='NC') AND estcol='A'";਀ऀऀऀऀ␀爀猀开搀愀琀漀猀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀猀攀氀攀挀琀⠀␀氀猀开猀焀氀⤀㬀 
				if(($rs_datos==false))਀ऀऀऀऀ笀 
					$lb_valido=false;਀ऀऀऀऀऀ␀琀栀椀猀ⴀ㸀椀猀开洀猀最开攀爀爀漀爀㴀␀琀栀椀猀ⴀ㸀椀漀开昀甀渀挀椀漀渀ⴀ㸀甀昀开挀漀渀瘀攀爀琀椀爀洀猀最⠀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀洀攀猀猀愀最攀⤀㬀ऀऀ 
					print "Error en uf_calcular_saldo_colocacion ".$this->is_msg_error;਀ऀऀऀऀ紀 
				else਀ऀऀऀऀ笀 
					if($row=$this->io_sql->fetch_row($rs_datos))਀ऀऀऀऀऀ笀 
						$ldec_debitos_negativostmp=$row["monto"];਀ऀऀऀऀऀऀ␀氀戀开瘀愀氀椀搀漀㴀琀爀甀攀㬀ऀऀऀऀऀ 
					}				਀ऀऀऀऀ紀ऀऀऀऀ 
			}਀ऀऀऀ椀昀⠀␀氀戀开瘀愀氀椀搀漀⤀ 
			{਀ऀऀऀऀ␀氀搀攀挀开搀攀戀椀琀漀猀  㴀 ␀氀搀攀挀开搀攀戀椀琀漀猀琀洀瀀  ⴀ ␀氀搀攀挀开搀攀戀椀琀漀猀开渀攀最愀琀椀瘀漀猀琀洀瀀㬀 
				$ldec_creditos = $ldec_creditostmp - $ldec_creditos_negativostmp;਀ऀऀऀऀ␀氀搀攀挀开猀愀氀搀漀    㴀 ␀氀搀攀挀开挀爀攀搀椀琀漀猀    ⴀ ␀氀搀攀挀开搀攀戀椀琀漀猀㬀  
				return $ldec_saldo;਀ऀऀऀ紀 
			else਀ऀऀऀ笀 
				return $lb_valido;਀ऀऀऀ紀ऀऀऀ 
		}਀ऀऀ 
		function uf_calcular_saldo_documento($as_codban,$as_ctaban)਀ऀऀ笀 
		    /*------------------------------------------------------------------਀ऀऀ    ऀⴀ 䘀甀渀挀椀漀渀 焀甀攀 挀愀氀挀甀氀愀 攀氀 猀愀氀猀漀 搀攀 氀愀猀 挀漀氀漀挀愀挀椀漀渀攀猀 
				- Retorna el saldo si se ejecuto correctamente, de lo contrario਀ऀऀऀऀ  爀攀琀漀爀渀愀 昀愀氀猀漀⸀ 
				- Elaborado por Ing. Laura Cabré.਀ऀऀऀऀⴀ 䘀攀挀栀愀㨀 ㄀㈀⼀　㄀⼀㈀　　㜀ऀऀऀ 
			//-----------------------------------------------------------------*/਀ऀऀऀ␀氀猀开挀漀搀攀洀瀀㴀␀琀栀椀猀ⴀ㸀搀愀琀嬀∀挀漀搀攀洀瀀∀崀㬀 
			$lb_valido=false;਀ऀऀऀ␀氀猀开猀焀氀㴀∀匀䔀䰀䔀䌀吀 挀漀搀漀瀀攀 䄀匀 漀瀀攀爀愀挀椀漀渀Ⰰ ⠀洀漀渀琀漀ⴀ洀漀渀爀攀琀⤀ 䄀匀 洀漀渀琀漀Ⰰ 攀猀琀洀漀瘀 䄀匀 攀猀琀愀搀漀 
					FROM scb_movbco਀ऀऀऀऀऀ圀䠀䔀刀䔀 挀漀搀攀洀瀀㴀✀␀氀猀开挀漀搀攀洀瀀✀ 䄀一䐀 挀漀搀戀愀渀㴀✀␀愀猀开挀漀搀戀愀渀✀ 䄀一䐀 挀琀愀戀愀渀㴀✀␀愀猀开挀琀愀戀愀渀✀∀㬀 
			$rs_datos=$this->io_sql->select($ls_sql);਀ऀऀऀ椀昀⠀⠀␀爀猀开搀愀琀漀猀㴀㴀昀愀氀猀攀⤀⤀ 
			{਀ऀऀऀऀ␀氀戀开瘀愀氀椀搀漀㴀昀愀氀猀攀㬀 
				$this->is_msg_error=$this->io_funcion->uf_convertirmsg($this->io_sql->message);		਀ऀऀऀऀ瀀爀椀渀琀 ∀䔀爀爀漀爀 攀渀 甀昀开挀愀氀挀甀氀愀爀开猀愀氀搀漀开挀漀氀漀挀愀挀椀漀渀 ∀⸀␀琀栀椀猀ⴀ㸀椀猀开洀猀最开攀爀爀漀爀㬀 
			}਀ऀऀऀ攀氀猀攀 
			{਀ऀऀऀऀ椀昀⠀␀爀漀眀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀昀攀琀挀栀开爀漀眀⠀␀爀猀开搀愀琀漀猀⤀⤀ 
				{਀ऀऀऀऀऀ␀氀愀开搀愀琀愀㴀␀琀栀椀猀ⴀ㸀椀漀开猀焀氀ⴀ㸀漀戀琀攀渀攀爀开搀愀琀漀猀⠀␀爀猀开搀愀琀漀猀⤀㬀 
					$this->ds_data->data=$la_data;਀ऀऀऀऀऀ␀氀椀开琀漀琀愀氀㴀␀琀栀椀猀ⴀ㸀搀猀开搀愀琀愀ⴀ㸀最攀琀刀漀眀䌀漀甀渀琀⠀∀漀瀀攀爀愀挀椀漀渀∀⤀㬀 
					$ldec_debitostmp=0;਀ऀऀऀऀऀ␀氀搀攀挀开挀爀攀搀椀琀漀猀琀洀瀀㴀　㬀 
					$ldec_debitos_negativostmp=0;਀ऀऀऀऀऀ␀氀搀攀挀开挀爀攀搀椀琀漀猀开渀攀最愀琀椀瘀漀猀琀洀瀀㴀　㬀 
					for($li_i=1;$li_i<=$li_total;$li_i++)਀ऀऀऀऀऀ笀 
						$ls_operacion = $this->ds_data->getValue("operacion",$li_i);਀ऀऀऀऀऀऀ␀氀猀开攀猀琀愀搀漀    㴀 ␀琀栀椀猀ⴀ㸀搀猀开搀愀琀愀ⴀ㸀最攀琀嘀愀氀甀攀⠀∀攀猀琀愀搀漀∀Ⰰ␀氀椀开椀⤀㬀 
						if((($ls_operacion=="CH") || ($ls_operacion=="ND") || ($ls_operacion=="RE")) && ($ls_estado<>"A"))਀ऀऀऀऀऀऀ 
						਀ऀऀऀऀऀऀ 
						Sum monto for (operacion$"CH,ND,RE") and (Estado <> "A") to nCreditosTmp਀ऀऀऀऀऀऀ匀甀洀 洀漀渀琀漀 昀漀爀 ⠀漀瀀攀爀愀挀椀漀渀␀∀䌀䠀Ⰰ一䐀Ⰰ刀䔀∀⤀ 愀渀搀 ⠀䔀猀琀愀搀漀 㴀 ∀䄀∀⤀ 琀漀 渀䌀爀攀搀椀琀漀猀吀洀瀀一攀最 
						Sum monto for (operacion$"DP,NC") and (Estado <> "A") to nDebitosTmp਀ऀऀऀऀऀऀ匀甀洀 洀漀渀琀漀 昀漀爀 ⠀漀瀀攀爀愀挀椀漀渀␀∀䐀倀Ⰰ一䌀∀⤀ 愀渀搀 ⠀䔀猀琀愀搀漀 㴀 ∀䄀∀⤀ 琀漀 渀䐀攀戀椀琀漀猀吀洀瀀一攀最 
					਀ऀऀऀऀऀ紀 
										਀ऀऀऀऀ紀ऀऀऀऀ 
			}਀ऀऀ紀 
	}਀㼀㸀�