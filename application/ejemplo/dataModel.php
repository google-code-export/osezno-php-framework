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
 	
 	public function formEdit ($id ='',$from = ''){
 		
 		$usuarios = new usuarios;
 		
 		if ($from=='grid')
 			$usuarios->find($id);
 		
 		$profesiones = new profesiones;
 		
 		$profs = array();
 		
 		foreach ($profesiones->find() as $row)
 			$profs[$row->prof_id] = $row->profesion; 
 		
 		$myForm = new myForm('editar');
 		
 		$myForm->addText('Nombre:','nombre',$usuarios->nombre);
 		
 		$myForm->addText('Apellido:','apellido',$usuarios->apellido);
 		
 		$myForm->addText('Edad:','edad',$usuarios->edad,3,3,true);
 		
 		$myForm->addSelect('Profesion:','prof_id',$profs, $usuarios->prof_id);
 		
 		$myForm->addButton('edit','Guardar','ok.gif');
 		
 		$myForm->addButton('cancel','Cancelar','cancel.gif');
 		
 		$myForm->addEvent('cancel','onclick','cancelAdd',array($from));
 		
 		$myForm->addEvent('edit','onclick','saveUser',array('a','b'),4);
 		
 		$myForm->width = 400;
 		
 		return $myForm->getForm(2);
 	}
 	
 	public function getIndexGrid (){
 		
 		$myAct = new myActiveRecord();
 		
 		$myList = new myList('usuarios', $myAct->loadSqlFromFile('sql/query.sql'));
 		
 		$myList->setExportData();
 		
 		$myList->setUseOrderMethodOnColumn('Nombre');
 		
 		$myList->setUseOrderMethodOnColumn('Apellido');
 		
 		$myList->setUseOrderMethodOnColumn('Edad');
 		
 		$myList->setUseOrderMethodOnColumn('Profesion');
 		
 		$myList->setPagination(true,10);
 		
 		$myList->width = 700; 
 		
 		$myList->setWidthColumn('Modificar',100);
 		
 		$myList->setWidthColumn('Nombre',150);
 		
 		$myList->setWidthColumn('Apellido',150);
 		
 		$myList->setWidthColumn('Edad',100);
 		
 		$myList->setWidthColumn('Profesion',200);
 		
 		$myList->setEventOnColumn('Modificar','editUsuario');
 		
 		$myList->setGlobalEventOnColumn('Modificar',array('globalModify'=>'Eliminar'));
 		
 		return $myList->getList(true);
 	}
 	
 	public function getTabs (){
 		
 		$myTabs = new myTabs;
 		
 		$myTabs->addTab('Registros','indexGrid.php');
 		
 		$myTabs->addTab('Agregar','indexForm.php');
 		
 		return $myTabs->getTabsHtml('Registros');
 	}
 	

 }

 class profesiones extends myActiveRecord {
 	
 	public $prof_id;
 	
 	public $profesion;
 	
 }
 
 class usuarios extends myActiveRecord {
 	
 	public $usuario_id;
 	
 	public $edad;
 	
 	public $nombre;
 	
 	public $apellido;
 	
 	public $prof_id;
 	
 }
 
 $modelo = new modelo;
 
?>