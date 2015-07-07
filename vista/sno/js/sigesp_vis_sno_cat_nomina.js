/**************************************************************************
*@archivo javascript para el cat�logo de nomina
*@version: 1.0
*@fecha de creaci�n: 09/08/2008.
*@autor: Ing. Gusmary Balza.
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
******************************************************************************/
var datos              = null;
var gridNomina         = null;
var ventanaNomina      = null;
var iniciargrid        = false;
var parametros         = '';
var rutaNomina         = '../../controlador/sno/sigesp_ctr_sno_nomina.php';
var rutaPermisos = '../../controlador/sss/sigesp_ctr_sss_usuariospermisos.php';


/******************************************************************************
* @Funci�n gen�rica para el uso del cat�logo de nomina
* @parametros: 
* @retorno: 
* @fecha de creaci�n: 15/08/2008. 
* @autor: Ing. Gusmary Balza. 
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*******************************************************************************/
	function catalogoNomina()
	{	
		this.mostrarCatalogoNomina = mostrarCatalogoNomina;
	}


/*************************************************************************
* @Funci�n que acualiza el catalgo para buscar por determinado campo
* @parametros: criterio: campo por el que se actualiza
* 				cadena: campo a actualizar
* @retorno:
* @fecha de creaci�n:
**************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
**************************************************************************/
	function actualizarDataNomina(criterio,cadena)
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
		url : rutaNomina,
		params : parametros,
		method: 'POST',
		success: function ( resultado, request )
		{ 
			datos = resultado.responseText;
			if (datos!='')
			{
				var DatosNuevo = eval('(' + datos + ')');
				gridNomina.store.loadData(DatosNuevo);
			}
		}
		});
		//gridNomina.store.filter(criterio,cadena);
	}
	
	
/***********************************************************************
*Obtener el valor de los caracteres de la caja texto
*@par�metros: obj --> caja de texto.
*@retorna: valor obtenido del objeto.
*@fecha de creaci�n:  21/05/2008
*@Funci�n predeterminada.
**************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
************************************************************************/		
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
		
	
/*****************************************************************************
* @Funci�n para validar que el registro seleccionado de
* @la grid del catalogo no exista en la grid del formulario
* @parametros:
* @retorno: true si el registro ya est�.
* @fecha de creaci�n: 19/08/2008
* @autor: Gusmary Balza
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
*****************************************************************************/
	function validarExistenciaNom()
	{
		NominaCat    = gridNomina.getSelectionModel().getSelected().get('codnom');
		cantNomina   = gridNom.store.getCount()-1;
		arrAuxNomina = gridNom.store.getRange(0,cantNomina);
		for (i=0; i<=arrAuxNomina.length-1; i++)
		{
			if (arrAuxNomina[i].get('codnom')==NominaCat)
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
*****************************************************************************/
	function pasarDatosGridNom(datos)
	{
		p = new RecordDefNom
		({
		'codnom':'',
		'desnom':''
		});
		gridNom.store.insert(0,p);
		p.set('desnom',datos.get('desnom'));
		p.set('codnom',datos.get('codnom'));
	}


/***********************************************************************************
* @Funci�n que carga los usuarios de la n�mina
* @par�metros: 
* @retorno: 
* @fecha de creaci�n: 29/10/2008
* @autor: Ing. Gusmary Balza. 
************************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
***********************************************************************************/	
	function cargarUsuariosNomina()
	{
		codtippersss = Ext.getCmp('txtcodnom').getValue();
		var objdata ={
				'oper': 'catalogodetalle',
				'codtippersss': codtippersss,
				'codsis': 'SNO',
				'campo': 'codnom',
				'tabla': 'sno_nomina',
				'sistema': sistema,
				'vista': vista					
		};
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata;
		Ext.Ajax.request({
			url : rutaPermisos,
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
* @par�metros: 	form: id del formulario, 
* 				fieldset: id del fieldset,
* 				array: arreglo con los campos del formulario
* 				arrValores: arreglo con los campos de la base de datos.
* @fecha de creaci�n: 07/10/2008
* @autor: Gusmary Balza.
*****************************************************************************
* @fecha modificaci�n:
* @descripci�n:
* @autor:
******************************************************************************/
	function mostrarCatalogoNomina(arrTxt, arrValores)
	{
		var objdata ={
			'oper': 'catalogo', 
			'sistema': sistema,
			'vista': vista
		};
		objdata=JSON.stringify(objdata);
		parametros = 'objdata='+objdata;
		Ext.Ajax.request({
		url : rutaNomina,
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
					{name: 'codnom'},     
					{name: 'desnom'}
					]);
			      
			      	gridNomina = new Ext.grid.GridPanel({
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
							{header: 'C�digo', width: 30, sortable: true,   dataIndex: 'codnom'},
			                {header: 'Nombre', width: 50, sortable: true, dataIndex: 'desnom'},
						]),
						 sm:new Ext.grid.CheckboxSelectionModel({singleSelect:false}),
			            viewConfig: {
			                            forceFit:true
			                        },
						autoHeight:true,
						stripeRows: true
			                   });
					
					if (pantalla=='usuariosnomina')
					{
						gridNomina.getSelectionModel().singleSelect = true;	 
					}
					else 
					{
						gridNomina.getSelectionModel().singleSelect = false;	
					}
					
			                  
					var panelNomina = new Ext.FormPanel({
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
							name: 'codnom',
							id:'codnom',
							width:50,
							changeCheck: function()
							{
								  var v = this.getValue();
								  actualizarDataNomina('codnom',v);
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
							name: 'nomnom',
							id:'nomnom',
							changeCheck: function()
							{
								  var v = this.getValue();
								  actualizarDataNomina('desnom',v);
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
						ventanaNomina = new Ext.Window(
						{
							title: 'Cat&aacute;logo de N�minas',
					    	autoScroll:true,
			                width:500,
			                height:400,
			                modal: true,
			                closeAction:'hide',
			                plain: false,
			                items:[panelNomina,gridNomina],
			                buttons: [{
			                	text:'Aceptar',  
			                    handler: function()
								{                     	
									if (pantalla=='usuariosnomina')
									{
										for (i=0;i<arrTxt.length;i++)
										{											
											Ext.getCmp(arrTxt[i]).setValue(gridNomina.getSelectionModel().getSelected().get(arrValores[i]));
										}										
										cargarUsuariosNomina();
									}
									else
									{
										if (validarExistenciaNom()==true)
										{
											Ext.Msg.alert('Mensaje','Registro ya agregado');
										}											
										else
										{
											seleccionados = gridNomina.getSelectionModel().getSelections();
											for (i=0; i<seleccionados.length; i++)
											{
												pasarDatosGridNom(seleccionados[i]);
											}
										}
									}
									panelNomina.destroy();
			                      	ventanaNomina.destroy();									
								}
								},{
			                     text: 'Salir',
			                     handler: function()
			                     {
			                      	panelNomina.destroy();
			                      	ventanaNomina.destroy();
			                     }
							}]
						});
			        
					ventanaNomina.show();
					if(!iniciargrid)
					{
						gridNomina.render('miGrid');
			            iniciargrid=false;
			        }
			        gridNomina.getSelectionModel().selectFirstRow();
		        }
			    else
			    {
					Ext.MessageBox.alert('Error', myObject.raiz[0].mensaje);
					close();
			    }
			}
			else
			{
				Ext.MessageBox.alert('Mensaje', 'No hay datos para mostrar');
			}		    
        },
        failure: function ( resultado, request)
		{ 
			Ext.MessageBox.alert('Error', resultado.responseText); 
        }
	   });
	};
