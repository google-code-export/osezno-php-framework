<?php header ('Content-type: text/css'); ?> 
@CHARSET "UTF-8";

/** on call **/
.blocker {
	background-color:#FFFFFF;
	position: absolute;
	display:block;
	top:0;
	left:0;
	z-index:5000;
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) echo 'filter:alpha(opacity=0);'; 	
	 else echo 'opacity:0;'; ?>
}

/** on call image **/
.blocker_image {
	position: absolute;
	z-index:5001;
	width:32px;
	height:16px;
	background-image: url('<?php echo $_GET['path_img']; ?>loader.gif');
}