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

 $user_on_line = new user_on_line;
 
 $user_on_line->buildFiles();
 
 $objOsezno->assign('nom_modulo',htmlentities(OPF_USRONLINE_TITLE));
 
 $objOsezno->assign('desc_modulo',htmlentities(OPF_USRONLINE_DESC));
 
 $objOsezno->assign('content1',$user_on_line->buildDinamicListUsersOnLine());
   
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('modulo/modulo.tpl');
 
?>