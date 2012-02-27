<?php header ('Content-type: text/css'); ?> 
@CHARSET "UTF-8";

/**
 * Reglas filtro lista
 */
.form_rule_for_list {
	border-radius: 10px 10px 10px 10px;
	-moz-border-radius: 10px 10px 10px 10px;
    background-clip: border-box;
	min-height:0px;
	background-color:#BEE1FC;
	font-style: normal;
	text-decoration: none;
	border-color:#BBCEF7;
	border-width: 1px;
	border-style: solid;
	padding-left:0px;
	padding-top:0px;	
	padding-bottom:0px;
	padding-right:0px;
}

/**
 * Contenido del formulario
 **/
.form_cont_filter {
	border-radius: 10px 10px 10px 10px;
	-moz-border-radius: 10px 10px 10px 10px;
    background-clip: border-box;
	background-color:#E7F4FE;
	font-style: normal;
	text-decoration: none;
	border-color:#D3E0FA;
	border-width: 1px;
	border-style: solid;
	padding-left:1px;
	padding-top:1px;	
	padding-bottom:1px;
	padding-right:1px;
	width:98%;
	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #039;
}

/**
 * Etiquetas de campo formulario de filtro
 **/
.texto_formularios {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
	text-align: right;
	vertical-align: middle;
	height:auto;
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
	color:#002F91;
	text-decoration: none;
}
a:hover {
	font-size: 10px;
	color:#004DEC;
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

.td_default_checkbox {
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

.td_middle_checkbox {
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
	color:#FFFFFF;
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

/** Contenido de una celda cuando es ordenada Checkbox **/
.cell_content_selected_checkbox {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style:italic;
	text-decoration: none;
	text-align:center;
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