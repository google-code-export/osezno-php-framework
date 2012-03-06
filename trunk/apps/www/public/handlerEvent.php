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
class eventos extends OPF_myController {

	public function saludar ($p1 = '', $p2 = '', $p3 = '', $p4 = ''){
		
		$this->nombre = $p1;
		
		//$this->nombre = 'José Ignacio Gutiérrez Guzmán';
		
		//$this->maga = array ('maga','lenore');
		
		$this->render_template('name', $p2);
	}

}

$eventos = new eventos();

$eventos->processRequest();

?>