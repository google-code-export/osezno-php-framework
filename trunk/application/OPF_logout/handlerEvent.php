<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'dataModel.php';

/**
 * Manejador de eventos de usuario
 *
 */
class eventos extends OPF_myController {

}

$objEventos = new eventos($objxAjax);
$objOsezno  = new OPF_osezno($objxAjax,$theme);

$objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
$objxAjax->processRequest();

?>