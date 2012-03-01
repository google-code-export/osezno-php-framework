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

$user_on_line = new user_on_line;

$user_on_line->buildFiles();

$objOsezno->assign('nom_modulo',OPF_USRONLINE_TITLE);

$objOsezno->assign('desc_modulo',OPF_USRONLINE_DESC);

$objOsezno->assign('content1',$user_on_line->buildDinamicListUsersOnLine());
 
/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('modulo/modulo.tpl');

?>