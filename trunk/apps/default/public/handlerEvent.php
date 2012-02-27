<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'dataModel.php';

/**
 * Manejador de eventos de usuario
 *
 */
class eventos extends OPF_myController {

	public function calcular ($params){
		
		$this->assign_to_template('alt_area', 1+1);
	}
	
	public function saludo ($params){
	
		$this->assign_to_template('alt_area', 'Hola perro del orto!');
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


$GLOBALS['objAjax']->processRequest();

?>