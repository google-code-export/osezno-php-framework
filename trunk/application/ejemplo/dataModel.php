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
 	
 	public function builtList ($idLista){
 		
		$usuarios = new usuarios;
		
 		$objList = new myList($idLista,$usuarios);
 		
 		$objList->setPagination(true,15);
 		
 		$objList->widthList = 700;
 		
 		$objList->setAliasInQuery('edad','Calcular Edad');
 		
 		$objList->setAliasInQuery('usuario_id','Ver');
 		
 		$objList->setEventOnColumn('edad','onClickCalcular');
 		
 		$objList->setEventOnColumn('usuario_id','onClickMostrarDatos');
 		
 		$objList->setExportData();
 		
 		$objList->setUseOrderMethodOnColumn('nombre');
 		
 		$objList->setUseOrderMethodOnColumn('prof_id');
 		
 		$objList->setWidthColumn('usuario_id',80);
 		
 		$objList->setWidthColumn('nombre',410);
 		
 		$objList->setWidthColumn('edad',130);
 		
 		$objList->setWidthColumn('prof_id',80);
 		
 		$objList->setGlobalEventOnColumn('usuario_id',array('onSelectDeleteRows'=>'Eliminar','onSelectUpdateRows'=>'Actualizar'));
 		
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