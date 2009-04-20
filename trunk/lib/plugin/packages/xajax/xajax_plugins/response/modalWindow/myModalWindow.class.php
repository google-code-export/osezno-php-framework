<?php
 
 class myModalWindow extends xajaxResponsePlugin {

 	public function addWindow($htmlContent, $colorBackground, $intOpacity, $className) {
 		
        $this->objResponse->script("addWindow('".addslashes($htmlContent)."', '".$colorBackground."', ".$intOpacity.", '".$className."')");
        
    }
 	
 }

 $objPluginManager =& xajaxPluginManager::getInstance();
 $objPluginManager->registerPlugin(new myModalWindow());

?>