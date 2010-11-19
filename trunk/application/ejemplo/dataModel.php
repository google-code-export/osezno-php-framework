<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   * 
   * dataModel.php: 
   * Modelo del datos del Modulo
   * - Acceso a datos de las bases de datos
   * - Retorna informacion que el Controlador muestra al usuario
   */

 include 'configMod.php';
 
 
 /**
  * Clase base del Modelo de Datos
  * - Usted puede cambiar el nombre
  */
 class modelo {
 	
 	public function formEdit($id){
 		
 		$usuarios = new usuarios();
 		
 		$usuarios->find($id);
 		
 		$profesion = new profesion();
 		
 		$profesiones = array();
 		
 		foreach ($profesion->find() as $row)
 			$profesiones[$row->prof_id] = $row->profesion;
 		
 		$objMyForm = new myForm('editRow');
 		
 		$objMyForm->addText('Nombre:','nombre',$usuarios->nombre);
 		
 		$objMyForm->addText('Edad:','edad',$usuarios->edad,4,2,true);
 		
 		$objMyForm->addSelect('Profesión:','prof_id',$profesiones,$usuarios->prof_id);

 		$objMyForm->addButton('b1','Guardar','onSubmitSaveChanges:'.$id,'save.gif');
 		
 		return $objMyForm->getForm(1);
 	}
 	
	public function form2 (){
		
		$objMyForm = new myForm('prueba');
		
		$objMyForm->addCheckBox('Check me!','cheq');
		
		$objMyForm->addText('Fecha Inicial:','fecha1',date('Y-m-d'),10,10,true,true);
		
		$objMyForm->addText('Fecha Finals:','fecha2',date('Y-m-d'),10,10,true,true);
		
		$objMyForm->width = 300;
		
		$objMyForm->addButton('word','Word','alert','word.gif');
		
		$objMyForm->addButton('excel','Excel','alert','excel.gif');
		
		$objMyForm->addButton('ok','Ok','procesarFormulario','ok.gif');
		
		$objMyForm->addButton('cancel','Cancel','buttonCancel','cancel.gif');
		
		$objMyForm->addButton('list','Grid','showGrid','list.gif');
		
		$objMyForm->width = 750;
		
		return $objMyForm->getForm(3);
	} 	
 	
 	
 	/**
 	 * Constructor de la clase
 	 *
 	 */
 	public function __construct (){
 		
 	}
 	
 	public function formulario (){
 		$objMyForm = new myForm('formulario',NULL,'onSubmitAccept');
 		
 		$objMyForm->FILE_src_img_button = 'add.gif';
 		
 		$objMyForm->FILE_upload_several_files = true;
 		
 		$objMyForm->FILE_debug = true;
 		
 		$objMyForm->addFile('Archivo plano:','file','upload.php');
 		
 		$objMyForm->FILE_src_img_button = 'add.gif';
		$objMyForm->FILE_size_limit = 100;
 		
 		
 		$objMyForm->FILE_debug = 'false';
 		
 		$objMyForm->formWidth = 500;
 		
 		$objMyForm->addButton('saludar','Saludar','procesarFormulario','ok.gif');
 		
 		return $objMyForm->getForm(1);
 	}

 	
 	public function builtList ($idLista){
 		
		$usuarios = new usuarios;
		
 		$objList = new myList($idLista,$usuarios->loadSqlFromFile('sql/query.sql'));
 		
 		$objList->setUseOrderMethodOnColumn('usuario_id');
 		$objList->setUseOrderMethodOnColumn('nombre');
 		$objList->setUseOrderMethodOnColumn('edad');
 		$objList->setUseOrderMethodOnColumn('prof_id');
 		
 		$objList->setAliasInQuery('usuario_id','Eliminar');
 		$objList->setAliasInQuery('nombre','Nombre','string');
 		$objList->setAliasInQuery('edad','Edad','numeric');
 		$objList->setAliasInQuery('prof_id','Profesion','date');
 		
 		//$objList->setEventOnColumn('usuario_id','deleteRecord','¿Desea borrar el registro?');
 		$objList->setEventOnColumn('actualizar','updateRecord','¿Desea actualizar el registro?');
 		
 		$objList->setGlobalEventOnColumn('usuario_id',array('showRecords_1'=>'Actualizar','showRecords_2'=>'Eliminar','showRecords_3'=>'Modificar'));
 		
 		$objList->setWidthColumn('usuario_id',100);
 		$objList->setWidthColumn('actualizar',100);
 		$objList->setWidthColumn('nombre',300);
 		
 		$objList->widthList = 750;
 		
 		$objList->setExportData(true,true,false);
 		
 		$objList->setPagination(true,50);
 		
 		return $objList->getList(true);
 	}
 	
 	/**
 	 * Destructor de la clase
 	 *
 	 */
 	public function __destruct (){
 		
 	}

 }

 class usuarios extends myActiveRecord {
 	
 	public $usuario_id;
 	
 	public $nombre;
 	
 	public $edad;
 	
 	public $prof_id;
 	
 }
 
 class profesion extends myActiveRecord {
 	
 	public $prof_id;
 	
 	public $profesion;
 	
 }
 
 
 $modelo = new modelo;
 
?>