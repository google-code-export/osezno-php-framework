<?php

	class CORE_dispatcher {
		
		private static $params = array ();
		
		private static $module = '';
		
		private static $event = '';
		
		private static $name_utility = '';
		
		public static function defineUtility ($name){
			
			self::$name_utility = $name;
		}
		
		public static function dispath ($q_string, $entorno, $entornos_validos, $is_utility){
			
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
					$i ++;
				}
			
				/**
			 	* Obtenemos el modulo a ejecutar, si no esta definido entonces ejecutamos el dejado por defecto
			 	*/
				if (empty($realComponents[0]) || $realComponents[0]=='index.php'){
				
					self::$module = DEFAULT_MOD;
					
					unset($realComponents);
					/**
					 * Obtenemos el evento a ejecutar, si no fue definido entonces ejecutamos por defecto 'default_event'
					 */
					if (empty($realComponents[1])){
							
						self::$event = 'default_event';
							
					}else{
							
						self::$event = $realComponents[2];
					
					}
				
				}else{
				
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
			
				for($i=2;$i<count($realComponents);$i++) {
					
					$params[] = $realComponents[$i];
				}
				
				//$c_params = array_merge($params, $_POST, $_GET, $_FILES);
				
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