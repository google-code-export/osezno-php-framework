<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include 'handlerEvent.php';

 if (SHOW_WELCOME_MESSAGE == true)
 
 	$objOsezno->assign('onload', 'onload="onLoadShowWel()"');
 
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('welcome/welcome.tpl');
 
?>