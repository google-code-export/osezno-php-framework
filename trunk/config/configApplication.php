<?php
/**
 * Configuración del proyecto OPF.
 * @author: José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */

# Diseño y Vista

/**
 * Idioma que se va a usar en las etiquetas de los objetos. (spanish, english) (lang/)
 * @var string
 */
$lang = 'spanish';

/**
 * Tema actual de estilos. (themes/)
 * @var string
 */
$theme = 'osezno';

/**
 * Nombre de la carpeta donde se llaman todas las plantillas, esta carpeta por defecto esta en la raiz del proyecto.
 * @var string
 */
$templateBaseFolder = 'templates/';

# Variables de sesión

/**
 * Nombre de la carpeta que guarda las sesiones, esta carpeta por defecto esta en la raiz del proyecto.
 * Si no se escribe el nombre de la carpeta el tomara por defecto la temporal.
 * @var string
 */
$sessionNameFolder = '';

/**
 * Nombre de cookie referencia de las sesiones de OPF.
 * @var string
 */
$sessionName = 'oseznophp';

/**
 * Caducidad en segundos en cache para la sesión.
 * @var string
 */
$sessionCacheExpire = 3600;

# Conexión a base de datos.

/**
 * Nombre de base de datos.
 * @var string
 */
$database = 'oseznophp';

/**
 * Motor de base de datos; pgsql ó mysql.
 * @var string
 */
$engine = 'mysql';

/**
 * Direccion Ip o nombre de maquina del motor de base de datos.
 * @var string
 */
$host = 'localhost';

/**
 * Nombre de usuario para conexion a base de datos.
 * @var string
 */
$user = 'root';

/**
 * Contraseña de usuario para conexión a base de datos.
 * @var string
 */
$password = '';

/**
 * Puerto para la conexión, Mysql 3306, Postgre 5432.
 * @var integer
 */
$port = '3306';

/**
 * Encender o Apagar el Debug.
 * El debug permite cuando se trabaja con ajax que podamos ver errores se sintaxis.
 * @var boolean
 */
$debugXajax = false;

/**
 * Decodificar todas las tildes o carateres especiales que vengan de los campos de texto.
 * @var boolean
 */
$decodeUTF8InputXajax = true;

/**
 * Nivel de manejo de errores, E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_ALL | E_DEPRECATED (> 5.3.0)
 * @var string
 */
if (version_compare(PHP_VERSION, '5.3.0') >= 0)
	error_reporting(E_ALL ^ E_DEPRECATED);
else
	error_reporting(E_ALL);

/**
 * Fin sección de config.
 *
 * Nota: No tocar si no es necesario hasta el final del archivo.
 */

# Parametros de conexion a base de datos por defecto
global $MYACTIVERECORD_PARAMS;

$GLOBALS['MYACTIVERECORD_PARAMS']['database'] = $database;

$GLOBALS['MYACTIVERECORD_PARAMS']['engine'] 	= $engine;

$GLOBALS['MYACTIVERECORD_PARAMS']['host'] 	= $host;

$GLOBALS['MYACTIVERECORD_PARAMS']['user'] 	= $user;

$GLOBALS['MYACTIVERECORD_PARAMS']['password'] = $password;

$GLOBALS['MYACTIVERECORD_PARAMS']['port'] 	= $port;

# Si la pagina fue accedida desde https cambiamos las urls de el framework
$http = 'http://';
if (isset($_SERVER['HTTPS'])){
	$http = 'https://';
}

global $folderProject;

$GLOBALS['folderProject'] = dirname(__FILE__);

# Cambiamos el nombre de la cookie
session_name($sessionName);

# Permitir al sistema usar sesiones para Usar listas dinamicas
session_start();

# La caducidad de la sesión esta definida en la siguiente linea en numero de segundos
session_cache_expire ($sessionCacheExpire);

require_once $GLOBALS['folderProject'].'/../plugin/packages/xajax/xajax_core/xajax.inc.php';

require $GLOBALS['folderProject'].'/../plugin/packages/fpdf/fpdf.php';

function __autoload($className){

	if (stripos($className,'_')!==false){
			
		list($pkg, $fileName) = explode('_', $className);

		$classFile = $GLOBALS['folderProject'].'/../lib/'.$pkg.'/'.$fileName.'.php';
			
		$pack = 'PACKAGE';

		if ($pkg)
			$pack = $pkg;

		if (file_exists($classFile)){
				
			include $classFile;
		}
	}
}

require $GLOBALS['folderProject'].'/../lang/'.$lang.'.php';

$httpHost = $_SERVER['HTTP_HOST'].'/../../';

require 'security.php';

# Lang en uso
define ('LANG',			$lang,true);

# Nombre del tema de hojas de estilos que usara el framework
define ('THEME_NAME',		$theme,true);

# Ruta donde se encuentran las plantillas de Osezno
define ('PATH_TEMPLATES', $GLOBALS['folderProject'].'/../'.$templateBaseFolder,true);

# Ruta tipo url en donde se almacenan los scripts js de xAjax
define ('URL_JS_XJX',     '../../plugin/packages/xajax/',true);

# Ruta tipo url donde se descarga el js de funciones
define ('URL_JS_FCN',     '../../javascript/MyFunctions.js',true);

# Ruta tipo Url archivo js para ventanas modales.
define ('URL_JS_MW',       '../../javascript/myModalWindow.js',true);

# Ruta tipo url donde se descarga el js de wz tooltip
define ('URL_JS_TT',       '../../javascript/wz_tooltip.js',true);

# Center window tooltip plugin
define ('URL_JS_CW',       '../../javascript/tip_centerwindow.js',true);

# Follow scroll tooltip plugin
define ('URL_JS_FS',       '../../javascript/tip_followscroll.js',true);

# Ruta tipo url donde se descarga el js de wz tooltip como plugin adicional para ayudas esilo bocadillo
define ('URL_JS_TB',       '../../javascript/tip_balloon.js',true);

# Ruta tipo url donde se descarga el js de funciones de SWF
define ('URL_SWF_FCN',     '../../javascript/swfupload.js',true);

# Ruta tipo url donde se encuentra el js de handlers de SWF
define ('URL_SWF_HLD',     '../../javascript/handlers.js',true);

# Ruta tipo url donde se encuentra el js de myList
define ('URL_JS_ML',       '../../javascript/myList.js',true);

# Ruta tipo url donde se encuentra el js de myTabs
define ('URL_JS_MT',       '../../javascript/myTabs.js',true);

# Ruta tipo url donde se encuentra el js de myCalendar
define ('URL_JS_MC',       '../../javascript/myCalendar.js',true);

# Ruta tipo url donde se descarga el favicon del proyecto
define ('URL_FAV_ICON',    '../../favicon.ico',true);

# Ruta tipo url donde se encuentra la base del proyecto
define ('URL_BASE_PROJECT','../../');

# Prefijo que usa xAjax para llamar a los metodos y funciones que reciben sus datos
define ('XAJAX_WRAPPER_PREFIX','',true);

# Osezno php framework versión
define ('FRAMEWORK_VERSION','1.2',true);

$objxAjax = new xajax();

$objxAjax->setFlag("debug", $debugXajax);

$objxAjax->setFlag('decodeUTF8Input',$decodeUTF8InputXajax);

/**
 * Configurar el prefijo de xAjax usado para llamar nuestras funciones de Php
 */
$objxAjax->setWrapperPrefix(XAJAX_WRAPPER_PREFIX);


if (!isset($_SESSION['prdLst']))
$_SESSION['prdLst'] = array();

?>