ifcheck = true;
function CheckAll(form)
{
	for (var i=0;i<form.elements.length-2;i++)
	{
		var e = form.elements[i];
		e.checked = ifcheck;
	}
	ifcheck = ifcheck == true ? false : true;
}

function fetch_object(idname)
{
	if (document.getElementById)
	{
		return document.getElementById(idname);
	}
	else if (document.all)
	{
		return document.all[idname];
	}
	else if (document.layers)
	{
		return document.layers[idname];
	}
	else
	{
		return null;
	}
}