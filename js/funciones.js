function selec()
{
	f=document.form1;
	f.OPERACION.value="SELECT";
	f.action="sigesp_conexion.php";
	f.submit();
}

function uf_selempresa()
{
	f=document.form1;
	empresa=f.cmbempresa.value;
	db=f.cmbdb.value;
	if(empresa=="")
	{
		if(db=="")
		{
			alert("Debe Seleccionar una base de datos");
		}
		else
		{
			alert("Debe Seleccionar la empresa");
		}
	}
	else
	{
		f.OPERACION.value="SELEMPRESA";
		f.action="sigesp_conexion.php";
		f.submit();
	}
}

function ue_encriptar()
{
	f=document.form1
	password=f.txtpassword.value;
	f.txtpassencript.value=calcMD5(password);
}

function ue_aceptar()
{
	ue_encriptar();
	f=document.form1;
	f.operacion.value="ACEPTAR";
	f.action="sigesp_inicio_sesion.php";
	f.submit();
}
function ue_cancelar()
{
	f=document.form1;
	f.operacion.value="CANCELAR";
	f.action="sigesp_inicio_sesion.php";
	f.submit();
}

function ue_enviar(e)
{
    var whichCode = (window.Event) ? e.which : e.keyCode; 

	if (whichCode == 13) // Enter 
	{
		
		ue_aceptar();
	}
}