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

class admTablas {

	public function getPHPCodeTable ($id){
			
		$code = '<?php'."\n\n";
			
		$code .= '#'.OPF_myLang::getPhrase('OPF_ADMTABLAS_10')."\n";
			
		$code .= 'class ess_master_tables_detail extends OPF_myActiveRecord {'."\n\n";
			
		$code .= "\t".'public $id;'."\n\n";
			
		$code .= "\t".'public $item_cod;'."\n\n";
			
		$code .= "\t".'public $item_desc;'."\r\n\n";
			
		$code .= '}'."\n\n";
			
		$code .= '#'.OPF_myLang::getPhrase('OPF_ADMTABLAS_11')."\n";
			
		$code .= '$ess_master_tables_detail = new ess_master_tables_detail;'."\n\n";

		$code .= '#'.OPF_myLang::getPhrase('OPF_ADMTABLAS_12')."\n";
			
		$code .= 'foreach ($ess_master_tables_detail->find(\'master_tables_id = '.$id.'\') as $row){'."\n\n";

		$code .= "\t".'echo $row->item_cod;'."\n\n";
			
		$code .= "\t".'echo $row->item_desc;'."\n\n";
			
		$code .= '}'."\n\n";

		$code .= '?>'."\n";
			
		$myForm = new OPF_myForm('frm_code_master_tables');
			
		$myForm->addComment('cm1', highlight_string($code,true));
			
		return $myForm->getForm(1);
	}

	public function getFormAdmTables_add (){

		$myForm = new OPF_myForm('adm_tablas_add');

		$myForm->addButton('btn_add_reg',OPF_myLang::getPhrase('LABEL_BTN_ADD'),'add.gif');

		$myForm->addEvent('btn_add_reg', 'onclick', 'onClickAddReg');

		return $myForm->getForm(1);
	}

	public function getFormAdmTables_register ($id = ''){
			
		$ess_master_tables = new ess_master_tables;
			
		if ($id)
		$ess_master_tables->find($id);

		$myForm = new OPF_myForm('adm_tablas_register');
			
		$myForm->styleClassForm = '';
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_ADMTABLAS_1'),'name',$ess_master_tables->name);
			
		$myForm->addTextArea(OPF_myLang::getPhrase('OPF_ADMTABLAS_2'),'description',$ess_master_tables->description,30);
			
		$myForm->addButton('btn_add_save',OPF_myLang::getPhrase('LABEL_BTN_SAVE'),'save.gif');
			
		$myForm->addEvent('btn_add_save', 'onclick', 'onClickSaveReg',$id);
			
		return $myForm->getForm(1);
	}

	public function getListForTables (){
			
		$myAct = new OPF_myActiveRecord();
			
		$arrReplace = array(
			
 			'OPF_FIELD_TABLA'=>OPF_myLang::getPhrase('OPF_FIELD_TABLA'),

 			'OPF_FIELD_USUARIO'=>OPF_myLang::getPhrase('OPF_FIELD_USUARIO'),

 			'OPF_FIELD_ACTUALIZADO'=>OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'),

 			'OPF_FIELD_MODIFICAR'=>OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'),

 			'OPF_FIELD_ELIMINAR'=>OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'),

 			'OPF_FIELD_DETALLE'=>OPF_myLang::getPhrase('OPF_FIELD_DETALLE'),

 			'OPF_ADMTABLAS_8'=>OPF_myLang::getPhrase('OPF_ADMTABLAS_8')

		);
			
		$myList = new OPF_myList('lst_tablas',$sql = $myAct->loadSqlFromFile(dirname(__FILE__).DS.'sql'.DS.'lst_tablas.sql',$arrReplace));
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_TABLA'), 'ess_master_tables.name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 'ess_system_users.user_name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'), 'ess_master_tables.datetime');
			
		$myList->width = 970;
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DETALLE'), 60);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'), 130);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 80);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_TABLA'), 420);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_ADMTABLAS_8'), 120);
			
		$myList->setExportData(true,true,true);
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 'onClickUpdateTable');
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 'onClickDeleteTable',OPF_myLang::getPhrase('OPF_FIELD_CONFIRM_ELIMINAR'));
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_DETALLE'), 'onClickGetDetList');
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_ADMTABLAS_8'), 'onClickGetCodePHP');
			
		$myList->setUseOrderMethod(true,OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'));
			
		return $myList->getList(true,true);
	}

}

