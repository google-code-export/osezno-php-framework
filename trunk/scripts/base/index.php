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
 //$objOsezno->assign('form_title','Cambiar este titulo');
 
 //$objOsezno->assign('work_area','Cambiar este contenido');
 
 //$objOsezno->assign('other_area','Cambiar este contenido');

 
 /**
  * Mostrar la plantilla
  */
 //$objOsezno->call_template('basic/basic.tpl');
 
 $base_sedes = new base_sedes;
 
 $base_sedes->sede = 'Hola';
 
 $base_sedes->estado = 7;
 
 $base_sedes->user_id = 5;
 
 $base_sedes->registro = '18-11-2008 09:04:17';
 
 $base_sedes->save();

 echo $base_sedes->getSqlLog();

 
?>