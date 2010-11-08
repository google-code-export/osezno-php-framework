@CHARSET "ISO-8859-1";

/**
 * Contenido del formulario
 **/
.form_cont {
	background-color:#BBCEF7;
	font-style: normal;
	text-decoration: none;
	border-color:#4A7EEA;
	border-width: 1px;
	border-style: solid;
	padding-left:1px;
	padding-top:1px;	
	padding-bottom:1px;
	padding-right:1px;
}

/**
 * Etiquetas de campo formulario de filtro
 **/
.etiqueta_filtro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	text-align: center;
	vertical-align: middle;
	font-weight: bold;
}

/**
 * Rule Apply
 */
.rule_apply {
	background-image: url('<?php echo $_GET['path_img']; ?>ok.gif');
	height: 15px;
	width: 15px;
	position:static;
	margin:0px;
	background-repeat: no-repeat;
}

/**
 * Rule Cancel
 */
.rule_cancel {
	background-image: url('<?php echo $_GET['path_img']; ?>cancel.gif');
	height: 15px;
	width: 15px;
	position:static;
	margin:0px;
	background-repeat: no-repeat;
}

th, td {
    overflow: hidden;
    word-wrap: normal;
    height: 20px;
}

/** Color de borde de la lista **/
.list {
	background-color:#D3E0FA;
}

a {
	font-size: 10px;
	color:#5F8CEA;
	text-decoration: none;
}
a:hover {
	font-size: 10px;
	color:#EA5F5F;
	text-decoration: none;
}

/** Filas por defecto **/
.td_default {
	background-color:#FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-decoration: none;
	text-align:center;
}

/** Fila del medio **/
.td_middle {
	background-color:#E7F4FE;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-decoration: none;
	text-align:center;
}

/** Fila seleccionada **/
.td_mark {
	background-image: url('<?php echo $_GET['path_img']; ?>cell_over.gif');
	background-color:#99ACDF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	text-align:center;
	font-weight: bold;
}

/** Fila sobre **/
.td_over {
	background-image: url('<?php echo $_GET['path_img']; ?>cell_selected.gif');
	background-color: #FFD07F;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-decoration: none;
	text-align:center;
}

/** Contenido de una celda **/
.cell_content {
	font-family: Arial, Helvetica, sans-serif;
	font-style: normal;
	text-decoration: none;
	text-align:center;
}

/** Contenido de una celda cuando es ordenada **/
.cell_content_selected {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style:italic;
	text-decoration: none;
	text-align:center;
	background-color: #ECFBFF;
}

/** Celda del titulo de la columna cuando es ordenada **/
.cell_title_selected {
	background-image: url('<?php echo $_GET['path_img']; ?>col_selected.gif');
	text-align:center;
}

/** Celda del titulo de la columna **/
.cell_title {
	background-image: url('<?php echo $_GET['path_img']; ?>col_default.gif');
	text-align:center;
}

/** Numero de ref del orden de las columnas **/
.num_ord_ref {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	font-style:italic;
	text-decoration: none;
	text-align:center;
	font-weight: bold;
	color: blue;
}

/** Contenido de la titulo de la columna **/
.column_title {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #FFFFFF;
	font-style: normal;
	text-decoration: none;
	font-weight: normal;
}

/** Contenido del titulo de la columna hover **/
.column_title:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #FDFF00;
	font-style: normal;
	text-decoration: none;
	font-weight: normal;
}