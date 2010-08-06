<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   * 
   * configMod.php: 
   * Configuracion del modulo
   */

 include '../../configApplication.php';

 /**
  * Encender o Apagar el Debug. 
  * El debug permite cuando se trabaja con ajax que podamos ver errores se sintaxis
  */ 
 $objxAjax->setFlag("debug", true); 
 
 
 /**
  * Decodificar todas las tildes o carateres especiales que vengan de los campos de texto.
  */ 
 $objxAjax->setFlag('decodeUTF8Input',true);

 /**
  * Configurar el prefijo de xAjax usado para llamar nuestras funciones de Php
  */  
 $objxAjax->setWrapperPrefix(XAJAX_WRAPPER_PREFIX);
 
?>