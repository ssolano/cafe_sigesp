<?php
require_once("class_sql.php");  
require_once("class_datastore.php");
require_once("sigesp_include.php");
require_once("class_funciones.php");
require_once("class_mensajes.php");

class class_generar_id_process
{
   var $dts_empresa; 
   var $is_codemp;
   var $io_fecha;
   var $io_function;
   var $io_siginc;
   var $io_connect;
   var $io_sql;
   var $io_msg;
   function class_generar_id_process()
   {
  	  $this->dts_empresa=$_SESSION["la_empresa"];
	  $this->is_codemp=$this->dts_empresa["codemp"];		
	  $this->io_function=new class_funciones() ;
	  $this->io_siginc=new sigesp_include();
	  $this->io_connect=$this->io_siginc->uf_conectar();
	  $this->io_sql=new class_sql($this->io_connect);		
	  $this->io_msg=new class_mensajes();		
	  $this->ls_gestor=$_SESSION["ls_gestor"];
   } // end constructor

    function uf_check_id($as_tabla,$as_columna,&$as_numero)   
	{ ////////////////////////////////////////////////////////////////////////////////////////////////////               
	  //	  Function: uf_sep_check_id
	  //	    Access: public
	  //    Argument: $as_tabla->nombre tabla , $as_columna->nombre columna , $as_numero->numero del documento
	  //              asociado a una SEP o CXP o SOC
	  //     Returns: retorna un booelano que indica si el n�mero est� en uso y retorna una variable por 
	  //              valor con el nuevo n�mero si es necesario
	  // Description: Est� m�todo se encarga de validar que un n�mero del docuemnto no sea utilizado por otra
	  //              instancia, y si lo est� siendo este debe generar uno nuevo
	  ////////////////////////////////////////////////////////////////////////////////////////////////////               
      $lb_change = false; // si cambio el n�mero de documento
      if ( !$this->uf_verificar_id_liberado($as_tabla,$as_columna,$as_numero))
	  {
	     $as_numero = $this->uf_generar_id_process($as_tabla,$as_columna);
		 $this->io_msg->message("Se le Asign� un nuevo n�mero de documento la cual es :".$as_numero);			
		 $lb_change = false;
	  }
	  return  $lb_change;
	} // end function 
	
    function uf_verificar_id_liberado($as_tabla,$as_columna,&$as_numero)   
	{ ////////////////////////////////////////////////////////////////////////////////////////////////////               
	  //    Function: uf_verificar_id_liberado
	  //	  Access: public
	  //    Argument: $as_codemp->codigo empresa  $as_numero->numero de la solicitud
	  //     Returns: retorna un booelano (true=si esta liberado y false=todo lo contrario )
	  // Description: Est� m�todo se encarga de validar que un n�mero de la sep se encuantra en la base de dato
	  ////////////////////////////////////////////////////////////////////////////////////////////////////               
      $lb_existe = true;
	  $ls_sql    = "SELECT ".$as_columna." FROM ".$as_tabla." WHERE codemp='".$this->is_codemp."' AND ".$as_columna."='".$as_numero."'";
	  $rs_data   = $this->io_sql->select($ls_sql);
	  if($rs_data===false)
	  { 
         $this->io_msg->message("Error en consulta uf_verificar_id_liberado ".$this->io_function->uf_convertirmsg($this->io_sql->message));			
		 return false;
	  }
	  else  {  if($row=$this->io_sql->fetch_row($rs_data))  {  $lb_existe = false;  }  }
  	  $this->io_sql->free_result($rs_data);
	  return $lb_existe;
	} // end function 

	function uf_generar_id_process($as_tabla,$as_columna)
	{ ////////////////////////////////////////////////////////////////////////////////////////////////////               
	  //    Function: uf_generar_id_process
	  //	  Access: public
	  //    Argument: $as_tabla->nombre de la tabla , $as_columna->nombre columna
	  //     Returns: retorna el codigo
	  // Description: Est� m�todo global genera un n�mero concecutivo asociada a una tabla y columna espec�fica,
	  //              tambien verifica si esta liberado o no para generar su n�mero posterior y asi concecutivamente
	  //              hasta que encuantre el n�mero liberado.
	  ////////////////////////////////////////////////////////////////////////////////////////////////////  
	  //print(); 
	  $ls_limit='limit 1';            
	  $lb_valido=true;
	  switch ($this->ls_gestor)
	   {
	   		case "INFORMIX":
				$ls_sql = " SELECT LIMIT 1 ".$as_columna." FROM ".$as_tabla. //OJO MYSQL
	            	  " WHERE codemp='".$this->is_codemp."' ORDER BY ".$as_columna." DESC ";
			break;
			
			default: // MYSQLT POSTGRES
				$ls_sql = " SELECT ".$as_columna." FROM ".$as_tabla. //OJO MYSQL
	           		  " WHERE codemp='".$this->is_codemp."' ORDER BY ".$as_columna." DESC ".$ls_limit;
			break;
	  }     
	  $rs_data=$this->io_sql->select($ls_sql);
	  if ($row=$this->io_sql->fetch_row($rs_data))
      { 
		  $ls_id = $row[$as_columna];
		
	      while($lb_valido)
		  {
			 settype($ls_id,'int');
			 $ls_id = $ls_id + 1;
			 settype($ls_id,'string');
			 $ls_id = $this->io_function->uf_cerosizquierda($ls_id,15);
             $lb_valido = (!$this->uf_verificar_id_liberado($as_tabla,$as_columna,$ls_id));
		  }
 	  }
	  else
	  {
		  $ls_id = "1";
		  $ls_id = $this->io_function->uf_cerosizquierda($ls_id,15);
	  }
  	  $this->io_sql->free_result($rs_data);
      return $ls_id;
   } // end function()
   
} // end class
?>