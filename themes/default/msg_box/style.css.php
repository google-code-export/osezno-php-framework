@CHARSET "ISO-8859-1";

/** Esquina superior izq **/
.top_left {
	background-image: url('<?= $_GET['path_img']; ?>top-left.gif');
}

/** Esquina superior centro **/
.top_center {
	background-image: url('<?= $_GET['path_img']; ?>top-middle.gif');
}

/** Esquina superior Der **/
.top_right {
	background-image: url('<?= $_GET['path_img']; ?>top-right.gif');
}

/** Centro izq **/
.center_left {
	background-image: url('<?= $_GET['path_img']; ?>left.gif');
}

/** Centro medio **/
.center_middle {
	background-image: url('<?= $_GET['path_img']; ?>gradient-bg.gif');
}

/** Esquina superior Der **/
.center_right {
	background-image: url('<?= $_GET['path_img']; ?>right.gif');
}

/** Base izq **/
.bottom_left {
	background-image: url('<?= $_GET['path_img']; ?>bottom-left.gif');
}

/** Base centro **/
.bottom_center {
	background-image: url('<?= $_GET['path_img']; ?>bottom-middle.gif');
}

/** Base Der **/
.bottom_right {
	background-image: url('<?= $_GET['path_img']; ?>bottom-right.gif');
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