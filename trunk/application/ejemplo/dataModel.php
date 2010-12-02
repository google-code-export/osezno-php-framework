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
 	
 	public function formEdit ($id){
 		
 		$usuarios = new usuarios;
 		
 		$usuarios->find($id);
 		
 		$myForm = new myForm('editar');
 		
 		$myForm->addText('Nombre:','nombre',$usuarios->nombre);
 		
 		$myForm->addText('Edad:','edad',$usuarios->edad);
 		
 		$myForm->addButton('edit','Salvar','saveUser:'.$id);
 		
 		return $myForm->getForm(1);
 	}
 	
 	public function getIndexGrid (){
 		
 		$myList = new myList('usuarios', 'select * from usuarios');
 		
 		$myList->setExportData();
 		
 		$myList->setUseOrderMethodOnColumn('nombre');
 		
 		$myList->setUseOrderMethodOnColumn('edad');
 		
 		$myList->setUseOrderMethodOnColumn('prof_id');
 		
 		$myList->setPagination(true,10);
 		
 		$myList->width = 700; 
 		
 		$myList->setWidthColumn('usuario_id',150);
 		
 		$myList->setWidthColumn('nombre',250);
 		
 		$myList->setWidthColumn('edad',150);
 		
 		$myList->setWidthColumn('prof_id',150);
 		
 		$myList->setEventOnColumn('usuario_id','editUsuario');
 		
 		$myList->setGlobalEventOnColumn('usuario_id',array('globalModify'=>'Modificar'));
 		
 		return $myList->getList(true);
 	}
 	
 	public function getIndexForm (){
 		
 		$myForm = new myForm('index_form');
 		
 		$myForm->addSelect('Sexo:','sex',array('F'=>'Femenino','M'=>'Masculino'),array('F','M'),5,0,true);
 		 		
 		$myForm->addButton('bt1','Salvar','onClickSave');
 		
 		return $myForm->getForm(1);
 	}
 	
 	public function getTabs (){
 		
 		$myTabs = new myTabs;
 		
 		$myTabs->addTab('Registros','indexGrid.php');
 		
 		$myTabs->addTab('Agregar','indexForm.php');
 		
 		return $myTabs->getTabsHtml('Registros');
 	}
 	

 }
 
 class usuarios extends myActiveRecord {
 	
 	public $usuario_id;
 	
 	public $edad;
 	
 	public $nombre;
 	
 	public $prof_id;
 	
 }
 
 $modelo = new modelo;
 
?>