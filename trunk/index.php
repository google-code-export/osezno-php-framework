<?php

	include ('lib'.DIRECTORY_SEPARATOR.'OPF'.DIRECTORY_SEPARATOR.'osezno.php');

	OPF_osezno::configIndex(dirname(__FILE__));	
	
	
	echo OPF_myLang::getLang();
	
	echo count(get_included_files());
	
	echo memory_get_usage()/(1024*1024);
?>