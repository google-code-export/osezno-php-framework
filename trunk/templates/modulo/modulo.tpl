<html lang="en">
<head>
<script type="text/javascript">

function posicionarTittle (){

	var arrayPageSize = new Array();

	arrayPageSize = getPageSize();

	document.getElementById('img_mod').style.left = arrayPageSize[0]-67;

	document.getElementById('titulo_modulo_div1').style.left = arrayPageSize[0]-670;
	
	document.getElementById('titulo_modulo_div2').style.left = arrayPageSize[0]-670;
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
<style type='text/css'>

select#icon option
{
    background-repeat: no-repeat;
    padding-left: 21px;
    height: 18px;
}

option#cd
{
    background-image: url(img/cd.gif);
    
}

option#imgfolder
{
    background-image: url(img/imgfolder.gif);
}

option#globe
{
    background-image: url(img/globe.gif);
}

option#musicfolder
{
    background-image: url(img/musicfolder.gif);
}

option#page
{
    background-image: url(img/page.gif);
}

option#question
{
    background-image: url(img/question.gif);
}

option#trash
{
    background-image: url(img/trash.gif);
}

option#osezno
{
    background-image: url(img/base.gif);
}

</style>

{javascript}

<meta http-equiv="content-type" content="text/html" />
<meta charset="UTF-8">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
</head>
<body onload="posicionarTittle(){onload}">
<div id="img_mod" style="z-index:0;top:2;position:absolute;width:50;"><img src="../../templates/modulo/imagenes/huellita.jpg"></div>
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
