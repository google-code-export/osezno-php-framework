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
</style>
</head>
<body bgcolor="#FFFFCA" class="tit">
<p>Tipos de operador en un filtro:</p>
<p>LIKE:<span class="conte"> El operador like trabaja exclusivamente con campos de tipo string (cadenas de texto) para encontrar coincidencias del texto a buscar en la columna a ser afectada. Es posible usar el comodin '%' para facilitar la busqueda. El comodin '%' trabaja de la siguiente forma: (%abc) Busca la coincidencia abc al final del campo, (abc%) Busca la coincidencia abc al comienzo del campo, (%abc%) Busca la coincidencia abc en cualquier parte del campo donde el campo hace referencia tambien a la columna afectada.</span></p>
<p>IN: <span class="conte">El operador IN es un tipo de operador especial que permite buscar varios valores en un campo seleccionado. Este operador puede trabajar con campos tipo string (cadenas de texto) y tipos numeric (numericos). Para usarlo podemos hacerlo de la siguiente forma; por ejemplo buscar los registros que en determinada columna contengan los datos 1, 2, y 3; la forma correcta de hacerlo seria escribiendo 1,2,3 en el campo valor, de esa manera el filtro al ser aplicado buscaria los registros que en el campo seleccionado sean igual a 1 o a 2 o a 3.</span></p>
<p>&gt; MAYOR QUE:<span class="conte"> Busca los registros que en el campo afectado sean mayor al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p>&gt;= MAYOR IGUAL QUE: <span class="conte">Busca los registros que en el campo afectado sean mayor o igual al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p>= IGUAL QUE:<span class="conte"> Busca los registros que en el campo afectado sean iguales al valor escrito y  funciona con campos de tipo numeric (n&uacute;mericos) o tipo string (cadenas de texto)</span></p>
<p>&lt;&gt; DIFERENTE QUE: <span class="conte">Busca los registros que en el campo afectado sean diferentes al valor escrito y funciona con campos de tipo numeric (n&uacute;mericos) o tipo string (cadenas de texto)</span></p>
<p>&lt;= MENOR IGUAL QUE:<span class="conte"> Busca los registros que en el campo afectado sean menor o igual al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p>&lt; MENOR QUE: <span class="conte">Busca los registros que en el campo afectado sean menores al valor escrito y solo funciona con campos de tipo numeric (n&uacute;mericos)</span></p>
<p>NOT IN: <span class="conte">Es la condici&oacute;n opuesta de IN.</span></p>
<p>NOT LIKE:  <span class="conte">Es la condici&oacute;n opuesta de LIKE.</span><br>
</p>
</body>
</html>