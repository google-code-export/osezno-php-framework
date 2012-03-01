<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Manejador de eventos de usuario
 *
 */
class eventos extends OPF_myController {

	public function onClickSaveProfileDet ($datForm, $profile_id){
			
		$ess_profiles_detail = new ess_profiles_detail;
			
		$ess_profiles_detail->beginTransaction();
			
		$ess_profiles_detail->delete('profiles_id = '.$profile_id);
			
		$pref = 'chk_';
			
		foreach ($datForm as $id => $chkList){

			if (stripos($id, $pref) !== false) {
					
				if ($datForm[$id]){

					$ess_profiles_detail->menu_id = substr($id,strlen($pref));

					$ess_profiles_detail->profiles_id = $profile_id;

					$ess_profiles_detail->save();
				}
			}

		}
			
		if ($ess_profiles_detail->endTransaction()){

			$this->notificationWindow(MSG_CAMBIOS_GUARDADOS,3,'ok');

			$this->onClickCancel();

		}else{

			$this->messageBox($ess_profiles_detail->getErrorLog(),'error');

		}
			
		return $this->response;
	}

	public function onClickCancel (){

		$this->closeMessageBox();
			
		$OPF_profiles = new OPF_profiles;
			
		$this->assign('content1', 'innerHTML', $OPF_profiles->getFormStartUp());

		$this->assign('content2', 'innerHTML', $OPF_profiles->getListProfiles());

		return $this->response;
	}

	public function onClickCancelConfirm (){

		$this->messageBox(OPF_PROFILES_1,'help',array(YES=>'onClickCancel',NO));

		return $this->response;
	}

	public function onClickEditMenu ($id){
			
		$OPF_profiles = new OPF_profiles;
			
		$this->assign('content1','innerHTML', $OPF_profiles->getFormSetProfile($id));
			
		$this->clear('content2', 'innerHTML');
			
		return $this->response;
	}

	public function onClickDeleteRecord ($id){
			
		$ess_profiles = new ess_profiles;
			
		if ($ess_profiles->delete($id)){

			$this->notificationWindow(OPF_PROFILES_2,3,'ok');

			$this->MYLIST_reload('lst_profiles');

		}else{

			$this->messageBox($ess_profiles->getErrorLog(),'error');
		}
			
		return $this->response;
	}

	public function onClickAddRecord ($idProfile){
			
		$OPF_profiles = new OPF_profiles;
			
		$id = '';
			
		if (!is_array($idProfile))
			
		$id = $idProfile;
			
		$this->modalWindow($OPF_profiles->getFormAddModProfile($id),OPF_PROFILES_3,300,250,2);
			
		return $this->response;
	}

	public function onClickSave ($datForm, $id = ''){
			
		if ($this->MYFORM_validate($datForm, array('name','description'))){

			$ess_profiles = new ess_profiles;

			if ($id)
			$ess_profiles->find($id);

			$ess_profiles->name = $datForm['name'];

			$ess_profiles->description = $datForm['description'];

			$ess_profiles->user_id = $_SESSION['user_id'];

			$ess_profiles->datetime = date("Y-m-d H:i:s");

			if ($ess_profiles->save()){
					
				$this->notificationWindow(MSG_CAMBIOS_GUARDADOS,3,'ok');
					
				$this->closeModalWindow();
					
				$this->MYLIST_reload('lst_profiles');
					
			}else{
					
				$this->messageBox($ess_profiles->getErrorLog(),'error');
			}

		}else{

			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,3,'error');
		}
			
		return $this->response;
	}


}

$objEventos = new eventos();
$objEventos->processRequest();

?>