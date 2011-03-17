@CHARSET "ISO-8859-1";

/** on call **/
.blocker {
	background-color:#FFFFFF;
	position: absolute;
	display:block;
	top:0;
	left:0;
	z-index:5000;	
	opacity:0;
	filter:alpha(opacity=0)
}

/** on call image **/
.blocker_image {
	position: absolute;
	z-index:5001;
	width:32px;
	height:16px;
	background-image: url('<?php echo $_GET['path_img']; ?>loader.gif');
}