<?php
/***********************************************************************************
 * @Modelo para la apertura del ejercicio contable.
 * @fecha de creación: 15/12/2008.
 * @autor: Ing. Gusmary Balza B.
 * **************************
 * @fecha modificacion
 * @autor
 * @descripcion
 ***********************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/modelo/sss/sigesp_dao_sss_registroeventos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/modelo/sss/sigesp_dao_sss_registrofallas.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/base/librerias/php/general/sigesp_lib_funciones.php');

//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_sigesp_int.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_sigesp_int_int.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_sigesp_int_spg.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_sigesp_int_scg.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_sigesp_int_spi.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_sigesp_int.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_sigesp_int_int.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_sigesp_int_spg.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_sigesp_int_scg.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_sigesp_int_spi.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_mensajes.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_fecha.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/apr/class_folder/class_fecha.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/sigesp_include.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/class_funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['sigesp_sitioweb'].'/shared/class_folder/sigesp_c_seguridad.php');

class AperturaEjercicio extends ADODB_Active_Record
{
	var $_table = 'scg_cuentas';
	public $mensaje;
	public $valido = true;
	public $existe;
	public $criterio;
		
	public $servidor;
	public $usuario;
	public $clave;
	public $basedatos;
	public $gestor;
	public $tipoconexionbd = 'DEFECTO';
	
	public $archivo;
	public $resultapertura;
	
/************************************************************************************
* @Función para seleccionar con que conexion a Base de Datos se va a trabajar
* @parametros:
* @retorno:
* @fecha de creación: 06/11/2008.
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificación:
* @descripción:
* @autor:
***********************************************************************************/
	public function seleccionarConexion(&$conexionbd)
	{
		global $conexionbd;
		
		if ($this->tipoconexionbd != 'DEFECTO')
		{
			$conexionbd = conectarBD($this->servidor, $this->usuario, $this->clave, $this->basedatos, $this->gestor);
		}
	}	
	
