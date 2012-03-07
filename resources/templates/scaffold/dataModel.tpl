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
 
 class scaffolding_{name_table_scaff} {
 
 	/**
 	 * Obtiene el formualario que permite agregar un registro
 	 */
 	public static function getFormStartUp_{name_table_scaff} (){
 	
 		$myForm = new OPF_myForm('FormStartUp_{name_table_scaff}');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Obtiene el formulario principal
 	 */
 	public static function getFormAddMod{name_table_scaff}($id){
{another_tables_are_defined}
 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddMod{name_table_scaff}');
 		
 		${name_table_scaff} = new {name_table_scaff};
 		
 		if ($id)
 			${name_table_scaff}->find($id);
 		{form_reg_list_fields}
 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	/**
 	 * Lista dinámica de los registros
 	 */
 	public function getList_{name_table_scaff} (){
 		
 		$sql = '{sql_list_scaff}';
 		
 		$myList = new OPF_myList('lst_{name_table_scaff}',$sql);
 		
 		$myList->width = {width_list};
 		{real_names_in_query}
 		$myList->setExportData({setexportdata});
 		
 		$myList->setPagination({setpagination});
 		
 		$myList->setUseOrderMethod({setuseordermethod});
 		
 		{eliminar}
 		{editar}
 		{eliminar_mul}
 		{width_fields}
 		return $myList->getList({getqueryform});
 	}
 
 }
 
 class {name_table_scaff} extends OPF_myActiveRecord {
{fields_table_scaff}
 }
 
 class ess_master_tables_detail extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $master_tables_id;
 	
 	public $item_cod;
 	
 	public $item_desc;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
 
 {another_tables}
 
?>