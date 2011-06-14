var req = new Array();

var addInfo = 'Please wait...';

var reloadInfo = 'Slow process, you can ';

var idInterval = new Array();

var idFuncion = new Array();

var counter = new Array();

var allTabs = new Array();

var arrayAllTabsContent = new Array();

var lastIdTabVisit = '';

function loadAllTabs (){
	
	for (i=0; i<=arguments.length;i++){
		
		if (isArray(arguments[i])){
			
			callContent(arguments[i][3], arguments[i][0], arguments[i][4]);

		}
	}
	
}

function callContent (url, idArray, idDiv){
	
	var req;
	
	try {
   	 req = new XMLHttpRequest(); /* e.g. Firefox */
    } catch(e) {
      try {
   	   req = new ActiveXObject("Msxml2.XMLHTTP");  /* some versions IE */
      } catch (e) {
        try {
       	 req = new ActiveXObject("Microsoft.XMLHTTP");  /* some versions IE */
        } catch (E) {
       	 req = false;
        } 
      } 
    }
    
    req.onreadystatechange = function() {responseContent(req, idArray, idDiv);};
    
    req.open("GET",url,true);
    
    req.send(null);

}

function responseContent (req, idArray, idDiv){
	  
	var output = '';

	if (req.readyState == 4) {

		if (req.status == 200) {

			output = req.responseText;

		} else {

			output = req.responseText;

		}

	}
	
	document.getElementById(idDiv).innerHTML = output; 
}


function cancelQuery (tab){
	
	req[tab].abort();
	
}

function contador (tab){

	counter[tab] += 1;
	
	if (document.getElementById('counter_info_'+tab)){
	
		if (counter[tab]>3){
			
			document.getElementById('counter_info_'+tab).style.color = 'red';
			
			document.getElementById('counter_info_'+tab).innerHTML = reloadInfo+'<a href="javascript:void(cancelQuery(\''+tab+'\'))"><font face="arial" size="2" color="blue">abort</font></a> this process'+' (<b>'+counter[tab]+' seconds elapsed</b>) ';
		}else	
			document.getElementById('counter_info_'+tab).innerHTML = addInfo+' ('+counter[tab]+' seconds elapsed) ';
	}
	
}

function detenerInterval (tab){
	
	clearInterval(idInterval[tab]);
	
	counter[tab] = 0;
	
}



function callAHAH(url, pageElement, callMessage, errorMessage, tab, funcion) {

	if (idInterval[tab])
		detenerInterval(tab);
	
	counter[tab] = 0;
	
	idFuncion[tab] = funcion;
	
	idInterval[tab] = setInterval("contador('"+tab+"')",1000);

	callMessage = '<div style="font-family: arial;color: gray;font-size: 12;" id="counter_info_'+tab+'" name="counter_info_'+tab+'">'+addInfo+'</div>';
	
	document.getElementById(pageElement).innerHTML = callMessage;
		
     try {
    	 req[tab] = new XMLHttpRequest(); /* e.g. Firefox */
     } catch(e) {
       try {
    	   req[tab] = new ActiveXObject("Msxml2.XMLHTTP");  /* some versions IE */
       } catch (e) {
         try {
        	 req[tab] = new ActiveXObject("Microsoft.XMLHTTP");  /* some versions IE */
         } catch (E) {
        	 req[tab] = false;
         } 
       } 
     }

     req[tab].onreadystatechange = function() {responseAHAH(pageElement, errorMessage, tab);};
     
     req[tab].open("GET",url,true);
     
     req[tab].send(null);
     
  }



function responseAHAH(pageElement, errorMessage, tab) {
	
   var output = '';
   
   if(req[tab].readyState == 4) {
	   
	   detenerInterval(tab);
	   
      if(req[tab].status == 200) {
         
    	 output = req[tab].responseText;
         
         document.getElementById(pageElement).innerHTML = output;
         
       } else {
    	   
    	 output = req[tab].responseText;
    	   
    	 document.getElementById(pageElement).innerHTML = errorMessage+"\n"+output;
        	 
       }
 
   }
   
   
 }

/**
 * Activa una pestaña
 * @param tabActive	Id de la pestaña
 * @param from	Iniciar desde id
 * @param countTabs	Numero de pestañas 
 * @param urlActive	Url a la que apunta la pestaña
 * @param idDiv	Id del div a modificar el contenido
 * @param idDiv	Id del grupo de pestañas  
 * @return
 */
function makeactive(tabActive, from, countTabs, urlActive, idDiv, idTabs) { 

	for (var i=from;i<(from+countTabs);i++){
			
		document.getElementById(idTabs+"_tab"+i).className = '';
			
		document.getElementById("div_cont_"+idTabs+"_tab"+i).style.display ="none";
	}
		
	document.getElementById(tabActive).className = 'current';
		
	document.getElementById("div_cont_"+tabActive).style.display ="";
		
}
 