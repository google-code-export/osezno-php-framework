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
 	
	public function form2 (){
		
		$objMyForm = new myForm('prueba',NULL,'enviar');
		
		$objMyForm->addText('Fecha:','fecha',date('Y-m-d'),10,10,true,true);
		
		
		$objMyForm->formWidth = 300;
	
		return $objMyForm->getForm(1);
	} 	
 	
 	
 	/**
 	 * Constructor de la clase
 	 *
 	 */
 	public function __construct (){
 		
 	}
 	
 	public function formulario (){
 		$objMyForm = new myForm('formulario',NULL,'onSubmitAccept');
 		
 		$objMyForm->SWF_upload_several_files = true;
 		
 		$objMyForm->addFile('Archivo:','file','upload.php');
 		
 		$objMyForm->SWF_src_img_button = 'file_find.png';
		$objMyForm->SWF_file_size_limit = 10000;
 		
 		
 		$objMyForm->SWF_debug = 'false';
 		
 		$objMyForm->formWidth = 500;
 		
 		return $objMyForm->getForm(1);
 	}

 	
 	public function builtList ($idLista){
 		
 		$sql = 'SELECT LPAD(cast(id as char),6,"0") as Llave, 
 				nombre as Nombre, 
 				precio as Valor, 
 				estado as Estado from libros';
 		
		$objList = new myList($idLista,$sql);
 
		$objList->widthList = 500;
		
 		$objList->setAliasInQuery('LPAD(cast(id as char),6,"0")','Llave');
 		$objList->setAliasInQuery('nombre','Nombre');
 		$objList->setAliasInQuery('precio','Valor');
 		$objList->setAliasInQuery('estado','Estado');
 
 		$objList->setUseOrderMethodInColumn('Llave');
 		$objList->setUseOrderMethodInColumn('Nombre');
 		$objList->setUseOrderMethodInColumn('Valor');
 		$objList->setUseOrderMethodInColumn('Estado'); 		
 		
 		
 		
 		return $objList->getList();
 	}
 	
 	/**
 	 * Destructor de la clase
 	 *
 	 */
 	public function __destruct (){
 		
 	}

 }
 
 
  class libros extends myActiveRecord {
 	
 	public $id;
 	
 	public $nombre;
 	
 	public $precio;
 	
 	public $estado;
 	
 }
 
 //$libros = new libros();
 
 $modelo = new modelo;
 
?>