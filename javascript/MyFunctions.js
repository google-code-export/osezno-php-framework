
/**
 * Bloquea el primer select-one de un formulario de filtro de una lista dinamica
 * @param nomForm
 * @return
 */
function blockFirstElementForm (nomForm){
	var i;
	var id;
	var option;
	for (i=0; i<document.forms[nomForm].elements.length; i++){
        
		option = document.forms[nomForm].elements[i].type;
		if (option == 'select-one'){
			id = document.forms[nomForm].elements[i].id;
			document.getElementById(id).disabled = true;
			document.getElementById(id).style.display = "none";
			break;
		}
		
   }	
}


function callUrlAsin(url, pageElement) {

    try{
   	 req = new XMLHttpRequest(); // e.g. Firefox 
    }catch(e){
      try{
   	   req = new ActiveXObject("Msxml2.XMLHTTP");  // some versions IE 
      }catch(e){
        try{
       	 req = new ActiveXObject("Microsoft.XMLHTTP");  // some versions IE 
        }catch(E){
       	 req = false;
        }
      }
    }

    req.onreadystatechange = function() {responseCallUrl(pageElement);};
    
    req.open("GET",url,true);
    
    req.send(null);

}

function responseCallUrl(pageElement) {
	
	var output = '';
	   
	if(req.readyState == 4){
		   
	  if(req.status == 200){
	         
	 	 output = req.responseText;
	        
	     document.getElementById(pageElement).innerHTML = output;
	         
	  }else{
	        	 
		 output = req.responseText;
		  
	  	 document.getElementById(pageElement).innerHTML = output;
	        	 
	  }
	  
	}
	   
}


/*
 *  xajax callbacks
 */

 /*
  * Obtiene el tamaño de una area de trabajo visible para un browser
  */
 function getPageSize()
	{
		var xScroll, yScroll;
		
		if (window.innerHeight && window.scrollMaxY) {	
			xScroll = document.body.scrollWidth;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}
		
		var windowWidth, windowHeight;
		if (self.innerHeight) {	// all except Explorer
			windowWidth = self.innerWidth;
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}	
		
		// for small pages with total height less then height of the viewport
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else { 
			pageHeight = yScroll;
		}
	
		// for small pages with total width less then width of the viewport
		if(xScroll < windowWidth){	
			pageWidth = windowWidth;
		} else {
			pageWidth = xScroll;
		}
		
		arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
		 
		return arrayPageSize;
	}	


  xajax.callback.global.onRequest = function() {
	  
	  var arrayPageSize = new Array();
     arrayPageSize = getPageSize();
     
     var miCapa = document.createElement('DIV');
     miCapa.id = 'notification';
     
     document.body.appendChild(miCapa);

 	 if (navigator.appVersion.indexOf("MSIE")!=-1){
		miCapa.style.filter = "alpha(opacity=20)";
	 }else{
		miCapa.style.opacity = 0.2;
	 }     
     
     miCapa.style.color = '#000000';
     miCapa.style.backgroundColor = '#AAAAAA';
     miCapa.style.position = 'absolute';
     
	 miCapa.style.zIndex = 5000;
	 miCapa.style.top    = '0';
	 miCapa.style.left   = '0';
	 miCapa.style.width	 = (arrayPageSize[2] + 'px');	 
	 miCapa.style.height = (arrayPageSize[1] + 'px');
	 miCapa.style.display='block';
	 
     var miImagen = document.createElement('DIV');
     miImagen.id = 'imagen_notificacion';
     
     document.body.appendChild(miImagen);

	 miImagen.style.position = 'absolute';

	 miImagen.style.zIndex = 5001;
	 miImagen.style.top    = '0';
	 miImagen.style.left   = '0';
	 miImagen.style.width  = (arrayPageSize[2] + 'px');	 
	 miImagen.style.height = (arrayPageSize[1] + 'px');
	 miImagen.style.minHeight	= '100%';
	 
	 miImagen.innerHTML = '<table border="0" width="100%" height="100%"><tr><td align="center" valign="middle"><img src="../../javascript/img/common/loader.gif" title="Loading..."></td></tr></table>';
	
	 //Preguntar si existe el objeto
	 //vanecerCallBack(miCapa,0);
  }

  xajax.callback.global.beforeResponseProcessing = function() {
    
    desvanecerCallBack ('notification','imagen_notificacion',10);

    var el = document.getElementById('notification');
    var padre = el.parentNode;
	padre.removeChild(el);
  }


function desvanecerCallBack (idMw, idGif, cont){
	
	temp = 30;
	cont -= 2;
	
	if(cont>0){
		if (navigator.appVersion.indexOf("MSIE")!=-1){
	   		document.getElementById(idGif).style.filter = "alpha(opacity="+(cont)+")";
		}else{
	   	    document.getElementById(idGif).style.opacity = cont/100;
		}
		setTimeout("desvanecerCallBack('"+idMw+"','"+idGif+"',"+cont+")",temp);
	}else{
  		var el = document.getElementById('imagen_notificacion');
    	var padre = el.parentNode;
		padre.removeChild(el);	
	}	
	
}


