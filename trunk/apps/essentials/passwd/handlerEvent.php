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

	/**
	 * Ejemplo de evento
	 *
	 * @param $params
	 * @return string
	 */
	public function onClikSavePasswd ($datForm){

		if ($this->MYFORM_validate($datForm, array('user_name','passwd1','passwd2'))){

			$OPF_passwd = new OPF_passwd;

			if ($OPF_passwd->validateUser($datForm['user_name'])){
					
				if ($OPF_passwd->validatePasswd($datForm['user_name'],$datForm['passwd'])){

					if (!strcmp($datForm['passwd1'], $datForm['passwd2'])){
							
						$ess_system_users = new ess_system_users;
							
						$ess_system_users->find($_SESSION['user_id']);
							
						$ess_system_users->passwd = md5($datForm['user_name'].$datForm['passwd']);
							
						if ($OPF_passwd->setNewPasswd($datForm['user_name'],$datForm['passwd1'])){

							$this->notificationWindow(MSG_CAMBIOS_GUARDADOS,3,'ok');

							$this->clear('user_name', 'value');

							$this->clear('passwd', 'value');

							$this->clear('passwd1', 'value');

							$this->clear('passwd2', 'value');

						}else
							
						$this->messageBox($ess_system_users->getErrorLog().$ess_system_users->getSqlLog(),'error');
					}else
						
					$this->notificationWindow(OPF_PASSWD_1,3,'error');
				}else

				$this->notificationWindow(OPF_PASSWD_2,3,'error');
					
			}else{
					
				$this->notificationWindow(OPF_PASSWD_3,3,'error');
					
				$this->redirect('../OPF_logout/');
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