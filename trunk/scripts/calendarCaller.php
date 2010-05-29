<?php

	include '../configApplication.php';

 	
 	$objOsezno  = new osezno($objxAjax);
 
 	$objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 	$objxAjax->processRequest();	
	
	$cal = new myCal($_GET);
	
	$objOsezno->assign('form_title','Cambiar este titulo');
 
 	$objOsezno->assign('work_area',$cal->getCalendar());

 	$objOsezno->call_template('basic/basic.tpl');
 
	 
?>