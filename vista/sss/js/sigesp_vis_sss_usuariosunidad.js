/***********************************************************************************
* @Archivo javascript que incluye tanto los componentes como los eventos asociados 
* al proceso de asignar usuarios a una unidad ejecutora. 
* @fecha de creaci�n: 29/10/2008
* @autor: Ing. Gusmary Balza
*************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
var cambiar = false;
var panel      = '';
var pantalla   = 'usuariosunidad';
var ruta = '../../controlador/sss/sigesp_ctr_sss_usuariospermisos.php';
var RecordDefUsu = '';
var gridUsu   = '';
var dsusuario = '';
var arrEliminar = new Array();
var usuarioElim = '';
var toteliminar = 0;
var datosNuevo={'raiz':[{'codusu':'','nomusu':'','apeusu':''}]};

Ext.onReady
(
	function()
	{
	    Ext.QuickTips.init();
		Ext.form.Field.prototype.msgTarget = 'side';
		var agregar = new Ext.Action(
		{
			text: 'Agregar',
			handler: irAgregar,
			iconCls: 'bmenuagregar',
        	tooltip: 'Agregar usuario a una unidad ejecutora'
		});
		
		var quitar = new Ext.Action(
		{
			text: 'Quitar',
			handler: irQuitar,
			iconCls: 'bmenuquitar',
        	tooltip: 'Quitar usuario de una unidad ejecutora'
		});
		
		var datosSistemas={'raiz':[{'codsis':'SEP','nomsis':'Solicitud de Ejecuci�n Presupuestaria'},
								   {'codsis':'SOC','nomsis':'Ordenes de Compra'},{'codsis':'CXP','nomsis':'Cuentas por Pagar'}]};
		
		record = Ext.data.Record.create([
				{name: 'codsis'},     
				{name: 'nomsis'}
		]);					
		dssistema =  new Ext.data.Store({
				proxy: new Ext.data.MemoryProxy(datosSistemas),
				reader: new Ext.data.JsonReader(
				{
					root: 'raiz',               
					id: 'id'   
				},
				record
				),
				data: datosSistemas			
			 });
			 
		
		Xpos = ((screen.width/2)-(550/2)); 
		Ypos = ((screen.height/2)-(550/2));
		//Panel con los componentes del formulario
		panel = new Ext.FormPanel({
        labelWidth: 75,
     	title: 'Proceso de Asignar Usuarios a Unidad Ejecutora',
        bodyStyle:'padding:5px 5px 5px',
		style:'position:absolute;top:'+Ypos+'px;left:'+Xpos+'px',
	  	tbar: [],
        defaults: {width: 230},		   
		items:[{
			   	xtype:'fieldset',
				title:'Datos del Sistema',
				id:'fsSistema',
    			autoHeight:true,
				autoWidth:true,
				cls :'fondo',	
			    items:[{			   
					xtype:'combo',
					fieldLabel:'Sistema',
					name:'sistema',
					id:'cmbsistema',
					emptyText:'Seleccione',
					displayField:'codsis',
					valueField:'codsis',
					typeAhead: true,
					mode: 'local',
					triggerAction: 'all',
					store: dssistema,
					width:100	
				}]
			   },{
					xtype:'fieldset',
					title:'Datos de la Unidad Ejecutora',
					id:'fsformunidad',
					autoHeight:true,
					autoWidth:true,
					cls :'fondo',	
					items:[{			   
							xtype:'textfield',
							fieldLabel:'C�digo',
							name:'C�digo de la Unidad Ejecutora',
							id:'txtcoduniadm',
							disabled: true,
							width:80
						},{
							xtype:'textfield',
							fieldLabel:'Denominaci�n',
							name:'Denominaci�n de la Unidad Ejecutora',
							id:'txtdenuniadm',
							disabled: true,
							width:400					
					}]
				},{
					xtype:'panel',
					width:500,
					title:'Usuarios para la Unidad Ejecutora',
					tbar: [agregar,quitar],
					contentEl:'grid-usuariosunidad'
			}]
		});
		panel.render(document.body);
	
		//llamada a la funci�n
		obtenerGridUsuario();
	}
);	//FIN

		
/***********************************************************************************
* @Funci�n para agregar un registro en la grid y llamar al cat�logo de usuarios.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/	
	function irAgregar()
	{
		ParamGridTarget = gridUsu;
		var arreglotxt     = new Array('','');		
		var arreglovalores = new Array('codusu','cedusu','nomusu','apeusu','telusu','email','ultingusu','actusu','admusu','nota');
		ObjUsuario      = new catalogoUsuario();
		ObjUsuario.mostrarCatalogo('','',arreglotxt, arreglovalores);
	}			


/***********************************************************************************
* @Funci�n para crear la grid y pasarle los datos del usuario.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function obtenerGridUsuario()
	{	
		RecordDefUsu = Ext.data.Record.create
		([
			{name: 'codusu'}, 
			{name: 'nomusu'},
			{name: 'apeusu'}
		]);
		
		var DatosNuevo = {'raiz':[{'codusu':'','nomusu':'','apeusu':''}]};	
		dsusuario =  new Ext.data.Store({
		proxy: new Ext.data.MemoryProxy(DatosNuevo),
		reader: new Ext.data.JsonReader({
			root: 'raiz',               
			id: 'id'   
			},
				  RecordDefUsu
			),
			data: DatosNuevo
			});
		
		gridUsu = new Ext.grid.GridPanel({
				width:500,
				autoScroll:true,
				border:true,
				ds: dsusuario,
				cm: new Ext.grid.ColumnModel([
					{header: 'C�digo', width: 100, sortable: true,   dataIndex: 'codusu'},
					{header: 'Nombre', width: 200, sortable: true, dataIndex: 'nomusu'},
					{header: 'Apellido', width: 200, sortable: true, dataIndex: 'apeusu'}
				]),
				viewConfig: {
								forceFit:true
							},
				autoHeight:true,
				stripeRows: true
		});
		gridUsu.render('grid-usuariosunidad');
	}
	
		
/***********************************************************************************
* @Funci�n para confirmar eliminar un registro de la grid de usuarios.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function irQuitar()
	{
		var claveseleccionada = gridUsu.selModel.selections.keys;
		if(claveseleccionada.length > 0)
		{
			Ext.Msg.confirm('Alerta!','Realmente desea eliminar el registro?', borrarRegistro);
		} 
		else 
		{
			Ext.Msg.alert('Alerta!','Seleccione un registro para eliminar');
		}
	}
	
	
/***********************************************************************************
* @Funci�n para eliminar un registro de la grid de usuarios.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 15/08/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/	
	function borrarRegistro(btn) 
	{
		if (btn=='yes') 
		{
			var filaseleccionada = gridUsu.getSelectionModel().getSelected();
			if (filaseleccionada)
			{
				usuarioElim    = gridUsu.getSelectionModel().getSelected().get('codusu');
				arrEliminar[toteliminar] = usuarioElim;
				toteliminar++;
				gridUsu.store.remove(filaseleccionada);
				Ext.Msg.alert('Exito','Registro eliminado');				
			}
		} 
	}
	
	
/***********************************************************************************
* @Limpiar campos del formulario
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/		
	function limpiarCampos() 
	{		 
		Ext.getCmp('txtcoduniadm').setValue('');
		Ext.getCmp('txtdenuniadm').setValue('');	
		Ext.getCmp('cmbsistema').setValue('Seleccione');			
	}


/***********************************************************************************
* @Funci�n que limpia los campos y asigna un nuevo c�digo
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function irCancelar()
	{
		limpiarCampos();
		gridUsu.store.removeAll();
		gridUsu.store.loadData(datosNuevo);
		gridUsu.store.commitChanges();
		arrEliminar = new Array();
		toteliminar = 0;
		cambiar = false;
	}


/***********************************************************************************
* @Funci�n que guarda o actualiza los datos del proceso de asignaci�n.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function irGuardar()
	{
		valido=true;
		if((!tbactualizar)&&(cambiar))
		{
			valido=false;
			Ext.MessageBox.alert('Error','No tiene permiso para Modificar.');
		}
		if (Ext.getCmp('txtcoduniadm').getValue()=='')
		{
			Ext.Msg.alert('Mensaje','Debe seleccionar una Unidad');
		}
		else if (validarObjetos('cmbsistema','3','novacio')!='0')
		/*else if (Ext.getCmp('cmbsistema').getValue()=='')
		
		{
			Ext.Msg.alert('Mensaje','Debe seleccionar un Sistema');
		}
		else*/
		{
			obtenerMensaje('procesar','','Guardando Datos');
			
			codsis = Ext.getCmp('cmbsistema').getValue();
			var cadenaJson = "{'oper': 'actualizar','codsis':codsis,'seleccionado':'unidad','sistema': sistema,'vista': vista,'codtippersss': '"+Ext.getCmp('txtcoduniadm').getValue()+"','dentippersss': '"+Ext.getCmp('txtdenuniadm').getValue()+"'";				
			arrAdmin = gridUsu.store.getModifiedRecords();
			cadenaJson=cadenaJson+ ",datosAdmin:[";
			total = arrAdmin.length;
			if (total>0)
			{	
				for (i=0; i < total; i++)
				{
					if (i==0)
					{
						cadenaJson = cadenaJson +"{'codusu':'"+ arrAdmin[i].get('codusu')+ "'}";
					}
					else
					{
						cadenaJson = cadenaJson +",{'codusu':'"+ arrAdmin[i].get('codusu')+ "'}";
					}
				}			
			}
			cadenaJson = cadenaJson + ']';
			cadenaJson=cadenaJson+ ',datosEliminar:[';
			total = arrEliminar.length;
			if (total>0)
			{
				for (i=0; i < total; i++)
				{
					if (i==0)
					{
						cadenaJson = cadenaJson +"{'codusu':'"+ arrEliminar[i]+ "'}";
					}
					else
					{
						cadenaJson = cadenaJson +",{'codusu':'"+ arrEliminar[i]+ "'}";
					}
				}			
			}
			cadenaJson = cadenaJson + ']}';
			objdata= eval('(' + cadenaJson + ')');	
			objdata=JSON.stringify(objdata);
			parametros = 'objdata='+objdata; 
			Ext.Ajax.request({
			url : ruta,
			params : parametros,
			method: 'POST',
			success: function (resultado, request)
			{ 
				datos = resultado.responseText;
				//alert(datos);
				Ext.Msg.hide();
				var datajson = eval('(' + datos + ')');
				if (datajson.raiz.valido==true)
				{	
					Ext.MessageBox.alert('Mensaje', datajson.raiz.mensaje);
					irCancelar();  
				}
				else
				{
					Ext.MessageBox.alert('Error', datajson.raiz.mensaje);
				}
			},
			failure: function (result,request) 
			{ 
				Ext.Msg.hide();
				Ext.MessageBox.alert('Error', 'Error al procesar la Informaci�n'); 
			}					
			});
		}	
	}


