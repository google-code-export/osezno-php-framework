<html>
<head>
<script type="text/javascript">

function onChangeTable (datForm, combo){

	if (datForm[combo] == 'other'){

		selectOtherTable(datForm, combo);
	}
	
}

function posicionarTittle (){

	var arrayPageSize = new Array();

	arrayPageSize = getPageSize();

	document.getElementById('img_mod').style.left = arrayPageSize[0]-67;

	document.getElementById('titulo_modulo_div1').style.left = arrayPageSize[0]-670;
	
	document.getElementById('titulo_modulo_div2').style.left = arrayPageSize[0]-670;
}

var valsAnchos = new Array();

function updateValsAnchos (){
	
	for (i=0; i<document.forms['formNewScaffStep4'].elements.length; i++){

		if (document.forms['formNewScaffStep4'].elements[i].name.substring(0,6)=='width_'){
			
			if (!document.forms['formNewScaffStep4'].elements[i].value)
			
				valsAnchos[document.forms['formNewScaffStep4'].elements[i].name] = 0;
			else
				valsAnchos[document.forms['formNewScaffStep4'].elements[i].name] = parseInt(document.forms['formNewScaffStep4'].elements[i].value);
		}
	}
	
	
}

function updateWidthListT (datForm, idText, idCheck){

	if (parseInt(datForm[idText]) >= 0){
	
		if (datForm[idCheck]){
		
			if (valsAnchos[idText]){
			
				varRest = parseInt(valsAnchos[idText]);

			}else{
			
				varRest = 0;
			}
				
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) - varRest;
		
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) + parseInt(datForm[idText]);
			
			valsAnchos[idText] = parseInt(datForm[idText]); 
		}
		  
	}else{
	
		document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) - valsAnchos[idText];
		
		valsAnchos[idText] = 0;
	
	}	
	  	
}

function updateWidthListT2 (datForm, idCheck, idText, idEtq){

	if (datForm[idCheck]){

		document.forms['formNewScaffStep4'].elements[idText].disabled = false;
		
		document.forms['formNewScaffStep4'].elements[idEtq].disabled = false;
			
		if (parseInt(datForm[idText]) >= 0){
	
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) + parseInt(datForm[idText]);
			
			valsAnchos[idText] = parseInt(datForm[idText]);
			 
		}else{
			
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) - valsAnchos[idText];
		
			valsAnchos[idText] = 0;
		
		}
		
	}else{
	
		document.forms['formNewScaffStep4'].elements[idText].disabled = true;
		
		document.forms['formNewScaffStep4'].elements[idEtq].disabled = true;
	
		if (parseInt(datForm[idText]) >= 0){
	
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) - parseInt(valsAnchos[idText]);
			
			valsAnchos[idText] = parseInt(datForm[idText]);
			
		}else{
			
			document.forms['formNewScaffStep4'].elements['ancho_total'].value = parseInt(document.forms['formNewScaffStep4'].elements['ancho_total'].value) - valsAnchos[idText];
		
			valsAnchos[idText] = 0;
		
		}
		
	}

}

function valOptDelete (datForm){

	if (!datForm['eliminar']){
	
		document.forms['formNewScaffStep4'].elements['eliminar_mul'].checked = false;
		
		document.forms['formNewScaffStep4'].elements['eliminar_mul'].disabled = true;
		
	}else{
	
		document.forms['formNewScaffStep4'].elements['eliminar_mul'].disabled = false;
	}
	
}

function checkFormItem (datForm, idCheck, idReq, idEtq, idType){

	if (datForm[idCheck]){
	
		document.forms['formNewScaffStep2'].elements[idReq].disabled = false;
		
		document.forms['formNewScaffStep2'].elements[idEtq].disabled = false;
		
		document.forms['formNewScaffStep2'].elements[idType].disabled = false;
		
	}else{
	
		document.forms['formNewScaffStep2'].elements[idReq].disabled = true;
		
		document.forms['formNewScaffStep2'].elements[idReq].checked = false;
		
		document.forms['formNewScaffStep2'].elements[idEtq].disabled = true;
		
		document.forms['formNewScaffStep2'].elements[idType].disabled = true;
	}
	
}

</script>
<style type="text/css">

.titulo_modulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: normal;
	text-decoration: none;
	text-align:right;
	color: #3366CC;
	font-weight:bold;
}

.desc_modulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-decoration: none;
	text-align:right;
	color: #666666;
}

</style>

{javascript}

<meta http-equiv="content-type" content="text/html"/>
<meta charset="UTF-8"> 
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body onload="posicionarTittle(){onload}">
<div id="img_mod" style="z-index:0;top:2;position:absolute;width:50;"><img src="{BASE_URL_PATH}resources/templates/modulo/imagenes/huellita.jpg"></div>
<div id="titulo_modulo_div1" style="z-index:2;top:5;position:absolute;width:600;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td class="titulo_modulo">{nom_modulo}</td></tr>
</table>
</div>
<div id="titulo_modulo_div2" style="z-index:1;top:20;position:absolute;width:600;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td class="desc_modulo">{desc_modulo}</td></tr>
</table>
</div>
<br><br><div align="center" id="content1">{content1}</div>
<div align="center" id="content2">{content2}</div>
</body>
</html>
