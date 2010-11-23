<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   *  
   * handlerEvent.php: 
   * Manejador de eventos del Usuario
   *  
   */

 include 'dataModel.php';
 
/**
 * Manejador de eventos de usuario
 *
 */	
 class eventos extends myController {

	public function onClickCalcular ($d){
		
		$this->messageBox('Tu edad es '.$d,'warning');
		
		return $this->response;
	}
	
 	public function onClickGetListRecords (){
		
		$modelo = new modelo;
		
		$this->modalWindow($modelo->builtList('usuarios'),'Usuarios del Sistema',725,500);
		
		return $this->response;
	}
 }

 
 /**
  * No modificar
  */
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new osezno($objxAjax);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>