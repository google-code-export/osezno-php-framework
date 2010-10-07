<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011
   * @version: 0.1
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * 
   * developer@osezno-framework.org
   */


  /**
   * Carpeta de projecto ubicada dentro de la caperta publica www
   */
  $baseFolder = 'osezno-framework';  

  
  /**********************************************************
   * 				   DISEÑO Y VISTA  	                    *
   **********************************************************/  
  
  /**
   * Idioma que se va a usar en las etiquetas de los objetos
   * @var string 
   */
  $lang = 'spanish';
  
  /**
   * Tema actual de estilos
   * @var string
   */
  $theme = 'default';

  /**
   * Nombre de la carpeta donde se llaman todas las plantillas,
   * esta carpeta por defecto esta en la raiz del proyecto.
   * @var string
   */
  $templateBaseFolder = 'templates/';
  
  /**
   * Nivel de manejo de errores,
   * E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_ALL
   * @var string
   */
  $error_reporting = 'E_ALL';
  
  /**********************************************************
   * 				  VARIABLES DE SESION	                *
   **********************************************************/
  
  /**
   * Nombre de la carpeta que guarda las sesiones,
   * esta carpeta por defecto esta en la raiz del proyecto.
   * @var string
   */
  $sessionNameFolder = 'sesiones';
  
  /**
   * Nombre de cookie referencia de las sesiones de OszenO framework.
   * @var string
   */
  $sessionName = 'OSEZNO_FRAMEWORK';
  
  /**
   * Caducidad en segundos en cache para la sesion.
   * @var string
   */
  $sessionCacheExpire = 3600;

  
  /**********************************************************
   * 				CONEXION BASE DE DATOS	                *
   **********************************************************/
  
  /**
   * Nombre de base de datos.
   * @var string
   */
  $database = 'multivacaciones';
  
  /**
   * Motor de base de datos; pgsql ó mysql.
   * @var string
   */
  $engine = 'pgsql';
  
  /**
   * Direccion Ip o nombre de maquina del motor de base de datos.
   * @var string
   */
  $host = '192.168.30.15';
  
  /**
   * Nombre de usuario para conexion.
   * @var string
   */
  $user = 'postgresql';
  
  /**
   * Contraseña de usuario para conexión.
   * @var string
   */
  $password = 'p4AGtkzenDPecl';

  /**
   * Puerto para la conexión, Mysql 3306, Postgre 5432.
   * @var integer
   */
  $port = 5432;
  
  
  /**
   * ¡¡¡ATENCION!!!
   *  
   * Configuraciones especificas 
   * para OseznO framework
   * 
   * No tocar si no es necesario
   * 
   */

  /**
   * Parametros de conexion a base de datos por defecto
   */
  global $MYACTIVERECORD_PARAMS;
  
  $GLOBALS['MYACTIVERECORD_PARAMS']['database'] = $database;
  $GLOBALS['MYACTIVERECORD_PARAMS']['engine'] 	= $engine;
  $GLOBALS['MYACTIVERECORD_PARAMS']['host'] 	= $host;
  $GLOBALS['MYACTIVERECORD_PARAMS']['user'] 	= $user;
  $GLOBALS['MYACTIVERECORD_PARAMS']['password'] = $password; 
  $GLOBALS['MYACTIVERECORD_PARAMS']['port'] 	= $port;
  
  
  /**
   * Si la pagina fue accedida desde https cambiamos las urls de el framework
   */ 
  $http = 'http://';
  if (isset($_SERVER['HTTPS'])){
  	$http = 'https://';
  }
    
  global $folderProject;
  $GLOBALS['folderProject'] = str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'.$baseFolder.'/');

  /**
   * Se van a  guardar todas las sesiones en la siguiente carpeta
   */
  session_save_path ($GLOBALS['folderProject'].$sessionNameFolder); 

  /**
   * Cambiamos el nombre de la cookie
   */
  session_name($sessionName);  
  
  /**
   * Permitir al sistema usar sesiones para Usar listas dinamicas
   */
  session_start();
  
  /**
   * La caducidad de la sesion esta definida en la siguiente linea en numero de segundos 
   */
  session_cache_expire ($sessionCacheExpire);
  
  /**
   * Setear el nivel de errores que desea mostrar dentro de la aplicacion
   */
  error_reporting($error_reporting);

  require_once $GLOBALS['folderProject'].'lib/plugin/packages/xajax/xajax_core/xajax.inc.php';
  
  require $GLOBALS['folderProject'].'lib/osezno.class.php';
  
  require $GLOBALS['folderProject'].'lib/myForm.class.php';
  
  require $GLOBALS['folderProject'].'lib/myDinamicList.class.php';
  
  require $GLOBALS['folderProject'].'lib/myActiveRecord.class.php';
  
  require $GLOBALS['folderProject'].'lib/myTime.class.php';
  
  require $GLOBALS['folderProject'].'lib/myTabs.class.php';
  
  require $GLOBALS['folderProject'].'lib/myController.class.php';
  
  require $GLOBALS['folderProject'].'lib/myCalendar.class.php';
  
  require $GLOBALS['folderProject'].'lang/'.$lang.'.php';
  
  $httpHost = $_SERVER['HTTP_HOST'].'/'.$baseFolder;
  
  global $urlProject;
  $GLOBALS['urlProject'] = $http.$httpHost;
  
  /**
   * Nombre del tema de hojas de estilos que usara el framework
   */
  define ('THEME_NAME',		$theme,true);
  
  /**
   * Ruta donde se encuentran las plantillas de Osezno  [*]
   */
  define ('PATH_TEMPLATES', $GLOBALS['folderProject'].$templateBaseFolder,true);
  
  /**
   * Ruta tipo url en donde se almacenan los scripts js de xAjax
   */
  define ('URL_JS_XJX',     $http.$httpHost.'/lib/plugin/packages/xajax/',true);
  
  /**
   * Ruta tipo url donde se descarga el js de funciones
   */
  define ('URL_JS_FCN',     $http.$httpHost.'/javascript/MyFunctions.js',true);

  /**
   * 
   */
  define ('URL_JS_MW',      $http.$httpHost.'/javascript/myModalWindow.js',true);
  
  /**
   * Ruta tipo url donde se descarga el js de wz tooltip
   */
  define ('URL_JS_TT',       $http.$httpHost.'/javascript/wz_tooltip.js',true);
  
  /**
   * Ruta tipo url donde se descarga el js de wz tooltip como plugin adicional para ayudas esilo bocadillo 
   */ 
  define ('URL_JS_TB',       $http.$httpHost."/javascript/tip_balloon.js",true);  
  
  /**
   * Ruta tipo url donde se descarga el js de funciones de SWF
   */
  define ('URL_SWF_FCN',     $http.$httpHost."/javascript/swfupload.js",true);
  
  /**
   * Ruta tipo url donde se encuentra el js de handlers de SWF
   */
  define ('URL_SWF_HLD',     $http.$httpHost.'/javascript/handlers.js',true);
  
  /**
   * Ruta tipo url donde se encuentra el js de autosuggest
   */
  define ('URL_JS_AS',       $http.$httpHost.'/javascript/autosuggest.js',true);

  /**
   * Ruta tipo url donde se encuentra el js de myList
   */
  define ('URL_JS_ML',       $http.$httpHost.'/javascript/myList.js',true);
  
  /**
   * Ruta tipo url donde se encuentra el js de myCalendar
   */
  define ('URL_JS_MC',       $http.$httpHost.'/javascript/myCalendar.js',true);
  
  /**
   * Ruta tipo url donde se descarga la hoja de estilos de la pagina
   */
  define ('URL_CSS_TPL',     $http.$httpHost.'/css/css.css',true);
  
  /**
   *  
   */
  define ('URL_CSS_CAL',     $http.$httpHost.'/css/calendar/calendar.css',true);
  
  /**
   * Ruta tipo url donde se descarga el favicon del proyecto
   */
  define ('URL_FAV_ICON',    $http.$httpHost.'/favicon.ico',true);

  /**
   * Ruta tipo url donde se encuentra la base del proyecto
   */
  define ('URL_BASE_PROJECT',$http.$httpHost);

  /**
   * Para la siguiente constante de configuracion...
   * Nota: No olvide que myForm.class.php y myDinamicList.class.php tienen ambas
   * un atributo llamado 'prefAjax', si usted piensa modificar esta constante; debe
   * tambien modificar los atributos de estas dos clases.
   */

  /**
   * Prefijo que usa xAjax para llamar a los metodos y funciones que reciben sus datos
   */
  define ('XAJAX_WRAPPER_PREFIX','',true);
  
  /**
   * OseznO php framework Version
   */
  define ('FRAMEWORK_VERSION','0.1.5',true);

  $objxAjax = new xajax();
  
  if (!isset($_SESSION['prdLst']))
  	$_SESSION['prdLst'] = array();
  
?>