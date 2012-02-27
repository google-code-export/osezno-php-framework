<?php

	class CORE_dispatcher {

		private static $params = array ();
		
		private static $module = '';
		
		private static $event = '';
		
		public static function dispath ($q_string, $entorno, $entornos_validos){
			
			if (strpos($q_string, '?') !== FALSE)
			
				$q_string = substr($q_string, 0, strpos($q_string, '?'));
				
			$q_pieces = explode('/', $q_string);
				
			$posicion = array_search($entornos_validos[$entorno]['INDEX'], $q_pieces);
			
			if (!$posicion) {
					
				$posicion = (($posicion === 0) ? 1 : 0);
					
			} else {
					
				$posicion++;
			}
				
			self::$module = (empty($q_pieces[$posicion])) ? DEFAULT_MOD : $q_pieces[$posicion];
			
			$posicion++;
			
			self::$event = (empty($q_pieces[$posicion])) ? 'default' : $q_pieces[$posicion];
			
			$posicion++;
			
			$params = array();
			
			for($i=$posicion;$i<count($q_pieces);$i++) {
					
				$params[$i] = $q_pieces[$i];
			}
				
			$c_params = array_merge($params, $_POST, $_GET);
			
			self::$params = $c_params;
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