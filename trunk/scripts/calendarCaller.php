<?php

	 include '../configApplication.php';

	 $cal = new myCal($_GET);
	 
	 echo $cal->getCalendar();
	 
?>