<?php

	include '../configApplication.php';

 	$objxAjax->processRequest();	
	
	$cal = new myCal($_GET);
	
	echo $cal->getCalendar();
	 
?>