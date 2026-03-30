function openFic() {
	var x = document.getElementById("divficha").style.visibility; //marginRight;
	//if (x != "1em") {
	if (x != "visible") {
   	document.getElementById("divficha").style.visibility = "visible"; //marginRight = "1em";
      document.getElementById("site-overlay1").style.display = "inline";   
	} else {
    	document.getElementById("divficha").style.visibility = "hidden"; //marginRight = "-500px";
   	document.getElementById("site-overlay1").style.display = "none"; 
   }	
}

function openNav() {
	var x = document.getElementById("lateral").style.marginLeft;
	/*var ancho = document.getElementById("lateral").offsetWidth;*/
	if (x != "0px") {
  		/*document.getElementById("container").style.marginLeft = ancho + "px";*/
   	document.getElementById("lateral").style.marginLeft = "0px";
      document.getElementById("site-overlay").style.display = "inline";   
	} else {
    	document.getElementById("lateral").style.marginLeft = "-50em";
   	document.getElementById("site-overlay").style.display = "none"; 
  		/*document.getElementById("container").style.marginLeft = "0px";*/
   }	
}

function segu() {
	return confirm("CONFIRMAR BORRADO")
}

function vaciar(form1) {

	form1.asigna0.value = ""
	form1.claves0.value = ""
	form1.titulo0.value = ""
	form1.pagina0.value = ""
	form1.orand10.value = "and"
	form1.orand20.value = "and"
	form1.orand40.value = "and"
	form1.d1.value = ""
	form1.d2.value = ""
	form1.asigna0.focus()
	
}
function ventana(URL) {
window.open(URL, "", "scrollbars=1,status=0,toolbar=0,directories=0,menubar=0,location=0,resizable=1,width=800,height=650,left = 100,top = 50");
}
function hsm(URL) {
window.open(URL, "hsm", "toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=250,height=520,left = 500,top = 0");
}
function popUp(URL) {
window.open(URL,"","toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=700,left = 300,top = 50");
}
function popUp3(URL) {
window.open(URL,"","toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=250,left = 50,top = 150");
}
function ventana1(URL) {
window.open(URL,"","toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=850,height=400,left = 100,top = 10");
}
function saludo(URL) {
window.open(URL,"","toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=500,left = 300,top = 50");
}
function vmess(URL) {
window.open(URL, "", "scrollbars=1,status=0,toolbar=0,directories=0,menubar=0,location=0,resizable=1,width=450,height=530");
}

////////////////////////////////////////////////////

function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else 
countfield.value = maxlimit - field.value.length;
}

function setPointer(theRow, thePointerColor)
{
    if (typeof(theRow.style) == 'undefined' || typeof(theRow.cells) == 'undefined') {
        return false;
    }

    var row_cells_cnt = theRow.cells.length;
    for (var c = 0; c < row_cells_cnt; c++) {
        theRow.cells[c].bgColor = thePointerColor;
    }

    return true;
}

////////////////////////////////////////////////////

function foco(elem) {
	document.getElementById(elem).focus();
}

function amplred(div)
{
	if (document.getElementById(div).style.display == "none")
	{
		document.getElementById(div).style.display="";
	} else {
		document.getElementById(div).style.display="none";
	}
}

function hide(div)
{
document.getElementById(div).style.display = "none";
}

function show(div)
{
document.getElementById(div).style.display = "";
} 
function r(form1,sm){
	document.form1.message.value=document.form1.message.value+" "+sm;
	document.form1.message.focus();
}

////////////////////////////////////////////////////

function ajaxFunction() {
  var xmlHttp;
  
  try {
   
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
  } catch (e) {
    
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
    } catch (e) {
      
	  try {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
      } catch (e) {
        alert("Tu navegador no soporta AJAX!");
        return false;
      }}}
}

function Enviar(_pagina,capa) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
		if (ajax.readyState==1){
			document.getElementById(capa).innerHTML = " Aguarde por favor...";
			     }
		if (ajax.readyState == 4) {
		   
                document.getElementById(capa).innerHTML=ajax.responseText; 
		     }}
			 
	ajax.send(null);
} 

// Esta función cargará las paginas
function llamarasincrono (url, id_contenedor)
{
    var pagina_requerida = false;
    if (window.XMLHttpRequest)
    {
        // Si es Mozilla, Safari etc
        pagina_requerida = new XMLHttpRequest ();
    } else if (window.ActiveXObject)
    {
        // pero si es IE
        try 
        {
            pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            // en caso que sea una versión antigua
            try
            {
                pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
        }
    } 
    else
    return false;
    pagina_requerida.onreadystatechange = function ()
    {
        // función de respuesta
        cargarpagina (pagina_requerida, id_contenedor);
    }
    pagina_requerida.open ('GET', url, true); // asignamos los métodos open y send
    pagina_requerida.send (null);
}
// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina (pagina_requerida, id_contenedor)
{
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
    document.getElementById (id_contenedor).innerHTML = pagina_requerida.responseText;
}

// Esta función cargará las paginas
function lla (url, id_contenedor)
{
    var pagina_requerida = false;
    if (window.XMLHttpRequest)
    {
        // Si es Mozilla, Safari etc
        pagina_requerida = new XMLHttpRequest ();
    } else if (window.ActiveXObject)
    {
        // pero si es IE
        try 
        {
            pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            // en caso que sea una versión antigua
            try
            {
                pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
        }
    } 
    else
    return false;
    pagina_requerida.onreadystatechange = function ()
    {
        // función de respuesta
        cargarpagina (pagina_requerida, id_contenedor);
    }
    pagina_requerida.open ('GET', url, true); // asignamos los métodos open y send
    pagina_requerida.send (null);
}

function hidedivxx() {
	var x = document.querySelectorAll(".oscu");
	var i;
	for (i = 0; i < x.length; i++) { 
   	x[i].style.display = "none"; 
	}
}





function asegurarContenedor(id) {
  var destino = document.getElementById(id);
  if (!destino) {
    console.warn('No existe #' + id + ' - lo creo automaticamente.');
    destino = document.createElement('div');
    destino.id = id;
    document.body.appendChild(destino);
  }
  return destino;
}

function llamarasincrono22(url, id_contenedor) {
  id_contenedor = id_contenedor || 'contenido';
  var destino = asegurarContenedor(id_contenedor);
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        destino.innerHTML = xhr.responseText;
      } else {
        destino.innerHTML = 'Error ' + xhr.status + ' cargando: ' + url;
      }
    }
  };

  var sep = url.indexOf('?') >= 0 ? '&' : '?';
  xhr.open('GET', url + sep + '_=' + Date.now(), true);
  xhr.send(null);
}
