<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include 'dataModel.php';
 
/**
 * Manejador de eventos de usuario
 *
 */	
 class eventos extends OPF_myController {

 	/**
 	 * Ejemplo de evento
 	 * 
 	 * @param $params
 	 * @return string
 	 */
 	public function onLoadShowConfig (){
 		
 		$this->modalWindow(testInstall::getInfoOPF(),'Current configuration',700,320);
 		
 		return $this->response;
 	}
 	
 	public function onClickTestDB (){
 		
 		$myAct = new OPF_myActiveRecord();
 		
 		if ($myAct->isSuccessfulConnect()){
 			
 			$this->messageBox('Successful connection!','info');
 			
 		}else{
 			
 			$this->heightMessageBox = 230;
 			
 			$this->errorBox('Connection refused.',$myAct->getErrorLog());
 		}
 		
 		return $this->response;
 	}
 	
	
 }

 
 
 
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new OPF_osezno($objxAjax,$theme);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>