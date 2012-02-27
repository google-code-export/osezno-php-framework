<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */


 class formularios {

 	public static function getForm (){
 		
 		$myForm = new OPF_myForm('form_ejemplo');
 		
 		$myForm->addText('Nombre:','nombre');
 		
 		$myForm->addButton('btn1','Aceptar');
 		
 		$myForm->addEvent('btn1', 'onclick', 'saludar');
 		
 		return $myForm->getForm(1);
 	}
 	
 	
 }

?>