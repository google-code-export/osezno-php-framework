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

class OPF_profiles {

	private $groups = array();

	private $maxCols = 0;

	private $arrItems = array();

	private function walkItems ($numSpaces){
			
		$ess_menu = new ess_menu();
			
		$ess_menu->setAutoQuotesInFind(false);

		foreach ($ess_menu->query('SELECT * FROM ess_menu WHERE menu_id is NULL order by ord ASC') as $menuOpt){
				
			$this->arrItems[] = $numSpaces.':'.$menuOpt->id.':'.$menuOpt->description;

			$this->recurWalkItems($ess_menu,$menuOpt->id,($numSpaces+1));
		}
			
	}

	private function recurWalkItems ($menu,$id,$numSpaces){
			
		foreach ($menu->find('menu_id = '.$id) as $row){

			if ($numSpaces>=$this->maxCols)

			$this->maxCols = $numSpaces;

			$this->arrItems[] = $numSpaces.':'.$row->id.':'.$row->description;

			$this->recurWalkItems($menu,$row->id,$numSpaces+1);
		}
			
	}

	public function getFormSetProfile ($profile_id){
			
		$ess_profiles_detail = new  ess_profiles_detail;
			
		$itemOnProfile = array();

		foreach ($ess_profiles_detail->find('profiles_id = '.$profile_id) as  $row)

		$itemOnProfile[$row->menu_id] = $row->id;

		$this->walkItems(0);
			
		$myForm = new OPF_myForm('FormSetProfile');
			
		$myForm->styleClassForm = '';
			
		$myForm->useRowSeparator = true;
			
		foreach ($this->arrItems as $opt){

			list($numSpaces, $id, $desc) = explode(':',$opt);

			for ($i=0;$i<$numSpaces;++$i){

				$add = '&nbsp;';
					
				if ($i==($numSpaces-1))
					
				$add = '->';
					
				$myForm->addFreeObject('cm1_'.$i.'_'.$id, '',$add);
					
				$this->groups[] = 'cm1_'.$i.'_'.$id;
					
			}

			$sts = false;

			if (isset($itemOnProfile[$id]))

			$sts = true;

			$myForm->addCheckBox($desc,'chk_'.$id,$sts);

			$this->groups[] = 'chk_'.$id;

			for ($j=($numSpaces+1);$j<$this->maxCols+1;++$j){
					
				$myForm->addComment('cm2_'.$j.'_'.$id, '&nbsp;');

				$this->groups[] = 'cm2_'.$j.'_'.$id;
			}

		}
			
		$myForm->addButton('btn_save_',OPF_myLang::getPhrase('LABEL_BTN_SAVE'),'save.gif');
			
		$myForm->addButton('btn_cancel_',OPF_myLang::getPhrase('LABEL_BTN_CANCEL'),'cancel.gif');
			
		$myForm->addEvent('btn_cancel_', 'onclick', 'onClickCancelConfirm');
			
		$myForm->addEvent('btn_save_', 'onclick', 'onClickSaveProfileDet',$profile_id);
			
		$myForm->border = 0;
			
		$myForm->width = ($this->maxCols+1)*(180);
			
		$myForm->addGroup('resources',OPF_myLang::getPhrase('OPF_PROFILES_4'),$this->groups,$this->maxCols+1);
			
		return $myForm->getForm(2);
	}

	public function getFormStartUp (){
			
		$myForm = new OPF_myForm('FormStartUp');
			
		$myForm->addButton('btn_up',OPF_myLang::getPhrase('LABEL_BTN_ADD'),'add.gif');
			
		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
			
		return $myForm->getForm(1);
	}

	public function getFormAddModProfile ($id = ''){
			
		$myForm = new OPF_myForm('FormAddModProfile');
			
		$ess_profiles = new ess_profiles;
			
		if ($id)
			
			$ess_profiles->find($id);
			
		$myForm->styleClassForm = '';
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_PROFILES_5'),'name',$ess_profiles->name,20,50);
			
		$myForm->addTextArea(OPF_myLang::getPhrase('OPF_PROFILES_6'),'description',$ess_profiles->description,40,6);
			
		$myForm->addButton('btn_save',OPF_myLang::getPhrase('LABEL_BTN_SAVE'),'save.gif');
			
		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
			
		return $myForm->getForm(1);
	}

	public function getListProfiles (){
			
		$myAct = new OPF_myActiveRecord();
			
		$arrRpl = array (
			
 			'OPF_FIELD_MODIFICAR' => 	OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'),

 			'OPF_FIELD_ELIMINAR' => 	OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'),

 			'OPF_FIELD_PERFIL' => 		OPF_myLang::getPhrase('OPF_FIELD_PERFIL'),

 			'OPF_FIELD_DESCRIPCION' => 	OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'),

 			'OPF_FIELD_USUARIO' => 		OPF_myLang::getPhrase('OPF_FIELD_USUARIO'),

 			'OPF_FIELD_DATETIME' => 	OPF_myLang::getPhrase('OPF_FIELD_DATETIME'),

 			'OPF_FIELD_MENU' => 		OPF_myLang::getPhrase('OPF_FIELD_MENU')
			
		);
			
		$myList = new OPF_myList('lst_profiles',$sql = $myAct->loadSqlFromFile(dirname(__FILE__).DS.'sql'.DS.'lstProfiles.sql',$arrRpl));
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 'onClickAddRecord');
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 'onClickDeleteRecord',OPF_myLang::getPhrase('OPF_FIELD_CONFIRM_ELIMINAR'));
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MENU'), 'onClickEditMenu');
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 100);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_MENU'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_PERFIL'), 140);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DATETIME'), 120);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 400);
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_PERFIL'), 'ess_profiles.name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 'ess_profiles.description');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 'ess_system_users.user_name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_DATETIME'), 'ess_profiles.datetime');
			
		$myList->setPagination(true,20);
			
		$myList->setExportData(true,true,true);
			
		$myList->setUseOrderMethod(true,'');
			
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

?>