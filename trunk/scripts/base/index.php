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
 $objOsezno->assign('form_title','Cambiar este titulo');
 
<<<<<<< .mine
 $objOsezno->assign('work_area',$modelo->builtList('libros'));
=======
 $objOsezno->assign('work_area','');
 
 $objOsezno->assign('other_area','Cambiar este contenido');
>>>>>>> .r74

 $objOsezno->call_template('basic/basic.tpl');
 
 
?>