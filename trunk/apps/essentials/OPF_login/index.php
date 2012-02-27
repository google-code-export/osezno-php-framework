<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'handlerEvent.php';


/**
 * Asignar contenidos a areas de la plantilla
 */
$OPF_login = new OPF_login;

$objOsezno->assign('nom_modulo','Essentials');

$objOsezno->assign('desc_modulo','Essentials Osezno PHP Framework');

if ($OPF_login->existsDB()){

	if ($OPF_login->existsStruct())

	$objOsezno->assign('content1',$OPF_login->getFormLogin());
		
	else
		
	$objOsezno->assign('content1',$OPF_login->getFormInstall('tables'));

}else{

	$disabled = false;
	
	$objOsezno->assign('onload', 'onLoadShowWel()');
	
	if (!strstr(strtoupper(ini_get('default_charset')), "UTF")){
		
		$disabled = true;
	}
	
	if (isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
			
		if(!strstr(strtoupper($_SERVER['HTTP_ACCEPT_CHARSET']), "UTF")){
				
			$disabled = true;
		}
			
	}
	
	if ($disabled){
		
		$objOsezno->assign('content2','<div align="center" id="content2" class="error">'.OPF_LOGIN_32.'</div>');
	}

	$objOsezno->assign('content1',$OPF_login->getFormInstall('db',array(),$disabled));
}

/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('login/login.tpl');

?>