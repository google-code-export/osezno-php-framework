<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Manejador de eventos de usuario
 *
 */
class controller extends OPF_myController {

	public function onLoadShowWel (){
			
		$this->modalWindowFromUrl(BASE_URL_PATH.'resources/lang/firstTime/'.LANG.'.html',OPF_myLang::getPhrase('OPF_LOGIN_31')',300,320,2);
			
		return $this->response;
	}


}


$objEventos = new controller();
$objEventos->processRequest();
?>