class admDetalleTablas {

	private $table_id = '';

	private $table_name = '';

	private $detail_id;

	public function __construct($id, $detail_id = ''){
			
		$this->table_id = $id;
			
		$this->detail_id = $detail_id;
			
		$ess_master_tables = new ess_master_tables;
			
		$ess_master_tables->find($this->table_id);
			
		$this->table_name = $ess_master_tables->name;
	}

	public function getFormAdmItemTable_add(){
			
		$myForm = new OPF_myForm('FormAdmItemTable_add');
			
		$myForm->addButton('btn_add_detail',OPF_myLang::getPhrase('LABEL_BTN_ADD'),'add.gif');
			
		$myForm->addEvent('btn_add_detail', 'onclick', 'onClickGetFormAddItemTable',$this->table_id);
			
		return $myForm->getForm(1);
	}

	public function getFormAdmItemTable_register($detail_id = ''){

		$ess_master_tables_detail = new ess_master_tables_detail;
			
		if ($detail_id)
		$ess_master_tables_detail->find($detail_id);
			
		$myForm = new OPF_myForm('FormAdmItemTable_register');

		$myForm->styleClassForm = '';
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_ADMTABLAS_3'),'item_cod',$ess_master_tables_detail->item_cod);
			
		$myForm->addText(OPF_myLang::getPhrase('OPF_ADMTABLAS_2'),'item_desc',$ess_master_tables_detail->item_desc);
			
		$myForm->addButton('btn_save_detail',OPF_myLang::getPhrase('LABEL_BTN_SAVE'),'save.gif');

		$myForm->addEvent('btn_save_detail', 'onclick', 'onClickSaveItemTable',$this->table_id, $detail_id);

		return $myForm->getForm(1);
	}

	public function getListForTableDetail (){
			
		$myAct = new OPF_myActiveRecord();
			
		$arrReplace = array(

 			'OPF_FIELD_MODIFICAR' => OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'),

 			'OPF_FIELD_ELIMINAR' => OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'),

 			'OPF_FIELD_CODIGO' => OPF_myLang::getPhrase('OPF_FIELD_CODIGO'),

 			'OPF_FIELD_DESCRIPCION' => OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'),

 			'OPF_FIELD_USUARIO' => OPF_myLang::getPhrase('OPF_FIELD_USUARIO'),

 			'OPF_FIELD_ACTUALIZADO' => OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'),
			
 			'master_tables_id'=>$this->table_id
			
		);
			
		$myList = new OPF_myList('lst_tablas_detalle',$myAct->loadSqlFromFile(dirname(__FILE__).'/sql/lst_tablas_detalle.sql',$arrReplace));
			
		$myList->width = 760;

		$myList->setGlobalEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'),array(OPF_FIELD_ELIMINAR=>'onClickDeleteItems'));
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 70);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 60);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_CODIGO'), 100);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 90);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'), 130);
			
		$myList->setWidthColumn(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 310);
			
		$myList->setPagination(true,10);
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_MODIFICAR'), 'onClickUpdateDetail');
			
		$myList->setEventOnColumn(OPF_myLang::getPhrase('OPF_FIELD_ELIMINAR'), 'onClickDeleteItems',OPF_myLang::getPhrase('OPF_FIELD_CONFIRM_ELIMINAR'));
			
		$myList->setExportData(true,true,true);
			
		$myList->setUseOrderMethod(true,OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'));
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_CODIGO'), 'ess_master_tables_detail.item_cod');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_DESCRIPCION'), 'ess_master_tables_detail.item_desc');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_USUARIO'), 'ess_system_users.user_name');
			
		$myList->setRealNameInQuery(OPF_myLang::getPhrase('OPF_FIELD_ACTUALIZADO'), 'ess_master_tables_detail.datetime');
			
		return $myList->getList(true);
	}

	public function getTablename (){
			
		return $this->table_name;
	}

}

class ess_master_tables extends OPF_myActiveRecord {

	public $id;

	public $name;

	public $description;

	public $user_id;

	public $datetime;

}

class ess_master_tables_detail extends OPF_myActiveRecord {

	public $id;

	public $master_tables_id;

	public $item_cod;

	public $item_desc;

	public $user_id;

	public $datetime;

}

?>