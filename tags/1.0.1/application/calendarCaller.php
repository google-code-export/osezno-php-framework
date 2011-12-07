<?php

	/**
	 * Llama asincronicamente el modulo Calendario para los
	 * formulario de la clase myForm.
	 */
	include '../config/configApplication.php';

 	$objxAjax->processRequest();	
	
 	if (!$_GET['date'])
 		$_GET['date'] = date('Y-m-d');
 	else if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_GET['date'])) 
 			$_GET['date'] = date('Y-m-d');
 	
 	list($nA, $nM, $nD) = explode ('-',$_GET['date']);
 	
 	$nM = intval($nM);
 	
	$cal = new OPF_myCal($nA, $nM, $nD, $_GET['update'], $_GET['form_name']);
	
	echo $cal->getCalendar();
	 
	die();
	
?>