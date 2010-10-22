<?php


class myControllerExt {
	
  	/**
  	 * Retorna un contenido HTML desde un archivo plano
  	 * 
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
 * myHandlerEvent
 * 
 * @uses Controlador de eventos
 * @package OSEZNO FRAMEWORK
 * @version 0.1
 * @author joselitohaCker
 *  
 * Clase que es padre de los eventos
 * de los diferentes modulos que existan
 * en la aplicacion.
 *
 */
class myController extends myControllerExt {

	/**
	 * Objeto de xajax pasado como referencia del Original
	 * pasado como parametro dentro del constructor.
	 *
	 * @var object
	 */
	private $xajaxObject;


	/**
	 * Recibe todas las peticiones de respuesta de xajax
	 * para poder permitir que este atributo se permita
	 * retornar en los metodos de la clases hijas.
	 *
	 * @var string
	 */
	protected $response;
	
	
	/**
	 * Nombre de la clase CSS que usara el contenido
	 * de los messageBox.
	 *
	 * @var string
	 */
	private $class_name_msg_content = 'message_box';
	
	
	/**
	 * Nombre de la clase CSS que usara el contenido
	 * de los titulos de los messageBox
	 *
	 * @var string
	 */
	private $class_name_msg_ttl = 'ttl_message_box';
	
	
	/**
	 * Nombre de la clase CSS que usaran los botones
	 * que se definan dentro del messageBox 
	 *
	 * @var string
	 */
	private $class_name_msg_buttons = 'button_message_box';

	
	
	/**
	 * Arreglo que contiene los nombres de los metodos
	 * magicos que para el controlador de eventos   no
	 * seran tenidos en cuenta.  
	 *
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
	   'modalWindow','closeModalWindow'
	);
	
	/**
	 * Id de la ultima modal window abierta
     */
	private $idLastMWopen = '';
	
	
	/**
 	 * Define el alto de la caja de
 	 * mensaje, si no tiene un valor
 	 * este se calculara automaticamente
 	 * dependiento del numero de caracteres
 	 * que contenga el mensaje
 	 *
 	 * @var int
 	 */
	public $heightMessageBox;

	
	/**
 	 * Define el ancho de la caja de
 	 * mensaje, si no tiene un valor
 	 * este sera por defecto 450px
 	 *
 	 * @var int
 	 */	
	public $widthMessageBox;
	
	
	/**
	 * Constructor de la clase
	 * Nota: Es el handlerEvent principal, aqui se registran automaticamente
	 * todos los methodos para que sean llamados a travez de xajax del lado del
	 * cliente.
	 *
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
		       //echo $method."<br>";
			}
		}
		
		
	}

	
	/**
	 * Destructor de la clase
	 *
	 */
	public function __destruct (){
		 
	}

		
	/**
	 * Display an alert dialog to the user.
	 * 
	 * @param string: The message to be displayed.
	 */
	public function alert($srtMsg){
		
		$this->response->alert($srtMsg);
	}
				
	
	/**
	 * Response command indicating that the 
	 * specified  value should be  assigned 
	 * to the given element’s attribute.
	 * 
	 * @param  string: The id of the html element on the browser.
	 * @param  string: The property to be assigned.
	 * @param  string: The value to be assigned to the property.
	 */ 	
	public function assign($idElement, $propertyElement, $newValue){
		
		$this->response->assign($idElement, $propertyElement, $newValue);
	}
				
	/**
	 * Replace a specified value with another
	 * value within the given element’s property.
	 * 
	 * @param  string: The id of the element to update.
	 * @param  string: The property to be updated.
	 * @param  string: The needle to search for.
	 * @param  string: The data to use in place of the needle.
	 */
	public function replace($idElement, $propertyElement, $strToFind, $newValue){
		
		$this->response->replace($idElement,$propertyElement, $strToFind, $newValue);
	}
				
	/**
	 * Response command used to clear the specified
	 * property of the given element.
	 * 
	 * @param  string: The id of the element to be updated.
	 * @param  string: The property to be clared.
	 */
	public function clear ($idElement, $propertyElement){

		$this->response->clear($idElement, $propertyElement);
	}
				
