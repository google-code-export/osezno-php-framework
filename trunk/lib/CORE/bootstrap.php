<?php

	class CORE_bootstrap {
	
		private static $utilitys = array ('calendarCaller', 'downloadQuery');
		
		private $params = array ();
		
		private $module = '';
		
		private $event = '';
		
		public function __construct($pathDir, $app = '', $ajax_conf = array()){
			
			$q_string = $_SERVER['REQUEST_URI'];
			
			$is_utility = false;
				
			$utilityFound = '';
			
			foreach (self::$utilitys as $utility){
			
				if (stripos($q_string, $utility) !== false){
						
					$is_utility = true;

					$utilityFound = $utility;
					
					break;
					
				}
				
			}
			
			CORE_dispatcher::defineUtility($utilityFound);
			
			CORE_dispatcher::dispath($q_string, $is_utility);
						
			$this->params = CORE_dispatcher::getParams();
			
			$this->module = CORE_dispatcher::getModule();
			
			$this->event = CORE_dispatcher::getEvent();
			
			CORE_router::router($app, $this->module, $this->event, $this->params, $ajax_conf, $utilityFound);
		}
		
		public function getParams (){
			
			return $this->params;
		}
		
		public function getModule (){
				
			return $this->module;
		}
		
		public function getEvent (){
				
			return $this->event;
		}

	}

?>