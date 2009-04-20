<?php
/**
 * oszeno.class.php
 * @uses Metodos y atributos propios del proyecto
 * @package OSEZNO FRAMEWORK
 * @version 0.1
 * @author joselitohaCker
 *
 */	
class osezno {
  	
  	/**
  	 * Ruta fisica donde se encuentra nuestro proyecto
  	 *
  	 * @var string
  	 */
  	private $folderProject = '';
  	
  	/**
  	 * Url base donde esta ubicado el proyecto
  	 *
  	 * @var string
  	 */
  	private $urlProject = '';
  	
  	/**
  	 * Ruta fisica donde se encuentran las plantillas
  	 *
  	 * @var string
  	 */
  	private $pathFolderTemplates;
  	
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
  	 * @var unknown_type
  	 */
  	private $objxAjax;
  	
  	/**
  	 * Contructor de la clase
  	 * Define caracteristicas iniciales del proyecto
  	 * para que este pueda comenzar a ser usado
  	 *
  	 */
  	public function __construct($objxAjax){

  		$this->folderProject = $GLOBALS['folderProject'];
  		$this->urlProject = $GLOBALS['urlProject']; 
		$this->objxAjax = $objxAjax;
  		
<<<<<<< .mine
  		require $this->folderProject.'lib/plugin/packages/xajax/xajax_plugins/response/modalWindow/myModalWindow.class.php';
=======
  		require $this->folderProject.'lib/plugin/packages/xajax/xajax_plugins/response/myModalWindow/myModalWindow.php';
>>>>>>> .r29
  		
		$this->arrayAssignAreasHead['xajax_scripts']         
		= $this->objxAjax->getJavascript(URL_JS_XJX);
		
		$this->arrayAssignAreasHead['string_favicon']        
		= '<link rel="shortcut icon" href="'.
		URL_FAV_ICON.
		'">';
		
		$this->arrayAssignAreasHead['string_js_common']     
		 = '<script type="text/javascript" src="'.
		 URL_JS_FCN.
		 '"></script>';
		
		$this->arrayAssignAreasHead['string_js_mw']     
		 = '<script type="text/javascript" src="'.
		 URL_JS_MW.
		 '"></script>';		 
		 
		$this->arrayAssignAreasHead['string_js_swf_hld']     
		= '<script type="text/javascript" src="'.
		URL_SWF_HLD.
		'"></script>';
		 
		$this->arrayAssignAreasHead['string_js_swf_fcn']     
		= '<script type="text/javascript" src="'.
		URL_SWF_FCN.
		'"></script>';
		 
		$this->arrayAssignAreasHead['string_js_autosuggest'] 
		= '<script type="text/javascript" src="'.
		URL_JS_AS.
		'"></script>';
		 
		$this->arrayAssignAreasHead['string_css_common']     
		= '<link href="'.
		URL_CSS_TPL.
		'" rel="stylesheet" type="text/css" />';
		
		$this->arrayAssignAreasHead['string_css_calendar']   
		= '<link href="'.
		URL_CSS_CLD.
		'" rel="stylesheet" type="text/css" />';
		
		$this->arrayAssignAreasBody['string_js_tooltip']     
		= '<script type="text/javascript" src="'.
		URL_JS_TT.
		'"></script>';
		
		$this->arrayAssignAreasBody['string_js_balloon']	 
		= '<script type="text/javascript" src="'.
		URL_JS_TB.
		'"></script>';
  	}
  	
	/**
	 * Obtiene la ruta fisica del proyecto
	 *
	 * @return string
	 */
  	public function getPathProject (){
  		return $this->folderProject;
  	}
  	
  	/**
  	 * Obtiene la url base del proyecto
  	 *
  	 * @return string
  	 */
  	public function getUrlProject (){
  		return $this->urlProject;
  	}
  	
  	/**
  	 * Configura la ruta fisica donde se encuentran las plantillas
  	 *
  	 * @param string $newpath
  	 */
  	public function setPathFolderTemplates ($newpath){
  		$this->pathFolderTemplates = $newpath; 
  	}
  	
  	/**
  	 * Asigna un contenido de usuario a una area de la plantilla
  	 *
  	 * @param string $nameRef
  	 * @param string $cont
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
  	 * Muestra la plantilla seleccionada
  	 *
  	 * @param string $strNameTemplate
  	 */
  	public function call_template ($strNameTemplate){
  		$newContent = '';
  		
  		/**
  		 * Obtension de la plantilla
  		 */
  		$linkTpl = fopen($fileName = $this->pathFolderTemplates.$strNameTemplate,'r');
  		$contHTML = fread($linkTpl,filesize($fileName));
  		fclose($linkTpl);
  		
  		/**
  		 * Areas del usuario
  		 */
  		$arrayKeys = array_keys($this->arrayAssignAreas);
  		$newContent = str_ireplace ( $arrayKeys, $this->arrayAssignAreas, $contHTML);

  		/**
  		 * Areas de OseznO
  		 */
  		$newContent = str_ireplace('</head>', $this->getAllHead().'</head>', $newContent);
  		$newContent = str_ireplace('</body>', $this->getAllBody().'</body>', $newContent);
  		
  		$newContent = ereg_replace("\{+[0-9a-zA-Z_]+\}","",$newContent);
  		
  		echo $newContent;
  	}
  	
  }
?>