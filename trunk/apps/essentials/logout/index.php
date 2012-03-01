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

session_destroy();

/**
 * Asignar contenidos a areas de la plantilla
 */
$objOsezno->assign('msg_close_session',OPF_LOGOUT_1);


/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('logout/logout.tpl');

?>