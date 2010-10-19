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
 $objOsezno->assign('Area de plantilla','Contenido en area');
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('basic/basic.tpl');
 
?>