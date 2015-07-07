/****************************************************************************
*@archivo javascript para el cat�logo de tipos de personal
*@version: 1.0
*@fecha de creaci�n: 08/08/2008.
*@autor: Ing. Gusmary Balza.
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
******************************************************************************/
var gridCreadaPersonal   = false;
var ventanaCreadaPersonal = false;
var datos                 = null;
var gridPersonal          = null;
var ventanaPersonal       = null;
var iniciargrid                = false;
var parametros            = '';
var rutaPersonal           = '../../controlador/sno/sigesp_ctr_sno_personalsss.php';
var ruta = '../../controlador/sss/sigesp_ctr_sss_usuariospermisos.php';

/******************************************************************************
* @Funci�n gen�rica para el uso del cat�logo de usuarios
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 15/08/2008. 
* @autor: Ing. Gusmary Balza. 
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*******************************************************************************/
	function catalogoPersonal()
	{	
		this.mostrarCatalogoPersonal = mostrarCatalogoPersonal;
	}


/****************************************************************************
* @Funci�n que acualiza el catalgo para buscar por determinado campo
* @parametros: criterio: campo por el que se actualiza
* cadena: campo a actualizar
* @retorno:
* @fecha de creaci�n:
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*****************************************************************************/
	function actualizarDataPersonal(criterio,cadena)
	{
		var myJSONObject ={
			'oper': 'catalogo',
			'cadena': cadena,
			'criterio': criterio,
			'sistema': sistema,
			'vista': vista
		};
		objdata=JSON.stringify(myJSONObject);
		parametros = 'objdata='+objdata; 
		Ext.Ajax.request({
		url : rutaPersonal,
		params : parametros,
		method: 'POST',
		success: function ( resultado, request )
		{ 
			datos = resultado.responseText;
			if (datos!='')
			{
				var DatosNuevo = eval('(' + datos + ')');
				gridPersonal.store.loadData(DatosNuevo);
			}
		}
		});
	}


/****************************************************************************
*Obtener el valor de los caracteres de la caja texto
*@par�metros: obj --> caja de texto.
*@retorna: valor obtenido del objeto.
*@fecha de creaci�n:  21/05/2008
*@Funci�n predeterminada.
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
****************************************************************************/		
	function agregarKeyPress(Obj)
	{
		Ext.form.TextField.superclass.initEvents.call(Obj);
		if(Obj.validationEvent == 'keyup')
		{
			Obj.validationTask = new Ext.util.DelayedTask(Obj.validate, Obj);
			Obj.el.on('keyup', Obj.filterValidation, Obj);
		}
		else if(Obj.validationEvent !== false)
		{
			Obj.el.on(Obj.validationEvent, Obj.validate, Obj, {buffer: Obj.validationDelay});
		}
		if(Obj.selectOnFocus || Obj.emptyText)
		{
			Obj.on('focus', Obj.preFocus, Obj);
			if(Obj.emptyText)
			{
				Obj.on('blur', Obj.postBlur, Obj);
				Obj.applyEmptyText();
			}
		}
		if(Obj.maskRe || (Obj.vtype && Obj.disableKeyFilter !== true && (Obj.maskRe = Ext.form.VTypes[Obj.vtype+'Mask']))){
			Obj.el.on('keypress', Obj.filterKeys, Obj);
		}
		if(Obj.grow)
		{
			Obj.el.on('keyup', Obj.onKeyUp,  Obj, {buffer:50});
			Obj.el.on('click', Obj.autoSize,  Obj);
		}
			Obj.el.on('keyup', Obj.changeCheck, Obj);
	}
	
	
/********************************************************************************
* @Funci�n para validar que el registro seleccionado de
* @la grid del catalogo no exista en la grid del formulario
* @parametros:
* @retorno: true si el registro ya est�.
* @fecha de creaci�n: 19/08/2008
* @autor: 
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
********************************************************************************/
	function validarExistenciaPer()
	{
		PersonalCat    = gridPersonal.getSelectionModel().getSelected().get('codtippersss');
		cantPersonal   = gridPer.store.getCount()-1;
		arrAuxPersonal = gridPer.store.getRange(0,cantPersonal);
		for (i=0; i<=arrAuxPersonal.length-1; i++)
		{
			if (arrAuxPersonal[i].get('codtippersss')==PersonalCat)
			{
				return true;
			}
		}		
	}


/****************************************************************************
* @Funci�n para insertar el registro seleccionado
* @de la grid del catalgo a la grid del formulario.
* @fecha de creaci�n: 19/08/2008
* @autor: Gusmary Balza
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*******************************************************************************/
	function pasarDatosGridPer(datos)
	{
		p = new RecordDefPer
		({
		'codtippersss':'',
		'dentippersss':''
		});
		gridPer.store.insert(0,p);
		p.set('dentippersss',datos.get('dentippersss'));
		p.set('codtippersss',datos.get('codtippersss'));
	}

	
