<?php

include '../config/configApplication.php';

if (!isset($_SESSION['user_id'])){

	header ('Location: '.$urlRedirect);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<HTML>
<HEAD>
<link rel="shortcut icon" href="../favicon.ico">
<TITLE><?php echo APP_DESC; ?></TITLE>
</HEAD>
<FRAMESET cols="170,*" border="0">

	<frame name="menu" src="OPF_options/" title="Menu de navegación">

	<frame name="modulo" src="OPF_welcome/" title="Modulos">

</FRAMESET>