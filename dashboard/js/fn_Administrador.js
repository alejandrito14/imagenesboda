// JavaScript Document
/*funcion para  checar que selecciones almenos un submenu al guardar los perfiles*/
function Validar_Check()
{
	
	var numTotal= document.getElementById('cantidad_menu').value;
	//alert(numTotal);
	var i=0;
	var si=0;
	for(i=0;i<numTotal;i++)
	{
		//alert('sub_menu'+(i+1));
		if(document.getElementById('menu'+(i+1)).checked==true)
		{
			si=1;
			i=numTotal;
			break;
		}
	}
	
	if(si==1)
	{
		return 1;
	}
	else
	{
		alert("Debe seleccionar al menos un menu");
		return 0;
	}
}