/***********************************************************************************
*  @Funci�n que llama al catalogo para mostrar los datos de la unidad ejecutora.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 29/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function irBuscar()
	{
		var arreglotxt     = new Array('txtcoduniadm','txtdenuniadm');		
		var arreglovalores = new Array('coduniadm','denuniadm');			
		objCatUnidad = new catalogoUnidad();
		objCatUnidad.mostrarCatalogoUnidad(arreglotxt, arreglovalores);
	}
	
	
/***********************************************************************************
* @Funci�n que elimina un usuario de una unidad ejecutora seleccionada.
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 29/10/2008. 
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/
	function irEliminar()
	{
		var Result;
		Ext.MessageBox.confirm('Confirmar', '�Desea eliminar todos los Usuarios?', Result);
		function Result(btn)
		{
			if(btn=='yes')
			{ 
				if (validarObjetos('txtcoduniadm','60','novacio')=='0')
				{					
					Ext.MessageBox.alert('Mensaje','No existen datos para eliminar');
				}
				else
				{
					obtenerMensaje('procesar','','Eliminando Datos');
					
					var objdata ={
						'oper': 'eliminar', 
						'codsis':Ext.getCmp('cmbsistema').getValue(),
						'seleccionado':'unidad',
						'sistema': sistema,
						'vista': vista,
						'codtippersss': Ext.getCmp('txtcoduniadm').getValue()						
					};	
					objdata=JSON.stringify(objdata);
					parametros = 'objdata='+objdata;
					Ext.Ajax.request({
					url : ruta,
					params : parametros,
					method: 'POST',
					success: function ( resultado, request )
					{ 
						datos = resultado.responseText;
						Ext.Msg.hide();
						var datajson = eval('(' + datos + ')');
						if (datajson.raiz.valido==true)
						{
							Ext.MessageBox.alert('Mensaje',datajson.raiz.mensaje);
							irCancelar();	  
						}
						else
						{
							Ext.MessageBox.alert('Error', datajson.raiz.mensaje);
						}
					},
					failure: function ( result, request)
					{ 
						Ext.Msg.hide();
						Ext.MessageBox.alert('Error', 'Error al procesar la informaci�n'); 
					} 
					});
				}
			}
		};		
	}	
	
