/************************************************************** 	
* @Archivo javascript que incluye tanto los componentes 
* @como los eventos asociados a la definici�n de grupo.
* @versi�n: 1.0 
* @fecha creaci�n: 28/07/2008
* @autor: Ing. Gusmary Balza
*************************************************************
* @fecha modificacion
* @autor 
* @descripcion: 
**************************************************************/
var actualizar = false;
var panel      = '';
var pantalla   = 'grupo'; //par�metro para el catalogo
ruta = '../../controlador/msg/sigesp_ctr_msg_grupo.php';
Ext.onReady
(
	function()
	{
	    Ext.QuickTips.init();
		// turn on validation errors beside the field globally
		Ext.form.Field.prototype.msgTarget = 'side';
		Xpos = ((screen.width/2)-(550/2)); 
		Ypos = ((screen.height/2)-(500/2));
		//Panel con los componentes del formulario
		panel = new Ext.FormPanel({
        labelWidth: 75,
     	title: 'Definici�n de Grupos',
        bodyStyle:'padding:10px 10px 0',
		style:'position:absolute;top:'+Ypos+'px;left:'+Xpos+'px',
	  	tbar: [],
        defaults: {width: 230},		   
		items:[{
			    xtype:'fieldset',
				title:'Datos del Grupo',
				id:'fsformgrupo',
    			autoHeight:true,
				autoWidth:true,
				cls :'fondo',	
			    items:[{			   
						xtype:'textfield',
						fieldLabel:'C�digo',
						name:'C�digo del grupo',
						id:'txtcodgrupo',
						disabled: true,
						width:60
					},{			   
						xtype:'textfield',
						fieldLabel:'Nombre',
						name:'Nombre del grupo',
						id:'txtnombre',
						width:200
					},{
						xtype:'textarea',
						fieldLabel:'Nota',
						name:'Nota',
						id:'txtnota',
						width:400
				}]
			}]
		});
	panel.render(document.body);
});	//FIN

/************************************
* @Limpiar campos del formulario
* @parametros 
* @retorno
* @fecha creaci�n 
* @autor 
****************************************/		
	function limpiarCampos() 
	{
		 panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').setValue('');
		 panel.getComponent('fsformgrupo').getComponent('txtnombre').setValue('');
		 panel.getComponent('fsformgrupo').getComponent('txtnota').setValue('');
	}

/*********************************************************
* @Funci�n que limpia los campos y asigna un nuevo c�digo
* @parametros
* @retorno
* @fecha de creaci�n: 
* @autor: Gusmary Balza.
***************************
* @fecha modificacion
* @autor 
* @descripcion: 
*********************************************************/
	function irNuevo()
	{
		limpiarCampos();
		panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').enable();
		var objdata ={
			'oper': 'buscarcodigo', 
			'codgrupo': panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').getValue(), 
			'nombre': panel.getComponent('fsformgrupo').getComponent('txtnombre').getValue(),
			'nota':     panel.getComponent('fsformgrupo').getComponent('txtnota').getValue(),
			'sistema': sistema,
			'vista': vista
		};
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata; 
		Ext.Ajax.request({
			url : ruta,
			params : parametros,
			method: 'POST',
			success: function (resultad,request)
			{ 
				datos = resultad.responseText;
				var datajson = datos.split("|");
				cod = datajson[1];
				if (cod!='')
				{
					panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').setValue(cod);						
					actualizar=false;
					panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').disable();
				}
				else
				{
					Ext.MessageBox.alert('Mensaje', 'No se genero c�digo para el registro');					
				}
			},
			failure: function ( result, request)
			{ 
				Ext.MessageBox.alert('Error', result.responseText); 
			} 
		});	 
	}

/*********************************************************
* @Funci�n que guarda o actualiza los datos de un grupo.
* @parametros
* @retorno
* @fecha de creaci�n: 08/07/2008
* @autor: Gusmary Balza
***************************
* @fecha modificacion
* @autor 
* @descripcion
*********************************************************/	
	function irGuardar()
	{
		valido=true;
		if((!tbnuevo)&&(!actualizar))
		{
			valido=false;
			Ext.MessageBox.alert('Error','No tiene permiso para Incluir.');
		}
		if((!tbactualizar)&&(actualizar))
		{
			valido=false;
			Ext.MessageBox.alert('Error','No tiene permiso para Modificar.');
		}
		if ((validarObjetos('txtcodgrupo','5','novacio|numero')!='0' && validarObjetos('txtnombre','60','novacio|alfanumerico')!='0' && validarObjetos('txtnota','5000','alfanumerico')!='0') && (valido))
		{   
			if (!actualizar)
			{
				evento ='incluir';
				mensaje = 'Incluido';
			}
			else
			{	
				evento ='actualizar';			
				mensaje = 'Modificado';
			}			 	
			var objdata ={
				'oper': evento, 
				'codgrupo': panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').getValue(), 
				'nombre': panel.getComponent('fsformgrupo').getComponent('txtnombre').getValue(), 
				'nota': panel.getComponent('fsformgrupo').getComponent('txtnota').getValue(),
				'sistema': sistema,
				'vista': vista
			};
			objdata=JSON.stringify(objdata);
			parametros = 'objdata='+objdata; 
			Ext.Ajax.request({
			url : ruta,
			params : parametros,
			method: 'POST',
			success: function (resultad, request)
			{ 
				datos = resultad.responseText;
				var datajson = eval('(' + datos + ')');
				if (datajson.raiz.valido==true)
				{	
					Ext.MessageBox.alert('Mensaje','Registro '+mensaje + ' con �xito');
					limpiarCampos();  
				}
				else
				{
					Ext.MessageBox.alert('Mensaje', datajson.raiz.mensaje);
				}
			},
			failure: function (result,request) 
			{ 
				Ext.MessageBox.alert('Error', 'El registro no se pudo incluir'); 
			}					
			});
		}
	}

