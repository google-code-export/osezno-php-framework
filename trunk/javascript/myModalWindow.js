var countId=null;
var nc = (document.layers) ? true:false
var ie = (document.all) ? true:false
var n6 = (document.getElementById) ? true:false

function addWindow (strContent, colorBg, intOpacity, windowWindth, windowHeight){
	
	var opacity = intOpacity;
	
	if (!countId)
		countId = 0;
	
	countId += 1;
	
	var arrayScrollPos = new Array();
	arrayScrollPos = getScrollXY();
	
	var arrayPageSize = new Array();
    arrayPageSize = getPageSize();
	
	var capaBase = document.createElement('DIV');
	capaBase.id = 'capaBase'+countId;
	
	document.body.appendChild(capaBase);
	
	capaBase.className = 'blocker_mw';
	
	capaBase.style.zIndex = countId+1;
	
	capaBase.style.height = arrayPageSize[1];
	capaBase.style.width = arrayPageSize[0];

	var capaModalWindow = document.createElement('DIV');
	capaModalWindow.id = 'modalWindow'+countId;
	
	document.body.appendChild(capaModalWindow);
	
	capaModalWindow.style.zIndex = countId+2;
	
	capaModalWindow.style.height = windowHeight + 'px';
	capaModalWindow.style.width  = windowWindth + 'px';

	capaModalWindow.style.position = 'absolute';
	
	capaModalWindow.style.top = Math.max(arrayScrollPos[1]+(arrayPageSize[3]/2)-(windowHeight/2))+'px';
	capaModalWindow.style.left = Math.max(((arrayPageSize[0] - windowWindth) / 2),0) + 'px';
	
	capaModalWindow.innerHTML = strContent;
}

function closeModalWindow (){
	
	var idElementBase = 'capaBase'+countId;
	
	if (document.getElementById(idElementBase)){
	
		var vcp = document.getElementById(idElementBase);

		var padreVcp = vcp.parentNode;
		
		padreVcp.removeChild(vcp);
    
		var idElementWindow = 'modalWindow'+countId;
		
		var vmw = document.getElementById(idElementWindow);

		var hijoVmw = vmw.parentNode;
		
		hijoVmw.removeChild(vmw);
    
		countId -= 1;
	}
	
}


/**
* Efectos para modalwindows
*/
function desvanecer (idMw, intWidth, intHeight, cont){
	
	temp = 25;
	cont += 5;
	
	if(cont<101){
		if (navigator.appVersion.indexOf("MSIE")!=-1){
	   		document.getElementById(idMw).style.filter = "alpha(opacity="+(cont)+")";
		}else{
	   	    document.getElementById(idMw).style.opacity = cont/100;
		}
		setTimeout("desvanecer('"+idMw+"',"+intWidth+","+intHeight+","+cont+")",temp);
	}
	
}

