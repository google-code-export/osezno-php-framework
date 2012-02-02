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
 $objOsezno->assign('nom_modulo','Usuarios');
 
 $objOsezno->assign('desc_modulo','Usuarios de magalenore');
 
 $objOsezno->assign('content1',scaffolding_maga::getFormStartUp_maga());
 
 $objOsezno->assign('content2',scaffolding_maga::getList_maga());
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('modulo/modulo.tpl');
 
?>