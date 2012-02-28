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
		
				self::$arrayAssignAreasHead['xajax_scripts'] = $objAjax->getJavascript(BASE_URL_PATH.PATH_XAJAX_JS);
		
				self::$arrayAssignAreasHead['string_js_mw']
				= '<script type="text/javascript" src="'.BASE_URL_PATH.'common/js/osezno/myModalWindow.js" charset="utf-8"></script>';
		
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
		
			$newContent = str_ireplace(array('background="','<img src="'), array('background="'.BASE_URL_PATH.'resources/templates/','<img src="'.BASE_URL_PATH.'resources/templates/'), $newContent);

			self::$content = $newContent;
			
		}else{
		
			$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.MSG_TEMPLATE_NO_FOUND.'&nbsp;&quot;'.$strNameTemplate.'&quot;<br><br><div class="error_detail"><b>'.ERROR_DET_LABEL.':</b> '.MSG_TEMPLATE_NO_FOUND_DET.'&nbsp;&quot;'.$this->pathFolderTemplates.'&quot;</div></div>';
		
			die ($this->arrayAssignAreasHead['css_errors'].$msgError);
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