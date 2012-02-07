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
 */	
 class eventos extends OPF_myController {

 	/**
 	 * Mostrar el codigo PHP de una tabla del sistema
 	 * 
 	 * @param unknown_type $id
 	 */
 	public function onClickGetCodePHP ($id){
 		
 		$admTablas = new admTablas;
 		
 		$this->modalWindow($admTablas->getPHPCodeTable($id),htmlentities(OPF_ADMTABLAS_8),500,400,2);
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Eliminar varios detalles de una tabla 
 	 * 
 	 * @param unknown_type $datFormId
 	 */
 	public function confirmDeleteItems ($datFormId){
 		
 		$ess_master_tables_detail = new ess_master_tables_detail;
 		
 		$ess_master_tables_detail->beginTransaction();
 		
		foreach ($datFormId as $id){
 				
			$ess_master_tables_detail->delete($id);
		}
		
		if ($ess_master_tables_detail->endTransaction()){
		
			$this->notificationWindow(htmlentities(OPF_ADMTABLAS_4),3,'warning');
		
			$this->MYLIST_reload('lst_tablas_detalle');
		
			$this->closeMessageBox();
			
		}else{
		
			$this->messageBox($ess_master_tables_detail->getErrorLog(),'ERROR');
		
		}
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Eliminar uno o mas detalles de tabla
 	 * 
 	 * @param unknown_type $datFormId
 	 */
 	public function onClickDeleteItems ($datFormId){

 		$ess_master_tables_detail = new ess_master_tables_detail;
 		
 		$ess_master_tables_detail->beginTransaction();
 		
 		if (is_array($datFormId)){
 			
 			$this->messageBox(htmlentities(OPF_FIELD_CONFIRM_ELIMINAR_VARIOS),'HELP',array(NO,YES=>'confirmDeleteItems'),$datFormId);
 			
 		}else{
 			
 			$ess_master_tables_detail->delete($datFormId);

 			if ($ess_master_tables_detail->endTransaction()){
 			
 				$this->notificationWindow(htmlentities(OPF_ADMTABLAS_5),3,'warning');
 			
 				$this->MYLIST_reload('lst_tablas_detalle');
 			
 			}else{
 			
 				$this->messageBox($ess_master_tables_detail->getErrorLog(),'ERROR');
 			
 			}
 			
 		}
 		
 		
 		
 		return $this->response;
 	}
 	
   /**
 	* Cargar los datos de una detalle de tabla para ser editado
 	*
 	* @param unknown_type $id
 	*/
 	public function onClickUpdateDetail ($id){
 			
 		$ess_master_tables_detail = new ess_master_tables_detail;
 		
 		$ess_master_tables_detail->find($id);
 		
 		$admDetalleTablas = new admDetalleTablas($ess_master_tables_detail->master_tables_id, $id);
 			
 		$this->modalWindow($admDetalleTablas->getFormAdmItemTable_register($id),OPF_ADMTABLAS_6,300,150,2);
 			
 		return $this->response;
 	} 	
 	
 	/**
 	 * Registrar los cambios del detalle
 	 * 
 	 * @param unknown_type $datForm
 	 */
 	public function onClickSaveItemTable ($datForm, $table_id, $detail_id = ''){
 		
 		if ($this->MYFORM_validate($datForm, array('item_desc'))){
 			
 			$ess_master_tables_detail = new ess_master_tables_detail;

 			if ($detail_id)
 			
	 			$ess_master_tables_detail->find($detail_id);
 			
 			$ess_master_tables_detail->item_cod = $datForm['item_cod'];
 			
 			$ess_master_tables_detail->item_desc = $datForm['item_desc'];
 			
 			$ess_master_tables_detail->master_tables_id = $table_id; 
 			
 			$ess_master_tables_detail->user_id = $_SESSION['user_id'];
 			
 			$ess_master_tables_detail->datetime = date("Y-m-d H:i:s");
 			
 			if ($ess_master_tables_detail->save()){
 				
 				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 				
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_tablas_detalle');
 				
 			}else{
 				
 				$this->messageBox($ess_master_tables_detail->getErrorLog(),'ERROR');
 				
 			}
 			
 			
 		}else{
 			
 			$this->notificationWindow(htmlentities(MSG_CAMPOS_REQUERIDOS),3,'error');
 		}
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Agregar un item nuevo a la tabla.
 	 * 
 	 */
 	public function onClickGetFormAddItemTable ($datForm, $id){
 		
 		$admDetalleTablas = new admDetalleTablas($id);
 		
 		$this->modalWindow($admDetalleTablas->getFormAdmItemTable_register(),OPF_ADMTABLAS_6,300,150,2);
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Obtener el detalle de los items de la lista dinamica
 	 * 
 	 * @param unknown_type $id
 	 */
 	public function onClickGetDetList ($id){
 		
 		$admDetalleTablas = new admDetalleTablas($id);
 		
 		$this->modalWindow($admDetalleTablas->getFormAdmItemTable_add()."\n".$admDetalleTablas->getListForTableDetail(),$admDetalleTablas->getTablename(),800,500,2);
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Eliminar una tabla del sistema
 	 * 
 	 * @param unknown_type $id
 	 */
 	public function onClickDeleteTable ($id){
 		
 		$ess_master_tables = new ess_master_tables;
 		
 		if ($ess_master_tables->delete($id)){
 			
 			$this->notificationWindow(htmlentities(OPF_ADMTABLAS_4),3,'warning');
 			
 			$this->MYLIST_reload('lst_tablas');
 			
 		}else{
 			
 			$this->messageBox($ess_master_tables->getErrorLog(),'ERROR');
 		}
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Cargar los datos de una tabla en el formulario para editarla
 	 * 
 	 * @param unknown_type $id
 	 */
 	public function onClickUpdateTable ($id){
 		
 		$admTablas = new admTablas;
 		
 		$this->modalWindow($admTablas->getFormAdmTables_register($id),OPF_ADMTABLAS_7,300,200,2);
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Agrega un registro 
 	 * @param array $params
 	 */
 	public function onClickAddReg ($params){
 		
 		$admTablas = new admTablas;
 		
 		$this->modalWindow($admTablas->getFormAdmTables_register(),OPF_ADMTABLAS_7,300,200,2);
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Guardar los cambios en un registro
 	 * @param array $params
 	 * @return string
 	 */
 	public function onClickSaveReg ($params, $id = ''){
 		
 		$requiredFields = array('name');
 		
 		if ($this->MYFORM_validate($params, $requiredFields)){
 			
 			$ess_master_tables = new ess_master_tables;
 			
 			if ($id)
 				$ess_master_tables->find($id);
 			
 			$ess_master_tables->name = $params['name'];
 			
 			$ess_master_tables->description = $params['description'];
 			
 			$ess_master_tables->user_id = $_SESSION['user_id'];
 			
 			$ess_master_tables->datetime = date("Y-m-d H:i:s");
 			
 			if ($ess_master_tables->save()){
 			
 				$this->closeModalWindow();
 				
 				$this->MYLIST_reload('lst_tablas');
 				
 				$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),5,'ok');
 				
 				if (!$id)
 				
 					$this->onClickGetDetList($ess_master_tables->getLastInsertId());
 				
 			}else{
 				
 				$this->messageBox($ess_master_tables->getSqlLog()."\n".$ess_master_tables->getErrorLog(),'error');
 			}
 			
 		}else 
 			$this->notificationWindow(htmlentities(MSG_CAMPOS_REQUERIDOS),5,'error');
 		
 		return $this->response;
 	}
 	
	
 }

 
 
 
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new OPF_osezno($objxAjax,$theme);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>