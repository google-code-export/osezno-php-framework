<?php

	class CORE_dispatcher {
		
		private static $params = array ();
		
		private static $module = '';
		
		private static $event = '';
		
		private static $name_utility = '';
		
		public static function defineUtility ($name){
			
			self::$module = self::$name_utility;
		}
		
		public static function dispath ($q_string, $is_utility){
			
			if ($is_utility){
				
				self::$module = $utility;
				
			}else{
			
				/**
			 	* Obtenemos la cadena de consulta hasta antes de los parametros GET
			 	*/
				if (strpos($q_string, '?') !== FALSE){
			
					$q_string = substr($q_string, 0, strpos($q_string, '?')); 
				}
			
			
				/**
			 	* Verificamos si el proyecto esta contenido dentro de alguna carpeta
			 	* 
			 	* Ambientes normales de desarrollo
			 	*/
				$from_path = substr($_SERVER['SCRIPT_NAME'],1);
			
				$folder = '';
			
				if (stripos($from_path, '/') !== false){
				
					$folder = substr($from_path, 0, stripos($from_path,'/')); 
				
				}
			
				/**
			 	* Obtenemos la porcion de los componentes de la URL
			 	*/
				if ($folder)
			
					$string_components = str_replace('/'.$folder, '', $q_string);
				else
					$string_components = $q_string;
			
				/**
			 	* Partimos los componentes para obtener 'modulo', 'evento', 'parametros'
			 	*/
				$components = explode('/', $string_components);
			
				$realComponents = array();

				$i = 0;
			
				foreach ($components as $component){
				
					if (!$component)
						unset($components[$i]);
					else
						$realComponents[] = $component;
					++$i;
				}
			
				/**
			 	* Obtenemos el modulo a ejecutar, si no esta definido entonces ejecutamos el dejado por defecto
			 	*/
				if (empty($realComponents[0])){
				
					self::$module = DEFAULT_MOD;
					
					/**
					 * Obtenemos el evento a ejecutar, si no fue definido entonces ejecutamos por defecto 'default_event'
					 */
					if (empty($realComponents[2])){
							
						self::$event = 'default_event';
						
					}else{
							
						self::$event = $realComponents[2];
					}
				
				}else if(stripos($realComponents[0],'.php')!==false){
					
					unset($realComponents[0]);
					
					if (empty($realComponents[1])){
						
						self::$module = DEFAULT_MOD;
						
					}else{
						
						self::$module = $realComponents[1];
					}

					if (empty($realComponents[2])){
							
						self::$event = 'default_event';
					
					}else{
							
						self::$event = $realComponents[2];
					}
					
				}else {	
				
					self::$module = $realComponents[0];
					
					/**
					 * Obtenemos el evento a ejecutar, si no fue definido entonces ejecutamos por defecto 'default_event'
					 */
					if (empty($realComponents[1])){
							
						self::$event = 'default_event';
							
					}else{
							
						self::$event = $realComponents[1];
					
					}
				
				}
			
				$params = array();
			
				$countRealC = count($realComponents);
				
				for($i=2;$i<$countRealC;++$i) {
					
					$params[] = $realComponents[$i];
				}
				
				$c_params = $params;
			
				self::$params = $c_params;
			}
			
		}
		
		public static function getParams () {
			
			return self::$params;
		}
		
		public static function getModule (){
			
			return self::$module;
		}
		
		public static function getEvent (){
			
			return self::$event;
		}
		
	}

?>