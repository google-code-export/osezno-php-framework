<?php

	class CORE_router {
		
		public static function router ($app, $module, $event, $params){
			
			$path = APP_PATH.$app.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'index.php';
			
			include $path;
			
			$eventos = new eventos;
			
			$eventos->$event($params);
		}
		
	}

?>