function vanecerCallBack (objCapa, cont){
	
	var id = objCapa.id;
	
	temp = 50;
	cont += 3;
	
	if(cont<61){
		
		if (navigator.appVersion.indexOf("MSIE")!=-1){
			document.getElementById(id).style.filter = "alpha(opacity="+cont+")";
		}else{
	   	    document.getElementById(id).style.opacity = cont/100;
		}
		
		setTimeout("vanecerCallBack('"+objCapa+"',"+cont+")",temp);
	}
	
}


/*
 * notificationWindow
 */

var nc = (document.layers) ? true:false
var ie = (document.all) ? true:false
var n6 = (document.getElementById) ? true:false
var posicion;
var nueva_posicion;
var aux=1;
var tam;
var absol;

function aleatorio(inferior,superior){
	
    numPosibilidades = superior - inferior
    aleat = Math.random() * numPosibilidades
    aleat = Math.round(aleat)
    
    return parseInt(inferior) + aleat
} 

function createNotificationWindow (strNotification, intSecDuration, type){
	
	var pofFijNW = aleatorio(1, 1000);
	
	var miCapa = document.createElement('DIV');
	
	miCapa.id = 'notificationwindow_'+pofFijNW;
	
	document.body.appendChild(miCapa);
	
	miCapa.innerHTML = '<table border="0" cellpadding="0" cellspacing="0"><tr><td><div class="notifi_img_'+type+'">&nbsp;</div></td><td class="notification_text_'+type+'">&nbsp;'+strNotification+'&nbsp;</td></tr></table>';
	
	miCapa.style.position = 'absolute';
	
	miCapa.style.zIndex = 2000;
	miCapa.style.top = -60;
	miCapa.style.left = 10;
	miCapa.className = 'notification_'+type;
	
	mueveNotificationWindow(miCapa.id, -60, 10);
	
	setTimeout("mueveNotificationWindow('"+miCapa.id+"', 10,-60)",intSecDuration);
	
	setTimeout("destructNotificationWindow('"+miCapa.id+"')",intSecDuration+1000);
}
 	
function mueveNotificationWindow(idElement, ini,pos){ 
	posicion=ini;     
   	tam=1;  
 	if ((ini>pos) && ((ini-pos)<10))
 	 tam=ini-pos;
 	if ((ini>pos) && ((ini-pos)>10))
 	 tam=1;
 	if ((ini<pos) && ((pos-ini)<10))
 	 tam=ini-pos;
 	if ((ini<pos) && ((pos-ini)<10))
 	 tam=1;	  
	if (ini<pos)
	 nueva_posicion=posicion+tam					
 	else if (ini>pos)
 	 nueva_posicion=posicion-tam						
	else
	 nueva_posicion=pos;	  
	
	aux=pos;	  
	if(nueva_posicion!=pos){
      if(ie) 
        document.all[idElement].style.top=nueva_posicion;
      else if(nc) 
        document.layers[idElement].top=nueva_posicion;
      else if(n6) 
        document.getElementById(idElement).style.top=nueva_posicion;          
      
      posicion=nueva_posicion;
      setTimeout("mueveNotificationWindow('"+idElement+"',posicion,aux)",10);
     }
}

function destructNotificationWindow (idElement){
	if (idElement){
		var el = document.getElementById(idElement);
    	var padre = el.parentNode;
    	padre.removeChild(el);
	}
}



/**
 * Manejo de archivos
 */	

function fileQueuedFunction(file, queuelength) {
	var ul = document.getElementById("joselito");
	var li = document.createElement("li");
	ul.appendChild(document.createTextNode(file.name));
}

function uploadProgressFunction(file, bytesloaded, bytestotal) {
	var progress = document.getElementById("lista_archivos");
	var percent = Math.ceil((bytesloaded / bytestotal) * 100);
	progress.innerHTML = percent + "%";	
}

function CentrarVentana(){
      x = (screen.width - 300)  / 2;
      y = (screen.height - 200) / 2;
      moveTo(x, y);
      }
      
function checkear (the_form, item)
{
 var status = document.forms[the_form].elements[item].checked
 if (status == true)
    document.forms[the_form].elements[item].checked=false
 else
    document.forms[the_form].elements[item].checked=true
}

function Check(the_form, item){
 var status = document.forms[the_form].elements[item].checked

 if (document.forms[the_form].elements[item].checked == 0){
    document.forms[the_form].elements[item].value='0'
    }
 else
    {
    document.forms[the_form].elements[item].value='1'
    }
}                

function setCheckboxes(the_form, do_check){
    var elts      = (typeof(document.forms[the_form].elements) != 'undefined')
                  ? document.forms[the_form].elements
                  : document.forms[the_form].elements;
    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt){
        for (var i = 0; i < elts_cnt; i++){
            if (elts[i].type == 'checkbox'){
               elts[i].checked = do_check;
               var nameCheck = elts[i].name; 
               var nameHidden = nameCheck;
               
               if (do_check)
                  document.getElementById(nameHidden).value = '1'
               else   
                  document.getElementById(nameHidden).value = '0'
            }
        }
    }else {
       elts.checked = do_check;
     } 
             
    return true;
}

