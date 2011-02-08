
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

 /**
  * Obtiene la posicion actual del scroll en un arreglo
  */
 function getScrollXY() {
	  var scrOfX = 0, scrOfY = 0;
	  if( typeof( window.pageYOffset ) == 'number' ) {
	    //Netscape compliant
	    scrOfY = window.pageYOffset;
	    scrOfX = window.pageXOffset;
	  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
	    //DOM compliant
	    scrOfY = document.body.scrollTop;
	    scrOfX = document.body.scrollLeft;
	  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
	    //IE6 standards compliant mode
	    scrOfY = document.documentElement.scrollTop;
	    scrOfX = document.documentElement.scrollLeft;
	  }
	  return [ scrOfX, scrOfY ];
	}
 
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
	  
	 var arrayScrollPos = new Array();
	 arrayScrollPos = getScrollXY();
	  
	 var arrayPageSize = new Array();
     arrayPageSize = getPageSize();
     
     var miCapa = document.createElement('DIV');
     miCapa.id = 'notification';
     
     document.body.appendChild(miCapa);

 	 if (navigator.appVersion.indexOf("MSIE")!=-1){
		miCapa.style.filter = "alpha(opacity=0)";
	 }else{
		miCapa.style.opacity = 0;
	 }     
     
     miCapa.style.color = '#000000';
     miCapa.style.backgroundColor = '#FFFFFF';
     miCapa.style.position = 'absolute';
     
	 miCapa.style.zIndex = 5000;
	 miCapa.style.top    = 0;
	 miCapa.style.left   = 0;
	 miCapa.style.width	 = (arrayPageSize[0] + 'px');	 
	 miCapa.style.height = (arrayPageSize[1] + 'px');
	 miCapa.style.display='block';
	 
     var miImagen = document.createElement('DIV');
     miImagen.id = 'imagen_notificacion';
     
     document.body.appendChild(miImagen);

	 miImagen.style.position = 'absolute';

	 miImagen.style.zIndex = 5001;
	 miImagen.style.top    = ((arrayPageSize[3]/2)+arrayScrollPos[1])-12;
	 miImagen.style.left   = (arrayPageSize[2]/2)-20;
	 miImagen.style.width  = '25px';
	 miImagen.style.height = '40px';

	 miImagen.innerHTML = '<img id="loader_image" src="../../javascript/img/common/loader.gif">';
  }

  xajax.callback.global.beforeResponseProcessing = function() {
    
    var el = document.getElementById('imagen_notificacion');
    var padre = el.parentNode;
	padre.removeChild(el);
	  
    var el = document.getElementById('notification');
    var padre = el.parentNode;
	padre.removeChild(el);
  }

  
  function onResizeScroll (){

	  var arrayPageSize = new Array();
	  arrayPageSize = getPageSize();

	  var capaBaseId = '';
	  
	  for (i=0;i<=countId;i++){
		  
		  capaBaseId = 'capaBase'+countId;
		  
		  if (document.getElementById(capaBaseId)){
			  
			  document.getElementById(capaBaseId).style.height = arrayPageSize[1];
			  document.getElementById(capaBaseId).style.width = arrayPageSize[0];
		  }
	  }
	   
  }
  
  /**
   * Funcion aplicada cuando el browser es cambiado de tamaño
   */
  function Resize (){
	  
	  var arrayPageSize = new Array();
	  arrayPageSize = getPageSize();

	  var capaBaseId = '';
	  
	  for (i=0;i<=countId;i++){
		  
		  capaBaseId = 'capaBase'+countId;
		  
		  if (document.getElementById(capaBaseId)){
			  
			  document.getElementById(capaBaseId).style.height = arrayPageSize[1];
			  document.getElementById(capaBaseId).style.width = arrayPageSize[0];
		  }
	  }  
	   
  }
  
/*
 * notificationWindow
 */

