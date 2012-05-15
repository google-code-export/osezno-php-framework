<?php
/**
 * osezno
 *
 * Asignación de areas de trabajo en plantillas. Llamado a javascripts, estilos. Configuración de tema.
 *
 * @uses Metodos y atributos propios del proyecto, llamado plantillas.
 * @package OPF
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_osezno {
		
	/**
	 * Areas definidas y asignadas dentro de la plantilla
	 *
	 * @var mixed
	 */
	private static $arrayAssignAreas = array ();
	 
	/**
	 * Arreglo con los areas del head que se van a autocompletar
	 *
	 * @var mixed
	 */
	private static $arrayAssignAreasHead = array ();
	 
	/**
	 * Arreglo con los areas del body que se van a autocompletar
	 *
	 * @var mixed
	 */
	private static $arrayAssignAreasBody = array ();
	 
	/**
	 * Arreglo con los areas del plantilla que se van a completar por los usuarios
	 *
	 * @var mixed
	 */
	private static $assignAreas = array ();
	 
	/**
	 * Objeto de xajax
	 *
	 * @var object
	 */
	private $objxAjax;
	
	/**
	 * Estilos usados para dar formato a los errores del sistema
	 * @var string
	 */
	public static $cssErrors = '.error {
	border-radius: 10px 10px 10px 10px;
	-moz-border-radius: 10px 10px 10px 10px;
	background-color:#FDCCCD;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-style: normal;
	text-decoration: none;
	text-align:left;
	color: red;
	border-color:#CC0000;
	border-width: 1px;
	border-style: solid;
	padding-left:10px;
	padding-top:10px;	
	padding-bottom:10px;
	padding-right:10px;
}

