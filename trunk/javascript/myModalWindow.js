var countId=null;

function TamVentana() {
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
window.onresize = function() {
  
};

function addWindow (strContent, colorBg, intOpacity, windowWindth, windowHeight){
	
	var opacity = intOpacity;
	
	if (!countId)
		countId = 0;
	
	countId += 1;
	
	var Tam = TamVentana();
	
	var capaBase = document.createElement('DIV');
	capaBase.id = 'capaBase'+countId;
	
	document.body.appendChild(capaBase);
	
	capaBase.style.background = colorBg;
	
	capaBase.style.position = 'absolute';
	
	capaBase.style.zIndex = countId+1;
	capaBase.style.top  = 0;
	capaBase.style.left = 0;
	
	capaBase.style.height = Tam[1];
	capaBase.style.width = Tam[0];
 	
	if (navigator.appVersion.indexOf("MSIE")!=-1){
		capaBase.style.filter = "alpha(opacity=" + opacity + ")";
	}else{
		capaBase.style.opacity = ( opacity / 100 );
	}	
	
	var capaModalWindow = document.createElement('DIV');
	capaModalWindow.id = 'modalWindow'+countId;
	
	document.body.appendChild(capaModalWindow);
	
	capaModalWindow.style.zIndex = countId+2;
	
	capaModalWindow.style.height = windowHeight + 'px';
	capaModalWindow.style.width  = windowWindth + 'px';

	capaModalWindow.style.position = 'absolute';
	
	capaModalWindow.style.top  = Math.max(((Tam[1] - windowWindth) / 2),0) + 'px';
	capaModalWindow.style.left = Math.max(((Tam[0] - windowHeight) / 2),0) + 'px';
	
	capaModalWindow.innerHTML = strContent;
}

function closeModalWindow (){
	
	
}