	/**
	 * Response command that causes the browser to 
	 * navigate to the specified URL.
	 * 
	 * @param  string: The relative or fully qualified URL.
	 * @param  integer, optional: Number of seconds to delay before the redirect occurs.
	 */
	public function redirect($strUrl, $intDelaySeconds){

		$this->response->redirect($strUrl, $intDelaySeconds);
	}
				
	/**
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
	 * @param  string: The script to execute.
	 */
	public function script ($strJs){
		
		$this->response->script($strJs);
	}	
				
	/**
	 * Response  command that indicates the specified 
	 * data should be appended to the given element’s 
	 * property.
	 * 
	 * @param  string: The id of the element to be updated.
	 * @param  string: The name of the property to be appended to.
	 * @param  string: The data to be appended to the property.
	 */	
	public function append ($idElement, $propertyElement, $dataAppended){
				
		$this->response->append($idElement, $propertyElement, $dataAppended);
	}
				
	/**
	 * Response command to prepend the specified value 
	 * onto the given element’s property.
	 * 
	 * @param  string: The id of the element to be updated.
	 * @param  string: The property to be updated.
	 * @param  string: The value to be prepended.
	 */
	public function prepend ($idElement, $propertyElement, $dataPrepended){

		$this->response->prepend($idElement, $propertyElement, $dataPrepended);
	}
				
	/**
	 * Response command that indicates that the  specified 
	 * javascript function should be called with the given 
	 * (optional) parameters.
	 * 
	 * @param  string: The name of the function to call.
	 * @param  arg2 .. argn .. arguments to be passed to the function.
	 */
	public function call ($strFunctionToCall, $params){

		$this->response->call($strFunctionToCall, $params);
	}
				
	/**
	 * Response command used to remove an element from the
	 * document.
	 * 
	 * @param  string: The id of the element to be removed.
	 */
	public function remove ($strFunctionToCall){

		$this->response->remove($strFunctionToCall);				
	}
				
	/**
	 * Response command used to create a new element on the 
	 * browser.
	 * 
	 * @param  string: The id of the parent element.
	 * @param  string: The tag name to be used for the new element.
	 * @param  string: The id to assign to the new element.
	 * @param  string, optional: The type of tag, deprecated, use xajaxResponse->createInput instead.
	 */
	public function create ($idParentElement, $tagNewElement, $idNewElement, $tagType){

		$this->response->create($idParentElement, $tagNewElement, $idNewElement, $tagType = '');
	}
				
	/**
	 * Response command used to insert a new element just 
	 * prior to the specified element.
	 * 
	 * @param  string: The element used as a reference point for the insertion.
	 * @param  string: The tag to be used for the new element.
	 * @param  string: The id to be used for the new element.
	 */
	public function insert ($idElementRef, $tagNewElement, $idNewElement){

		$this->response->insert($idElementRef, $tagNewElement, $idNewElement);
	}
				
	/**
	 * Response command used to insert a new element after 
	 * the specified one.
	 * 
	 * @param  string: The id of the element that will be used as a reference for the insertion.
	 * @param  string: The tag name to be used for the new element.
	 * @param  string: The id to be used for the new element.
	 */
	public function insertAfter ($idElementRef, $tagNewElement, $idNewElement){

		$this->response->insertAfter($idElementRef, $tagNewElement, $idNewElement);
	}
				
	/**
	 * Response command used to create an input element on 
	 * the browser.
	 * 
	 * @param  string: The id of the parent element.
	 * @param  string: The type of the new input element.
	 * @param  string: The name of the new input element.
	 * @param  string: The id of the new element.
	 */
	public function createInput ($idParentElement, $typeNewElement, $strNameNewElement, $idNewElement){

		$this->response->createInput($idParentElement, $typeNewElement, $strNameNewElement, $idNewElement);
	}
				
	/**
	 * Response command used to insert a new input element 
	 * preceeding the specified element.
	 * 
	 * @param  string: The id of the element to be used as the reference point for the insertion.
	 * @param  string: The type of the new input element.
	 * @param  string: The name of the new input element.
	 * @param  string: The id of the new input element.
	 */
	public function insertInput ($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement){
			
		$this->response->insertInput($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement);
	}
				
