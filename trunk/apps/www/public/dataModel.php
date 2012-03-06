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
		
		public static function form (){
			
			$myForm = new OPF_myForm('frm_1');
			
			$myForm->addText('Fecha:','fecha',date('Y-m-d'),12,10,true,true);
			
			return $myForm->getForm(1);
		} 
		
	}

?>