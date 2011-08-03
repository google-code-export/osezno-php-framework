<?php

	include '../configApplication.php';

	$objOsezno = new OPF_osezno($objxAjax);
 
 	$objOsezno->setPathFolderTemplates('../lang/help_mylist/');

 	echo $objOsezno->call_template(LANG.'.tpl');
 	
?>