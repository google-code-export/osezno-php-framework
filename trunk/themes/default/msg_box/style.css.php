@CHARSET "ISO-8859-1";

/** Esquina superior izq **/
.top_left {
	background-image: url('<?= $_GET['path_img']; ?>top-left.png');
	text-align:center;
}

/** Esquina superior centro **/
.top_center {
	background-image: url('<?= $_GET['path_img']; ?>top-middle.png');
	text-align:center;
}

/** Esquina superior Der **/
.top_right {
	background-image: url('<?= $_GET['path_img']; ?>top-right.png');
	text-align:center;
}

/** Centro izq **/
.center_left {
	background-image: url('<?= $_GET['path_img']; ?>left.png');
	text-align:center;
}

/** Centro medio **/
.center_middle {
	background-image: url('<?= $_GET['path_img']; ?>gradient-bg.png');
	text-align:center;
}

/** Esquina superior Der **/
.center_right {
	background-image: url('<?= $_GET['path_img']; ?>right.png');
	text-align:center;
}

/** Base izq **/
.bottom_left {
	background-image: url('<?= $_GET['path_img']; ?>bottom-left.png');
	text-align:center;
}

/** Base centro **/
.bottom_center {
	background-image: url('<?= $_GET['path_img']; ?>bottom-middle.png');
	text-align:center;
}

/** Base Der **/
.bottom_right {
	background-image: url('<?= $_GET['path_img']; ?>bottom-right.png');
	text-align:center;
}


/** Titulo del messagebox **/
.tit_msg_box {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: bold;
	text-decoration: none;
	text-align:center;
}

/** Contenido del texto del messagebox **/
.cont_msg_box {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-style: bold;
	text-decoration: none;
	text-align:justify;
}