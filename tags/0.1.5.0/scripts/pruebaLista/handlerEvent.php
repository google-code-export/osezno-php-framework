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

 	public function enviar_formulario (){
 		
 		$tablas = new tablas;
 		
 		//$myTime = new myTime;
 		//$myTime->timeStart();
 		
 		$this->assign('other_area','innerHTML',$tablas->prepararObtener_listaDinamica());
 		
 		//$this->alert($myTime->timeEnd());
 		
 		return $this->response;
 	}
 	
 	
 	
 	public function onClick_saludar ($j1,$j2){
 		
 		$this->alert($j1+$j2);
 		
 		return $this->response;
 	}
 	
 	
 	
 	
 	public function onClick_otro1 ($datos){
 		
 		$this->alert($_SESSION['prdLst']['lista_usuarios']['sql']);
 		
 		return $this->response;
 	}
 	
 	public function onClick_otro2 ($datos){
 		
 		$this->alert($_SESSION['prdLst']['lista_usuarios']['sqlt']);
 		
 		return $this->response;
 	}
 	
 	public function mostrar_nombre ($nombre){
 		
 		$this->alert($nombre);
 		
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