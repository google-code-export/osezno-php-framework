<?php

	class CORE_router {
		
		public static function router ($app, $module, $event, $params, $name_utility = ''){
			
			$security 		= APP_PATH.$app.DS.'security.php';

			include $security;
			
			# Es una utilidad?
			if ($name_utility){
				
				$pathScript 	= ROOT_PATH.DS.'resources'.DS.'utility'.DS.$name_utility.'.php';
				
				include $pathScript;
				
			}else{
				
				$pathModel 		= APP_PATH.$app.DS.$module.DS.'dataModel.php';
			
				$pathHandler 	= APP_PATH.$app.DS.$module.DS.'handlerEvent.php';
			
				$pathIndex 		= APP_PATH.$app.DS.$module.DS.'index.php';
							
				if (file_exists($pathIndex)){
				
					include $pathModel;
				
					include $pathHandler;
					
					if (class_exists('controller')){
				
						$eventos = new controller;
					
						if (method_exists($eventos, $event)){
					
							$reflectionMethod = new ReflectionMethod('controller', $event);
						
							$reflectionMethod->invokeArgs($eventos, $params);
					
						}else{
						
							if ($event != 'default_event'){
						
								$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.ROUTER_METHOD_NOT_FOUND.'&nbsp;&quot;'.$event.'&quot;</div>';
							
								die ($msgError);
							}
						
						}
					
						include $pathIndex;
						
					}else{
					
						$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.ROUTER_CLASS_NOT_FOUND.'&nbsp;&quot;'.'eventos'.'&quot;</div>';
					
						die ($msgError);
					}
				
				}else{

					die('Error: 404 / The module "'.$app.'/'.$module.'" does not exist.');
				}
								
			}
			
		}
		
	}

?>