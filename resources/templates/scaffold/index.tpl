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
 OPF_osezno::assign('nom_modulo','{scaff_mod_name}');
 
 OPF_osezno::assign('desc_modulo','{scaff_mod_desc}');
 
 OPF_osezno::assign('content1',scaffolding_{name_table_scaff}::getFormStartUp_{name_table_scaff}());
 
 OPF_osezno::assign('content2',scaffolding_{name_table_scaff}::getList_{name_table_scaff}());
 
  
 /**
  * Mostrar la plantilla
  */
OPF_osezno::call_template('modulo'.DS.'modulo.tpl');
 
?>