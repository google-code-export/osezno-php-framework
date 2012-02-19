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
	 * Ruta fisica donde se encuentran las plantillas
	 *
	 * @var string
	 */
	private $pathFolderTemplates;
	 
	/**
	 * Areas definidas y asignadas dentro de la plantilla
	 *
	 * @var mixed
	 */
	private $arrayAssignAreas = array ();
	 
	/**
	 * Arreglo con los areas del head que se van a autocompletar
	 *
	 * @var mixed
	 */
	private $arrayAssignAreasHead = array ();
	 
	/**
	 * Arreglo con los areas del body que se van a autocompletar
	 *
	 * @var mixed
	 */
	private $arrayAssignAreasBody = array ();
	 
	/**
	 * Arreglo con los areas del plantilla que se van a completar por los usuarios
	 *
	 * @var mixed
	 */
	private $assignAreas = array ();
	 
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
	 * Contructor de la clase.
	 *
	 * Constructor de la clase. En cada modulo nuevo ya viene declarado.
	 * @param object $objxAjax Objeto xajax
	 */
	public function __construct($objxAjax = ''){

		$this->objxAjax = $objxAjax;

		require '../../plugin/packages/xajax/xajax_plugins/response/modalWindow/myModalWindow.class.php';

		$this->arrayAssignAreasHead['xajax_scripts']
		= $this->objxAjax->getJavascript(URL_JS_XJX);

		$this->arrayAssignAreasHead['string_favicon']
		= '<link rel="shortcut icon" href="'.
		URL_FAV_ICON.
		'">';

		$this->arrayAssignAreasHead['string_js_common']
		= '<script type="text/javascript" src="'.
		URL_JS_FCN.
		 '" charset="utf-8"></script>';

		$this->arrayAssignAreasHead['string_js_mw']
		= '<script type="text/javascript" src="'.
		URL_JS_MW.
		 '" charset="utf-8"></script>';		 
			
		$this->arrayAssignAreasHead['string_js_swf_hld']
		= '<script type="text/javascript" src="'.
		URL_SWF_HLD.
		'" charset="utf-8"></script>';
			
		$this->arrayAssignAreasHead['string_js_swf_fcn']
		= '<script type="text/javascript" src="'.
		URL_SWF_FCN.
		'" charset="utf-8"></script>';
			
		$this->arrayAssignAreasHead['string_js_mylist']
		= '<script type="text/javascript" src="'.
		URL_JS_ML.
		'" charset="utf-8"></script>';

		$this->arrayAssignAreasHead['string_js_mytabs']
		= '<script type="text/javascript" src="'.
		URL_JS_MT.
		'" charset="utf-8"></script>';

		$this->arrayAssignAreasHead['string_js_mycalendar']
		= '<script type="text/javascript" src="'.
		URL_JS_MC.
		'" charset="utf-8"></script>';

		$this->arrayAssignAreasBody['string_js_tooltip']
		= '<script type="text/javascript" src="'.
		URL_JS_TT.
		'" charset="utf-8"></script>';

		$this->arrayAssignAreasBody['string_js_centerwindow']
		= '<script type="text/javascript" src="'.
		URL_JS_CW.
		'" charset="utf-8"></script>';

		$this->arrayAssignAreasBody['string_js_followsroll']
		= '<script type="text/javascript" src="'.
		URL_JS_FS.
		'"  charset="utf-8"></script>';

		$this->arrayAssignAreasBody['string_js_balloon']
		= '<script type="text/javascript" src="'.
		URL_JS_TB.
		'"  charset="utf-8"></script>';		

		$this->arrayAssignAreasBody['string_js_resize']
		= '<script type="text/javascript">window.onresize=Resize;</script>';

		/**
		 * Llamar a las diferentes hojas de estilos
		 */
		$this->arrayAssignAreasHead['string_css_calendar']
		= '<link href="'.'../../themes/'.THEME_NAME.'/calendar/style.php'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_mylist']
		= '<link href="'.'../../themes/'.THEME_NAME.'/mylist/style.php?path_img='.'../../../themes/'.THEME_NAME.'/mylist/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_myform']
		= '<link href="'.'../../themes/'.THEME_NAME.'/myform/style.php?path_img='.'../../../themes/'.THEME_NAME.'/myform/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_message_box']
		= '<link href="'.'../../themes/'.THEME_NAME.'/msg_box/style.php?path_img='.'../../../themes/'.THEME_NAME.'/msg_box/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_modal_window']
		= '<link href="'.'../../themes/'.THEME_NAME.'/modal_window/style.php?path_img='.'../../../themes/'.THEME_NAME.'/modal_window/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_notification_window']
		= '<link href="'.'../../themes/'.THEME_NAME.'/notification_window/style.php?path_img='.'../../../themes/'.THEME_NAME.'/notification_window/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_tabs']
		= '<link href="'.'../../themes/'.THEME_NAME.'/mytabs/style.php?path_img='.'../../../themes/'.THEME_NAME.'/mytabs/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['string_css_callback_xajax']
		= '<link href="'.'../../themes/'.THEME_NAME.'/callback_xajax/style.php?path_img='.'../../../themes/'.THEME_NAME.'/callback_xajax/'.
		'" rel="stylesheet" type="text/css" />';

		$this->arrayAssignAreasHead['css_errors'] = '<style type="text/css">'."\n".self::$cssErrors."\n".'</style>';
	}
	 
	/**
	 * Configura el tema de estilos para el framework.
	 *
	 * Configura el tema de estilos para el framework. Puede cambiar el tema general de estilos en el archivo de configuracion del proyecto.
	 * @param string $theme	Nombre del tema
	 */
	public function setTheme ($theme){
		$this->theme = $theme;
	}
	 
	/**
	 * Configura la ruta fisica donde se encuentran las plantillas.
	 *
	 * Configura la ruta fisica donde se encuentran las plantillas.
	 * @param string $newpath Nueva ruta
	 */
	public function setPathFolderTemplates ($newpath){
		$this->pathFolderTemplates = $newpath;
	}
	 
	/**
	 * Asigna un contenido a una plantilla.
	 *
	 * Asigna a una area de la plantilla definida el contenido que quiera.
	 * @param string $nameRef Nombre del area
	 * @param string $cont	Contenido
	 */
	public function assign ($nameRef,$cont){
		$this->arrayAssignAreas['{'.$nameRef.'}'] = $cont;
	}
	 
	/**
	 * Obtiene todas las areas del head a reemplazar
	 *
	 * @return string
	 */
	private function getAllHead (){
		$toReturn = '';

		foreach ($this->arrayAssignAreasHead as $key => $cont){
			$toReturn .= $cont."\n";
		}

		return $toReturn;
	}
	 
	/**
	 * Obtiene todas la areas del body a reemplazar
	 *
	 * @return string
	 */
	private function getAllBody (){
		$toReturn = '';

		foreach ($this->arrayAssignAreasBody as $key => $cont){
			$toReturn .= $cont."\n";
		}

		return $toReturn;
	}
	 
	/**
	 * Muestra la plantilla seleccionada.
	 *
	 * Muestra la plantilla seleccionada. En caso de no encontrar la plantilla devuelve un error.
	 * @param string $strNameTemplate Nombre de plantilla.
	 */
	public function call_template ($strNameTemplate){

		$newContent = '';

		/**
		 * Obtension de la plantilla
		 */
		$linkTpl = @fopen($fileName = $this->pathFolderTemplates.$strNameTemplate,'r');

		if ($linkTpl){

			$contHTML = fread($linkTpl,filesize($fileName));

			$newContent = $contHTML;
				
			fclose($linkTpl);

			/**
			 * Areas del usuario
			 */
			if (count($this->arrayAssignAreas)){

				$arrayKeys = array_keys($this->arrayAssignAreas);
					
				$newContent = str_ireplace ( $arrayKeys, $this->arrayAssignAreas, $contHTML);
			}
				
			/**
			 * Areas de OseznO
			 */
			if (!isset($_GET['no_load_xajax'])){

				$newContent = str_ireplace('<head>', '<head>'."".$this->getAllHead(), $newContent);
					
				$newContent = str_ireplace('</body>', $this->getAllBody().'</body>', $newContent);
					
			}
				
			$newContent = preg_replace('(\\{+[0-9a-zA-Z_]+\\})','',$newContent);
				
		}else{
				
			$msgError = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.MSG_TEMPLATE_NO_FOUND.'&nbsp;&quot;'.$strNameTemplate.'&quot;<br><br><div class="error_detail"><b>'.ERROR_DET_LABEL.':</b> '.MSG_TEMPLATE_NO_FOUND_DET.'&nbsp;&quot;'.$this->pathFolderTemplates.'&quot;</div></div>';
				
			die ($this->arrayAssignAreasHead['css_errors'].$msgError);
		}

		echo $newContent;
	}
	 
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