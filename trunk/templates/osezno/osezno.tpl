<html>
<head>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.titulo_pagina{
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	font-size:22px;
	font-style:normal;
	font-weight:bold;
	font-variant:normal;
	text-shadow:#666;
}
.desc_pagina{
	font-family:Arial, Helvetica, sans-serif;
	color:#009AE2;
	font-size:10px;
	font-style:normal;
}
-->
</style>
<meta charset="UTF-8">
</head>
<body background="../../templates/osezno/bg.jpg" onload="{on_load}">
<div align="center">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="5" align="right" background="../../templates/osezno/bg_left.gif">&nbsp;</td>
      <td width="780" bgcolor="#808080"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td background="../../templates/osezno/head.jpg" width="769" height="90">
          <table width="100%" height="86" border="0" cellpadding="0" cellspacing="0">
  			<tr>
    			<td>&nbsp;</td>
  			</tr>
  			<tr>
    			<td height="32" align="right" valign="bottom" class="titulo_pagina">{name}&nbsp;</td>
  			</tr>
  			<tr>
    			<td height="29" class="desc_pagina" align="right" valign="top">{desc}&nbsp;&nbsp;</td>
  			</tr>
		  </table>
		  </td>
        </tr>
        <tr>
          <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" bgcolor="#FFFFFF"><div align="center" name="main_area" id="main_area">{main_area}</div></td>
        </tr>
        <tr>
          <td align="center"><div name="alt_area" id="alt_area">{alt_area}</div></td>
        </tr>		
        <tr>
          <td><img src="../../templates/osezno/foot.jpg" width="770" height="20" /></td>
        </tr>
      </table></td>
      <td width="5" align="left" background="../../templates/osezno/bg_right.gif">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>