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
				
						global $objAjax;
						
						switch (AJAX_ENGINE){
						
							case 'xajax':
						
								require PLUGINS_PATH.'xajax/xajax_core/xajax.inc.php';
									
								# Agilizar el rendimiento
								$objxAjax = new xajax();
						
								//$objxAjax->setFlag("debug", $ajax_conf[AJAX_ENGINE]['debug']);
						
								//$objxAjax->setFlag('decodeUTF8Input', $ajax_conf[AJAX_ENGINE]['decodeUTF8Input']);
									
								//$objxAjax->setWrapperPrefix($ajax_conf[AJAX_ENGINE]['wrapper_prefix']);
								$objxAjax->setWrapperPrefix('');
						
								$GLOBALS['objAjax'] = $objxAjax;
									
								define ('PATH_XAJAX_JS','plugin/xajax/');
									
								break;
						}
						
						$controller = new controller;
												
						$controller->processRequest();
						
						if (method_exists($controller, $event)){
					
							$reflectionMethod = new ReflectionMethod('controller', $event);
						
							$reflectionMethod->invokeArgs($controller, $params);
					
						}else{
						
							if ($event != 'default_event'){
						
								$msgError = '<div class="error"><b>'.OPF_myLang::getPhrase('ERROR_LABEL').':</b>&nbsp;'.OPF_myLang::getPhrase('ROUTER_METHOD_NOT_FOUND').'&nbsp;&quot;'.$event.'&quot;</div>';
							
								die ($msgError);
							}
						
						}
					
						include $pathIndex;
						
					}else{
					
						$msgError = '<div class="error"><b>'.OPF_myLang::getPhrase('ERROR_LABEL').':</b>&nbsp;'.OPF_myLang::getPhrase('ROUTER_CLASS_NOT_FOUND').'&nbsp;&quot;'.'controller'.'&quot;</div>';
					
						die ($msgError);
					}
				
				}else{

					die('Error: 404 / The module "'.$app.'/'.$module.'" does not exist.');
				}
								
			}
			
		}
		
	}

?>