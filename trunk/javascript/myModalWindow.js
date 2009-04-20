	xjxmW = xajax.ext.modalWindow;
	
	var lb_widgets = 0;
	var loadinglayer = 0;


	xjxmW.getHeight = function( e )
	{
		if ( e.style.Height )
		{
			return e.style.Height;
		}
		else
		{
			return e.offsetHeight;
		}
	}

	/**
	 * Function getWidth to recieve the height of the element
	 */
	xjxmW.getWidth = function( e )
	{
		if ( e.style.Width )
		{
			return e.style.Width;
		}
		else
		{
			return e.offsetWidth;
		}
	}

	/**
	 * Function getPageSize to recieve the size of the current window
	 */
	xjxmW.getPageSize = function()
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

	/**
	 * Function getPageSize to recieve the size of the current pagescroll
	 */
	xjxmW.getPageScroll = function()
	{
		var yScroll;

		if (self.pageYOffset) {
			yScroll = self.pageYOffset;
		} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
			yScroll = document.documentElement.scrollTop;
		} else if (document.body) {// all other Explorers
			yScroll = document.body.scrollTop;
		}

		arrayPageScroll = new Array('',yScroll)
		return arrayPageScroll;
	}	
	
	function addWindow(htmlContent, colorBackground, intOpacity, className) {
		
		lb_widgets++;
				
		//xjxmW.hideSelects( 'hidden' );
				
		var objBody			= document.getElementsByTagName("body").item(0);
		var zIndex			= lb_widgets ? lb_widgets * 1000 : 1000;
		var arrayPageSize	= xjxmW.getPageSize();
		var arrayPageScroll = xjxmW.getPageScroll();
		var objOverlay 		= document.createElement("div");
				
		objOverlay.setAttribute('id','lb_layer' + lb_widgets );
		objOverlay.style.display 	= 'none';
		objOverlay.style.position	= 'absolute';
		objOverlay.style.top		= '0';
		objOverlay.style.left		= '0';
		objOverlay.style.zIndex		= zIndex;
	 	objOverlay.style.width		= '100%';
	 	objOverlay.style.height		= (arrayPageSize[1] + 'px');
	 	objOverlay.style.minHeight	= '100%';
	 	
	 	if ( colorBackground )
	 	{
	 		objOverlay.style.backgroundColor = colorBackground;
	 	}
	 	
	 	if ( intOpacity )
	 	{
			if (navigator.appVersion.indexOf("MSIE")!=-1)
			{
				objOverlay.style.filter = "alpha(opacity=" + intOpacity + ")";
			}
			else
			{
	 			objOverlay.style.opacity = ( intOpacity / 100 );
			}
	 	}
	 	
	 	if ( className )
	 	{
			objOverlay.className = className;
	 	}

	 	objBody.appendChild(objOverlay);

	 	/*
		var objLockbox = document.createElement("div");
		objLockbox.setAttribute('id','lb_content' + lb_widgets );
		objLockbox.style.visibility	= 'hidden';
		objLockbox.style.position	= 'absolute';
		objLockbox.style.top		= '0';
		objLockbox.style.left		= '0';
		objLockbox.style.zIndex		= zIndex + 1 ;
		
		objBody.appendChild(objLockbox);
		
		objLockbox.innerHTML = htmlContent;
		
		var objContent = objLockbox.firstChild;
				
		height	= xjxmW.getHeight( objContent );
		
		width	= xjxmW.getWidth( objContent );
		
		cltop   = (arrayPageScroll[1] + ( (arrayPageSize[3] -  height ) / 2 ) );
		clleft	= (                     ( (arrayPageSize[0] -  width ) / 2 ) );

		objLockbox.style.top  = cltop  < 0 ? '0px' : cltop  + 'px';
		objLockbox.style.left = clleft < 0 ? '0px' : clleft + 'px';

		objOverlay.style.display = '';
		objLockbox.style.visibility = '';	 	
*/
	 	alert(htmlContent);
	 	
	}
