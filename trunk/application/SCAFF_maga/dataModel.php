<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include '../../config/configApplication.php';
 
 class scaffolding_maga {
 
 	public static function getFormStartUp_maga (){
 	
 		$myForm = new OPF_myForm('FormStartUp_maga');
 		
 		$myForm->addButton('btn_up',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn_up', 'onclick', 'onClickAddRecord');
 		
 		return $myForm->getForm(1);
 	}
 	
 	public static function getFormAddModmaga($id){
 	
 		$ess_master_tables_detail = new ess_master_tables_detail;
 	
 		$myForm = new OPF_myForm('FormAddModmaga');
 		
 		$maga = new maga;
 		
 		if ($id)
 			$maga->find($id);
 		
		$myForm->addText('Nombre:', 'eombre', $maga->eombre);

		$myForm->addText('Apellido:', 'apellido', $maga->apellido);

		$myForm->addText('Edad:', 'edad', $maga->edad, NULL, NULL, true);

		$myForm->addText('Fecha:', 'echa', $maga->echa, 10, 12, true, true);

		$arrayValuesciudad = array();

		foreach ($ess_master_tables_detail->find('master_tables_id = 2') as $row){

			$arrayValuesciudad[$row->id] = $row->item_desc;

		}

		$myForm->addSelect('Ciudad:', 'ciudad', $arrayValuesciudad, $maga->ciudad);

 		$myForm->addButton('btn_save',LABEL_BTN_SAVE,'save.gif');
 		
 		$myForm->addEvent('btn_save', 'onclick', 'onClickSave',$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	public function getList_maga (){
 		
 		$sql = 'SELECT maga.id AS "Eliminar", maga.id AS "Editar", maga.eombre AS "Nombre", maga.apellido AS "Apellido", maga.edad AS "Edad", maga.echa AS "Fecha", rel1.item_desc AS "Ciudad" FROM maga LEFT OUTER JOIN ess_master_tables_detail rel1 ON (rel1.id = maga.ciudad AND rel1.master_tables_id = 2) ';
 		
 		$myList = new OPF_myList('lst_maga',$sql);
 		
 		$myList->width = '690';
 		
		$myList->setRealNameInQuery('Nombre','maga.eombre');

		$myList->setRealNameInQuery('Apellido','maga.apellido');

		$myList->setRealNameInQuery('Edad','maga.edad');

		$myList->setRealNameInQuery('Fecha','maga.echa');

		$myList->setRealNameInQuery('Ciudad','rel1.item_desc');

 		$myList->setExportData(true,true,true);
 		
 		$myList->setPagination(true,50);
 		
 		$myList->setUseOrderMethod(true);
 		
 		$myList->setEventOnColumn('Eliminar','onClickDeleteRecord');

 		$myList->setEventOnColumn('Editar','onClickAddRecord');

 		$myList->setGlobalEventOnColumn('Eliminar', array('Eliminar'=>'onClickDeleteRecord') );
 		
		$myList->setWidthColumn('eombre', 150);

		$myList->setWidthColumn('apellido', 150);

		$myList->setWidthColumn('edad', 50);

		$myList->setWidthColumn('echa', 100);

		$myList->setWidthColumn('ciudad', 150);

		$myList->setWidthColumn('Eliminar', 50);

		$myList->setWidthColumn('Editar', 40);

 		return $myList->getList(true,true);
 	}
 
 }
 
 class maga extends OPF_myActiveRecord {

	public $id;

	public $eombre;

	public $apellido;

	public $edad;

	public $echa;

	public $ciudad;

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