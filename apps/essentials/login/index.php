<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Asignar contenidos a areas de la plantilla
 */
$OPF_login = new OPF_login;

OPF_osezno::assign('nom_modulo','Essentials');

OPF_osezno::assign('desc_modulo','Essentials Osezno PHP Framework');

if ($OPF_login->existsDB()){

	if ($OPF_login->existsStruct()){

	OPF_osezno::assign('content1',$OPF_login->getFormLogin());
		
	}else
		
	OPF_osezno::assign('content1',$OPF_login->getFormInstall('tables'));

}else{

	$disabled = false;
	
	OPF_osezno::assign('onload', 'onLoadShowWel()');
	
	if (!strstr(strtoupper(ini_get('default_charset')), "UTF")){
		
		$disabled = true;
	}
	
	if (isset($_SERVER['HTTP_ACCEPT_CHARSET'])){
			
		if(!strstr(strtoupper($_SERVER['HTTP_ACCEPT_CHARSET']), "UTF")){
				
			$disabled = true;
		}
			
	}
	
	if ($disabled){
		
		OPF_osezno::assign('content2','<div align="center" id="content2" class="error">'.OPF_LOGIN_32.'</div>');
	}

	OPF_osezno::assign('content1',$OPF_login->getFormInstall('db',array(),$disabled));
}

/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('login'.DS.'login.tpl');

?>