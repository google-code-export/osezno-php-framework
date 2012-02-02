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

 
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('nom_modulo',htmlentities(OPF_PROFILES_TITLE));
 
 $objOsezno->assign('desc_modulo',htmlentities(OPF_PROFILES_DESC));
 
 $OPF_profiles = new OPF_profiles;
 
 $objOsezno->assign('content1',$OPF_profiles->getFormStartUp());
 
 $objOsezno->assign('content2',$OPF_profiles->getListProfiles());
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('modulo/modulo.tpl');

?>