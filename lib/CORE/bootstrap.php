<?php

	class CORE_bootstrap {
	
		private $params = array ();
		
		private $module = '';
		
		private $event = '';
		
		public function __construct($pathDir, $entorno = 'dev', $app = ''){
			
			$q_string = $_SERVER['REQUEST_URI'];
				
			$q_string = trim(filter_var($q_string, FILTER_SANITIZE_URL), '/');

			$q_string = str_replace(substr($pathDir, strripos($pathDir, DIRECTORY_SEPARATOR)), '', $q_string);
				
			$entornos_validos = array(
			        
		        'dev'  => array('INDEX' => 'index.php'),
			        
		        'prod' => array('INDEX' => 'index.php')
			);
			
			CORE_dispatcher::dispath($q_string, $entorno, $entornos_validos);
			
			$this->params = CORE_dispatcher::getParams();
			
			$this->module = CORE_dispatcher::getModule();
			
			$this->event = CORE_dispatcher::getEvent();
			
			CORE_router::router($app, $this->module, $this->event, $this->params);
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