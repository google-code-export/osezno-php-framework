<?php

OPF_osezno::assign('home_etq','&nbsp;<b>'.'Folders</b>');

$readDirs = new readDirs(dirname(dirname(__FILE__)).DS);

OPF_osezno::assign('path_js_tree',BASE_URL_PATH);

OPF_osezno::assign('menu_struct',$readDirs->returnJsTree());

OPF_osezno::call_template('urlselect/urlselect.tpl');

?>