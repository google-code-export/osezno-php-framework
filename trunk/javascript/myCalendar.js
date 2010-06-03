var countId=null;
var nc = (document.layers) ? true:false
var ie = (document.all) ? true:false
var n6 = (document.getElementById) ? true:false

function CalTamVentana() {
  var Tamanyo = [0, 0];
  if (typeof window.innerWidth != 'undefined')
  {
    Tamanyo = [
        window.innerWidth,
        window.innerHeight
    ];
  }
  else if (typeof document.documentElement != 'undefined'
      && typeof document.documentElement.clientWidth !=
      'undefined' && document.documentElement.clientWidth != 0)
  {
 Tamanyo = [
        document.documentElement.clientWidth,
        document.documentElement.clientHeight
    ];
  }
  else   {
    Tamanyo = [
        document.getElementsByTagName('body')[0].clientWidth,
        document.getElementsByTagName('body')[0].clientHeight
    ];
  }
  return Tamanyo;
}


function addCalendarWindow (strUrlCalendar, idtrigger){
	
	document.getElementById('div_trigger_'+idtrigger).style.visibility  = 'visible';
	
	callUrl(strUrlCalendar+'&div=div_trigger_'+idtrigger, 'div_trigger_'+idtrigger, 'Cargando calendario...', 'Error');
}



function callUrl(url, pageElement, callMessage, errorMessage) {
    document.getElementById(pageElement).innerHTML = callMessage;
    
    try {
    req = new XMLHttpRequest(); // e.g. Firefox 
    } catch(e) {
      try {
      req = new ActiveXObject("Msxml2.XMLHTTP");  // some versions IE 
      } catch (e) {
        try {
        req = new ActiveXObject("Microsoft.XMLHTTP");  // some versions IE 
        } catch (E) {
         req = false;
        } 
      } 
    }
    req.onreadystatechange = function() {responseAHAH(pageElement, errorMessage);};
    req.open("GET",url,true);
    req.send(null);
 }

function responseAHAH(pageElement, errorMessage) {
  var output = '';
  if(req.readyState == 4) {
     if(req.status == 200) {
        output = req.responseText;
        document.getElementById(pageElement).innerHTML = output;
        } else {
        document.getElementById(pageElement).innerHTML = errorMessage+"\n"+output;
        }
     }
 }
