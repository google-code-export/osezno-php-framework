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
 	
 	public function getIndexGrid (){
 		
 		$myList = new myList('usuarios', 'select * from usuarios');
 		
 		$myList->setUseOrderMethodOnColumn('nombre');
 		
 		$myList->setPagination(true,20);
 		
 		$myList->width = 700; 
 		
 		return $myList->getList(false);
 	}
 	
 	public function getIndexForm (){
 		
 		sleep(10);
 		
 		$myForm = new myForm('index_form');
 		
 		$myForm->addText('Nombre usuario:','nom');
 		
 		$myForm->addText('Apellido usuario:','ape');
 		
 		$myForm->addButton('bt1','Salvar','onClickSave');
 		
 		return $myForm->getForm(1);
 	}
 	
 	public function getTabs (){
 		
 		$myTabs = new myTabs;
 		
 		$myTabs->addTab('Registros','indexGrid.php');
 		
 		$myTabs->addTab('Agregar','indexForm.php');
 		
 		return $myTabs->getTabsHtml();
 	}
 	

 }
 
 $modelo = new modelo;
 
?>