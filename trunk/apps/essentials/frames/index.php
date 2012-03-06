<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<HTML>
<HEAD>
<link rel="shortcut icon" href="<?php echo BASE_URL_PATH; ?>common/favicon.ico">
<TITLE><?php echo APP_DESC; ?></TITLE>
</HEAD>
<FRAMESET cols="170,*" border="0">

	<frame name="menu" src="<?php echo BASE_URL_PATH.'options/'; ?>" title="Menu de navegación">

	<frame name="modulo" src="<?php echo BASE_URL_PATH.'welcome/'; ?>" title="Modulos">

</FRAMESET>