/***********************************************************************************
* @Función para actualizar las cuentas contables.
* @parametros:
* @retorno:
* @fecha de creación: 15/12/2008.
* @autor: Ing. Gusmary Balza.
************************************************************************************
* @fecha modificación:
* @descripción:
* @autor:
***********************************************************************************/	
	public function procesarAperturaEjercicio()
	{
		global $conexionbd;
		//$conexionbd->debug = 1;
		$conexionbdorigen = conectarBD($_SESSION['sigesp_servidor'], $_SESSION['sigesp_usuario'], $_SESSION['sigesp_clave'],
									   $_SESSION['sigesp_basedatos'], $_SESSION['sigesp_gestor']);
		
		$this->mensaje = 'Proceso la apertura del ejercicio contable';
		
		$fecdesde = convertirFechaBd($this->periodo);
		$fecdesde = substr($fecdesde,0,10);
		$anno     = substr($this->periodo,0,4);
		$fechasta = '31/12/'.$anno;
		$fechasta = convertirFechaBd($fechasta);		
		$conexionbd->StartTrans();
		try
		{						
			//$this->seleccionarConexion(&$conexionbd);
			
			$consulta = " SELECT curbb.*,scta.status ".
				        " FROM (  SELECT DISTINCT B.sc_cuenta as sc_cuenta,B.denominacion as denominacion,B.saldo_Ant as saldo_ant, ".
		                "                  B.debe as debe,B.haber as haber,B.saldo_act as saldo_act,C.T_DEBE_MES as t_debe_mes, ".
		                "                  C.T_HABER_MES as t_haber_mes,COALESCE(C.T_DEBE_MES,0) as BalDebe, ".
		                "                  COALESCE(C.T_HABER_MES,0) as BalHABER ".
		                " FROM ( SELECT A.sc_cuenta,A.denominacion,saldo_ant,COALESCE(curSACT.T_DEBE_MES,0) as Debe, ".
		                "               COALESCE(curSACT.T_HABER_MES,0) as Haber, ".
		                "               (COALESCE(Saldo_Ant,0)+COALESCE(curSACT.T_DEBE_MES,0) - COALESCE(curSACT.T_HABER_MES,0)) as Saldo_Act ".
		                "        FROM (SELECT CCT.sc_cuenta,CCT.denominacion,CCT.nivel,COALESCE(curSANT.SANT,0) as Saldo_Ant ".
		                "              FROM scg_cuentas CCT ".
		                " LEFT OUTER JOIN ( SELECT CSD.sc_cuenta,SUM(debe_mes-haber_mes) AS SANT ".
		                "                   FROM scg_saldos CSD ".
		                "                   WHERE CSD.codemp='".$this->codemp."' AND  CSD.fecsal < '".$fecdesde."' ".
		                "                   GROUP BY CSD.sc_cuenta ) curSANT  ".
		                " ON  CCT.sc_cuenta=curSANT.sc_cuenta ) A ".
		                " LEFT OUTER JOIN ( SELECT CSD.sc_cuenta, COALESCE(SUM(debe_mes),0) As T_DEBE_MES, ".
						"                          COALESCE(SUM(haber_mes),0) As T_HABER_MES ".
		                "                   FROM scg_saldos CSD ".
		                "                   WHERE CSD.codemp='".$this->codemp."'  AND ".
		                "                         CSD.fecsal between '".$fecdesde."' AND '".$fechasta."' ".
		                "                   GROUP BY CSD.sc_cuenta ) curSACT ON A.sc_cuenta=curSACT.sc_cuenta ".
		                " WHERE (A.nivel<=7)) B, ".
		                " ( SELECT COALESCE(sum(DEBE_MES),0) as T_DEBE_MES, COALESCE(sum(HABER_MES),0) as T_HABER_MES ".
		                "   FROM  scg_cuentas CCT, scg_saldos CSD ".
		                "   WHERE CCT.codemp='".$this->codemp."' AND (CCT.sc_cuenta=CSD.sc_cuenta) AND ".
		                "         CSD.fecsal between '".$fecdesde."' AND '".$fechasta."' AND (CCT.nivel=1) ) C ".
		                "   ORDER BY B.sc_cuenta ) as curbb, scg_cuentas scta ".
		                " WHERE curbb.sc_cuenta=scta.sc_cuenta  AND  scta.status='C' ";
			$resultSCG = $conexionbdorigen->Execute($consulta);
			if ($resultSCG===false)
			{
				escribirArchivo($this->archivo,'* Error al Seleccionar los saldos de la origen '.''.$conexionbd->ErrorMsg());
				$this->valido = false; 
			}
			else
			{	
				$this->arrSaldosContables = array('sccuenta'=>array(),'denominacion'=>array(),'saldoant'=>array(),'debe'=>array(),'haber'=>array(),'saldoact'=>array());
				$i = 0;			
				while (!$resultSCG->EOF) 
				{
					$this->arrSaldosContables['sccuenta'][$i] 	= $resultSCG->fields['sc_cuenta'];
					$this->arrSaldosContables['denominacion'][$i] = $resultSCG->fields['denominacion'];	
					$this->arrSaldosContables['saldoant'][$i] 	= $resultSCG->fields['saldo_ant'];
					$this->arrSaldosContables['debe'][$i] 		= $resultSCG->fields['debe'];
					$this->arrSaldosContables['haber'][$i] 		= $resultSCG->fields['haber'];
					$this->arrSaldosContables['saldoact'][$i] 	= $resultSCG->fields['saldo_act'];
					
					$i++;
					$resultSCG->MoveNext();
				}				
				$this->valido = true;				
			}
			if ($this->valido)
			{				
				$periodo = '';
				$this->seleccionarPeriodo();
				$anno     = substr($this->periodo,0,4);
				$periodo  = '31/12/2008';
				$fecdesde = convertirFechaBd($periodo);
				$autoconta = true;
				if ($this->tipo=='B')
				{
					$fuente = $this->ced_ben;
				}
				if ($this->tipo=='P')
				{
					$fuente = $this->cod_prov;
				}
				if ($this->tipo=='-')
				{
					$fuente = '----------';
				}
				$codban = '---';
				$ctaban = '-------------------------';
				
				$this->objInt = new class_sigesp_int_int();
				
				if ($this->valido)
				{
					//Insertar los Saldos Contables Iniciales
					$this->valido = $this->objInt->uf_int_init($this->codemp,$this->procede,$this->comprobante,$fecdesde,$this->descripcion,$this->tipo,
															   $fuente,$autoconta,$codban,$ctaban,$this->tipo_cmp); 
				}																
				if ($this->valido)
				{					
					$total = count($this->arrSaldosContables['sccuenta']);					
					$j=0;
					while ($j<$total && $this->valido)
					{							
						$sccuenta 	  = $this->arrSaldosContables['sccuenta'][$j];
						$denominacion = $this->arrSaldosContables['denominacion'][$j];
						$saldoant     = $this->arrSaldosContables['saldoant'][$j];
						$debe		  = $this->arrSaldosContables['debe'][$j];
						$haber		  = $this->arrSaldosContables['haber'][$j];
						$saldoact	  = $this->arrSaldosContables['saldoact'][$j];
						if ($saldoact!=0)
						{
							if ($saldoact>0)
							{
								$operacion = 'D';
							}
							if ($saldoact<0)
							{
								$operacion = 'H';
							}
							$monto = abs($saldoact);							
							$this->valido = $this->objInt->uf_scg_insert_datastore($this->codemp,$sccuenta,$operacion,$monto,
																				 $this->comprobante,$this->procede,$this->descripcion);													 																	 
						}					
						$j++;						
					}				
				}				
				if ($this->valido)
				{
					$this->valido = $this->objInt->uf_init_end_transaccion_integracion('');
					
				}				
				$this->objInt->uf_sql_transaction($this->valido);				
				
			}
			if ($this->valido)
			{
				escribirArchivo($this->archivo,'*******************************************************************************************************');
				escribirArchivo($this->archivo,'La Apertura de Contabilidad se Creo con Exito');
				escribirArchivo($this->archivo,'*******************************************************************************************************');		
			}
			else
			{
				escribirArchivo($this->archivo,'*******************************************************************************************************');
				escribirArchivo($this->archivo,''.$this->objInt->is_msg_error);
				escribirArchivo($this->archivo,'*******************************************************************************************************');		
			
			}
		}
		catch (exception $e) 
		{
			$this->valido = false;
			$this->mensaje='Ocurrio un error en la Transferencia. '.$conexionbd->ErrorMsg();
			escribirArchivo($this->archivo,'* Ocurrio un error en la Transferencia. ');
			escribirArchivo($this->archivo,'* Error  '.$conexionbd->ErrorMsg());
			escribirArchivo($this->archivo,'*******************************************************************************************************');
		}
		$conexionbd->CompleteTrans();
		$this->incluirSeguridad('PROCESAR',$this->valido);
					
	}
		
	
	
