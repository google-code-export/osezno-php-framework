<html>
<head>
<style type="text/css">
.divname{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 32px;
	font-style: normal;
	text-decoration: none;
	color: white;
    height: 35px;
    position:fixed;
    bottom:0px;
    margin:0 auto;
    color: #FFFFFF;
}
</style>
<style type="text/css">
/*--------------------------------------------------|
| dTree 2.05 | www.destroydrop.com/javascript/tree/ |
|---------------------------------------------------|
| Copyright (c) 2002-2003 Geir Landr�               |
|--------------------------------------------------*/

.dtree {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666;
	white-space: nowrap;
}
.dtree img {
	border: 0px;
	vertical-align: middle;
}
.dtree a {
	color: #333;
	text-decoration: none;
}
.dtree a.node, .dtree a.nodeSel {
	white-space: nowrap;
	padding: 1px 2px 1px 2px;
}
.dtree a.node:hover, .dtree a.nodeSel:hover {
	color: #333;
	text-decoration: underline;
}
.dtree a.nodeSel {
	background-color: #c0d2ec;
}
.dtree .clip {
	overflow: hidden;
}
</style>
<script type="text/javascript" src="{path_js_tree}common/js/essentials/dtree.js"></script>
<meta charset="UTF-8">
</head>
<body background="login/imagenes/bg.jpg">

<div class="dtree">
{user_login}
	<p><a href="javascript: d.openAll();">{open_all}</a> | <a href="javascript: d.closeAll();">{close_all}</a></p>

	<script type="text/javascript">
		<!--

		d = new dTree('d');
		d.add(0,-1,'{home_etq}');
		{menu_struct}

		document.write(d);

		//-->
	</script>

</div>
<div id="divname" class="divname">{essentials}</div>
</body>
</html>