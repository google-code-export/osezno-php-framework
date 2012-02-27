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

	# Ruta del tema seleccionado
	define('THEME_NAME',	$theme);
	
	# Motor de ajax seleccionado
	define('AJAX_ENGINE',	$ajax_engine);
	
	# Base url
	define ('BASE_URL_PATH', 'http://'.dirname($_SERVER['HTTP_HOST'].''.$_SERVER['SCRIPT_NAME']).'/');
	
	if (version_compare(PHP_VERSION, '5.3.0') >= 0)
	
		error_reporting(E_ALL ^ E_DEPRECATED);
	else
		error_reporting(E_ALL);

	# Cambiamos el nombre de la cookie
	session_name($sessionName);
	
	# Permitir al sistema usar sesiones para Usar listas dinamicas
	session_start();
	
	# La caducidad de la sesión esta definida en la siguiente linea en numero de segundos
	session_cache_expire ($sessionCacheExpire);
	
	#Modulo a cargar por defecto por app
	define('DEFAULT_MOD', $default_mod);
	
	# Osezno php framework versión
	define ('FRAMEWORK_VERSION','1.2',true);
	
	# Arreglo de listas dinamicas
	if (!isset($_SESSION['prdLst']))
	
		$_SESSION['prdLst'] = array();	

	#Areas de la plantilla
	global $ptlAreas;
	
	$GLOBALS['ptlAreas'] = array ();
	
	#Nombre de archivo de la plantilla en uso
	global $tplNameInUse;
	
	# Parametros de conexion a base de datos por defecto
	global $MYACTIVERECORD_PARAMS;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['database'] 	= $database;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['engine'] 	= $engine;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['host'] 		= $host;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['user'] 		= $user;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['password'] 	= $password;
	
	$GLOBALS['MYACTIVERECORD_PARAMS']['port'] 		= $port;
		
	function __autoload($className){
	
		if (stripos($className,'_')!==false){
				
			list($pkg, $fileName) = explode('_', $className);
	
			$classFile =LIB_PATH.$pkg.DS.$fileName.'.php';
				
			$pack = 'PACKAGE';
	
			if ($pkg)
			
				$pack = $pkg;
	
			if (file_exists($classFile)){
	
				include $classFile;
			}
				
		}
	
	}
	
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
	
	require PLUGINS_PATH.'fpdf/fpdf.php';

	date_default_timezone_set($timezone);
	
	ini_set('default_charset', $default_charset);
	
	$bootstrap = new CORE_bootstrap(ROOT_PATH,'dev',$default_app);
	
?>