var nc = (document.layers) ? true:false
var ie = (document.all) ? true:false
var n6 = (document.getElementById) ? true:false
var arrayNotiWindNuPos = new Array();
var arrayNotiWindPos = new Array();
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
	
	var arrayScrollPos = new Array();
	
	var arrayPageSize = new Array();
	
    arrayPageSize = getPageSize();
    
    arrayScrollPos = getScrollXY();
	
    var checkPoint = arrayScrollPos[1]-60;
    
    var startPoint = checkPoint;
    
    var endPoint = checkPoint+70;
    
	var pofFijNW = aleatorio(1, 10000);
	
	var miCapa = document.createElement('DIV');
	
	miCapa.id = 'notificationwindow_'+pofFijNW;
	
	document.body.appendChild(miCapa);
	
	miCapa.innerHTML = '<table border="0" cellpadding="0" cellspacing="0"><tr><td><div class="notifi_img_'+type+'">&nbsp;</div></td><td class="notification_text_'+type+'">&nbsp;'+strNotification+'&nbsp;</td></tr></table>';
	
	miCapa.style.position = 'absolute';
	
	miCapa.style.zIndex = 2000;
	
	miCapa.style.top = startPoint;
	
	miCapa.style.left = 10;
	
	miCapa.className = 'notification_'+type;
	
	if (navigator.appVersion.indexOf("MSIE")!=-1){
		miCapa.style.filter = "alpha(opacity=90)";
	 }else{
		miCapa.style.opacity = 0.9;
	 }  

	mueveNotificationWindow(miCapa.id, startPoint, endPoint);
	
	setTimeout("mueveNotificationWindow('"+miCapa.id+"', "+endPoint+","+startPoint+")",intSecDuration);
	
	setTimeout("destructNotificationWindow('"+miCapa.id+"')",intSecDuration+1000);
}
 	
function mueveNotificationWindow(idElement, ini,pos){ 
	
	arrayNotiWindPos[idElement]=ini;
	
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
		arrayNotiWindNuPos[idElement]=arrayNotiWindPos[idElement]+tam					
 	else if (ini>pos)
 		arrayNotiWindNuPos[idElement]=arrayNotiWindPos[idElement]-tam						
	else
		arrayNotiWindNuPos[idElement]=pos;	  
	
	aux=pos;	  
	if(arrayNotiWindNuPos[idElement]!=pos){
      if(ie) 
        document.all[idElement].style.top=arrayNotiWindNuPos[idElement];
      else if(nc) 
        document.layers[idElement].top=arrayNotiWindNuPos[idElement];
      else if(n6) 
        document.getElementById(idElement).style.top=arrayNotiWindNuPos[idElement];          
      
      arrayNotiWindPos[idElement]=arrayNotiWindNuPos[idElement];
      
      setTimeout("mueveNotificationWindow('"+idElement+"',"+arrayNotiWindPos[idElement]+","+aux+")",10);
     }
}

function destructNotificationWindow (idElement){
	if (idElement){
		var el = document.getElementById(idElement);
    	var padre = el.parentNode;
    	padre.removeChild(el);
	}
}

function CentrarVentana(){
      x = (screen.width - 300)  / 2;
      y = (screen.height - 200) / 2;
      moveTo(x, y);
      }
      
/**
 * Por medio de la eitqueta de un checkbox cheka o no la misma dependiendo de su valor actual-
 * 
 * @param id
 * @return
 */
function checkear (id){

	if (document.getElementById(id).checked == true)
		document.getElementById(id).checked = false;
	else
		document.getElementById(id).checked = true;
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

function GetArray(){
	
	ar = new Array();
	
	frag = new Array();
	
	for (var i=0;i<arguments.length;i++){
		frag = arguments[i].split(':::');
		ar[frag[0]] = frag[1];
	}
	
	return ar;
}

function GetDataForm (form){
      
	  var buf = '';
	
      var form_elements = new Array();
         
      if (form){
    	  
    	 form_elements['form_id'] = form; 
    	  
         for (i=0; i<document.forms[form].elements.length; i++){
              
              if (isArray(document.forms[form].elements[i].name)) 
                  alert (document.forms[form].elements[i].name);
               
              var option = document.forms[form].elements[i].type;
               
              switch (option){
                 case 'checkbox':
                    var checkbox_value = document.forms[form].elements[i].checked;
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

function getAbsolutePosition(element) {
	
		var r = { x: element.offsetLeft, y: element.offsetTop };
		
		if (element.offsetParent) {
			
			var tmp = getAbsolutePosition(element.offsetParent);
			
			r.x += tmp.x;
			
			r.y += tmp.y;
		}
		
		return r;
}