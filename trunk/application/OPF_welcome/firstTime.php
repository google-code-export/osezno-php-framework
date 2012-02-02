<?php

	include 'handlerEvent.php';

	$objOsezno->setPathFolderTemplates('../../lang/firstTime/');

	echo $objOsezno->call_template(LANG.'.tpl');

?>