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

class OPF_login {

	public $errorSql;

	private $errorLogIn = '';

	public function readTemplate ($file, $arrayAssignAreas){
			
		$newContent = '';
			
		$linkTpl = fopen($file,'r');
			
		if ($linkTpl){
	
			$contHTML = fread($linkTpl,filesize($file));
	
			$newContent = $contHTML;
	
			fclose($linkTpl);
	
			if (count($arrayAssignAreas)){
					
				$arrayKeys = array_keys($arrayAssignAreas);
	
				$newContent = str_ireplace ( $arrayKeys, $arrayAssignAreas, $contHTML);
			}
	
			$newContent = preg_replace('(\\{+[0-9a-zA-Z_]+\\})','',$newContent);
	
		}
			
		return $newContent;
	}
	
	public function getFormConfigApp ($datForm){
			
		$code = ''.
'<?php
 	
	#/config/configApplication.php

	$database = \''.$datForm['db'].'\';
	
	$engine = \''.$datForm['engine'].'\';
 	
	$host = \''.$datForm['host_db'].'\';
 	
	$user = \''.$datForm['user_db'].'\';
 	
	$password = \''.$datForm['passwd_db'].'\';
 	
	$port = '.$datForm['host_port'].';

?>
'.'';
			
		$myForm = new OPF_myForm('config_app');

		$myForm->addComment('cmmt', OPF_myLang::getPhrase('OPF_LOGIN_26'));
			
		return $myForm->getForm(1).'<br><div class="formulario">'.highlight_string($code,true).'</div>';
	}

	public function loadSQLfromFile ($file){
			
		$link = @fopen($file,'r');

		$sql = false;

		if ($link){

			$sql = fread($link, filesize($file));

			fclose($link);

		}

		return $sql;
	}

	public function existsStruct (){
			
		$ess_system_users = new ess_system_users;
			
		$ess_system_users->find(1);
			
		$this->errorSql = $ess_system_users->getSqlLog();
			
		return $ess_system_users->getNumRowsAffected();
	}

	public function existsDB (){
			
		$ess_system_users = new ess_system_users;
			
		return $ess_system_users->isSuccessfulConnect();
	}

	public function getStrError(){
			
		return $this->errorLogIn;
	}

	public function getFormInstall ($type, $datForm = '', $disabled = false){
			
		$myForm = new OPF_myForm('install_essentials');
			
		$arEngine = array(
			
 			'mysql'=>'MySQL',
			
 			'pgsql'=>'PostgreSQL'
		);
			
		$myForm->setParamTypeOnEvent('field');
			
		$myForm->addEvent('engine', 'onchange', 'onChangeEngine');
			
		$myForm->setParamTypeOnEvent('global');

		$engine = '';
			
		if (isset($datForm['engine']))
			
			$engine = $datForm['engine'];
			
		if ($disabled)
		
			$myForm->addDisabled('engine');
		
		$myForm->addSelect(OPF_myLang::getPhrase('OPF_LOGIN_8'), 'engine', $arEngine, $engine);
			
		$db = '';
			
		if (isset($datForm['db']))
			
			$db = $datForm['db'];

		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_12'),'db',$db);

		$encoding = 'UTF8';
			
		if (isset($datForm['encoding']))
			
			$encoding = $datForm['encoding'];

		$myForm->addDisabled('encoding');
		
		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_12A'),'encoding',$encoding);
			
		$user_db = '';

		if (isset($datForm['user_db']))

			$user_db = $datForm['user_db'];
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_9'),'user_db',$user_db);
			
		$passwd_db = '';
			
		if (isset($datForm['passwd_db']))
			
			$passwd_db = $datForm['passwd_db'];
			
		$myForm->addPassword(OPF_myLang::getPhrase('OPF_LOGIN_10'),'passwd_db',$passwd_db);
			
		$host_db = '';

		if (isset($datForm['host_db']))

			$host_db = $datForm['host_db'];
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_11'),'host_db',$host_db);
			
		$host_port = '';
			
		if (isset($datForm['host_port']))
			
			$host_port = $datForm['host_port'];
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_13'),'host_port',$host_port, NULL, 5, true);

		if ($type == 'tables'){
				
			$str = OPF_myLang::getPhrase('OPF_LOGIN_30');

			$myForm->addButton('btn_install',OPF_myLang::getPhrase('OPF_LOGIN_14'),'list.gif');
				
			$myForm->addEvent('btn_install', 'onclick', 'onClickInstall');
				
		}else{

			$str = OPF_myLang::getPhrase('OPF_LOGIN_29');

			if ($disabled)
				
				$myForm->addDisabled('btn_install');
			
			$myForm->addButton('btn_install',OPF_myLang::getPhrase('OPF_LOGIN_17'),'add.gif');
				
			$myForm->addEvent('btn_install', 'onclick', 'onClickCreateBD');
			
		}
			
		$myForm->addGroup('grp1',$str,array('engine','db','encoding','user_db','passwd_db','host_db','host_port'),1);
			
			
		return $myForm->getForm(1);
	}

	public function autenticate ($datForm){
			
		$return = false;
			
		$ess_system_users = new ess_system_users;
			
		if ($ess_system_users->find('user_name = '.$datForm['user_opf_ess'].' & passwd = '.md5($datForm['user_opf_ess'].$datForm['passwd_opf_ess']).' & status = 1' )){

			$return = true;

			$_SESSION['user_id'] = $ess_system_users->id;

			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

			$_SESSION['datetime'] = date("Y-m-d H:i:s");

			$_SESSION['profile_id'] = $ess_system_users->profile_id;

			if ($datForm['rem_usr']){
					
				setcookie("user_opf_ess", $datForm['user_opf_ess']);
					
			}else{
					
				setcookie("user_opf_ess","");
			}

		}else
		
			$this->errorLogIn = OPF_myLang::getPhrase('OPF_LOGIN_1');
			
		return $return;
	}

	public function getFormLogin (){
			
		$myForm = new OPF_myForm('frm_login');
			
		$myForm->setAutoComplete('user_opf_ess', false);
			
		$user_opf_ess = '';
			
		$mark = false;
			
		if (isset($_COOKIE['user_opf_ess'])){
				
			$user_opf_ess = $_COOKIE['user_opf_ess'];

			$mark = true;
		}
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_LOGIN_2'),'user_opf_ess',$user_opf_ess);
			
		$myForm->addPassword(OPF_myLang::getPhrase('OPF_LOGIN_3'),'passwd_opf_ess');
			
		$myForm->addCheckBox(OPF_myLang::getPhrase('OPF_LOGIN_5'),'rem_usr',$mark);
			
		$myForm->addButton('btn_log',OPF_myLang::getPhrase('OPF_LOGIN_4'),'ok.gif');
			
		$myForm->addEvent('btn_log', 'onclick', 'onClickLogIn');
			
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