	/**
	 * Response command used to insert a new input element
	 * after the specified element.
	 * 
	 * @param  string: The id of the element that is to be used as the insertion point for the new element.
	 * @param  string: The type of the new input element.
	 * @param  string: The name of the new input element.
	 * @param  string: The id of the new input element.
	 */
	public function insertInputAfter ($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement){
			
		$this->response->insertInputAfter($idElementRef, $typeNewElement, $strNameNewElement, $idNewElement);
	}
				
	/**
	 * Response command used to set an event handler on the 
	 * browser.
	 * 
	 * @param  string: The id of the element that contains the event.
	 * @param  string: The name of the event.
	 * @param  string: The javascript to execute when the event is fired.
	 */
	public function setEvent ($idELement, $strNameEvent, $strNameFunction){
				
		$this->response->setEvent($idELement, $strNameEvent, $strNameFunction);
	}
				
	/**
	 * Response command used to install an event handler on the
	 * specified element.
	 * 
	 * @param  string: The id of the element.
	 * @param  string: The name of the event to add the handler to.
	 * @param  string: The javascript function to call when the event is fired.
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
	 * @param  string: The id of the element.
	 * @param  string: The name of the event.
	 * @param  string: The javascript function that is called when the event is fired.
	 */
	public function removeHandler ($idElement, $strNameEvent, $strNameFunction){
		
		$this->response->removeHandler($idElement, $strNameEvent, $strNameFunction);
	}
				
	/**
	 * Response command used to construct a javascript function
	 * on the browser.
	 * 
	 * @param  string: The name of the function to construct.
	 * @param  string: Comma separated list of parameter names.
	 * @param  string: The javascript code that will become the body of the function.
	 */
	public function setFunction ($strNameFunction, $params, $jsCode){

		$this->response->setFunction($strNameFunction, $params, $jsCode);
	}
				
	/**
	 * Response command used to construct a wrapper function 
	 * around and existing javascript function on the browser.
	 * 
	 * @param  string: The name of the existing function to wrap.
	 * @param  string: The comma separated list of parameters for the function.
	 * @param  array:  An array of javascript code snippets that will be used to build the body of the function.  The first piece of code specified in the array will occur before the call to the original function, the second will occur after the original function is called.
	 * @param  string: The name of the variable that will retain the return value from the call to the original function.
	 */
	public function wrapFunction ($strNameFunction, $params, $mixedJsCode, $varReturn){
			
		$this->response->wrapFunction($strNameFunction, $params, $mixedJsCode, $varReturn);
	}
				
	/**
	 * Response command used to load a javascript file on the 
	 * browser.
	 * 
	 * @param  string: The relative or fully qualified URI of the javascript file.
	 */
	public function includeScript ($strUri){

		$this->response->includeScript($strUri);
	}
				
	/**
	 * Response command used to include a javascript file on 
	 * the browser if it has not already been loaded.
	 * 
	 * @param  string: The relative for fully qualified URI of the javascript file.
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
	 * @param  string: The relative or fully qualified URI of the javascript file.
	 * @param  string: Name of a javascript function to call prior to unlaoding the file.
	 */
	public function removeScript ($strUri, $strNameFunction){
		
		$this->response->removeScript($strUri, $strNameFunction);
	}
				
	/**
	 * Response command used to include a LINK reference to 
	 * the specified CSS file on the browser.     This will 
	 * cause the browser to load and apply the style sheet.
	 * 
	 * @param  string: The relative or fully qualified URI of the css file.
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
	 * @param  string: The relative or fully qualified URI of the css file.
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
	 * @param  integer: The number of 1/10ths of a second to pause before timing out and continuing with the execution of the response commands.
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
	 * @param  string: A piece of javascript code that evaulates to true or false.
	 * @param  integer: The number of 1/10ths of a second to wait before timing out and continuing with the execution of the response commands.
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
	 * @param  integer: The number of 1/10ths of a second to sleep.
	 */
	public function sleep ($intSeconds){

		$this->response->sleep($intSeconds);
	}
								
