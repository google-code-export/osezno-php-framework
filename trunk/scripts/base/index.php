<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: Jos� Ignacio Guti�rrez Guzm�n
   * developer@osezno-framework.com
   * 
   * index.php: 
   * Vista inicial.
   */
 include 'handlerEvent.php';
 
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('form_title','Cambiar este titulo');
 
 $objOsezno->assign('work_area',$modelo->form2());

 $objOsezno->call_template('basic/basic.tpl');
 
 
?>