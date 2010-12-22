<?php
/**
 * myControllerExt
 *
 * @internal
 * @uses Controlador de eventos
 * @package	OSEZNO-PHP-FRAMEWORK 
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 *  
 */
class myControllerExt {
	
  	/**
  	 * Obtener HTML desde plantilla.
  	 * 
  	 * Retorna un contenido HTML desde un archivo plano
  	 * @param $file	Nombre del archivo fisico
  	 * @param $arrayReplacement	Arreglo con valores que desea reemplazar
  	 * @return string
  	 */
  	protected function loadHtmlFromFile ($file, $arrayReplacement = ''){
		
		$gestor = fopen($file, 'r');
		
		$contenido = fread($gestor, filesize($file));
		
  		if (is_array($arrayReplacement)){
  			$arrayKeys = array_keys($arrayReplacement);
  			
			$contenido = str_ireplace ( $arrayKeys, $arrayReplacement, $contenido);  			
  		}
		
		fclose($gestor);
  		
		return $contenido;
  	}
	
}

/**
 * myController
 * 
 * Agrupa los diferentes eventos de la aplicacion. Los predefinidos y los creados por los usuarios.
 * <code>
 * 
 * <?
 * 
 * # Forma de uso:
 * 
 * class className extends myController {
 * 
 * 		# Definimos los eventos:
 * 
 * 		public function myEvent ($args){
 * 
 * 			$this->alert('Hi!');
 * 
 * 			return $this->response;
 * 		}
 * 
 * }
 *   
 * $objclassName = new className($objxAjax);
 * 
 * ?>
 * 
 * </code>
 * @uses Controlador de eventos
 * @package	OSEZNO-PHP-FRAMEWORK 
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class myController extends myControllerExt {

	/**
	 * Objeto xajax
	 * 
	 * Objeto de xajax pasado como referencia del original pasado como parametro dentro del constructor.
	 * @access private
	 * @var object
	 */
	private $xajaxObject;

	/**
	 * Respuesta xajax
	 * 
	 * Recibe todas las peticiones de respuesta de xajax para poder permitir que este atributo se permita retornar en los metodos de la clases hijas.
	 * @ignore
	 * @var string
	 */
	protected $response;
	
	/**
	 * Estilo messageBox
	 * 
	 * Nombre de la clase CSS que usara el contenido de los messageBox.
	 * @access private
	 * @var string
	 */
	private $class_name_msg_content = 'message_box';
	
	/**
	 * Estilo titulo messageBox
	 * 
	 * Nombre de la clase CSS que usara el contenido de los titulos de los messageBox
	 * @access private
	 * @var string
	 */
	private $class_name_msg_ttl = 'ttl_message_box';
	
	/**
	 * Estilo botones messageBox
	 * 
	 * Nombre de la clase CSS que usaran los botones que se definan dentro del messageBox
	 * @access private 
	 * @var string
	 */
	private $class_name_msg_buttons = 'button_message_box';

	/**
	 * Metodos invalidos en llamada
	 * 
	 * Arreglo que contiene los nombres de los metodos magicos que para el controlador de eventos no seran tenidos en cuenta.  
	 * @access private
	 * @var mixed
	 */
	private $arrayInvalidMethods = array ('__get','__set','__call',
	   '__isset','__unset','__sleep','__wakeup','__clone','__construct',
	   '__destruct','alert', 'assign', 'replace', 'clear', 'redirect', 'script', 
	   'append', 'prepend', 'call', 'remove', 'create', 'insert', 'insertAfter',
	   'createInput', 'insertInput', 'insertInputAfter', 'setEvent', 'addHandler', 
	   'removeHandler', 'setFunction', 'wrapFunction', 'includeScript', 
	   'includeScriptOnce', 'removeScript', 'includeCSS', 'removeCSS',
	   'waitForCSS', 'waitFor', 'sleep', 'setReturnValue', 'getContentType', 
	   'getOutput', 'getCommandCount', 'loadCommands', 'closeWindow', 
	   'window', 'closeMessageBox', 'messageBox','notificationWindow',
	   'modalWindow','closeModalWindow','loadHtmlFromFile','modalWindowFromUrl','errorBox'
	);
	
	/**
	 * Ultimo ID modal window
	 * 
	 * Id de la ultima modal window abierta
	 * @access private
	 * @var string
     */
	private $idLastMWopen = '';
	
	/**
	 * Tipos de filtro
	 * 
	 * Relacion en filtros sql
	 * @access private
	 * @var mixed
	 */
	private $myDinamicListRel = array(		
	
			'like'=>'LIKE',
	
			'in'=>'IN',
			
			'greater_than'=>'>',
		
			'greater_equal_than'=>'>=',
		
			'equal'=>'=',

			'different'=>'<>',
	
			'less_than'=>'<',
		
			'less_equal_than'=>'<=',
			
			'notin'=>'NOT IN',
	
			'notlike'=>'NOT LIKE'
			
		);
	
	/**
	 * Alto en PX de un Messsage Box
	 * 
 	 * Define el alto de la caja de mensaje, si no tiene un valor este se calculara automaticamente dependiento del numero de caracteres que contenga el mensaje.
 	 * @var integer
 	 */
	public $heightMessageBox;
	
	/**
	 * Ancho en PX de un Message Box
	 * 
 	 * Define el ancho de la caja de mensaje, si no tiene un valor este sera por defecto 450px
 	 * @var integer
 	 */	
	public $widthMessageBox;
	
	/**
	 * Constructor
	 * 
	 * Es el handlerEvent principal, aqui se registran automaticamente todos los methodos para que sean llamados a travez de xajax del lado del cliente.
	 * @param object $objxAjax Objeto de xAjax
	 */
	public function __construct($objxAjax){
		
		require_once 'plugin/packages/xajax/xajax_core/xajaxResponse.inc.php';
		
		$this->response = new xajaxResponse();
		
		$this->xajaxObject = $objxAjax;
		
		$methods = get_class_methods( get_class($this) );
		
		foreach ( $methods as $method ){
			
			if (!in_array($method,$this->arrayInvalidMethods)){
				
		       $this->xajaxObject->registerFunction(array($method, $this, $method));

			}
			
		}
		
	}

	/**
	 * Muestra una alerta.
	 * 
	 * Muestra un dialogo de alerta al usuario.
	 * @param string $srtMsg El mensaje a mostrar.
	 */
	public function alert($srtMsg){
		
		$this->response->alert($srtMsg);
	}
	
	/**
	 * Asigna un contenido.
	 *
	 * Asigna un nuevo contenido a un elemento definido mediante DOM. 
	 * @param  string idElement El id del elemento HTML en el browser.
	 * @param  string $propertyElement La propiedad del elemento a usar para la asigancion.
	 * @param  string $newValue El valor a ser asignado a la propiedad.
	 */ 	
	public function assign($idElement, $propertyElement, $newValue){
		
		$this->response->assign($idElement, $propertyElement, $newValue);
	}
				
	/**
	 * Reemplaza un contenido.
	 * 
	 * Reemplaza el o parte del contenido de un elemento definido.
	 * @param  string $idElement El id del elemento HTML en el browser.
	 * @param  string $propertyElement La propiedad del elemento a actualizar.
	 * @param  string $strToFind El valor que desea reemplazar.
	 * @param  string $newValue El nuevo dato que reemplazara el valor buscado.
	 */
	public function replace($idElement, $propertyElement, $strToFind, $newValue){
		
		$this->response->replace($idElement,$propertyElement, $strToFind, $newValue);
	}
				
	/**
	 * Response command used to clear the specified property of the given element.
	 * 
	 * @param  string $idElement The id of the element to be updated.
	 * @param  string $propertyElement The property to be clared.
	 */
	public function clear ($idElement, $propertyElement){

		$this->response->clear($idElement, $propertyElement);
	}
				
	/**
	 * Response command that causes the browser to navigate to the specified URL.
	 * 
	 * @param  string $strUrl The relative or fully qualified URL.
	 * @param  integer $intDelaySeconds Optional number of seconds to delay before the redirect occurs.
	 */
	public function redirect($strUrl, $intDelaySeconds = 1){

		$this->response->redirect($strUrl, $intDelaySeconds);
	}
				
	/**
	 * Ejecutar script
	 * 
	 * Response command that is used  to execute a 
	 * portion of javascript on the browser.  
	 * The script  runs  in it’s own  context,  so 
	 * variables declared locally, using the ‘var’ 
	 * keyword, will  no longer be available after 
	 * the call.  
	 * To construct a variable that will be accessable 
	 * globally,  even after the script  has executed, 
	 * leave off the ‘var’ keyword.
	 * 
	 * @param  string $strJs The script to execute.
	 */
	public function script ($strJs){
		
		$this->response->script($strJs);
	}	

	/**
	 * Response  command that indicates the specified 
	 * data should be appended to the given element’s 
	 * property.
	 * 
	 * @param  string $idElement The id of the element to be updated.
	 * @param  string $propertyElement The name of the property to be appended to.
	 * @param  string $dataAppended The data to be appended to the property.
	 */	
	public function append ($idElement, $propertyElement, $dataAppended){
				
		$this->response->append($idElement, $propertyElement, $dataAppended);
	}

	/**
	 * Response command to prepend the specified value 
	 * onto the given element’s property.
	 * 
	 * @param  string $idElement The id of the element to be updated.
	 * @param  string $propertyElement The property to be updated.
	 * @param  string $dataPrepended The value to be prepended.
	 */
	public function prepend ($idElement, $propertyElement, $dataPrepended){

		$this->response->prepend($idElement, $propertyElement, $dataPrepended);
	}

	/**
	 * Response command that indicates that the  specified 
	 * javascript function should be called with the given 
	 * (optional) parameters.
	 * 
	 * @param  string $strFunctionToCall The name of the function to call.
	 * @param  arg2 .. argn .. arguments to be passed to the function.
	 */
	public function call ($strFunctionToCall, $params){

		$this->response->call($strFunctionToCall, $params);
	}

	/**
	 * Response command used to remove an element from the document.
	 * 
	 * @param  string $strFunctionToCall The id of the element to be removed.
	 */
	public function remove ($strFunctionToCall){

		$this->response->remove($strFunctionToCall);				
	}

	/**
	 * Response command used to create a new element on the browser.
	 * 
	 * @param  string $idParentElement The id of the parent element.
	 * @param  string $tagNewElement The tag name to be used for the new element.
	 * @param  string $idNewElement The id to assign to the new element.
	 * @param  string $tagType optional: The type of tag, deprecated, use xajaxResponse->createInput instead.
	 */
	public function create ($idParentElement, $tagNewElement, $idNewElement, $tagType){

		$this->response->create($idParentElement, $tagNewElement, $idNewElement, $tagType = '');
	}

	/**
	 * Response command used to insert a new element just 
	 * prior to the specified element.
	 * 
	 * @param  string $idElementRef The element used as a reference point for the insertion.
	 * @param  string $tagNewElement The tag to be used for the new element.
	 * @param  string $idNewElement The id to be used for the new element.
	 */
	public function insert ($idElementRef, $tagNewElement, $idNewElement){

		$this->response->insert($idElementRef, $tagNewElement, $idNewElement);
	}

	/**
	 * Response command used to insert a new element after 
	 * the specified one.
	 * 
	 * @param  string $idElementRef The id of the element that will be used as a reference for the insertion.
	 * @param  string $tagNewElement The tag name to be used for the new element.
	 * @param  string $idNewElement The id to be used for the new element.
	 */
	public function insertAfter ($idElementRef, $tagNewElement, $idNewElement){

		$this->response->insertAfter($idElementRef, $tagNewElement, $idNewElement);
	}

	/**
	 * Response command used to create an input element on 
	 * the browser.
	 * 
	 * @param  string $idParentElement The id of the parent element.
	 * @param  string $typeNewElement The type of the new input element.
	 * @param  string $strNameNewElement The name of the new input element.
	 * @param  string $idNewElement The id of the new element.
	 */
	public function createInput ($idParentElement, $typeNewElement, $strNameNewElement, $idNewElement){

		$this->response->createInput($idParentElement, $typeNewElement, $strNameNewElement, $idNewElement);
	}

	/**
	 * Response command used to insert a new input element 
	 * preceeding the specified element.
	 * 
	 * @param  string $idElementRef The id of the element to be used as the reference point for the insertion.
	 * @param  string $typeNewElement The type of the new input element.
	 * @param  string $strNameNewElement The name of the new input element.
	 * @param  string $idNewElement The id of the new input element.
	 */
	public function insertInput ($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement){
			
		$this->response->insertInput($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement);
	}

	/**
	 * Response command used to insert a new input element
	 * after the specified element.
	 * 
	 * @param  string $idElementRef The id of the element that is to be used as the insertion point for the new element.
	 * @param  string $typeNewElement The type of the new input element.
	 * @param  string $strNameNewElement The name of the new input element.
	 * @param  string $idNewElement The id of the new input element.
	 */
	public function insertInputAfter ($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement){
			
		$this->response->insertInputAfter($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement);
	}

	/**
	 * Response command used to set an event handler on the 
	 * browser.
	 * 
	 * @param  string $idELement The id of the element that contains the event.
	 * @param  string $strNameEvent The name of the event.
	 * @param  string $strNameFunction The javascript to execute when the event is fired.
	 */
	public function setEvent ($idELement, $strNameEvent, $strNameFunction){
				
		$this->response->setEvent($idELement, $strNameEvent, $strNameFunction);
	}

	/**
	 * Response command used to install an event handler on the
	 * specified element.
	 * 
	 * @param  string $idElement The id of the element.
	 * @param  string $strNameEvent The name of the event to add the handler to.
	 * @param  string $strNameFunction The javascript function to call when the event is fired.
	 * 
	 * You can add more than one event handler to an element’s event using this method.
	 */
	public function addHandler ($idElement, $strNameEvent, $strNameFunction){
			
		$this->response->addHandler($idElement, $strNameEvent, $strNameFunction);
	}

	/**
	 * Response command used to remove an event handler from 
	 * an element.
	 * 
	 * @param  string $idElement The id of the element.
	 * @param  string $strNameEvent The name of the event.
	 * @param  string $strNameFunction The javascript function that is called when the event is fired.
	 */
	public function removeHandler ($idElement, $strNameEvent, $strNameFunction){
		
		$this->response->removeHandler($idElement, $strNameEvent, $strNameFunction);
	}

	/**
	 * Response command used to construct a javascript function
	 * on the browser.
	 * 
	 * @param  string $strNameFunction The name of the function to construct.
	 * @param  string $params Comma separated list of parameter names.
	 * @param  string $jsCode The javascript code that will become the body of the function.
	 */
	public function setFunction ($strNameFunction, $params, $jsCode){

		$this->response->setFunction($strNameFunction, $params, $jsCode);
	}

	/**
	 * Response command used to construct a wrapper function 
	 * around and existing javascript function on the browser.
	 * 
	 * @param  string $strNameFunction The name of the existing function to wrap.
	 * @param  string $params The comma separated list of parameters for the function.
	 * @param  array $mixedJsCode  An array of javascript code snippets that will be used to build the body of the function.  The first piece of code specified in the array will occur before the call to the original function, the second will occur after the original function is called.
	 * @param  string $varReturn The name of the variable that will retain the return value from the call to the original function.
	 */
	public function wrapFunction ($strNameFunction, $params, $mixedJsCode, $varReturn){
			
		$this->response->wrapFunction($strNameFunction, $params, $mixedJsCode, $varReturn);
	}

	/**
	 * Response command used to load a javascript file on the 
	 * browser.
	 * 
	 * @param  string $strUri The relative or fully qualified URI of the javascript file.
	 */
	public function includeScript ($strUri){

		$this->response->includeScript($strUri);
	}

	/**
	 * Response command used to include a javascript file on 
	 * the browser if it has not already been loaded.
	 * 
	 * @param  string $strUri The relative for fully qualified URI of the javascript file.
	 */
	public function  includeScriptOnce ($strUri){
		
		$this->response->includeScriptOnce($strUri);
	}

	/**
	 * Response command used to remove a SCRIPT reference to 
	 * a javascript file on the browser.  Optionally,    you 
	 * can call a javascript function just prior to the file
	 * being unloaded (for cleanup).
	 * 
	 * @param  string $strUri The relative or fully qualified URI of the javascript file.
	 * @param  string $strNameFunction Name of a javascript function to call prior to unlaoding the file.
	 */
	public function removeScript ($strUri, $strNameFunction){
		
		$this->response->removeScript($strUri, $strNameFunction);
	}

	/**
	 * Response command used to include a LINK reference to 
	 * the specified CSS file on the browser.     This will 
	 * cause the browser to load and apply the style sheet.
	 * 
	 * @param  string $strUri The relative or fully qualified URI of the css file.
	 */
	public function includeCSS ($strUri){
		
		$this->response->includeCSS($strUri);
	}

	/**
	 * Response command used to remove a LINK  reference to a 
	 * CSS file on the browser.  This causes the  browser  to 
	 * unload the style sheet, effectively removing the style 
	 * changes it caused.
	 * 
	 * @param  string $strUri The relative or fully qualified URI of the css file.
	 */																																																										
	public function removeCSS ($strUri){
		
		$this->response->removeCSS($strUri);
	}

	/**
	 * Response command instructing xajax to pause while the CSS 
	 * files are loaded.  
	 * The browser is not typically a multi-threading application, 
	 * with regards to javascript code.  Therefore, the CSS files 
	 * included or removed with xajaxResponse->includeCSS and 
	 * xajaxResponse->removeCSS respectively, will not be loaded 
	 * or removed until the browser regains control from the script.  
	 * This command returns control back to the browser and pauses 
	 * the execution of the response until the CSS files, included 
	 * previously, are loaded.
	 * 
	 * @param  integer $insSeconds The number of 1/10ths of a second to pause before timing out and continuing with the execution of the response commands.
	 */																																																													
	public function  waitForCSS ($insSeconds){
		
		$this->response->waitForCSS($insSeconds);
	}

	/**
	 * Response command instructing xajax to delay execution of the 
	 * response commands until a specified condition is met.  
	 * Note, this returns control to the browser, so that other 
	 * script operations can execute.  xajax will continue to 
	 * monitor the specified condition and, when it evaulates to 
	 * true, will continue processing response commands.
	 * 
	 * @param  string $jsPiece A piece of javascript code that evaulates to true or false.
	 * @param  integer $intSeconds The number of 1/10ths of a second to wait before timing out and continuing with the execution of the response commands.
	 */
	public function waitFor ($jsPiece, $intSeconds){

		$this->response->waitFor($jsPiece, $intSeconds);
	}

	/**
	 * Response command which instructs xajax to pause execution 
	 * of the response commands, returning control to the browser 
	 * so it can perform other commands asynchronously.  
	 * After the specified delay, xajax will continue execution of the response commands.
	 * 
	 * @param  integer $intSeconds The number of 1/10ths of a second to sleep.
	 */
	public function sleep ($intSeconds){

		$this->response->sleep($intSeconds);
	}

	/**
	 * Stores a value that will be passed back as part of the response.  
	 * When making synchronous requests, the calling javascript can 
	 * obtain this value immediately as the return value of the xajax.call function.
	 * 
	 * @param  mixed $strValue Any value.
	 */					
	public function setReturnValue ($strValue){
			
		$this->response->setReturnValue($strValue);
	}

	/**
	 * Cierra una ventana.
	 * 
	 * Cierra la ventana actualmente abierta.
	 */	
	public function closeWindow (){
		
		$this->response->script('window.close()');	
	}

   /**
	* Intenta abrir una ventana.
	*  
 	* Intenta abrir una ventana del explorador para mostrar la url que se esta llamando con los parametros requeridos.
 	* @param string $strNomWindow Nombre de la ventana.
 	* @param string $strUrl Url que desea abrir. 
 	* @param integer $widthWindow Ancho de la ventana.
 	* @param integer $heightWindow Alto de la ventana.
 	* @param mixed $mixedGetParams Arreglo de datos con llaves y valores que pueden pasados como parametros o variables GET.    
 	*/
	public function window ($strNomWindow, $strUrl, $widthWindow = '400', $heightWindow = '300', $mixedGetParams = ''){
		if (is_array($mixedGetParams)){
				   
		    $countGet = count($mixedGetParams);	
		    $strGet = '';
		    $countIni = 0;	
				   
			foreach($mixedGetParams as $key => $value){
			   	 $strGet .= $key.'='.$value;
			   	 if ($countIni<($countGet-1)){
			   	    $strGet .= '&';
			   	 }
			   	 
			  	 $countIni++; 
			}
			
			if (stripos($strUrl,'?'))
			   $strUrl.='&'.$strGet;
			else   
			   $strUrl.='?'.$strGet;
		}
				
		$js = 'OpenWindowForm (\''.$strNomWindow.'\', \''.$widthWindow.'\', \''.$heightWindow.'\', \''.$strUrl.'\')';
		$this->response->script($js);
	}
	
	
	/**
	 * Cierra una venta modal
	 * 
	 * Cierra la ultima ventana modal abierta.
	 */
	public function closeModalWindow (){
		
		$this->response->script('closeModalWindow()');
	}

	/**
	 * Abre una ventana modal desde una Url.
	 * 
	 * Lanza una ventana modal al igual que modalWindow pero da la opcion de usar una ruta a un script para cargar su contenido desde alli.
	 * @param string $url	Url del script o pagina dentro del servidor al que hace referencia
	 * @param string $title	Titulo de la ventana
	 * @param integer $width	Ancho en px
	 * @param integer $height	Alto en px
	 * @param integer $effect	Efecto de transicion 1 o 2
	 */
	public function modalWindowFromUrl ($url = '', $title = '', $width = 200, $height = 200, $effect = ''){
		
		$this->modalWindow('', $title, $width, $height, $effect);
		
		$this->response->script('callUrlAsin("'.$url.'","'.$this->idLastMWopen.'_work")');
	}
	
	/**
	 * Abre una ventana modal.
	 * 
	 * Lanza una ventana modal. Una ventana modal que se sobrepone mediante una capa a los elementos que estan detras de ella con un contenido.
	 * @param string $htmlContent	Contenido html
	 * @param string $title	Titulo de la ventana
	 * @param integer $width	Ancho en px
	 * @param integer $height	Alto en px
	 * @param integer $effect	Efecto de transicion 1 o 2
	 */
	public function modalWindow($htmlContent = '', $title = '', $width = 200, $height = 200, $effect = ''){
		
		$tabla = '';
		
		$widthC = ($width-9);
		
		$nameFuntionEffect = '';
		
		$this->idLastMWopen = 'mw_'.date("His");
		
		$arrayEffects = array (
			'curtain' => 'curtain',
			1 => 'curtain',
			'ghost' => 'ghost',
			2 => 'ghost'
		);
		
		$tablaDisplay = '';
		$tablaOpacity = '';
		

		$file = $GLOBALS['folderProject'].'/themes/'.THEME_NAME.'/modal_window/modal_window.tpl';
		
		$arRepl = array (
			'{div_name}'=>$this->idLastMWopen,
			'{tabla_width}'=>$width,
			'{tabla_height}'=>$height,
			'{tabla_display}'=>$tablaDisplay,
			'{tabla_opacity}'=>$tablaOpacity,
			'{div_height}'=>'',
			'{html_title}'=>$title,
			'{width_area}'=>($width-21),
			'{height_area}'=>($height-52),
			'{height_main}'=>($height-52),
			'{html_content}'=>$htmlContent
		);
		
		if ($effect){

			switch ($arrayEffects[$effect]){
					case 'curtain':
					
						$nameFuntionEffect = 'curtain'; 
						$ini_height = 40;
					
						$arRepl['{div_height}'] = 'HEIGHT:40px;';
					break;
					case 'ghost':
							
						if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
							$tablaOpacity = 'filter: alpha(opacity=100);';
						}else{
							$tablaOpacity = 'opacity: 0;';
						}
						
						$nameFuntionEffect = 'desvanecer';
						$ini_height = 0;
							
					break;	
			}
			
		}		
		
		$html = $this->loadHtmlFromFile($file, $arRepl);
		
		$this->response->plugin('myModalWindow', 'addWindow',$html,'#000000',10, $width, $height);
		
		if ($nameFuntionEffect){
			$this->response->script($nameFuntionEffect.'(\''.$this->idLastMWopen.'\','.$width.','.$height.','.$ini_height.');');
		}
		
	}
	
	/**
	 * Cierra un messageBox
	 *  
	 * Cierra el ultimo messageBox abierto
	 */
	public function closeMessageBox (){

		$this->response->script('xajax.closeWindow()');
	}
	
	/**
	 * Abre una ventana de dialogo parametrizable.
	 * 
	 * Abre en la ventana una venanta de dialogo estilo caja de mensaje (messageBox). Es caja de mensaje tiene la posibilidad de tener uno o mas botones, iconos de acuerdo al tipo de mensaje, texto, ect
	 * <code>
	 * 
	 * Ejemplo:
	 * 
	 * handlerEvent.php
	 * <?
	 * 
	 * class events extends myController {
	 * 
	 * 		# Evento botón de formulario:
	 * 
	 * 		public function sendFormData ($formData){
	 * 			
	 * 			# En un arreglo definimos los eventos. Donde la llave es la Etiqueta del botón y el valor es el evento que va a llamar. 
	 * 			# Si la llave no es definida, el valor sera tomado como la etiqueta del boton y el evento por defecto sera closeModalWindow.
	 * 			# Del parametro número 4 al numero 8 puede enviar variables tipo caracter, numericas o arreglos.
	 * 			# Los parametros enviados seran recibidos por el evento definido.
	 * 	
	 * 			$events = array ('Aceptar'=>'acceptSendFormData','Cancelar');			
	 * 
	 * 			$this->messageBox('Los datos fueron enviados','info',$events, $formData);	
	 * 			
	 * 			return $this->response;
	 * 		}
	 * 
	 * 		# Creamos el evento del message box y los programamos
	 * 		public function acceptSendFormData ($formData){
	 * 			
	 * 			$this->alert('Usted pulso el botón aceptar, enviaste esto: '.var_export($formData,true));
	 * 
	 * 			$this->closeMessageBox();
	 * 			
	 * 			return $this->response;
	 * 		}
	 * }
	 * 
	 * ?>
	 * 
	 * </code> 
	 * @param  string $msg Mensaje
	 * @param  string $iconMsg Icono que se va a mostra; critical, error, help, info, list, user, warning
	 * @param  array $mixedButtons  Arreglo de los botones que pueda tener la caja de mensaje 
	 * @param1 array/string $param1 Parametro 1
	 * @param2 array/string $param2 Parametro 2
	 * @param3 array/string $param3 Parametro 3
	 * @param4 array/string $param4 Parametro 4
	 * @param5 array/string $param5 Parametro 5
	 */	
	public function messageBox($msg = '', $iconMsg = 'info', $mixedButtons = array(), $param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){
		
		$arrImg = array (
			'critical'=>'img_critical',
			'error'=>'img_error',
			'help'=>'img_help',
			'info'=>'img_info',
			'list'=>'img_list',
			'user'=>'img_user',
			'warning'=>'img_warning'
		);

		if (isset($arrImg[$iconMsg]))
			$iconMsg = $arrImg[$iconMsg];
		else
			$iconMsg = $arrImg['info'];		
			
		
		$file = $GLOBALS['folderProject'].'/themes/'.THEME_NAME.'/msg_box/message_box.tpl';

		if (!$this->widthMessageBox)
		  $width = 400;
		else  
		  $width = $this->widthMessageBox;
				  
		if (!$this->heightMessageBox){
             $height = intval(strlen($msg)/55)*23;
                 if ($height<100)
                   $height = 170;
		}else
		  $height = $this->heightMessageBox;		

		$frm = '';
		
		$objMyForm = new myForm;
		
		$objMyForm->styleClassButtons = $this->class_name_msg_buttons;
		
		$primerButton = '';
		if (count($mixedButtons)){
		  
			foreach($mixedButtons as $etq=>$action){

				if (!$etq){
					$etq = $action;
					$action = '';
				}
				
		  		if (!$action)
		  			$action = 'closeModalWindow';
		  	
		  		$nameButton = 'bmbx_'.strtolower(trim($etq)); 

		  		$objMyForm->addEvent($nameButton,'onclick',$action, $param1, $param2, $param3, $param4, $param5);
		  	
		  		$frm .= str_ireplace('GetDataForm(\'\'),','',$objMyForm->getButton($nameButton,$etq));	
		  		$frm .= '&nbsp;&nbsp;&nbsp;';
				  	
		 		if (!$primerButton)
		  	   		$primerButton = $nameButton;
		  }
		  
		}else{
			$etq = MSGBOX_STR_UNI_BUTTON;
			
			$primerButton = $nameButton = 'bmbx_'.strtolower(trim($etq));
			
			$objMyForm->addEvent($nameButton,'onclick','closeModalWindow');
			
			$frm .= str_ireplace('GetDataForm(\'\'),','',$objMyForm->getButton($nameButton,$etq));
		}

		$arRepl = array (
			'{titl_msg}'=>MSGBOX_TITLE,
			'{height_msg_box}'=>$height,
			'{width_msg_box}'=>$width,
			'{cont_msg_box}'=>str_replace("\n",'<br>',$msg),
			'{class_div_img}'=>$iconMsg,
			'{cont_form}'=>$frm,
			'{width_area}'=>($width-21),
			'{height_area}'=>($height-52),
			'{height_main}'=>($height-52),
		);		
		
		$html = $this->loadHtmlFromFile($file, $arRepl);
		
        $this->response->plugin('myModalWindow', 'addWindow',$html,'#000000',5, $width, $height);
		
        $this->script('document.getElementById(\''.$primerButton.'\').focus()');
	}

	/**
	 * Abre un messageBox de error.
	 * 
	 * Abre un messageBox con la informacion de un error.
	 * @param string $error Error	
	 * @param string $detail Detalle del error
	 */
	public function errorBox ($error, $detail = ''){
		
		if ($detail)
			$htmDet = '<br><div class="error_detail"><b>'.ERROR_DET_LABEL.':</b>&nbsp;'.$detail.'</div>';
		
		$html = '<div align="center" class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.$error.'<br>'.$htmDet.'</div>';
		
		$this->messageBox($html,'error');
	}
	
	/**
	 * Crea una notificación.
	 * 
	 * Crea un mensaje de notificacion que no afecta la ventana principal.
	 * @param string $strNotification Mensaje de notificacion.
	 * @param integer $intSecDuration Duracion en pantalla.
	 * @param string $style	Estilo que puede ser: info, ok, cancel, error, warning, help, critical.
	 */
	public function notificationWindow ($strNotification, $intSecDuration = 3, $style = 'info'){
		
		$styles = array(
			'info'=>'info',
			'ok'=>'ok',
			'cancel'=>'cancel',
			'error'=>'error',
			'warning'=>'warning',
			'help'=>'help',
			'critical'=>'critical'
		);
		
		if (!isset($styles[$style]))
			$style = 'info';
		
		$intSecDuration = $intSecDuration*1000;
		
		$strNotification = str_replace('"','\"',$strNotification);
		
		$strSctipt = 'createNotificationWindow("'.$strNotification.'",'.$intSecDuration.',"'.$style.'")';
		
		$this->response->script($strSctipt);
	}
	
	/**
	 * Cambia fecha en campo texto.
	 * 
	 * Evento que se cumple al cambiar el mes o año a mostrar en el calendario.
	 * @ignore
	 * @param $partDate
	 * @param $toUpdate
	 * @return string
	 */
	public function MYFORM_calOnChange ($partDate, $toUpdate){

		list($nD, $nM, $nA) = explode ('_',$partDate);
		
		$cal = new myCal($nA, $nM, $nD, $toUpdate);
		
		$this->assign('div_trigger_'.$toUpdate,'innerHTML',$cal->getCalendar());
		
		return $this->response;
	}
	
	/**
	 * Valida un formulario.
	 * 
	 * Valida el contenido de un formulario mediante sus valores y los campos requeridos. 
	 * <code>
	 * 
	 * Ejemplo:
	 * 
	 * handlerEvent.php
	 * <?
	 * 
	 * class events extends myController {
	 * 
	 * 		# Evento botón de formulario:
	 * 		public function validateForm ($formData){
	 * 			
	 * 			# Id's de los campos requeridos.
	 * 			$required = array ('name', 'age', 'last_name');
	 * 
	 * 			if ($this->MYFORM_validate($formData,$required))
	 * 				
	 * 				$this->alert('Datos completos!');
	 * 
	 * 			else
	 * 
	 * 				$this->alert('Datos incompletos!');
	 * 
	 * 			return $this->response;
	 * 		}
	 * 
	 * }
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param array $datForm	Datos del formulario
	 * @param array $requiredFields	Campos requeridos
	 * @return boolean
	 */
	public function MYFORM_validate($datForm,$requiredFields){
		
		$valid = true;
		
		if (is_array($requiredFields)){
			
			foreach ($requiredFields as $field){
				
				if (isset($datForm[$field])){
				
					if (!$datForm[$field]){
					
						$this->assign($field,'className','caja_required');

						$valid = false;
					}else{
					
						$this->assign($field,'className','caja');
					}	
				
				}
				
			}
		}
		
		return $valid;
	}
	
	/**
	 * Nivel de ayuda listas dinamicas
	 * @ignore
	 * @param $datForm
	 * @return unknown_type
	 */
	public function MYLIST_help ($datForm){
		
		$this->window('help_list','../mylistHelp.php',350,630);
		
		return $this->response;
	}
	
	/**
	 * Cambiar el numero de registros a paginar
	 * @ignore
	 * @param $datForm
	 * @param $idList
	 * @return unknown_type
	 */
	public function MYLIST_chPag ($datForm, $idList){
		
		$myList = new myList($idList);
		
		$myList->setVar('recordsPerPageForm',$datForm[$idList.'_chg_pag']);
		
		$myList->setVar('maxNumPage',0);
		
		$myList->setVar('currentPage',0);
		
		$this->assign($idList,'innerHTML',$myList->getList());
		
		$js = 'clearRowsMarked();'."\n";
		
		$this->script($js);
		
		return $this->response;
	}
	
	/**
	 * Mover la lista dinamica a determinada pagina.
	 * @ignore
	 * @param $datForm
	 * @param $idList
	 * @param $numPage
	 * @param $action
	 * @return unknown_type
	 */
	public function MYLIST_page ($datForm, $idList, $action){
		
		$myList = new myList($idList);
		
		$nameVar = 'currentPage';
		
		$error = false;
		
		switch ($action){
			case 'beg':
				$numPage =0;
			break;
			case 'bac':
				$numPage = $myList->getVar($nameVar)-1;
			break;
			case 'goto':
				$this->notificationWindow('Opcion aun no disponible.',5,'info');
				
				$error = true;
			break;
			case 'nex':
				$numPage = $myList->getVar($nameVar)+1;
				
				if ($numPage>$myList->getVar('maxNumPage'))
					$myList->setVar('maxNumPage',$numPage);
			break;
			case 'end':
				$numPage = $myList->getVar('maxNumPage');
			break;
		}
		
		if (!$error){
			
			$myList->setVar($nameVar,$numPage);
		
			//$this->alert(var_export($_SESSION['prdLst'][$idList],true));
		
			$this->assign($idList,'innerHTML',$myList->getList());
		
			$js = 'clearRowsMarked();'."\n";
		
			$this->script($js);
		}
		
		return $this->response;
	}
	
	/**
	 * Ordena ascendente y descendente las columnas.
	 * @ignore
	 * @param $idList	Id o nombre de la lista dinámica	
	 * @param $alias	Alias de la columna
	 */
	public function MYLIST_moveTo ($idList, $alias){
		
		$myList = new myList($idList);
		
		$nameVar = 'arrayOrdMethod';

		switch ($myList->getVar($nameVar,$alias)){
			case 'ASC':
				$myList->setVar($nameVar,'DESC',$alias);
			break;
			case 'DESC':
				$myList->setVar($nameVar,'',$alias);
				
				$myList->unSetVar('arrayOrdNum',$alias);
			break;
			case '':
				$myList->setVar($nameVar,'ASC',$alias);
				
				$myList->setVar('arrayOrdNum',$alias,$alias);
			break;
		}
		
		//$this->alert(var_export($_SESSION['prdLst'][$idList],true));
		
		$this->assign($idList,'innerHTML',$myList->getList());
		
		$js = 'clearRowsMarked();'."\n";
		
		$this->script($js);
		
		return $this->response;
	}
	
	/**
	 * Cuarda el resultado de la consulta de una lista dinamica segun el filtro aplicado al disco
	 * @ignore
	 * @param $datForm	Datos de form
	 * @param $format	Formato
	 * @param $idList	Id lista
	 */
	public function MYLIST_exportData ($datForm, $format, $idList){

		$usepg = 'f';
		if ($datForm['not_pg_'.$idList]){
			$usepg = 't';
		}
		
		$error = '';
		
		if (!$error){
			
			$url = '../downloadQuery.php?id_list='.$idList.'&format='.$format.'&usepg='.$usepg;
			$this->redirect($url);
		}
		
		return $this->response;
	}
	
	/**
	 * Abre una ventana modal con un formulario que permite agregar una regla a la consulta actual de la lista dinamica.
	 * @ignore
	 * @param $datForm	Datos de form
	 * @param $idList	Id lista
	 * @return string
	 */
	public function MYLIST_addRuleQuery ($datForm, $idList){
		
		$arFields = array();
		
		$objMyForm = new myForm($idForm = $idList.'QueryForm');
		
		$objMyForm->cellPadding = 0;
		
		$objMyForm->styleTypeHelp = 2;
		
		$objMyForm->selectUseFirstValue = false;
		
		$objList = new myList($idList);
		
		$arFldOnQry = $objList->getVar('arrayFieldsOnQuery');
		
		$arEvnOnClm = $objList->getVar('arrayEventOnColumn');
		
		$arAlsInQry = $objList->getVar('arrayAliasSetInQuery');		
		
		$objList->setVar('numRuleQuery',$numRuleQuery = $objList->getVar('numRuleQuery')+1);

		$html = '<table border="0" id="rule_gp_'.$idList.'_'.$numRuleQuery.'" width="100%" cellpadding="0" cellspacing="0">';
		
		$html .= '<tr>';
		
		$html .= '<td width="10%" align="center"><div id="status_'.$idList.'_'.$numRuleQuery.'" class="rule_cancel" id=""></div></td>';
		
		$objMyForm->addHelp('logic_'.$numRuleQuery,LABEL_LOGIC_FIELD_ADD_RULE_FORM);
		
		$html .= '<td width="18%" align="center">'.$objMyForm->getSelect(
			'logic_'.$numRuleQuery,
			array(
				'AND'=>LABEL_RELATION_OPTAND_ADD_RULE_FORM,
			
				'OR'=>LABEL_RELATION_OPTOR_ADD_RULE_FORM)
			).'</td>';
		
		
		foreach ($arFldOnQry as $field){
			
			if (!isset($arEvnOnClm[$field])){
				
				$etq = $field;
				
				if (isset($arAlsInQry[$field])){
					
					$data = $arAlsInQry[$field];
					
					list($etq,$data_type) = explode('::',$data);
				}else
					$data = $field;
					
				$arFields[$field] = $etq;
			}
		}
		
		$objMyForm->addHelp('field_'.$numRuleQuery, LABEL_FIELD_LIST_ADD_RULE_FORM);
		
		$html .= '<td width="18%" align="center">'.$objMyForm->getSelect('field_'.$numRuleQuery,$arFields).'</td>';	
			
		$spaCha = '&nbsp;';
		
		$objMyForm->addHelp('relation_'.$numRuleQuery,LABEL_RELATION_FIELD_ADD_RULE_FORM);
		
		$html .= '<td width="18%" align="center">'.$objMyForm->getSelect('relation_'.$numRuleQuery,$this->myDinamicListRel).'</td>';
		
		$objMyForm->addHelp('value_'.$numRuleQuery,LABEL_FIELD_VALUE_ADD_RULE_FORM);
		
		$html .= '<td width="18%" align="center">'.$objMyForm->getText('value_'.$numRuleQuery,NULL,12).'</td>';
		
		$objMyForm->addHelp($idList.'_remove_rule_'.$numRuleQuery,LABEL_HELP_REM_RULE_FORM);

		$objMyForm->addEvent($idList.'_remove_rule_'.$numRuleQuery,'onclick','MYLIST_removeRuleQuery',$idList,$numRuleQuery);
		
		$html .= '<td align="center">'.
		
			$objMyForm->getButton($idList.'_remove_rule_'.$numRuleQuery,NULL,'remove.gif').
			
		'</td>';
		
		$html .= '</tr>';
		
		$html .= '</table>';
		
		$this->append('rule_for_'.$idList,'innerHTML',$html);
		
		foreach ($datForm as $id => $value){
			$this->assign($id,'value',$value);
		}
		
		$this->script("blockFirstElementForm('".$idForm."')");
		
		return $this->response;
	}
	
	/**
	 * Elimina una regla del formulario de filtro por reglas de la lista dinamica
	 * @ignore
	 * @param $datForm	Datos de form
	 * @param $idList	Id de la lista
	 * @param $numRule	Id de la regla
	 * @return string
	 */
	public function MYLIST_removeRuleQuery ($datForm, $idList, $numRule){

		$myList = new myList($idList);
		
		$idForm = $idList.'QueryForm';
		
		$arWhRls = $myList->getVar('arrayWhereRules');
		
		$this->remove('rule_gp_'.$idList.'_'.$numRule);

		$this->script("blockFirstElementForm('".$idForm."')");
		
		if (isset($arWhRls[$numRule])){
			
			$myList->unSetVar('arrayWhereRules',$numRule);

			$myList->setVar('maxNumPage',0);
		
			$myList->setVar('currentPage',0);

			#Cuando se elimina el filtro se vuelve a ejecutar la consulta
			
			$this->assign($idList,'innerHTML',$myList->getList());
			
			$js = 'clearRowsMarked();'."\n";
		
			$this->script($js);
		}

		return $this->response;
	}
	
	
	/**
	 * Aplicar una regla antes definida
	 * @ignore
	 * @param $datForm	Datos de form
	 * @param $idList	Id de la lista
	 * @return string
	 */
	public function MYLIST_applyRuleQuery ($datForm, $idList){
		
		$someValues = false;
		
		$someNullValues = false;
		
		$sqlRule = '';
					
		$myList = new myList($idList);
		
		$numRules = $myList->getVar('numRuleQuery');
		
		for ($i=1;$i<=$numRules;$i++){
			
			if (isset($datForm['field_'.$i])){

				$val = trim($datForm['value_'.$i]);
				 
				if ($val){
					
					$someValues = true;
					
					if (in_array($datForm['relation_'.$i],array('in','notin'))){
						
						$nVal = '(';
						
							$vals = explode(',',$val);
							
							foreach ($vals as $nVals){
								
								if (!is_numeric($nVals))
									$nVals = '\''.$nVals.'\'';
								
								$nVal .= $nVals.',';
							}
						
						$val = substr($nVal,0,-1).')';
						
					}else if (in_array($datForm['relation_'.$i],array('like','notlike'))){
						
						$val = '\''.$val.'\'';
						
					}else{
						
						if (!is_numeric($val))
							$val = '\''.$val.'\'';
							
					}
					
					$sqlRule .= $datForm['logic_'.$i].' '.$datForm['field_'.$i].' '.$this->myDinamicListRel[$datForm['relation_'.$i]].' ';
					
			
					$sqlRule .= $val;
					
					$myList->setVar('arrayWhereRules',$sqlRule,$i);
					
					$this->assign('value_'.$i,'className','caja');
					
					$this->assign('status_'.$idList.'_'.$i,'className','rule_apply');
					
				}else{
					
					$someNullValues = true;
					
					$this->assign('value_'.$i,'className','caja_required');
				}
				
			}
			
		}
		
		if ($someValues){
			
			$myList->setVar('maxNumPage',0);
			
			$myList->setVar('currentPage',0);
		
			$this->assign($idList,'innerHTML',$myList->getList());
		
			if ($myList->isSuccessfulProcess()){
			
				if ($myList->getNumRowsAffected()){
				
					$this->notificationWindow(MSG_QUERY_FORM_OK,3,'ok');
					
			}else
				$this->notificationWindow(MSG_QUERY_FORM_NOROWS,3,'info');
					
			}else{
				$this->notificationWindow(MSG_QUERY_FORM_BAD,3,'error');

				$myList->unSetVar('arrayWhereRules',$i);
			}
		
			$js = 'clearRowsMarked();'."\n";
		
			$this->script($js);
			
		}else{
			
			$this->notificationWindow(MSG_APPLY_RULES_ALL_VALUES_NULL,3,'warning');
		}
		
		return $this->response;
	}
	
	/**
	 * Recarga una lista dinamica.
	 * 
	 * Refresca los datos contenidos de una lista dinamica previamente declarada y actuamente mostrada.
	 * @param string $idList Id de la lista a refrescar su contenido
	 */
	public function MYLIST_reload($idList){
		
		if (isset($_SESSION['prdLst'][$idList])){
			
			$myList = new myList($idList);
		
			$this->assign($idList,'innerHTML',$myList->getList());
		
			$js = 'clearRowsMarked();'."\n";
		
			$this->script($js);
		}else
			$this->messageBox(MSG_ERROR_IDLIST_NOTDEFINED,'critical');	
		
	}
	
}

?>