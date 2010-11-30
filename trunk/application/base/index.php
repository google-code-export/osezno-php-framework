<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011  
   * @version: 0.1
   * @author: Oscar Eduardo Aldana 
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
 $objOsezno->assign('name','');
 
 $objOsezno->assign('desc','');
 
 $objOsezno->assign('main_area','');
 
 $objOsezno->assign('alt_area','');
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('osezno/osezno.tpl');
 
?>