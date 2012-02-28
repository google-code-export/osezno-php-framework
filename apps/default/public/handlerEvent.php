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

	public function default_event (){
		
	}
	
	/**
	 * Ejemplo de evento
	 *
	 * @param $params
	 * @return string
	 */
	public function saludar ($params){
			
		$this->alert('Hola');
			
		return $this->response;
	}


}

$objEventos = new eventos();
$objEventos->processRequest();

?>