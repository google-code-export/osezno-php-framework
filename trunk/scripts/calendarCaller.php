<?php

	include '../configApplication.php';

 	$objxAjax->processRequest();	
	
 	list($nA, $nM, $nD) = explode ('-',$_GET['date']);
 	
 	$nM = intval($nM);
 	
	$cal = new myCal($nA, $nM, $_GET['update']);
	
	echo $cal->getCalendar();
	 
?>