function curtain (idMw, intWidth, intHeight, cont){
	
	if (cont==0){
  		document.getElementById(idMw).style.display ="";
	}
	
	if(ie){ 
	  temp = 15;
	  cont += 15;
	}else if(nc){  
	  temp = 5;
	  cont += 10;
	}else if(n6){  
	  temp = 5;
	  cont += 5;
	}
	
	if (cont<=intHeight){
		 
		if(ie){
			document.all[idMw].style.height=cont;
		}else if(nc){
			document.layers[idMw].height=cont;
		}else if(n6){
			document.getElementById(idMw).style.height=cont;
		}  	   	
     
	   setTimeout("curtain('"+idMw+"',"+intWidth+","+intHeight+","+cont+")",temp);
	}
}

 /**
  * Drag and drop para modalWindow y messageBox
  */
 var is_ie = navigator.appName == 'Microsoft Internet Explorer';
 var is_op = navigator.appName == 'Opera' ? true : false;
 var is_ns = !is_ie && !is_op ? true : false;
 	
 function js_drag(e){
 		
	var sufijo = 'modalWindow';
 	var capas;
 	var idcapa;
 	var lb_widgets = 0;
 	capas = document.getElementsByTagName("div");
 		 
 	for (iCapas=0;iCapas<capas.length;iCapas++){
   		idcapa = capas[iCapas].getAttribute('id');
   		if (idcapa){
 	  		if (idcapa.substring(0,sufijo.length) == sufijo)
   				lb_widgets++;
   		}
   	} 
 		
 	var elemento =  sufijo+lb_widgets;
   	
 	e||window.event;
 	var e = e;
 	var Obj = new Object(); 
 	var body  = document.getElementsByTagName('body')[0];
 	Obj.zI = 0;
 	Obj.Elemento = typeof(elemento) == 'object' ? elemento : document.getElementById(elemento);
 	
 	js_position = function(ly,x,y){
 		x = is_ie||is_op ? e.clientX + document.documentElement.scrollLeft + body.scrollLeft : e.clientX + window.scrollX;
 		y = is_ie||is_op ? e.clientY + document.documentElement.scrollTop + body.scrollTop : e.clientY + window.scrollY;
 		Obj.startX=x;
 		Obj.startY=y;
 		Obj.startL=parseInt(Obj.Elemento.style.left,10);
 		Obj.startT=parseInt(Obj.Elemento.style.top,10);
 		Obj.startL=isNaN(Obj.startL) ? 0 : Obj.startL;
 		Obj.startT=isNaN(Obj.startT) ? 0 : Obj.startT;
 		//Obj.Elemento.style.zIndex = ++Obj.zI;
 		js_addEvent(document,'mousemove',startdrag);
 		js_addEvent(document,'mouseup',enddrag);
 		js_addEvent(document,'keypress',enddrag);
 		if(is_ie){    
 			e.cancelBubble = true;
 			e.returnValue = false;    
 		}else{
 			e.preventDefault();
 		}
 	};
 		
 	startdrag = function(e){
 		var x, y;
 		e||event;
 		x = is_ie||is_op ? e.clientX + document.documentElement.scrollLeft + body.scrollLeft : e.clientX + window.scrollX;
 		y = is_ie||is_op ? e.clientY + document.documentElement.scrollTop + body.scrollTop : e.clientY + window.scrollY;
 		ILeft = ( Obj.startL + x - parseInt(Obj.startX) );
 		ITop = ( Obj.startT + y - parseInt(Obj.startY) );
 		js_moveTo(Obj.Elemento,ILeft,ITop);
 			
 		if (navigator.appVersion.indexOf("MSIE")!=-1){
 		    Obj.Elemento.style.filter = "alpha(opacity=" + 50 + ")";
 		}else{
 			Obj.Elemento.style.opacity = ( 50 / 100 );
 		}
 			
 		if(is_ie){
 		    e.cancelBubble = true; e.returnValue = false;    
 		}else{
 			e.preventDefault();
 		}
 	};
 		
 	enddrag = function (e){
 		js_detEvent(document,'mousemove',startdrag);
 		js_detEvent(document,'mouseup',enddrag);
 			
 		if (navigator.appVersion.indexOf("MSIE")!=-1){
 		   Obj.Elemento.style.filter = "alpha(opacity=" + 100 + ")";
 		}else{
 		   Obj.Elemento.style.opacity = ( 100 / 100 );
 		}
 		
 		onResizeScroll();
 	};
 		
 	js_position(Obj.Elemento,e.clientX,e.clientY);
 };
 	
 	js_moveTo = function(element,Left,Top){
 		element.style.left = Left + "px";
 		element.style.top  = Top + "px";
 	};
 	
 	js_addEvent = function(Layer,eventype,func){
 		if( is_ns )
 			Layer.addEventListener( eventype, func, true );
 		else if( is_ie )
 			Layer.attachEvent( "on" + eventype, func );
 		else
 			Layer[ "on" + eventype ] = func;
 	};
 	
 	js_detEvent = function(Layer,typef,func){
 		if(is_ie)
 			Layer.detachEvent("on" + typef, func);
 		else if(is_ns)
 			Layer.removeEventListener( typef, func, true);
 		else
 			Layer["on" + typef] = null;
 	};