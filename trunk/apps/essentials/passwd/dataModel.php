<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

class OPF_passwd {

	private $system_users;

	private $lastError = '';

	private $sqlLog = '';

	public function getLastError (){
			
		return $this->system_users->getErrorLog();
	}

	public function getSqlLog(){
			
		return $this->system_users->getSqlLog();
	}

	public function __construct(){
			
		$this->system_users = new ess_system_users;
	}

	public function __destruct(){
			
		$this->lastError = $this->system_users->getErrorLog();
	}

	public function setNewPasswd ($user_name, $passwd){
			
		$return = false;
			
		$this->system_users->find($_SESSION['user_id']);
			
		$this->system_users->passwd = md5($user_name.$passwd);
			
		if ($this->system_users->save())

		$return = true;
		else

		$this->lastError = $this->system_users->getErrorLog();
			
		return $return;
	}

	public function validatePasswd ($user_name, $passwd){
			
		$return = false;

		if ($this->system_users->find('id = '.$_SESSION['user_id'].' & passwd = '.md5($user_name.$passwd).' & status = 1')){
				
			$return = true;
		}
			
		return $return;
	}

	public function validateUser ($user_name){
			
		$return = false;
			
		if ($this->system_users->find('id = '.$_SESSION['user_id'].' & user_name = '.$user_name.' & status = 1')){

			$return = true;
		}
			
		return $return;
	}

	public function getFormChngPasswd (){
			
		$myForm = new OPF_myForm('ChngPasswd');
			
		$myForm->addText(OPF_PASSWD_4,'user_name');
			
		$myForm->addPassword(OPF_PASSWD_5,'passwd');
			
		$myForm->addPassword(OPF_PASSWD_6,'passwd1');
			
		$myForm->addPassword(OPF_PASSWD_7,'passwd2');
			
		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
			
		$myForm->addEvent('btn_save', 'onclick', 'onClikSavePasswd');
			
		return $myForm->getForm(1);
	}

}

class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

	public $name;

	public $lastname;

	public $passwd;

	public $status;

	public $profile_id;

	public $datetime;

}

?>