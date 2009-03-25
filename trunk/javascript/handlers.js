
function fileQueueError(fileObj, error_code, message) {
	try {
		var error_name = "";
		switch(error_code) {
			case SWFUpload.ERROR_CODE_QUEUE_LIMIT_EXCEEDED:
				alert('Usted excedio el numero maximo de archivos de Lista por Subida. Seleccione 10 o menos archivos');
			break;
		}

		if (error_name !== "") {
			alert("Error 2:"+error_name);
			return;
		}

		switch(error_code) {
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				alert('El archivo "'+fileObj.name+'" es un archivo vacio y no sera subido.');
			break;
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				alert('El archivo "'+fileObj.name+'" es un archivo muy grande y no sera subido.');
			break;
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
	            alert('El archivo "'+fileObj.name+'" es un tipo de archivo no valido y no sera subido.');			
			break;
			default:
				alert('Usted selecciono mas de 10 Archivos por subida. Debe seleccionar Una cantidad menor o igual a 10');
			break;
		}
	} catch (ex) { this.debug(ex); }

}

function fileDialogComplete(num_files_queued) {
	try {
	
		if (num_files_queued > 0) {
			this.startUpload();
		}
		
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadProgress(fileObj, bytesLoaded) {

	try {
		
		var percent = Math.ceil((bytesLoaded / fileObj.size) * 100)
		
		if (percent === 100) {
		
		     document.getElementById("SWF_file_upload_progress").innerHTML = "100%";

   	         var el = document.getElementById('SWF_file_upload');
   	         var padre = el.parentNode;
  	         padre.removeChild(el);
    	
   	         var el = document.getElementById('SWF_file_upload_imagen');
   	         var padre = el.parentNode;
  	         padre.removeChild(el); 
  	            		
		} else {
		
		     document.getElementById("SWF_file_upload_progress").style.width = (percent*2)+"px";
		     document.getElementById("SWF_file_upload_progress").innerHTML = ""+percent+"%";
		     
		}
	} catch (ex) { this.debug(ex); }
	
}

function uploadSuccess(fileObj, server_data) {

	try {
        		
	} catch (ex) { this.debug(ex); }
	
	
}

function uploadComplete(fileObj) {
	
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued > 0) {
		
			this.startUpload();
		} else {
		}
	} catch (ex) { this.debug(ex); }
	
}

function uploadError(fileObj, error_code, message) {
	var image_name =  "error.gif";
	try {
		switch(error_code) {
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				try {
					
				}
				catch (ex) { this.debug(ex); }
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				image_name = "uploadlimit.gif";
			break;
			default:
				alert("Error 4:"+message);
			break;
		}

		

	} catch (ex) { this.debug(ex); }

}

function swfuploadLoadedHandler (){
 
}

function fileDialogStart () {
	 
}

function fileQueued () {

 	 var arrayPageSize	= xjxmW.getPageSize();
 	
     var miCapa = document.createElement('DIV');
     miCapa.id = 'SWF_file_upload';
     
     document.body.appendChild(miCapa);
     
     miCapa.style.color = '#FFFFFF';
     miCapa.style.backgroundColor = '#000000';
     miCapa.style.position = 'absolute';
     
	 miCapa.style.zIndex = 5000;
	 miCapa.style.top    = '0';
	 miCapa.style.left   = '0';
	 miCapa.style.width	 = (arrayPageSize[0] + 'px');	 
	 miCapa.style.height = (arrayPageSize[1] + 'px');
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
	 miImagen.style.width	 = (arrayPageSize[2] + 'px');	 
	 miImagen.style.height = (arrayPageSize[3] + 'px');
	 miImagen.style.minHeight	= '100%';
	 miImagen.style.display='block';
	 
     miImagen.innerHTML = '<table border="0" width="100%" height="100%"><tr><td align="center" valign="middle"><img src="../../img/common/uploading.gif"><font face="arial" size="1" color="white"><div id="SWF_file_upload_progress_wraper" style="width:200px; background:#C0C0FF none repeat scroll 0% 0%; border: #000000 1px solid;" align="left"><div id="SWF_file_upload_progress" style="width:0px; background:#8080FF none repeat scroll 0% 0%;" align="left"></div></div></font></td></tr></table>';
}

function uploadStart () {
	
}

function uploadError () {

}

function debugHandler () {

}
