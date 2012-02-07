<?php

include 'handlerEvent.php';

$objOsezno->assign('home_etq','&nbsp;<b>'.$GLOBALS['folderProject'].'application/</b>');

$readDirs = new readDirs($GLOBALS['folderProject']);

$objOsezno->assign('menu_struct',$readDirs->returnJsTree());

$objOsezno->call_template('urlselect/urlselect.tpl');

?>