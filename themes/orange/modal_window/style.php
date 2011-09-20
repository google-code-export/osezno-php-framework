<?php header ('Content-type: text/css'); ?> 
@CHARSET "ISO-8859-1";

/** Capa que bloquea otros contenidos **/
.blocker_mw {
	background-color:#FFF7EA;
	position: absolute;
	display:block;
	top:0;
	left:0;
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) echo 'filter:alpha(opacity=50);'; 	
	 else echo 'opacity:0.5;'; ?>
}

/** Boton cerrar **/
.buttom_close_mw {
	background-image: url('<?php echo $_GET['path_img']; ?>button-close.gif');
	height: 9px;
	width: 15px;
	position: absolute;
	margin:0px;
	background-repeat: no-repeat;
}

/** Esquina superior izq **/
.mw_top_left {
	background-image: url('<?php echo $_GET['path_img']; ?>top-left.gif');
}

/** Esquina superior centro **/
.mw_top_center {
	background-image: url('<?php echo $_GET['path_img']; ?>top-middle.gif');
}

/** Esquina superior Der **/
.mw_top_right {
	background-image: url('<?php echo $_GET['path_img']; ?>top-right.gif');
}

/** Centro izq **/
.mw_center_left {
	background-image: url('<?php echo $_GET['path_img']; ?>left.gif');
}

/** Centro medio **/
.mw_center_middle {
	background-image: url('<?php echo $_GET['path_img']; ?>gradient-bg.png');
}

/** Esquina superior Der **/
.mw_center_right {
	background-image: url('<?php echo $_GET['path_img']; ?>right.gif');
}

/** Base izq **/
.mw_bottom_left {
	background-image: url('<?php echo $_GET['path_img']; ?>bottom-left.gif');
}

/** Base centro **/
.mw_bottom_center {
	background-image: url('<?php echo $_GET['path_img']; ?>bottom-middle.gif');
}

/** Base Der **/
.mw_bottom_right {
	background-image: url('<?php echo $_GET['path_img']; ?>bottom-right.gif');
}

/** Titulo de la ventana modal **/
.tit_mw {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-weight:bold;
	text-decoration: none;
	text-align:left;
	color:#FF9900;
}

/** Contenido del texto del modal window **/
.cont_mw {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	text-align:justify;
}

