@CHARSET "ISO-8859-1";
th, td {
    overflow: hidden;
    word-wrap: normal;
    height: 20px;
}

/** Color de borde de la lista **/
.list {
	background-color:#D3E0FA;
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
	background-image: url('<?= $_GET['path_img']; ?>cell_selected.gif');
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
	background-image: url('<?= $_GET['path_img']; ?>cell_over.gif');
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
	font-size: 10px;
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
	background-image: url('<?= $_GET['path_img']; ?>col_selected.gif');
	text-align:center;
}

/** Celda del titulo de la columna **/
.cell_title {
	background-image: url('<?= $_GET['path_img']; ?>col_default.gif');
	text-align:center;
}

/** Contenido de la titulo de la columna **/
.column_title {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
	font-style: normal;
	text-decoration: none;
	font-weight: bold;
}

/** Contenido del titulo de la columna hover **/
.column_title:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FDFF00;
	font-style: normal;
	text-decoration: none;
	font-weight: bold;
}