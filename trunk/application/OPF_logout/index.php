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

 session_destroy();
 
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('msg_close_session',htmlentities(OPF_LOGOUT_1));
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('logout/logout.tpl');
 
?>