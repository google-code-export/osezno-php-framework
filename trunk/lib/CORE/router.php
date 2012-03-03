<?php

	class CORE_router {
		
		public static function router ($app, $module, $event, $params){
			
			$security 		= APP_PATH.$app.DS.'security.php';

			include $security;
			
			if (strstr($module, '.php')){
				
				$pathScript 	= APP_PATH.$app.DS.$module;
				
				include $pathScript;
				
			}else{
				
				$pathModel 		= APP_PATH.$app.DS.$module.DS.'dataModel.php';
			
				$pathHandler 	= APP_PATH.$app.DS.$module.DS.'handlerEvent.php';
			
				$pathIndex 		= APP_PATH.$app.DS.$module.DS.'index.php';
							
				if (file_exists($pathIndex)){
				
					include $pathModel;
				
					include $pathHandler;
				
					include $pathIndex;

					if (class_exists('eventos')){
				
						$eventos = new eventos;
					
						if (method_exists($eventos, $event)){
					
							$reflectionMethod = new ReflectionMethod('eventos', $event);
						
							$reflectionMethod->invokeArgs($eventos, $params);
					
						}else{
						
							if ($event != 'default_event'){
						
								$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.ROUTER_METHOD_NOT_FOUND.'&nbsp;&quot;'.$event.'&quot;</div>';
							
								die ($msgError);
							}
						
						}
					
					}else{
					
						$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.ROUTER_CLASS_NOT_FOUND.'&nbsp;&quot;'.'eventos'.'&quot;</div>';
					
						die ($msgError);
					}
				
				}else{

					die('Error: 404 / The module "'.$module.'" does not exist.');
				}
								
			}
			
		}
		
	}

?>