function OnlyNum(event)
         {
         var unicode=event.charCode? event.charCode : event.keyCode
         if (unicode!=8  && unicode!=9){
            if ((unicode<48 || unicode>57) && unicode != 46)
               return false 
            }
         }
         
function OpenWindowForm (NAME, WIDTH, HEIGHT, URL){
   var urlToGo

   if (URL.lastIndexOf ("?") > 0){
      urlToGo = URL+'&width='+WIDTH+'&height='+HEIGHT
      }
   else{
      urlToGo = URL+'?width='+WIDTH+'&height='+HEIGHT
      }

   mywindow= window.open (urlToGo,NAME,"resizable=1,menubar=1,location=0,status=0,scrollbars=1,width="+WIDTH+",height="+HEIGHT+"");
}

function CernterWindowForm(WIDTH, HEIGHT){
      x = (screen.width - WIDTH)  / 2;
      y = (screen.height - HEIGHT) / 2;
      moveTo(x, y);
      }

function isArray(v) {
     return v && typeof v === 'object' && typeof v.length === 'number' &&
	          !(v.propertyIsEnumerable('length'));
}

function GetDataField(data){
	
	
	return data;
}

function GetDataForm (form){
      var buf = '';
      var form_elements = new Array();
         
      if (form){   
         for (i=0; i<document.forms[form].elements.length; i++){
              
              if (isArray(document.forms[form].elements[i].name)) 
                  alert (document.forms[form].elements[i].name);
               
              var option = document.forms[form].elements[i].type;
               
              switch (option){
                 case 'checkbox':
                    var checkbox_value = document.forms[form].elements[i].value;
                    form_elements[document.forms[form].elements[i].name] = checkbox_value;
                 break;
                 case 'select-multiple':
                    var cadenaMultiple = '';
                    
                    form_elements[document.forms[form].elements[i].name] = new Array();
                    
                    for (var j=0; j<document.forms[form].elements[i].options.length; j++){
                        if (document.forms[form].elements[i].options[j].selected){
                           form_elements[document.forms[form].elements[i].name][j] = document.forms[form].elements[i].options[j].value; 
                        }
                    }
                  break;
                  case 'radio':
                    if (document.forms[form].elements[i].checked){
                       form_elements[document.forms[form].elements[i].name] = document.forms[form].elements[i].value; 
                    }                  
                  break;
                  case 'button':
                  break;
                  case 'submit':
                  break;
           	      default:
                     form_elements[document.forms[form].elements[i].name] = document.forms[form].elements[i].value;                     
                  break;
              }
              
         }
       }  
         return form_elements;
}

function MostrarEsconderFieldSet (idCapa){
    if ((document.getElementById(idCapa).style.display == "none"))
       document.getElementById(idCapa).style.display ="";
    else
       document.getElementById(idCapa).style.display ="none";
 }

function add_values(objetoSelect)
         {
         var opt_selected = new Array();
         var index = 0;
         for (var i=0;i < objetoSelect.options.length;i++)
             {
             if (objetoSelect.options[i].selected)
                {
                opt_selected[index] = objetoSelect.options[i].value;
                index++;
                }
             }
         return opt_selected;
         }           
 
function diaHoy()
        {
        var dias=new Array (
                            "Domingo","Lunes","Martes",
                            "Miercoles","Jueves",
                            "Viernes","Sabado"
                           );
        var meses=new Array (
                             "Enero","Febrero","Marzo",
                             "Abril","Mayo","Junio",
                             "Julio","Agosto","Septiembre",
                             "Octubre","Noviembre","Diciembre"
                            );
        var hoy = new Date();
        var fecha = "Hoy es "+dias[hoy.getDay()] + " " +  hoy.getDate() + " de " + meses[hoy.getMonth()] + " de " + hoy.getFullYear();
        document.write(fecha);
        }

function muestraReloj()
{
if (!document.layers && !document.all && !document.getElementById) return;
   var fechacompleta = new Date();
   var horas = fechacompleta.getHours();
   var minutos = fechacompleta.getMinutes();
   var segundos = fechacompleta.getSeconds();
   var mt = "am";
   if (horas > 12)
      {
      mt = "pm";
      horas = horas - 12;
      }
   if (horas == 0)
      horas = 12;
   if (minutos <= 9)
      minutos = "0" + minutos;
   if (segundos <= 9)
      segundos = "0" + segundos;
   cadenareloj = horas + ":" + minutos + ":" + segundos + " " + mt;
   if (document.layers)
      {
      document.layers.spanreloj.document.write(cadenareloj);
      document.layers.spanreloj.document.close();
      }
   else if (document.all)
           spanreloj.innerHTML = cadenareloj;
   else if (document.getElementById)
           document.getElementById("spanreloj").innerHTML = cadenareloj;
   setTimeout("muestraReloj()", 1000);
}
