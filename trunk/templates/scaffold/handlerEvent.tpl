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
 		
 		${name_table_scaff} = new {name_table_scaff};
 		
 		$ok = false;
 		
 		if (is_array($id)){

			${name_table_scaff}->beginTransaction();

			foreach ($id as $idDel){
			
				${name_table_scaff}->delete($idDel);
			
			}
			
			if (${name_table_scaff}->endTransaction())
 		
				$ok = true; 			
 		
 		}else{
 		
 			if (${name_table_scaff}->delete($id))
 			
 				$ok = true;
 				
 		}
 		
 		if ($ok){
 		
 			$this->notificationWindow(htmlentities('Registro(s) eliminado(s)'),3,'ok');

			$this->MYLIST_reload('lst_{name_table_scaff}');
			
		}else{
		
			$this->messageBox(${name_table_scaff}->getErrorLog(),'error');
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
 		
 		$this->modalWindow(scaffolding_{name_table_scaff}::getFormAddMod{name_table_scaff}($idParam),htmlentities('Registro'),300,{height_window_form},2);
 		
 		return $this->response;
 	}
	
	/**
	 * Evento al guardar los cambios en un registro
	 */
	public function onClickSave ($datForm, $id = ''){
	
		if ($this->MYFORM_validate($datForm,array({fields_required_list_array}))){
		
			${name_table_scaff} = new {name_table_scaff};
			
			if ($id)
				
				${name_table_scaff}->find($id);	
			{fields_assign_to_save}
			if (${name_table_scaff}->save()){
				
				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_{name_table_scaff}');
 				
			}else{
				
				$this->messageBox(${name_table_scaff}->getErrorLog(),'error');
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