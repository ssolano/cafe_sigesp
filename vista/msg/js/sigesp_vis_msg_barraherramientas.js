/** 	
*	
* @Menu para el M�dulo de Configuaci�n y Definiciones
* @versi�n: 1.0      
* @modificado: 19/05/2008
* @autor: Ing. Yesenia de Lang 
*
*/
var tbguardar = false;
Ext.onReady
(
	function()
	{
		rutaarchivo ='../../controlador/msg/sigesp_ctr_msg_menu.php';
    	Ext.QuickTips.init();
		// Tool Bar que va a obtener las Opciones de Menu
		var objbarraherramienta ={
			'operacion': 'barraherramienta', 
			'codsistema': sistema,
			'nomfisico': vista
		};
		objbarraherramienta = JSON.stringify(objbarraherramienta);
		parametros = 'objdata='+objbarraherramienta; 
		Ext.Ajax.request({
		url : rutaarchivo,
		params : parametros,
		method: 'POST',
		success: function (resultad, request)
		{ 
			obj   = eval('('+resultad.responseText+')');
			total = obj.raiz.length;
			herramienta=0;
			// Generar el menu de manera dinamica
			for (menu=0; menu<total; menu++) 
			{
				//////////////////////////////////////
				if (obj.raiz[menu].cancelar==1)
				{
					// Acci�n de cancelar
					var cancelar = new Ext.Action(
					{
						text: 'Cancelar',
						handler: irCancelar,
						iconCls: 'bmenucancelar',
						tooltip: 'Limpiar campos'
					});
					panel.getTopToolbar().add(cancelar);
				}
				////////////////////////////////////
				if (obj.raiz[menu].incluir==1)
				{
					// Acci�n de Nuevo
					var nuevo = new Ext.Action(
					{
						text: 'Nuevo',
						handler: irNuevo,
						iconCls: 'bmenunuevo',
						tooltip: 'Crear un nuevo registro'
					});
					tbnuevo = true;
					panel.getTopToolbar().add(nuevo);
				}
				if (obj.raiz[menu].actualizar==1)
				{
					// Acci�n de Actualizar
					tbactualizar = true;
				}
				if (((tbnuevo==true)|| (tbactualizar==true)) && (tbguardar==false))
				{
					// Acci�n de Guardar
					var guardar = new Ext.Action(
					{
						text: 'Guardar',
						handler: irGuardar,
						iconCls: 'bmenuguardar',
						tooltip: 'Guardar � Actualizar un Registro'
					});
					tbguardar = true;
					panel.getTopToolbar().add(guardar);
				}
				if (obj.raiz[menu].leer==1)
				{
					// Acci�n de Leer
					var buscar = new Ext.Action(
					{
						text: 'Buscar',
						handler: irBuscar,
						iconCls: 'bmenubuscar',
						tooltip: 'Buscar un registro'
					});
					panel.getTopToolbar().add(buscar);
				}
				if (obj.raiz[menu].eliminar==1)
				{
					// Acci�n de Eliminar
					var eliminar = new Ext.Action(
					{
						text: 'Eliminar',
						handler: irEliminar,
						iconCls: 'bmenueliminar',
						tooltip: 'Eliminar un Registro'
					});
					panel.getTopToolbar().add(eliminar);
				}
				if (obj.raiz[menu].anular==1)
				{
					// Acci�n de Anular
					var anular = new Ext.Action(
					{
						text: 'Anular',
						handler: irAnular,
						iconCls: 'bmenuanular',
						tooltip: 'Anular un Registro'
					});
					panel.getTopToolbar().add(anular);
				}
				if (obj.raiz[menu].ejecutar==1)
				{
					// Acci�n de Procesar
					var procesar = new Ext.Action(
					{
						text: 'Procesar',
						handler: irProcesar,
						iconCls: 'bmenuprocesar',
						tooltip: 'Procesar'
					});
					panel.getTopToolbar().add(procesar);
				}
				if (obj.raiz[menu].administrativo==1)
				{
					// Acci�n de Administrador
					tbadministrativo = true;
				}
				if (obj.raiz[menu].imprimir==1)
				{
					// Acci�n de Imprimir
					var imprimir = new Ext.Action(
					{
						text: 'Imprimir',
						handler: irImprimir,
						iconCls: 'bmenuimprimir',
						tooltip: 'Imprimir un Registro'
					});
					panel.getTopToolbar().add(imprimir);
				}
				if (obj.raiz[menu].ayuda==1)
				{
					// Acci�n de Ayuda
					var ayuda = new Ext.Action(
					{
						text: 'Ayuda',
						handler: irAyuda,
						iconCls: 'bmenuayuda',
						tooltip: 'Ayuda sobre la funcionalidad'
					});
					panel.getTopToolbar().add(ayuda);
				}
			}
		},
		failure: function (result,request) 
		{ 
			Ext.MessageBox.alert('Error', request); 
		}
		});
		
		
/*********************************************
* @Funci�n para mostrar el archivo de ayuda.
* @Disponible para todas las funcionalidades.
* @parametros: pagina
* @retorno: pagina
* @fecha de creaci�n: 02/09/2008
* @autor: Ing. Yesenia Moreno.
**********************************************/
		function irAyuda(pagina)
		{
			pagina = vista.replace("sigesp_vis_","sigesp_ayu_");
			pagina = 'ayuda/'+pagina;
			abrirVentana(pagina);
		}
	}
);