	/**
	 * Stores a value that will be passed back as part of the response.  
	 * When making synchronous requests, the calling javascript can 
	 * obtain this value immediately as the return value of the xajax.call function.
	 * 
	 * @param  mixed: Any value.
	 */					
	public function setReturnValue ($strValue){
			
		$this->response->setReturnValue($strValue);
	}
						
	/**
	 * Returns the current content type that will be used for 
	 * the response packet.  (typically: “text/xml”)
	 */																																																		
	public function getContentType (){
		
	}
				
	public function getOutput (){
		
	}
																																																																	
	public function getCommandCount (){
		
	}
																																																																	
	public function loadCommands (){
		
	}

	/**
	 * Cierra la ventana actualmente abierta
	 */	
	public function closeWindow (){
		
		$this->response->script('window.close()');	
	}
				

	/**
 	* Abre una ventana del explorador para mostrar
 	* la url que se esta llamando con los parametros
 	* requeridos.
 	* 
 	* @param string: Nombre de la ventana.
 	* @param int: Ancho de la ventana.
 	* @param int: Alto de la ventana.
 	* @param string: Url que desea abrir.
 	* @param mixed: Arreglo de datos con llaves y valores que pueden pasados como parametros o variables GET.    
 	*/
	public function window ($strNomWindow, $widthWindow, $heightWindow, $strUrl, $mixedGetParams){
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
	 * @return string
	 */
	public function closeModalWindow (){
		$_SESSION['lb_widgets']--;
		$this->response->script('xajax.closeWindow()');
	}

	/**
	 * Lanza una ventana modal al igual que modalWindow pero da la opcion de usar una ruta a un script para cargar su contenido desde alli.
	 * 
	 * @param $url	Url del script o pagina dentro del servidor al que hace referencia
	 * @param $title	Titulo de la ventana
	 * @param $width	Ancho en px
	 * @param $height	Alto en px
	 * @param $effect	Efecto de transicion
	 * 
	 * @return string
	 */
	public function modalWindowFromUrl ($url = '', $title = '', $width = 200, $height = 200, $effect = ''){
		
		$this->modalWindow('', $title, $width, $height, $effect);
		
		$this->response->script('callUrlAsin("'.$url.'","'.$this->idLastMWopen.'_work")');
	}
	
	/**
	 * Lanza una ventana tipo modal
	 * 
	 * @param $htmlContent	Contenido html
	 * @param $title	Titulo de la ventana
	 * @param $width	Ancho en px
	 * @param $height	Alto en px
	 * @param $effect	Efecto de transicion 1 o 2
	 * 
	 * @return string
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
	 * Cierra la caja de mensaje actual abierta
	 */
	public function closeMessageBox (){

		$this->response->script('xajax.closeWindow()');
	}
	
	
	/**
	 * Abre en la ventana una venanta de dialogo estilo
	 * caja de mensaje (messageBox). Es caja de mensaje
	 * tiene la posibilidad de tener uno o mas botones,
	 * iconos de acuerdo al tipo de mensaje, texto, ect
	 *
	 * @param  string: Mensaje
	 * @param  string: Icono que se va a mostra; critical, error, help, info, list, user, warning
	 * @param  array:  Arreglo de los botones que pueda tener la caja de mensaje 
	 * @param  string: Nombre del formulario que abre la caja de mensaje
	 */	
	public function messageBox($msg = '', $iconMsg = '', $mixedButtons = array(), $strNomForm = ''){
		
		$arrImg = array (
			'critical'=>'img_critical',
			'error'=>'img_error',
			'help'=>'img_help',
			'info'=>'img_info',
			'list'=>'img_list',
			'user'=>'img_user',
			'warning'=>'img_warning'
		);
		
		if (!isset($arrImg[$iconMsg]))
			$iconMsg = 'img_info';
		else
			$iconMsg = $arrImg[$iconMsg];	
		
		$file = $GLOBALS['folderProject'].'/themes/'.THEME_NAME.'/msg_box/message_box.tpl';

		if (!$this->widthMessageBox)
		  $width = 450;
		else  
		  $width = $this->widthMessageBox;
				  
		if (!$this->heightMessageBox){
             $height = intval(strlen($msg)/55)*23;
                 if ($height<100)
                   $height = 200;
		}else
		  $height = $this->heightMessageBox;		

		$frm = '';
		
		$objMyForm = new myForm;
		$objMyForm->NomForm = $strNomForm;

		$objMyForm->styleClassButtons = $this->class_name_msg_buttons;
		
		$primerButton = '';
		if (count($mixedButtons)){
		  
			foreach($mixedButtons as $etq=>$action){

		  	if (!$action)
		  	   $action = 'closeModalWindow()';

		  	$nameButton = 'bmbx_'.strtolower(trim($etq)); 
				  	
		  	$frm .= $objMyForm->getButton($nameButton,$etq,$action);	
		  	$frm .= '&nbsp;&nbsp;&nbsp;';
				  	
		 	if (!$primerButton)
		  	   $primerButton = $nameButton;
		  }
		}else{
			$etq = MSGBOX_STR_UNI_BUTTON;
			
			$nameButton = 'bmbx_'.strtolower(trim($etq));
			
			$frm .= $objMyForm->getButton($nameButton,$etq,'closeModalWindow()');
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
		
        if ($primerButton)
   			$this->response->script('document.message_box_buttons.'.$primerButton.'.focus()');
	}

	/**
	 * Abre un messageBox con la informacion del error
	 * 
	 * @param $error	
	 * @param $detail	Detalle del error
	 * @return unknown_type
	 */
	public function errorBox ($error, $detail = ''){
		
		if ($detail)
			$htmDet = '<br><div class="error_detail"><b>'.ERROR_DET_LABEL.':</b>&nbsp;'.$detail.'</div>';
		
		$html = '<div align="center" class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.$error.'<br>'.$htmDet.'</div>';
		
		$this->messageBox($html,'error');
	}
	
	/**
	 * Crea un mensaje de notificacion que no afecta la ventana
	 * principal.
	 *
	 * @param string $strNotification
	 * @param integer $intSecDuration
	 * @param string $strColorBg
	 */
	public function notificationWindow ($strNotification, $intSecDuration = 3, $strColorBg = '#FF0000'){
		
		$intSecDuration = $intSecDuration*1000;
		
		$strSctipt = 'createNotificationWindow("'.$strNotification.'",'.$intSecDuration.',"'.$strColorBg.'")';
		
		$this->response->script($strSctipt);
	}
	
	
	public function calEventOnChange ($partDate, $toUpdate){

		list($nD, $nM, $nA) = explode ('_',$partDate);
		
		$cal = new myCal($nA, $nM, $nD, $toUpdate);
		
		$this->assign('div_trigger_'.$toUpdate,'innerHTML',$cal->getCalendar());
		
		return $this->response;
	}
	
	/**
	 * Mover la lista dinamica a determinada pagina.
	 * 
	 * @param $datForm
	 * @param $idList
	 * @param $numPage
	 * @param $action
	 * @return unknown_type
	 */
	public function myListPage ($datForm, $idList, $action){
		
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
				$this->notificationWindow('Opcion aun no disponible. [Pendiente]',3,'red');
				
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
		
			$js = 'myList.clearRowsMarked();'."\n";
		
			$this->script($js);
		}
		
		return $this->response;
	}
	
	/**
	 * Mueve la lista dinamica en sentido adelante, atras, ascendente y descendente.
	 * 
	 * @param $idList	Id o nombre de la lista dinámica	
	 * @param $alias	Alias de la columna
	 */
	public function myListMoveTo ($idList, $alias){
		
		$myList = new myList($idList);
		
		$nameVar = 'arrayOrdMethod';

		switch ($myList->getVar($nameVar,$alias)){
			case 'ASC':
				$myList->setVar($nameVar,'DESC',$alias);
			break;
			case 'DESC':
				$myList->setVar($nameVar,'',$alias);
				
				//$myList->unSetVaretVar('arrayOrdNum',$alias);
			break;
			case '':
				$myList->setVar($nameVar,'ASC',$alias);
				
				//$myList->setVar('arrayOrdNum','1',$alias);
			break;
		}
		
		$this->alert(var_export($_SESSION['prdLst'][$idList],true));
		
		//$arrayColors = array('green','purple','red','blue','black','pink');
		
		//$this->notificationWindow(str_replace(array("\n"),array(''),$myList->getVar('sqlW')),2,$arrayColors[rand(0,5)]);
		
		$this->assign($idList,'innerHTML',$myList->getList());
		
		$js = 'myList.clearRowsMarked();'."\n";
		
		$this->script($js);
		
		return $this->response;
	}
	
	/**
	 * Carga atributos visuales de la lista dinamica 
	 * @param $idList
	 * 
	 * @return string 
	 */
	public function myListLoadCSS ($idList){
		
		$myList = new myList($idList);
		
		$this->includeCSS($myList->setTheme());
		
		return $this->response;
	}
	
	
	/**
	 * Ordena o mueve las paginas de una lista
	 * dinamica.
	 *
	 * @param string $NameRefList
	 * @param string $OrderBy
	 * @param string $aliasOrderBy
	 * @param integer $Desde
	 * @param integer $Hasta
	 * @param string $CambiarOrden
	 * @return string
	 */
	public function myListMove ($NameRefList, $OrderBy = '',  $Desde = '', $Hasta = '', $CambiarOrden = 'S'){
		$objDinamicList = new myDinamicList($NameRefList, $_SESSION['prdLst'][$NameRefList]['sql']);
		
		//$this->script('rowsMarked = new Array();');
		
		if ($OrderBy && $CambiarOrden == "S"){

			$_SESSION['prdLst'][$NameRefList]['ordBy']  = $OrderBy;

			switch ($_SESSION['prdLst'][$NameRefList]['ordMtd']){
				case 'ASC':
					$_SESSION['prdLst'][$NameRefList]['ordMtd'] = 'DESC';
					break;
				case 'DESC':
					$_SESSION['prdLst'][$NameRefList]['ordMtd'] = '';
					unset($_SESSION['prdLst'][$NameRefList]['ordBy']);
					break;
				case '':
					$_SESSION['prdLst'][$NameRefList]['ordMtd'] = 'ASC';
					break;
			}
		}
	
		//$_SESSION['prdLst'][$NameRefList]['pagIni'] = $Desde;

		//$_SESSION['prdLst'][$NameRefList]['acPag'] = $Desde/$Hasta;
	
		//Refrescamos la lista dinamica
		$this->response->assign($NameRefList,'innerHTML',$objDinamicList->getDinamicList($NameRefList,false));
		
		/*
		// Averiguo si estoy en la ultima pagina generada
		if (($_SESSION['prdLst'][$NameRefList]['acPag']+1)==$_SESSION['prdLst'][$NameRefList]['tcPag']){
		
			//Preguntamos si la ultima pagina ya se lleno para regenar el tope
			if ($_SESSION['prdLst'][$NameRefList]['cTsh']==$_SESSION['prdLst'][$NameRefList]['pagRng']){
			
				//$this->alert('Se llego al tope'); 
				
				$objActiveRecord = new myActiveRecord;
				$antes = $_SESSION['prdLst'][$NameRefList]['cRws'];
			
				switch($_SESSION['prdLst'][$NameRefList]['enD']){
					case 'mysql':
						$_SESSION['prdLst'][$NameRefList]['cRws'] = mysqli_num_rows(mysqli_query($_SESSION['prdLst'][$NameRefList]['sql']));
					break;
					case 'postgre':
						$_SESSION['prdLst'][$NameRefList]['cRws'] = pg_num_rows (pg_query($_SESSION['prdLst'][$NameRefList]['sql']));
					break; 
				}
		    	
				//$this->alert('Encontramos ahora que hay '.$_SESSION['prdLst'][$NameRefList]['cRws'].' de '.$antes.' que habian antes');
		    	
		    	if ($_SESSION['prdLst'][$NameRefList]['cRws']>($_SESSION['prdLst'][$NameRefList]['tcPag']*$_SESSION['prdLst'][$NameRefList]['pagRng'])){
			   		$_SESSION['prdLst'][$NameRefList]['tcPag'] = intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng'])+1;
			   	
			   	//$this->alert('Aumentamos una pagina');
			   	
			   	$objDinamicListUpdate = new myDinamicList($NameRefList, $_SESSION['prdLst'][$NameRefList]['sql']);
			   
			   	$this->response->assign($NameRefList,'innerHTML',$objDinamicListUpdate->getDinamicList($NameRefList,false));
		    	}else{
		       		//$this->alert('NO aumentamos ninguna pagina');
		    	}
		    	
			}
		}
		*/
		
		return $this->response;
	}

	/**
	 * Recarga la consulta de una lista dinamica
	 * mediante su formulario de parametrizacion
	 *
	 * @param mixed $FormElements
	 * @param string $strLabel
	 * @param string $strNomDiv
	 */
	public function myListReloadQuery ($FormElements, $strLabel = '', $strNomDiv = ''){
		$objMyForm = new myForm;
	 
		$this->script('rowsMarked = new Array();');
		unset($_SESSION['prdLst'][$NameRefList]['ordBy'], $_SESSION['prdLst'][$NameRefList]['ordMtd']);
		
		$NameRefList = $FormElements['mylist_ndiv'];
		$objDinamicList = new myDinamicList($NameRefList);
	
		if ($FormElements && $strLabel){
			if ($FormElements['mylist_filter_select']){
				if (strlen($FormElements['mylist_text'])){
					// La consulta Original
					$strSqlOriginal    = $_SESSION['prdLst'][$NameRefList]['sqlt'];
					$strConsultaActual = $_SESSION['prdLst'][$NameRefList]['sqlt'];
					 
					switch ($FormElements['mylist_filter_select']){
						case 1://'abc123 %'
							if (strpos(strtolower($strConsultaActual),'where')){
								$strConsultaActual .= ' AND UPPER('.$FormElements['mylist_select'].') LIKE \''.strtoupper($FormElements['mylist_text']).'%\' ';
							}else{
								$strConsultaActual .= ' WHERE UPPER('.$FormElements['mylist_select'].') LIKE \''.strtoupper($FormElements['mylist_text']).'%\' ';
							}
							break;
						case 2://'% abc123'
							if (strpos(strtolower($strConsultaActual),'where')){
								$strConsultaActual .= ' AND UPPER('.$FormElements['mylist_select'].') LIKE \'%'.strtoupper($FormElements['mylist_text']).'\' ';
							}else{
								$strConsultaActual .= ' WHERE UPPER('.$FormElements['mylist_select'].') LIKE \'%'.strtoupper($FormElements['mylist_text']).'\' ';
							}
							break;
						case 3://'% abc123 %'
							if (strpos(strtolower($strConsultaActual),'where')){
								$strConsultaActual .= ' AND UPPER('.$FormElements['mylist_select'].') LIKE \'%'.strtoupper($FormElements['mylist_text']).'%\' ';
							}else{
								$strConsultaActual .= ' WHERE UPPER('.$FormElements['mylist_select'].') LIKE \'%'.strtoupper($FormElements['mylist_text']).'%\' ';
							}
							break;
						case 4://'= abc123'
							if (strpos(strtolower($strConsultaActual),'where')){
								$strConsultaActual .= ' AND UPPER('.$FormElements['mylist_select'].') = \''.strtoupper($FormElements['mylist_text']).'\' ';
							}else{
								$strConsultaActual .= ' WHERE UPPER('.$FormElements['mylist_select'].') = \''.strtoupper($FormElements['mylist_text']).'\' ';
							}
							break;
						case 5://'!= abc123'
							if (strpos(strtolower($strConsultaActual),'where')){
								$strConsultaActual .= ' AND UPPER('.$FormElements['mylist_select'].') != \''.strtoupper($FormElements['mylist_text']).'\' ';
							}else{
								$strConsultaActual .= ' WHERE UPPER('.$FormElements['mylist_select'].') != \''.strtoupper($FormElements['mylist_text']).'\' ';
							}
							break;
					}
					$_SESSION['prdLst'][$NameRefList]['sqlt'] = $strConsultaActual;

					$_SESSION['prdLst'][$NameRefList]['usPag'] = false;
			    	$_SESSION['prdLst'][$NameRefList]['shwOrdMet'] = false;
				 
					$this->response->assign($FormElements['mylist_ndiv'],'innerHTML',$objDinamicList->getDinamicList($NameRefList,false));
				 
				}else{
					//$this->response->alert('Por favor digite un valor para ser buscado en la columna \''.$strLabel.'\'.');
					$this->notificationWindow('Por favor digite un valor para ser buscado en la columna <b>'.$strLabel.'</b>',5);
				}
			}else{
				//$this->response->alert('Por favor seleccione una regla para el filtro.');
				$this->notificationWindow('Por favor seleccione una regla para el filtro.',5);
			}
		}else {
			$_SESSION['prdLst'][$NameRefList]['usPag'] = true;
			$_SESSION['prdLst'][$NameRefList]['shwOrdMet'] = true;
			$this->response->assign($strNomDiv,'innerHTML',$objDinamicList->getDinamicList($NameRefList,false));  
		}
	
		return $this->response;
	}
	
	/**
	 * Aplica determinado filtro por columna segun
	 * la disponibilidad de los valores regitrados
	 * en esa columna.
	 *
	 * @param string $NameRefList
	 * @param string $idDiv
	 * @param string $whereValue
	 * @param string $filterBy
	 * @param string $filterByAlias
	 * @return string
	 */
	public function myListFilterIn ($NameRefList, $idDiv, $whereValue, $filterBy, $filterByAlias){
	 	$objMyList = new myDinamicList($NameRefList);
	 
	 	$this->script('rowsMarked = new Array();');
	 	unset($_SESSION['prdLst'][$NameRefList]['ordBy'], $_SESSION['prdLst'][$NameRefList]['ordMtd']);
	 	
	 	$strConsultaActual = $_SESSION['prdLst'][$NameRefList]['sql'];
	 	$this->response->assign($idDiv,'style.visibility','hidden');
	 
	 	if (!isset($_SESSION['prdLst'][$NameRefList]['fltByCl']))
	    	$_SESSION['prdLst'][$NameRefList]['fltByCl'] = array();

	 	if (trim($whereValue)){   
	   		$_SESSION['prdLst'][$NameRefList]['fltByCl'][$filterBy] = $whereValue;
	 	}else{      
	   		unset($_SESSION['prdLst'][$NameRefList]['fltByCl'][$filterBy]);
	 	}
	   
		if ($nFiltros = count($_SESSION['prdLst'][$NameRefList]['fltByCl'])){
			if (strpos(strtolower($strConsultaActual),'where')){
		  		$strConsultaActual .= ' AND ';		
			}else{
		  		$strConsultaActual .= ' WHERE ';
			}
		
			$i = 0;
			foreach ($_SESSION['prdLst'][$NameRefList]['fltByCl'] as $key => $value){
				if (is_numeric($value))
			  		$strConsultaActual .= $key.' = '.$value;
				else  
			  		$strConsultaActual .= $key.' = \''.$value.'\'';

				if ($i<($nFiltros-1))  
			  		$strConsultaActual .= ' AND ';
			  
				$i++;  
			}
		
			$_SESSION['prdLst'][$NameRefList]['sqlt'] = $strConsultaActual;

	  		$_SESSION['prdLst'][$NameRefList]['usPag'] = false;
	  		$_SESSION['prdLst'][$NameRefList]['shwOrdMet'] = false;
	  
		}else{
	  		$_SESSION['prdLst'][$NameRefList]['usPag'] = true;
	  		$_SESSION['prdLst'][$NameRefList]['shwOrdMet'] = true;
		
		}
	
		$this->response->assign($NameRefList,'innerHTML',$objMyList->getDinamicList($NameRefList,false));
	
		return $this->response;	 
	}	
	
	
}



?>