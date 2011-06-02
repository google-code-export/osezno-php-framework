var countIdCall=null;
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

function closeCalendarWindow (datForm, update){
	
	var callId = 'div_trigger_'+update;
	
	var div = document.getElementById(callId);
	
	padre = div.parentNode;
	
	padre.removeChild(div);
	
	countIdCall -= 2;
}

function selectDate (date, update){
	
	if (document.getElementById(update))
		
		document.getElementById(update).value  = date;
	
	var callId = 'div_trigger_'+update;
	
	var div = document.getElementById(callId);
	
	padre = div.parentNode;
	
	padre.removeChild(div);
	
	countIdCall -= 2;
}


function addCalendarWindow (value, update, idtrigger){

	if (!countIdCall)
		
		countIdCall = countId;
	
	var callId = 'div_trigger_'+idtrigger;
	
	var strUrlCalendar = '../calendarCaller.php?date='+value+'&update='+update;
	
	var div = document.getElementById(callId);
	
	if(!div){
	    
		countIdCall += 2;
		
		var pos = getAbsolutePosition(document.getElementById(update));
		
		var miCapa = document.createElement('DIV');
		
		miCapa.id = callId;
	
		document.body.appendChild(miCapa);
	
		miCapa.style.position = 'absolute';
	
		miCapa.style.zIndex = countIdCall;
		
		miCapa.style.top = pos.y+20;
		
		miCapa.style.left = pos.x;

		miCapa.className = 'calmain';

		callUrlAsin(strUrlCalendar+'&div=div_trigger_'+idtrigger, 'div_trigger_'+idtrigger);		
    	
	}else{  
		
		padre = div.parentNode;
		
		padre.removeChild(div);

		countIdCall -= 2;
	}
	
}

/**
 * Formato calendario
 */

function BlurDate( fInput )
{
  if ( !IsNumeric( StringReplace( '-', fInput.value ) ) || fInput.value == '0000-00-00' || fInput.value.length != 10 || !is_date( fInput.value ) )
  {
    fInput.value = '';
  }
}




function IsNumeric( sText ) 
{
  var ValidChars = "0123456789.";
  var IsNumber = true;
  var Char;
  for (i = 0; i < sText.length && IsNumber == true; i++) 
  {
    Char = sText.charAt(i);
    if ( ValidChars.indexOf( Char ) == -1 ) 
    {
      IsNumber = false;
    }
  }  
  return IsNumber;
}




function StringReplace( spliter, string )   {
  var array = string.split( spliter );
  if( array.length > 0 )
  {
    var size = array.length;
    var str = "";
    for ( var i=0; i<size; i++ )
    {
      str += array[i];
    }
    return str;
  }
  else
    return string;
}




function is_date( id )  
{
  if ( typeof( id ) == 'string' )
    var string = id;
  else
    var string = document.getElementById( id ).value;

  if ( !string )
    return false;
    
  var size = string.length;
    if ( size != 10 )
      return false;
    else    
    {
      if ( string.substring( 4, 5 ) != "-" )
        return false;
      if ( string.substring( 7, 8 ) != "-" )
        return false;
      return true;
    }
}




function NumericInput( evt )
{
  var keyPressed = (evt.which) ? evt.which : evt.keyCode;
  return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57) );
}




function CalendarFormat( input )   
{
  if ( input.value == "0000-00-00" || input.value == "0000000000")
  {
    return input.value = "";
  }
  
  var size = input.value.length;
  var now = new Date();
  var day = now.getDate();
  if ( day < 10 ) day = "0"+day;
  var month = now.getMonth()+1;
  if ( month < 10 ) month = "0"+month;
  var year = now.getFullYear();
  
  if ( size==4 || size==7 || size==10 )
  {
    //if ( size == 4 && input.value < ( year - 3 ) )
      //input.value = year; // Year
    if ( size == 7 && input.value.substring( 5, 7 ) == "00" )
      input.value = input.value.substring( 0, 4 )+"-"+month;
    if ( size == 10 && input.value.substring( 8, 10 ) == "00" )
      input.value = input.value.substring( 0, 4 )+"-"+input.value.substring( 5, 7 )+"-"+day;
    if ( size != 10 )
      input.value += "-";
  }
  
  //var nen = input.value.substring( 0, 4 );
  //if ( nen > ( year + 3 ) )
    //input.value = year+"-";
  var mes = input.value.substring( 5, 7 );
  if ( mes > 12 )   
  {
    input.value = input.value.substring( 0, 5 )+month+"-";
  }
  else    
  {
    var limit = "";
    
    switch( mes )
    {
      case "01" : limit = 31; break;
      case "02" : if ( nen % 4 == 0 ) limit = "29"; else limit = "28"; break;
      case "03" : limit = "31"; break;
      case "04" : limit = "30"; break;
      case "05" : limit = "31"; break;
      case "06" : limit = "30"; break;
      case "07" : limit = "31"; break;
      case "08" : limit = "31"; break;
      case "09" : limit = "30"; break;
      case "10" : limit = "31"; break;
      case "11" : limit = "30"; break;
      case "12" : limit = "31"; break;
    }
  }
  if ( input.value.length == 10 )
    if ( input.value.substring( 8, 10 ) > limit )
      input.value = input.value.substring( 0, 8 )+day;
}

