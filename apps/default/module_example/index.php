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
$objOsezno->assign('name','');

$objOsezno->assign('desc','');

$objOsezno->assign('main_area','');

$objOsezno->assign('alt_area','');


/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('osezno/osezno.tpl');

?>