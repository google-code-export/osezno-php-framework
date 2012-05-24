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
	
	public function default_event (){
		
		$myForm = new OPF_myForm('new_form');
		
		$myForm->addText('Nombre:','nombre');
		
		$myForm->addButton('btn1','Enviar');
		
		$myForm->addEvent('btn1', 'onclick', 'getData');
		
		$this->formulario = $myForm->getForm(2);
	}
	
	public function getData ($datForm){
		
		$this->alert($datForm['nombre']);
		
		return $this->response;
	}
	
	public function perro(){
		
		echo 'perro';
	}
	
}

?>