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
	
	public function onSelectDeleteRows ($array){
		
		$this->notificationWindow('Eliminados '.count($array).' registros.',5,'error');
		
		return $this->response;
	}
	
	public function onSelectUpdateRows ($array){
		
		$this->notificationWindow('Actualizados '.count($array).' registros.',5,'ok');
		
		return $this->response;
	}

	public function onClickMostrarDatos($usuario_id){
		
		$usuarios = new usuarios;
		
		$profesion = new profesion;
		
		$usuarios->find($usuario_id);
		
		$profesion->find($usuarios->prof_id);
		
		$this->messageBox('Nombre:'.$usuarios->nombre."\n".'Edad:'.$usuarios->edad."\n".'Profesion:'.$profesion->profesion);
		
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