<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   *  
   * handlerEvent.php: 
   * Manejador de eventos del Usuario
   *  
   */

 include 'dataModel.php';
 
/**
 * Manejador de eventos de usuario
 *
 */	
 class eventos extends myController {

 	public function buttonOk ($datForm){
 		
 		$this->notificationWindow('Ok',3,'ok');
 		
 		
 		return $this->response;
 	}

  	public function buttonCancel ($datForm){
 		
 		$this->notificationWindow('Cancel',3,'cancel');
 		
 		
 		return $this->response;
 	} 	
 	
	public function showGrid ($datForm){
		
		$modelo = new modelo;
		
		$this->modalWindow($modelo->builtList('lista'),'Listado',520,250);
		
		return $this->response;
	}
 	
 	
 	public function onSubmitAccept(){
 		
 		$objMyForm = new myForm('formulario',NULL,'procesarFormulario');
 		
 		$objMyForm->addText('Nombre:','nombre');
 		$objMyForm->addText('Apellido:','apellido');
 		
 		$objMyForm->addText('Nombre:','nombre1');
 		$objMyForm->addText('Nombre:','nombre2');
 		$objMyForm->addText('Nombre:','nombre3');
 		$objMyForm->addText('Nombre:','nombre4');
 		$objMyForm->addText('Nombre:','nombre5');
 		$objMyForm->addText('Nombre:','nombre6');
 		$objMyForm->addText('Nombre:','nombre7');
 		$objMyForm->addText('Nombre:','nombre8');
 		$objMyForm->addText('Nombre:','nombre9');
 		//$objMyForm->addText('Nombre:','nombre10');
 		//$objMyForm->addText('Nombre:','nombre11');
 		//$objMyForm->addText('Nombre:','nombre12');
 		//$objMyForm->addText('Nombre:','nombre12');
 		//$objMyForm->addText('Nombre:','nombre13');
 		
 		$objMyForm->addHelp('nombre','Saludos a The Code Machine');
 		
 		$objMyForm->formHeight = 0;
 		
 		//$this->modalWindow($objMyForm->getForm(1),'The Code Machine',400,400);
 		//$this->modalWindow('hola','The Code Machine',400,400);
 		
 		$this->messageBox(NULL,'Hola',array('Acpetar'=>NULL),'ERROR');
 		
 		return $this->response;
 	}
 	

 	
 	public function procesarFormulario (){
 		/*
 		$objMyForm = new myForm('formulario','procesarFormulario');
 		
 		$objMyForm->addText('Nombre:','nombre');
 		$objMyForm->addText('Apellido:','apellido');
 		
 		$objMyForm->addHelp('nombre','Saludos a The Code Machine');
 		
 		$objMyForm->height = 0;
 		
 		$this->modalWindow($objMyForm->getForm(1),'The Code Machine',400,200,2);
 		
 		$this->notificationWindow('Nueva ventana...',2);
 		*/

		//$this->messageBox('text text text text text text text text text text text text text text text text text text text text text ');
 		
 		//$this->modalWindow('hola','Hola',100,600,2);
 		
 		//$this->modalWindowFromUrl('index.php2','Yahoo',400,400);
 		
 		$this->errorBox('lkjflskdj lksdjf ','Error en la consulta sql');
 		
 		return $this->response;
 	}
	
 }

 
 
 
 /**
  * No modificar
  */
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new osezno($objxAjax);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>