.error_detail {
	border-radius: 10px 10px 10px 10px;
	-moz-border-radius: 10px 10px 10px 10px;
	background-color:#CCCCCC;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-style: normal;
	text-decoration: none;
	text-align:left;
	color: #333333;
	border-color:#666666;
	border-width: 1px;
	border-style: solid;
	padding-left:10px;
	padding-top:10px;	
	padding-bottom:10px;
	padding-right:10px;
}';
	 
	
	public static function auto_carga ($className){
	
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
	
	public static function configIndex ($dir_name){
		
		spl_autoload_register ('OPF_osezno::auto_carga');
		
		#Separador de directorios
		define('DS', DIRECTORY_SEPARATOR);
	
		# Directorio Raiz
		define('ROOT_PATH',	$dir_name);
	
		# Ruta de plantillas
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
		
		# Ruta del tema seleccionado
		define('THEME_NAME',	$theme);
		
		# Motor de ajax seleccionado
		define('AJAX_ENGINE',	$ajax_engine);
		
		# Base url
		define ('BASE_URL_PATH', 'http://'.dirname($_SERVER['HTTP_HOST'].''.$_SERVER['SCRIPT_NAME']).'/');
		
		# Cambiamos el nombre de la cookie
		session_name($sessionName);
		
		# La sesiones se van a guardar en:
		session_save_path(ROOT_PATH.DS.$sessionPathFolder);
		
		# Permitir al sistema usar sesiones para Usar listas dinamicas
		session_start();
		
		# La caducidad de la sesión esta definida en la siguiente linea en numero de segundos
		session_cache_expire ($sessionCacheExpire);
		
		#Modulo a cargar por defecto por app
		define('DEFAULT_MOD', $default_mod);
		
		# Osezno php framework versión
		define ('FRAMEWORK_VERSION','1.6',true);
		
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
		
		
		# Ruta de archivos de idiomas
		define('LANG_PATH',  ROOT_PATH. DS.'resources'.DS.'lang'.DS.$lang.'.php');
		
		#Definimos el idioma
		OPF_myLang::setLang($lang);
		
		# Idioma en uso
		define('LANG',  $lang);
		
		global $objAjax;
		
		switch ($ajax_engine){
		
		case 'xajax':
		
		//require PLUGINS_PATH.'xajax/xajax_core/xajax.inc.php';
			
		# Agilizar el rendimiento
		//$objxAjax = new xajax();
		
		//$objxAjax->setFlag("debug", $ajax_conf[$ajax_engine]['debug']);
		
		//$objxAjax->setFlag('decodeUTF8Input', $ajax_conf[$ajax_engine]['decodeUTF8Input']);
			
		//$objxAjax->setWrapperPrefix($ajax_conf[$ajax_engine]['wrapper_prefix']);
		
		//$GLOBALS['objAjax'] = $objxAjax;
			
		//define ('PATH_XAJAX_JS','plugin/xajax/');
			
		break;
		
		}
		
		date_default_timezone_set($timezone);
		
		ini_set('default_charset', $default_charset);
		$cad = $_SERVER['SERVER_NAME'];
		
		global $cuantas;
		
		$GLOBALS['cuantas'] = 0;
		
		function cuantas_en ($cad, $caracter){
		
			if (stripos($cad,$caracter)!==false){
					
				++$GLOBALS['cuantas'];
					
				$newCad = substr($cad, strpos($cad,$caracter)+1);
					
				cuantas_en( $newCad, $caracter);
			}
		
		}
		
		cuantas_en($cad, '.');
		
		if ($GLOBALS['cuantas'] == 2){
		
			if ($autodetect_subdomain){
		
				$userMaxLen = 100;
		
				$usuario = addslashes(htmlentities(substr(strtolower($_SERVER['SERVER_NAME']), 0, $userMaxLen)));
		
				$usuario = substr($usuario,0,strpos($usuario,"."));
		
				if ($usuario)
		
					$default_app = $usuario;
			}
				
		}
		
		$bootstrap = new CORE_bootstrap(ROOT_PATH,'dev',$default_app);
		
	}
	
	/**
	 * Asigna un contenido a una plantilla.
	 *
	 * Asigna a una area de la plantilla definida el contenido que quiera.
	 * @param string $nameRef Nombre del area
	 * @param string $cont	Contenido
	 */
	public static function assign ($nameRef,$cont){
		
		if (strlen($cont))
		
			$GLOBALS['ptlAreas']['{'.$nameRef.'}'] = $cont;
	}
	 
	/**
	 * Obtiene todas las areas del head a reemplazar
	 *
	 * @return string
	 */
	private static function getAllHead (){
		
		$varJsPathUrl = "\n".'<script type=\'text/javascript\' charset=\'UTF-8\'>'."\n".'var pathUrl = \''.BASE_URL_PATH.'\';'."\n".'</script>'."\n";
		
		$toReturn = $varJsPathUrl;

		foreach (self::$arrayAssignAreasHead as $key => $cont){
			
			$toReturn .= $cont."\n";
		}

		return $toReturn;
	}
	 
	/**
	 * Obtiene todas la areas del body a reemplazar
	 *
	 * @return string
	 */
	private static function getAllBody (){
		
		$toReturn = '';

		foreach (self::$arrayAssignAreasBody as $key => $cont){
			
			$toReturn .= $cont."\n";
		}

		return $toReturn;
	}
	 
	
	public static function buildAreas (){
		
		$objAjax = $GLOBALS['objAjax'];
		
		self::$arrayAssignAreasHead['string_favicon']
		= '<link rel="shortcut icon" href="'.BASE_URL_PATH.'common/favicon.ico">';
		
		switch (AJAX_ENGINE){
				
			case 'xajax':
		
				//self::$arrayAssignAreasHead['xajax_scripts'] = $objAjax->getJavascript(BASE_URL_PATH.PATH_XAJAX_JS);
		
				//self::$arrayAssignAreasHead['string_js_mw']
				//= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/myModalWindow.js" charset="utf-8"></script>';
		
				break;
		}

		self::$arrayAssignAreasHead['string_js_common']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/MyFunctions.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasHead['string_js_swf_hld']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/handlers.js" charset="utf-8"></script>';
			
		self::$arrayAssignAreasHead['string_js_swf_fcn']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/swfupload.js" charset="utf-8"></script>';
			
		self::$arrayAssignAreasHead['string_js_mylist']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/myList.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasHead['string_js_mytabs']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/myTabs.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasHead['string_js_mycalendar']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/myCalendar.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasBody['string_js_tooltip']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/wz_tooltip.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasBody['string_js_centerwindow']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/tip_centerwindow.js" charset="utf-8"></script>';
		
		self::$arrayAssignAreasBody['string_js_followsroll']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/tip_followscroll.js"  charset="utf-8"></script>';
		
		self::$arrayAssignAreasBody['string_js_balloon']
		= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/tip_balloon.js"  charset="utf-8"></script>';
		
		self::$arrayAssignAreasBody['string_js_resize']
		= '<script type="text/javascript">window.onresize=Resize;</script>';
		
		/**
		 * Llamar a las diferentes hojas de estilos
		 */
		self::$arrayAssignAreasHead['string_css_calendar']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/calendar/style.php'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_mylist']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/mylist/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/mylist/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_myform']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/myform/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/myform/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_message_box']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/msg_box/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/msg_box/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_modal_window']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/modal_window/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/modal_window/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_notification_window']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/notification_window/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/notification_window/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_tabs']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/mytabs/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/mytabs/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['string_css_callback_xajax']
		= '<link href="'.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/callback_xajax/style.php?path_img='.BASE_URL_PATH.'resources/themes/'.THEME_NAME.'/callback_xajax/'.
						'" rel="stylesheet" type="text/css" />';
		
		self::$arrayAssignAreasHead['css_errors'] = '<style type="text/css">'."\n".self::$cssErrors."\n".'</style>';
		
		$newContent = '';
		
		/**
		 * Obtension de la plantilla
		 */
		$linkTpl = @fopen($fileName = TPL_PATH.$GLOBALS['tplNameInUse'],'r');
		
		if ($linkTpl){
		
			$contHTML = fread($linkTpl,filesize($fileName));
		
			$newContent = $contHTML;
		
			fclose($linkTpl);
		
			/**
			 * Areas del usuario
			 */
			if (count($GLOBALS['ptlAreas'])){
		
				$arrayKeys = array_keys($GLOBALS['ptlAreas']);
					
				$newContent = str_ireplace ( $arrayKeys, $GLOBALS['ptlAreas'], $contHTML);
			}
		
			/**
			 * Areas de OseznO
			 */
			if (!isset($_GET['no_load_xajax'])){
		
				$newContent = str_ireplace('<head>', '<head>'."".self::getAllHead(), $newContent);
					
				$newContent = str_ireplace('</body>', self::getAllBody().'</body>', $newContent);
					
			}
		
			self::$content = $newContent;
			
		}else{
		
			$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.MSG_TEMPLATE_NO_FOUND.'&nbsp;&quot;'.$GLOBALS['tplNameInUse'].'&quot;<br><br><div class="error_detail"><b>'.ERROR_DET_LABEL.':</b> '.MSG_TEMPLATE_NO_FOUND_DET.'&nbsp;&quot;'.TPL_PATH.'&quot;</div></div>';
		
			die (self::$arrayAssignAreasHead['css_errors'].$msgError);
		}
		
	} 
	

	private static $content = '';
	
	/**
	 * Muestra la plantilla seleccionada.
	 *
	 * Muestra la plantilla seleccionada. En caso de no encontrar la plantilla devuelve un error.
	 * @param string $strNameTemplate Nombre de plantilla.
	 */
	public static function call_template ($strNameTemplate){

		$GLOBALS['ptlAreas']['{BASE_URL_PATH}'] = BASE_URL_PATH;
		
		$GLOBALS['tplNameInUse'] = $strNameTemplate;
		
		self::buildAreas();
		
		ob_start('antes_imprimir');

		echo self::$content;
	}
	
	
	 
}

function antes_imprimir ($buff){
	
	$nbuff = '';
	
	$arrayKeys = array_keys($GLOBALS['ptlAreas']);
					
	$nbuff = str_ireplace ( $arrayKeys, $GLOBALS['ptlAreas'], $buff);
	
	$nbuff = preg_replace('(\\{+[0-9a-zA-Z_]+\\})','',$nbuff);
	
	return $nbuff;
}

/**
 * Da un formato a un etiqueta para crear un javascript legible
 * @param string $etq Nombre de la etiqueta
 * @return string
 */
function etqFormat ($etq){

	$etq = strtolower($etq);
	 
	$tildes = array("á","é","í","ó","ú","ä","ë","ï","ö","ü","à","è","ì","ò","ù","ñ"," ",",",".",";",":","¡","!","¿","?",'"',"[","]","{","}","(",")");

	$replac = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","","","","","","","","","",'',"","","","","","");
	 
	$etq = str_replace($tildes,$replac,$etq);

	return $etq;
}


?>