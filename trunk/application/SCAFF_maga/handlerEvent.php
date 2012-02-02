<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include 'dataModel.php';
 
/**
 * Manejador de eventos de usuario
 *
 */	
 class eventos extends OPF_myController {

 	public function onClickDeleteRecord ($id){
 		
 		$this->alert(var_export($id,true));
 		
 		$maga = new maga;
 		
 		$ok = false;
 		
 		if (is_array($id)){

			$maga->beginTransaction();

			foreach ($id as $idDel){
			
				$maga->delete($idDel);
			
			}
			
			if ($maga->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if ($maga->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->MYLIST_reload('lst_maga');
			
		}else{
		
			$this->messageBox($maga->getErrorLog(),'error');
		}
 		
 		return $this->response;
 	}
 	
	/**
	 * Evento de lanzar la ventana de nuevo registro
	 */
	 public function onClickAddRecord ($id){
 		
 		$idParam = '';
 		
 		if (!is_array($id))
 		
 			$idParam = $id;
 		
 		$this->modalWindow(scaffolding_maga::getFormAddModmaga($idParam),htmlentities('Registro'),300,250,2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array('eombre'))){
		
			$maga = new maga;
			
			if ($id)
				
				$maga->find($id);	
			
			$maga->eombre = $datForm['eombre'];

			$maga->apellido = $datForm['apellido'];

			$maga->edad = $datForm['edad'];

			$maga->echa = $datForm['echa'];

			$maga->ciudad = $datForm['ciudad'];

			if ($maga->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_maga');
 				
			}else{
				
				$this->messageBox($maga->getErrorLog(),'error');
			}
		
		}else{
		
			$this->notificationWindow(htmlentities(MSG_CAMPOS_REQUERIDOS),3,'error');
		
		}
	
		return $this->response;
	}
	
 }

 
 
 
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new OPF_osezno($objxAjax,$theme);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>