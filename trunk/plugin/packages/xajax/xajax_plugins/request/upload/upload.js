/*
	File: upload.js
	
	Title: upload progressbar plugin for xajax
	
*/

/*
	@package uploadProgress plugin
	@version $Id: 
	@copyright Copyright (c) 2007 by Steffen Konerow (IE)
	@license http://www.xajaxproject.org/bsd_license.txt BSD License
*/

/*
	Class: xajax.ext.uploadProgress
	
	This class contains all functions for using uploading files with xajax.
	
*/

	try 
	{
		if (undefined == xajax.ext)
			xajax.ext = {};
	} catch (e) 
	{
		alert("Could not create xajax.ext namespace");
	}

	try 
	{
		if (undefined == xajax.ext.uploadProgress)
			xajax.ext.uploadProgress = {};
	} catch (e) 
	{
		alert("Could not create xajax.ext.comet namespace");
	}

	// create Shorthand for xajax.ext.comet
	xjxUp = xajax.ext.uploadProgress;

	xjxUp.config={};
	xjxUp.iframes={};
	xjxUp.inputs={};


	xjxUp.uploads={};
	
	
	xjxUp.configure = function(sName,mValue) 
	{
		xjxUp.config[sName]=mValue;
	}

	xjxUp.getConf = function(sName) 
	{
		return xjxUp.config[sName]=mValue;
	}

	
	xjxUp.processUpload = function(formID,sMethod,oParams) 
	{
		switch (xjxUp.config.UploadProgressType) 
		{
			case "APC" : oRequest = new xjxUp.APC();break;
			case "PHP" : oRequest = new xjxUp.PHP();break;
			case "LIGHTTPD" : oRequest = new xjxUp.LIGHTY();break;
			default: alert("XAJAX.EXT.UPLOADPROGRESS: No upload type defined");return;break;
		}
		var oForm = xajax.$(formID);
		var pid = this.tools.getPid();
		
		var i = 0;
		for (a in xjxUp.uploads) i++;		
		
		if (1 <= i || "undefined" != typeof xjxUp.uploads[pid]) return;
		
		oRequest.prepareRequest(oForm,pid,sMethod);
		oRequest.send(pid,oParams);
		xjxUp.uploads[pid]=oRequest;
		if ("function" == typeof xjxUp.onRequest) xjxUp.onRequest();
		return false;
	}




	/* -----------------------------------------------------------------------------------
	tools & helper functions
	
	----------------------------------------------------------------------------------- */

	xjxUp.tools={};
	
	xjxUp.tools.manageResponse = function(pid,response) {

		
		var xx = xajax;
		var xt = xx.tools;
		var xcb = xx.callback;
		var gcb = xcb.global;
		if (response) {
			var cmd = (new DOMParser()).parseFromString(response, "text/xml");
			var seq=0;
			var child = cmd.documentElement.firstChild;
			xt.xml.processFragment(child, seq, oRequest);
			if (null == xx.response.timeout)
				xt.queue.process(xx.response);
		
		}
		xjxUp.uploads[pid].completeRequest();
		if ("function" == typeof xjxUp.onComplete) xjxUp.onComplete();
	}
	
	xjxUp.tools.getPid = function() 
	{
		var pid_str = "";
		for (i=0;i<=3;i++) {
			var pid = 0;
			pid = Math.random();
			while( Math.ceil(pid).toString().length<8) 
			{
				pid *= 10;
			}
			pid = Math.ceil(pid).toString();		
			pid_str = pid_str+pid.toString();
		}
		return pid_str;
	}
	
	xjxUp.tools.createIframe = function(pid,oForm) 
	{

		var sTarget = xjxUp.config.UploadProgressTarget+pid;
		var iframe = document.createElement("iframe");
		iframe.setAttribute("id",sTarget);
		iframe.setAttribute("name",sTarget);
		iframe.setAttribute("width","0");
		iframe.setAttribute("height","0");
		iframe.setAttribute("border","0");
		iframe.setAttribute("style","width: 0; height: 0; border: none;");
		oForm.appendChild(iframe);
		// IE fix
		window.frames[sTarget].name=sTarget; 

		return iframe;
	}
	
	xjxUp.tools.formatBytes = function(bytes) 
	{

		var ret = {};
		if (bytes / 1204  < 1024) {
		    return (Math.round(bytes / 1024 * 100)/100).toString()+ " KB";
		} else {
		    return (Math.round(bytes / 1024 / 1024 * 100)/100).toString()+ " MB";
		}
		return ret;		
	}

	xjxUp.tools.showProgress = function(upload) 
	{

		var elapsed = upload.now-upload.start;
		var bar = xajax.$('xjxExtUpBar');
		var barTxt = xajax.$('xjxExtUpBarTxt');
		var rateEl = xajax.$('xjxExtUpRate');


		switch (upload.state) 
		{
			case 'fake' :
				xajax.$('xjxExtUpBytes').innerHTML = 'uploading';
				w = 192 *  upload.percent / 100;
				bar.style.width = w + 'px';
				barTxt.innerHTML = 'upload in progress';	
			break;
			
			case 'uploading':

				if (0 > elapsed) elapsed = 0;
				step = upload.received / (upload.size / 100);
				var rate = 0;
				if (null != upload.lastbytes && 0 < upload.received) 
				{
					rate = xjxUp.tools.formatBytes(upload.received/ elapsed).toString() + '/s';
					xajax.$('xjxExtUpBytes').innerHTML = xjxUp.tools.formatBytes(upload.received) + "/" + xjxUp.tools.formatBytes(upload.size);
				}
				rateEl.innerHTML = rate;
			
				w = 192 * upload.received / upload.size;
				bar.style.width = w + 'px';
				barTxt.innerHTML = Math.round(step) + '%';
			
			break;

			case 'starting':
				bar.style.width = '1px';
				barTxt.innerHTML = '0%';
			  xajax.$('xjxExtUpBytes').innerHTML = 'Starting';
			break;			

			case 'done':
			
				bar.style.width = 192 + 'px';
				barTxt.innerHTML = '100%';
			  xajax.$('xjxExtUpBytes').innerHTML = 'Done';
			
			break;
			
			case '413':
				xajax.$('xjxExtUpBytes').innerHTML = 'Error, file too big';
			break;
		}
		
	}

	xjxUp.transform = function(file_target, max )
	{
	
		/*
			create markup automatically
			remove list_target 
			list_target = xajax.$('xjxExtUpFiles' ),
		
		*/
	
		var new_btn = document.createElement('div');
		new_btn.className = 'xjxExtUpfakefile';

		var image = document.createElement('img');
		image.src='/upload/img/browse.gif';
		
		new_btn.appendChild(image);
		var new_list = document.createElement('div');

		file_target.parentNode.appendChild(new_list);
		list_target = new_list;

		var clone = new_btn.cloneNode(true);
		file_target.parentNode.appendChild(clone);
	
		file_target.parentNode.style.position='relative';
		file_target.parentNode.style.width='300px';
		file_target.parentNode.style.height='30px';
	
		this.list_target = list_target;
		this.count = 0;
		this.name = file_target.name;
		this.id = 0;
		if( max )
		{
			this.max = max;
		} 
		else 
		{
			this.max = -1;
		};
		
		this.addElement = function( element )
		{
	
			if( element.tagName == 'INPUT' && element.type == 'file' )
			{
				if (1 != this.max) 
				{
					element.name = this.name +"[]";
					this.id++;
				} else {
					element.name = this.name;
				}
				element.multi_selector = this;
				element.className = 'file hidden';
				element.onchange = function()
				{
					var new_element = document.createElement( 'input' );
					new_element.type = 'file';
					this.parentNode.insertBefore( new_element, this );
					this.multi_selector.addElement( new_element );
					this.multi_selector.addListRow( this );
					this.style.position = 'absolute';
					this.style.left = '-1000px';
	
				};
				if( this.max != -1 && this.count >= this.max )
				{
					element.disabled = true;
				};
				this.count++;
				this.current_element = element;
			} 
			else 
			{
				alert( 'Error: not a file input element' );
			};
		};
	
		this.addListRow = function( element )
		{
			var new_row = document.createElement( 'div' );
			new_row.className="xjxExtUpRow";	
			var new_row_button = document.createElement( 'input' );
			new_row_button.type = 'button';
			new_row_button.className = 'xjxExtUpDelete';
			new_row.element = element;
			new_row_button.onclick= function()
			{
				this.parentNode.element.parentNode.removeChild( this.parentNode.element );
				this.parentNode.parentNode.removeChild( this.parentNode );
				this.parentNode.element.multi_selector.count--;
				this.parentNode.element.multi_selector.current_element.disabled = false;
				return false;
			};
			var new_row_clear = document.createElement( 'div' );
			new_row_clear.className="xjxExtUpClear";
			var new_row_txt = document.createElement( 'div' );
			new_row_txt.innerHTML = this.elipse(element.value);
			new_row_txt.className="xjxExtUpLabelFile";
			new_row.appendChild( new_row_txt );
			new_row.appendChild( new_row_button );
			new_row.appendChild( new_row_clear );
			this.list_target.appendChild( new_row );
		};
	
		this.elipse = function(str) 
		{
		 if ( 30 > str.length ) return str;
		 return '...'+str.substring(str.length-30,str.length,str);
		}
	
		this.addElement(file_target);
	
	};


	/* -----------------------------------------------------------------------------------
	APC UPLOAD
	
	----------------------------------------------------------------------------------- */
	
	xjxUp.APC = function(pid,oForm,sMethod) 
	{
		this.checkState=null;
		this.lastbytes=0;
		
		this.prepareRequest = function(oForm,pid,sMethod) 
		{

			this.pid = pid;
			this.oForm = oForm;
			var first = oForm.firstChild;

			xajax.forms.insertInput(first,"hidden","APC_UPLOAD_PROGRESS","APC_UPLOAD_PROGRESS");
			var upID = xajax.$("APC_UPLOAD_PROGRESS");
			upID.name="APC_UPLOAD_PROGRESS";
			upID.value=pid;
			this.InputField =upID;

			xajax.forms.insertInput(first,"hidden","xjxExtUP","xjxExtUP");
			var upMethod = xajax.$("xjxExtUP");
			upMethod.name="xjxExtUP";
			upMethod.value=sMethod;
			


			this.iFrame = xjxUp.tools.createIframe(this.pid,this.oForm);
			oForm.target = this.iFrame.id;
			
		}

		this.request = function() 
		{
			if ( null != this.checkState) 
			{
				window.clearTimeout(this.checkState);
				this.checkState=null;
			}
			xajax.request({xjxExtUP:'getProgress'},{parameters:[this.pid],context:this});
		}
		
		this.processResponse = function(upload) 
		{

			var reqTime = new Date();

			upload.lastbytes = this.lastbytes;
			upload.now = reqTime.getTime() / 1000;
			upload.start = this.startTime.getTime()/ 1000;
			
			xjxUp.tools.showProgress(upload);
	    this.lastbytes = upload.received;
			if ( null == this.checkState) 
			{
				var tmp = this;
		    this.checkState = window.setInterval(
				  function () {
						tmp.request();
				   },
					xjxUp.config.UploadProgressDelay
			  );						
			}

		}
		
		this.send = function() 
		{
			this.request();
			this.startTime = new Date();
			this.oForm.submit();
		}
	
		this.done = function(upload) 
		{
			upload.lastbytes = this.lastbytes;
			xjxUp.tools.showProgress(upload);
		}
	
		this.completeRequest = function() {

			delete(xjxUp.uploads[this.pid]);
			xajax.dom.remove(this.InputField);
			xajax.dom.remove(this.iFrame );
			
		}
	}
	/* -----------------------------------------------------------------------------------
	PHP UPLOAD (no progress)
	
	----------------------------------------------------------------------------------- */
	
	xjxUp.PHP = function(pid,oForm) 
	{
		this.checkState=null;
		this.percent=0;
		
		this.prepareRequest = function(oForm,pid,sMethod) 
		{

			this.pid = pid;
			this.oForm = oForm;
			var first = oForm.firstChild;

			xajax.forms.insertInput(first,"hidden","APC_UPLOAD_PROGRESS","APC_UPLOAD_PROGRESS");
			var upID = xajax.$("APC_UPLOAD_PROGRESS");
			upID.name="APC_UPLOAD_PROGRESS";
			upID.value=pid;
			this.InputField =upID;

			xajax.forms.insertInput(first,"hidden","xjxExtUP","xjxExtUP");
			var upMethod = xajax.$("xjxExtUP");
			upMethod.name="xjxExtUP";
			upMethod.value=sMethod;

			this.iFrame = xjxUp.tools.createIframe(this.pid,this.oForm);
			oForm.target = this.iFrame.id;
			
		}

		this.request = function() 
		{
			if ( null != this.checkState) 
			{
				window.clearTimeout(this.checkState);
				this.checkState=null;
			}
			this.processResponse();
			//xajax.request({xjxExtUP:'getProgress'},{parameters:[this.pid],context:this});
		}
		
		this.processResponse = function() 
		{
			var reqTime = new Date();

			this.percent += 10;
			if (100 < this.percent) this.percent=0;
			upload = {};
			upload.state='fake';
			upload.percent=this.percent;
			
			xjxUp.tools.showProgress(upload);
			if ( null == this.checkState) 
			{
				var tmp = this;
		    this.checkState = window.setInterval(
				  function () {
						tmp.request();
				   },
					xjxUp.config.UploadProgressDelay
			  );						
			}

		}
		
		this.send = function() 
		{
			this.startTime = new Date();
			this.request();
			this.oForm.submit();
		}
	
		this.done = function() 
		{
			upload={state:'done'};
			upload.lastbytes = this.lastbytes;
			xjxUp.tools.showProgress(upload);
		}
	
		this.completeRequest = function() {

			delete(xjxUp.uploads[this.pid]);
			xajax.dom.remove(this.InputField);
			xajax.dom.remove(this.iFrame );
			this.done();

			if ( null != this.checkState) 
			{
				window.clearTimeout(this.checkState);
				this.checkState=null;
			}

			
		}
	}
	/* -----------------------------------------------------------------------------------
	LIGHTTPD UPLOAD
	
	----------------------------------------------------------------------------------- */

	xjxUp.LIGHTY = function(pid,oForm) 
	{	
		
		this.pid = pid;
		this.oForm = oForm;
		this.interval = null;
		this.checktimeout = null;
		this.lastbytes=1;
		this.showparenttimeout = null;
 		
 		this.checkState = null;


		this.prepareRequest = function(oForm,pid,sMethod) 
		{
			this.oForm=oForm;
			this.pid =pid;
			var first = oForm.firstChild;
			
			xajax.forms.insertInput(first,"hidden","APC_UPLOAD_PROGRESS","APC_UPLOAD_PROGRESS");
			var upID = xajax.$("APC_UPLOAD_PROGRESS");
			upID.name="APC_UPLOAD_PROGRESS";
			upID.value=pid;
			this.InputField =upID;

			this.iFrame = xjxUp.tools.createIframe(this.pid,this.oForm);
			this.oForm.target = this.iFrame.id;
			this.oForm.action ="upload.php?X-Progress-ID="+this.pid;

			xajax.forms.insertInput(first,"hidden","xjxExtUP","xjxExtUP");
			var upMethod = xajax.$("xjxExtUP");
			upMethod.name="xjxExtUP";
			upMethod.value=sMethod;

		}


		
		this.request= function() {
			xajax.request({xjExtUP:'getProgress'},{URI:"/progress", parameters: [], responseProcessor: this.processResponse, method:'GET', getHeaders:{'X-Progress-ID':this.pid,'X-Requested-With':'XMLHttpRequest'},context:this } );
		}		
		
		this.send = function() 
		{
			if ( null == this.checkState) 
			{
				var tmp = this;
		    this.checkState = window.setInterval(
				  function () {
						tmp.request();
				   },
					xjxUp.config.UploadProgressDelay
			  );				
				this.request();
			}
			this.startTime = new Date();
			this.oForm.submit();
		}	
		/*
				lighttpd process
				JSON
				
				The returned json may contain:
				state:
				    current state of upload values = starting, error, done, uploading
				status:
				    http error status values = 413
				size:
				    size of request
				received:
				    bytes received by lighttpd yet 	
		
		*/
		this.processResponse = function (objResponse, objOptions) 
		{
			var reqTime = new Date();
			var ref = objResponse.context;
	    var upload = eval(objResponse.request.responseText);

	    if (upload.state == 'done' || upload.status == '413') {
				window.clearTimeout(ref.checkState);
			}
			
			upload.lastbytes = ref.lastbytes;
			
			upload.now = reqTime.getTime() / 1000;
			upload.start = ref.startTime.getTime()/ 1000;
			
			xjxUp.tools.showProgress(upload);
	    ref.lastbytes = upload.received;
			xajax.completeResponse(objResponse);
		}
		
		this.completeRequest = function() {
			delete(xjxUp.uploads[this.pid]);
			xajax.dom.remove(this.InputField);
			xajax.dom.remove(this.iFrame );
		}
		
	}
	
	/*

	Function: DOMParser
	
	Prototype DomParser for IE/Opera

*/
if (typeof DOMParser == "undefined") {
   DOMParser = function () {}

   DOMParser.prototype.parseFromString = function (str, contentType) {
      if (typeof ActiveXObject != "undefined") {
         	var d = new ActiveXObject("Microsoft.XMLDOM");
         	d.loadXML(str);
         return d;
      } else if (typeof XMLHttpRequest != "undefined") {
         var req = new XMLHttpRequest;
         req.open("GET", "data:" + (contentType || "application/xml") +
                         ";charset=utf-8," + encodeURIComponent(str), false);
         if (req.overrideMimeType) {
            req.overrideMimeType(contentType);
         }
         req.send(null);
         return req.responseXML;
      }
   }
}