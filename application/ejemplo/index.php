<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   * 
   * index.php: 
   * Vista inicial.
   */
 include 'handlerEvent.php';
 

 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('name','Usuarios');
 
 $objOsezno->assign('desc','Administración de usuarios del sistema');
 
 $objOsezno->assign('main_area',$modelo->getMainForm());
 
 $objOsezno->call_template('osezno/osezno.tpl');
 
?> 