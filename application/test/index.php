<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011  
   * @version: 0.1
   * @author: José Ignacio Gutiérrez Guzmán
   * 
   * developer@osezno-framework.org
   * 
   * index.php: 
   * Vista inicial.
   */
 include 'handlerEvent.php';

 
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('name','Instalation test');
 
 $objOsezno->assign('desc','Instalation test');
 
 $objOsezno->assign('main_area',testInstall::getInfoOPF());
 
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('osezno/osezno.tpl');
 
?>