/*********************************************************************
* @Funci�n que llama al catalogo para mostrar los datos de los grupos.
* @parametros
* @retorno
* @fecha de creaci�n: 09/07/2008
* @autor: Ing. Gusmary Balza.
***************************
* @fecha modificacion
* @autor 
* @descripcion
**********************************************************************/
	function irBuscar()
	{
		var arreglotxt     = new Array('txtcodgrupo','txtnombre','txtnota');		
		var arreglovalores = new Array('codgrupo','nombre','nota');			
		objCatGrupo = new catalogoGrupo();
		objCatGrupo.mostrarCatalogo(panel,'fsformgrupo',arreglotxt, arreglovalores);
		actualizar = true;
		panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').disable();
	}

/*********************************************************
* @Funci�n que elimina un grupo seleccionado.
* @parametros
* @retorno
* @fecha de creaci�n: 08/07/2008
* @autor: Gusmary Balza.
***************************
* @fecha modificacion
* @autor 
* @descripcion
*********************************************************/	
	function irEliminar()
	{
		var Result;
		Ext.MessageBox.confirm('Confirmar', '�Desea eliminar este registro?', Result);
		function Result(btn)
		{
			if(btn=='yes')
			{ 
				if (validarObjetos('txtnombre','60','novacio')=='0')
				{					
					Ext.MessageBox.alert('Mensaje','No existen datos para eliminar');
				}
				else
				{
					var objdata ={
						'oper': 'eliminar', 
						'codgrupo': panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').getValue(),
						'nombre': panel.getComponent('fsformgrupo').getComponent('txtnombre').getValue(), 
						'nota': panel.getComponent('fsformgrupo').getComponent('txtnota').getValue(),
						'sistema': sistema,
						'vista': vista
					 };	
					 
					objdata=JSON.stringify(objdata);
					parametros = 'objdata='+objdata;
					mensaje = 'Eliminado';
					Ext.Ajax.request({
					url : ruta,
					params : parametros,
					method: 'POST',
					success: function ( resultad, request )
					{ 
						datos = resultad.responseText;
						var datajson = eval('(' + datos + ')');
						if (datajson.raiz.valido==true)
						{
							Ext.MessageBox.alert('Mensaje','Registro '+mensaje + ' con �xito');
							limpiarCampos();		  
						}
						else
						{
							Ext.MessageBox.alert('Error', datajson.raiz.mensaje);
						}
					},
					failure: function ( result, request)
					{ 
						Ext.MessageBox.alert('Error', result.responseText); 
					} 
					});
				}
			}
		};		
	}
	

/*********************************************************
*Funci�n que imprime un reporte ficha de un grupo. 
seleccionado de acuerdo a un archivo Xml generado.
*@par�metros: 
*@retorna: 
*@fecha de creaci�n:  22/07/2008
*@Autor: Gusmary Balza.	
***************************
* @fecha modificaci�n
* @autor 
* @descripci�n
**************************************************************/	
	function irImprimir()
	{
		var objdata ={
			'oper': 'reporteficha',
			'codgrupo': panel.getComponent('fsformgrupo').getComponent('txtcodgrupo').getValue(),
			'sistema': sistema,
			'vista': vista
		}
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata;
		Ext.Ajax.request({
		url : ruta,
		params : parametros,
		method: 'POST',
		success: function (resultado,request)
		{
			datos = resultado.responseText;
			if (validarObjetos('txtcodgrupo','5','novacio')!='0')
			{
				abrirVentana(datos);
			}			
			else
			{
				Ext.MessageBox.alert('Mensaje', 'No existen datos para imprimir');		
			}
		},
		failure: function ( result, request) 
		{ 
			Ext.MessageBox.alert('Error', result.responseText); 
		} 
		});				
	}

	
