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

 	public function inhabilitaUsuarios ($datArr){
 			
 		$this->messageBox(htmlentities(OPF_ADMUSR_12),'warning',array(NO,YES=>'inhabilitaUsuariosConfirm'),$datArr);
 			
 		return $this->response;
 	}
 	
 	public function inhabilitaUsuariosConfirm ($datArr){
 			
 		$ess_system_users = new ess_system_users;
 			
 		$ess_system_users->beginTransaction();
 			
 		foreach ($datArr as $id){
 	
 			$ess_system_users->find($id);
 	
 			$ess_system_users->status = 2;
 			
 			$ess_system_users->datetime = date("Y-m-d H:i:s");
 	
 			$ess_system_users->save();
 		}
 			
 		if ($ess_system_users->endTransaction()){
 	
 			$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 	
 			$this->MYLIST_reload('lst_users');
 	
 			$this->closeMessageBox();
 	
 		}else
 		$this->alert($ess_system_users->getErrorLog());
 			
 			
 		return $this->response;
 	}
 	
 	
 	public function habilitaUsuarios ($datArr){
 		
 		$this->messageBox(htmlentities(OPF_ADMUSR_13),'warning',array(NO,YES=>'habilitaUsuariosConfirm'),$datArr);
 		
 		return $this->response;
 	}
 	
 	public function habilitaUsuariosConfirm ($datArr){
 		
 		$ess_system_users = new ess_system_users;
 		
 		$ess_system_users->beginTransaction();
 		
 		foreach ($datArr as $id){
 			
 			$ess_system_users->find($id);
 			
 			$ess_system_users->status = 1;
 			
 			$ess_system_users->datetime = date("Y-m-d H:i:s");
 			
 			$ess_system_users->save();
 		}
 		
 		if ($ess_system_users->endTransaction()){
 			
 			$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS),3,'ok');
 			
 			$this->MYLIST_reload('lst_users');
 			
 			$this->closeMessageBox();
 			
 		}else 
 			$this->alert($ess_system_users->getErrorLog());
 		
 		
 		return $this->response;
 	}
 	
 	
 	public function onClickDeleteRecord ($user_id){
 		
 		$ess_system_users = new ess_system_users;
 		
 		if ($ess_system_users->delete($user_id)){
 			
 			$this->notificationWindow(htmlentities(OPF_ADMUSR_14),3,'ok');
 			
 			$this->MYLIST_reload('lst_users');
 			
 		}else{
 			
 			$this->messageBox($ess_system_users->getErrorLog(),'error');
 		}
 		
 		return $this->response;
 	}
 	
 	/**
 	 * Guardar el registro
 	 * 
 	 * @param array $datForm
 	 */
 	public function onClickSaveRecord ($datForm, $user_id = ''){
 		
 		$txtChgPas = '';
 		
 		$requiredFields = array('user_name','passwd1','passwd','profile_id');
 		
 		if ($this->MYFORM_validate($datForm, $requiredFields)){
 			
 			if (!strcmp($datForm['passwd'],$datForm['passwd1'])){
 				
 				$ess_system_users = new ess_system_users;
 				
 				$ess_system_users->beginTransaction();
 				
 				if ($ess_system_users->find('user_name = '.$datForm['user_name']) && !$user_id){
 					
 					$this->notificationWindow(htmlentities(OPF_ADMUSR_15).' <b>'.htmlentities($datForm['user_name']).'</b> '.htmlentities(OPF_ADMUSR_16),3,'error');
 					
 				}else{
 					
 					if ($user_id){
 					
 						$ess_system_users->find($user_id);
 					
 						if (strcmp($ess_system_users->passwd,$datForm['passwd'])){
 						
 							$ess_system_users->passwd = md5($datForm['user_name'].$datForm['passwd']);
 							
 							$txtChgPas = '. '.OPF_ADMUSR_17;
 							
 						}else
 							
 							$txtChgPas = '. '.OPF_ADMUSR_18;
 						
 					}else {
 					
 						$ess_system_users->user_name = $datForm['user_name'];
 						
 						$ess_system_users->passwd = md5($datForm['user_name'].$datForm['passwd']);
 					}
 					
 					$ess_system_users->name = $datForm['name'];
 					
 					$ess_system_users->lastname = $datForm['lastname'];
 					
 					$ess_system_users->profile_id = $datForm['profile_id'];
 					
 					$ess_system_users->datetime = date("Y-m-d H:i:s");
 					
 					$status = 2;
 					
 					if ($datForm['status'])
 					
 						$status = 1;
 					
 					$ess_system_users->status = $status;
 					
 					$ess_system_users->save();
 					
 					if ($ess_system_users->endTransaction()){
 							
 						$this->notificationWindow(htmlentities(MSG_CAMBIOS_GUARDADOS).' <b>'.htmlentities($txtChgPas).'</b>',3,'ok');
 							
 						$this->MYLIST_reload('lst_users');
 							
 						$this->alert($ess_system_users->getSqlLog());
 						
 						$this->closeModalWindow();
 							
 					}else{
 							
 						$this->alert($ess_system_users->getErrorLog());
 					}
 					
 				}
 				
 			}else{

 				$this->notificationWindow(htmlentities(OPF_ADMUSR_19),3,'error');
 			}
 			
 		}else{
 			
 			$this->notificationWindow(htmlentities(MSG_CAMPOS_REQUERIDOS),3,'error');
 		}

 		return $this->response;
 	}
 	
 	/**
 	 * Ejemplo de evento
 	 * 
 	 * @param $params
 	 * @return string
 	 */
 	public function onClickNewRecord ($user_id = ''){
 		
 		$OPF_admUsr = new OPF_admUsr;
 		
 		if (is_array($user_id))
 		
 			$user_id = '';
 		
 		$this->modalWindow($OPF_admUsr->getFormAgrUsr($user_id),OPF_ADMUSR_1,260,290,2);
 		
 		return $this->response;
 	}
 	
	
 }

 
 
 
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new OPF_osezno($objxAjax,$theme);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>