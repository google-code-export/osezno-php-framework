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
	
	document.getElementById('div_trigger_'+update).style.visibility  = 'hidden';
	
}

function addCalendarWindow (value, update, idtrigger){
	
	var strUrlCalendar = '../calendarCaller.php?date='+value+'&update='+update;
	
	if (document.getElementById('div_trigger_'+idtrigger).style.visibility=='visible')
		document.getElementById('div_trigger_'+idtrigger).style.visibility  = 'hidden';
	else{	
		document.getElementById('div_trigger_'+idtrigger).style.visibility  = 'visible';
	
		callUrlAsin(strUrlCalendar+'&div=div_trigger_'+idtrigger, 'div_trigger_'+idtrigger);
	}
}