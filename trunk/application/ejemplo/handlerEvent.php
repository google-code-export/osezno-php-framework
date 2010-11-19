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

 	public function onSubmitSaveChanges ($form, $id){
 		
 		$usuarios = new usuarios;
 		
		$usuarios->find($id);
		
		$usuarios->nombre = $form['nombre'];
 		
 		$usuarios->edad = $form['edad'];
		
 		$usuarios->prof_id = $form['prof_id'];
 		
 		if ($usuarios->save()){
 			$this->notificationWindow('Los cambios fueron guardados',3,'ok');
 			
 			$this->closeModalWindow();
 		}else
 			$this->messageBox($usuarios->getErrorLog(),'critical');
		
 		return $this->response;
 	}
 	
 	public function showRecords_1($ids){
 		
 		$this->notificationWindow('Selecciono '.count($ids).' registros para Actualizar',3,'ok');
 		
 		return $this->response;
 	}
 	
 	public function showRecords_2($ids){
 		
 		$this->notificationWindow('Selecciono '.count($ids).' registros para Modificar',3,'warning');
 		
 		return $this->response;
 	}
 	
 	public function showRecords_3($ids){
 		
 		$this->notificationWindow('Selecciono '.count($ids).' registros para Eliminar',3,'cancel');
 		
 		return $this->response;
 	}
 	
 	public function updateRecord ($id){

		$modelo = new modelo;
		
		$this->modalWindow($modelo->formEdit($id),'Editar registro',310,185);
		
 		return $this->response;
 	}
 	
 	public function deleteRecord($id){
 		
 		$this->notificationWindow('El registro con el ID <b>'.$id.'</b> no sera eliminado',3,'warning');
 		
 		return $this->response;
 	}
 	
 	public function buttonOk ($datForm){
 		
 		return $this->response;
 	}

  	public function buttonCancel ($datForm){
 		
 		$this->notificationWindow('Cancel',3,'cancel');
 		
 		return $this->response;
 	} 	
 	
	public function showGrid ($datForm){
		
		$modelo = new modelo;
		
		$this->modalWindow($modelo->builtList('lista'),'Listado',800,270,2);
		
		return $this->response;
	}
 	
 	
 	public function onSubmitAccept(){
 		
 		$this->messageBox(NULL,'Hola',array('Acpetar'=>NULL),'ERROR');
 		
 		return $this->response;
 	}
 	

 	
 	public function procesarFormulario ($datForm){
 		
 		$this->messageBox('Los datos del formulario son:'."\n".var_export($datForm,true),'warning');
 		
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