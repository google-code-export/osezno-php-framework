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

 	public function globalModifyAccept($data){
 		
		$this->alert(var_export($data,true)); 		
 		
 		return $this->response;
 	}
 	
 	public function globalModify($data){
 		
 		#TODO: Pasar parametros botones en messageBox
		$this->messageBox('Desea eliminar estos registros?','warning',array('Si'=>'globalModifyAccept','No'=>NULL)); 		
 		
 		return $this->response;
 	}
 	
 	public function saveUser ($datos, $id){
 		
 		if ($this->MYFORM_validate($datos,array('nombre','apellido','edad','prof_id'))){
 			
			$usuarios = new usuarios;
 		
 			if ($id)
 				$usuarios->find($id);
 		
 			$usuarios->nombre = $datos['nombre'];
 		
 			$usuarios->apellido = $datos['apellido'];
 		
 			$usuarios->edad = $datos['edad'];
 		
 			$usuarios->prof_id = $datos['prof_id'];
 		
 			if ($usuarios->save()){
 			
 				$this->notificationWindow('Los cambios fueron guardados '.$usuarios->getLastInsertId(),3,'ok');

 				$this->closeModalWindow();	
 			
 				if ($id)
 					$this->MYLIST_reload('usuarios');
 				
 			}else
 				$this->messageBox($usuarios->getErrorLog());
 			
 		}else{
 			$this->notificationWindow('Existen campos sin diligenciar.',3,'error');
 		}
 		
 		return $this->response;
 	}
 	
 	public function cancelAdd ($dat,$from){
 		
 		$this->notificationWindow('Acci&oacute;n cancelada.',3,'cancel');
 		
 		if ($from == 'grid')
 			$this->closeModalWindow();
 		else{
 			
 			$this->clear('nombre','value');
 			
 			$this->clear('apellido','value');
 			
 			$this->clear('prof_id','value');
 			
 			$this->clear('edad','value');
 			
 		}	
 		
 		return $this->response;
 	}
 	
 	public function editUsuario ($id){

 		$modelo = new modelo;
 		
 		$this->modalWindow($modelo->formEdit($id,'grid'),'Editar',450,160);
 		
 		return $this->response;
 	}
 	
	public function onClickSave ($data){
		
		if ($this->MYFORM_validate($data,array('nom','ape','sex'))){

			$this->notificationWindow('Campos diligenciados',3,'ok');
		}else{
			$this->notificationWindow('Campos sin dilegenciar',3,'error');
		}
		
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