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
$objOsezno->assign('nom_modulo',OPF_ADMUSR_TITLE);

$objOsezno->assign('desc_modulo',OPF_ADMUSR_DESC);

$OPF_admUsr = new OPF_admUsr;

$objOsezno->assign('content1',$OPF_admUsr->getBtnAgrUsr());

$objOsezno->assign('content2',$OPF_admUsr->getListUsrs());


/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('modulo/modulo.tpl');

?>