/***********************************************************************************
* @Función para obtener el periodo de la empresa.
* @parametros:
* @retorno:
* @fecha de creación: 15/12/2008.
* @autor: Ing. Gusmary Balza.
************************************************************************************
* @fecha modificación:
* @descripción:
* @autor:
***********************************************************************************/	
	public function seleccionarPeriodo()
	{
		global $conexionbd;
				
		$this->existe = false;
		$consulta = " SELECT periodo ".
					" FROM sigesp_empresa ".
					" WHERE codemp='$this->codemp'";
		$result = $conexionbd->Execute($consulta);
		if ($result===false)
		{
			$this->mensaje = 'Error al seleccionar el periodo '.$conexionbd->ErrorMsg();
			return false;
		}
		elseif (!$result->EOF)
		{
			$this->periodo = $result->fields['periodo'];
			$this->existe  = true;
		}
	}	
		
		
/***********************************************************************************
* @Función que Incluye el registro de la transacción exitosa
* @parametros: $evento
* @retorno:
* @fecha de creación: 10/10/2008
* @autor: Ing. Yesenia Moreno de Lang
************************************************************************************
* @fecha modificación:
* @descripción:
* @autor:
***********************************************************************************/
	function incluirSeguridad($evento,$tipotransaccion)
	{
		if($tipotransaccion) // Transacción Exitosa
		{
			$objEvento = new RegistroEventos();
		}
		else // Transacción fallida
		{
			$objEvento = new RegistroFallas();
		}
		// Registro del Evento
		$objEvento->codemp = $this->codemp;
		$objEvento->codsis = $this->codsis;
		$objEvento->nomfisico = $this->nomfisico;
		$objEvento->evento = $evento;
		$objEvento->desevetra = $this->mensaje;
		$objEvento->incluir();
		unset($objEvento);
	}
	
}
?>	