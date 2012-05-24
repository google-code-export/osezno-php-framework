<?php

	include ('lib'.DIRECTORY_SEPARATOR.'OPF'.DIRECTORY_SEPARATOR.'osezno.php');

	OPF_osezno::setConfigFile('configApplication.php');
	
	OPF_osezno::configIndex(dirname(__FILE__), $_SERVER['REQUEST_URI']);
	
?>