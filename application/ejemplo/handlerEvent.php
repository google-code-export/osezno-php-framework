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

 	public function globalModify($data){
 		
 		$this->alert(var_export($data,true));
 		
 		return $this->response;
 	}
 	
 	public function saveUser ($datos, $id){
 		
 		$usuarios = new usuarios;
 		
 		$usuarios->find($id);
 		
 		$usuarios->nombre = $datos['nombre'];
 		
 		$usuarios->edad = $datos['edad'];
 		
 		if ($usuarios->save())
 			$this->notificationWindow('Datos salvados');
 		else
 			$this->messageBox($usuarios->getErrorLog());	
 		
 		$this->closeModalWindow();	
 			
 		$this->MYLIST_reload('usuarioss');	
 		
 		return $this->response;
 	}
 	
 	public function editUsuario ($id){

 		$modelo = new modelo;
 		
 		$this->modalWindow($modelo->formEdit($id),'Editar',250,200);
 		
 		return $this->response;
 	}
 	
	public function onClickSave ($data){
		
		$this->notificationWindow('Datos salvados...');
		
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