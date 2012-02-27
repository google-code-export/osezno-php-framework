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
include '../../config/configApplication.php';

class OPF_admUsr {

	public function getBtnAgrUsr (){
			
		$myForm = new OPF_myForm('getBtnAgrUsr');
			
		$myForm->addButton('btnagr',LABEL_BTN_ADD,'add.gif');
			
		$myForm->addEvent('btnagr', 'onclick', 'onClickNewRecord');
			
		return $myForm->getForm(1);
	}

	public function getFormAgrUsr ($user_id = ''){
			
		$ess_profiles = new ess_profiles;
			
		$profilesArray = array ();
			
		foreach ($ess_profiles->find() as $profile){

			$profilesArray[$profile->id] = $profile->name;
		}
			
		$ess_system_users = new ess_system_users;
			
		$myForm = new OPF_myForm('getFormAgrUsr');
			
		if ($user_id){

			$ess_system_users->find($user_id);

			$myForm->addDisabled('user_name');
		}
			
		$myForm->styleClassForm = '';
			
		$myForm->addText(OPF_ADMUSR_1,'user_name',$ess_system_users->user_name,15);
			
		$myForm->addText(OPF_ADMUSR_2,'name',$ess_system_users->name,15);
			
		$myForm->addText(OPF_ADMUSR_3,'lastname',$ess_system_users->lastname,15);
			
		$myForm->addPassword(OPF_ADMUSR_4,'passwd1',$ess_system_users->passwd,15);
			
		$myForm->addPassword(OPF_ADMUSR_5,'passwd',$ess_system_users->passwd,15);
			
		$myForm->addSelect(OPF_ADMUSR_6,'profile_id',$profilesArray,$ess_system_users->profile_id);
			
		$status = false;
			
		if ($ess_system_users->status == 1)
			
		$status = true;
			
		$myForm->addCheckBox(OPF_ADMUSR_7,'status', $status);
			
		$myForm->addButton('btnsave',LABEL_BTN_SAVE,'save.gif');
			
		$myForm->addEvent('btnsave', 'onclick', 'onClickSaveRecord',$user_id);
			
		return $myForm->getForm(1);
	}

	public function getListUsrs (){
			
		$myAct = new OPF_myActiveRecord();
			
		$arrReplace = array(
			
 			'OPF_FIELD_MODIFICAR' => OPF_FIELD_MODIFICAR,

 			'OPF_FIELD_ELIMINAR' => OPF_FIELD_ELIMINAR, 

 			'OPF_FIELD_USUARIO' => OPF_FIELD_USUARIO, 

 			'OPF_FIELD_NOMBRE' => OPF_FIELD_NOMBRE,

 			'OPF_FIELD_APELLIDO' => OPF_FIELD_APELLIDO,

 			'OPF_FIELD_ACTUALIZADO' => OPF_FIELD_ACTUALIZADO, 

 			'OPF_FIELD_PERFIL' => OPF_FIELD_PERFIL, 

 			'OPF_ADMUSR_11' => OPF_ADMUSR_11,

 			'OPF_ADMUSR_10' => OPF_ADMUSR_10,

 			'OPF_FIELD_ESTADO' => OPF_FIELD_ESTADO
			
		);
			
		$myList = new OPF_myList('lst_users',$myAct->loadSqlFromFile('sql/lst_users.sql',$arrReplace));
			
		$myList->width = 950;
			
		$myList->setWidthColumn(OPF_FIELD_MODIFICAR, 70);
			
		$myList->setWidthColumn(OPF_FIELD_ELIMINAR, 70);
			
		$myList->setWidthColumn(OPF_FIELD_USUARIO, 150);
			
		$myList->setWidthColumn(OPF_FIELD_NOMBRE, 150);
			
		$myList->setWidthColumn(OPF_FIELD_APELLIDO, 150);
			
		$myList->setWidthColumn(OPF_FIELD_PERFIL, 150);
			
		$myList->setWidthColumn(OPF_FIELD_ACTUALIZADO, 160);
			
		$myList->setRealNameInQuery(OPF_FIELD_USUARIO, 'ess_system_users.user_name');
			
		$myList->setRealNameInQuery(OPF_FIELD_NOMBRE, 'ess_system_users.name');
			
		$myList->setRealNameInQuery(OPF_FIELD_APELLIDO, 'ess_system_users.lastname');
			
		$myList->setRealNameInQuery(OPF_FIELD_PERFIL, 'ess_profiles.name');
			
		$myList->setRealNameInQuery(OPF_FIELD_ACTUALIZADO, 'ess_system_users.datetime');
			
		$myList->setRealNameInQuery(OPF_FIELD_ESTADO, 'ess_system_users.status');
			
		$myList->setEventOnColumn(OPF_FIELD_MODIFICAR, 'onClickNewRecord');
			
		$myList->setEventOnColumn(OPF_FIELD_ELIMINAR, 'onClickDeleteRecord',OPF_FIELD_CONFIRM_ELIMINAR);
			
		$myList->setUseOrderMethod(true,OPF_FIELD_ACTUALIZADO);

		$myList->setPagination(true,50);
			
		$myList->setExportData(true,true,true);

		$myList->setGlobalEventOnColumn(OPF_FIELD_MODIFICAR,array(OPF_ADMUSR_8=>'habilitaUsuarios',OPF_ADMUSR_9=>'inhabilitaUsuarios'));
			
		return $myList->getList(true,true);
	}

}

class ess_profiles extends OPF_myActiveRecord {

	public $id;

	public $name;

	public $description;

	public $user_id;

	public $datetime;

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