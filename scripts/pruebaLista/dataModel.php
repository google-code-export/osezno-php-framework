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
 
 
 class otra {
 	
 	public function otra ($value){
 		return $value.'conesto';
 	}
 	
 }
 
 
 /**
  * Clase base del Modelo de Datos
  * - Usted puede cambiar el nombre
  */
 class tablas {
 	
 	/**
 	 * Constructor de la clase
 	 *
 	 */
 	public function __construct (){
 		
 	}
 	
 	
 	public function prepararObtener_listaDinamica (){
 		
 		$idLista = 'lista_usuarios';
 		
 		$sqlLista = 'SELECT id,nombre as apodo,apellido as nadita FROM usuarios';
 		
 		$objDinamicList = new myDinamicList($idLista, $sqlLista);
 		
 		//$objDinamicList->setPagination($idLista,5);
 		
 		$objDinamicList->setShowOrderMethod($idLista,true);

 		
 		$objDinamicList->STYLE_ancho_lista = 1000;
 		
 		//$objDinamicList->mixColumnInArray($idLista,'id',array(6=>'Seis',8=>'Ocho'));
 		
		//$objDinamicList->setColumn($idLista,'id','onClick_saludar'); 		
 		
		
		$otra = new otra;
		
		//$objDinamicList->setFunctionInColumn($idLista,'nombre',$otra,'otra');
		
		
		$objDinamicList->setFilterByColumn($idLista,'nadita',true);
		
 		
 		$objDinamicList->savePreferences($idLista);
 		 		
 		return $objDinamicList->getDinamicList($idLista,true);
 	}
 	
 	
 	public function obtenerFormulario (){
 		$objMyForm = new myForm('formulario',NULL,'enviar_formulario');

 		$objMyForm->formWidth = 300;
 		
 		$objMyForm->strSubmit = 'Lista';
 		
 		/**
 		 * Otro boton
 		 */
 		$objMyForm->addButton('otro1','SQL','onClick_otro1','save.png');
 		$objMyForm->addButton('otro2','SQLT','onClick_otro2','save.png');
 		
 		return $objMyForm->getForm();
 	}
 	
 	
 	/**
 	 * Destructor de la clase
 	 *
 	 */
 	public function __destruct (){
 		
 	}

 }
 
?>