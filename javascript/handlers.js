/**
 * notificationWindowFiles
 */
var archUp = 0;
var archSel = 0;

var nc = (document.layers) ? true:false
var ie = (document.all) ? true:false
var n6 = (document.getElementById) ? true:false
var posicion;
var nueva_posicion;
var aux=1;
var tam;
var absol;
 
function TamVentanaFunc() {
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


function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			return;
		}
		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		default:
			if (file !== null) {
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		}
		
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		
		archSel = numFilesQueued;
		if (numFilesQueued){
			//alert("Se seleccionaron "+numFilesSelected+" y hay "+numFilesQueued+" en cola");		
			var Tam = TamVentanaFunc();
			
			var miCapa = document.createElement('DIV');
			miCapa.id = 'SWF_file_upload';
	     
			document.body.appendChild(miCapa);
	     
			miCapa.style.color = '#FFFFFF';
			miCapa.style.backgroundColor = '#000000';
			miCapa.style.position = 'absolute';
			miCapa.style.zIndex = 5000;
			miCapa.style.top    = '0';
			miCapa.style.left   = '0';
			miCapa.style.width	 = (Tam[0] + 'px');	 
			miCapa.style.height = (Tam[1] + 'px');
			miCapa.style.minHeight	= '100%';
			miCapa.style.display='block';
		 
			if (navigator.appVersion.indexOf("MSIE")!=-1){
				miCapa.style.filter = "alpha(opacity=" + 10 + ")";
			}else{
				miCapa.style.opacity = ( 10 / 100 );
			}
		 
			var miImagen = document.createElement('DIV');
			miImagen.id = 'SWF_file_upload_imagen';
			document.body.appendChild(miImagen);
			miImagen.style.position = 'absolute';
			miImagen.style.zIndex = 5001;
			miImagen.style.height	= '50px';
			miImagen.style.width	= '400px';
			miImagen.style.display='block';
			miImagen.style.top  = Math.max(((Tam[1] - 50) / 2),0) + 'px';
			miImagen.style.left = Math.max(((Tam[0] - 400) / 2),0) + 'px';		 
		 
			miImagen.innerHTML = 
	    	 '<div id="SWF_file_upload_progress_wraper" style="width:400px;heigth:50px; background:#C0C0FF none repeat scroll 0% 0%; border: #000000 1px solid;" align="left">'+
	    	 '<div id="SWF_file_upload_progress" style="width:0px;heigth:50px; background:#8080FF none repeat scroll 0% 0%;" align="left">&nbsp;</div></div>';
	    	 
	     
			var miCapaProgress = document.createElement('DIV');
			miCapaProgress.id = 'SWF_file_upload_progress_percent';
			document.body.appendChild(miCapaProgress);
			miCapaProgress.style.position = 'absolute';
			miCapaProgress.style.zIndex = 5002;
			miCapaProgress.style.height	= '50px';
			miCapaProgress.style.width	= '400px';
			miCapaProgress.style.display='block';
			miCapaProgress.style.top  = Math.max(((Tam[1] - 50) / 2),0) + 'px';
			miCapaProgress.style.left = Math.max(((Tam[0] - 400) / 2),0) + 'px';
	     
			miCapaProgress.innerHTML = '<font face="arial" size="2" color="white"><div id="SWF_file_upload_progress_percent_content" style="width:100%" align="center"></div></font>';
		
			/* I want auto start the upload and I can do that here */
			this.startUpload();
			}
		
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadProgress(fileObj, bytesLoaded, bytesTotal) {
	try {
		
		var percent = Math.ceil((bytesLoaded / fileObj.size) * 100)
		
		if (percent === 100) {
		
		     document.getElementById("SWF_file_upload_progress_percent_content").innerHTML = (archUp+1)+" de "+archSel+" "+fileObj.name+" (100%)";

  	            		
		} else {
		
		     document.getElementById("SWF_file_upload_progress").style.width = (percent*4)+"px";
		     document.getElementById("SWF_file_upload_progress_percent_content").innerHTML = (archUp+1)+" de "+archSel+" "+fileObj.name+" ("+percent+"%)";
		     
		}
		
	} catch (ex) { this.debug(ex); }	
}

function uploadSuccess(file, serverData) {

    document.getElementById("SWF_file_upload_progress").style.width = "0px";
    document.getElementById("SWF_file_upload_progress_percent_content").innerHTML = (archUp+1)+" de "+archSel+" "+file.name+" (0%)";

}

function uploadComplete(file) {
	
	archUp++;
	
	if (archUp==archSel){
		
		clearDiv ();
		
       archUp = 0;
	}
	
	this.startUpload();
}


function swfuploadLoadedHandler (){
}

function fileDialogStart () {
}

function fileQueued (file) {
}

function uploadStart (file) {
}


function clearDiv (){
    var el = document.getElementById('SWF_file_upload');
    var padre = el.parentNode;
    padre.removeChild(el);

    var el = document.getElementById('SWF_file_upload_imagen');
    var padre = el.parentNode;
    padre.removeChild(el); 

	var el = document.getElementById('SWF_file_upload_progress_percent');
	var padre = el.parentNode;
	padre.removeChild(el); 
}

function uploadError (file, errorCode, message) {
	try {

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			createNotificationWindow("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			createNotificationWindow("Error Code: IO Error, File name: " + file.name + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			createNotificationWindow("Error Code: Security Error, File name: " + file.name + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			break;
		default:
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			createNotificationWindow("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message,5000,"error");
			break;
		}
		
	} catch (ex) {
        this.debug(ex);
    }
}

function debugHandler () {

}
