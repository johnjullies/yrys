function lightbox(id)
{
	
	var xmlhttp;
	if ( window.XMLHttpRequest){xmlhttp=new XMLHttpRequest(); }
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
		
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("lightbox-content").innerHTML=xmlhttp.responseText;
			$('#lightbox').fadeIn(200);
		}
	
	}
	
	xmlhttp.open("GET","permalink.php?id=" + id ,false);
	xmlhttp.send();
}

function delete_lightbox(id)
{
	
	var xmlhttp;
	if ( window.XMLHttpRequest){xmlhttp=new XMLHttpRequest(); }
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
		
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("lightbox-content").innerHTML=xmlhttp.responseText;
			$('#lightbox').fadeIn(200);
		}
	
	}
	
	xmlhttp.open("GET","delete.php?id=" + id ,false);
	xmlhttp.send();
}

function edit_lightbox(id)
{
	
	var xmlhttp;
	if ( window.XMLHttpRequest){xmlhttp=new XMLHttpRequest(); }
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
		
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("lightbox-content").innerHTML=xmlhttp.responseText;
			$('#lightbox').fadeIn(200);
		}
	
	}
	
	xmlhttp.open("GET","edit_product.php?id=" + id ,false);
	xmlhttp.send();
}

function closeLightbox()
{
	$('#lightbox').fadeOut(200);
}