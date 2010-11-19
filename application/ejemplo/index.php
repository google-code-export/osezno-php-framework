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
 $objOsezno->assign('nombre_pagina','Tabla de registros');
 
 $objOsezno->assign('form_title','Tabla de resgistros del sistema');
 
 //$objOsezno->assign('work_area',$modelo->builtList('litas2'));
 $objOsezno->assign('work_area',$modelo->form2());
  
 //$objOsezno->call_template('multivacaciones/multivacaciones.tpl');
 $objOsezno->call_template('osezno/osezno.tpl');
 
?> 