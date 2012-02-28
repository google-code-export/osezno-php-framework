<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

//if (SHOW_WELCOME_MESSAGE == true)

	OPF_osezno::assign('onload', 'onload="onLoadShowWel()"');

/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('welcome'.DS.'welcome.tpl');

?>