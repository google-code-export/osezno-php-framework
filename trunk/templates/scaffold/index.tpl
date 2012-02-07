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
 $objOsezno->assign('nom_modulo','{scaff_mod_name}');
 
 $objOsezno->assign('desc_modulo','{scaff_mod_desc}');
 
 $objOsezno->assign('content1',scaffolding_{name_table_scaff}::getFormStartUp_{name_table_scaff}());
 
 $objOsezno->assign('content2',scaffolding_{name_table_scaff}::getList_{name_table_scaff}());
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('modulo/modulo.tpl');
 
?>