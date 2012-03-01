<?php

include 'handlerEvent.php';

$objOsezno->assign('home_etq','&nbsp;<b>'.'../../application/</b>');

$readDirs = new readDirs('../../');

$objOsezno->assign('menu_struct',$readDirs->returnJsTree());

$objOsezno->call_template('urlselect/urlselect.tpl');

?>