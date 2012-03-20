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

class forms{
	
	public static function getForm (){
		
		$frm = new OPF_myForm('frm1');
		
		$frm->addButton('bt1','Ok');
		
		$frm->addEvent('bt1', 'onclick','ajax_enviarForm');
		
		return $frm->getForm(1);
	}
}
?>