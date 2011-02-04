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

function selectDate (date, update){
	
	document.getElementById(update).value  = date;
	
	var callId = 'div_trigger_'+update;
	
	var div = document.getElementById(callId);
	
	padre = div.parentNode;
	
	padre.removeChild(div);
	
	countId -= 2;
}


function addCalendarWindow (value, update, idtrigger){

	if (!countId)
		countId = 0;
	
	var callId = 'div_trigger_'+idtrigger;
	
	var strUrlCalendar = '../calendarCaller.php?date='+value+'&update='+update;
	
	var div = document.getElementById(callId);
	
	if(!div){
	    
		countId += 2;
		
		var pos = getAbsolutePosition(document.getElementById(update));
		
		var miCapa = document.createElement('DIV');
		
		miCapa.id = callId;
	
		document.body.appendChild(miCapa);
	
		miCapa.style.position = 'absolute';
	
		miCapa.style.zIndex = countId;
		
		miCapa.style.top = pos.y+20;
		
		miCapa.style.left = pos.x;

		miCapa.className = 'calmain';

		callUrlAsin(strUrlCalendar+'&div=div_trigger_'+idtrigger, 'div_trigger_'+idtrigger);		
    	
	}else{  
		
		padre = div.parentNode;
		
		padre.removeChild(div);

		countId -= 2;
	}
	
}