<?php

	include '../configApplication.php';

	$objOsezno = new osezno($objxAjax);
 
 	$objOsezno->setPathFolderTemplates('../lang/help_mylist/');
	
 	
 	echo $objOsezno->call_template('spanish.tpl');
?>