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


function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			return;
		}
		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(num_files_queued) {
	//alert('Se van a subir '+num_files_queued+' archivos');
	
	this.startUpload();

}

function uploadProgress(fileObj, bytesLoaded, bytesTotal) {
	try {
		
		var percent = Math.ceil((bytesLoaded / fileObj.size) * 100)
		
		if (percent === 100) {
		
		     document.getElementById("SWF_file_upload_progress").innerHTML = "100%";

  	            		
		} else {
		
		     document.getElementById("SWF_file_upload_progress").style.width = (percent*2)+"px";
		     document.getElementById("SWF_file_upload_progress").innerHTML = ""+percent+"%";
		     
		}
	} catch (ex) { this.debug(ex); }	
}

function uploadSuccess(file, serverData) {

	//alert('El archivo fue subido');

       var el = document.getElementById('SWF_file_upload');
	         var padre = el.parentNode;
         padre.removeChild(el);
	
	         var el = document.getElementById('SWF_file_upload_imagen');
	         var padre = el.parentNode;
         padre.removeChild(el); 
	
}

function uploadComplete(fileObj) {
	
	//alert('Se completo la subida del archivo');
	
}

function uploadError(fileObj, error_code, message) {

}

function swfuploadLoadedHandler (){
 
}

function fileDialogStart () {
	 
}

function fileQueued (file) {
	
	 var Tam = TamVentana();
	
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
	 miImagen.style.top    = '0';
	 miImagen.style.left   = '0';
	 miImagen.style.width	 = (Tam[0] + 'px');	 
	 miImagen.style.height = (Tam[1] + 'px');
	 miImagen.style.minHeight	= '100%';
	 miImagen.style.display='block';
	 
     miImagen.innerHTML = '<table border="0" width="100%" height="100%"><tr><td align="center" valign="middle"><img src="../../img/common/uploading.gif"><font face="arial" size="1" color="white"><div id="SWF_file_upload_progress_wraper" style="width:200px; background:#C0C0FF none repeat scroll 0% 0%; border: #000000 1px solid;" align="left"><div id="SWF_file_upload_progress" style="width:0px; background:#8080FF none repeat scroll 0% 0%;" align="left"></div></div></font></td></tr></table>';	
	
}

function uploadStart (file) {
	
	return true;
}

function uploadError (file, errorCode, message) {
	try {

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
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
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function debugHandler () {

}
