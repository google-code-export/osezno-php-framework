<html>
<head>
<style type="text/css">
.tit {
	font-size:14px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight: bold;
	text-align: justify;
}
.conte {
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.help_content {
	border-radius: 10px 10px 10px 10px;
	-moz-border-radius: 10px 10px 10px 10px;
    background-clip: border-box;
	background-color:#FFFFCC;
	font-style: normal;
	text-decoration: none;
	border-color:gray;
	border-width: 1px;
	border-style: solid;
	padding-left:10px;
	padding-top:1px;	
	padding-bottom:1px;
	padding-right:10px;
}
</style>
</head>
<body>
<div class="help_content">
<p><b><u>TIPOS DE UNI&Oacute;N L&Oacute;GICA:</u></b></p>
<p><b>Y:</b><span class="conte"> La uni&oacute;n l&oacute;gica Y (AND) trabaja uniendo dos o mas filtros cuando cuando las condiciones entre estos filtros se cumplan en cada una.</span></p>
<p><b>O:</b><span class="conte"> La uni&oacute;n l&oacute;gica O (OR) trabaja uniendo dos o mas filtros cuando las condiciones entre estos filtros se cumpla en al menos una de ellas.</span><br>
<p><b><u>TIPOS DE OPERADOR EN PARA UN FILTRO:</u></b></p>
<p><b>LIKE:</b><span class="conte"> El operador like trabaja exclusivamente con campos de tipo string (cadenas de texto) para encontrar coincidencias del texto a buscar en la columna a ser afectada. Es posible usar el comodin '%' para facilitar la busqueda. El comodin '%' trabaja de la siguiente forma: (%abc) Busca la coincidencia abc al final del campo, (abc%) Busca la coincidencia abc al comienzo del campo, (%abc%) Busca la coincidencia abc en cualquier parte del campo donde el campo hace referencia tambi&eacute;n a la columna afectada.</span></p>
<p><b>IN: </b><span class="conte"> El operador IN es un tipo de operador especial que permite buscar varios valores en un campo seleccionado. Este operador puede trabajar con campos tipo string (cadenas de texto) y tipos numeric (numericos). Para usarlo podemos hacerlo de la siguiente forma; por ejemplo buscar los registros que en determinada columna contengan los datos 1, 2, y 3; la forma correcta de hacerlo seria escribiendo 1,2,3 en el campo valor, de esa manera el filtro al ser aplicado buscaria los registros que en el campo seleccionado sean igual a 1 o a 2 o a 3.</span></p>
<p><b>&gt; MAYOR QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean mayor al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p><b>&gt;= MAYOR IGUAL QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean mayor o igual al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p><b>= IGUAL QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean iguales al valor escrito y  funciona con campos de tipo numeric (n&uacute;mericos) o tipo string (cadenas de texto)</span></p>
<p><b>&lt;&gt; DIFERENTE QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean diferentes al valor escrito y funciona con campos de tipo numeric (n&uacute;mericos) o tipo string (cadenas de texto)</span></p>
<p><b>&lt;= MENOR IGUAL QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean menor o igual al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p><b>&lt; MENOR QUE:</b><span class="conte"> Busca los registros que en el campo afectado sean menores al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p><b>NOT IN:</b><span class="conte"> Es la condici&oacute;n opuesta de IN.</span></p>
<p><b>NOT LIKE:</b><span class="conte"> Es la condici&oacute;n opuesta de LIKE.</span><br>
</p>
</div>
</body>
</html>