<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'handlerEvent.php';

/**
 * Asignar contenidos a areas de la plantilla
 */

OPF_osezno::assign('name','Modulo de Ejemplo');

OPF_osezno::assign('desc','Modulo de ejemplo');

OPF_osezno::assign('main_area',formularios::getForm());

OPF_osezno::assign('alt_area','');


/**
 * Mostrar la plantilla
 */
echo OPF_osezno::call_template('osezno'.DS.'osezno.tpl');


?>