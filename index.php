<?php

	#Separador de directorios
	define('DS', DIRECTORY_SEPARATOR);

	# Directorio Raiz
	define('ROOT_PATH',	dirname(__FILE__));

	# Ruta de plantilals
	define('TPL_PATH',	ROOT_PATH . DS.'resources'.DS.'templates'.DS);

	# Ruta de aplicaciones
	define('APP_PATH',	ROOT_PATH . DS.'apps'.DS);

	# Directorio de librerias
	define('LIB_PATH',	ROOT_PATH . DS.'lib'.DS);
	
	# Directorio de Agragados / Plugins
	define('PLUGINS_PATH', ROOT_PATH . DS.'plugin'.DS);

	# Ruta de Archivo de configuracion
	define('CONF_PATH',  ROOT_PATH. DS.'conf'.DS.'configApplication.php');

	require CONF_PATH;

	# Ruta de archivos de idiomas
	define('LANG_PATH',  ROOT_PATH. DS.'resources'.DS.'lang'.DS.$lang.'.php');

	require LANG_PATH;

	# Idioma en uso
	define('LANG',  $lang);
	
	# Ruta del tema seleccionado
	define('THEME_NAME',	$theme);
	
	# Motor de ajax seleccionado
	define('AJAX_ENGINE',	$ajax_engine);
	
	# Base url
	define ('BASE_URL_PATH', 'http://'.dirname($_SERVER['HTTP_HOST'].''.$_SERVER['SCRIPT_NAME']).'/');
	
	# Cambiamos el nombre de la cookie
	session_name($sessionName);
	
	# Permitir al sistema usar sesiones para Usar listas dinamicas
	session_start();
	
	# La caducidad de la sesión esta definida en la siguiente linea en numero de segundos
	session_cache_expire ($sessionCacheExpire);
	
	#Modulo a cargar por defecto por app
	define('DEFAULT_MOD', $default_mod);
	
	# Osezno php framework versión
	define ('FRAMEWORK_VERSION','1.5',true);
	
	# Arreglo de listas dinamicas
	if (!isset($_SESSION['prdLst']))
	
		$_SESSION['prdLst'] = array();

	#Areas de la plantilla
	global $ptlAreas;
	
	$GLOBALS['ptlAreas'] = array ();
	
	#Nombre de archivo de la plantilla en uso
	global $tplNameInUse;
	
	# Parametros de conexion a base de datos por defecto
	global $myActParams;
	
	$GLOBALS['myActParams'] = array (
	
		'database' 	=> $pull_connect[$default_app]['database'],
	
		'engine' 	=> $pull_connect[$default_app]['engine'],
	
		'host'		=> $pull_connect[$default_app]['host'],
	
		'user'		=> $pull_connect[$default_app]['user'],
	
		'password' 	=> $pull_connect[$default_app]['password'],
	
		'port'		=> $pull_connect[$default_app]['port']
	
	);
		
	function auto_carga ($className){
		
		$classFound = false;
		
		# Buscamos en los paquetes
		
		if (stripos($className,'_')!==false){
				
			list($pkg, $fileName) = explode('_', $className);
	
			$classFile = LIB_PATH.$pkg.DS.$fileName.'.php';
				
			$pack = 'PACKAGE';
	
			if ($pkg)
			
				$pack = $pkg;
	
			if (file_exists($classFile)){
	
				include $classFile;
				
				$classFound = true;
			}
				
		}
		
	}
	
	spl_autoload_register ('auto_carga');
	
	global $objAjax;
	
	switch ($ajax_engine){
		
		case 'xajax':

			require PLUGINS_PATH.'xajax/xajax_core/xajax.inc.php';

			$objxAjax = new xajax();

			$objxAjax->setFlag("debug", $ajax_conf[$ajax_engine]['debug']);

			$objxAjax->setFlag('decodeUTF8Input', $ajax_conf[$ajax_engine]['decodeUTF8Input']);
			
			$objxAjax->setWrapperPrefix($ajax_conf[$ajax_engine]['wrapper_prefix']);

			$GLOBALS['objAjax'] = $objxAjax;
			
			define ('PATH_XAJAX_JS','plugin/xajax/');
			
		break;
		
	}
	
	date_default_timezone_set($timezone);
	
	ini_set('default_charset', $default_charset);
	
	$cad = $_SERVER['SERVER_NAME'];
	
	global $cuantas;
	
	$GLOBALS['cuantas'] = 0;
	
	function cuantas_en ($cad, $caracter){
		
		if (stripos($cad,$caracter)!==false){
			
			$GLOBALS['cuantas']++;
			
			$newCad = substr($cad, strpos($cad,$caracter)+1);
			
			cuantas_en( $newCad, $caracter, $cuantas);
		}
		
	}
	
	cuantas_en($cad, '.');
	
	if ($GLOBALS['cuantas'] >= 2){
		
		if ($autodetect_subdomain){
		
			$userMaxLen = 100;
		
			$usuario = addslashes(htmlentities(substr(strtolower($_SERVER['SERVER_NAME']), 0, $userMaxLen)));
		
			$usuario = substr($usuario,0,strpos($usuario,"."));
		
			if ($usuario)
		
				$default_app = $usuario;
		}
			
	}
	
	$bootstrap = new CORE_bootstrap(ROOT_PATH,'dev',$default_app);
		
?>