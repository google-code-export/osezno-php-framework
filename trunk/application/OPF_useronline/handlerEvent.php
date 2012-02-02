<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011  
   * @version: 0.1
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * 
   * developer@osezno-framework.org
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
 class eventos extends OPF_myController {

 	public function closeSessionOnUser ($id){
 		
 		$ess_usronline = new ess_usronline;
 		
 		$exito = false;
 		
 		$ess_usronline->find($id);
 				
 		if (@unlink(session_save_path().'/'.$ess_usronline->sesname))
 			
 			$exito = true;
 				
 		$ess_usronline->delete($id);
 		
 		if ($exito){
 			
 			$this->notificationWindow(htmlentities(OPF_USRONLINE_1),5,'ok');

 			$this->MYLIST_reload('users_on_line');
 			
 		}else
 		 
 			$this->notificationWindow(htmlentities(OPF_USRONLINE_2),5,'error');	 
 		
 		return $this->response;
 	}
 	
	
 }
 
 
 $objEventos = new eventos($objxAjax);
 $objOsezno  = new OPF_osezno($objxAjax,$theme);
 
 $objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
 $objxAjax->processRequest();
 
?>