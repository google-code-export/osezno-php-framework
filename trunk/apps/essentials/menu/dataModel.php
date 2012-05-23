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

class menuOPF extends OPF_menu {

	private $charSpace = '&nbsp;&nbsp;';

	private $menu;

	public function __construct(){
			
		$this->menu = new ess_menu();
			
		$this->menu->setAutoQuotesInFind(false);
			
		foreach ($this->menu->query('SELECT * FROM ess_menu WHERE menu_id is NULL order by ord ASC') as $menuOpt){

			$this->arrOpt[$menuOpt->id] = '+ ['.$menuOpt->ord.'] '.$menuOpt->description;

			$this->calcRecursive($menuOpt->id,1);
		}
			
	}

	private function calcRecursive ($menu_id,$numSpaces){
			
		foreach ($this->menu->find('menu_id = '.$menu_id) as $menuOpt){

			$this->arrOpt[$menuOpt->id] = str_repeat($this->charSpace, $numSpaces).'+ ['.$menuOpt->ord.'] '.$menuOpt->description;

			$this->calcRecursive($menuOpt->id,($numSpaces+1));
		}
			
	}

}

class OPF_menu {

	protected $arrOpt = array ();

	public function getFormStarUp (){
			
		$myForm = new OPF_myForm('FormStarUp');
			
		$myForm->addButton('btn_starup',OPF_myLang::getPhrase('LABEL_BTN_ADD'),'add.gif');
			
		$myForm->addEvent('btn_starup', 'onclick', 'onClickAddModRecord');
			
		return $myForm->getForm(1);
	}

	public function getFormAddModRecord ($id = ''){

		$ess_menu = new ess_menu;

		if ($id)

		$ess_menu->find($id);

		$arrIcons = array (
			
		array ('img/imgfolder.gif','imgfolder','Image folder'),

		array ('img/musicfolder.gif','musicfolder','Music folder'),
			
		array ('img/page.gif','page','Page'),
			
		array ('img/cd.gif','cd','Cd'),
			
		array ('img/base.gif','osezno','Osezno PHP Framefork logo'),
			
		array ('img/globe.gif','globe','Globe'),

		array ('img/question.gif','question','Question'),

		array ('img/trash.gif','trash','Trash')
			
		);
			
		$myForm = new OPF_myForm('FormAddModRecord');
			
		$htmlInconsel = '<select name="icon" id="icon" class="'.$myForm->styleClassFields.'">';
			
		$htmlInconsel .= '<option>'.OPF_myLang::getPhrase('LABEL_FIRST_OPT_SELECT_FIELD').'</option>';
			
		foreach ($arrIcons as $icon){

			$sel = '';

			if ($ess_menu->icon == $icon[0] && $ess_menu->icon)

			$sel = 'selected';

			$htmlInconsel .= '<option '.$sel.' value="'.$icon[0].'" id="'.$icon[1].'">'.$icon[2].'</option>';

		}
			
		$htmlInconsel .= '</select>';
			
			
		$myForm->styleClassForm = '';
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_MENU_4'),'description:2',$ess_menu->description,15,50);
			
		$myForm->selectStringFirstLabelOption = '/';
			
		$myForm->addSelect(OPF_myLang::getPhrase('OPF_MENU_5'),'menu_id:2',$this->arrOpt,$ess_menu->menu_id);
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_MENU_6'),'ord:2',$ess_menu->ord,2,3,true);

		$myForm->addFreeObject('fo1:2','Icono:',$htmlInconsel);
			
		$myForm->addTextArea(OPF_myLang::getPhrase('OPF_MENU_7'),'url:2',$ess_menu->url,50,2);
			
		$myForm->addButton('btn_dir',OPF_myLang::getPhrase('OPF_MENU_8'),'find.gif');
			
		$myForm->addButton('btn_save',OPF_myLang::getPhrase('LABEL_BTN_SAVE'),'save.gif');
			
		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
			
		$myForm->addEvent('btn_dir', 'onclick', 'onClickFindMod');
			
		return $myForm->getForm(2);
	}

	public function getList (){
			
		$myAct = new OPF_myActiveRecord();
			
		$arRpl = array (
			
 			'OPF_FIELD_MODIFICAR' => 	OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'),

 			'OPF_FIELD_ELIMINAR' => 	OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'),

 			'OPF_FIELD_ID' => 			OPF_myLang::getPhrase('OPF_FIELD_ID'),

 			'OPF_FIELD_PADRE' => 		OPF_myLang::getPhrase('OPF_FIELD_PADRE'),

 			'OPF_FIELD_DESCRIPCION' => 	OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'),

 			'OPF_FIELD_ICON' => 		OPF_myLang::getPhrase('OPF_FIELD_ICON'),

 			'OPF_FIELD_URL' => 			OPF_myLang::getPhrase('OPF_FIELD_URL'),

 			'OPF_FIELD_ORDEN' => 		OPF_myLang::getPhrase('OPF_FIELD_ORDEN'),

 			'OPF_FIELD_USUARIO' => 		OPF_myLang::getPhrase('OPF_FIELD_USUARIO'),

 			'OPF_FIELD_DATETIME' => 	OPF_myLang::getPhrase('OPF_FIELD_DATETIME')

		);
			
		$myList = new OPF_myList('lst_menu',$myAct->loadSqlFromFile(dirname(__FILE__).DS.'sql'.DS.'list_menu.sql',$arRpl));
			
		$myList->width = 1100;
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ID'), 50);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_PADRE'), 125);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 125);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ICON'), 60);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ORDEN'), 40);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 100);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DATETIME'), 120);
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_ID'), 'ess_menu.id');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_PADRE'), 'same.description');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 'ess_menu.description');

		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_ICON'), 'ess_menu.icon');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_URL'), 'ess_menu.url');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_ORDEN'), 'ess_menu.ord');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 'ess_system_users.user_name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_DATETIME'), 'ess_menu.datetime');
			
		$myList->setUseOrderMethod(true,OPF_myLang::getPhrase('OPF_FIELD_DATETIME'),'DESC');
			
		$myList->setExportData(true,true,true);
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 'onClickAddModRecord');
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 'onClickDeleteRecord',OPF_myLang::getPhrase('OPF_FIELD_CONFIRM_ELIMINAR'));
			
		$myList->setPagination(true,50);
			
		return $myList->getList(true,true);
	}

}

?>