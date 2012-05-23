<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Asignar contenidos a areas de la plantilla
 */

$user_on_line = new user_on_line;

$user_on_line->buildFiles();

OPF_osezno::assign('nom_modulo',OPF_myLang::getPhrase('OPF_USRONLINE_TITLE'));

OPF_osezno::assign('desc_modulo',OPF_myLang::getPhrase('OPF_USRONLINE_DESC'));

OPF_osezno::assign('content1',$user_on_line->buildDinamicListUsersOnLine());
 
/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('modulo'.DS.'modulo.tpl');

?>