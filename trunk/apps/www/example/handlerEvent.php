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
	
	public function saludar (){
		
		$this->saludo = 'Hola Mundo';
	}
	
	public function default_event (){
		
		/* Default event */
	}
	
}

$controller = new controller();

$controller->processRequest();

?>