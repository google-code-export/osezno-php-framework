<?php
 
 class myModalWindow extends xajaxResponsePlugin {

 	public function addWindow($htmlContent, $colorBackground, $intOpacity, $windth, $height) {
 		
        $this->objResponse->script("addWindow('".addslashes(eregi_replace("[\n|\r|\n\r]",'',$htmlContent))."', '".$colorBackground."', ".$intOpacity.", ".$windth.", ".$height.")");
        
    }
 	
 }

 $objPluginManager =& xajaxPluginManager::getInstance();
 $objPluginManager->registerPlugin(new myModalWindow());

?>