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

function addWindow (strContent, colorBg, intOpacity, className){
	
	var opacity = 10;
	
	if (!countId)
		countId = 0;
	
	countId += 1;
	
	var Tam = TamVentana();
	
	var capaBase = document.createElement('DIV');
	capaBase.id = 'capaBase'+countId;
	
	document.body.appendChild(capaBase);
	
	capaBase.style.background = '#000000';
	
	capaBase.style.position = 'absolute';
	
	capaBase.style.zIndex = countId;
	capaBase.style.top  = 0;
	capaBase.style.left = 0;
	
	capaBase.style.height = Tam[1];
	capaBase.style.width = Tam[0];
 	
	if (navigator.appVersion.indexOf("MSIE")!=-1){
		capaBase.style.filter = "alpha(opacity=" + opacity + ")";
	}else{
		capaBase.style.opacity = ( opacity / 100 );
	}	
	
	// alert(capaBase.id);
}