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
 	
 	/**
 	 * Constructor de la clase
 	 *
 	 */
 	public function __construct (){
 		
 	}
 	
 	public function getMainForm (){
 		
 		$objMyForm = new myForm('main_form');
 		
 		$objMyForm->addButton('new_record','Nuevo','onClickGetFormAddRecord','new.gif');
 		
 		$objMyForm->addButton('show_records','Registros','onClickGetListRecords','list.gif');
 		
 		$objMyForm->width = 400;
 		
 		return $objMyForm->getForm();
 	} 
 	
 	public function builtList ($idLista){
 		
		$usuarios = new usuarios;
		
 		$objList = new myList($idLista,$usuarios);
 		
 		$objList->setPagination(true,15);
 		
 		$objList->widthList = 700;
 		
 		$objList->setAliasInQuery('edad','Eda');
 		
 		$objList->setEventOnColumn('edad','onClickCalcular');
 		
 		$objList->setExportData();
 		
 		$objList->setUseOrderMethodOnColumn('nombre');
 		
 		$objList->setWidthColumn('usuario_id',70);
 		
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