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

	public function onClickFindMod ($datForm){
			
		$this->window('url_select_mod', '../url/');
			
		return $this->response;
	}

	public function onClickDeleteRecord ($id){
			
		$ess_menu = new ess_menu;
			
		if ($ess_menu->delete($id)){

			$this->notificationWindow(OPF_MENU_1,3,'warning');

			$this->MYLIST_reload('lst_menu');

		}else{

			$this->messageBox($ess_menu->getErrorLog(),'error');
		}
			
		return $this->response;
	}

	public function onClickAddModRecord ($id){
			
		$menuOPF = new menuOPF;
			
		$idMenu = '';
			
		if (!is_array($id))
			
		$idMenu = $id;
			
		$this->modalWindow($menuOPF->getFormAddModRecord($idMenu),OPF_MENU_2,400,270,2);
			
		return $this->response;
	}

	public function onClickSave ($datForm, $id = ''){
			
		$requiredFields = array ('description','ord');
			
		if ($this->MYFORM_validate($datForm, $requiredFields)){

			$error = false;

			$ess_menu = new ess_menu;

			if ($id)
			$ess_menu->find($id);

			$ess_menu->description = $datForm['description'];

			if ($datForm['menu_id']){

				$ess_menu->menu_id = $datForm['menu_id'];

			}

			$ess_menu->ord = $datForm['ord'];

			$ess_menu->url = $datForm['url'];

			$ess_menu->icon = $datForm['icon'];

			$ess_menu->usuario_id = $_SESSION['user_id'];

			$ess_menu->datetime = date("Y-m-d H:i:s");

			if ($id == $datForm['menu_id'] && $id)
			$error = true;

			if (!$error){

				if ($ess_menu->save()){
						
					$this->notificationWindow(MSG_CAMBIOS_GUARDADOS,3,'ok');
						
					$this->closeModalWindow();
						
					$this->MYLIST_reload('lst_menu');
						
				}else{
						
					$this->messageBox($ess_menu->getSqlLog().$ess_menu->getErrorLog(),'error');

				}
					
			}else{
				$this->messageBox(OPF_MENU_3,'error');
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