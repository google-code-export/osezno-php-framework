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
OPF_osezno::assign('nom_modulo',OPF_ADMTABLAS_TITLE);

OPF_osezno::assign('desc_modulo',OPF_ADMTABLAS_DESC);

$admTablas = new admTablas;

OPF_osezno::assign('content1',$admTablas->getFormAdmTables_add());

OPF_osezno::assign('content2',$admTablas->getListForTables());


/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('modulo/modulo.tpl');

?>