/***********************************************************************************
* @Funci�n que carga los usuarios del personal
* @par�metros: 
* @retorno: 
* @fecha de creaci�n: 24/10/2008
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/	
	function cargarUsuariosPersonal()
	{
		codtippersss = Ext.getCmp('txtcodigo').getValue();
		var objdata ={
				'oper': 'catalogodetalle',
				'codtippersss': codtippersss,
				'codsis': 'SNO',
				'campo': 'codtippersss',
				'tabla': 'sno_tipopersonalsss',
				'sistema': sistema,
				'vista': vista					
		};
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata;
		Ext.Ajax.request({
			url : ruta,
			params : parametros,
			method: 'POST',
			success: function (resultado,request)
			{
				datos = resultado.responseText;
				if (datos!='')
				{
					var myObject = eval('(' + datos + ')');
					if(myObject.raiz[0].valido==true)
					{
						gridUsu.store.loadData(myObject);
					}
					else
					{
						Ext.MessageBox.alert('Error', myObject.raiz[0].mensaje+' Al cargar los usuarios.');
					}
				}
			}
		});
	}	
		
	
/*****************************************************************************
* @Funci�n que busca el listado de personal.
* @par�metros: form: id del formulario, 
* 			fieldset: id del fieldset,
* 			array: arreglo con los campos del formulario
* 			arrValores: arreglo con los campos de la base de datos.
* @fecha de creaci�n: 07/10/2008
* @autor: Gusmary Balza.
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
******************************************************************************/
	function mostrarCatalogoPersonal(arrTxt, arrValores)
	{
		var objdata ={
			'oper': 'catalogo', 
			'codtippersss': '', 
			'dentippersss': '',
			'sistema': sistema,
			'vista': vista
		};
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata;
		Ext.Ajax.request({
		url : rutaPersonal,
		params : parametros,
		method: 'POST',
		success: function ( resultado, request ) 
		{ 
			datos = resultado.responseText;
			if (datos!='')
			{
				var myObject = eval('(' + datos + ')');
				if (myObject.raiz[0].valido==true)
				{			
					var RecordDef = Ext.data.Record.create([
					{name: 'codtippersss'},    
					{name: 'dentippersss'}
					]);
			       
					gridPersonal = new Ext.grid.GridPanel({
						width:500,
						autoScroll:true,
			            border:true,
			            ds: new Ext.data.Store({
						proxy: new Ext.data.MemoryProxy(myObject),
						reader: new Ext.data.JsonReader({
						    root: 'raiz',                
						    id: 'id'   
			                },
						RecordDef
						),
						data: myObject
			            }),
			            cm: new Ext.grid.ColumnModel([
			             new Ext.grid.CheckboxSelectionModel(),
							{header: 'C�digo', width: 30, sortable: true, dataIndex: 'codtippersss'},
			                {header: 'Nombre', width: 50, sortable: true, dataIndex: 'dentippersss'},
						]),
			            sm:new Ext.grid.CheckboxSelectionModel({singleSelect:false}),
			            viewConfig: {
			                            forceFit:true
			                        },
						autoHeight:true,
						stripeRows: true
			        });
					
					if (pantalla=='usuariospersonal')
					{
						gridPersonal.getSelectionModel().singleSelect = true;	 
					}
					else 
					{
						gridPersonal.getSelectionModel().singleSelect = false;	
					}
					
			                  					
					var panelPersonal = new Ext.FormPanel({
						labelWidth: 75, 
						frame:true,
						title: 'B�squeda',
						bodyStyle:'padding:5px 5px 0',
						width: 350,
						height:120,
						defaults: {width: 230},
						defaultType: 'textfield',
						items: [{
							fieldLabel: 'C�digo',
							name: 'codper',
							id:'codper',
							width:50,
							changeCheck: function()
							{
								  var v = this.getValue();
								  actualizarDataPersonal('codtippersss',v);
								  if (String(v) !== String(this.startValue))
								  {
									  this.fireEvent('change', this, v, this.startValue);
								  } 
							},
							initEvents : function()
							{
								agregarKeyPress(this);
							}
						},{
							fieldLabel: 'Nombre',
							name: 'nomper',
							id:'nomper',
							changeCheck: function()
							{
								var v = this.getValue();
								actualizarDataPersonal('dentippersss',v);
								if (String(v) !== String(this.startValue))
								{
									this.fireEvent('change', this, v, this.startValue);
								} 
							},
							initEvents : function()
							{
								agregarKeyPress(this);
							}
						}]
					});
					
						ventanaPersonal = new Ext.Window(
						{
							title: 'Cat&aacute;logo de Personal',
					    	autoScroll:true,
			                width:500,
			                height:400,
			                modal: true,
			                closeAction:'hide',
			                plain: false,
			                items:[panelPersonal,gridPersonal],
			                buttons: [{
			                	text:'Aceptar',  
			                    handler: function()
								{  
									if (pantalla=='usuariospersonal')
									{
										for (i=0;i<arrTxt.length;i++)
										{
											Ext.getCmp(arrTxt[i]).setValue(gridPersonal.getSelectionModel().getSelected().get(arrValores[i]));
										}
										cargarUsuariosPersonal();
									}
									else
									{
										if (validarExistenciaPer()==true)
										{
											Ext.Msg.alert('Mensaje','Registro ya agregado');
										}											
										else
										{
											seleccionados = gridPersonal.getSelectionModel().getSelections();
											for (i=0; i< seleccionados.length; i++)
											{
												pasarDatosGridPer(seleccionados[i]);
											}
										
										}
									}
									panelPersonal.destroy();
		                      		ventanaPersonal.destroy();
								}
								},{
			                     text: 'Salir',
			                     handler: function()
			                     {
			                      	panelPersonal.destroy();
			                      	ventanaPersonal.destroy();
			                     }
							}]
						});
			      	ventanaPersonal.show();
					if(!iniciargrid)
					{
						gridPersonal.render('miGrid');
			            iniciargrid=false;
			        }
			        gridPersonal.getSelectionModel().selectFirstRow();
				}
				else
	        	{
	        		Ext.MessageBox.alert('Error', myObject.raiz[0].mensaje);
					close();
	        	}
			}
			else
			{
				Ext.MessageBox.alert('Mensaje', 'No existen datos para mostrar'); 
			}				        
        },
        failure: function ( resultado, request)
		{ 
			Ext.MessageBox.alert('Error', resultado.responseText); 
        }
	   });
	};
